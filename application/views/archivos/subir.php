<?php echo validation_errors(); ?>
<?php $hidden = array('subest' => $subest, 'tipo' => $tipo);?>
<?php echo form_open_multipart('archivos/subir_cargas','',$hidden) ?>
<label for="file">Seleccionar archivo</label>
<input type="file" name="file"><br />

<label for="notas">Notas</label>
<textarea name="notas"></textarea><br />

<input type="submit" name="submit" value="Subir Cargas" />