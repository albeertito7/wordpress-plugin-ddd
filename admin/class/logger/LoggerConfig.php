<?php

/**
 * DTO (Data Transfer Object),
 * for a specific Logger implementation.
 *
 * DTO is one of the enterprise application architecture patterns that calls for the use of objects that
 * aggregate and encapsulate data for transfer.
 *
 * Like a data structure.
 *
 * Martin Fowler - Patterns of Enterprise Application Architecture - definition:
 *  - The main idea of DTOs is to reduce the number of remote calls that are expensive.
 *
 *
 */
class LoggerConfig
{

    var bool $print_log;
    var bool $write_log;

    var string $log_dir;
    var string $log_file_name;
    var string $log_file_extension;

    var bool $log_file_append;

    var string $log_level;

    var string $default_timer;

    var array $log_level_integers = [
      'debug' => 7,
      'info' => 6,
      'warning' => 4,
      'error' => 3
    ];

    var string $log_file_path = '';

}