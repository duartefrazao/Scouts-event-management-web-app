let group_wrap = document.querySelectorAll('.group-wrap');

let membersLists = document.querySelectorAll(".group-container .card-body");
membersLists.forEach(function(member){
    /* loadMembersNames(10, member); */
})

group_wrap.forEach(event => {

    let card = event.querySelector('.card-wrap');
    let modal = $(event).find(".modal");
    

    loadMembers(5, event.querySelector(".moderators-container .member-container"));
    loadMembers(15, event.querySelector(".members-container .member-container"));

    card.addEventListener('click', function (e) {
        e.preventDefault();
        modal.modal();
    });
});



