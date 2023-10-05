<?php




function GetSummit($param)
{
    $sql = 'SELECT * FROM sommets WHERE 1 ';
    $sql .= $param;
    try {
        
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
