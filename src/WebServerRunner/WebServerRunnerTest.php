<?php
use WebServerRunner\WebServerRunner;

class WebServerRunnerTest extends PHPUnit_Framework_TestCase
{
    public function testRunner()
    {
        $runner = new WebServerRunner('localhost', '3343', './');
        $runner->execute();
        $info = $runner->info();
        $this->assertNotNull($info);

        $pid = $runner->getPid();
        $this->assertNotNull($pid);
    }
}

