export default function InlineSvg(selector) {

    let selectors = [selector || 'img[src$="svg"]'];

    this.addSelector = function (selector) {
        selectors.push(selector);
    }

    this.replaceImages = function() {
        selectors.forEach((selector) => {
            var svgImages = document.querySelectorAll(selector);
            svgImages.forEach(replaceImgWithSvg);
        });
    }

    function replaceImgWithSvg(img) {

        var attributes = img.attributes;
        var request = new XMLHttpRequest();
        request.open('GET', img.src, true);
        request.onload = function () {

            if(request.status >= 200 && request.status < 400) {
                var parser = new DOMParser(),
                    result = parser.parseFromString(request.responseText, 'text/xml'),
                    svg = result.getElementsByTagName('svg')[0];
                svg.removeAttribute('xmlns');
                svg.removeAttribute('xmlns:a');
                svg.removeAttribute('width');
                svg.removeAttribute('height');
                svg.removeAttribute('x');
                svg.removeAttribute('y');
                svg.removeAttribute('enable-background');
                svg.removeAttribute('xmlns:xlink');
                svg.removeAttribute('xml:space');
                svg.removeAttribute('version');
                [].slice.call(attributes).forEach(function(attribute) {
                    if(attribute.name !== 'src' && attribute.name !== 'alt') {
                        svg.setAttribute(attribute.name, attribute.value);
                    }
                });
                svg.setAttribute('role', 'img');
                img.parentNode.replaceChild(svg, img);
            }

        }
        request.send();
    }
}

