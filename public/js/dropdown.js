function closeAllDropdownsExcept(id){
    // only closes header-dropdowns
    const x = document.getElementsByName("header-dropdown");
    for (let i=0; i<x.length; i++)
    {
        if (x[i].classList.contains("is-active") && id && (i != id-1)){
            x[i].classList.remove("is-active");
        }
    }
}

function drawDropdown(id){
    const button = document.getElementById("header-dropdown-button"+id);
    button.classList.toggle("is-active");
    closeAllDropdownsExcept(id)


}

// listener
document.body.addEventListener('click', function(){
    closeAllDropdownsExcept(2);
}, true);