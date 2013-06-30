<?php
class Excel_model extends CI_Model {
        
	public function __construct()
	{
            $this->load->database();
            $this->load->helper('url');
            require_once BASEPATH.'libraries/excel_reader2.php';
	}
        
        public function cargas()
        {
            $this->db->trans_begin();
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
            $tname 	  = $_FILES['file']['tmp_name'];
            $name	  = $_FILES['file']['name'];
            $data = array(
                'idSubestacion' => utf8_encode($this->input->post('subest')),
                'correlTabla' => utf8_encode($lastTab),
                'nombreArchivo' => utf8_encode($name),
                'fechaCreacion' => utf8_encode(date('Y-m-d H:i:s')),
                'notasTabla' => utf8_encode($this->input->post('notas')),
                'idTipo' => 1
            );
            $this->db->insert('tabla',$data);
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
                                $value = $dato->val($i,$j); 
                            }else{
                                $value .= '/|\\'.$dato->val($i,$j); 
                            } 
                    }
                    //echo $value;
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
