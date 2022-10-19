PHP tests & code analysis
=========================

> A bad test is equivalent to no test

:warning: unit tests != functional tests != end to end tests 

Intention
----------
Basic & advanced practice of :
- TDD (Test Driven Development for **unit & functional tests**)  - `PHPUnit`
- BDD (Behavior Driven Development for **end to end tests** ) - `Behat`
- Code analysis - `PHPStan` & `PHP CS Fixer`.
  
With a blank `Symfony` project to practice them.

Dev Env
--------
- `Symfony 6.1` (traditional web app skeleton)
- `PHP 8.1`
- `Docker` 
- `PHPUnit 9.5`
- `PHPStan 1.8`
- `Behat 3.11`
- `PHP CS Fixer 3.11`
  
Documentations
--------------
Docker integration (with caddy server)
- https://github.com/dunglas/symfony-docker#docs 

PHPUnit
- https://symfony.com/doc/current/testing.html
- https://phpunit.readthedocs.io/

PHPStan
- https://phpstan.org/user-guide/getting-started
- https://phpstan.org/writing-php-code/phpdocs-basics
- https://medium.com/@edouard.courty/write-flawless-code-with-phpstan-a6ef9206cc56 

Behat
- https://github.com/Behat/Behat 
- https://symfonycasts.com/blog/behat-symfony and the [full course](https://symfonycasts.com/screencast/behat).

PHP CS Fixer
- https://github.com/FriendsOfPHP/PHP-CS-Fixer

Symfony tutorial in French, from Grafikart, about testing a Symfony app.:
- https://grafikart.fr/tutoriels/tests-symfony-introduction-1213#autoplay