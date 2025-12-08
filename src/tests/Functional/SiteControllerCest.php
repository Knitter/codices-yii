<?php

declare(strict_types=1);

namespace tests\Functional;

use HttpSoft\Message\ServerRequest;
use tests\Support\FunctionalTester;
use function PHPUnit\Framework\assertStringContainsString;

final class SiteControllerCest
{
    public function testGetIndex(FunctionalTester $tester): void
    {
        $response = $tester->sendRequest(
            new ServerRequest(uri: '/'),
        );

        assertStringContainsString(
            'Don\'t forget to check the guide',
            $response->getBody()->getContents(),
        );
    }
}
