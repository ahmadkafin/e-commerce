var discountsTB = $("#discounts-data").DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: config.routes.index,
        dataSrc: "discounts",
    },
    order: [[0, "desc"]],
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    columnDefs: [
        {
            searchable: false,
            orderable: true,
            targets: 0,
        },
    ],
    columns: [
        { data: "id" },
        {
            data: "images",
            render: function (data, type, row) {
                if (data == null || data == "" || data == []) {
                    var img = config.data._path;
                    return `
                    <div class="text-center">
                        <img src="${img}/default.png" alt="default" class="img-fluid" width="50">
                    </div>
                    `;
                } else {
                    var img = config.data._path;
                    return `
                    <div class="text-center">
                        <img src="${img}/discounts/${data}" alt="default" class="img-fluid" width="50">
                    </div>`;
                }
            },
        },
        { data: "event_name" },
        { data: "slugs" },
        {
            data: "start_date",
            render: function (data) {
                return moment(data).format("MM-DD-YYYY/HH:mm");
            },
        },
        {
            data: "end_date",
            render: function (data) {
                return moment(data).format("MM-DD-YYYY/HH:mm");
            },
        },
        {
            data: "_isActive",
            render: function (data) {
                if (data == 0) {
                    return "<span class='badge bg-danger'> Discount tidak aktif </span>";
                } else {
                    return "<span class='badge bg-success'> Discount aktif </span>";
                }
            },
        },
        {
            data: "id",
            render: function (data) {
                var _url_edit = config.routes.edit;
                _url_edit = _url_edit.replace(":id", data);
                return `<div id="buttons" class="d-grid gap-2 d-md-block">
                    <a href="${_url_edit}" class="btn btn-info btn-block btn-sm">
                        <i class="fas fa-pencil-alt"></i>&nbsp; Edit
                    </a>
                    <button class="btn btn-warning my-2 btn-block btn-sm" onclick="updatestat(this)" data-id="${data}" type="button">
                        <i class="fas fa-pencil-alt"></i>&nbsp; Ubah status Aktif 
                    </button>
                    <button class="delete-products btn btn-danger my-2 btn-block btn-sm" onclick="deletecollection(this)" data-id="${data}" type="button">
                        <i class="fas fa-trash-alt"></i>&nbsp; Delete
                    </button>
                </div>`;
            },
        },
        {
            data: "created_at",
            visible: false,
        },
    ],
});
discountsTB
    .on("order.dt search.dt", function () {
        discountsTB
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    })
    .draw();
const p = document.getElementById("discounts-data_filter").childNodes;
p[0].classList.add("col-lg-12");
