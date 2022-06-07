<?php

namespace MyProject\Cli;

class Summator extends AbstractCommand
{
    public function execute()
    {
        echo $this->getParam('a') + $this->getParam('b');
    }

    protected function checkParams()
    {
        $this->ensureParamExists('a');
        $this->ensureParamExists('b');
    }
}
