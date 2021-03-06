<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="<?=base_url()?>css/style.css" rel="stylesheet" type="text/css" />
        <script src="<?=base_url()?>js/jquery-2.0.2.min.js"></script>
        <script src="<?=base_url()?>js/functions.js"></script>
        <script src="<?=base_url()?>js/jquery.blockUI.js"></script>
        <script type="text/javascript">
            function cambiar(){
                window.location.href = base_url + "index.php/cambioPassword";
            }
            window.onload = function() {
                <?php
                $msj = $this->session->flashdata('msj');
                if ($msj) {
                ?>
                    showMsg('modal_msj', 'aceptar', '<?php echo $msj; ?>');
                <?php
                }
                ?>
                $("#user").keypress(function(e) {
                    if(e.which == 13) {
                        submitLogin();
                    }
                });
                $("#password").keypress(function(e) {
                    if(e.which == 13) {
                        submitLogin();
                    }
                });
            };
        </script>
        <style type="text/css">
            h1{
                font-size: 22px;
                text-align: left;
                margin: 20px 0px;
            }
            h2{
                text-align: center;

                color: white;


            }
            #login{
                background: #333333;
                min-height: 300px;
                width: 40%;

            }
            #formulario_login{
                font-size: 14px;
                border: 0px solid #112233; 

            }
            label{
                display: block;
                font-size: 16px;
                color: #fff;
                font-weight: bold;
            }
            input[type=text],input[type=password]{
                padding: 10px 6px;
                width: 80%;
            }
            input[type=submit]{
                padding: 5px 40px;
                background: #61399d;
                color: #fff;
                width: 50%;
            }
            #campos_login{
                margin: 50px 20px;                 
            }
            p{
                color: #f00;
                font-weight: bold;
            }

            colores{
                background-color: #000000;
            }



        </style>
    </head>
    <body>
        <table width="100%" class="colores">
            <tr> 
                <td>
                    <?php

                    function getRealIP() {
                        if (!empty($_SERVER['HTTP_CLIENT_IP']))
                            return $_SERVER['HTTP_CLIENT_IP'];

                        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                            return $_SERVER['HTTP_X_FORWARDED_FOR'];

                        return $_SERVER['REMOTE_ADDR'];
                    }

                    //echo getRealIP();
                    $username = array('name' => 'username', 'placeholder' => 'nombre de usuario', 'maxlength' => '10', 'id'=>'user');
                    $password = array('name' => 'password', 'placeholder' => 'introduce tu password', 'maxlength' => '12', 'id'=>'password');
                    $submit = array('type' => 'button','value' => 'Iniciar sesión', 'title' => 'Iniciar sesión', 'onclick' => 'javascript:submitLogin();');
                    $cambio = array('type' => 'button', 'onclick' => 'javascript:cambiar();', 'value' => 'Cambiar password', 'title' => 'Cambiar password');
                    //'type' => 'button' 'name' => 'submit'
                    ?>

                    <br>    
                    <br>    

            <tr><td align="center">
                    <div id="prueba" class="prueba">
                        <h2>SISTEMA DE MONITOREO DE CALIDAD DE ENERGÍA UCA</h2>
                    </div>
                </td></tr>

            <tr><td align="center">
                    <div class="grid_12" id="login">
                        <div class="grid_8 push_2" id="formulario_login">

                            <div class="grid_6 push_1" id="campos_login">
                                <?= form_open(base_url() . 'index.php/login/new_user','id="loginForm"') ?>
                                <br>
                                <label for="username">Nombre de usuario:</label>
                                <?= form_input($username) ?><p><?= form_error('username') ?></p>
                                <label for="password">Introduce tu password:</label>
                                <?= form_password($password) ?><p><?= form_error('password') ?></p>
                                <?= form_input($submit) ?>
                                <?= form_submit($cambio) ?>
                                <?= form_close() ?>
                                <br />
                                <a href="<?php echo base_url('index.php/login/guest_login'); ?>">Iniciar como invitado</a>
                            </div>
                        </div>
                    </div>
                </td></tr>

            <tr><td align="center">
                    <div id="modal_msj" style="display:none; cursor: default;"> 

                    </div>  
                    <div id="footer"> Universidad Centroamericana "José Simeon Cañas"
                        <br>
                        2013 
                    </div>
                </td></tr>

        </tr>
    </td>
</table>
</body>
</html>