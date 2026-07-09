<?php include('commun/header.php'); ?>
<!-- contenue de la page de salaire -->
 <div>
        <h1>Page Salaire</h1>
    </div>
<?php include('../bdd/bdd.php'); //inclusion de la connexion a la base de donnee
//var_dump($_POST); //permet de voir les donnes envoyees par le formulaire

if (isset($_POST['libelle'])) { //verifie si le bouton valider a ete clique
    //recuperation des donnes du formulaire
    //var_dump('je rentre dedans'); //permet de voir la donnee saisie dans la case libelle
    $requete = $bdd->prepare ("INSERT INTO salaire(libelle, montant) VALUES (:libelle, :montant)"); //preparation de la requete d'insertion et : sert de variable temporaire
    $requete->bindParam(':libelle', $_POST['libelle']); //liaison du parametre :libelle avec la donnee saisie dans la case libelle
    //requete pour remplacer la valeur de :libelle par la donnee saisie dans la case libelle
    $requete->bindParam(':montant', $_POST['montant']); //liaison du parametre :montant avec la donnee saisie dans la case montant

    $requete->execute(); //execution de la requete

    header('Location:http://localhost/promo321/pageslairefianlamodifier/view/listSalaire.php'); //redirection vers la page salaire.php

}

?>

    <div>
        <h1>Formulaire de salaire</h1>

        <form action=" " method="post"> <!-- permet d'envoyer les donnes du formulaire en methode post -->
            <!--formulaire de saisie-->
            <p>nom entreprise</p>
            <!--input permet au client de saisir dans la case-->
            <input type="text" name="libelle" placehold="libelle"> <!-- name permet de nommer la case pour recuperer la donnee-->
            <p>montant</p>
            <input type="number" name="montant" placeholder="montant"> <!-- PLACEHOLDER est un texte d'aide a la saisie-->

            <input type="submit" name="valider" value="valider">
        </form>
    </div>
<?php include('commun/footer.php'); ?>