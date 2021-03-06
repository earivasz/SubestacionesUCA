<?php
class Graficos_control extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('subest_model');
	}

        public function graficosDatos(){
            if($this->input->post('origenCorrecto')){
                $id =  $this->input->post('id');
                $fechaIni = $this->input->post('fechaIni'); 
                $fechaFin = $this->input->post('fechaFin');
//                $date = DateTime::createFromFormat('m-d-Y', '04-15-2013');
//$date->modify('+1 day');
//echo $date->format('m-d-Y');
                //echo date('d-m-Y', strtotime($fechaFin, "+1 days"));
                
                $fase = $this->input->post('fase');
                $tipo = $this->input->post('tipo');
                $datos = Array();
                $linea = "";
                if($tipo == "pri"){
                    $data['datosArr'] = $this->subest_model->get_tablaPrincipal($id, $fechaIni, $fechaFin);
                    foreach($data['datosArr'] as $trans):
                        $linea = $trans['fechaHora'] . "/|\\" . $trans['datop'];
                        array_push($datos, explode("/|\\", $linea));
                    endforeach;
                }
                if($tipo == "armi"){
                    $data['datosArr'] = $this->subest_model->get_tablaArmI($id, $fechaIni, $fechaFin, $fase);
                    foreach($data['datosArr'] as $trans):
                        $linea = $trans['fechaHora'] . "/|\\" . $trans['datoi'];
                        array_push($datos, explode("/|\\", $linea));
                    endforeach;
                }
                if($tipo == "armv"){
                    $data['datosArr'] = $this->subest_model->get_tablaArmV($id, $fechaIni, $fechaFin, $fase);
                    foreach($data['datosArr'] as $trans):
                        $linea = $trans['fechaHora'] . "/|\\" . $trans['datov'];
                        array_push($datos, explode("/|\\", $linea));
                    endforeach;
                }
                //$this->load->view('subestaciones/graficosDatos', $data);
                echo json_encode($datos);
            }
            else{
                $this->load->view('templates/header');
                $this->load->view('templates/no_auth');
                $this->load->view('templates/footer');
            }
        }
}
?>
