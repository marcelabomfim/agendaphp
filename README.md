# Agenda PHP

Demonstração de uma agenda simples onde os usuários podem se registrar para ter acesso à sua agenda particular e cadastrar seus contatos com email e telefone.
Feita em PHP puro com arquitetura MVC, depende de uma conexão com Banco de Dados MySQL.


## Instruções para instalação

1 - Descompacte os arquivos no diretório desejado em seu servidor web ou localhost.

2 - No arquivo config.php altere as seguintes definições:

2.1 - URL completa do site, exemplo: http://www.seusite.com/seudiretorio ou http://localhost/seudiretorio:
```sh
define( 'HOME_URI', 'http://suaurlcompletaaqui' );
```
2.2 - Dados de conexão com o Banco de Dados  MySQL:
```sh
define( 'HOSTNAME', 'seuhostaqui' );
define( 'DB_NAME', 'nomedobancoaqui' );
define( 'DB_USER', 'nomedousuarioaqui' );
define( 'DB_PASSWORD', 'suasenhaaqui' );
```

3 - Importe o arquivo db.sql para seu Banco de Dados, ele irá criar as tabelas necessárias e adicionar o usuário padrão.

4 - Está pronto! Agora você pode acessar a URL do diretório e se registrar ou utilizar o usuário padrão para fazer login:
> usuário: admin
> senha: admin