let event_page = document.querySelector('.event-page');

let mapDOM = event_page.querySelector('.map');


let textarea = document.querySelector('.input-description.comment-box');

let confirm_button = document.querySelector(".confirm-presence");
let remove_button = document.querySelector(".deny-presence");
let members = document.querySelectorAll(".member-wrap");
let invite_member_button = document.querySelector("#memberModal #invite-members");
let invite_moderators_button = document.querySelector('#organizerModal #invite-members');
let event_id = document.querySelector('.event-title').getAttribute('data-id');
let save_members = document.querySelector('#memberModal .save-members');
let save_moderators = document.querySelector('#organizerModal .save-members');

let location_select = document.querySelector('.location-container .custom-select');

function addEventListeners() {

    if (confirm_button != null)
        confirm_button.addEventListener('click', function (event) {
            newConfirmation(true, confirm_button.classList.contains('active'));
        });

    if (remove_button != null)
        remove_button.addEventListener('click', function (event) {
            newConfirmation(false, remove_button.classList.contains('active'));
        });


    if (mapDOM != null) {
        initializeGMap(41.1780, -8.5980, mapDOM);
        $("#location-map").css("width", "100%");
        $("#map_canvas").css("width", "100%");

        google.maps.event.trigger(map, "resize");
        map.setCenter(myLatlng);
    }


    if (textarea != null)
        textarea.addEventListener('keydown', autosize);


    if (members != null) {
        members.forEach(member => {
            if (member.getAttribute('data-id') == user)
                confirm_button.classList.add('active');
        });
    }

    if (invite_member_button != null) {
        invite_member_button.addEventListener('input', function (event) {

            sendAjaxRequest('post', '/search/users', {name: this.value}, usersHandler);

        });
    }

    if (invite_moderators_button != null) {
        invite_moderators_button.addEventListener('input', function (event) {

            sendAjaxRequest('post', '/search/users', {name: this.value}, organizersHandler);

        });
    }

    if (save_members != null) {
        save_members.addEventListener('click', function (event) {
            saveNewMembers();
        });
    }

    if (save_moderators != null) {
        save_moderators.addEventListener('click', function (event) {
            saveNewModerators();
        });
    }

    if (location_select != null) {
        location_select.addEventListener('input', function (event) {
            console.log(this.value);

            if (this.value == -1) {
                $('#locationModal').modal('show');
            }
        })
    }

}


function saveNewMembers() {

    let addedMembers = Array.from(document.querySelector('#memberModal .added-members div').children);

    let container = document.querySelector('.members-name');

    deleteChildren(container);

    addedMembers.forEach(new_member => {

        container.appendChild(createNewMemberInput(new_member));

    });


    $('#memberModal').modal('hide');
}

function createNewMemberInput(participant) {

    let input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.setAttribute('name', 'participant[]');
    input.setAttribute('value', participant.getAttribute('data-id'));

    let span = document.createElement('span');
    span.classList.add('invite-name');
    span.textContent = participant.textContent;

    span.appendChild(input);

    return span;
}


function saveNewModerators() {
    let addedMembers = Array.from(document.querySelector('#organizerModal .added-members div').children);

    let container = document.querySelector('.organizers-name');


    deleteChildren(container);

    addedMembers.forEach(new_organizer => {
        container.appendChild(createNewOrganizerInput(new_organizer));
    });

    $('#organizerModal').modal('hide');
}

function createNewOrganizerInput(organizer) {
    let input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.setAttribute('name', 'organizer[]');
    input.setAttribute('value', organizer.getAttribute('data-id'));

    let span = document.createElement('span');
    span.classList.add('invite-name');
    span.textContent = organizer.textContent;

    span.appendChild(input);

    return span;
}

function deleteChildren(element) {
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
}

function usersHandler() {


    let response = JSON.parse(this.responseText);

    let searchResults = document.querySelector('#memberModal .search-results');

    let currentlyAdded = document.querySelector('#memberModal .added-members div');

    if (response.length == 0) {
        deleteChildren(searchResults);
    }

    response.forEach(user => {

        let can_add = true;

        Array.from(searchResults.children).forEach(old_user => {

            console.log(old_user);

            if (old_user.getAttribute('data-id') == user.id)
                can_add = false;
        });

        if (can_add) {
            Array.from(currentlyAdded.children).forEach(old_user => {

                if (old_user.getAttribute('data-id') == user.id)
                    can_add = false;
            });
        }

        if (can_add)
            searchResults.appendChild(createUser(user, false));
    });
}


function organizersHandler() {
    let response = JSON.parse(this.responseText);

    let searchResults = document.querySelector('#organizerModal .search-results');

    let currentlyAdded = document.querySelector('#organizerModal .added-members div');

    if (response.length == 0) {
        deleteChildren(searchResults);
    }

    response.forEach(user => {

        let can_add = true;

        if (!user.is_responsible) {
            can_add = false;
            console.log('Not responsible!');
        } else {
            Array.from(searchResults.children).forEach(old_user => {

                if (old_user.getAttribute('data-id') == user.id)
                    can_add = false;
            });

            if (can_add) {
                Array.from(currentlyAdded.children).forEach(old_user => {

                    if (old_user.getAttribute('data-id') == user.id)
                        can_add = false;
                });
            }

        }

        if (can_add)
            searchResults.appendChild(createUser(user, true));
    });
}


function createUser(user, is_moderator) {

    let wrap = document.createElement('div');
    wrap.classList.add('new-member');
    wrap.setAttribute('data-id', user.id);
    wrap.textContent = user.name;

    let action = document.createElement('div');
    action.classList.add('action');
    action.innerHTML += '<i class="fal fa-check"></i>';


    wrap.appendChild(action);

    addNewMemberListener(action, wrap, user.id, is_moderator);

    return wrap;

}

function removeNewMemberListener(action, wrap, id) {

    action.querySelector('.fa-times').addEventListener('click', function (event) {
        wrap.parentElement.removeChild(wrap);
    });


}

function addNewMemberListener(action, wrap, id, is_moderator) {

    let elem = '#memberModal';

    if (is_moderator)
        elem = '#organizerModal';


    let addedMembers = document.querySelector(elem + ' .added-members div');

    action.querySelector('.fa-check').addEventListener('click', function (event) {
        wrap.parentElement.removeChild(wrap);
        wrap.childNodes[1].innerHTML = '<i class="fal fa-times"></i>';
        removeNewMemberListener(action, wrap, id);
        addedMembers.appendChild(wrap);
    });

}

function newConfirmation(status, previousSelected) {

    if (previousSelected) return;

    sendAjaxRequest('post', '/api/events/' + event_id + '/presence', {presence: status}, confirmationHandler);

}

function confirmationHandler() {

    console.log(this.responseText);

    let response = JSON.parse(this.responseText);

    //console.log(response);
}


function autosize(e) {

    if (e.keyCode === 13) {
        storeComment();
        return;
    }
    let el = this;
    setTimeout(function () {
        el.style.cssText = 'height:auto; padding:0';
        el.style.cssText = 'box-sizing:content-box';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
    }, 0);
}

function storeComment() {

    if (textarea.value.length === 0) {
        return;
    }

    sendAjaxRequest('post', '/events/' + event_id + '/comments', {text: textarea.value}, commentReceiver);
}


function commentReceiver() {
    if (this.status === 200) {
        let commentSection = document.querySelector('.event-comments');

        let response = JSON.parse(this.responseText);
        console.log(response);
        //TO-DO update comments that might be done simultaneously, neccessary?

        let newComment = createComment(response);

        commentSection.insertBefore(newComment, commentSection.childNodes[4]);

        textarea.value = "";
    }
}

function createComment(response) {

    let newComment = document.createElement('div');
    newComment.classList.add('row', 'comment-wrap');
    newComment.setAttribute('data-id', response.id);

    let deleteButton = document.createElement('button');
    deleteButton.type = "button";
    deleteButton.classList.add('close');
    let icon = document.createElement('span');
    icon.innerHTML = "&times;";
    deleteButton.appendChild(icon);

    let holder = document.createElement('div');
    holder.classList.add('col-12', 'event-comment');

    let commentHeader = document.createElement('div');

    let commentAuthor = document.createElement('span');
    commentAuthor.classList.add('comment-author');
    commentAuthor.setAttribute('data-id', response.participant);
    commentAuthor.textContent = response.name + "|" + response.date;

    let commentBody = document.createElement('span');
    commentBody.classList.add('comment-body');
    commentBody.textContent = response.text;

    commentHeader.appendChild(commentAuthor);

    if (user == response.participant) {

        deleteButton.addEventListener('click', function () {

            sendAjaxRequest('delete', '/api/comments/' + response.id, null, removeComment);

        });

        commentHeader.appendChild(deleteButton);

    }


    holder.appendChild(commentHeader);
    holder.appendChild(commentBody);

    newComment.appendChild(holder);

    return newComment;
}

function removeComment() {
    if (this.status === 200) {

        let response = JSON.parse(this.responseText);

        let commentSection = document.querySelector('.event-comments');

        let comment = document.querySelector('.comment-wrap[data-id="' + response + '"]');

        commentSection.removeChild(comment);

    }
}

/*let input_file_btn = document.querySelector('.input-file-btn');
let input_file_hidden = document.querySelector('.input-file-hidden');
input_file_btn.addEventListener('click', () => input_file_hidden.click());*/


function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}


function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}


window.onload = function (event) {

    console.log(event_id);

    if (event_id != null)
        sendAjaxRequest('get', '/events/' + event_id + '/comments', null, commentsReceiver);
};


function commentsReceiver() {
    if (this.status === 200) {
        let commentSection = document.querySelector('.event-comments');

        let response = JSON.parse(this.responseText);

        response.forEach(comment => {

            let newComment = createComment(comment);

            commentSection.appendChild(newComment);
        });
        us
    }
}


addEventListeners();
