<h2>Create a news item</h2>
<div id="map-canvas" class="map-create"></div>
<?php echo validation_errors(); ?>

<?php echo form_open('subestaciones/crear') ?>

	<label for="coordX">Title</label> 
	<input type="input" name="coordX" id="coordX"/><br />

	<label for="coordY">Text</label>
	<input type="input" name="coordY" id="coordY"/><br />
	
        <label for="numSub">Text</label>
	<input type="input" name="numSub" /><br />
        
        <label for="localizacion">Text</label>
	<input type="input" name="localizacion" /><br />
        
        <label for="capacidad">Text</label>
	<input type="input" name="capacidad" /><br />
        
        <label for="conexion">Text</label>
	<input type="input" name="conexion" /><br />
        
	<input type="submit" name="submit" value="Crear subestacion" /> 

</form>