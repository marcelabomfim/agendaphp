<?

class UserLogin
{
	public $logged_in;
	public $userdata;
	public $login_error;

	public function check_userlogin () {

		$post = false; // Se o login está sendo feito agora, recebe por post

		if ( isset( $_SESSION['userdata'] ) && ! empty( $_SESSION['userdata'] ) && is_array( $_SESSION['userdata'] ) && ! isset( $_POST['userdata'] ) ) {
			$userdata = $_SESSION['userdata'];
			$post = false;
		}

		if ( isset( $_POST['userdata'] ) && ! empty( $_POST['userdata'] ) && is_array( $_POST['userdata'] ) ) {
			$userdata = $_POST['userdata'];
			$post = true;
		}

		if ( ! isset( $userdata ) || ! is_array( $userdata ) ) {
			$this->logout();
			return;
		}

		if ( empty( $userdata ) ) {
			$this->logged_in = false;
			$this->login_error = null;
			$this->logout();
			return;
		}

		/**
		* Extrai variáveis dos dados do usuário
		* $userdata['user'] --> $user
		* $userdata['user_password'] --> $user_password
		*/
		extract( $userdata );

		if ( ! isset( $user ) || ! isset( $user_password ) ) {
			$this->logged_in = false;
			$this->login_error = null;
			$this->logout();
			return;
		}

		// Busca o usuário na base de dados
		$query = $this->db->query(
			'SELECT * FROM users WHERE user = ? LIMIT 1',
			array( $user )
		);

		if ( ! $query ) {
			$this->logged_in = false;
			$this->login_error = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Erro ao enviar dados!
			</div>';
			$this->logout();
			return;
		}

		// Obtém os dados da query
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		$user_id = (int) $fetch['user_id'];

		if ( empty( $user_id ) ){
			$this->logged_in = false;
			$this->login_error = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Usuário não cadastrado
			</div>';
			$this->logout();
			return;
		}

		// Se for um post - login está sendo feito agora
		if ( $post ) {
			// Confere se o md5 da senha digitada bate com a do BD
			if ( md5( $user_password ) == $fetch['user_password'] ) {

				session_regenerate_id();
				$session_id = session_id();

				// Envia os dados de usuário para a sessão
				$_SESSION['userdata'] = $fetch;
				$_SESSION['userdata']['user_password'] = $user_password;
				$_SESSION['userdata']['user_session_id'] = $session_id;

				// Atualiza o ID da sessão na base de dados
				$query = $this->db->query(
					'UPDATE users SET user_session_id = ? WHERE user_id = ?',
					array( $session_id, $user_id )
				);

				// O usuário agora está logado
				$this->logged_in = true;
				$this->userdata = $_SESSION['userdata'];

				// Verifica se existe uma URL para redirecionar o usuário
				if ( isset( $_SESSION['goto_url'] ) ) {
					$goto_url = urldecode( $_SESSION['goto_url'] );
					unset( $_SESSION['goto_url'] );

					// Redireciona para a página
					echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
					echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
					//header( 'location: ' . $goto_url );
				}

				return;
			} else {
				// A senha não bateu
				$this->logged_in = false;
				$this->login_error = '
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Senha incorreta!
				</div>';
				$this->logout();
				return;
			}
		} else {
			// Se for uma sessão, verifica se a sessão bate com a sessão do BD
			if ( session_id() == $fetch['user_session_id'] ) {
				$this->logged_in = true;
				$this->userdata = $_SESSION['userdata'];
				return;
			} else {
				$this->logged_in = false;
				$this->login_error = 'Sessão expirada.';
				$this->logout();
				return;				
			}
		}

	}

	// Logout
	public function logout( $redirect = false ) {
		$_SESSION['userdata'] = array();
		unset( $_SESSION['userdata'] );
		session_regenerate_id();

		if ( $redirect === true ) {
			$this->goto_login();
		}
	}

	public function goto_login() {
		if ( defined( 'HOME_URI' ) ) {
			$login_uri  = HOME_URI . '/login/';

			// Página que o usuário estava antes e vai voltar
			$_SESSION['goto_url'] = urlencode( $_SERVER['REQUEST_URI'] );

			// Redireciona
			echo '<meta http-equiv="Refresh" content="0; url=' . $login_uri . '">';
			echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';
			// header('location: ' . $login_uri);
		}

		return;
	}

	final public function goto_page( $page_uri = null ) {
		if ( isset( $_GET['url'] ) && ! empty( $_GET['url'] ) && ! $page_uri ) {
			$page_uri  = urldecode( $_GET['url'] );
		}

		if ( $page_uri ) {
			echo '<meta http-equiv="Refresh" content="0; url=' . $page_uri . '">';
			echo '<script type="text/javascript">window.location.href = "' . $page_uri . '";</script>';
			//header('location: ' . $page_uri);
			return;
		}
	}

}
