<?php
ini_set('memory_limit', '-1');
class Excel_model extends CI_Model {
        
	public function __construct()
	{
            $this->load->database();
            $this->load->helper('url');
            $this->load->library('excel');
            require_once BASEPATH.'libraries/excel_reader2.php';
	}
        
        /*public function cargas()
        {
            $this->db->trans_begin();
            $lastTab = $this->correl_get();
            $tname 	  = $_FILES['file']['tmp_name'];
            $name	  = $_FILES['file']['name'];
            $this->tabla_insert($lastTab, $name, 1);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            $dato = new Spreadsheet_Excel_Reader($tname);
            for ($i = 3; $i <= $dato->rowcount($sheet_index=0); $i++) {

                if($dato->val($i,2) != ''){
                    for ($j = 1; $j <= $dato->colcount($sheet_index=0); $j++) { 
                            if($j==1){
                                $value = utf8_decode($dato->val($i,$j)); 
                            }else{
                                $value .= '/|\\'.utf8_decode($dato->val($i,$j)); 
                            } 
                    }
                    $this->datac_insert($value, $lastTab, $i);
                    if ($this->db->trans_status() === FALSE)
                    {
                        $this->db->trans_rollback();
                        return FALSE;
                    }
                }
                
            }
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                return TRUE;
            }
        }
        */
        public function dato_i_v($tipo,$idFase){
            $batch = array();
            $this->db->trans_begin();
            $lastTab = $this->correl_get();
            $tname 	  = $_FILES['file']['tmp_name'];
            $name	  = $_FILES['file']['name'];
            $inputFileName = $tname;
            $this->tabla_insert($lastTab, $name, $tipo);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            //$dato = new Spreadsheet_Excel_Reader($tname);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                $this->db->trans_rollback();
                return FALSE;
            }
            
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++){ 
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('B' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                TRUE);
                if(! empty($rowData[0][0])){
                    $tiempo = $rowData[0][0];
                    unset($rowData[0][0]);
                    //echo $row . implode("/|\\", $rowData[0]);
                    //echo '<br /><br />';
                    $idTiempo = $this->tiempo_insert($tiempo);
                    array_push($batch, $this->dato_i_v_insert($lastTab, $idTiempo, $idFase, $row, implode("/|\\", $rowData[0]),$tipo));
                }
            }
            print_r($batch);
            echo '<br />';
            if($tipo == 2)
            {
                $this->db->insert_batch('datoI',$batch);
            }
            else
            {
                $this->db->insert_batch('datoV',$batch);
            }
            echo 'FIN';
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                return TRUE;
            }
        }
        
        private function correl_get(){
            $query = 'select max(tabla.correlTabla) as id from tabla where tabla.idSubestacion = ?;';
            $lastCorrelSub = $this->db->query($query, array($this->input->post('subest')));
            foreach ($lastCorrelSub->result() as $row)
            {
               $lastTab = $row->id;
            }
            if($lastTab == ''){
                $lastTab = 0;
            }
            $lastTab++;
            return $lastTab;
        }
        
        private function tabla_insert($lastTab,$name,$idTipo){
            $data = array(
                'idSubestacion' => utf8_encode($this->input->post('subest')),
                'correlTabla' => utf8_encode($lastTab),
                'nombreArchivo' => utf8_encode($name),
                'fechaCreacion' => utf8_encode(date('Y-m-d H:i:s')),
                'notasTabla' => utf8_encode($this->input->post('notas')),
                'idTipo' => $idTipo
            );
            $this->db->insert('tabla',$data);
        }
        
        private function datac_insert($value,$lastTab,$i){
            $paramsC = explode('/|\\', $value);

            $data = array(
                'idSubestacion' => utf8_encode($this->input->post('subest')),
                'correlTabla' => utf8_encode($lastTab),
                'correlDatoC' => utf8_encode($i-2),
                'edificio' => utf8_encode($paramsC[0]),
                'tipoCarga' => utf8_encode($paramsC[1]),
                'cantidad' => utf8_encode($paramsC[2]),
                'corriente' => str_replace(' ','',utf8_encode($paramsC[3])),
                'voltaje' => utf8_encode($paramsC[4]),
                'fase' => utf8_encode($paramsC[5]),
                'fp' => str_replace(' ','',utf8_encode($paramsC[6])),
                'especificacion' => utf8_encode($paramsC[7]),
                'accesorio' => utf8_encode($paramsC[8]),
                'notasCargas' => utf8_encode($paramsC[9])
            );
            print_r($data);
            $this->db->insert('datoc',$data);
        }
        
        private function dato_i_v_insert($lastTab, $idTiempo, $idFase, $i, $value, $tipo){
            if($tipo == 2)
            {
                $data = array(
                    'idSubestacion' => utf8_encode($this->input->post('subest')),
                    'correlTabla' => utf8_encode($lastTab),
                    'idTiempo' => utf8_encode($idTiempo),
                    'correlDatoI' => utf8_encode($i-1),
                    'idFase' => utf8_encode($idFase),
                    'datoI' => utf8_encode($value)
                );
            }
            else
            {
                $data = array(
                    'idSubestacion' => utf8_encode($this->input->post('subest')),
                    'correlTabla' => utf8_encode($lastTab),
                    'idTiempo' => utf8_encode($idTiempo),
                    'correlDatoV' => utf8_encode($i-1),
                    'idFase' => utf8_encode($idFase),
                    'datoV' => utf8_encode($value)
                );
            }
            //print_r($data);
            //$this->db->insert('datoI',$data);
            return $data;
        }
        
        private function tiempo_insert($tiempo){
            $time = strtotime($tiempo);
            $timeF = date('Y/m/d H:m:s', $time);
            $data = array(
                'idTiempo' => NULL,
                'fechaHora' => $timeF
            );
            $this->db->insert('tiempo',$data);
            return $this->db->insert_id();
        }
        
        public function cargas()
        {
            $this->db->trans_begin();
            $lastTab = $this->correl_get();
            $tname 	  = $_FILES['file']['tmp_name'];
            $name	  = $_FILES['file']['name'];
            $inputFileName = $tname;
            $this->tabla_insert($lastTab, $name, 1);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            //$dato = new Spreadsheet_Excel_Reader($tname);
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                $this->db->trans_rollback();
                return FALSE;
            }
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 3; $row <= $highestRow; $row++){ 
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if(! empty($rowData[0][0])){
                    print_r(implode("/|\\", $rowData[0]));
                    echo '<br />';
                    $this->datac_insert(implode("/|\\", $rowData[0]), $lastTab, $row);
                    if ($this->db->trans_status() === FALSE)
                    {
                        $this->db->trans_rollback();
                        return FALSE;
                    }
                    
                }
            }

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                return TRUE;
            }
        }
}
?>
