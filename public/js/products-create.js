const btnRes = document.getElementById("reset_sku");
const sku = document.getElementById("sku");

window.onload = function () {
    sku.value = randNum();
    checkDuplicate();
    collections();
    checkSlugs();
    resetSku();
};

Quill.register("modules/imageCompressor", imageCompressor);

var toolbarOptions = [
    ["bold", "italic", "underline", "strike"], // toggled buttons
    ["blockquote", "code-block"],
    ["link", "image"],
    [{ header: 1 }, { header: 2 }], // custom button values
    [{ list: "ordered" }, { list: "bullet" }],
    [{ script: "sub" }, { script: "super" }], // superscript/subscript
    [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
    [{ size: ["small", false, "large", "huge"] }], // custom dropdown
    [{ header: [1, 2, 3, 4, 5, 6, false] }],
    [{ color: [] }, { background: [] }], // dropdown with defaults from theme
    [{ font: [] }],
    [{ align: [] }],
    ["clean"], // remove formatting button
];

var options = {
    placeholder: "Masukan deskripsi kamu",
    theme: "snow",
    modules: {
        toolbar: toolbarOptions,
        imageCompressor: {
            quality: 0.9,
            maxWidth: 500, // default
            maxHeight: 500, // default
            imageType: "image/jpeg",
        },
    },
};
var quill = new Quill("#body", options);
const formAdd = document.getElementById("form-add-product");

$("#form-add-product").submit(function (e) {
    e.preventDefault();
    var html_quill = quill.root.innerHTML;
    $("#deskripsi").text(html_quill);

    let formData = new FormData(this);

    const url_submit = config.routes.store;
    const spinner = document.getElementById("spins");
    const btnAdd = document.getElementById("add-product");
    $.ajax({
        url: url_submit,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            spinner.classList.remove("d-none");
            spinner.classList.add("d-inline-block");
            btnAdd.setAttribute("disabled", true);
        },
        success: function (data) {
            const newline = "\r\n";
            spinner.classList.remove("d-inline-block");
            spinner.classList.add("d-none");
            btnAdd.setAttribute("disabled", false);
            if (data.status === 200) {
                var cnfrm = confirm(
                    `Success: ${data.status} - ${data.message}${newline}apakah ingin menambahkan produk lagi?`
                );
                if (cnfrm === true) {
                    document.getElementById("form-add-product").reset();
                    $("#body").summernote("code", "");
                } else {
                    window.location.href = config.routes.index;
                }
            } else {
                $.each(data.validation, function (key, value) {
                    $("." + key + "-error").text(value);
                });
                alert(`Error: ${data.status}`);
            }
        },
    });
});

function randNum() {
    return Math.floor(100000 + Math.random() * 900000);
}

function resetSku() {
    btnRes.addEventListener("click", function () {
        sku.value = randNum();
    });
}

function checkDuplicate() {
    $.ajax({
        url: config.routes.checks,
        type: "POST",
        data: {
            _token: config.data._token,
            sku: sku.value,
        },
        success: function (resp) {
            if (resp.msg === "duplicate") {
                document.getElementById("name-error").innerHTML =
                    "sku sudah ada";
                btnRes.disabled = false;
            } else {
                btnRes.disabled = true;
            }
        },
    });
}

function collections() {
    $.ajax({
        url: config.routes.collections,
        type: "GET",
        dataType: "json",
        success: function (resp) {
            if (resp.collections.length === 0) {
                console.log("data tidak ditemukan");
            } else {
                const colDrop = document.getElementById("collections");
                for (var i = 0; i < resp.collections.length; i++) {
                    colDrop.innerHTML += `<option value="${resp.collections[i].id}"> ${resp.collections[i].name} </option>`;
                }
            }
        },
    });
}

btnRes.addEventListener("click", (e) => {
    e.preventDefault();
    sku.value = randNum();
    checkDuplicate();
});

function checkSlugs() {
    let names = document.getElementById("nama");
    names.addEventListener("blur", function () {
        if (names.value != "") {
            $.ajax({
                url: config.routes.slugs,
                type: "POST",
                data: {
                    _token: config.data._token,
                    nama: names.value,
                },
                success: function (data) {
                    document.getElementById("slugs").value = data.slug;
                },
            });
        }
    });
}
