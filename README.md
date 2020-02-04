# Ambassadeurs de créateurs
Réalisation et conception du site Internet Ambassadeurs de créateurs.

# Objectifs pédagogiques
Projet client réalisé dans le cadre de la formation « Développeur web et web mobile » à la Wild Code School, pour la société « Ambassadeurs de créateurs ».

 - Les technologies utilisées sont : PHP 7.2 / Symfony 4.4.3 / Doctrine 2 / Twig / HTML 5 / CSS-SCSS / Bootstrap 4 / Javascript / MySQL
 - Développement de fonctionnalités : identification, rôles utilisateurs, importation de fichier, carte interactive, etc.
 - Méthode Scrum / Agile sur 8 semaines.



# Installer le projet Ambassadeurs de créateurs

-  Cloner le repository Ambassadeurs de créateurs (https://github.com/WildCodeSchool/orleans-0919-php-ambassadeurs-de-createurs.git)

-  Créer un fichier .env.local à partir du fichier .env et renseigner vos données sur cette ligne :
```sh
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```
*db_user*:  votre nom d’utilisateur
*db_password*: votre mot de passe
*db_name*: le nom de la base de données

-  Installer Composer, avec la commande :
```sh
$ composer install
```

-  [Initialiser et installer yarn](https://classic.yarnpkg.com/fr/docs/install/#debian-stable) 

-  Créer une base de données, avec la commande :
```sh
$ php bin/console doctrine:database:create
```
-  Mettre à jour la base de données, avec la commande :
```sh
$ php bin/console make:migration
$ php bin/console doctrine:schema:update --force
```
-  Charger les fixtures : 
```sh
$ php bin/console doctrine:fixture:load --append
```

-  Exécuter Webpack, avec la commande :
```sh
$ yarn encore dev –watch (pour un environnement de développement)
$ yarn encore production (pour un environnement de production)
```
- Lancer le serveur, avec la commande :
```sh
$ symfony server:start
```



# Contributeurs
-  Bédu Steven [Stevenbdu](https://github.com/Stevenbdu)
-  De Sousa Sylvain [sdesousa](https://github.com/sdesousa)
-  Planchenault Cindy [cnd24](https://github.com/cnd24)
-  Richard Caroline [Helra](https://github.com/Helra)
-  Va Toua [Toua45](https://github.com/Toua45)


#Informations de la Wild Code School


# Project 3 - Starter Kit - Symfony 4.4.*

![Wild Code School](https://wildcodeschool.fr/wp-content/uploads/2019/01/logo_pink_176x60.png)

This starter kit is here to easily start a repository for your students.

It's symfony website-skeleton project with some additional tools to validate code standards.

* GrumPHP, as pre-commit hook, will run 2 tools when `git commit` is run :
  
    * PHP_CodeSniffer to check PSR2 
    * PHPStan will check PHP recommendation
     
  If tests fail, the commit is canceled and a warning message is displayed to developper.

* Travis CI, as Continuous Integration will be run when a branch with active pull request is updated on github. It will run :

    * Tasks to check if vendor, .idea, env.local are not versionned,
    * PHP_CodeSniffer to check PSR2,
    * PHPStan will check PHP recommendation.
 

## Getting Started for trainers

Before your students can code, you have some work to do !

### Prerequisites

Create a repository on Github in WildCodeSchool organization following this exemple :
**ville-session-language-project** as **bordeaux-0219-php-servyy**

### Get starter kit

1. Clone this project
2. Remove `.git` folder to remove history
3. `git init`
4. Link to your project repository you'll give to your students : `git remote add origin ...`
5. Edit `.travis.yml` file to change default e-mails settings to get notification checking tasks end
6. Remove trainers instructions
5. `git add .`
6. `git commit -m "Init project repository"`
7. `git push -u origin master`

### Check on Travis

1. Go on [https://travis-ci.com](https://travis-ci.com).
2. Sign up if you don't have account,
3. Look for your project in search bar on the left,
4. As soon as your repository have a `.travis.yml` in root folder, Travis should detect it and run test.

> You can watch this screenshot to see basic configuration : ![basic config](http://images.innoveduc.fr/symfony4/travis-config.png)



### Configure you repository - Settings options

1. Add your students team as contributor .
2. Disallow both on 'dev' and 'master' branches your students writing credentials. 
3. Disallow merge available while one approbation is not submitted on PR.

> You can watch this very tiny short video : (Loom : verrouillage branches GitHub)[https://www.loom.com/share/ad0c641d0b9447be9e40fa38a499953b]

## Getting Started for Projects

### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`

### Working

1. Run `php bin/console server:run` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets

### Testing

1. Run `./bin/phpcs` to launch PHP code sniffer
2. Run `./bin/phpstan analyse src --level max` to launch PHPStan
3. Run `./bin/phpmd src text phpmd.xml` to launch PHP Mess Detector
3. Run `./bin/eslint assets/js` to launch ESLint JS linter
3. Run `./bin/sass-lint -c sass-linter.yml` to launch Sass-lint SASS/CSS linter

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command :

`git config --global core.autocrlf true`

## Deployment

Add additional notes about how to deploy this on a live system


## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)
* [Travis CI](https://github.com/marketplace/travis-ci)

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning


## Authors

Wild Code School trainers team

## License

MIT License

Copyright (c) 2019 aurelien@wildcodeschool.fr

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Acknowledgments

