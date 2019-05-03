let event_page = document.querySelector('.event-page');

let mapDOM = event_page.querySelector('.map');

let confirm_button = document.querySelector(".confirm-presence");
let remove_button = document.querySelector(".deny-presence");
let members = document.querySelectorAll(".member-wrap");
let invite_member_button = document.querySelector("#memberModal #invite-members");
let invite_moderators_button = document.querySelector('#organizerModal #invite-members');
let event_id = document.querySelector('.event-title').getAttribute('data-id');
let save_members = document.querySelector('#memberModal .save-members');
let save_moderators = document.querySelector('#organizerModal .save-members');
let create_event = document.querySelector('#btn-create-event');

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

        let textarea = document.querySelector('.input-description');

        textarea.addEventListener('keydown', autosize);
    }

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


/*    if (create_event != null) {

        create_event.addEventListener('click', function (event) {

            let event_title = document.querySelector('.event-title').value;

            let price = document.querySelector('.input-price').value;

            let description = document.querySelector('.input-description').value;

            let begin_date = document.querySelector('#start_date').value;

            let end_date = document.querySelector('#final_date').value;

            let location_id = location_select.value;

            let members = document.querySelectorAll('input[name="participant[]"]');

            let members_array = [];

            members.forEach(m => {
                members_array.push(m.value);
            });

            console.log(event_title, price, description, begin_date, end_date, location_id, members_array);

            /!*            sendAjaxRequest('post', '/event/create', {
                            title: event_title,
                            price: price,
                            description: description,
                            start_date: begin_date,
                            final_date: end_date,
                            location: location_id,
                            participants: JSON.stringify(members_array)
                        }, handler);*!/

        });
    }*/

    if (location_select != null) {
        location_select.addEventListener('input', function (event) {
            console.log(this.value);

            if (this.value == -1) {
                $('#locationModal').modal('show');
            }
        })
    }

}

function handler() {
    console.log(this.responseText);

}


function saveNewMembers() {

    let addedMembers = Array.from(document.querySelector('#memberModal .added-members div').children);

    let container = document.querySelector('.add-member-container');

    addedMembers.forEach(new_member => {

        container.appendChild(createNewMemberInput(new_member.getAttribute('data-id')));

    });


    $('#memberModal').modal('hide');
}

function createNewMemberInput(id) {
    let input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.setAttribute('name', 'participant[]');
    input.setAttribute('value', id);

    return input;
}


function saveNewModerators() {
    let addedMembers = Array.from(document.querySelector('#organizerModal .added-members div').children);

    let container = document.querySelector('.add-organizer-container');

    addedMembers.forEach(new_organizer => {
        container.appendChild(createNewOrganizerInput(new_organizer.getAttribute('data-id')));
    });

    $('#organizerModal').modal('hide');
}

function createNewOrganizerInput(id) {
    let input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'organizer[]');
    input.setAttribute('value', id);

    return input;
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
    var el = this;
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

        let newComment = document.createElement('div')
        newComment.classList.add('row');
        newComment.classList.add('col-11');

        newComment.innerHTML =
            '<div class="col-12 event-comment "> <span class="comment-author">' + response.name + " | " + response.comment.date + '</span><span class="comment-body">' + response.comment.text + '</span></div>';

        commentSection.insertBefore(newComment, commentSection.childNodes[4]);

        textarea.value = "";
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


addEventListeners();