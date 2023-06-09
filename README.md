# Twitter Clone

O mesmo se trata de um projeto realizado para fins de estudos na linguagem de programação `PHP` e `MYSQL` para banco de dados.
O projeto utiliza o padrão `MVC` assim como o paradigma de `POO`, todo o projeto é construído em classes.

Twitter Clone e utilizado como "rede social" de forma bem simples, como citado acima para fins de estudo!

É possível encontrar outros usuários, com a possibilidade de seguir ou mesmo deixar de segui-los.
Com isso a aba de timeline é apresentada conforme suas ligações dentro da plataforma, ou seja, você verá publicações de pessoas que segue!

As publicações que são aceitas, são simples, aceitado apenas a inclusão de texto!
Também é possível fazer a deleção de publicações.

# Estrutura

Dentro do diretório **vendor** você vai encontrar a pasta **MF** que contem os seguintes diretórios

1. **Controller**
2. **Init**
3. **Model**

Os mesmo contem arquivos que são responsáveis pela abstração de determinados comportamentos da aplicação.

Segue a baixo detalhes!

`Controller -> Actions.php`

Este arquivo é responsável pela abstração da renderização das views e dos layouts.

`Init -> Bootstrap.php`

- O Bootstrap.php é responsável pelo mapeamento e também a inicialização das rotas.
- Também fica a cargo dele, ler a rota passada pelo usuário e identificar se a rota é valida ou não.

`Model -> Container.php`

- O Container.php é o arquivo responsável por instanciar um modelo já com a conexão ao banco estabelecida.

`Model ->; Model.php`

- Arquivo apenas traz a abstração de métodos comuns dos Models, como a atribuição da conexão com o banco, para o atributo `protected $db`.

# Banco de dados

Dentro da pasta **BD** você encontrar um arquivo com o nome `query.sql` que terá todos as querys usadas para a criação do banco de dados.
A conexão do banco e feita a partir do arquivo `Connection.php` que se encontra do diretório **App**.
