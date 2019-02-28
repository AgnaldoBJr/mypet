<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: Clientes
	*	
	*	Description: Classe da área admistrativa para controlar o gerenciamento de clientes
	*	Possui os métodos para inserção, listagem, alteração e exclusão de clientes
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/
	class Clientes extends CI_Controller {

		//Método construtor: verifica sessão
		function __construct(){
			parent::__construct();
	
			if($this->session->userdata('is_logged_in') != 1){
				$this->session->sess_destroy();
				redirect('sistema/login');
			}		
		}

		//Metodo para solicitar a lista de clientes e carrega a view de operações(CRUD)
		public function index(){		
			$table = 'clientes';
			$data['clientes'] = $this->Generic_model->readAll($table);

			$this->load->view('sistema/clientes', $data);
		}

		//Método para inserir um cliente
		public function novo(){
			$data = $this->parseData($this->input->post(), 1);
			$table = 'clientes';
			$campoId = 'id';

			//----------------------------------------------
			//Verificar se já existe e-mail cadastrado
			$table = 'clientes';
			$clientes = $this->Generic_model->readAll($table);

			$cont = 0;
			foreach ($clientes as $cliente) {
				if($cliente['email'] == $data['email'])
					$count++;
			}
			//Caso já exista email cadastrado
			if( $count > 0 ){
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Este e-mail já foi cadastrado</span>');	
				redirect("sistema/clientes");
			}
			//-----------------------------------------------

			$resultado = $this->Generic_model->insert($table, $campoId, $data);
			
			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Cliente cadastrado com sucesso</span>');
				redirect("sistema/clientes");  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não cadastrado! Tente novamente</span>');	
				redirect("sistema/clientes");
			}
		
		}

		//Método para editar um cliente
		public function editar(){
			$table = 'clientes';
			$campoId = 'id';			
			$id = $this->input->post('id');
			$data = $this->parseData($this->input->post(), 2);
			
			$resultado = $this->Generic_model->update($table, $campoId, $id, $data);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Editado com sucesso</span>');
				redirect('sistema/clientes');  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não editado! Tente novamente</span>');	
				redirect('sistema/clientes');
			}
		}

		//Método para excluir um cliente e os animais que pertencem a ele (Não foi utilizado cascade no banco de dados)
		public function excluir(){
			$table = 'clientes';
			$campoId = 'id';			
			$id = $this->input->post('id');

			$resultado = $this->Generic_model->delete($table, $campoId, $id);


			$table = 'animais';
			$campoId = 'cliente_id';			
			$id = $this->input->post('id');

			$resultado = $this->Generic_model->delete($table, $campoId, $id);


			if($resultado == true){	
				$this->session->set_flashdata('msg', 
		  					'<span style="font-weight: 600; color:#3f3ff0">Excluído com sucesso</span>');
				redirect('sistema/clientes');  		
		    } else{
				$this->session->set_flashdata('msg', '
							<span style="color: red; font-weight: 600">Não excluído! Tente novamente</span>');	
				redirect('sistema/clientes');
			}
		}

		//Método para realizar o parse dos dados recebidos montando os "objetos" cliente e animal para serem inseridos ou alterados
		//O parâmetro method aceita os valores 1 (inserção) e 2 (alteração)
		public function parseData($data, $method){
			$cliente =  array(
							'nome' => $data['nome'], 
							'email' => $data['email'], 	 
							'dt_nascimento' => formataDataDb($data['dt-nasc']), 
							'cpf' =>  $data['cpf'], 
							'celular' =>  $data['celular'], 
						);

			if($method == 1){
				$cliente['senha'] = md5($data['senha']);
				$cliente['created_at'] = Date('Y-m-d');
			
			} else if ($method == 2){
				$cliente['updated_at'] = Date('Y-m-d');
			
			}
			return $cliente;
		}
	}