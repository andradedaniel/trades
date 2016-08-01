# Projetos Trades


## Instalaçao

Para instalação do zero deve seguir os seguintes passos:

1) git clone https://github.com/andradedaniel/trades.git
2) composer install
3) Comentar o codigo do arquivo vendor/acacha/admin-lte-template-laravel/src/Http/routes.php
4) Copiar as pastas dentro do diretorio 'vendor/acacha/admin-lte-template-laravel/public' para dentro de '/public' do projeto
   São 5 pastas (css, fonts, img, js e plugins). Cuidado para não substituir a pasta public, pois ela já possui outros arquivos.
5) Copiar a pasta 'assets' do diretorio 'vendor/acacha/admin-lte-template-laravel/resources' para o '/resources' do projeto


## Apenas atualização

Se já possui o projeto instalado a partir de clone anterior deste projeto, siga os seguintes passos:

1) Certifique que os passos 3, 4 e 5 do processo de instalaçao descritos acima estão feitos.
2) git pull


## Comandos Uteis

Excluir todas as tabelas, cria-las novamente e carregar com a massa de dados:
php artisan migrate:refresh --seed



## Links de Referencia

[Laravel documentation](http://laravel.com/docs/contributions)
https://github.com/acacha/adminlte-laravel/issues/69
https://github.com/fzaninotto/Faker

