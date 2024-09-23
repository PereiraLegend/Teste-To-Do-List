# Teste-To-Do-List
## Uma aplicação de gestão de tarefas (To-Do List)

### Sobre a implementação:
 Após criar o projeto base requerido pelo teste achei que precisava de algo a mais, mas fiquei em dúvida sobre se caso eu criasse algo a mais dentro do teste, isso fugiria da proposta inicial, então optei por construir uma outra versão na pasta "Api_v2" além do que é realmente requerido (e seguindo a proposta do teste), que se encontra na pasta "Api", onde nessa segunda versão além de implementar o que o teste pede, adicionei um sistema de autenticação e autorização para dois perfis diferentes de usuário ("client" e "admin") podendo ou não acessar certas rotas enquanto logado, enquanto adicionei funcionalidades já existentes na micro-framework, como a criptografia de senhas e casos de excessão de acesso a rotas protegidas;

### Tecnologias Utilizadas:
Framework: Lumen (PHP)

Banco de dados: PostgreeSQL 

Testes: PHPUnit

### Comandos: (Obs.: Fora as pastas que são diferentes, os dois projetos utilizam os mesmos comandos)

Comando para inicializar as migrations: "php artisan migrate:fresh"

Comando para inicializar tabela usuers: "php artisan make:migration create_users_table"

Comando para inicializar tabela tasks: "php artisan make:migration create_tasks_table"

Comando para gerar a chave secreta: "php artisan jwt:secret"

Comando para iniciar a aplicação: "php -S localhost:8000 -t public"

Comando para executar os testes: "./vendor/bin/phpunit"

### Observação: 
O DER do banco de dados se encontra na pasta "DER(DB)", e a collection do postman para todas as rotas dos dois projetos se encontram em "Collection(Postman)"
