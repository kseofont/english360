(()=>{"use strict";var r={};/************************************************************************/// The module cache
var t={};// The require function
function n(e){// Check if module is in cache
var o=t[e];if(o!==undefined){return o.exports}// Create a new module (and put it into the cache)
var u=t[e]={exports:{}};// Execute the module function
r[e](u,u.exports,n);// Return the exports of the module
return u.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{n.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{n.ruid="bundler=rspack@1.5.7"})();/************************************************************************/;// CONCATENATED MODULE: ./node_modules/@swc/helpers/esm/_async_to_generator.js
function e(r,t,n,e,o,u,i){try{var a=r[u](i);var c=a.value}catch(r){n(r);return}if(a.done)t(c);else Promise.resolve(c).then(e,o)}function o(r){return function(){var t=this,n=arguments;return new Promise(function(o,u){var i=r.apply(t,n);function a(r){e(i,o,u,a,c,"next",r)}function c(r){e(i,o,u,a,c,"throw",r)}a(undefined)})}};// CONCATENATED MODULE: ./addons/tutor-assignments/assets/react/assignment.js
window.jQuery(document).ready(function(r){var{__,_x:t,_n:n,_nx:e}=wp.i18n;/**
     * Delete assignment
     */// This code is not necessary. We have unified ajax action request handler already. 
/* const deleteAssignment = document.querySelectorAll( ".delete-single-assignment" );
     for ( let assignment of deleteAssignment ) {
         if ( assignment ) {
            assignment.onclick = async(e) => {
                const id = e.currentTarget.dataset.id;
                const formData = new FormData();
                formData.set( window.tutor_get_nonce_data( true ).key, window.tutor_get_nonce_data( true ).value );
                formData.set( 'assignment_id', id )
                formData.set( 'action', 'delete_tutor_course_assignment_submission' );
                const post = await ajaxHandler( formData );
                const response = await post.json();
                if ( true === response.success ) {
                    tutor_toast( __( 'Success!', 'tutor-pro' ), response.data.message, 'success', false );
                    e.target.closest( 'tr' ).remove();
                } else {
                    tutor_toast( __( 'Failed!', 'tutor-pro' ), response.data.message, 'error', false );
                }
            }
        }
    } *//**
     * Handle ajax request show toast message on success | failure
     *
     * @param {*} formData including action and all form fields
     */function u(r){return o(function*(){try{var t=yield fetch(window._tutorobject.ajaxurl,{method:"POST",body:r});return t}catch(r){tutor_toast(__("Operation failed","tutor-pro"),r,"error")}})()}})})();