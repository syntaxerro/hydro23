function changePumpStatusOnDisplay(state) {
    let pumpButton = document.querySelector('.pump-button');
    pumpButton.dataset.state = state ? 'enabled' : 'disabled';
    if (state) {
        pumpButton.innerText = 'Zakończ nawadnianie';
        pumpButton.className += ' button-85-animating';
    } else {
        pumpButton.innerText = 'Rozpocznij nawadnianie';
        pumpButton.className = pumpButton.className.replace(' button-85-animating', '')
    }
}

function changeValveStatusOnDisplay(valveIdentifier, state) {
    let valve = document.querySelector('.irrigation-line-valve-button[data-id="'+valveIdentifier+'"]');
    valve.dataset.state = state ? 'enabled' : 'disabled';
    valve.className = valve.className.replace(' btn-bubble-animating', '')
    if(valve.dataset.state === 'enabled') {
        valve.className += ' btn-bubble-active';
        valve.className = valve.className.replace(' btn-bubble', '')
    } else {
        valve.className += ' btn-bubble';
        valve.className = valve.className.replace(' btn-bubble-active', '')
    }
}

function showInConsole(line) {
    let console = document.querySelector('.console');
    console.innerHTML += '<div>'+line+'</div>';
    console.scrollTop = console.scrollHeight;
}

function changeConnectionStatusIcon(statusIcon) {
    document.querySelector('.status-icon').innerHTML = '<i class="' + statusIcon +'"></i>';
}