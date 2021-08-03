const disc = document.getElementsByClassName("diskon");
const cks = document.getElementsByClassName("cks");
const harga = document.getElementsByClassName("harga");
const hasil = document.getElementsByClassName("harga-hasil");
const checks = document.getElementsByClassName("chckall");
const form_discount = document.getElementById("form-add-discount");
const data_body = document.getElementById("data-body");

window.onload = function () {
    checkSlugs();

    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if (month < 10) month = "0" + month.toString();
    if (day < 10) day = "0" + day.toString();

    var maxDate = year + "-" + month + "-" + day;
    $("#start_date").attr("min", maxDate);
    $("#end_date").attr("min", maxDate);
};

const checkall = document.getElementById("checkall");
checkall.addEventListener("change", function () {
    if (this.checked === true) {
        $(".chckall").prop("checked", true);
        for (let y = 0; y < disc.length; y++) {
            disc[y].removeAttribute("disabled");
        }
    } else {
        $(".chckall").prop("checked", false);
        for (let y = 0; y < disc.length; y++) {
            disc[y].setAttribute("disabled", true);
        }
    }
});

function checkSlugs() {
    let names = document.getElementById("event_name");
    names.addEventListener("blur", function () {
        if (names.value != "") {
            $.ajax({
                url: config.routes.slugs,
                type: "POST",
                data: {
                    _token: config.data._token,
                    event_name: names.value,
                },
                success: function (data) {
                    document.getElementById("slugs").value = data.slugs;
                },
            });
        }
    });
}

form_discount.addEventListener("submit", function (e) {
    e.preventDefault();
    const _url_add = config.routes.store;
    const spinner = document.getElementById("spins");
    const btnAdd = document.getElementById("add-discount");
    let formData = new FormData(this);
    $.ajax({
        url: _url_add,
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            spinner.classList.remove("d-none");
            spinner.classList.add("d-inline-block");
            btnAdd.setAttribute("disabled", true);
        },
        success: function (resp) {
            const newline = "\r\n";
            spinner.classList.remove("d-inline-block");
            spinner.classList.add("d-none");
            btnAdd.removeAttribute("disabled", false);
            if (resp.status === 200) {
                var cnfrm = confirm(
                    `Success: ${resp.status} - ${resp.message}${newline}apakah ingin menambahkan discount lagi?`
                );
                if (cnfrm === true) {
                    form_discount.reset();
                    data_body.innerHTML = "";
                    $("#result").html();
                } else {
                    window.location.href = config.routes.index;
                }
            } else {
                $.each(resp.error, function (key, value) {
                    if (key == "products") {
                        $("#" + key + "_alert").alert("show");
                        $("#msg").html(value);
                        document
                            .getElementById("products_alert")
                            .classList.add("show");
                    } else {
                        $("#" + key + "_error").text(value);
                    }
                });
                alert(`Error: ${resp.status} `);
            }
        },
    });
});

const search = document.getElementById("search");
search.addEventListener("keyup", function () {
    if (this.value !== "") {
        $.ajax({
            url: config.routes.search,
            method: "POST",
            data: {
                _token: config.data._token,
                search: this.value,
            },
            success: function (resp) {
                $("#result").html(resp);
            },
        });
    } else {
        document.getElementById("result").innerHTML = "";
    }
});

function addtotbl(x) {
    document.getElementById("search").value = "";
    document.getElementById("result").innerHTML = "";
    var s = x.getAttribute("data-id");
    var t = x.getAttribute("data-nama");
    var u = x.getAttribute("data-sku");
    var v = x.getAttribute("data-harga");

    data_body.innerHTML += `
        <tr>
            <td>
                <input type="checkbox" checked value="${s}" name="products[]"  class="cks"/>
            </td>
            <td>${u}</td>
            <td>${t}</td>
            <td width="15%">${v}</td>
            <td width="10%">
                <input type="number" data-harga="${v}" class="form-control diskon" name="diskon[]">
            </td>
            <td width="20%">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                    </div>
                    <input type="number" class="form-control harga-hasil" value="0" readonly>
                </div>
            </td>
        </tr>
    `;

    for (let x = 0; x < disc.length; x++) {
        disc[x].addEventListener("blur", function () {
            var s = this.dataset.harga;
            var d = (this.value / 100) * this.dataset.harga;
            var a = this.dataset.harga - d;
            if (this.value == "") {
                hasil[x].value = 0;
            } else if (this.value == 0) {
                hasil[x].value = 0;
            } else {
                hasil[x].value = a;
            }
        });
    }

    for (let y = 0; y < cks.length; y++) {
        cks[y].addEventListener("change", function () {
            if (this.checked === false) {
                var td = this.parentElement;
                var tr = td.parentElement;
                tr.remove();
            }
        });
    }
}
