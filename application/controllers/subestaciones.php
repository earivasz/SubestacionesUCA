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
            if($this->input->post('origenCorrecto')){
                $response = $this->subest_model->borrar_fotos($this->input->post('idSub'), $this->input->post('arrFotos'));
                if($response){
                    echo 'exito';
                }else{
                    echo 'fracaso';
                }
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/no_auth');
                $this->load->view('templates/footer');
            }
        }
        
        public function galeria($id){
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $data['idSubest'] = $id;
                        $data['fotos'] = $this->subest_model->get_fotos($id);
                        $data['subest'] = $this->subest_model->get_subest($id);
                        $data['ultimocorrel'] = $this->subest_model->get_latestCorrelFoto($id);
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/galeria', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://invitado
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;
                    default:
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;        
                }
            }
        }
        
        public function subir_archivo(){
            if($this->input->post('origenCorrecto')){
                $rutaGuardar = 'img/';
                $numImagenes = count($_FILES['arrimg']['name']);
                $ultCorr = $this->input->post('ultimocorrel');
                $sub = $this->input->post('subest');
                $arrimagenes = Array();
                $allgood = 1;
                $picnum = $this->subest_model->get_valsistema('picnum');
                $picnum = $picnum[0]['valor'];

                $allowedExts = array("jpeg", "jpg");
                for($ar=0;$ar<$numImagenes;$ar++){//hago uno por uno
                    $temp = explode(".", $_FILES["arrimg"]["name"][$ar]);
                    $extension = end($temp);
                     if ((($_FILES["arrimg"]["type"][$ar] == "image/jpeg")
                     || ($_FILES["arrimg"]["type"][$ar] == "image/jpg")
                    || ($_FILES["arrimg"]["type"][$ar] == "image/pjpeg"))
                     && ($_FILES["arrimg"]["size"][$ar] < 2097152)//max 2 mb
                     && in_array($extension, $allowedExts))
                       {
                           if ($_FILES["arrimg"]["error"][$ar] > 0)
                             {
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
                                $picnum = $picnum + 1;

                                $image_info = getimagesize($_FILES["arrimg"]["tmp_name"][$ar]);
                                $image_width = $image_info[0];
                                $image_height = $image_info[1];
                                $new_width = 300;
                                $new_height = $image_width/$image_height;
                                $new_height = $new_width/$new_height;
                                //jpeg output quality
                                $quality = 100;
                                $destimg=imagecreatetruecolor($new_width,$new_height); 
                                $srcimg=imagecreatefromjpeg($_FILES["arrimg"]["tmp_name"][$ar]); 
                                imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)); 
                                imagejpeg($destimg,$rutaGuardar . $picnum . '.jpeg',$quality);
                               //move_uploaded_file($_FILES["arrimg"]["tmp_name"][$ar],
                               //$rutaGuardar . $sub . '/' . $picnum . '.jpeg');
                               //echo "Stored in: " . $rutaGuardar . $_FILES["arrimg"]["name"][$ar];
                               $ultCorr = $ultCorr + 1;
                               $tta = Array('correl' => $ultCorr, 'url' => base_url() . 'img/' . $picnum . '.jpeg');
                               array_push($arrimagenes, $tta);
                               //}
                             }
                       }
                     else
                       {
                         $allgood = 0;
                       }
                }
                //guardo en la base de datos
                if($allgood == 1){
                    $allgood = $this->subest_model->crear_fotos($sub, $arrimagenes);
                    $allgood2 = $this->subest_model->set_valsistema('picnum', '' . $picnum);
                    if(!$allgood)
                        $this->session->set_flashdata('msj', 'Ocurrio un error al subir las imagenes al servidor');
                }
                else{
                    $this->session->set_flashdata('msj', 'Ocurrio un error al subir las imagenes al servidor');
                }
                redirect(base_url().'index.php/subestaciones/galeria/'. $sub);
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/no_auth');
                $this->load->view('templates/footer');
            }
        }
        
	public function index()
	{   
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                $data['perfil'] = $this->session->userdata('perfil');
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $data['subest'] = $this->subest_model->get_subestaciones();
                        $this->load->view('templates/header', $data);
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $data['subest'] = $this->subest_model->get_subestaciones();
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://invitado
                        $data['subest'] = $this->subest_model->get_subestaciones_xperfil('3');
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/home', $data);
                        $this->load->view('templates/footer');
                        break;
                    default:
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;        
                }
            }
	}
        
        public function detalle($id)
	{
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                $data['subest'] = $this->subest_model->get_subest($id);
                $data['transformadores'] = $this->subest_model->get_transformadores($id);
                $data['fotos'] = $this->subest_model->get_fotosSubest($id);
                $data['subestId'] = $id;
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/detalle', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/detalle', $data);
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://invitado
                        if($this->subest_model->check_subestacion_invitado($id)){
                            $this->load->view('templates/header');
                            $this->load->view('subestaciones/detalle', $data);
                            $this->load->view('templates/footer');
                        }
                        else{
                            $this->load->view('templates/header');
                            $this->load->view('templates/no_auth');
                            $this->load->view('templates/footer');
                        }
                        break;
                    default:
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;
                }
            }
	}
        
        public function crear_trans(){
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $data['subs'] = $this->subest_model->get_subestaciones();
                        $data['trans'] = $this->subest_model->getAll_trans();
                        $this->load->view('templates/header');
                        $this->load->view('subestaciones/crear_trans', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://invitado
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;
                    default:
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;
                }
            }
        }
        
        public function set_trans(){
            if($this->input->post('origenCorrecto')){
                try{
                    $this->output->enable_profiler(TRUE);
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
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/no_auth');
                $this->load->view('templates/footer');
            }
        }
        
        public function crear(){
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $data['subs'] = $this->subest_model->getAll_subestaciones();
                        $this->load->view('templates/header');	
                        $this->load->view('subestaciones/crear_sub',$data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://invitado
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;
                    default:
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;        
                }
            }
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
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $data['cargas'] = $this->subest_model->get_cargas($id);
                        $data['subest'] = $this->subest_model->get_subest($id);
                        $data['idSub'] = $id;
                        $this->load->view('templates/header');	
                        $this->load->view('subestaciones/cargas', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://invitado
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;
                    default:
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;        
                }
            }
        }
        
//        public function modificar($id)
//        {
//            $data['subest'] = $this->subest_model->get_subest($id);
//            $data['idSub'] = $id;
//            $this->load->view('templates/header');	
//            $this->load->view('subestaciones/modificar', $data);
//            $this->load->view('templates/footer');
//        }
        
        public function graficos($id, $tipo)
        {
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                $data['subest'] = $this->subest_model->get_subest($id);
                $data['idSub'] = $id;
                $data['tipo'] = $tipo;
                $data['multafp'] = $this->subest_model->get_valsistema('multafp');
                $data['multathdi'] = $this->subest_model->get_valsistema('multathdi');
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $this->load->view('templates/header');	
                        $this->load->view('subestaciones/graficos', $data);
                        $this->load->view('templates/footer');
                        break;
                    case '2'://consultas
                        $this->load->view('templates/header');	
                        $this->load->view('subestaciones/graficos', $data);
                        $this->load->view('templates/footer');
                        break;    
                    case '3'://invitado
                        if($this->subest_model->check_subestacion_invitado($id) && $tipo == 'pri'){
                            $this->load->view('templates/header');	
                            $this->load->view('subestaciones/graficos', $data);
                            $this->load->view('templates/footer');
                        }
                        else{
                            $this->load->view('templates/header');
                            $this->load->view('templates/no_auth');
                            $this->load->view('templates/footer');
                        }
                        break;
                    default:
                        $this->load->view('templates/header');
                        $this->load->view('templates/no_auth');
                        $this->load->view('templates/footer');
                        break;
                }   
            }
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