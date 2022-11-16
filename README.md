[![CI status badge](https://github.com/vinceAmstoutz/tests-and-quality-tools/actions/workflows/ci.yaml/badge.svg?branch=main)](https://github.com/vinceAmstoutz/tests-and-quality-tools/actions/workflows/ci.yml)
[![PHP lint status badge](https://github.com/vinceAmstoutz/tests-and-quality-tools/actions/workflows/lint.yaml/badge.svg)](https://github.com/vinceAmstoutz/tests-and-quality-tools/actions/workflows/lint.yaml)
[![Codecov badge](https://codecov.io/gh/vinceAmstoutz/tests-and-quality-tools/branch/main/graph/badge.svg?token=3XOC3NTY00)](https://codecov.io/gh/vinceAmstoutz/tests-and-quality-tools)
[![PHPStan level badge](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg?style=flat&logo=php)](./phpstan.neon.dist)

PHP tests & code analysis
=========================

> A bad test is equivalent to no test!

:warning: unit tests != integration tests != functional tests != end to end tests

:brain: Intention
----------
Basic & advanced practice of :
- TDD (Test Driven Development for **unit, integration & functional tests**)  - `PHPUnit`
- BDD (Behavior Driven Development for **end to end tests** ) - `Behat & PHPSpec` and complete it with the newest E2E solution `symfony/panther`. 
- Code analysis - `PHPStan` & `PHP CS Fixer` & `Decomplex web tool`.
  
With a blank `Symfony` project to practice them and I take the opportunity to practice SOLID, KISS and other code quality principles.

:shield: Dev Env
--------
- `Symfony 6.1` (traditional web app skeleton)
- `PHP 8.1`
- `Docker` 
- `PHPUnit 9.5`
- `PHPStan 1.8`
- `Symfony Panther 2.0`
- `Behat 3.11` (using Symfony's HTTP Client)
- `PHP CS Fixer 3`
- `nektos/act` (Run GitHub Actions locally)
  
:gift: Pros tips
---------
- Red Green Refactor for TDD
- Replace STUPID by SOLID
- DRY vs WET for less complexity  

:books: Documentations & resources
--------------
Docker integration (with caddy server)
- https://github.com/dunglas/symfony-docker#docs 

PHPUnit
- https://symfony.com/doc/current/testing.html
- https://phpunit.readthedocs.io/

Symfony Panther (E2E tests)
- https://github.com/symfony/panther
  
PHPStan
- https://phpstan.org/user-guide/getting-started
- https://phpstan.org/writing-php-code/phpdocs-basics
- https://medium.com/@edouard.courty/write-flawless-code-with-phpstan-a6ef9206cc56 

Behat
- https://github.com/Behat/Behat 
- https://symfonycasts.com/blog/behat-symfony and the [full course](https://symfonycasts.com/screencast/behat).

PHP CS Fixer
- https://github.com/FriendsOfPHP/PHP-CS-Fixer
- https://www.strangebuzz.com/en/blog/initializing-your-symfony-project-with-solid-foundations

Decomplex web tool 
- :chart: The complexity is measured with two KPI (cyclomatic complexity + cognitive complexity)
with a complexity quantified between 0 & 10 for each of them (an acceptable rate is 4 maximum).

    :link: It's possible to share the result by a permalink directly.

- https://github.com/chr-hertel/decomplex
- https://decomplex.me/eZGq7A 

Symfony tutorial in French, from Grafikart, about testing a Symfony app.:
- https://grafikart.fr/tutoriels/tests-symfony-introduction-1213#autoplay
