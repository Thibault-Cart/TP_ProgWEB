<?php

//DECLARATION VARAIBLES ET CONSTANTE
define("DB_HOST","127.0.0.1");
define("DB_USER","root");
define("DB_PSW","");
define("DB_NAME","tp_bdd");


function GetDataByLocalite($localite){
    $sql='SELECT  DISTINCT npa.npa_localite FROM npa WHERE npa.npa_localite LIKE "'.$localite.'%" ';
    try{
        $bdd = new mysqli(DB_HOST, DB_USER, DB_PSW, DB_NAME);
        $rec = $bdd->query($sql);
        $row = $rec->fetch_all();
       if (empty($row)) {
            throw new Exception("Aucune donnée trouvée");
       }
        $bdd->close();
        return $row;
    }catch (Exception  $e)
     { if ($e->getMessage() == "Aucune donnée trouvée") {
        throw new Exception("Aucune donnée trouvée");
     }
        throw new Exception("Erreur de connexion a la base de donnée");
    }

     
    
}


function GetDataByNpa($localite){
    $sql='SELECT  DISTINCT npa.npa_localite FROM npa WHERE npa.npa_code LIKE "'.$localite.'%"';
    try{
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
       if (empty($row)) {
            throw new Exception("Aucune donnée trouvée");
       }
        
        return $row;
    }catch (Exception  $e)
     { if ($e->getMessage() == "Aucune donnée trouvée") {
        throw new Exception("Aucune donnée trouvée");
     }
        throw new Exception("Erreur de connexion a la base de donnée");
    }


}
