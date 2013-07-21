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
        $this->db->where('contrasena',$password);
        $query = $this->db->get('user');
        if($query->num_rows() == 1)
        {
            //echo 'TRUE';
            return $query->row();
        }else{
            //echo 'FALSE';
            $this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
            redirect(base_url().'login','refresh');
        }
    }
}

?>