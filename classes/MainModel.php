<?
// MainModel - Modelo geral

class MainModel
{
	// Dados de formulários de envio.
	public $form_data;

	// Mensagens de feedback para formulários.
	public $form_msg;

	// Mensagem de confirmação para apagar dados de formulários
	public $form_confirma;

	// O objeto da conexão PDO
	public $db;

	// O controller que gerou esse modelo
	public $controller;

	// Parâmetros da URL
	public $parametros;

	// Dados do usuário
	public $userdata;

} // MainModel
