
# boucle infinie
def exemple_1():
    while True:
        input("infie : ")

# boucle avec condition ce qui le rend indeterminé
def exemple_2():
    choix = "a"
    while choix != "1":
        choix = input("Le chiffre 1 permet de quitter :")

# boule for simple
def exemple_3():
    # i est la variable du nombre de fois qu'on a bouclé
    # la boucle vas de 0 à 9 car le nombre donnér n'est pas inclus et il commence a 0
    for i in range(10):
        print(i)

# boucle for avec depart defini
def exemple_4():
    for i in range(5, 15):
        print(i)

# boucle avec depart definie et pas definit
def exemple_5():
    # 0 est le depart
    # 20 est la fin sans inclure
    # 2 est le pas
    for i in range(0, 20, 2):
        print(i)

### Partie ressemblant a un tableau ###

# exemple pour montrer la diférence avec un foreach
# while afficher caractere par caractere
def exemple_6():
    txt = input("Entrez un texte : ")
    count = 0
    while count < len(txt):
        print(txt[count])
        count += 1

# exemple pour montrer la diférence avec un for sans range
# for range pour afficher caractere par caractere
def exemple_7():
    txt = input("Entrez un texte : ")
    for i in range(len(txt)):
        # la methode utiliser renvoie un nombre dans i
        # ce nombre permet de pouvoir afficher le caractere comme un tableau
        print(txt[i])

# boucle for sans range anevec
def exemple_8():
    txt = input("Entrez un texte : ")
    for i in txt:
        print(i)

### Fin partie ressemblant a un tableau ###

# appel des fonctions

# eneleve le hastage pour lancer la fonction
#exemple_1()

# eneleve le hastage pour lancer la fonction
#exemple_2()

# eneleve le hastage pour lancer la fonction
#exemple_3()

# eneleve le hastage pour lancer la fonction
#exemple_4()

# eneleve le hastage pour lancer la fonction
#exemple_5()

# eneleve le hastage pour lancer la fonction
#exemple_6()

# eneleve le hastage pour lancer la fonction
#exemple_7()

# eneleve le hastage pour lancer la fonction
#exemple_8()