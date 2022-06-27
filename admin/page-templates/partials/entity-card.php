<?php

if (!isset($package)) {
    return;
}

?>

<!-- Main Entity card styles -->
<style>

    .entity-card > * {
        margin-bottom: 10px;
    }

    .entity-card > *:last-child {
        margin-bottom: 0px;
    }

    .card-1 {
        width: 300px;
        min-height: 300px;
        padding: 20px 15px;
        border: 1px solid black;
        border-radius: 10px;
        margin: 40px 20px;
    }

    .card-1 > img {
        max-width: 100%;
    }

    .card-1 > button {
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

</style>

<!-- Card -->
<div class="entity-card card-1">

    <!--<img src="<?php echo get_home_url(); ?>/wp-content/plugins/entities/admin/../screenshot.jpg" alt="" />-->

    <img src="<?php echo $package->getFeaturedImage(); ?>" alt="" />

    <h3><?php echo $package->getName(); ?></h3>

    <p><?php echo $package->getDescription(); ?></p>

    <p><?php echo $package->getPrice(); ?>€</p>

    <button class="btn-buy-now"><?php _e('BUY NOW') ?></button>

</div>
