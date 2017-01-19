<?

class ContactsController extends MainController
{

	// Controla se a página precisa de login
	public $login_required = true;

	public function index() {
		$this->title = 'Meus Contatos';
		$this->menu_ativo = 1;

		// Verifica se o usuário está logado
		if ( ! $this->logged_in ) {
			$this->logout();
			$this->goto_login();
			return;
		}

		$modelo = $this->load_model('contacts/contacts-model');

		/** Carrega os arquivos do view **/
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/contacts/contacts-view.php';
        require ABSPATH . '/views/_includes/footer.php';

    } // index

	public function edit() {
		$this->title = 'Editar Contato';
		$this->menu_ativo = 1;

        $modelo = $this->load_model('contacts/contacts-model');

		/** Carrega os arquivos do view **/
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/contacts/contacts-edit-view.php';
        require ABSPATH . '/views/_includes/footer.php';

    } // edit

    public function del() {
		$this->title = 'Apagar Contato';
		$this->menu_ativo = 1;

        $modelo = $this->load_model('contacts/contacts-model');

		/** Carrega os arquivos do view **/
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/contacts/contacts-view.php';
        require ABSPATH . '/views/_includes/footer.php';

    } // adm

} // class ContactsController
