(()=>{"use strict";var t={};/************************************************************************/// The module cache
var e={};// The require function
function o(r){// Check if module is in cache
var a=e[r];if(a!==undefined){return a.exports}// Create a new module (and put it into the cache)
var n=e[r]={exports:{}};// Execute the module function
t[r](n,n.exports,o);// Return the exports of the module
return n.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{o.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{o.ruid="bundler=rspack@1.5.7"})();/************************************************************************/;// CONCATENATED MODULE: ./node_modules/@swc/helpers/esm/_async_to_generator.js
function r(t,e,o,r,a,n,i){try{var c=t[n](i);var s=c.value}catch(t){o(t);return}if(c.done)e(s);else Promise.resolve(s).then(r,a)}function a(t){return function(){var e=this,o=arguments;return new Promise(function(a,n){var i=t.apply(e,o);function c(t){r(i,a,n,c,s,"next",t)}function s(t){r(i,a,n,c,s,"throw",t)}c(undefined)})}};// CONCATENATED MODULE: ./assets/react/lib/ajax-handler.js
function n(t){return a(function*(){try{var e=yield fetch(window._tutorobject.ajaxurl,{method:"POST",body:t});return e}catch(t){tutor_toast(__("Operation failed","tutor-pro"),t,"error")}})()};// CONCATENATED MODULE: ./addons/tutor-report/assets/react/report.js
jQuery(document).ready(function(t){"use strict";var{__,_x:e,_n:o,_nx:r}=wp.i18n;var i=document.getElementById("tutor-common-confirmation-modal");var c=document.getElementById("tutor-common-confirmation-form");t(document).on("click",".tutor-quiz-attempt-delete-btn",function(e){e.preventDefault();var o=t(this);t.ajax({url:ajaxurl,type:"POST",data:{attempt_id:o.attr("data-attempt-id"),action:"treport_quiz_atttempt_delete"},beforeSend:function t(){o.addClass("updating-message")},success:function t(t){if(t.success){o.closest("tr").remove()}},complete:function t(){o.removeClass("updating-message")}})});/**
   * Datepicker initiate
   */function s(t,e){var o=new URL(window.location.href);var r=o.searchParams;r.set(t,e);o.search=r.toString();r.set("paged",1);o.search=r.toString();return o.toString()}t(".tutor-report-category").on("change",function(e){window.location=s("cat",t(this).val())});t(".tutor-report-sort").on("change",function(e){window.location=s("order",t(this).val())});t(".tutor-report-date").on("change",function(e){window.location=s("date",t(this).val())});t(document).on("click",".tutor-report-search-btn",function(e){window.location=s("search",t(".tutor-report-search").val())});t(document).on("click",".tutor-report-search-action",function(e){e.preventDefault();window.location=s("search",t(".tutor-report-search").val())});t(document).on("click",".details-link",function(e){e.preventDefault();if(t(this).hasClass("active")){t(this).removeClass("active")}else{t(this).addClass("active")}var o=t("#table-toggle-"+t(this).data("count"));if(o.hasClass("open")){o.removeClass("open")}else{o.addClass("open")}});/**
   * Delete recent reviews
   * 
   * @since v.2.0.0
   */var u=document.querySelectorAll(".tutor-delete-recent-reviews");var l=document.getElementById("tutor-admin-reviews-table");for(var d of u){if(d){d.onclick=t=>a(function*(){var e=t.currentTarget.dataset.id;if(c){c.elements.action.value="tutor_delete_review";c.elements.id.value=e}})()}}/**
   * Handle common confirmation form
   * review delete
   * 
   * @since v.2.0.0
   */if(c){c.onsubmit=t=>a(function*(){t.preventDefault();var e=new FormData(c);//show loading
    var o=c.querySelector("[data-tutor-modal-submit]");o.classList.add("is-loading");var r=yield n(e);//hide modal
    if(i.classList.contains("tutor-is-active")){i.classList.remove("tutor-is-active");document.body.classList.remove("tutor-modal-open")}if(r.ok){var a=yield r.json();if(a){if(l&&e.get("action")=="tutor_delete_review"){tutor_toast(__("Delete","tutor-pro"),__("Review has been deleted ","tutor-pro"),"success");// if there is less row then reload to avoid empty state related issue
    if(l.rows.length<3){location.reload()}else{// find row that need to remove
    var s=l.querySelector('a[data-id="'.concat(e.get("id"),'"]'));if(s){s.closest("tr").remove()}}}else{location.reload()}}else{tutor_toast(__("Failed","tutor-pro"),__("Review delete failed ","tutor-pro"),"error")}}else{tutor_toast(__("Failed","tutor-pro"),__("Review delete failed ","tutor-pro"),"error")}})()}})})();