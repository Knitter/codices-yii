<?php

declare(strict_types=1);

namespace tests\Acceptance;

use tests\Support\AcceptanceTester;

final class NotFoundHandlerCest
{
    public function about(AcceptanceTester $I): void
    {
        $I->amOnPage('/about');
        $I->wantTo('see about page.');
        $I->see('404');
        $I->see('The page /about not found.');
        $I->see('The above error occurred while the Web server was processing your request.');
        $I->see('Please contact us if you think this is a server error. Thank you.');
    }

    public function aboutReturnHome(AcceptanceTester $I): void
    {
        $I->amOnPage('/about');
        $I->wantTo('see about page.');
        $I->see('404');
        $I->see('The page /about not found.');
        $I->see('The above error occurred while the Web server was processing your request.');
        $I->see('Please contact us if you think this is a server error. Thank you.');
        $I->click('Go Back Home');
        $I->expectTo('see page home.');
        $I->see('Hello!');
    }
}
