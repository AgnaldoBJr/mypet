<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: Users
	*	
	*	Description: Classe da área admistrativa para controlar o gerenciamento de usuários
	*	do sistema, possui os métodos para inserção, listagem, alteração e exclusão de 
	*	usuários
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/
	class Users extends CI_Controller {

		//Método construtor: verifica sessão
		function __construct(){
			parent::__construct();
	
			if($this->session->userdata('is_logged_in') != 1){
				$this->session->sess_destroy();
				redirect('sistema/login');
			}		
		}

		//Método para solicitar a lista de usuários e carregar a view de operações
		public function index(){
			$table = 'usuarios';
			$data['users'] = $this->Generic_model->readAll($table);

			$this->load->view('sistema/users', $data);
		}

		//Método para inserir um nova usuário
		public function novo(){
			$data = $this->parseData($this->input->post(), 1);
			$table = 'usuarios';
			$campoId = 'id';

			//----------------------------------------------
			//Verificar se já existe e-mail cadastrado
			$table = 'usuarios';
			$users = $this->Generic_model->readAll($table);

			$cont = 0;
			foreach ($users as $user) {
				if($user['email'] == $data['email'])
					$count++;
			}
			//Caso já exista email cadastrado
			if( $count > 0 ){
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Este e-mail já foi cadastrado</span>');	
				redirect("sistema/users");
			}
			//-----------------------------------------------

			$resultado = $this->Generic_model->insert($table, $campoId, $data);
			
			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Usuário cadastrado com sucesso</span>');
				redirect("sistema/users");  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não cadastrado! Tente novamente</span>');	
				redirect("sistema/users");
			}
		}

		//Método para editar um usuário
		public function editar(){
			$table = 'usuarios';
			$campoId = 'id';			
			$id = $this->input->post('id');
			$data = $this->parseData($this->input->post(), 2);
			
			$resultado = $this->Generic_model->update($table, $campoId, $id, $data);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Editado com sucesso</span>');
				redirect('sistema/users');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não editado! Tente novamente</span>');	
				redirect('sistema/users');
			}
		}
		
		//Método para excluir um usuário
		public function excluir(){
			$table = 'usuarios';
			$campoId = 'id';			
			$id = $this->input->post('id');

			$resultado = $this->Generic_model->delete($table, $campoId, $id);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
		  					'<span style="font-weight: 600; color:#3f3ff0">Excluído com sucesso</span>');
				redirect('sistema/users');  		
		    } else{
				$this->session->set_flashdata('msg', '
							<span style="color: red; font-weight: 600">Não excluído! Tente novamente</span>');	
				redirect('sistema/users');
			}
		}

		//Método para realizar o parse dos dados recebidos montando o "objeto" user para ser inserido ou alterado
		//O parâmetro method aceita os valores 1 (inserção) e 2 (alteração)
		public function parseData($data, $method){
			$user =  array(
							'nome' => $data['nome'], 
							'email' => $data['email'], 	 
						);

			if($method == 1){
				$user['senha'] = md5($data['senha']);
				$user['created_at'] = Date('Y-m-d');
			
			} else if ($method == 2){
				$user['updated_at'] = Date('Y-m-d');
			
			}
			return $user;
		}
	}