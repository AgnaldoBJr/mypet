<?php
	defined('BASEPATH') OR die ('No direct script access allowed');
	/***************************************************************************************
	*	Class: Mypet
	*	
	*	Description: Classe de renderização Home(website) do sistema, para controlar entrada 
	*	na área de clientes, cadastro de clientes e cadastros de agendamentos dos clientes
	*
	*   Author: Agnaldo Burgo Junior
	*	Created at: Fev/2019
	*
	*****************************************************************************************/


	class Mypet extends CI_Controller {

		//Método construtor: carrega a model de acesso
		function __construct(){
			parent::__construct();
			
			$this->load->model('Acesso_model');
		}

		//Solicita os dados de serviços e animais e carrega a view do website, a tela principal
		public function index(){			
			$table = 'servicos';
			$data['servicos'] = $this->Generic_model->readAll($table);

			$table = 'animais';
			$campoId = 'cliente_id';
			$id = $this->session->userdata('id');
			$data['animais'] = $this->Generic_model->readAllWhere($table, $campoId, $id);

			$this->load->view('website/home', $data);
		}

		//Função para realizar validar login e entrar na área de clientes 
		public function entrar(){
			$dataLogin = $this->input->post();
      		$res = $this->Acesso_model->readEmailWeb($dataLogin);
      		
  			if(!$res){
  				$this->session->set_flashdata('msg', '<span style="color: red; font-weight: 600">Senha ou usuários inválidos</span>');
  			}
  			else{
  				if (md5($dataLogin['senha']) != $res[0]->senha){
  						$this->session->set_flashdata('msg', '<span style="color: red; font-weight: 600">Senha ou usuários inválidos</span>');
  				}
				else {
					//Validação de login com sucesso
					//Início de sessão e redirect
					
					$dataSession = array (
						'id' => $res[0]->id,
						'nome' => $res[0]->nome,
						'email'=> $res[0]->email,
						'is_logged_in' => 2
					);      							
					
					$this->session->set_flashdata('msg', 
						'<span style="font-weight: 600;color:#3f3ff0">Logado com sucesso...</span><br><br>
					<span style="font-size: 12px;">Acesse <span style="font-weight: 600">Configurações</span> no menu principal para editar o seu perfil
					</span>');
					$this->session->set_userdata($dataSession); 

					redirect("");
				}
  			}
  			$table = 'servicos';
			$data['servicos'] = $this->Generic_model->readAll($table);

			$table = 'animais';
			$campoId = 'id';
			$id = $this->session->userdata('id');
			$data['animais'] = $this->Generic_model->readAllWhere($table, $campoId, $id);

  			$this->load->view('website/home', $data);
		}

		//Método para os clientes se cadastrarem e cadastrarem de modo obrigatório um animal
		//É feita a validação de email ao ser cadastrado, ver se é único
		public function cadastrar(){
			$data = $this->parseData($this->input->post());
			$table = 'clientes';
			$campoId = 'id';
			$cliente = $data['cliente'];

			//----------------------------------------------
			//Verificar se já existe e-mail cadastrado
			$clientes = $this->Generic_model->readAll($table);

			// Realizei a coreção do nome da variável
			$count = 0;
			
			// Aqui você terá um problema de performace, pois imagine uma listagem de milhares de clientes, você perdera performace com o trafego de rede e lentidão na intereção de um por um
			// Seria melhor e mais performatico a seguinte queries:
			// SELECT count(1) from clientes where email = LOWER('email@docliente.com');
			
			foreach ($clientes as $cliente) {
				if($cliente['email'] == $data['email'])
					$count++;
			}
			
			
			//Caso já exista email cadastrado
			// Nuca adicione tag HTML no controller, isso é responsábilidade da View
			
			if( $count > 0 ){
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Este e-mail já foi cadastrado</span>');	
				redirect("");
			}
			//-----------------------------------------------
			
			$resultado = $this->Generic_model->insert($table, $campoId, $cliente);
			
			$data['animal']['cliente_id'] = $resultado['id'];
			$table = 'animais';
			$animal = $data['animal'];
			$resultado2 = $this->Generic_model->insert($table, $campoId, $animal);

			if($resultado == true){	
				$this->session->set_flashdata('msg', 
  							'<span style="font-weight: 600; color:#3f3ff0">Parabéns, você está cadastrado!</span><br><br>
							<span style="font-size: 12px;">Faça seu login para continuar</span>');
				redirect("");  		
		    } else{
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não cadastrado! Tente novamente</span>');	
				redirect("");
			}
		}

		//Método para cadastrar um novo agendamento
		public function agendar(){
			// Nunca deixe qualquer tipo de saida no controller, primeiro seria uma falha de segurança, segundo poderia causar algum problema de session, em códigos legados
			var_dump($this->input->post());
			$data = $this->input->post();

			//Preparando os dados para salvar
			$agenda['animal_id'] = $this->input->post('animal_id');
			$agenda['servicos'] = $this->servicosToString($data);
			$agenda['created_at'] = Date('Y-m-d');

			//Validação simples
			if($this->input->post('animal_id') == "" || $agenda['servicos'] == ""){
				$this->session->set_flashdata('msg', 
							'<span style="color: red; font-weight: 600">Não agendado</span>
							<br><br><span style="font-size: 12px;">Selecione um animal e pelo menos um serviço!</span>');	
				redirect("");
			} else {
				$table = 'agendamentos';
				$campoId = 'id';
				$resultado = $this->Generic_model->insert($table, $campoId, $agenda);

				if($resultado == true){	
					$this->session->set_flashdata('msg', 
	  							'<span style="font-weight: 600; color:#3f3ff0">Agendado com sucesso!</span>');
					redirect("");  		
			    } else{
					$this->session->set_flashdata('msg', 
								'<span style="color: red; font-weight: 600">Não agendado! Tente novamente</span>');	
					redirect("");
				}
			}
		}
		//Função para destruir a sessão e ser redirecionado para a home(website)
		public function logout(){
			$this->session->sess_destroy();
			redirect('');
		}

		//Função para realizar o parse de dados recebidos e montar os "objetos" clientes e animal para serem persistidos
		public function parseData($data){
			$data['cliente'] =  array(
							'nome' => $data['nome'], 
							'email' => $data['email'], 
							'senha' => md5($data['senha']), 
							'dt_nascimento' => formataDataDb($data['dt-nasc']), 
							'cpf' =>  $data['cpf'], 
							'celular' =>  $data['celular'], 
							'created_at' =>  Date('Y-m-d'), 
						);

			$data['animal'] =  array(
							'nome' => $data['animal'], 
							'tipo' => $data['tipo'], 
							'raca' => $data['raca'],
							'dt_nascimento' =>  $data['dt-nasc-animal']!="" ? formataDataDb($data['dt-nasc-animal']) : null, 
						);
			
			return $data;
		}

		//Método para tranformar um array de serviços em uma string de serviço
		public function servicosToString($data){
			$servicos = "";
			foreach($data as $value){
  				$mykey = key($data);
  				echo $mykey;
  				if(substr($mykey, 0 , 2) == "cb")
  					$servicos .= $value . ", ";
  				next($data);
			}
			$servicos = substr($servicos, 0, strlen($servicos)-2);
			
			return $servicos;
		}
	}

