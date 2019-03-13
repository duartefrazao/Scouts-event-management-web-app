let editProfile = document.querySelector(".profile-edit .account-manage");
let fieldset = document.querySelector(".profile-information");
let actionButtons = document.querySelector("#profile-page .profile-form-btns");
let profileUpdate = document.querySelector("#profile-page .profile-update-btn");
let undoAction = document.querySelector("#profile-page #undo-action");


let activeProfileEdit = false;

editProfile.addEventListener("click", function () {
    activeProfileEdit = true;
    enableEditable();
});

undoAction.addEventListener("click", function() {

    if(!activeProfileEdit)
        return;
    else{
        editProfile.style.display = "block";
        actionButtons.style.display ="none";
        fieldset.setAttribute('disabled', 'disabled');
        $('body .profile-alert').remove();
        $('body').append("<div class='alert alert-primary alert-dismissable profile-alert'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> A tua informação não foi atualizada!</div>");
        activeProfileEdit = false;
    }
});

profileUpdate.addEventListener("click", function(event) {

    event.preventDefault();

    if(!activeProfileEdit)
        return;
    else{
        editProfile.style.display = "block";
        actionButtons.style.display ="none";
        fieldset.setAttribute('disabled', 'disabled');
        $("#profile-page .profile-alert").remove();
        $('#profile-page').append("<div class='alert alert-success alert-dismissable profile-alert'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> A tua informação foi atualizada!</div>");
        activeProfileEdit = false;
    }
});


$('#profile-page #undo-action').alert('close');

function enableEditable() {
    fieldset.removeAttribute('disabled');

    editProfile.style.display = "none";

    actionButtons.style.display = "block";
}


function addFields() {
    const form = document.querySelector("form");
    const divs = document.querySelectorAll("form div");
    let lastInput = divs[divs.length - 1];

    const inners = [
        '<label>Palavra passe antiga</label> <input type="password" class="form-control">',
        '<label>Palavra passe nova</label><input type="password" class="form-control" >',
        '<label>Confirmar palavra passe nova</label><input type="password" class="form-control" > </input>'
    ]

    inners.forEach(function (inner) {
        let node = document.createElement("div");
        node.className = "form-group profile-form-group profile-password-fields";

        node.innerHTML = inner;
        form.insertBefore(node, lastInput);
    });

    activePassBtn = true;

    changePassBtn.classList.remove("btn-warning");
    changePassBtn.classList.add("btn-secondary");
    changePassBtn.innerHTML = "Cancelar";
}

function removeFields() {
    const form = document.querySelector("form");
    const divs = document.querySelectorAll("form .profile-password-fields");

    console.log(divs);
    divs.forEach(function (element) {
        form.removeChild(element);
    })

    changePassBtn.classList.remove("btn-secondary");
    changePassBtn.classList.add("btn-warning");
    changePassBtn.innerHTML = "Mudar palavra passe";

    activePassBtn = false;
}