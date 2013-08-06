<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.selection.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.columnsresize.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxdata.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.pager.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxcheckbox.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxlistbox.js"></script> 
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxdata.export.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/jqxgrid.export.js"></script>
<script type="text/javascript" src="<?= base_url() ?>jqwidgets/gettheme.js"></script>

<script>

    var chart;
    var arreglo_completo = new Array();
    var arreglo_pag = new Array();
    var myGrid;
    window.onload = function() {
        //******************CARGA DE TABLA
        $("#usuario").attr('readonly', 'readonly');
        arreglo_completo = <?php echo json_encode($cargas); ?>;

        var source =
                {
                    localdata: arreglo_completo,
                    datatype: "array"
                };

        $("#jqxgrid").jqxGrid(
                {
                    width: 900,
                    source: source,
                    showfilterrow: true,
                    pageable: true,
                    autoheight: true,
                    filterable: true,
                    columns: [
                        {text: 'Edificio', datafield: 'edificio', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Tipo de carga', datafield: 'tipoCarga', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Cantidad', datafield: 'cantidad', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Corriente', datafield: 'corriente', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Voltaje', datafield: 'voltaje', width: 10, cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Fase', datafield: 'fase', width: 10, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'FP', datafield: 'fp', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Especificacion', datafield: 'especificacion', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Accesorio', datafield: 'accesorio', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Notas', datafield: 'notasCargas', width: 10, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'}
                    ]
                });
        $("#jqxgrid").jqxGrid('autoresizecolumns');
        $("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'jqxGrid');           
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
</script>
<h2 style="width:100%; text-align: center;">CARGAS DE SUBESTACION <?php echo $subest[0]['numSubestacion'] . ', ' . $subest[0]['localizacion'];?></h2>
    <div style="text-align: right; width: 100%;">
        <div align="center" id='jqxWidget' style="text-align: center;">
    <div align="center" style="width:100%; height: 700px;" id="jqxgrid"></div>
    <input type="button" value="Exportar a Excel" id='excelExport' />
    </div>

</div>