/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/floorselector.js":
/*!***************************************!*\
  !*** ./resources/js/floorselector.js ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ FloorSelector; }
/* harmony export */ });
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function FloorSelector() {
  var visualBlock;
  var flatInfoPopup = document.querySelector('.js-selector-popup');
  var hidePopupTimeout;

  /**
   * CRITICAL: Prevent height from being set on .js-floors container
   * This function actively clears any height that gets set using multiple methods:
   * 1. MutationObserver to watch for style attribute changes
   * 2. Periodic check to catch any height that gets set
   * 3. Override style.height setter if possible
   */
  function preventContainerHeight() {
    var floorsContainer = document.querySelector('.js-floors');
    if (!floorsContainer) {
      // Retry if container doesn't exist yet
      setTimeout(preventContainerHeight, 100);
      return;
    }

    // Clear any existing inline height immediately
    if (floorsContainer.style.height) {
      floorsContainer.style.height = '';
      floorsContainer.style.removeProperty('height');
      console.log('[FloorPlan] Cleared existing inline height from .js-floors');
    }

    // Method 1: Use MutationObserver to watch for style attribute changes
    var heightObserver = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
          var target = mutation.target;
          if (target.classList && target.classList.contains('js-floors')) {
            if (target.style.height && target.style.height !== '' && target.style.height !== 'auto') {
              console.warn('[FloorPlan] Height was set on .js-floors, clearing it:', target.style.height);
              target.style.height = '';
              target.style.removeProperty('height');
              target.style.setProperty('height', '', 'important');
            }
          }
        }
      });
    });

    // Observe the container for style attribute changes
    heightObserver.observe(floorsContainer, {
      attributes: true,
      attributeFilter: ['style'],
      attributeOldValue: true
    });

    // Method 2: Override the style.height setter directly on this element
    try {
      var styleObj = floorsContainer.style;
      var originalHeightSetter = Object.getOwnPropertyDescriptor(styleObj, 'height');
      Object.defineProperty(styleObj, 'height', {
        get: function get() {
          return '';
        },
        set: function set(value) {
          // Ignore any attempts to set height
          console.warn('[FloorPlan] Attempted to set height to:', value, '- blocked');
          return '';
        },
        configurable: true,
        enumerable: true
      });
      console.log('[FloorPlan] Height setter override active');
    } catch (e) {
      console.warn('[FloorPlan] Could not override height setter:', e);
    }

    // Method 3: Periodic check to catch any height that slips through
    var heightCheckInterval = setInterval(function () {
      if (floorsContainer.style.height && floorsContainer.style.height !== '' && floorsContainer.style.height !== 'auto') {
        console.warn('[FloorPlan] Periodic check found height set, clearing:', floorsContainer.style.height);
        floorsContainer.style.height = '';
        floorsContainer.style.removeProperty('height');
        floorsContainer.style.setProperty('height', '', 'important');
      }
    }, 100); // Check every 100ms

    // Store references for cleanup if needed
    floorsContainer._heightObserver = heightObserver;
    floorsContainer._heightCheckInterval = heightCheckInterval;
    console.log('[FloorPlan] Height prevention active on .js-floors container (MutationObserver + setter override + periodic check)');
  }

  // Initialize height prevention immediately and on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', preventContainerHeight);
  } else {
    preventContainerHeight();
  }

  // Also initialize after a short delay to catch late-loading elements
  setTimeout(preventContainerHeight, 500);

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
    setTimeout(function () {
      flatInfoPopup.style.left = 0;
      flatInfoPopup.style.top = 0;
    }, 1);
  }
  function showPopup(target, left, top) {
    clearTimeout(hidePopupTimeout);
    // console.log(rect);
    // console.log(target);
    var row = document.querySelector('.js-flats-table tr[data-locations~="' + target + '"]');
    if (!row) return false;
    var fields = ['number', 'floor', 'status', 'rooms', 'area', 'pricefmt', 'typetitle'];
    fields.forEach(function (field) {
      var htmlElement = flatInfoPopup.querySelector('.' + field);
      if (htmlElement) htmlElement.innerHTML = row.dataset[field] + (field == 'pricefmt' ? ' €' : '');
    });
    var levelRow = flatInfoPopup.querySelector('.level-row');
    var levelCell = flatInfoPopup.querySelector('.level');
    if (row.dataset.id2) {
      if (target == row.dataset.id2) {
        if (levelCell) {
          levelCell.innerText = '2';
        }
        var floorElement = flatInfoPopup.querySelector('.floor');
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
    var margin = 8;
    var rect = flatInfoPopup.getBoundingClientRect();
    var adjustedLeft = left;
    var adjustedTop = top;
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
    var allSlides = visualBlock.querySelectorAll('.slide');
    allSlides.forEach(function (slide) {
      slide.classList.remove('active');
    });
    var sidebarLinks = document.querySelectorAll('.sidebar .action');
    sidebarLinks.forEach(function (link) {
      link.classList.remove('active');
    });
  }

  /**
   * Calculate floor plan dimensions based on window size minus delta
   * @param {number} deltaWidth - Delta to subtract from window width (default: 300px for sidebar/margins)
   * @param {number} deltaHeight - Delta to subtract from window height (default: 150px for header + margins)
   * @returns {Object} Object with width and height in pixels
   */
  function calculateFloorplanDimensions() {
    var deltaWidth = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 300;
    var deltaHeight = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 150;
    var windowWidth = window.innerWidth;
    var windowHeight = window.innerHeight;
    var dimensions = {
      width: Math.max(300, windowWidth - deltaWidth),
      // Minimum 300px width
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
   * Reset all transforms on a floorplan element to prevent accumulation
   * CRITICAL: Must be called BEFORE any sizing/positioning operations
   * 
   * @param {HTMLElement} element - The floorplan element to reset
   */
  function resetFloorplanTransform(element) {
    if (!element) return;

    // Force reset transform immediately - use multiple methods to ensure it sticks
    element.style.transform = 'none';
    element.style.webkitTransform = 'none';
    element.style.mozTransform = 'none';
    element.style.msTransform = 'none';
    element.style.oTransform = 'none';
    element.style.transformOrigin = 'center center';

    // Remove any transform-related data attributes that might be used by libraries
    if (element.dataset) {
      delete element.dataset.scale;
      delete element.dataset.transform;
      delete element.dataset.zoom;
    }

    // If element has a panzoom instance attached, destroy it
    if (element._panzoom) {
      try {
        if (typeof element._panzoom.destroy === 'function') {
          element._panzoom.destroy();
        }
        delete element._panzoom;
      } catch (e) {
        console.warn('[FloorPlan] Error destroying panzoom instance:', e);
      }
    }
    console.log('[FloorPlan] Transform reset applied to:', element.className);
  }

  /**
   * Get natural dimensions of floorplan element (before any transforms)
   * Uses viewBox for SVG, naturalWidth/Height for images
   * 
   * @param {HTMLElement} element - The floorplan element
   * @returns {Object} Object with naturalWidth and naturalHeight
   */
  function getNaturalDimensions(element) {
    if (!element) return {
      naturalWidth: 0,
      naturalHeight: 0
    };
    var elementType = element.tagName.toLowerCase();
    if (elementType === 'svg') {
      // For SVG, use viewBox if available, otherwise width/height attributes
      var viewBox = element.getAttribute('viewBox');
      if (viewBox) {
        var parts = viewBox.split(/\s+/);
        if (parts.length >= 4) {
          return {
            naturalWidth: parseFloat(parts[2]) || 0,
            naturalHeight: parseFloat(parts[3]) || 0
          };
        }
      }
      // Fallback to width/height attributes
      var width = parseFloat(element.getAttribute('width')) || 0;
      var height = parseFloat(element.getAttribute('height')) || 0;
      return {
        naturalWidth: width,
        naturalHeight: height
      };
    } else if (elementType === 'img') {
      // For images, use naturalWidth/naturalHeight (not affected by CSS transforms)
      return {
        naturalWidth: element.naturalWidth || 0,
        naturalHeight: element.naturalHeight || 0
      };
    }
    return {
      naturalWidth: 0,
      naturalHeight: 0
    };
  }

  /**
   * Apply auto-fitting dimensions to a floor plan element
   * FIX: Changed from fixed pixel sizing to CSS-based responsive sizing
   *      to prevent overflow and zoom accumulation issues.
   * 
   * CRITICAL: Always resets transform BEFORE applying any sizing to prevent accumulation
   * 
   * @param {HTMLElement} floorplanElement - The floor plan element (img or svg)
   * @param {number} deltaWidth - Not used anymore (kept for compatibility)
   * @param {number} deltaHeight - Not used anymore (kept for compatibility)
   */
  function applyFloorplanAutoFit(floorplanElement) {
    var deltaWidth = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
    var deltaHeight = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 150;
    if (!floorplanElement) {
      console.warn('[FloorPlan] applyFloorplanAutoFit: floorplanElement is null or undefined');
      return;
    }
    var elementType = floorplanElement.tagName.toLowerCase();
    var className = floorplanElement.className || 'unknown';
    console.log('[FloorPlan] Applying CSS-based auto-fit to element:', {
      elementType: elementType,
      className: className
    });

    // CRITICAL STEP 1: Reset transform FIRST, before any other operations
    // This prevents reading transformed dimensions and accumulating scale
    resetFloorplanTransform(floorplanElement);

    // Get natural dimensions (before any transforms) for logging/debugging
    var naturalDims = getNaturalDimensions(floorplanElement);
    console.log('[FloorPlan] Natural dimensions (untransformed):', naturalDims);

    // FIX: Use CSS-based sizing instead of fixed pixels to prevent overflow
    // Remove any inline width/height that could cause overflow
    floorplanElement.style.width = '';
    floorplanElement.style.height = '';
    floorplanElement.style.maxWidth = '';
    floorplanElement.style.maxHeight = '';

    // CRITICAL STEP 2: Ensure transform stays reset (defense in depth)
    resetFloorplanTransform(floorplanElement);

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
    var allSlides = visualBlock.querySelectorAll('.floorplan');
    allSlides.forEach(function (slide) {
      slide.classList.remove('active');
      // CRITICAL: Reset transforms when hiding to prevent zoom accumulation
      // Use comprehensive reset function instead of simple style assignment
      resetFloorplanTransform(slide);
    });
  }
  function onActionTouchstart(ev) {
    var parent = this.closest('.action');
    if (!parent.dataset.target) {
      console.error('Action element does not provide target!', ev);
      return false;
    }
    var targetPath = parent.dataset.target.split('-');
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
    var parent = this.closest('.action');
    if (!parent.dataset.target) {
      console.error('Action element does not provide target!', ev);
      return false;
    }
    var targetPath = parent.dataset.target.split('-');
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
    var parent = this.closest('.action');
    if (!parent.dataset.target) {
      console.error('Action element does not provide target!', ev);
      return false;
    }
    var targetPath = parent.dataset.target.split('-');
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
    var parent = this.closest('.action');
    if (!parent.dataset.target) {
      console.error('Action element does not provide target!', ev);
      return false;
    }
    var targetPath = parent.dataset.target.split('-');
    if (targetIsFlatInPlan(parent)) {
      if (targetPath[1]) {
        if (flatInfoPopup.dataset.current == targetPath[1]) {
          hidePopupTimeout = setTimeout(function () {
            hidePopup();
          }, 1000);
        }
      }
    }
  }
  function doAction(target) {
    console.log('[FloorPlan] doAction called with target:', target);
    var targetPath = target.split('-');
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
    var targetSlide = visualBlock.querySelector('.slide.' + targetPath[0]);
    if (!targetSlide) {
      console.error('Target slide not found!', ev);
      return false;
    }
    hideAllSlides();
    hideAllFloorplans();
    targetSlide.classList.add('active');
    targetSlide.scrollIntoView({
      behavior: 'smooth'
    });
    var linkQuery;
    if (targetPath[1]) {
      if (targetPath[0] == 'apt' || targetPath[0] == 'loft') {
        var aptPlans = targetSlide.querySelectorAll('.aptplan');
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
        var floorTarget = target[0] + 'floors-' + targetPath[1].substr(0, targetPath[1].search('_'));
        linkQuery = '.sidebar .action[data-target="' + floorTarget + '"]';
        var closeLinkQuery = '.' + targetPath[0] + ' .sidebar .action.close';
        var closeLinkElem = document.querySelector(closeLinkQuery);
        closeLinkElem.dataset.target = floorTarget;
      } else {
        console.log('[FloorPlan] Opening floor plan:', {
          target: target,
          targetPath: targetPath,
          floorPlanClass: targetPath[1]
        });
        document.querySelector('.js-floors').classList.remove('has-second-floor');

        // CRITICAL: Reset ALL floorplan transforms BEFORE switching to prevent zoom accumulation
        // This must happen synchronously before any other operations
        var allFloorplans = visualBlock.querySelectorAll('.floorplan');
        console.log('[FloorPlan] Resetting', allFloorplans.length, 'existing floor plans');
        allFloorplans.forEach(function (floorplan) {
          resetFloorplanTransform(floorplan);
        });

        // Replace SVG (async operation, but transform already reset)
        replaceFloorplanSvg(targetPath[1]);

        // Get target floorplan AFTER resetting all transforms
        var targetFloorplan = visualBlock.querySelector('.floorplan.' + targetPath[1]);
        if (targetFloorplan) {
          console.log('[FloorPlan] Target floor plan found:', {
            element: targetFloorplan,
            tagName: targetFloorplan.tagName,
            className: targetFloorplan.className
          });

          // CRITICAL: Reset transform on target BEFORE applying auto-fit
          // This ensures we're working with natural dimensions, not transformed ones
          resetFloorplanTransform(targetFloorplan);

          // Calculate delta values (adjust these as needed)
          // deltaWidth accounts for sidebar (260px) + margins (40px) = ~300px
          // deltaHeight accounts for header + margins = ~150px
          var deltaWidth = 300;
          var deltaHeight = 150;

          // Apply auto-fitting dimensions based on window size
          // applyFloorplanAutoFit will reset transform again as defense in depth
          applyFloorplanAutoFit(targetFloorplan, deltaWidth, deltaHeight);
          targetFloorplan.classList.add('active');
          console.log('[FloorPlan] Floor plan activated:', targetPath[1]);
        } else {
          console.warn('[FloorPlan] Target floor plan not found for class:', targetPath[1]);
        }
        var matches = targetPath[1].match(/[a-z](\d+)/);
        if (matches && matches[1]) {
          var floorInt = parseInt(matches[1]);
          var aptType = targetPath[1][0] == 'l' ? 'loft' : 'apartment';
          resetAndFilterTableByFloor(floorInt, floorInt, aptType);
        }
        linkQuery = '.sidebar .action[data-target="' + target + '"]';
      }
      var sidebarLinks = document.querySelectorAll(linkQuery);
      sidebarLinks.forEach(function (link) {
        link.classList.add('active');
      });
    } else {
      if (target == 'lofts') {
        resetAndFilterTableByFloor(-1, -1, 'loft');
      } else if (target == 'apartments') {
        resetAndFilterTableByFloor(-1, -1, 'apartment');
      }
    }

    // CRITICAL: Prevent and clear any height being set on .js-floors container
    // The container should size naturally based on CSS (min-height, aspect-ratio, content)
    // Setting fixed height via JS causes layout issues and prevents natural sizing
    // CSS handles sizing via:
    //   - min-height: 28.3333333333rem (680px)
    //   - aspect-ratio: 1440/790 (on xl screens)
    //   - Content-based height (natural flow)

    // Aggressively clear height on every action to prevent accumulation
    var floorsContainer = document.querySelector('.js-floors');
    if (floorsContainer) {
      // Clear height immediately
      if (floorsContainer.style.height) {
        floorsContainer.style.height = '';
        console.log('[FloorPlan] Cleared inline height from .js-floors container');
      }

      // Also clear using removeProperty for extra safety
      if (floorsContainer.style.removeProperty) {
        floorsContainer.style.removeProperty('height');
      }

      // Set height to empty string explicitly
      floorsContainer.style.setProperty('height', '', 'important');

      // Force a reflow to ensure the change takes effect
      void floorsContainer.offsetHeight;
    }

    // Handle window resize to update floor plan dimensions
    // Debounce resize handler
    var resizeTimeout;
    function handleResize() {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(function () {
        var activeFloorplan = visualBlock.querySelector('.floorplan.active');
        if (activeFloorplan) {
          console.log('[FloorPlan] Window resized, resetting transform and updating dimensions');
          // CRITICAL: Reset transform on resize to prevent accumulation
          resetFloorplanTransform(activeFloorplan);
          var _deltaWidth = 300;
          var _deltaHeight = 150;
          applyFloorplanAutoFit(activeFloorplan, _deltaWidth, _deltaHeight);
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
    if (!this.dataset.target) {
      console.error('Action element does not provide target!', ev);
      return false;
    }
    history.pushState({
      target: this.dataset.target
    }, document.title, "");
    doAction(this.dataset.target);
    return false;
  }
  function targetIsFlatInPlan(target) {
    if ((target.closest('.action') || target.classList.contains('action')) && target.closest('.floorplan')) {
      return true;
    }
    return false;
  }
  function onVisualBlockClick(ev) {
    if (!targetIsFlatInPlan(ev.target)) {
      hidePopup();
    }
  }
  function setupActionEvents(actionElement) {
    actionElement.addEventListener('click', onActionClick);
    var actionBg = actionElement.querySelector('.bg');
    // console.log(actionBg);
    if (actionBg) {
      actionBg.addEventListener('mouseover', onActionHover);
      actionBg.addEventListener('mousemove', onActionMove);
      actionBg.addEventListener('mouseleave', onActionLeave);
      actionBg.addEventListener('touchstart', onActionTouchstart);
    }
  }
  function observerCallback(mutationList, observer) {
    var _iterator = _createForOfIteratorHelper(mutationList),
      _step;
    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var mutation = _step.value;
        if (mutation.type === "childList") {
          _toConsumableArray(mutation.addedNodes).forEach(function (addedNode) {
            // console.log(addedNode, addedNode instanceof Node, addedNode instanceof Text);
            if (addedNode instanceof Node && !(addedNode instanceof Text) && addedNode.classList.contains('floorplan')) {
              var addedActions = addedNode.querySelectorAll('.action');
              _toConsumableArray(addedActions).forEach(function (actionElement) {
                // console.log(actionElement);
                setupActionEvents(actionElement);
              });
            }
          });
        }
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
  }
  var observer = new MutationObserver(observerCallback);
  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
  function setupVisualBlock() {
    // replaceFloorplanSvg();
    visualBlock.addEventListener('click', onVisualBlockClick);
    var actionElements = document.querySelectorAll('.action'); // FIXME
    for (var i = 0; i < actionElements.length; i++) {
      setupActionEvents(actionElements[i]);
    }
  }
  this.setVisualBlock = function (element) {
    visualBlock = element;
    setupVisualBlock();

    // Ensure height prevention is active when visual block is set
    preventContainerHeight();
  };
  var filterSliders = document.querySelectorAll('.js-filter-slider');
  var filterValues = {};
  var defaultFilterValues = {};
  var currentTypes = ['loft', 'apartment'];
  filterSliders.forEach(function (slider) {
    defaultFilterValues[slider.dataset.attr] = filterValues[slider.dataset.attr] = {
      low: parseInt(slider.dataset.min),
      high: parseInt(slider.dataset.max)
    };
    $(slider).slider({
      range: true,
      min: parseInt(slider.dataset.min),
      max: parseInt(slider.dataset.max),
      step: parseInt(slider.dataset.step),
      values: [parseInt(slider.dataset.min), parseInt(slider.dataset.max)],
      slide: function slide(event, ui) {
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
    if (value >= min && value <= max) return true;
    return false;
  }
  function resetAndFilterTableByFloor(floorMin, floorMax, type) {
    if (type) {
      var apartmentCheckbox = document.querySelector('#id_type_apartments');
      var loftCheckbox = document.querySelector('#id_type_lofts');
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
    filterSliders.forEach(function (slider) {
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
    var tableOfFlats = document.querySelector('.js-flats-table');
    var rows = tableOfFlats.querySelectorAll('tbody tr');
    rows.forEach(function (row) {
      row.classList.remove('filtered-out');
      if (!currentTypes.includes(row.dataset.type)) {
        row.classList.add('filtered-out');
        return;
      }
      for (var attr in filterValues) {
        if (!inRange(parseFloat(row.dataset[attr]), filterValues[attr].low, filterValues[attr].high)) {
          row.classList.add('filtered-out');
          break;
        }
      }
    });
  }
  function markUnavailableOnFloorplans() {
    var tableOfFlats = document.querySelector('.js-flats-table');
    var rows = tableOfFlats.querySelectorAll('tbody tr');
    rows.forEach(function (row) {
      if (row.dataset.available == 1) return;
      var locations = row.dataset.locations;
      locations = locations.split(' ');
      locations.forEach(function (location) {
        var selector = '.floorplan .action.' + location.replace('_', '-');
        var floorplanItem = document.querySelector(selector);
        // console.log(location, floorplanItem);
        if (floorplanItem) floorplanItem.classList.add('unavailable');
      });
    });
  }
  var typeInputs = document.querySelectorAll('.js-flats input[name="flats_type"]');
  typeInputs.forEach(function (typeInput) {
    typeInput.addEventListener('change', function (ev) {
      if (ev.target.checked) {
        if (!currentTypes.includes(ev.target.value)) {
          currentTypes.push(ev.target.value);
        }
      } else {
        currentTypes = currentTypes.filter(function (item) {
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
    var target = ev.target;
    var floor = target.dataset.floor;
    var plans = target.closest('.aptplan').querySelectorAll('.plan');
    var siblings = target.closest('.floor-selector').querySelectorAll('a');
    for (var i = 0; i < plans.length; i++) {
      if (plans[i].dataset.floor != floor) plans[i].classList.remove('active');else plans[i].classList.add('active');
      if (siblings[i].dataset.floor != floor) siblings[i].classList.remove('active');else siblings[i].classList.add('active');
    }
  }
  var aptFloorSelectors = document.querySelectorAll('.aptplan .floor-selector a');
  aptFloorSelectors.forEach(function (item) {
    item.addEventListener('click', onAptFloorSelectorClick);
  });
  function replaceFloorplanSvg(targetClass) {
    console.log('[FloorPlan] replaceFloorplanSvg called for:', targetClass);

    // Check if SVG was already replaced - if so, skip replacement
    var existingSvg = document.querySelector('svg.floorplan.' + targetClass);
    if (existingSvg) {
      console.log('[FloorPlan] SVG already exists, resetting transform and applying auto-fit');
      // CRITICAL: Reset transform BEFORE applying auto-fit to prevent accumulation
      resetFloorplanTransform(existingSvg);
      // SVG already exists, apply auto-fitting dimensions
      var deltaWidth = 300;
      var deltaHeight = 150;
      applyFloorplanAutoFit(existingSvg, deltaWidth, deltaHeight);
      markUnavailableOnFloorplans();
      return;
    }
    var svgImages = document.querySelectorAll('img.floorplan.' + targetClass);
    console.log('[FloorPlan] Found', svgImages.length, 'image(s) to replace for class:', targetClass);
    [].forEach.call(svgImages, function (img) {
      // Skip if this image was already replaced (shouldn't happen, but safety check)
      if (img.tagName.toLowerCase() !== 'img') {
        return;
      }
      var attributes = img.attributes;
      var request = new XMLHttpRequest();
      request.open('GET', img.src, true);
      request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
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
          [].slice.call(attributes).forEach(function (attribute) {
            if (attribute.name !== 'src' && attribute.name !== 'alt') {
              svg.setAttribute(attribute.name, attribute.value);
            }
          });
          svg.setAttribute('role', 'img');
          console.log('[FloorPlan] Replacing img with SVG for:', targetClass);
          img.parentNode.replaceChild(svg, img);
          console.log('[FloorPlan] SVG replacement completed');

          // CRITICAL: Reset transform immediately after replacement, before auto-fit
          // This ensures the new SVG starts with no transforms
          resetFloorplanTransform(svg);

          // Apply auto-fitting dimensions after SVG replacement
          var _deltaWidth2 = 300;
          var _deltaHeight2 = 150;
          applyFloorplanAutoFit(svg, _deltaWidth2, _deltaHeight2);
          markUnavailableOnFloorplans();
          console.log('[FloorPlan] SVG replacement and auto-fit completed for:', targetClass);
        }
      };
      request.send();
    });
  }
  window.addEventListener("popstate", function (ev) {
    if (ev.state.target) {
      doAction(ev.state.target);
    }
  });
}

/***/ }),

/***/ "./resources/js/menu.js":
/*!******************************!*\
  !*** ./resources/js/menu.js ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Menu; }
/* harmony export */ });
function Menu(menuElements) {
  var toggles = [];
  var isActive = false;
  if (typeof menuElements == 'string') {
    menuElements = document.querySelectorAll(menuElements);
  } else if (menuElements instanceof Node) {
    menuElements = new Array(menuElements);
  } else if (!menuElements instanceof NodeList) {
    // unexpected type
  }
  menuElements.forEach(function (menuElement) {
    menuElement.classList.remove('active');
  });
  function displayMenu() {
    isActive = true;
    toggles.forEach(function (toggleElement) {
      toggleElement.classList.add('active');
    });
    menuElements.forEach(function (menuElement) {
      menuElement.classList.add('active');
    });
    document.body.style.overflowY = 'hidden';
    document.body.parentElement.style.overflowY = 'hidden';
    // document.body.style.height = '100vh';
    // document.body.parentElement.style.height = '100vh';
  }

  function hideMenu() {
    isActive = false;
    toggles.forEach(function (toggleElement) {
      toggleElement.classList.remove('active');
    });
    menuElements.forEach(function (menuElement) {
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

  this.addToggle = function (toggleElement) {
    toggles.push(toggleElement);
    toggleElement.addEventListener('click', onToggleClick);
    if (isActive) {
      toggleElement.classList.add('active');
    } else {
      toggleElement.classList.remove('active');
    }
  };
  window.addEventListener('keydown', function (ev) {
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

/***/ }),

/***/ "./resources/js/smoothscroll.min.js":
/*!******************************************!*\
  !*** ./resources/js/smoothscroll.min.js ***!
  \******************************************/
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
!function () {
  "use strict";

  function o() {
    var o = window,
      t = document;
    if (!("scrollBehavior" in t.documentElement.style && !0 !== o.__forceSmoothScrollPolyfill__)) {
      var l,
        e = o.HTMLElement || o.Element,
        r = 468,
        i = {
          scroll: o.scroll || o.scrollTo,
          scrollBy: o.scrollBy,
          elementScroll: e.prototype.scroll || n,
          scrollIntoView: e.prototype.scrollIntoView
        },
        s = o.performance && o.performance.now ? o.performance.now.bind(o.performance) : Date.now,
        c = (l = o.navigator.userAgent, new RegExp(["MSIE ", "Trident/", "Edge/"].join("|")).test(l) ? 1 : 0);
      o.scroll = o.scrollTo = function () {
        void 0 !== arguments[0] && (!0 !== f(arguments[0]) ? h.call(o, t.body, void 0 !== arguments[0].left ? ~~arguments[0].left : o.scrollX || o.pageXOffset, void 0 !== arguments[0].top ? ~~arguments[0].top : o.scrollY || o.pageYOffset) : i.scroll.call(o, void 0 !== arguments[0].left ? arguments[0].left : "object" != _typeof(arguments[0]) ? arguments[0] : o.scrollX || o.pageXOffset, void 0 !== arguments[0].top ? arguments[0].top : void 0 !== arguments[1] ? arguments[1] : o.scrollY || o.pageYOffset));
      }, o.scrollBy = function () {
        void 0 !== arguments[0] && (f(arguments[0]) ? i.scrollBy.call(o, void 0 !== arguments[0].left ? arguments[0].left : "object" != _typeof(arguments[0]) ? arguments[0] : 0, void 0 !== arguments[0].top ? arguments[0].top : void 0 !== arguments[1] ? arguments[1] : 0) : h.call(o, t.body, ~~arguments[0].left + (o.scrollX || o.pageXOffset), ~~arguments[0].top + (o.scrollY || o.pageYOffset)));
      }, e.prototype.scroll = e.prototype.scrollTo = function () {
        if (void 0 !== arguments[0]) if (!0 !== f(arguments[0])) {
          var o = arguments[0].left,
            t = arguments[0].top;
          h.call(this, this, void 0 === o ? this.scrollLeft : ~~o, void 0 === t ? this.scrollTop : ~~t);
        } else {
          if ("number" == typeof arguments[0] && void 0 === arguments[1]) throw new SyntaxError("Value could not be converted");
          i.elementScroll.call(this, void 0 !== arguments[0].left ? ~~arguments[0].left : "object" != _typeof(arguments[0]) ? ~~arguments[0] : this.scrollLeft, void 0 !== arguments[0].top ? ~~arguments[0].top : void 0 !== arguments[1] ? ~~arguments[1] : this.scrollTop);
        }
      }, e.prototype.scrollBy = function () {
        void 0 !== arguments[0] && (!0 !== f(arguments[0]) ? this.scroll({
          left: ~~arguments[0].left + this.scrollLeft,
          top: ~~arguments[0].top + this.scrollTop,
          behavior: arguments[0].behavior
        }) : i.elementScroll.call(this, void 0 !== arguments[0].left ? ~~arguments[0].left + this.scrollLeft : ~~arguments[0] + this.scrollLeft, void 0 !== arguments[0].top ? ~~arguments[0].top + this.scrollTop : ~~arguments[1] + this.scrollTop));
      }, e.prototype.scrollIntoView = function () {
        if (!0 !== f(arguments[0])) {
          var l = function (o) {
              for (; o !== t.body && !1 === (e = p(l = o, "Y") && a(l, "Y"), r = p(l, "X") && a(l, "X"), e || r);) o = o.parentNode || o.host;
              var l, e, r;
              return o;
            }(this),
            e = l.getBoundingClientRect(),
            r = this.getBoundingClientRect();
          l !== t.body ? (h.call(this, l, l.scrollLeft + r.left - e.left, l.scrollTop + r.top - e.top), "fixed" !== o.getComputedStyle(l).position && o.scrollBy({
            left: e.left,
            top: e.top,
            behavior: "smooth"
          })) : o.scrollBy({
            left: r.left,
            top: r.top,
            behavior: "smooth"
          });
        } else i.scrollIntoView.call(this, void 0 === arguments[0] || arguments[0]);
      };
    }
    function n(o, t) {
      this.scrollLeft = o, this.scrollTop = t;
    }
    function f(o) {
      if (null === o || "object" != _typeof(o) || void 0 === o.behavior || "auto" === o.behavior || "instant" === o.behavior) return !0;
      if ("object" == _typeof(o) && "smooth" === o.behavior) return !1;
      throw new TypeError("behavior member of ScrollOptions " + o.behavior + " is not a valid value for enumeration ScrollBehavior.");
    }
    function p(o, t) {
      return "Y" === t ? o.clientHeight + c < o.scrollHeight : "X" === t ? o.clientWidth + c < o.scrollWidth : void 0;
    }
    function a(t, l) {
      var e = o.getComputedStyle(t, null)["overflow" + l];
      return "auto" === e || "scroll" === e;
    }
    function d(t) {
      var l,
        e,
        i,
        c,
        n = (s() - t.startTime) / r;
      c = n = n > 1 ? 1 : n, l = .5 * (1 - Math.cos(Math.PI * c)), e = t.startX + (t.x - t.startX) * l, i = t.startY + (t.y - t.startY) * l, t.method.call(t.scrollable, e, i), e === t.x && i === t.y || o.requestAnimationFrame(d.bind(o, t));
    }
    function h(l, e, r) {
      var c,
        f,
        p,
        a,
        h = s();
      l === t.body ? (c = o, f = o.scrollX || o.pageXOffset, p = o.scrollY || o.pageYOffset, a = i.scroll) : (c = l, f = l.scrollLeft, p = l.scrollTop, a = n), d({
        scrollable: c,
        method: a,
        startTime: h,
        startX: f,
        startY: p,
        x: e,
        y: r
      });
    }
  }
  "object" == ( false ? 0 : _typeof(exports)) && "undefined" != "object" ? module.exports = {
    polyfill: o
  } : o();
}();

/***/ }),

/***/ "./node_modules/slugify/slugify.js":
/*!*****************************************!*\
  !*** ./node_modules/slugify/slugify.js ***!
  \*****************************************/
/***/ (function(module) {


;(function (name, root, factory) {
  if (true) {
    module.exports = factory()
    module.exports["default"] = factory()
  }
  /* istanbul ignore next */
  else {}
}('slugify', this, function () {
  var charMap = JSON.parse('{"$":"dollar","%":"percent","&":"and","<":"less",">":"greater","|":"or","¢":"cent","£":"pound","¤":"currency","¥":"yen","©":"(c)","ª":"a","®":"(r)","º":"o","À":"A","Á":"A","Â":"A","Ã":"A","Ä":"A","Å":"A","Æ":"AE","Ç":"C","È":"E","É":"E","Ê":"E","Ë":"E","Ì":"I","Í":"I","Î":"I","Ï":"I","Ð":"D","Ñ":"N","Ò":"O","Ó":"O","Ô":"O","Õ":"O","Ö":"O","Ø":"O","Ù":"U","Ú":"U","Û":"U","Ü":"U","Ý":"Y","Þ":"TH","ß":"ss","à":"a","á":"a","â":"a","ã":"a","ä":"a","å":"a","æ":"ae","ç":"c","è":"e","é":"e","ê":"e","ë":"e","ì":"i","í":"i","î":"i","ï":"i","ð":"d","ñ":"n","ò":"o","ó":"o","ô":"o","õ":"o","ö":"o","ø":"o","ù":"u","ú":"u","û":"u","ü":"u","ý":"y","þ":"th","ÿ":"y","Ā":"A","ā":"a","Ă":"A","ă":"a","Ą":"A","ą":"a","Ć":"C","ć":"c","Č":"C","č":"c","Ď":"D","ď":"d","Đ":"DJ","đ":"dj","Ē":"E","ē":"e","Ė":"E","ė":"e","Ę":"e","ę":"e","Ě":"E","ě":"e","Ğ":"G","ğ":"g","Ģ":"G","ģ":"g","Ĩ":"I","ĩ":"i","Ī":"i","ī":"i","Į":"I","į":"i","İ":"I","ı":"i","Ķ":"k","ķ":"k","Ļ":"L","ļ":"l","Ľ":"L","ľ":"l","Ł":"L","ł":"l","Ń":"N","ń":"n","Ņ":"N","ņ":"n","Ň":"N","ň":"n","Ō":"O","ō":"o","Ő":"O","ő":"o","Œ":"OE","œ":"oe","Ŕ":"R","ŕ":"r","Ř":"R","ř":"r","Ś":"S","ś":"s","Ş":"S","ş":"s","Š":"S","š":"s","Ţ":"T","ţ":"t","Ť":"T","ť":"t","Ũ":"U","ũ":"u","Ū":"u","ū":"u","Ů":"U","ů":"u","Ű":"U","ű":"u","Ų":"U","ų":"u","Ŵ":"W","ŵ":"w","Ŷ":"Y","ŷ":"y","Ÿ":"Y","Ź":"Z","ź":"z","Ż":"Z","ż":"z","Ž":"Z","ž":"z","Ə":"E","ƒ":"f","Ơ":"O","ơ":"o","Ư":"U","ư":"u","ǈ":"LJ","ǉ":"lj","ǋ":"NJ","ǌ":"nj","Ș":"S","ș":"s","Ț":"T","ț":"t","ə":"e","˚":"o","Ά":"A","Έ":"E","Ή":"H","Ί":"I","Ό":"O","Ύ":"Y","Ώ":"W","ΐ":"i","Α":"A","Β":"B","Γ":"G","Δ":"D","Ε":"E","Ζ":"Z","Η":"H","Θ":"8","Ι":"I","Κ":"K","Λ":"L","Μ":"M","Ν":"N","Ξ":"3","Ο":"O","Π":"P","Ρ":"R","Σ":"S","Τ":"T","Υ":"Y","Φ":"F","Χ":"X","Ψ":"PS","Ω":"W","Ϊ":"I","Ϋ":"Y","ά":"a","έ":"e","ή":"h","ί":"i","ΰ":"y","α":"a","β":"b","γ":"g","δ":"d","ε":"e","ζ":"z","η":"h","θ":"8","ι":"i","κ":"k","λ":"l","μ":"m","ν":"n","ξ":"3","ο":"o","π":"p","ρ":"r","ς":"s","σ":"s","τ":"t","υ":"y","φ":"f","χ":"x","ψ":"ps","ω":"w","ϊ":"i","ϋ":"y","ό":"o","ύ":"y","ώ":"w","Ё":"Yo","Ђ":"DJ","Є":"Ye","І":"I","Ї":"Yi","Ј":"J","Љ":"LJ","Њ":"NJ","Ћ":"C","Џ":"DZ","А":"A","Б":"B","В":"V","Г":"G","Д":"D","Е":"E","Ж":"Zh","З":"Z","И":"I","Й":"J","К":"K","Л":"L","М":"M","Н":"N","О":"O","П":"P","Р":"R","С":"S","Т":"T","У":"U","Ф":"F","Х":"H","Ц":"C","Ч":"Ch","Ш":"Sh","Щ":"Sh","Ъ":"U","Ы":"Y","Ь":"","Э":"E","Ю":"Yu","Я":"Ya","а":"a","б":"b","в":"v","г":"g","д":"d","е":"e","ж":"zh","з":"z","и":"i","й":"j","к":"k","л":"l","м":"m","н":"n","о":"o","п":"p","р":"r","с":"s","т":"t","у":"u","ф":"f","х":"h","ц":"c","ч":"ch","ш":"sh","щ":"sh","ъ":"u","ы":"y","ь":"","э":"e","ю":"yu","я":"ya","ё":"yo","ђ":"dj","є":"ye","і":"i","ї":"yi","ј":"j","љ":"lj","њ":"nj","ћ":"c","ѝ":"u","џ":"dz","Ґ":"G","ґ":"g","Ғ":"GH","ғ":"gh","Қ":"KH","қ":"kh","Ң":"NG","ң":"ng","Ү":"UE","ү":"ue","Ұ":"U","ұ":"u","Һ":"H","һ":"h","Ә":"AE","ә":"ae","Ө":"OE","ө":"oe","Ա":"A","Բ":"B","Գ":"G","Դ":"D","Ե":"E","Զ":"Z","Է":"E\'","Ը":"Y\'","Թ":"T\'","Ժ":"JH","Ի":"I","Լ":"L","Խ":"X","Ծ":"C\'","Կ":"K","Հ":"H","Ձ":"D\'","Ղ":"GH","Ճ":"TW","Մ":"M","Յ":"Y","Ն":"N","Շ":"SH","Չ":"CH","Պ":"P","Ջ":"J","Ռ":"R\'","Ս":"S","Վ":"V","Տ":"T","Ր":"R","Ց":"C","Փ":"P\'","Ք":"Q\'","Օ":"O\'\'","Ֆ":"F","և":"EV","ء":"a","آ":"aa","أ":"a","ؤ":"u","إ":"i","ئ":"e","ا":"a","ب":"b","ة":"h","ت":"t","ث":"th","ج":"j","ح":"h","خ":"kh","د":"d","ذ":"th","ر":"r","ز":"z","س":"s","ش":"sh","ص":"s","ض":"dh","ط":"t","ظ":"z","ع":"a","غ":"gh","ف":"f","ق":"q","ك":"k","ل":"l","م":"m","ن":"n","ه":"h","و":"w","ى":"a","ي":"y","ً":"an","ٌ":"on","ٍ":"en","َ":"a","ُ":"u","ِ":"e","ْ":"","٠":"0","١":"1","٢":"2","٣":"3","٤":"4","٥":"5","٦":"6","٧":"7","٨":"8","٩":"9","پ":"p","چ":"ch","ژ":"zh","ک":"k","گ":"g","ی":"y","۰":"0","۱":"1","۲":"2","۳":"3","۴":"4","۵":"5","۶":"6","۷":"7","۸":"8","۹":"9","฿":"baht","ა":"a","ბ":"b","გ":"g","დ":"d","ე":"e","ვ":"v","ზ":"z","თ":"t","ი":"i","კ":"k","ლ":"l","მ":"m","ნ":"n","ო":"o","პ":"p","ჟ":"zh","რ":"r","ს":"s","ტ":"t","უ":"u","ფ":"f","ქ":"k","ღ":"gh","ყ":"q","შ":"sh","ჩ":"ch","ც":"ts","ძ":"dz","წ":"ts","ჭ":"ch","ხ":"kh","ჯ":"j","ჰ":"h","Ṣ":"S","ṣ":"s","Ẁ":"W","ẁ":"w","Ẃ":"W","ẃ":"w","Ẅ":"W","ẅ":"w","ẞ":"SS","Ạ":"A","ạ":"a","Ả":"A","ả":"a","Ấ":"A","ấ":"a","Ầ":"A","ầ":"a","Ẩ":"A","ẩ":"a","Ẫ":"A","ẫ":"a","Ậ":"A","ậ":"a","Ắ":"A","ắ":"a","Ằ":"A","ằ":"a","Ẳ":"A","ẳ":"a","Ẵ":"A","ẵ":"a","Ặ":"A","ặ":"a","Ẹ":"E","ẹ":"e","Ẻ":"E","ẻ":"e","Ẽ":"E","ẽ":"e","Ế":"E","ế":"e","Ề":"E","ề":"e","Ể":"E","ể":"e","Ễ":"E","ễ":"e","Ệ":"E","ệ":"e","Ỉ":"I","ỉ":"i","Ị":"I","ị":"i","Ọ":"O","ọ":"o","Ỏ":"O","ỏ":"o","Ố":"O","ố":"o","Ồ":"O","ồ":"o","Ổ":"O","ổ":"o","Ỗ":"O","ỗ":"o","Ộ":"O","ộ":"o","Ớ":"O","ớ":"o","Ờ":"O","ờ":"o","Ở":"O","ở":"o","Ỡ":"O","ỡ":"o","Ợ":"O","ợ":"o","Ụ":"U","ụ":"u","Ủ":"U","ủ":"u","Ứ":"U","ứ":"u","Ừ":"U","ừ":"u","Ử":"U","ử":"u","Ữ":"U","ữ":"u","Ự":"U","ự":"u","Ỳ":"Y","ỳ":"y","Ỵ":"Y","ỵ":"y","Ỷ":"Y","ỷ":"y","Ỹ":"Y","ỹ":"y","–":"-","‘":"\'","’":"\'","“":"\\\"","”":"\\\"","„":"\\\"","†":"+","•":"*","…":"...","₠":"ecu","₢":"cruzeiro","₣":"french franc","₤":"lira","₥":"mill","₦":"naira","₧":"peseta","₨":"rupee","₩":"won","₪":"new shequel","₫":"dong","€":"euro","₭":"kip","₮":"tugrik","₯":"drachma","₰":"penny","₱":"peso","₲":"guarani","₳":"austral","₴":"hryvnia","₵":"cedi","₸":"kazakhstani tenge","₹":"indian rupee","₺":"turkish lira","₽":"russian ruble","₿":"bitcoin","℠":"sm","™":"tm","∂":"d","∆":"delta","∑":"sum","∞":"infinity","♥":"love","元":"yuan","円":"yen","﷼":"rial","ﻵ":"laa","ﻷ":"laa","ﻹ":"lai","ﻻ":"la"}')
  var locales = JSON.parse('{"bg":{"Й":"Y","Ц":"Ts","Щ":"Sht","Ъ":"A","Ь":"Y","й":"y","ц":"ts","щ":"sht","ъ":"a","ь":"y"},"de":{"Ä":"AE","ä":"ae","Ö":"OE","ö":"oe","Ü":"UE","ü":"ue","ß":"ss","%":"prozent","&":"und","|":"oder","∑":"summe","∞":"unendlich","♥":"liebe"},"es":{"%":"por ciento","&":"y","<":"menor que",">":"mayor que","|":"o","¢":"centavos","£":"libras","¤":"moneda","₣":"francos","∑":"suma","∞":"infinito","♥":"amor"},"fr":{"%":"pourcent","&":"et","<":"plus petit",">":"plus grand","|":"ou","¢":"centime","£":"livre","¤":"devise","₣":"franc","∑":"somme","∞":"infini","♥":"amour"},"pt":{"%":"porcento","&":"e","<":"menor",">":"maior","|":"ou","¢":"centavo","∑":"soma","£":"libra","∞":"infinito","♥":"amor"},"uk":{"И":"Y","и":"y","Й":"Y","й":"y","Ц":"Ts","ц":"ts","Х":"Kh","х":"kh","Щ":"Shch","щ":"shch","Г":"H","г":"h"},"vi":{"Đ":"D","đ":"d"},"da":{"Ø":"OE","ø":"oe","Å":"AA","å":"aa","%":"procent","&":"og","|":"eller","$":"dollar","<":"mindre end",">":"større end"},"nb":{"&":"og","Å":"AA","Æ":"AE","Ø":"OE","å":"aa","æ":"ae","ø":"oe"},"it":{"&":"e"},"nl":{"&":"en"},"sv":{"&":"och","Å":"AA","Ä":"AE","Ö":"OE","å":"aa","ä":"ae","ö":"oe"}}')

  function replace (string, options) {
    if (typeof string !== 'string') {
      throw new Error('slugify: string argument expected')
    }

    options = (typeof options === 'string')
      ? {replacement: options}
      : options || {}

    var locale = locales[options.locale] || {}

    var replacement = options.replacement === undefined ? '-' : options.replacement

    var trim = options.trim === undefined ? true : options.trim

    var slug = string.normalize().split('')
      // replace characters based on charMap
      .reduce(function (result, ch) {
        var appendChar = locale[ch];
        if (appendChar === undefined) appendChar = charMap[ch];
        if (appendChar === undefined) appendChar = ch;
        if (appendChar === replacement) appendChar = ' ';
        return result + appendChar
          // remove not allowed characters
          .replace(options.remove || /[^\w\s$*_+~.()'"!\-:@]+/g, '')
      }, '');

    if (options.strict) {
      slug = slug.replace(/[^A-Za-z0-9\s]/g, '');
    }

    if (trim) {
      slug = slug.trim()
    }

    // Replace spaces with replacement character, treating multiple consecutive
    // spaces as a single space.
    slug = slug.replace(/\s+/g, replacement);

    if (options.lower) {
      slug = slug.toLowerCase()
    }

    return slug
  }

  replace.extend = function (customMap) {
    Object.assign(charMap, customMap)
  }

  return replace
}))


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _menu__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./menu */ "./resources/js/menu.js");
/* harmony import */ var _smoothscroll_min_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./smoothscroll.min.js */ "./resources/js/smoothscroll.min.js");
/* harmony import */ var _smoothscroll_min_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_smoothscroll_min_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _floorselector__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./floorselector */ "./resources/js/floorselector.js");


// import InlineSvg from './inline-svg';

_smoothscroll_min_js__WEBPACK_IMPORTED_MODULE_1___default().polyfill();
function App() {
  window.scrollTo(0, 0);
  function addListener(selector, event, callback) {
    var elements = document.querySelectorAll(selector);
    for (var i = 0; i < elements.length; i++) {
      elements[i].addEventListener(event, callback);
    }
  }
  function generateAutoAnchors() {
    var slugify = __webpack_require__(/*! slugify */ "./node_modules/slugify/slugify.js");
    var containers = document.querySelectorAll('.js-autoanchors');
    containers.forEach(function (container) {
      var prefix = '';
      if (container.dataset.anchorPrefix) {
        prefix = container.dataset.anchorPrefix + '-';
      }
      var headings = container.querySelectorAll('h1,h2,h3,h4,h5,h6');
      headings.forEach(function (heading) {
        var anchor = prefix + slugify(heading.innerText);
        anchor = anchor.toLowerCase();
        heading.id = anchor;
      });
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

    window.addEventListener('keydown', function (ev) {
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
    var menuHandler = new _menu__WEBPACK_IMPORTED_MODULE_0__["default"](menuElements);
    menuToggles.forEach(function (toggle) {
      menuHandler.addToggle(toggle);
    });
    var floorSelectorElement = document.querySelector('.js-floors');
    if (floorSelectorElement) {
      var selector = new _floorselector__WEBPACK_IMPORTED_MODULE_2__["default"]();
      selector.setVisualBlock(floorSelectorElement);
    }
    var contactForms = document.querySelectorAll('.js-contactform form');
    contactForms.forEach(function (form) {
      form.addEventListener('submit', onContactFormSubmit);
    });
    generateAutoAnchors();
  }
  function onContactFormSubmit(ev) {
    ev.preventDefault();
    var form = ev.target;
    var successDiv = form.querySelector('.message.success');
    var userErrorDiv = form.querySelector('.message.error.user');
    var serverErrorDiv = form.querySelector('.message.error.server');
    var data = new FormData();
    ['name', 'email', 'message', '_token'].forEach(function (field) {
      var element = form.querySelector('[name="' + field + '"]');
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
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 400) {
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
  function onLoad() {}
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
}();
/******/ })()
;