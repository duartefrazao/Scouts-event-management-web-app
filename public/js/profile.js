let editProfile = document.querySelector(".profile-edit .account-manage");
let fieldset = document.querySelector(".profile-information");
let actionButtons = document.querySelector("#profile-page .profile-form-btns");
let profileUpdate = document.querySelector("#profile-page .profile-update-btn");
let undoAction = document.querySelector("#profile-page #undo-action");
let form= document.querySelector("#profile-page > form");

let activeProfileEdit = false;

editProfile.addEventListener("click", function () {
    
    removeNotificationErrors();
    activeProfileEdit = true;
    enableEditable();
});

undoAction.addEventListener("click", function() {

    if(!activeProfileEdit)
        return;
    else{

        editProfile.style.display = "block";
        actionButtons.style.display ="none";
        removeFields();
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
        $("#profile-page .profile-alert").remove();
        $('#profile-page').append("<div class='alert alert-success alert-dismissable profile-alert'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> A tua informação foi atualizada!</div>");
        activeProfileEdit = false;

        if(cropppedImg!=null){
            var input = $("<input class='input_hidden'>")
            .attr("name", "cropped").val(cropppedImg);
         
             $('.form_image').append(input);

        }

        form.submit();

        fieldset.setAttribute('disabled', 'disabled');

    }
});


$('#profile-page #undo-action').alert('close');

function enableEditable() {
    fieldset.removeAttribute('disabled');

    editProfile.style.display = "none";

    actionButtons.style.display = "block";

    addFields();

}


function addFields() {
    const form = document.querySelector("form fieldset");
    const divs = document.querySelectorAll("form fieldset div");
    let lastInput = divs[divs.length ];

    const inners = [
        '<label>Palavra passe antiga</label> <input name="old_password" type="password" class="form-control">',
        '<label>Palavra passe nova</label><input name="new_password" type="password" class="form-control" >',
        '<label>Confirmar palavra passe nova</label><input name="new_password_confirmation" type="password" class="form-control" >'
    ]

    inners.forEach(function (inner) {
        let node = document.createElement("div");
        node.className = "form-group profile-form-group profile-password-fields";

        node.innerHTML = inner;
        form.insertBefore(node, lastInput);
    });

    activePassBtn = true;

}

function removeFields() {
    const fieldset = document.querySelector("fieldset");
    const divs = document.querySelectorAll("form .profile-password-fields");


    divs.forEach(function (element) {
        fieldset.removeChild(element);
    })



    activePassBtn = false;
}

function removeNotificationErrors(){
    let errors = document.querySelector(".notification");
    if(errors != null){
        errors.parentElement.removeChild(errors);
    }
}