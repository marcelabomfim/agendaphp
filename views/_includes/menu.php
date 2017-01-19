<?if ( ! defined('ABSPATH')) exit;

if ( $this->login_required && ! $this->logged_in ) return; ?>

<header>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
	    	<div class="navbar-header">
	      		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	        		<span class="sr-only">Toggle navigation</span>
	        		<span class="icon-bar"></span>
	        		<span class="icon-bar"></span>
	        		<span class="icon-bar"></span>
	      		</button>
	      		<a class="navbar-brand" href="<?=HOME_URI?>">Agenda PHP</a>
	    	</div>
	    	<div id="navbar" class="navbar-collapse collapse">
	      		<ul class="nav navbar-nav">
	        		<li class="<?=$this->menu_ativo==1?'active':''?>"><a href="<?=HOME_URI?>/contacts/">Meus Contatos</a></li>
	        		<li class="<?=$this->menu_ativo==2?'active':''?>"><a href="<?=HOME_URI?>/user/">Meus Dados</a></li>
	      		</ul>
	      		<ul class="nav navbar-nav navbar-right">
	      			<? if ( $this->logged_in ){ ?>
	        			<p class="navbar-text">Olá, <?=$this->userdata['user_name']?></p>
	        			<a class="btn btn-default navbar-btn" href="<?=HOME_URI?>/logout/">Logout</a>
	        		<? } else { ?>
		        		<a class="btn btn-primary navbar-btn" href="<?=HOME_URI?>/login/">Login</a>
		        		<a class="btn btn-default navbar-btn" href="<?=HOME_URI?>/user-register/">Cadastro</a>
		     		<? } ?>
	      		</ul>
	    	</div>
	  	</div>
	</nav>
</header>
