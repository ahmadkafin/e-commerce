var collectionsTB = $("#collections-data").DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: config.routes.index,
        dataSrc: "collections",
    },
    order: [[6, "desc"]],
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
            data: "image",
            render: function (data, type, row) {
                if (data == null || data == "" || data == []) {
                    var img = config.data._path;
                    return `
                    <div class="text-center">
                        <img src="${img}/default.png" alt="default" class="img-fluid" width="100">
                    </div>
                    `;
                } else {
                    var img = config.data._path;
                    return `
                    <div class="text-center">
                        <img src="${img}/collections/${data}" alt="default" class="img-fluid" width="100">
                    </div>`;
                }
            },
        },
        { data: "name" },
        { data: "slugs" },
        {
            data: "_isActive",
            render: function (data) {
                if (data == 0) {
                    return "<span class='badge bg-danger'> Collection tidak aktif </span>";
                } else {
                    return "<span class='badge bg-success'> Collection aktif </span>";
                }
            },
        },
        {
            data: "id",
            render: function (data) {
                // var routeEdit = config.routes.edit;
                // routeEdit = routeEdit.replace(":id", data);
                return `<div id="buttons" class="d-grid gap-2 d-md-block">
                    <button type="button" onclick="openmodal(this)" class="btn btn-info btn-block btn-sm" data-id="${data}" type="button">
                        <i class="fas fa-pencil-alt"></i>&nbsp; Edit
                    </button>
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
collectionsTB
    .on("order.dt search.dt", function () {
        collectionsTB
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    })
    .draw();

const p = document.getElementById("collections-data_filter").childNodes;
p[0].classList.add("col-lg-12");

const input = document.getElementById("name_collection");
const slugs = document.getElementById("slugs_collection");
input.addEventListener("blur", function () {
    checkDuplicate();
});
function checkDuplicate() {
    $.ajax({
        url: config.routes.check,
        type: "POST",
        data: {
            _token: config.data._token,
            name: input.value,
        },
        success: function (resp) {
            if (resp.msg === "duplicate") {
                document.getElementById("name-error").innerHTML =
                    "nama collection sudah ada";
            } else {
                document.getElementById("name-error").innerHTML = "";
                var inp = input.value;
                inp = inp.replace(" ", "-");
                slugs.value = inp;
            }
        },
    });
}

const form_add = document.getElementById("form-add-collection");
form_add.addEventListener("submit", function (e) {
    e.preventDefault();
    const spinner = document.getElementById("spins");
    let formData = new FormData(form_add);
    $.ajax({
        url: config.routes.store,
        data: formData,
        method: "POST",
        contentType: false,
        processData: false,
        beforeSend: function () {
            spinner.classList.remove("d-none");
            spinner.classList.add("d-inline-block");
            $("#btn-save").prop("disabled", true);
        },
        success: function (resp) {
            if (resp.status === 200) {
                spinner.classList.remove("d-inline-block");
                spinner.classList.add("d-none");
                $("#btn-save").prop("disabled", false);
                collectionsTB.ajax.reload();
                var cnfrm = confirm(
                    "Sukses menambahkan collection, ingin menambahkan lagi?"
                );
                if (cnfrm === true) {
                    form_add.reset();
                }
            }
        },
    });
});

function updatestat(x) {
    var id = x.getAttribute("data-id");
    var _url = config.routes.patch;
    _url = _url.replace(":id", id);
    $.ajax({
        url: _url,
        method: "PATCH",
        data: {
            _token: config.data._token,
        },
        beforeSend: function () {
            x.setAttribute("disabled", true);
        },
        success: function () {
            collectionsTB.ajax.reload();
            x.removeAttribute("disabled", true);
        },
    });
}

function openmodal(x) {
    $("#collection-modal-update").modal("show");
    var _url_show = config.routes.show;
    var id = x.getAttribute("data-id");
    _url_show = _url_show.replace(":id", id);
    $.ajax({
        url: _url_show,
        method: "GET",
        success: function (resp) {
            console.log(resp);
            document.getElementById("id").value = resp.data.id;
            document.getElementById("name_collection_update").value =
                resp.data.name;
            document.getElementById("slugs_collection_update").value =
                resp.data.slugs;
            var _path = config.data._path;
            if (resp.data.image !== null) {
                document.getElementById(
                    "_image"
                ).innerHTML = `<img src="${_path}/collections/${resp.data.image}" class="img-fluid" width="150"/>`;
            } else {
                document.getElementById(
                    "_image"
                ).innerHTML = `<p>Belum ada gambar</p>`;
            }
        },
    });

    const form_update = document.getElementById("form-update-collection");
    form_update.addEventListener("submit", function (e) {
        e.preventDefault();
        var _url_update = config.routes.update;
        _url_update = _url_update.replace(":id", id);
        const spinner2 = document.getElementById("spins2");
        let formDataUpdate = new FormData(form_update);
        $.ajax({
            url: _url_update,
            data: formDataUpdate,
            type: "POST",
            contentType: false,
            processData: false,
            beforeSend: function () {
                spinner2.classList.remove("d-none");
                spinner2.classList.add("d-inline-block");
                $("#btn-save-update").prop("disabled", true);
            },
            success: function (resp) {
                if (resp.status === 200) {
                    spinner2.classList.remove("d-inline-block");
                    spinner2.classList.add("d-none");
                    $("#btn-save-update").prop("disabled", false);
                    collectionsTB.ajax.reload();
                    alert("Berhasil mengupdate collection");
                } else {
                    alert(`error ${resp.msg}`);
                    console.log(resp.msg);
                }
            },
        });
    });
}

function deletecollection(x) {
    let id = x.getAttribute("data-id");
    var _url_delete = config.routes.delete;
    _url_delete = _url_delete.replace(":id", id);
    let confirmDelete = confirm(
        `Apakah data ini akan dihapus? Jika di hapus semua yang berkaitan dengan collection ini akan terhapus`
    );
    if (confirmDelete === true) {
        $.ajax({
            url: _url_delete,
            method: "DELETE",
            success: function (resp) {
                alert("berhasil menghapus collection");
                collectionsTB.ajax.reload();
            },
        });
    }
}
