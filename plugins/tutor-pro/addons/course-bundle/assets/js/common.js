(()=>{"use strict";var t={};/************************************************************************/// The module cache
var r={};// The require function
function e(n){// Check if module is in cache
var o=r[n];if(o!==undefined){return o.exports}// Create a new module (and put it into the cache)
var a=r[n]={exports:{}};// Execute the module function
t[n](a,a.exports,e);// Return the exports of the module
return a.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{e.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{e.ruid="bundler=rspack@1.5.7"})();/************************************************************************/;// CONCATENATED MODULE: ./node_modules/@swc/helpers/esm/_async_to_generator.js
function n(t,r,e,n,o,a,i){try{var u=t[a](i);var d=u.value}catch(t){e(t);return}if(u.done)r(d);else Promise.resolve(d).then(n,o)}function o(t){return function(){var r=this,e=arguments;return new Promise(function(o,a){var i=t.apply(r,e);function u(t){n(i,o,a,u,d,"next",t)}function d(t){n(i,o,a,u,d,"throw",t)}u(undefined)})}};// CONCATENATED MODULE: ./assets/lib/tutor-formdata.js
/**
 * Creates FormData object from array of data objects
 * @deprecated This function is deprecated and will be removed in a future version
 * @param {Array} data - Array of objects to convert to FormData
 * @returns {FormData} FormData object with nonce data included
 */function a(){var t=arguments.length>0&&arguments[0]!==void 0?arguments[0]:[];var r=new FormData;t.forEach(t=>{for(var[e,n]of Object.entries(t)){r.set(e,n)}});r.set(window.tutor_get_nonce_data(true).key,window.tutor_get_nonce_data(true).value);return r}/* ESM default export */const i=a;// CONCATENATED MODULE: ./assets/react/lib/ajax-handler.js
function u(t){return o(function*(){try{var r=yield fetch(window._tutorobject.ajaxurl,{method:"POST",body:t});return r}catch(t){tutor_toast(__("Operation failed","tutor-pro"),t,"error")}})()};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/common.js
/**
 * Course bundle builder
 *
 * @since 2.2.0
 */document.addEventListener("DOMContentLoaded",function(){return o(function*(){var{__}=wp.i18n;var t=__("Something went wrong, please try again after refreshing page","tutor-pro");/** 
    * Create new draft course bundle
    * 
    * @since 3.2.0
    */var r=document.querySelectorAll("a.tutor-add-new-course-bundle,li.tutor-add-new-course-bundle a");if(r){r.forEach(r=>{r.addEventListener("click",function(e){return o(function*(){e.preventDefault();var n=document.querySelector("body.tutor-frontend");var o=[{action:"tutor_create_course_bundle",source:n?"frontend":"backend"}];var a=i(o);try{if(e.target.classList.contains("ab-item")){e.target.innerHTML="Creating..."}r.classList.add("is-loading");r.setAttribute("disabled","disabled");var d=yield u(a);var c=yield d.json();if(c.status_code===200){window.location.href=c.data}else{tutor_toast(__("Failed","tutor-pro"),c.message||__("Bundle creation failed","tutor-pro"),"error")}}catch(r){tutor_toast(__("Failed","tutor-pro"),t,"error")}finally{r.classList.remove("is-loading");r.removeAttribute("disabled")}})()})})}})()})})();