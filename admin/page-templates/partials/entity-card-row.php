<?php

if ( !isset( $package ) ) {
    return;
}

?>

<!-- Main Entity card styles -->
<style>

    .entity-card > * {
        margin-bottom: 10px;
    }

    .entity-card > *:last-child {
        margin-bottom: 0;
    }

    .card-1 {
        display: flex;
        align-items: center;
        max-width: 600px;
        height: 200px;
        padding: 15px 15px;
        border: 1px solid black;
        border-radius: 10px;
        margin: 40px 20px;
        background: purple;
        /*box-shadow: 0 5px 5px 1px #d0d0d0;*/
    }

    .card-1 img {
        max-width: 100%;
    }

    .card-1 button {
        outline: none;
        border: none;
        border-radius: 5px;
        padding: 8px 30px;
        color: white;
        font-weight: bold;
        font-size: 1em;
        background: black;
        /*margin: 0 auto;*/
        display: block;
    }

    .product-meta {

    }

</style>

<!-- Card -->
<div class="entity-card card-1">

    <!-- Article -->
    <article class="" data-id-product="<?php echo $package->getId(); ?>" itemtype="http://schema.org/Product" style="display: flex; align-items: center;">

        <!-- Image -->
        <div class="product-image">

            <!-- Featured Image: An image of the item. This can be an URL or a fully described ImageObject -->
            <img src="<?php echo $package->getFeaturedImage(); ?>" alt="<?php echo $package->getName(); ?>" onerror="this.onerror=null;this.style.display='none';" style="padding-right: 20px;"/>

        </div>

        <div class="meta-wrapper" style="min-width: 50%; display: flex; flex-direction: column; justify-content: space-between;">

            <!-- Meta data -->
            <div class="product-meta">
                <!-- Name: The name of the item (Text) -->
                <h3 style="margin-bottom: 5px;"><?php echo $package->getName(); ?></h3>

                <!-- Description: A description of the item (Text) -->
                <p><?php echo $package->getShortDescription(); ?></p>
            </div>

            <!-- Shipping -->
            <div class="product-submit" style="align-self: flex-end;">

                <!-- Price -->
                <p style="margin-bottom: 5px; text-align: right;"><?php echo $package->getPrice(); ?>€</p>

                <!-- Action Button -->
                <button class="btn-add-to-cart"><?php _e('Add to cart') ?></button>
            </div>

        </div>

    </article>

</div>
