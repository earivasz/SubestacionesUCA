<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
        public function __construct()
	{
		parent::__construct();
                $this->load->helper('url');
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->model('excel_model');
	}
    
	public function index()
	{
            $this->load->model('');
            $this->load->view('Excel');
	}
	
	public function importar()
	{
		
		$name	  = $_FILES['file']['name'];
		$tname 	  = $_FILES['file']['tmp_name'];
		require_once BASEPATH.'libraries/excel_reader2.php';
		$dato = new Spreadsheet_Excel_Reader($tname);
                print_r($dato->rowcount($sheet_index=0));
		$html = "<table cellpadding='2' border='1'>";
		for ($i = 1; $i <= $dato->rowcount($sheet_index=0); $i++) {
			
			if($dato->val($i,2) != ''){
				$html .= "<tr>";
				for ($j = 1; $j <= $dato->colcount($sheet_index=0); $j++) { 
					
					$value 	 = $dato->val($i,$j); 
					$html .="<td>".$value."&nbsp;</td>";
				}
				$html .="</tr>";
			}
		}
		$html .="</table>";	
		
		echo $html;	
	}
        
        public function importar_line()
	{
		
		$name	  = $_FILES['file']['name'];
		$tname 	  = $_FILES['file']['tmp_name'];
		print_r($name);
                print_r('\n');
                print_r($tname);
		require_once BASEPATH.'libraries/excel_reader2.php';
		$dato = new Spreadsheet_Excel_Reader($tname, false);
                print_r($dato->rowcount($sheet_index=0));
		$html = "<table cellpadding='2' border='1'>";
		for ($i = 3; $i <= $dato->rowcount($sheet_index=0); $i++) {
			
			if($dato->val($i,2) != ''){
				$html .= "<tr>";
				for ($j = 1; $j <= $dato->colcount($sheet_index=0); $j++) { 
					if($j==1){
                                            $value 	 = $dato->val($i,$j); 
                                        }else{
                                            $value      .= ';'.$dato->val($i,$j); 
                                        }
					
					//$html .="<td>".$value."&nbsp;</td>";
				}
				$html .='<td>'.$value."</td></tr>";
			}
		}
		$html .="</table>";	
		//$this->excel_model->prueba_trans();
		echo $html;	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */