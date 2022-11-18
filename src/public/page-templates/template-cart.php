<?php

use Entities\Domain\cart\ProductCart;
use Entities\Domain\Utils;
use Entities\Services\PackageRepository;
use Entities\Services\HotelRepository;
use Entities\Services\ActivityRepository;

$cart = ProductCart::collect();

//$packages = $cart['Entities\Domain\product\Package'];
//$activity = $cart["Entities\\Domain\\product\\Activity"];
//$hotels = $cart['Entities\Domain\product\Hotel'];

$repo_package = PackageRepository::getInstance();
$repo_hotel = HotelRepository::getInstance();
$repo_activity = ActivityRepository::getInstance();

// adds the header built upon the theme builder to the page
if (wp_is_block_theme()) {
    block_template_part('header');
    wp_head();
} else {
    get_header();
}

?>

<style>
    .contact_feedback {
        outline: none;
        padding: 8px 40px;
        color: white;
        float: right;
        font-size: 25px;
    }
</style>

<div id="main-content" style="padding:100px;">

    <button class="contact_feedback">Contact</button>

    <?php foreach ($cart as $class => $products) { ?>
        <!-- Products Header -->
        <h2><?php _e($class . ' Cart'); ?></h2>
        <hr />

        <!-- Products Grid -->
        <div class="package-grid" style="margin-top: 30px; display: flex; justify-content: space-evenly; align-self: center; flex-wrap: wrap;">

            <?php foreach ($products as $id => $cart_info) {
                $product = null;
                $xarray = explode("\\\\", $class);
                switch (end($xarray)) {
                    case 'Package':
                        $product = $repo_package->findById($id);
                        break;
                    case 'Hotel':
                        $product = $repo_hotel->findById($id);
                        break;
                    case 'Activity':
                        $product = $repo_activity->findById($id);
                        break;
                }

                //echo get_class($product);
                $product = Utils::objectToObject($product, "Entities\\Domain\\product\\Product");
                if ($product->getStatus() == "publish") {
                    Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/entity-card.php', array(
                        'package' => $product // cast to product for the entity-card
                    ));
                }
            } ?>
        </div>
    <?php } ?>
</div>

<?php

// adds the content built upon the theme builder to the page
// meaning it will be displayed before any other programmatically adding
the_content();

?>

<?php
Utils::includeCustom(plugin_dir_path(__FILE__) . 'partials/cart-contact-form.php');

// load footer theme
if (wp_is_block_theme()) {
    block_template_part('footer');
    wp_footer();
} else {
    get_footer();
}

?>
