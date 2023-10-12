<?php

function XML_creator($rows)
{
  // Récupération des données de la base de données
  if (count($rows) > 0) {

    // Créez un nouveau XML document
    $xml_header = '<?xml version="1.0" encoding="UTF-8"?><LIST_Localite></LIST_Localite>';
    $xml = new SimpleXMLElement($xml_header);



    // Convertissez et ajoutez les données ligne par ligne au XML
    foreach ($rows as $row) {

      //ajout d'un noeud enfant au noeud racine
      $node1 = $xml->addChild('Localite');
      //ajout d'un noeud  pour chaque valeur
      $node1->addChild('npa_id', $row[0]);
      $node1->addChild('npa_localite', $row[2]);
      $node1->addChild('npa_code', $row[1]);
    }

    $test = $xml->asXML('localite.xml');

    if ($test == true) {
      echo "Le fichier XML a été créé avec succès";
    }
  }
}


function JSON_creator($rows)
{
  // Si aucun résultat n'a été trouvé, on génère une erreur.
  if (count($rows) == 0) {
    throw new Exception("Aucune localité ne correspond à votre recherche<br/>");
  }

  // creation array vide
  $result = array();


  // Parcours les résultats trouvés pour affichage
  foreach ($rows as $row) {

    // Exercice 03
    // Voir si affichage du lien
    if (isset($_POST['avecLien'])) {
      // Construction du lien
      $lien = '<a href="https://www.google.ch/?q=' . $row->npa_localite . '">Voir dans Google</a>';
    } else {
      $lien = '';
    }
    // array temporaire prend comme valeur un localite
    $temp = array('id' => "{$row->npa_id}", 'localite' => "{$row->npa_localite}", 'code' => "{$row->npa_code}", 'lien' => "{$lien}");
    // array temporaire est ajouter dans le array result
    array_push($result, $temp);
    // reinitialisation du array temporaire
    $temp = array();
  }
  // creation du fichier json avec comme param le nom et le array result converti en json
  $creation = file_put_contents('localite.json', json_encode($result));

  // si la creation du fichier json est false alors afficher un message d'erreur
  if ($creation == false) {
    echo "Probleme lors de la creation du fichier json";
  } else {
    echo "Fichier json creer avec succes";
  }
}

// Définit les constantes de connexions.
define('DB_HOST', 'localhost');
define('DB_NAME', 'tp_bdd');
define('DB_USER', 'root');
define('DB_PSW', '');

// Exercice 01

// Tester si la recherche a été déclenchée
if (isset($_POST['rechercher'])) {
  // Lance le code dans un bloc "try".
  try {
    // Connexion à la base de données
    $bdd = new mysqli(DB_HOST, DB_USER, DB_PSW, DB_NAME);
    // Lire le critère et protéger la requête contre les injections SQL ou bug en cas de recherche avec un apostrophe.
    $critere = addslashes($_POST['critere']);
    // Construire la requête
    $sql = "select * from npa where npa_localite like '$critere%'";
    // Exécution de la requête.
    $rec = $bdd->query($sql);
    // Si aucun résultat n'a été trouvé, on génère une erreur.
    if ($rec->num_rows == 0) {
      throw new Exception("Aucune localité ne correspond à votre recherche<br/>");
    }
    // Récupération des résultats (sous format d'un tableau d'objet)
    $rows = $rec->fetch_all();

    XML_creator($rows);

    // Affichage de l'erreur si elle a été trouvée.
  } catch (Exception $e) {
    echo 'ERREUR: ' . $e->getMessage();
  }
}




// Tester si la recherche a été déclenchée
if (isset($_POST['rechercher_ex2'])) {
  // Lance le code dans un bloc "try".
  try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
    // Lire le critère et protéger la requête contre les injections SQL ou bug en cas de recherche avec un apostrophe
    $critere = addslashes($_POST['critere']);
    // Voir si le critère est numérique
    if (is_numeric($critere)) {
      $clause = "npa_code like '$critere%'";
    } else {
      $clause = "npa_localite like '$critere%'";
    }
    // Construire la requête
    $sql = "select * from npa where $clause";
    // Préparer la requête.
    $stmt = $pdo->prepare($sql);
    // Exécution de la requête.
    $stmt->execute();
    // Récupération des résultats (sous format d'un tableau d'objet)
    $rows = $stmt->fetchAll(PDO::FETCH_CLASS);

    JSON_creator($rows);


  } catch (Exception $e) {
    echo 'ERREUR: ' . $e->getMessage();
  }
}
