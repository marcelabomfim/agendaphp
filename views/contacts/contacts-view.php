<?
// Evita acesso direto a este arquivo
if ( ! defined('ABSPATH')) exit;

// Configura as URLs
$adm_uri = HOME_URI . '/contacts/';
$edit_uri = $adm_uri . 'edit/';
$delete_uri = $adm_uri . 'del/';

// Carrega o método para obter um contato
$modelo->get_contact();

// Carrega o método para inserir um contato
$modelo->insert_contact();

// Carrega o método para apagar o contato
$modelo->form_confirma = $modelo->delete_contact();
?>

<div class="container">
    
    <h2 class="pull-left">Meus Contatos</h2>
	<button type="button" class="btn btn-primary add-contact" data-toggle="modal" data-target="#modalContactForm"><i class="glyphicon glyphicon-plus-sign"></i> Novo Contato</button>

	<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
	    	<div class="modal-content">
				<form method="post" action="">
		      		<div class="modal-header">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        		<h4 class="modal-title" id="myModalLabel">Novo Contato</h4>
		      		</div>
		      		<div class="modal-body">
				  		<div class="form-group">
				    		<label for="contact_name">Nome</label>
				    		<input type="text" name="contact_name" class="form-control" id="contactName" required/><span></span>
				  		</div>
				  		<div class="form-group">
				    		<label for="contact_email">Email</label>
				    		<input type="email" name="contact_email" class="form-control" id="contactName" required/><span></span>
				  		</div>
				  		<div class="form-group">
				    		<label for="contact_phone">Telefone</label>
				    		<input type="tel" name="contact_phone" class="form-control" id="contactName" required/><span></span>
				  		</div>
		      		</div>
		      		<div class="modal-footer">
		        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        		<input type="submit" class="btn btn-primary"value="Salvar">
		        		<input type="hidden" name="insert_contact" value="1" />
		      		</div>
				</form>	        
			</div>
	  	</div>
	</div>

	<div class="clearfix"></div><br>

	<? if( $modelo->form_msg != '' ) { // Mensagem de feedback para o usuário
		echo $modelo->form_msg;
	}

	if( $modelo->form_confirma != '' ) { // Mensagem de configuração antes de apagar algo
		echo $modelo->form_confirma;
	} ?>

	<div class="clearfix"></div>

	<!-- LISTA OS CONTATOS -->
	<? $list = $modelo->list_contacts();
	if( sizeof( $list )>0 ) { ?>	
		<div class="list-group list-contacts">
			<? foreach( $list as $contact ) { ?>
				<div class="list-group-item contact" onClick="$(this).toggleClass('on');">
			    	<h4 class="list-group-item-heading"><?=$contact['contact_name']?></h4>
			    	<p class="list-group-item-text"><i class="glyphicon glyphicon-earphone"></i> <?=$contact['contact_phone']?></p>
			    	<p class="list-group-item-text"><i class="glyphicon glyphicon-envelope"></i> <?=$contact['contact_email']?></p>
			    	<div class="actions">
			    		<a href="<?=$edit_uri.$contact['contact_id']?>" class="btn btn-info">Editar</a>
			    		<a href="<?=$delete_uri.$contact['contact_id']?>" class="btn btn-danger">Excluir</a>
			    	</div>
			  	</div>
			<? } ?>
		</div>
	<? } else { ?>		
		<p>Você não tem nenhum contato cadastrado ainda!</p>
	<? } ?>

</div> <!-- .container -->

<script src="<?=HOME_URI?>/views/_js/jquery.maskedinput.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		mask9digito('input[type=tel]');
	});

	function mask9digito(seletor){
	    $(seletor).each(function(){
	        $(this).focusout(function(){
	            var phone, element;
	            element = $(this);
	            element.unmask();
	            phone = element.val().replace(/\D/g, '');
	            if(phone.length > 10) {
	                element.mask("(99) 9 9999-999?9");
	            } else {
	                element.mask("(99) 9999-9999?9");
	            }
	        }).trigger('focusout');         
	    });
	}
</script>