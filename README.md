## Environment Setup for the Latest Version of Laravel (PHP, Nginx, Laravel, MySql) Using Docker

### Project Structure

- `docker` - Folder for all configuration files for docker and other services
    - `nginx` - Folder for nginx configuration files
    - `php` - Folder for php configuration files
- `docker-compose.yml` - Docker compose configuration file

- This laravel project uses the Domain Driven Design code structure and logic: the logic of Products and Orders is splitted on Controllers, Services and Repositories under App\Domain namespace

- The interfaces are written entirely in Vue 3 using Inertia.js
- There are endpoints for the interfaces and separated API REST. The API tests are in the Postman collection "Test.postman_collection.json" in the root of the project. 

### Step-by-Step Guide


#### 1. Install HTTPS certificates locally

- Install certutils to manage certificates locally
  ```
  sudo apt-get install libnss3-tools
  ```

- Download the compiled binaries for Linux
  ```
  curl -JLO "https://dl.filippo.io/mkcert/latest?for=linux/amd64"
  chmod +x mkcert-v*-linux-amd64
  sudo cp mkcert-v*-linux-amd64 /usr/local/bin/mkcert
  ```

- Launch local CA installation
  ```
  mkcert -install
  ```

- Generate certificates. From docker/nginx folder launch certificate creation

  ```
  cd docker/nginx
  mkcert -cert-file local-ssl.crt -key-file local-key.key local-test.com
  ```


- Change certificate permission to allow Docker to move them in certificate folders
  ```
  sudo chmod 644 local-key.key
  ```

- Add local domain in /etc/hosts
  ```
  127.0.0.1 local-test.com
  ```

- if the certificates weren't copied in the proper directory by nginx/Dockerfile, copy them manully from the Docker shell as root
  
  ```
  docker exec -u 0 -it mycontainer bash
  cp /var/www/docker/nginx/local-ssl.crt /etc/ssl/certs/local-ssl.crt
  cp /var/www/docker/nginx/local-key.key /etc/ssl/certs/local.key
  ```


#### 2. Build the Project Using Docker Compose

- To install the docker engine on Linux, follow this guide https://docs.docker.com/engine/install/ubuntu/

- After the Docker installation you can give useful permission to your user

  ```
  sudo usermod -aG docker your-user
  ```

- Download or clone the project

  ```
  sudo git clone https://github.com/lspedalieri/project-test.git
  ```

- After download the project, run the following command to build the Docker containers
  
  ```
  docker compose build
  ```

- The images should have all the required dependencies for PHP 8.2 installed on the system

- kill any web services on port 80 and 3306 on the host machine because can interfere with docker services.

  ```
  sudo service apache2 stop
  ```

- Start docker containers

  ```
  docker compose up -d
  ```

#### 3. Download Laravel dependencies

- Enter in the Docker shell to work directly in the workdir

  ```
  docker compose exec app bash
  ```

#### 4. Configure Laravel project 

-  Run the following commands to install Laravel library and set the configuration:

    ```
    composer install
    ```

- Copy .env.example file in .env

    ```
    cp .env.example .env
    ```

    ```
    php artisan key:generate
    ```


- Check DB credentials in .env file
  ```
  DB_CONNECTION=mysql       # connection name, we use mysql
  DB_HOST=mysql             # name of mysql service in docker-compose.yml
  DB_PORT=3306              # mysql standart port 
  DB_DATABASE=app           # database name from MYSQL_DATABASE in 
  DB_USERNAME=root          # username from MYSQL_USER in docker-compose.yml
  DB_PASSWORD=              # user password from MYSQL_PASSWORD in 
  ```

- Exit from Docker shell with CTRL+d and Restart all the services
  
  ```
  docker compose down
  docker compose up -d
  ```
#### 5. Set Node and npm
  
- The project needs Node 20 on the host machine. In the root of the project launch. If nvm is present, just set Node 20
  
  ```
  sudo apt-get update
  sudo apt install nvm
  nvm install 20
  nvm version 20

- After Node/npm installation, download dependencies and start node server to compile Vue scripts
  
  ```
  npm install
  npm run dev
  ```

#### 6. Run Migrations
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

#### 7. Interfaces

- You can verify if the project is working by opening the browser. For example, if it’s set port 80

  ```
  https://local-test.com
  or
  http://local-test.com
  ```

- Login page (root page or /login)

![login Page](https://i.ibb.co/zsP7Wf5/Login-page.png)

- Product page for admins (/products)

![Product page for admins](https://i.ibb.co/1fYFrCH/Schermata-del-2025-01-21-09-35-23.png)

- Product page for users (/products)

![Product page for users](https://i.ibb.co/Mp5pRQr/Order-page.png)

- Order page (/orders)

![Order page](https://i.ibb.co/3RPvcsk/Product-page-for-users.png)


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
  chown -R laravel:laravel /var/www
  ```

