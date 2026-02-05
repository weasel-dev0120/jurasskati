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

        // If we are too close to the top, show the popup below the pointer.
        // Otherwise show it above (default).
        flatInfoPopup.classList.toggle('bottom', top - 100 < flatInfoPopup.clientHeight);

        // Clamp the popup inside the viewport to avoid triggering horizontal scrollbars
        // (transforms are included in getBoundingClientRect()).
        const margin = 8;
        const rect = flatInfoPopup.getBoundingClientRect();
        let adjustedLeft = left;
        let adjustedTop = top;

        if (rect.left < margin) {
            adjustedLeft += margin - rect.left;
        }
        if (rect.right > window.innerWidth - margin) {
            adjustedLeft -= rect.right - (window.innerWidth - margin);
        }
        if (rect.top < margin) {
            adjustedTop += margin - rect.top;
        }
        if (rect.bottom > window.innerHeight - margin) {
            adjustedTop -= rect.bottom - (window.innerHeight - margin);
        }

        if (adjustedLeft !== left) {
            flatInfoPopup.style.left = adjustedLeft + 'px';
        }
        if (adjustedTop !== top) {
            flatInfoPopup.style.top = adjustedTop + 'px';
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

    /**
     * Calculate floor plan dimensions based on window size minus delta
     * @param {number} deltaWidth - Delta to subtract from window width (default: 300px for sidebar/margins)
     * @param {number} deltaHeight - Delta to subtract from window height (default: 150px for header + margins)
     * @returns {Object} Object with width and height in pixels
     */
    function calculateFloorplanDimensions(deltaWidth = 300, deltaHeight = 150) {
        const windowWidth = window.innerWidth;
        const windowHeight = window.innerHeight;
        
        const dimensions = {
            width: Math.max(300, windowWidth - deltaWidth), // Minimum 300px width
            height: Math.max(300, windowHeight - deltaHeight) // Minimum 300px height
        };
        
        console.log('[FloorPlan] Calculating dimensions:', {
            windowWidth: windowWidth,
            windowHeight: windowHeight,
            deltaWidth: deltaWidth,
            deltaHeight: deltaHeight,
            calculatedWidth: dimensions.width,
            calculatedHeight: dimensions.height
        });
        
        return dimensions;
    }

    /**
     * Apply auto-fitting dimensions to a floor plan element
     * FIX: Changed from fixed pixel sizing to CSS-based responsive sizing
     *      to prevent overflow and zoom accumulation issues.
     * 
     * @param {HTMLElement} floorplanElement - The floor plan element (img or svg)
     * @param {number} deltaWidth - Not used anymore (kept for compatibility)
     * @param {number} deltaHeight - Not used anymore (kept for compatibility)
     */
    function applyFloorplanAutoFit(floorplanElement, deltaWidth = 300, deltaHeight = 150) {
        if (!floorplanElement) {
            console.warn('[FloorPlan] applyFloorplanAutoFit: floorplanElement is null or undefined');
            return;
        }
        
        const elementType = floorplanElement.tagName.toLowerCase();
        const className = floorplanElement.className || 'unknown';
        
        console.log('[FloorPlan] Applying CSS-based auto-fit to element:', {
            elementType: elementType,
            className: className
        });
        
        // FIX: Use CSS-based sizing instead of fixed pixels to prevent overflow
        // Remove any inline width/height that could cause overflow
        floorplanElement.style.width = '';
        floorplanElement.style.height = '';
        floorplanElement.style.maxWidth = '';
        floorplanElement.style.maxHeight = '';
        
        // CRITICAL: Always reset transform to prevent zoom accumulation
        floorplanElement.style.transform = 'none';
        floorplanElement.style.transformOrigin = 'center center';
        
        // Maintain aspect ratio - CSS will handle sizing via max-width/max-height
        if (elementType === 'img') {
            floorplanElement.style.objectFit = 'contain';
        } else if (elementType === 'svg') {
            // For SVG, preserve aspect ratio
            if (!floorplanElement.getAttribute('preserveAspectRatio')) {
                floorplanElement.setAttribute('preserveAspectRatio', 'xMidYMid meet');
            }
        }
        
        console.log('[FloorPlan] CSS-based auto-fit applied. Element will size via CSS max-width/max-height.');
    }

    function hideAllFloorplans() {
        let allSlides = visualBlock.querySelectorAll('.floorplan');
        allSlides.forEach((slide) => {
            slide.classList.remove('active');
            // Reset transforms when hiding to prevent zoom accumulation
            slide.style.transform = 'none';
            slide.style.transformOrigin = 'center center';
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
        console.log('[FloorPlan] doAction called with target:', target);
        let targetPath = target.split('-');
        console.log('[FloorPlan] Parsed targetPath:', targetPath);

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
                console.log('[FloorPlan] Opening floor plan:', {
                    target: target,
                    targetPath: targetPath,
                    floorPlanClass: targetPath[1]
                });
                
                document.querySelector('.js-floors').classList.remove('has-second-floor');
                
                // Reset all floorplan transforms before switching to prevent zoom issues
                let allFloorplans = visualBlock.querySelectorAll('.floorplan');
                console.log('[FloorPlan] Resetting', allFloorplans.length, 'existing floor plans');
                allFloorplans.forEach(function(floorplan) {
                    floorplan.style.transform = 'none';
                    floorplan.style.transformOrigin = 'center center';
                });
                
                replaceFloorplanSvg(targetPath[1]);
                let targetFloorplan =
                    visualBlock.querySelector('.floorplan.' + targetPath[1]);
                
                if (targetFloorplan) {
                    console.log('[FloorPlan] Target floor plan found:', {
                        element: targetFloorplan,
                        tagName: targetFloorplan.tagName,
                        className: targetFloorplan.className
                    });
                    
                    // Calculate delta values (adjust these as needed)
                    // deltaWidth accounts for sidebar (260px) + margins (40px) = ~300px
                    // deltaHeight accounts for header + margins = ~150px
                    const deltaWidth = 300;
                    const deltaHeight = 150;
                    
                    // Apply auto-fitting dimensions based on window size
                    applyFloorplanAutoFit(targetFloorplan, deltaWidth, deltaHeight);
                    
                    targetFloorplan.classList.add('active');
                    console.log('[FloorPlan] Floor plan activated:', targetPath[1]);
                } else {
                    console.warn('[FloorPlan] Target floor plan not found for class:', targetPath[1]);
                }
                
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

        // Set height for container (auto-sizing for apartment slides)
        if(document.querySelector('.slide.active.apt')){
            let activeSlide = document.querySelector('.slide.active.apt');
            if (activeSlide) {
                // Use setTimeout to ensure DOM has updated after SVG replacement
                setTimeout(function() {
                    // Calculate container height based on window height minus delta
                    const deltaHeight = 150;
                    const windowHeight = window.innerHeight;
                    const containerHeight = Math.max(400, windowHeight - deltaHeight);
                    
                    let floorsContainer = document.querySelector('.js-floors');
                    if (floorsContainer) {
                        floorsContainer.style.height = containerHeight + 'px';
                    }
                }, 100);
            }
        }
        
        // Handle window resize to update floor plan dimensions
        // Debounce resize handler
        let resizeTimeout;
        function handleResize() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const activeFloorplan = visualBlock.querySelector('.floorplan.active');
                if (activeFloorplan) {
                    console.log('[FloorPlan] Window resized, updating active floor plan dimensions');
                    const deltaWidth = 300;
                    const deltaHeight = 150;
                    applyFloorplanAutoFit(activeFloorplan, deltaWidth, deltaHeight);
                }
            }, 250);
        }
        
        // Only add resize listener once
        if (!window.floorplanResizeHandlerAdded) {
            window.addEventListener('resize', handleResize);
            window.floorplanResizeHandlerAdded = true;
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
        console.log('[FloorPlan] replaceFloorplanSvg called for:', targetClass);
        
        // Check if SVG was already replaced - if so, skip replacement
        var existingSvg = document.querySelector('svg.floorplan.' + targetClass);
        if (existingSvg) {
            console.log('[FloorPlan] SVG already exists, applying auto-fit to existing SVG');
            // SVG already exists, apply auto-fitting dimensions
            const deltaWidth = 300;
            const deltaHeight = 150;
            applyFloorplanAutoFit(existingSvg, deltaWidth, deltaHeight);
            markUnavailableOnFloorplans();
            return;
        }

        var svgImages = document.querySelectorAll('img.floorplan.' + targetClass);
        console.log('[FloorPlan] Found', svgImages.length, 'image(s) to replace for class:', targetClass);

        [].forEach.call(svgImages, function(img) {
            // Skip if this image was already replaced (shouldn't happen, but safety check)
            if (img.tagName.toLowerCase() !== 'img') {
                return;
            }

            var attributes = img.attributes;
            var request = new XMLHttpRequest();
            request.open('GET', img.src, true);
            request.onload = function () {

                if(request.status >= 200 && request.status < 400) {
                    // Double-check the img still exists and hasn't been replaced
                    if (!img.parentNode || img.tagName.toLowerCase() !== 'img') {
                        return;
                    }

                    var parser = new DOMParser(),
                        result = parser.parseFromString(request.responseText, 'text/xml'),
                        svg = result.getElementsByTagName('svg')[0];
                    
                    if (!svg) {
                        return;
                    }

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
                    
                    console.log('[FloorPlan] Replacing img with SVG for:', targetClass);
                    img.parentNode.replaceChild(svg, img);
                    console.log('[FloorPlan] SVG replacement completed');
                    
                    // Apply auto-fitting dimensions after SVG replacement
                    const deltaWidth = 300;
                    const deltaHeight = 150;
                    applyFloorplanAutoFit(svg, deltaWidth, deltaHeight);
                    
                    markUnavailableOnFloorplans();
                    console.log('[FloorPlan] SVG replacement and auto-fit completed for:', targetClass);
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
