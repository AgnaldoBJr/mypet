<?php 
    $this->load->view("header");
    $this->load->view("sistema/navigation");
    $this->load->view("messages"); 
?>
<!-- ******************************************* 
  Área de usuários contendo listagem
************************************************-->
<div class="my-main">
    <div class="block">
        <div class="mp-actions">
            <button type="button"  class="ml-2 mb-1 close mp-btn blue" data-toggle="modal" data-target="#cadastrarUserModal">
                <i class="fas fa-plus" style="font-size: 18px"></i>
            </button>
        </div>
        <h3 class="mp-h3">Usuários do Sistema</h3>
        <!--Listagem de usuários-->
        <div class="row" style="margin-top: 50px">
            <div class="col-md-12">
                <table class="table table-striped table-bordered" id="usersTable">
                    <thead>
                        <tr>
                            <th style="width: 30%">Nome</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($users) foreach ($users as $user) { ?>
                        <tr>
                            <?php $s = json_encode($user);?>
                            <td><?=$user['nome']?></td>
                            <td><?=$user['email']?></td>
                            <td>       
                            <?php if($user['id'] == 1) { ?>
                                <button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#detalhesModal" data-whatever='<?=$s;?>' >
                                    <i class="fas fa-info-circle"></i>
                                </button>   
                            <?php } else { ?>
                                <button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#editarUserModal" data-whatever='<?=$s;?>' >
                                    <i class="fas fa-pen"></i>
                                </button>
                                
                                <button type="button"  class="close mp-btn2" data-toggle="modal" data-target="#excluirUserModal" data-whatever='<?=$s;?>' >
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php } ?>
                            </td>
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
<!-- *************************************** 
  Modais

  1. Modal de detalhes para a não exclusão
  2. Modal de novo usuário
  3. Modal de editar usuário
  4. Modal de excluir usuário
********************************************-->
<!-- Modal de detalhes para a não exclusão -->
<div class="modal fade" id="detalhesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mp-logo-center">
                    <img src="<?=base_url('assets/img/my-pet-small.png')?>">
                </div>
                <h3 class="mp-modal-title" >Detalhes</h3>
                <div class="mp-tab">
                    <div class="mp-empty">
                        <p>Ops, você não pode editar ou excluir esse usuário!<p>
                        <span>Fale com o desenvolvedor em (14)99625-7952 !</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de novo usuário -->
<div class="modal fade" id="cadastrarUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mp-logo-center">
                    <img src="<?=base_url('assets/img/my-pet-small.png')?>">
                </div>
                <h3 class="mp-modal-title" >Cadastrar usuário do sistema</h3>
                <form method="post" action="<?=base_url('sistema/users/novo')?>" id="cadastrarValidation">
                    <input type="text" name="nome" placeholder="Nome">
                    <input type="text" name="email" placeholder="E-mail">
                    <input type="password" id="senha" name="senha" placeholder="Senha">
                    <input type="password" name="confirma" placeholder="Confirmar senha">    
                    <button type="submit" class="btn btn-primary btn-primary-custom">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal de editar usuário -->
<div class="modal fade" id="editarUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mp-logo-center">
                    <img src="<?=base_url('assets/img/my-pet-small.png')?>">
                </div>
                <h3 class="mp-modal-title" >Editar usuário do sistema</h3>
                <form method="post" action="<?=base_url('sistema/users/editar')?>" id="editarValidation">
                    <input type="text" id="nome_editar" name="nome" placeholder="Nome">
                    <input type="text" id="email_editar" name="email" placeholder="E-mail">
                    <input type="hidden" id="id_editar" name="id">
                    <button type="submit" class="btn btn-primary btn-primary-custom">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal de excluir usuário -->
<div class="modal fade" id="excluirUserModal">
    <div class="modal-dialog" role="document">
        <form method="POST" action="<?=base_url('sistema/users/excluir');?>">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Deseja realmente excluir o usuário: <b><span id="nome_excluir"></span></b>?</p>
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
    $('#editarUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        console.log(recipient);

        var modal = $(this)
        modal.find('#nome_editar').val(recipient.nome)
        modal.find('#email_editar').val(recipient.email);
        modal.find('#id_editar').val(recipient.id);
    });

    $('#excluirUserModal').on('show.bs.modal', function (event) {
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
    var table = $('#usersTable').DataTable({
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
</script>
</body>
</html>