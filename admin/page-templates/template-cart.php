<?php

// adds the header built upon the theme builder to the page
get_header();

?>

<div id="main-content" style="padding:100px;">

    <h2><?php _e('My Cart'); ?></h2>
    <hr />

</div>

<?php

// adds the content built upon the theme builder to the page
// meaning it will be displayed before any other programmatically adding
the_content();

?>

<?php get_footer(); ?>