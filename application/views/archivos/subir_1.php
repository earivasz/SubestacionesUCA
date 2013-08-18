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
 <hr  align="left"><h2 align="center">ARMÓNICOS</h2>
 
<?php echo validation_errors(); ?>
 <?php $hidden = array('subest' => $subest, 'tipo' => $tipo, 'origenCorrecto' => true); ?>
<br>
<br>
<?php echo form_open_multipart('archivos/subir_cargas','id="archivo"',$hidden) ?>

<table>
    <tr><td align="left">
<label for="file">Seleccionar archivo:</label>
     </td><td>
<input type="file" name="file"><br />
    </td></tr><tr><td>
<br>
    <tr><td align="left">
<label for="fase">Fase:</label>
    </td><td>
<select name="fase">
    <option value="">Seleccione una fase</option>
    <option value="1">Fase A</option>
    <option value="2">Fase B</option>
    <option value="3">Fase C</option>
</select>
     </td></tr><tr><td>
<br />
    <tr><td align="left">
<label for="notas">Notas:</label>
    </td><td>
<textarea name="notas"></textarea><br />
<br/>
    
<input type="submit" id="submitArch" name="submit" value="Subir Cargas" />
    

</table>
</div>