<?php
class Archivos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('excel_model');
                $this->load->helper('url');
                $this->load->helper('form');
                $this->load->library('form_validation');
                //$this->load->library('excel');
	}
              
        public function mod_archivos($idSub,$idTipo)
        {
            $data['subest'] = $idSub;
            $data['tipo'] = $idTipo;
            $this->load->view('templates/header');
            if($idTipo==1 || $idTipo == 4){
                $this->load->view('archivos/subir',$data);
            }else{
                $this->load->view('archivos/subir_1',$data);
            }
            $this->load->view('templates/footer');

        }
        
        public function subir_cargas()
        {
            $tipo = $this->input->post('tipo');
            $fase = $this->input->post('fase');
            $sub = $this->input->post('subest');
            if($tipo == 1){
                $this->form_validation->set_rules('file', 'Archivo de cargas', 'required');
                $this->form_validation->set_message('required', 'El campo "%s" es requerido');
                if ($this->form_validation->run() === FALSE)
                {
                    $this->mod_archivos($sub, $tipo);

                }else{
                    $result = $this->excel_model->cargas();
                    $this->mod_archivos($sub, $tipo);
                }
            }else{
                $this->form_validation->set_rules('file', 'Archivo de cargas', 'required');
                $this->form_validation->set_rules('fase', 'Fase', 'required');
                $this->form_validation->set_message('required', 'El campo "%s" es requerido');
                if ($this->form_validation->run() === FALSE)
                {
                    $this->mod_archivos($sub, $tipo);
                }else{
                    $result = $this->excel_model->dato_i_v($tipo,$fase);
                    $this->mod_archivos($sub, $tipo);
                }
            }
            
                
            
        }
}
?>
