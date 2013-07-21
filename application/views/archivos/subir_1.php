<?php echo validation_errors(); ?>
<?php $hidden = array('subest' => $subest, 'tipo' => $tipo);?>
<?php echo form_open_multipart('archivos/subir_cargas','',$hidden) ?>
<label for="file">Seleccionar archivo</label>
<input type="file" name="file"><br />
<label for="fase">Fase</label>
<select name="fase">
    <option value="1">Fase A</option>
    <option value="2">Fase B</option>
    <option value="3">Fase C</option>
</select>
<br />
<label for="notas">Notas</label>
<textarea name="notas"></textarea><br />

<input type="submit" name="submit" value="Subir Cargas" />