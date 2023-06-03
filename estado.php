<?php 
require_once 'conexion.php';
require_once 'jwt.php'; 
$c = conexion();
if (isset($_GET['id'])) {
    $s = $c->prepare("SELECT * FROM bulb WHERE id = :id");
    $s->bindValue(":id", $_GET['id']);
} else {
    $s = $c->prepare("SELECT * FROM bulb");
}
$s->execute();
$s->setFetchMode(PDO::FETCH_ASSOC);
$r = $s->fetchAll();

header("Content-Type: application/json");
echo $r[0]['status'];

?>