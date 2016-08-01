# Projetos Trades


## Instalaçao

Para instalação do zero deve seguir os seguintes passos:

1. Clonar o projeto no github 
``` git clone https://github.com/andradedaniel/trades.git ```

2. Criar o arquivo .env
> cp .env.example .env

3. Instalar as dependencias do projeto 
> composer install

4. Gerar a chave de segurança da aplicação
> php artisan key:generate

5. Comentar o codigo do arquivo *vendor/acacha/admin-lte-template-laravel/src/Http/routes.php*

6. Copiar as pastas dentro do diretorio 'vendor/acacha/admin-lte-template-laravel/public' para dentro de '/public' do projeto
> cd _trades_
> cp -R vendor/acacha/admin-lte-template-laravel/public/* public

São 5 pastas (css, fonts, img, js e plugins). Certifique de que não foi substituido toda a pasta public, pois ela já possui outros arquivos.

7. Criar as tabelas e carregar com a massa de dados
> php artisan migrate --seed

## Apenas atualização

Se já possui o projeto instalado a partir de clone anterior deste projeto, siga os seguintes passos:

1. Certifique que os passos 5 e 6 do processo de instalaçao descritos acima estão feitos.
2. git pull


## Informações Uteis

* Simular o login a partir do ID de usuario
Caso queira simular o login de algum usuario para que, ao fazer os testes, não seja necessario ficar digitando login e senha, basta
usar o codigo _Auth::loginUsingId(1, true);_ conforme consta no arquivo app/routes.php, onde o parametro "1" se refere ao ID do usuario

* Excluir todas as tabelas, cria-las novamente e carregar com a massa de dados:
> php artisan migrate:refresh --seed



## Links de Referencia

* [Laravel documentation](http://laravel.com/docs/contributions)
* https://github.com/acacha/adminlte-laravel/issues/69
* https://github.com/fzaninotto/Faker

