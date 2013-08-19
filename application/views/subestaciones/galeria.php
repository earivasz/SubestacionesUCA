<script type="text/javascript" src="<?=base_url()?>js/jquery.MultiFile.js"></script>
<script>
$(document).ready(function() {
            $('img').click(function(){
                $(this).toggleClass('selected');
            });
            
            $('#subirimgs').click(function(){
                showMsg('modal_msj', 'loading', 'Su peticion se esta procesando');
            });
            
            <?php
                $msj = $this->session->flashdata('msj');
                if ($msj) {
                    ?>
                            showMsg('modal_msj', 'aceptar', '<?php echo $msj; ?>');
                    <?php
                }
        ?>
});
        
   var borraImagenes = function(){
       var imagenes = $('.selected');
       if(imagenes.length>0){
       showMsg('modal_msj', 'loading', 'Su peticion se esta procesando');
        //console.log(imagenes);
        var imagenesId = new Array();
        for(i=0;i<imagenes.length;i++){
            imagenesId.push(imagenes[i]['id']);
        }
        console.log(imagenesId);
        var cct = $.cookie('cookieUCA');
        var request = $.ajax({
                  url: "<?=base_url()?>index.php/subestaciones/borrar_fotos",
                  type: "POST",
                  data: {'tokenUCA' : cct, 'idSub' : <?php echo $idSubest ?>, 'arrFotos' : imagenesId, 'origenCorrecto' : true},
                  dataType: "text"
                });
                request.done(function(msg, status, XHR) {
                  close_modal();
                  if(msg = 'exito')
                    window.location.reload()
                  else{
                    showMsg('modal_msj', 'aceptar', 'Ocurrio un error borrando las imagenes, asegurese que su conexion a internet este activa y vuelva a intentarlo');
                  }
                });
                request.fail(function(XHR, textStatus, response) {
                  close_modal();
                  showMsg('modal_msj', 'aceptar', 'Ocurrio un error borrando las imagenes, asegurese que su conexion a internet este activa y vuelva a intentarlo');
                });
         }
         else{
             showMsg('modal_msj', 'aceptar', 'Debe seleccionar por lo menos una imagen');
         }
        }
        
        var resultadoUpload = function(estado, file) {
            var link = '<br /><br /><a href="upload3.php">Subir Archivo</a> - <a href="verArchivos.php">Ver Imagenes</a> - <a href="eliminar.php">Eliminar Archivo</a>';
            if (estado == 0)
            var mensaje = 'El Archivo <a href="archs/' + file + '" target="_blank">' + file + '</a> se ha subido al servidor correctamente' + link;
            if (estado == 1)
            var mensaje = 'Error ! - El Archivo no llego al servdor' + link;
            if (estado == 2)
            var mensaje = 'Error ! - Solo se permiten Archivos tipo Imagen' + link;
            if (estado == 3)
            var mensaje = 'Error ! - No se pudo copiar Archivo. Posible problema de permisos en server' + link;
            document.getElementById('formUpload').innerHTML=mensaje;
         } 
</script>

<style>
    .galeria .divsmain{
        margin-left:15px;
        margin-bottom: 15px;
        text-align: center;
    }
    
    .galeria .divsmain .imagenesSubestCarga img{
        width:auto;
        height:125px;
        padding: 2px;
        margin: 5px;
        float: left;
        background-color: #333333;
    }
    
    .galeria .divsmain .imagenesSubestCarga img.selected {
            background-color: #E13300;
        }
        
    .galeria .divsmain .imagenesSubestCarga img:hover {
            background-color: #2B9CFF;
        }
        
    .galeria .divsmain .removeGif {
            height:16px; 
            width:16px;
            margin: 0px;
            padding:0px;
            border-style: none;
        }
      
    .galeria .divsmain .removeGif:hover {
         margin:0px;
     }
</style>
<div class="menu_navegacion_subs">
      <a href="<?=base_url()?>index.php/subestaciones">Subestaciones</a>
      <span class="menu_navegacion_subs_sep">/</span>
      <a href="<?=base_url()?>index.php/subestaciones/detalle/<?php echo $idSubest ?>">Subestacion <?php echo $subest[0]['numSubestacion'] . ', ' . $subest[0]['localizacion'] ?></a>
      <span class="menu_navegacion_subs_sep">/</span>
      Galeria
  </div>
<div style="width: 100%; text-align:center;">
    <h2 style="margin: 5px 5px 20px 20px;">GALERIA SUBESTACION <?php echo $subest[0]['numSubestacion'] . ', ' . $subest[0]['localizacion'];?></h2>
</div>
<div style="width:100%; height:auto;" class="galeria">
    <div style="float:left; width: 45%" class="divsmain">
        <h3>Subir Imagenes de subestacion</h3>
        <div style="text-align:left; width: 90%; margin-left:10%; font-style: italic;">
            <?php $hidden = array('subest' => $idSubest, 'ultimocorrel' => $ultimocorrel[0]['correlFoto'], 'origenCorrecto' => true); ?>
            <?php echo form_open_multipart('subestaciones/subir_archivo', 'id="imagenes"', $hidden) ?>
            
            <input type="file" id="T8A" accept="jpg|jpeg" name="arrimg[]">
            <script type="text/javascript" language="javascript">
                              $(function(){
                                  //alert('hola');
                               $('#T8A').MultiFile({ 
                                STRING: {
                                 remove: '<img src="<?=base_url()?>img/remove2.gif" class="removeGif" alt="x"/>'
                                }
                               }); 
                              });
                              </script>
             <input id="subirimgs" type="submit" style="clear:both; display:block; width:250px; height:30px; margin-left:80px; margin-top:25px;" value="Subir imagenes seleccionadas" />
             <?php echo form_close(); ?>
        </div>
    </div>
    <div style="float:left; width: 45%" class="divsmain">
        <h3>Imagenes de Subestacion</h3>
        <div class="imagenesSubestCarga">
            <?php
            foreach ($fotos as $foto) :
                echo '<img id="' . $foto['correlFoto'] . '" src="' . $foto['url'] . '" />';
                endforeach;
            ?>
        </div>
        <button style="clear:both; display:block; width:250px; height:30px; margin-left:80px;" type="button" onClick="borraImagenes()">Borrar imagenes seleccionadas</button>
    </div>
    
</div>