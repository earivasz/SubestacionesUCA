<script type="text/javascript" src="<?=base_url()?>js/canvasjs.min.js"></script>
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
    var arreglo_completo;
    var arreglo_headersPri;
    var arreglo_headersArm;
    var arrColumnasGrid;
    var myGrid;
    var source;
    var tipo;

  window.onload = function () {
    tipo = '<?php echo $tipo; ?>';
    arreglo_headersPri = ['Fecha y hora',
        'Voltaje 1 [V]','Corriente 1 [A]','%THD V1','%THD I1','Potencia Aparente 1 [VA]','Potencia Activa 1 [W]','Potencia reactiva 1 [VAR]','Factor de potencia 1',
        'Voltaje 2 [V]','Corriente 2 [A]','%THD V2','%THD I2','Potencia Aparente 2 [VA]','Potencia Activa 2 [W]','Potencia reactiva 2 [VAR]','Factor de potencia 2',
        'Voltaje 3 [V]','Corriente 3 [A]','%THD V3','%THD I3','Potencia Aparente 3 [VA]','Potencia Activa 3 [W]','Potencia reactiva 3 [VAR]','Factor de potencia 3'];
    arreglo_headersArm = ['Fecha y hora','fundamental',
        '2 armonico','3 armonico','4 armonico','5 armonico','6 armonico','7 armonico','8 armonico','9 armonico','10 armonico',
        '11 armonico','12 armonico','13 armonico','14 armonico','15 armonico','16 armonico','17 armonico','18 armonico','19 armonico','20 armonico',
        '21 armonico','22 armonico','23 armonico','24 armonico','25 armonico','26 armonico','27 armonico','28 armonico','29 armonico','30 armonico',
        '31 armonico','32 armonico','33 armonico','34 armonico','35 armonico','36 armonico','37 armonico','38 armonico','39 armonico','40 armonico'];
    $('#loaderimg').hide();
    $("#graficosPredefinidos").children().prop('disabled',true);
    $('input[name="fase"]')[0].checked = true;
    $('#cboxfase1').attr('checked', true);
    $('#cboxfase2').attr('checked', true);
    $('#cboxfase3').attr('checked', true);
    
    //registrando eventos de check/uncheck de las fases para la tabla principal
    if(tipo == 'pri'){
        $('#cboxfase1').click (function ()
            {
             var thisCheck = $(this);
             if (thisCheck.is (':checked')){
                for(ch=1;ch<9;ch++){
                    $("#jqxgrid").jqxGrid('showcolumn', +ch);
                }
             }
             else{
                for(ch=1;ch<9;ch++){
                    $("#jqxgrid").jqxGrid('hidecolumn', +ch);
                }
             }
             setListaCB($('#cboxfase1').prop('checked'), $('#cboxfase2').prop('checked'), $('#cboxfase3').prop('checked'));
            });
        $('#cboxfase2').click (function ()
            {
             var thisCheck = $(this);
             if (thisCheck.is (':checked')){
                for(ch=9;ch<17;ch++){
                    $("#jqxgrid").jqxGrid('showcolumn', +ch);
                }
             }
             else{
                for(ch=9;ch<17;ch++){
                    $("#jqxgrid").jqxGrid('hidecolumn', +ch);
                }
             }
             setListaCB($('#cboxfase1').prop('checked'), $('#cboxfase2').prop('checked'), $('#cboxfase3').prop('checked'));
            });
        $('#cboxfase3').click (function ()
            {
             var thisCheck = $(this);
             if (thisCheck.is (':checked')){
                for(ch=17;ch<25;ch++){
                    $("#jqxgrid").jqxGrid('hidecolumn', +ch);
                }
             }
             else{
                for(ch=17;ch<25;ch++){
                    $("#jqxgrid").jqxGrid('hidecolumn', +ch);
                }
             }
             setListaCB($('#cboxfase1').prop('checked'), $('#cboxfase2').prop('checked'), $('#cboxfase3').prop('checked'));
            });
    }
    //**********************CARGANDO EL GRAFICO
        chart = new CanvasJS.Chart("chartContainer", {
        
        theme: "theme1",
        zoomEnabled: true,
      title:{
        text: "Graficos"              
      },
      legend: {
       horizontalAlign: "center",
       verticalAlign: "bottom",
       fontSize: 14,
     },
      axisX:{
        labelAngle: 30,
      },
      data: [
        {   type: "column", 
            color: "#4F81BC", 
            dataPoints: [] }
       ]
     });
    chart.render();
    //******************FIN CARGA DE GRAFICO
    
    //******************CARGA DE GRID
    arreglo_completo = null;
    var theme = getDemoTheme();
            
    var widthGrid = 900;
    if(tipo == 'pri')
        widthGrid = 750;

    source =
    {
        localdata: arreglo_completo,
        datatype: "array"
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#jqxgrid").jqxGrid(
    {
        width: widthGrid,
        source: dataAdapter,
        columns: [
          { text: 'Datos', datafield: '0', width: 900, height : 400, cellsalign: 'left' }
          ]
    });

    //registrando el evento de seleccion de una fila si estoy en las armonicas
    if(tipo == 'armi' || tipo == 'armv'){
        $("#jqxgrid").bind('rowselect', function (event) {
            //console.log('seleccione la fila');
            var row = event.args.rowindex;
            var datarow = $("#jqxgrid").jqxGrid('getrowdata', row);
            recargarGrafico('armonicas', datarow);
        });
    }
    
    //iniciando el listBox si estoy en la tabla principal
    if(tipo == 'pri'){
        $("#jqxlistbox").jqxListBox({ source: [{ label: 'Datos', value: '0', checked: true }], width: 145, height: 325, theme: theme, checkboxes: true });
        $("#jqxlistbox").on('checkChange', function (event) {
            if (event.args.checked) {
                $("#jqxgrid").jqxGrid('showcolumn', event.args.value);
            }
            else {
                $("#jqxgrid").jqxGrid('hidecolumn', event.args.value);
            }
        });
    }
    
  };
  
  var obtenerColumna = function(colIndex){
      //retorno toda la columna en un Array
      var arrayCol = new Array();
      var rowIndex = 0;
      while(true){
          var displayValue = $("#jqxgrid").jqxGrid('getcellvalue', rowIndex, colIndex);
          rowIndex++;
          if(displayValue == null)
              break;
          else
              arrayCol.push(displayValue);
      }
      return arrayCol;
  }
  
  var recargarGrafico =function(tipoChart, datos){
      if(tipoChart == 'armonicas')//cuando se selecciona una fila y se dibuja el grafico de barras
          {
              var long = datos.length;
              var headerGrafico = datos[0];
              //console.log(headerGrafico);
              var arrGrafico = new Array();
              var item = {};
              var num;
              for(var ss=2;ss<long;ss++){
                  num = +datos[ss];
                  if(num != datos[ss])
                      num = 0;
                  item = {
                      'label' : 'columna' + ss,
                      'y' : num
                  };
                  arrGrafico.push(item);
              }
            chart.options.data[0].dataPoints = arrGrafico;
            chart.options.title.text = headerGrafico;
            chart.render();
          }
      if(tipoChart == 'principal')
          {
            var arrayData = new Array();//Array donde van todas las columnas a graficar ya listas, tier 3
            var fechas = obtenerColumna('0');//arreglo de fechas
            var filasAgraficar = datos.length;
            var longDatos = fechas.length;//numero de datos que van como datapoints (numero de filas)
            //variables a usar en cada iteracion del for
            var arrGrafico;//array de los datapoints, tier 1
            var item = {};
            var num;
            var arrTempCol;
            //una iteracion por cada columna a graficar
            for(ss=0;ss<filasAgraficar;ss++){//datos[ss] es el index de la columna en la que estoy, s2 es el index de la fila
                arrGrafico = new Array()
                arrTempCol = obtenerColumna(+datos[ss]);
                for(var s2=0;s2<longDatos;s2++){
                  num = +arrTempCol[s2];
                  if(num != arrTempCol[s2])
                      num = 0;
                  item = {
                      'label' : fechas[s2],
                      'y' : num
                  };
                  arrGrafico.push(item);
                }
                item = {
                    'type' : 'line',
                    'showInLegend' : true,
                    'legendText': $('#jqxgrid').jqxGrid('getcolumnproperty', +datos[ss], 'text'),
                    'dataPoints' : arrGrafico
                };
                arrayData.push(item);
            }
            chart.options.data = arrayData;
            chart.options.title.text = 'Datos filtrados';
            chart.render();
          }
  };
  
  var limpiarGrafico = function(){
            chart.options.data = [{type: "column", color: "#4F81BC", dataPoints: []}];
            chart.options.title.text = 'Graficos';
            chart.render();
  }
  
  var graficaPri = function(){
      //obtengo las columnas que estan marcadas en el listBox para enviarselas a recargarGrafico()
      var itemsChecked = $("#jqxlistbox").jqxListBox('getCheckedItems');
      var arrColsGraf = new Array();
      for(gp=0;gp<itemsChecked.length;gp++){
          arrColsGraf.push(itemsChecked[gp]['value']);
      }
      console.log(arrColsGraf);
      recargarGrafico('principal', arrColsGraf);
  }
  
  var graficaPredef = function(tipoGrafico){
      //obtengo la fase que quieren graficar
    var fase = obtieneFase();
    var colg = 0;
      //grafico
    if(tipoGrafico == 'vt')
        colg = 1;
    else{
      if(tipoGrafico == 'it')
        colg = 2;
      else{
        if(tipoGrafico == 'fpt')
          colg = 8;
        else{
            if(tipoGrafico == 'thdit')
              colg = 4;
        }
      }
    }
    if(fase == '1')
        colg = colg + 0;
    else{
        if(fase == '2')
            colg = colg + 8;
        else{
            if(fase == '3')
                colg = colg + 16;
        }
    }
    recargarGrafico('principal', [+colg]);
  }
  
  var obtieneFase = function(){
      return $('input:radio[name=fase]:checked').val();
  }
  
  var traerDatos = function(){
      if(tipo == 'armi' || tipo == 'armv'){
        var fase = obtieneFase();
        if(validaFecha($('#start-date').val(), $('#end-date').val()) && fase != undefined)
            {
              $('#loaderimg').show();    
              var cct = $.cookie('cookieUCA');
              var fechaIni = $('#start-date').val();
              var fechaFin = $('#end-date').val();
              var request = $.ajax({
                  url: "<?=base_url()?>index.php/graficos_control/graficosDatos",
                  type: "POST",
                  data: {'tokenUCA' : cct, 'id' : <?php echo $idSub ?>, 'fechaIni' : fechaIni, 'fechaFin' : fechaFin, 'tipo' : tipo, 'fase' : fase},
                  dataType: "json"
                });
                request.done(function(msg, status, XHR) {
                  arreglo_completo = msg;
                  setColumnas();
                  $("#jqxgrid").jqxGrid('columns', arrColumnasGrid);
                  source.localdata = arreglo_completo;
                  $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                  $("#jqxgrid").jqxGrid('autoresizecolumns');
                  limpiarGrafico();
                  $('#loaderimg').hide();
                });
                request.fail(function(XHR, textStatus, response) {
                  $('#loaderimg').hide();
                  alert( "Fallo peticion a servidor: " + textStatus );
                });
            }
        else
            {
                alert("Ingresar Fechas validas");
            }
      }
      if(tipo == 'pri'){//AQUI NO VALIDO LA FASE
        if(validaFecha($('#start-date').val(), $('#end-date').val()))
            {
              $('#loaderimg').show();    
              var cct = $.cookie('cookieUCA');
              var fechaIni = $('#start-date').val();
              var fechaFin = $('#end-date').val();
              var request = $.ajax({
                  url: "<?=base_url()?>index.php/graficos_control/graficosDatos",
                  type: "POST",
                  data: {'tokenUCA' : cct, 'id' : <?php echo $idSub ?>, 'fechaIni' : fechaIni, 'fechaFin' : fechaFin, 'tipo' : tipo},
                  dataType: "json"
                });
                request.done(function(msg, status, XHR) {
                  arreglo_completo = msg;
                  setColumnas();
                  setListaCB(true, true, true);
                  $("#jqxgrid").jqxGrid('columns', arrColumnasGrid);
                  source.localdata = arreglo_completo;
                  $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                  $("#jqxgrid").jqxGrid('autoresizecolumns');
                  limpiarGrafico();
                  $("#graficosPredefinidos").children().prop('disabled',false);
                  $('#loaderimg').hide();
                });
                request.fail(function(XHR, textStatus, response) {
                  $('#loaderimg').hide();
                  alert( "Fallo peticion a servidor: " + textStatus );
                });
            }
        else
            {
                alert("Ingresar Fechas validas");
            }
      }
        
}

var setColumnas = function(){
    arrColumnasGrid = new Array();
    var itemColumna = {};
    if(tipo == 'pri'){
            for(cc=0;cc<arreglo_headersPri.length;cc++){
                itemColumna = {
                    text: arreglo_headersPri[cc],
                    datafield : cc,
                    width : 80
                }
                arrColumnasGrid.push(itemColumna);
            }
    }
    if(tipo == 'armi' || tipo == 'armv'){
            for(cc=0;cc<arreglo_headersArm.length;cc++){
                itemColumna = {
                    text: arreglo_headersArm[cc],
                    datafield : cc,
                    width : 80
                }
                arrColumnasGrid.push(itemColumna);
            }
    }
}

var setListaCB = function(f1, f2, f3){
    var listSource = new Array();
    var itemListSource = {};
    if(f1){
            for(dd=1;dd<9;dd++){
                itemListSource = {
                    label: arreglo_headersPri[dd],
                    value : dd+'',
                    checked : true
                }
                listSource.push(itemListSource);
            }
    }
    if(f2){
            for(dd=9;dd<17;dd++){
                itemListSource = {
                    label: arreglo_headersPri[dd],
                    value : dd+'',
                    checked : true
                }
                listSource.push(itemListSource);
            }
    }
    if(f3){
            for(dd=17;dd<25;dd++){
                itemListSource = {
                    label: arreglo_headersPri[dd],
                    value : dd+'',
                    checked : true
                }
                listSource.push(itemListSource);
            }
    }
    $("#jqxlistbox").jqxListBox('source', listSource);
}
  
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

  <div style="float: left;"><h2 style="margin: 5px 5px 0px 20px;">GRAFICOS</h2></div>
<div style="margin-left: 200px;">
    <div style="float:left;">Fecha de inicio<br>
    <input name="start-date" id="start-date" class="date-pick" value="Fecha de inicio" /></div>
    <div style="float:left;">Fecha de finalizacion<br>
    <input name="end-date" id="end-date" class="date-pick" value="Fecha fin" /></div>
    <div style="float:left; height:100%; vertical-align: bottom; margin-left:15px;">
        <?php if ($tipo == 'armi' || $tipo == 'armv'){
            echo 'Fase: <br>
                <input type="radio" name="fase" value="1">1
                <input type="radio" name="fase" value="2">2
                <input type="radio" name="fase" value="3">3';
        }
        ?>
    
        <button onClick="traerDatos();" style="width: 155px; height: 35px; margin-top:10px;" name="pressmeDatos">Cargar Datos</button>
    </div><br>
    <?php if ($tipo == 'pri'){
        echo '<div id="graficosPredefinidos" style="clear: both; margin-top:25px; margin-bottom: 5px;">
            Graficos Predefinidos:<br>
            <button style="width: 125px; height: 35px;" onClick="graficaPredef(\'vt\')" name="graficarPri">Grafico V-t</button>
            <button style="width: 125px; height: 35px;" onClick="graficaPredef(\'it\')" name="graficarPri">Grafico I-t</button>
            <button style="width: 125px; height: 35px;" onClick="graficaPredef(\'fpt\')" name="graficarPri">Grafico Fp.-t</button>
            <button style="width: 125px; height: 35px;" onClick="graficaPredef(\'thdit\')" name="graficarPri">Grafico THD I-t</button>
            Fase:
            <input type="radio" name="fase" value="1">1
            <input type="radio" name="fase" value="2">2
            <input type="radio" name="fase" value="3">3
        </div>';
    }
        ?>
<img id="loaderimg" style="height: 40px; width: 40px; margin-left:15px;" src="<?=base_url()?>css/images/ajax-loader2.gif"/>
</div>
 
<div id="chartContainer" style="height: 400px; width: 100%;  clear:both;">
  </div>
<div id='jqxWidget' style="height: 400px;">
        
        <div style="height: 400px;  float:left;" id="jqxgrid"></div>
        <?php 
        if ($tipo == 'pri'){
            echo '<div style="height:50px;">
                Fase: <br>
                <input type="checkbox" name="fase1" id="cboxfase1">1
                <input type="checkbox" name="fase2" id="cboxfase2">2
                <input type="checkbox" name="fase3" id="cboxfase3">3
                </div>
                <div id="jqxlistbox"></div>
                <button style="width: 147px; height: 25px;" onClick="graficaPri()" name="graficarPri">Graficar</button>';
        }
        ?>
        
    </div>
