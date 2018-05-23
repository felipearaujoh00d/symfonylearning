<?php

namespace Tests\AppBundle\Command;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class SoundAlarmCommandTest extends WebTestCase
{
    public function testItOutputsInUppercaseOnYellOption()
    {
        $output = $this->runCommand('app:sound-alarm', [
            'message' => 'run',
            '--yell' => true,
        ]);

        $this->assertSame('ALARM: RUN !!!', $output);
    }
}
