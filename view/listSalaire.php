<?php include('commun/header.php'); ?>

<div>
    <center>
        <h2>liste salaire</h2>
    </center>
</div>

<?php include('../bdd/bdd.php');

//ecrire la requete
$requete = $bdd->prepare('SELECT * FROM salaire');
//executer la requete
$requete->execute();
//stocker les resultats de la requete pour manipuler le TR
$salaires = $requete->fetchAll();

/*var_dump($salaires);
die();*/
?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">libelle</th>
            <th scope="col">montant</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach($salaires as $salaire) { ?> 
        
        <tr>
            <th scope="row"> <?php echo $salaire['id']; ?></th>
            <td><?php echo $salaire['libelle']; ?></td>
            <td><?php echo $salaire['montant']; ?></td>
    
        </tr>
    <?php } ?>

    </tbody>
</table>













<?php include('commun/footer.php');
