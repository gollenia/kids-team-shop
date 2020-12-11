
export default (function() {
	
	var iconElements = document.querySelectorAll(".ctx-icon");

    iconElements.forEach(element => {
        var icon;
        for (var i = 0; i < element.classList.length; i++) {
            if (element.classList[i].substring(0, 9) === "ctx-icon-") {
                icon = element.classList[i].substring(9);

                fetch(`${DOKU_TPL }/assets/dist/img/icons/${icon}.svg`)
                .then(res => res.text())
                .then(data => {
                    const parser = new DOMParser();
                    const svg = parser.parseFromString(data, 'image/svg+xml').querySelector('svg');

                    element.prepend(svg);
                })
                .catch(error => console.error(error))

            }          
        }
    });

})();