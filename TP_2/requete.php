<?php


// Définit les constantes de connexions.
define('DB_HOST', "127.0.0.1");
define('DB_NAME', 'tp_bdd');
define('DB_USER', 'root');
define('DB_PSW', '');



function GetSummit($param)
{
    $sql = 'SELECT * FROM sommets WHERE 1 ';
    $sql .= $param;
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
        $stmt = $pdo->prepare($sql);
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
