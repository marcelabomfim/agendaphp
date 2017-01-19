<? if ( ! defined('ABSPATH')) exit; 

// Carrega todos os métodos do modelo
$modelo->validate_register_form();
?>

<div class="container">

  <form class="form-login" action="" method="post">
    <h2>Cadastro</h2>
	<? if( $modelo->form_msg != '' ) { // Mensagem de feedback para o usuário
		  echo $modelo->form_msg;
  	 } ?>
    <div class="form-group">
        <label for="inputUserName" class="sr-only">Nome</label>
        <input type="text" name="user_name" id="inputUserName" class="form-control" placeholder="Nome" required="" autofocus="">
    </div>
    <div class="form-group">
        <label for="inputUser" class="sr-only">Usuário</label>
        <input type="text" name="user" id="inputUser" class="form-control" placeholder="Usuário" required="">
    </div>
    <div class="form-group">
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" name="user_password" id="inputPassword" class="form-control" placeholder="Senha" required="">
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar</button>
</form>