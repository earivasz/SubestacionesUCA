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
        
        public function get_subest($id)
        {
            $query = $this->db->get_where('subestacion',array('idSubestacion' => $id));
            //$query = $this->db->query('select * from subestuca.subestacion where idSubestacion = ' . $id );
            return $query->result_array();   
        }
        
        public function get_transformadores($id)
        {
            $query = $this->db->get_where('transformador',array('idSubestacion' => $id));
            return $query->result_array();
        }
        
        public function get_fotosSubest($id)
        {
            $query = $this->db->get_where('foto',array('idSubestacion' => $id));
            return $query->result_array();
        }
        
        public function get_tablaPrincipal($idSubest, $fechaInicio, $fechaFin)
        {
            //tengo que filtrar por fecha, el filtrador por fase se hace en la vista
            $query = $this->db->get_where('datop');
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
                'activo' => $this->input->post('activo')
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
