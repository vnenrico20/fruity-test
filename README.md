1. cd into the project folder
2. Set dummy admin email value & MAILER_URL in api/.env (better to create .env.local and override the values)
3. docker-compose up -d
4. docker-compose exec -it api sh /var/www/api/setup.sh
5. docker-compose exec -it api php /var/www/api/bin/console fruits:fetch
6. Open localhost:93 in the browser to view fruit list.
