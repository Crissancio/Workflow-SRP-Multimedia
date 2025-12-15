<?php
// Datos del paciente
$sql = "SELECT p.nombre, p.edad, p.sexo
        FROM seguimiento s
        JOIN paciente p ON s.ci_paciente = p.ci
        WHERE s.id_seguimiento = $id_seguimiento";

$res = mysqli_query($con, $sql);
$paciente = mysqli_fetch_assoc($res);
?>

<h3>🚨 Registro de Evento Adverso</h3>

<div style="border:1px solid #e57373; padding:10px; margin-bottom:15px; background:#fff3f3;">
    <h4>👤 Datos del Paciente</h4>
    <p><b>Nombre:</b> <?= $paciente["nombre"] ?></p>
    <p><b>Edad:</b> <?= $paciente["edad"] ?> años</p>
    <p><b>Sexo:</b> <?= $paciente["sexo"] == "M" ? "Masculino" : "Femenino" ?></p>
</div>

<p style="color:red;">
⚠️ Se ha detectado un evento adverso posterior a la vacunación.
Por favor registre la información correspondiente.
</p>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">
    <input type="hidden" name="condicion" value="registrado">

    <label><b>Tipo de evento:</b></label><br>
    <select name="tipo" required>
        <option value="">-- Seleccione --</option>
        <option value="Urticaria">Urticaria</option>
        <option value="Reacción alérgica">Reacción alérgica</option>
        <option value="Dificultad respiratoria">Dificultad respiratoria</option>
        <option value="Otro">Otro</option>
    </select><br><br>

    <label><b>Descripción del evento:</b></label><br>
    <textarea name="descripcion" rows="4" cols="50" required></textarea><br><br>

    <button type="submit">➡️ Registrar evento y continuar</button>
</form>
