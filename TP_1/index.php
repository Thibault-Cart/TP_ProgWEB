<?php

require "Requete.php";


?>

<!doctype html>
<html>

<head>
    <title>Example Domain</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<body>




    <h3>TP 1 BDD</h3>
    <div>
        <form action="#" method="post">
            <label for="npa">Saisir une localite</label>
            <input value="" id="npa" name="npa" type="text"><br>
            <label for="cbxGoogle">Voulez vous un lien Google</label>
            <input type="checkbox" id="cbxGoogle" name="cbxGoogle" checked />
            <br><input class="btn btn-primary" type="submit" name="submit" value="Envoyer">
        </form>

        <?php
        if (isset($_POST["submit"])) {
            $param = $_POST["npa"];

            try {
                if (is_numeric($param)) {
                    $data = GetDataByNpa($param);
                    echo "<h2>Les localites dont le NPA EST : " . $param . "</h2>";
                } else {
                    $data = GetDataByLocalite($param);
                    echo "<h2>Les localites dont le nom commence par : " . $param . "</h2>";
                }
                // affichage des données a lindex 2 du tableau

                foreach ($data as $key => $value) {
                    if (isset($_POST["cbxGoogle"])) {
                        echo "<a href='https://www.google.com/maps/place/" . $value[0] . "'>" . $value[0] . "</a><br>";
                    } else {
                        echo $value[0] . "<br>";
                    }
                }
            } catch (Exception  $e) {
                echo $e->getMessage();
            }
        }

        ?>
        <br>


    </div>

</body>

</html>