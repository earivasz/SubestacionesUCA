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

<script>

    var chart;
    var arreglo_completo = new Array();
    var arreglo_pag = new Array();
    var myGrid;
    window.onload = function() {
        //******************CARGA DE TABLA
        $("#usuario").attr('readonly', 'readonly');
        arreglo_completo = <?php echo json_encode($archivos); ?>;
        //AQUI IBA EL CODIGO DEL GRID ANTERIOR

        //var theme = getDemoTheme();

        var source =
                {
                    localdata: arreglo_completo,
                    datatype: "array"
                };

        $("#jqxgrid").jqxGrid(
                {
                    width: 770,
                    source: source,
                    showfilterrow: true,
                    pageable: true,
                    autoheight: true,
                    columnsresize: true,
                    filterable: true,
                    columns: [
                        {text: 'Subestacion', datafield: 'localizacion', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Nombre', datafield: 'nombreArchivo', width: 200, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Fecha creacion', datafield: 'fechaCreacion', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Notas', datafield: 'notasTabla', width: 200, cellsalign: 'right', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Tipo', datafield: 'tipo', width: 85, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Estado', datafield: 'nomEstado', width: 85, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'}
                    ]
                });

        $("#jqxgrid").bind('rowselect', function(event) {
            var row = event.args.rowindex;
            var datarow = $("#jqxgrid").jqxGrid('getrowdata', row);
            $("#subest").val(datarow.localizacion);
            $("#tipArch").val(datarow.tipo);
            $("#nomArch").val(datarow.nombreArchivo);
            $("#fecCrea").val(datarow.fechaCreacion);
            $("#notas").val(datarow.notasTabla);
            if(datarow.activo == 1){
                $('#activo').prop('checked',true);
            }else{
                $('#activo').prop('checked',false);
            }
            $('#correlTabla').val(datarow.correlTabla);
            $('#idSub').val(datarow.idSubestacion);
        });

        //MUESTRO MENSAJE SI HA SIDO SETEADO UN FLASHDATA
<?php
$msj = $this->session->flashdata('msj');
if ($msj) {
    ?>
            showMsg('modal_msj', 'aceptar', '<?php echo $msj; ?>');
    <?php
}
?>
    };

function validArch() {
        var idSub = $('#idSub').val();
        var correl = $('#correlTabla').val();
        var msj = '';
        if (idSub === '' || correl === '') {
            msj = msj + 'Debe seleccionar un archivo para realizar los cambios';
        }

        if (msj !== '') {
            showMsg('modal_msj', 'aceptar', msj);
            return false;
        } else {
            showMsg('modal_msj', 'loading', 'Un momento mientras el archivo esta siendo modificado');
            $("#archForm").submit();
            return true;
        }
    }
</script>
<!--<h2 align="center">MANTENIMIENTO USUARIOS</h2>-->
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
    input[readonly="readonly"]{
        padding-left: 10px;
    }
</style>
<div align="center" id='jqxWidget'>         
    <h2>ARCHIVOS</h2>
    <div align="center" style="width:100%; height: 700px;" id="jqxgrid"></div>
</div>
<br/>
<?php echo form_open('archivos/set_archivo','id=archForm', array('origenCorrecto' => true)); ?>
<div id="arch-form">
    <input type="hidden" name="correlTabla" id="correlTabla"/>
    <input type="hidden" name="idSub" id="idSub"/>
    <div style="text-align:center;width: 100%;" id="sub-params">
        <div class="params">
            <div class="lbl-left">
                <?php echo form_label('Subestacion:', 'subest');?>
            </div>
            <div class="in-right">
                <?php echo form_input(array('name' => 'subest', 'type' => 'text', 'id' => 'subest', 'readonly' => 'readonly')); ?>
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <?php echo form_label('Tipo de archivo:', 'tipArch');?>
            </div>
            <div class="in-right">
                <?php echo form_input(array('name' => 'tipArch', 'type' => 'text', 'id' => 'tipArch', 'readonly' => 'readonly')); ?>
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <?php echo form_label('Nombre Archivo:', 'nomArch'); ?>
            </div>
            <div class="in-right">
                <?php echo form_input(array('name' => 'nomArch', 'type' => 'text', 'id' => 'nomArch', 'readonly' => 'readonly')); ?>
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <?php echo form_label('Fecha creacion:', 'fecCrea'); ?>
            </div>
            <div class="in-right">
                <?php echo form_input(array('name' => 'fecCrea', 'type' => 'text', 'id' => 'fecCrea', 'readonly' => 'readonly')); ?>
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <?php echo form_label('   Notas:', 'notas'); ?>
            </div>
            <div class="in-right">
                <textarea name="notas" id="notas" rows="4" cols="14"></textarea>
            </div>
        </div>
        <div class="limpiar"></div>
        <div class="params">
            <div class="lbl-left">
                <?php ?>
                <label for="activo">Activo</label>
            </div>
            <div class="in-right">
                <?php ?>
                <input type="checkbox" name="activo" id="activo" value="1" checked="checked">
            </div>
        </div>
        
    </div>
    <?php echo validation_errors(); ?>
    <div class="params">

        <div class="prev-step">
        </div>
        <div class="finish-step">
            <input type="button" id="fin-sub" value="Guardar" onclick="javascript:validArch();"/>
        </div>
        <div class="next-step">
            <!--<input type="button" id="next-sub" value="Siguiente >" onclick="javascript:nextStep();"/>-->
        </div>
    </div>
</div>
<?php echo form_close(); ?>