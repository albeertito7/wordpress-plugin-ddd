<?php
/**
 * Template Name: Template-landing Row
 */

use Entities\Domain\Utils;
use Entities\Services\ActivityRepository;
use Entities\Services\HotelRepository;
use Entities\Services\PackageRepository;

$packageRepository = PackageRepository::getInstance();
$packages = $packageRepository->findAll();

$activityRepository = ActivityRepository::getInstance();
$activities = $packageRepository->findAll();

$hotelRepository = HotelRepository::getInstance();
$hotels = $hotelRepository->findAll();

// adds the header built upon the theme builder to the page
get_header();

?>

    <div id="main-content" style="padding:100px;">

        <?php Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/cart-icon.php'); ?>

        <h2><?php _e('My Packages'); ?></h2>
        <hr />

        <!-- Packages Grid -->
        <div class="package-grid" style="margin-top: 30px; display: flex; justify-content: space-evenly; align-self: center; flex-wrap: wrap;">

            <?php foreach ($packages as $package) {
                if ($package->getStatus() == "publish") {
                    Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/entity-card-row.php', array(
                        'package' => $package // cast to product for the entity-card
                    ));
                }
            } ?>
        </div>

        <h2><?php _e('My Activities'); ?></h2>
        <hr />

        <!-- Activities Grid -->
        <div class="package-grid" style="margin-top: 30px; display: flex; justify-content: space-evenly; align-self: center; flex-wrap: wrap;">

            <?php foreach ($activities as $activity) {
                if ($activity->getStatus() == "publish") {
                    Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/entity-card-row.php', array(
                        'package' => $activity // cast to product for the entity-card
                    ));
                }
            } ?>
        </div>

        <h2><?php _e('My Hotels'); ?></h2>
        <hr />

        <!-- Hotels Grid -->
        <div class="package-grid" style="margin-top: 30px; display: flex; justify-content: space-evenly; align-self: center; flex-wrap: wrap;">

            <?php foreach ($hotels as $hotel) {
                if ($hotel->getStatus() == "publish") {
                    Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/entity-card-row.php', array(
                        'package' => $hotel // cast to product for the entity-card
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
