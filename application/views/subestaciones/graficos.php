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
    <script type="text/javascript" src="<?=base_url()?>js/jquery.datePicker.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/date.js"></script>

<script  type="text/javascript" charset="utf-8">
    
    var chart;
    var arreglo_completo = new Array();
    var arreglo_pag = new Array();
    var myGrid;
    var source;
    <?php
    
    //los datos entrarian linea por linea (cada linea es un conjunto de datos separados por comas)
    //hay que separarlos e ingresarlos en un arreglo para manipularlos localmente
    //la generacion de columnas en el grid debe ser dinamica, asi como la generaciond e puntos en la grafica,
    //el tipo de grafica dependera del valor que venga como parametro en la llamda de la pagina.
    
    //SIMULANDO DATOS:
//    $simulacion = "4/22/20131131,75.55185,0.451633,,0.261574,8.541767,0.121345,4.581907,0.113815,1.671975,0.09726,2.875276,0.089291,0.538053,0.073813,0.483467,0.0703,0.760839,0.076046,0.487163,0.082853,0.260822,0.076809,0.311854,0.238721,0.420766,0.130676,0.199594,0.270461,0.177867,0.079403,0.312972,0.07109,0.130364,0.069402,0.195517,0.076076,0.242641,0.076742,0.127689,0.085107";
//    $datos_simulados = array();
//    for($yy=0;$yy<1203;$yy++){
//        array_push($datos_simulados, explode(",", $simulacion));
//    }
    //$datos_simulados_json = json_encode($datos_simulados);
    //$arreglo_paginacion = array();
    //el siguiente numero va a ser dinamico, por el momento es de prueba y estatico
    $numColumnas = 40;
    $numFilas = 1203;
    //esta variable tambien sera dinamica, dependiendo del tipo de tabla que este viendo seran los headers
    //$headers = "fecha hora,fundamental,2 armonico,3 armonico,4 armonico,5 armonico,6 armonico,7 armonico,8 armonico,9 armonico,10 armonico,11 armonico,12 armonico,13 armonico,14 armonico,15 armonico,16 armonico,17 armonico,18 armonico,19 armonico,20 armonico,21 armonico";
    $headers = "col1, col2, col3, col4, col5,col1, col2, col3, col4, col5,col1, col2, col3, col4, col5,col1, col2, col3, col4, col5,col1, col2, col3, col4, col5,col1, col2, col3, col4, col5,col1, col2, col3, col4, col5,col1, col2, col3, col4, col40";
    
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
    //arreglo_completo = <?php //echo json_encode($datos_simulados); ?>;
    arreglo_completo = null;
    
    var theme = getDemoTheme();
            
            source =
            {
                localdata: arreglo_completo,
                datatype: "array"
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            $("#jqxgrid").jqxGrid(
            {
                width: 900,
                source: dataAdapter,
                columns: [
                  { text: 'First Name', datafield: '0', width: 100 },
                  { text: 'Last Name', datafield: '1', width: 100 },
                  { text: 'Product', datafield: '2', width: 180 },
                  { text: 'Quantity', datafield: '3', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '4', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'Total', datafield: '5', width: 100, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: '6', width: 100 },
                  { text: 'Last Name', datafield: '7', width: 100 },
                  { text: 'Product', datafield: '8', width: 180 },
                  { text: 'Quantity', datafield: '9', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '10', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: '11', width: 100 },
                  { text: 'Last Name', datafield: '12', width: 100 },
                  { text: 'Product', datafield: '13', width: 180 },
                  { text: 'Quantity', datafield: '14', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '15', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: '16', width: 100 },
                  { text: 'Last Name', datafield: '17', width: 100 },
                  { text: 'Product', datafield: '18', width: 180 },
                  { text: 'Quantity', datafield: '19', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '20', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: '21', width: 100 },
                  { text: 'Last Name', datafield: '22', width: 100 },
                  { text: 'Product', datafield: '23', width: 180 },
                  { text: 'Quantity', datafield: '24', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '25', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: '26', width: 100 },
                  { text: 'Last Name', datafield: '27', width: 100 },
                  { text: 'Product', datafield: '28', width: 180 },
                  { text: 'Quantity', datafield: '29', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '30', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: '31', width: 100 },
                  { text: 'Last Name', datafield: '32', width: 100 },
                  { text: 'Product', datafield: '33', width: 180 },
                  { text: 'Quantity', datafield: '34', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '35', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'First Name', datafield: '36', width: 100 },
                  { text: 'Last Name', datafield: '37', width: 100 },
                  { text: 'Product', datafield: '38', width: 180 },
                  { text: 'Quantity', datafield: '39', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: '40', width: 90, cellsalign: 'right', cellsformat: 'c2' },
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
  
  
  var traerDatos = function(){
      //hacer validaciones de fechas
        var cct = $.cookie('cookieUCA');
        var fechaIni = $('#start-date').val();
        var fechaFin = $('#end-date').val();
        console.log(fechaIni + fechaFin);
     var request = $.ajax({
        url: "<?=base_url()?>index.php/graficos_control/graficosDatos",
        type: "POST",
        data: {'tokenUCA' : cct, 'id' : <?php echo $idSub ?>, 'fechaIni' : fechaIni, 'fechaFin' : fechaFin},
        dataType: "json"
      });
      request.done(function(msg, status, XHR) {
        arreglo_completo = msg;
        source.localdata = arreglo_completo;
        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
        //console.log(msg);
      });
      request.fail(function(XHR, textStatus, response) {
        alert( "Request failed: " + textStatus );
        //console.log(XHR, textStatus, response);
      });

//     }

      
//      alert('<?//=base_url()?>index.php/graficos_control/graficosDatos');
//      $.post('<?//=base_url()?>index.php/graficos_control/graficosDatos',
//      { 'id':'1', 
//        'fechaIni':'20/01/2013', 
//        'fechaFin':'30/09/2013' },
//      // when the Web server responds to the request
//      function(result) {
//          alert('olakease');
//          $('#olakease').html(result);
//      }
//    );
}
//});
  
  
  
  </script>
  
  <script type="text/javascript" charset="utf-8">
			$(function()
            {
				$('.date-pick').datePicker({startDate:'01/01/1996'})
				$('#start-date').bind(
					'dpClosed',
					function(e, selectedDates)
					{
						var d = selectedDates[0];
						if (d) {
							d = new Date(d);
							$('#end-date').dpSetStartDate(d.addDays(1).asString());
						}
					}
				);
				$('#end-date').bind(
					'dpClosed',
					function(e, selectedDates)
					{
						var d = selectedDates[0];
						if (d) {
							d = new Date(d);
							$('#start-date').dpSetEndDate(d.addDays(-1).asString());
						}
					}
				);
            });
		</script>

 <h2 style="margin: 5px 5px 0px 20px;">GRAFICOS</h2>
<div style="margin-left: 300px;">
    <div style="float:left;">Fecha de inicio<br>
    <input name="start-date" id="start-date" class="date-pick" value="fecha de inicio" /></div>
    <div>Fecha de finalizacion<br>
    <input name="end-date" id="end-date" class="date-pick" value="ola ke ase" /></div>
    Fase:
    <?php if ($tipo == 'arm'){
        echo '<input type="checkbox" name="fase1">1
            <input type="checkbox" name="fase2">2
            <input type="checkbox" name="fase3">3';
    }
    if ($tipo == 'pri'){
        echo '<input type="radio" name="fase" value="1">1
            <input type="radio" name="fase" value="2">2
            <input type="radio" name="fase" value="3">3';
    }
    ?>
<button onClick="traerDatos();" name="pressmeDatos">Cargar Datos</button>
</div>
 
<div id="chartContainer" style="height: 300px; width: 100%;">
  </div>
<div id='jqxWidget'>
        
        <div style="width:100%; height: 600px;" id="jqxgrid"></div>
        <br>
        <div style="" id="jqxlistbox"></div>
    </div>
<br>
<button onClick="recargar();" name="pressme">Press Me</button>

<?php

?>