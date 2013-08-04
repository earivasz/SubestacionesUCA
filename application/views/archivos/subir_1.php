<?php
    $tiempo ='4/22/13 11:31';
    $time = explode(' ', $tiempo);
    if (strpos($time[0],'-') !== false) {
        $fecha = explode('-',$time[0]);
    }elseif(strpos($time[0],'/') !== false){
        $fecha = explode('/',$time[0]);
    }elseif(strpos($time[0],'.') !== false){
        $fecha = explode('.',$time[0]);
    }
    if(count($time)>2){
        $newFec = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $time[1]. $time[2];
    }else{
        $newFec = $fecha[2].'-'.$fecha[0].'-'.$fecha[1].' '.$time[1];
    }
    $timeN = strtotime($newFec);
    echo $newFec . ' : '.$timeN;
?>

<?php echo validation_errors(); ?>
<?php $hidden = array('subest' => $subest, 'tipo' => $tipo);?>
<?php echo form_open_multipart('archivos/subir_cargas','',$hidden) ?>
<label for="file">Seleccionar archivo</label>
<input type="file" name="file"><br />
<label for="fase">Fase</label>
<select name="fase">
    <option value="">Seleccione una fase</option>
    <option value="1">Fase A</option>
    <option value="2">Fase B</option>
    <option value="3">Fase C</option>
</select>
<br />
<label for="notas">Notas</label>
<textarea name="notas"></textarea><br />

<input type="submit" name="submit" value="Subir Cargas" />