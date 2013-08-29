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
<script type="text/javascript">
    var numTrans = 1;
    var numId= 1;
    window.onload = function() {
        arreglo_completo = <?php echo json_encode($trans); ?>;
        //AQUI IBA EL CODIGO DEL GRID ANTERIOR
        console.log(arreglo_completo);
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
            columnsresize: true,
            columns: [
                {text: 'Subestacion', datafield: 'localizacion', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Numero de serie', datafield: 'noSerie', width: 125, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Capacidad', datafield: 'capacidad', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Fabricante', datafield: 'fabricante', width: 125, cellsalign: 'right', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Enfriamiento', datafield: 'enfriamiento', width: 80, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Impedancia', datafield: 'impedancia', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Voltaje primaria', datafield: 'vPrimaria', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Voltaje secundario', datafield: 'vSecundario', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Transformacion', datafield: 'rTransformacion', width: 80, cellsalign: 'right', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Polaridad', datafield: 'polaridad', width: 120, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Aterrizamiento', datafield: 'nomAterr', width: 80, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Pararrayos', datafield: 'nomPara', width: 80, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Cuchillas', datafield: 'nomCuchillas', width: 80, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                {text: 'Estado', datafield: 'nomActivo', width: 80, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'}
            ]
        });
        
        $('#capaTra').keyup(function() {
            var $th = $(this);
            $th.val( $th.val().replace(/[^0-9.]/g, function(str) { return ''; } ) );
        });
        
        $('#capaTra').blur(function() {
            var $th = $(this);
            var valor = parseFloat($th.val());
            if(isNaN(valor)){
                $th.val('');
            }else{
                $th.val(valor);
            }
            
        });
        
        $('.trimI').blur(function(){
            var $th = $(this);
            var valor = $.trim($th.val());
            $th.val(valor);
        });
        
        $("#jqxgrid").jqxGrid('autoresizecolumns');
        
        $("#jqxgrid").bind('rowselect', function(event) {
            var row = event.args.rowindex;
            var datarow = $("#jqxgrid").jqxGrid('getrowdata', row);
            //$("#idSub").prop('disabled', true);
            $("#idSub").val(datarow.idSubestacion);
            $("#noSerie").val(datarow.noSerie);
            $("#capaTra").val(datarow.capacidad);
            $("#fabricante").val(datarow.fabricante);
            $("#enfriamiento").val(datarow.enfriamiento);
            $("#impedancia").val(datarow.impedancia);
            $("#vPrimaria").val(datarow.vPrimaria);
            $("#vSecundario").val(datarow.vSecundario);
            $("#rTrans").val(datarow.rTransformacion);
            $("#polaridad").val(datarow.polaridad);
            if(datarow.aterrizamiento === '1'){
                $('#aterriza').prop('checked',true);
            }else{
                $('#aterriza').prop('checked',false);
            } 
            
            if(datarow.pararrayos === '1'){
                $('#pararrayos').prop('checked',true);
            }else{
                $('#pararrayos').prop('checked',false);
            } 
            
            if(datarow.cuchillas === '1'){
                $('#cuchillas').prop('checked',true);
            }else{
                $('#cuchillas').prop('checked',false);
            }    
            $("#correl").val(datarow.correlTransformador);
            if(datarow.activoTrans === '1'){
                $('#activo').prop('checked',true);
            }else{
                $('#activo').prop('checked',false);
            }
            $("#activo").val(datarow.activo);
            $("#isMod").val('True');
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

    function validTrans(){
        var numParams = 0;
        $('div[id^="trans_"]').each(function(){
            var idDiv=$(this).attr('id');
            numParams = 0;
            $('#'+idDiv+' :input[type="input"]').each(function(){
                var valor = $.trim($(this).val());
                var id = $(this).attr('id');
                if (id=='capaTra' && valor!=''){
                    
                }
                if(valor!==''){
                    numParams++;
                }
            });
            if(numParams===0 || $("#idSub").val()=== ''){
                if($("#idSub").val()=== ''){
                    showMsg('modal_msj', 'aceptar', 'Debe seleccionar una subestacion para poder crear un transformador.');
                }else{
                    showMsg('modal_msj', 'aceptar', 'Debe completar al menos un campo para crear un transformador.');
                }
                return false;
            }else{
                showMsg('modal_msj', 'loading', 'Un momento mientras se procesa su solicitud');
                $("#transForm").submit();
                return true;
            }
        });
        
    }
    
    function crear_trans() {
        //$("#idSub").prop('disabled', false);
        $("#idSub").val('');
        $("#noSerie").val('');
        $("#capaTra").val('');
        $("#fabricante").val('');
        $("#impedancia").val('');
        $("#enfriamiento").val('');
        $("#vPrimaria").val('');
        $("#vSecundario").val('');
        $("#rTrans").val('');
        $("#polaridad").val('');
        $("#aterriza").prop('checked',false);
        $("#pararrayos").prop('checked',false);
        $("#cuchillas").prop('checked',false);
        $("#isMod").val('False');
        $('#activo').prop('checked',true);
        $("#activo").val('1');
    }
    
    function setCheck(){
        if($('#activo').val() === '1'){
            $('#activo').val('0');
        }else{
            $('#activo').val('1');
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

<div align="center" id='jqxWidget'>  
    <br>
    <h2>TRANSFORMADORES</h2>
    <br>
    <div align="center" style="width:100%;" id="jqxgrid"></div>
</div>
<br/>
<div class="errores_form">
    <?php
        echo validation_errors();
    ?>
    </div>
<?php

    echo form_open('subestaciones/set_trans','id=transForm', array('origenCorrecto' => true));
?>
<input type="hidden" name="isMod" id="isMod" value="False"/>
<input type="hidden" name="correl" id="correl" value="False"/>
<div id="trans-form">
    <div id="transformadores">      
        <div id="trans_1">
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="idSub">Subestacion</label>
                </div>
                <div class="in-right">
                    <select name="idSub" id="idSub">
                        <option value="">----Seleccione una subestacion----</option>
                        <?php foreach ($subs as $subest_item): ?>
                        <option value="<?php echo $subest_item['idSubestacion'] ?>"><?php echo $subest_item['localizacion'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="noSerie">Numero de serie</label>
                </div>
                <div class="in-right">
                    <input type="input" id="noSerie" name="noSerie" value="<?php echo set_value('noSerie'); ?>" maxlength="25" class="trimI"/>
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="capaTra">Capacidad</label>
                </div>
                <div class="in-right">
                    <input type="input" id="capaTra" name="capaTra" value="<?php echo set_value('capaTra'); ?>">
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="fabricante">Fabricante</label>
                </div>
                <div class="in-right">
                    <input type="input" id="fabricante" name="fabricante" value="<?php echo set_value('fabricante'); ?>" maxlength="55" class="trimI"/>
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="enfriamiento">Enfriamento</label>
                </div>
                <div class="in-right">
                    <input type="input" id="enfriamiento" name="enfriamiento" value="<?php echo set_value('enfriamiento'); ?>" maxlength="25" class="trimI"/>
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="impedancia">Impedancia</label>
                </div>
                <div class="in-right">
                    <input type="input" id="impedancia" name="impedancia" value="<?php echo set_value('impedancia'); ?>" maxlength="25" class="trimI"/>
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="vPrimaria">Voltaje primario</label>
                </div>
                <div class="in-right">
                    <input type="input" id="vPrimaria" name="vPrimaria" value="<?php echo set_value('vPrimaria'); ?>" maxlength="30" class="trimI"/>
                </div>
            </div>
            
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="vSecundario">Voltaje secundario</label>
                </div>
                <div class="in-right">
                    <input type="input" id="vSecundario" name="vSecundario" value="<?php echo set_value('vSecundario'); ?>" maxlength="30" class="trimI"/>
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="rTrans">Relacion de transformacion</label>
                </div>
                <div class="in-right">
                    <input type="input" id="rTrans" name="rTrans" value="<?php echo set_value('rTrans'); ?>"  maxlength="15" class="trimI"/>
                </div>
            </div>
            
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="polaridad">Polaridad</label>
                </div>
                <div class="in-right">
                    <input type="input" id="polaridad" name="polaridad" value="<?php echo set_value('polaridad'); ?>" maxlength="20" class="trimI"/>
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="aterriza">Aterrizamiento</label>
                </div>
                <div class="in-right">
                    <input type="checkbox" name="aterriza" id="aterriza" value="1" checked="checked">
                    <!--<input type="input" id="aterriza" name="aterriza" />-->
                </div>
            </div>
            
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="pararrayos">Pararrayos</label>
                </div>
                <div class="in-right">
                    <input type="checkbox" name="pararrayos" id="pararrayos" value="1" checked="checked">
                    <!--<input type="input" id="pararrayos" name="pararrayos" />-->
                </div>
            </div>
            <div class="limpiar"></div>
            <div class="params-tra-left">
                <div class="lbl-left">
                    <label for="cuchillas">Cuchillas</label>
                </div>
                <div class="in-right">
                    <input type="checkbox" name="cuchillas" id="cuchillas" value="1" checked="checked">
                    <!--<input type="input" id="cuchillas" name="cuchillas" />-->
                </div>
            </div>
            <div class="params-tra-right">
                <div class="lbl-left">
                    <label for="activo">Activo</label>
                </div>
                <div class="in-right">
                    <input type="checkbox" name="activo" id="activo" value="1" checked="checked">
                </div>
            </div>
            
            <div class="limpiar"></div>
        </div>

    </div>
    <div class="params" id="but-trans">
        <div class="finish-step">
            <input type="button" id="crear-sub" value="Limpiar" onclick="javascript:crear_trans();" style="width:100px;"/>
            <input type="button" id="add-trans" value="Guardar" onclick="javascript:validTrans();" style="width:100px;"/>
        </div>
        <div class="next-step">
            <!--<input type="button" id="fin-trans" value="Finalizar" onclick="javascript:validTrans();"/>-->
        </div>
    </div>
</div>
<?php
echo form_close();
?>