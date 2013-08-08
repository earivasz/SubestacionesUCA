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
        
        public function getAll_trans()
        {
            $query = $this->db->get('transformador');
            return $query->result_array();
        }
        
        public function getAll_subestaciones()
        {
            //SELECT *, CASE WHEN activo = 1 THEN "ACTIVO" WHEN activo = 0 THEN "INACTIVO" END AS nomEstado FROM SUBESTACION;
            $query = 'SELECT *, CASE WHEN activo = 1 THEN "ACTIVO" WHEN activo = 0 THEN "INACTIVO" END AS nomEstado FROM SUBESTACION;';
            $subs = $this->db->query($query);
            return $subs->result_array();
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
        
        public function get_fotos($id){
            $query = $this->db->get_where('foto',array('idSubestacion' => $id));
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
        
        public function borrar_fotos($idSub, $arrFotos){
            $cont = 0;
            $fs = '';
            foreach ($arrFotos as $fotocorrel) {
                if($cont == 0)
                    $fs = "correlFoto = " . $fotocorrel;
                else
                    $fs = $fs . " OR correlFoto = " . $fotocorrel;
                $cont++;
            }
            $queryString = "delete from subestuca.foto where idSubestacion = " . $idSub . " and (" . $fs . ")";
            //print_r($queryString);
            $this->db->query($queryString);
            return ($this->db->affected_rows() < 1) ? false : true;
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
            $coordX = $this->input->post('coordX');
            $coordY = $this->input->post('coordY');
            $noSub = $this->input->post('numSub');
            $localizacion = $this->input->post('localizacion'); 
            $capacidad = $this->input->post('capacidad');
            $conexion = $this->input->post('conexion');
            $activo = $this->input->post('activo');
            if($localizacion==''){
                $localizacion = null;
            }
            
            if($capacidad==''){
                $capacidad = null;
            }

            if($conexion==''){
                $conexion = null;
            }
            
            $data = array(
                'coordX' => $coordX,
                'coordY' => $coordY,
                'numSubestacion' => $noSub,
                'localizacion' => $localizacion,
                'capacidad' => $capacidad,
                'conexion' => $conexion,
                'activo' => $activo
            );
            
            $this->db->insert('subestacion', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
        
        public function set_trans_sub(){
                $noSerie = $this->input->post('noSerie');
                if($noSerie==''){
                    $noSerie = null;
                }
                $capacidad = $this->input->post('capaTra');
                if($capacidad==''){
                    $capacidad = null;
                }
                $fabricante = $this->input->post('fabricante');
                if($fabricante==''){
                    $fabricante = null;
                }
                $enfriamiento = $this->input->post('enfriamiento');
                if($enfriamiento==''){
                    $enfriamiento = null;
                }
                $impedancia = $this->input->post('impedancia');
                if($impedancia==''){
                    $impedancia = null;
                }
                $vPrimaria = $this->input->post('vPrimaria');
                if($vPrimaria==''){
                    $vPrimaria = null;
                }
                $vSecundaria = $this->input->post('vSecundario');
                if($vSecundaria==''){
                    $vSecundaria = null;
                }
                $rTransformador = $this->input->post('rTrans');
                if($rTransformador==''){
                    $rTransformador = null;
                }
                $polaridad = $this->input->post('polaridad');
                if($polaridad==''){
                    $polaridad = null;
                }
                $aterrizamiento = $this->input->post('aterriza');
                if($aterrizamiento==''){
                    $aterrizamiento = null;
                }
                $pararrayos = $this->input->post('pararrayos');
                if($pararrayos==''){
                    $pararrayos = null;
                }
                $cuchillas = $this->input->post('cuchillas');
                if($cuchillas==''){
                    $cuchillas = null;
                }
                $idSub = $this->input->post('idSub');
                $data = $this->correl_get($idSub);
                $num = $this->transCount($idSub);
                if($num < 4){
                    $dataT = array(
                        'idSubestacion' => $idSub,
                        'correlTransformador'=> $data['last'],
                        'noSerie' => $noSerie,
                        'capacidad' => $capacidad,
                        'fabricante' => $fabricante,
                        'enfriamiento' => $enfriamiento,
                        'impedancia' => $impedancia,
                        'vPrimaria' => $vPrimaria,
                        'vSecundario' => $vSecundaria,
                        'rTransformacion' => $rTransformador,
                        'polaridad' => $polaridad,
                        'aterrizamiento' => $aterrizamiento,
                        'pararrayos' => $pararrayos,
                        'cuchillas' => $cuchillas,
                        'activoTrans' => $this->input->post('activo')
                    );
                    $this->db->insert('transformador', $dataT);
                    if($this->db->affected_rows() != 1){
                        $this->session->set_flashdata('msj', 'No pudo ser creado el transformador');
                    }else{
                        $this->session->set_flashdata('msj', 'Transformador creado con exito');
                    }
                    
                }else{
                    $this->session->set_flashdata('msj', 'Maximo de transformadores alcanzado');
                }
                return $idSub;
        }
        
        
        public function update_trans(){
                $noSerie = $this->input->post('noSerie');
                if($noSerie==''){
                    $noSerie = null;
                }
                $capacidad = $this->input->post('capaTra');
                if($capacidad==''){
                    $capacidad = null;
                }
                $fabricante = $this->input->post('fabricante');
                if($fabricante==''){
                    $fabricante = null;
                }
                $enfriamiento = $this->input->post('enfriamiento');
                if($enfriamiento==''){
                    $enfriamiento = null;
                }
                $impedancia = $this->input->post('impedancia');
                if($impedancia==''){
                    $impedancia = null;
                }
                $vPrimaria = $this->input->post('vPrimaria');
                if($vPrimaria==''){
                    $vPrimaria = null;
                }
                $vSecundaria = $this->input->post('vSecundario');
                if($vSecundaria==''){
                    $vSecundaria = null;
                }
                $rTransformador = $this->input->post('rTrans');
                if($rTransformador==''){
                    $rTransformador = null;
                }
                $polaridad = $this->input->post('polaridad');
                if($polaridad==''){
                    $polaridad = null;
                }
                $aterrizamiento = $this->input->post('aterriza');
                if($aterrizamiento==''){
                    $aterrizamiento = null;
                }
                $pararrayos = $this->input->post('pararrayos');
                if($pararrayos==''){
                    $pararrayos = null;
                }
                $cuchillas = $this->input->post('cuchillas');
                if($cuchillas==''){
                    $cuchillas = null;
                }
                $idSub = $this->input->post('idSub');
                $correl = $this->input->post('correl');
                    $dataT = array(
                        'noSerie' => $noSerie,
                        'capacidad' => $capacidad,
                        'fabricante' => $fabricante,
                        'enfriamiento' => $enfriamiento,
                        'impedancia' => $impedancia,
                        'vPrimaria' => $vPrimaria,
                        'vSecundario' => $vSecundaria,
                        'rTransformacion' => $rTransformador,
                        'polaridad' => $polaridad,
                        'aterrizamiento' => $aterrizamiento,
                        'pararrayos' => $pararrayos,
                        'cuchillas' => $cuchillas,
                        'activoTrans' => $this->input->post('activo')
                    );
                    $this->db->trans_begin();
                    $this->db->where('idSubestacion', $idSub);
                    $this->db->where('correlTransformador', $correl);
                    $this->db->update('transformador', $dataT);
                    if($this->db->affected_rows() == 0){
                        $this->db->trans_commit();
                        $this->session->set_flashdata('msj', 'No pudo ser actualizado el transformador activo:'. $this->input->post('activo'));
                    }else{
                        $num = $this->transCount($idSub);
                        if($num <= 4){
                            $this->db->trans_commit();
                            $this->session->set_flashdata('msj', 'Transformador actualizado con exito');
                        }else{
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('msj', 'Maximo de transformadores activos alcanzado');
                        }
                        
                    }
                    
                return $idSub;
        }
        
        private function correl_get($idSub) {
        $query = 'select max(transformador.correlTransformador) as id, count(transformador.correlTransformador) as num from transformador where transformador.idSubestacion = ?;';
        $lastCorrelSub = $this->db->query($query, array($idSub));
        foreach ($lastCorrelSub->result() as $row) {
            $last = $row->id;
            $num = $row->num;
        }
        if ($last == '') {
            $last = 0;
        }
        $last++;
        $data['last'] = $last;
        $data['num'] = $num;
        return $data;
    }
    
    private function transCount($idSub) {
        $query = 'select count(transformador.correlTransformador) as num from transformador where transformador.idSubestacion = ? and transformador.activoTrans = 1;';
        $lastCorrelSub = $this->db->query($query, array($idSub));
        foreach ($lastCorrelSub->result() as $row) {
            $num = $row->num;
        }
        return $num;
    }
}
?>
