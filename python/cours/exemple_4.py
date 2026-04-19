# affichage d'un tableau pour le reste des fonctions
def tableau(tableau):
    for i in tableau:
        print(i)


def dictionnaire(dictionnaire):
    # clef est une variable crée par la boucle elle contient la clef du dictionnaire
    # valeur est une variable crée par la boucle elle contient la valeur du dictionnaire
    # mon_dictionnaire est le dictionnaire
    # .items() permet de recuperer les clefs et valeurs du dictionnaire
    for clef, valeur in dictionnaire.items():
        print(f"{clef} : {valeur}")


# fin affchage d'un tableau


# affichage simple d'un tableau
def exemple_1():
    mon_tableau = ["a", "b", "c", "d", "e"]
    # recupère l'element du tableau sans la clef
    for i in mon_tableau:
        print(i)


# modification d'un tableau
def exemple_2():
    # affiche le tableau
    mon_tableau = ["a", "b", "c", "d", "e"]
    tableau(mon_tableau)

    # on utilise le range pour pouvoir modifier les elements
    for i in range(len(mon_tableau)):
        # on recupère la valeur de l'element pour ajouter un suffixe "_modifier" et le mettre a jour sur le tableau
        mon_tableau[i] = mon_tableau[i] + "_modifier"

    # affiche une ligne avec deux saut de ligne via \n
    print("------------\n\n")
    tableau(mon_tableau)


# ajout d'un element a un tableau
def exemple_3():
    # affiche le tableau
    mon_tableau = ["a", "b", "c", "d", "e"]
    tableau(mon_tableau)

    # ajoute un element a la fin du tableau
    mon_tableau.append("f")
    # equivalent a append
    mon_tableau += ["g"]
    # equivalent a append
    mon_tableau = mon_tableau + ["h"]

    # ajoute un element au debut du tableau
    mon_tableau = ["i"] + mon_tableau

    # affiche une ligne avec deux saut de ligne via \n
    print("------------\n\n")

    tableau(mon_tableau)


# suppression d'un element d'un tableau
def exemple_4():
    # affiche le tableau
    mon_tableau = ["a", "b", "c", "d", "e"]
    tableau(mon_tableau)

    # on peut supprimer un element via sa clef
    mon_tableau.remove("a")

    # affiche une ligne avec deux saut de ligne via \n
    print("------------\n\n")
    tableau(mon_tableau)


# affichage de dictionnaire
def exemple_5():
    mon_dictionnaire = {"nom": "DOE", "prenom": "John", "age": 35}
    # f permet de formater le texte et d'asselbler plus intuitivement les variables au texte brut
    # "prenom :" est un texte brut
    # "{mon_dictionnaire['prenom']}" est une variable
    print(f"prenom : {mon_dictionnaire['prenom']}")
    print(f"nom : {mon_dictionnaire['nom']}")
    print(f"age : {mon_dictionnaire['age']}")

    print("------------\n\n")
    # affiche le dictionnaire automatiquement de manière dynamique
    dictionnaire(mon_dictionnaire)


# ajout d'élément dans un dictionnaire
def exemple_6():
    mon_dictionnaire = {}
    # entre crochet et le nom de la clef que l'on souhaite attribuer
    # a droite du egale est la valeur de l'element
    mon_dictionnaire["nom"] = "DOE"
    mon_dictionnaire["prenom"] = "John"
    mon_dictionnaire["age"] = 35

    dictionnaire(mon_dictionnaire)


# modifier une valeur dans un dictionnaire
def exemple_7():
    mon_dictionnaire = {"nom": "DOE", "prenom": "John", "age": 35}
    dictionnaire(mon_dictionnaire)

    print("------------\n\n")
    # on modifie toujours par sa clef
    # John a eu anniversaire on a mis a jour sa valeur
    mon_dictionnaire["age"] = 36
    dictionnaire(mon_dictionnaire)


# suppression d'un element d'un dictionnaire
def exemple_8():
    mon_dictionnaire = {"nom": "DOE", "prenom": "John", "age": 35}
    dictionnaire(mon_dictionnaire)

    print("------------\n\n")
    # on supprime via sa clef del permet aussi de supprimer une variable classique
    del mon_dictionnaire["age"]
    dictionnaire(mon_dictionnaire)


# affiche d'un tableau dans un tbaleau
def exemple_9():
    mon_tableau = [
        ["John", "Doe", 35],
        ["Jane", "Doe", 32],
        ["Bob", "Smith", 40],
        ["Alice", "Johnson", 38],
        ["Charlie", "Brown", 36],
    ]

    # avec un seul parametre on affiche le sous tableau
    # dans le cas ou par exageration il y a 20 sous tableau on affiche un tableau de tableau pour tout voir correctement il faut faire 19 sous parametre
    for ligne in mon_tableau:
        print(ligne)

    print("------------\n\n")
    for ligne in mon_tableau:
        for colonne in ligne:
            print(colonne)
        print("------------ fin ligne")


# affiche un dictionnaire dans un dictionnaire
def exemple_10():
    mon_dictionnaire = {
        "John": {"age": 35, "city": "New York"},
        "Jane": {"age": 32, "city": "Los Angeles"},
        "Bob": {"age": 40, "city": "Chicago"},
        "Alice": {"age": 38, "city": "Houston"},
        "Charlie": {"age": 36, "city": "Philadelphia"},
    }
    # clef est une variable crée par la boucle elle contient la clef du dictionnaire
    # valeur est une variable crée par la boucle elle contient la valeur du dictionnaire
    # mon_dictionnaire est le dictionnaire
    # .items() permet de recuperer les clefs et valeurs du dictionnaire
    for  valeur in mon_dictionnaire:
        print(valeur)

    print("------------\n\n")

    # clef est une variable crée par la boucle elle contient la clef du dictionnaire
    # valeur est une variable crée par la boucle elle contient la valeur du dictionnaire
    # mon_dictionnaire est le dictionnaire
    # .items() permet de recuperer les clefs et valeurs du dictionnaire
    for clef, valeur in mon_dictionnaire.items():
        # affiche le nom de la personne qui est a la fois une valeur du dctionnaire et une clef du sous dictionnaire
        print(f"{clef} : ")

        # clef est une variable crée par la boucle elle contient la clef du dictionnaire
        # valeur est une variable crée par la boucle elle contient la valeur du dictionnaire
        # mon_dictionnaire est le dictionnaire
        # .items() permet de recuperer les clefs et valeurs du dictionnaire
        for sous_clef, sous_valeur in valeur.items():
            # affiche le sous dictionnaire
            print(f"  {sous_clef} : {sous_valeur}")
        # affiche la fin pour mieux voir le resultat
        print("------------ fin dictionnaire")

    print("------------\n\n")

    # exemple d'affiche non dynamic comme avec les for
    print(mon_dictionnaire["John"]["age"])


# affiche un tableau dans un dictionnaire
def exemple_11():
    mon_dictionnaire = {
        "John": [15, "Paris"],
        "Jane": [18, "Londre"],
        "Bob": [20, "New York"],
        "Alice": [22, "Los Angeles"],
    }
    # clef est une variable crée par la boucle elle contient la clef du dictionnaire
    # valeur est une variable crée par la boucle elle contient la valeur du dictionnaire
    # mon_dictionnaire est le dictionnaire
    # .items() permet de recuperer les clefs et valeurs du dictionnaire
    for valeur in mon_dictionnaire:
        print(valeur)

    print("------------\n\n")

    # clef est une variable crée par la boucle elle contient la clef du dictionnaire
    # valeur est une variable crée par la boucle elle contient la valeur du dictionnaire
    # mon_dictionnaire est le dictionnaire
    # .items() permet de recuperer les clefs et valeurs du dictionnaire
    for clef, valeur in mon_dictionnaire.items():
        # affiche le nom de la personne qui est a la fois une valeur du dctionnaire et une clef du sous dictionnaire
        print(f"{clef} : ")

        # boucle sur le sous tableau
        for sous_valeur in valeur:
            # affiche le sous dictionnaire
            print(sous_valeur)
        # affiche la fin pour mieux voir le resultat
        print("------------ fin dictionnaire")

    print("------------\n\n")

    # exemple d'affiche non dynamic comme avec les for
    print(mon_dictionnaire["John"][1])

#affiche un dictionnaire dans un tableau
def exemple_12():
    mon_tableau = [
        {"nom": "John", "age": 35, "ville": "Paris"},
        {"nom": "Jane", "age": 32, "ville": "Londre"},
        {"nom": "Bob", "age": 40, "ville": "New York"},
        {"nom": "Alice", "age": 38, "ville": "Los Angeles"},
    ]
    #affiche le tableau
    for personne in mon_tableau:
        print(personne)


    print("------------\n\n")

    # clef est une variable crée par la boucle elle contient la clef du dictionnaire
    # valeur est une variable crée par la boucle elle contient la valeur du dictionnaire
    # mon_dictionnaire est le dictionnaire
    # .items() permet de recuperer les clefs et valeurs du dictionnaire
    for valeur in mon_tableau:
        # affiche le nom de la personne qui est a la fois une valeur du dctionnaire et une clef du sous dictionnaire
        print(valeur)

        # boucle sur le sous tableau
        for sous_clef, sous_valeur in valeur.items():
            # affiche le sous dictionnaire
            print(f"{sous_clef}: {sous_valeur}")
        # affiche la fin pour mieux voir le resultat
        print("------------ fin dictionnaire")

    print("------------\n\n")

    # exemple d'affiche non dynamic comme avec les for
    print(mon_tableau[1]["nom"])

exemple_12()