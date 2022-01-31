<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');

use Medoo\Medoo;

$data = $database->query("SELECT classfield.classfield_categoryid, classfield_category.category_title, classfield_category.category_icon, count(*) AS classfield_count
FROM classfield
INNER JOIN classfield_category
ON classfield.classfield_categoryid = classfield_category.ctid
GROUP BY classfield_categoryid
ORDER BY classfield_count DESC
LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
header('Content-type: application/json');
echo json_encode($data);

?>