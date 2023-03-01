<?php

namespace Thusitha;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandTwo extends BaseCommand
{
    protected function configure()
    {
        $this->setName('command-two');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing Command Two');

        return 0;
    }
}
