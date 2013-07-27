<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxgrid.columnsresize.js"></script> 
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxdata.js"></script> 
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxcheckbox.js"></script> 
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxlistbox.js"></script> 
    <script type="text/javascript" src="<?=base_url()?>jqwidgets/gettheme.js"></script>

<script>
    
    var chart;
    var arreglo_completo = new Array();
    var arreglo_pag = new Array();
    var myGrid;
  window.onload = function () {
    //******************CARGA DE TABLA
    
   arreglo_completo = <?php echo json_encode($usuarios); ?>;
    //AQUI IBA EL CODIGO DEL GRID ANTERIOR
    
    var theme = getDemoTheme();
            
            var source =
            {
                localdata: arreglo_completo,
                datatype: "array"
            };
            var dataAdapter = new $.jqx.dataAdapter(source, {
                downloadComplete: function (data, status, xhr) { },
                loadComplete: function (data) { },
                loadError: function (xhr, status, error) { }
            });
            $("#jqxgrid").jqxGrid(
            {
                width: 900,
                source: dataAdapter,
                columns: [
                  { text: 'First Name', datafield: 'usuario', width: 100 },
                  { text: 'Last Name', datafield: 'nomUser', width: 100 },
                  { text: 'Product', datafield: 'apel', width: 180 },
                  { text: 'Quantity', datafield: 'correo', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: 'estado', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'Total', datafield: 'ultimoIngreso', width: 100, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: 'idPerfil', width: 100 }
                ]
            });
            
            var listSource = [{ label: 'Name', value: 'name', checked: false }, { label: 'Beverage Type', value: 'type', checked: true }, { label: 'Calories', value: 'calories', checked: true }, { label: 'Total Fat', value: 'totalfat', checked: true }, { label: 'Protein', value: 'protein', checked: true}];

            $("#jqxlistbox").jqxListBox({ source: listSource, width: 200, height: 200, theme: theme, checkboxes: true });
            $("#jqxlistbox").on('checkChange', function (event) {
                if (event.args.checked) {
                    $("#jqxgrid").jqxGrid('showcolumn', event.args.value);
                }
                else {
                    $("#jqxgrid").jqxGrid('hidecolumn', event.args.value);
                }
            });
    
    
    
  };
  
//  var paginacion =function(indice){
//      console.log(indice);
//      myGrid.load(arreglo_pag[indice], "jsarray");
//      myGrid.parse(arreglo_pag[indice], "jsarray");
//      console.log(arreglo_pag[indice]);
////    var myHonda = { color: "red", wheels: 4, engine: { cylinders: 4, size: 2.2 } };
////    var myCar = [myHonda, 2, "cherry condition", "purchased 1997"];
////    var newCar = myCar.slice(0, 2);
////    //console.log(newCar);

//  }
  
  var recargar =function(){
  //alert("hola que aseee");
            
                chart.options.data[0].dataPoints = <?php
                $datos2 = array('label: "cambio1", y: 28', 'label: "cambio2", y: 15',);
            $top2 = count($datos2);
            $cont2 = 1;
            echo '[';
            foreach ($datos2 as $itemGraf) {
                if($cont2 < $top2)
                    echo '{' . $itemGraf . '},';
                else
                    echo '{' . $itemGraf . '}';
                $cont2++;
            }
            echo ']';
            ?>;
            chart.render();
    
  };
  
  
  </script>
<h2>GRAFICOS</h2>
<div id='jqxWidget'>
        
        <div style="width:100%; height: 600px;" id="jqxgrid"></div>
        <br>
        <div style="" id="jqxlistbox"></div>
    </div>
<br>
<button onClick="recargar();" name="pressme">Press Me</button>

<?php
//    foreach ($datos as $value) {
//     echo $value;
//    }
    
    //echo '<br>' . json_encode($datos) ;
    echo '<br>';
    //echo $datos_reales_json;
    //echo $datos_simulados_json;
    echo "<br>";
    //echo json_encode($headers);
    echo "<br>";
    //echo json_encode($widths);
    echo "<br>";
    //echo $datos_simulados;
    
//    $top = count($datos);
//    $cont = 1;
//    echo '[';
//    foreach ($datos as $itemGraf) {
//        if($cont < $top)
//            echo '{' . $itemGraf . '},';
//        else
//            echo '{' . $itemGraf . '}';
//        $cont++;
//    }
//    echo ']';
?>