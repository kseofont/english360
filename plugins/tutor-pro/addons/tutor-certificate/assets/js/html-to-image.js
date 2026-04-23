(()=>{"use strict";var e={};/************************************************************************/// The module cache
var t={};// The require function
function r(a){// Check if module is in cache
var n=t[a];if(n!==undefined){return n.exports}// Create a new module (and put it into the cache)
var o=t[a]={exports:{}};// Execute the module function
e[a](o,o.exports,r);// Return the exports of the module
return o.exports}/************************************************************************/// webpack/runtime/rspack_version
(()=>{r.rv=()=>"1.5.7"})();// webpack/runtime/rspack_unique_id
(()=>{r.ruid="bundler=rspack@1.5.7"})();/************************************************************************/;// CONCATENATED MODULE: ./assets/lib/response.js
var a=(e,t)=>{var{__}=wp.i18n;var{data:r={}}=e||{};var{message:a=t||__("Something Went Wrong!","tutor-pro")}=r;return a};// CONCATENATED MODULE: ./addons/tutor-certificate/assets/react/html-to-image.js
jQuery(document).ready(function(e){var t=window.navigator.userAgent.match(/Firefox\/([0-9]+)\./);var r=t?parseInt(t[1]):0;var n=/^((?!chrome|android).)*safari/i.test(navigator.userAgent);var o=/Chrome/.test(navigator.userAgent)&&/Google Inc/.test(navigator.vendor);var{__,_x:i,_n:c,_nx:d}=wp.i18n;e("body").append('<svg id="tutor_svg_font_id" width="0" height="0" style="background-color:white;"></svg>');var s=(t,r)=>{var a=new XMLHttpRequest;a.open("get","?tutor_action=get_fonts&course_id="+t);a.responseType="text";a.send();a.onloadend=()=>{//(2)find all font urls.
var t=a.response;var n=t.match(/https?:\/\/[^ \)]+/g);var o=0;n.forEach(a=>{//(3)get each font binary.
var i=new XMLHttpRequest;i.open("get",a);i.responseType="blob";i.onloadend=()=>{//(4)conver font blob to binary string.
var c=new FileReader;c.onloadend=()=>{//(5)replace font url by binary string.
t=t.replace(new RegExp(a),c.result);o++;//check all fonts are replaced.
if(o==n.length){e("#tutor_svg_font_id").prepend("<style>".concat(t,"</style>"));r()}};c.readAsDataURL(i.response)};i.send()})}};var l=e=>{// Create canvas
var t=document.createElement("canvas");var r=t.getContext("2d");// Set width and height
t.width=e.naturalWidth;t.height=e.naturalHeight;// Draw the image
r.drawImage(e,0,0);return t.toDataURL("image/png")};var u=function e(e,t){var r=e.getElementsByTagName("img");var a=0;function n(){if(a>=r.length){t();return}r[a].onload=n;r[a].src=l(r[a]);a=a+1}n()};// HTML to Images related functionalities
var p=function t(t,i,c){this.reload=function(){window.location.reload()};this.dataURItoBlob=(e,t)=>{// convert base64 to raw binary data held in a string
var r=atob(e.split(",")[1]);// write the bytes of the string to an ArrayBuffer
var a=new ArrayBuffer(r.length);var n=new Uint8Array(a);for(var o=0;o<r.length;o++){n[o]=r.charCodeAt(o)}return new Blob([a],{type:t})};this.store_certificate=(t,r)=>{var a=tutor_get_nonce_data(true);var n=new FormData;n.append("action","tutor_store_certificate_image");n.append("cert_hash",i);n.append("certificate_image",this.dataURItoBlob(t,"image/jpeg"),"certificate.jpg");n.append(a.key,a.value);e.ajax({url:window._tutorobject.ajaxurl,type:"POST",data:n,processData:false,contentType:false,success:function e(e){var t=(e.data||{}).message;r(e&&e.success,t)},error:function e(){r(false)}})};// Call various method like image converter and after action
this.dispatch_conversion_methods=(e,t)=>{var r=e.getElementsByTagName("body")[0];var a=e.getElementById("watermark");var n=a.offsetWidth;var i=a.offsetHeight;// Now set this dimension body
r.style.display="inline-block";r.style.overflow="hidden";r.style.width=n+"px";r.style.height=i+"px";r.style.padding="0px";r.style.margin="0px";// Now capture the iframe using library
var c=e.getElementsByTagName("body")[0];var d={scale:3,letterRendering:true,logging:true,foreignObjectRendering:o,allowTaint:true,useCORS:true,x:0,y:0,width:n,height:i,windowWidth:n,windowHeight:i};u(e,()=>{html2canvas(c,d).then(e=>{var r=e.toDataURL("image/jpeg",1);// Store the blob on server
this.store_certificate(r,(e,r)=>{console.log("Store cert image");// Show error if fails
!e?alert(r||__("Something Went Wrong","tutor-pro")):0;// Execute callback if callable
typeof t=="function"?t(e):0})})})};this.load_certificate_builder=e=>{var t=document.createElement("iframe");t.width="1920";t.height="1080";t.style.position="absolute";t.style.left="-999999px";t.src=e;document.getElementsByTagName("body")[0].appendChild(t)};// Fetch certificate html from server
// and initialize converters
this.init_render_certificate=o=>{var c={action:"tutor_generate_course_certificate",course_id:t,certificate_hash:i||""};// Get the HTML from server
e.ajax({url:window._tutorobject.ajaxurl,type:"POST",data:c,success:i=>{if(!i.success){tutor_toast(__("Error","tutor-pro"),a(i),"error");return}// Open certificate builder if made by builder
var{certificate_builder_url:c}=i.data;if(c){window.tutor_certificate_after_build=()=>o(true);this.load_certificate_builder(c);return}// Backward compatibile certificate rendering
var d=i.success?i.data.html:"";// We need to put the html into iframe to make the certificate styles isolated from parent document
// Otherwise style might be overridden/influenced
var l=document.createElement("iframe");var u=function t(t){t.write(d);t.write(e("<div></div>").append(e("#tutor_svg_font_id").clone()).html());if(r){// Increase word spacing, other wise firefox compresses texts.
var a=window.document.createElement("style");a.innerHTML="*{word-spacing:3px !important; letter-spacing:2px !important;}";t.getElementsByTagName("head")[0].appendChild(a)}};if(r||n){l.addEventListener("load",()=>{var e=l.contentWindow||l.contentDocument.document||l.contentDocument;e=e.document;u(e);// Load font and then call dispatcher
s(t,()=>this.dispatch_conversion_methods(e,o))})}else{s(t,()=>{var e=l.contentWindow||l.contentDocument.document||l.contentDocument;e=e.document;// Render the html in iframe
e.open();u(e);e.close();l.onload=()=>this.dispatch_conversion_methods(e,o)})}l.style.position="absolute";l.style.left="-999999px";document.getElementsByTagName("body")[0].appendChild(l)}})}};// Download PDF certificate
var v=e(".tutor-certificate-pdf");v.click(function(t){t.preventDefault();var r=e("#tutor-pro-certificate-preview");var a=r.attr("src");var n=r.data("orientation")==="landscape"?"l":"p";var o=r.data("size")||"letter";var i=new jspdf.jsPDF(n,"px",o,true);i.addImage(a,"PNG",0,0,i.internal.pageSize.getWidth(),i.internal.pageSize.getHeight(),undefined,"NONE");i.save("certificate-".concat(new Date().getTime(),".pdf"))});// Download image directly without further processing (in individual certificate page)
var g=e("#tutor-pro-certificate-download-image");g.click(function(t){t.preventDefault();var r=e("#tutor-pro-certificate-preview");var a=document.createElement("A");a.href=r.attr("src");a.download="certificate-"+new Date().getTime()+".jpg";document.body.appendChild(a);a.click();document.body.removeChild(a)});// Instantiate image processor for this scope
var h=e("#tutor-pro-certificate-preview");var f=h.data("course_id");var m=h.data("cert_hash");var _=new p(f,m);// Regenerate certificate image (in individual page)
if(h.data("is_generated")==="no"){_.init_render_certificate(function(){window.location.replace(h.data("certificate_url"))})}// Print certificate.
this.PrintDiv=()=>{var e=document.querySelector("#div-to-print");if(!e){return}var t=window.open("","_blank","width=800,height=500");var r=t.document;var a=r.createElement("body");a.append(...e.cloneNode(true).childNodes);r.body.replaceWith(a);setTimeout(()=>{t.print();t.close()},100)}})})();