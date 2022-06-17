<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       author_uri
 * @since      1.0.0
 *
 * @package    Entities
 * @subpackage Entities/admin/partials
 */

$paquets = json_decode(EntitiesController::getStaticPackages());

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<style>
    #plugin-img {
        width: 100%;

    }
</style>

<div class="wrap">
    <h1>Travel Manager</h1>

    <p>Aquest plugin serveix per ...</p>
    <p>La seva funció es...</p>

    <p>Es basa en les seccions... on es poden configurar... </p>

    <h2>Set your own style</h2>

    <!-- selector theme (meanwhile only one theme, default, the user can customize it) -->

    <div class="custom-container">
        <div style="">

            <form name="" action="" method="post" id="config-post">

                <select id="custom-theme" style="width: 200px;">
                    <option value="default" selected>Default theme</option>
                </select>

                <!-- custom input theme options -->
                <div class="config-options-wrapper" style="margin-top: 25px;">

                    <!-- Option Label -->
                    <div>
                        <label for="card-back-color">Card background color:</label>
                        <input id="card-back-color" type="text">
                    </div>

                    <!-- Option Label -->
                    <div>
                        <label for="card-border-color">Card border color:</label>
                        <input id="card-border-color" type="text">
                    </div>

                    <!-- Option Label -->
                    <div>
                        <label for="text-color">Text color:</label>
                        <input id="text-color" type="text">
                    </div>

                    <!-- Option Label -->
                    <div>
                        <label for="button-back-color">Button background color:</label>
                        <input id="button-back-color" type="text">
                    </div>

                    <!-- Option Label -->
                    <div>
                        <label for="button-text-color">Button text color:</label>
                        <input id="button-text-color" type="text">
                    </div>

                </div>

                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Desa els canvis" />
                </p>

            </form>

        </div>
        <!-- visualizing card with the theme applied -->

        <div style="">
            <?php Utils::includeCustom(plugin_dir_path(dirname(__FILE__ ) ) . '/page-templates/partials/entity-card.php' , array(
                'p' => $paquets[0]
            )) ?>
        </div>
    </div>

    <!--<img id="plugin-img" src="<?php echo plugin_dir_url( dirname(__FILE__)) . '../screenshot.jpg' ?>" style="width: 100%;"/>-->

</div>

<script type="application/javascript">

    (function ($) {

        $(document).ready(function () {

            $("#card-back-color").change(function () {
                $(".entity-card").first().css('background-color', $(this).val());
            });

            $("#card-border-color").change(function () {
                $(".entity-card").first().css('border-color', $(this).val());
            });

            $("#text-color").change(function () {
                $(".entity-card").first().css('color', $(this).val());
            });

            $("#button-back-color").change(function () {
                $(".entity-card > button").first().css('background-color', $(this).val());
            });

            $("#button-text-color").change(function () {
                $(".entity-card > button").first().css('color', $(this).val());
            });

        });

    }(jQuery.noConflict()));


</script>