<?php
// Datos del paciente
$sql = "SELECT p.nombre, p.edad, p.sexo
        FROM seguimiento s
        JOIN paciente p ON s.ci_paciente = p.ci
        WHERE s.id_seguimiento = $id_seguimiento";

$res = mysqli_query($con, $sql);
$paciente = mysqli_fetch_assoc($res);
?>

<h3>💉 Registro de Vacunación SRP</h3>

<div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
    <h4>👤 Datos del Paciente</h4>
    <p><b>Nombre:</b> <?= $paciente["nombre"] ?></p>
    <p><b>Edad:</b> <?= $paciente["edad"] ?> años</p>
    <p><b>Sexo:</b> <?= $paciente["sexo"] == "M" ? "Masculino" : "Femenino" ?></p>
</div>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">
    <input type="hidden" name="condicion" value="aplicada">

    <label>📅 Fecha de aplicación:</label><br>
    <input type="date" name="fecha" required><br><br>

    <label>💊 Dosis aplicada:</label><br>
    <select name="dosis" required>
        <option value="1">Primera dosis</option>
        <option value="2">Segunda dosis</option>
    </select><br><br>

    <button type="submit">➡️ Registrar vacunación</button>
</form>
