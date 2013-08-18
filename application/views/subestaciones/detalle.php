<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?=base_url()?>js/maps2.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqFancyTransitions.1.8.min.js"></script>
<script>
     $(document).ready( function(){
         $('#slideshowHolder').jqFancyTransitions({ width: 300, height: 200, navigation: true });
         //$("#cssmenu .active").removeClass(".active");
         //$('#cssmenu ul li[id=cssmenu1]')("refresh");
         //$('#cssmenu ul li[id=cssmenu2]').addClass("active");
         $('#cssmenu ul li[id=cssmenu2] ul').append('<li><a href="<?php echo base_url() . 'index.php/subestaciones/galeria/' . $subestId ?>"><span>Galeria</span></a></li>');
         //cargas tipo = 1
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subestId . '/1' ?>"><span>Cargas de subestacion</span></a></li>');
         //principal tipo = 4
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subestId . '/4' ?>"><span>Tabla principal</span></a></li>');
         //voltaje tipo = 3
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subestId . '/3' ?>"><span>Tabla armonicas (Voltaje)</span></a></li>');
         //corriente tipo = 2
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $subestId . '/2' ?>"><span>Tabla armonicas (Corriente)</span></a></li>');
});
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
                //$cX = $subest_item['coordX'];
                //$cY = $subest_item['coordY'];
                $numSub = $subest_item['numSubestacion'];
                $localizacion = $subest_item['localizacion'];
                $capacidad = $subest_item['capacidad'];
                $conexion = $subest_item['conexion'];
                //$activo = $subest_item['activo'];
            endforeach;  

            
    ?>
    ];
    setTimeout(drop_modificar(), 1000);
    
</script>
<h2 align="center">DETALLE SUBESTACIÓN</h2>
<div id="map-canvas" class="map-create"></div>
<br>
<h2 class="subtitles" align="center">INFORMACIÓN GENERAL</h2>
       <div style="width:100%; height:230px;">
           <div style="float:left; width:300px; margin-left:20px;">
               <?php 
                echo "";
                echo  'Número de subestación:<b> '. $numSub . "</b><br>";
                echo 'Localización de la subestación:<b> ' . $localizacion . "</b><br>";
                echo 'Capacidad de la subestación:<b> '. $capacidad . "</b><br>";
                echo 'Conexión de la subestación:<b> '. $conexion . "</b><br>";   
                echo "</b>";
            ?>
           </div>
           <div style="float:left; width: 350px;">
               <div id='slideshowHolder'>
               <?php
                    foreach($fotos as $foto):
                        echo '<img src ="' . $foto['url'] . '" />';
                    endforeach;
                ?>
               </div>
           </div>
           <div style="float:left; width:200px;">
               <button class="botDetalle" TYPE = "Button" Name = "Submit1" onClick="location.href='<?=base_url()?>index.php/subestaciones/graficos/<?=$subestId?>/pri'">Tabla Principal</button><br>
               <?php 
                if($this->session->userdata('perfil') != '3'){
                    echo '
                    <button class="botDetalle" TYPE = "Button" Name = "Submit1" onClick="location.href=\'' . base_url() . 'index.php/subestaciones/graficos/' . $subestId . '/armi\'">Armónicos de Corriente</button><br>
                    <button class="botDetalle" TYPE = "Button" Name = "Submit1" onClick="location.href=\'' . base_url() . 'index.php/subestaciones/graficos/' . $subestId . '/armv\'">Armónicos de Voltaje</button><br>
                    <button class="botDetalle" TYPE = "Button" Name = "Submit1" onClick="location.href=\'' . base_url() . 'index.php/subestaciones/cargas/' . $subestId . '\'">Cargas de subestacion</button><br>';
                }
                if($this->session->userdata('perfil') == '1'){
                    echo '
                    <button class="botDetalle" TYPE = "Button" Name = "Submit1" onClick="location.href=\'' . base_url() . 'index.php/subestaciones/galeria/' . $subestId . '\'">Galeria de imagenes</button><br>';
                    }
                ?>
               
               
           </div>
           
       
            
       </div>
 <h2 align="center">TRANSFORMADORES</h2> 
      <div class="tablas"> 
      
      <table  class="hor-minimalist-b" style="float:left; width:200px; margin-left:50px; margin-right: 0px; margin-top: 0px;" >
          <tr><th>Nº de Transformador:</th></tr>
          <tr><td>N° de serie:</td></tr>
          <tr><td>Capacidad [KVA]:</td></tr>
          <tr><td>Fabricante (marca):</td></tr>
          <tr><td>Tipo de enfriamiento:</td></tr>
          <tr><td>Porcentaje impedancia:</td></tr>
          <tr><td>Voltaje Primario:</td></tr>
          <tr><td>Voltaje Secundario:</td></tr>
          <tr><td>Relación de transformación:</td></tr>
          <tr><td>Polaridad:</td></tr>
          <tr><td>Aterrizamiento:</td></tr>
          <tr><td>Pararrayos:</td></tr>
          <tr><td>Cuchillas</td></tr>
      </table>
      <table class="hor-minimalist-b" style="margin-left:0px;  margin-top: 0px; width:600px;">
           
        <?php
                
        function iif($condition, $true, $false ) {
        return ($condition ? $true : $false);
        }

         $cont2 = 1;
            echo "<tr>";
           foreach($transformadores as $trans):
                    echo "<th>Transformador $cont2 </th>";
                $cont2+=1;
            endforeach; 
            echo "</tr>";
            
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>" . iif(empty($trans['noSerie']),"--",$trans['noSerie']). "</td>";
            endforeach; 
            echo "</tr>";
            
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['capacidad']),"--",$trans['capacidad']). "</td>";
            endforeach;
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['fabricante']),"--",$trans['fabricante']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['enfriamiento']),"--",$trans['enfriamiento']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['impedancia']),"--",$trans['impedancia']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['vPrimaria']),"--",$trans['vPrimaria']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['vSecundario']),"--",$trans['vSecundario']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>". iif(empty($trans['rTrnasformacion']),"--",$trans['rTransformacion']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['polaridad']),"--",$trans['polaridad']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['aterrizamiento']),"--",($trans['aterrizamiento']== '1') ? 'si' : 'no'). "</td>";
            endforeach; 
            echo "</tr>";
        
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['pararrayos']),"--",($trans['pararrayos'] == '1') ? 'si': 'no'). "</td>";
            endforeach; 
            echo "</tr>";
            
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td>".iif(empty($trans['cuchillas']),"--",($trans['cuchillas'] == '1') ? 'si' : 'no'). "</td>";
            endforeach; 
            echo "</tr>";
        
         ?>
        </table>
      </div>



        



        
