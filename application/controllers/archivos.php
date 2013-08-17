<?php

class Archivos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('excel_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library(array('session','form_validation'));
        //$this->load->library('excel');
    }

    public function mod_archivos($idSub, $idTipo) {
        $data['subest'] = $idSub;
        $data['tipo'] = $idTipo;
        $this->load->view('templates/header');
        if ($idTipo == 1 || $idTipo == 4) {
            $this->load->view('archivos/subir', $data);
        } else {
            $this->load->view('archivos/subir_1', $data);
        }
        $this->load->view('templates/footer');
    }

    public function subir_cargas() {
        $tipo = $this->input->post('tipo');
        $fase = $this->input->post('fase');
        $sub = $this->input->post('subest');
        $tname = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        if ($tipo == 1) {

            //echo $tname . '<br/>' . $name;
            if ($tname == '' && $name == '') {
                $this->session->set_flashdata('msj', 'Debe completar los campos obligatorios');
                redirect(base_url()."index.php/archivos/crear/".$sub."/".$tipo);
            } else {
                $result = $this->excel_model->cargas();
                redirect(base_url()."index.php/archivos/crear/".$sub."/".$tipo);
            }
        } else {
            //validar fase trambien
            if ($tipo==4){
                if ($tname == '' && $name == '') {
                $this->session->set_flashdata('msj', 'Debe completar los campos obligatorios');
                redirect(base_url()."index.php/archivos/crear/".$sub."/".$tipo);
                } else {
                    $result = $this->excel_model->dato_i_v($tipo, $fase);
                    redirect(base_url()."index.php/archivos/crear/".$sub."/".$tipo);
                }
            }else{
                if (($tname == '' && $name == '') || $fase == '') {
                $this->session->set_flashdata('msj', 'Debe completar los campos obligatorios');
                redirect(base_url()."index.php/archivos/crear/".$sub."/".$tipo);
            } else {
                $result = $this->excel_model->dato_i_v($tipo, $fase);
                redirect(base_url()."index.php/archivos/crear/".$sub."/".$tipo);
            }
            }
            
        }
    }
    
    public function mant_archivos(){
        $data['archivos'] = $this->excel_model->get_archivos();
        $this->load->view('templates/header');
        $this->load->view('archivos/mantenimiento', $data);
        $this->load->view('templates/footer');
    }
    
    public function set_archivo(){
        try{
            $this->excel_model->set_archivo();
            redirect(base_url()."index.php/archivos/mantenimiento");
        }catch(Exception $e){
            $this->session->set_flashdata('msj', 'Ocurrio un problema para actualizar el archivo, favor intente de nuevo.');
            redirect(base_url()."index.php/archivos/mantenimiento");
        }
    }

}

?>
