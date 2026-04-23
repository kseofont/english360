(()=>{var n={};/************************************************************************/// The module cache
var e={};// The require function
function a(t){// Check if module is in cache
var i=e[t];if(i!==undefined){return i.exports}// Create a new module (and put it into the cache)
var r=e[t]={exports:{}};// Execute the module function
n[t](r,r.exports,a);// Return the exports of the module
return r.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{a.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{a.ruid="bundler=rspack@1.5.7"})();/************************************************************************/jQuery(document).ready(function(n){n(document).on("click","#download_analytics",function(a){a.preventDefault();var t=n(this);if(t.hasClass("is-loading")){return}n.ajax({url:window._tutorobject.ajaxurl,type:"POST",data:{action:"export_analytics"},beforeSend:function n(){t.addClass("is-loading")},success:function n(n){if(n.success){e(n.data)}},complete:function n(){t.removeClass("is-loading")}})});function e(n){var e=n.students;var a=n.earnings;var t=n.discounts.length;var i=n.refunds;var r=new JSZip;// get keys as array
if(e.length){var o=Object.keys(e[0]);var s=[o.join(","),e.map(n=>o.map(e=>n[e]).join(",")).join("\n")].join("\n");//generate csv
var c=new Blob([s]);r.file("students.csv",c)}if(a.length){var l=Object.keys(a[0]);var d=[l.join(","),a.map(n=>l.map(e=>n[e]).join(",")).join("\n")].join("\n");//generate csv
var v=new Blob([d]);//add file
r.file("earnings.csv",v)}if(t.length){var u=Object.keys(t[0]);var f=[u.join(","),t.map(n=>u.map(e=>n[e]).join(",")).join("\n")].join("\n");//generate csv
var j=new Blob([f]);//add file 
r.file("discounts.csv",j)}if(i.length){var p=Object.keys(i[0]);var b=[p.join(","),i.map(n=>p.map(e=>n[e]).join(",")).join("\n")].join("\n");//generate csv
var m=new Blob([b]);//add file
r.file("refunds.csv",m)}//generate zip archive
try{r.generateAsync({type:"blob"}).then(function(n){var e=new Blob([n],{type:"application/zip"});var a=document.createElement("a");document.body.appendChild(a);a.download="analytics-data.zip";a.href=URL.createObjectURL(e);a.click();URL.revokeObjectURL(a.href)})}catch(n){alert(n)}}})})();