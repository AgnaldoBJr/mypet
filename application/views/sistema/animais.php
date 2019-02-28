<?php 
	$this->load->view("header");
	$this->load->view("sistema/navigation");
	$this->load->view("messages"); 
?>
<!-- ******************************************* 
	Área de animais contendo 
	filtros e listagens
************************************************-->
<div class="my-main">
	<div class="block">
		<div class="mp-actions">
			<button type="button"  class="ml-2 mb-1 close mp-btn blue" data-toggle="modal" data-target="#cadastrarAnimalModal">
				<i class="fas fa-plus" style="font-size: 18px"></i>
			</button>
		</div>
		<h3 class="mp-h3">Animais</h3>
		<!--Filtros para pesquisa dinâmica na listagem de animais-->
		<div class="row">
			<div class="col-md-6">
				<input class="form-control" id="searchNome" type="text" placeholder="Pesquisar por nome(dono)..">
			</div>
			<div class="col-md-6">
				<input class="form-control" id="searchEmail" type="text" placeholder="Pesquisar por email..">
			</div>
		</div>
		<!--Listagem de animais-->
		<div class="row" style="margin-top: 50px">
			<div class="col-md-12">
				<table class="table table-striped table-bordered" id="animaisTable">
					<thead>
						<tr>
							<th style="width: 30%">Nome do Animal</th>
							<th>Tipo</th>
							<th>Nome do dono</th>
							<th>E-mail do dono</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
					<?php if($dataTable) foreach ($dataTable as $animal) { ?>
						<tr>
							<?php 
								if($animal['dt_nascimento'] != "") 
									$animal['dt_nascimento']=formataDataBr($animal['dt_nascimento']);
								$s = json_encode($animal);
							?>
							<td><?=$animal['nome']?></td>
							<td><?=$animal['tipo']?></td>
							<td><?=$animal['cliente_nome']?></td>
							<td><?=$animal['cliente_email']?></td>
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
<!-- *************************************** 
  Modais

  1. Modal de novo animal
  2. Modal de editar animal
  3. Modal de excluir animal
  
********************************************-->
<!--Modal de novo animal-->
<div class="modal fade" id="cadastrarAnimalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-scrollable" role="document">
    	<div class="modal-content">
      		<div class="modal-body">
      			<div style="text-align: center">
      				<img src="<?=base_url('assets/img/my-pet-small.png')?>">
      			</div>
      			<h3 style="width: 100%; text-align: center; font-size:16px; text-transform: uppercase; margin-top: 20px;" >Cadastrar animal</h3>
        		<form method="post" action="<?=base_url('sistema/animais/novo')?>" id="animalValidation">
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
                    <select  type="text" id="cliente-animal" name="cliente" placeholder="Escolha uma opção...">
                        <option value=<?php null;?>>Escolha uma opção...</option>
                    <?php
                        if($clientes) foreach ($clientes as $data){ 
                    ?>
                        <option value="<?=$data['id']?>"><?=$data['nome']?></option>
                    <?php } ?>
                    </select>
                	<button type="submit" class="btn btn-primary btn-primary-custom">Cadastrar</button>
            	</form>
      		</div>
    	</div>
  	</div>
</div>
<!--Modal de editar animal-->
<div class="modal fade" id="editarAnimalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-scrollable" role="document">
    	<div class="modal-content">
      		<div class="modal-body">
      			<div style="text-align: center">
      				<img src="<?=base_url('assets/img/my-pet-small.png')?>">
      			</div>
      			<h3 style="width: 100%; text-align: center; font-size:16px; text-transform: uppercase; margin-top: 20px;" >Editar animal</h3>
        		<form method="post" action="<?=base_url('sistema/animais/editar')?>" id="animalEditValidation">
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
<!--Modal de excluir animal-->
<div class="modal fade" id="excluirAnimalModal">
	<div class="modal-dialog" role="document">
		<form method="POST" action="<?=base_url('sistema/animais/excluir');?>">
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

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	var table = $('#animaisTable').DataTable({
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
		.columns( 2 )
		.search( this.value )
		.draw();
	} );

	$('#searchEmail').on( 'keyup', function () {
		table
		.columns( 3 )
		.search( this.value )
		.draw();
	} );
</script>
</body>
</html>