<script type="text/javascript">
function enviar_archivo(){
    showMsg('modal_msj','loading','Su peticion esta siendo procesada.');
    $.ajax({
        type:post,
        url: base_url + 'archivos/prueba',
        cache: false,
        data: $('#archivo').serialize(),
        success: function(){
            close_modal();
            alert('yay!');
        }
    });
}

$(document).ready(function(){
    $('#archivo').ajaxForm({
        beforeSend: function() {
            showMsg('modal_msj','loading','Su peticion esta siendo procesada.'); 
        },
        complete: function(data) {
            console.log(data);
            close_modal();
        }
    }); 
});
</script>

<?php echo validation_errors(); ?>
<?php
    $tiempo='22-4-13 12:01 AM';
    
    $time = explode(' ', $tiempo);
    $fecha = explode('-',$time[0]);
    $newFec = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' '.$time[1];
    $newTime = 
    $timeP = date_parse($newFec);
    $timeN = strtotime($newFec);
    $dateN = mktime($timeP['hour'],$timeP['minute'],$timeP['second'],$timeP['month'],$timeP['day'],$timeP['year']);
    $timeF = date('H:m:s', strtotime($time[1]));
    echo $newFec . ' : '.$timeF;
    //print_r($timeP)
    //echo date('Y-m-d H:m:s',$newFec);
    ?>
<?php $hidden = array('subest' => $subest, 'tipo' => $tipo);?>
<?php echo form_open_multipart('archivos/subir_cargas','id="archivo"',$hidden) ?>
<label for="file">Seleccionar archivo</label>
<input type="file" name="file"><br />

<label for="notas">Notas</label>
<textarea name="notas"></textarea><br />

<input type="submit" name="submit" value="Subir Cargas" />
<?php echo form_close(); ?>