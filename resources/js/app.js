import Menu from './menu';
import smoothscroll from './smoothscroll.min.js';
// import InlineSvg from './inline-svg';
import FloorSelector from './floorselector';

smoothscroll.polyfill();

function App() {
    window.scrollTo(0, 0);

    function addListener(selector, event, callback) {
        var elements = document.querySelectorAll(selector);
        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener(event, callback);
        }
    }

    function generateAutoAnchors() {
        var slugify = require('slugify');
        let containers = document.querySelectorAll('.js-autoanchors');
        containers.forEach((container) => {
            let prefix = ''; 
            if (container.dataset.anchorPrefix) {
                prefix = container.dataset.anchorPrefix + '-';
            }
            let headings = container.querySelectorAll('h1,h2,h3,h4,h5,h6');
            headings.forEach((heading) => {
                let anchor = prefix + slugify(heading.innerText);
                anchor = anchor.toLowerCase();
                heading.id = anchor;
            })
        });
    }

    function onReady() {

        // let inlineSvg = new InlineSvg('img[src$="svg"].inline');
        // inlineSvg.replaceImages();

        // AOS.init({
        //     disable: 'mobile',
        //     // disable: true,
        //     offset: 50,
        //     duration: 1000,
        //     once: true,
        //     easing: 'ease-out-quart',
        // });

        // let scrollable = document.querySelector('.bee-page-scrollable');
        // let scrollable = document;
        // scrollable.addEventListener('scroll', (ev) => {
        //     let header = document.querySelector('header.bee-header');
        //     // if (ev.target.scrollTop > 0) {
        //     if (window.scrollY > 0) {
        //         header.classList.add('compact');
        //     } else {
        //         header.classList.remove('compact');
        //     }
        // });

        // let partnersCarousel = document.querySelector('.bee-partners');
        // if (partnersCarousel) {
        //     let partnersFlickity = new Flickity(partnersCarousel, {
        //         autoPlay: 2000,
        //         wrapAround: true,
        //         prevNextButtons: false,
        //         pageDots: false,
        //         lazyLoad: true,
        //         percentPosition: false,
        //         resize: true,
        //         cellAlign: 'left',
        //     });
        // }
        //


        window.addEventListener('keydown', (ev) => {
            // let activeGalleryPopup = document.querySelector('.bee-gallery-popup.active');
            // if (activeGalleryPopup) {
            //     switch (ev.key) {
            //         case 'ArrowLeft':
            //             showPreviousGallerySlide(activeGalleryPopup);
            //             break;
            //         case 'ArrowRight':
            //             showNextGallerySlide(activeGalleryPopup);
            //             break;
            //         case 'Escape':
            //             activeGalleryPopup.classList.remove('active');
            //             break;
            //     }
            // }
        });

        var menuToggles = document.querySelectorAll('.js-menu-toggle');
        var menuElements = document.querySelectorAll('.js-mobmenu-background, .js-mobmenu-content');
        var menuHandler = new Menu(menuElements);
        menuToggles.forEach((toggle) => {
            menuHandler.addToggle(toggle);
        });

        var floorSelectorElement = document.querySelector('.js-floors');
        if (floorSelectorElement) {
            var selector = new FloorSelector();
            selector.setVisualBlock(floorSelectorElement);
        }

        let contactForms = document.querySelectorAll('.js-contactform form');
        contactForms.forEach((form) => {
            form.addEventListener('submit', onContactFormSubmit);
        });

        generateAutoAnchors();
    }

    function onContactFormSubmit(ev) {
        ev.preventDefault();

        let form = ev.target;
        let successDiv = form.querySelector('.message.success');
        let userErrorDiv = form.querySelector('.message.error.user');
        let serverErrorDiv = form.querySelector('.message.error.server');

        var data = new FormData();
        ['name','email','message','_token'].forEach((field) => {
            let element = form.querySelector('[name="' + field + '"]');
            // let value;
            // if (field == 'file') {
            //     value = element.files[0];
            // } else {
            //     value = element.value;
            // }
            // data.append(field, value);
            data.append(field, element.value);
        });
        data.append('title', document.title);
        data.append('url', document.location.href);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.getAttribute('action'), true);
        xhr.onload = function() {
            if(xhr.status >= 200 && xhr.status < 400) {
                serverErrorDiv.classList.add('d-none');
                if (xhr.responseText == 'ok') {
                    form.reset();
                    successDiv.classList.remove('d-none');
                    userErrorDiv.classList.add('d-none');
                } else {
                    successDiv.classList.add('d-none');
                    userErrorDiv.classList.remove('d-none');
                }
            } else {
                successDiv.classList.add('d-none');
                userErrorDiv.classList.add('d-none');
                serverErrorDiv.classList.remove('d-none');
            }
        };
        xhr.send(data);

        return false;
    }

    function onLoad() {
    }

    window.addEventListener('DOMContentLoaded', onReady);
    window.addEventListener('load', onLoad);

    // document.addEventListener('aos:in:slider', ({ detail }) => {
    //     let delay = detail.dataset.aosDelay;
    //     setTimeout(() => {
    //         let slide = detail.querySelector('.slide:first-child');
    //         slide.classList.add('active');
    //     }, delay);
    // });

    // document.addEventListener('aos:out:slider', ({ detail }) => {
    //     console.log('animated out', detail);
    // });
}

window.app = new App();
