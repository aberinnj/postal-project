function useAddress() {

    var checkbox = document.getElementById("customer_package_form_useDefaultAddress");
    var return_AddressInputs = document.getElementsByClassName("postal_returnAddress");
    if (checkbox.checked) {
        
        console.log()

        document.getElementById("customer_package_form_rStreet").value = document.getElementById("postal-default-street").innerHTML;
        document.getElementById("customer_package_form_rApartmentNo").value = document.getElementById("postal-default-number").innerHTML;
        document.getElementById("customer_package_form_rCity").value = document.getElementById("postal-default-city").innerHTML;
        document.getElementById("customer_package_form_rState").value = document.getElementById("postal-default-state").innerHTML;
        document.getElementById("customer_package_form_rZIP").value = document.getElementById("postal-default-zip").innerHTML;

    } else {

        for (let i=0; i< return_AddressInputs.length; i++) {
            return_AddressInputs[i].value="";
        }
    }
}