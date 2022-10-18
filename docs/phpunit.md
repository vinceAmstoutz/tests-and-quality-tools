PHPUnit cheat sheet
===================

Version (in this tutorial) : 9.5.25

:link: [Official documentation](https://phpunit.readthedocs.io/)

Getting started
---------------
1. Install the dependency if it's not present in the project : `composer require --dev symfony/test-pack` in a Symfony project or in a standard PHP project : `composer require --dev phpunit/phpunit ^9`.
2. Check the install by running : `./bin/phpunit --version`

Adding tests
------------

> There are many types of automated tests and precise definitions often differ from project to project. In Symfony, the following definitions are used. If you have learned something different, that is not necessarily wrong, just different from what the Symfony documentation is using.

:warning: In the **Symfony test recipe** (based among others on PHPUnit) it's important to know the difference between :

``` TestCase - basic PHPUnit tests 
    KernelTestCase - basic tests that have access to Symfony services
    WebTestCase - to run browser-like scenarios but that don't execute JS code
    ApiTestCase - to run API-oriented scenarios
    PantherTestCase - to run e2e scenarios
```

:bulb: Note that you can see this list by running `php bin/console make:test`


In this part we focused on `TestCase` and after that `KernelTestCase`.


## 1. Tests cases (individual units of source code)

:book: Definition
 > These tests ensure that individual units of source code (e.g. a single class) behave as intended.

1. Generate one simple test case in our Symfony project :
`php bin/console make:test` and then type `TestCase`
or the short version :
`php bin/console make:test TestCase`.
2. Specify the class name **according to the standard described in the command instructions**, in our study case: `\App\Tests\Entity\UserTest`

:bulb: This generates a class named `UserTest.php` in the specified path.

## 2. Integration tests called KernelTestCase (services) 

:book: Definition
 > Modules/services are combined & tested as groups. That's why, we have access to the kernel, this means we have access to all services. To avoid unnecessary configuration, all services are marked as public in the environnement.

1. Generate one simple test case in our Symfony project :
`php bin/console make:test` and then type `KernelTestCase`
or the short version :
`php bin/console make:test KernelTestCase`.
2. Specify the class name **according to the standard described in the command instructions**, in our study case: `\App\Tests\Repository\UserRepository`

:bulb: This generates a class named `UserRepository.php` in the specified path.

## 3. Web tests cases (functional tests for controllers)


Credits
-----------
A big thank you for these extraordinarily well done resources that allowed me to learn PHPUnit (theory & practice) :
- https://symfony.com/doc/current/testing.html
- https://www.strangebuzz.com/en/blog/organizing-your-symfony-project-tests 