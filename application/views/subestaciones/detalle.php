<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?=base_url()?>js/maps2.js"></script>
<script>
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
       <div id="info" class="info">
       <h2 class="subtitles" align="center">INFORMACIÓN GENERAL</h2>
            <?php 
                echo "<b>";
                echo  'Número de subestación: '. $numSub . "<br>";
                echo 'Localización de la subestación: ' . $localizacion . "<br>";
                echo 'Capacidad de la subestación: '. $capacidad . "<br>";
                echo 'Conexión de la subestación: '. $conexion . "<br>";   
                echo "</b>";
            ?>
       </div>
        <br>
        <br>
        <div id="botones" class="botones">
            <center>
        <INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Tabla Principal">
        <INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Armónicos">
        <INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Gráficos">
            </center>
        </div>
        <br>
       
      <div id="tablas" class="tablas"> 
      <hr> <h2 align="center">TRANSFORMADORES</h2> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr align="center">
          <td width="25%">
      <table width=\"15%\"  border=\"1\" cellspacing=\"5\" cellpadding=\"10\" align="right">
      <tr>
          <tr><td>Nº de Transformador:</td></tr>
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
      </tr>
      </table>
      </td>
          <td align="center" width="75%">
      <table width=\"80%\"  border=\"1\" cellspacing=\"5\" cellpadding=\"10\" align="left">  
           
        <?php
                
        function iif($condition, $true, $false ) {
        return ($condition ? $true : $false);
        }

        echo '<div class ="transformador">';
         $cont2 = 1;
            echo "<tr>";
           foreach($transformadores as $trans):
                    echo "<td class=\"detalles\">Transformador $cont2 </td>";
                $cont2+=1;
            endforeach; 
            echo "</tr>";
            
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">" . iif(empty($trans['noSerie']),"&nbsp;",$trans['noSerie']). "</td>";
            endforeach; 
            echo "</tr>";
            
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['capacidad']),"&nbsp;",$trans['capacidad']). "</td>";
            endforeach;
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['fabricante']),"&nbsp;",$trans['fabricante']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['enfriamiento']),"&nbsp;",$trans['enfriamiento']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['impedancia']),"&nbsp;",$trans['impedancia']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['vPrimaria']),"&nbsp;",$trans['vPrimaria']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['vSecundario']),"&nbsp;",$trans['vSecundario']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">". iif(empty($trans['rTrnasformacion']),"&nbsp;",$trans['rTransformacion']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['polaridad']),"&nbsp;",$trans['polaridad']). "</td>";
            endforeach; 
            echo "</tr>";
            
             echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['aterrizamiento']),"&nbsp;",$trans['aterrizamiento']). "</td>";
            endforeach; 
            echo "</tr>";
        
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['pararrayos']),"&nbsp;",$trans['pararrayos']). "</td>";
            endforeach; 
            echo "</tr>";
            
            echo "<tr>";
           foreach($transformadores as $trans):
                echo "<td class=\"detalles\">".iif(empty($trans['cuchillas']),"&nbsp;",$trans['cuchillas']). "</td>";
            endforeach; 
            echo "</tr>";
        echo '</div>';
        
         ?>
        </table>
        </div>
         </td></tr></table>
        <br>
    
        <div id="imagenes" class="tablas">
        <hr  align="left"> <h2 align="center">GALERÍA DE FOTOS</h2>       
        <?php
            foreach($fotos as $foto):
                echo '<div class ="foto">';
                echo '<img src ="' . $foto['url'] . '" /><br>';
                echo '</div>';
            endforeach;
        ?>
        </div>
        
        <br><br>

        



        
