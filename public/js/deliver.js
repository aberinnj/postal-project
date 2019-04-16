function deliver(packageID, packageState){
    deliver_modal();
    let pid_form = document.getElementById("form_PackageID");
    let state_form = document.getElementById("form_State");
    
    pid_form.value = packageID;
    state_form.value = packageState;
    
}

function submitDelivery(){
    let delivery_form = document.getElementById("form_Ship");
    delivery_form.click();
}

function view(packageID, packageWeight, packageWidth, packageLength, packageHeight) {
    let id = packageID;
    let weight = "Weight: "+packageWeight;
    let width = "Width: "+packageWidth;
    let length = "Length: "+packageLength;
    let height = "Height: "+packageHeight;

    document.getElementById("view-package-id").innerHTML = id;
    document.getElementById("view-package-specifications").innerHTML = "Weight (lbs): " + weight+"<br/>Width (cm): " + width+"<br/>Length (cm): " + length+"<br/>Height (cm): " + height;

    view_modal();
}

function deliver_modal(){
    document.getElementById("shift-deliver-modal").classList.toggle("is-active");
}

function view_modal(){
    document.getElementById("shift-view-modal").classList.toggle("is-active");
}

function modal(){
    document.getElementById("shift-modal").classList.toggle("is-active");
}

document.getElementById("shift-view-modal-bg").addEventListener('click', function(){
    view_modal();
});

document.getElementById("shift-deliver-modal-bg").addEventListener('click', function(){
    deliver_modal();
});

document.getElementById("shift-modal-bg").addEventListener('click', function(){
    modal();
});

function modal2(){
    document.getElementById("shift-modal").classList.toggle("is-active");
    window.location.replace("http://courierpo.aberin-nj.com/employee");
}
