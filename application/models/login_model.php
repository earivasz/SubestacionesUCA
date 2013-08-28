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
            //echo $password . '<br/>';
            //echo $user->contrasena;
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
            
            /*if(sha1("subUCA13")==$user->contrasena && $user->estado == 'A'){
                //proceso de cambio de contra por defecto
                return 5;
            }*/
            
            if($password==$user->contrasena && $user->estado == 'A'){
                //update ultimo ingreso
                $this->db->where('usuario',$username);
                $this->db->update('user',array('intentos'=>0,'ultimoIngreso'=>date('Y-m-d H:i:s')));
                //setear session
                if(sha1("subUCA13")==$user->contrasena && $user->estado == 'A'){
                //proceso de cambio de contra por defecto
                    return 5;
                }
                $data = array(
                'is_logued_in'=>TRUE,
                'id_usuario'=>$user->idUser,
                'perfil'=>$user->idPerfil,
                'username'=>$user->usuario,
                'nomUser'=>$user->nomUser,
                'apel'=>$user->apel
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
            redirect(base_url().'index.php/login');
        }
    }

    public function get_users(){
        $query = 'SELECT user.* , CASE when estado = "B" then "BLOQUEADO" when estado = "A" then "ACTIVO" when estado = "I" THEN "INACTIVO" END as nomEstado, perfil.tipoPerfil  FROM user inner join perfil ON user.idPerfil = perfil.idPerfil;';
        $usuarios = $this->db->query($query);
        //$usuarios = $this->db->get('user');
        return $usuarios->result_array();
    }
    
    public function get_perfiles(){
        $perfiles = $this->db->get('perfil');
        return $perfiles->result_array();
    }
    
    public function create_user($datos){
        $query = $this->db->get_where('user', array('usuario'=>$datos['usuario']));
        $count = $query->num_rows();
        if($count > 0){
            $this->session->set_flashdata('msj', 'El usuario '. $datos['usuario']. ' ya existe');
            return false;
        }else{
            $insert = $this->db->insert('user',$datos);
            if($insert){
                $this->session->set_flashdata('msj', 'Usuario creado correctamente');
                return true;
            }else{
                $this->session->set_flashdata('msj', 'Usuario no pudo ser creado');
                return false;
            }
        }
    }
    
    public function update_user($datos){
        $this->db->where('usuario',$datos['usuario']);
        $query = $this->db->update('user',$datos);
        if($query > 0){
            $this->session->set_flashdata('msj', 'Usuario actualizado correctamente.');
            return true;
        }else{
            $this->session->set_flashdata('msj', 'No se pudo actualizar el usuario.');
            return false;
        }
    }
    
    public function cambio_pass(){
        $usuario= $this->input->post('username');
        $newPass = $this->input->post('newPass');
        $oldPass = $this->input->post('password');
        $data = array(
                'usuario'=> $usuario,
                'contrasena'=> sha1($oldPass)
                );
        $query = $this->db->get_where('user',$data);
        $count = $this->db->count_all_results();
        if($count > 0){
            //logica de cambio de password
            $data = array(
                'contrasena'=> sha1($newPass)
                );
            $this->db->where('usuario',$usuario);
            $query = $this->db->update('user',$data);
            if($query > 0){
                $this->session->set_flashdata('msj', 'Usuario actualizado correctamente.');
                return true;
            }else{
                $this->session->set_flashdata('msj', 'No se pudo actualizar el usuario.');
                return false;
            }
        }else{
            $this->session->set_flashdata('msj', 'Usuario o contraseña incorrectos.');
            return false;
        }
    }
    
}
?>