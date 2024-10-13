[![](https://rodobank.com.br/themes/rodobank/assets/img/logo.png)](https://rodobank.com.br)

# Prazo de Entrega: 13/10/2024

# Comandos

docker compose up -d --build

docker-compose exec laravelapi php artisan migrate --seed

# Teste para candidatos à vaga de Desenvolvedor PHP.

Nesse teste analisaremos seu conhecimento geral e inclusive velocidade de desenvolvimento. Abaixo explicaremos tudo o que será necessário.

## Instruções

O desafio consiste em implementar uma REST API com CRUD usando o framework Laravel 11 e banco de dados MySQL. A Funcionalidade principal é cadastrar, editar e deletar transportadoras, motoristas e caminhões. O Fluxo consiste em, uma Transportadora possui um ou vários motoristas cadastrados, um motorista pode estar cadastrado em uma ou várias Transportadoras e o Motorista possui um ou vários caminhões. Além do CRUD, o sistema deverá disponibilizar a lista dos cadastros que foram realizados.

## Modelo de dados

A modelagem inicial para a implementação solução é a seguinte:

| Nome                    | Tipo         | Nullable |
| ----------------------- | ------------ | -------- |
| NomeTransportadora      | varchar(100) | false    |
| CNPJTransportadora      | char(14)     | false    |
| StatusTransportadora    | int          | false    |
| NomeMotorista           | varchar(100) | false    |
| CPFMotorista            | char(11)     | false    |
| DataNascimentoMotorista | datetime     | false    |
| EmailMotorista          | varchar(100) | true     |
| PlacaCaminhao           | char(8)      | false    |
| ModeloCaminhao          | varchar(50)  | false    |
| CorCaminhao             | varchar(50)  | false    |

Você deve alterar esta modelagem para que a mesma cumpra com as três primeiras formas normais.

Além disso, a implementação deste modelo em um banco de dados relacional deve ser realizada levando em consideração os seguintes requisitos:

- O banco de dados deve ser criado utilizando Migrations do framework Laravel, e também utilizar Seeds para popular as informações no banco de dados.
- Implementação das validações necessárias na camada que julgar melhor.
- Deve existir um relacionamento de caminhão com modelo e motorista, caminhão TEM um modelo e PERTENCE a um motorista
- Deve utilizar o padrão snake_case para o nome das colunas no banco de dados

## Validações no Cadastro/Update usando Form Request Validation

- Transportadora
  - nome: obrigatório
  - cnpj: obrigatório | número | 14 digitos | único no banco de dados
- Motorista
  - nome: obrigatório
  - cpf: obrigatório | número | 11 dígitos | único no banco de dados
  - data_nascimento: obrigatório | data
  - email: opcional | email
- Caminhão
  - motorista: obrigatório
  - modelo: obrigatório
  - placa: obrigatório | único no banco de dados
- Modelo
  - modelo: obrigatório
  - cor: obrigatório

## Regras de Negócio

1. O cadastro de transportadora deve por padrão ser status = 1 ativado. Essa informação não precisar ser passada no request, isso deve ser responsabilidade do backend.
2. No cadastro do motorista validar se o mesmo é maior de idade. Caso não seja não permitir o cadastro.

## Criar registros na tabela modelo_caminhaousando Seeder

- Gere no mínimo 5 registros de modelos de caminhões para serem usados nos cadastros dos caminhões.
- Opcional e diferencial: usar o Factory

## Endpoints de Listagem

1. Listar as transportadoras; Rotas: /api/transportadoras | /api/transportadoras/{id}/motoristas
2. Altera o status de uma transportadora; Rotas: Put /api/transportadoras/{id}/motoristas
3. Cadastrar e listar motoristas cadastrados na transportadora; Rotas: Put /api/transportadoras/{id}/motoristas | /api/transportadoras/{id}/motoristas
4. Cadastro e vínculo de caminhões ao motorista;
5. Visualizar os caminhões pertencentes a um motorista. Rotas: Get: /api/motoristas/{id}/caminhoes

Obs.: Faça o relacionamento das tabelas para que seja possível acessar essas informações via relacionamento.

## Tecnologias a serem utilizadas

Devem ser utilizadas as seguintes tecnologias:

- HTML
- CSS
- Javascript
- Framework Laravel (PHP)
- Docker

## Entrega

Para iniciar o teste, faça um fork deste repositório, crie uma branch com o seu nome completo e depois envie-nos o pull request. Se você apenas clonar o repositório não vai conseguir fazer push e depois vai ser mais complicado fazer o pull request.

## Bônus

- Implementar autenticação de usuário na aplicação.
- Permitir que o usuário mude o número de itens por página.
- Permitir remoção em massa de itens nos CRUDs.
- Implementar a camada de Front-End utilizando Vue.JS
- API Rest JSON para todos os CRUDS listados acima.
- Uso de Repository
