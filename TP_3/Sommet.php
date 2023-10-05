
<?php
 
 class Sommet  
{
    private $pdo;
    



    public function __construct() {
            // Définit les constantes de connexions.
        define('DB_HOST', "127.0.0.1");
        define('DB_NAME', 'tp_bdd');
        define('DB_USER', 'root');
        define('DB_PSW', '');
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PSW);
    }
}
 



?>