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
}
?>
