<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/960.css" media="screen" />
         <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/text.css" media="screen" />
         <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/reset.css" media="screen" />
         <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/style.css" media="screen" />
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
                 width: 400px;
             }
             input[type=submit]{
                 padding: 5px 40px;
                 background: #61399d;
                 color: #fff;
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
    $username = array('name' => 'username', 'placeholder' => 'nombre de usuario');
    $password = array('name' => 'password',    'placeholder' => 'introduce tu password');
    $submit = array('name' => 'submit', 'value' => 'Iniciar sesión', 'title' => 'Iniciar sesión');
    ?>
     
    <tr><td align='center'>
    <div id="titulo" class="titulo">
       
       <img height="15%" width="25%" src= "../../img/uca.jpg" />
    </div>
    </td></tr>
    
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
                    <?=form_open(base_url().'index.php/login/new_user')?>
                    <br>
                    <label for="username">Nombre de usuario:</label>
                    <?=form_input($username)?><p><?=form_error('username')?></p>
                    <label for="password">Introduce tu password:</label>
                    <?=form_password($password)?><p><?=form_error('password')?></p>
                    
                    <?=form_submit($submit)?>
                    <?=form_close()?>
                    <br />
                    <a href="<?php echo base_url('index.php/login/guest_login');?>">Iniciar como invitado</a>
                </div>
            </div>
        </div>
    </td></tr>
    
    <tr><td align="center">
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