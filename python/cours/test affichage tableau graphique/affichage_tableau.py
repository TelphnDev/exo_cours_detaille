"""
table_viewer.py
===============
Usage :
    from table_viewer import show_table
    show_table(data)

Formats :
    dict          {"clé": valeur, ...}
    list[list]    [[1, 2], [3, 4], ...]
    list[dict]    [{"a": 1}, {"a": 2}, ...]

Les valeurs imbriquées (dict / list) sont cliquables → navigation en profondeur.
"""

import tkinter as tk
from tkinter import ttk


# ──────────────────────────────────────────────────────────────────────
#  Helpers
# ──────────────────────────────────────────────────────────────────────

def _is_nested(v) -> bool:
    if isinstance(v, dict):
        return True
    if isinstance(v, list) and v and isinstance(v[0], (list, dict)):
        return True
    return False


def _preview(v) -> str:
    if isinstance(v, dict):
        n = len(v)
        return f"📋 dict  ({n} clé{'s' if n > 1 else ''})"
    if isinstance(v, list):
        n = len(v)
        if n and isinstance(v[0], dict):
            return f"📋 list[dict]  ({n} ligne{'s' if n > 1 else ''})"
        if n and isinstance(v[0], list):
            return f"📋 list[list]  ({n} ligne{'s' if n > 1 else ''})"
    return str(v)


def _to_table(data):
    """Retourne (headers: list[str], rows: list[list])."""
    if isinstance(data, dict):
        return ["Clé", "Valeur"], [[k, v] for k, v in data.items()]

    if isinstance(data, list):
        if not data:
            return ["(vide)"], []
        if isinstance(data[0], dict):
            keys = list(data[0].keys())
            for row in data[1:]:
                for k in row:
                    if k not in keys:
                        keys.append(k)
            return keys, [[row.get(k, "") for k in keys] for row in data]
        if isinstance(data[0], list):
            n_cols = max(len(r) for r in data)
            headers = [f"[{i}]" for i in range(n_cols)]
            return headers, [r + [""] * (n_cols - len(r)) for r in data]

    raise TypeError(f"Format non supporté : {type(data)}")


# ──────────────────────────────────────────────────────────────────────
#  Viewer
# ──────────────────────────────────────────────────────────────────────

class _Viewer(tk.Tk):
    BG = "#0d1117"
    BG2 = "#161b22"
    BG3 = "#21262d"
    ACCENT = "#58a6ff"
    FG = "#e6edf3"
    FG2 = "#8b949e"
    SEL = "#1f6feb"
    ODD = "#161b22"
    EVN = "#0d1117"
    FONT = ("Consolas", 10)
    FNSM = ("Consolas", 9)
    CHUNK = 300

    def __init__(self, root_data):
        super().__init__()
        self.configure(bg=self.BG)
        self.geometry("860x520")
        self.minsize(500, 300)
        self.title("table_viewer")

        self._stack = []  # pile (data, breadcrumb_text, yview)
        self._sort_asc = {}  # col -> bool

        self._all_rows = []
        self._filtered = []
        self._headers = []
        self._loaded = 0
        self._cur_data = None

        self._build_ui()
        self._show(root_data, push=False)
        self.bind("<Escape>", lambda e: self._go_back() if self._stack else self.destroy())

    # ── construction ──────────────────────────────────────────────────

    def _build_ui(self):
        # barre du haut
        nav = tk.Frame(self, bg=self.BG2, padx=8, pady=5)
        nav.pack(fill="x")

        self._back_btn = tk.Button(
            nav, text="← Retour", command=self._go_back,
            bg=self.BG3, fg=self.ACCENT, relief="flat",
            font=self.FNSM, padx=8, pady=2, cursor="hand2",
            activebackground=self.BG, activeforeground=self.ACCENT
        )

        self._crumb = tk.Label(nav, text="", bg=self.BG2, fg=self.FG2,
                               font=self.FNSM, anchor="w")
        self._crumb.pack(side="left", fill="x", expand=True)

        self._q = tk.StringVar()
        self._q.trace_add("write", self._on_search)
        tk.Label(nav, text="🔍", bg=self.BG2, fg=self.FG2,
                 font=self.FNSM).pack(side="right")
        tk.Entry(nav, textvariable=self._q,
                 bg=self.BG3, fg=self.FG, insertbackground=self.FG,
                 relief="flat", font=self.FNSM, width=22
                 ).pack(side="right", ipady=3, padx=(4, 0))

        # cadre tableau
        frm = tk.Frame(self, bg=self.BG)
        frm.pack(fill="both", expand=True, padx=8, pady=2)
        frm.rowconfigure(0, weight=1)
        frm.columnconfigure(0, weight=1)

        # style
        st = ttk.Style(self)
        st.theme_use("clam")
        st.configure("V.Treeview",
                     background=self.BG, foreground=self.FG,
                     fieldbackground=self.BG, rowheight=22, font=self.FONT)
        st.configure("V.Treeview.Heading",
                     background=self.BG3, foreground=self.ACCENT,
                     font=(self.FONT[0], self.FONT[1], "bold"), relief="flat")
        st.map("V.Treeview",
               background=[("selected", self.SEL)],
               foreground=[("selected", self.FG)])
        st.map("V.Treeview.Heading",
               background=[("active", self.BG)])

        self._tree = ttk.Treeview(frm, show="headings",
                                  style="V.Treeview", selectmode="browse")
        self._tree.tag_configure("odd", background=self.ODD)
        self._tree.tag_configure("even", background=self.EVN)
        self._tree.tag_configure("nested", foreground=self.ACCENT)

        vsb = ttk.Scrollbar(frm, orient="vertical", command=self._tree.yview)
        hsb = ttk.Scrollbar(frm, orient="horizontal", command=self._tree.xview)
        self._tree.configure(yscrollcommand=self._yscroll, xscrollcommand=hsb.set)

        self._tree.grid(row=0, column=0, sticky="nsew")
        vsb.grid(row=0, column=1, sticky="ns")
        hsb.grid(row=1, column=0, sticky="ew")
        self._vsb = vsb

        self._tree.bind("<Double-1>", self._on_dclick)
        self._tree.bind("<Return>", self._on_dclick)

        # statut
        self._status = tk.Label(self, text="", bg=self.BG2, fg=self.FG2,
                                font=self.FNSM, anchor="w", padx=8)
        self._status.pack(fill="x")

    # ── affichage d'un jeu de données ─────────────────────────────────

    def _show(self, data, label="", push=True):
        if push and self._cur_data is not None:
            self._stack.append((self._cur_data, self._crumb.cget("text")))

        self._cur_data = data
        self._q.set("")
        self._sort_asc.clear()

        headers, rows = _to_table(data)
        self._headers = headers
        self._all_rows = rows
        self._filtered = rows[:]
        self._loaded = 0

        # reconfigurer les colonnes
        self._tree.configure(columns=headers)
        sample = rows[:150]
        for i, h in enumerate(headers):
            vals = [str(r[i]) if i < len(r) else "" for r in sample]
            max_len = max((len(v) for v in vals), default=4)
            w = min(260, max(60, max(len(str(h)), max_len) * 7 + 14))
            self._tree.heading(str(h), text=str(h),
                               command=lambda c=h: self._sort(c))
            self._tree.column(str(h), width=w, minwidth=50, stretch=True)

        self._tree.delete(*self._tree.get_children())
        self._load_chunk()
        self._refresh_nav(label)

    # ── chargement par lots ───────────────────────────────────────────

    def _load_chunk(self):
        if self._loaded >= len(self._filtered):
            return
        end = min(self._loaded + self.CHUNK, len(self._filtered))
        for i, row in enumerate(self._filtered[self._loaded:end], self._loaded):
            base_tag = "odd" if i % 2 else "even"
            display, has_nested = [], False
            for v in row:
                if _is_nested(v):
                    display.append(_preview(v))
                    has_nested = True
                else:
                    display.append("" if v == "" else str(v))
            tags = (base_tag, "nested") if has_nested else (base_tag,)
            self._tree.insert("", "end", values=display, tags=tags, iid=str(i))
        self._loaded = end
        self._refresh_status()

    def _yscroll(self, lo, hi):
        self._vsb.set(lo, hi)
        if float(hi) >= 0.85:
            self._load_chunk()

    # ── navigation ────────────────────────────────────────────────────

    def _on_dclick(self, event=None):
        iid = self._tree.focus()
        if not iid:
            return
        idx = int(iid)
        row = self._filtered[idx]
        col_id = self._tree.identify_column(
            self._tree.winfo_pointerx() - self._tree.winfo_rootx()
        )
        if not col_id:
            return
        ci = int(col_id.replace("#", "")) - 1
        if ci < 0 or ci >= len(row):
            return
        val = row[ci]
        if not _is_nested(val):
            return
        self._show(val, label=str(self._headers[ci]))

    def _go_back(self):
        if not self._stack:
            return
        prev_data, prev_bc = self._stack.pop()
        self._cur_data = None  # évite le push dans _show
        self._show(prev_data, push=False)
        self._crumb.config(text=prev_bc)
        if not self._stack:
            self._back_btn.pack_forget()

    def _refresh_nav(self, label=""):
        if self._stack:
            self._back_btn.pack(side="left", padx=(0, 8), before=self._crumb)
        else:
            self._back_btn.pack_forget()

        depth = len(self._stack)
        kind = type(self._cur_data).__name__
        n, c = len(self._all_rows), len(self._headers)
        path = " › ".join(bc.split(" — ")[0] for (_, bc) in self._stack if bc)
        here = label if label else kind
        full = f"{path} › {here}" if path else here
        self._crumb.config(
            text=f"{full}  —  {n} ligne{'s' if n > 1 else ''} × {c} col."
        )

    # ── tri ───────────────────────────────────────────────────────────

    def _sort(self, col):
        rev = self._sort_asc.get(col, False)
        idx = self._headers.index(col)
        try:
            self._filtered.sort(
                key=lambda r: (r[idx] is None,
                               float(str(r[idx]).replace(",", "."))),
                reverse=rev
            )
        except (ValueError, TypeError):
            self._filtered.sort(key=lambda r: str(r[idx]), reverse=rev)
        self._sort_asc[col] = not rev
        arrow = " ▲" if not rev else " ▼"
        for h in self._headers:
            self._tree.heading(str(h), text=str(h) + (arrow if h == col else ""))
        self._tree.delete(*self._tree.get_children())
        self._loaded = 0
        self._load_chunk()

    # ── recherche ─────────────────────────────────────────────────────

    def _on_search(self, *_):
        q = self._q.get().strip().lower()
        self._filtered = (
            self._all_rows[:] if not q
            else [r for r in self._all_rows
                  if any(q in str(v).lower() for v in r)]
        )
        self._tree.delete(*self._tree.get_children())
        self._loaded = 0
        self._load_chunk()

    # ── statut ────────────────────────────────────────────────────────

    def _refresh_status(self):
        total = len(self._all_rows)
        shown = len(self._filtered)
        loaded = self._loaded
        filt = f"  filtre : {shown}/{total}" if shown != total else f"  {total} lignes"
        self._status.config(
            text=f"Chargé {loaded}/{shown}{filt}"
                 f"  │  double-clic 📋 pour entrer  │  ← ou Échap pour revenir"
        )


# ──────────────────────────────────────────────────────────────────────
#  API publique
# ──────────────────────────────────────────────────────────────────────

def show_table(data) -> None:
    """Affiche data dans une fenêtre.  Formats : dict, list[list], list[dict].
    Les valeurs imbriquées sont navigables par double-clic."""
    _Viewer(data).mainloop()


# ── démo ──────────────────────────────────────────────────────────────
if __name__ == "__main__":
    show_table([
        {
            "id": 1, "nom": "Alice", "scores": [95, 87, 92],
            "adresse": {"rue": "12 rue de la Paix", "ville": "Paris", "cp": "75001"},
            "commandes": [
                {"ref": "A001", "montant": 120.5, "statut": "livré"},
                {"ref": "A002", "montant": 45.0, "statut": "en cours"},
            ],
        },
        {
            "id": 2, "nom": "Bob", "scores": [78, 85, 90],
            "adresse": {"rue": "8 allée des Roses", "ville": "Lyon", "cp": "69003"},
            "commandes": [{"ref": "B001", "montant": 200.0, "statut": "livré"}],
        },
        {
            "id": 3, "nom": "Charlie", "scores": [60, 72, 68],
            "adresse": {"rue": "3 bd Victor Hugo", "ville": "Marseille", "cp": "13001"},
            "commandes": [],
        },
    ])
