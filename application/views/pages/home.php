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