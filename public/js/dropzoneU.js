var id = [];
var ids = [];
var testID = [];
Dropzone.options.uploadImage = {
    paramName: "file", // The name that will be used to transfer the file
    url: config.routes.postImage,
    uploadMultiple: true,
    maxFilesize: 2, // MB
    init: function () {
        this.on("addedfile", function (file, serverResponse) {});
        this.on("success", function (file, serverResponse) {
            // console.log(serverResponse.status);
            const checks = document.getElementById("checks");
            const noimage = document.getElementById("no-image");
            if (checks.checked == true) {
                noimage.innerHTML = "";
                id.unshift(serverResponse.id);
            } else {
                noimage.innerHTML = "No Images Found";
            }

            for (var x = 0; x < id.length; x++) {
                ids = ids.concat(id[x]);
            }
            for (var z = 0; z < ids.length; z++) {
                if (testID.indexOf(ids[z]) === -1) {
                    testID.push(ids[z]);
                }
            }
            console.log(testID);
        });
        this.on("complete", function (file) {
            if (
                this.getUploadingFiles().length === 0 &&
                this.getQueuedFiles().length === 0
            ) {
                getImage();
            }
        });
    },
    accept: function (file, done) {
        if (file.name == "justinbieber.jpg") {
            done("ehehehehe.");
        } else {
            done();
        }
    },
};

getImage();
function getImage() {
    var urlImages = config.routes.getImage;
    $.ajax({
        url: urlImages,
        type: "GET",
        data: {
            idImage: testID,
        },
        success: function (data) {
            const imgProd = document.getElementById("images_product");
            for (var i = 0; i < data.data.length; i++) {
                //ganti pake testData
                var img = config.data._img;
                img = img.replace(":data", data.data[i].image_name);
                imgProd.innerHTML += `
                        <div class="col-md-3 col-lg-3 col-sm-12 mt-4">
                            <img src="${img}" alt="${data.data[i].image_name}" class="img-fluid"/>
                            <input type="text" name="imageID[]" value="${data.data[i].id}" hidden/>
                        </div>
                `;
            }
        },
    });
}
