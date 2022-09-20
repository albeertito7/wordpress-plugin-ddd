/**
 * Dependencies:
 *  - jQuery
 *  - my_vars
 *  - kendo
 */

(function ( $ ) {

    const statusEntityTypes = [
        { id: 'publish', text: 'publish' },
        { id: 'draft', text: 'draft' },
        { id: 'pending', text: 'pending' }
    ];

    // document.ready
    $(function () {
        debugger;

        function getAvailability()
        {
            return $.ajax({
                url: my_vars.ajaxurl,
                type: "post",
                dataType: "json",
                data: {
                    action: "entities_hotels_controller",
                    type: "getHotels"
                }
            });
        }

        function updateAvailability(data_json)
        {
            return $.ajax({
                url: my_vars.ajaxurl,
                type: "post",
                dataType: "json",
                data: {
                    action: "entities_hotels_controller",
                    type: "updateGridHotel",
                    hotel: JSON.stringify(data_json)
                }
            });
        }

        let dataSource = new kendo.data.DataSource({
            transport: {
                create: () => {
                    location.href = "admin.php?page=add-hotel";
                },
                read: options => {
                    $.when(getAvailability())
                        .done((response) => {
                            options.success(response);
                        })
                        .fail((error) => {
                            options.error(error.jqXHR);
                        })
                        .always(() => {
                        });
                },
                update: options => {
                    $.when(updateAvailability(options.data))
                        .done((response) => {
                            options.success(response);
                        }).fail((jqXHR) => {
                            options.error(jqXHR);
                        }).always(() => {
                        });
                },
                destroy: () => {
                    // pass
                }
            },
            autoSync: true,
            pageSize: 20,
            schema: {
                model: {
                    id: 'id',
                    fields: {
                        id: {
                            type: "number",
                            editable: false
                        },
                        status: {
                            type: "string",
                            editable: true
                        },
                        date_created: {
                            editable: false
                        },
                        date_modified: {
                            editable: false
                        },
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
            pageable: {
                refresh: true,
                info: true,
                pageSizes: [5, 10, 15, 20, "all"],
                messages: {
                    empty: "No hotels",
                    itemsPerPage: "Hotels per page",
                    previous: "Previous",
                    next: "Next",
                    first: "First",
                    last: "Last"
                }
            },
            resizable: true,
            columnMenu: true,
            sortable: true,
            filterable: true,
            reorderable: true,
            editable: "incell",
            dataBound: onDataBound,
            //height: 680,
            columns: [{
                field: 'id',
                title: 'ID'
            }, {
                field: 'status',
                title: 'Status',
                width: 100,
                template: function (dataItem) {
                    return dataItem.status; // as the ID corresponds to the text itself
                    /*for (let i = 0; i < statusEntityTypes.length; i++) {
                        if (statusEntityTypes[i].id === dataItem.status) {
                            return statusEntityTypes[i].text;
                        }
                    }*/
                },
                editor: function (container) {
                    let input = $('<input id="status" name="status">');
                    input.appendTo(container);
                    input.kendoDropDownList({
                        dataSource: statusEntityTypes,
                        dataValueField: "id",
                        dataTextField: "text"
                    });
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
                        let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid($(e.target).closest("tr").attr("data-uid"));
                        location.href = "admin.php?page=add-hotel&id=" + dataItem.id;
                    }
                }, {
                    name: "copy",
                    iconClass: "k-icon k-i-copy",
                    click: function (e) {
                        let dataItem = $("#grid").data("kendoGrid").dataSource.getByUid($(e.target).closest("tr").attr("data-uid"));
                        location.href = "admin.php?page=add-hotel&copyid=" + dataItem.id;
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
                            if (result.isConfirmed) {
                                //openLoading("<h4>Deleting...</h4>");

                                let uid = $(e.target).closest("tr").attr('data-uid');
                                let dataItem = dataSource.getByUid(uid);

                                $.post({
                                    url: my_vars.ajaxurl,
                                    type: "post",
                                    dataType: "json",
                                    data: {
                                        action: "entities_hotels_controller",
                                        type: "deleteHotel",
                                        id: dataItem.id
                                    }
                                }).done((response) => {
                                    console.log("done delete");
                                    grid.dataSource.read();
                                }).fail((error) => {
                                    console.log(error);
                                    console.log("fail delete");
                                }).always(() => {
                                    console.log("always delete");
                                    //closeLoading();
                                });
                            }
                        });
                    }
                }]
            }]
        }).data("kendoGrid");

        function onDataBound(e)
        {
            // fit columns
            grid.autoFitColumn(0);
            //grid.autoFitColumn(1);
            grid.autoFitColumn(2);
            grid.autoFitColumn(3);
            grid.autoFitColumn(4);
            grid.autoFitColumn(7);
            grid.autoFitColumn(8);

            // scrollbar
            toggleScrollbar(e);
        }

        function toggleScrollbar(e)
        {
            let gridWrapper = e.sender.wrapper, gridTable = e.sender.table, gridArea = gridTable.closest(".k-grid-content");
            gridWrapper.toggleClass("no-scrollbar", gridTable[0].offsetHeight < gridArea[0].offsetHeight)
        }

        function openLoading(html)
        {

            let sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

            swal.fire({
                html: html,
                showConfirmButton:false,
                onRender: function () {
                    $('.swal2-content').prepend(sweet_loader);
                }
            });
        }

        function closeLoading()
        {
            swal.close();
        }
    });

})(jQuery, kendo, my_vars);
