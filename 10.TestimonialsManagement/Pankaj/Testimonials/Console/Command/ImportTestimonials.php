<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\Testimonials\Console\Command;

use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Csv;
use Pankaj\Testimonials\Api\TestimonialRepositoryInterface;
use Pankaj\Testimonials\Api\Data\TestimonialInterfaceFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Helper\Table;
use Magento\Framework\Filesystem\Driver\File as FileDriver;

class ImportTestimonials extends Command
{
    /** Constant for Command Name */
    private const COMMAND_NAME = 'testimonials:import';
    
    /** Constant for Argument File Path */
    private const ARGUMENT_FILE_PATH = 'file_path';

    /**
     * @var TestimonialRepositoryInterface
     */
    protected $testimonialRepository;
    
    /**
     * @var TestimonialInterfaceFactory
     */
    protected $testimonialFactory;
    
    /**
     * @var Csv
     */
    protected $csvProcessor;
    
    /**
     * @var State
     */
    protected $appState;

    /**
     * @var FileDriver
     */
    protected $fileDriver;

    /**
     * Constructor
     * @param TestimonialRepositoryInterface $testimonialRepository
     * @param TestimonialInterfaceFactory $testimonialFactory
     * @param Csv $csvProcessor
     * @param State $appState
     * @param FileDriver $fileDriver
     */
    public function __construct(
        TestimonialRepositoryInterface $testimonialRepository,
        TestimonialInterfaceFactory $testimonialFactory,
        Csv $csvProcessor,
        State $appState,
        FileDriver $fileDriver
    ) {
        $this->testimonialRepository = $testimonialRepository;
        $this->testimonialFactory = $testimonialFactory;
        $this->csvProcessor = $csvProcessor;
        $this->appState = $appState;
        $this->fileDriver = $fileDriver;
        parent::__construct();
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Import testimonials from a specific CSV file')
            ->addArgument(
                self::ARGUMENT_FILE_PATH,
                InputArgument::OPTIONAL,
                'Enter the full or relative path of the CSV file (e.g. var/import/data.csv)'
            )
            //This for help section
            ->setHelp(
                <<<HELP
                    The <info>%command.name%</info> command allows you to bulk import testimonials.
                    The CSV file must contain headers: name, company_name, post, message, status.

                    Example usage:
                    <comment>php bin/magento %command.name% var/import/testimonials.csv</comment>
                HELP
            );
        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument(self::ARGUMENT_FILE_PATH);

        //Check if file path is provided or not
        if (!$filePath) {
            $output->writeln("<error>[Missing Argument] The CSV file path is required.</error>");
            $output->writeln("<comment>Usage example: php bin/magento testimonials:import var/import/testimonials.csv
            </comment>");
            $output->writeln("<info>Tip: Ensure the file path is correct and accessible.</info>");
            return Cli::RETURN_FAILURE;
        }

        $tableData = [];
        $successCount = 0; // Count of successful imports
        $errorCount = 0; // Count of failed imports

        // Convert relative path to absolute if necessary
        if (strpos($filePath, '/') !== 0) {
            $filePath = BP . '/' . $filePath;
        }

        if (!$this->fileDriver->isExists($filePath)) {
            $output->writeln("<error>File not found at: $filePath</error>");
            return Cli::RETURN_FAILURE;
        }

        try {
            // Emulate Adminhtml area for repository operations
            return $this->appState->emulateAreaCode(Area::AREA_ADMINHTML, function () use ($filePath, $output) {
                $rows = $this->csvProcessor->getData($filePath);
                if (empty($rows) || count($rows) < 2) {
                    $output->writeln('<error>CSV file is empty or missing headers.</error>');
                    return Cli::RETURN_FAILURE;
                }

                $header = array_shift($rows);
                $successCount = 0;
                $errorCount = 0;

                foreach ($rows as $row) {
                    try {
                        // Data mapping using header keys
                        $data = array_combine($header, $row);
                        $name = $data['name'] ?? 'N/A';
                        $company = $data['company_name'] ?? 'N/A';
                        
                        $testimonial = $this->testimonialFactory->create();
                        $testimonial->setData($data);

                        $this->testimonialRepository->save($testimonial);
                        // Success row format: [Name, Company, Status]
                        $tableData[] = [$name, $company, '<info>Success</info>', '-'];

                        $successCount++;
                    } catch (\Exception $e) {
                        // Error row format: [Name, Company, Status, Error Message]
                        $tableData[] = [$name, $company, '<error>Failed</error>', $e->getMessage()];
                        $errorCount++;
                        $output->writeln("<error>Row Error: {$e->getMessage()}</error>");
                    }
                }

                // --- Symfony Table implementation ---
                $table = new \Symfony\Component\Console\Helper\Table($output);
                $table->setHeaders(['Name', 'Company', 'Status', 'Log/Message'])
                    ->setRows($tableData);
                
                $output->writeln(""); // Spacing
                $output->writeln("<info>Import Process Finished</info>");
                $table->render(); // Render the table

                // Final Summary
                $output->writeln("");
                $output->writeln("<comment>Total Success: $successCount | Total Errors: $errorCount</comment>");

                $output->writeln("<info>Import finished. Success: $successCount, Errors: $errorCount</info>");
                return Cli::RETURN_SUCCESS;
            });

        } catch (\Exception $e) {
            $output->writeln("<error>Fatal Error: {$e->getMessage()}</error>");
            return Cli::RETURN_FAILURE;
        }
    }
}
