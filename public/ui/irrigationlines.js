fetch(location.href.replace('/ui', '/index.php/irrigation-lines'))
    .then((response) => response.json())
    .then(function(json) {
        let irrigationLines = document.querySelector('.irrigation-lines');
        for (let line of json) {
            let lineButton = '<a href="#" class="btn btn-bubble irrigation-line-valve-button" data-id="' + line.identifier + '">' + line.name + '</a>';
            irrigationLines.innerHTML += lineButton;
        }
    });