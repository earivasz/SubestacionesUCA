<script src="https://maps.googleapis.com/maps/api/js?v=3.13&sensor=false"></script>
<script src="<?=base_url()?>js/maps2.js"></script>
<script>
    var neighborhoods = [
    <?php 
    $contSubEst = count($subest);
    $cont = 1;
    foreach ($subest as $subest_item): 
        if($cont<$contSubEst){
    ?>
        new google.maps.LatLng(<?php echo $subest_item['coordX'] ?>, <?php echo $subest_item['coordY'] ?>),    
    <?php 
        }else{
    ?>
        new google.maps.LatLng(<?php echo $subest_item['coordX'] ?>, <?php echo $subest_item['coordY'] ?>)
    <?php
        }
    endforeach;
        
        foreach ($subest as $subest_item) :
                $cX = $subest_item['coordX'];
                $cY = $subest_item['coordY'];
                $numSub = $subest_item['numSubestacion'];
                $localizacion = $subest_item['localizacion'];
                $capacidad = $subest_item['capacidad'];
                $conexion = $subest_item['conexion'];
                $activo = $subest_item['activo'];
            endforeach;  

            
    ?>
    ];
    setTimeout(drop_modificar(), 1000);
    
</script>

<h2>Modificar Subestacion</h2>
<div id="map-canvas" class="map-create"></div>
<?php echo validation_errors(); ?>
<?php $hidden=array('idSub' => $idSub);?>
<?php echo form_open('subestaciones/mod_sub','',$hidden) ?>

        <?php echo "activo " . $subest_item['activo']; ?><br>

	<label for="coordX">X</label> 
	<input type="input" name="coordX" id="coordX" value="<?php echo $cX; ?>" /><br />

	<label for="coordY">Y</label>
	<input type="input" name="coordY" id="coordY" value="<?php echo $cY; ?>"/><br />
	
        <label for="numSub">Numero Subestacion</label>
	<input type="input" name="numSub" value="<?php echo $numSub; ?>" /><br />
        
        <label for="localizacion">Localizacion</label>
	<input type="input" name="localizacion" value="<?php echo $localizacion; ?>" /><br />
        
        <label for="capacidad">Capacidad</label>
	<input type="input" name="capacidad" value="<?php echo $capacidad; ?>" /><br />
        
        <label for="conexion">Conexion</label>
	<input type="input" name="conexion" value="<?php echo $conexion; ?>" /><br />
        
        <input type="radio" name="activo" value="1" <?php echo ($activo == 1 ? "checked" : ""); ?> />Activa<br />
        <input type="radio" name="activo" value="0" <?php echo ($activo == 0 ? "checked" : ""); ?> />Inactiva
        
        <br />
	<input type="submit" name="submit" value="Modificar subestacion" /> 

</form>
