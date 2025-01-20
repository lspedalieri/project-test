## Environment Setup for the Latest Version of Laravel (PHP, Nginx, Laravel, MySql) Using Docker

### Project Structure

- `docker` - Folder for all configuration files for docker and other services
    - `nginx` - Folder for nginx configuration files
    - `php` - Folder for php configuration files
- `docker-compose.yml` - Docker compose configuration file

### Step-by-Step Guide


#### 1. Build the Project Using Docker Compose

- Run this command
  
  ```
  docker compose build
  ```

#### 2. Download Laravel dependencies

-  Run this command:

  ```
  docker compose run --rm composer install .
  php artisan key:generate
  ```

- kill any web services on port 80 and 3306 on the host machine because can interfere with docker services.

  ```
  sudo service apache2 stop
  ```

- Start docker containers

  ```
  docker compose up -d
  ```

- You can verify if the project is working by opening the browser. For example, if it’s set to 80:

  ```
  http://local-test.com
  ```

#### 3. Configure Laravel project 
 

- Copy .env.example file in .env

  ```
  cp .env.example .env
  ```

- Check DB credentials
  ```
  DB_CONNECTION=mysql       # connection name, we use mysql
  DB_HOST=mysql             # name of mysql service in docker-compose.yml
  DB_PORT=3306              # mysql standart port 
  DB_DATABASE=app           # database name from MYSQL_DATABASE in docker-compose.yml
  DB_USERNAME=root          # username from MYSQL_USER in docker-compose.yml
  DB_PASSWORD=              # user password from MYSQL_PASSWORD in docker-compose.yml
  ```
- Restart all services
  
  ```
  docker compose down
  docker compose up -d
  ```
#### 4. Set Node and npm
  
- The project needs Node 20 on the host machine. In the root of the project launch. If nvm is present, just set Node 20
  
  ```
  apt install nvm
  nvm install 20
  nvm version 20

- After Node/npm installation, download dependencies and start node server to compile Vue scripts
  
  ```
  npm install
  npm run dev
  ```

#### 5. Run Migrations
- Run migration and seeder from the host machine shell

  ```
  docker compose run --rm artisan migrate
  docker compose run --rm artisan db:seed DatabaseSeeder
  ```

- Or enter in docker shell first
  
  ```
  docker compose exec app bash
  php artisan migrate
  php artisan db:seed DatabaseSeeder
  ```

#### Test
- The endpoints can be found in the Postman collection "Test.postman_collection.json" in the root of the project. 
- Steps:
  - login with credentials "admin@example.com" for admin and "user@example.com" for a user, the password is "password"
  - Use the "service-api" parameter as bearer token in the authorization parameters to use the other api
  

![login result](https://i.ibb.co/TqPzWd5/Schermata-del-2025-01-20-09-49-52.png)
![how to set the bearer token variable](https://i.ibb.co/wLWSxb1/Schermata-del-2025-01-20-09-54-52.png)


#### Some useful commands

- Enter the php container (php is the name of the service from docker-compose.yml)

  ```
  docker compose run --rm php /bin/sh

  ```

- If access Forbidden

  ```
  docker compose run --rm php /bin/sh
  chown -R laravel:laravel /var/www/html
  ```

