<?php declare(strict_types=1);

namespace Amenofisch\Pubscheduler\Commands;

use Amenofisch\Pubscheduler\Constants\iPublicationTypes;
use Amenofisch\Pubscheduler\PublicationLogic\iPublicationProcessor;
use Amenofisch\Pubscheduler\PublicationLogic\PagesPublication;
use Amenofisch\Pubscheduler\PublicationLogic\ttContentPublication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PublicationCommand extends Command {
  public array $publicationTypeToDateStringMapping = [
    iPublicationTypes::DEFAULT => '',
    iPublicationTypes::DAILY => '+1 day',
    iPublicationTypes::WEEKLY => '+1 week',
    iPublicationTypes::MONTHLY => '+1 month',
    iPublicationTypes::YEARLY => '+1 year'
  ];

  public array $publicationRunners = [
    PagesPublication::class,
    ttContentPublication::class
  ];

  private ConnectionPool $connectionPool;

  public function __construct(ConnectionPool $connectionPool)
  {
    $this->connectionPool = $connectionPool;
    parent::__construct();
  }

  protected function configure(): void
  {
    $this
      ->setDescription('Updates the start and end dates of all TYPO3 pages by adding the configured amount of time from the backend.')
      ->setHelp('This command updates all entries where publication type is not the default.');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $responses = array_map(function($runner) use($input, $output) {
      $instance = GeneralUtility::makeInstance($runner);

      if($instance instanceof iPublicationProcessor) {
        return $instance->processPublication($input, $output, $this->connectionPool, $this->publicationTypeToDateStringMapping);
      }

      return Command::FAILURE;
    }, $this->publicationRunners);

    if(
      in_array(Command::FAILURE, $responses, true) ||
      in_array(Command::INVALID, $responses, true)
    ) {
      return Command::FAILURE;
    }

    return Command::SUCCESS;
  }
}