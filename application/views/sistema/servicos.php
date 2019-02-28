<?php 
	$this->load->view("header");
	$this->load->view("sistema/navigation");
  $this->load->view("messages"); 
?>
<!-- ******************************************* 
  Área de serviços contendo listagem
************************************************-->
<div class="my-main">
	<div class="block">
		<div class="mp-actions">
      <button type="button"  class="ml-2 mb-1 close mp-btn blue" data-toggle="modal" data-target="#cadastrarServicoModal">
          <i class="fas fa-plus" style="font-size: 18px"></i>
      </button>
    </div>
    <h3 class="mp-h3">Serviços</h3>
    <!--Listagem de serviços-->
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped table-bordered" id="servicosTable">
					<thead>
						<tr>
              <th style="width: 55px"></th>
							<th style="width: 30%">Nome</th>
							<th>Descrição</th>
							<th>Preço</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
					<?php if($servicos) foreach ($servicos as $servico) { ?>
						<tr>
							<?php $s = json_encode($servico);?>
              <td><img class="mp-img-table" src="<?=base_url('uploads/'. $servico['foto'])?>"></td>
							<td><?=$servico['nome']?></td>
							<td><?=$servico['descricao']?></td>
							<td><?=$servico['preco']?></td>
							<td>
								<button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#editarServicoModal" data-whatever='<?=$s;?>' >
                  <i class="fas fa-pen"></i>
                </button>

                <button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#excluirServicoModal" data-whatever='<?=$s;?>' >
                  <i class="fas fa-times"></i>
                </button> 		
              </td>
						</tr>
					<?php } else { ?>
						<tr>
							<td colspan="4">Nenhum dado encontrado</td>
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

  1. Modal de novo serviço
  2. Modal de editar serviço
  3. Modal de excluir serviço
  
********************************************-->
<!--Modal de novo Serviço com upload de imagem-->
<div class="modal fade" id="cadastrarServicoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <form method="POST" action="<?=base_url('sistema/servicos/novo');?>" enctype="multipart/form-data" id = "servicoValidation">
      <div class="modal-content">                        
        <div class="block block-themed block-transparent remove-margin-b">
          <div class="block-header bg-primary-dark">
              <h3 class="block-title">Novo serviço</h3>
          </div>
          <div class="mp-wrapper-img-cad">
            <img class="mp-img-cad" id="up-img" src="<?=base_url('assets/img/camera.png')?>">
          </div>
          <div class="mp-button-img-cad">
            <label for="upload-photo" class="btn btn-primary btn-primary-custom">Upload</label>
            <input type="file" name="upload" id="upload-photo" onchange="loadFile(this)"/>
          </div>
        	<input type="text" placeholder="Nome do Serviço" name="nome">
        	<textarea rows="2" placeholder="Descrição" name="descricao"></textarea>
        	<input type="text" placeholder="Preço (R$)" name="preco">       
        </div>                          
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-primary-custom">Cadastrar</button>
        </div>
      </div> 
    </form>
  </div>
</div>
<!--Modal de editar Serviço com upload de imagem-->
<div class="modal fade" id="editarServicoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <form method="POST" action="<?=base_url('sistema/servicos/editar');?>" enctype="multipart/form-data" id="servicoEditValidation">
      <div class="modal-content">                        
        <div class="block block-themed block-transparent remove-margin-b">
          <div class="block-header bg-primary-dark">
              <h3 class="block-title">Editar serviço</h3>
          </div>
          <div class="mp-wrapper-img-cad">
            <img class="mp-img-cad" id="up-img2" src="<?=base_url('assets/img/camera.png')?>">
          </div>
          <div class="mp-button-img-cad">
            <label class="btn btn-primary btn-primary-custom" for="upload2">Upload
              <input id="upload2" type="file" name="upload" onchange="loadFileEdit(this)">
            </label>
          </div>
          <input type="text" placeholder="Nome do Produto" name="nome" id="nome_editar">
          <input type="text" placeholder="Descrição" name="descricao" id="descricao_editar">
          <input type="text" placeholder="Preço (R$)" name="preco" id="preco_editar">
          <input type="hidden" name="id" id="id_editar" >
          <input type="hidden" name="foto_atual" id="foto_atual" >      
        </div>
        <div class="modal-footer">        
          <button type="submit" class="btn btn-primary btn-primary-custom">Editar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!--Modal de excluir Serviço -->
<div class="modal fade" id="excluirServicoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <form method="POST" action="<?=base_url('sistema/servicos/excluir');?>">
      <div class="modal-content">
        <div class="modal-body">
          <p>Deseja realmente excluir o servico <b><span id="nome_excluir"></span></b>?</p>
          <input type="hidden" name="id" id="id_excluir">
          <input type="hidden" name="foto" id="foto_excluir" >
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
  $('#excluirServicoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('whatever');
    console.log(recipient.nome);
    
    var modal = $(this);
    modal.find('#nome_excluir').text(recipient.nome)
    modal.find('#id_excluir').val(recipient.id);
    modal.find('#foto_excluir').val(recipient.foto);
  });

  $('#editarServicoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var recipient = button.data('whatever')
    //console.log(recipient);
    
    var modal = $(this)
    var src ="<?=base_url('uploads/')?>" + recipient.foto;
    console.log(src)
    $('#up-img2').attr('src', src);
   
    modal.find('#nome_editar').val(recipient.nome);
    modal.find('#descricao_editar').val(recipient.descricao);
    modal.find('#preco_editar').val(recipient.preco);
    modal.find('#id_editar').val(recipient.id);
    modal.find('#foto_atual').val(recipient.foto);
  });
</script>

<script type="text/javascript">
  function loadFile(e){
    console.log("loadFile");
    document.getElementById('up-img').src = window.URL.createObjectURL(e.files[0]);
  }
  function loadFileEdit(e){
    console.log("loadFileEdit");
    document.getElementById('up-img2').src = window.URL.createObjectURL(e.files[0]);
  }
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
  var table = $('#servicosTable').DataTable({
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

