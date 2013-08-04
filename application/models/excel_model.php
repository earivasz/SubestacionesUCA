<?php

ini_set('memory_limit', '-1');

class Excel_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('excel');
        require_once BASEPATH . 'libraries/excel_reader2.php';
    }
    
    public function dato_i_v($tipo, $idFase) {
        try {
            $batch = array();
            $this->db->trans_begin();
            $lastTab = $this->correl_get();
            $tname = $_FILES['file']['tmp_name'];
            $name = $_FILES['file']['name'];
            $inputFileName = $tname;
            $this->tabla_insert($lastTab, $name, $tipo);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            }
            //$dato = new Spreadsheet_Excel_Reader($tname);

            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);


            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            //$highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
                //  Read a row of data into an array
                if($tipo==4){
                    $rowData = $sheet->rangeToArray('C' . $row . ':AA' . $row, NULL, TRUE, TRUE);
                }else{
                    $rowData = $sheet->rangeToArray('B' . $row . ':AP' . $row, NULL, TRUE, TRUE);
                }
                if (!empty($rowData[0][0])) {
                    $tiempo = $rowData[0][0];
                    unset($rowData[0][0]);
                    //echo $row . implode("/|\\", $rowData[0]);
                    //echo '<br /><br />';
                    $idTiempo = $this->tiempo_insert($tiempo, $tipo);
                    array_push($batch, $this->dato_i_v_insert($lastTab, $idTiempo, $idFase, $row, implode("/|\\", $rowData[0]), $tipo));
                }
            }
            //print_r($batch);
            //echo '<br />';
            if ($tipo == 2) {
                $this->db->insert_batch('datoI', $batch);
            } elseif ($tipo == 3) {
                $this->db->insert_batch('datoV', $batch);
            } else {
                $this->db->insert_batch('datoP', $batch);
            }
            echo 'FIN';

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
                return TRUE;
            }
        } catch (Exception $e) {
            //die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            $this->db->trans_rollback();
            return FALSE;
        }
    }

    //obtiene correlativo del ultimo archivo ingresado
    private function correl_get() {
        $query = 'select max(tabla.correlTabla) as id from tabla where tabla.idSubestacion = ?;';
        $lastCorrelSub = $this->db->query($query, array($this->input->post('subest')));
        foreach ($lastCorrelSub->result() as $row) {
            $lastTab = $row->id;
        }
        if ($lastTab == '') {
            $lastTab = 0;
        }
        $lastTab++;
        return $lastTab;
    }

    //inserta en la tabla 'TABLA'
    private function tabla_insert($lastTab, $name, $idTipo) {
        $data = array(
            'idSubestacion' => utf8_encode($this->input->post('subest')),
            'correlTabla' => utf8_encode($lastTab),
            'nombreArchivo' => utf8_encode($name),
            'fechaCreacion' => utf8_encode(date('Y-m-d H:i:s')),
            'notasTabla' => utf8_encode($this->input->post('notas')),
            'idTipo' => $idTipo
        );
        $this->db->insert('tabla', $data);
    }

    private function datac_insert($value, $lastTab, $i) {
        $paramsC = explode('/|\\', $value);

        $data = array(
            'idSubestacion' => utf8_encode($this->input->post('subest')),
            'correlTabla' => utf8_encode($lastTab),
            'correlDatoC' => utf8_encode($i - 2),
            'edificio' => utf8_encode($paramsC[0]),
            'tipoCarga' => utf8_encode($paramsC[1]),
            'cantidad' => utf8_encode($paramsC[2]),
            'corriente' => str_replace(' ', '', utf8_encode($paramsC[3])),
            'voltaje' => utf8_encode($paramsC[4]),
            'fase' => utf8_encode($paramsC[5]),
            'fp' => str_replace(' ', '', utf8_encode($paramsC[6])),
            'especificacion' => utf8_encode($paramsC[7]),
            'accesorio' => utf8_encode($paramsC[8]),
            'notasCargas' => utf8_encode($paramsC[9])
        );
        //print_r($data);
        $this->db->insert('datoc', $data);
    }

    private function dato_i_v_insert($lastTab, $idTiempo, $idFase, $i, $value, $tipo) {
        if ($tipo == 2) {
            $data = array(
                'idSubestacion' => utf8_encode($this->input->post('subest')),
                'correlTabla' => utf8_encode($lastTab),
                'idTiempo' => utf8_encode($idTiempo),
                'correlDatoI' => utf8_encode($i - 1),
                'idFase' => utf8_encode($idFase),
                'datoI' => utf8_encode($value)
            );
        } elseif ($tipo == 3) {
            $data = array(
                'idSubestacion' => utf8_encode($this->input->post('subest')),
                'correlTabla' => utf8_encode($lastTab),
                'idTiempo' => utf8_encode($idTiempo),
                'correlDatoV' => utf8_encode($i - 1),
                'idFase' => utf8_encode($idFase),
                'datoV' => utf8_encode($value)
            );
        } elseif($tipo == 4) {
            $data = array(
                'idSubestacion' => utf8_encode($this->input->post('subest')),
                'correlTabla' => utf8_encode($lastTab),
                'idTiempo' => utf8_encode($idTiempo),
                'correlDatoP' => utf8_encode($i - 1),
                'datoP' => utf8_encode($value)
            );
        }else{
            $data = array(
                'idSubestacion' => utf8_encode($this->input->post('subest')),
                'correlTabla' => utf8_encode($lastTab),
                'idTiempo' => utf8_encode($idTiempo),
                'correlDatoP' => utf8_encode($i - 1),
                'idFase' => utf8_encode($idFase),
                'datoP' => utf8_encode($value)
            );
        }
        //print_r($data);
        //$this->db->insert('datoI',$data);
        return $data;
    }

    private function tiempo_insert($tiempo, $tipo) {
        $time = explode(' ', $tiempo);
        //echo $tiempo . '    ';
        //print_r($time);
        if (strpos($time[0],'-') !== false) {
            $fecha = explode('-',$time[0]);
        }elseif(strpos($time[0],'/') !== false){
            $fecha = explode('/',$time[0]);
        }elseif(strpos($time[0],'.') !== false){
            $fecha = explode('.',$time[0]);
        }
        switch($tipo){
            case '4':
                $newFec = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' '.$time[1];
                break;
            default :
                $newFec = $fecha[2].'-'.$fecha[0].'-'.$fecha[1].' '.$time[1];
                break;
        }
        $timeN = strtotime($newFec);
        echo $newFec . '  :  ' . $timeN . '<br/>';
        //$timeF = date('Y-m-d H:m:s', $timeN);
        $query = "INSERT INTO tiempo (idTiempo, fechaHora) VALUES (NULL, CONVERT_TZ(FROM_UNIXTIME(?),'+00:00', '+01:00'));";
        
        $this->db->query($query, array($timeN,'?'));
        return $this->db->insert_id();
        /*$data = array(
            'idTiempo' => NULL,
            'fechaHora' => 'FROM_UNIXTIME('.$timeN.')'
        );
        $this->db->insert('tiempo', $data);
        return $this->db->insert_id();*/
    }

    public function cargas() {
        $this->db->trans_begin();
        $lastTab = $this->correl_get();
        $tname = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        $inputFileName = $tname;
        $this->tabla_insert($lastTab, $name, 1);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        //$dato = new Spreadsheet_Excel_Reader($tname);
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            $this->db->trans_rollback();
            return FALSE;
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        //  Loop through each row of the worksheet in turn
        for ($row = 3; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            if (!empty($rowData[0][0])) {
                //print_r(implode("/|\\", $rowData[0]));
                //echo '<br />';
                $this->datac_insert(implode("/|\\", $rowData[0]), $lastTab, $row);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return FALSE;
                }
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

}

?>
