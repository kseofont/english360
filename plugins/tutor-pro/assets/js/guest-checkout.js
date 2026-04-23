(()=>{"use strict";var t={};/************************************************************************/// The module cache
var r={};// The require function
function e(o){// Check if module is in cache
var n=r[o];if(n!==undefined){return n.exports}// Create a new module (and put it into the cache)
var a=r[o]={exports:{}};// Execute the module function
t[o](a,a.exports,e);// Return the exports of the module
return a.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{e.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{e.ruid="bundler=rspack@1.5.7"})();/************************************************************************/;// CONCATENATED MODULE: ./node_modules/@swc/helpers/esm/_async_to_generator.js
function o(t,r,e,o,n,a,u){try{var i=t[a](u);var c=i.value}catch(t){e(t);return}if(i.done)r(c);else Promise.resolve(c).then(o,n)}function n(t){return function(){var r=this,e=arguments;return new Promise(function(n,a){var u=t.apply(r,e);function i(t){o(u,n,a,i,c,"next",t)}function c(t){o(u,n,a,i,c,"throw",t)}i(undefined)})}};// CONCATENATED MODULE: ./assets/lib/tutor-formdata.js
/**
 * Creates FormData object from array of data objects
 * @deprecated This function is deprecated and will be removed in a future version
 * @param {Array} data - Array of objects to convert to FormData
 * @returns {FormData} FormData object with nonce data included
 */function a(){var t=arguments.length>0&&arguments[0]!==void 0?arguments[0]:[];var r=new FormData;t.forEach(t=>{for(var[e,o]of Object.entries(t)){r.set(e,o)}});r.set(window.tutor_get_nonce_data(true).key,window.tutor_get_nonce_data(true).value);return r}/* ESM default export */const u=a;// CONCATENATED MODULE: ./assets/react/lib/ajax-handler.js
function i(t){return n(function*(){try{var r=yield fetch(window._tutorobject.ajaxurl,{method:"POST",body:t});return r}catch(t){tutor_toast(__("Operation failed","tutor-pro"),t,"error")}})()};// CONCATENATED MODULE: ./assets/react/guest-checkout.js
/**
 * Scripts for handling guest checkout
 *
 * @since 3.3.0
 */document.addEventListener("DOMContentLoaded",()=>{var{__}=wp.i18n;document.addEventListener("click",t=>n(function*(){var r=t.target.closest(".tutor-add-to-guest-cart");if(r){var e=r.dataset.courseId;if(e){var o=u([{action:"tutor_guest_add_course_to_cart",course_id:e}]);var n=document.body.classList.contains("single-courses")||document.body.classList.contains("single-course-bundle");try{r.setAttribute("disabled","disabled");r.classList.add("is-loading");var a=yield i(o);var{status_code:c,data:s,message:d=defaultErrorMessage}=yield a.json();if(c===201){tutor_toast(__("Success","tutor-pro"),d,"success");var l;var v='<a href="'.concat((l=s===null||s===void 0?void 0:s.cart_page_url)!==null&&l!==void 0?l:"#",'" class="tutor-btn tutor-btn-outline-primary ').concat(n?"tutor-btn-lg tutor-btn-block":"tutor-btn-md"," ").concat(!(s===null||s===void 0?void 0:s.cart_page_url)?"tutor-cart-page-not-configured":"",'">').concat(__("View Cart","tutor-pro"),"</a>");r.parentElement.innerHTML=v;// Dispatch the custom cart event
    var _=new CustomEvent("tutorAddToCartEvent",{detail:{cart_count:s===null||s===void 0?void 0:s.cart_count}});document.dispatchEvent(_)}else{tutor_toast(__("Failed","tutor-pro"),d,"error")}}catch(t){tutor_toast(__("Failed","tutor-pro"),defaultErrorMessage,"error")}finally{r.removeAttribute("disabled");r.classList.remove("is-loading")}}}})());// Hide tax amount if billing country not selected.
var t=document.querySelector("select[name=billing_country]");var r=document.querySelector("div[data-tax-amount]");if(r&&t&&!t.value){r.style.display="none"}})})();