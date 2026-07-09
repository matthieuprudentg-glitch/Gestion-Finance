<!-- integrer un bout de code dans la page -->

<?php include('commun/header.php'); ?>

<!-- contenue de la page en dessous -->

<div>
    <h1>epargne</h1>
</div>
<div>
    <center>
        <h2>epargne</h2>
        <form action="" method="POST">
            <p>nom </p>
            <input type="text" name="libelle"><br>
            <p>categorie</p>
            <input type="text" name="categorie"><br>
            <p>montant</p>
            <input type="number" name="montant"><br>
            <input type="submit" name="valider" value="valider">
        </form>
    </center>
</div>


<?php include('commun/footer.php'); ?>