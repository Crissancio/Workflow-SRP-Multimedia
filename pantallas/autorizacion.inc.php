<?php
// Obtener datos del paciente
$sql = "SELECT p.nombre, p.edad, p.sexo
        FROM seguimiento s
        JOIN paciente p ON s.ci_paciente = p.ci
        WHERE s.id_seguimiento = $id_seguimiento";

$res = mysqli_query($con, $sql);
$paciente = mysqli_fetch_assoc($res);
?>

<h3>📝 Autorización para Vacunación</h3>

<div style="border:1px solid #ccc; padding:12px; margin-bottom:15px;">
    <h4>👤 Datos del Paciente</h4>
    <p><b>Nombre:</b> <?= $paciente["nombre"] ?></p>
    <p><b>Edad:</b> <?= $paciente["edad"] ?> años</p>
    <p><b>Sexo:</b> <?= $paciente["sexo"] == "M" ? "Masculino" : "Femenino" ?></p>
</div>

<p style="color:#555;">
    El paciente es <b>menor de edad</b>.  
    Para continuar con la vacunación se requiere autorización del tutor legal.
</p>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">

    <p><b>¿Cuenta con autorización del tutor legal?</b></p>

    <label>
        <input type="radio" name="condicion" value="autorizado" required>
        ✅ Sí, tiene autorización
    </label><br>

    <label>
        <input type="radio" name="condicion" value="no_autorizado">
        ❌ No cuenta con autorización
    </label><br><br>

    <p style="color:orange;">
        ⚠️ Si no cuenta con autorización, el trámite se devuelve al paciente.
    </p>

    <button type="submit">➡️ Continuar</button>
</form>
