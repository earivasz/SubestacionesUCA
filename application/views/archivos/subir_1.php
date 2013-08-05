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
<?php echo validation_errors(); ?>
<?php $hidden = array('subest' => $subest, 'tipo' => $tipo);?>
<?php echo form_open_multipart('archivos/subir_cargas','id="archivo"',$hidden) ?>
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

<input type="submit" id="submitArch" name="submit" value="Subir Cargas" />