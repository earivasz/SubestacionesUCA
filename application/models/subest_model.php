<?php
class Subest_model extends CI_Model {
        
	public function __construct()
	{
            $this->load->database();
	}
        
        public function get_subestaciones()
        {
            
            $query = "select s.idSubestacion, s.coordX, s.coordY, s.numSubestacion, s.localizacion, s.capacidad, s.conexion, s.activo, f.url 
                from subestuca.subestacion s left join subestuca.foto f on s.idSubestacion = f.idSubestacion
                where activo = 1 and (correlFoto = 1 or correlFoto is NULL)";
            $subs = $this->db->query($query);
            return $subs->result_array();
            
        }
        
        public function get_subestaciones_xperfil($idperfil)
        {
            $query = 'select s.idSubestacion, s.coordX, s.coordY, s.numSubestacion, s.localizacion, s.capacidad, s.conexion, s.activo, f.url 
                from subestuca.subestacion s inner join subestuca.perfilxsubest pxs on s.idSubestacion = pxs.idSubestacion
                left join subestuca.foto f on s.idSubestacion = f.idSubestacion
                where activo = 1 and pxs.idPerfil = ? and (correlFoto = 1 or correlFoto is NULL);';
            $subs = $this->db->query($query, array($idperfil));
            return $subs->result_array();
        }
        
        public function getAll_trans()
        {
            $query = 'SELECT t.*, s.localizacion, CASE WHEN t.aterrizamiento = 1 THEN "SI" WHEN t.aterrizamiento = 0 THEN "NO" END AS nomAterr, CASE WHEN t.pararrayos = 1 THEN "SI" WHEN t.pararrayos = 0 THEN "NO" END AS nomPara, CASE WHEN t.cuchillas = 1 THEN "SI" WHEN t.cuchillas = 0 THEN "NO" END AS nomCuchillas, CASE WHEN t.activoTrans = 1 THEN "ACTIVO" WHEN t.activoTrans = 0 THEN "INACTIVO" END AS nomActivo FROM subestuca.transformador t INNER JOIN subestuca.subestacion s ON t.idSubestacion = s.idSubestacion;';
            //$query = $this->db->get('transformador');
            $trans = $this->db->query($query);
            return $trans->result_array();
        }
        
        public function getAll_subestaciones()
        {
            $query = 'SELECT *, CASE WHEN activo = 1 THEN "ACTIVO" WHEN activo = 0 THEN "INACTIVO" END AS nomEstado FROM subestacion;';
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
            $query = $this->db->query('SELECT * FROM subestuca.foto where idSubestacion = ? order by correlFoto desc;', array($id));
            return $query->result_array();
        }
        
        public function get_latestCorrelFoto($id){
            $query = $this->db->query('SELECT 0 as correlFoto union select correlFoto FROM subestuca.foto where idSubestacion = ? order by correlFoto desc limit 1;', array($id));
            return $query->result_array();
        }
        
        public function get_valsistema($valor){
            $query = $this->db->get_where('valsistema',array('nomValor' => $valor));
            return $query->result_array();
        }
        
        public function set_valsistema($valsistema, $valor){
            $data = array(
              'nomValor' => $valsistema,
                'valor' => $valor
            );
            $this->db->where('nomValor', $valsistema);
            $this->db->update('valsistema', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }
        
        public function get_valsistema_all(){
            $query = $this->db->get('valsistema');
            return $query->result_array();
        }
        
        public function check_subestacion_invitado($idSub){
            $query = 'select * from subestuca.perfilxsubest where idSubestacion = ?';
            $this->db->query($query, array($idSub));
            //return (count($arr) > 0) ? true : false;
            return ($this->db->affected_rows() > 0) ? true : false;
        }
        
        public function get_subestaciones_con_perfil()
        {
            $query = 'SELECT s.idSubestacion, numSubestacion, localizacion, idPerfil FROM subestuca.subestacion s left join subestuca.perfilxsubest pxs on s.idSubestacion = pxs.idSubestacion 
                where s.activo = 1;';
            $subs = $this->db->query($query);
            return $subs->result_array();
        }
        
        public function set_sistema($arrSubs, $multafp, $multathdi){
            $this->db->trans_begin();
            $allgood = 1;
            
            //primero borro
            $query = 'delete from subestuca.perfilxsubest where idPerfil = 3;';
            $this->db->query($query);
            if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $allgood = 0;
                }
            else{
            //luego hago insert por cada subestacion
                foreach ($arrSubs as $sub) {
                    $data = array(
                        'idPerfil' => '3',
                        'idSubestacion' => $sub,
                    );
                    $this->db->insert('perfilxsubest', $data);
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $allgood = 0;
                    }
                }

                if($allgood == 1){
                    $this->set_valsistema('multafp', $multafp);
                    if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $allgood = 0;
                        }
                }
                if($allgood == 1){
                    $this->set_valsistema('multathdi', $multathdi);
                    if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $allgood = 0;
                        }
                }
            }
            if($allgood == 1){
                $this->db->trans_commit();
                return true;
            }
            else
                return false;
        }
        
        public function get_fechasConDatos($idSub, $tipo){
            if($tipo == 'pri'){
                $query = $this->db->query("select distinct DATE_FORMAT(fechaHora, '%d-%m-%Y') as dia
                from subestuca.datop dp inner join subestuca.tiempo t on dp.idTiempo = t.idTiempo
                where dp.idSubestacion = ?;", array($idSub));
                return $query->result_array();
            }
            else{
                if($tipo == 'armv'){
                    $query = $this->db->query("select distinct DATE_FORMAT(fechaHora, '%d-%m-%Y') as dia 
                    from subestuca.datov dv inner join subestuca.tiempo t on dv.idTiempo = t.idTiempo
                    where dv.idSubestacion = ?;", array($idSub));
                    return $query->result_array();
                }
                else{//armi
                    $query = $this->db->query("select distinct DATE_FORMAT(fechaHora, '%d-%m-%Y') as dia 
                    from subestuca.datoi di inner join subestuca.tiempo t on di.idTiempo = t.idTiempo
                    where di.idSubestacion = ?;", array($idSub));
                    return $query->result_array();
                }
            }
        }
        
        public function get_tablaPrincipal($idSubest, $fechaInicio, $fechaFin)
        {
            //tengo que filtrar por fecha, el filtrador por fase se hace en la vista
            //echo $fechaFin;
            $query = $this->db->query("select DATE_FORMAT(t.fechaHora, '%d/%m/%Y %H:%i:%s') as fechaHora, p.datop from subestuca.datop p inner join subestuca.tiempo t on p.idTiempo = t.idTiempo 
                where idSubestacion = ?  
                 AND t.fechaHora BETWEEN STR_TO_DATE(?, '%d-%m-%Y') 
                AND DATE_ADD(STR_TO_DATE(?, '%d-%m-%Y'), INTERVAL 1 DAY) 
                LIMIT 0, 10000;", array($idSubest, $fechaInicio, $fechaFin));
            return $query->result_array();
        }
        
        public function get_tablaArmI($idSubest, $fechaInicio, $fechaFin, $fase)
        {
            $query = $this->db->query("select DATE_FORMAT(t.fechaHora, '%d/%m/%Y %H:%i:%s') as fechaHora, i.datoi from subestuca.datoi i inner join subestuca.tiempo t on i.idTiempo = t.idTiempo 
                where idSubestacion = ?  
                 AND t.fechaHora BETWEEN STR_TO_DATE(?, '%d-%m-%Y') 
                AND DATE_ADD(STR_TO_DATE(?, '%d-%m-%Y'), INTERVAL 1 DAY) 
                AND i.idFase = ? LIMIT 0, 10000;", array($idSubest, $fechaInicio, $fechaFin, $fase));
            return $query->result_array();
        }
        
        public function get_tablaArmV($idSubest, $fechaInicio, $fechaFin, $fase)
        {
            //tengo que filtrar por fecha, el filtrador por fase se hace en la vista
            $query = $this->db->query("select DATE_FORMAT(t.fechaHora, '%d/%m/%Y %H:%i:%s') as fechaHora, v.datov from subestuca.datov v inner join subestuca.tiempo t on v.idTiempo = t.idTiempo 
                where idSubestacion = ?  
                 AND t.fechaHora BETWEEN STR_TO_DATE(?, '%d-%m-%Y') 
                AND DATE_ADD(STR_TO_DATE(?, '%d-%m-%Y'), INTERVAL 1 DAY) 
                AND v.idFase = ? LIMIT 0, 10000;", array($idSubest, $fechaInicio, $fechaFin, $fase));
            return $query->result_array();
        }
        
        public function get_cargas($idSubest){
            $query = $this->db->query("select edificio, tipoCarga, cantidad, corriente, voltaje, fase, fp, especificacion, accesorio, notasCargas 
                from subestuca.datoc where idSubestacion = ? limit 0,10000;", array($idSubest));
            return $query->result_array();
        }
        
        public function galeria($id){
            $data['idSubest'] = $id;
            $data['fotos'] = $this->subest_model->get_fotos($id);
            $data['subest'] = $this->subest_model->get_subest($id);
            $this->load->view('templates/header');
            $this->load->view('subestaciones/galeria', $data);
            $this->load->view('templates/footer');
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
            $queryString = "delete from subestuca.foto where idSubestacion = ? and (" . $fs . ")";
            //print_r($queryString);
            $this->db->query($queryString, array($idSub));
            return ($this->db->affected_rows() < 1) ? false : true;
        }
        
        public function crear_fotos($idSub, $arrFotos){
            $this->db->trans_begin();
            $allgood = 1;
            
            foreach ($arrFotos as $imagen) {
                $data = array(
                    'idSubestacion' => $idSub,
                    'correlFoto' => $imagen['correl'],
                    'url' => $imagen['url'],
                );
                $this->db->insert('foto', $data);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $allgood = 0;
                }
            }
            
            if($allgood == 1){
                $this->db->trans_commit();
                return true;
            }
            else
                return false;
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
            
            if($this->input->post('activo')==''){
                $activo = 0;
            }else{
                $activo = 1;
            }
            
            $data = array(
              'coordX' => $this->input->post('coordX'),
                'coordY' => $this->input->post('coordY'),
                'numSubestacion' => $this->input->post('numSub'),
                'localizacion' => $localizacion,
                'capacidad' => $capacidad,
                'conexion' => $conexion,
                'activo' => $activo
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
                    $aterrizamiento = 0;
                }
                $pararrayos = $this->input->post('pararrayos');
                if($pararrayos==''){
                    $pararrayos = 0;
                }
                $cuchillas = $this->input->post('cuchillas');
                if($cuchillas==''){
                    $cuchillas = 0;
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
                    $aterrizamiento = 0;
                }
                $pararrayos = $this->input->post('pararrayos');
                if($pararrayos==''){
                    $pararrayos = 0;
                }
                $cuchillas = $this->input->post('cuchillas');
                if($cuchillas==''){
                    $cuchillas = 0;
                }
                $activo = $this->input->post('activo');
                if($activo==''){
                    $activo=0;
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
                        'activoTrans' => $activo
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
