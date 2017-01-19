<?

class UserRegisterModel extends MainModel
{

	public function __construct( $db = false, $controller = null ) {
		$this->db = $db;
		$this->controller = $controller;
		$this->parametros = $this->controller->parametros;
		$this->userdata = $this->controller->userdata;
		if( isset( $_SESSION['form_msg'] ) && ! empty( $_SESSION['form_msg'] ) ) {
			$this->form_msg = $_SESSION['form_msg'];
			unset( $_SESSION['form_msg'] );
		}
	}

	// Valida o formulário de envio
	public function validate_register_form () {

		$this->form_data = array();
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {
			foreach ( $_POST as $key => $value ) {
				$this->form_data[$key] = $value;
				if ( empty( $value ) ) {
					$_SESSION['form_msg'] = '
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Por favor, preencha todos os campos!
					</div>';

					$this->goto_user_register();
					return;
				}
			}
		} else {
			return;
		}

		if( empty( $this->form_data ) ) {
			return;
		}

		// Verifica se o usuário já existe
		$db_check_user = $this->db->query ( 'SELECT * FROM `users` WHERE `user` = ?', array( chk_array( $this->form_data, 'user') ) );
		if ( ! $db_check_user ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Erro interno, por favor tente novamente!
			</div>';

			$this->goto_user_register();
			return;
		}

		$fetch_user = $db_check_user->fetch();
		$user_id = $fetch_user['user_id'];
		if ( ! empty( $user_id ) ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Usuário já cadastrado, escolha outro!
			</div>';

			$this->goto_user_register();
			return;
		} else {
			// Se o ID do usuário estiver vazio, insere o
			$password = md5( $this->form_data['user_password'] );
			$query = $this->db->insert('users', array(
				'user' => chk_array( $this->form_data, 'user'),
				'user_password' => $password,
				'user_name' => chk_array( $this->form_data, 'user_name'),
				'user_session_id' => md5(time()),
			));

			if ( ! $query ) {
				$_SESSION['form_msg'] = '
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Erro interno, por favor tente novamente!
				</div>';

				$this->goto_user_register();
				return;
			} else {
				$_SESSION['form_msg'] = '
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Cadastro feito com sucesso! Clique <a href="' . HOME_URI . '/login/">aqui</a> para logar.
				</div>';

				$this->goto_user_register();
				return;
			}
		}
	} // validate_register_form

	final public function goto_user_register () {
		// Redireciona para a página de administração de contatos
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/user-register/">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/user-register/";</script>';
		return;
	}
}
