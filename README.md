[![Dependency Status](https://www.versioneye.com/user/projects/565d82010188bb000d000150/badge.svg?style=flat)](https://www.versioneye.com/user/projects/565d82010188bb000d000150) [![Build Status](https://travis-ci.org/carloscmaleno/php-symfony-basic.svg?branch=master)](https://travis-ci.org/carloscmaleno/php-symfony-basic)

Symfony basic project
====
Base 
A Symfony project created on November 30, 2015, 2:34 pm.

## Installation

git clone ...

composer install

npm install

./node_modules/grunt-cli/bin/grunt

## Maquetación

Los recursos CSS, JS, IMG y FONTS van en la carpeta "resources". Grunt se encarga de 
copiar/minificar/encapsular/comprimir todo en su carpeta correspondiente "web/"

Los recursos externos, como jQuery, Bootstrap, etc van a través de NPM y deberán añadirse a la tarea "copy" de Grunt.

Hay 2 perfiles de Grunt

* grunt default: Tiene un watcher al final, para el entorno de desarrollo.

* grunt package: Empaqueta todo y termina.

## Contributors

Programación: Carlos Coronado.

## License
The MIT License (MIT)