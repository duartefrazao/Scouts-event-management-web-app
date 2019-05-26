let scoutButton = document.querySelector('#Escuteiro');
let wardButton = document.querySelector('#Encarregado');
let simpleForm = document.querySelector('#simple-form');
let doubleForm = document.querySelector('#double-form');


function showDoubleForm() {


    console.log('ya2');

    doubleForm.style.display = "block";
    simpleForm.style.width = "initial"
}

function showSimpleForm() {

    console.log('ya');
 
    doubleForm.style.display = "none";
    simpleForm.style.width = "100%";

}

function addEventListeners() {

    console.log("yo");

    if (scoutButton != null) {

        console.log("yo2");

        console.log(scoutButton);

        scoutButton.addEventListener('click', function () {
            console.log('here');
            showSimpleForm();
        });

    }


    if (wardButton != null) {

        console.log("yo3");

        wardButton.addEventListener('click', function () {
            showDoubleForm();
        })

    }

}


addEventListeners();