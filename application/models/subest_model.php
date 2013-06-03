<?php
class Subest_model extends CI_Model {

	public function __construct()
	{
            $this->load->database();
	}
        
        public function get_subestaciones()
        {
            $query = $this->db->get('subestacion');
            return $query->result_array();
        }
        
}
?>
