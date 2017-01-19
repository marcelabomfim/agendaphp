<?
/**
* Configurações Gerais 
*/

// Caminho raiz
define( 'ABSPATH', dirname( __FILE__ ) );

// URL da home
define( 'HOME_URI', 'http://localhost/agendaphp' );

// Configurações do Banco de Dados
define( 'HOSTNAME', 'localhost' );
define( 'DB_NAME', 'agendaphp' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_CHARSET', 'utf8' );

// Mostrar ou não mostrar erros
define( 'DEBUG', true );

// Carrega as funções globais
require_once ABSPATH . '/functions.php';

// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';
?>
