const search = document.getElementById("search");
const cks = document.getElementsByClassName("cks");
const data_body = document.getElementById("data-body");
const disc = document.getElementsByClassName("diskon");

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
