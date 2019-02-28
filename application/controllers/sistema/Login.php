<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
    /***************************************************************************************
    *   Class: Login
    *   
    *   Description: Classe para acesso à área adminstrativa, verifica a sessão e possui a 
    *   função de entrada do sistema e logout
    *
    *   Author: Agnaldo Burgo Junior
    *   Created at: Fev/2019
    *
    *****************************************************************************************/
	class Login extends CI_Controller {

        //Método construtor: carrega os arquivos necessários
		function __construct(){
			parent::__construct();

            $this->load->model('Acesso_model');
			$this->load->library('form_validation');
			$this->load->helper('form');
		}

        //Método que verifica a sessão e carrega a view de login
		public function index(){
			if($this->session->userdata('is_logged_in') == 1){
				redirect('sistema/dashboard');
			}  else if($this->session->userdata('is_logged_in') == 2){
				$this->session->sess_destroy();
				redirect('sistema/login');
			}
			$data['error_database'] = "";
			$this->load->view('sistema/login', $data);
		}

		//Função para a validação de login e se tudo estiver correto, redireciona para o sistema
		// Created_at: 27/02/2017
        // Updated_at: Fev/2019 
		public function entrar(){
			$this->form_validation->set_rules('email', '', 'required|trim|min_length[5]');
			$this->form_validation->set_rules('senha', '', 'required|md5|trim');
			
			$this->form_validation->set_message('required', 'Este campo deve ser preenchido');
			$this->form_validation->set_message('min_length', 'O campo {field} deve ter no mínimo {param} caracteres');

			$data['error_database'] = 'Preencha todos os campos para entrar!';

			if($this->form_validation->run()){
				$dataLogin = $this->input->post();
      			$res = $this->Acesso_model->readEmail($dataLogin);
      		    
      			if(!$res){
      				$data['error_database'] = 'Senha ou usuário inválidos';
      			}
      			else{
      				if ($dataLogin['senha'] != $res[0]->senha){
  						$data['error_database'] = 'Senha ou usuário inválidos';
  					}
  					else {
  						$dataSession = array (
								'id' => $res[0]->id,
								'nome' => $res[0]->nome,
								'email'=> $res[0]->email,
								'is_logged_in' => 1
							);      							
  						
  						$this->session->set_userdata($dataSession); 
						redirect('sistema/dashboard');
  					}
      			}
      		}
        	$this->load->view('sistema/login', $data);
		}

        //Método para redirecionar para o login
		public function redirecionar(){
			redirect('sistema/login');
		}

        //Método para destruir a sessão e levá-los a tela de login
		public function logout(){
			$this->session->sess_destroy();
			redirect('sistema/login');
		}
	}