<?php 
	$this->load->view("header");
	$this->load->view("sistema/navigation");
?>
<!-- *************************************************** 
    Estrutura do dashboard: possui uma área de 
    saudação com um menu e alguns cards contendo
    informações básicas de agendamentos e cadastrados
  
********************************************************-->
<div class="my-main">
    <div class="row" style="">
        <div class="col-md-6">
            <div class="block mp-dashboard-panel">
                <h3 class="mp-h3">Dashboard</h3>
                <div class="container">
                    <h2>Olá, seja bem vindo <b><?=$this->session->userdata('nome')?></b></h2>
                    <p>Você está no painel adminstrativo do MyPet!</p>
                    <p>Aqui você poderá gerenciar:</p>
                    <ul>
                        <li><a href="<?=base_url('sistema/servicos')?>">Serviços</a></li>
                        <li><a href="<?=base_url('sistema/clientes')?>">Clientes</a></li>
                        <li><a href="<?=base_url('sistema/animais')?>">Animais</a></li>
                        <li><a href="<?=base_url('sistema/agendamentos')?>">Agendamentos</a></li>
                        <li><a href="<?=base_url('sistema/users')?>">Usuários</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <a class="mp-dashboard-a" href="<?=base_url('sistema/agendamentos')?>">
                            <div class="card mp-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title mp-dashboard-title">Agendados hoje</h5>
                                    <p class="card-text mp-dashboard-text"><?=$agendados_hoje; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="mp-dashboard-a" href="<?=base_url('sistema/agendamentos')?>">  
                            <div class="card mp-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title mp-dashboard-title">Agendados essa semana</h5>
                                    <p class="card-text mp-dashboard-text"><?=$agendados_semana; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <a class="mp-dashboard-a" href="<?=base_url('sistema/clientes')?>">
                            <div class="card mp-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title mp-dashboard-title">Cadastrados hoje</h5>
                                    <p class="card-text mp-dashboard-text"><?=$cadastrados_hoje; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="mp-dashboard-a" href="<?=base_url('sistema/clientes')?>">
                            <div class="card mp-dashboard-card">
                                <div class="card-body">
                                    <h5 class="card-title mp-dashboard-title">Cadastrados essa semana</h5>
                                    <p class="card-text mp-dashboard-text"><?=$cadastrados_semana; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>