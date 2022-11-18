<?php
/**
 * Template Name: Template-landing Row
 */

use Entities\Domain\Utils;
use Entities\Services\PackageRepository;

$packageRepository = PackageRepository::getInstance();
$packages = $packageRepository->findAll();

// adds the header built upon the theme builder to the page
// load header theme
if (wp_is_block_theme()) {
    block_template_part('header');
    wp_head();
} else {
    get_header();
}

?>

    <div id="main-content" style="padding:100px;">

        <?php Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/cart-icon.php'); ?>

        <h2><?php _e('My Packages'); ?></h2>
        <hr />

        <div class="package-grid" style="margin-top: 30px; display: flex; justify-content: space-evenly; align-self: center; flex-wrap: wrap;">
            <?php foreach ($packages as $package) {
                if ($package->getStatus() == "publish") {
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

<?php

// load footer theme
if (wp_is_block_theme()) {
    block_template_part('footer');
    wp_footer();
} else {
    get_footer();
}

?>
