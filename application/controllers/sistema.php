<?php
class Sistema extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('subest_model');
                $this->load->helper('url');
                $this->load->helper('form');
                //$this->load->library('form_validation');
                $this->load->library(array('session','form_validation'));
	}
        
        public function mod_sistema(){
            if (!$this->session->userdata('perfil')){
                redirect(base_url());
            }else{
                switch ($this->session->userdata('perfil')) {
                    case '1'://admin
                        $data['subest'] = $this->subest_model->get_subestaciones_con_perfil();
                        $data['vals_sistema'] = $this->subest_model->get_valsistema_all();
                        $this->load->view('templates/header');
                        $this->load->view('sistema/mod_sistema', $data);
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
        
        public function mod_sistema_action(){
            if($this->input->post('origenCorrecto')){
                $this->form_validation->set_rules('multafp', 'Limite de multa para Factor de Potencia: ', 'required|numeric');
                $this->form_validation->set_rules('multathdi', 'Limite de multa para THD-I: ', 'required|numeric');
                $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
                if ($this->form_validation->run() === FALSE)
                {
                    $this->session->set_flashdata('msj', 'Faltan campos obligatorios');
                    redirect(base_url().'index.php/sistema/mod_sistema');
                }
                else
                {
                    $multafp = $_POST['multafp'];
                    $multathdi = $_POST['multathdi'];
                    unset($_POST['multafp']);
                    unset($_POST['multathdi']);
                    $subs = Array();
                    foreach($_POST as $val){
                        array_push($subs, $val);
                    }
                    $this->subest_model->set_sistema($subs, $multafp, $multathdi);
                    $this->session->set_flashdata('msj', 'Valores guardados correctamente');
                    redirect(base_url().'index.php/sistema/mod_sistema');
                }
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/no_auth');
                $this->load->view('templates/footer');
            }
        }
}
?>
