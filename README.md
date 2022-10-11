PHP tests & code analysis
=========================

Intention
----------
Basic & advanced practice of :
- TDD (Test Driven Development) - `PHPUnit`
- BDD (Behavior Driven Development) - `Behat`
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

Commands
--------
Check the [Makefile](Makefile) directly or run `make help` into a bash.

On Windows systems you must install `make` with [choco](https://community.chocolatey.org/packages/make#install) before using it. [Instructions](https://chocolatey.org/install) to install it very quickly.

To display the `make help` correctly, you need to use a bash (linux based). So under Windows OS, ZSH or GitBash for e.g. are recommended. 

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