<?php

namespace Thusitha;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandOne extends BaseCommand
{
    protected function configure()
    {
        $this->setName('command-one');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing Command One');
        
        return 0;
    }
}
