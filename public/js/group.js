let group_page = document.querySelector('.group-page');

let members = document.querySelectorAll(".member-wrap");
let invite_member_button = document.querySelector("#memberModal #invite-members");
let invite_moderators_button = document.querySelector('#moderatorModal #invite-members');
let group_id = document.querySelector('.group-title') != null ? document.querySelector('.group-title').getAttribute('data-id') : null;
let save_members = document.querySelector('#memberModal .save-members');
let save_moderators = document.querySelector('#moderatorModal .save-members');


function addgroupListeners() {


    if (members != null) {
        members.forEach(member => {
            if (member.getAttribute('data-id') == user)
                confirm_button.classList.add('active');
        });
    }

    if (invite_member_button != null) {
        invite_member_button.addEventListener('input', function (group) {
            sendAjaxRequest('post', '/search/users', {name: this.value}, usersHandler);
        });
    }

    if (invite_moderators_button != null) {
        invite_moderators_button.addEventListener('input', function (group) {
            sendAjaxRequest('post', '/search/users', {name: this.value}, moderatorsHandler);

        });
    }

    if (save_members != null) {
        save_members.addEventListener('click', function (group) {
            saveNewMembers();
        });
    }

    if (save_moderators != null) {
        save_moderators.addEventListener('click', function (group) {
            saveNewModerators();
        });
    }

}


function saveNewMembers() {

    let addedMembers = Array.from(document.querySelectorAll('#memberModal .added-members .new-member'));
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
    input.setAttribute('name', 'member[]');
    input.setAttribute('value', participant.getAttribute('data-id'));

    let span = document.createElement('span');
    span.classList.add('invite-name');
    span.textContent = participant.textContent;

    span.appendChild(input);

    return span;
}


function saveNewModerators() {
    let addedMembers = Array.from(document.querySelector('#moderatorModal .added-members div').children);

    let container = document.querySelector('.moderators-name');


    deleteChildren(container);

    addedMembers.forEach(new_moderator => {
        container.appendChild(createNewModeratorInput(new_moderator));
    });

    $('#moderatorModal').modal('hide');
}

function createNewModeratorInput(moderator) {
    let input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.setAttribute('name', 'moderator[]');
    input.setAttribute('value', moderator.getAttribute('data-id'));

    let span = document.createElement('span');
    span.classList.add('invite-name');
    span.textContent = moderator.textContent;

    span.appendChild(input);

    return span;
}

function deleteChildren(element) {
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
}

function deleteChildrenWithClass(element, class_type) {

    let elements = element.getElementsByClassName(class_type);

    while (elements[0]) {
        elements[0].parentNode.removeChild(elements[0]);
    }

}

function usersHandler() {

    let response = JSON.parse(this.responseText);

    let searchResults = document.querySelector('#memberModal .search-results');

    let currentlyAdded = document.querySelectorAll('#memberModal .added-members .new-member');

    if (response.length == 0) {
        deleteChildrenWithClass(searchResults, 'new-member');
    }

    response.forEach(s_user => {

        let can_add = true;

        if (s_user.id == user)
            can_add = false;

        if (can_add)
            Array.from(searchResults.children).forEach(old_user => {


                if (old_user.getAttribute('data-id') == s_user.id)
                    can_add = false;
            });

        if (can_add) {
            Array.from(currentlyAdded).forEach(old_user => {

                if (old_user.getAttribute('data-id') == s_user.id)
                    can_add = false;
            });
        }

        if (can_add)
            searchResults.appendChild(createUser(s_user, false));
    });
}

function moderatorsHandler() {
    let response = JSON.parse(this.responseText);

    let searchResults = document.querySelector('#moderatorModal .search-results');

    let currentlyAdded = document.querySelector('#moderatorModal .added-members div');

    if (response.length == 0) {
        deleteChildren(searchResults);
    }

    response.forEach(s_user => {

        let can_add = true;

        if (!s_user.is_responsible) {
            can_add = false;
            console.log('Not responsible!');
        } else {

            if (s_user.id == user)
                can_add = false;

            if (can_add)
                Array.from(searchResults.children).forEach(old_user => {

                    if (old_user.getAttribute('data-id') == s_user.id)
                        can_add = false;
                });

            if (can_add) {
                Array.from(currentlyAdded.children).forEach(s_user => {

                    if (old_user.getAttribute('data-id') == user.id)
                        can_add = false;
                });
            }

        }

        if (can_add)
            searchResults.appendChild(createUser(s_user, true));
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

    action.querySelector('.fa-times').addEventListener('click', function (group) {
        wrap.parentElement.removeChild(wrap);
    });


}

function addNewMemberListener(action, wrap, id, is_moderator) {

    let elem = '#memberModal';

    if (is_moderator)
        elem = '#moderatorModal';


    let addedMembers = document.querySelector(elem + ' .added-members div');

    action.querySelector('.fa-check').addEventListener('click', function (group) {
        wrap.parentElement.removeChild(wrap);
        wrap.childNodes[1].innerHTML = '<i class="fal fa-times"></i>';
        removeNewMemberListener(action, wrap, id);
        addedMembers.appendChild(wrap);
    });

}


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


addgroupListeners();
