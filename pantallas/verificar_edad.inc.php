<?php
$sql = "SELECT p.nombre, p.edad, p.sexo
        FROM seguimiento s
        JOIN paciente p ON s.ci_paciente = p.ci
        WHERE s.id_seguimiento = $id_seguimiento";

$res = mysqli_query($con, $sql);
$p = mysqli_fetch_assoc($res);

$condicion = ($p["edad"] < 18) ? "menor" : "mayor";
?>

<h3>🔍 Verificación de Edad</h3>

<div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
    <p><b>Nombre:</b> <?= $p["nombre"] ?></p>
    <p><b>Edad:</b> <?= $p["edad"] ?> años</p>
    <p><b>Sexo:</b> <?= $p["sexo"] == "M" ? "Masculino" : "Femenino" ?></p>
</div>

<?php if ($condicion == "menor"): ?>
    <p style="color:orange;">
        🧒 El paciente es menor de edad.  
        Se requiere autorización del tutor legal.
    </p>
<?php else: ?>
    <p style="color:green;">
        🧑 El paciente es mayor de edad.  
        Puede continuar directamente a la vacunación.
    </p>
<?php endif; ?>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">
    <input type="hidden" name="condicion" value="<?= $condicion ?>">

    <button type="submit">➡️ Continuar</button>
</form>
