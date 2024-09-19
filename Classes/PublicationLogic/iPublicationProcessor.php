<?php declare(strict_types=1);

namespace Amenofisch\Pubscheduler\PublicationLogic;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;

interface iPublicationProcessor {
  public function processPublication(
    InputInterface $input,
    OutputInterface $output,
    ConnectionPool $connectionPool,
    array $publicationTypeToDateStringMapping
  ): int;

  public function getTable(): string;
}