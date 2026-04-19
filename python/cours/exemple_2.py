

def case():
    mon_langage = input("quel est votre mangage favori ? ")
    # verifie les caracteres si ils sont egales
    match mon_langage:
        case "python":
            print("je suis un python")
        case "java":
            print("je suis un java")
        # si aucun des caracteres ne correspond a ce que l'on a saisi
        case _:
            print("je ne sais pas")

case()