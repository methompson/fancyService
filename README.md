# FancyService Implementation

How to use this implementation:

In a system with Docker Installed, clone the repo into a folder. From terminal, navigate to the folder and run the following commands:

- docker-compose build
- docker-compose up

Navigate to localhost:8000 to get to the main web server.
Navigate to localhost:8080 to get to adminer database viewer

Username/Password for the database are 'products'

Tests can be performed by using the following commands from terminal:

- docker exec -it php bash

This will put you into the container's linux environment.

- cd /var/www/html

This will place you into the host folder

- ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/upcSearchTest.php

This will run all unit tests