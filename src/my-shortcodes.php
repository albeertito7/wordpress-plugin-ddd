<?php
/**
 * Custom WP Shortcodes
 */

function silence(): string
{
    return "Silence is golden";
}
add_shortcode('silence', 'silence');
