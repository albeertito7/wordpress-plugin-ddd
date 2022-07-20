<?php

$cart = ProductCart::collect();

/*$packages = $cart['Package'];
$activity = $cart['Activity'];
$hotels = $cart['Hotel'];*/

$repo = PackageRepository::getInstance();

// adds the header built upon the theme builder to the page
get_header();

?>

<div id="main-content" style="padding:100px;">

    <?php foreach($cart as $class => $products) { ?>

        <h2><?php _e('My ' . $class); ?></h2>
        <hr />

        <!-- Packages Grid -->
        <div class="package-grid" style="margin-top: 30px; display: flex; justify-content: space-evenly; align-self: center; flex-wrap: wrap;">

            <?php foreach($products as $id => $cart_info) {

                $product = $repo->findById($id);

                if ( $product->getStatus() == "publish" ) {
                    Utils::includeCustom(plugin_dir_path( __FILE__ ) . 'partials/entity-card.php', array(
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

<?php get_footer(); ?>