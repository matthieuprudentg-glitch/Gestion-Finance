<!-- integrer un bout de code dans la page -->

<?php include('commun/header.php'); ?>

<!-- contenue de la page en dessous -->



<?php include("../bdd/bdd.php");


if (isset($_POST['libelle'])) {
    //execution pour envoyer a la BDD 
    $requete = $bdd->prepare("INSERT INTO depense(libelle, categorie, montant) VALUES(:libelle, :categorie, :montant)");
    $requete->bindParam(':libelle', $_POST['libelle']);
    $requete->bindParam(':categorie', $_POST['categorie']); // permet d'eviter les injonction sql
    $requete->bindParam(':montant', $_POST['montant']);
    $requete->execute();
    // redirection une fois inseré dans la base 
    header('location:http://localhost/promo321/pageslairefianlamodifier/view/listDepenses.php');
}
?>







<div>
    <h1>depense</h1>
</div>
<div>
    <center>
        <h2>formulaire de depense</h2>
        <form action="" method="POST">
            <p>nom </p>
            <input type="text" name="libelle" placeholder="libelle"><br>
            <p>categorie</p>
            <input type="text" name="categorie" placeholder="categorie"><br>
            <p>montant</p>
            <input type="number" name="montant" placeholder="montant"><br>
            <input type="submit" name="valider" value="valider">
        </form>
    </center>
</div>



<?php include('commun/footer.php'); ?>