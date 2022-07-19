<?php
/**
 * Template Name: Template-landing Row
 */

$activityRepository = ActivityRepository::getInstance();
$packages = $activityRepository->findAll();

// adds the header built upon the theme builder to the page
get_header();

?>

    <div id="main-content" style="padding:100px;">

        <h2><?php _e('My Activities'); ?></h2>
        <hr />

        <div class="package-grid" style="margin-top: 30px; display: flex; justify-content: space-evenly; align-self: center; flex-wrap: wrap;">

            <?php foreach($packages as $package) {

                if ( $package->getStatus() == "publish" ) {
                    Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/entity-card-row.php', array(
                        'package' => $package // cast to package for the entity-card
                    ));
                }

            } ?>
        </div>
    </div>

<?php

// adds the content built upon the theme builder to the page
// meaning it will be displayed before any other programmatically adding
the_content();

?>

<?php get_footer(); ?>