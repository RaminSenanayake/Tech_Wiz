function viewSignInPassword() {
    var signInPassword = document.getElementById("signInPassword");
    var viewSignInPasswordButton = document.getElementById("viewSignInPasswordButton");

    if (signInPassword.type == "password") {
        signInPassword.type = "text";
        viewSignInPasswordButton.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        signInPassword.type = "password";
        viewSignInPasswordButton.innerHTML = '<i class="bi bi-eye"></i>';
    }
}

function adminLogin() {
    var form = document.adminLoginForm;
    var request = new XMLHttpRequest();
    var f = new FormData(form);
    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "success") {
                window.location = "adminDashboard.php"
            } else {
                alert(request.responseText);
            }
        }
    };
    request.open("POST", "adminSignInProcess.php", true);
    request.send(f);
}

function sidebarCollapse() {
    document.getElementById("sidebarMain").classList.toggle("sidebarCollapse");
    document.getElementById("mainAdminContent").classList.toggle("mainAdminContentExpand");
    document.getElementById("mainAdminContent").classList.toggle("mainAdminContent");
    if (document.getElementById("sidebarHeaderTitle").classList.contains("d-none")) {
        setTimeout(() => {
            document.getElementById("sidebarHeaderTitle").classList.toggle("d-none");
        }, 350);
    } else {
        document.getElementById("sidebarHeaderTitle").classList.toggle("d-none");
    }
    var header = document.querySelectorAll("#headerTitle a");
    for (let index = 0; index < header.length; index++) {
        header[index].classList.toggle("d-lg-none")
    }
}

function selectChange(x) {
    var select = document.querySelector(".selector" + x);
    var otherText = document.querySelector(".other" + x);
    if (select.value == 'Other') {
        otherText.classList.remove('d-none');
        if (x >= 4) {
            var inputs1 = otherText.getElementsByTagName("input");
            for (var y = 0; y < inputs1.length; y++) {
                inputs1[y].value = null;
                inputs1[y].required = true;
            }
        } else {
            otherText.required = true;
        }
    } else {
        if (!otherText.classList.contains('d-none')) {
            otherText.classList.add('d-none')
        }
        if (x >= 4) {
            var inputs2 = otherText.getElementsByTagName("input");
            for (var z = 0; z < inputs2.length; z++) {
                inputs2[z].required = false;
            }
        } else {
            otherText.required = false;
        }
    }
}

function addNewSpec() {
    var layout = document.getElementById("spec0Container");
    var clone = layout.cloneNode(true);
    document.getElementById("addNewSpecContainer").before(clone);
    var specs = document.getElementsByClassName("specContainer");
    clone.id = "spec" + (specs.length - 1) + "Container";
    var input = clone.querySelector("input");
    input.name = input.id = "spec" + (specs.length - 1);
    input.value = null
    var textArea = clone.querySelector("textarea");
    textArea.name = textArea.id = "spec" + (specs.length - 1) + "Text";
    textArea.value = null;
    var deleteBtn = clone.querySelector("button");
    deleteBtn.id = "deleteSpecBtn" + (specs.length - 1);
    document.addProductForm.numOfDescriptions.value = specs.length;
    for (var x = 0; x < specs.length; x++) {
        document.getElementById("deleteSpecBtn" + x).classList.remove("d-none");
    }
}

function deleteSpec(element) {
    var deletingSpec = element.parentNode.parentNode;
    var specs = document.getElementsByClassName("specContainer");
    var input;
    var textArea;
    var deleteBtn;
    for (var x = 0; x < specs.length; x++) {
        if (x > parseInt(deletingSpec.id.slice(4))) {
            input = document.getElementById("spec" + x);
            specs[x].id = "spec" + (x - 1) + "Container";
            input.name = input.id = "spec" + (x - 1);
            textArea = document.getElementById("spec" + x + "Text");
            textArea.name = textArea.id = "spec" + (x - 1) + "Text";
            deleteBtn = document.getElementById("deleteSpecBtn" + x);
            deleteBtn.id = "deleteSpecBtn" + (x - 1);
        }
    }
    deletingSpec.remove();
    document.addProductForm.numOfDescriptions.value = specs.length;
    if (specs.length == 1) {
        document.getElementById("deleteSpecBtn0").classList.add("d-none");
    }
}

function brandSelectChange(selectValue) {
    var r = new XMLHttpRequest();
    var brand = document.getElementById("brand");
    var option;
    r.onreadystatechange = () => {
        if (r.readyState == 4 && r.status == 200) {
            var start = document.getElementById("firstBrandOption");
            var end = document.getElementById("lastBrandOption");
            while (start.nextElementSibling && start.nextElementSibling !== end) {
                start.nextElementSibling.remove();
            }
            var t = JSON.parse(r.responseText);
            for (var x = 0; x < t["value"].length; x++) {
                option = document.createElement("option");
                option.value = t["value"][x];
                option.innerHTML = t["text"][x];
                brand.insertBefore(option, end);
            }
        }
    }
    r.open("GET", "brandSelectChange.php?catId=" + selectValue, true);
    r.send()
}

function modelSelectChange(selectValue) {
    var r = new XMLHttpRequest();
    var model = document.getElementById("model");
    var option;
    r.onreadystatechange = () => {
        if (r.readyState == 4 && r.status == 200) {
            var start = document.getElementById("firstModelOption");
            var end = document.getElementById("lastModelOption");
            while (start.nextElementSibling && start.nextElementSibling !== end) {
                start.nextElementSibling.remove();
            }
            var t = JSON.parse(r.responseText);
            for (var x = 0; x < t["value"].length; x++) {
                option = document.createElement("option");
                option.value = t["value"][x];
                option.innerHTML = t["text"][x];
                model.insertBefore(option, end);
            }
        }
    }
    r.open("GET", "modelSelectChange.php?brandId=" + selectValue, true);
    r.send()
}

var prodImageUploader = document.getElementById("productImgsSelect");
function addProductImgs() {
    prodImageUploader.click();
    prodImageUploader.addEventListener("input", productImageUpload)
}

function productImageUpload() {
    var form = document.addProductForm;
    var mdRadio = form.modelProductRadio;
    var prodImgs = document.getElementsByClassName("productImg");
    if (prodImageUploader.files.length > 4) {
        alert("cannot upload more than 4 files");
        prodImageUploader.value = "";
    } else {
        var productImgContainer;
        var inputs;
        var selects;
        for (var x = 0; x < prodImageUploader.files.length; x++) {
            prodImgs[x].style.backgroundImage = "url(" + URL.createObjectURL(prodImageUploader.files[x]) + ")"
        }
        for (var z = 0; z < prodImageUploader.files.length; z++) {
            productImgContainer = document.getElementById("productImgContainer" + z)
            inputs = productImgContainer.getElementsByTagName("input");
            selects = productImgContainer.getElementsByTagName("select");
            for (var c = 0; c < inputs.length; c++) {
                inputs[c].disabled = false;
            }
            for (var d = 0; d < selects.length; d++) {
                selects[d].disabled = false;
            }
            if (z < mdRadio.value) {
                break;
            }
        }
        if (mdRadio.value == "1") {
            form.numOfProducts.value = mdRadio.value;
        } else {
            form.numOfProducts.value = prodImageUploader.files.length;
        }
    }
}

function radioChange() {
    document.addProductForm.productImgs.disabled = false
    prodImageUploader.value = "";
    var prodImgs = document.getElementsByClassName("productImg");
    var productImgContainer;
    var inputs;
    var selects;
    for (var x = 0; x < 4; x++) {
        prodImgs[x].style.backgroundImage = "url('resources/icons8-upload.gif')";
        productImgContainer = document.getElementById("productImgContainer" + x)
        inputs = productImgContainer.getElementsByTagName("input");
        selects = productImgContainer.getElementsByTagName("select");
        for (var a = 0; a < inputs.length; a++) {
            inputs[a].disabled = true;
        }
        for (var b = 0; b < selects.length; b++) {
            selects[b].selectedIndex = "0";
            selectChange(b + 4);
            selects[b].disabled = true;
        }
    }
}

function addProductFormSubmission() {
    var form = document.addProductForm;
    var r = new XMLHttpRequest();
    var file_count = form.productImgs.files.length;
    if (form.checkValidity()) {
        var f = new FormData();
        f.append("productName", form.productName.value);
        f.append("category", form.category.value);
        f.append("categoryText", form.categoryText.value);
        f.append("brand", form.brand.value);
        f.append("brandText", form.brandText.value);
        f.append("model", form.model.value);
        f.append("modelText", form.modelText.value);
        f.append("shipping", form.shipping.value);
        f.append("numOfProducts", form.numOfProducts.value);
        f.append("numOfDescriptions", form.numOfDescriptions.value);
        for (var z = 0; z < form.numOfDescriptions.value; z++) {
            f.append("spec" + z, document.getElementById("spec" + z).value)
            f.append("spec" + z + "Text", document.getElementById("spec" + z + "Text").value)
        }
        for (var y = 0; y < form.numOfProducts.value; y++) {
            f.append("colorSelect" + y, document.getElementById("colorSelect" + y).value)
            f.append("colourCode" + y, document.getElementById("colourCode" + y).value)
            f.append("colourName" + y, document.getElementById("colourName" + y).value)
            f.append("price" + y, document.getElementById("price" + y).value)
            f.append("qty" + y, document.getElementById("qty" + y).value)
            f.append("disc" + y, document.getElementById("disc" + y).value)
            f.append("conditionSelect" + y, document.getElementById("conditionSelect" + y).value)
        }
        for (var x = 0; x < file_count; x++) {
            f.append("img" + x, form.productImgs.files[x]);
        }
        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "success") {
                    var toastDiv = document.getElementById("productAddedToast");
                    var toast = bootstrap.Toast.getOrCreateInstance(toastDiv);
                    toast.show();
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    alert(t);
                }
            }
        }
        r.open("POST", "addProductProcess.php", true);
        r.send(f);
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Invalid product addition!",
        });
    }
}

function signOut() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "adminLogin.php";
            } else {
                alert(t);
            }
        }
    }
    r.open("POST", "adminSignOut.php", true);
    r.send();
}

function changeUserActiveStatus(x, email) {
    var activeButton = document.getElementById("userActiveBtn" + x);
    var activeId = activeButton.value;
    if (activeId == 1) {
        activeId = 2
    } else {
        activeId = 1;
    }
    var r = new XMLHttpRequest();
    var f = new FormData();
    f.append("activeId", activeId);
    f.append("user_email", email);
    r.onreadystatechange = () => {
        if (r.status == 200 && r.readyState == 4) {
            activeButton.value = activeId;
            if (activeId == 1) {
                activeButton.classList.replace("btn-danger", "btn-success");
                activeButton.innerHTML = "Active";
            } else {
                activeButton.classList.replace("btn-success", "btn-danger");
                activeButton.innerHTML = "Inactive";
            }
        }
    }
    r.open("POST", "changeUserActiveStatus.php", true);
    r.send(f);
}

function prodListChangePage(x) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = () => {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.body.innerHTML = t;
        }
    }
    r.open("GET", "productListing.php?page=" + x, true);
    r.send();
}

function changeProductActiveStatus(x, prodId) {
    var activeButton = document.getElementById("prodActiveBtn" + x);
    var activeId = activeButton.value;
    if (activeId == 1) {
        activeId = 2
    } else {
        activeId = 1;
    }
    var r = new XMLHttpRequest();
    var f = new FormData();
    f.append("activeId", activeId);
    f.append("prodId", prodId);
    r.onreadystatechange = () => {
        if (r.status == 200 && r.readyState == 4) {
            activeButton.value = activeId;
            if (activeId == 1) {
                activeButton.classList.replace("btn-danger", "btn-success");
                activeButton.innerHTML = "In stock";
            } else {
                activeButton.classList.replace("btn-success", "btn-danger");
                activeButton.innerHTML = "Out of stock";
            }
        }
    }
    r.open("POST", "changeProductActiveStatus.php", true);
    r.send(f);
}

function updateProductFormValueCall(prodId) {
    var prodName = document.getElementById("prodName");
    var unitPriceInput = document.getElementById("unitPrice");
    var qtyInput = document.getElementById("qty");
    var discountInput = document.getElementById("discount");
    var product_id = document.getElementById("product_id");
    var submitBtn = document.getElementById("discFormSubmitBtn");
    var r = new XMLHttpRequest();
    r.onreadystatechange = () => {
        if (r.readyState == 4 && r.status == 200) {
            var t = JSON.parse(r.responseText);
            prodName.value = t["productName"];
            unitPriceInput.value = t["price"];
            qtyInput.value = t["qty"];
            discountInput.value = t["discount"];
            product_id.value = prodId;
            submitBtn.disabled = false;
        }
    }
    r.open("GET", "updateProductFormDataCall.php?prodId=" + prodId, true);
    r.send();
}

function updateProduct() {
    var form = document.updateProductForm;
    var r = new XMLHttpRequest();
    var f = new FormData(form);
    r.onreadystatechange = () => {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                var toastDiv = document.getElementById("productUpdatedToast");
                var toast = bootstrap.Toast.getOrCreateInstance(toastDiv);
                toast.show();
                setTimeout(() => {
                    location.reload();
                }, 3000);
            } else {
                alert(t);
            }
        }
    }
    r.open("POST", "updateProductProcess.php", true);
    r.send(f)
}

function changeOrderStatus(orderId, orderStatusId) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = () => {
        if (r.readyState == 4 && r.status == 200) {
            var toastDiv = document.getElementById("orderStatusUpdatedToast");
            var toast = bootstrap.Toast.getOrCreateInstance(toastDiv);
            toast.show();
            setTimeout(() => {
                location.reload();
            }, 3000);
        }
    }
    r.open("GET", "updateOrderStatus.php?orderId=" + orderId.slice(1) + "&orderStatus=" + orderStatusId, true);
    r.send()
}

function reportPrint() {
    var restoreBody = document.body.innerHTML;
    var invoiceTable = document.getElementById("reportTable").innerHTML
    document.body.innerHTML = invoiceTable;
    window.print();
    document.body.innerHTML = restoreBody;
}