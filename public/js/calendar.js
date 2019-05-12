let meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
let meses_redux = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
let month_name = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
let day_name = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
let calendar = document.querySelector('#calendar');
let original_calendar = null;

let current_month = document.querySelector('.month-name');
let current_year = document.querySelector('.year');

let next_month = document.querySelector('.next-month');
let previous_month = document.querySelector('.previous-month');

next_month.addEventListener('click', function () {
    changeMonth(true)
});
previous_month.addEventListener('click', function () {
    changeMonth(false)
});


window.onload = function () {
    calcDate(null, null);
}

function changeMonth(forward) {

    let month_number = meses_redux.indexOf(current_month.textContent);

    let n_month = month_number;

    let n_year = parseInt(current_year.textContent);

    n_month = forward === true ? n_month + 1 : n_month - 1;

    if (n_month < 0) {
        n_month = 11;
        n_year--;
    } else if (n_month > 11) {
        n_month = 0;
        n_year++;
    }
    resetCalendar();
    calcDate(n_year, n_month);
}


function calcDate(start_year, start_month) {

    let now = new Date();
    let d = null;
    if (start_year == null && start_month == null)
        d = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    else
        d = new Date(start_year, start_month);

    let month = d.getMonth();
    let year = d.getFullYear();
    let curr_day = d.getDate();
    let first_date = month_name[month] + " " + 1 + " " + year;

    let tmp = new Date(first_date).toDateString();

    let first_day = tmp.substring(0, 3); //Mon

    let day_no = day_name.indexOf(first_day); //1
    let days = new Date(year, month + 1, 0).getDate();

    current_month.textContent = meses_redux[month];
    current_year.textContent = "" + year;

    setFirstDay(day_no, days);
    if (start_year == null && start_month == null)
        highlightCurrentDay(curr_day);

    let firstDay = new Date(year, month, 1);
    let lastDay = new Date(year, month + 1, 0);

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

function resetCalendar() {
    let days = calendar.querySelectorAll('.day');

    days.forEach(day => {
        day.classList.add('text-muted');
        day.querySelector('h6 span').textContent = 0;
        if (day.querySelector('h6').classList.contains('current-day')) {
            day.querySelector('h6').classList.remove('current-day');
        }
        day.querySelector('h6').setAttribute('data-id', 0);
    });


    $('.calendar-event').remove();
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

        if (index == 6) {

            //  updateDay(day.nextElementSibling, ++i);
            index = 0;
            week = week.nextElementSibling;
            day = week.firstElementChild;
        } else {
            index++;
            day = day.nextElementSibling;
        }

        i++;
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