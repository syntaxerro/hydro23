function handleEvent(eventName, event) {
    switch (eventName) {
        case 'App\\Domain\\Event\\ValveStateChangedEvent':
            changeValveStatusOnDisplay(event.identifier, event.state);
            break;
        case 'App\\Domain\\Event\\PumpEnabledEvent':
            changePumpStatusOnDisplay(true);
            break;
        case 'App\\Domain\\Event\\PumpDisabledEvent':
            changePumpStatusOnDisplay(false);
            break;
        case 'App\\Domain\\Event\\IrrigationLinesReconfiguredEvent':
            showInConsole('! Reconfigured irrigation lines: restarting in next 2 seconds... !');
            setTimeout(function() {
                location.reload();
            }, 2000);
    }
}