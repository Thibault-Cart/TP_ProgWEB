<?php
require_once('requete.php');


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



parse_str($_SERVER['QUERY_STRING'], $query);


$body = file_get_contents('php://input');

$method = $_SERVER['REQUEST_METHOD'];



$tableauAffichage = array(
    "data" => "",
    "message" => "",
);
//echo json_encode($tableauAffichage);


if ($method == "GET") {

    if ($query == null) {
        try {
            $result = GetAllUser();
            $tableauAffichage["data"] = $result;
            
           
        } catch (Exception  $e) {
            $tableauAffichage["message"] = $e->getMessage();
        }
    } else {
        try {
            $result =  GetUserById($query['id']);
            $tableauAffichage["data"] = $result;
        } catch (Exception  $e) {
            $tableauAffichage["message"] = $e->getMessage();
        }
    }
    echo json_encode($tableauAffichage);
}


if ($method == 'DELETE') {

    if ($query != null) {

        $tableauAffichage["message"] = DeleteUserById($query['id']);
    }
    echo json_encode($tableauAffichage,);
}
if ($method == "POST") {


    if (isset($query['nom']) && isset($query['prenom']) && isset($query['email'])) {

        $nom = $query['nom'];
        $prenom = $query['prenom'];
        $email = $query['email'];
        $npa = isset($query['npa']) ? (int)$query['npa'] : null;
        $pays = isset($query['pays']) ? $query['pays'] : null;

        $tableauAffichage["message"] = AddUser($prenom, $nom, $email, $pays, $npa);
    } else {

        $tableauAffichage["message"] = "Une des valeurs obligatoire n'est pas transmise";
    }

    echo json_encode($tableauAffichage);
}

if ($method == "PUT" || $method == "PATCH") {


    
        $id = isset($query['id']) ? (int)$query['id'] : null;
        $nom =isset($query['nom']) ? $query['nom'] : null;
        $prenom = isset($query['prenom']) ? $query['prenom'] : null;
        $email = isset($query['email']) ? $query['email'] : null;
        $npa = isset($query['npa']) ? (int)$query['npa'] : null;
        $pays = isset($query['pays']) ? $query['pays'] : null;

        
        $tableauAffichage["message"] = UpdateUser($id,$prenom, $nom, $email, $pays, $npa);

    echo json_encode($tableauAffichage);
}
