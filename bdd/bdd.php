<?php


    try{
        $user = "root";
        $pass = "";
        $bdd = new PDO('mysql:host=localhost;dbname=findumois', $user,$pass);


    }catch(PDOException $e){
        print"erreur !:". $e->getMessage();
        die();
    }



?>