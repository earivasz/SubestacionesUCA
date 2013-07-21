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
            if($idTipo==1){
                $this->load->view('archivos/subir',$data);
            }else{
                $this->load->view('archivos/subir_1',$data);
            }
            $this->load->view('templates/footer');

        }
        
        public function subir_cargas()
        {
            //$this->form_validation->set_rules('file', 'Archivo de cargas', 'required');
            /*$this->form_validation->set_rules('coordY', 'Coordenada Y', 'required');
            $this->form_validation->set_rules('numSub', 'Numero Subestacion', 'required');*/
            /* if ($this->form_validation->run() === FALSE)
            {
                $tname 	  = $_FILES['file']['tmp_name'];
                echo $tname;
                $idSub = $this->input->post('subest');
                $idTipo = $this->input->post('tipo');
                echo 'subestacion: '.$this->input->post('subest');
                echo 'Tipo: '.$this->input->post('tipo');
                $this->mod_archivos($idSub,$idTipo);
            }
            else
            {*/
                $tipo = $this->input->post('tipo');
                $fase = $this->input->post('fase');
                if($tipo == 1){
                    $result = $this->excel_model->cargas();
                }else{
                    $result = $this->excel_model->dato_i_v($tipo,$fase);
                }
                if($result){
                    echo 'exito';
                }else{
                    echo 'fracaso';
                }
            //}
        }
}
?>
