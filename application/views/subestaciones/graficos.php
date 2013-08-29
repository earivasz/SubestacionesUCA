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
<script type="text/javascript" src="<?=base_url()?>js/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.ui.datepicker.js"></script>
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
    var multafp;
    var multathdi;

$(document).ready( function(){
         $('#cssmenu ul li[id=cssmenu2] ul').append('<li><a href="<?php echo base_url() . 'index.php/subestaciones/galeria/' . $idSub ?>"><span>Galeria</span></a></li>');
         //cargas tipo = 1
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $idSub . '/1' ?>"><span>Cargas de subestacion</span></a></li>');
         //principal tipo = 4
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $idSub . '/4' ?>"><span>Tabla principal</span></a></li>');
         //voltaje tipo = 3
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $idSub . '/3' ?>"><span>Tabla armonicas (Voltaje)</span></a></li>');
         //corriente tipo = 2
         $('#cssmenu ul li[id=cssmenu4] ul').append('<li><a href="<?php echo base_url() . 'index.php/archivos/crear/' . $idSub . '/2' ?>"><span>Tabla armonicas (Corriente)</span></a></li>');
});

  window.onload = function () {
    tipo = '<?php echo $tipo; ?>';
    multafp = <?php echo $multafp[0]['valor']; ?>;
    multathdi = <?php echo $multathdi[0]['valor']; ?>;
    arreglo_headersPri = ['Fecha y hora',
        'Voltaje 1 [V]','Corriente 1 [A]','%THD V1','%THD I1','Potencia Aparente 1 [VA]','Potencia Activa 1 [W]','Potencia reactiva 1 [VAR]','Factor de potencia 1',
        'Voltaje 2 [V]','Corriente 2 [A]','%THD V2','%THD I2','Potencia Aparente 2 [VA]','Potencia Activa 2 [W]','Potencia reactiva 2 [VAR]','Factor de potencia 2',
        'Voltaje 3 [V]','Corriente 3 [A]','%THD V3','%THD I3','Potencia Aparente 3 [VA]','Potencia Activa 3 [W]','Potencia reactiva 3 [VAR]','Factor de potencia 3',
        'FP Promedio', '%THDI Promedio'];
    arreglo_headersArm = ['Fecha y hora','fundamental',
        '2 armonico','3 armonico','4 armonico','5 armonico','6 armonico','7 armonico','8 armonico','9 armonico','10 armonico',
        '11 armonico','12 armonico','13 armonico','14 armonico','15 armonico','16 armonico','17 armonico','18 armonico','19 armonico','20 armonico',
        '21 armonico','22 armonico','23 armonico','24 armonico','25 armonico','26 armonico','27 armonico','28 armonico','29 armonico','30 armonico',
        '31 armonico','32 armonico','33 armonico','34 armonico','35 armonico','36 armonico','37 armonico','38 armonico','39 armonico','40 armonico'];
    $("#graficosPredefinidos").children().prop('disabled',true);
    $("#filtrosPri").children().prop('disabled',true);
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
            recargarGrafico('armonicas', datarow, '', 0);
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
  
  var recargarGrafico =function(tipoChart, datos, titulo, linearoja){
      if(tipoChart == 'armonicas')//cuando se selecciona una fila y se dibuja el grafico de barras
          {
              var long = datos.length;
              var headerGrafico = datos[0];
              //console.log(headerGrafico);
              var arrGrafico = new Array();
              var item = {};
              var num;
              for(var ss=1;ss<long;ss++){
                  num = +datos[ss];
                  if(num != datos[ss])
                      num = 0;
                  item = {
                      'label' : arreglo_headersArm[ss],
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
            var columnasAgraficar = datos.length;
            var longDatos = fechas.length;//numero de datos que van como datapoints (numero de filas)
            //variables a usar en cada iteracion del for
            var arrGrafico;//array de los datapoints, tier 1
            var item = {};
            var num;
            var arrTempCol;
            //una iteracion por cada columna a graficar
            for(ss=0;ss<columnasAgraficar;ss++){//datos[ss] es el index de la columna en la que estoy, s2 es el index de la fila
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
            //comprobando si tengo que hacer una linea roja o no
            if(linearoja > 0){
                arrGrafico = new Array();
                for(var s2=0;s2<longDatos;s2++){
                  item = {
                      'label' : fechas[s2],
                      'y' : linearoja
                  };
                  arrGrafico.push(item);
                }
                item = {
                    'type' : 'line',
                    'showInLegend' : true,
                    'legendText': 'Limite de multa',
                    'dataPoints' : arrGrafico
                };
                arrayData.push(item);
            }
            //fin agregando linea roja
            chart.options.data = arrayData;
            if(titulo != '')
                chart.options.title.text = titulo;
            else
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
      //console.log(arrColsGraf);
      recargarGrafico('principal', arrColsGraf, '', 0);
  };
  
  var graficaPredef = function(tipoGrafico){
      //obtengo la fase que quieren graficar
    var fase = obtieneFase();
    var colg = 0;
    var titulo = '';
    var linearoja = 0;
      //grafico
    if(tipoGrafico == 'vt'){
        colg = 1;
        titulo = 'Voltaje/tiempo';
    }
    else{
      if(tipoGrafico == 'it'){
        colg = 2;
        titulo = 'Corriente/tiempo';
      }
      else{
        if(tipoGrafico == 'fpt'){
          colg = 8;
          titulo = 'Factor de Potencia/tiempo';
          linearoja = +multafp;
        }
        else{
            if(tipoGrafico == 'thdit'){
              colg = 4;
              titulo = 'THD I/tiempo';
              linearoja = +multathdi;
            }
            else{
                if(tipoGrafico == 'fpprom'){
                    colg = 25;
                    titulo = 'FP Promedio';
                    linearoja = +multafp;
                }
                else{
                    if(tipoGrafico == 'thdiprom'){
                        colg = 26;
                        titulo = 'THDI Promedio';
                        linearoja = +multathdi;
                    }
                }
            }
        }
      }
    }
    if(fase == '1' && tipoGrafico != 'fpprom' && tipoGrafico != 'thdiprom'){
        colg = colg + 0;
        titulo += ' Fase 1';
    }
    else{
        if(fase == '2' && tipoGrafico != 'fpprom' && tipoGrafico != 'thdiprom'){
            colg = colg + 8;
            titulo += ' Fase 2';
        }
        else{
            if(fase == '3' && tipoGrafico != 'fpprom' && tipoGrafico != 'thdiprom'){
                colg = colg + 16;
                titulo += ' Fase 3';
            }
        }
    }
    recargarGrafico('principal', [+colg], titulo, linearoja);
  };
  
  var obtieneFase = function(){
      return $('input:radio[name=fase]:checked').val();
  };
  
  var traerDatos = function(){
      $("#botbotTraerDatos").prop('disabled',true);
      if(tipo == 'armi' || tipo == 'armv'){
        var fase = obtieneFase();
        if(validaFecha($('#start-date').val(), $('#end-date').val()) && fase != undefined)
            {
              showMsg('modal_msj', 'loading', 'Un momento mientras se cargan los datos');
              var cct = $.cookie('cookieUCA');
              var fechaIni = $('#start-date').val();
              var fechaFin = $('#end-date').val();
              var request = $.ajax({
                  url: "<?=base_url()?>index.php/graficos_control/graficosDatos",
                  type: "POST",
                  data: {'tokenUCA' : cct, 'id' : <?php echo $idSub ?>, 'fechaIni' : fechaIni, 'fechaFin' : fechaFin, 'tipo' : tipo, 'fase' : fase, 'origenCorrecto' : true},
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
                  close_modal();
                });
                request.fail(function(XHR, textStatus, response) {
                  close_modal();
                  //console.log(response);
                  showMsg('modal_msj', 'aceptar', 'Ocurrio un error obteniendo los datos, asegurese que su conexion a internet este activa y vuelva a intentarlo');
                });
            }
        else
            {
                showMsg('modal_msj', 'aceptar', 'Debe ingresar fechas validas');
            }
      }
      if(tipo == 'pri'){//AQUI NO VALIDO LA FASE
        if(validaFecha($('#start-date').val(), $('#end-date').val()))
            { 
              showMsg('modal_msj', 'loading', 'Un momento mientras se cargan los datos');
              var cct = $.cookie('cookieUCA');
              var fechaIni = $('#start-date').val();
              var fechaFin = $('#end-date').val();
              var request = $.ajax({
                  url: "<?=base_url()?>index.php/graficos_control/graficosDatos",
                  type: "POST",
                  data: {'tokenUCA' : cct, 'id' : <?php echo $idSub ?>, 'fechaIni' : fechaIni, 'fechaFin' : fechaFin, 'tipo' : tipo, 'origenCorrecto' : true},
                  dataType: "json"
                });
                request.done(function(msg, status, XHR) {
                  arreglo_completo = msg;
                  //console.log(arreglo_completo);
                  setColumnas();
                  setListaCB(true, true, true);
                  $("#jqxgrid").jqxGrid('columns', arrColumnasGrid);
                  source.localdata = arreglo_completo;
                  $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                  $("#jqxgrid").jqxGrid('autoresizecolumns');
                  limpiarGrafico();
                  $("#graficosPredefinidos").children().prop('disabled',false);
                  $("#filtrosPri").children().prop('disabled',false);
                  close_modal();
                  $('#cboxfase1').prop('checked', true);
                  $('#cboxfase2').prop('checked', true);
                  $('#cboxfase3').prop('checked', true);
                });
                request.fail(function(XHR, textStatus, response) {
                  close_modal();
                  showMsg('modal_msj', 'aceptar', 'Ocurrio un error obteniendo los datos, asegurese que su conexion a internet este activa y vuelva a intentarlo');
                });
            }
        else
            {
                showMsg('modal_msj', 'aceptar', 'Debe ingresar fechas validas');
            }
      }
      $("#botbotTraerDatos").prop('disabled',false);
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
    for(dd=25;dd<27;dd++){
                itemListSource = {
                    label: arreglo_headersPri[dd],
                    value : dd+'',
                    checked : true
                }
                listSource.push(itemListSource);
            }
    $("#jqxlistbox").jqxListBox('source', listSource);
}
  
  </script>
  
  <script type="text/javascript" charset="utf-8">
    $(function()
    {
            var dias = '<?php foreach($diasConDatos as $dia){echo $dia['dia'] . ',';} ?>';
            var ev = dias.split(',');
            $('#start-date').datepicker({
                startDate:'01-01-1996', 
                dateFormat: 'dd-mm-yy',
                onSelect: function(selected){
                    $('#end-date').datepicker("option", "minDate", selected);
                },
                beforeShowDay: function(date){
                    var current = $.datepicker.formatDate('dd-mm-yy', date);
                    return $.inArray(current, ev) == -1 ? [true, ''] : [true, 'markedDay', 'ui-state-highlight'];
                }
            });
            $('#end-date').datepicker({
                startDate:'01-01-1996', 
                dateFormat: 'dd-mm-yy',
                beforeShowDay: function(date){
                    var current = $.datepicker.formatDate('dd-mm-yy', date);
                    return $.inArray(current, ev) == -1 ? [true, ''] : [true, 'markedDay', 'ui-state-highlight'];
                }
            });
    });
    

        
    
  </script>
  <div class="menu_navegacion_subs">
      <a href="<?=base_url()?>index.php/subestaciones">Subestaciones</a>
      <span class="menu_navegacion_subs_sep">/</span>
      <a href="<?=base_url()?>index.php/subestaciones/detalle/<?php echo $idSub ?>">Subestacion <?php echo $subest[0]['numSubestacion'] . ', ' . $subest[0]['localizacion'] ?></a>
      <span class="menu_navegacion_subs_sep">/</span>
      <?php if ($tipo == 'pri'){
            echo 'Tabla Principal';
        }
        else{
            if($tipo == 'armi'){
                echo 'Armonicas de Corriente';
            }
            else{
                echo 'Armonicas de Voltaje';
            }
        }
        ?>
  </div>
  <div style="width: 100%; text-align:center;"><h2 style="margin: 5px 5px 20px 20px;">GRAFICOS <?php echo (($tipo == 'pri') ? 'TABLA PRINCIPAL' : 'TABLA ARMONICOS ' . (($tipo == 'armi') ? '(CORRIENTE)' : '(VOLTAJE)')) . ', SUBESTACION ' . $subest[0]['numSubestacion'] . ', ' . $subest[0]['localizacion'];?></h2></div>
  <div style="text-align: center; width: 100%; margin-bottom: 20px;">Seleccione un rango de fechas:</div>
  <div style="text-align: center; width: 100%; margin-bottom: 20px;">
    <div style="float:left; margin-left: 175px; margin-right: 30px;">Fecha de inicio<br>
    <input name="start-date" id="start-date" class="date-pick" value="Fecha de inicio" /></div>
    <div style="float:left;">Fecha de finalizacion<br>
    <input name="end-date" id="end-date" class="date-pick" value="Fecha fin" /></div>
    <div style="float:left; height:100%; vertical-align: bottom; margin-left:15px;">
        <?php if ($tipo == 'armi' || $tipo == 'armv'){
            echo 'Fase:
                <input type="radio" name="fase" value="1">1
                <input type="radio" name="fase" value="2">2
                <input type="radio" name="fase" value="3">3';
        }
        ?>
    
        <button id="botTraerDatos" onClick="traerDatos();" style="width: 155px; height: 35px; margin-top:10px; margin-left:10px;" name="pressmeDatos">Cargar Datos</button>
    </div><br><br>
    <?php if ($tipo == 'pri'){
        echo '<div id="graficosPredefinidos" style="clear: both; margin-top:25px; margin-bottom: 5px;">
            Graficos Predefinidos:<br>
            Fase:
            <input type="radio" name="fase" value="1">1
            <input type="radio" name="fase" value="2">2
            <input type="radio" name="fase" value="3">3
            <button style="width: 105px; height: 35px;" onClick="graficaPredef(\'vt\')" name="graficarPri">Voltaje/tiempo</button>
            <button style="width: 105px; height: 35px;" onClick="graficaPredef(\'it\')" name="graficarPri">Corriente/tiempo</button>
            <button style="width: 100px; height: 35px;" onClick="graficaPredef(\'fpt\')" name="graficarPri">FP/tiempo</button>
            <button style="width: 100px; height: 35px;" onClick="graficaPredef(\'thdit\')" name="graficarPri">THD I/tiempo</button>
            |
            <button style="width: 125px; height: 35px;" onClick="graficaPredef(\'fpprom\')" name="graficarPri"> FP Promedio</button>
            <button style="width: 125px; height: 35px;" onClick="graficaPredef(\'thdiprom\')" name="graficarPri"> THD I Promedio</button>
        </div>';
    }
        ?>
</div>
 
<div id="chartContainer" style="height: 400px; width: 100%;  clear:both;">
  </div>
<div style="height: 40px; font-size: 30px; text-align: center; width:100%;">Datos de tabla</div>
<div id='jqxWidget' style="height: 400px;">
        <?php 
        if ($tipo != 'pri'){
              echo '<div style="width:100%; text-align:center;">Seleccione una fila para ver su grafica</div>';
        }
        ?>
        <div style="height: 400px;  float:left;" id="jqxgrid"></div>
        <?php 
        if ($tipo == 'pri'){
            echo '<div id="filtrosPri" style="height:50px;">
                Filtrado por fase: <br>
                <input type="checkbox" name="fase1" id="cboxfase1" style="width:15px;">1
                <input type="checkbox" name="fase2" id="cboxfase2" style="width:15px;">2
                <input type="checkbox" name="fase3" id="cboxfase3" style="width:15px;">3
                </div>
                <div id="jqxlistbox"></div>
                <button style="width: 135px; height: 25px;" onClick="graficaPri()" name="graficarPri">Graficar</button>';
        }
        ?>
        
    </div>