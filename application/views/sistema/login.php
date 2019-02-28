<?php $this->load->view('header'); ?>
<!-- ******************************************* 
    Tela de login para a área administrativa 
************************************************-->
<div class="mp-bg-login" style="">
    <div class="my-main-login" >
        <div class="block block-login">
            <div>
                <img src="<?=base_url('assets/img/my-pet-small.png')?>">
            </div>
            <h3 class="mp-login-title" style="" >Login</h3>
            <form method="post" action="<?=base_url('sistema/login/entrar')?>">
                <input type="text" name="email" placeholder="E-mail">
                <input type="password" name="senha" placeholder="Senha">
                <button type="submit" class="btn btn-primary btn-primary-custom">Entrar</button>
            </form>
            <div>
                <span style="color: red;"><?=$error_database?></span>
            </div>
        </div>
    </div>
</div>

</body>
</html>