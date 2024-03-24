<?php

namespace Tests\Acceptance;

use Codeception\Configuration;
use ProxiedMail\Client\Entrypoint\PxdMailApinitializer;
use Tests\Support\AcceptanceTester;
use ProxiedMail\Client\Config\Config;


class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }

    public function frontpageWorks(
        AcceptanceTester $I
    ) {
        $proxiedMailApiToken = Configuration::config()['PROXIEDMAIL_API_TOKEN'];
        $config = new Config();
        $config->setApiToken($proxiedMailApiToken);
        $api = PxdMailApinitializer::init($config);
        $api->createProxyEmail();



        $I->amOnPage('/email-playground/index.html');
        $I->see('Automate your email');
    }

}
