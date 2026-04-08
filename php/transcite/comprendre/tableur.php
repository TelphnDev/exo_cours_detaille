<?php
/**
 * viewer_lib.php
 * -----------------------------------------------------------
 * Bibliotheque de visualisation de tableaux PHP.
 * Ne produit aucune sortie seule.
 *
 * UTILISATION RAPIDE :
 *
 *   include_once 'viewer_lib.php';
 *
 *   // Page HTML complete (header + footer inclus) :
 *   renderArrayPage($monTableau, 'Mon titre');
 *
 *   // Bloc embarque dans une page existante :
 *   echo renderArrayBlock($monTableau);
 *
 *   // Un seul tableau nommé :
 *   echo renderSection('Statistiques bus', $monTableau);
 * -----------------------------------------------------------
 */

if (!defined('VIEWER_LIB_LOADED')) {
    define('VIEWER_LIB_LOADED', true);

    // --------------------------------------------------------
    //  POINT D'ENTREE PRINCIPAL : page HTML autonome
    // --------------------------------------------------------

    /**
     * Affiche une page HTML complete avec Bootstrap.
     *
     * @param array  $data      Tableau a afficher (peut etre multidimensionnel)
     * @param string $pageTitle Titre affiché dans le <title> et le header
     */
    function renderArrayPage($data, $pageTitle)
    {
        if ($pageTitle === null || $pageTitle === '') {
            $pageTitle = 'Visualiseur de tableaux';
        }
        echo _viewerHtmlHeader($pageTitle);
        echo _viewerBody($data);
        echo _viewerHtmlFooter();
    }

    /**
     * Retourne le HTML d'un bloc de visualisation (sans <html>/<body>).
     * A utiliser quand Bootstrap est deja charge dans votre page.
     *
     * @param array $data Tableau a afficher
     * @return string HTML pret a etre insere avec echo
     */
    function renderArrayBlock($data)
    {
        return _viewerBody($data);
    }

    /**
     * Retourne le HTML d'une seule section (une carte).
     *
     * @param string $label Nom de la section
     * @param mixed  $value Valeur (tableau ou scalaire)
     * @param int    $colorIdx Index de couleur (0-6)
     * @return string
     */
    function renderSection($label, $value, $colorIdx)
    {
        if ($colorIdx === null) {
            $colorIdx = 0;
        }
        $col   = _sectionColor($colorIdx);
        $uid   = 'sec_' . preg_replace('/\W+/', '_', $label) . '_' . $colorIdx;
        $count = is_array($value) ? count($value) : 1;
        $isArr = is_array($value);

        $html  = '<div class="viewer-section-card card">';

        // En-tete
        $html .= '<div class="viewer-section-header bg-' . $col['bg'] . ' text-' . $col['text'] . '">';
        $html .= '<i class="bi ' . $col['icon'] . ' fs-5"></i>';
        $html .= '<h2 class="viewer-section-title">' . htmlspecialchars(_camelToLabel($label), ENT_QUOTES) . '</h2>';
        if ($isArr) {
            $html .= '<span class="viewer-badge-count">' . $count . ' element' . ($count > 1 ? 's' : '') . '</span>';
        }
        $html .= '<button class="viewer-toggle-btn" type="button"'
               . ' data-bs-toggle="collapse" data-bs-target="#' . $uid . '"'
               . ' aria-expanded="true"><i class="bi bi-chevron-down"></i></button>';
        $html .= '</div>';

        // Corps
        $html .= '<div id="' . $uid . '" class="collapse show">';
        $html .= '<div class="card-body p-0">' . _renderValue($value, 0, $label) . '</div>';

        // Barre de stats
        if ($isArr && _isTableArray($value)) {
            $nbCols = _countColumns($value);
            $html .= '<div class="viewer-stats-bar">';
            $html .= '<span><i class="bi bi-list-ul me-1"></i>' . $count . ' ligne' . ($count > 1 ? 's' : '') . '</span>';
            $html .= '<span><i class="bi bi-layout-three-columns me-1"></i>' . $nbCols . ' colonne' . ($nbCols > 1 ? 's' : '') . '</span>';
            $html .= '<span style="margin-left:auto">' . htmlspecialchars($label, ENT_QUOTES) . '</span>';
            $html .= '</div>';
        }

        $html .= '</div></div>';
        return $html;
    }

    // --------------------------------------------------------
    //  FONCTIONS INTERNES (prefixe _ = privees par convention)
    // --------------------------------------------------------

    function _viewerBody($data)
    {
        $html = '<div class="container-fluid px-3">';

        // Si $data est un tableau associatif a plusieurs cles, une section par cle
        if (is_array($data) && !_isTableArray($data) && !_isScalarList($data)) {
            $sIdx = 0;
            foreach ($data as $key => $value) {
                $html .= renderSection((string)$key, $value, $sIdx);
                $sIdx++;
            }
        } else {
            // Sinon on l'affiche comme une seule section
            $html .= renderSection('Donnees', $data, 0);
        }

        $html .= '</div>';

        // Section debug (print_r brut, masquee)
        $html .= '<div class="container-fluid px-3 mt-2 mb-5">';
        $html .= '<div class="card viewer-section-card">';
        $html .= '<div class="viewer-section-header bg-dark text-white">';
        $html .= '<i class="bi bi-terminal-fill fs-5"></i>';
        $html .= '<h2 class="viewer-section-title">Donnees brutes <small class="fw-normal" style="opacity:.65">(print_r)</small></h2>';
        $html .= '<button class="viewer-toggle-btn collapsed" type="button"'
               . ' data-bs-toggle="collapse" data-bs-target="#viewerRawDebug"'
               . ' aria-expanded="false"><i class="bi bi-chevron-down"></i></button>';
        $html .= '</div>';
        $html .= '<div id="viewerRawDebug" class="collapse">';
        $html .= '<pre class="p-3 m-0 bg-light" style="font-size:.78rem;max-height:400px;overflow:auto">'
               . htmlspecialchars(print_r($data, true), ENT_QUOTES)
               . '</pre>';
        $html .= '</div></div></div>';

        return $html;
    }

    function _viewerHtmlHeader($title)
    {
        return '<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>' . htmlspecialchars($title, ENT_QUOTES) . '</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  ' . _viewerStyles() . '
</head>
<body>
<div class="viewer-page-header text-center">
  <h1><i class="bi bi-grid-3x3-gap-fill me-2"></i>' . htmlspecialchars($title, ENT_QUOTES) . '</h1>
  <p>Rendu automatique et lisible de structures de donnees complexes</p>
</div>
';
    }

    function _viewerHtmlFooter()
    {
        return '
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
' . _viewerScript() . '
</body>
</html>';
    }

    function _viewerStyles()
    {
        return '<style>
body { background:#f0f2f5; font-family:"Segoe UI",system-ui,sans-serif; }
.viewer-page-header {
  background: linear-gradient(135deg,#1a1a2e 0%,#16213e 60%,#0f3460 100%);
  color:#fff; padding:32px 24px 24px;
  border-radius:0 0 24px 24px; margin-bottom:32px;
  box-shadow:0 4px 20px rgba(0,0,0,.3);
}
.viewer-page-header h1 { font-weight:700; letter-spacing:-0.5px; }
.viewer-page-header p  { opacity:.75; font-size:.9rem; margin:0; }
.viewer-section-card {
  border:none; border-radius:16px;
  box-shadow:0 2px 12px rgba(0,0,0,.08);
  overflow:hidden; margin-bottom:32px; transition:box-shadow .2s;
}
.viewer-section-card:hover { box-shadow:0 4px 24px rgba(0,0,0,.13); }
.viewer-section-header {
  padding:16px 20px; display:flex; align-items:center; gap:12px;
}
.viewer-section-title {
  font-size:1.05rem; font-weight:700; letter-spacing:.4px; margin:0;
}
.viewer-badge-count {
  font-size:.75rem; padding:3px 10px; border-radius:999px;
  background:rgba(255,255,255,.25); color:#fff;
}
.table thead th {
  font-size:.78rem; text-transform:uppercase;
  letter-spacing:.6px; white-space:nowrap;
}
.table tbody td { font-size:.88rem; vertical-align:middle; }
.viewer-stats-bar {
  font-size:.8rem; color:#6c757d; padding:6px 20px;
  background:#f8f9fa; border-top:1px solid #dee2e6;
  display:flex; flex-wrap:wrap; gap:16px;
}
.viewer-toggle-btn {
  background:transparent; border:none; cursor:pointer;
  color:rgba(255,255,255,.8); font-size:1.1rem;
  margin-left:auto; transition:transform .2s; line-height:1;
}
.viewer-toggle-btn.collapsed { transform:rotate(-90deg); }
td .table { margin-bottom:0; }
</style>';
    }

    function _viewerScript()
    {
        return '<script>
document.querySelectorAll("[data-bs-toggle=\'collapse\']").forEach(function(btn) {
  var target = document.querySelector(btn.getAttribute("data-bs-target"));
  if (!target) { return; }
  target.addEventListener("show.bs.collapse", function() { btn.classList.remove("collapsed"); });
  target.addEventListener("hide.bs.collapse", function() { btn.classList.add("collapsed"); });
});
<\/script>';
    }

    // --------------------------------------------------------
    //  RENDU RECURSIF
    // --------------------------------------------------------

    function _renderValue($value, $depth, $keyHint)
    {
        if (!is_array($value)) {
            return _formatScalar($keyHint, $value);
        }
        if (empty($value)) {
            return '<span class="badge bg-secondary">[ ]</span>';
        }
        if (_isScalarList($value)) {
            $items = '';
            foreach ($value as $v) {
                $items .= '<span class="badge bg-light text-dark border me-1">'
                        . htmlspecialchars((string)$v, ENT_QUOTES) . '</span>';
            }
            return '<div class="d-flex flex-wrap gap-1">' . $items . '</div>';
        }
        if (_isTableArray($value)) {
            return _renderTable($value, $depth);
        }
        return _renderCard($value, $depth);
    }

    function _renderTable($rows, $depth)
    {
        $clean = array();
        foreach ($rows as $row) {
            $clean[] = _deduplicateArray($row);
        }

        $allKeys = array();
        foreach ($clean as $row) {
            foreach (array_keys($row) as $k) {
                $allKeys[$k] = true;
            }
        }
        $allKeys = array_keys($allKeys);

        $tableClass = ($depth === 0)
            ? 'table table-hover table-bordered align-middle mb-0'
            : 'table table-sm table-bordered align-middle mb-0';

        $html  = '<div class="table-responsive">';
        $html .= '<table class="' . $tableClass . '">';
        $html .= '<thead class="table-dark"><tr>';
        $html .= '<th class="text-center" style="width:40px">#</th>';
        foreach ($allKeys as $k) {
            $html .= '<th>' . htmlspecialchars(_camelToLabel((string)$k), ENT_QUOTES) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($clean as $i => $row) {
            $html .= '<tr>';
            $html .= '<td class="text-center text-muted small">' . ($i + 1) . '</td>';
            foreach ($allKeys as $k) {
                $val  = isset($row[$k]) ? $row[$k] : null;
                $html .= '<td>' . _renderValue($val, $depth + 1, $k) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';
        return $html;
    }

    function _renderCard($assoc, $depth)
    {
        $clean = _deduplicateArray($assoc);
        $html  = '<ul class="list-group list-group-flush">';
        foreach ($clean as $k => $v) {
            $html .= '<li class="list-group-item px-2 py-1">'
                   . '<span class="fw-semibold text-secondary me-2">'
                   . htmlspecialchars(_camelToLabel((string)$k), ENT_QUOTES) . ' :</span>'
                   . _renderValue($v, $depth + 1, $k)
                   . '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    // --------------------------------------------------------
    //  FONCTIONS DE DETECTION / FORMAT
    // --------------------------------------------------------

    function _deduplicateArray($row)
    {
        $stringKeys  = array();
        $stringVals  = array();
        $numericVals = array();

        foreach ($row as $k => $v) {
            if (is_string($k)) {
                $stringKeys[] = $k;
                $stringVals[] = $v;
            } else {
                $numericVals[] = $v;
            }
        }

        if ($numericVals === $stringVals && !empty($stringKeys)) {
            return array_combine($stringKeys, $stringVals);
        }

        $out = array();
        foreach ($row as $k => $v) {
            if (is_string($k)) {
                $out[$k] = $v;
            }
        }
        return empty($out) ? $row : $out;
    }

    function _isTableArray($arr)
    {
        if (empty($arr)) { return false; }
        $first = reset($arr);
        return is_array($first);
    }

    function _isScalarList($arr)
    {
        foreach ($arr as $v) {
            if (is_array($v)) { return false; }
        }
        return true;
    }

    function _formatScalar($key, $val)
    {
        if (is_bool($val)) {
            $color = $val ? 'success' : 'danger';
            $label = $val ? 'true' : 'false';
            return '<span class="badge bg-' . $color . '">' . $label . '</span>';
        }

        if (is_int($val) || (is_string($val) && preg_match('/^[01]$/', $val))) {
            $lower     = strtolower((string)$key);
            $flagWords = array('point', 'actif', 'enabled', 'flag', 'activ', 'visible', 'statut');
            foreach ($flagWords as $word) {
                if (strpos($lower, $word) !== false) {
                    $color = $val ? 'success' : 'danger';
                    $icon  = $val ? '&#10004;' : '&#10008;';
                    return '<span class="badge bg-' . $color . ' fs-6">' . $icon . '</span>';
                }
            }
        }

        if (is_null($val)) { return '<span class="text-muted fst-italic">null</span>'; }
        if ($val === '')   { return '<span class="text-muted fst-italic">vide</span>'; }
        return htmlspecialchars((string)$val, ENT_QUOTES);
    }

    function _camelToLabel($key)
    {
        $label = str_replace('_', ' ', $key);
        $label = preg_replace('/([a-z])([A-Z])/', '$1 $2', $label);
        return ucfirst($label);
    }

    function _sectionColor($idx)
    {
        $palette = array(
            array('bg' => 'primary',   'icon' => 'bi-table',                  'text' => 'white'),
            array('bg' => 'success',   'icon' => 'bi-geo-alt-fill',           'text' => 'white'),
            array('bg' => 'info',      'icon' => 'bi-database-fill',          'text' => 'dark'),
            array('bg' => 'warning',   'icon' => 'bi-collection-fill',        'text' => 'dark'),
            array('bg' => 'danger',    'icon' => 'bi-file-earmark-code-fill', 'text' => 'white'),
            array('bg' => 'secondary', 'icon' => 'bi-layers-fill',            'text' => 'white'),
            array('bg' => 'dark',      'icon' => 'bi-braces',                 'text' => 'white'),
        );
        return $palette[$idx % count($palette)];
    }

    function _countColumns($rows)
    {
        $keys = array();
        foreach ($rows as $row) {
            $clean = _deduplicateArray($row);
            foreach (array_keys($clean) as $k) {
                $keys[$k] = true;
            }
        }
        return count($keys);
    }
}