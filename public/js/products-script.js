let path = window.location.pathname.split("/");
let idProduct = path[3];
const isDisc = document.getElementById("_isDiscount");
var productsTB = $("#products-data").DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: config.routes.index,
        dataSrc: "products",
    },
    order: [[9, "desc"]],
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
            data: "images[]",
            render: function (data, type, row) {
                if (data == null || data == "" || data == []) {
                    var img = config.data._img;
                    img = img.replace(":data", "default.png");
                    return `<img src="${img}" alt="default" class="img-fluid" width="50">`;
                } else {
                    var img = config.data._img;
                    img = img.replace(
                        ":data",
                        `/products/${row.images[0].image_name}`
                    );
                    return `<img src="${img}" alt="default" class="img-fluid" width="150">`;
                }
            },
        },
        { data: "sku" },
        { data: "nama" },
        {
            data: "warna",
            render: function (data) {
                if (data == null || data == "") {
                    return "<span> belum ada warna </span>";
                } else {
                    return data;
                }
            },
        },
        {
            data: "ukurans[]",
            render: function (data, type, row) {
                var s =
                    data == null ? 0 : data == "" ? 0 : row.ukurans[0].jumlah;
                var m =
                    data == null ? 0 : data == "" ? 0 : row.ukurans[1].jumlah;
                var l =
                    data == null ? 0 : data == "" ? 0 : row.ukurans[2].jumlah;
                var xl =
                    data == null ? 0 : data == "" ? 0 : row.ukurans[3].jumlah;
                var xxl =
                    data == null ? 0 : data == "" ? 0 : row.ukurans[4].jumlah;
                var xxxl =
                    data == null ? 0 : data == "" ? 0 : row.ukurans[5].jumlah;
                return `<button type="button" class="btn btn-primary shwModal" onclick=hs(this) id="sacaa" data-nama="${row.nama}" data-s="${s}" data-m="${m}" data-l="${l}" data-xl="${xl}" data-xxl="${xxl}" data-xxxl="${xxxl}"> 
                            ${row.total}
                        </button>`;
            },
        },
        {
            data: "harga",
            render: $.fn.dataTable.render.number(",", ".", 0, "IDR "),
        },
        { data: "_discount" },
        {
            data: "sku",
            render: function (data) {
                var routeEdit = config.routes.edit;
                routeEdit = routeEdit.replace(":id", data);
                return `<div id="buttons" class="d-grid gap-2 d-md-block"><a href="${routeEdit}" class="btn btn-info btn-block btn-sm" type="button"><i class="fas fa-pencil-alt"></i>&nbsp; Edit</a><button class="delete-artikel btn btn-danger my-2 btn-block btn-sm" onclick="" type="button"><i class="fas fa-trash-alt"></i>&nbsp; Delete</button>`;
            },
        },
        {
            data: "created_at",
            visible: false,
        },
    ],
});
productsTB
    .on("order.dt search.dt", function () {
        productsTB
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    })
    .draw();

const p = document.getElementById("products-data_filter").childNodes;
p[0].classList.add("col-lg-12");

function hs(x) {
    const labelBaju = document.getElementById("labelBaju");
    const dataS = document.getElementById("ukuranS");
    const dataM = document.getElementById("ukuranM");
    const dataL = document.getElementById("ukuranL");
    const dataXL = document.getElementById("ukuranXL");
    const dataXXL = document.getElementById("ukuranXXL");
    const dataXXXL = document.getElementById("ukuranXXXL");

    labelBaju.innerHTML = `List size produk ${x.getAttribute("data-nama")}`;
    dataS.innerHTML = `<p> S : ${x.getAttribute("data-s")}`;
    dataM.innerHTML = `<p> M : ${x.getAttribute("data-m")}`;
    dataL.innerHTML = `<p> L : ${x.getAttribute("data-L")}`;
    dataXL.innerHTML = `<p> XL : ${x.getAttribute("data-XL")}`;
    dataXXL.innerHTML = `<p> 2XL : ${x.getAttribute("data-XXL")}`;
    dataXXXL.innerHTML = `<p> 3XL : ${x.getAttribute("data-XXXL")}`;

    $("#modSize").modal("show");
}
