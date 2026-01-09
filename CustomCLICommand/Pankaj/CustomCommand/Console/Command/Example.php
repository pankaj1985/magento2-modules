<?php
namespace Pankaj\CustomCommand\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Example extends Command
{
    protected function configure()
    {
        $this->setName('pankaj:example')
             ->setDescription('Example custom CLI command for Magento 2');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Hello! This is a custom CLI command.</info>");
        return Cli::RETURN_SUCCESS;
    }
}
