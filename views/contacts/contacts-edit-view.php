<?
// Evita acesso direto a este arquivo
if ( ! defined('ABSPATH')) exit;

// Carrega o método para obter um contato
$modelo->get_contact();
?>

<div class="container">
    
    <h2 class="pull-left">Editar Contato</h2>
	<a href="<?=HOME_URI?>/contacts/" class="btn btn-primary add-contact"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>

	<div class="clearfix"></div><br>

	<? if( $modelo->form_msg != '' ) { // Mensagem de feedback para o usuário
		echo $modelo->form_msg;
	} ?>

	<div class="clearfix"></div>
	
	<form method="post" action="">
  		<div class="form-group">
	    	<label for="contact_name">Nome</label>
	    	<input type="text" name="contact_name" class="form-control" id="contactName" value="<?=htmlentities( chk_array( $modelo->form_data, 'contact_name') )?>" required /><span></span>
	  	</div>
	  	<div class="form-group">
		    <label for="contact_email">Email</label>
	    	<input type="email" name="contact_email" class="form-control" id="contactName" value="<?=htmlentities( chk_array( $modelo->form_data, 'contact_email') )?>" required /><span></span>
	  	</div>
	  	<div class="form-group">
		    <label for="contact_phone">Telefone</label>
	    	<input type="tel" name="contact_phone" class="form-control" id="contactName" value="<?=htmlentities( chk_array( $modelo->form_data, 'contact_phone') )?>" required /><span></span>
	  	</div>

	    <input type="submit" class="btn btn-primary"value="Salvar">
	    <input type="hidden" name="edit_contact" value="1" />
	</form>	        

	<div class="clearfix"></div>

</div> <!-- .container -->
