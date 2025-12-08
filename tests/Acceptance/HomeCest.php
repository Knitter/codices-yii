<?php

declare(strict_types=1);

namespace tests\Acceptance;

use tests\Support\AcceptanceTester;

final class HomeCest
{
    public function testIndexPage(AcceptanceTester $I): void
    {
        $I->wantTo('home page works.');
        $I->amOnPage('/');
        $I->expectTo('see page home.');
        $I->see('Hello!');
    }
}
