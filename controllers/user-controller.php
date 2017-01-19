<?

class UserController extends MainController
{

	// Controla se a página precisa de login
	public $login_required = true;

	public function index() {
		$this->title = 'Meus Dados';
		$this->menu_ativo = 2;

		// Verifica se o usuário está logado
		if ( ! $this->logged_in ) {
			$this->logout();
			$this->goto_login();
			return;
		}

	    $modelo = $this->load_model('user/user-model');

		/** Carrega os arquivos do view **/
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/user/user-view.php';
        require ABSPATH . '/views/_includes/footer.php';

    } // index

} // class home
