<?php
class Subestaciones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('subest_model');
                $this->load->helper('url');
                $this->load->helper('form');
                //$this->load->library('form_validation');
                $this->load->library(array('session','form_validation'));
	}

	public function index()
	{   
            $data['subest'] = $this->subest_model->get_subestaciones();
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                switch ($this->session->userdata('perfil')) {
                    case '1':
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2':
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;    
                    case '3':
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;
                    default:        
                        $this->load->view('templates/header');
                        $this->load->view('template/no_auth');
                        $this->load->view('templates/footer');
                        break;        
                }
            }
	}
        
        public function detalle($id)
	{          
            $data['subest'] = $this->subest_model->get_subest($id);
            $data['transformadores'] = $this->subest_model->get_transformadores($id);
            $data['fotos'] = $this->subest_model->get_fotosSubest($id);
            
            //TESTING
//            foreach($data['transformadores'] as $trans):
//                echo $trans['noSerie'];
//            endforeach;
            
//            foreach($data['fotos'] as $trans):
//                echo $trans['url'];
//            endforeach;
            //ENDTESTING
            echo "DETALLE";
            $this->load->view('templates/header');
            $this->load->view('subestaciones/detalle', $data);
            $this->load->view('templates/footer');
	}
        
        public function crear()
        {
            $this->form_validation->set_rules('coordX', 'Coordenada X', 'required');
            $this->form_validation->set_rules('coordY', 'Coordenada Y', 'required');
            $this->form_validation->set_rules('numSub', 'Numero Subestacion', 'required');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');

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
        
        public function modificar($id)
        {
            $data['subest'] = $this->subest_model->get_subest($id);
            $data['idSub'] = $id;
            $this->load->view('templates/header');	
            $this->load->view('subestaciones/modificar', $data);
            $this->load->view('templates/footer');
        }
        
        public function graficos($id, $tipo)
        {
            $data['subest'] = $this->subest_model->get_subest($id);
            $data['idSub'] = $id;
            $data['tipo'] = $tipo;
            //$data['datos'] = 
            $this->load->view('templates/header');	
            $this->load->view('subestaciones/graficos', $data);
            $this->load->view('templates/footer');
        }
        
        public function mod_sub()
        {
            
            
            $this->form_validation->set_rules('coordX', 'Coordenada X', 'required');
            $this->form_validation->set_rules('coordY', 'Coordenada Y', 'required');
            $this->form_validation->set_rules('numSub', 'Numero Subestacion', 'required');
            

            if ($this->form_validation->run() === FALSE)
            {
                $this->modificar($this->input->post('idSub'));
            }
            else
            {
                    $response = $this->subest_model->mod_subest($this->input->post('idSub'));
                    echo $id;
                    if($response){
                        //$this->load->view('subestaciones/exito');
                        echo 'eeeeeeexito';
                    }else{
                        //$this->load->view('subestaciones/errordb');
                        echo 'waaaashinton';
                    }
            }
        }
}
?>
