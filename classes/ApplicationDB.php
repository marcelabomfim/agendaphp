<?

class ApplicationDB
{
	public $host      = HOSTNAME, 		// Host da base de dados
	       $db_name   = DB_NAME,    	// Nome do banco de dados
	       $password  = DB_PASSWORD,    // Senha do usuário da base de dados
	       $user      = DB_USER,      	// Usuário da base de dados
	       $charset   = DB_CHARSET,     // Charset da base de dados
	       $error     = null,        	// Configura o erro
	       $debug     = DEBUG,       	// Mostra todos os erros
	       $last_id   = null;        	// Último ID inserido

	public function __construct(
		$host     = null,
		$db_name  = null,
		$password = null,
		$user     = null,
		$charset  = null,
		$debug    = null
	) {

		$this->connect();

	} // __construct

	final protected function connect() {

		$pdo_details  = "mysql:host={$this->host};";
		$pdo_details .= "dbname={$this->db_name};";
		$pdo_details .= "charset={$this->charset};";

		try {
			$this->pdo = new PDO($pdo_details, $this->user, $this->password);

			if ( $this->debug === true ) {
				$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			}

			// Não precisamos mais dessas propriedades
			unset( $this->host     );
			unset( $this->db_name  );
			unset( $this->password );
			unset( $this->user     );
			unset( $this->charset  );

		} catch (PDOException $e) {
			if ( $this->debug === true ) {
				echo "Erro: " . $e->getMessage();
			}
			die();
		} // catch
	} // connect

	// query - Consulta PDO
	public function query( $stmt, $data_array = null ) {
		$query      = $this->pdo->prepare( $stmt );
		$check_exec = $query->execute( $data_array );

		if ( $check_exec ) {
			return $query;
		} else {
			$error       = $query->errorInfo();
			$this->error = $error[2];
			return false;
		}
	}

	// insert - Insere valores e tenta retornar o último id enviado
	public function insert( $table ) {
		$cols = array();
		$place_holders = '(';
		$values = array();

		// assegura que colunas serão configuradas apenas uma vez
		$j = 1;

		$data = func_get_args();

		if ( ! isset( $data[1] ) || ! is_array( $data[1] ) ) {
			return;
		}

		for ( $i = 1; $i < count( $data ); $i++ ) {
			// Obtém as chaves como colunas e valores como valores
			foreach ( $data[$i] as $col => $val ) {

				// A primeira volta do laço configura as colunas
				if ( $i === 1 ) { $cols[] = "`$col`"; }

				// Configura os divisores
				if ( $j <> $i ) { $place_holders .= '), ('; }

				// Configura os place holders do PDO
				$place_holders .= '?, ';

				// Configura os valores que vamos enviar
				$values[] = $val;

				$j = $i;
			}

			// Remove os caracteres extra dos place holders
			$place_holders = substr( $place_holders, 0, strlen( $place_holders ) - 2 );
		}

		$cols = implode(', ', $cols);
		$stmt = "INSERT INTO `$table` ( $cols ) VALUES $place_holders) ";
		$insert = $this->query( $stmt, $values );

		if ( $insert ) {
			if ( method_exists( $this->pdo, 'lastInsertId' ) && $this->pdo->lastInsertId() ) {
				$this->last_id = $this->pdo->lastInsertId();
			}
			return $insert;
		}

		return;
	} // insert

	// Update simples - Atualiza uma linha da tabela baseada em um campo
	public function update( $table, $where_field, $where_field_value, $values ) {
		if ( empty($table) || empty($where_field) || empty($where_field_value)  ) {
			return;
		}

		$stmt = " UPDATE `$table` SET ";
		$set = array();
		$where = " WHERE `$where_field` = ? ";

		if ( ! is_array( $values ) ) {
			return;
		}

		foreach ( $values as $column => $value ) { $set[] = " `$column` = ?"; }

		$set = implode(', ', $set);
		$stmt .= $set . $where;
		
		$values[] = $where_field_value;
		$values = array_values($values);

		$update = $this->query( $stmt, $values );

		if ( $update ) {
			return $update;
		}

		return;
	} // update

	// Deleta uma linha da tabela
	public function delete( $table, $where_field, $where_field_value ) {
		if ( empty($table) || empty($where_field) || empty($where_field_value)  ) {
			return;
		}

		$stmt = " DELETE FROM `$table` WHERE `$where_field` = ? ";
		$values = array( $where_field_value );
		$delete = $this->query( $stmt, $values );

		if ( $delete ) {
			return $delete;
		}

		return;
	} // delete

} // Class ApplicationDB
