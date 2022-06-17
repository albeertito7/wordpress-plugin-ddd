//var $ = jQuery.noConflict();

(function( $ ) {

	/**
	 * All of the code for your admin-facing JavaScript source
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

	$(document).ready(function () {
		debugger;

		/*$.post({
			url: my_vars.ajaxurl,
			type: "post",
			dataType: "json",
			data: {
				action: "entities_controller",
				type: "getPackages"
			}
		}).done(function (response) {
			console.log("ajax getPackages done");
		}).fail(function () {
			console.log("ajax getPackages fail");
		}).always(function () {
			console.log("ajax getPackages always");
		});*/

	});

	$(document).ready(function () {
		//var crudServiceBaseUrl = "https://demos.telerik.com/kendo-ui/service",
			var dataSource = new kendo.data.DataSource({
				transport: {
					read: {
						url: my_vars.ajaxurl,
						dataType: "json",
						type: "post",
						data: {
							action: "entities_controller",
							type: "getPackages"
						}
					},
					/*parameterMap: function (options, operation) {
						if (operation !== "read" && options.models) {
							return { models: kendo.stringify(options.models) };
						}
					}*/
				},
				batch: true,
				pageSize: 20,
				autoSync: true,
				/*schema: {
					model: {

					}
				}*/
			});

		$("#grid").kendoGrid({
			dataSource: dataSource,
			columnMenu: {
				filterable: false
			},
			//height: 680,
			//editable: "incell",
			pageable: true,
			sortable: true,
			navigatable: true,
			resizable: true,
			//reorderable: true,
			//groupable: true,
			//filterable: true,
			dataBound: onDataBound,
			//toolbar: ["excel", "pdf", "search"],
			columns: [{
				field: 'id',
				title: 'ID',
				width: 100
			}, {
				field: 'name',
				title: 'Name',
				width: 100
			},{
				field: 'short_description',
				title: 'Short Description',
				width: 300
			}, {
				field: 'description',
				title: 'Description',
				width: 300
			}]
		});
	});

	function onDataBound(e) {
		// pass
	}

})( jQuery );
