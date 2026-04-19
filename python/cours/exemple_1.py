# if unique
# convertisseur chiffre negatif en positif
def condition_1():
    nbr = -10

    # verifie si le nombre est positif ou pas
    # abs fais la conversion en positif
    if (nbr != abs(nbr)):
        # previens que le nombre est negatif
        print("Le nombre est négatif")
        # converti le nombre en positif
        nbr = abs(nbr)
    # previen que le nombre est positif ou a été converti en positif
    print("Le nombre est positif")
    return nbr


# if avec else
# convertisseur chiffre positif en negatif
def condition_2():
    nbr = 1

    # verifie si le nombre est positif ou pas
    # abs fais la conversion en positif
    if (nbr != abs(nbr)):
        # converti le nombre en positif
        nbr = abs(nbr)
        # previens que le nombre etait negatif
        print("Le nombre était négatif")
    else:
        # previen que le nombre est positif
        print("Le nombre est positif")
    return nbr


# if avec elif il y a pas de else pour avoir un condition supplémentaire
# donne l'état de l'age
def condition_3():
    age = 20
    # verifie si age est inferieur ou egal a 3 (ans)
    if (age <= 3):
        print("Je suis un bebe")
    # verifie si age est superieur a 3 et inferieur ou egale a 11 (ans)
    elif (age > 3 and age <= 11):
        print("Je suis un enfant")
    # verifie si age est superieur a 11 et inferieur ou egale a 17 (ans)
    elif (age > 11 and age <= 17):
        print("Je suis un ado")
    # verifie si age est superieur a 17 et inferieur ou egale a 63 (ans)
    elif (age > 17 and age <= 63):
        print("Je suis un adulte")
    # si age est superieur a 63 (ans)
    elif (age > 64):
        print("Je suis a la retraite")

# if avec elif et else
# donne l'état de l'age
def condition_4():
    age = 20
    # verifie si age est inferieur ou egal a 3 (ans) et age est superieur ou egale a 0 (ans)
    if (age <= 3 and age >= 0):
        print("Je suis un bebe")
    # verifie si age est superieur a 3 et inferieur ou egale a 11 (ans)
    elif (age > 3 and age <= 11):
        print("Je suis un enfant")
    # verifie si age est superieur a 11 et inferieur ou egale a 17 (ans)
    elif (age > 11 and age <= 17):
        print("Je suis un ado")
    # verifie si age est superieur a 17 et inferieur ou egale a 63 (ans)
    elif (age > 18 and age <= 63):
        print("Je suis un adulte")
    # si age est superieur a 63 (ans) et inferieur ou egale a 120 (ans)
    elif (age > 63 and age <= 120):
        print("Je suis a la retraite")
    # si c'est inferieur a 0 ou superieur a 120 (ans) sa fait un else
    else:
        print("Je me suis trompé sur mon age")

# condition avec if et else sur une ligne
def condition_avancer():
    nbr = 1
    print("paire") if nbr % 2 == 0 else print("impair")

# apprendre les verifications possibles
def verification():
    # dans cette fonction il y a plusieurs if car les elif et else son utiliser que lorsque le if est faux

    nbr = 1
    bool = True
    # == est egal
    if nbr == 1:
        print("c'est egale")

    # != est different (n'est pas egale)
    if nbr != 1:
        print("c'est different")

    # > est plus grand que
    if nbr > 0:
        print("c'est plus grand que 0")

    # < est plus petit que
    if nbr < 2:
        print("c'est plus petit que 2")

    # >= est plus grand ou egale a
    if nbr >= 0:
        print("c'est plus grand ou egale a 0")

    # <= est plus petit ou egale a
    if nbr <= 2:
        print("c'est plus petit ou egale a 2")

    # vrai ou faux
    if nbr:
        print("c'est vrai")
    if bool:
        print("bool est vrai")

# apprendre les parametre des verification verifications possibles
def verification_2():
    nbr = 1
    car = "b"

    # and permet de verifier si les conditions sont vraies
    if nbr > 0 and nbr < 2:
        print("c'est superieur a 0 et inferieur a 2")

    # or permet de verifier si au moins une condition est vraie
    if nbr == 20 or nbr < 2:
        print("c'est egale a 20 ou inferieur a 2")

    # not permet de verifier si une condition est fausse
    if not (nbr < 0):
        print("ce n'est pas inferieur a 0")


    # exemple de condition imbriqué
    # reproduction du xor (ou exclusif)

    # 1er parenthèse on verifie si nbr est supérieur a 0 ou si cas vaut "a"
    # 2emme parenthèse on verifie si nbr est inférieur a 0 et si cas vaut "a" si c'est le cas on retourne faux car il y  le not
    # and entre les parenthèses permet de verifier si les conditions sont vraies
    # resultat un xor (ou exclusif)

    if ((nbr > 0 or car == "a") and  (not nbr > 0 or not car == "a")):
        print("c'est superieur a 0 car n'est pas egale a 'a'")





# if unique
# eneleve le hastage pour lancer la fonction
# condition_1()

# if avec else
# eneleve le hastage pour lancer la fonction
#condition_2()

# if avec elif
# eneleve le hastage pour lancer la fonction
#condition_3()

# if avec elif et else
# eneleve le hastage pour lancer la fonction
#condition_4()

# condition avec if et else sur une ligne
# eneleve le hastage pour lancer la fonction
#condition_avancer()


# apprendre les verifications possibles
# eneleve le hastage pour lancer la fonction
#verification()

# apprendre les parametre des verification verifications possibles
# eneleve le hastage pour lancer la fonction
#verification_2()