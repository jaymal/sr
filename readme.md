## Set up instructions

-  docker-compose up -d

- Set the DOCKER_BASE_IP enviroment variable in the website .env file here website/.env according to the base IP of your docker configuration. Mine is http://192.168.99.106

- run 'docker-compose exec app2 bash'

- run 'php artisan migrate' to create necessary database tables

- I used Docker Toolbox  and my IP designations are as follows

  - DOCKER_BASE_IP:80 (http://192.168.99.106:80) - The webservice url

  - DOCKER_BASE_IP:8090 (http://192.168.99.106:8090) - The website URL 

	- Here you can enter the amount and currency to convert and also the currency you are converting to.You then click on the 'Convert' button

	- You can click on the Refresh Logs button to view the last 20 conversion history


- Tests are located in the /tests folder of each of the sites and to run them
	- run 'docker-compose exec app bash' then
	- run 'vendor/bin/phpunit'



  		

