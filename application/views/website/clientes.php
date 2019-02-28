<?php 
	$this->load->view("header");
	$this->load->view('website/navigation');
    $this->load->view("messages"); 
?>
<!-- *************************************** 
    Área reservada do cliente

    3 partes principais:
        1. Dados pessoais
        2. Gerenciamento de animais
        3. Listagem de agendamentos
********************************************-->

<div class="my-main">
	<div class="container">
        <!-- Dados Pessoais -->
		<div class="block">
			<div class="mp-actions">
				<button type="button"  class="ml-2 mb-1 close mp-btn" data-toggle="modal" data-target="#editarDadosModal">
      				<i class="fas fa-pen"></i>
    			</button>
			</div>
			<h3 class="mp-h3">Meus dados</h3>

			<div class="mp-content-clientes">
    			<p>Nome: <b><?=$nome?></b></p>
    			<p>Email: <b><?=$email?></b></p>
    			<p>Celular: <b><?=$celular?></b></p>
    			<p>Data de Nascimento: <b><?=formataDataBr($dt_nascimento)?></b></p>
    			<p>CPF: <b><?=$cpf?></b></p>
			</div>	
		</div>
        <!-- Gerenciamento de animais -->
		<div class="block" style="margin-top: 40px;">
			<div class="mp-actions">
				<button type="button"  class="ml-2 mb-1 close mp-btn blue" data-toggle="modal" data-target="#novoAnimalModal">
      				<i class="fas fa-plus" style="font-size: 18px"></i>
    			</button>
			</div>
			<h3 class="mp-h3">Meus Animais</h3>
			<div class="mp-content-clientes">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th style="width: 30%">Nome</th>
									<th>Tipo</th>
									<th>Raça</th>
									<th>Data de Nascimento</th>
									<th>Ações</th>
								</tr>
							</thead>
							<tbody>
							<?php if($animais) foreach ($animais as $animal) { ?>
								<tr>
									<?php 
										if($animal['dt_nascimento'] != ""){
										$animal['dt_nascimento'] = formataDataBr($animal['dt_nascimento']);}
										$s = json_encode($animal);?>
									<td><?=$animal['nome']?></td>
									<td><?=$animal['tipo']?></td>
									<td><?=$animal['raca']?></td>
									<td><?=$animal['dt_nascimento']?></td>
									<td>
										<button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#editarAnimalModal" data-whatever='<?=$s;?>' >
						      				<i class="fas fa-pen"></i>
						    			</button>

		                        		<button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#excluirAnimalModal" data-whatever='<?=$s;?>' >
						      				<i class="fas fa-times"></i>
						    			</button>				
		                        	</td>
								</tr>
							<?php } else { ?>
								<tr>
									<td colspan="5">Nenhum dado encontrado</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
        <!-- Listagem de agendamentos -->
		<div class="block" style="margin-top: 40px;">
			<h3 class="mp-h3">Agendamentos</h3>
			<div class="mp-content-clientes">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th style="width: 20%">Nome do Animal</th>
									<th style="width: 50%">Serviços</th>
									<th>Agendado em</th>
								</tr>
							</thead>
							<tbody>
							<?php if($agendamentos) foreach ($agendamentos as $agendamento) { ?>
								<tr>
									<?php $s = json_encode($agendamento);?>
									<td><?=$agendamento['nome']?></td>
									<td><?=$agendamento['servicos']?></td>
									<td><?=formataDataBr($agendamento['created_at'])?></td>
								</tr>

							<?php } else { ?>
								<tr>
									<td colspan="3">Nenhum dado encontrado</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<!-- *************************************** 
  Modais

  1. Modal de editar dados
  2. Modal de novo animal
  3. Modal de editar animal
  4. Modal de excluir animal
********************************************-->
<!--Modal editar dados -->
<div class="modal fade" id="editarDadosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mp-logo-center">
                    <img src="<?=base_url('assets/img/my-pet-small.png')?>">
                </div>
      	        <h3 class="mp-modal-title">Editar dados pessoais</h3>
                <form method="post" action="<?=base_url('clientes/editar-dados')?>" id="cadastrarValidation">
    		        <input type="text" name="nome" placeholder="Nome" value="<?=$nome?>">
                    <input type="text" name="email" placeholder="E-mail" value="<?=$email?>">
                    <input type="text" name="celular" placeholder="Celular" value="<?=$celular?>">
                    <div class="row">
                    	<div class="col-md-6">
                    		<input type="text" name="cpf" placeholder="CPF" value="<?=$cpf?>">
                    	</div>
                    	<div class="col-md-6">
                    		<input type="text" name="dt-nasc" placeholder="Data de Nascimento" value="<?=formataDataBr($dt_nascimento)?>">
                    	</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-primary-custom">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal novo animal -->
<div class="modal fade" id="novoAnimalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
      	        <div class="mp-logo-center">
                    <img src="<?=base_url('assets/img/my-pet-small.png')?>">
                </div>
      	        <h3 class="mp-modal-title" >Novo animal</h3>
                <form method="post" action="<?=base_url('clientes/novo-animal')?>" id="animalValidation">
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
                    <button type="submit" class="btn btn-primary btn-primary-custom">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal editar animal -->
<div class="modal fade" id="editarAnimalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
          	    <div class="mp-logo-center">
                    <img src="<?=base_url('assets/img/my-pet-small.png')?>">
                </div>
          	    <h3 class="mp-modal-title" >Editar animal</h3>
                <form method="post" action="<?=base_url('clientes/editar-animal')?>" id="animalEditValidation">	
                    <div class="row">
                    	<div class="col-md-6">
                    		<input type="text" id="animal_editar" name="animal" placeholder="Nome do animal">
                    	</div>
                    	<div class="col-md-6">
                    		<input type="text" id="tipo_editar" name="tipo" placeholder="Tipo (cachorro, gato, ...)">
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                    		<input type="text" id="raca_editar" name="raca" placeholder="Raça">
                    	</div>
                    	<div class="col-md-6">
                    		<input type="text" id="nascimento_editar" name="dt-nasc-animal" placeholder="Data de Nascimento">
                    	</div>
                    </div>
                    <input type="hidden" id="id_editar" name="id">
                    <button type="submit" class="btn btn-primary btn-primary-custom">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal excluir animal -->
<div class="modal fade" id="excluirAnimalModal">
    <div class="modal-dialog" role="document">
        <form method="POST" action="<?=base_url('clientes/excluir-animal');?>">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Deseja realmente excluir o animal <b><span id="nome_excluir"></span></b>?</p>
                    <input type="hidden" name="id" id="id_excluir">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                	<button type="submit" class="btn btn-primary btn-primary-custom">Excluir</button>
            	</div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#editarAnimalModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        console.log(recipient);
          
        var modal = $(this)
        modal.find('#animal_editar').val(recipient.nome)
        modal.find('#tipo_editar').val(recipient.tipo);
        modal.find('#raca_editar').val(recipient.raca);
        modal.find('#nascimento_editar').val(recipient.dt_nascimento);
        modal.find('#id_editar').val(recipient.id);
    });
        
    $('#excluirAnimalModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        console.log(recipient.nome);
          
        var modal = $(this)
        modal.find('#id_excluir').val(recipient.id);
        modal.find('#nome_excluir').text(recipient.nome);
    });
</script>

<script type="text/javascript">
    function dismiss(){
        document.getElementById("mp-toast").style.display="none";
    }

    setTimeout(function() {
        $('#mp-toast').fadeOut('slow');
    }, 3000); 
</script>
    
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/form-validation.js')?>"></script>

</body>
</html>

