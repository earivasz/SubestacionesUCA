<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Login_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login_user($username,$password)
    {
        $this->db->where('usuario',$username);
        //$this->db->where('contrasena',$password);
        $query = $this->db->get('user');
        if($query->num_rows() == 1)
        {
            //echo 'TRUE';
            $user = $query->row();
            if($user->estado == 'I'){
                //realizar proceso de usuario inactivo
                return 1;
            }
            
            if($user->estado == 'B'){
                //realizar proceso de usuario bloquedo
                return 2;
            }
            
            if($user->intentos > 3){
                //bloquear usuario
                $this->db->where('usuario',$username);
                $this->db->update('user',array('estado'=>'B'));
                return 3;
            }
            
            if($password==$user->contrasena && $user->estado == 'A'){
                //update ultimo ingreso
                $this->db->where('usuario',$username);
                $this->db->update('user',array('intentos'=>0,'ultimoIngreso'=>date('Y-m-d H:i:s')));
                //setear session
                $data = array(
                'is_logued_in'=>TRUE,
                'id_usuario'=>$user->idUser,
                'perfil'=>$user->idPerfil,
                'username'=>$user->usuario
                );        
                $this->session->set_userdata($data);
                return 0;  
            }else{
                //aumentar intentos
                $this->db->where('usuario',$username);
                $this->db->update('user',array('intentos'=> $user->intentos + 1));
                return 4;
            }
        }else{
            //echo 'FALSE';
            //$this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
            redirect(base_url().'login','refresh');
        }
    }
}

?>