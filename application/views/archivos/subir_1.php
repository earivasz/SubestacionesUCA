<script type="text/javascript">
    $(document).ready( function(){
         $('#cssmenu ul li[id=cssmenu2] ul').append('<li><a href="<?php echo base_url() . 'index.php/subestaciones/galeria/' . $subest ?>"><span>Galeria</span></a></li>');
         //cargas tipo = 1
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subest . '/1' ?>"><span>Cargas de subestacion</span></a></li>');
         //principal tipo = 4
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subest . '/4' ?>"><span>Tabla principal</span></a></li>');
         //voltaje tipo = 3
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subest . '/3' ?>"><span>Tabla armonicas (Voltaje)</span></a></li>');
         //corriente tipo = 2
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subest . '/2' ?>"><span>Tabla armonicas (Corriente)</span></a></li>');
});
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
<div class="menu_navegacion_subs">
      <a href="<?=base_url()?>index.php/subestaciones">Subestaciones</a>
      <span class="menu_navegacion_subs_sep">/</span>
      <a href="<?=base_url()?>index.php/subestaciones/detalle/<?php echo $subest ?>">Subestacion <?php echo $subestacion[0]['numSubestacion'] . ', ' . $subestacion[0]['localizacion'] ?></a>
      <span class="menu_navegacion_subs_sep">/</span>
      <?php if($tipo == '2'){
          echo 'Subir archivo de Armonicas de Corriente';
      }
      else{
          echo 'Subir archivo de Armonicas de Voltaje';
      }
      ?>
  </div>
<div align="center">
 <hr  align="left"><h2 align="center"><?php if($tipo == '2'){
          echo 'ARMONICAS DE CORRIENTE, ' . 'SUBESTACION ' . $subestacion[0]['numSubestacion'] . ', ' . $subestacion[0]['localizacion'];
      }
      else{
          echo 'ARMONICAS DE VOLTAJE, ' . 'SUBESTACION ' . $subestacion[0]['numSubestacion'] . ', ' . $subestacion[0]['localizacion'];
      }
      ?></h2>
 
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
    
<input type="submit" id="submitArch" name="submit" value="Subir Archivo" />
    

</table>
</div>