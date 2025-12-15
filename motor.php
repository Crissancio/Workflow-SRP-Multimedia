<?php
session_start();
include "config/conexion.php";

/*
 NUEVO TRÁMITE
*/
if (isset($_GET["nuevo"])) {

    $sql = "SELECT id_proceso FROM proceso WHERE codigo = 'P1'";
    $res = mysqli_query($con, $sql);
    $fila = mysqli_fetch_assoc($res);

    $id_proceso = $fila["id_proceso"];

    $sql = "INSERT INTO seguimiento
            (id_flujo, id_proceso_actual, fecha_inicio, estado)
            VALUES
            (1, $id_proceso, NOW(), 'activo')";

    mysqli_query($con, $sql);

    $id_seguimiento = mysqli_insert_id($con);

    header("Location: motor.php?id_seguimiento=$id_seguimiento");
    exit;
}

/*
 CONTINUAR TRÁMITE
*/
$id_seguimiento = $_GET["id_seguimiento"];

$sql = "SELECT p.pantalla, p.nombre
        FROM seguimiento s
        JOIN proceso p ON s.id_proceso_actual = p.id_proceso
        WHERE s.id_seguimiento = $id_seguimiento";

$res = mysqli_query($con, $sql);
$fila = mysqli_fetch_assoc($res);

$pantalla = $fila["pantalla"];
$nombre_proceso = $fila["nombre"];
?>

<h2><?= $nombre_proceso ?></h2>

<?php include "pantallas/$pantalla.inc.php"; ?>
