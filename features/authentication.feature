Feature: Access to the administration panel
        In order to access the administration panel
        As admin user
        I need to check the identity (via login)
        And allow the end (logout)

    Scenario: Try to acess granted content witout login
        When I go to "/auth"
        Then I should be redirected to "/login"

    Scenario: Logging in with invalid credentials
        Given I am on "/login"
        Then I fill in "Email" with "admin@email.com"
        And I fill in "Password" with "adminpass"
        And I press "Sign in"
        And I should see "Invalid credentials."

    @javascript
    Scenario: Logging in with valid credentials
        Given I am on "/login"
        Then I fill in "Email" with "admin@domain.com"
        And I fill in "Password" with "not-secured-admin-pass"
        And I press "Sign in"
        And I should see "Hello admin@domain.com!"

    Scenario: Try to logout
        Given I am on "/login"
        Then I fill in "Email" with "admin@domain.com"
        And I fill in "Password" with "not-secured-admin-pass"
        And I press "Sign in"
        And I should see "Hello admin@domain.com!"
        Then I should be redirected to "/auth"
        When I go to "/logout"
        Then I should be redirected to "/"
