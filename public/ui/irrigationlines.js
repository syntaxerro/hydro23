let configuredIrrigationLines = false;
fetch(location.href.replace('/ui', '/index.php/irrigation-lines'))
    .then((response) => response.json())
    .then(function(json) {
        const defaultClassNames = 'btn btn-bubble irrigation-line-valve-button';

        let irrigationLines = document.querySelector('.irrigation-lines');
        let i=0;
        for (let line of json) {
            let style='';
            if (i++ > 0) {
                style='style="margin-left: 1em"';
            }
            let lineButton = '<a '+style+' data-state="disabled" class="'+defaultClassNames+'" data-id="' + line.identifier + '">' + line.name + '</a>';
            irrigationLines.innerHTML += lineButton;
            fetch(location.href.replace('/ui', '/index.php/irrigation-lines/'+line.identifier))
                .then((response) => response.json())
                .then(function(state) {
                    changeValveStatusOnDisplay(line.identifier, state)
                });
        }
        renderIrrigationLinesConfigurationTable(json);
        configuredIrrigationLines = true;
    });

function renderIrrigationLinesConfigurationTable(json) {
    let tbody = document.querySelector('.lines-configurator table tbody');
    for (let line of json) {
        let idInput = '<input class="irrigation-line-id" value="'+line.identifier+'" readonly/>';
        let nameInput = '<input class="irrigation-line-name" value="'+line.name+'"/>';
        let saveButton = '<button class="button-85 save-irrigation-line-button">Zapisz</button>'
        let deleteButton = '<button class="button-85 delete-irrigation-line-button" style="background: red">Usuń</button>'
        tbody.innerHTML += '<tr><td>'+idInput+'</td><td>'+nameInput+'</td><td>'+saveButton+deleteButton+'</td></tr>';
    }
}

document.querySelector('.add-irrigation-line-button').onclick = function() {
    let tbody = document.querySelector('.lines-configurator table tbody');
    let idInput = '<input class="irrigation-line-id"/>';
    let nameInput = '<input class="irrigation-line-name"/>';
    let saveButton = '<button class="button-85 save-irrigation-line-button">Zapisz</button>'
    tbody.innerHTML += '<tr><td>'+idInput+'</td><td>'+nameInput+'</td><td>'+saveButton+'</td></tr>';
};

document.querySelector('.lines-configurator')
    .addEventListener('click', event => {
        if (event.target && event.target.className && event.target.className.match(/delete-irrigation-line-button/)) {
            let row = event.target.parentNode.parentNode;
            let id = row.querySelector('.irrigation-line-id').value;
            sendToWebsocket({
               'command': 'IrrigationLine\\RemoveIrrigationLineCommand',
               'arguments': {
                   'identifier': id
               }
            });
        }
    });

document.querySelector('.lines-configurator')
    .addEventListener('click', event => {
        if (event.target && event.target.className && event.target.className.match(/save-irrigation-line-button/)) {
            let row = event.target.parentNode.parentNode;
            let id = row.querySelector('.irrigation-line-id').value;
            let name = row.querySelector('.irrigation-line-name').value;
            sendToWebsocket({
                'command': 'IrrigationLine\\SetIrrigationLineCommand',
                'arguments': {
                    'identifier': id,
                    'name': name
                }
            });
        }
    });