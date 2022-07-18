<?php

// control vars
$type = "create";
$id = "";
$copyid = "";

$package = new Package();
$packageRepository = PackageRepository::getInstance();

if ( isset( $_GET['id'] ) ) {

    $id = $_GET["id"];
    $type = "update";
    $package = $packageRepository->findById($id);
}
else if ( isset( $_GET['copyid'] ) ) {

    $id = $_GET["copyid"];
    $type = "create";
    $package = $package = $packageRepository->findById($id);
}

?>

<script type="application/javascript">

    (function ($) {

        $(document).ready(function () {

            utils.inicializarCargadorImagenes();
            utils.loadImages("<?php echo $package->getFeaturedImage(); ?>");

            $("form#create_package").submit(function (event) {
                event.preventDefault();
                debugger;
                let ajaxRequest = {
                    url: my_vars.ajaxurl,
                    type: "post",
                    dataType: "json",
                    data: {
                        action: "entities_controller",
                        <?php if ($type == "create") { ?>
                        type: "createPackage",
                        <?php } elseif ($type == 'update') { ?>
                        type: "updatePackage",
                        id: <?php echo $package->getId(); ?>,
                        <?php } ?>
                        status: $("[name='status']").val(),
                        name: $("[name='name'").val(),
                        short_description: $("[name='short_description']").val(),
                        description: $("[name='description']").val(),
                        featured_image: $("[name='imagendestacada']").val(),
                        observations: $("[name='observations']").val(),
                        price: $("[name='price']").val(),
                        custom_order: $("[name='order']").val()
                    }
                };

                $.ajax(ajaxRequest)
                    .done(function (response) {
                        if(response.success) {
                            swal.fire({
                                icon: 'success',
                                showConfirmButton: true,
                                html: '<h4>Package <?php echo ($type == "update") ? "updated" : "created"; ?></h4>'
                            }).then((result) => {
                                if(result.isConfirmed && "<?php echo $type; ?>" === "create") {
                                    location.href = "admin.php?page=packages";
                                }
                            });
                        }
                    })
                    .error(function (response) {
                    })
                    .always(function (response) {
                    });
            });

            <?php if($type == "update") { ?>
            $("#delete-action").click(function () {

                swal.fire({
                    icon: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    html: '<h4>Are you sure?</h4>',
                    confirmButtonText: 'Yes, I am sure',
                    cancelButtonText: "No, cancel it!"
                }).then((result) => {
                    if(result.isConfirmed) {

                        //openLoading("<h4>Deleting...</h4>");

                        $.post({
                            url: my_vars.ajaxurl,
                            type: "post",
                            data: {
                                action: "entities_controller",
                                type: "deletePackage",
                                id: <?php echo $id; ?>
                            }
                        }).done(function (response) {
                            location.href = "admin.php?page=packages";
                        }).error(function (response) {
                        }).always(function (response) {
                            //closeLoading();
                            console.log("ajax deletePackage always");
                        });
                    }
                });
            });
            <?php } ?>

        });

    }(jQuery.noConflict()));

</script>

<style>

    .block-field {
        margin-bottom: 40px;
    }

</style>

<div class="wrap travel-management">

    <h1 class="wp-heading-inline">Añadir Paquete</h1>

    <form id="create_package" name="create_package" method="post" action="admin.php">

        <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-2">

                <div id="post-body-content" style="position: relative;">

                    <!-- Title -->
                    <div id="titlediv" class="block-field">
                        <label>
                            <input type="text" name="name" size="30" value="<?php echo $package->getName(); ?>" id="title" spellcheck="true" autocomplete="off" placeholder="Añadir el nombre">
                        </label>
                    </div>

                    <!-- Short description -->
                    <div class="block-field">
                        <h3>Descripción corta</h3>
                        <label>
                            <input type="text" name="short_description" id="short_description" value="<?php echo $package->getShortDescription(); ?>" autocomplete="off"/>
                        </label>
                    </div>

                    <!-- Price -->
                    <div class="block-field">
                        <h3>Price (€)</h3>
                        <label>
                            <input type="number" name="price" id="price" value="<?php echo $package->getPrice(); ?>" autocomplete="off"/>
                        </label>
                    </div>

                    <!-- Order -->
                    <div class="block-field">
                        <h3>Order</h3>
                        <label>
                            <input type="number" name="order" id="order" value="<?php echo $package->getCustomOrder(); ?>" autocomplete="off"/>
                        </label>
                    </div>

                    <!-- Description -->
                    <div class="block-field">
                        <h3>Descripción detallada</h3>
                        <label>
                            <?php echo wp_editor( stripslashes( $package->getDescription() ), 'description' ); ?>
                        </label>
                    </div>

                    <!-- Featured image -->
                    <div class="block-field">
                        <h3>Imagen destacada</h3>
                        <div id="imagen-destacada">
                            <div id="uploaderImage">
                                <label>
                                    <input type="hidden" name="imagendestacada" id="travelImage" data-bind="value:imagendestacada" />
                                </label>
                            </div>
                            <div class="divImagenDestacada">
                                <a href="#" class="upload_image_button">Añadir Imagen Destacada</a>
                                <a href="#" class="remove_imagen_destacada" style="display: none;">Borrar Imagen Destacada</a>
                            </div>
                        </div>
                    </div>

                    <!-- Considerations -->
                    <div class="block-field">
                        <h3>Observaciones</h3>
                        <label>
                            <?php echo wp_editor( $package->getObservations(), 'observations' ); ?>
                        </label>
                    </div>

                </div><!-- /post-body-content -->

                <div id="postbox-container-1" class="postbox-container">

                    <div id="side-sortables" class="meta-box-sortables ui-sortable" style="">

                        <div id="submitdiv" class="postbox">

                            <div class="postbox-header">
                                <h2 class="handle ui-sortable-handle">Guardar</h2>
                            </div>

                            <div class="inside">

                                <!-- Fecha de creación -->
                                <div style="padding: 10px 10px 5px; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Fecha creación:</span>
                                    <span><?php echo $package->getDateCreated(); ?></span>
                                </div>

                                <!-- Fecha de modificación -->
                                <div style="padding: 5px 10px; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Fecha modificación:</span>
                                    <span><?php echo $package->getDateModified(); ?></span>
                                </div>

                                <!-- Status -->
                                <div style="padding: 10px; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Estado: </span>
                                    <label>
                                        <select name="status">
                                            <option value="draft" <?php echo ($package->getStatus() == "draft") ? "selected" : ""; ?>>Draft</option>
                                            <option value="publish" <?php echo ($package-> getStatus() == "publish") ? "selected" : ""; ?>>Publish</option>
                                            <option value="pending" <?php echo ($package->getStatus() == "pending") ? "selected" : ""; ?>>Pending</option>
                                        </select>
                                    </label>
                                </div>

                                <div id="major-publishing-actions">

                                    <?php if ($type == "update") { ?>
                                        <div id="delete-action" style="display: inline-block; float: none !important;">
                                            <a class="submitdelete deletion" href="#" style="color: red;">Eliminar</a>
                                        </div>
                                    <?php } ?>

                                    <div id="publishing-action" style="float: none !important; display: inline-flex; justify-self: right;">

                                        <?php if($type == "update"): ?>
                                            <!--<input type="button" name="custom-duplicate" id="custom-duplicate" class="button button-primary" value="Duplicar">-->
                                            <input type="submit" name="custom-update" id="custom-update" class="button button-primary" value="Actualizar">
                                        <?php else: ?>
                                            <input type="submit" name="custom-publish" id="custom-publish" class="button button-primary" value="Guardar">
                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- /post-body -->

            <br class="clear">

        </div><!-- /poststuff -->

    </form>

</div>
