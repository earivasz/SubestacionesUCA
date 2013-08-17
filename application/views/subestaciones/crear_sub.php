<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.selection.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.columnsresize.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.pager.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxdata.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxcheckbox.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxlistbox.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/gettheme.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?= base_url() ?>js/maps2.js"></script>
<script type="text/javascript">
    var numTrans = 1;
    var numId = 1;
    window.onload = function() {
        arreglo_completo = <?php echo json_encode($subs); ?>;
        //AQUI IBA EL CODIGO DEL GRID ANTERIOR
        //console.log(arreglo_completo);
        //var theme = getDemoTheme();
        
        var source ={
            localdata: arreglo_completo,
            datatype: "array"
        };

        $("#jqxgrid").jqxGrid({
            width: 770,
            source: source,
            showfilterrow: true,
            pageable: true,
            autoheight: true,
            filterable: true,
            columns: [
                {text: 'Numero', datafield: 'numSubestacion', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Localizacion', datafield: 'localizacion', width: 235, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Capacidad', datafield: 'capacidad', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Conexion', datafield: 'conexion', width: 255, cellsalign: 'right', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Estado', datafield: 'nomEstado', width: 80, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'}
            ]
        });

        $("#jqxgrid").bind('rowselect', function(event) {
            var row = event.args.rowindex;
            var datarow = $("#jqxgrid").jqxGrid('getrowdata', row);
            var location = new google.maps.LatLng(datarow.coordX, datarow.coordY);
            placeMarker(location);
            $("#numSub").attr('readonly', 'readonly');
            $("#coordX").val(datarow.coordX);
            $("#coordY").val(datarow.coordY);
            $("#numSub").val(datarow.numSubestacion);
            $("#localizacion").val(datarow.localizacion);
            $("#capacidad").val(datarow.capacidad);
            $("#conexion").val(datarow.conexion);
            //console.log(datarow.activo);
            if(datarow.activo === '1'){
                $('#activo').prop('checked',true);
            }else{
                $('#activo').prop('checked',false);
            }
            $("#activo").val(datarow.activo);
            $("#isMod").val('True');
            $("#idSub").val(datarow.idSubestacion);
        });
        
        <?php
        $msj = $this->session->flashdata('msj');
        if ($msj) {
            ?>
                    showMsg('modal_msj', 'aceptar', '<?php echo $msj; ?>');
            <?php
        }
        ?>
    };

    function validSub() {
        var coordX = $('#coordX').val();
        var coordY = $('#coordY').val();
        var numSub = $('#numSub').val();
        var msj = '';
        if (coordX === '' || coordY === '') {
            msj = msj + '<li>Debe seleccionar un punto en el mapa.</li>';
        }
        if (numSub === '') {
            msj = msj + '<li>Debe completar el campo Numero Subestacion</li>';
        }
        if (msj !== '') {
            showMsg('modal_msj', 'aceptar', 'Debe completar la siguiente informacion: <br /><ul>' + msj + '</ul>');
            return false;
        } else {
            showMsg('modal_msj', 'loading', 'Un momento mientras el archivo esta siendo cargado');
            $("#subForm").submit();
            return true;
        }
    }
    
    function validTrans() {
        var dataT = '';
        var numParams = 0;
        $('div[id^="trans_"]').each(function() {
            var idDiv = $(this).attr('id');
            numParams = 0;
            $('#' + idDiv + ' :input[type="input"]').each(function() {
                //var idI = $(this).attr('id');
                var valor = $(this).val();
                if (dataT === '') {
                    dataT = valor + '/|\\';
                } else {
                    dataT = dataT + valor + '/|\\';
                }
                if (valor !== '') {
                    numParams++;
                }
                //dataT = dataT + $(this).val() + '/|\\';
            });
            dataT = dataT.slice(0, -3);
            dataT = dataT + '|||';
            if (numParams === 0) {
                showMsg('modal_msj', 'aceptar', 'Debe completar al menos un campo de cada transformador.');
                return false;
            }
        });
        dataT = dataT.slice(0, -3);
        var sub = getParamsSub();
        var cct = $.cookie('cookieUCA');
        //alert(cct);
        //'tokenUCA': cct, 
        //console.log(sub)
        //console.log(dataT);
        var request = $.ajax({
            url: "<?= base_url() ?>index.php/subestaciones/crear",
            type: "POST",
            data: {'tokenUCA': cct, 'subD': sub, 'transD': dataT, 'tipo': '2'},
            dataType: "json"
        });
        request.done(function(msg, status, XHR) {
            //var msj = '<?php echo $this->session->flashdata('msj'); ?>';
            close_modal();
            showMsgRed('modal_msj', 'aceptar', msg, 'crear');

        });
        request.fail(function(XHR, textStatus, response) {
            //console.log(XHR);
            //console.log(textStatus);
            //console.log(response);
            close_modal();
            showMsg('modal_msj', 'aceptar', 'Ocurrio un error obteniendo los datos, asegurese que su conexion a internet este activa y vuelva a intentarlo');
        });
    }
    
    function setCheck(){
        if($('#activo').val() === '1'){
            $('#activo').val('0');
        }else{
            $('#activo').val('1');
        }
    }
    
    function crear_sub() {
        newMarker.setPosition(null);
        $("#numSub").removeAttr('readonly');
        $("#coordX").val('');
        $("#coordY").val('');
        $("#numSub").val('');
        $("#capacidad").val('');
        $("#conexion").val('');
        $("#localizacion").val('');
        $('#activo').prop('checked',true);
        $('#activo').val('1');
        $("#isMod").val('False');
    }
    
</script>
<style>
    .params{
        width: 100%;
        height: 25px;
    }
    .lbl-left{
        width: 45%;
        text-align: right;
        float: left;
        vertical-align: middle;
    }
    .in-right{
        width: 55%;
        text-align: left;
        float: right;
    }
    .prev-step{
        position: absolute;
        width: 300px;
        text-align: left;
    }
    .next-step{
        position: absolute;
        width: 300px;
        margin-left: 600px;
        text-align: right;
    }
    .finish-step{
        position: absolute;
        width: 300px;
        margin-left: 300px;
        text-align: center;
    }

    .params-tra-left{
        width: 50%;
        text-align: left;
        float: left;
        vertical-align: middle;
    }
    .params-tra-right{
        width: 50%;
        text-align: right;
        float: right;
        vertical-align: middle;
    }
    .limpiar{
        clear: both;
    }
    .border-box{padding:14px 12px; border:1px solid #e9e9e9;}
</style>
<div align="center" id='jqxWidget'>         
    <h2>SUBESTACIONES</h2>
    <div align="center" style="width:100%; height: 700px;" id="jqxgrid"></div>
</div>
<br/>
<div id="map-canvas" class="map-create"></div>
<?php echo form_open('subestaciones/crear_sub','id=subForm'); ?>
<div id="sub-form">
    <input type="hidden" name="coordX" id="coordX"/>
    <input type="hidden" name="coordY" id="coordY"/>
    <input type="hidden" name="isMod" id="isMod" value="False"/>
    <input type="hidden" name="idSub" id="idSub"/>
    <div style="text-align:center;width: 100%;" id="sub-params">
        <div class="params">
            <div class="lbl-left">
                <label for="numSub">Numero Subestacion</label>
            </div>
            <div class="in-right">
                <input type="input" id="numSub" name="numSub" />
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <label for="localizacion">Localizacion</label>
            </div>
            <div class="in-right">
                <input type="input" id="localizacion" name="localizacion">
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <label for="capacidad">Capacidad</label>
            </div>
            <div class="in-right">
                <input type="input" id="capacidad" name="capacidad" />
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <label for="conexion">Conexion</label>
            </div>
            <div class="in-right">
                <input type="input" id="conexion" name="conexion" />
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <label for="activo">Activo</label>
            </div>
            <div class="in-right">
                <input type="checkbox" name="activo" id="activo" value="1" checked="checked">
            </div>
        </div>
        
    </div>
    <?php echo validation_errors(); ?>
    <div class="params">

        <div class="prev-step">
        </div>
        <div class="finish-step">
            <input type="button" id="crear-sub" value="Crear" onclick="javascript:crear_sub();"/>
            <input type="button" id="fin-sub" value="Guardar" onclick="javascript:validSub();"/>
        </div>
        <div class="next-step">
            <!--<input type="button" id="next-sub" value="Siguiente >" onclick="javascript:nextStep();"/>-->
        </div>
    </div>
</div>
<?php echo form_close(); ?>