<?

class UserRegisterController extends MainController
{

	public $login_required = false;

	public function index() {
		$this->title = 'Cadastrar-se';

		$modelo = $this->load_model('user-register/user-register-model');

		/** Carrega os arquivos do view **/
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/user-register/user-register-view.php';
        require ABSPATH . '/views/_includes/footer.php';

    } // index

} // class home
