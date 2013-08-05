<script type="text/javascript">
    window.onload = function() {
<?php
$msj = $this->session->flashdata('msj');
if ($msj) {
    ?>
            showMsg('modal_msj', 'aceptar', '<?php echo $msj; ?>');
    <?php
}
?>
        $("#archivo").submit(function(e) {
            var self = this;
            //e.preventDefault();
            $('#submitArch').attr('disabled', 'disabled');
            showMsg('modal_msj', 'loading', 'Un momento mientras el archivo esta siendo cargado')
            //self.submit();
            return true; //is superfluous, but I put it here as a fallback
        });

        //MUESTRO MENSAJE SI HA SIDO SETEADO UN FLASHDATA


    };
</script>
<div align="center">
 <hr  align="left"><h2 align="center">ARCHIVO PRINCIPAL Y CARGAS</h2>
 
<?php echo validation_errors(); ?>
<?php $hidden = array('subest' => $subest, 'tipo' => $tipo); ?>
<?php echo form_open_multipart('archivos/subir_cargas', 'id="archivo"', $hidden) ?>
 
<table>
    <tr><td align="left">
<label for="file">Seleccionar archivo:</label>
    </td><td>
<input align="center" type="file" name="file"><br />
    </td></tr><tr><td>
<br>
    <tr><td align="left">
<label for="notas">Notas:</label>
 </td><td>
<textarea align="center" name="notas"></textarea><br />
<br>  
<input align="center" type="submit" name="submit_me" id="submitArch" value="Subir Cargas" />
    
<?php echo form_close(); ?>
    
 </table>
</div>

