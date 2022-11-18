<?php

/**
 * @link       https://compsaonline.com
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage src/class
 */

namespace Entities\Domain;

/**
 * Class Utils.
 *
 * @package    Entities
 * @subpackage src/class
 * @author     albert <albertperez@compsaonline.com>
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
     * @param string $filePath
     * @param array|null $variables
     * @param bool $print
     * @return false|string|null
     */
    public static function includeCustom(string $filePath, ?array $variables = array(), bool $print = true)
    {
        $output = null;
        if (file_exists($filePath)) {
            // Extract the variables to a local namespace
            if ($variables) {
                extract($variables);
            }

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
     * PHP Custom object class typecasting.
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
