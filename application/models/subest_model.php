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
        
        public function mod_subest($id)
        {    
            if($this->input->post('localizacion')==''){
                $localizacion = null;
            }else{
                $localizacion = $this->input->post('localizacion');
            }
            
            if($this->input->post('capacidad')==''){
                $capacidad = null;
            }else{
                $capacidad = $this->input->post('capacidad');
            }
            
            
            if($this->input->post('conexion')==''){
                $conexion = null;
            }else{
                $conexion = $this->input->post('conexion');
            }
            
            $data = array(
              'coordX' => $this->input->post('coordX'),
                'coordY' => $this->input->post('coordY'),
                'numSubestacion' => $this->input->post('numSub'),
                'localizacion' => $localizacion,
                'capacidad' => $capacidad,
                'conexion' => $conexion,
                'activo' => 1
            );
            
            $this->db->where('idSubestacion', $id);
            $this->db->update('subestacion', $data);
            
            return ($this->db->affected_rows() != 1) ? false : true;
        }
        
        public function set_subest()
        {    
            if($this->input->post('localizacion')==''){
                $localizacion = null;
            }else{
                $localizacion = $this->input->post('localizacion');
            }
            
            if($this->input->post('capacidad')==''){
                $capacidad = null;
            }else{
                $capacidad = $this->input->post('capacidad');
            }
            
            
            if($this->input->post('conexion')==''){
                $conexion = null;
            }else{
                $conexion = $this->input->post('conexion');
            }
            
            $data = array(
              'coordX' => $this->input->post('coordX'),
                'coordY' => $this->input->post('coordY'),
                'numSubestacion' => $this->input->post('numSub'),
                'localizacion' => $localizacion,
                'capacidad' => $capacidad,
                'conexion' => $conexion,
                'activo' => 1
            );
            
            $this->db->insert('subestacion', $data);
            
            return ($this->db->affected_rows() != 1) ? false : true;
        }
        
}
?>
