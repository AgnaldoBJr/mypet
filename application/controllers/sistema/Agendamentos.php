<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: Agendamentos
	*	
	*	Description: Classe da área admistrativa para controlar a listagem de agendamentos
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/
	class Agendamentos extends CI_Controller {

		//Método construtor: verifica sessão
		function __construct(){
			parent::__construct();
			
			if($this->session->userdata('is_logged_in') != 1){
				$this->session->sess_destroy();
				redirect('sistema/login');
			}
		}

		//Método para solicitar dados referentes a agendamentos e carrega a view
		public function index(){
			$campos = "animais.*, clientes.nome as cliente_nome, clientes.email, clientes.celular, agendamentos.servicos, agendamentos.created_at";
			$tables = "animais, clientes, agendamentos";
			$where = "animais.cliente_id = clientes.id and animais.id = agendamentos.animal_id";
			$data['dataTable'] = $this->Generic_model->readAndProjectionManyTables($campos, $tables, $where);
			
			$this->load->view('sistema/agendamentos', $data);			
		}
	}