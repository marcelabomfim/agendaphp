<?
/**
 * Carregar os arquivos de classes automaticamente 
 * Desde que siga o padrão: classes/NomeDaClasse.php.
 */
function __autoload($class_name) {
	$file = ABSPATH . '/classes/' . $class_name . '.php';

	if ( ! file_exists( $file ) ) {
		require_once ABSPATH . '/includes/404.php';
		return;
	}

	// Inclui o arquivo da classe
    require_once $file;
} // __autoload

/**
* Checa se a chave informada existe dentro do array
* Se sim retorna o valor dela, se não retorna NULL
*/
function chk_array ( $array, $key ) {
	// Verifica se a chave existe no array
	if ( isset( $array[ $key ] ) && ! empty( $array[ $key ] ) ) {
		// Retorna o valor da chave
		return $array[ $key ];
	}

	// Retorna nulo por padrão
	return null;
} // chk_array
