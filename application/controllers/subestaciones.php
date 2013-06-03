<?php
class Subestaciones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('subest_model');
	}

	public function index()
	{          
            $data['subest'] = $this->subest_model->get_subestaciones();
            
            $this->load->view('templates/header');
            $this->load->view('subestaciones/home', $data);
            $this->load->view('templates/footer');
	}
}
?>
