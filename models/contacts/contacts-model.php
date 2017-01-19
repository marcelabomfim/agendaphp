<?

class ContactsModel extends MainModel
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

	// Lista contatos
	public function list_contacts () {
		$query = $this->db->query(
			'SELECT * FROM contacts WHERE contact_user_id = ? ORDER BY contact_name ASC', array( $this->userdata['user_id'] )
		);
		return $query->fetchAll();
	} // list_contacts

	// Seleciona contato, e se tiver POST "edit_contact" salva a edição
	public function get_contact () {

		// Verifica se o parâmetro é um número
		if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}
		$contact_id = chk_array( $this->parametros, 0 );

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['edit_contact'] ) ) {
			unset($_POST['edit_contact']);

			$query = $this->db->update('contacts', 'contact_id', $contact_id, $_POST);
			if ( $query ) {
				$_SESSION['form_msg'] = '
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Contato atualizado com sucesso!
				</div>';

				$this->goto_contact();
			}

			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Erro ao enviar dados!
			</div>';

			$this->goto_contact();
		}

		$query = $this->db->query(
			'SELECT * FROM contacts WHERE contact_user_id = ? AND contact_id = ? LIMIT 1',
			array( $this->userdata['user_id'], $contact_id )
		);

		$fetch_data = $query->fetch();

		if ( empty( $fetch_data ) ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Contato não encontrado!
			</div>';
			$this->goto_contact();
			return;
		}
		$this->form_data = $fetch_data;

	} // get_contact

	// Insere contato
	public function insert_contact() {

		if ( 'POST' != $_SERVER['REQUEST_METHOD'] || empty( $_POST['insert_contact'] ) ) {
			return;
		}

		unset($_POST['insert_contact']);
		$_POST['contact_user_id'] = $this->userdata['user_id'];

		$query = $this->db->insert( 'contacts', $_POST );
		if ( $query ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Contato cadastrado com sucesso!
			</div>';

			$this->goto_contact();
			return;
		}

		$_SESSION['form_msg'] = '
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			Erro ao enviar dados!
		</div>';

		$this->goto_contact();

	} // insert_contact

	// Apaga o contato
	public function delete_contact () {

		// Verifica se o primeiro parâmetro um número
		if ( ! is_numeric( chk_array( $this->parametros, 0 ) ) ) {
			return;
		}

		// Para excluir, o segundo parâmetro deverá ser "confirma"
		if ( chk_array( $this->parametros, 1 ) != 'confirma' ) {
			$mensagem  = 
			'<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>Tem certeza que deseja apagar o contato?</h4>
				<p>
					<a href="' . $_SERVER['REQUEST_URI'] . '/confirma/" class="btn btn-danger">Sim, apagar contato</a>
					<a href="' . HOME_URI . '" class="btn btn-default">Não</a>
				</p>
			</div>';
			return $mensagem;
		}

		$contact_id = chk_array( $this->parametros, 0 );

		$query = $this->db->delete( 'contacts', 'contact_id', $contact_id );
		if ( $query ) {
			$_SESSION['form_msg'] = '
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Contato excluído com sucesso!
			</div>';

			$this->goto_contact();
			return;
		}

		$_SESSION['form_msg'] = '
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			Erro ao enviar dados!
		</div>';

		$this->goto_contact();

	} // delete_contact

	final public function goto_contact () {
		// Redireciona para a página de administração de contatos
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/contacts/">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/contacts/";</script>';
		return;
	}

} // ContactsModel
