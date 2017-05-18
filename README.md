# README #

Sem dor.

# Bancos de dados compatíveis
* MySQL

# Instruções da tabela
Todas as instruções para a criação da classe são baseadas nas informações da tabela que está sendo tranformada em classe vem do banco de dados. São utilizadas instruções SQL para a captura das informações.

# Nomeando tabelas
Para que tudo fique corretamente separado, as tabelas obrigatoriamente devem possuir um prefixo seguido de underline (_), o prefixo é visto como um grupo, ou seja, tabelas com mesmos prefixos são armazenadas juntas.

Todas as classes geradas são criadas diretamente no diretório "_core/Entities_", e tudo fica dividido em sub-pastas com os nomes dos prefixos da tabela que está sendo atacada, por exemplo, para a tabela "_auth_users_" será criada dentro da pasta "_Entities_" um diretório com o nome "_Auth_" e dentro deste serão armazenadas as classes "_Users_" e "_UsersManager_".

Todas as tabelas que iniciarem com o mesmo prefixo ficarão juntas no diretório, voltando no exemplo acima todas as tabelas que iniciarem com "*auth\_*" ficarão juntas no diretório "_Auth_".

# Instruções do campo
Cada campo da tabela deve conter em seu comentário uma string JSon que contem as informações específicas para configurar cada atributo ou método correspondente ao campo. Se divide em um array com os seguinte campos:

* _*name_msg*_ -> string com o nome do campo que será apresentado para interação com o usuário

+ _*validate*_ -> string que informa os parâmetros para validação do campo, recebe os seguintes valores:
    * **auto_increment**: valida campo com numeração automática;
    * **date_automatic**: valida um campo onde a data é informada automaticamente pelo sistema, padrão _date('Y-m-d H:i:s')_;
    * **fk**: valida um campo do tipo _foreng key_;
    * **string**: valida um campo que contem apenas uma cadeia de caracteres;
    * **integer**: valida campos que armazenam números inteiros;
    * **float**: valida campos que armazenam números decimais;
    * **flag**: os flags são campos especiais que utilizam o campo nome para gerar uma string sem acentos ou caracteres especiais;
    * **cpf**: valida campos que armazenam CPFs;
    * **email**: valida campos que armazenam Emails;
    * **token**: valida campos que armazenam Tokens;
    * **login**: valida campos que armazenam Login;
    * **password**: valida campos que armazenam Passwords;

* _*validate_ref*_ -> string que informa a qual campo a validação faz referência, a exemplo os campos de validação do tipo "**flag**" ou "**token**", ele são gerados automaticamente pelos sistema com base nas funções "_flag()_" e "_token()_" respectivamente;

* _*insert*_ -> valor booleano que informa se o campo estará disponível em páginas de inserção de registro;

* _*update*_ -> valor booleano que informa se o campo estará disponível em páginas de alteração de registro;

* _*comment*_ -> Armazena o comentário do campo.

# Arquivos de interação com o banco de dados
Os arquivos de interação com o banco de dados ficam dentro do diretório "_api/*_" com as ações de INSERT, UPDATE, ENABLE e DISABLE.
