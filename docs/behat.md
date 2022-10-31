Behat cheat sheet
===================

Version (in this tutorial) : 3.11.0

:link: [Official current documentation](https://behat.org/en/latest/guides.html)

Principles
----------
**BDD - Behavior Driven Development**
- Write the behavior for a feature list
- **Code until the behavioral tests passes**
- Think first & then code => maximize the value

**2 types of BDD**
1. Story : is done wih `Behat` & `functional tests` (can be done with PHPUnit `WebTestCase` & `KernelTestCase`  :tada:)
2. Spec : is done with ``PHPSpec`` & ``Unit tests`` (can be done with PHPUnit `kernelTestCase` :tada:)

Getting started
---------------
1. Install the dependency if it's not present in symfony the project by using : `composer require friends-of-behat/mink-extension friends-of-behat/mink-browserkit-driver friends-of-behat/symfony-extension --dev` 
   or to use `Goutte` (make real HTTP requests) :
   `composer require friends-of-behat/mink-extension friends-of-behat/mink-browserkit-driver behat/mink-goutte-driver --dev`
2. Check the install by running : `./vendor/bin/behat -V`

Credits
-------
- [Behat official documentation](https://behat.org/en/latest/index.html)
- [Behat screencast by SymfonyCasts](https://symfonycasts.com/screencast/behat)