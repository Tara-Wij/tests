<?php

declare(strict_types=1);

use DrupalFinder\DrupalFinder;
use Rector\Set\ValueObject\LevelSetList;
use DrupalRector\Set\Drupal10SetList;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    // Adjust the set lists to be more granular to your Drupal requirements.
    // @todo find out how to only load the relevant rector rules.
    //   Should we try and load \Drupal::VERSION and check?
    $rectorConfig->sets([
        Drupal10SetList::DRUPAL_10,
        LevelSetList::UP_TO_PHP_82,
        LevelSetList::UP_TO_PHP_83
    ]);

    $drupalFinder = new DrupalFinder();
    $drupalFinder->locateRoot(__DIR__);
    $drupalRoot = $drupalFinder->getDrupalRoot();
    $rectorConfig->autoloadPaths([
        $drupalRoot . '/core',
        $drupalRoot . '/modules',
        $drupalRoot . '/profiles',
        $drupalRoot . '/themes'
    ]);

    $rectorConfig->skip(['*/upgrade_status/tests/modules/*']);
    $rectorConfig->fileExtensions(['php', 'module', 'theme', 'install', 'profile', 'inc', 'engine']);
    $rectorConfig->importNames(true, false);
    $rectorConfig->importShortClasses(false);
};
