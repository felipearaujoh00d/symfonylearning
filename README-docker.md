# Executando a plataforma symfonylearning em containers docker

Visando simplificar os processos de criação de ambientes de desenvolvimento, testes e produção para a plataforma, estamos
adotando a arquitetura de containeres, utilizando a tecnologia [**docker**](https://www.docker.com/).


## Pré-requisitos

- docker
- docker compose  


## Geral

- a pasta **build** contém scripts e outros arquivos relacionados a criação e manutenção de imagens docker para a plataforma SymfonyLearning


#### webserver

Container onde fica instalado o servidor web Apache e a linguagem PHP. A pasta onde fica o **código fonte da aplicação** é montada a
partir da maquina hospedeira. Essa configuração é espécialmente útil para o ambiente de desenvolvimento, onde o código fonte
precisa ser acessado pela IDE diretamente na máquina hospedeira.

Outras pastas devem ser montadas e acessadas pelo container (veja a definição de webserver no arquivo **run/docker-composer.yml**)

__/opt/plataforma__ - local o onde está a raiz do código fonte da plataforma
__/opt/composer/cache__ - cache do PHP composer
__/opt/cache/consultoria__ - cache da aplicação **consultoria** (feita em symfony 2)
__/opt/logs/consultoria__ - logs da aplicação **consultoria** (feita em symfony 2)


## Configurando o ambiente de desenvolvimento

- escolha uma pasta onde você armazenará os **dados da aplicação** que irá rodar na máquina. Esses dados incluem banco de
dados, cache, logs, arquivos da plataforma (anexos). Por exemplo, escolha **/home/xpto/dados/symfony_learning_dev**. Crie essa 
pasta.
- execute o script de configuração

```
cd docker
./prepare-env.py --datadir=/home/xpto/dados/symfony_learning_dev
``` 

este script irá criar as pastas necessárias para a aplicação e em seguida, o  arquivo ```envvars```. Este arquivo contém
as variáveis de ambiente necessárias para a aplicação.

- confira se esse arquivo foi gerado corretamente e se as pastas foram criadas.

- para iniciar a aplicação:

```
cd docker
./start.sh
```

e em seguida, para o caso do ambiente de desenvolvimento, acesse a aplicação pelo endereço **https://localhost:8090/genus/felipe**


- para parar a aplicação:

```
cd docker
./stop.sh
```

### Comandos úteis

Executa o bash shell dentro do container **symfony_webserver** 
```
docker exec -it symfony_webserver bash
```




