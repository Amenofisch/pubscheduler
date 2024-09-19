<?php declare(strict_types=1);

namespace Amenofisch\Pubscheduler\PublicationLogic;

use Amenofisch\Pubscheduler\Constants\iTables;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\ConnectionPool;

class ttContentPublication implements iPublicationProcessor {

  public function processPublication(
    InputInterface $input,
    OutputInterface $output,
    ConnectionPool $connectionPool,
    array $publicationTypeToDateStringMapping
  ) : int {
    $io = new SymfonyStyle($input, $output);

    try {
      // Get the QueryBuilder for the 'pages' table
      $queryBuilder = $connectionPool
        ->getQueryBuilderForTable($this->getTable());

      $queryBuilder->getRestrictions()->removeAll();

      // Fetch all pages that have a starttime or endtime
      $contents = $queryBuilder
        ->select('uid', 'starttime', 'endtime', 'pubscheduler_publication_type')
        ->from($this->getTable())
        ->where(
          $queryBuilder->expr()->orX(
            $queryBuilder->expr()->gt('starttime', 0),
            $queryBuilder->expr()->gt('endtime', 0)
          )
        )
        ->executeQuery()
        ->fetchAllAssociative();

      if (empty($contents)) {
        $io->success(sprintf('No %s found with starttime or endtime.', $this->getTable()));
        return Command::SUCCESS;
      }

      $updatedCount = 0;
      $updatedIds = [];

      foreach ($contents as $content) {
        $uid = $content['uid'];
        $starttime = $content['starttime'];
        $endtime = $content['endtime'];
        $mappedDateString = $publicationTypeToDateStringMapping[$content['pubscheduler_publication_type'] ?? 'default'];

        $currentTime = time();  // Get the current timestamp

        // Only update the times if both starttime and endtime are in the past
        if (($starttime > 0 && $starttime < $currentTime) || ($endtime > 0 && $endtime < $currentTime)) {
          // Add the mapped time period to starttime and endtime
          $newStartTime = ($starttime > 0) ? strtotime($mappedDateString, $starttime) : $starttime;
          $newEndTime = ($endtime > 0) ? strtotime($mappedDateString, $endtime) : $endtime;

          if ($newStartTime > 0 || $newEndTime > 0) {
            // Update the record with the new values
            $queryBuilder
              ->update($this->getTable())
              ->set('starttime', $newStartTime)
              ->set('endtime', $newEndTime)
              ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid)))
              ->executeStatement();

            $updatedCount++;
            $updatedIds[] = $uid;
          }
        }
      }

      if ($updatedCount > 0) {
        $io->success(sprintf('Updated %d %s entries successfully! Updated IDs: %s', $updatedCount, $this->getTable(), implode(', ', $updatedIds)));
      } else {
        $io->warning(sprintf('No %s was updated because no starttime or endtime was in the past.', $this->getTable()));
      }

      return Command::SUCCESS;
    } catch (\Exception $e) {
      $io->error('An error occurred: ' . $e->getMessage());
      return Command::FAILURE;
    }
  }

  public function getTable()
  : string {
    return iTables::TT_CONTENT;
  }
}