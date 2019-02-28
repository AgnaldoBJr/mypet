<?php 
	$this->load->view("header");
	$this->load->view("sistema/navigation");
?>
<!-- ******************************************* 
	Área de agendamentos contendo 
	filtros e listagens
************************************************-->
<div class="my-main">
	<div class="block">
		<h3 class="mp-h3">Agendamentos</h3>
		<!--Filtros para pesquisa dinâmica na listagem de agendamentos-->
		<div class="row">
			<div class="col-md-3">
				<input class="form-control" id="searchAnimal" type="text" placeholder="Pesquisar por nome do animal..">
			</div>
			<div class="col-md-3">
				<input class="form-control" id="searchCliente" type="text" placeholder="Pesquisar por nome do dono..">
			</div>
			<div class="col-md-3">
				<input class="form-control" id="searchServico" type="text" placeholder="Pesquisar por serviços..">
			</div>
			<div class="col-md-3">
				<input class="form-control" id="searchData" type="text" placeholder="Pesquisar por data..">
			</div>
		</div>
		<!--Listagens de agendamentos-->
		<div class="row" style="margin-top: 50px">
			<div class="col-md-12">
				<table class="table table-striped table-bordered" id="agendamentoTable">
					<thead>
						<tr>
							<th style="width: 30%">Nome do Animal</th>
							<th>Nome do dono</th>
							<th>Serviços</th>
							<th>Data de Agendamento</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
					<?php if($dataTable) foreach ($dataTable as $agendamento) { ?>
						<tr>
						<?php
							if($agendamento['raca'] == ""){
								$agendamento['raca'] = 'Não informado';
							}  
							if ($agendamento['dt_nascimento'] != ""){
								$agendamento['dt_nascimento'] = formataDataBr($agendamento['dt_nascimento']);
							} else {
								$agendamento['dt_nascimento'] = 'Não informado';
							}
							$agendamento['created_at'] = formataDataBr($agendamento['created_at']);
							$s = json_encode($agendamento);
						?>
							<td><?=$agendamento['nome']?></td>
							<td><?=$agendamento['cliente_nome']?></td>
							<td><?=$agendamento['servicos']?></td>
							<td><?=$agendamento['created_at']?></td>
							<td>
								<button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#detalhesModal" data-whatever='<?=$s;?>' >
									<i class="fas fa-info-circle"></i>
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
<!-- *************************************** 
 	
 	Modal para detalhamento dos agendamentos

********************************************-->
<div class="modal fade" id="detalhesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mp-logo-center">
					<img src="<?=base_url('assets/img/my-pet-small.png')?>">
				</div>
				<h3 class="mp-modal-title" >Detalhes</h3>
				<div class="mp-tab-content">
					<div class="row">
						<p class="mp-title">Dados do Cliente</p>
					</div>
					<div class="row">
						<div class="col-md-12">
							Nome: <b><span id="view_cliente"></span></b>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							Email: <b><span id="view_email"></span></b>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-12">
							Celular: <b><span id="view_celular"></span></b>
						</div>
					</div>
					
					<div class="row" style="margin-top: 20px;">
						<p class="mp-title">Dados do Animal</p>
					</div>
					<div class="row">
						<div class="col-md-6">
							Nome: <b><span id="view_nome"></span></b>
						</div>
						
						<div class="col-md-6">
							Tipo: <b><span id="view_tipo"></span></b>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							Raça: <b><span id="view_raca"></span></b>
						</div>
						
						<div class="col-md-6">
							Data de nasc: <b><span id="view_dt_nascimento"></span></b>
						</div>
					</div>
					<div class="row" style="margin-top: 20px;">
						<p class="mp-title">Dados do Agendamento</p>
					</div>
					<div class="row">
						<div class="col-md-12">
							Servicos: <b><span id="view_servicos"></span></b>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							Criado em: <b><span id="view_create"></span></b>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#detalhesModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var recipient = button.data('whatever')
		console.log(recipient);

		var modal = $(this)
		modal.find('#view_cliente').text(recipient.cliente_nome)
		modal.find('#view_email').text(recipient.email);
		modal.find('#view_celular').text(recipient.celular);
		modal.find('#view_nome').text(recipient.nome);
		modal.find('#view_raca').text(recipient.raca);
		modal.find('#view_tipo').text(recipient.tipo);
		modal.find('#view_dt_nascimento').text(recipient.dt_nascimento)
		modal.find('#view_servicos').text(recipient.servicos);
		modal.find('#view_create').text(recipient.created_at);
		
	});	
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
	var table = $('#agendamentoTable').DataTable({
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
	$('#searchAnimal').on( 'keyup', function () {
		table
		.columns( 0 )
		.search( this.value )
		.draw();
	} );

	$('#searchCliente').on( 'keyup', function () {
		table
		.columns( 1 )
		.search( this.value )
		.draw();
	} );

	$('#searchServico').on( 'keyup', function () {
		table
		.columns( 2 )
		.search( this.value )
		.draw();
	} );

	$('#searchData').on( 'keyup', function () {
		table
		.columns( 3 )
		.search( this.value )
		.draw();
	} );
</script>
</body>
</html>