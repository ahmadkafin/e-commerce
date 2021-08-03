const isDisc = document.getElementById("_isDiscount");
let path = window.location.pathname.split("/");
let idProduct = path[2];
var img_path = config.data._img;
img_path = img_path.replace(":data", "");
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

getData();
getImages();

function getData() {
    var urlShow = config.routes.show;
    urlShow = urlShow.replace(":id", idProduct);
    $.ajax({
        url: urlShow,
        type: "GET",
        contentType: false,
        processData: false,
        success: function (data) {
            document.getElementById("sku").value = data.produk.sku;
            document.getElementById("nama").value = data.produk.nama;
            document.getElementById("slugs").value = data.produk.slugs;
            document.getElementById("harga").value = data.produk.harga;
            document.getElementById("discount").value = data.produk._discount;

            var quill = new Quill("#body", options);
            quill.root.innerHTML = data.produk.deskripsi;

            if (data.produk._isDiscount === 0) {
                isDisc.removeAttribute("checked", false);
                isDisc.value = 0;
            } else {
                isDisc.setAttribute("checked", true);
                isDisc.value = 1;
            }
            const uk = document.getElementById("ukuran");
            if (data.produk.ukurans.length === 0) {
                let indexs = ["S", "M", "L", "XL", "XXL", "XXXL"];
                for (var i = 0; i < indexs.length; i++) {
                    uk.innerHTML += `
                    <div class="col-md-2 col-lg-2 col-sm-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">${indexs[i]}</span>
                            </div>
                            <input type="number" class="form-control" name="size[]" placeholder="Jumlah">
                        </div>
                    </div>
                    `;
                }
            } else {
                for (var i = 0; i < data.produk.ukurans.length; i++) {
                    uk.innerHTML += `
                    <div class="col-md-2 col-lg-2 col-sm-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">${data.produk.ukurans[i].size}</span>
                            </div>
                            <input type="number" class="form-control" name="size[]" placeholder="Discount" value="${data.produk.ukurans[i].jumlah}">
                        </div>
                    </div>
                    `;
                }
            }

            const images = document.getElementById("images_product");
            if (data.produk.images.length === 0) {
                images.innerHTML = `
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <p class="text-center" id="no-image"> No images Found </p>
                        <button type="button" id="btns" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_update">Add Image</button>
                    </div>
                `;
            } else {
                for (var im = 0; im < data.produk.images.length; im++) {
                    images.innerHTML += `
                    <div class="col-md-3 col-lg-3 col-sm-12 mt-4">
                        <img src="${img_path}${data.produk.images[im].image_name}" class="img-fluid"/>
                    `;
                }
                images.innerHTML += `<button type="button" id="btns" class="btn btn-primary btn-block mt-3" data-toggle="modal" data-target="#modal_update">Update Image / Add Image</button>
                    </div>`;
            }
        },
    });
}

function getImages() {
    $.ajax({
        url: config.routes.images,
        type: "GET",
        success: function (data) {
            const imgFrame = document.getElementById("img_data");
            for (var l = 0; l < data.data.length; l++) {
                if (data.data[l].uid_products == idProduct) {
                    imgFrame.innerHTML += `
                            <div class="col-md-3 col-lg-3 col-sm-12 mt-4">
                                <div class="this-image">
                                    <div class="topleft"><button class="btn btn-sm btn-danger deleteImage" data-id="${data.data[l].id}" type="button"><i class="far fa-times-circle"></i></button></div>
                                    <img src="${img_path}${data.data[l].image_name}" class="img-fluid"/>
                                    <div class="bottomright"><i class="fas fa-check-circle"></i></div>
                                </div>
                            </div>
                        `;
                } else {
                    imgFrame.innerHTML += `
                            <div class="col-md-3 col-lg-3 col-sm-12 mt-4">
                                <img src="${img_path}${data.data[l].image_name}" class="img-fluid"/>
                            </div>
                    `;
                }
            }
        },
    });
}

window.addEventListener("load", () => {
    const delImage = document.getElementsByClassName("deleteImage");
    for (var x = 0; x < delImage.length; x++) {
        delImage[x].addEventListener("click", function (e) {
            var y = this.dataset.id;
            e.preventDefault();
            console.log(y);
        });
    }

    isDisc.addEventListener("change", function () {
        if (this.checked == true) {
            this.value = 1;
            document
                .getElementById("discount")
                .removeAttribute("disabled", false);
        } else {
            this.value = 0;
            document.getElementById("discount").setAttribute("disabled", true);
        }
    });
});
