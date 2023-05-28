fetch(location.href.replace('/ui', '/index.php/schedule'))
    .then((response) => response.json())
    .then(function(json) {
        renderSchedulerConfiguationTable(json);
        configuredIrrigationLines = true;
    });

function renderSchedulerConfiguationTable(json) {
    let tbody = document.querySelector('.scheduler table tbody');
    for (let schedule of json) {
        let idInput = '<input class="schedule-id" value="'+schedule.id+'" type="hidden"/>';
        let irrigationLineIdInput = '<input class="schedule-irrigation-line" value="'+schedule.irrigationLineIdentifier+'"/>';
        let startAtInput = '<input class="schedule-start-at" value="'+schedule.startAt+'"/>';
        let dayOfWeekInput = '<input class="schedule-day-of-week" value="'+schedule.dayOfWeek+'"/>';
        let irrigationTimeInput = '<input class="schedule-irrigation-time" value="'+schedule.irrigationTime+'"/>';
        let saveButton = '<button class="button-85 save-schedule-button">Zapisz</button>'
        let deleteButton = '<button class="button-85 delete-schedule-button" style="background: red">Usuń</button>'
        tbody.innerHTML += '<tr><td>'+idInput+irrigationLineIdInput+'</td><td>'+startAtInput+'</td><td>'+dayOfWeekInput+'</td><td>'+irrigationTimeInput+'</td><td>'+saveButton+deleteButton+'</td></tr>';
    }
}

document.querySelector('.add-schedule-button').onclick = function() {
    let tbody = document.querySelector('.scheduler table tbody');
    let idInput = '<input class="schedule-id" type="hidden"/>';
    let irrigationLineIdInput = '<input class="schedule-irrigation-line"/>';
    let startAtInput = '<input class="schedule-start-at"/>';
    let dayOfWeekInput = '<input class="schedule-day-of-week"/>';
    let irrigationTimeInput = '<input class="schedule-irrigation-time"/>';
    let saveButton = '<button class="button-85 save-schedule-button">Zapisz</button>'
    let deleteButton = '<button class="button-85 delete-schedule-button" style="background: red">Usuń</button>'
    tbody.innerHTML += '<tr><td>'+idInput+irrigationLineIdInput+'</td><td>'+startAtInput+'</td><td>'+dayOfWeekInput+'</td><td>'+irrigationTimeInput+'</td><td>'+saveButton+deleteButton+'</td></tr>';
};

document.querySelector('.scheduler')
    .addEventListener('click', event => {
        if (event.target && event.target.className && event.target.className.match(/delete-schedule-button/)) {
            let row = event.target.parentNode.parentNode;
            let id = row.querySelector('.schedule-id').value;
            if (id) {
                fetch(location.href.replace('/ui', '/index.php/schedule')+id, { method: 'DELETE' })
                    .then(() => row.remove());
                return;
            }

            row.remove();
        }
    });

document.querySelector('.scheduler')
    .addEventListener('click', event => {
        if (event.target && event.target.className && event.target.className.match(/save-schedule-button/)) {
            let row = event.target.parentNode.parentNode;
            let id = row.querySelector('.schedule-id').value;
            let requestBody = {
                irrigationLineIdentifier: row.querySelector('.schedule-irrigation-line').value,
                startAt: row.querySelector('.schedule-start-at').value,
                dayOfWeek: row.querySelector('.schedule-day-of-week').value,
                irrigationTime: row.querySelector('.schedule-irrigation-time').value,
            };

            let url = location.href.replace('/ui', '/index.php/schedule');
            let method = 'PUT';
            if (id) {
                url += id;
                method = 'POST';
            }
            fetch(url, {
                method: method, // or 'PUT'
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(requestBody),
            }).then(function(response) {
                response.json().then(function(obj) {
                    row.querySelector('.schedule-id').value = obj.id;
                });
            });
        }
    });