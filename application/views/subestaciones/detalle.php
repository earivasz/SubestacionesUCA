<div id="contenido">
    
    <div id="overlay-mapa">
            <?php foreach ($subest as $subest_item): ?>
            <?php echo $subest_item['idSubestacion'] ?>
        <br>
            <?php echo $subest_item['localizacion'] ?>
        <br><br>
            <?php endforeach ?>
    </div>
</div>
