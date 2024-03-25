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

        $firstEmail = $api->waitUntilFirstEmail($proxyEmail->getId());

        $I->assertSame($firstEmail->getSubject(), 'Code confirmation');
        $text = $firstEmail->getPayload()['stripped-text'];
        //find code after "Your confirmation code is"
        preg_match('/Your confirmation code is ([0-9]+)/', $text, $matches);
        var_dump($text);
        $code = $matches[1];

        $I->amOnPage('/email-playground/confirmation.html');
        //testing negative behaviour
        $I->fillField(['id' => 'confirmation_code'], mt_rand(0000, 9999));
        $I->executeJS('document.getElementById("submit").click()');
        sleep(1);

        $I->canSee('Code is invalid');


        $I->fillField(['id' => 'confirmation_code'], $code);
        $I->executeJS('document.getElementById("submit").click()');
        sleep(3);
        $I->canSee('Code is valid');
    }

}
