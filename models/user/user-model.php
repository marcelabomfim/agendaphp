<?

class UserModel extends MainModel
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
	public function validate_form () {

		$this->form_data = array();
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {
			foreach ( $_POST as $key => $value ) {
				$this->form_data[$key] = $value;
			}
		} else {
			return;
		}

		if( empty( $this->form_data ) ) {
			return;
		}

		if ( !isset($this->form_data['user_name']) || empty($this->form_data['user_name']) || !isset($this->form_data['user_password']) || empty($this->form_data['user_password']) ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Os seguintes campos são obrigatórios: <b>Nome</b> e <b>Senha atual</b>
			</div>';

			$this->goto_user();
			return;
		}

		// Verifica o id do usuário
		$user_id = $this->userdata['user_id'];
		$db_user = $this->db->query ( 'SELECT * FROM `users` WHERE `user_id` = ?', array( $user_id ) );
		if ( ! $db_user ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Erro ao enviar dados!
			</div>';

			$this->goto_user();
			return;
		}
		$fetch_user = $db_user->fetch(PDO::FETCH_ASSOC);

		//Checa se a senha atual bate com a senha do banco
		$password = md5( $this->form_data['user_password'] );
		if ( $password != $fetch_user['user_password'] ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Senha atual incorreta
			</div>';

			$this->goto_user();
			return;
		}

		//Checa se os campos nova senha e confirmar senha batem
		if ( !empty($this->form_data['user_password_new']) && !empty($this->form_data['user_password_confirm'])){
			if($this->form_data['user_password_new']!=$this->form_data['user_password_confirm']) {
				$_SESSION['form_msg'] = '
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					O campo <b>Nova senha</b> e <b>Confirmar nova senha</b> não batem!
				</div>';

				$this->goto_user();
				return;
			} else {
				//Atribui a nova senha
				$new_password = md5($this->form_data['user_password_new']);
				$_SESSION['userdata']['user_password'] = $new_password;

				$query = $this->db->update('users', 'user_id', $user_id, array(
					'user_password' => $new_password,
					'user_name' => chk_array( $this->form_data, 'user_name'),
				));
			}
		} else {
			$query = $this->db->update('users', 'user_id', $user_id, array(
				'user_name' => chk_array( $this->form_data, 'user_name'),
			));			
		}


		// Verifica se a consulta está OK e configura a mensagem
		if ( ! $query ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Erro ao enviar dados!
			</div>';

			$this->goto_user();
			return;
		} else {
			$_SESSION['form_msg'] = '
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Dados atualizados com sucesso!
			</div>';

			$this->goto_user();
			return;
		}			
	} // validate_form

	// Obtém os dados do usuários
	public function get_form () {
		$s_user_id = $this->userdata['user_id'];
		$query = $this->db->query('SELECT * FROM `users` WHERE `user_id` = ?', array( $s_user_id ));
		if ( ! $query ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Erro ao enviar dados!
			</div>';

			$this->goto_user();
			return;
		}

		$fetch_userdata = $query->fetch();
		if ( empty( $fetch_userdata ) ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Erro ao enviar dados!
			</div>';

			$this->goto_user();
			return;
		}

		foreach ( $fetch_userdata as $key => $value ) {
			$this->form_data[$key] = $value;
		}
		$this->form_data['user_password'] = null;

	} // get_form

	final public function goto_user () {
		// Redireciona para a página de administração de contatos
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/user/">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/user/";</script>';
		return;
	}
}
