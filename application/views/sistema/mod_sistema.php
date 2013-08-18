<script>
    window.onload = function(){
        <?php
        $msj = $this->session->flashdata('msj');
        if ($msj) {
            ?>
                    showMsg('modal_msj', 'aceptar', '<?php echo $msj; ?>');
            <?php
        }
        ?>
    };
    
    function valida() {
        var fp = $('#multafp').val();
        var thdi = $('#multathdi').val();
        var msj = '';
        if (fp === '' || thdi === '') {
            msj = 'Los campos de Limite de multa son obligatorios';
        }
        else{
            if(isNumber(fp) && isNumber(thdi)){
                showMsg('modal_msj', 'loading', 'Enviando datos');
                $("#guardard").submit();
                return true;
            }
            else{
                msj = 'Los campos de Limite de multa deben ser numéricos';
            }
        }
        if (msj !== '') {
            showMsg('modal_msj', 'aceptar', msj);
            return false;
        }
    }
</script>

<?php echo form_open('sistema/mod_sistema_action','id=subForm', array('origenCorrecto' => true)); ?>
<div style ='float:left; width: 30%; margin-left:10%'>
    <h4>Selecciones subestaciones visibles a INVITADOS:</h4>
    <?php 
        foreach($subest as $sub){
            echo '<input type="checkbox" name="sub' . $sub['idSubestacion'] . '" value="' . $sub['idSubestacion'] .'" ' . (($sub['idPerfil'] == '3') ? 'checked="true"' : '') . '>' . $sub['numSubestacion'] . ', ' . $sub['localizacion'] . '<br>';
        }
    ?>
</div>
<div style ='float:left; width: 30%; margin-left:10%'>
    <h4>Valores globales de sistema:</h4>
    <?php 
        foreach($vals_sistema as $vals){
            if($vals['nomValor'] == 'multafp' || $vals['nomValor'] == 'multathdi'){
                echo '
                    <label for="' . $vals['nomValor'] . '">' . $vals['nombreExt'] . ': </label><br>
                    <input type="input" id="' . $vals['nomValor'] . '" name="' . $vals['nomValor'] . '" value="' . $vals['valor'] . '"><br>';
            }
        }
    ?>
</div>
<div style ='width: 100%; text-align: center;'>
    <?php echo validation_errors(); ?>
    <input id="guardard" type="submit" style="clear:both; display:block; width:250px; margin-left:325px; margin-top:25px;" value="Guardar valores"  onclick="javascript:valida();"/>
    <?php echo form_close(); ?>
</div>
