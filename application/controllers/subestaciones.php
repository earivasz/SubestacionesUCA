<?php
class Subestaciones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('subest_model');
                $this->load->helper('url');
                $this->load->helper('form');
                $this->load->library('form_validation');
	}

	public function index()
	{   
            print('inicio index');
            $data['subest'] = $this->subest_model->get_subestaciones();
            
            $this->load->view('templates/header');
            $this->load->view('subestaciones/home', $data);
            $this->load->view('templates/footer');
	}
        
        public function detalle($id)
	{          
            $data['subest'] = $this->subest_model->get_subest($id);
            
            $this->load->view('templates/header');
            $this->load->view('subestaciones/detalle', $data);
            $this->load->view('templates/footer');
	}
        
        public function crear()
        {
            $this->form_validation->set_rules('coordX', 'Coordenada X', 'required');
            $this->form_validation->set_rules('coordY', 'Coordenada Y', 'required');
            $this->form_validation->set_rules('numSub', 'Numero Subestacion', 'required');
            

            if ($this->form_validation->run() === FALSE)
            {
                    $this->load->view('templates/header');	
                    $this->load->view('subestaciones/crear');
                    $this->load->view('templates/footer');

            }
            else
            {
                    $response = $this->subest_model->set_subest();
                    if($response){
                        $this->load->view('subestaciones/exito');
                    }else{
                        $this->load->view('subestaciones/errordb');
                    }
            }
        }
}
?>
