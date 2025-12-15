<h3>📝 Registro del Paciente</h3>

<form action="procesar.php" method="POST">
    <input type="hidden" name="id_seguimiento" value="<?= $id_seguimiento ?>">
    <input type="hidden" name="condicion" value="siempre">

    <fieldset>
        <legend><b>Datos personales</b></legend>

        <label>CI:</label><br>
        <input type="text" name="ci" required><br><br>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Edad:</label><br>
        <input type="number" name="edad" min="0" required><br><br>

        <label>Sexo:</label><br>
        <select name="sexo" id="sexo" required>
            <option value="">Seleccione</option>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select>
    </fieldset>

    <br>

    <fieldset>
        <legend><b>Condiciones clínicas actuales</b></legend>

        <label>
            <input type="checkbox" name="fiebre">
            Fiebre
        </label><br>

        <label>
            <input type="checkbox" name="alergias">
            Alergias
        </label><br>

        <label>
            <input type="checkbox" name="inmunodeficiencia">
            Inmunodeficiencia
        </label><br>

        <label>
            <input type="checkbox" name="embarazo" id="embarazo">
            Embarazo
        </label>
    </fieldset>

    <br>
    <button type="submit">💾 Guardar y continuar</button>
</form>

<script>
document.getElementById("sexo").addEventListener("change", function () {
    const embarazo = document.getElementById("embarazo");

    if (this.value === "M") {
        embarazo.checked = false;
        embarazo.disabled = true;
    } else {
        embarazo.disabled = false;
    }
});
</script>
