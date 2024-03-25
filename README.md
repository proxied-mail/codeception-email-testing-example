# codeception-email-testing-example
Example repository about testing emails with [codeception testing framework](https://codeception.com/).

Using [ProxiedMail php library](https://github.com/proxied-mail/proxiedmail-php-client) to perform email receiving and fetching confirmation code.

If you prefer to have some guide to dive into email testing with codeception, feel free to check out [our article on dev.to](https://dev.to/yatsenkolesh/email-testing-with-codeception-4b5g)

## Test Case

Test case is about requesting confirmation on a first page and validating the confirmation code from email on the second.
We have two pages:

1. Page that requests email confirmation (https://proxiedmail.com/email-playground/index.html)
![page](./docs/index-page-screen.png)
3. Page that validating confirmation code (https://proxiedmail.com/email-playground/confirmation.html)
   ![page](./docs/confirm-page-screen.png)

## Code
You can check out the completed code in [EmailCodeCest](./tests/Acceptance/EmailCodeCest.php) 

## Running test

First of all put your ProxiedMail token to env file

```bash
cp .env.dist .env
```

And put your ProxiedMail token to .env.
You can obtain the ProxiedMail token after sign up on [ProxiedMail](https://proxiedmail.com).
Just go to the "API" link in a header section.


Then run composer
```bash
composer install
```

Build and up the docker container (runs docker-compose up -d)
```
make up
```

Now we're able to run the tests. It runs codeception tests
```
make test-run
```

The result should be the following:
```
@hello codeception-email-testing-example % make test-run
docker exec -it pxdmail-codeception-example php vendor/bin/codecept run --steps 
Codeception PHP Testing Framework v5.1.2 https://stand-with-ukraine.pp.ua

Tests.Acceptance Tests (1) -------------------------------------------------------------------------------------------------------------------------------------------------
EmailCodeCest: Frontpage works
Signature: Tests\Acceptance\EmailCodeCest:frontpageWorks
Test: tests/Acceptance/EmailCodeCest.php:frontpageWorks
Scenario --
 I am on page "/email-playground/index.html"
 I fill field {"id":"name"},"Tester"
 I fill field {"id":"email"},"6754fb839@proxiedmail.com"
 I execute js "document.getElementById("submit").click()"
 I can see "Check your mailbox"
 I assert same "Code confirmation","Code confirmation"
string(349) "[App Name](https://proxiedmail.com)

Please, do not reply! Message customer by their emails.
    Bitte nicht antworten! Nachricht an den Kunden per E-Mail.

## Name:
Tester

## E-mail:
6754fb839@proxiedmail.com

## Message:
Your confirmation code is 2203

ProxiedMail: https://proxiedmail.com/

© 2024 App Name. All rights reserved."
 I am on page "/email-playground/confirmation.html"
 I fill field {"id":"confirmation_code"},3079
 I execute js "document.getElementById("submit").click()"
 I can see "Code is invalid"
 I fill field {"id":"confirmation_code"},"2203"
 I execute js "document.getElementById("submit").click()"
 I can see "Code is valid"
 PASSED 

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Tests.Functional Tests (0) -------------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Tests.Unit Tests (0) -------------------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Time: 00:19.199, Memory: 14.00 MB

OK (1 test, 4 assertions)

```
