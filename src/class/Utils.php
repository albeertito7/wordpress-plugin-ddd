<?php

namespace Entities\Domain;

/**
 * Class Utils
 */
class Utils
{
    /**
     * Utils constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param $filePath
     * @param array $variables
     * @param bool $print
     * @return false|string|null
     */
    public static function includeCustom($filePath, array $variables = array(), bool $print = true)
    {
        $output = null;
        if (file_exists($filePath)) {
            // Extract the variables to a local namespace
            extract($variables);

            // Start output buffering
            ob_start();

            // Include the template file
            include $filePath;

            // End buffering and return its contents
            $output = ob_get_clean();
        }

        if ($print) {
            print $output;
        }

        return $output;
    }

    /**
     * @param $instance
     * @param $className
     * @return mixed
     *
     * PHP Custom object class typecasting
     */
    public static function objectToObject($instance, $className)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($className),
            $className,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }
}
