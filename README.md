# Vox-challenge

### Requisitos

```text
PHP Version: 8.2.28
Laravel Version: 11.31
DB Version: Postgres 17.4
Composer Version: 2.8.0
Node Version: v22.15.0
Npm Version: 10.9.2
```

## Configuração do Ambiente

#### 1. Clone o repositório

```shell
git clone git@github.com:netorochaa/vox-challenge.git
```

#### 2. Instale as dependências do PHP

```shell
composer install
```

#### 3. Copie o arquivo .env file

```shell
cp .env.example .env
```

_Agora preencha as variáveis do arquivo .env de acordo com suas configurações de ambiente_

#### 4. Gere a chave APP_KEY

```shell
php artisan key:generate
```

#### 5. Execute a migrações na base de dados

```shell
php artisan migrate --seed
```
_Necessário usar o `--seed` para realizar login no sistema_

#### 6. Instale as dependências do javascript

```shell
npm install
```

## Informações adicionais

### Execução do sistema
##### Herd/Valet
```shell
Acesse: http://vox-challenge.test/
```
_Importante alterar a variável APP_URL_

##### Artisan server
```shell
Execute: php artisan serve
Acesse: http://127.0.0.1:8000 ou http://localhost:8000
```

### Credenciais
```shell
login: test@example.com
pass: password
```

### Executar os testes
```shell
php artisan test
```

