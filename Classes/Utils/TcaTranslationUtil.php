<?php declare(strict_types=1);

namespace Amenofisch\Pubscheduler\Utils;

class TcaTranslationUtil {
  public static function buildLanguageString(string $key): string {
    return 'LLL:EXT:pubscheduler/Resources/Private/Language/locallang_pubscheduler.xlf:' . $key;
  }
}