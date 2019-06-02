let scoutButton = document.querySelector('#Escuteiro');
let wardButton = document.querySelector('#Encarregado');
let simpleForm = document.querySelector('#simple-form');
let doubleForm = document.querySelector('#double-form');
let addImgBtn = document.querySelector('#new-profile-image');

function addFilenames(){
    let filenameLocation = addImgBtn.parent.querySelector("div");
    filenameLocation.innerHTML = filenameLocation.files[0].name;
}

function showDoubleForm() {



    doubleForm.style.display = "block";
    simpleForm.style.width = "initial"
}

function showSimpleForm() {

 
    doubleForm.style.display = "none";
    simpleForm.style.width = "100%";

}

function addEventListeners() {


    if (scoutButton != null) {


        console.log(scoutButton);

        scoutButton.addEventListener('click', function () {
            console.log('here');
            showSimpleForm();
        });

    }


    if (wardButton != null) {


        wardButton.addEventListener('click', function () {
            showDoubleForm();
        })

    }
    if(addImgBtn != null){

        addImgBtn.addEventListener('change',function(){
            addFilenames();
        })
    }
}


addEventListeners();