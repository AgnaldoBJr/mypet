<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: ClientesWeb
	*	
	*	Description: Classe para controlar a área de clientes no website. Possui os métodos 
	*	para editar dados, gerenciar os animais e listar os agendamentos feitos
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/
	class ClientesWeb extends CI_Controller {

		//Método construtor: verifica sessão
		function __construct(){
			parent::__construct();
			
			if($this->session->userdata('is_logged_in') != 2){
				$this->session->sess_destroy();
				redirect('');
			}
		}

		//Metodo para solicitar a lista de clientes, de animais e de agendamentos e carrega a view de operações(CRUD)
		public function index(){
			$table = 'clientes';
			$campoId = 'id';
			$id = $this->session->userdata('id');
			$data=$this->Generic_model->readById($table, $campoId, $id);

			
			$table = 'animais';
			$campoId = 'cliente_id';
			$id = $this->session->userdata('id');
			$data['animais'] = $this->Generic_model->readAllWhere($table, $campoId, $id);
			
			
			$campos = "animais.nome, agendamentos.*";
			$tables = "animais, agendamentos";
			$where = "animais.id = agendamentos.animal_id and animais.cliente_id = '" . $this->session->userdata('id') . "'";
			$data['agendamentos'] = $this->Generic_model->readAndProjectionManyTables($campos, $tables, $where);

			$this->load->view('website/clientes', $data);
		}

		//Método para editar os dados pessoais do cliente
		public function editarDados() {
			$table = 'clientes';
			$campoId = 'id';			
			$id = $this->session->userdata('id');
			$data = $this->parseCliente($this->input->post());			
			$resultado = $this->Generic_model->update($table, $campoId, $id, $data);


			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Editado com sucesso</span>');
				redirect('clientes');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não editado! Tente novamente</span>');	
				redirect('clientes');
			}
		}

		//Método para editar um animal
		public function editarAnimal() {
			$table = "animais";
			$campoId = 'id';
			$id = $this->input->post('id');
			$data = $this->parseAnimal($this->input->post());
			$resultado = $this->Generic_model->update($table, $campoId, $id, $data);


			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Animal editado com sucesso</span>');
				redirect('clientes');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Animal não editado! Tente novamente</span>');	
				redirect('clientes');
			}
		}

		//Método para excluir um animal
		public function excluirAnimal() {
			$table = 'animais';
			$campoId = 'id';			
			$id = $this->input->post('id');
			$resultado = $this->Generic_model->delete($table, $campoId, $id);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Excluído com sucesso</span>');
				redirect('clientes');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não excluído! Tente novamente</span>');	
				redirect('clientes');
			}
		}

		//Médodo para adicionar um animal
		public function novoAnimal() {
			$table = 'animais';
			$campoId = 'id';
			$data = $this->parseAnimal($this->input->post());
			
			$resultado = $this->Generic_model->insert($table, $campoId, $data);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Cadastrado com sucesso</span>');
				redirect('clientes');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não cadastrado! Tente novamente</span>');	
				redirect('clientes');
			}
		}

		//Método para realizar o parse dos dados recebidos para o "objeto" cliente que será persistido
		public function parseCliente($data){
			$cliente =  array(
							'nome' => $data['nome'], 
							'email' => $data['email'], 
							'dt_nascimento' => formataDataDb($data['dt-nasc']) , 
							'cpf' =>  $data['cpf'], 
							'celular' =>  $data['celular'], 
							'updated_at' =>  Date('Y-m-d'), 
						);
			return $cliente;
		}

		//Método para realizar o parse dos dados recebidos para o "objeto" animal que será persistido
		public function parseAnimal($data){
			$animal =  array(
							'cliente_id' => $this->session->userdata('id'),
							'nome' => $data['animal'], 
							'tipo' => $data['tipo'], 
							'raca' => $data['raca'],
							'dt_nascimento' =>  $data['dt-nasc-animal']!="" ? formataDataDb($data['dt-nasc-animal']) : null, 
						);
			return $animal;
		}
	}