const imagesP = document.getElementById("images-product");

getImages();

function getImages() {
    var img_path = config.data._img;
    img_path = img_path.replace(":data", "");
    $.ajax({
        url: config.routes.images,
        type: "GET",
        success: function (data) {
            for (var l = 0; l < data.data.length; l++) {
                imagesP.innerHTML += `
                    <div class="col-md-2 col-lg-2 col-sm-12 mt-4">
                        <label class="cards">
                            <input class="cards__input" type="checkbox" ${
                                data.data[l].uid_products !== null
                                    ? "checked disabled"
                                    : ""
                            } value="${data.data[l].id}"/>
                            <div class="cards__body">
                                <div class="cards__body-cover">
                                    <img class="cards__body-cover-image" src="${img_path}${
                    data.data[l].image_name
                }" />
                                    <span class="cards__body-cover-checkbox">
                                        <svg class="cards__body-cover-checkbox--svg" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg></span></div>
                                <header class="cards__body-header">
                                    <h5 class="cards__body-header-title">${
                                        data.data[l].products === null
                                            ? `Not Assigned`
                                            : data.data[l].products.nama
                                    }</h5>
                                    <p class="cards__body-header-subtitle">${
                                        data.data[l].products === null
                                            ? `Not Assigned`
                                            : data.data[l].products.sku
                                    }</p>
                                </header>
                            </div>
                        </label>
                    </div>
                `;
            }
        },
    });
}
const btnAss = document.getElementById("btn-assign");
const btnSave = document.getElementById("btn-save");

window.addEventListener("load", function () {
    const chks = document.getElementsByClassName("cards__input");
    console.log(chks.length);
    chngestate();
});

function chngestate() {
    var selected = new Array();
    $(".cards__input").each(function () {
        if (!$(this).prop("disabled")) {
            $(this).on("click", function () {
                if (this.checked) {
                    selected.push(this.value);
                } else {
                    selected.pop(this.value);
                }

                if (selected.length >= 1) {
                    btnAss.removeAttribute("disabled");
                } else {
                    btnAss.setAttribute("disabled", true);
                }
            });
        }
    });
    assignUid(selected);
}

function assignUid(id) {
    btnSave.addEventListener("click", function () {
        const uid = document.getElementById("dropdown-products");
        const spinner = document.getElementById("spins");

        $.ajax({
            url: config.routes.edit,
            method: "PATCH",
            data: {
                _token: config.data._token,
                img_id: id,
                uid_products: uid.value,
            },
            beforeSend: function () {
                spinner.classList.remove("d-none");
                spinner.classList.add("d-inline-block");
                $("#btn-save").prop("disabled", true);
            },
            success: function (data) {
                if (data.status === 200) {
                    spinner.classList.remove("d-inline-block");
                    spinner.classList.add("d-none");
                    $("#btn-save").prop("disabled", false);
                    location.reload();
                    alert("Sukses menyematkan gambar produk");
                }
            },
        });
    });
}
