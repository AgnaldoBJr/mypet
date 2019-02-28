<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: Servicos
	*	
	*	Description: Classe da área admistrativa para controlar o gerenciamento de servicos
	*	que aparecerão na home. Possui os métodos para inserção, listagem, alteração e  
	*	exclusão de usuários
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/
	class Servicos extends CI_Controller {

		//Método construtor: verifica sessão e carrega o helper File
		function __construct(){
			parent::__construct();

			$this->load->helper('file');

			if($this->session->userdata('is_logged_in') != 1){
				$this->session->sess_destroy();
				redirect('sistema/login');
			}
		}

		//Metodo para solicitar a lista de serviços e carregar a view de operações(CRUD)
		public function index(){
			$table = 'servicos';
			$campoId = 'id';
			$data['servicos'] = $this->Generic_model->readAll($table, $campoId);

			$this->load->view('sistema/servicos', $data);
		}

		//Método que faz a inserção de um novo serviço recebendo um arquivo de imagem
		public function novo() {
			$data = $this->parseData($this->input->post(), $_FILES['upload']['name'], 1);
			$table = 'servicos';
			$campoId = 'id';
			
			$foto = $_FILES['upload'];
			$this->salvar($foto);

			$resultado = $this->Generic_model->insert($table, $campoId, $data);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Serviço cadastrado com sucesso</span>');
				redirect("sistema/servicos");  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não cadastrado! Tente novamente</span>');	
				redirect("sistema/servicos");
			}
		}

		//Método para fazer a alteração de serviço, cuidando da parte do upload de imagens
		public function editar() {
			$table = 'servicos';
			$campoId = 'id';			
			$id = $this->input->post('id');
			/*
				Para a atualização da imagem temos duas possibilidades:
				1. Se a imagem foi atualizada, será necessário
					a. Salvar a imagem salva;
					b. Deletar imagem antiga;
				2. Se a imagem não foi atualizada, serão atualizados apenas os dados, permanecendo a imagem já inserida;
			*/
			$foto = $this->input->post('foto_atual');
			
			if($_FILES['upload']['name'] != ""){
				
				$data = $this->parseData($this->input->post(), $_FILES['upload']['name'], 2);
				$novaFoto = $_FILES['upload'];
				$this->salvar($novaFoto);
				
				$file = './uploads/' . $foto;
				unlink($file);
			} else {
				
				$data = $this->parseData($this->input->post(), $foto, 2);
			}


			$resultado = $this->Generic_model->update($table, $campoId, $id, $data);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Serviço editado com sucesso</span>');
				redirect("sistema/servicos");  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não editado! Tente novamente</span>');	
				redirect("sistema/servicos");
			}
		}

		//Método para excluir um serviço, bem como as imagens do servidor
		public function excluir() {
			$table = 'servicos';
			$campoId = 'id';			
			$id = $this->input->post('id');
			$resultado = $this->Generic_model->delete($table, $campoId, $id);

			//Excluindo a foto
			$foto = $this->input->post('foto');
			$file = './uploads/' . $foto;
			unlink($file);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Serviço excluído com sucesso</span>');
				redirect("sistema/servicos");  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não excluído! Tente novamente</span>');	
				redirect("sistema/servicos");
			}
		}

		//Método para salvar imagem no servidor
		public function salvar($foto){
	 		$configuracao = array(	
			    			'upload_path'   => './uploads/',
			         		'allowed_types' => 'gif|jpg|png',
			         		'file_name'     => $foto['name'],
			     		);

     		$this->load->library('upload');    
 			$this->upload->initialize($configuracao);
    		
    		if ($this->upload->do_upload('upload'))
       			echo 'Arquivo salvo com sucesso.'; 
   			else
        		echo $this->upload->display_errors(); 
 		}
	    
	    //Método para realizar o parse dos dados recebidos montando o "objeto" serviço para ser inserido ou alterado
		//O parâmetro method aceita os valores 1 (inserção) e 2 (alteração)
	    public function parseData($data, $foto, $method){
	    	$servico = array(
	    				'nome' => $data['nome'], 
	    				'descricao' => $data['descricao'], 
	    				'preco' => $data['preco'], 
	    				'foto' => $foto
	    			);

	    	if($method == 1){
	    		$servico['created_at'] = Date('Y-m-d');
	    	
	    	} else if($method == 2){
	    		$servico['updated_at'] = Date('Y-m-d');

	    	}

	    	return $servico;
	    }
	}
