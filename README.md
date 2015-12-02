#MobileBarometer
---

A Symfony project created on September 16, 2015, 3:27 pm.

The project uses Friends of Symphony UserBundle to work with the users.

#Installation
---
1. Clone project
2. Go to the directory. On commandline:
  + `$composer install`

3. Open innobarometer/app/config/parameter.yml and setup correct settings for your database.

4. Set up project entities.
  + $`php app/console doctrine:generate:entities AppBundle`

5. Create database and schema for project.
  + `php app/console doctrine:schema:update --force`

6. Start up web-server.
  + `$php app/console server:run`

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

- Ask Jyri if you have any questions regarding this.


For updates and more explained, check  out the [blog](https://slothfuldesigns.wordpress.com).

[Antti Eloranta](https://anttieloranta.wordpress.com)

[Turo Mikkonen](https://turomikkonen.wordpress.com)

#TODO

+ päivitä entityt
+ korjaa kontrolleriin tiimin luonti (lisää jäsenet ja tiimit teammember-tauluun)
+ tee uusi projektikontrolleri
+ muuta answer+entity niin että siihen tallennetaan ihan kaikki
+ uuden questionnairen yhteydessä kehitetään vastaukset jotka on tyhjiä -> täytetään kun käyttäjä täyttää, muutoin näytetään sivuilla questionnaire saatavilla olevana

+ tiimi projektiin kiinni
+ projekti kyselyyn kiinni
+ miten käyttäjän vastauksen tilaa tarkkaillaan
+ käyttäjän, tiimin ja projektin muokattavuus / poistaminen



