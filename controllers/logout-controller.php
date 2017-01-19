<?

class LogoutController extends MainController
{

	public function index() {
		$this->logout();
		$this->goto_page(HOME_URI . '/login/');

    } // index

} // class LogoutController
