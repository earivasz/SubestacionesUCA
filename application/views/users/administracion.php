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
        arreglo_completo = <?php echo json_encode($usuarios); ?>;
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
                    filterable: true,
                    columnsresize: true,
                    columns: [
                        {text: 'Usuario', datafield: 'usuario', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Nombre', datafield: 'nomUser', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Apellido', datafield: 'apel', width: 100, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Correo', datafield: 'correo', width: 80, cellsalign: 'right', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Estado', datafield: 'nomEstado', width: 90, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Ultimo ingreso', datafield: 'ultimoIngreso', width: 175, cellsalign: 'right', cellsformat: 'c2', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'},
                        {text: 'Perfil', datafield: 'tipoPerfil', width: 125, columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with'}
                    ]
                });
                
                $("#jqxgrid").jqxGrid('autoresizecolumns');
                
        $("#jqxgrid").bind('rowselect', function(event) {
            var row = event.args.rowindex;
            var datarow = $("#jqxgrid").jqxGrid('getrowdata', row);
            $("#usuario").attr('readonly', 'readonly');
            $("#usuario").val(datarow.usuario);
            $("#nomUser").val(datarow.nomUser);
            $("#apel").val(datarow.apel);
            $("#correo").val(datarow.correo);
            $("#estado").val(datarow.estado);
            $("#perfil").val(datarow.idPerfil);
            $("#isMod").val('True');
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
    //VACIAR CAMPOS Y SETEAR VARIABLE DE MODIFICAR EN FALSE
    function crear_user() {
        $("#usuario").removeAttr('readonly');
        $("#usuario").val('');
        $("#nomUser").val('');
        $("#apel").val('');
        $("#correo").val('');
        $("#estado").val('');
        $("#perfil").val('');
        $("#isMod").val('False');
    }
    
    function submit_user(){
        var user= $.trim($("#usuario").val()); 
        var nombre = $.trim($("#nomUser").val()); 
        var apellido = $.trim($("#apel").val()); 
        var correo = $.trim($("#correo").val()); 
        var estado = $.trim($("#estado").val()); 
        var perfil = $.trim($("#perfil").val());
        var band = 0;
        var msj = '';
        if(user==''){
            msj = msj +'<li>Debe colocar un usuario</li>';
            band = 1;
        }else{
            if(!validUser(user)){
                msj = msj + '<li>Verifique el formato de su usuario</li>';
                band = 1;
            }
        }
        if(nombre==''){
            msj = msj +'<li>Debe colocar un nombre</li>';
            band = 1;
        }
        if(apellido==''){
            msj = msj +'<li>Debe colocar un apellido</li>';
            band = 1;
        }
        if(correo==''){
            msj = msj +'<li>Debe colocar un correo</li>';
            band = 1;
        }
        if(estado==''){
            msj = msj +'<li>Debe elegir un estado</li>';
            band = 1;
        }
        if(perfil==''){
            msj = msj +'<li>Debe elegir un perfil</li>';
            band = 1;
        }
        
        if(band==1){
            showMsg('modal_msj', 'aceptar', '<ul>' + msj + '</ul>');
            return false;
        }else{
            showMsg('modal_msj', 'loading', 'Un momento mientras se procesa su solicitud');
            $("#userForm").submit();
            return true;
        }
        
    }
</script>
<!--<h2 align="center">MANTENIMIENTO USUARIOS</h2>-->

    <div align="left" id="formUsers">
        
      
       <table width="100%" align="center" id="tabla_usuario" border="0">
           <td align="center" colspan="3">
           <h2>LISTA DE USUARIOS</h2>   </td></tr>
   <tr><td  colspan="3">
   <div align="center" id='jqxWidget'>
               
    <div align="center" style="width:100%; height: 700px;" id="jqxgrid"></div>
    <h2>DATOS DE USUARIOS</h2>
    </div>
    </td>
            
        <?php
        echo '<tr><td width=40%">';
        echo form_open('login/crear_user', 'id="userForm"');
        echo '</td><td width="5%"></td><td width="55%">';
        echo form_input(array('name' => 'isMod', 'type' => 'hidden', 'id' => 'isMod', 'value' => 'False'));
        echo '</td><td></td></tr><tr align="right"><td>';
        echo form_label('Usuario:', 'usuario');
        echo '</td></td><td><td align="left">';
        echo form_input(array('name' => 'usuario', 'type' => 'text', 'id' => 'usuario'));
        echo '</td><td></td></tr><tr  align="right"><td>';
        echo form_label('Nombre:', 'nomUser');
        echo '</td></td><td><td align="left">';
        echo form_input(array('name' => 'nomUser', 'type' => 'text', 'id' => 'nomUser'));
        echo '</td><td></td></tr><tr  align="right"><td>';
        echo form_label('Apellido:', 'apel');
        echo '</td></td><td><td align="left">';
        echo form_input(array('name' => 'apel', 'type' => 'text', 'id' => 'apel'));
       echo '</td><td></td></tr><tr  align="right"><td>';
        echo form_label('Correo:', 'correo');
        echo '</td></td><td><td align="left">';
        echo form_input(array('name' => 'correo', 'type' => 'text', 'id' => 'correo'));
        echo '</td><td></td></tr><tr  align="right"><td>';
        echo form_label('Estado:', 'estado');
        echo '</td></td><td><td align="left">';
        $options = array(
            '' => 'Seleccione una opcion',
            'A' => 'ACTIVO',
            'B' => 'BLOQUEADO',
            'I' => 'INACTIVO'
        );
        echo form_dropdown('estado', $options, '', 'id="estado"');
        echo '</td><td></td></tr><tr align="right"><td>';
        echo form_label('Perfil:', 'perfil');
        echo '</td></td><td><td align="left">';
        echo '<select name="perfil" id="perfil">';
        echo '<option value="" id="perfil">Seleccione una opcion</option>';
        foreach ($perfiles as $perfil):
            if($perfil['tipoPerfil'] != 'INVITADO'){
                echo '<option value="' . $perfil['idPerfil'] . '">' . $perfil['tipoPerfil'] . '</option>';
            }
        endforeach;
        echo '</select> </td><td></td></tr><tr><td colspan="3">&nbsp;</td></tr><tr align="left"><td  colspan="2"></td><td>';
        echo form_button('crear', 'Crear', 'id="crear" onclick="javascript:crear_user();"');
        echo form_button('save', 'Guardar', 'id="guardar" onclick="javascript:submit_user();"');
        echo '</td></tr>';
        echo form_close();
        ?>
        
        
   </table>

</div>