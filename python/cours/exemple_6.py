
# appele simple de la fonction
def exemple_1():
    print("bonjour")

# apelle de la fonction avec 2 parametre obligatoire
# variable1 est le nom attribuer a la variable
# variable2 est le nom attribuer a la variable
def exemple_2(variable1, variable2):
    print(f"variable1 : {variable1}  variable2 : {variable2}")

# appele de la fonction avec 2 parametre optionnel
def exemple_3(variable1 = "default", variable2 = "default"):
    print(f"variable1 : {variable1}  variable2 : {variable2}")

# appele de la fonction avec 1 parametre obligatoire et 1 optionnel
def exemple_4(variable1, variable2 = "default"):
    print(f"variable1 : {variable1}  variable2 : {variable2}")

# appele de la fonction avec 1 parametre obligatoire et le type est definie par int
def exemple_5(variable1 : int):
    print(f"variable1 : {variable1}")

# appele de la fonction avec 1 parametre optionnel et le type est definie par int
# variable1 est le nom attribuer a la variable
# int est le type de la variable
# 1 est la valeur par defaut
def exemple_6(variable1 : int = 1):
    print(f"variable1 : {variable1}")

# appele de la fonction sans parametre et le type de retour est definie par None (donc aucun retour)
def exemple_7() -> None:
    print("bonjour")

# exemple avec retour
def exemple_8() -> None:
    # appele la fonction retour_valeur et affiche la valeur retourner
    print(retour_valeur())

def retour_valeur() -> str:
    return "bonjour"

