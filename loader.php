<?
/**
* Carrega a aplicação
*/

// Evita o o arquivo seja acessado diretamente
if ( ! defined('ABSPATH')) exit;

session_start();

if ( ! defined('DEBUG') || DEBUG === false ) {
	error_reporting(0);
	ini_set("display_errors", 0);
} else {
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

/** 
* Inicializa a aplicação
*/
$app = new Application();