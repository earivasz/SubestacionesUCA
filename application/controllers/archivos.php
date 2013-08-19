<?php

class Archivos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('excel_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library(array('session', 'form_validation'));
        //$this->load->library('excel');
    }

    public function mod_archivos($idSub, $idTipo) {
        if (!$this->session->userdata('perfil')) {
            redirect(base_url());
        } else {
            switch ($this->session->userdata('perfil')) {
                case '1'://admin
                    $data['subest'] = $idSub;
                    $data['tipo'] = $idTipo;
                    $data['subestacion'] = $this->excel_model->get_subest($idSub);
                    $this->load->view('templates/header');
                    if ($idTipo == 1 || $idTipo == 4) {
                        $this->load->view('archivos/subir', $data);
                    } else {
                        $this->load->view('archivos/subir_1', $data);
                    }
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

    public function subir_cargas() {
        if ($this->input->post('origenCorrecto')) {
            $tipo = $this->input->post('tipo');
            $fase = $this->input->post('fase');
            $sub = $this->input->post('subest');
            $tname = $_FILES['file']['tmp_name'];
            $name = $_FILES['file']['name'];
            if ($tipo == 1) {

                //echo $tname . '<br/>' . $name;
                if ($tname == '' && $name == '') {
                    $this->session->set_flashdata('msj', 'Debe completar los campos obligatorios');
                    redirect(base_url() . "index.php/archivos/crear/" . $sub . "/" . $tipo);
                } else {
                    if (preg_match('/[0-3][0-9]-[0-1][0-9]-[0-9]{2,2}-CARGAS/', $name)) {
                        if($this->validarFecha($name)){
                            $result = $this->excel_model->cargas();
                        }else{
                            $this->session->set_flashdata('msj', 'Formato de fecha en el nombre es invalido. Debe ser dd-mm-yy');
                        }
                    } else {
                        $this->session->set_flashdata('msj', 'El archivo no tiene el formato de nombre esperado. Debe ser dd-mm-yy-CARGAS');
                    }
                    //$result = $this->excel_model->cargas();
                    redirect(base_url() . "index.php/archivos/crear/" . $sub . "/" . $tipo);
                }
            } else {
                //validar fase trambien
                if ($tipo == 4) {
                    if ($tname == '' && $name == '') {
                        $this->session->set_flashdata('msj', 'Debe completar los campos obligatorios');
                        redirect(base_url() . "index.php/archivos/crear/" . $sub . "/" . $tipo);
                    } else {
                        if (preg_match('/[0-3][0-9]-[0-1][0-9]-[0-9]{2,2}-PRINCIPAL/', $name)) {
                            if($this->validarFecha($name)){
                                $result = $this->excel_model->dato_i_v($tipo, $fase);
                            }else{
                                $this->session->set_flashdata('msj', 'Formato de fecha en el nombre es invalido. Debe ser dd-mm-yy');
                            }
                        } else {
                            $this->session->set_flashdata('msj', 'El archivo no tiene el formato de nombre esperado. Debe ser dd-mm-yy-PRINCIPAL');
                        }
                        //$result = $this->excel_model->dato_i_v($tipo, $fase);
                        redirect(base_url() . "index.php/archivos/crear/" . $sub . "/" . $tipo);
                    }
                } else {
                    if (($tname == '' && $name == '') || $fase == '') {
                        $this->session->set_flashdata('msj', 'Debe completar los campos obligatorios');
                        redirect(base_url() . "index.php/archivos/crear/" . $sub . "/" . $tipo);
                    } else {
                        if((preg_match('/[0-3][0-9]-[0-1][0-9]-[0-9]{2,2}-CORRIENTE-[A-C]/', $name) && $tipo==2)||(preg_match('/[0-3][0-9]-[0-1][0-9]-[0-9]{2,2}-VOLTAJE-[A-C]/', $name) && $tipo==3)){
                            if($this->validarFecha($name) && $this->validaFase($name, $fase)){
                                $result = $this->excel_model->dato_i_v($tipo, $fase);
                            }else{
                                $this->session->set_flashdata('msj', 'Formato de fecha en el nombre es invalido o fase no correcta. Debe ser dd-mm-yy para la fecha y A,B o C para la fase.');
                            }
                            //$result = $this->excel_model->dato_i_v($tipo, $fase);
                        }else{
                            if($tipo==2){
                                $this->session->set_flashdata('msj', 'El archivo no tiene el formato de nombre esperado. Debe ser dd-mm-yy-CORRRIENTE-A');
                            }else{
                                $this->session->set_flashdata('msj', 'El archivo no tiene el formato de nombre esperado. Debe ser dd-mm-yy-VOLTAJE-A');
                            }
                            
                        }
                        //$result = $this->excel_model->dato_i_v($tipo, $fase);
                        redirect(base_url() . "index.php/archivos/crear/" . $sub . "/" . $tipo);
                    }
                }
            }
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/no_auth');
            $this->load->view('templates/footer');
        }
    }

    public function mant_archivos() {
        if (!$this->session->userdata('perfil')) {
            redirect(base_url());
        } else {
            switch ($this->session->userdata('perfil')) {
                case '1'://admin
                    $data['archivos'] = $this->excel_model->get_archivos();
                    $this->load->view('templates/header');
                    $this->load->view('archivos/mantenimiento', $data);
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

    public function set_archivo() {
        if ($this->input->post('origenCorrecto')) {
            try {
                $this->excel_model->set_archivo();
                redirect(base_url() . "index.php/archivos/mantenimiento");
            } catch (Exception $e) {
                $this->session->set_flashdata('msj', 'Ocurrio un problema para actualizar el archivo, favor intente de nuevo.');
                redirect(base_url() . "index.php/archivos/mantenimiento");
            }
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/no_auth');
            $this->load->view('templates/footer');
        }
    }
    
    private function validarFecha($name){
        $partes = explode("-", $name);
        return checkdate($partes[1], $partes[0], $partes[2]);
    }
    
    private function validaFase($name,$fase){
        $partes = explode("-", $name);
        $faseA = explode(".", $partes[4]);
        switch($fase){
            case '1':
                if ($faseA[0] == 'A'){
                    return true;
                }else{
                    return false;
                }
                break;
            case '2':
                if ($faseA[0] == 'B'){
                    return true;
                }else{
                    return false;
                }
                break;
            case '3':
                if ($faseA[0] == 'C'){
                    return true;
                }else{
                    return false;
                }
                break;
        }
    }

}

?>
