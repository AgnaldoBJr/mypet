<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: Animais
	*	
	*	Description: Classe da área admistrativa para controlar o gerenciamento de animais
	*	dos clientes. Possui os métodos para inserção, listagem, alteração e  
	*	exclusão de animais
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/
	class Animais extends CI_Controller {
		
		//Método construtor: verifica sessão
		function __construct(){
			parent::__construct();
			
			if($this->session->userdata('is_logged_in') != 1){
				$this->session->sess_destroy();
				redirect('sistema/login');
			}
			
		}

		//Método que solicita dados de animais e seus donos e carrega a view de operações(CRUD)
		public function index(){
			$campos = "animais.*, clientes.nome as cliente_nome, clientes.email as cliente_email";
			$tables = "animais, clientes";
			$where = "animais.cliente_id = clientes.id";
			$data['dataTable'] = $this->Generic_model->readAndProjectionManyTables($campos, $tables, $where);

			$table = 'animais';
			$campoId = 'id';
			$data['animais'] = $this->Generic_model->readAll($table, $campoId);

			$table = 'clientes';
			$campoId = 'id';
			$data['clientes'] = $this->Generic_model->readAll($table, $campoId);

			$this->load->view('sistema/animais', $data);
		}

		//Método para criar um novo animal e redireciona para a rota especificada
		public function novo(){
			$table = 'animais';
			$campoId = 'id';
			$data = $this->parseAnimal($this->input->post(), 1);
			
			$resultado = $this->Generic_model->insert($table, $campoId, $data);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Cadastrado com sucesso</span>');
				redirect('sistema/animais');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não cadastrado! Tente novamente</span>');	
				redirect('sistema/animais');
			}
		}

		//Método para editar um animal e redireciona para a rota especificada
		public function editar(){
			$table = "animais";
			$campoId = 'id';
			$id = $this->input->post('id');
			$data = $this->parseAnimal($this->input->post(), 2);

			$resultado = $this->Generic_model->update($table, $campoId, $id, $data);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Animal editado com sucesso</span>');
				redirect('sistema/animais');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Animal não editado! Tente novamente</span>');	
				redirect('sistema/animais');
			}
		}

		//Método para excluir um animal e redireciona para a rota especificada	
		public function excluir(){
			$table = 'animais';
			$campoId = 'id';			
			$id = $this->input->post('id');

			$resultado = $this->Generic_model->delete($table, $campoId, $id);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Excluído com sucesso</span>');
				redirect('sistema/animais');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não excluído! Tente novamente</span>');	
				redirect('sistema/animais');
			}
		}

		//Método para realizar o parse dos dados recebidos para ser persistidos como um "objeto" Animal
		public function parseAnimal($data, $method){
			$animal =  array(
							'nome' => $data['animal'], 
							'tipo' => $data['tipo'], 
							'raca' => $data['raca'],
							'dt_nascimento' =>  $data['dt-nasc-animal']!="" ? formataDataDb($data['dt-nasc-animal']) : null, 
						);
			
			if($method == 1){
				$animal['cliente_id'] = $data['cliente'];
			}
			return $animal;
		}
	}