<?

class MainController extends UserLogin
{

	public $db;
	public $title;
	public $menu_ativo;
	public $login_required = false;
	public $parametros = array();

	public function __construct ( $parametros = array() ) {
		$this->db = new ApplicationDB();
		$this->parametros = $parametros;
		$this->check_userlogin();
	} // __construct

	// Carrega os modelos da pasta /models/.
	public function load_model( $model_name = false ) {
		if ( ! $model_name ) return;

		$model_name =  strtolower( $model_name );
		$model_path = ABSPATH . '/models/' . $model_name . '.php';

		if ( file_exists( $model_path ) ) {
			require_once $model_path;

			// Pega só o nome final do caminho
			$model_name = explode('/', $model_name);
			$model_name = end( $model_name );
			$model_name = preg_replace( '/[^a-zA-Z0-9]/is', '', $model_name );

			// Retorna um objeto da classe
			if ( class_exists( $model_name ) ) {
				return new $model_name( $this->db, $this );
			}

			return;
		} // load_model

	} // load_model

} // class MainController
