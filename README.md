# WebCar - V2

## Baixar Projeto
```
git clone https://github.com/HudsonMota/WebCarHSJ
```
## Executar Projeto

- Configuração da .env
```
cp .env.example .env
```
## Criação do banco de dados deve ser feita e configurada no arquivo .env

- Copie o arquivo /db/db_wecar_v2.sql e cole no gerenciador de banco de dados (Workbench ou similar)


- Instalação dos componentes
```
composer install
```

- Atualização dos componentes
```
composer update
```

- Tokens e chaves
```
php artisan key:generate
```

- Servidor local
```
php artisan serve
```
