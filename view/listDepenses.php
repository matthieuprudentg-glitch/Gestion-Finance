<?php include('commun/header.php'); ?>

<div>
    <center>
        <h2>liste depenses</h2>
    </center>
</div>

<?php include('../bdd/bdd.php');

//ecrire la requete
$requete = $bdd->prepare('SELECT * FROM depense');
//executer la requete
$requete->execute();
//stocker les resultats de la requete pour manipuler le TR
$depenses = $requete->fetchAll();

/*var_dump($salaires);
die();*/
?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">libelle</th>
            <th scope="col">categorie</th>
            <th scope="col">montant</th>

        </tr>
    </thead>
    <tbody>

    <?php foreach($depenses as $depense) { ?> 
        
        <tr>
            <th scope="row"> <?php echo $depense['id']; ?></th>
            <td><?php echo $depense['libelle']; ?></td>
            <td><?php echo $depense['categorie']; ?></td>
            <td><?php echo $depense['montant']; ?></td>
    
        </tr>
    <?php } ?>

    </tbody>
</table>













<?php include('commun/footer.php');
