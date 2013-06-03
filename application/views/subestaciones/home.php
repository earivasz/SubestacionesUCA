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
    endforeach 
    ?>
    ];
    setTimeout(drop(), 1000);
</script>
<div id="contenido">
    <div id="map-canvas"></div>
    <div id="overlay-mapa">
        <select>
            <?php foreach ($subest as $subest_item): ?>
            <option value="<?php echo $subest_item['idSubestacion'] ?>"><?php echo $subest_item['localizacion'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>