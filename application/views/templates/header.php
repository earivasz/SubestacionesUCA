<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
    <link href="<?=base_url()?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>css/jqx.base.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/datePicker.css" />
    <script src="<?=base_url()?>js/jquery-2.0.2.min.js"></script>
    <script src="<?=base_url()?>js/jquery.cookie.js"></script>
    <script src="<?=base_url()?>js/functions.js"></script>
    <script src="<?=base_url()?>js/jquery.blockUI.js"></script>
</head>
<body>
    <div id="principal" class="centro">
        <div id="titulo">Monitoreo Subestaciones UCA</div>
        <div id="separacion_arriba"></div>
        <div id="menu">
            <div class="menu_item"><a href="www.bing.com">Inicio</a></div>
            <div class="menu_item"><a href="www.bing.com">Subestaciones</a></div>
            <div class="menu_item"><a href="www.bing.com">Usuarios</a></div>
            <div class="menu_item"><a href="<?php echo base_url("login/logout_ci"); ?>">Salir</a></div>
        </div>
        <div id="separacion_contenido"></div>
        
 <?php 
    function logout_ci()
    {
        $this->session->sess_destroy();
        $this->index();
    }
 ?>