<?php

declare(strict_types=1);

namespace tests\Cli;

use tests\Support\CliTester;

final class ConsoleCest
{
    public function testCommandYii(CliTester $I): void
    {
        $command = dirname(__DIR__, 2) . '/yii';
        $I->runShellCommand($command);
        $I->seeInShellOutput('Yii Console');
    }

    public function testCommandHello(CliTester $I): void
    {
        $command = dirname(__DIR__, 2) . '/yii';
        $I->runShellCommand($command . ' hello');
        $I->seeInShellOutput('Hello!');
    }
}
