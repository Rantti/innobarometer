#MobileBarometer
---

A Symfony project created on September 16, 2015, 3:27 pm.

The project uses Friends of Symphony UserBundle to work with the users.

## Requirements and Installation

Mobilebarometer uses Symfony 2-framework. This requires MySql and PHP. The project also uses composer to install some project dependencies like bootstrap.  
Symfony installation: http://symfony.com/doc/current/book/installation.html  
Composer installation https://getcomposer.org/doc/00-intro.md  
After the installation clone the repository from git
- `$git git@github.com:Rantti/innobarometer.git`
- `$cd innobarometer`
- `$composer install`
- go to app/config/ and copy the contents of the parameters.yml.dist into a new file in the same directory named parameters.yml.
- Inside this file define the basic parameters used by the Symfony project. Only the database-parameters matter in this project.
- Go back to the direcotory root and run.
- `php app/console doctrine:generate:entities AppBundle`
- `php app/console doctrine:schema:update --force`
- Start up the web-server by running `$php app/console server:run`
- Open up your browser and go to `localhost:8000` to get access to your new mobilebarometer-project.

#### User promotion
After creating yourself a new user, go to commandline and type (replace 'username' with your username)  
`$php app/console fos:user:promote username ROLE_ADMIN`  
to promote yourself to admin-priviledges. You should be now able to access all different entity-controls, including initiating questionnaires.

### Web Server Configuration
To use this project on an Apache WebServer, you have to create a configuration which directs to your mobilebarometer location.

- `$cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/mobilebarometer.conf`
- `$sudoedit /etc/apache2/sites-available/mobilebarometer.conf`  
- Paste the following inside the file and replace the [path/to/your/mobilebarometer/folder/web] with your own path.
```
<Directory />
        Allow from All
</Directory>
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName serverName.local
        ServerAlias serverAlias.local
        DocumentRoot path/to/your/mobilebarometer/folder/web

        <Directory path/to/your/mobilebarometer/folder/web>
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
- After saving the file run `$sudo a2ensite mobilebarometer` and navigate to localhost to find your own mobilebarometer project.

###Some useful commands for cmd
+ `$php app/console fos:user:promote username ROLE_ADMIN`  
+ `$php app/console doctrine:database:create`  
+ `$php app/console doctrine:schema:update --force`  


##How to use CSVtoSQL.py

This program is designed to take a CSV file and turn it into SQL insert clauses which are run to add statements into your database.

- The table it currently uses (hard coded) Statement
- the CSV has to be in following format: 
  Seperated by Semicolon ;
  First row: header. 
  First column: External id, Third column: Statement, Sixth column: Category. Other columns not used at this time.

- The program will create CSVtoSQL.ini the first time you run it. It will contain: Host name, user, password, database name and file name. ** Make sure you add this file to your gitignore. **
- You need Python 2.7 to run this program. Instal python & add python to your system variable. You may also need to import some libraries. 

- Ask Jyri if you have any questions regarding this program or it's function.

---

For updates and more explained, check  out the [blog](https://slothfuldesigns.wordpress.com).

[Antti Eloranta](https://anttieloranta.wordpress.com)

[Turo Mikkonen](https://turomikkonen.wordpress.com)



