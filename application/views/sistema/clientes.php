<?php 
	$this->load->view("header");
	$this->load->view("sistema/navigation");
	$this->load->view("messages"); 
?>
<!-- ******************************************* 
	Área de clientes contendo 
	filtros e listagens
************************************************-->
<div class="my-main">
	<div class="block">
		<div class="mp-actions">
			<button type="button"  class="ml-2 mb-1 close mp-btn blue" data-toggle="modal" data-target="#cadastrarClienteModal">
				<i class="fas fa-plus" style="font-size: 18px"></i>
			</button>
		</div>
		<h3 class="mp-h3">Clientes</h3>
		<!--Filtros para pesquisa dinâmica na listagem de clientes-->
		<div class="row">
			<div class="col-md-6">
				<input class="form-control" id="searchNome" type="text" placeholder="Pesquisar por nome..">
			</div>
			<div class="col-md-6">
				<input class="form-control" id="searchEmail" type="text" placeholder="Pesquisar por email..">
			</div>
		</div>
		<!--Listagem de animais-->
		<div class="row" style="margin-top: 50px">
			<div class="col-md-12">
				<table class="table table-striped table-bordered" id="clientesTable">
					<thead>
						<tr>
							<th style="width: 30%">Nome</th>
							<th>Email</th>
							<th>Data de Nascimento</th>
							<th>CPF</th>
							<th>Celular</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php if($clientes) foreach ($clientes as $cliente) { ?>
						<tr>
							<?php 
							$cliente['dt_nascimento']=formataDataBr($cliente['dt_nascimento']);
							$s = json_encode($cliente);
							?>
							<td><?=$cliente['nome']?></td>
							<td><?=$cliente['email']?></td>
							<td><?=$cliente['dt_nascimento']?></td>
							<td><?=$cliente['cpf']?></td>
							<td><?=$cliente['celular']?></td>
							<td>
								<button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#editarClienteModal" data-whatever='<?=$s;?>' >
									<i class="fas fa-pen"></i>
								</button>

								<button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#excluirClienteModal" data-whatever='<?=$s;?>' >
									<i class="fas fa-times"></i>
								</button>						
							</td>
						</tr>

						<?php } else { ?>
						<tr>
							<td colspan="6">Nenhum dado encontrado</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- *************************************** 
  Modais

  1. Modal de novo cliente
  2. Modal de editar cliente
  3. Modal de excluir cliente
  
********************************************-->
<!--Modal de novo cliente-->
<div class="modal fade" id="cadastrarClienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mp-logo-center">
					<img src="<?=base_url('assets/img/my-pet-small.png')?>">
				</div>
				<h3 class="mp-modal-title" >Cadastrar cliente</h3>
				<form method="post" action="<?=base_url('sistema/clientes/novo')?>" id="cadastrarValidation">
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
					<button type="submit" class="btn btn-primary btn-primary-custom">Cadastrar</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!--Modal de editar cliente-->
<div class="modal fade" id="editarClienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mp-logo-center">
					<img src="<?=base_url('assets/img/my-pet-small.png')?>">
				</div>
				<h3 class="mp-modal-title" >Editar cliente</h3>
				<form method="post" action="<?=base_url('sistema/clientes/editar')?>" id="editarValidation">
					<input type="text" id="nome_editar" name="nome" placeholder="Nome">
					<input type="text" id="email_editar" name="email" placeholder="E-mail">
					<input type="text" id="cel_editar" name="celular" placeholder="Celular">
					<div class="row">
						<div class="col-md-6">
							<input type="text" id="cpf_editar" name="cpf" placeholder="CPF">
						</div>
						<div class="col-md-6">
							<input type="text" id="nascimento_editar" name="dt-nasc" placeholder="Data de Nascimento">
						</div>
					</div>
					<input type="hidden" id="id_editar" name="id">
					<button type="submit" class="btn btn-primary btn-primary-custom">Editar</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!--Modal de excluir cliente-->
<div class="modal fade" id="excluirClienteModal">
	<div class="modal-dialog" role="document">
		<form method="POST" action="<?=base_url('sistema/clientes/excluir');?>">
			<div class="modal-content">
				<div class="modal-body">
					<p>Deseja realmente excluir o(a) cliente <b><span id="nome_excluir"></span></b>?</p>
					<p class="mp-modal-footer">Esta ação irá excluir todos os animais que pertencem a ele(a).</p>
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
	$('#editarClienteModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var recipient = button.data('whatever')
		console.log(recipient);

		var modal = $(this)
		modal.find('#nome_editar').val(recipient.nome)
		modal.find('#email_editar').val(recipient.email);
		modal.find('#cel_editar').val(recipient.celular);
		modal.find('#cpf_editar').val(recipient.cpf);
		modal.find('#nascimento_editar').val(recipient.dt_nascimento);
		modal.find('#id_editar').val(recipient.id);
	});

	$('#excluirClienteModal').on('show.bs.modal', function (event) {
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

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
	var table = $('#clientesTable').DataTable({
		"language" : {
			"sEmptyTable": "Nenhum registro encontrado",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			"sInfoFiltered": "(Filtrados de _MAX_ registros)",
			"sInfoPostFix": "",
			"sInfoThousands": ".",
			"sLengthMenu": "_MENU_ resultados por página",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado",
			"sSearch": "Pesquisar",
			"oPaginate": {
				"sNext": "Próximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Último"
			},
			"oAria": {
				"sSortAscending": ": Ordenar colunas de forma ascendente",
				"sSortDescending": ": Ordenar colunas de forma descendente"
			}
		},
		"paging":   true,
		"ordering": false,
		"info":     false
	});
	$('#searchNome').on( 'keyup', function () {
		table
		.columns( 0 )
		.search( this.value )
		.draw();
	} );

	$('#searchEmail').on( 'keyup', function () {
		table
		.columns( 1 )
		.search( this.value )
		.draw();
	} );
</script>
</body>
</html>