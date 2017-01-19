<?

class LoginController extends MainController
{

	public function index() {
		$this->title = 'Login';

		// Login não tem Model

		/** Carrega os arquivos do view **/
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/login/login-view.php';
        require ABSPATH . '/views/_includes/footer.php';

    } // index

} // class LoginController
