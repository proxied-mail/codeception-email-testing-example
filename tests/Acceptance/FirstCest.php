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

    public function frontpageWorks(
        AcceptanceTester $I
    ) {
        $proxiedMailApiToken = Configuration::config()['PROXIEDMAIL_API_TOKEN'];
        $config = new Config();
        $config->setApiToken($proxiedMailApiToken);
        $api = PxdMailApinitializer::init($config);
        $proxyEmail = $api->createProxyEmail();


        $I->amOnPage('/email-playground/index.html');
        $I->fillField(['id' => 'name'], 'Tester');
        $I->fillField(['id' => 'email'], $proxyEmail->getProxyAddress());
        $I->executeJS('document.getElementById("submit").click()');
        sleep(3);

        $I->canSee('Check your mailbox');
    }

}
