<?php

require_once('requete.php');

// Constante qui défini le nombre d'entrée maximum à afficher sur la pagination.
define('NOMBRE_PAR_PAGE', 20);

// Variables utilisées lors de la recherche.
$nom = "";
$region = "";
$alt_min = "";
$alt_max = "";
$tri = "";
$sens = "";
$page = 1;
// Variables d'affichage.
$totalResults = 0;
$resultat = '';
$erreur = '';

if (isset($_GET['submit'])) {
  $nom = $_GET['nom'];
  $region = $_GET['region'];
  $alt_min = $_GET['alt_min'];
  $alt_max = $_GET['alt_max'];
  $tri = $_GET['tri'];
  $sens = $_GET['sens'];

  $page = $_GET['submit'];

  $querySansLimites = "";
  $query = "";
  if ($nom != "") {
    $query .= " AND som_nom LIKE '" . $nom . "%' ";
  }
  if ($region != "") {
    $query .= " AND som_region LIKE '" . $region . "%' ";
  }
  if ($alt_min != "") {
    $query .= " AND som_altitude >= " . $alt_min . " ";
  }
  if ($alt_max != "") {
    $query .= " AND som_altitude <= " . $alt_max . " ";
  }
  if ($tri != "") {
    $query .= " ORDER BY " . $tri . " ";
  }
  if ($sens != "") {
    $query .= " " . $sens . " ";
  }
  $querySansLimites = $query;
  if ($page != "") {
    $query .= " LIMIT " . ($page - 1) * NOMBRE_PAR_PAGE . ", " . NOMBRE_PAR_PAGE . " ";
  }
  try {
    $data = GetSummit($query);

    foreach ($data as $key => $value) {

      $resultat .= "<p> --NOM: " . $value[1] . " -- Region: " . $value[2] . " -- ALT MAX : " . $value[3] . " metres</p> <br>";
    }
    $datatemp = GetSummit($querySansLimites);
    $totalResults = count($datatemp);
  } catch (Exception  $e) {
    echo "--Erreur : " . $e->getMessage();
  }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Sommets</title>
</head>

<body class="container">

  <h1>Recherche des sommets</h1>

  <form method="get" action="">

    <div class="row">

      <!-- Filtre pour la recherche (nom, region, alt_min et alt_max) sous forme de champs de texte -->
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Filtres</h5>
            <div class="mb-3">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom ?>">
            </div>
            <div class="mb-3">
              <label for="region" class="form-label">Région</label>
              <input type="text" class="form-control" id="region" name="region" value="<?php echo $region ?>">
            </div>
            <div class="mb-3">
              <label for="alt_min" class="form-label">Altitude minimum</label>
              <input type="text" class="form-control" id="alt_min" name="alt_min" value="<?php echo $alt_min ?>">
            </div>
            <div class="mb-3">
              <label for="alt_max" class="form-label">Altitude maximum</label>
              <input type="text" class="form-control" id="alt_max" name="alt_max" value="<?php echo $alt_max ?>">
            </div>
          </div>
        </div>
      </div>

      <!-- Tri pour la recherche (tri et sens) sous forme de liste de sélection -->
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Tri</h5>
            <select class="form-select" name="tri">
              <option <?php if ($tri == "som_nom") {
                        echo 'selected';
                      } ?> value="som_nom">Nom</option>
              <option <?php if ($tri == "som_region") {
                        echo 'selected';
                      } ?> value="som_region">Région</option>
              <option <?php if ($tri == "som_altitude") {
                        echo 'selected';
                      } ?> value="som_altitude">Altitude</option>
            </select>
            <select class="form-select" name="sens">
              <option <?php if ($sens == "asc") {
                        echo 'selected';
                      } ?> value="asc">Ascendant</option>
              <option <?php if ($sens == "desc") {
                        echo 'selected';
                      } ?> value="desc">Descendant</option>
            </select>
          </div>
        </div>

      </div>

    </div>

    <br />

    <!-- Lance la recherche -->
    <button type="submit" name="submit" value="1" class="btn btn-primary">Rechercher</button>

    <hr />

    <!-- Pagination de la recherche -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <?php for ($pageNum = 0; $pageNum < $totalResults / NOMBRE_PAR_PAGE; $pageNum++) { ?>
          <li class="page-item <?php if ($page == $pageNum + 1) {
                                  echo 'active';
                                } ?>"><button type="submit" name="submit" value="<?php echo $pageNum + 1 ?>" class="page-link"><?php echo $pageNum + 1 ?></a></li>
        <?php } ?>
      </ul>
    </nav>

  </form>

  <!-- Affiche le résultat de la recherche -->
  <p><?php echo $resultat ?></p>

  <!-- Affiche l'erreur -->
  <p class="text-bg-danger"><?php echo $erreur ?></p>

</body>

</html>