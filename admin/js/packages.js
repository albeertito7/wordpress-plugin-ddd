(function( $ ) {

    const statusEntityTypes = [
        { id: 'publish', text: 'publish' },
        { id: 'draft', text: 'draft' },
        { id: 'pending', text: 'pending' }
    ];

    $(document).ready(function () {
        debugger;

        function getAvailability() {
            return $.ajax({
                url: my_vars.ajaxurl,
                dataType: "json",
                type: "post",
                data: {
                    action: "entities_controller",
                    type: "getPackages"
                }
            });
        }

        let dataSource = new kendo.data.DataSource({
            transport: {
                read: function (options) {
                    $.when(getAvailability())
                        .done(function (response) {
                            options.success(response);
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            options.error(jqXHR);
                        })
                        .always(function () {
                        });
                },
                create: function (options) {
                    console.log("create");
                    location.href = "admin.php?page=add-package";
                },
                update: function (options) {
                    console.log("update");
                    $.ajax({
                        url: my_vars.ajaxurl,
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: "entities_controller",
                            type: "updateGridPackage",
                            package: kendo.stringify(options.data)
                        },
                        success: function(result) {
                            options.success(result);
                        },
                        error: function(result) {
                            options.error(result);
                        }
                    });
                },
                destroy: function (options) {
                    console.log("destroy");
                }
            },
            sort: { field: "custom_order", dir: "asc" },
            //batch: true,
            pageSize: 20,
            autoSync: true,
            schema: {
                model: {
                    id: 'id',
                    fields: {
                        id: { editable: false },
                        status: { editable: true },
                        date_created: { editable: false },
                        date_modified: { editable: false },
                        price: {
                            type: 'number',
                            editable: true
                        },
                        name: {
                            type: "string",
                            editable: true
                        },
                        short_description: {
                            type: "string",
                            editable: true
                        },
                        custom_order: {
                            type: "number",
                            editable: true
                        },
                    }
                }
            }
        });

        let grid = $("#grid").kendoGrid({
            dataSource: dataSource,
            columnMenu: {
                filterable: true
            },
            //height: 680,
            pageable: {
                refresh: true,
                info: true,
                pageSizes: [5, 10, 15, 20, "all"],
                messages: {
                    empty: "No packages",
                    itemsPerPage: "Packages per page",
                    previous: "Previous",
                    next: "Next",
                    first: "First",
                    last: "Last"
                }
            },
            sortable: true,
            resizable: true,
            /*reorderable: {
                columns: true
            },*/
            editable: "incell",
            //filterable: true,
            dataBound: onDataBound,
            toolbar: ["create", "excel"/*, "pdf"*/],
            pdf: {
                fileName: "PDF_export.pdf",
                allPages: true,
                avoidLinks: true,
                paperSize: "A4",
                margin: { right: "0.4cm", top: "1cm", bottom: "1cm", left: "0.4cm" },
                landscape: true,
                repeatHeaders: true,
                //template: $("#page-template").html(),
                scale: 0.4
            },
            columns: [{
                field: 'id',
                title: 'ID'
            }, {
                field: 'status',
                title: 'Status',
                width: 100,
                template: function(dataItem) {
                    for (var i = 0; i < statusEntityTypes.length; i++) {
                        if (statusEntityTypes[i].id === dataItem.status) {
                            return statusEntityTypes[i].text;
                        }
                    }
                },
                editor: function (container) {
                    var input = $('<input id="status" name="status">');
                    input.appendTo(container);
                    input.kendoDropDownList({
                        dataSource: statusEntityTypes,
                        dataTextField: "text",
                        dataValueField: "id"
                    }).appendTo(container);
                }
            }, {
                field: 'date_created',
                title: 'Date created',
                type: 'date'
            }, {
                field: 'date_modified',
                title: 'Date modified',
                type: 'date'
            }, {
                field: 'price',
                title: 'Price (€)'
            },{
                field: 'name',
                title: 'Name'
            },{
                field: 'short_description',
                title: 'Short Description',
            }, {
                field: 'custom_order',
                title: 'Order'
            }, {
                command: [{
                    name: "edit",
                    click: function (e) {
                        // command button click handler
                        console.log("edit");
                        let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid($(e.target).closest("tr").attr("data-uid"));
                        location.href = "admin.php?page=add-package&id=" + dataItem.id;
                    }
                }, {
                    name: "copy",
                    iconClass: "k-icon k-i-copy",
                    click: function (e) {
                        console.log("copy");
                        let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid($(e.target).closest("tr").attr("data-uid"));
                        location.href = "admin.php?page=add-package&copyid=" + dataItem.id;
                    }
                }, {
                    name: "remove",
                    text: "Delete",
                    iconClass: "k-icon k-i-close",
                    click: function (e) {
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

                                let uid = $(e.target).closest("tr").attr('data-uid');
                                let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid(uid);

                                $.post({
                                    url: my_vars.ajaxurl,
                                    type: "post",
                                    dataType: "json",
                                    data: {
                                        action: "entities_controller",
                                        type: "deletePackage",
                                        id: dataItem.id
                                    }
                                }).done(function (response) {
                                    console.log("ajax deletePackage done");
                                    $("#grid").data("kendoGrid").dataSource.read();
                                }).error(function (response) {
                                    console.log("ajax deletePackage fail");
                                }).always(function (response) {
                                    //closeLoading();
                                    console.log("ajax deletePackage always");
                                });
                            }
                        });
                    }
                }]
            }]
        }).data("kendoGrid");

        function onDataBound(e) {
            // fit columns
            //let grid = $("#grid").data("kendoGrid");
            grid.autoFitColumn(0);
            //grid.autoFitColumn(1);
            grid.autoFitColumn(2);
            grid.autoFitColumn(3);
            grid.autoFitColumn(4);
            grid.autoFitColumn(7);
            grid.autoFitColumn(8);

            // listeners
            addEventListeners();

            // scrollbar
            toggleScrollbar(e);

        };

        function addEventListeners() {

            /*$(".edit-package").click(function () {

                let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid($(this).closest("tr").attr("data-uid"));
                location.href = "admin.php?page=add-package&id=" + dataItem.id;
            });*/

            $(".copy-package").click(function () {
                let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid($(this).closest("tr").attr("data-uid"));
                location.href = "admin.php?page=add-package&copyid=" + dataItem.id;
            });

            $(".delete-package").click(function () {

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

                        let uid = $(this).closest("tr").attr('data-uid');
                        let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid(uid);

                        $.post({
                            url: my_vars.ajaxurl,
                            type: "post",
                            data: {
                                action: "entities_controller",
                                type: "deletePackage",
                                id: dataItem.id
                            }
                        }).done(function (response) {
                            console.log("ajax deletePackage done");
                            $("#grid").data("kendoGrid").dataSource.read();
                        }).fail(function (response) {
                            console.log("ajax deletePackage fail");
                        }).always(function (response) {
                            //closeLoading();
                            console.log("ajax deletePackage always");
                        });
                    }
                });
            });

        }

        function toggleScrollbar(e) {
            let gridWrapper = e.sender.wrapper, gridTable = e.sender.table, gridArea = gridTable.closest(".k-grid-content");
            gridWrapper.toggleClass("no-scrollbar", gridTable[0].offsetHeight < gridArea[0].offsetHeight)
        };

        function openLoading(html) {

            let sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

            swal.fire({
                html: html,
                showConfirmButton:false,
                onRender: function() {
                    $('.swal2-content').prepend(sweet_loader);
                }
            });
        }

        function closeLoading() {
            swal.close();
        }
    });

})( jQuery );
