<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: Dashboard
	*	
	*	Description: Classe da área admistrativa para controlar a renderização do daschboard
	*	Realiza as consultas de agendamentos e cadastros de clientes para ser mostrado no painel 
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/
	class Dashboard extends CI_Controller {

		//Método construtor: verifica sessão
		function __construct(){
			parent::__construct();
			
			if($this->session->userdata('is_logged_in') != 1){
				$this->session->sess_destroy();
				redirect('sistema/login');
			}
		}

		//Método que solicita dados e coloca-os em um array data para carregamento do dashboard
		public function index(){
			//Buscando registros de Agendamentos do dia ocorrente
			$sql='SELECT count(created_at) as qtd FROM agendamentos WHERE created_at  = "' . Date('Y-m-d'). '"';
			$data['agendados_hoje'] = $this->Generic_model->justQuery($sql)[0]['qtd'];

			//Buscando registros de Agendamentos da semana
			$sql='SELECT count(created_at) as qtd FROM agendamentos WHERE created_at > (NOW() - INTERVAL 7 DAY)';
			$data['agendados_semana'] = $this->Generic_model->justQuery($sql)[0]['qtd'];
			
			//Buscando registros de Cadastros de clientes do dia ocorrente
			$sql='SELECT count(created_at) as qtd FROM clientes WHERE created_at  = "' . Date('Y-m-d'). '"';
			$data['cadastrados_hoje'] = $this->Generic_model->justQuery($sql)[0]['qtd'];
			
			//Buscando registros de Cadastros de clientes da semana
			$sql='SELECT count(created_at) as qtd FROM clientes WHERE created_at > (NOW() - INTERVAL 7 DAY)';
			$data['cadastrados_semana'] = $this->Generic_model->justQuery($sql)[0]['qtd'];

			$this->load->view('sistema/dashboard', $data);
		}
	}