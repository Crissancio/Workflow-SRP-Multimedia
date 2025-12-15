<?php
session_start();
include "config/conexion.php";

/*
 Mostrar trámites activos
*/
$sql = "SELECT s.id_seguimiento, p.nombre AS proceso
        FROM seguimiento s
        JOIN proceso p ON s.id_proceso_actual = p.id_proceso
        WHERE s.fecha_fin IS NULL";

$resultado = mysqli_query($con, $sql);
?>

<h2>Trámites de Vacunación SRP</h2>

<a href="motor.php?nuevo=1">➕ Iniciar nuevo trámite</a>
<br><br>

<table border="1">
    <tr>
        <th>ID Seguimiento</th>
        <th>Proceso Actual</th>
        <th>Acción</th>
    </tr>

<?php
while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>{$fila['id_seguimiento']}</td>";
    echo "<td>{$fila['proceso']}</td>";
    echo "<td>
            <a href='motor.php?id_seguimiento={$fila['id_seguimiento']}'>
            Continuar
            </a>
          </td>";
    echo "</tr>";
}
?>
</table>
