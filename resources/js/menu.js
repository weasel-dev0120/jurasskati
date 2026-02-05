export default function Menu(menuElements) {
    var toggles = [];
    var isActive = false;

    if (typeof menuElements == 'string') {
        menuElements = document.querySelectorAll(menuElements);
    } else if (menuElements instanceof Node) {
        menuElements = new Array(menuElements);
    } else if ( ! menuElements instanceof NodeList) {
        // unexpected type
    }

    menuElements.forEach((menuElement) => {
        menuElement.classList.remove('active');
    });

    function displayMenu() {
        isActive = true;
        toggles.forEach((toggleElement) => {
            toggleElement.classList.add('active');
        });
        menuElements.forEach((menuElement) => {
            menuElement.classList.add('active');
        });
        document.body.style.overflowY = 'hidden';
        document.body.parentElement.style.overflowY = 'hidden';
        // document.body.style.height = '100vh';
        // document.body.parentElement.style.height = '100vh';
    }

    function hideMenu() {
        isActive = false;
        toggles.forEach((toggleElement) => {
            toggleElement.classList.remove('active');
        });
        menuElements.forEach((menuElement) => {
            menuElement.classList.remove('active');
        });
        document.body.style.overflowY = '';
        document.body.parentElement.style.overflowY = '';
        // document.body.style.height = '';
        // document.body.parentElement.style.height = '';
    }

    function onToggleClick(ev) {
        if (isActive) {
            hideMenu();
        } else {
            displayMenu();
        }
    }

    function onMenuItemClick(ev) {
        if (this.href.indexOf('#') > -1) {
            hideMenu();
        }
    }

    // var menuItems = menuElement.querySelectorAll('a');
    // // for (var i = 0; i < menuItems.length; ++i) {
    // //     menuItems[i].addEventListener('click', onMenuItemClick);
    // // }
    // menuItems.forEach((item) => {
    //     item.addEventListener('click', onMenuItemClick);
    // });

    this.addToggle = function(toggleElement) {
        toggles.push(toggleElement);
        toggleElement.addEventListener('click', onToggleClick);
        if (isActive) {
            toggleElement.classList.add('active');
        } else {
            toggleElement.classList.remove('active');
        }
    }

    window.addEventListener('keydown', (ev) => {
        // console.log(ev);
        if (isActive) {
            switch (ev.key) {
                // case 'ArrowLeft':
                //     showPreviousGallerySlide(activeGalleryPopup);
                //     break;
                // case 'ArrowRight':
                //     showNextGallerySlide(activeGalleryPopup);
                //     break;
                case 'Escape':
                    hideMenu();
                    break;
            }
        }
    });
}

