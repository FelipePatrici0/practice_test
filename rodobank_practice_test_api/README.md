# Configuração Teste Prático Desenvolvedor FullStack

## Configurações iniciais

1. Acessar o repositório do backend
`cd rodobank_practice_test_api`

2. Instalar dependencias 
`composer install`

3. Duplicar o arquivo `.env.example` e renomear para `.env`

4. Iniciar o docker
`docker compose up`.

5. É necessário executar os comandos dentro do docker
 - Conectar no docker via bash
 `docker exec -it rodobank_practice_test_api.test-1 bash`
 - Criar as tabelas no banco de dados
  `php artisan migrate`
 - Criar as seeds no banco de dados
  `php artisan db:seed --class=ModelTruckSeeder`
 - Criar a chave JWT
 `php artisan jwt:secret`
 - Iniciar o server Laravel
  `php artisan serve`

#
# Estrutura de Rotas
As rotas estão organizadas na pasta routes/api e gerenciadas pelo RouteServiceProvider. Cada arquivo de rota está relacionado a uma funcionalidade específica do sistema:

- `authRoute.php`: Contém as rotas de autenticação, como registro, login, e logout.
- `carrierRoute.php`: Rotas para  transportadora.
- `driverRoute.php`: Rotas para motorista.
- `modelTruckRoute.php`: Rotas para modelo de caminhão.
- `truckRoute.php`: Rotas para caminhão.
- `carrierDriverRoute.php`: Rotas para a relação entre transportadora e motorista.

As rotas são registradas automaticamente pelo RouteServiceProvider.

#
# Controllers
## AuthController
* Responsável pelos métodos de `login` e `logout` dos usuários.
* Executa validações de credenciais e lógica de autenticação, como emissão e verificação de tokens JWT.
* Delegado ao repository as operações de login e logout.

## CarrierController
* Responsável pelos métodos de `crud` da Transportadora.
* Realiza validações como verificação de duplicidade de CNPJ e regras de negócio específicas antes de delegar as operações ao repository.

## CarrierDriverController
* Responsável pelos métodos de `crud` da Relação entre Transportadora e Motorista.
* Valida se transportadora e motorista são válidos antes de criar ou atualizar a relação, e delega essas operações ao repository.

## DriverController
* Responsável pelos métodos de `crud` dos Motoristas.
* Realiza validações como verificação de duplicidade de CPF, além de aplicar lógicas de negócio específicas antes de delegar as operações ao repository.

## ModelTruckController
* Responsável pelos métodos de `crud` dos Modelos de Caminhão.

## TruckController
* Responsável pelos métodos de `crud` dos Caminhões.
Realiza validações como verificação de duplicidade associação, além de aplicar lógicas de negócio específicas antes de delegar as operações ao repository.

# Repositories
## CarrierRepository
* Responsável pelos métodos de `crud` da Transportadora.
* Realiza consultas à model `Transportadora` e fornece métodos para criar, ler, atualizar e excluir registros de transportadoras.

## CarrierDriverRepository
* Responsável pelos métodos de `crud` da Relação entre Transportadora e Motorista.
* Executa operações de CRUD nas relações entre transportadoras e motoristas e manipula as associações entre eles.

## DriverRepository
* Responsável pelos métodos de `crud` dos Motoristas.
* Acessa a model `Motorista` para criar, ler, atualizar e excluir registros de motoristas.

## ModelTruckRepository
* Responsável pelos métodos de `crud` dos Modelos de Caminhão.
* Realiza operações de CRUD na model `Modelo de Caminhão`, garantindo o acesso e manipulação centralizada dos dados.

## TruckRepository
* Responsável pelos métodos de `crud` dos Caminhões.
* Gerencia as operações de CRUD na model `Caminhão`, encapsulando a lógica de acesso aos dados.

# Tables
* Segue um link para verificar como está a UML do banco:
[Veja a UML do banco](https://dbdiagram.io/d/rodobank_db-6706cfa597a66db9a371ecae)

# Rotas relacionadas ao teste

# Carrier (Transportadora)
- GET /api/carrier → CarrierController@index

- POST /api/carrier → CarrierController@store

```
{
	"name_carrier_tbc":"Nome da Transportadora",
	"cnpj_carrier_tbc":"CNPJ da Transportadora"
}

```

- GET /api/carrier/{id} → CarrierController@show

- PUT /api/carrier/{id} → CarrierController@update

```
{
	"name_carrier_tbc":"Nome da Transportadora",
	"cnpj_carrier_tbc":"CNPJ da Transportadora"
}

```

- DELETE /api/carrier/{id} → CarrierController@destroy

- PATCH /api/carrier/activate/{id?} → CarrierController@activate

- PATCH /api/carrier/deactivate/{id?} → CarrierController@deactivate

# Carrier-Driver (Relação entre Transportadora e Motorista)
- GET /api/carrier-driver → CarrierDriverController@index

- POST /api/carrier-driver → CarrierDriverController@store

```
{
	"id_carrier_rcd": 1,
	"id_driver_rcd": 5
}

```

- GET /api/carrier-driver/{id} → CarrierDriverController@show

- PUT /api/carrier-driver/{id} → CarrierDriverController@update

```
{
	"id_carrier_rcd": 1,
	"id_driver_rcd": 5
}

```

- DELETE /api/carrier-driver/{id} → CarrierDriverController@destroy

- GET /api/carrier-driver/driver-associated-carrier/{id} → CarrierDriverController@getDriverAssociatedCarrier

# Driver (Motorista)

- GET /api/driver → DriverController@index

- POST /api/driver → DriverController@store

```
{
	"name_driver_tbd":"Nome do motorista",
	"cpf_driver_tbd": "CPF do motorista",
	"birthdate_driver_tbd":"Data de nascimento do motorista(AAAA-MM-DD)",
	"email_driver_tbd": "email do motorista(não obrigatório)"
}
```

- GET /api/driver/{id} → DriverController@show

- PUT /api/driver/{id} → DriverController@update

```
{
	"name_driver_tbd":"Nome do motorista",
	"cpf_driver_tbd": "CPF do motorista",
	"birthdate_driver_tbd":"Data de nascimento do motorista(AAAA-MM-DD)",
	"email_driver_tbd": "email do motorista(não obrigatório)"
}
```

- DELETE /api/driver/{id} → DriverController@destroy

# ModelTruck (Modelos de Caminhão)

- GET /api/model-truck → ModelTruckController@index

- POST /api/model-truck → ModelTruckController@store

```
{
	"model_truck_tmt":"Modelo do Caminhão",
	"color_truck_tmt":"Cor do Caminhão"
}
```

- GET /api/model-truck/{id} → ModelTruckController@show

- PUT /api/model-truck/{id} → ModelTruckController@update

```
{
	"model_truck_tmt":"Modelo do Caminhão",
	"color_truck_tmt":"Cor do Caminhão"
}
```

- DELETE /api/model-truck/{id} → ModelTruckController@destroy

# Truck (Caminhão)

- GET /api/truck → TruckController@index

- POST /api/truck → TruckController@store

```
{
	"id_driver_tbt": "id do motorista", 
	"id_model_truck_tbt": "id do modelo de caminhão",
	"plate_truck_tbt":"Placa do caminhão"
}
```

- GET /api/truck/{id} → TruckController@show

- PUT /api/truck/{id} → TruckController@update

```
{
	"id_driver_tbt": "id do motorista", 
	"id_model_truck_tbt": "id do modelo de caminhão",
	"plate_truck_tbt":"Placa do caminhão"
}
```

- DELETE /api/truck/{id} → TruckController@destroy

- GET /api/truck/data-truck-drivers → TruckController@getTruckDriversData

- GET /api/truck/data-truck-drivers/{id} → TruckController@findTruckDriverData

- GET /api/truck/list-trucks-by-driver/{id} → TruckController@getTrucksByDriver

# Auth (Autenticação e Usuários)

- POST /api/user/login → AuthController@login

```
{
	"email":"Email do usuário cadastrado",
	"password":"Senha do usuário cadastrado"
}
```

- POST /api/user/register → AuthController@register

```
{
	"name":"Nome do usuário",
	"email":"email do usuário",
	"password":"senha do usuário"
}
```

- POST /api/user/logout → AuthController@logout

- GET /api/user/list → AuthController@index

# Biblioteca de rotas Insomnia
* Segue um link para baixar as requisições e respostas que utilizei no insomnia(basta importar o arquivo no seu aplicativo de consumo de api):
[Veja o arquivo](https://drive.google.com/file/d/13Ksi9Bp1rkz9qqC5GYEwvd9WDVsOdlwK/view?usp=sharing)

# Teste feito utilizando Laravel 11, Docker e Mysql