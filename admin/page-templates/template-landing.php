<?php
/**
 * Template Name: Template-landing
 */

// adds the header built upon the Divi builder to the page
get_header();

// adds the content built upon the Divi builder to the page
// meaning it will be displayed before any other programmatically adding
//the_content();

$packages = EntitiesController::getStaticPackages();

?>

<div id="main-content" style="padding:100px;">

    <h1><?php _e('My Products'); ?></h1>

    <div class="package-grid" style="margin-top: 100px;">

        <?php foreach($packages as $package) {

            Utils::includeCustom(plugin_dir_path(__FILE__) .  'partials/entity-card.php', array(
                'package' => $package // cast to package for the entity-card
            ));

        } ?>
    </div>
</div>

<?php //echo do_shortcode("[footer]"); ?>
<?php echo do_shortcode('[et_pb_section global_module="397"][/et_pb_section]'); ?>
<?php get_footer(); ?>