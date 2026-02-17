## Configurações Iniciais para rodar com Docker + Postgres + Nginx
---

`cp .env.example .env` 

## Usar os comandos a seguir:

- `docker-compose up -d --build` 

- `docker-compose run --rm composer install`

- `docker-compose run --rm npm install`

- `docker-compose run --rm npm run build`

- `docker-compose run --rm artisan key:generate` 

- `docker-compose run --rm artisan migrate --seed` 

- `docker-compose run --rm artisan storage:link` 

- `docker exec -it multistore-app chown -R www-data:www-data /var/www/storage`

> Obs: Por padrão o container da aplicação será "multistore-app", caso mude no docker-compose.yml mude no comando acima também. 

---

> Obs: Checklist de implementações em documentation.md. 


Se ocorrer tudo certo a aplicação irá rodar em [http://localhost](http://localhost)

Acessar o PGAdmin [http://localhost:8080](http://localhost:8080)