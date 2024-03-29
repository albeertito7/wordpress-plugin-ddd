const utils_deps = {
    _document: document,
    _jQuery: jQuery.noConflict() || $
};

const utils = (function (_deps) {

    let $ = _deps._jQuery;

    // private methods
    function __()
    {
        return "Silence is golden";
    }

    function inicializarCargadorImagenes()
    {
        /*Imagen Destacada*/
        $('.upload_image_button').click(function ( event ) {
            event.preventDefault();
            openFrameMedia(false, "linkImage");
        });

        /*Gallery Images*/
        $('.upload_image_gallery').click(function ( event ) {
            event.preventDefault();
            openFrameMedia(true, "gallery");
        });
    }

    function openFrameMedia(multiple, modeInsercio)
    {
        //Uploading files
        var file_frame;

        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: $(this).data('uploader_title'),
            button: {
                text: $(this).data('uploader_button_text'),
            },
            multiple: (multiple) ? 'add' : false // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        file_frame.on('select', function () {
            var attachments, attachment;
            if (multiple) {
                attachments = file_frame.state().get('selection').map(
                    function (attachment) {
                        attachment.toJSON();
                        return attachment;
                    }
                );
            } else {
                // We set multiple to false so only get one image from the uploader
                attachment = file_frame.state().get('selection').first().toJSON();
            }

            if (modeInsercio === "linkImage") {
                // Do something with attachment.id and/or attachment.url here
                $('#travelImage').val(attachment.url); //attach id to hidden input
                $('#travelImage').trigger("change");
                $('#uploaderImage .image-travel').remove(); //remove any previous preview images
                $('#uploaderImage').prepend('<img class="image-travel" src="' + attachment.url + '" style="max-width: 200px;">'); //show preview image
                $(".upload_image_button").hide();
                $(".remove_imagen_destacada").show();
            } else if (modeInsercio === "gallery") {
                var imagesId = [];
                for (var i=0; i<attachments.length; i++) {
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

    function loadImages(imagen_destacada/*, imagenes*/)
    {
        if (imagen_destacada !== "") {
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

    function initRemoveImages(modeInsercio)
    {
        if (modeInsercio === "linkImage") {
            $('.remove_imagen_destacada').click(function ( event ) {
                event.preventDefault();
                $('#travelImage').val(0);
                $('#travelImage').trigger("change");
                $('#uploaderImage .image-travel').remove();
                $(".upload_image_button").show();
                $(".remove_imagen_destacada").hide();
            });
        } else if (modeInsercio === "gallery") {
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

    // public methods
    return {
        inicializarCargadorImagenes: inicializarCargadorImagenes,
        openFrameMedia: openFrameMedia,
        loadImages: loadImages,
        initRemoveImages: initRemoveImages
    }
}(utils_deps));