<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?= base_url() ?>js/maps2.js"></script>
<script type="text/javascript">
    var numTrans = 1;
    var numId = 1;
    window.onload = function() {
        $('#trans-form').slideUp();
        $('#but-trans').slideUp();
        <?php
        $msj = $this->session->flashdata('msj');
        if ($msj) {
            ?>
                    showMsg('modal_msj', 'aceptar', '<?php echo $msj; ?>');
            <?php
        }
        ?>
        /*$("#subForm").submit(function(e) {
            var self = this;
            //e.preventDefault();
            //$('#submitArch').attr('disabled', 'disabled');
            showMsg('modal_msj', 'loading', 'Un momento mientras el archivo esta siendo cargado')
            //self.submit();
            return true; //is superfluous, but I put it here as a fallback
        });*/
    };
    /**
     * Validar parametros de una subestacion
     */
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

    function addTrans() {
        numTrans++;
        numId++;
        var div = '<div id="trans_' + numId + '" class="border-box">' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="noSerie">Numero de serie</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="noSerie_' + numId + '" name="noSerie" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="capaTra">Capacidad</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="capaTra_' + numId + '" name="capaTra">' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="fabricante">Fabricante</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="fabricante_' + numId + '" name="fabricante" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="enfriamento">Enfriamento</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="enfriamento_' + numId + '" name="enfriamento" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="impedancia">Impedancia</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="impedancia_' + numId + '" name="impedancia" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="vPrimaria">Voltaje primario</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="vPrimaria_' + numId + '" name="vPrimaria" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="vSecundario">Voltaje secundario</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="vSecundario_' + numId + '" name="vSecundario" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="rTrans">Resistencia transformador</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="rTrans_' + numId + '" name="rTrans" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="polaridad">Polaridad</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="polaridad_' + numId + '" name="polaridad" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="aterriza">Aterrizamiento</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="aterriza_' + numId + '" name="aterriza" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="pararrayos">Pararrayos</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="pararrayos_' + numId + '" name="pararrayos" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="cuchillas">Cuchillas</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="cuchillas_' + numId + '" name="cuchillas" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<input type="button" value="Eliminar" onclick="javascript:removeTrans(this);" id="remove_' + numId + '"/>' +
                '</div>';
        if (numTrans <= 4) {
            $('#transformadores').append(div);
        } else {
            numTrans--;
            showMsg('modal_msj', 'aceptar', 'No se pueden agregar mas de 4 transformadores')
        }

    }

    function removeTrans(boton) {
        $("#" + boton.id).parent().remove();
        numTrans--;
    }

    function prevStep() {
        $('#but-trans').slideUp('slow', function() {
            $('#trans-form').slideUp('slow', function() {
                $('#map-canvas').slideDown('slow', function() {
                    $('#sub-form').slideDown('slow');
                });
            });
        });
    }

    function nextStep() {
        if (validSub()) {
            $('#map-canvas').slideUp();
            $('#sub-form').slideUp('slow', function() {
                $('#trans-form').slideDown('slow', function() {
                    $('#but-trans').slideDown('slow');
                });
            });
        }
    }

    function getParamsSub() {
        var coordX = $('#coordX').val();
        var coordY = $('#coordY').val();
        var numSub = $('#numSub').val();
        var localizacion = $('#localizacion').val();
        var capacidad = $('#capacidad').val();
        var conexion = $('#conexion').val();
        var sub = coordX + '/|\\' + coordY + '/|\\' + numSub + '/|\\' + localizacion + '/|\\' + capacidad + '/|\\' + conexion;
        return sub;
    }

    function finalizaSub() {
        showMsg('modal_msj', 'loading', 'Un momento mientras se almacenan los datos');
        if (validSub()) {

            var sub = getParamsSub();
            //alert(sub);
            //console.log(sub.split('/|\\'));
            var cct = $.cookie('cookieUCA');
            //alert(cct);
            //'tokenUCA': cct, 
            var request = $.ajax({
                url: "<?= base_url() ?>index.php/subestaciones/crear",
                type: "POST",
                data: {'tokenUCA': cct, 'subData': sub, 'tipo': '1'},
                dataType: "json"
            });
            request.done(function(msg, status, XHR) {
                //var msj = '<?php echo $this->session->flashdata('msj'); ?>';
                close_modal();
                showMsg('modal_msj', 'aceptar', msg);
            });
            request.fail(function(XHR, textStatus, response) {
                console.log(XHR);
                console.log(textStatus);
                console.log(response);
                close_modal();
                showMsg('modal_msj', 'aceptar', 'Ocurrio un error obteniendo los datos, asegurese que su conexion a internet este activa y vuelva a intentarlo');
            });
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
        console.log(sub)
        console.log(dataT);
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
            console.log(XHR);
            console.log(textStatus);
            console.log(response);
            close_modal();
            showMsg('modal_msj', 'aceptar', 'Ocurrio un error obteniendo los datos, asegurese que su conexion a internet este activa y vuelva a intentarlo');
        });
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
<h2>Create a news item</h2>
<div id="map-canvas" class="map-create"></div>
<?php echo form_open('subestaciones/crear_sub','id=subForm'); ?>
<div id="sub-form">
    <input type="hidden" name="coordX" id="coordX"/>
    <input type="hidden" name="coordY" id="coordY"/>
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
    </div>
    <?php echo validation_errors(); ?>
    <div class="params">

        <div class="prev-step">
        </div>
        <div class="finish-step">
            
            <input type="button" id="fin-sub" value="Finalizar" onclick="javascript:validSub();"/>
        </div>
        <div class="next-step">
            <!--<input type="button" id="next-sub" value="Siguiente >" onclick="javascript:nextStep();"/>-->
        </div>
    </div>
</div>
<?php echo form_close(); ?>