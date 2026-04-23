(()=>{"use strict";var t={};/************************************************************************/// The module cache
var e={};// The require function
function r(o){// Check if module is in cache
var a=e[o];if(a!==undefined){return a.exports}// Create a new module (and put it into the cache)
var n=e[o]={exports:{}};// Execute the module function
t[o](n,n.exports,r);// Return the exports of the module
return n.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{r.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{r.ruid="bundler=rspack@1.5.7"})();/************************************************************************/;// CONCATENATED MODULE: ./node_modules/@swc/helpers/esm/_async_to_generator.js
function o(t,e,r,o,a,n,i){try{var s=t[n](i);var u=s.value}catch(t){r(t);return}if(s.done)e(u);else Promise.resolve(u).then(o,a)}function a(t){return function(){var e=this,r=arguments;return new Promise(function(a,n){var i=t.apply(e,r);function s(t){o(i,a,n,s,u,"next",t)}function u(t){o(i,a,n,s,u,"throw",t)}s(undefined)})}};// CONCATENATED MODULE: ./assets/react/lib/ajax-handler.js
function n(t){return a(function*(){try{var e=yield fetch(window._tutorobject.ajaxurl,{method:"POST",body:t});return e}catch(t){tutor_toast(__("Operation failed","tutor-pro"),t,"error")}})()};// CONCATENATED MODULE: ./addons/google-meet/assets/react/scripts.js
/**
 * Google meet scripts for create, update & delete meetings
 * 
 * @since v2.1.0
 */window.jQuery(document).ready(function(t){var{__,sprintf:e}=wp.i18n;// Listen click event on meta-box
var r=document.getElementById("tutor-google-meet-meta-box-wrapper");var o=document.getElementById("tutor-common-confirmation-modal");var i=__("Something went wrong, please refresh the page & try again!","tutor-pro");var s=document.getElementById("tutor-course-content-builder-root");var u="tutor-gm-create-new-meeting";var l="tutor-gm-update-meeting";/**
     * Listen edit/delete event & act accordingly
     */if(r){r.onclick=t=>{var e=t.target;// Handle delete event.
if(e.classList.contains("tutor-google-meet-list-delete")){t.preventDefault();c(e)}/**
             * On the frontend meeting inside tutor-google-meet-list-delete class
             * there is icon and span tag. So if clicked on icon or span 
             * set target to delete.
             */if(e.classList.contains("tutor-gm-delete")){t.preventDefault();e=e.closest("a.tutor-google-meet-list-delete");c(e)}// Handle create
if(e.classList.contains(u)||e.classList.contains(l)){t.preventDefault();try{v(e)}catch(t){tutor_toast(__("Failed","tutor-pro"),i,"warning")}}if(e.hasAttribute("type")&&e.getAttribute("type")==="checkbox"){if(e.hasAttribute("checked")){e.removeAttribute("checked")}else{e.setAttribute("checked","checked")}}return};// Handle attendees checkbox
t(document.body).on("change",'#tutor-google-meet-meta-box-wrapper input[type="checkbox"]',function(){if(t(this).is(":checked")){t(this).closest(".tutor-modal").find("input[name=attendees]").val("Yes")}else{t(this).closest(".tutor-modal").find("input[name=attendees]").val("No")}})}// Prepare topics event to delete.
if(s){s.onclick=t=>{var e=t.target;// Handle delete event.
if(e.classList.contains("tutor-google-meet-list-delete")){t.preventDefault();c(e)}// Handle create/update.
if(e.classList.contains(u)||e.classList.contains(l)){t.preventDefault();try{v(e)}catch(t){tutor_toast(__("Failed","tutor-pro"),i,"warning")}}return};// Handle attendees checkbox
t(document.body).on("change",'#tutor-course-content-builder-root input[type="checkbox"]',function(){if(t(this).is(":checked")){t(this).closest(".tutor-modal").find("input[name=attendees]").val("Yes")}else{t(this).closest(".tutor-modal").find("input[name=attendees]").val("No")}})}function c(t){var e=t.dataset.eventId;var r=t.dataset.meetingPostId;var a=t.dataset.itemReference;o.querySelector("[name=id]").value=r;o.querySelector("[name=event-id]").value=e;o.querySelector("[name=item-reference]").value=a}/**
     * Handle meeting delete event
     */if(o){var d=o.querySelector("button[data-tutor-modal-submit]");d.onclick=e=>a(function*(){e.preventDefault();var r=e.target;var a=new FormData;var i=o.querySelector("[name=item-reference]").value;a.set("event-id",o.querySelector("[name=event-id]").value);a.set("post-id",o.querySelector("[name=id]").value);a.set("action","tutor_google_meet_delete");a.set(window.tutor_get_nonce_data(true).key,window.tutor_get_nonce_data(true).value);r.setAttribute("disabled",true);r.classList.add("is-loading");var s=yield n(a);if(s.ok){var u=yield s.json();if(u.status_code===200||u.status_code===201){tutor_toast(__("Success","tutor-pro"),u.message,"success");if(_tutorobject.current_page==="google-meet"){window.location.reload();return}}else{tutor_toast(__("Failed","tutor-pro"),u.message,"warning")}r.classList.remove("is-loading");r.removeAttribute("disabled");o.classList.remove("tutor-is-active");t("body").removeClass("tutor-modal-open");window.dispatchEvent(new Event(_tutorobject.content_change_event))}else{tutor_toast(__("Error","tutor-pro"),__("Something went wrong, please try after refreshing page","tutor-pro"),"error");r.classList.remove("is-loading");r.removeAttribute("disabled")}})()}/**
     * Manage AJAX request for meeting create or update
     * 
     * @param {*} wrapper selector, where form fields exists, all
     * form fields having name will be  selected.
     * 
     * @param {*} additionalFields  additional fields, array of objects. If need to set
     * additional fields in form data. 
     * @returns void
     */function v(r){return a(function*(r){var o=arguments.length>1&&arguments[1]!==void 0?arguments[1]:[];var a=r.closest(".tutor-modal");var i=a.getAttribute("id");var s=a.querySelectorAll("[name]");var u=new FormData;var l=[];s.forEach(t=>{// Exclude attendees from validation.
if(t.value===""&&t.name!=="attendees"){/* Translators: %s template name. */l.push(e(__("%s is required","tutor-pro"),t.name))}// Fallback if attendees value not set.
if(t.name==="attendees"){u.set(t.name,t.value===""?"Yes":t.value)}else{u.set(t.name,t.value)}});u.set("action","tutor_google_meet_new_meeting");// Set additional fields.
o.forEach(t=>{u.set(t.name,t.value)});r.classList.add("is-loading");r.setAttribute("disabled",true);// Validate request before post.
if(l.length){l.forEach(t=>{tutor_toast(__("Validation Error","tutor-pro"),m(t.replace(/_/g," ")),"warning")});r.removeAttribute("disabled");r.classList.remove("is-loading");return}var c=yield n(u);if(c.ok){var d=yield c.json();if(d.status_code===200||d.status_code===201){// If it is create form then reset after successful submit.
if(i==="tutor-google-meet-create-modal"||a.classList.contains("tutor-gm-topic-create-modal")){// Show success message.
tutor_toast(__("Success","tutor-pro"),d.message,"success")}else{// Show success message.
tutor_toast(__("Success","tutor-pro"),d.message,"success");// Reload if it is listing page.
if(_tutorobject.current_page==="google-meet"){window.location.reload();return}}a.classList.remove("tutor-is-active");// Close the meeting editor modal
t("body").removeClass("tutor-modal-open");window.dispatchEvent(new Event(_tutorobject.content_change_event))}else{tutor_toast(__("Failed","tutor-pro"),d.message,"warning")}}else{tutor_toast(__("Failed","tutor-pro"),__("Something went wrong, please try again!","tutor-pro"),"warning")}r.classList.remove("is-loading");r.removeAttribute("disabled")}).apply(this,arguments)}/**
     * Upper case the fist letter from string
     * 
     * @param string text 
     * @returns string
     */function m(t){var e=t.substr(0,1);return e.toUpperCase()+t.substr(1)}function g(e,r){var o=e.getBoundingClientRect();// use 'setTimeout' to prevent effect overridden by other scripts
setTimeout(function(){var a=t("body").scrollTop();r.dpDiv.css({top:o.top+e.offsetHeight+a})},0)}// Init timepicker
function f(){t(".tutor-google-meet-timepicker").timepicker({timeFormat:"hh:mm TT",beforeShow:function t(t,e){g(t,e)}})}function _(){// Reassign date and timepicker.
t(".tutor-google-meet-timepicker").timepicker({timeFormat:"hh:mm TT",beforeShow:function t(t,e){g(t,e)}})}f();window.addEventListener(_tutorobject.content_change_event,f);/**
     * Drag and Drop files -> Upload JSON (SET API)
     */var p=document.querySelectorAll(".tutor-google-meet-credential-form .drag-drop-zone input[type=file]");if(p.length>0){p.forEach(t=>{var e=t.closest(".drag-drop-zone");["dragover","dragleave","dragend"].forEach(t=>{if(t==="dragover"){e.addEventListener(t,t=>{t.preventDefault();e.classList.add("dragover")})}else{e.addEventListener(t,t=>{e.classList.remove("dragover")})}});e.addEventListener("drop",r=>{r.preventDefault();var o=r.dataTransfer.files;h(o,t,e);e.classList.remove("dragover")});t.addEventListener("change",r=>{var o=r.target.files;h(o,t,e)})})}// Show file info
var h=(t,e,r)=>{if(t.length){e.files=t;r.classList.add("file-attached");r.querySelector(".file-info").innerHTML="<strong>File attached</strong> - ".concat(t[0].name)}else{r.classList.remove("file-attached");r.querySelector(".file-info").innerHTML=""}};// Handle credential upload.
var y=document.getElementById("tutor-google-meet-credential-upload");var w=document.getElementById("tutor-google-meet-choose-label");var b=document.querySelector(".tutor-google-meet-credential-form .drag-drop-zone");if(w){w.onclick=t=>{y.click()}}if(y){y.onchange=t=>{var e=t.target.files[0];L(e)}}if(b){b.addEventListener("drop",t=>{t.preventDefault();var e=t.dataTransfer.files[0];L(e)})}function L(t){return a(function*(){var e=new FormData;var r=document.querySelector(".file-info");e.set("file",t);e.set("action","tutor_pro_google_meet_credential_upload");e.set(window.tutor_get_nonce_data(true).key,window.tutor_get_nonce_data(true).value);try{if(t.type==="application/json"){w.classList.add("is-loading");var o=yield n(e);if(o.ok){var a=yield o.json();if(a.success){tutor_toast(__("Success","tutor-pro"),a.data,"success");window.location.reload()}else{tutor_toast(__("Error","tutor-pro"),a.data,"warning")}w.classList.remove("is-loading")}}else{w.classList.remove("is-loading");tutor_toast(__("Error","tutor-pro"),__("Invalid file type!","tutor-pro"),"warning");y.value="";if(r){r.innerHTML=""}}}catch(t){tutor_toast(__("Error","tutor-pro"),__("Something went wrong, please try again!","tutor-pro"),"warning")}})()}// Handle settings event.
var E=document.getElementById("tutor-google-meet-settings");if(E){E.onchange=t=>a(function*(){var e=false;var r=t.target;// If search then return.
    if(r.hasAttribute("type")&&r.getAttribute("type")==="search"){return}// Check if user selecting same timezone.
    if(r.hasAttribute("data-value")){e=true;var o=t.target.dataset.value;var a=r.value;if(o===a){return}}var s=new FormData(E);try{var u=yield n(s);if(u.ok){var l=yield u.json();if(l.success){tutor_toast(__("Success","tutor-pro"),l.data,"success");if(e){r.setAttribute("data-value",r.value)}}else{tutor_toast(__("Failed","tutor-pro"),l.data,"error")}}else{tutor_toast(__("Error","tutor-pro"),__(u.statusText),"error")}}catch(t){tutor_toast(__("Error","tutor-pro"),i,"error")}})()}var S=document.getElementById("tutor-meet-confirmation-form");if(S){S.onsubmit=t=>a(function*(){t.preventDefault();var e=new FormData(S);var r=S.querySelector("[data-tutor-modal-submit]");r.classList.add("is-loading");r.setAttribute("disabled",true);try{var o=yield n(e);var a=yield o.json();var{success:i,data:s}=a;if(i){tutor_toast(__("Success","tutor-pro"),s,"success");location.reload()}else{tutor_toast(__("Failed","tutor-pro"),s,"error")}}catch(t){tutor_toast(__("Failed","tutor-pro"),__("Something went wrong, please try again","tutor-pro"),"error")}finally{r.classList.remove("is-loading");r.removeAttribute("disabled")}})()}})})();