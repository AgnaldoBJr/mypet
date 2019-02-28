<?php 
  $this->load->view("header"); 
  $this->load->view("messages"); 
?>
<!-- *************************************** 
  Estrutura do site(Landing Page)

  Contém três partes principais:
  Header, Seção de Serviços e Footer 
********************************************-->
<!--Header-->
<div class="mp-header">
	<div class="text">
		<img src="<?=base_url('assets/img/my-pet-big.png')?>">

		<h2>Agende um serviço para o seu bichinho de maneira rápido e fácil!</h2>
	
		<button type="button" class="btn btn-primary mp-header-button btn-primary-custom" data-toggle="modal" data-target="<?php if($this->session->userdata('is_logged_in') != 2) echo '#loginModal'; else echo "#agendarModal";?>" style="width: 200px">Agendar</button>
	</div>
	
  <div class="img-wrapper">
    <img src="<?=base_url('assets/img/dog.gif')?>">
  </div>
	
	<nav class="mp-menu">
		<ul>
			<li><a href="#servico">Serviços</a></li>
		
    <?php if($this->session->userdata('is_logged_in') != 2) { ?>
			<li>
        <button class="btn-custom-menu" data-toggle="modal" data-target="#loginModal">Login</button>
      </li>
			<li>
        <button class="btn-custom-menu" data-toggle="modal" data-target="#cadastrarModal">Cadastre-se</button>
      </li>
		<?php } else { ?>
		
    	<li class="dropdown"><a  href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Olá, <?=$this->session->userdata('nome')?> <i class="fas fa-sort-down"></i></a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
			      <a class="dropdown-item" href="<?=base_url('clientes')?>">
                <i class="fas fa-cog"></i> &nbsp; Configurações
            </a>
			      <a class="dropdown-item" href="<?=base_url('logout')?>">
                <i class="fas fa-sign-out-alt"></i> &nbsp; Sair
            </a>			          
			    </div>
			</li>
		<?php } ?>
		</ul>
	</nav>
</div>
<!--Serviços-->
<div class="mp-services" id="servico">
	<div class="container" style="">
    <h3 class="mp-services-title">Serviços</h3>
    <div class="row" style="clear: both;"> 
      <?php if($servicos) foreach ($servicos as $servico) { ?>
      <div class="col-sm-6 col-md-4 col-lg-3 mp-service-card">
        <div class="card mp-card">
          <img src="<?=base_url('uploads/' . $servico['foto'])?>" class="card-img-top mp-img-service-card">
          <div class="card-body">
            <h5 class="card-title mp-dashboard-title"><?=$servico['nome'];  ?></h5>
            <p class="card-text mp-card-text" ><?=$servico['descricao'];?></p>
            <div>  
              <a href="#" class="btn btn-primary btn-primary-custom" data-toggle="modal" data-target="<?php if($this->session->userdata('is_logged_in') != 2) echo '#loginModal'; else echo "#agendarModal";?>" >Agendar
              </a>
              <span class="card-text mp-preco-service-card" >R$ <?=$servico['preco'];?></span>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<!--Footer-->
<div class="mp-footer">
	<div class="container">
		<img src="<?=base_url('assets/img/my-pet-footer.png')?>">
		<h3>By Agnaldo Burgo Junior</h3>
		<p>Avaliação YAPAY - Desenvolvedor</p>
		<p>2019</p>
	</div>
</div>

<!-- *************************************** 
  Modais

  1. Modal de Agendamento com três tabs
  2. Modal de login
  3. Modal de cadastro
********************************************-->
<!--Modal de Agendamento -->
<div class="modal fade" id="agendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
       <div class="mp-logo-center">
          <img src="<?=base_url('assets/img/my-pet-small.png')?>">
        </div>
        <h3 class="mp-modal-title">Agendar</h3>
        <form method="post" action="<?=base_url('agendar')?>" id="agendarValidation">
          <!--Tab1-->
          <div id="mp-tab1" class="mp-tab">
            <?php if($animais == false) {?>
              <div class="mp-empty">
                <p>Ops, você não possui nenhum animal cadastrado!<p>
                <span>Cadastre um animal em suas configurações!</span>
              </div>
            <?php } else {?>
              <div class="mp-tab-content">
                <p>Escolha um de seus animais para continuar:</p>
                <div>
                <?php if($animais) foreach ($animais as $animal){ ?>
                  <input style="width: auto" type="radio" name="animal_id" value="<?=$animal['id']?>"> <?=$animal['nome']?><br>
                <?php } ?>
                </div>
              </div>
            <?php } ?>
            <div class="mp-tab-footer">
              <div id="error" class="error"></div> 
              <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                <?php if($animais != false) {?>
                  <button type="button" class="btn btn-primary btn-primary-custom" onclick="toTab2()">Próximo</button>
                <?php }?>  
                </div>
              </div> 
            </div>
          </div>
          <!--Tab2-->
          <div id="mp-tab2" class="mp-tab" style='display: none'>
            <div class="mp-tab-content">
              Escolha os serviços que deseja:
              <div class="row">
                <?php if($servicos) foreach ($servicos as $servico) { ?>
                <div class="col-md-6">
                  <input style="width: auto" type="checkbox" name="<?php echo 'cb-' . $servico['id']?>" value="<?=$servico['nome']?>"> <?=$servico['nome']?><br>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="mp-tab-footer"> 
              <div class="row">
                <div class="col-md-4">
                  <button type="button" class="btn btn-primary btn-primary-custom" onclick="toTab1()">Voltar</button>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-primary btn-primary-custom" onclick="toTab3()">Próximo</button>
                </div>
              </div>
            </div>
          </div>
          <!--Tab3-->
          <div id="mp-tab3" class="mp-tab" style='display: none'>
            <div class="mp-empty">
              <p>Por enquanto é isso! Você já pode agendar o seus serviços!</p>
              <span>Entraremos em contato para agendar data e hora para o(s) serviço(s) agendado(s). Muito obrigado</span>
            </div>
            <div class="mp-tab-footer">
              <div class="row">
                <div class="col-md-4">
                  <button type="button" class="btn btn-primary btn-primary-custom" onclick="toTab2()">Voltar</button>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <input type="submit" class="btn btn-primary btn-primary-custom" value="Agendar">
                </div>
              </div> 
            </div>
          </div>
        </form>      
      </div>
    </div>
  </div>
</div>
<!--Modal de login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <div class="mp-logo-center">
          <img src="<?=base_url('assets/img/my-pet-small.png')?>">
        </div>
        <h3 class="mp-modal-title">Login</h3>
        <form method="post" action="<?=base_url('entrar')?>" id="loginValidation">
          <input type="text" id="email" name="email" placeholder="E-mail">
          <input type="password" name="senha" placeholder="Senha">
          <button type="submit" class="btn btn-primary btn-primary-custom">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Modal de cadastro-->
<div class="modal fade" id="cadastrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-body">
      	<div class="mp-logo-center">
          <img src="<?=base_url('assets/img/my-pet-small.png')?>">
        </div>
      	<h3 class="mp-modal-title">Cadastrar</h3>
        <form method="post" action="<?=base_url('cadastrar')?>" id="cadastrarValidation">
          <input type="text" name="nome" placeholder="Nome">
          <input type="text" name="email" placeholder="E-mail">
          <input type="password" id="senha" name="senha" placeholder="Senha">
          <input type="password" name="confirma" placeholder="Confirmar senha">
          <input type="text" name="celular" placeholder="Celular">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="cpf" placeholder="CPF">
            </div>
            <div class="col-md-6">
              <input type="text" name="dt-nasc" placeholder="Data de Nascimento">
            </div>
          </div>
        
          <h3 class="mp-modal-title" style="margin-top: 40px; margin-bottom: -10px" >Cadastrar animal</h3>
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="animal" placeholder="Nome do animal">
            </div>
            <div class="col-md-6">
              <input type="text" name="tipo" placeholder="Tipo (cachorro, gato, ...)">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="raca" placeholder="Raça">
            </div>
            <div class="col-md-6">
              <input type="text" name="dt-nasc-animal" placeholder="Data de Nascimento">
            </div>
          </div>
          <div class="mp-modal-footer" style="">
            <span style="color: #2d2de4;">Você poderá cadastrar mais animais depois, nas configurações</span>
          </div>
          <button type="submit" class="btn btn-primary btn-primary-custom">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function toTab1(){
    document.getElementById('mp-tab1').style.display = 'block';
    document.getElementById('mp-tab2').style.display = 'none';
    document.getElementById('mp-tab3').style.display = 'none';
  }

  function toTab2(){
    document.getElementById('mp-tab1').style.display = 'none';
    document.getElementById('mp-tab2').style.display = 'block';
    document.getElementById('mp-tab3').style.display = 'none';
  }

  function toTab3(){
    document.getElementById('mp-tab1').style.display = 'none';
    document.getElementById('mp-tab2').style.display = 'none';
    document.getElementById('mp-tab3').style.display = 'block';
  }

</script>

<script type="text/javascript">
	function dismiss(){
		document.getElementById("mp-toast").style.display="none";
	}

	setTimeout(function() {
    $('#mp-toast').fadeOut('slow');
  }, 5000); 
</script>

<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/form-validation.js')?>"></script>

</body>
</html>