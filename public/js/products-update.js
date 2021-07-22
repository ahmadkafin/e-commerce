const isDisc = document.getElementById('_isDiscount');
let path = window.location.pathname.split('/');
let idProduct = path[2];

getData();
function getData() {
    var urlShow = config.routes.show;
    urlShow = urlShow.replace(':id', idProduct);
    $.ajax({
        url: urlShow,
        type: "GET",
        contentType: false,
        processData: false,
        success: function (data) {
            // console.log(data);
            var s = data.produk.ukurans;
            document.getElementById('sku').value = data.produk.sku;
            document.getElementById('nama').value = data.produk.nama;
            document.getElementById('slugs').value = data.produk.slugs;
            document.getElementById('harga').value = data.produk.harga;
            document.getElementById('discount').value = data.produk._discount;
            if (data.produk._isDiscount === 0) {
                isDisc.removeAttribute('checked', false);
                isDisc.value = 0;
            } else {
                isDisc.setAttribute('checked', true);
                isDisc.value = 1
            }
            const uk = document.getElementById('ukuran');
            if (s.size != null) {
                for (var i = 0; i < s.length; i++) {
                    uk.innerHTML += `
                    <div class="col-md-2 col-lg-2 col-sm-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">${s[i].size}</span>
                            </div>
                            <input type="number" class="form-control" name="size[]" placeholder="Discount" value="${s[i].jumlah}">
                        </div>
                    </div>
                    `;
                }
            } else {
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
            }

            const images = document.getElementById('images_product');
            if (data.produk.images.length === 0) {
                images.innerHTML = `
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <p class="text-center" id="no-image"> No images Found </p>
                        <button type="button" id="btns" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_update">Add Image</button>
                    </div>
                `;
            } else {
                console.log(typeof (data.produk.images))
            }
        }
    });
}

isDisc.addEventListener('change', function () {
    if (this.checked == true) {
        this.value = 1
        document.getElementById('discount').removeAttribute('disabled', false);
    } else {
        this.value = 0
        document.getElementById('discount').setAttribute('disabled', true);
    }
})