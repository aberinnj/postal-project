function loadVehicle(id) {
    let vehicle = document.getElementById("vehicle_form"+id);
    let pidForm = document.getElementById("form_PackageID");
    let vehicleForm = document.getElementById("form_Vehicle");
    let submitForm = document.getElementById("form_Update");

    pidForm.value = id;
    vehicleForm.value = vehicle.value;
    submitForm.click();

}