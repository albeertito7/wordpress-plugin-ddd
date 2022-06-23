<?php
$type = "create";
$id = "";
$copyid="";
$url = "";
$date_created = "";
$status = "";
$name = "";
$short_description = "";
$description = "";
$featured_image = "";
//$gallery_images = "";
$observations="";
$price = "";
$order = "";

if(isset($_GET["id"]))
{
    // Update/Edit package if 'id' exists
    $id = $_GET["id"];
    $package = EntitiesController::getPackageById($id);

    $type = "update";

    $name = $package->getName();
    $date_created = $package->getDateCreated();
    $date_modified = $package->getDateModified();
    $status = $package->getStatus();
    $short_description = $package->getShortDescription();
    $description = $package->getDescription();
    $price = $package->getPrice();
    $featured_image = $package->getFeaturedImage();
    $order = $package->getOrder();
    //$gallery_images = $package->getGalleryImages();
    //$observations = $package->getObservations();
}
else if(isset($_GET["copyid"]))
{
    // copiar paquete
    $id = $_GET["copyid"];
    $package = EntitiesController::getPackageById($id);

    $name = $package->getName();
    $date_created = $package->getDateCreated();
    $date_modified = $package->getDateModified();
    $status = $package->getStatus();
    $short_description = $package->getShortDescription();
    $description = $package->getDescription();
    $price = $package->getPrice();
    $featured_image = $package->getFeaturedImage();
    $order = $package->getOrder();
    //$gallery_images = $package->getGalleryImages();
    //$observations = $package->getObservations();
}

?>

<script type="application/javascript">

    (function ($) {

        function inicializarCargadorImagenes() {
            /*Imagen Destacada*/
            $('.upload_image_button').click(function( event ){
                event.preventDefault();
                openFrameMedia(false, "linkImage");
            });

            /*Gallery Images*/
            $('.upload_image_gallery').click(function( event ){
                event.preventDefault();
                openFrameMedia(true, "gallery");
            });
        }

        function openFrameMedia(multiple, modeInsercio) {
            //Uploading files
            var file_frame;

            // If the media frame already exists, reopen it.
            if ( file_frame ) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: $( this ).data( 'uploader_title' ),
                button: {
                    text: $( this ).data( 'uploader_button_text' ),
                },
                multiple: (multiple) ? 'add' : false // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                var attachments, attachment;
                if(multiple) {
                    attachments = file_frame.state().get('selection').map(
                        function(attachment) {
                            attachment.toJSON();
                            return attachment;
                        }
                    );
                } else {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();
                }

                if(modeInsercio === "linkImage") {
                    // Do something with attachment.id and/or attachment.url here
                    $('#travelImage').val(attachment.url); //attach id to hidden input
                    $('#travelImage').trigger("change");
                    $('#uploaderImage .image-travel').remove(); //remove any previous preview images
                    $('#uploaderImage').prepend('<img class="image-travel" src="' + attachment.url + '" style="max-width: 200px;">'); //show preview image
                    $(".upload_image_button").hide();
                    $(".remove_imagen_destacada").show();

                }  else if(modeInsercio === "gallery") {
                    var imagesId = [];
                    for(var i=0; i<attachments.length; i++) {
                        var image = {id: attachments[i].attributes.id, url: attachments[i].attributes.url};
                        imagesId.push(image);
                        var classImage = "image-travel-" + attachments[i].attributes.id;
                        $('#' + classImage).remove();
                        var divHtml = '<div id="' + classImage + '" style="float: left;padding: 10px;position:relative;">';
                        divHtml += '<img class=' + classImage + ' src="' + attachments[i].attributes.url + '" style="max-width: 150px;"/>';
                        divHtml += '<a href="#" data-idimage="' + attachments[i].attributes.id + '" id="remove_image_gallery" title="Borrar Imagen" class="remove_image_gallery">';
                        divHtml += '<i class="fa fa-times-circle" aria-hidden="true" style="font-size: 20px;position: absolute;top: 0px;right: -3px;color: black;"></i></a>';
                        divHtml += '</div>';
                        $('#uploadImagesGallery').prepend(divHtml); //show preview image
                    }
                    $("#travelGalleryImages").val(JSON.stringify(imagesId));
                    $('#travelGalleryImages').trigger("change");
                }

                initRemoveImages(modeInsercio);
            });

            // Finally, open the modal
            file_frame.open();
        }

        function loadImages(imagen_destacada/*, imagenes*/) {
            if(imagen_destacada !== "") {
                $('#travelImage').val(imagen_destacada); //attach id to hidden input
                $('#travelImage').trigger("change");
                $('#uploaderImage .image-travel').remove(); //remove any previous preview images
                $('#uploaderImage').prepend('<img class="image-travel" src="' + imagen_destacada + '" style="max-width: 200px;">'); //show preview image
                $(".upload_image_button").hide();
                $(".remove_imagen_destacada").show();
                initRemoveImages("linkImage");
            }

            /*if(imagenes !== "") {
                var imagesId = JSON.parse(imagenes)
                for(var i=0; i<imagesId.length; i++) {
                    var classImage = "image-travel-" + imagesId[i].id;
                    $('#' + classImage).remove();
                    var divHtml = '<div id="' + classImage + '" style="float: left;padding: 10px;position:relative;">';
                    divHtml += '<img class=' + classImage + ' src="' + imagesId[i].url + '" style="max-width: 150px;"/>';
                    divHtml += '<a href="#" data-idimage="' + imagesId[i].id + '" id="remove_image_gallery" title="Borrar Imagen" class="remove_image_gallery">';
                    divHtml += '<i class="fa fa-times-circle" aria-hidden="true" style="font-size: 20px;position: absolute;top: 0px;right: -3px;color: black;"></i></a>';
                    divHtml += '</div>';
                    $('#uploadImagesGallery').prepend(divHtml); //show preview image
                }
                $("#travelGalleryImages").val(JSON.stringify(imagesId));
                $('#travelGalleryImages').trigger("change");
                initRemoveImages("gallery");
            }*/
        }

        function initRemoveImages(modeInsercio) {
            if(modeInsercio === "linkImage") {
                $('.remove_imagen_destacada').click(function( event ){
                    event.preventDefault();
                    $('#travelImage').val(0);
                    $('#travelImage').trigger("change");
                    $('#uploaderImage .image-travel').remove();
                    $(".upload_image_button").show();
                    $(".remove_imagen_destacada").hide();
                });

            } else if(modeInsercio === "gallery") {
                $('.remove_image_gallery').click(function (event) {
                    event.preventDefault();
                    var idImageInGallery = $(this).data('idimage');
                    var classImage = "#image-travel-" + idImageInGallery;
                    var jsonImages = JSON.parse($("#travelGalleryImages").val());

                    for (var i = 0; i < jsonImages.length; i++) {
                        if (jsonImages[i].id === idImageInGallery) {
                            jsonImages.splice(i, 1);
                        }
                    }

                    $('#travelGalleryImages').val(JSON.stringify(jsonImages));
                    $('#travelGalleryImages').trigger("change");
                    $('#uploadImagesGallery ' + classImage).remove();
                });
            }
        }

        $(document).ready(function () {

            inicializarCargadorImagenes();
            loadImages("<?php echo $featured_image; ?>");

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
                        id: <?php echo $id; ?>,
                         <?php } ?>
                        status: $("[name='status']").val(),
                        name: $("[name='name'").val(),
                        short_description: $("[name='short_description']").val(),
                        description: $("[name='description']").val(),
                        featured_image: $("[name='imagendestacada']").val(),
                        observations: $("[name='observations']").val(),
                        price: $("[name='price']").val(),
                        order: $("[name='order']").val()
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
                .fail(function (response) {
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
                                console.log("ajax deletePackage done");
                                location.href = "admin.php?page=packages";
                            }).fail(function (response) {
                                console.log("ajax deletePackage fail");
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


</style>

<div class="wrap travel-management">

    <h1 class="wp-heading-inline">Añadir Paquete</h1>

    <form id="create_package" name="create_package" method="post" action="admin.php">

        <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-2">

                <div id="post-body-content" style="position: relative;">

                    <!-- Title -->
                    <div id="titlediv">
                        <label>
                            <input type="text" name="name" size="30" value="<?php echo $name; ?>" id="title" spellcheck="true" autocomplete="off" placeholder="Añadir el nombre">
                        </label>
                    </div>

                    <!-- Short description -->
                    <div>
                        <h3>Descripción corta</h3>
                        <label>
                            <input type="text" name="short_description" id="short_description" value="<?php echo $short_description; ?>" autocomplete="off"/>
                        </label>
                    </div>

                    <!-- Price -->
                    <div>
                        <h3>Price (€)</h3>
                        <label>
                            <input type="number" name="price" id="price" value="<?php echo $price; ?>" autocomplete="off"/>
                        </label>
                    </div>

                    <!-- Order -->
                    <div>
                        <h3>Order</h3>
                        <label>
                            <input type="number" name="order" id="order" value="<?php echo $order; ?>" autocomplete="off"/>
                        </label>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3>Descripción detallada</h3>
                        <label>
                            <?php echo wp_editor( stripslashes($description), 'description' ); ?>
                        </label>
                    </div>

                    <!-- Featured image -->
                    <div>
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
                    <div>
                        <h3>Observaciones</h3>
                        <label>
                            <?php echo wp_editor( $observations, 'observations' ); ?>
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
                                    <span><?php echo $date_created; ?></span>
                                </div>

                                <!-- Fecha de modificación -->
                                <div style="padding: 5px 10px; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Fecha modificación:</span>
                                    <span><?php echo $date_modified; ?></span>
                                </div>

                                <!-- Status -->
                                <div style="padding: 10px; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Estado: </span>
                                    <label>
                                        <select name="status">
                                            <option value="draft" <?php echo ($status == "draft") ? "selected" : ""; ?>>Draft</option>
                                            <option value="publish" <?php echo ($status == "publish") ? "selected" : ""; ?>>Publish</option>
                                            <option value="pending" <?php echo ($status == "pending") ? "selected" : ""; ?>>Pending</option>
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
