<?if ( ! defined('ABSPATH')) exit;

if ( $this->logged_in ) {
    $this->goto_page(HOME_URI);
}
?>

<div class="container">

    <form class="form-login" action="" method="post">
        <h2>Login</h2>
        <? if( $this->login_error != '' ) { // Mensagem de feedback para o usuário
            echo $this->login_error;
        } ?>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">Usuário</label>
            <input type="text" name="userdata[user]" id="inputEmail" class="form-control" placeholder="Usuário" required autofocus><span></span>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" name="userdata[user_password]" id="inputPassword" class="form-control" placeholder="Senha" required><span></span>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        <br>
        <p>Não tem uma conta ainda? Clique <a href="<?=HOME_URI?>/user-register/">aqui</a> para se cadastrar</p>
    </form>

</div>