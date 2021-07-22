const sku = document.getElementById("sku");
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
    $.ajax({
        url: url_submit,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
        },
    });
});

function randNum() {
    return Math.floor(100000 + Math.random() * 900000);
}
const btnRes = document.getElementById("reset_sku");
window.onload = function () {
    sku.value = randNum();
    checkDuplicate();
};

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
            console.log(resp);
        },
    });
}

btnRes.addEventListener("click", (e) => {
    e.preventDefault();
    sku.value = randNum();
    checkDuplicate();
});
