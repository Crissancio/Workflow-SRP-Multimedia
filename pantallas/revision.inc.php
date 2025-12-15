<?php
$sql = "SELECT p.nombre, p.edad, p.sexo,
               r.fiebre, r.alergias, r.inmunodeficiencia, r.embarazo
        FROM seguimiento s
        JOIN paciente p ON s.ci_paciente = p.ci
        JOIN registro_clinico r ON s.id_seguimiento = r.id_seguimiento
        WHERE s.id_seguimiento = $id_seguimiento";

$res = mysqli_query($con, $sql);
$d = mysqli_fetch_assoc($res);
?>

<h3>Datos del Paciente</h3>
<ul>
    <li><b>Nombre:</b> <?= $d["nombre"] ?></li>
    <li><b>Edad:</b> <?= $d["edad"] ?></li>
    <li><b>Sexo:</b> <?= $d["sexo"] ?></li>
</ul>

<h3>Condiciones Clínicas</h3>
<ul>
    <li><b>Fiebre:</b> <?= $d["fiebre"] ? "Sí" : "No" ?></li>
    <li><b>Alergias:</b> <?= $d["alergias"] ? "Sí" : "No" ?></li>
    <li><b>Inmunodeficiencia:</b> <?= $d["inmunodeficiencia"] ? "Sí" : "No" ?></li>
    <li><b>Embarazo:</b> <?= $d["embarazo"] ? "Sí" : "No" ?></li>
</ul>

<h3>Decisión de la Enfermera</h3>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">

    <label>
        <input type="radio" name="condicion" value="sin_riesgo" required>
        Paciente apto
    </label><br>

    <label>
        <input type="radio" name="condicion" value="riesgo" required>
        Condición de riesgo
    </label><br><br>

    <button type="submit">Continuar</button>
</form>
