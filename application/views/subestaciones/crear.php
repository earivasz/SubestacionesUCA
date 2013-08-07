<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="<?= base_url() ?>js/maps2.js"></script>
<script type="text/javascript">
    var numTrans = 1;
    $(document).ready(function() {
        $('#trans-form').slideUp();
        $('#but-trans').slideUp();
    });
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
            return true;
        }
    }

    function addTrans() {
        numTrans++;
        var div = '<div id="trans_' + numTrans + '" class="border-box">' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="noSerie">Numero de serie</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="noSerie_' + numTrans + '" name="noSerie" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="capaTra">Capacidad</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="capaTra_' + numTrans + '" name="capaTra">' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="fabricante">Fabricante</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="fabricante_' + numTrans + '" name="fabricante" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="enfriamento">Enfriamento</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="enfriamento_' + numTrans + '" name="enfriamento" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="impedancia">Impedancia</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="impedancia_' + numTrans + '" name="impedancia" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="vPrimaria">Voltaje primario</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="vPrimaria_' + numTrans + '" name="vPrimaria" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="vSecundario">Voltaje secundario</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="vSecundario_' + numTrans + '" name="vSecundario" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="rTrans">Resistencia transformador</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="rTrans_' + numTrans + '" name="rTrans" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="polaridad">Polaridad</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="polaridad_' + numTrans + '" name="polaridad" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="aterriza">Aterrizamiento</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="aterriza_' + numTrans + '" name="aterriza" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<div class="params-tra-left">' +
                '<div class="lbl-left">' +
                '<label for="pararrayos">Pararrayos</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="pararrayos_' + numTrans + '" name="pararrayos" />' +
                '</div>' +
                '</div>' +
                '<div class="params-tra-right">' +
                '<div class="lbl-left">' +
                '<label for="cuchillas">Cuchillas</label>' +
                '</div>' +
                '<div class="in-right">' +
                '<input type="input" id="cuchillas_' + numTrans + '" name="cuchillas" />' +
                '</div>' +
                '</div>' +
                '<div class="limpiar">' + '</div>' +
                '<input type="button" value="Eliminar" onclick="javascript:removeTrans(this);" id="remove_' + numTrans + '"/>' +
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

    function finalizaSub() {
        showMsg('modal_msj', 'loading', 'Un momento mientras se almacenan los datos');
        if (validSub()) {
            var coordX = $('#coordX').val();
            var coordY = $('#coordY').val();
            var numSub = $('#numSub').val();
            var localizacion = $('#localizacion').val();
            var capacidad = $('#capacidad').val();
            var conexion = $('#conexion').val();
            var sub = coordX + '/|\\' + coordY + '/|\\' + numSub + '/|\\' + localizacion + '/|\\' + capacidad + '/|\\' + conexion;
            //alert(sub);
            //console.log(sub.split('/|\\'));
            var cct = $.cookie('cookieUCA');
            //alert(cct);
            //'tokenUCA': cct, 
            var request = $.ajax({
                url: "<?= base_url() ?>index.php/subestaciones/crear_sub",
                type: "POST",
                data: {'tokenUCA': cct, 'subData': sub},
                dataType: "json"
            });
            request.done(function(msg, status, XHR) {
                //var msj = '<?php echo $this->session->flashdata('msj');?>';
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
<?php echo form_open();?>
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
    <div class="params">

        <div class="prev-step">
        </div>
        <div class="finish-step">
            <input type="button" id="fin-sub" value="Finalizar" onclick="javascript:finalizaSub();"/>
        </div>
        <div class="next-step">
            <input type="button" id="next-sub" value="Siguiente >" onclick="javascript:nextStep();"/> 
        </div>
    </div>
</div>
<div id="trans-form">
    <div id="transformadores">
        <div id="trans_1" class="border-box">
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="noSerie">Numero de serie</label>
                </div>
                <div class="in-right">
                    <input type="input" id="noSerie" name="noSerie" />
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="capaTra">Capacidad</label>
                </div>
                <div class="in-right">
                    <input type="input" id="capaTra" name="capaTra">
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="fabricante">Fabricante</label>
                </div>
                <div class="in-right">
                    <input type="input" id="fabricante" name="fabricante" />
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="enfriamento">Enfriamento</label>
                </div>
                <div class="in-right">
                    <input type="input" id="enfriamento" name="enfriamento" />
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="impedancia">Impedancia</label>
                </div>
                <div class="in-right">
                    <input type="input" id="impedancia" name="impedancia" />
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="vPrimaria">Voltaje primario</label>
                </div>
                <div class="in-right">
                    <input type="input" id="vPrimaria" name="vPrimaria" />
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="vSecundario">Voltaje secundario</label>
                </div>
                <div class="in-right">
                    <input type="input" id="vSecundario" name="vSecundario" />
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="rTrans">Resistencia transformador</label>
                </div>
                <div class="in-right">
                    <input type="input" id="rTrans" name="rTrans" />
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="polaridad">Polaridad</label>
                </div>
                <div class="in-right">
                    <input type="input" id="polaridad" name="polaridad" />
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="aterriza">Aterrizamiento</label>
                </div>
                <div class="in-right">
                    <input type="input" id="aterriza" name="aterriza" />
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="pararrayos">Pararrayos</label>
                </div>
                <div class="in-right">
                    <input type="input" id="pararrayos" name="pararrayos" />
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="cuchillas">Cuchillas</label>
                </div>
                <div class="in-right">
                    <input type="input" id="cuchillas" name="cuchillas" />
                </div>
            </div>
            <div class="limpiar"></div>
        </div>

    </div>
    <div class="params" id="but-trans">
        <div class="prev-step">
            <input type="button" id="prev-sub" value="< Anterior" onclick="javascript:prevStep();"/>
        </div>
        <div class="finish-step">
            <input type="button" id="add-trans" value="Agregar Transformador" onclick="javascript:addTrans();"/>
        </div>
        <div class="next-step">
            <input type="button" id="fin-trans" value="Finalizar" onclick="javascript:finalizar();"/> 
        </div>
    </div>
</div>
<?php echo form_close();?>