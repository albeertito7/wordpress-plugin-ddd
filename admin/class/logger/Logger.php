<?php

/**
 * Class Logger
 *
 * Log entries can be added with any of the following methods:
 *
 * Useful information to log. This is the out-of-the-box level.
 * - Logger::info( $message, $title = '' );
 *
 * Information that is diagnostically helpful to people more than just developers.
 * - Logger::debug( $message, $title = '' );
 *
 * A warning that something might go wrong.
 * Anything that can potentially cause application oddities, but for which I am automatically recovering.
 * - Logger::warning( $message, $title = '' );
 *
 * Any error which is fatal to the operation, but not the service or application
 * - Logger::error( $message, $title = '' );
 *
 * Any error that is forcing a shutdown of the service or application.
 * Reserved for the most heinous errors and situations where there is guaranteed to have been data corruption or loss.
 * - Logger::fatal( $message, $title = '' );
 *
 */
class Logger
{
    /**
     * Incremental log, where each entry is an array with the following elements:
     *
     *  - timestamp => timestamp in seconds as returned by time()
     *  - level => severity of the bug; one between debug, info, warning, error, fatal
     *  - name => name of the log entry, optional
     *  - message => actual log message
     *
     * @var array
     */
    protected static array $log = [];

    /**
     * Whether to print log entries to screen as they are added.
     *
     * @var bool
     */
    public static bool $print_log = true;

    /**
     * Whether to write log entries to file as they are added.
     *
     * @var bool
     */
    public static bool $write_log = false;

    /**
     * Directory where the log will be dumped, without final slash; default
     * is this file's directory.
     *
     * @var string
     */
    public static string $log_dir = __DIR__;

    /**
     * File name for the log saved in the log dir.
     *
     * @var string
     */
    public static string $log_file_name = 'log';

    /**
     * File extension for the logs saved in the log dir
     *
     * @var string
     */
    public static string $log_file_extension = '.log';

    /**
     * Wheter to append to the log file (true), or to overwrite it (false).
     *
     * @var bool
     */
    public static bool $log_file_append = true;

    /**
     * Set the maximum level of logging to write to logs.
     *
     * @var string
     */
    public static string $log_level = 'error';

    /**
     * Name of the default timer.
     *
     * @var string
     */
    public static string $default_timer = 'timer';

    /**
     * Map logging levels to syslog specifications, there's room for the other levels.
     *
     * @var int[]
     */
    private static array $log_level_integers = [
        'debug' => 7,
        'info' => 6,
        'warning' => 4,
        'error' => 3
    ];

    /**
     * Absolute path of the log file, built at run time.
     *
     * @var string
     */
    private static string $log_file_path = '';

    /**
     * Where should we write/print the output to? Build at run time.
     *
     * @var array
     */
    private static array $output_streams = [];

    /**
     * Whether the init() function has already been called.
     *
     * @var bool
     */
    private static bool $logger_ready = false;

    /**
     * Associative array used as a buffer to keep track of timed logs.
     *
     * @var array
     */
    private static array $time_tracking = [];

    /**
     * Add a log entry with a diagnostic message fot the developer.
     *
     * @param $message
     * @param string $name
     * @return array|void
     */
    public static function debug($message, $name = '' ) {
        return self::add( $message, $name, 'debug' );
    }

    /**
     * Add a log entry with an informational message for the user.
     *
     * @param $message
     * @param $name
     * @return array|void
     */
    public static function info( $message, $name='' ) {
        return self::add( $message, $name, 'info' );
    }

    /**
     * Add a log entry with a warning message.
     *
     * @param $message
     * @param $name
     * @return array|void
     */
    public static function warning( $message, $name='' ) {
        return self::add( $message, $name, 'warning' );
    }

    /**
     * Add a log entry with an error.
     *
     * @param $message
     * @param $name
     * @return array|void
     */
    public static function error( $message, $name = '' ) {
        return self::add( $message, $name, 'error' );
    }

    /**
     * Add a log entry with an error - usually followed by script termination.
     *
     * @param $message
     * @param $name
     * @return array|void
     */
    public static function fatal( $message, $name = '' ) {
        return self::add( $message, $name, 'fatal' );
    }

    /**
     * Start counting time, using $name as identifier.
     *
     * Returns the start time or false if a time tracker with the same name exists.
     *
     * @param string|null $name
     * @return false|float
     */
    public static function time( string $name = null ) {

        if ( $name == null ) {
            $name = self::$default_timer;
        }

        if ( ! isset( self::$time_tracking[ $name ] ) ) {
            self::$time_tracking[ $name ] = microtime( true );
            return self::$time_tracking[ $name ];
        }
        else {
            return false;
        }
    }

    /**
     * Stop counting time, and create a log entry reporting the elapsed amount of time.
     *
     * Returns the total time elapsed for the given time-tracker, or false if the time tracker is not found.
     *
     * @param string|null $name
     * @param int $decimals
     * @param $level
     * @return false|string
     */
    public static function timeEnd( string $name = null, int $decimals = 6, $level = 'debug' ) {

        $is_default_timer = $name === null;

        if ( $is_default_timer ) {
            $name = self::$default_timer;
        }

        if ( isset( self::$time_tracking[ $name ] ) ) {
            $start = self::$time_tracking[ $name ];
            $end = microtime( true );
            $elapsed_time = number_format( ( $end - $start ), $decimals );

            unset( self::$time_tracking[ $name ] );

            if ( ! $is_default_timer ) {
                self::add( "$elapsed_time seconds", "Elapsed time for '$name'", $level );
            }
            else {
                self::add( "$elapsed_time seconds", "Elapsed time", $level );
            }

            return $elapsed_time;
        }
        else {
            return false;
        }
    }

    /**
     * Add an entry to the log.
     *
     * This function does not update the pretty log.
     *
     * @param $message
     * @param $name
     * @param $level
     * @return array|void
     */
    public static function add( $message, $name='', $level='debug') {

        /* Check if the logging level severity warrants writing this log */
        if ( self::$log_level_integers[ $level ] > self::$log_level_integers[ self::$log_level ] ) {
            return;
        }

        /* Create the log entry */
        $log_entry = [
            'timestamp' => time(),
            'name' => $name,
            'message' => $message,
            'level' => $level
        ];

        /* Add the lof entry to the incremental log */
        self::$log[] = $log_entry;

        /* Initialize the logger if it hasn't been done already */
        if ( ! self::$logger_ready ) {
            self::init();
        }

        /* Write the log to output, if requested */
        if ( self::$logger_ready && count( self::$output_streams ) > 0 ) {
            $output_line = self::format_log_entry( $log_entry ) . PHP_EOL;
            foreach ( self::$output_streams as $key => $stream ) {
                fputs( $stream, $output_line );
            }
        }

        return $log_entry;
    }

    /**
     * Take on log entry and return a one-line human-readable string.
     *
     * @param array $log_entry
     * @return string
     */
    public static function format_log_entry( array $log_entry ): string {

        $log_line = "";

        if ( ! empty( $log_entry ) ) {

            $log_entry = array_map( function( $v ) { return print_r( $v, true ); }, $log_entry );

            $log_line .= date( 'c', $log_entry[ 'timestamp' ] ) . " ";
            $log_line .= "[" . strtoupper( $log_entry['level'] ) . "] : ";
            if ( ! empty( $log_entry[ 'name' ] ) ) {
                $log_line .= $log_entry[ 'name' ] . " => ";
            }
            $log_line .= $log_entry[ 'message' ];
        }

        return $log_line;
    }

    /**
     * Determine whether an where the log needs to be written; executed only once.
     *
     * @return {array} - An associative array with the output streams.
     * The keys are 'output' for STDOUT and the filename for file streams.
     *
     * @return void
     */
    public static function init() {

        if ( ! self::$logger_ready ) {

            if ( true === self::$print_log ) {
                self::$output_streams[ 'stdout' ] = STDOUT;
            }

            if ( file_exists( self::$log_dir ) ) {
                self::$log_file_path = implode( DIRECTORY_SEPARATOR, [ self::$log_dir, self::$log_file_name ] );
                if ( ! empty( self::$log_file_extension ) ) {
                    self::$log_file_path .= "." . self::$log_file_extension;
                }
            }

            if ( true === self::$write_log ) {
                if ( file_exists( self::$log_dir ) ) {
                    $mode = self::$log_file_append ? "a" : "w";
                    self::$output_streams[ self::$log_file_path ] = fopen( self::$log_file_path, $mode );
                }
            }
        }

        self::$logger_ready = true;
    }

    /**
     * Dump the whole log to the given file.
     *
     * Useful if you don't know beforehand the name of the log file. Otherwise,
     * you should use the real-time logging option, that is,
     * the $write_log or $print_log options.
     *
     * The method format_log_entry() is used to format the log.
     *
     * @param $file_path - Absolute path of the output file. If empty,
     * will use the config property $log_file_path.
     * @return void
     */
    public static function dump_to_file( $file_path='' ) {

        if ( ! $file_path ) {
            $file_path = self::$log_file_path;
        }

        if ( file_exists( dirname( $file_path ) ) ) {
            $mode = self::$log_file_append ? "a" : "w";
            $output_file = fopen( $file_path, $mode );

            foreach ( self::$log as $log_entry ) {
                $log_line = self::format_log_entry( $log_entry );
                fwrite( $output_file, $log_line . PHP_EOL );
            }

            fclose( $output_file );
        }
    }

    /**
     * Dump the whole log to string, and return it.
     *
     * The method format_log_entry() is used to format the log.
     *
     * @return string
     */
    public static function dump_to_string() {

        $output = '';

        foreach ( self::$log as $log_entry ) {
            $log_line = self::format_log_entry( $log_entry );
            $output .= $log_line . PHP_EOL;
        }

        return $output;
    }

    /**
     * Empty the log.
     *
     * @return void
     */
    public static function clear_log() {
        self::$log = [];
    }

}