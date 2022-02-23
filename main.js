jQuery('.mean-menu').meanmenu({
    meanScreenWidth: "991"
});

function confirmDelete() {
    var agree=confirm("Weet je zeker dat je dit item wilt verwijderen?");
    if (agree)
     return true ;
    else{ return false ;}
}

function imgClick() {
    document.querySelector('#productimg').click();
}

function displayImage(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector("#productDisplay").setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function imgClickEdit() {
    document.querySelector('#productimgedit').click();
}

function displayImageEdit(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector("#productDisplayEdit").setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

