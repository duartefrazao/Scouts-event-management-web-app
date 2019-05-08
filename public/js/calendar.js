let meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
let month_name = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
let day_name = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

window.onload = function () {
    calcDate(0);
}

let calendar = document.querySelector("#calendar");


function calcDate(month_offset) {
    let now = new Date();
    let d = new Date(now.getFullYear(), (now.getMonth() + month_offset), now.getDate());
    let month = d.getMonth();
    let year = d.getFullYear();
    let curr_day = d.getDate();
    let first_date = month_name[month] + " " + 1 + " " + year;

    let tmp = new Date(first_date).toDateString();

    let first_day = tmp.substring(0, 3); //Mon
    let day_no = day_name.indexOf(first_day); //1
    let days = new Date(year, month + 1, 0).getDate(); //30

    calendar.querySelector('.month-name').textContent = meses[month];

    setFirstDay(day_no, days);

    highlightCurrentDay(curr_day);

    let date = new Date();
    let firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    let lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

    sendAjaxRequest('post', 'events', {
        start_date: firstDay.getTime() / 1000,
        final_date: lastDay.getTime() / 1000
    }, fillEvents);

}

function fillEvents() {

    let response = JSON.parse(this.responseText);

    response.forEach(event => {

        let week = calendar.querySelector('.week[data-id="week-' + (event.weekNo - 1) + '"]');

        let day = week.querySelector('.day[data-id="day-' + (event.dayNo - 1) + '"]');

        addEventBox(day, event);

    })
}


function addEventBox(day, event) {

    let event_desktop_div = document.createElement('a');

    event_desktop_div.setAttribute('href', '/events/' + event.event.id);

    event_desktop_div.classList.add('container', 'calendar-event', 'calendar-desktop');


    let event_mobile_div = document.createElement('a');

    event_mobile_div.classList.add('container', 'calendar-event', 'calendar-mobile');

    event_mobile_div.setAttribute('href', '/events/' + event.event.id);

    event_desktop_div.textContent = event.event.title;

    event_mobile_div.textContent = event.event.title.substring(0, 2);


    day.appendChild(event_desktop_div);

    day.appendChild(event_mobile_div);

}

function highlightCurrentDay(day) {
    calendar.querySelector('.day [data-id="' + day + '"]').classList.add('current-day');
}

function setFirstDay(index, days) {

    let firstWeek = calendar.querySelector('[data-id="week-0"]');

    let firstDay = firstWeek.querySelector('[data-id="day-' + index + '"]');

    let week = firstWeek;

    let day = firstDay;

    let i = 0;

    while (i < days) {

        updateDay(day, i);

        if ((index + 1) % 6 == 0) {

            updateDay(day.nextElementSibling, ++i);

            week = week.nextElementSibling;
            day = week.firstElementChild;
        } else {
            day = day.nextElementSibling;
        }

        i++;
        index++;
    }

}

function updateDay(element, day) {

    element.classList.remove("text-muted");
    element.querySelector('h6 span').textContent = day + 1;
    element.querySelector('h6').setAttribute('data-id', day + 1);

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