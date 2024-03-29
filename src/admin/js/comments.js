/**
 * Dependencies:
 *  - jQuery
 *  - ajaxurl_admin
 *  - kendo
 */

(function ($) {

    // document.ready
    $(function () {
        debugger;

        function getAvailability()
        {
            return $.ajax({
                url: ajaxurl_admin,
                dataType: "json",
                type: "post",
                data: {
                    action: "entities_comments_controller",
                    type: "getComments"
                }
            });
        }

        function updateAvailability(data_json)
        {
            return $.ajax({
                url: ajaxurl_admin,
                type: "POST",
                dataType: "json",
                data: {
                    action: "entities_comments_controller",
                    type: "updateGridComment",
                    hotel: JSON.stringify(data_json)
                }
            });
        }

        let dataSource = new kendo.data.DataSource({
            transport: {
                create: () => {
                    // pass
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
                        date_created: {
                            editable: false
                        },
                        author: {
                            type: "string",
                            editable: false
                        },
                        email: {
                            type: "string",
                            editable: false
                        },
                        phone: {
                            type: "string",
                            editable: false
                        },
                        message: {
                            type: "string",
                            editable: false
                        }
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
                    empty: "No comments",
                    itemsPerPage: "Comments per page",
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
                field: 'date_created',
                title: 'Date created',
                type: 'date'
            }, {
                field: 'author',
                title: 'Author'
            },{
                field: 'email',
                title: 'Email',
            }, {
                field: 'phone',
                title: 'Phone'
            }, {
                field: 'message',
                title: 'Message'
            }, {
                command: [{
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
                                    url: ajaxurl_admin,
                                    type: "post",
                                    data: {
                                        action: "entities_comments_controller",
                                        type: "deleteComment",
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
            grid.autoFitColumn(1);
            grid.autoFitColumn(2);
            grid.autoFitColumn(3);
            grid.autoFitColumn(4);
            //grid.autoFitColumn(5);
            grid.autoFitColumn(6);

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

})(jQuery);
