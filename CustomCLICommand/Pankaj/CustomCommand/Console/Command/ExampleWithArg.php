<?php
namespace Pankaj\CustomCommand\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;

class ExampleWithArg extends Command
{
    // Default values
    private const DEFAULT_CITY = 'Unknown';

    // Argument names
    private const NAME_ARGUMENT = 'name';

    // Argument City
    private const CITY_ARGUMENT = 'city';

    //Uppercase option
    private const UPPERCASE_OPTION = 'uppercase';


    protected function configure()
    {
        $this->setName('pankaj:second:command')
            ->setDescription('This is second example command with argument and option')
            //Required argument
             ->addArgument(
                 self::NAME_ARGUMENT,
                 InputArgument::REQUIRED,
                 'Enter your name'
             )
             
             //Optional argument
             ->addArgument(
                 self::CITY_ARGUMENT,
                 InputArgument::OPTIONAL,
                 'Enter your city',
                 self::DEFAULT_CITY
             )
             
             //Optional flag (option)
             ->addOption(
                 self::UPPERCASE_OPTION,
                 null,
                 InputOption::VALUE_NONE,
                 'Display message in uppercase'
             );

        parent::configure();
    }
    
    /**
     * Print stores in table formate
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
            $name = $input->getArgument(self::NAME_ARGUMENT);
            $city = $input->getArgument(self::CITY_ARGUMENT);
            $uppercase = $input->getOption(self::UPPERCASE_OPTION);

            $message = "Hello, $name from $city! Welcome to Magento 2 CLI commands.";
            if ($uppercase) {
                $message = strtoupper($message);
            }

            $output->writeln("<info>$message</info>");

            return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
    }
}