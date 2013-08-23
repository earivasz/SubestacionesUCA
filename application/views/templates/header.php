<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Subestaciones UCA</title>
    <link href="<?=base_url()?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>css/styles_menu.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>css/jqx.base.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery-ui.css" />
    <script src="<?=base_url()?>js/jquery-2.0.2.min.js"></script>
    <script src="<?=base_url()?>js/jquery.cookie.js"></script>
    <script src="<?=base_url()?>js/functions.js"></script>
    <script src="<?=base_url()?>js/jquery.blockUI.js"></script>
</head>
<body>
    <div id="principal" class="centro">
        <div id="titulo">Monitoreo Subestaciones UCA</div>
        <div id="separacion_arriba"></div>
        <div id='cssmenu'>
            <ul>
               <li id="cssmenu1"><a href="<?=base_url()?>index.php/subestaciones"><span>Inicio</span></a></li>
               <?php 
                if($this->session->userdata('perfil') == '1'){
                    echo '
                <li id="cssmenu2" class="has-sub "><a href="#"><span>Subestaciones</span></a>
                    <ul>
                       <li><a href="' . base_url() . 'index.php/subestaciones/crear_sub"><span>Crear/modificar</span></a></li>
                       <li><a href="' . base_url() . 'index.php/subestaciones/crear_trans"><span>Crear/modificar transformadores</span></a></li>
                    </ul>
                 </li>
                 <li id="cssmenu3"><a href="' . base_url() . 'index.php/admin/usuarios"><span>Usuarios</span></a></li>
                 <li id="cssmenu4" class="has-sub "><a href="#"><span>Archivos</span></a>
                    <ul>
                       <li><a href="' . base_url() . 'index.php/archivos/mantenimiento"><span>Mantenimiento</span></a></li>
                    </ul>
                </li>
                <li><a href="' . base_url() . 'index.php/sistema/mod_sistema"><span>Sistema</span></a></li>';
                }
            ?>
               
               <li><a href="<?php echo base_url("index.php/login/logout_ci"); ?>"><span>Salir</span></a></li>
               <li class="nombreUsuario" style="<?php echo ($this->session->userdata('perfil') == '1') ? 'left:30px;' : 'left:450px;' ?>"><span>Usuario: <?php echo $this->session->userdata('nomUser') . ' ' . $this->session->userdata('apel') ?></span></li>
            </ul>
        </div>
        <div id="separacion_contenido"></div>
