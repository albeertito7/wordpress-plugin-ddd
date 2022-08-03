<?php
$cart_size = ProductCart::size();
?>

<!-- Cart Absolute Icon -->
<a href="/multisite/cart/"><div class="cart_icon"><i class="fa fa-shopping-cart"></i> <span class="entities_cart_num"><?php echo $cart_size; ?></span></div></a>