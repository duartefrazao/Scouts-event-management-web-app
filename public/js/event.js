let event_page = document.querySelector('.event-page');

let textarea = document.querySelector('.input-description.comment-box');

let confirm_button = document.querySelector(".confirm-presence");
let remove_button = document.querySelector(".deny-presence");
let members = document.querySelectorAll(".member-wrap");
let invite_member_button = document.querySelector("#memberModal #invite-members");
let invite_moderators_button = document.querySelector('#organizerModal #invite-members');
let event_id = document.querySelector('.event-title') != null ? document.querySelector('.event-title').getAttribute('data-id') : null;
let save_members = document.querySelector('#memberModal .save-members');
let dateSelection = document.querySelector('#dateSelection');
let save_organizers = document.querySelector('#organizerModal .save-members');

let addOptionButton = document.querySelector('#add-poll-option');
//Create event add files
let fileInput = document.querySelector(".input-file-hidden");
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


    if (event_page != null) {
        let mapDOM = event_page.querySelector('.map');
        if (mapDOM != null) {
            initializeGMap(41.1780, -8.5980, mapDOM);
            $("#location-map").css("width", "100%");
            $("#map_canvas").css("width", "100%");

            google.maps.event.trigger(map, "resize");
            map.setCenter(myLatlng);
        }
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
            sendAjaxRequest('post', '/search/groups', {name: this.value}, groupsHandler);
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

    if (save_organizers != null) {
        save_organizers.addEventListener('click', function (event) {
            saveNewModerators();
        });
    }

    if (addOptionButton != null) {
        addOptionButton.addEventListener('click', function (event) {

            addNewOptionToPoll();

        });
    }

    if (location_select != null) {
        location_select.addEventListener('input', function (event) {
            console.log(this.value);
            let location_option = document.querySelector("#location option[value='" + this.value + "']");

            let location_id = null;

            if (location_option != null)
                location_id = location_option.dataset.value;
            else
                return;

            console.log(location_id);

            if (location_id == -1) {
                $('#locationModal').modal('show');
            } else {
                document.querySelector('input[name="location"').value = location_id;
            }
        })
    }

    if (fileInput != null) {
        fileInput.addEventListener('change', function (e) {

            let targetDiv = document.querySelector('.file-container .form-group .files');

            while (targetDiv.firstChild) {
                targetDiv.removeChild(targetDiv.firstChild);
            }

            let button = document.querySelector('.input-file-btn');

            let files = e.target.files;

            Array.from(files).forEach(file => {
                let div = document.createElement("div");
                div.innerHTML = truncateFileName(file.name, 20);
                div.classList = "btn btn-outline-secondary file-btn";
                targetDiv.appendChild(div);
            });
        })
    }

}


function saveNewMembers() {

    let addedMembers = Array.from(document.querySelectorAll('#memberModal .added-members .new-member'));

    let addedGroups = Array.from(document.querySelectorAll('#memberModal .added-members .new-group'));

    let container = document.querySelector('.members-name');

    deleteChildren(container);

    addedMembers.forEach(new_member => {

        container.appendChild(createNewMemberInput(new_member));

    });

    addedGroups.forEach(new_group => {

        container.appendChild((createNewGroupInput(new_group)));

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

function saveNewGroups() {
    let addedMembers = Array.from(document.querySelector('#organizerModal .added-members div').children);

    let container = document.querySelector('.organizers-name');


    deleteChildren(container);

    addedMembers.forEach(new_organizer => {
        container.appendChild(createNewOrganizerInput(new_organizer));
    });

    $('#organizerModal').modal('hide');
}

function createNewGroupInput(group) {
    let input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.setAttribute('name', 'group[]');
    input.setAttribute('value', group.getAttribute('data-id'));

    let span = document.createElement('span');
    span.classList.add('invite-name');
    span.textContent = group.textContent;

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


function groupsHandler() {

    let response = JSON.parse(this.responseText);

    let searchResults = document.querySelector('#memberModal .search-results');

    let currentlyAdded = document.querySelectorAll('#memberModal .added-members .new-group');

    if (response.length == 0) {
        deleteChildrenWithClass(searchResults, 'new-group');
    }

    response.forEach(group => {


        let can_add = true;

        Array.from(searchResults.children).forEach(old_group => {


            if (old_group.getAttribute('data-id') == group.id)
                can_add = false;
        });

        if (can_add) {
            Array.from(currentlyAdded).forEach(old_group => {

                if (old_group.getAttribute('data-id') == group.id)
                    can_add = false;
            });
        }
        if (can_add)
            searchResults.appendChild(createGroup(group));
    });
}


function organizersHandler() {
    let response = JSON.parse(this.responseText);

    let searchResults = document.querySelector('#organizerModal .search-results');

    let currentlyAdded = document.querySelector('#organizerModal .added-members div');

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

function createGroup(group) {

    let wrap = document.createElement('div');
    wrap.classList.add('new-group');
    wrap.setAttribute('data-id', group.id);

    let group_info = document.createElement('span');
    let num_parts = document.createElement('span');
    num_parts.classList.add('text-muted', 'num-participants');
    num_parts.textContent = " - grupo com " + group.num_part + "  " + (group.num_part == 1 ? "participante" : "participantes");
    group_info.textContent = group.name;
    group_info.appendChild(num_parts);

    let action = document.createElement('div');
    action.classList.add('action');
    action.innerHTML += '<i class="fal fa-check"></i>';


    wrap.appendChild(group_info);
    wrap.appendChild(action);

    addNewMemberListener(action, wrap, group.id, false);

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


function addNewOptionToPoll() {

    let options = document.querySelector('.options-selection');
    let lastOption = options.children[options.children.length - 1];

    let optionID = 1;

    if (lastOption != null) {
        optionID = parseInt(lastOption.getAttribute('data-id')) + 1;
    }


    options.appendChild(createNewOption(optionID));


    addDateRangePicker(optionID);


}

function createNewOption(id) {

    let option = document.createElement('div');
    option.classList.add('poll-option');
    option.setAttribute('data-id', id);

    let span = document.createElement('span');
    span.classList.add('poll-option-name');
    span.textContent = "Opção :";

    let dateOption = document.createElement('div');
    dateOption.classList.add('date-option');

    let icon = document.createElement('i');
    icon.classList.add('fa', 'fa-calendar');
    let caret = document.createElement('i');
    caret.classList.add('fa', 'fa-caret-down');

    let input = createDateInput();

    dateOption.appendChild(icon);
    dateOption.appendChild(input);
    dateOption.appendChild(caret);

    option.appendChild(span);
    option.appendChild(dateOption);


    return option;
}

function createDateInput() {

    let input = document.createElement('input');
    input.classList.add('date-range-input');
    input.setAttribute('type', 'text');
    input.setAttribute('name', 'poll[]');
    //input.setAttribute('value', '');

    return input;

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
    }
}


function truncateFileName(n, len) {
    let ext = n.substring(n.lastIndexOf(".") + 1, n.length).toLowerCase();
    let filename = n.replace('.' + ext, '');
    if (filename.length <= len) {
        return n;
    }
    filename = filename.substr(0, len) + (n.length > len ? '[...]' : '');
    return filename + '.' + ext;
}

function addDateRangePicker(id) {

    let start = moment();
    let end = moment().add(1, 'day');

    let obj = {id: id};

    function cb(start, end) {
        document.querySelector('.poll-option[data-id="' + this.id + '"] input').value = start.format('DD/MM/YYYY HH:mm') + ' - ' + end.format('DD/MM/YYYY HH:mm');
    }

    let _cb = cb.bind(obj);

    $('.poll-option[data-id="' + id + '"] .date-option').daterangepicker({
        timePicker: true,
        minDate: moment(),
        maxDate: moment().add(2, 'year'),
        startDate: moment(),
        endDate: moment().add(1, 'day'),
        "timePicker24Hour": true,
        "maxSpan": {
            "days": 20
        },
        "locale": {
            "format": "DD/MM/YYYY HH:mm",
            "separator": " - ",
            "applyLabel": "Confirmar",
            "cancelLabel": "Cancelar",
            "fromLabel": "De",
            "toLabel": "Até",
            "weekLabel": "Sem",
            "daysOfWeek": [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sab"
            ],
            "monthNames": [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ]
        },
        opens: 'left'
    }, _cb);

    _cb(start, end);

}

$(function () {

    let startDate = moment().startOf('hour');
    let endDate = moment().startOf('hour').add(32, 'hour');

    function cb(start, end) {
        document.querySelector('#dateSelectionInput').value = start.format('DD/MM/YYYY HH:mm') + ' - ' + end.format('DD/MM/YYYY HH:mm');
        //$('#dateSelectionInput').value = "";
    }

    $('#dateSelection').daterangepicker({
        timePicker: true,
        minDate: moment(),
        maxDate: moment().add(2, 'year'),
        startDate: moment(),
        endDate: moment().add(1, 'day'),
        "timePicker24Hour": true,
        "maxSpan": {
            "days": 20
        },
        "locale": {
            "format": "DD/MM/YYYY HH:mm",
            "separator": " - ",
            "applyLabel": "Confirmar",
            "cancelLabel": "Cancelar",
            "fromLabel": "De",
            "toLabel": "Até",
            "weekLabel": "Sem",
            "daysOfWeek": [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sab"
            ],
            "monthNames": [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ]
        },
        opens: 'left'
    }, cb);

    cb(startDate, endDate);
});

addEventListeners();
