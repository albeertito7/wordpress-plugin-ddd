(function ($) {
    'use strict';

    /**
     * All the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(function () {

        $(".btn-add-to-cart").click(function () {

            let article = $(this).closest("article"),
                article_id = article.attr("data-id-product"),
                article_class = article.attr("data-class-product");

            $.ajax({
                url: ajaxurl,
                //dataType: "json",
                type: "post",
                data: {
                    action: "entities_cart_controller",
                    type: "addProduct",
                    id: article_id,
                    class: article_class
                }
            }).done(function (response) {
                console.log("add cart done");
                refreshCartIcon(response);
            }).fail(function (response) {
                console.log("add cart fail");
            }).always(function (response) {
                console.log("add cart always");
            });
        });

        function refreshCartIcon(size)
        {
            console.log("refreshCartIcon");

            $(".entities_cart_num").html(size);

        }

        $(".contact_feedback").click(function () {
            // Show form
        });

        $("form#contact_feedback").submit(function () {

        });

        console.log("JS Public Domain Loaded");
    });

})(jQuery);
