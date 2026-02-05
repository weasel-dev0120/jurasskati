export default function FloorSelector() {

    let visualBlock;
    let flatInfoPopup = document.querySelector('.js-selector-popup');
    let hidePopupTimeout;

    // function onFlatInPlanClick(ev) {
    //     console.log(ev);
    // }
    //
    // let flatsInPlans = document.querySelectorAll('.floorplan .action');
    // flatsInPlans.forEach((flat) => {
    //     flat.addEventListener('click', onFlatInPlanClick);
    // });

    function hidePopup() {
        flatInfoPopup.classList.remove('active');
        flatInfoPopup.classList.remove('bottom');
        flatInfoPopup.dataset.current = '';
        setTimeout(() => {
            flatInfoPopup.style.left = 0;
            flatInfoPopup.style.top = 0;
        }, 1);
    }

    function showPopup(target, left, top) {
        clearTimeout(hidePopupTimeout);
        // console.log(rect);
        // console.log(target);
        let row =
            document
                .querySelector('.js-flats-table tr[data-locations~="' + target + '"]');
        if ( ! row)
            return false;
        let fields = ['number', 'floor', 'status', 'rooms', 'area', 'pricefmt', 'typetitle'];
        fields.forEach((field) => {
            let htmlElement = flatInfoPopup.querySelector('.' + field);
            if (htmlElement)
                htmlElement.innerHTML =
                    row.dataset[field]  + (field == 'pricefmt' ? ' €' : '');
        });
        let levelRow = flatInfoPopup.querySelector('.level-row');
        let levelCell = flatInfoPopup.querySelector('.level');
        if (row.dataset.id2) {
            if (target == row.dataset.id2) {
                if (levelCell) {
                    levelCell.innerText = '2';
                }
                let floorElement = flatInfoPopup.querySelector('.floor');
                if (floorElement) {
                    floorElement.innerText = parseInt(row.dataset.floor) + 1;
                }
            } else {
                if (levelCell) {
                    levelCell.innerText = '1';
                }
            }
            levelRow.classList.remove('d-none');
        } else {
            levelRow.classList.add('d-none');
            levelCell.innerText = '—';
        }
        movePopup(left, top);
        flatInfoPopup.classList.add('active');
        flatInfoPopup.dataset.current = target;
    }

    function movePopup(left, top) {
        clearTimeout(hidePopupTimeout);
        // if ( ! flatInfoPopup.classList.contains('active'))
        //     return;
        flatInfoPopup.style.left = left + 'px';
        flatInfoPopup.style.top = top + 'px';
        // console.log(top, flatInfoPopup.clientHeight);
        // let left = rect.x + Math.round(rect.width / 2);
        if (top-100 < flatInfoPopup.clientHeight) {
        // if (rect.y < flatInfoPopup.clientHeight) {
            flatInfoPopup.style.left = left + 'px';
            flatInfoPopup.style.top =
                top + 'px';
                // (rect.y + rect.height + window.scrollY) + 'px';
            flatInfoPopup.classList.add('bottom');
        } else {
            flatInfoPopup.style.left = left + 'px';
            flatInfoPopup.style.top =
                top + 'px';
                // (rect.y + window.scrollY) + 'px';
            flatInfoPopup.classList.remove('bottom');
        }
    }

    function hideAllSlides() {
        let allSlides = visualBlock.querySelectorAll('.slide');
        allSlides.forEach((slide) => {
            slide.classList.remove('active');
        });
        let sidebarLinks = document.querySelectorAll('.sidebar .action');
        sidebarLinks.forEach((link) => {
            link.classList.remove('active');
        });
    }

    function hideAllFloorplans() {
        let allSlides = visualBlock.querySelectorAll('.floorplan');
        allSlides.forEach((slide) => {
            slide.classList.remove('active');
        });
    }

    function onActionTouchstart(ev) {
        let parent = this.closest('.action');
        if ( ! parent.dataset.target) {
            console.error('Action element does not provide target!', ev);
            return false;
        }
        let targetPath = parent.dataset.target.split('-');

        if (targetIsFlatInPlan(parent)) {
            if (targetPath[1]) {
                if (flatInfoPopup.dataset.current != targetPath[1]) {
                    // console.log(this);
                    showPopup(targetPath[1], ev.pageX, ev.pageY);
                    ev.preventDefault();
                    // showPopup(targetPath[1], this.getBoundingClientRect());
                    // return;
                // } else {
                //     hidePopup();
                }
            }
        }
    }

    function onActionHover(ev) {
        // console.log('hover', ev);
        let parent = this.closest('.action');
        if ( ! parent.dataset.target) {
            console.error('Action element does not provide target!', ev);
            return false;
        }
        let targetPath = parent.dataset.target.split('-');

        if (targetIsFlatInPlan(parent)) {
            if (targetPath[1]) {
                if (flatInfoPopup.dataset.current != targetPath[1]) {
                    // console.log(this);
                    showPopup(targetPath[1], ev.pageX, ev.pageY);
                    // showPopup(targetPath[1], this.getBoundingClientRect());
                    // return;
                // } else {
                //     hidePopup();
                }
            }
        }
    }

    function onActionMove(ev) {
        // console.log('move', this);
        let parent = this.closest('.action');
        if ( ! parent.dataset.target) {
            console.error('Action element does not provide target!', ev);
            return false;
        }
        let targetPath = parent.dataset.target.split('-');

        if (targetIsFlatInPlan(parent)) {
            if (targetPath[1]) {
                if (flatInfoPopup.dataset.current == targetPath[1]) {
                    movePopup(ev.pageX, ev.pageY);
                }
            }
        }
    }

    function onActionLeave(ev) {
        // console.log('leave', this);
        if (!ev.toElement || ev.toElement.classList.contains('apt') || ev.toElement.closest('.apt')) {
            // console.log('no leave', ev.toElement);
            return;
        }
        if (ev.toElement == flatInfoPopup || ev.toElement.closest('.js-selector-popup')) {
            hidePopup();
        }
        let parent = this.closest('.action');
        if ( ! parent.dataset.target) {
            console.error('Action element does not provide target!', ev);
            return false;
        }
        let targetPath = parent.dataset.target.split('-');

        if (targetIsFlatInPlan(parent)) {
            if (targetPath[1]) {
                if (flatInfoPopup.dataset.current == targetPath[1]) {
                    hidePopupTimeout = setTimeout(() => {
                        hidePopup();
                    }, 1000);
                }
            }
        }
    }

    function doAction(target) {
        let targetPath = target.split('-');

        // if (targetIsFlatInPlan(ev.target)) {
        //     if (targetPath[1]) {
        //         if (flatInfoPopup.dataset.current != targetPath[1]) {
        //             // console.log(this);
        //             // showPopup(targetPath[1], ev.pageX, ev.pageY);
        //             showPopup(targetPath[1], this.getBoundingClientRect());
        //             return;
        //         } else {
        //             hidePopup();
        //         }
        //     }
        // }
        hidePopup();

        let targetSlide =
            visualBlock.querySelector('.slide.' + targetPath[0]);
        if ( ! targetSlide) {
            console.error('Target slide not found!', ev);
            return false;
        }
        hideAllSlides();
        hideAllFloorplans();
        targetSlide.classList.add('active');
        targetSlide.scrollIntoView({behavior: 'smooth'});
        let linkQuery;
        if (targetPath[1]) {
            if (targetPath[0] == 'apt' || targetPath[0] == 'loft') {
                let aptPlans =
                    targetSlide.querySelectorAll('.aptplan');
                for (var i = 0; i < aptPlans.length; i++) {
                    if (aptPlans[i].classList.contains(targetPath[1])) {
                        aptPlans[i].classList.add('active');
                        if (aptPlans[i].classList.contains('has-second-floor')) {
                            document.querySelector('.js-floors').classList.add('has-second-floor');
                        } else {
                            document.querySelector('.js-floors').classList.remove('has-second-floor');
                        }
                    } else {
                        aptPlans[i].classList.remove('active');
                    }
                }
                let floorTarget =
                    target[0] + 'floors-'
                    + targetPath[1].substr(0, targetPath[1].search('_'));
                linkQuery =
                    '.sidebar .action[data-target="' + floorTarget + '"]';
                let closeLinkQuery =
                    '.' + targetPath[0] + ' .sidebar .action.close';
                let closeLinkElem = document.querySelector(closeLinkQuery);
                closeLinkElem.dataset.target = floorTarget;
            } else {
                document.querySelector('.js-floors').classList.remove('has-second-floor');
                // console.log(targetPath[1]);
                replaceFloorplanSvg(targetPath[1]);
                let targetFloorplan =
                    visualBlock.querySelector('.floorplan.' + targetPath[1]);
                targetFloorplan.classList.add('active');
                let matches = targetPath[1].match(/[a-z](\d+)/);
                if (matches && matches[1]) {
                    let floorInt = parseInt(matches[1]);
                    let aptType =
                        targetPath[1][0] == 'l' ? 'loft' : 'apartment';
                    resetAndFilterTableByFloor(floorInt, floorInt, aptType);
                }
                linkQuery =
                    '.sidebar .action[data-target="' + target + '"]';
            }
            let sidebarLinks = document.querySelectorAll(linkQuery);
            sidebarLinks.forEach((link) => {
                link.classList.add('active');
            });
        } else {
            if (target == 'lofts') {
                resetAndFilterTableByFloor(-1, -1, 'loft');
            } else if (target == 'apartments') {
                resetAndFilterTableByFloor(-1, -1, 'apartment');
            }
        }
    }

    function onActionClick(ev) {
        ev.preventDefault();
        if ( ! this.dataset.target) {
            console.error('Action element does not provide target!', ev);
            return false;
        }
        history.pushState({ target: this.dataset.target }, document.title, "");

        doAction(this.dataset.target);

        return false;
    }

    function targetIsFlatInPlan(target) {
        if (
            (target.closest('.action') || target.classList.contains('action'))
            && target.closest('.floorplan')
        ) {
            return true;
        }
        return false;
    }

    function onVisualBlockClick(ev) {
        if ( ! targetIsFlatInPlan(ev.target)) {
            hidePopup();
        }
    }

    function setupActionEvents(actionElement) {
        actionElement.addEventListener('click', onActionClick);
        let actionBg = actionElement.querySelector('.bg');
        // console.log(actionBg);
        if (actionBg) {
            actionBg.addEventListener('mouseover', onActionHover);
            actionBg.addEventListener('mousemove', onActionMove);
            actionBg.addEventListener('mouseleave', onActionLeave);
            actionBg.addEventListener('touchstart', onActionTouchstart);
        }
    }

    function observerCallback(mutationList, observer) {
        for (const mutation of mutationList) {
            if (mutation.type === "childList") {
                [...mutation.addedNodes].forEach((addedNode) => {
                    // console.log(addedNode, addedNode instanceof Node, addedNode instanceof Text);
                    if (addedNode instanceof Node
                        && !( addedNode instanceof Text )
                        && addedNode.classList.contains('floorplan')
                    ) {
                        let addedActions = addedNode.querySelectorAll('.action');
                        [...addedActions].forEach((actionElement) => {
                            // console.log(actionElement);
                            setupActionEvents(actionElement);
                        })
                    }
                });
            }
        }
    }

    let observer = new MutationObserver(observerCallback);
    observer.observe(document.body, {
            childList: true,
            subtree: true
        });

    function setupVisualBlock() {
        // replaceFloorplanSvg();
        visualBlock.addEventListener('click', onVisualBlockClick);
        let actionElements = document.querySelectorAll('.action'); // FIXME
        for (let i = 0; i < actionElements.length; i++) {
            setupActionEvents(actionElements[i]);
        }
    }

    this.setVisualBlock = function(element) {
        visualBlock = element;
        setupVisualBlock();
    }

    let filterSliders = document.querySelectorAll('.js-filter-slider');
    let filterValues = {};
    let defaultFilterValues = {};
    let currentTypes = ['loft', 'apartment'];

    filterSliders.forEach((slider) => {

        defaultFilterValues[slider.dataset.attr] = filterValues[slider.dataset.attr] = {
            low: parseInt(slider.dataset.min),
            high: parseInt(slider.dataset.max),
        };

        $(slider).slider({
            range: true,
            min: parseInt(slider.dataset.min),
            max: parseInt(slider.dataset.max),
            step: parseInt(slider.dataset.step),
            values: [parseInt(slider.dataset.min),parseInt(slider.dataset.max)],
            slide: function( event, ui ) {
                var indicatorLow = this.parentElement.querySelector('.low');
                var indicatorHigh = this.parentElement.querySelector('.high');
                indicatorLow.innerText = ui.values[0];
                indicatorHigh.innerText = ui.values[1];
                filterValues[event.target.dataset.attr] = {
                    low: ui.values[0],
                    high: ui.values[1]
                };
                filterTable();
            }
        });

    });

    function inRange(value, min, max) {
        if (value >= min && value <= max)
            return true;
        return false;
    }

    function resetAndFilterTableByFloor(floorMin, floorMax, type) {
        if (type) {
            let apartmentCheckbox =
                document.querySelector('#id_type_apartments');
            let loftCheckbox =
                document.querySelector('#id_type_lofts');
            if (type == 'loft') {
                apartmentCheckbox.checked = false;
                loftCheckbox.checked = true;
                currentTypes = ['loft'];
            } else {
                apartmentCheckbox.checked = true;
                loftCheckbox.checked = false;
                currentTypes = ['apartment'];
            }
        }

        filterSliders.forEach((slider) => {
            if (slider.dataset.attr == 'floor') {
                floorMin = floorMin === -1 ? slider.dataset.min : floorMin;
                floorMax = floorMax === -1 ? slider.dataset.max : floorMax;
                $(slider).slider('values', 0, floorMin);
                $(slider).slider('values', 1, floorMax);
                var indicatorLow = slider.parentElement.querySelector('.low');
                var indicatorHigh = slider.parentElement.querySelector('.high');
                indicatorLow.innerText = floorMin;
                indicatorHigh.innerText = floorMax;
            } else {
                $(slider).slider('values', 0, slider.dataset.min);
                $(slider).slider('values', 1, slider.dataset.max);
                var indicatorLow = slider.parentElement.querySelector('.low');
                var indicatorHigh = slider.parentElement.querySelector('.high');
                indicatorLow.innerText = slider.dataset.min;
                indicatorHigh.innerText = slider.dataset.max;
            }
            filterValues[slider.dataset.attr] = {
                low: $(slider).slider('values', 0),
                high: $(slider).slider('values', 1)
            };
        });
        filterTable();
    }

    function filterTable() {
        // console.log(currentTypes);
        // console.log(filterValues);
        let tableOfFlats = document.querySelector('.js-flats-table');
        let rows = tableOfFlats.querySelectorAll('tbody tr');
        rows.forEach((row) => {
            row.classList.remove('filtered-out');
            if ( ! currentTypes.includes(row.dataset.type)) {
                row.classList.add('filtered-out');
                return;
            }
            for (var attr in filterValues) {
                if ( ! inRange(parseFloat(row.dataset[attr]), filterValues[attr].low, filterValues[attr].high)) {
                    row.classList.add('filtered-out');
                    break;
                }
            }
        });

    }

    function markUnavailableOnFloorplans() {
        let tableOfFlats = document.querySelector('.js-flats-table');
        let rows = tableOfFlats.querySelectorAll('tbody tr');
        rows.forEach((row) => {
            if (row.dataset.available == 1)
                return;
            let locations = row.dataset.locations;
            locations = locations.split(' ');
            locations.forEach((location) => {
                let selector =
                    '.floorplan .action.' + location.replace('_', '-');
                let floorplanItem = document.querySelector(selector);
                // console.log(location, floorplanItem);
                if (floorplanItem)
                    floorplanItem.classList.add('unavailable');
            });
        });
    }

    let typeInputs = document.querySelectorAll('.js-flats input[name="flats_type"]');
    typeInputs.forEach((typeInput) => {
        typeInput.addEventListener('change', (ev) => {
            if (ev.target.checked) {
                if ( ! currentTypes.includes(ev.target.value)) {
                    currentTypes.push(ev.target.value);
                }
            } else {
                currentTypes = currentTypes.filter((item) => {
                    return item != ev.target.value;
                });
            }
            filterTable();
        });
    });

    filterTable();
    // markUnavailableOnFloorplans();

    function onAptFloorSelectorClick(ev) {
        ev.preventDefault();
        let target = ev.target;
        let floor = target.dataset.floor;
        let plans = target.closest('.aptplan').querySelectorAll('.plan');
        let siblings = target.closest('.floor-selector').querySelectorAll('a');
        for (var i = 0; i < plans.length; i++) {
            if (plans[i].dataset.floor != floor)
                plans[i].classList.remove('active');
            else
                plans[i].classList.add('active');
            if (siblings[i].dataset.floor != floor)
                siblings[i].classList.remove('active');
            else
                siblings[i].classList.add('active');
        }
    }

    let aptFloorSelectors = document.querySelectorAll('.aptplan .floor-selector a');
    aptFloorSelectors.forEach((item) => {
        item.addEventListener('click', onAptFloorSelectorClick);
    });

    function replaceFloorplanSvg(targetClass) {
        var svgImages = document.querySelectorAll('img.floorplan.' + targetClass);

        [].forEach.call(svgImages, function(img) {

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
                    markUnavailableOnFloorplans();
                }

            }
            request.send();

        });
    }

    window.addEventListener("popstate", (ev) => {
        if (ev.state.target) {
            doAction(ev.state.target);
        }
    });
}
