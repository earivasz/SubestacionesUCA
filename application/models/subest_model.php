<?php
class Subest_model extends CI_Model {
        
	public function __construct()
	{
            $this->load->database();
	}
        
        public function get_subestaciones()
        {
            $query = $this->db->get_where('subestacion',array('activo' => '1'));
            return $query->result_array();
        }
        
        public function get_subest($id=1)
        {
            $query = $this->db->get_where('subestacion',array('idSubestacion' => $id));
            return $query->result_array();
        }
        
}
?>
