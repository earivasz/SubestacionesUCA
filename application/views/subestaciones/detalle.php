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
<h2>Detalle Subestacion</h2>
<div id="map-canvas" class="map-create"></div>

    
    
            
            <?php echo $numSub ?>
        <br>
            <?php echo $localizacion ?>
        <br>
            <?php echo $capacidad ?>
        <br>
            <?php echo $conexion ?>
        <br>
        
        <br>
        <?php
            foreach($transformadores as $trans):
                echo '<div class ="transformador">';
                echo 'Numero de serie: ' . $trans['noSerie'] . '<br>';
                echo $trans['capacidad'] . '<br>';
                echo $trans['fabricante'] . '<br>';
                echo $trans['enfriamiento'] . '<br>';
                echo $trans['impedancia'] . '<br>';
                echo $trans['vPrimaria'] . '<br>';
                echo $trans['vSecundario'] . '<br>';
                echo $trans['rTransformacion'] . '<br>';
                echo $trans['polaridad'] . '<br>';
                echo $trans['aterrizamiento'] . '<br>';
                echo $trans['pararrayos'] . '<br>';
                echo $trans['cuchillas'] . '<br>';
                echo '</div>';
                echo 'olakease';
            endforeach;
        ?>
        
        <div>
            
        </div>
        
        <?php
            foreach($fotos as $foto):
                echo '<div class ="foto">';
                echo '<img src ="' . $foto['url'] . '" /><br>';
                echo '</div>';
            endforeach;
        ?>
        
        <br><br>
            

        
