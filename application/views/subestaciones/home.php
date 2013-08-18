<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?=base_url()?>js/maps_principal.js"></script>
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
    <div id="map-canvas" class="map-canvas"></div>
    <div id="overlay-mapa">
        <select onchange="javascript:setSub(this);">
            <option value="#">----Seleccione una subestacion----</option>
            <?php foreach ($subest as $subest_item): ?>
            <option value="<?php echo $subest_item['idSubestacion'] ?>"><?php echo $subest_item['localizacion'] ?></option>
            <?php endforeach ?>
        </select>
        <br/>
        <br>
        <!--<a  id="verSub" href="index.php/subestaciones/detalle/1">Ver subestacion</a>-->
        <a  id="verSub" href="<?php echo base_url("index.php/subestaciones/detalle/#"); ?>">Ver subestacion</a>
    </div>
</div>