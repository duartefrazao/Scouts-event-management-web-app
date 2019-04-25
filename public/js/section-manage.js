let arrows = document.querySelectorAll('.promote-arrow');

arrows.forEach(arrow => {
    arrow.addEventListener('click', function (e) {
        e.preventDefault();
        activateArrow(arrow);
    })
});


function activateArrow(arrow) {
    arrow.classList.add('active');
}


let accept_incoming = document.querySelector('#chief-section-manage  .btn-success');
let reset_request = document.querySelector('#chief-section-manage  .btn-danger');

accept_incoming.addEventListener('click', function () {

    let green_arrows = document.querySelectorAll('#chief-section-manage li .promote-arrow.active');

    let parent = document.querySelector('#chief-section-manage ul');
    green_arrows.forEach(arrow => {

        let li = arrow.parentNode.parentNode;
        li.classList.add('animate-section-transition');
        setTimeout(function () {
            li.style.display = "none";
            parent.removeChild(li);

        }, 500);
    });

    if (green_arrows.length == 0) {
        $("body .alert-pending-user").remove();
        $('body').append("<div class='alert alert-info alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tem de selecionar elementos para os aceitar!</div>");
    } else {

        $("body .alert-pending-user").remove();
        $('body').append("<div class='alert alert-success alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Os novos membros foram aceites para o grupo!</div>");

    }

});

reset_request.addEventListener('click', function () {

    let green_arrows = document.querySelectorAll('#chief-section-manage li .promote-arrow.active');

    green_arrows.forEach(arrow => {
        arrow.classList.remove('active')
    });


    $("body .alert-pending-user").remove();
    $('body').append("<div class='alert alert-primary alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> As escolhas foram revertidas! </div>");

})