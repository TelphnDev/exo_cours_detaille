
# affiche "bonjour"
def exemple_1():
    print("bonjour")

# affiche une valeur
def exemple_2():
    # sa peut êrte tout type de variable
    # sa peut aussi être un input
    ma_variable = "salut"
    print(ma_variable)

# affiche deux valeurs
def exemple_3():
    age = 35
    # ici on additionne deux string donc il faut le convertir en string
    print("age : " + str(age))

    # les deux autre methodes
    print("age", age)
    print(f"age : {age}")