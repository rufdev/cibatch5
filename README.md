# HOW TO INSTALL

METHOD 1
1. Download the source code from this repo
2. Extract the folder source code (zip) file on your htdocs folder (change folder name to the name of your project ex. ciapp)
3. Edit the .env file (change values as to your project folder name and database connection parameters):

app.baseURL = 'http://localhost/ciapp'

database.default.hostname = localhost
database.default.database = ciapp
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

4. Run the following commands on your terminal
 - composer update
 - composer install
 - php spark shield:setup
 - php spark migrate --all
