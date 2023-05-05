let menuItems = document.querySelectorAll('.menu_input');
for (let menuItem of menuItems) {
    menuItem.onclick = function() {
        let checkedId = document.querySelector('.menu_input:checked').id.replace('btn', '');
        hideAllUiSections();
        let chosenSection = document.querySelector('.ui-section-'+checkedId);
        chosenSection.className = chosenSection.className.replace(' invisible', '')
    };
}

function hideAllUiSections() {
    let sections = document.querySelectorAll('.ui-section');
    for (let section of sections) {
        if (section.className.match(/invisible/)) {
            continue;
        }
        section.className += ' invisible';
    }
}