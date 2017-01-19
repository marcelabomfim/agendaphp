<? if ( ! defined('ABSPATH')) exit;

// Carrega os métodos do modelo
$modelo->validate_form();
$modelo->get_form();
?>

<div class="container">
    
    <h2>Meus Dados</h2>

	<div class="clearfix"></div><br>

	<? if( $modelo->form_msg != '' ) { // Mensagem de feedback para o usuário
		echo $modelo->form_msg;
	} ?>

	<div class="clearfix"></div>
	
	<form method="post" action="">
  		<div class="form-group">
	    	<label for="user_name">Nome</label>
	    	<input type="text" name="user_name" class="form-control" id="userName" value="<?=htmlentities( chk_array( $modelo->form_data, 'user_name') )?>" required/><span></span>
	  	</div>
	  	<div class="form-group">
		    <label for="user">Usuário</label>
	    	<input type="text" name="user" class="form-control" id="userName" value="<?=htmlentities( chk_array( $modelo->form_data, 'user') )?>" disabled/><span></span>
	  	</div>
	  	<div class="form-group">
	    	<label for="userPasswordNew">Nova senha</label>
	    	<input type="password" name="user_password_new" class="form-control" id="userPasswordNew" value="" /><span></span>
		</div>
		<div class="form-group">
		    <label for="userPasswordConfirm">Confirmar nova senha</label>
	    	<input type="password" name="user_password_confirm" class="form-control" id="userPasswordConfirm" value="" /><span></span>
		</div>
	  	<div class="form-group">
		    <label for="userPassword">Senha atual</label>
	    	<input type="password" name="user_password" class="form-control" id="userPassword" value="" required/><span></span>
	  	</div>

	    <input type="submit" class="btn btn-primary"value="Salvar">
	    <input type="hidden" name="edit_user" value="1" />
	</form>	        

	<div class="clearfix"></div>

</div> <!-- .container -->