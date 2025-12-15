<?php
$sql = "SELECT *
        FROM vacunacion_srp
        WHERE ci_paciente = (
            SELECT ci_paciente
            FROM seguimiento
            WHERE id_seguimiento = $id_seguimiento
        )
        ORDER BY fecha_aplicacion ASC";

$res = mysqli_query($con, $sql);
$cant = mysqli_num_rows($res);
?>

<h3>🧬 Verificación del Esquema SRP</h3>

<p><b>Dosis registradas:</b> <?= $cant ?></p>

<?php if ($cant > 0): ?>
<table border="1" cellpadding="6">
    <tr>
        <th>#</th>
        <th>Fecha</th>
        <th>Dosis</th>
        <th>Vacuna</th>
    </tr>
    <?php $i=1; while ($v=mysqli_fetch_assoc($res)): ?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= $v["fecha_aplicacion"] ?></td>
        <td><?= $v["dosis"] ?></td>
        <td><?= $v["tipo_vacuna"] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p style="color:red;">⚠️ No existen dosis registradas.</p>
<?php endif; ?>

<hr>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">

    <p><b>¿Cuenta con 2 dosis documentadas?</b></p>

    <label>
        <input type="radio" name="condicion" value="completo" required>
        Sí, esquema completo
    </label><br>

    <label>
        <input type="radio" name="condicion" value="incompleto">
        No, requiere vacunación
    </label><br><br>

    <button type="submit">➡️ Continuar</button>
</form>
