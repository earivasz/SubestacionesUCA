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
            $query = $this->db->get_where('transformador',array('idSubestacion' => $id, 'activoTrans' => '1'));
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
            $query = $this->db->query("select DATE_FORMAT(t.fechaHora, '%d/%m/%Y %H:%i:%s') as fechaHora, p.datop from subestuca.datop p inner join subestuca.tiempo t on p.idTiempo = t.idTiempo 
                where idSubestacion = " . $idSubest .  
                " AND t.fechaHora BETWEEN STR_TO_DATE('" . $fechaInicio . "', '%d/%m/%Y') 
                AND STR_TO_DATE('" . $fechaFin . "', '%d/%m/%Y')
                LIMIT 0, 10000;");
            return $query->result_array();
        }
        
        public function get_tablaArmI($idSubest, $fechaInicio, $fechaFin, $fase)
        {
            $query = $this->db->query("select DATE_FORMAT(t.fechaHora, '%d/%m/%Y %H:%i:%s') as fechaHora, i.datoi from subestuca.datoi i inner join subestuca.tiempo t on i.idTiempo = t.idTiempo 
                where idSubestacion = " . $idSubest .  
                " AND t.fechaHora BETWEEN STR_TO_DATE('" . $fechaInicio . "', '%d/%m/%Y') 
                AND STR_TO_DATE('" . $fechaFin . "', '%d/%m/%Y') 
                AND i.idFase = " . $fase . 
                " LIMIT 0, 10000;");
            return $query->result_array();
        }
        
        public function get_tablaArmV($idSubest, $fechaInicio, $fechaFin, $fase)
        {
            //tengo que filtrar por fecha, el filtrador por fase se hace en la vista
            $query = $this->db->query("select DATE_FORMAT(t.fechaHora, '%d/%m/%Y %H:%i:%s') as fechaHora, v.datov from subestuca.datov v inner join subestuca.tiempo t on v.idTiempo = t.idTiempo 
                where idSubestacion = " . $idSubest .  
                " AND t.fechaHora BETWEEN STR_TO_DATE('" . $fechaInicio . "', '%d/%m/%Y') 
                AND STR_TO_DATE('" . $fechaFin . "', '%d/%m/%Y') 
                AND v.idFase = " . $fase . 
                " LIMIT 0, 10000;");
            return $query->result_array();
        }
        
        public function get_cargas($idSubest){
            $query = $this->db->query("select edificio, tipoCarga, cantidad, corriente, voltaje, fase, fp, especificacion, accesorio, notasCargas 
                from subestuca.datoc where idSubestacion = " . $idSubest . " limit 0,10000;");
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
            $subData = $this->input->post('subData'); 
            $subArray = explode('/|\\',$subData);
            //echo $subData.'<br/>';
            //print_r($subArray);
            if($subArray[3]==''){
                $localizacion = null;
            }else{
                $localizacion = $subArray[3];
            }
            
            if($subArray[4]==''){
                $capacidad = null;
            }else{
                $capacidad = $subArray[4];
            }
            
            
            if($subArray[5]==''){
                $conexion = null;
            }else{
                $conexion = $subArray[5];
            }
            
            $data = array(
              'coordX' => $subArray[0],
                'coordY' => $subArray[1],
                'numSubestacion' => $subArray[2],
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
