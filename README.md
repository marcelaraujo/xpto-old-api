xpto - API
=============

API RESTFull para a xpto

Instalação
==========

É necessário o PHP 5.5.x

## Extensões necessárias
- curl
- pdo
- reflection
- json
- xdebug (opcional)

## Instalação
Baixe o [Composer](https://getcomposer.org/)

```
./vendor/bin/phing install
```

## O arquivo config.yml
Se tudo ocorreu bem, foi criado um arquivo chamado *config.yml* na pasta *config* do projeto, edite-o e preencha corretamente
todos os dados solicitados. Eles são imprescindíveis para o correto funcionamento da aplicação.

Para preencher o arquivo de configuração, é necessários conseguir os dados de acesso ao banco de dados e as APIs utilizadas:
- [Banco de dados](http://silex.sensiolabs.org/doc/providers/doctrine.html)
- [YouTube](https://developers.google.com/youtube/registering_an_application)
- [Vimeo](http://developer.vimeo.com/apps)
- [Cloudinary](http://cloudinary.com/)
- [SoundCloud](https://developers.soundcloud.com/docs/api/guide)

*Todos os parâmetros são obrigatórios.*

## Rodando localmente
Você pode utilizar o [servidor web embutido](http://php.net/manual/pt_BR/features.commandline.webserver.php) no [PHP](http://www.php.net)
para rodar localmente a API. Ou se preferir, configurar seu servidor web preferido apontando para a pasta *public*.
```
composer.phar run
```

## Rodando em modo desenvolvimento
Rodar a API em modo de desenvolvimento, você deve definir a variável de ambiente *APPLICATION_ENV* com o valor *development*.
Caso a variável não esteja definida, o valor padrão é *production*.
Em modo de desenvolvimento, a aplicação irá mostrar todas as mensagens de erro e também de irá logar as mensagens de 
debug.
```
export APPLICATION_ENV="development"
composer.phar run
```

## Testando
### ATENÇÃO: a base é totalmente limpa e são carregadas as fixtures antes dos testes, então, *NÃO EXECUTE EM PRODUÇÃO*.

```
./vendor/bin/phing test
```

## Rotas que não necessitam de um token
- Home
  - Url: /
  - Método: GET

- Signup
  - Url: /signup/
  - Método: POST

- Login
  - Url: /login/
  - Método: POST