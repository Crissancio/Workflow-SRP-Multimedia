<?php
include "config/conexion.php";

$id_seguimiento = $_POST["id_seguimiento"] ?? null;
$condicion = $_POST["condicion"] ?? null;

if (!$id_seguimiento) {
    die("❌ Seguimiento no especificado");
}

/*
 1️⃣ OBTENER PROCESO ACTUAL
*/
$sql = "SELECT id_proceso_actual
        FROM seguimiento
        WHERE id_seguimiento = $id_seguimiento";
$res = mysqli_query($con, $sql);
$seg = mysqli_fetch_assoc($res);

if (!$seg) {
    die("❌ Seguimiento no encontrado");
}

$id_proceso_actual = $seg["id_proceso_actual"];

/*
 2️⃣ SABER SI ES P1 (REGISTRO)
*/
$sql = "SELECT codigo FROM proceso WHERE id_proceso = $id_proceso_actual";
$res = mysqli_query($con, $sql);
$proc = mysqli_fetch_assoc($res);

if ($proc && $proc["codigo"] === "P1") {

    // DATOS PERSONALES
    $ci = $_POST["ci"];
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $sexo = $_POST["sexo"];

    // DATOS CLÍNICOS
    $fiebre = isset($_POST["fiebre"]) ? 1 : 0;
    $alergias = isset($_POST["alergias"]) ? 1 : 0;
    $inmunodeficiencia = isset($_POST["inmunodeficiencia"]) ? 1 : 0;
    $embarazo = isset($_POST["embarazo"]) ? 1 : 0;

    // PACIENTE
    mysqli_query($con,
        "INSERT INTO paciente (ci, nombre, edad, sexo)
         VALUES ('$ci', '$nombre', $edad, '$sexo')
         ON DUPLICATE KEY UPDATE
         nombre='$nombre', edad=$edad, sexo='$sexo'"
    );

    // REGISTRO CLÍNICO
    mysqli_query($con,
        "INSERT INTO registro_clinico
         (id_seguimiento, fiebre, alergias, inmunodeficiencia, embarazo)
         VALUES
         ($id_seguimiento, $fiebre, $alergias, $inmunodeficiencia, $embarazo)
         ON DUPLICATE KEY UPDATE
         fiebre=$fiebre,
         alergias=$alergias,
         inmunodeficiencia=$inmunodeficiencia,
         embarazo=$embarazo"
    );

    // ASOCIAR PACIENTE AL SEGUIMIENTO
    mysqli_query($con,
        "UPDATE seguimiento
         SET ci_paciente='$ci'
         WHERE id_seguimiento=$id_seguimiento"
    );
}

/*
 3️⃣ BUSCAR TRANSICIÓN
*/
$trans = null;

// 1️⃣ Intentar con condición enviada
if (!empty($condicion)) {
    $sql = "SELECT proceso_destino
            FROM transicion
            WHERE proceso_origen = $id_proceso_actual
            AND condicion = '$condicion'";
    $res = mysqli_query($con, $sql);
    $trans = mysqli_fetch_assoc($res);
}

// 2️⃣ Si no existe → usar transición 'siempre'
if (!$trans) {
    $sql = "SELECT proceso_destino
            FROM transicion
            WHERE proceso_origen = $id_proceso_actual
            AND condicion = 'siempre'";
    $res = mysqli_query($con, $sql);
    $trans = mysqli_fetch_assoc($res);
}

// 3️⃣ Validación final
if (!$trans) {
    die("❌ No existe transición válida para este proceso.");
}

$id_proceso_siguiente = $trans["proceso_destino"];


/*
 4️⃣ ACTUALIZAR SEGUIMIENTO
*/
mysqli_query($con,
    "UPDATE seguimiento
     SET id_proceso_actual = $id_proceso_siguiente
     WHERE id_seguimiento = $id_seguimiento"
);

/*
    4.1️⃣ REGISTRAR VACUNACIÓN SI ES P5
*/
if ($proc["codigo"] === "P6") {
    mysqli_query($con,
        "INSERT INTO vacunacion_srp
         (ci_paciente, fecha_aplicacion, dosis, tipo_vacuna)
         VALUES
         (
            (SELECT ci_paciente FROM seguimiento WHERE id_seguimiento=$id_seguimiento),
            '{$_POST["fecha"]}',
            {$_POST["dosis"]},
            'SRP'
         )"
    );
}


/*
 5️⃣ REDIRECCIÓN
*/
header("Location: motor.php?id_seguimiento=$id_seguimiento");
exit;
