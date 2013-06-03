<script>
    var subestaciones = '<?php echo count($subest); ?>';
    var neighborhoods = [
    <?php 
    $contSubEst = count($subest);
    $cont = 1;
    foreach ($subest as $subest_item): 
        if($cont<$contSubEst){
    ?>
        new google.maps.LatLng(<?php echo $subest_item['idSubestacion'] ?>, <?php echo $subest_item['idSubestacion'] ?>),    
    <?php 
        }else{
    ?>
        new google.maps.LatLng(<?php echo $subest_item['idSubestacion'] ?>, <?php echo $subest_item['idSubestacion'] ?>)
    <?php
        }
    endforeach 
    ?>
    ];
    setTimeout(drop(), 1000);
</script>
<select>
  <?php foreach ($subest as $subest_item): ?>
  <option value="<?php echo $subest_item['idSubestacion'] ?>"><?php echo $subest_item['localizacion'] ?></option>
  <?php endforeach ?>
</select>