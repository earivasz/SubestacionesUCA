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
        
        public function borrar_fotos(){
            
            $response = $this->subest_model->borrar_fotos($this->input->post('idSub'), $this->input->post('arrFotos'));
            if($response){
                echo 'exito';
            }else{
                echo 'fracaso';
            }
        }
        
        public function galeria($id){
            $data['idSubest'] = $id;
            $data['fotos'] = $this->subest_model->get_fotos($id);
            $data['subest'] = $this->subest_model->get_subest($id);
            $data['ultimocorrel'] = $this->subest_model->get_latestCorrelFoto($id);
            $this->load->view('templates/header');
            $this->load->view('subestaciones/galeria', $data);
            $this->load->view('templates/footer');
        }
        
        public function subir_archivo(){
            $rutaGuardar = 'img/';
            $numImagenes = count($_FILES['arrimg']['name']);
            $ultCorr = $this->input->post('ultimocorrel');
            $sub = $this->input->post('subest');
            $arrimagenes = Array();
            $allgood = 1;

            $allowedExts = array("gif", "jpeg", "jpg", "png");
            for($ar=0;$ar<$numImagenes;$ar++){//hago uno por uno
                $temp = explode(".", $_FILES["arrimg"]["name"][$ar]);
                $extension = end($temp);
                 if ((($_FILES["arrimg"]["type"][$ar] == "image/gif")
                 || ($_FILES["arrimg"]["type"][$ar] == "image/jpeg")
                 || ($_FILES["arrimg"]["type"][$ar] == "image/jpg")
                || ($_FILES["arrimg"]["type"][$ar] == "image/pjpeg")
                || ($_FILES["arrimg"]["type"][$ar] == "image/x-png")
                 || ($_FILES["arrimg"]["type"][$ar] == "image/png"))
                 && ($_FILES["arrimg"]["size"][$ar] < 2000000)
                 && in_array($extension, $allowedExts))
                   {
                       if ($_FILES["arrimg"]["error"][$ar] > 0)
                         {
                         //echo "Return Code: " . $_FILES["arrimg"]["error"][$ar] . "<br>";
                           $allgood = 0;
                         }
                       else
                         {
//                         echo "Upload: " . $_FILES["arrimg"]["name"][$ar] . "<br>";
//                         echo "Type: " . $_FILES["arrimg"]["type"][$ar] . "<br>";
//                         echo "Size: " . ($_FILES["arrimg"]["size"][$ar] / 1024) . " kB<br>";
//                         echo "Temp file: " . $_FILES["arrimg"]["tmp_name"][$ar] . "<br>";
//                         if (file_exists($rutaGuardar . $_FILES["arrimg"]["name"][$ar]))
//                           {
//                           echo $_FILES["arrimg"]["name"][$ar] . " already exists. ";
//                           }
//                         else
//                           {
                           move_uploaded_file($_FILES["arrimg"]["tmp_name"][$ar],
                           $rutaGuardar . $sub . '/' . $_FILES["arrimg"]["name"][$ar]);
                           //echo "Stored in: " . $rutaGuardar . $_FILES["arrimg"]["name"][$ar];
                           $ultCorr = $ultCorr + 1;
                           $tta = Array('correl' => $ultCorr, 'url' => base_url() . 'img/' . $sub . '/' . $_FILES["arrimg"]["name"][$ar]);
                           array_push($arrimagenes, $tta);
                           //}
                         }
                   }
                 else
                   {
                   //echo "Invalid file";
                     $allgood = 0;
                   }
            }
            //guardo en la base de datos
            if($allgood == 1){
                $allgood = $this->subest_model->crear_fotos($sub, $arrimagenes);
                if(!$allgood)
                    $this->session->set_flashdata('msj', 'Ocurrio un error al subir las imagenes al servidor');
            }
            else{
                $this->session->set_flashdata('msj', 'Ocurrio un error al subir las imagenes al servidor');
            }
            redirect(base_url().'index.php/subestaciones/galeria/'. $sub);
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
        
        public function crear_trans(){
            $data['subs'] = $this->subest_model->get_subestaciones();
            $data['trans'] = $this->subest_model->getAll_trans();
            $this->load->view('templates/header');
            $this->load->view('subestaciones/crear_trans', $data);
            $this->load->view('templates/footer');
        }
        
        public function set_trans(){
            try{
                
                if($this->input->post('isMod')=='True'){
                    $response = $this->subest_model->update_trans();
                }else{
                    $response=$this->subest_model->set_trans_sub();
                }


                redirect(base_url().'index.php/subestaciones/crear_trans');
            }catch(Exception $e){
                $this->session->set_flashdata('msj', 'Ocurrio un problema al momento de recibir su peticion');
                redirect(base_url().'index.php/subestaciones/crear_trans');
            }
        }
        
        public function crear(){
            $data['subs'] = $this->subest_model->getAll_subestaciones();
            $this->load->view('templates/header');	
            $this->load->view('subestaciones/crear_sub',$data);
            $this->load->view('templates/footer');
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
                    if($this->input->post('isMod')=='True'){
                        $response = $this->subest_model->mod_subest($this->input->post('idSub'));
                    }else{
                        $response = $this->subest_model->set_subest();
                    }
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
                    if($response){
                        //$this->load->view('subestaciones/exito');
                        $this->session->set_flashdata('msj', 'Exito');
                    }else{
                        //$this->load->view('subestaciones/errordb');
                        $this->session->set_flashdata('msj', 'Error');
                    }
            }
        }
        
        public function set_trans_sub(){
            $response = $this->subest_model->set_trans_sub();
            echo json_encode($response);
        }
}
?>