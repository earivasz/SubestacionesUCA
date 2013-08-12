<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: isra
 * Date: 19/01/13
 * Time: 18:51
 * To change this template use File | Settings | File Templates.
 */
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->config->set_item('sess_expiration', '10');
        $this->load->model('login_model');
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','form'));
        $this->load->database('default');
        //$_SESSION['perfil']='';
    }
    
    public function index()
    {   
        switch ($this->session->userdata('perfil')) {
            case '':
                //$data['token'] = $this->token();
                //echo $data['token'].'<br/>';
                $data['titulo'] = 'Login con roles de usuario en codeigniter';
                $this->load->view('Login/login',$data);
                break;
            case '1':
                redirect(base_url()."index.php/subestaciones");
                break;
            case '2':
                redirect(base_url()."index.php/subestaciones");
                break;    
            case '3':
                redirect(base_url()."index.php/subestaciones");
                break;
            default:        
                $data['titulo'] = 'Login con roles de usuario en codeigniter';
                //$data['token'] = $this->token();
                //$this->load->view('Login/login',$data);
                echo 'default';
                break;        
        }
    }
    
    public function token()
    {
        $token = md5(uniqid(rand(),true));
        $this->session->set_userdata('token',$token);
        return $token;
    }
    
    public function new_user()
    {

            $this->form_validation->set_rules('username', 'nombre de usuario', 'required|trim|min_length[2]|max_length[150]|xss_clean');
            $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[5]|max_length[150]|xss_clean');
 
            //lanzamos mensajes de error si es que los hay
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('min_length', 'El %s debe tener al menos %s carácteres');
            $this->form_validation->set_message('max_length', 'El %s debe tener al menos %s carácteres');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
                //echo sha1($this->input->post('encriptar'));
            }else{
                $username = $this->input->post('username');
                $password = sha1($this->input->post('password'));
                $check_user = $this->login_model->login_user($username,$password);
                switch($check_user){
                    case 1:
                        $this->session->set_flashdata('msj', 'usuario inactivo');
                        //echo 'usuario inactivo';
                        break;
                    case 2:
                        $this->session->set_flashdata('msj', 'usuario bloqueado');
                        //echo 'usuario bloqueado';
                        break;
                    case 3:
                        $this->session->set_flashdata('msj', 'usuario bloqueado');
                        //echo 'usuario bloqueado';
                        break;
                    case 4:
                        $this->session->set_flashdata('msj', 'usuario o contraseña incorrecta');
                        //echo 'usuario o contraseña incorrecta';
                        break;
                    case 5:
                        $this->session->set_flashdata('msj', 'Debe cambiar su password por defecto');
                        redirect(base_url()."index.php/cambioPassword");
                        //echo 'Debe cambiar su password por defecto';
                        break;
                    default:
                        $this->index();
                        break;
                }
                redirect(base_url().'index.php');
            }
    }
 
    public function logout_ci()
    {
        $this->session->sess_destroy();
        $this->index();
    }
    
    public function renewSessionTime()
    {
        $this->session->sess_destroy();
        $this->index();
    }
    
    public function guest_login(){
        $data = array(
            'is_logued_in'   =>    TRUE,
            'id_usuario'     =>    '0',
            'perfil'         =>    '3',
            'username'       =>    'INVITADO'
        );        
        $this->session->set_userdata($data);
        $this->index();
    }
    
    public function admin_users(){
        
        if($this->session->userdata('perfil')=='1'){
            $data['usuarios'] = $this->login_model->get_users();
            $data['perfiles'] = $this->login_model->get_perfiles();
            $this->load->view('templates/header');
            $this->load->view('users/administracion', $data);
            $this->load->view('templates/footer');
            //print_r($data['perfiles']);
            //echo '<br><br><br>';
            //print_r(json_encode($data['usuarios']));
        }else{
            echo $this->session->userdata('perfil') . '<br/>';
            echo 'ola ke ase';
        }
    }
    
    public function get_data(){
        return $this->login_model->get_users();
    }
    
    public function crear_user(){
        $this->form_validation->set_rules('usuario', '"Usuario"', 'required');
        $this->form_validation->set_rules('nomUser', '"Nombre"', 'required');
        $this->form_validation->set_rules('apel', '"Apellido"', 'required');
        $this->form_validation->set_rules('correo', '"Correo"', 'required');
        $this->form_validation->set_rules('estado', '"Estado"', 'required');
        $this->form_validation->set_rules('perfil', '"Perfil"', 'required');
        $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->admin_users();
        }else{
            $isMod = $this->input->post('isMod');
            
            if($isMod == 'True'){
                $data = array(
                    'nomUser' => $this->input->post('nomUser'),
                    'apel' => $this->input->post('apel'),
                    'usuario' => $this->input->post('usuario'),
                    'correo' => $this->input->post('correo'),
                    'estado' => $this->input->post('estado'),
                    'idPerfil' => $this->input->post('perfil')
                );
                $result = $this->login_model->update_user($data);
            }else{
                $data = array(
                    'idUser' => null,
                    'nomUser' => $this->input->post('nomUser'),
                    'apel' => $this->input->post('apel'),
                    'usuario' => $this->input->post('usuario'),
                    'contrasena' => sha1('subUCA'),
                    'correo' => $this->input->post('correo'),
                    'estado' => $this->input->post('estado'),
                    'ultimoIngreso' => null,
                    'idPerfil' => $this->input->post('perfil')
                );
                $result = $this->login_model->create_user($data);
            }
            redirect(base_url()."index.php/admin/usuarios");
        }
    
    }
    
    public function cambioPassword(){
        $this->load->view('Login/cambioPass');
    }
    
    public function cambio_pass(){
        //logica de cambio de password
        try{
            $this->login_model->cambio_pass();
            redirect(base_url()."index.php/cambioPassword");
        }catch(Exception $e){
            $this->session->set_flashdata('msj', 'Ocurrio un problema para actualizar su usuario, favor intente de nuevo.');
            redirect(base_url()."index.php/cambioPassword");
        }
    }
}
?>