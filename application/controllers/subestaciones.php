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
                $data['perfil'] = $this->session->userdata('perfil');
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $this->load->view('templates/header', $data);
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://generico
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
            $data['subestId'] = $id;
            $this->load->view('templates/header');
            $this->load->view('subestaciones/detalle', $data);
            $this->load->view('templates/footer');
	}
        
        public function crear_trans($sub){
            $data['subId'] = $sub;
            $this->load->view('templates/header');
            $this->load->view('subestaciones/crear_trans', $data);
            $this->load->view('templates/footer');
        }
        
        public function set_trans($sub){
            try{
            $response=$this->subest_model->set_trans_sub();
            //$response = true;
            redirect(base_url().'index.php/subestaciones/crear_trans/'.$response);
            }catch(Exception $e){
                $this->session->set_flashdata('msj', 'Ocurrio un problema al momento de recibir su peticion');
                redirect(base_url().'index.php/subestaciones/crear_trans/'.$sub);
            }
        }
        
        public function crear(){
            /*switch($this->input->post('tipo')){
                case '1':
                    $response = $this->subest_model->set_subest();
                    //$response = 'OK';
                    echo json_encode($response);
                    break;
                case '2':
                    $response = $this->subest_model->set_trans_sub();
                    //$response = 'OK';
                    echo json_encode($response);
                    break;
                default:
                    print_r(explode('/|\\','13.679627104248063/|\\-89.23582255840302/|\\666/|\\/|\\/|\\'));
                    $prueba = explode('|||','666/|\\/|\\/|\\/|\\/|\\/|\\/|\\/|\\/|\\/|\\/|\\');
                    print_r($prueba);
                    
                    foreach ($prueba as $item) {
                        $transArray = explode('/|\\',$item);
                        print_r($transArray);
                    }*/
                    $this->load->view('templates/header');	
                    $this->load->view('subestaciones/crear_sub');
                    $this->load->view('templates/footer');
                    /*break;
            }*/
        }
        
        public function crear_sub()
        {
            $this->form_validation->set_rules('coordX', 'Coordenada X', 'required');
            $this->form_validation->set_rules('coordY', 'Coordenada Y', 'required');
            $this->form_validation->set_rules('numSub', 'Numero Subestacion', 'required');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio.');

            if ($this->form_validation->run() === FALSE)
            {
                    //$this->session->set_flashdata('msj', 'Hace falta uno o mas campos obligatorios');
                    $this->crear();

            }
            else
            {
                    $response = $this->subest_model->set_subest();
                    //$response = true;
                    if($response){
                        $this->session->set_flashdata('msj', 'Exito');
                        
                    }else{
                        $this->session->set_flashdata('msj', 'Error');
                        //$this->crear();
                        //echo json_encode('error');
                        //$this->load->view('subestaciones/errordb');
                    }
                    redirect(base_url().'index.php/subestaciones/crear');
            }
        }
        
        public function cargas($id)
        {
            $data['cargas'] = $this->subest_model->get_cargas($id);
            $data['subest'] = $this->subest_model->get_subest($id);
            $data['idSub'] = $id;
            $this->load->view('templates/header');	
            $this->load->view('subestaciones/cargas', $data);
            $this->load->view('templates/footer');
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
        
        public function set_trans_sub(){
            $response = $this->subest_model->set_trans_sub();
            echo json_encode($response);
        }
}
?>
