(()=>{var t={};/************************************************************************/// The module cache
var e={};// The require function
function n(i){// Check if module is in cache
var a=e[i];if(a!==undefined){return a.exports}// Create a new module (and put it into the cache)
var o=e[i]={exports:{}};// Execute the module function
t[i](o,o.exports,n);// Return the exports of the module
return o.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{n.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{n.ruid="bundler=rspack@1.5.7"})();/************************************************************************/window.jQuery(document).ready(function(t){var{__}=window.wp.i18n;// Check if all the h5p question are answered
t("button[name='quiz_answer_submit_btn']").on("click",()=>{var e=[];var n=false;var i=t("button[name='quiz_answer_submit_btn']");var a=document.querySelectorAll("[data-h5p-quiz-content-id]");if(a&&a.length>0){a.forEach(n=>{var i=parseInt(t(n).attr("id").match(/\d+/)[0],10);var a=parseInt(t(n).data("h5p-quiz-content-id"),10);e.push({"question_id":i,"content_id":a})})}t.ajax({url:_tutorobject.ajaxurl,type:"POST",async:false,data:{action:"check_h5p_question_answered",question_ids:JSON.stringify(e),attempt_id:parseInt(t("input[name='attempt_id']").val(),10),quiz_id:parseInt(t("#tutor_quiz_id").val(),10)},beforeSend:function t(){i.addClass("is-loading").attr("disabled",true)},success:function e(e){if(e.success){var i=e.data.required_answers;var o=JSON.parse(i);a.forEach(e=>{var n=t(e).children(".answer-help-block")[0];if(t(n).children("p").length>0){t(n).children("p").remove()}});if(o.length>0){t("#quiz-attempt-single-question-".concat(o[0].question_id)).get(0).scrollIntoView();o.forEach(e=>{var n=t("#quiz-attempt-single-question-"+e.question_id).children(".answer-help-block");t(n).html("<p class='answer-required' style=\"color: #dc3545\">".concat(__("The answer for this question is required","tutor_pro"),"</p>"))})}else{n=true}}},complete:function t(){i.removeClass("is-loading").attr("disabled",false)}});return n});var e=null;if(H5P||H5P.externalDispatcher){//Handle storing xapi data upon interaction
var n=function n(n){var i=parseInt(t("#tutor_quiz_id").val(),10);var a="h5p-local-content-id";var o="h5p-local-question-id";e=n.data.statement;var r=e.object.definition.extensions["http://h5p.org/x-api/"+a];if(e.object.definition.extensions["http://h5p.org/x-api/"+o]!==undefined){var s=e.object.definition.extensions["http://h5p.org/x-api/"+o];t.ajax({url:_tutorobject.ajaxurl,type:"POST",data:{action:"save_h5p_question_xAPI_statement",quiz_id:i,question_id:s,statement:JSON.stringify(e),content_id:r,attempt_id:t("input[name='attempt_id']").val()}})}};H5P.externalDispatcher.on("xAPI",n)}var i=document.querySelectorAll(".h5p-content");// Here content id and question id are set on the object property of xAPI statement
// So that it can be obtained during saving the xAPI statement
i.forEach(e=>{var n=parseInt(t(e).closest(".quiz-attempt-single-question").attr("id").match(/\d+/)[0],10);if(H5P){// XAPIEvent property of H5P is used which has method to update the object property of xAPI statement
H5P.XAPIEvent.prototype.setObject=function(t){if(t.contentId){// Here the extension property of the statements object is used
// To add the question id of the h5p question
this.data.statement.object={"id":this.getContentXAPIId(t),"objectType":"Activity","definition":{"extensions":{"http://h5p.org/x-api/h5p-local-content-id":t.contentId,"http://h5p.org/x-api/h5p-local-question-id":n}}};if(t.subContentId){this.data.statement.object.definition.extensions["http://h5p.org/x-api/h5p-subContentId"]=t.subContentId;// Don't set titles on main content, title should come from publishing platform
if(typeof t.getTitle==="function"){this.data.statement.object.definition.name={"en-US":t.getTitle()}}}else{var e=H5P.getContentForInstance(t.contentId);if(e&&e.metadata&&e.metadata.title){this.data.statement.object.definition.name={"en-US":H5P.createTitle(e.metadata.title)}}}}else{// Content types view always expect to have a contentId when they are displayed.
// This is not the case if they are displayed in the editor as part of a preview.
// The fix is to set an empty object with definition for the xAPI event, so all
// the content types that rely on this does not have to handle it. This means
// that content types that are being previewed will send xAPI completed events,
// but since there are no scripts that catch these events in the editor,
// this is not a problem.
this.data.statement.object={definition:{}}}}}});var a=document.querySelectorAll(".h5p-iframe");// Setup the h5p content iframe upon loading
a.forEach(e=>{var n=parseInt(t(e).closest(".quiz-attempt-single-question").attr("id").match(/\d+/)[0],10);var i=setInterval(()=>{var a=e.contentDocument||e.contentWindow.document;// Check if the iframe is visible or interactive
if(a.readyState==="complete"||a.readyState==="interactive"){// Send a signal from iframe to parent to perform some event after the content has loaded
e.contentWindow.postMessage({action:"set_iframe",selector:".h5p-content",question_id:n,content_id:t(e).closest(".quiz-attempt-single-question").data("h5p-quiz-content-id")},"*");//If not ready then clear timer and stop to go to next iteration
clearInterval(i)}},500)})})})();