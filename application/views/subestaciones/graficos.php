<script>
    
    var chart;
    <?php
    
    //los datos entrarian linea por linea (cada linea es un conjunto de datos separados por comas)
    //hay que separarlos e ingresarlos en un arreglo para manipularlos localmente
    //la generacion de columnas en el grid debe ser dinamica, asi como la generaciond e puntos en la grafica,
    //el tipo de grafica dependera del valor que venga como parametro en la llamda de la pagina.
    
    //SIMULANDO DATOS:
    $simulacion = "4/22/2013 11:31,75.55185,0.451633,2.369664,0.261574,8.541767,0.121345,4.581907,0.113815,1.671975,0.09726,2.875276,0.089291,0.538053,0.073813,0.483467,0.0703,0.760839,0.076046,0.487163,0.082853,0.260822,0.076809,0.311854,0.238721,0.420766,0.130676,0.199594,0.270461,0.177867,0.079403,0.312972,0.07109,0.130364,0.069402,0.195517,0.076076,0.242641,0.076742,0.127689,0.085107";
    $datos_simulados = array();
    for($yy=0;$yy<1050;$yy++){
        array_push($datos_simulados, explode(",", $simulacion));
    }
    $datos_simulados_json = json_encode($datos_simulados);
    //el siguiente numero va a ser dinamico, por el momento es de prueba y estatico
    $numColumnas = 40;
    //esta variable tambien sera dinamica, dependiendo del tipo de tabla que este viendo seran los headers
    $headers = "fecha  hora,fundamental,2 armonico,3 armonico,4 armonico,5 armonico,6 armonico,7 armonico,8 armonico,9 armonico,10 armonico,11 armonico,12 armonico,13 armonico,14 armonico,15 armonico,16 armonico,17 armonico,18 armonico,19 armonico,20 armonico,21 armonico,22 armonico,23 armonico,24 armonico,25 armonico,26 armonico,27 armonico,28 armonico,29 armonico,30 armonico,31 armonico,32 armonico,33 armonico,34 armonico,35 armonico,36 armonico,37 armonico,38 armonico,39 armonico,40 armonico";
    
    //probando el control de grid
    $datos = array('label: "primero", y: 18', 'label: "orange", y: 29', 'label: "apple", y: 40', 
            'label: "mango", y: 34', 'label: "grape", y: 24');
        $linea = array("51968.25","154878.21","4578.25");
        $datos_reales = array();
        for($kk=0;$kk<10;$kk++){
            array_push($datos_reales, $linea);
        }
        $datos_reales_json = json_encode($datos_reales);
    ?>
  window.onload = function () {
    
    //**********************CARGANDO EL GRAFICO
        chart = new CanvasJS.Chart("chartContainer", {
        
        zoomEnabled: true,
      title:{
        text: "Pruebas"              
      },
      axisX:{
        labelAngle: 30,
      },
      data: [//array of dataSeries              
        { //dataSeries object

         /*** Change type "column" to "bar", "area", "line" or "pie"***/
         type: "line",
//         dataPoints: [
//         { label: "banana", y: 18 },
//         { label: "orange", y: 29 },
//         { label: "apple", y: 40 },                                    
//         { label: "mango", y: 34 },
//         { label: "grape", y: 24 }
//         ]
            dataPoints: 
            <?php
            $top = count($datos);
            $cont = 1;
            echo '[';
            foreach ($datos as $itemGraf) {
                if($cont < $top)
                    echo '{' . $itemGraf . '},';
                else
                    echo '{' . $itemGraf . '}';
                $cont++;
            }
            echo ']';
            ?>
       }
       ]
     });
     

    chart.render();
    //******************FIN CARGA DE GRAFICO
    
    
    //******************CARGA DE TABLA
    myGrid = new dhtmlXGridObject("gridContainer");
    myGrid.setImagePath("<?=base_url()?>img/imgs_xgrid/");
    myGrid.enableResizing("false");
    myGrid.setHeader(<?php echo $headers; ?>);
    //myGrid.setInitWidths("*,150,150");
    myGrid.setInitWidths(
        <?php
        $widths = "120,";
        for($ww=1;$ww<$numColumnas;$ww++){
            $widths = $widths . "70,";
        }
        $widths = $widths . "70";
        echo $widths;
        ?>
        );
    
    //myGrid.setColAlign("left,right,right");
    myGrid.init();
    myGrid.setSkin("dhx_skyblue");
    myGrid.load(<?php echo $datos_simulados_json; ?>, "jsarray");
    myGrid.parse(<?php echo $datos_simulados_json; ?>, "jsarray");
    //******************FIN CARGA DE TABLA
//    alert("hola que aseee");
    
  };
  
  
  
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
<div id="chartContainer" style="height: 300px; width: 100%;">
  </div>
<div id="gridContainer" style="height: 600px; width: 100%;">ola ke ase</div>
<button onClick="recargar();" name="pressme">Press Me</button>

<?php
//    foreach ($datos as $value) {
//     echo $value;
//    }
    
    //echo '<br>' . json_encode($datos) ;
    echo '<br>';
    //echo $datos_reales_json;
    echo $datos_simulados_json;
    echo "<br>";
    echo $widths;
    
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