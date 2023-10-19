<?php


// Définit les constantes de connexions.
define('DB_HOST', "127.0.0.1");
define('DB_NAME', 'tp_bdd');
define('DB_USER', 'root');
define('DB_PSW', '');



function GetAllUser()
{
    $sql = 'SELECT * FROM clients ';


    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll();
    if (empty($row)) {
        throw new Exception("Aucune donnée trouvée");
    }

    return $row;
}
function GetUserById($iduser)
{
    $sql = 'SELECT * FROM clients WHERE id = :id';

    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $iduser);
        $stmt->execute();
        $row = $stmt->fetchAll();
        if (empty($row)) {
            throw new Exception("Aucune donnée trouvée");
        }

        return $row;
    } catch (Exception  $e) {
        throw new Exception("Erreur : " . $e->getMessage());
    }
}

function DeleteUserById($iduser)
{

    $iduser = (int) $iduser;
    $sql = "DELETE  FROM clients WHERE id = :id ";


    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $iduser, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {


        return "L'utilisateur ayant l'id " . $iduser . " a bien été supprimé";
    } else {
        return "L'utilisateur ayant l'id " . $iduser . " n'a pas été supprimé";
    }
}


function AddUser($prenom, $nom, $email, $pays, $npa)
{

    $sql = "INSERT INTO `clients`(`id`, `prenom`, `nom`, `email`, `pays`, `npa`) 
    VALUES ('NULL',:prenom,:nom,:email,:pays,:npa);";


    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':pays', $pays, PDO::PARAM_STR);
    $stmt->bindParam(':npa', $npa, PDO::PARAM_INT);


    try {
        $stmt->execute();
    } catch (Exception $e) {
        return "Error lors de l'execution de la requete";
    }
    if ($stmt->rowCount() == 1) {


        return "L'utilisateur a ete ajouter";
    } else {
        return "L'utilisateur n'a pas ete ajouter!!!!!!!!!!!!!!!!!!";
    }
}

function UpdateUser($id, $prenom, $nom, $email, $pays, $npa)
{
    $npa = (int)$npa;
    $sql = "UPDATE `clients` SET  `prenom`=:prenom,`nom`=:nom,`email`=:email,`pays`=:pays,`npa`=:npa WHERE id=:id; ";


    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':pays', $pays, PDO::PARAM_STR);
    $stmt->bindParam(':npa', $npa, PDO::PARAM_INT);


    try {
        $stmt->execute();
    } catch (Exception $e) {
        return "Error lors de l'execution de la requete";
    }

    if ($stmt->rowCount() == 1) {


        return "L'utilisateur a ete modifier";
    } else {
        return "L'utilisateur n'a pas ete modifier!!!!!!!!!!!!!!!!!!";
    }
}
