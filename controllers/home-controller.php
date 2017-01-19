<?

class HomeController extends MainController
{

	public function index() {
		$this->title = 'Home';

		// Verifica se o usuário está logado, se sim manda para página de contato
		if ( $this->logged_in ) {
			$this->goto_page(HOME_URI . '/contacts/');
			return;
		}

		/** Carrega os arquivos do view **/
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/home/home-view.php';
        require ABSPATH . '/views/_includes/footer.php';

    } // index

} // class HomeController
