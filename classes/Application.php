<?

class Application
{

	// exemplo.com/controlador/
	private $controlador;

	// exemplo.com/controlador/acao
	private $acao;

	// exemplo.com/controlador/acao/param1/param2/param50
	private $parametros;

	private $not_found = '/includes/404.php';

	public function __construct () {

		$this->get_url_data();

		// Se o controlador não existe adiciona o controlador padrão
		if ( ! $this->controlador ) {
			require_once ABSPATH . '/controllers/home-controller.php';
			$this->controlador = new HomeController();
			$this->controlador->index();
			return;
		}
		
		// Se o arquivo do controlador não existir, retorna como página não encontrada
		if ( ! file_exists( ABSPATH . '/controllers/' . $this->controlador . '.php' ) ) {
			require_once ABSPATH . $this->not_found;
			return;
		
		}
		// Inclui o arquivo do controlador
		require_once ABSPATH . '/controllers/' . $this->controlador . '.php';

		// Remove caracteres inválidos e gera o nome da classe
		$this->controlador = preg_replace( '/[^a-zA-Z]/i', '', $this->controlador );

		// Se a classe do controlador indicado não existir, retorna como página não encontrada
		if ( ! class_exists( $this->controlador ) ) {
			require_once ABSPATH . $this->not_found;
			return;
		}

		// Cria o objeto da classe do controlador e envia os parâmentros
		$this->controlador = new $this->controlador( $this->parametros );

		// Remove caracteres inválidos do nome da ação (método da classe)
		$this->acao = preg_replace( '/[^a-zA-Z]/i', '', $this->acao );

		// Se o método indicado existir, executa o método e envia os parâmetros
		if ( method_exists( $this->controlador, $this->acao ) ) {
			$this->controlador->{$this->acao}( $this->parametros );
			return;
		}

		// Se não informou nenhuma ação, chamamos o método index
		if ( ! $this->acao && method_exists( $this->controlador, 'index' ) ) {
			$this->controlador->index( $this->parametros );
			return;
		}

		// Página não encontrada
		require_once ABSPATH . $this->not_found;

		return;
		
	} // __construct

	// Lê a URL $_GET['path'] e configura $this->controlador, $this->acao e $this->parametros
	// exemplo.com/controlador/acao/parametro1/parametro2/etc...
	public function get_url_data () {

		if ( isset( $_GET['path'] ) ) {

			$path = $_GET['path'];

			// Limpa os dados
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

			$path = explode('/', $path);

			// Configura as propriedades
			$this->controlador  = chk_array( $path, 0 );
			$this->controlador .= '-controller';
			$this->acao         = chk_array( $path, 1 );

			// Configura os parâmetros
			if ( chk_array( $path, 2 ) ) {
				unset( $path[0] );
				unset( $path[1] );

				// Os parâmetros sempre virão após a ação
				$this->parametros = array_values( $path );
			}
		}

	} // get_url_data

} // class Application
