<?php
// Obtener datos del paciente
$sql = "SELECT p.nombre, p.edad, p.sexo
        FROM seguimiento s
        JOIN paciente p ON s.ci_paciente = p.ci
        WHERE s.id_seguimiento = $id_seguimiento";

$res = mysqli_query($con, $sql);
$paciente = mysqli_fetch_assoc($res);
?>

<h3>⏱️ Observación Post Vacunación</h3>

<div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
    <h4>👤 Datos del Paciente</h4>
    <p><b>Nombre:</b> <?= $paciente["nombre"] ?></p>
    <p><b>Edad:</b> <?= $paciente["edad"] ?> años</p>
    <p><b>Sexo:</b> <?= $paciente["sexo"] == "M" ? "Masculino" : "Femenino" ?></p>
</div>

<p>
El paciente debe permanecer en observación entre
<b>15 y 30 minutos</b> después de la aplicación de la vacuna.
</p>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">

    <p><b>¿Presenta algún síntoma durante la observación?</b></p>

    <label>
        <input type="radio" name="condicion" value="evento" required>
        🚨 Sí, presenta síntomas
    </label><br>

    <label>
        <input type="radio" name="condicion" value="normal">
        ✅ No, todo normal
    </label><br><br>

    <p style="color:green;">
        ✔ Si no hay síntomas, el proceso continúa normalmente.
    </p>

    <button type="submit">➡️ Continuar</button>
</form>
