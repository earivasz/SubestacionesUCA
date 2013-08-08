<script type="text/javascript" src="<?=base_url()?>js/jquery.MultiFile.js"></script>

<script>
$(document).ready(function() {
            $('img').click(function(){
                $(this).toggleClass('selected');
            });
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
                  data: {'tokenUCA' : cct, 'idSub' : <?php echo $idSubest ?>, 'arrFotos' : imagenesId},
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
</script>

<div style="width: 100%; text-align:center;">
    <h2 style="margin: 5px 5px 20px 20px;">GALERIA SUBESTACION <?php echo $subest[0]['numSubestacion'] . ', ' . $subest[0]['localizacion'];?></h2>
</div>

<style>
    .galeria .divsmain{
        margin-left:15px;
        margin-bottom: 15px;
        text-align: center;
    }
    
    .galeria .divsmain img{
        width:auto;
        height:125px;
        padding: 2px;
        margin: 10px;
        float: left;
        background-color: #333333;
    }
    
    .galeria .divsmain img.selected {
            background-color: #E13300;
        }
        
    .galeria .divsmain img:hover {
            background-color: #2B9CFF;
        }
    

</style>

<div style="width:100%; height:auto;" class="galeria">
    <div style="float:left; width: 45%" class="divsmain">ola</div>
    <div style="float:left; width: 45%" class="divsmain">
        <h3>Fotos de Subestacion</h3>
        <?php
        foreach ($fotos as $foto) :
            echo '<img id="' . $foto['correlFoto'] . '" src="' . $foto['url'] . '" />';
            endforeach;
        ?>
        <button style="clear:both; display:block; width:250px; height:30px; margin-left:80px;" type="button" onClick="borraImagenes()">Borrar imagenes seleccionadas</button>
    </div>
    
</div>