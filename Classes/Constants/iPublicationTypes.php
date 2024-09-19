<?php declare(strict_types=1);

namespace Amenofisch\Pubscheduler\Constants;

interface iPublicationTypes {
  public const string DEFAULT = 'default';
  public const string DAILY = 'daily';
  public const string WEEKLY = 'weekly';
  public const string MONTHLY = 'monthly';
  public const string YEARLY = 'yearly';
}