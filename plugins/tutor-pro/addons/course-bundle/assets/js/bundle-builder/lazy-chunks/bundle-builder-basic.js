"use strict";(self["webpackChunktutor_pro"]=self["webpackChunktutor_pro"]||[]).push([["421"],{1543:function(e,t,r){r.d(t,{A:()=>l});/* ESM import */var n=r(1601);/* ESM import */var o=/*#__PURE__*/r.n(n);/* ESM import */var a=r(6314);/* ESM import */var i=/*#__PURE__*/r.n(a);// Imports
var s=i()(o());// Module
s.push([e.id,`/* Variables declaration */
/* prettier-ignore */
.rdp-root {
  --rdp-accent-color: blue; /* The accent color used for selected days and UI elements. */
  --rdp-accent-background-color: #f0f0ff; /* The accent background color used for selected days and UI elements. */

  --rdp-day-height: 44px; /* The height of the day cells. */
  --rdp-day-width: 44px; /* The width of the day cells. */
  
  --rdp-day_button-border-radius: 100%; /* The border radius of the day cells. */
  --rdp-day_button-border: 2px solid transparent; /* The border of the day cells. */
  --rdp-day_button-height: 42px; /* The height of the day cells. */
  --rdp-day_button-width: 42px; /* The width of the day cells. */
  
  --rdp-selected-border: 2px solid var(--rdp-accent-color); /* The border of the selected days. */
  --rdp-disabled-opacity: 0.5; /* The opacity of the disabled days. */
  --rdp-outside-opacity: 0.75; /* The opacity of the days outside the current month. */
  --rdp-today-color: var(--rdp-accent-color); /* The color of the today's date. */
  
  --rdp-dropdown-gap: 0.5rem;/* The gap between the dropdowns used in the month captons. */
  
  --rdp-months-gap: 2rem; /* The gap between the months in the multi-month view. */
  
  --rdp-nav_button-disabled-opacity: 0.5; /* The opacity of the disabled navigation buttons. */
  --rdp-nav_button-height: 2.25rem; /* The height of the navigation buttons. */
  --rdp-nav_button-width: 2.25rem; /* The width of the navigation buttons. */
  --rdp-nav-height: 2.75rem; /* The height of the navigation bar. */
  
  --rdp-range_middle-background-color: var(--rdp-accent-background-color); /* The color of the background for days in the middle of a range. */
  --rdp-range_middle-color: inherit;/* The color of the range text. */
  
  --rdp-range_start-color: white; /* The color of the range text. */
  --rdp-range_start-background: linear-gradient(var(--rdp-gradient-direction), transparent 50%, var(--rdp-range_middle-background-color) 50%); /* Used for the background of the start of the selected range. */
  --rdp-range_start-date-background-color: var(--rdp-accent-color); /* The background color of the date when at the start of the selected range. */
  
  --rdp-range_end-background: linear-gradient(var(--rdp-gradient-direction), var(--rdp-range_middle-background-color) 50%, transparent 50%); /* Used for the background of the end of the selected range. */
  --rdp-range_end-color: white;/* The color of the range text. */
  --rdp-range_end-date-background-color: var(--rdp-accent-color); /* The background color of the date when at the end of the selected range. */
  
  --rdp-week_number-border-radius: 100%; /* The border radius of the week number. */
  --rdp-week_number-border: 2px solid transparent; /* The border of the week number. */
  
  --rdp-week_number-height: var(--rdp-day-height); /* The height of the week number cells. */
  --rdp-week_number-opacity: 0.75; /* The opacity of the week number. */
  --rdp-week_number-width: var(--rdp-day-width); /* The width of the week number cells. */
  --rdp-weeknumber-text-align: center; /* The text alignment of the weekday cells. */

  --rdp-weekday-opacity: 0.75; /* The opacity of the weekday. */
  --rdp-weekday-padding: 0.5rem 0rem; /* The padding of the weekday. */
  --rdp-weekday-text-align: center; /* The text alignment of the weekday cells. */

  --rdp-gradient-direction: 90deg;

  --rdp-animation_duration: 0.3s;
  --rdp-animation_timing: cubic-bezier(0.4, 0, 0.2, 1);
}

.rdp-root[dir="rtl"] {
  --rdp-gradient-direction: -90deg;
}

.rdp-root[data-broadcast-calendar="true"] {
  --rdp-outside-opacity: unset;
}

/* Root of the component. */
.rdp-root {
  position: relative; /* Required to position the navigation toolbar. */
  box-sizing: border-box;
}

.rdp-root * {
  box-sizing: border-box;
}

.rdp-day {
  width: var(--rdp-day-width);
  height: var(--rdp-day-height);
  text-align: center;
}

.rdp-day_button {
  background: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
  font: inherit;
  color: inherit;
  justify-content: center;
  align-items: center;
  display: flex;

  width: var(--rdp-day_button-width);
  height: var(--rdp-day_button-height);
  border: var(--rdp-day_button-border);
  border-radius: var(--rdp-day_button-border-radius);
}

.rdp-day_button:disabled {
  cursor: revert;
}

.rdp-caption_label {
  z-index: 1;

  position: relative;
  display: inline-flex;
  align-items: center;

  white-space: nowrap;
  border: 0;
}

.rdp-dropdown:focus-visible ~ .rdp-caption_label {
  outline: 5px auto Highlight;
  outline: 5px auto -webkit-focus-ring-color;
}

.rdp-button_next,
.rdp-button_previous {
  border: none;
  background: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
  font: inherit;
  color: inherit;
  -moz-appearance: none;
  -webkit-appearance: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  position: relative;
  appearance: none;

  width: var(--rdp-nav_button-width);
  height: var(--rdp-nav_button-height);
}

.rdp-button_next:disabled,
.rdp-button_next[aria-disabled="true"],
.rdp-button_previous:disabled,
.rdp-button_previous[aria-disabled="true"] {
  cursor: revert;

  opacity: var(--rdp-nav_button-disabled-opacity);
}

.rdp-chevron {
  display: inline-block;
  fill: var(--rdp-accent-color);
}

.rdp-root[dir="rtl"] .rdp-nav .rdp-chevron {
  transform: rotate(180deg);
  transform-origin: 50%;
}

.rdp-dropdowns {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: var(--rdp-dropdown-gap);
}
.rdp-dropdown {
  z-index: 2;

  /* Reset */
  opacity: 0;
  appearance: none;
  position: absolute;
  inset-block-start: 0;
  inset-block-end: 0;
  inset-inline-start: 0;
  width: 100%;
  margin: 0;
  padding: 0;
  cursor: inherit;
  border: none;
  line-height: inherit;
}

.rdp-dropdown_root {
  position: relative;
  display: inline-flex;
  align-items: center;
}

.rdp-dropdown_root[data-disabled="true"] .rdp-chevron {
  opacity: var(--rdp-disabled-opacity);
}

.rdp-month_caption {
  display: flex;
  align-content: center;
  height: var(--rdp-nav-height);
  font-weight: bold;
  font-size: large;
}

.rdp-root[data-nav-layout="around"] .rdp-month,
.rdp-root[data-nav-layout="after"] .rdp-month {
  position: relative;
}

.rdp-root[data-nav-layout="around"] .rdp-month_caption {
  justify-content: center;
  margin-inline-start: var(--rdp-nav_button-width);
  margin-inline-end: var(--rdp-nav_button-width);
  position: relative;
}

.rdp-root[data-nav-layout="around"] .rdp-button_previous {
  position: absolute;
  inset-inline-start: 0;
  top: 0;
  height: var(--rdp-nav-height);
  display: inline-flex;
}

.rdp-root[data-nav-layout="around"] .rdp-button_next {
  position: absolute;
  inset-inline-end: 0;
  top: 0;
  height: var(--rdp-nav-height);
  display: inline-flex;
  justify-content: center;
}

.rdp-months {
  position: relative;
  display: flex;
  flex-wrap: wrap;
  gap: var(--rdp-months-gap);
  max-width: fit-content;
}

.rdp-month_grid {
  border-collapse: collapse;
}

.rdp-nav {
  position: absolute;
  inset-block-start: 0;
  inset-inline-end: 0;

  display: flex;
  align-items: center;

  height: var(--rdp-nav-height);
}

.rdp-weekday {
  opacity: var(--rdp-weekday-opacity);
  padding: var(--rdp-weekday-padding);
  font-weight: 500;
  font-size: smaller;
  text-align: var(--rdp-weekday-text-align);
  text-transform: var(--rdp-weekday-text-transform);
}

.rdp-week_number {
  opacity: var(--rdp-week_number-opacity);
  font-weight: 400;
  font-size: small;
  height: var(--rdp-week_number-height);
  width: var(--rdp-week_number-width);
  border: var(--rdp-week_number-border);
  border-radius: var(--rdp-week_number-border-radius);
  text-align: var(--rdp-weeknumber-text-align);
}

/* DAY MODIFIERS */
.rdp-today:not(.rdp-outside) {
  color: var(--rdp-today-color);
}

.rdp-selected {
  font-weight: bold;
  font-size: large;
}

.rdp-selected .rdp-day_button {
  border: var(--rdp-selected-border);
}

.rdp-outside {
  opacity: var(--rdp-outside-opacity);
}

.rdp-disabled {
  opacity: var(--rdp-disabled-opacity);
}

.rdp-hidden {
  visibility: hidden;
  color: var(--rdp-range_start-color);
}

.rdp-range_start {
  background: var(--rdp-range_start-background);
}

.rdp-range_start .rdp-day_button {
  background-color: var(--rdp-range_start-date-background-color);
  color: var(--rdp-range_start-color);
}

.rdp-range_middle {
  background-color: var(--rdp-range_middle-background-color);
}

.rdp-range_middle .rdp-day_button {
  border-color: transparent;
  border: unset;
  border-radius: unset;
  color: var(--rdp-range_middle-color);
}

.rdp-range_end {
  background: var(--rdp-range_end-background);
  color: var(--rdp-range_end-color);
}

.rdp-range_end .rdp-day_button {
  color: var(--rdp-range_start-color);
  background-color: var(--rdp-range_end-date-background-color);
}

.rdp-range_start.rdp-range_end {
  background: revert;
}

.rdp-focusable {
  cursor: pointer;
}

@keyframes rdp-slide_in_left {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(0);
  }
}

@keyframes rdp-slide_in_right {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(0);
  }
}

@keyframes rdp-slide_out_left {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-100%);
  }
}

@keyframes rdp-slide_out_right {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(100%);
  }
}

.rdp-weeks_before_enter {
  animation: rdp-slide_in_left var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-weeks_before_exit {
  animation: rdp-slide_out_left var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-weeks_after_enter {
  animation: rdp-slide_in_right var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-weeks_after_exit {
  animation: rdp-slide_out_right var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-root[dir="rtl"] .rdp-weeks_after_enter {
  animation: rdp-slide_in_left var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-root[dir="rtl"] .rdp-weeks_before_exit {
  animation: rdp-slide_out_right var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-root[dir="rtl"] .rdp-weeks_before_enter {
  animation: rdp-slide_in_right var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-root[dir="rtl"] .rdp-weeks_after_exit {
  animation: rdp-slide_out_left var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

@keyframes rdp-fade_in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes rdp-fade_out {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
  }
}

.rdp-caption_after_enter {
  animation: rdp-fade_in var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-caption_after_exit {
  animation: rdp-fade_out var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-caption_before_enter {
  animation: rdp-fade_in var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}

.rdp-caption_before_exit {
  animation: rdp-fade_out var(--rdp-animation_duration)
    var(--rdp-animation_timing) forwards;
}
`,""]);// Exports
/* ESM default export */const l=s},6314:function(e){/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/e.exports=function(e){var t=[];// return the list of modules as css string
t.toString=function t(){return this.map(function(t){var r="";var n=typeof t[5]!=="undefined";if(t[4]){r+="@supports (".concat(t[4],") {")}if(t[2]){r+="@media ".concat(t[2]," {")}if(n){r+="@layer".concat(t[5].length>0?" ".concat(t[5]):""," {")}r+=e(t);if(n){r+="}"}if(t[2]){r+="}"}if(t[4]){r+="}"}return r}).join("")};// import a list of modules into the list
t.i=function e(e,r,n,o,a){if(typeof e==="string"){e=[[null,e,undefined]]}var i={};if(n){for(var s=0;s<this.length;s++){var l=this[s][0];if(l!=null){i[l]=true}}}for(var c=0;c<e.length;c++){var u=[].concat(e[c]);if(n&&i[u[0]]){continue}if(typeof a!=="undefined"){if(typeof u[5]==="undefined"){u[5]=a}else{u[1]="@layer".concat(u[5].length>0?" ".concat(u[5]):""," {").concat(u[1],"}");u[5]=a}}if(r){if(!u[2]){u[2]=r}else{u[1]="@media ".concat(u[2]," {").concat(u[1],"}");u[2]=r}}if(o){if(!u[4]){u[4]="".concat(o)}else{u[1]="@supports (".concat(u[4],") {").concat(u[1],"}");u[4]=o}}t.push(u)}};return t}},1601:function(e){e.exports=function(e){return e[1]}},5072:function(e){var t=[];function r(e){var r=-1;for(var n=0;n<t.length;n++){if(t[n].identifier===e){r=n;break}}return r}function n(e,n){var a={};var i=[];for(var s=0;s<e.length;s++){var l=e[s];var c=n.base?l[0]+n.base:l[0];var u=a[c]||0;var d="".concat(c," ").concat(u);a[c]=u+1;var f=r(d);var p={css:l[1],media:l[2],sourceMap:l[3],supports:l[4],layer:l[5]};if(f!==-1){t[f].references++;t[f].updater(p)}else{var h=o(p,n);n.byIndex=s;t.splice(s,0,{identifier:d,updater:h,references:1})}i.push(d)}return i}function o(e,t){var r=t.domAPI(t);r.update(e);var n=function t(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap&&t.supports===e.supports&&t.layer===e.layer){return}r.update(e=t)}else{r.remove()}};return n}e.exports=function(e,o){o=o||{};e=e||[];var a=n(e,o);return function e(e){e=e||[];for(var i=0;i<a.length;i++){var s=a[i];var l=r(s);t[l].references--}var c=n(e,o);for(var u=0;u<a.length;u++){var d=a[u];var f=r(d);if(t[f].references===0){t[f].updater();t.splice(f,1)}}a=c}}},7659:function(e){var t={};/* istanbul ignore next  */function r(e){if(typeof t[e]==="undefined"){var r=document.querySelector(e);// Special case to return head of iframe instead of iframe itself
if(window.HTMLIFrameElement&&r instanceof window.HTMLIFrameElement){try{// This will throw an exception if access to iframe is blocked
// due to cross-origin restrictions
r=r.contentDocument.head}catch(e){// istanbul ignore next
r=null}}t[e]=r}return t[e]}/* istanbul ignore next  */function n(e,t){var n=r(e);if(!n){throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.")}n.appendChild(t)}e.exports=n},540:function(e){/* istanbul ignore next  */function t(e){var t=document.createElement("style");e.setAttributes(t,e.attributes);e.insert(t,e.options);return t}e.exports=t},5056:function(e,t,r){/* istanbul ignore next  */function n(e){var t=true?r.nc:0;if(t){e.setAttribute("nonce",t)}}e.exports=n},7825:function(e){/* istanbul ignore next  */function t(e,t,r){var n="";if(r.supports){n+="@supports (".concat(r.supports,") {")}if(r.media){n+="@media ".concat(r.media," {")}var o=typeof r.layer!=="undefined";if(o){n+="@layer".concat(r.layer.length>0?" ".concat(r.layer):""," {")}n+=r.css;if(o){n+="}"}if(r.media){n+="}"}if(r.supports){n+="}"}var a=r.sourceMap;if(a&&typeof btoa!=="undefined"){n+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(a))))," */")}// For old IE
/* istanbul ignore if  */t.styleTagTransform(n,e,t.options)}function r(e){// istanbul ignore if
if(e.parentNode===null){return false}e.parentNode.removeChild(e)}/* istanbul ignore next  */function n(e){if(typeof document==="undefined"){return{update:function e(){},remove:function e(){}}}var n=e.insertStyleElement(e);return{update:function r(r){t(n,e,r)},remove:function e(){r(n)}}}e.exports=n},1113:function(e){/* istanbul ignore next  */function t(e,t){if(t.styleSheet){t.styleSheet.cssText=e}else{while(t.firstChild){t.removeChild(t.firstChild)}t.appendChild(document.createTextNode(e))}}e.exports=t},8906:function(e,t,r){r.d(t,{A:()=>_});/* ESM import */var n=r(7584);/* ESM import */var o=r(408);/* ESM import */var a=r(3747);/* ESM import */var i=r(9185);/* ESM import */var s=r(1573);/* ESM import */var l=r(3494);/* ESM import */var c=r(6277);/* ESM import */var u=r(5781);/* ESM import */var d=r(4532);/* ESM import */var f=r(1817);/* ESM import */var p=r(6783);/* ESM import */var h=r(1699);/* ESM import */var v=r(2470);/* ESM import */var g=/*#__PURE__*/r.n(v);/* ESM import */var m=r(3937);/* ESM import */var b=r(7767);var y=e=>{var{styleModifier:t}=e;var{steps:r,setSteps:g}=(0,s/* .useBundleNavigator */.h)();var y=(0,b/* .useNavigate */.Zp)();var _=(0,p/* .useCurrentPath */.G)(i/* ["default"] */.A);var x=(0,m/* .useFormContext */.xW)();var A=r.findIndex(e=>e.path===_);var k=Math.max(-1,A-1);var Y=Math.min(r.length,A+1);var I=r[k];var D=r[Y];var C=x.watch("post_title");var S=()=>{g(e=>{return e.map((e,t)=>{if(t===A){return(0,o._)((0,n._)({},e),{isActive:false})}if(t===k){return(0,o._)((0,n._)({},e),{isActive:true})}return e})});y(I.path)};var M=()=>{g(e=>{return e.map((e,t)=>{if(t===A){return(0,o._)((0,n._)({},e),{isActive:false})}if(t===Y){return(0,o._)((0,n._)({},e),{isActive:true})}return e})});y(D.path)};return/*#__PURE__*/(0,a/* .jsxs */.FD)("div",{css:[w.wrapper,t],children:[/*#__PURE__*/(0,a/* .jsx */.Y)(f/* ["default"] */.A,{when:A>0,children:/*#__PURE__*/(0,a/* .jsx */.Y)(l/* ["default"] */.A,{variant:"tertiary",icon:/*#__PURE__*/(0,a/* .jsx */.Y)(c/* ["default"] */.A,{name:!u/* .isRTL */.V8?"chevronLeft":"chevronRight",height:24,width:24}),iconPosition:"left",size:"small",onClick:S,buttonCss:/*#__PURE__*/(0,h/* .css */.AH)("padding:",d/* .spacing["4"] */.YK["4"]," ",d/* .spacing["12"] */.YK["12"]," ",d/* .spacing["4"] */.YK["4"]," ",d/* .spacing["4"] */.YK["4"],";svg{color:",d/* .colorTokens.icon["default"] */.I6.icon["default"],";}"),disabled:k<0,children:(0,v.__)("Back","tutor-pro")})}),/*#__PURE__*/(0,a/* .jsx */.Y)(f/* ["default"] */.A,{when:A<r.length-1&&C,children:/*#__PURE__*/(0,a/* .jsx */.Y)(l/* ["default"] */.A,{variant:"tertiary",icon:/*#__PURE__*/(0,a/* .jsx */.Y)(c/* ["default"] */.A,{name:!u/* .isRTL */.V8?"chevronRight":"chevronLeft",height:24,width:24}),iconPosition:"right",size:"small",onClick:M,buttonCss:/*#__PURE__*/(0,h/* .css */.AH)("padding:",d/* .spacing["4"] */.YK["4"]," ",d/* .spacing["4"] */.YK["4"]," ",d/* .spacing["4"] */.YK["4"]," ",d/* .spacing["12"] */.YK["12"],";svg{color:",d/* .colorTokens.icon["default"] */.I6.icon["default"],";}"),disabled:!C||Y>=r.length,children:(0,v.__)("Next","tutor-pro")})})]})};/* ESM default export */const _=y;var w={wrapper:/*#__PURE__*/(0,h/* .css */.AH)("width:100%;display:flex;justify-content:end;height:32px;align-items:center;gap:",d/* .spacing["16"] */.YK["16"],";")}},6567:function(e,t,r){// ESM COMPAT FLAG
r.r(t);// EXPORTS
r.d(t,{"default":()=>/* binding */mL});// NAMESPACE OBJECT: ../tutor/node_modules/react-day-picker/dist/esm/components/custom-components.js
var n={};r.r(n);r.d(n,{Button:()=>f6,CaptionLabel:()=>f2,Chevron:()=>f4,Day:()=>f3,DayButton:()=>f5,Dropdown:()=>f8,DropdownNav:()=>f7,Footer:()=>f9,Month:()=>pe,MonthCaption:()=>pt,MonthGrid:()=>pr,Months:()=>pn,MonthsDropdown:()=>pi,Nav:()=>ps,NextMonthButton:()=>pl,Option:()=>pc,PreviousMonthButton:()=>pu,Root:()=>pd,Select:()=>pf,Week:()=>pp,WeekNumber:()=>pg,WeekNumberHeader:()=>pm,Weekday:()=>ph,Weekdays:()=>pv,Weeks:()=>pb,YearsDropdown:()=>py});// NAMESPACE OBJECT: ../tutor/node_modules/react-day-picker/dist/esm/formatters/index.js
var o={};r.r(o);r.d(o,{formatCaption:()=>pA,formatDay:()=>pY,formatMonthCaption:()=>pk,formatMonthDropdown:()=>pI,formatWeekNumber:()=>pD,formatWeekNumberHeader:()=>pC,formatWeekdayName:()=>pS,formatYearCaption:()=>pE,formatYearDropdown:()=>pM});// NAMESPACE OBJECT: ../tutor/node_modules/react-day-picker/dist/esm/labels/index.js
var a={};r.r(a);r.d(a,{labelCaption:()=>pP,labelDay:()=>pB,labelDayButton:()=>pW,labelGrid:()=>pN,labelGridcell:()=>pL,labelMonthDropdown:()=>pz,labelNav:()=>pR,labelNext:()=>pV,labelPrevious:()=>pj,labelWeekNumber:()=>pU,labelWeekNumberHeader:()=>pG,labelWeekday:()=>pq,labelYearDropdown:()=>pQ});// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_async_to_generator.js
var i=r(6838);// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var s=r(7584);// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_object_spread_props.js
var l=r(408);// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_tagged_template_literal.js
var c=r(9785);// EXTERNAL MODULE: ./node_modules/@emotion/react/jsx-runtime/dist/emotion-react-jsx-runtime.esm.js
var u=r(3747);// EXTERNAL MODULE: ./node_modules/@emotion/react/dist/emotion-react.esm.js
var d=r(1699);// EXTERNAL MODULE: ./node_modules/@tanstack/react-query/build/legacy/QueryClientProvider.js
var f=r(241);// EXTERNAL MODULE: ./node_modules/@tanstack/react-query/build/legacy/useIsFetching.js
var p=r(9272);// EXTERNAL MODULE: external "wp.i18n"
var h=r(2470);// EXTERNAL MODULE: external "React"
var v=r(1594);var g=/*#__PURE__*/r.n(v);// EXTERNAL MODULE: ./node_modules/react-hook-form/dist/index.esm.mjs
var m=r(3937);// EXTERNAL MODULE: ./node_modules/date-fns/format.js + 29 modules
var b=r(1181);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/SVGIcon.tsx
var y=r(6277);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var _=r(7317);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread_props.js
var w=r(8015);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_tagged_template_literal.js
var x=r(6154);// CONCATENATED MODULE: ../tutor/node_modules/immer/dist/immer.mjs
// src/utils/env.ts
var A=Symbol.for("immer-nothing");var k=Symbol.for("immer-draftable");var Y=Symbol.for("immer-state");// src/utils/errors.ts
var I=false?0:[];function D(e,...t){if(false){}throw new Error(`[Immer] minified error nr: ${e}. Full error at: https://bit.ly/3cXEKWf`)}// src/utils/common.ts
var C=Object.getPrototypeOf;function S(e){return!!e&&!!e[Y]}function M(e){if(!e)return false;return F(e)||Array.isArray(e)||!!e[k]||!!e.constructor?.[k]||W(e)||B(e)}var E=Object.prototype.constructor.toString();function F(e){if(!e||typeof e!=="object")return false;const t=C(e);if(t===null){return true}const r=Object.hasOwnProperty.call(t,"constructor")&&t.constructor;if(r===Object)return true;return typeof r=="function"&&Function.toString.call(r)===E}function H(e){if(!S(e))D(15,e);return e[Y].base_}function T(e,t){if(O(e)===0/* Object */){Reflect.ownKeys(e).forEach(r=>{t(r,e[r],e)})}else{e.forEach((r,n)=>t(n,r,e))}}function O(e){const t=e[Y];return t?t.type_:Array.isArray(e)?1/* Array */:W(e)?2/* Map */:B(e)?3/* Set */:0/* Object */}function K(e,t){return O(e)===2/* Map */?e.has(t):Object.prototype.hasOwnProperty.call(e,t)}function N(e,t){return O(e)===2/* Map */?e.get(t):e[t]}function P(e,t,r){const n=O(e);if(n===2/* Map */)e.set(t,r);else if(n===3/* Set */){e.add(r)}else e[t]=r}function L(e,t){if(e===t){return e!==0||1/e===1/t}else{return e!==e&&t!==t}}function W(e){return e instanceof Map}function B(e){return e instanceof Set}function R(e){return e.copy_||e.base_}function z(e,t){if(W(e)){return new Map(e)}if(B(e)){return new Set(e)}if(Array.isArray(e))return Array.prototype.slice.call(e);const r=F(e);if(t===true||t==="class_only"&&!r){const t=Object.getOwnPropertyDescriptors(e);delete t[Y];let r=Reflect.ownKeys(t);for(let n=0;n<r.length;n++){const o=r[n];const a=t[o];if(a.writable===false){a.writable=true;a.configurable=true}if(a.get||a.set)t[o]={configurable:true,writable:true,// could live with !!desc.set as well here...
enumerable:a.enumerable,value:e[o]}}return Object.create(C(e),t)}else{const t=C(e);if(t!==null&&r){return{...e}}const n=Object.create(t);return Object.assign(n,e)}}function V(e,t=false){if(q(e)||S(e)||!M(e))return e;if(O(e)>1){e.set=e.add=e.clear=e.delete=j}Object.freeze(e);if(t)Object.entries(e).forEach(([e,t])=>V(t,true));return e}function j(){D(2)}function q(e){return Object.isFrozen(e)}// src/utils/plugins.ts
var U={};function G(e){const t=U[e];if(!t){D(0,e)}return t}function Q(e,t){if(!U[e])U[e]=t}// src/core/scope.ts
var X;function $(){return X}function Z(e,t){return{drafts_:[],parent_:e,immer_:t,// Whenever the modified draft contains a draft from another scope, we
// need to prevent auto-freezing so the unowned draft can be finalized.
canAutoFreeze_:true,unfinalizedDrafts_:0}}function J(e,t){if(t){G("Patches");e.patches_=[];e.inversePatches_=[];e.patchListener_=t}}function ee(e){et(e);e.drafts_.forEach(en);e.drafts_=null}function et(e){if(e===X){X=e.parent_}}function er(e){return X=Z(X,e)}function en(e){const t=e[Y];if(t.type_===0/* Object */||t.type_===1/* Array */)t.revoke_();else t.revoked_=true}// src/core/finalize.ts
function eo(e,t){t.unfinalizedDrafts_=t.drafts_.length;const r=t.drafts_[0];const n=e!==void 0&&e!==r;if(n){if(r[Y].modified_){ee(t);D(4)}if(M(e)){e=ea(t,e);if(!t.parent_)es(t,e)}if(t.patches_){G("Patches").generateReplacementPatches_(r[Y].base_,e,t.patches_,t.inversePatches_)}}else{e=ea(t,r,[])}ee(t);if(t.patches_){t.patchListener_(t.patches_,t.inversePatches_)}return e!==A?e:void 0}function ea(e,t,r){if(q(t))return t;const n=t[Y];if(!n){T(t,(o,a)=>ei(e,n,t,o,a,r));return t}if(n.scope_!==e)return t;if(!n.modified_){es(e,n.base_,true);return n.base_}if(!n.finalized_){n.finalized_=true;n.scope_.unfinalizedDrafts_--;const t=n.copy_;let o=t;let a=false;if(n.type_===3/* Set */){o=new Set(t);t.clear();a=true}T(o,(o,i)=>ei(e,n,t,o,i,r,a));es(e,t,false);if(r&&e.patches_){G("Patches").generatePatches_(n,r,e.patches_,e.inversePatches_)}}return n.copy_}function ei(e,t,r,n,o,a,i){if(false){}if(S(o)){const i=a&&t&&t.type_!==3/* Set */&&// Set objects are atomic since they have no keys.
!K(t.assigned_,n)?a.concat(n):void 0;const s=ea(e,o,i);P(r,n,s);if(S(s)){e.canAutoFreeze_=false}else return}else if(i){r.add(o)}if(M(o)&&!q(o)){if(!e.immer_.autoFreeze_&&e.unfinalizedDrafts_<1){return}ea(e,o);if((!t||!t.scope_.parent_)&&typeof n!=="symbol"&&Object.prototype.propertyIsEnumerable.call(r,n))es(e,o)}}function es(e,t,r=false){if(!e.parent_&&e.immer_.autoFreeze_&&e.canAutoFreeze_){V(t,r)}}// src/core/proxy.ts
function el(e,t){const r=Array.isArray(e);const n={type_:r?1/* Array */:0/* Object */,// Track which produce call this is associated with.
scope_:t?t.scope_:$(),// True for both shallow and deep changes.
modified_:false,// Used during finalization.
finalized_:false,// Track which properties have been assigned (true) or deleted (false).
assigned_:{},// The parent draft state.
parent_:t,// The base state.
base_:e,// The base proxy.
draft_:null,// set below
// The base copy with any updated values.
copy_:null,// Called by the `produce` function.
revoke_:null,isManual_:false};let o=n;let a=ec;if(r){o=[n];a=eu}const{revoke:i,proxy:s}=Proxy.revocable(o,a);n.draft_=s;n.revoke_=i;return s}var ec={get(e,t){if(t===Y)return e;const r=R(e);if(!K(r,t)){return ef(e,r,t)}const n=r[t];if(e.finalized_||!M(n)){return n}if(n===ed(e.base_,t)){ev(e);return e.copy_[t]=em(n,e)}return n},has(e,t){return t in R(e)},ownKeys(e){return Reflect.ownKeys(R(e))},set(e,t,r){const n=ep(R(e),t);if(n?.set){n.set.call(e.draft_,r);return true}if(!e.modified_){const n=ed(R(e),t);const o=n?.[Y];if(o&&o.base_===r){e.copy_[t]=r;e.assigned_[t]=false;return true}if(L(r,n)&&(r!==void 0||K(e.base_,t)))return true;ev(e);eh(e)}if(e.copy_[t]===r&&// special case: handle new props with value 'undefined'
(r!==void 0||t in e.copy_)||// special case: NaN
Number.isNaN(r)&&Number.isNaN(e.copy_[t]))return true;e.copy_[t]=r;e.assigned_[t]=true;return true},deleteProperty(e,t){if(ed(e.base_,t)!==void 0||t in e.base_){e.assigned_[t]=false;ev(e);eh(e)}else{delete e.assigned_[t]}if(e.copy_){delete e.copy_[t]}return true},// Note: We never coerce `desc.value` into an Immer draft, because we can't make
// the same guarantee in ES5 mode.
getOwnPropertyDescriptor(e,t){const r=R(e);const n=Reflect.getOwnPropertyDescriptor(r,t);if(!n)return n;return{writable:true,configurable:e.type_!==1/* Array */||t!=="length",enumerable:n.enumerable,value:r[t]}},defineProperty(){D(11)},getPrototypeOf(e){return C(e.base_)},setPrototypeOf(){D(12)}};var eu={};T(ec,(e,t)=>{eu[e]=function(){arguments[0]=arguments[0][0];return t.apply(this,arguments)}});eu.deleteProperty=function(e,t){if(false){}return eu.set.call(this,e,t,void 0)};eu.set=function(e,t,r){if(false){}return ec.set.call(this,e[0],t,r,e[0])};function ed(e,t){const r=e[Y];const n=r?R(r):e;return n[t]}function ef(e,t,r){const n=ep(t,r);return n?`value`in n?n.value:// This is a very special case, if the prop is a getter defined by the
// prototype, we should invoke it with the draft as context!
n.get?.call(e.draft_):void 0}function ep(e,t){if(!(t in e))return void 0;let r=C(e);while(r){const e=Object.getOwnPropertyDescriptor(r,t);if(e)return e;r=C(r)}return void 0}function eh(e){if(!e.modified_){e.modified_=true;if(e.parent_){eh(e.parent_)}}}function ev(e){if(!e.copy_){e.copy_=z(e.base_,e.scope_.immer_.useStrictShallowCopy_)}}// src/core/immerClass.ts
var eg=class{constructor(e){this.autoFreeze_=true;this.useStrictShallowCopy_=false;/**
     * The `produce` function takes a value and a "recipe function" (whose
     * return value often depends on the base state). The recipe function is
     * free to mutate its first argument however it wants. All mutations are
     * only ever applied to a __copy__ of the base state.
     *
     * Pass only a function to create a "curried producer" which relieves you
     * from passing the recipe function every time.
     *
     * Only plain objects and arrays are made mutable. All other objects are
     * considered uncopyable.
     *
     * Note: This function is __bound__ to its `Immer` instance.
     *
     * @param {any} base - the initial state
     * @param {Function} recipe - function that receives a proxy of the base state as first argument and which can be freely modified
     * @param {Function} patchListener - optional function that will be called with all the patches produced here
     * @returns {any} a new state, or the initial state if nothing was modified
     */this.produce=(e,t,r)=>{if(typeof e==="function"&&typeof t!=="function"){const r=t;t=e;const n=this;return function e(o=r,...a){return n.produce(o,e=>t.call(this,e,...a))}}if(typeof t!=="function")D(6);if(r!==void 0&&typeof r!=="function")D(7);let n;if(M(e)){const o=er(this);const a=em(e,void 0);let i=true;try{n=t(a);i=false}finally{if(i)ee(o);else et(o)}J(o,r);return eo(n,o)}else if(!e||typeof e!=="object"){n=t(e);if(n===void 0)n=e;if(n===A)n=void 0;if(this.autoFreeze_)V(n,true);if(r){const t=[];const o=[];G("Patches").generateReplacementPatches_(e,n,t,o);r(t,o)}return n}else D(1,e)};this.produceWithPatches=(e,t)=>{if(typeof e==="function"){return(t,...r)=>this.produceWithPatches(t,t=>e(t,...r))}let r,n;const o=this.produce(e,t,(e,t)=>{r=e;n=t});return[o,r,n]};if(typeof e?.autoFreeze==="boolean")this.setAutoFreeze(e.autoFreeze);if(typeof e?.useStrictShallowCopy==="boolean")this.setUseStrictShallowCopy(e.useStrictShallowCopy)}createDraft(e){if(!M(e))D(8);if(S(e))e=eb(e);const t=er(this);const r=em(e,void 0);r[Y].isManual_=true;et(t);return r}finishDraft(e,t){const r=e&&e[Y];if(!r||!r.isManual_)D(9);const{scope_:n}=r;J(n,t);return eo(void 0,n)}/**
   * Pass true to automatically freeze all copies created by Immer.
   *
   * By default, auto-freezing is enabled.
   */setAutoFreeze(e){this.autoFreeze_=e}/**
   * Pass true to enable strict shallow copy.
   *
   * By default, immer does not copy the object descriptors such as getter, setter and non-enumrable properties.
   */setUseStrictShallowCopy(e){this.useStrictShallowCopy_=e}applyPatches(e,t){let r;for(r=t.length-1;r>=0;r--){const n=t[r];if(n.path.length===0&&n.op==="replace"){e=n.value;break}}if(r>-1){t=t.slice(r+1)}const n=G("Patches").applyPatches_;if(S(e)){return n(e,t)}return this.produce(e,e=>n(e,t))}};function em(e,t){const r=W(e)?G("MapSet").proxyMap_(e,t):B(e)?G("MapSet").proxySet_(e,t):el(e,t);const n=t?t.scope_:$();n.drafts_.push(r);return r}// src/core/current.ts
function eb(e){if(!S(e))D(10,e);return ey(e)}function ey(e){if(!M(e)||q(e))return e;const t=e[Y];let r;if(t){if(!t.modified_)return t.base_;t.finalized_=true;r=z(e,t.scope_.immer_.useStrictShallowCopy_)}else{r=z(e,true)}T(r,(e,t)=>{P(r,e,ey(t))});if(t){t.finalized_=false}return r}// src/plugins/patches.ts
function e_(){const e=16;if(false){}const t="replace";const r="add";const n="remove";function o(e,t,r,n){switch(e.type_){case 0/* Object */:case 2/* Map */:return i(e,t,r,n);case 1/* Array */:return a(e,t,r,n);case 3/* Set */:return s(e,t,r,n)}}function a(e,o,a,i){let{base_:s,assigned_:l}=e;let c=e.copy_;if(c.length<s.length){;[s,c]=[c,s];[a,i]=[i,a]}for(let e=0;e<s.length;e++){if(l[e]&&c[e]!==s[e]){const r=o.concat([e]);a.push({op:t,path:r,// Need to maybe clone it, as it can in fact be the original value
// due to the base/copy inversion at the start of this function
value:d(c[e])});i.push({op:t,path:r,value:d(s[e])})}}for(let e=s.length;e<c.length;e++){const t=o.concat([e]);a.push({op:r,path:t,// Need to maybe clone it, as it can in fact be the original value
// due to the base/copy inversion at the start of this function
value:d(c[e])})}for(let e=c.length-1;s.length<=e;--e){const t=o.concat([e]);i.push({op:n,path:t})}}function i(e,o,a,i){const{base_:s,copy_:l}=e;T(e.assigned_,(e,c)=>{const u=N(s,e);const f=N(l,e);const p=!c?n:K(s,e)?t:r;if(u===f&&p===t)return;const h=o.concat(e);a.push(p===n?{op:p,path:h}:{op:p,path:h,value:f});i.push(p===r?{op:n,path:h}:p===n?{op:r,path:h,value:d(u)}:{op:t,path:h,value:d(u)})})}function s(e,t,o,a){let{base_:i,copy_:s}=e;let l=0;i.forEach(e=>{if(!s.has(e)){const i=t.concat([l]);o.push({op:n,path:i,value:e});a.unshift({op:r,path:i,value:e})}l++});l=0;s.forEach(e=>{if(!i.has(e)){const i=t.concat([l]);o.push({op:r,path:i,value:e});a.unshift({op:n,path:i,value:e})}l++})}function l(e,r,n,o){n.push({op:t,path:[],value:r===A?void 0:r});o.push({op:t,path:[],value:e})}function c(o,a){a.forEach(a=>{const{path:i,op:s}=a;let l=o;for(let t=0;t<i.length-1;t++){const r=O(l);let n=i[t];if(typeof n!=="string"&&typeof n!=="number"){n=""+n}if((r===0/* Object */||r===1/* Array */)&&(n==="__proto__"||n==="constructor"))D(e+3);if(typeof l==="function"&&n==="prototype")D(e+3);l=N(l,n);if(typeof l!=="object")D(e+2,i.join("/"))}const c=O(l);const d=u(a.value);const f=i[i.length-1];switch(s){case t:switch(c){case 2/* Map */:return l.set(f,d);case 3/* Set */:D(e);default:return l[f]=d}case r:switch(c){case 1/* Array */:return f==="-"?l.push(d):l.splice(f,0,d);case 2/* Map */:return l.set(f,d);case 3/* Set */:return l.add(d);default:return l[f]=d}case n:switch(c){case 1/* Array */:return l.splice(f,1);case 2/* Map */:return l.delete(f);case 3/* Set */:return l.delete(a.value);default:return delete l[f]}default:D(e+1,s)}});return o}function u(e){if(!M(e))return e;if(Array.isArray(e))return e.map(u);if(W(e))return new Map(Array.from(e.entries()).map(([e,t])=>[e,u(t)]));if(B(e))return new Set(Array.from(e).map(u));const t=Object.create(C(e));for(const r in e)t[r]=u(e[r]);if(K(e,k))t[k]=e[k];return t}function d(e){if(S(e)){return u(e)}else return e}Q("Patches",{applyPatches_:c,generatePatches_:o,generateReplacementPatches_:l})}// src/plugins/mapset.ts
function ew(){class e extends Map{constructor(e,t){super();this[Y]={type_:2/* Map */,parent_:t,scope_:t?t.scope_:$(),modified_:false,finalized_:false,copy_:void 0,assigned_:void 0,base_:e,draft_:this,isManual_:false,revoked_:false}}get size(){return R(this[Y]).size}has(e){return R(this[Y]).has(e)}set(e,t){const n=this[Y];i(n);if(!R(n).has(e)||R(n).get(e)!==t){r(n);eh(n);n.assigned_.set(e,true);n.copy_.set(e,t);n.assigned_.set(e,true)}return this}delete(e){if(!this.has(e)){return false}const t=this[Y];i(t);r(t);eh(t);if(t.base_.has(e)){t.assigned_.set(e,false)}else{t.assigned_.delete(e)}t.copy_.delete(e);return true}clear(){const e=this[Y];i(e);if(R(e).size){r(e);eh(e);e.assigned_=/* @__PURE__ */new Map;T(e.base_,t=>{e.assigned_.set(t,false)});e.copy_.clear()}}forEach(e,t){const r=this[Y];R(r).forEach((r,n,o)=>{e.call(t,this.get(n),n,this)})}get(e){const t=this[Y];i(t);const n=R(t).get(e);if(t.finalized_||!M(n)){return n}if(n!==t.base_.get(e)){return n}const o=em(n,t);r(t);t.copy_.set(e,o);return o}keys(){return R(this[Y]).keys()}values(){const e=this.keys();return{[Symbol.iterator]:()=>this.values(),next:()=>{const t=e.next();if(t.done)return t;const r=this.get(t.value);return{done:false,value:r}}}}entries(){const e=this.keys();return{[Symbol.iterator]:()=>this.entries(),next:()=>{const t=e.next();if(t.done)return t;const r=this.get(t.value);return{done:false,value:[t.value,r]}}}}[(Y,Symbol.iterator)](){return this.entries()}}function t(t,r){return new e(t,r)}function r(e){if(!e.copy_){e.assigned_=/* @__PURE__ */new Map;e.copy_=new Map(e.base_)}}class n extends Set{constructor(e,t){super();this[Y]={type_:3/* Set */,parent_:t,scope_:t?t.scope_:$(),modified_:false,finalized_:false,copy_:void 0,base_:e,draft_:this,drafts_:/* @__PURE__ */new Map,revoked_:false,isManual_:false}}get size(){return R(this[Y]).size}has(e){const t=this[Y];i(t);if(!t.copy_){return t.base_.has(e)}if(t.copy_.has(e))return true;if(t.drafts_.has(e)&&t.copy_.has(t.drafts_.get(e)))return true;return false}add(e){const t=this[Y];i(t);if(!this.has(e)){a(t);eh(t);t.copy_.add(e)}return this}delete(e){if(!this.has(e)){return false}const t=this[Y];i(t);a(t);eh(t);return t.copy_.delete(e)||(t.drafts_.has(e)?t.copy_.delete(t.drafts_.get(e)):/* istanbul ignore next */false)}clear(){const e=this[Y];i(e);if(R(e).size){a(e);eh(e);e.copy_.clear()}}values(){const e=this[Y];i(e);a(e);return e.copy_.values()}entries(){const e=this[Y];i(e);a(e);return e.copy_.entries()}keys(){return this.values()}[(Y,Symbol.iterator)](){return this.values()}forEach(e,t){const r=this.values();let n=r.next();while(!n.done){e.call(t,n.value,n.value,this);n=r.next()}}}function o(e,t){return new n(e,t)}function a(e){if(!e.copy_){e.copy_=/* @__PURE__ */new Set;e.base_.forEach(t=>{if(M(t)){const r=em(t,e);e.drafts_.set(t,r);e.copy_.add(r)}else{e.copy_.add(t)}})}}function i(e){if(e.revoked_)D(3,JSON.stringify(R(e)))}Q("MapSet",{proxyMap_:t,proxySet_:o})}// src/immer.ts
var ex=new eg;var eA=ex.produce;var ek=ex.produceWithPatches.bind(ex);var eY=ex.setAutoFreeze.bind(ex);var eI=ex.setUseStrictShallowCopy.bind(ex);var eD=ex.applyPatches.bind(ex);var eC=ex.createDraft.bind(ex);var eS=ex.finishDraft.bind(ex);function eM(e){return e}function eE(e){return e}//# sourceMappingURL=immer.mjs.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-hook-form/dist/index.esm.mjs
var eF=e=>e.type==="checkbox";var eH=e=>e instanceof Date;var eT=e=>e==null;const eO=e=>typeof e==="object";var eK=e=>!eT(e)&&!Array.isArray(e)&&eO(e)&&!eH(e);var eN=e=>eK(e)&&e.target?eF(e.target)?e.target.checked:e.target.value:e;var eP=e=>e.substring(0,e.search(/\.\d+(\.|$)/))||e;var eL=(e,t)=>e.has(eP(t));var eW=e=>{const t=e.constructor&&e.constructor.prototype;return eK(t)&&t.hasOwnProperty("isPrototypeOf")};var eB=typeof window!=="undefined"&&typeof window.HTMLElement!=="undefined"&&typeof document!=="undefined";function eR(e){let t;const r=Array.isArray(e);const n=typeof FileList!=="undefined"?e instanceof FileList:false;if(e instanceof Date){t=new Date(e)}else if(!(eB&&(e instanceof Blob||n))&&(r||eK(e))){t=r?[]:Object.create(Object.getPrototypeOf(e));if(!r&&!eW(e)){t=e}else{for(const r in e){if(e.hasOwnProperty(r)){t[r]=eR(e[r])}}}}else{return e}return t}var ez=e=>/^\w*$/.test(e);var eV=e=>e===undefined;var ej=e=>Array.isArray(e)?e.filter(Boolean):[];var eq=e=>ej(e.replace(/["|']|\]/g,"").split(/\.|\[/));var eU=(e,t,r)=>{if(!t||!eK(e)){return r}const n=(ez(t)?[t]:eq(t)).reduce((e,t)=>eT(e)?e:e[t],e);return eV(n)||n===e?eV(e[t])?r:e[t]:n};var eG=e=>typeof e==="boolean";var eQ=(e,t,r)=>{let n=-1;const o=ez(t)?[t]:eq(t);const a=o.length;const i=a-1;while(++n<a){const t=o[n];let a=r;if(n!==i){const r=e[t];a=eK(r)||Array.isArray(r)?r:!isNaN(+o[n+1])?[]:{}}if(t==="__proto__"||t==="constructor"||t==="prototype"){return}e[t]=a;e=e[t]}};const eX={BLUR:"blur",FOCUS_OUT:"focusout",CHANGE:"change"};const e$={onBlur:"onBlur",onChange:"onChange",onSubmit:"onSubmit",onTouched:"onTouched",all:"all"};const eZ={max:"max",min:"min",maxLength:"maxLength",minLength:"minLength",pattern:"pattern",required:"required",validate:"validate"};const eJ=v.createContext(null);eJ.displayName="HookFormContext";/**
 * This custom hook allows you to access the form context. useFormContext is intended to be used in deeply nested structures, where it would become inconvenient to pass the context as a prop. To be used with {@link FormProvider}.
 *
 * @remarks
 * [API](https://react-hook-form.com/docs/useformcontext) • [Demo](https://codesandbox.io/s/react-hook-form-v7-form-context-ytudi)
 *
 * @returns return all useForm methods
 *
 * @example
 * ```tsx
 * function App() {
 *   const methods = useForm();
 *   const onSubmit = data => console.log(data);
 *
 *   return (
 *     <FormProvider {...methods} >
 *       <form onSubmit={methods.handleSubmit(onSubmit)}>
 *         <NestedInput />
 *         <input type="submit" />
 *       </form>
 *     </FormProvider>
 *   );
 * }
 *
 *  function NestedInput() {
 *   const { register } = useFormContext(); // retrieve all hook methods
 *   return <input {...register("test")} />;
 * }
 * ```
 */const e0=()=>v.useContext(eJ);/**
 * A provider component that propagates the `useForm` methods to all children components via [React Context](https://reactjs.org/docs/context.html) API. To be used with {@link useFormContext}.
 *
 * @remarks
 * [API](https://react-hook-form.com/docs/useformcontext) • [Demo](https://codesandbox.io/s/react-hook-form-v7-form-context-ytudi)
 *
 * @param props - all useForm methods
 *
 * @example
 * ```tsx
 * function App() {
 *   const methods = useForm();
 *   const onSubmit = data => console.log(data);
 *
 *   return (
 *     <FormProvider {...methods} >
 *       <form onSubmit={methods.handleSubmit(onSubmit)}>
 *         <NestedInput />
 *         <input type="submit" />
 *       </form>
 *     </FormProvider>
 *   );
 * }
 *
 *  function NestedInput() {
 *   const { register } = useFormContext(); // retrieve all hook methods
 *   return <input {...register("test")} />;
 * }
 * ```
 */const e1=e=>{const{children:t,...r}=e;return v.createElement(eJ.Provider,{value:r},t)};var e6=(e,t,r,n=true)=>{const o={defaultValues:t._defaultValues};for(const a in e){Object.defineProperty(o,a,{get:()=>{const o=a;if(t._proxyFormState[o]!==e$.all){t._proxyFormState[o]=!n||e$.all}r&&(r[o]=true);return e[o]}})}return o};const e2=typeof window!=="undefined"?v.useLayoutEffect:v.useEffect;/**
 * This custom hook allows you to subscribe to each form state, and isolate the re-render at the custom hook level. It has its scope in terms of form state subscription, so it would not affect other useFormState and useForm. Using this hook can reduce the re-render impact on large and complex form application.
 *
 * @remarks
 * [API](https://react-hook-form.com/docs/useformstate) • [Demo](https://codesandbox.io/s/useformstate-75xly)
 *
 * @param props - include options on specify fields to subscribe. {@link UseFormStateReturn}
 *
 * @example
 * ```tsx
 * function App() {
 *   const { register, handleSubmit, control } = useForm({
 *     defaultValues: {
 *     firstName: "firstName"
 *   }});
 *   const { dirtyFields } = useFormState({
 *     control
 *   });
 *   const onSubmit = (data) => console.log(data);
 *
 *   return (
 *     <form onSubmit={handleSubmit(onSubmit)}>
 *       <input {...register("firstName")} placeholder="First Name" />
 *       {dirtyFields.firstName && <p>Field is dirty.</p>}
 *       <input type="submit" />
 *     </form>
 *   );
 * }
 * ```
 */function e4(e){const t=e0();const{control:r=t.control,disabled:n,name:o,exact:a}=e||{};const[i,s]=v.useState(r._formState);const l=v.useRef({isDirty:false,isLoading:false,dirtyFields:false,touchedFields:false,validatingFields:false,isValidating:false,isValid:false,errors:false});e2(()=>r._subscribe({name:o,formState:l.current,exact:a,callback:e=>{!n&&s({...r._formState,...e})}}),[o,n,a]);v.useEffect(()=>{l.current.isValid&&r._setValid(true)},[r]);return v.useMemo(()=>e6(i,r,l.current,false),[i,r])}var e3=e=>typeof e==="string";var e5=(e,t,r,n,o)=>{if(e3(e)){n&&t.watch.add(e);return eU(r,e,o)}if(Array.isArray(e)){return e.map(e=>(n&&t.watch.add(e),eU(r,e)))}n&&(t.watchAll=true);return r};var e8=e=>eT(e)||!eO(e);function e7(e,t,r=new WeakSet){if(e8(e)||e8(t)){return e===t}if(eH(e)&&eH(t)){return e.getTime()===t.getTime()}const n=Object.keys(e);const o=Object.keys(t);if(n.length!==o.length){return false}if(r.has(e)||r.has(t)){return true}r.add(e);r.add(t);for(const a of n){const n=e[a];if(!o.includes(a)){return false}if(a!=="ref"){const e=t[a];if(eH(n)&&eH(e)||eK(n)&&eK(e)||Array.isArray(n)&&Array.isArray(e)?!e7(n,e,r):n!==e){return false}}}return true}/**
 * Custom hook to subscribe to field change and isolate re-rendering at the component level.
 *
 * @remarks
 *
 * [API](https://react-hook-form.com/docs/usewatch) • [Demo](https://codesandbox.io/s/react-hook-form-v7-ts-usewatch-h9i5e)
 *
 * @example
 * ```tsx
 * const { control } = useForm();
 * const values = useWatch({
 *   name: "fieldName"
 *   control,
 * })
 * ```
 */function e9(e){const t=e0();const{control:r=t.control,name:n,defaultValue:o,disabled:a,exact:i,compute:s}=e||{};const l=v.useRef(o);const c=v.useRef(s);const u=v.useRef(undefined);c.current=s;const d=v.useMemo(()=>r._getWatch(n,l.current),[r,n]);const[f,p]=v.useState(c.current?c.current(d):d);e2(()=>r._subscribe({name:n,formState:{values:true},exact:i,callback:e=>{if(!a){const t=e5(n,r._names,e.values||r._formValues,false,l.current);if(c.current){const e=c.current(t);if(!e7(e,u.current)){p(e);u.current=e}}else{p(t)}}}}),[r,a,n,i]);v.useEffect(()=>r._removeUnmounted());return f}/**
 * Custom hook to work with controlled component, this function provide you with both form and field level state. Re-render is isolated at the hook level.
 *
 * @remarks
 * [API](https://react-hook-form.com/docs/usecontroller) • [Demo](https://codesandbox.io/s/usecontroller-0o8px)
 *
 * @param props - the path name to the form field value, and validation rules.
 *
 * @returns field properties, field and form state. {@link UseControllerReturn}
 *
 * @example
 * ```tsx
 * function Input(props) {
 *   const { field, fieldState, formState } = useController(props);
 *   return (
 *     <div>
 *       <input {...field} placeholder={props.name} />
 *       <p>{fieldState.isTouched && "Touched"}</p>
 *       <p>{formState.isSubmitted ? "submitted" : ""}</p>
 *     </div>
 *   );
 * }
 * ```
 */function te(e){const t=e0();const{name:r,disabled:n,control:o=t.control,shouldUnregister:a,defaultValue:i}=e;const s=eL(o._names.array,r);const l=v.useMemo(()=>eU(o._formValues,r,eU(o._defaultValues,r,i)),[o,r,i]);const c=e9({control:o,name:r,defaultValue:l,exact:true});const u=e4({control:o,name:r,exact:true});const d=v.useRef(e);const f=v.useRef(o.register(r,{...e.rules,value:c,...eG(e.disabled)?{disabled:e.disabled}:{}}));d.current=e;const p=v.useMemo(()=>Object.defineProperties({},{invalid:{enumerable:true,get:()=>!!eU(u.errors,r)},isDirty:{enumerable:true,get:()=>!!eU(u.dirtyFields,r)},isTouched:{enumerable:true,get:()=>!!eU(u.touchedFields,r)},isValidating:{enumerable:true,get:()=>!!eU(u.validatingFields,r)},error:{enumerable:true,get:()=>eU(u.errors,r)}}),[u,r]);const h=v.useCallback(e=>f.current.onChange({target:{value:eN(e),name:r},type:eX.CHANGE}),[r]);const g=v.useCallback(()=>f.current.onBlur({target:{value:eU(o._formValues,r),name:r},type:eX.BLUR}),[r,o._formValues]);const m=v.useCallback(e=>{const t=eU(o._fields,r);if(t&&e){t._f.ref={focus:()=>e.focus&&e.focus(),select:()=>e.select&&e.select(),setCustomValidity:t=>e.setCustomValidity(t),reportValidity:()=>e.reportValidity()}}},[o._fields,r]);const b=v.useMemo(()=>({name:r,value:c,...eG(n)||u.disabled?{disabled:u.disabled||n}:{},onChange:h,onBlur:g,ref:m}),[r,n,u.disabled,h,g,m,c]);v.useEffect(()=>{const e=o._options.shouldUnregister||a;o.register(r,{...d.current.rules,...eG(d.current.disabled)?{disabled:d.current.disabled}:{}});const t=(e,t)=>{const r=eU(o._fields,e);if(r&&r._f){r._f.mount=t}};t(r,true);if(e){const e=eR(eU(o._options.defaultValues,r));eQ(o._defaultValues,r,e);if(eV(eU(o._formValues,r))){eQ(o._formValues,r,e)}}!s&&o.register(r);return()=>{(s?e&&!o._state.action:e)?o.unregister(r):t(r,false)}},[r,o,s,a]);v.useEffect(()=>{o._setDisabledField({disabled:n,name:r})},[n,r,o]);return v.useMemo(()=>({field:b,formState:u,fieldState:p}),[b,u,p])}/**
 * Component based on `useController` hook to work with controlled component.
 *
 * @remarks
 * [API](https://react-hook-form.com/docs/usecontroller/controller) • [Demo](https://codesandbox.io/s/react-hook-form-v6-controller-ts-jwyzw) • [Video](https://www.youtube.com/watch?v=N2UNk_UCVyA)
 *
 * @param props - the path name to the form field value, and validation rules.
 *
 * @returns provide field handler functions, field and form state.
 *
 * @example
 * ```tsx
 * function App() {
 *   const { control } = useForm<FormValues>({
 *     defaultValues: {
 *       test: ""
 *     }
 *   });
 *
 *   return (
 *     <form>
 *       <Controller
 *         control={control}
 *         name="test"
 *         render={({ field: { onChange, onBlur, value, ref }, formState, fieldState }) => (
 *           <>
 *             <input
 *               onChange={onChange} // send value to hook form
 *               onBlur={onBlur} // notify when input is touched
 *               value={value} // return updated value
 *               ref={ref} // set ref for focus management
 *             />
 *             <p>{formState.isSubmitted ? "submitted" : ""}</p>
 *             <p>{fieldState.isTouched ? "touched" : ""}</p>
 *           </>
 *         )}
 *       />
 *     </form>
 *   );
 * }
 * ```
 */const tt=e=>e.render(te(e));const tr=e=>{const t={};for(const r of Object.keys(e)){if(eO(e[r])&&e[r]!==null){const n=tr(e[r]);for(const e of Object.keys(n)){t[`${r}.${e}`]=n[e]}}else{t[r]=e[r]}}return t};const tn="post";/**
 * Form component to manage submission.
 *
 * @param props - to setup submission detail. {@link FormProps}
 *
 * @returns form component or headless render prop.
 *
 * @example
 * ```tsx
 * function App() {
 *   const { control, formState: { errors } } = useForm();
 *
 *   return (
 *     <Form action="/api" control={control}>
 *       <input {...register("name")} />
 *       <p>{errors?.root?.server && 'Server error'}</p>
 *       <button>Submit</button>
 *     </Form>
 *   );
 * }
 * ```
 */function to(e){const t=e0();const[r,n]=React.useState(false);const{control:o=t.control,onSubmit:a,children:i,action:s,method:l=tn,headers:c,encType:u,onError:d,render:f,onSuccess:p,validateStatus:h,...v}=e;const g=async t=>{let r=false;let n="";await o.handleSubmit(async e=>{const i=new FormData;let f="";try{f=JSON.stringify(e)}catch(e){}const v=tr(o._formValues);for(const e in v){i.append(e,v[e])}if(a){await a({data:e,event:t,method:l,formData:i,formDataJson:f})}if(s){try{const e=[c&&c["Content-Type"],u].some(e=>e&&e.includes("json"));const t=await fetch(String(s),{method:l,headers:{...c,...u&&u!=="multipart/form-data"?{"Content-Type":u}:{}},body:e?f:i});if(t&&(h?!h(t.status):t.status<200||t.status>=300)){r=true;d&&d({response:t});n=String(t.status)}else{p&&p({response:t})}}catch(e){r=true;d&&d({error:e})}}})(t);if(r&&e.control){e.control._subjects.state.next({isSubmitSuccessful:false});e.control.setError("root.server",{type:n})}};React.useEffect(()=>{n(true)},[]);return f?React.createElement(React.Fragment,null,f({submit:g})):React.createElement("form",{noValidate:r,action:s,method:l,encType:u,onSubmit:g,...v},i)}var ta=(e,t,r,n,o)=>t?{...r[e],types:{...r[e]&&r[e].types?r[e].types:{},[n]:o||true}}:{};var ti=e=>Array.isArray(e)?e:[e];var ts=()=>{let e=[];const t=t=>{for(const r of e){r.next&&r.next(t)}};const r=t=>{e.push(t);return{unsubscribe:()=>{e=e.filter(e=>e!==t)}}};const n=()=>{e=[]};return{get observers(){return e},next:t,subscribe:r,unsubscribe:n}};var tl=e=>eK(e)&&!Object.keys(e).length;var tc=e=>e.type==="file";var tu=e=>typeof e==="function";var td=e=>{if(!eB){return false}const t=e?e.ownerDocument:0;return e instanceof(t&&t.defaultView?t.defaultView.HTMLElement:HTMLElement)};var tf=e=>e.type===`select-multiple`;var tp=e=>e.type==="radio";var th=e=>tp(e)||eF(e);var tv=e=>td(e)&&e.isConnected;function tg(e,t){const r=t.slice(0,-1).length;let n=0;while(n<r){e=eV(e)?n++:e[t[n++]]}return e}function tm(e){for(const t in e){if(e.hasOwnProperty(t)&&!eV(e[t])){return false}}return true}function tb(e,t){const r=Array.isArray(t)?t:ez(t)?[t]:eq(t);const n=r.length===1?e:tg(e,r);const o=r.length-1;const a=r[o];if(n){delete n[a]}if(o!==0&&(eK(n)&&tl(n)||Array.isArray(n)&&tm(n))){tb(e,r.slice(0,-1))}return e}var ty=e=>{for(const t in e){if(tu(e[t])){return true}}return false};function t_(e,t={}){const r=Array.isArray(e);if(eK(e)||r){for(const r in e){if(Array.isArray(e[r])||eK(e[r])&&!ty(e[r])){t[r]=Array.isArray(e[r])?[]:{};t_(e[r],t[r])}else if(!eT(e[r])){t[r]=true}}}return t}function tw(e,t,r){const n=Array.isArray(e);if(eK(e)||n){for(const n in e){if(Array.isArray(e[n])||eK(e[n])&&!ty(e[n])){if(eV(t)||e8(r[n])){r[n]=Array.isArray(e[n])?t_(e[n],[]):{...t_(e[n])}}else{tw(e[n],eT(t)?{}:t[n],r[n])}}else{r[n]=!e7(e[n],t[n])}}}return r}var tx=(e,t)=>tw(e,t,t_(t));const tA={value:false,isValid:false};const tk={value:true,isValid:true};var tY=e=>{if(Array.isArray(e)){if(e.length>1){const t=e.filter(e=>e&&e.checked&&!e.disabled).map(e=>e.value);return{value:t,isValid:!!t.length}}return e[0].checked&&!e[0].disabled?e[0].attributes&&!eV(e[0].attributes.value)?eV(e[0].value)||e[0].value===""?tk:{value:e[0].value,isValid:true}:tk:tA}return tA};var tI=(e,{valueAsNumber:t,valueAsDate:r,setValueAs:n})=>eV(e)?e:t?e===""?NaN:e?+e:e:r&&e3(e)?new Date(e):n?n(e):e;const tD={isValid:false,value:null};var tC=e=>Array.isArray(e)?e.reduce((e,t)=>t&&t.checked&&!t.disabled?{isValid:true,value:t.value}:e,tD):tD;function tS(e){const t=e.ref;if(tc(t)){return t.files}if(tp(t)){return tC(e.refs).value}if(tf(t)){return[...t.selectedOptions].map(({value:e})=>e)}if(eF(t)){return tY(e.refs).value}return tI(eV(t.value)?e.ref.value:t.value,e)}var tM=(e,t,r,n)=>{const o={};for(const r of e){const e=eU(t,r);e&&eQ(o,r,e._f)}return{criteriaMode:r,names:[...e],fields:o,shouldUseNativeValidation:n}};var tE=e=>e instanceof RegExp;var tF=e=>eV(e)?e:tE(e)?e.source:eK(e)?tE(e.value)?e.value.source:e.value:e;var tH=e=>({isOnSubmit:!e||e===e$.onSubmit,isOnBlur:e===e$.onBlur,isOnChange:e===e$.onChange,isOnAll:e===e$.all,isOnTouch:e===e$.onTouched});const tT="AsyncFunction";var tO=e=>!!e&&!!e.validate&&!!(tu(e.validate)&&e.validate.constructor.name===tT||eK(e.validate)&&Object.values(e.validate).find(e=>e.constructor.name===tT));var tK=e=>e.mount&&(e.required||e.min||e.max||e.maxLength||e.minLength||e.pattern||e.validate);var tN=(e,t,r)=>!r&&(t.watchAll||t.watch.has(e)||[...t.watch].some(t=>e.startsWith(t)&&/^\.\w+/.test(e.slice(t.length))));const tP=(e,t,r,n)=>{for(const o of r||Object.keys(e)){const r=eU(e,o);if(r){const{_f:e,...a}=r;if(e){if(e.refs&&e.refs[0]&&t(e.refs[0],o)&&!n){return true}else if(e.ref&&t(e.ref,e.name)&&!n){return true}else{if(tP(a,t)){break}}}else if(eK(a)){if(tP(a,t)){break}}}}return};function tL(e,t,r){const n=eU(e,r);if(n||ez(r)){return{error:n,name:r}}const o=r.split(".");while(o.length){const n=o.join(".");const a=eU(t,n);const i=eU(e,n);if(a&&!Array.isArray(a)&&r!==n){return{name:r}}if(i&&i.type){return{name:n,error:i}}if(i&&i.root&&i.root.type){return{name:`${n}.root`,error:i.root}}o.pop()}return{name:r}}var tW=(e,t,r,n)=>{r(e);const{name:o,...a}=e;return tl(a)||Object.keys(a).length>=Object.keys(t).length||Object.keys(a).find(e=>t[e]===(!n||e$.all))};var tB=(e,t,r)=>!e||!t||e===t||ti(e).some(e=>e&&(r?e===t:e.startsWith(t)||t.startsWith(e)));var tR=(e,t,r,n,o)=>{if(o.isOnAll){return false}else if(!r&&o.isOnTouch){return!(t||e)}else if(r?n.isOnBlur:o.isOnBlur){return!e}else if(r?n.isOnChange:o.isOnChange){return e}return true};var tz=(e,t)=>!ej(eU(e,t)).length&&tb(e,t);var tV=(e,t,r)=>{const n=ti(eU(e,r));eQ(n,"root",t[r]);eQ(e,r,n);return e};var tj=e=>e3(e);function tq(e,t,r="validate"){if(tj(e)||Array.isArray(e)&&e.every(tj)||eG(e)&&!e){return{type:r,message:tj(e)?e:"",ref:t}}}var tU=e=>eK(e)&&!tE(e)?e:{value:e,message:""};var tG=async(e,t,r,n,o,a)=>{const{ref:i,refs:s,required:l,maxLength:c,minLength:u,min:d,max:f,pattern:p,validate:h,name:v,valueAsNumber:g,mount:m}=e._f;const b=eU(r,v);if(!m||t.has(v)){return{}}const y=s?s[0]:i;const _=e=>{if(o&&y.reportValidity){y.setCustomValidity(eG(e)?"":e||"");y.reportValidity()}};const w={};const x=tp(i);const A=eF(i);const k=x||A;const Y=(g||tc(i))&&eV(i.value)&&eV(b)||td(i)&&i.value===""||b===""||Array.isArray(b)&&!b.length;const I=ta.bind(null,v,n,w);const D=(e,t,r,n=eZ.maxLength,o=eZ.minLength)=>{const a=e?t:r;w[v]={type:e?n:o,message:a,ref:i,...I(e?n:o,a)}};if(a?!Array.isArray(b)||!b.length:l&&(!k&&(Y||eT(b))||eG(b)&&!b||A&&!tY(s).isValid||x&&!tC(s).isValid)){const{value:e,message:t}=tj(l)?{value:!!l,message:l}:tU(l);if(e){w[v]={type:eZ.required,message:t,ref:y,...I(eZ.required,t)};if(!n){_(t);return w}}}if(!Y&&(!eT(d)||!eT(f))){let e;let t;const r=tU(f);const o=tU(d);if(!eT(b)&&!isNaN(b)){const n=i.valueAsNumber||(b?+b:b);if(!eT(r.value)){e=n>r.value}if(!eT(o.value)){t=n<o.value}}else{const n=i.valueAsDate||new Date(b);const a=e=>new Date(new Date().toDateString()+" "+e);const s=i.type=="time";const l=i.type=="week";if(e3(r.value)&&b){e=s?a(b)>a(r.value):l?b>r.value:n>new Date(r.value)}if(e3(o.value)&&b){t=s?a(b)<a(o.value):l?b<o.value:n<new Date(o.value)}}if(e||t){D(!!e,r.message,o.message,eZ.max,eZ.min);if(!n){_(w[v].message);return w}}}if((c||u)&&!Y&&(e3(b)||a&&Array.isArray(b))){const e=tU(c);const t=tU(u);const r=!eT(e.value)&&b.length>+e.value;const o=!eT(t.value)&&b.length<+t.value;if(r||o){D(r,e.message,t.message);if(!n){_(w[v].message);return w}}}if(p&&!Y&&e3(b)){const{value:e,message:t}=tU(p);if(tE(e)&&!b.match(e)){w[v]={type:eZ.pattern,message:t,ref:i,...I(eZ.pattern,t)};if(!n){_(t);return w}}}if(h){if(tu(h)){const e=await h(b,r);const t=tq(e,y);if(t){w[v]={...t,...I(eZ.validate,t.message)};if(!n){_(t.message);return w}}}else if(eK(h)){let e={};for(const t in h){if(!tl(e)&&!n){break}const o=tq(await h[t](b,r),y,t);if(o){e={...o,...I(t,o.message)};_(o.message);if(n){w[v]=e}}}if(!tl(e)){w[v]={ref:y,...e};if(!n){return w}}}}_(true);return w};const tQ={mode:e$.onSubmit,reValidateMode:e$.onChange,shouldFocusError:true};function tX(e={}){let t={...tQ,...e};let r={submitCount:0,isDirty:false,isReady:false,isLoading:tu(t.defaultValues),isValidating:false,isSubmitted:false,isSubmitting:false,isSubmitSuccessful:false,isValid:false,touchedFields:{},dirtyFields:{},validatingFields:{},errors:t.errors||{},disabled:t.disabled||false};let n={};let o=eK(t.defaultValues)||eK(t.values)?eR(t.defaultValues||t.values)||{}:{};let a=t.shouldUnregister?{}:eR(o);let i={action:false,mount:false,watch:false};let s={mount:new Set,disabled:new Set,unMount:new Set,array:new Set,watch:new Set};let l;let c=0;const u={isDirty:false,dirtyFields:false,validatingFields:false,touchedFields:false,isValidating:false,isValid:false,errors:false};let d={...u};const f={array:ts(),state:ts()};const p=t.criteriaMode===e$.all;const h=e=>t=>{clearTimeout(c);c=setTimeout(e,t)};const v=async e=>{if(!t.disabled&&(u.isValid||d.isValid||e)){const e=t.resolver?tl((await A()).errors):await Y(n,true);if(e!==r.isValid){f.state.next({isValid:e})}}};const g=(e,n)=>{if(!t.disabled&&(u.isValidating||u.validatingFields||d.isValidating||d.validatingFields)){(e||Array.from(s.mount)).forEach(e=>{if(e){n?eQ(r.validatingFields,e,n):tb(r.validatingFields,e)}});f.state.next({validatingFields:r.validatingFields,isValidating:!tl(r.validatingFields)})}};const m=(e,s=[],l,c,p=true,h=true)=>{if(c&&l&&!t.disabled){i.action=true;if(h&&Array.isArray(eU(n,e))){const t=l(eU(n,e),c.argA,c.argB);p&&eQ(n,e,t)}if(h&&Array.isArray(eU(r.errors,e))){const t=l(eU(r.errors,e),c.argA,c.argB);p&&eQ(r.errors,e,t);tz(r.errors,e)}if((u.touchedFields||d.touchedFields)&&h&&Array.isArray(eU(r.touchedFields,e))){const t=l(eU(r.touchedFields,e),c.argA,c.argB);p&&eQ(r.touchedFields,e,t)}if(u.dirtyFields||d.dirtyFields){r.dirtyFields=tx(o,a)}f.state.next({name:e,isDirty:D(e,s),dirtyFields:r.dirtyFields,errors:r.errors,isValid:r.isValid})}else{eQ(a,e,s)}};const b=(e,t)=>{eQ(r.errors,e,t);f.state.next({errors:r.errors})};const y=e=>{r.errors=e;f.state.next({errors:r.errors,isValid:false})};const _=(e,t,r,s)=>{const l=eU(n,e);if(l){const n=eU(a,e,eV(r)?eU(o,e):r);eV(n)||s&&s.defaultChecked||t?eQ(a,e,t?n:tS(l._f)):M(e,n);i.mount&&v()}};const w=(e,n,a,i,s)=>{let l=false;let c=false;const p={name:e};if(!t.disabled){if(!a||i){if(u.isDirty||d.isDirty){c=r.isDirty;r.isDirty=p.isDirty=D();l=c!==p.isDirty}const t=e7(eU(o,e),n);c=!!eU(r.dirtyFields,e);t?tb(r.dirtyFields,e):eQ(r.dirtyFields,e,true);p.dirtyFields=r.dirtyFields;l=l||(u.dirtyFields||d.dirtyFields)&&c!==!t}if(a){const t=eU(r.touchedFields,e);if(!t){eQ(r.touchedFields,e,a);p.touchedFields=r.touchedFields;l=l||(u.touchedFields||d.touchedFields)&&t!==a}}l&&s&&f.state.next(p)}return l?p:{}};const x=(e,n,o,a)=>{const i=eU(r.errors,e);const s=(u.isValid||d.isValid)&&eG(n)&&r.isValid!==n;if(t.delayError&&o){l=h(()=>b(e,o));l(t.delayError)}else{clearTimeout(c);l=null;o?eQ(r.errors,e,o):tb(r.errors,e)}if((o?!e7(i,o):i)||!tl(a)||s){const t={...a,...s&&eG(n)?{isValid:n}:{},errors:r.errors,name:e};r={...r,...t};f.state.next(t)}};const A=async e=>{g(e,true);const r=await t.resolver(a,t.context,tM(e||s.mount,n,t.criteriaMode,t.shouldUseNativeValidation));g(e);return r};const k=async e=>{const{errors:t}=await A(e);if(e){for(const n of e){const e=eU(t,n);e?eQ(r.errors,n,e):tb(r.errors,n)}}else{r.errors=t}return t};const Y=async(e,n,o={valid:true})=>{for(const i in e){const l=e[i];if(l){const{_f:e,...c}=l;if(e){const c=s.array.has(e.name);const d=l._f&&tO(l._f);if(d&&u.validatingFields){g([i],true)}const f=await tG(l,s.disabled,a,p,t.shouldUseNativeValidation&&!n,c);if(d&&u.validatingFields){g([i])}if(f[e.name]){o.valid=false;if(n){break}}!n&&(eU(f,e.name)?c?tV(r.errors,f,e.name):eQ(r.errors,e.name,f[e.name]):tb(r.errors,e.name))}!tl(c)&&await Y(c,n,o)}}return o.valid};const I=()=>{for(const e of s.unMount){const t=eU(n,e);t&&(t._f.refs?t._f.refs.every(e=>!tv(e)):!tv(t._f.ref))&&z(e)}s.unMount=new Set};const D=(e,r)=>!t.disabled&&(e&&r&&eQ(a,e,r),!e7(K(),o));const C=(e,t,r)=>e5(e,s,{...i.mount?a:eV(t)?o:e3(e)?{[e]:t}:t},r,t);const S=e=>ej(eU(i.mount?a:o,e,t.shouldUnregister?eU(o,e,[]):[]));const M=(e,t,r={})=>{const o=eU(n,e);let i=t;if(o){const r=o._f;if(r){!r.disabled&&eQ(a,e,tI(t,r));i=td(r.ref)&&eT(t)?"":t;if(tf(r.ref)){[...r.ref.options].forEach(e=>e.selected=i.includes(e.value))}else if(r.refs){if(eF(r.ref)){r.refs.forEach(e=>{if(!e.defaultChecked||!e.disabled){if(Array.isArray(i)){e.checked=!!i.find(t=>t===e.value)}else{e.checked=i===e.value||!!i}}})}else{r.refs.forEach(e=>e.checked=e.value===i)}}else if(tc(r.ref)){r.ref.value=""}else{r.ref.value=i;if(!r.ref.type){f.state.next({name:e,values:eR(a)})}}}}(r.shouldDirty||r.shouldTouch)&&w(e,i,r.shouldTouch,r.shouldDirty,true);r.shouldValidate&&O(e)};const E=(e,t,r)=>{for(const o in t){if(!t.hasOwnProperty(o)){return}const a=t[o];const i=e+"."+o;const l=eU(n,i);(s.array.has(e)||eK(a)||l&&!l._f)&&!eH(a)?E(i,a,r):M(i,a,r)}};const F=(e,t,l={})=>{const c=eU(n,e);const p=s.array.has(e);const h=eR(t);eQ(a,e,h);if(p){f.array.next({name:e,values:eR(a)});if((u.isDirty||u.dirtyFields||d.isDirty||d.dirtyFields)&&l.shouldDirty){f.state.next({name:e,dirtyFields:tx(o,a),isDirty:D(e,h)})}}else{c&&!c._f&&!eT(h)?E(e,h,l):M(e,h,l)}tN(e,s)&&f.state.next({...r,name:e});f.state.next({name:i.mount?e:undefined,values:eR(a)})};const H=async e=>{i.mount=true;const o=e.target;let c=o.name;let h=true;const m=eU(n,c);const b=e=>{h=Number.isNaN(e)||eH(e)&&isNaN(e.getTime())||e7(e,eU(a,c,e))};const y=tH(t.mode);const _=tH(t.reValidateMode);if(m){let i;let k;const I=o.type?tS(m._f):eN(e);const D=e.type===eX.BLUR||e.type===eX.FOCUS_OUT;const C=!tK(m._f)&&!t.resolver&&!eU(r.errors,c)&&!m._f.deps||tR(D,eU(r.touchedFields,c),r.isSubmitted,_,y);const S=tN(c,s,D);eQ(a,c,I);if(D){if(!o||!o.readOnly){m._f.onBlur&&m._f.onBlur(e);l&&l(0)}}else if(m._f.onChange){m._f.onChange(e)}const M=w(c,I,D);const E=!tl(M)||S;!D&&f.state.next({name:c,type:e.type,values:eR(a)});if(C){if(u.isValid||d.isValid){if(t.mode==="onBlur"){if(D){v()}}else if(!D){v()}}return E&&f.state.next({name:c,...S?{}:M})}!D&&S&&f.state.next({...r});if(t.resolver){const{errors:e}=await A([c]);b(I);if(h){const t=tL(r.errors,n,c);const o=tL(e,n,t.name||c);i=o.error;c=o.name;k=tl(e)}}else{g([c],true);i=(await tG(m,s.disabled,a,p,t.shouldUseNativeValidation))[c];g([c]);b(I);if(h){if(i){k=false}else if(u.isValid||d.isValid){k=await Y(n,true)}}}if(h){m._f.deps&&O(m._f.deps);x(c,k,i,M)}}};const T=(e,t)=>{if(eU(r.errors,t)&&e.focus){e.focus();return 1}return};const O=async(e,o={})=>{let a;let i;const l=ti(e);if(t.resolver){const t=await k(eV(e)?e:l);a=tl(t);i=e?!l.some(e=>eU(t,e)):a}else if(e){i=(await Promise.all(l.map(async e=>{const t=eU(n,e);return await Y(t&&t._f?{[e]:t}:t)}))).every(Boolean);!(!i&&!r.isValid)&&v()}else{i=a=await Y(n)}f.state.next({...!e3(e)||(u.isValid||d.isValid)&&a!==r.isValid?{}:{name:e},...t.resolver||!e?{isValid:a}:{},errors:r.errors});o.shouldFocus&&!i&&tP(n,T,e?l:s.mount);return i};const K=e=>{const t={...i.mount?a:o};return eV(e)?t:e3(e)?eU(t,e):e.map(e=>eU(t,e))};const N=(e,t)=>({invalid:!!eU((t||r).errors,e),isDirty:!!eU((t||r).dirtyFields,e),error:eU((t||r).errors,e),isValidating:!!eU(r.validatingFields,e),isTouched:!!eU((t||r).touchedFields,e)});const P=e=>{e&&ti(e).forEach(e=>tb(r.errors,e));f.state.next({errors:e?r.errors:{}})};const L=(e,t,o)=>{const a=(eU(n,e,{_f:{}})._f||{}).ref;const i=eU(r.errors,e)||{};// Don't override existing error messages elsewhere in the object tree.
const{ref:s,message:l,type:c,...u}=i;eQ(r.errors,e,{...u,...t,ref:a});f.state.next({name:e,errors:r.errors,isValid:false});o&&o.shouldFocus&&a&&a.focus&&a.focus()};const W=(e,t)=>tu(e)?f.state.subscribe({next:r=>"values"in r&&e(C(undefined,t),r)}):C(e,t,true);const B=e=>f.state.subscribe({next:t=>{if(tB(e.name,t.name,e.exact)&&tW(t,e.formState||u,J,e.reRenderRoot)){e.callback({values:{...a},...r,...t,defaultValues:o})}}}).unsubscribe;const R=e=>{i.mount=true;d={...d,...e.formState};return B({...e,formState:d})};const z=(e,i={})=>{for(const l of e?ti(e):s.mount){s.mount.delete(l);s.array.delete(l);if(!i.keepValue){tb(n,l);tb(a,l)}!i.keepError&&tb(r.errors,l);!i.keepDirty&&tb(r.dirtyFields,l);!i.keepTouched&&tb(r.touchedFields,l);!i.keepIsValidating&&tb(r.validatingFields,l);!t.shouldUnregister&&!i.keepDefaultValue&&tb(o,l)}f.state.next({values:eR(a)});f.state.next({...r,...!i.keepDirty?{}:{isDirty:D()}});!i.keepIsValid&&v()};const V=({disabled:e,name:t})=>{if(eG(e)&&i.mount||!!e||s.disabled.has(t)){e?s.disabled.add(t):s.disabled.delete(t)}};const j=(e,r={})=>{let a=eU(n,e);const l=eG(r.disabled)||eG(t.disabled);eQ(n,e,{...a||{},_f:{...a&&a._f?a._f:{ref:{name:e}},name:e,mount:true,...r}});s.mount.add(e);if(a){V({disabled:eG(r.disabled)?r.disabled:t.disabled,name:e})}else{_(e,true,r.value)}return{...l?{disabled:r.disabled||t.disabled}:{},...t.progressive?{required:!!r.required,min:tF(r.min),max:tF(r.max),minLength:tF(r.minLength),maxLength:tF(r.maxLength),pattern:tF(r.pattern)}:{},name:e,onChange:H,onBlur:H,ref:l=>{if(l){j(e,r);a=eU(n,e);const t=eV(l.value)?l.querySelectorAll?l.querySelectorAll("input,select,textarea")[0]||l:l:l;const i=th(t);const s=a._f.refs||[];if(i?s.find(e=>e===t):t===a._f.ref){return}eQ(n,e,{_f:{...a._f,...i?{refs:[...s.filter(tv),t,...Array.isArray(eU(o,e))?[{}]:[]],ref:{type:t.type,name:e}}:{ref:t}}});_(e,false,undefined,t)}else{a=eU(n,e,{});if(a._f){a._f.mount=false}(t.shouldUnregister||r.shouldUnregister)&&!(eL(s.array,e)&&i.action)&&s.unMount.add(e)}}}};const q=()=>t.shouldFocusError&&tP(n,T,s.mount);const U=e=>{if(eG(e)){f.state.next({disabled:e});tP(n,(t,r)=>{const o=eU(n,r);if(o){t.disabled=o._f.disabled||e;if(Array.isArray(o._f.refs)){o._f.refs.forEach(t=>{t.disabled=o._f.disabled||e})}}},0,false)}};const G=(e,o)=>async i=>{let l=undefined;if(i){i.preventDefault&&i.preventDefault();i.persist&&i.persist()}let c=eR(a);f.state.next({isSubmitting:true});if(t.resolver){const{errors:e,values:t}=await A();r.errors=e;c=eR(t)}else{await Y(n)}if(s.disabled.size){for(const e of s.disabled){tb(c,e)}}tb(r.errors,"root");if(tl(r.errors)){f.state.next({errors:{}});try{await e(c,i)}catch(e){l=e}}else{if(o){await o({...r.errors},i)}q();setTimeout(q)}f.state.next({isSubmitted:true,isSubmitting:false,isSubmitSuccessful:tl(r.errors)&&!l,submitCount:r.submitCount+1,errors:r.errors});if(l){throw l}};const Q=(e,t={})=>{if(eU(n,e)){if(eV(t.defaultValue)){F(e,eR(eU(o,e)))}else{F(e,t.defaultValue);eQ(o,e,eR(t.defaultValue))}if(!t.keepTouched){tb(r.touchedFields,e)}if(!t.keepDirty){tb(r.dirtyFields,e);r.isDirty=t.defaultValue?D(e,eR(eU(o,e))):D()}if(!t.keepError){tb(r.errors,e);u.isValid&&v()}f.state.next({...r})}};const X=(e,l={})=>{const c=e?eR(e):o;const d=eR(c);const p=tl(e);const h=p?o:d;if(!l.keepDefaultValues){o=c}if(!l.keepValues){if(l.keepDirtyValues){const e=new Set([...s.mount,...Object.keys(tx(o,a))]);for(const t of Array.from(e)){eU(r.dirtyFields,t)?eQ(h,t,eU(a,t)):F(t,eU(h,t))}}else{if(eB&&eV(e)){for(const e of s.mount){const t=eU(n,e);if(t&&t._f){const e=Array.isArray(t._f.refs)?t._f.refs[0]:t._f.ref;if(td(e)){const t=e.closest("form");if(t){t.reset();break}}}}}if(l.keepFieldsRef){for(const e of s.mount){F(e,eU(h,e))}}else{n={}}}a=t.shouldUnregister?l.keepDefaultValues?eR(o):{}:eR(h);f.array.next({values:{...h}});f.state.next({values:{...h}})}s={mount:l.keepDirtyValues?s.mount:new Set,unMount:new Set,array:new Set,disabled:new Set,watch:new Set,watchAll:false,focus:""};i.mount=!u.isValid||!!l.keepIsValid||!!l.keepDirtyValues;i.watch=!!t.shouldUnregister;f.state.next({submitCount:l.keepSubmitCount?r.submitCount:0,isDirty:p?false:l.keepDirty?r.isDirty:!!(l.keepDefaultValues&&!e7(e,o)),isSubmitted:l.keepIsSubmitted?r.isSubmitted:false,dirtyFields:p?{}:l.keepDirtyValues?l.keepDefaultValues&&a?tx(o,a):r.dirtyFields:l.keepDefaultValues&&e?tx(o,e):l.keepDirty?r.dirtyFields:{},touchedFields:l.keepTouched?r.touchedFields:{},errors:l.keepErrors?r.errors:{},isSubmitSuccessful:l.keepIsSubmitSuccessful?r.isSubmitSuccessful:false,isSubmitting:false,defaultValues:o})};const $=(e,t)=>X(tu(e)?e(a):e,t);const Z=(e,t={})=>{const r=eU(n,e);const o=r&&r._f;if(o){const e=o.refs?o.refs[0]:o.ref;if(e.focus){e.focus();t.shouldSelect&&tu(e.select)&&e.select()}}};const J=e=>{r={...r,...e}};const ee=()=>tu(t.defaultValues)&&t.defaultValues().then(e=>{$(e,t.resetOptions);f.state.next({isLoading:false})});const et={control:{register:j,unregister:z,getFieldState:N,handleSubmit:G,setError:L,_subscribe:B,_runSchema:A,_focusError:q,_getWatch:C,_getDirty:D,_setValid:v,_setFieldArray:m,_setDisabledField:V,_setErrors:y,_getFieldArray:S,_reset:X,_resetDefaultValues:ee,_removeUnmounted:I,_disableForm:U,_subjects:f,_proxyFormState:u,get _fields(){return n},get _formValues(){return a},get _state(){return i},set _state(value){i=value},get _defaultValues(){return o},get _names(){return s},set _names(value){s=value},get _formState(){return r},get _options(){return t},set _options(value){t={...t,...value}}},subscribe:R,trigger:O,register:j,handleSubmit:G,watch:W,setValue:F,getValues:K,reset:$,resetField:Q,clearErrors:P,unregister:z,setError:L,setFocus:Z,getFieldState:N};return{...et,formControl:et}}var t$=()=>{if(typeof crypto!=="undefined"&&crypto.randomUUID){return crypto.randomUUID()}const e=typeof performance==="undefined"?Date.now():performance.now()*1e3;return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,t=>{const r=(Math.random()*16+e)%16|0;return(t=="x"?r:r&3|8).toString(16)})};var tZ=(e,t,r={})=>r.shouldFocus||eV(r.shouldFocus)?r.focusName||`${e}.${eV(r.focusIndex)?t:r.focusIndex}.`:"";var tJ=(e,t)=>[...e,...ti(t)];var t0=e=>Array.isArray(e)?e.map(()=>undefined):undefined;function t1(e,t,r){return[...e.slice(0,t),...ti(r),...e.slice(t)]}var t6=(e,t,r)=>{if(!Array.isArray(e)){return[]}if(eV(e[r])){e[r]=undefined}e.splice(r,0,e.splice(t,1)[0]);return e};var t2=(e,t)=>[...ti(t),...ti(e)];function t4(e,t){let r=0;const n=[...e];for(const e of t){n.splice(e-r,1);r++}return ej(n).length?n:[]}var t3=(e,t)=>eV(t)?[]:t4(e,ti(t).sort((e,t)=>e-t));var t5=(e,t,r)=>{[e[t],e[r]]=[e[r],e[t]]};var t8=(e,t,r)=>{e[t]=r;return e};/**
 * A custom hook that exposes convenient methods to perform operations with a list of dynamic inputs that need to be appended, updated, removed etc. • [Demo](https://codesandbox.io/s/react-hook-form-usefieldarray-ssugn) • [Video](https://youtu.be/4MrbfGSFY2A)
 *
 * @remarks
 * [API](https://react-hook-form.com/docs/usefieldarray) • [Demo](https://codesandbox.io/s/react-hook-form-usefieldarray-ssugn)
 *
 * @param props - useFieldArray props
 *
 * @returns methods - functions to manipulate with the Field Arrays (dynamic inputs) {@link UseFieldArrayReturn}
 *
 * @example
 * ```tsx
 * function App() {
 *   const { register, control, handleSubmit, reset, trigger, setError } = useForm({
 *     defaultValues: {
 *       test: []
 *     }
 *   });
 *   const { fields, append } = useFieldArray({
 *     control,
 *     name: "test"
 *   });
 *
 *   return (
 *     <form onSubmit={handleSubmit(data => console.log(data))}>
 *       {fields.map((item, index) => (
 *          <input key={item.id} {...register(`test.${index}.firstName`)}  />
 *       ))}
 *       <button type="button" onClick={() => append({ firstName: "bill" })}>
 *         append
 *       </button>
 *       <input type="submit" />
 *     </form>
 *   );
 * }
 * ```
 */function t7(e){const t=e0();const{control:r=t.control,name:n,keyName:o="id",shouldUnregister:a,rules:i}=e;const[s,l]=v.useState(r._getFieldArray(n));const c=v.useRef(r._getFieldArray(n).map(t$));const u=v.useRef(s);const d=v.useRef(false);u.current=s;r._names.array.add(n);v.useMemo(()=>i&&r.register(n,i),[r,i,n]);e2(()=>r._subjects.array.subscribe({next:({values:e,name:t})=>{if(t===n||!t){const t=eU(e,n);if(Array.isArray(t)){l(t);c.current=t.map(t$)}}}}).unsubscribe,[r,n]);const f=v.useCallback(e=>{d.current=true;r._setFieldArray(n,e)},[r,n]);const p=(e,t)=>{const o=ti(eR(e));const a=tJ(r._getFieldArray(n),o);r._names.focus=tZ(n,a.length-1,t);c.current=tJ(c.current,o.map(t$));f(a);l(a);r._setFieldArray(n,a,tJ,{argA:t0(e)})};const h=(e,t)=>{const o=ti(eR(e));const a=t2(r._getFieldArray(n),o);r._names.focus=tZ(n,0,t);c.current=t2(c.current,o.map(t$));f(a);l(a);r._setFieldArray(n,a,t2,{argA:t0(e)})};const g=e=>{const t=t3(r._getFieldArray(n),e);c.current=t3(c.current,e);f(t);l(t);!Array.isArray(eU(r._fields,n))&&eQ(r._fields,n,undefined);r._setFieldArray(n,t,t3,{argA:e})};const m=(e,t,o)=>{const a=ti(eR(t));const i=t1(r._getFieldArray(n),e,a);r._names.focus=tZ(n,e,o);c.current=t1(c.current,e,a.map(t$));f(i);l(i);r._setFieldArray(n,i,t1,{argA:e,argB:t0(t)})};const b=(e,t)=>{const o=r._getFieldArray(n);t5(o,e,t);t5(c.current,e,t);f(o);l(o);r._setFieldArray(n,o,t5,{argA:e,argB:t},false)};const y=(e,t)=>{const o=r._getFieldArray(n);t6(o,e,t);t6(c.current,e,t);f(o);l(o);r._setFieldArray(n,o,t6,{argA:e,argB:t},false)};const _=(e,t)=>{const o=eR(t);const a=t8(r._getFieldArray(n),e,o);c.current=[...a].map((t,r)=>!t||r===e?t$():c.current[r]);f(a);l([...a]);r._setFieldArray(n,a,t8,{argA:e,argB:o},true,false)};const w=e=>{const t=ti(eR(e));c.current=t.map(t$);f([...t]);l([...t]);r._setFieldArray(n,[...t],e=>e,{},true,false)};v.useEffect(()=>{r._state.action=false;tN(n,r._names)&&r._subjects.state.next({...r._formState});if(d.current&&(!tH(r._options.mode).isOnSubmit||r._formState.isSubmitted)&&!tH(r._options.reValidateMode).isOnSubmit){if(r._options.resolver){r._runSchema([n]).then(e=>{const t=eU(e.errors,n);const o=eU(r._formState.errors,n);if(o?!t&&o.type||t&&(o.type!==t.type||o.message!==t.message):t&&t.type){t?eQ(r._formState.errors,n,t):tb(r._formState.errors,n);r._subjects.state.next({errors:r._formState.errors})}})}else{const e=eU(r._fields,n);if(e&&e._f&&!(tH(r._options.reValidateMode).isOnSubmit&&tH(r._options.mode).isOnSubmit)){tG(e,r._names.disabled,r._formValues,r._options.criteriaMode===e$.all,r._options.shouldUseNativeValidation,true).then(e=>!tl(e)&&r._subjects.state.next({errors:tV(r._formState.errors,e,n)}))}}}r._subjects.state.next({name:n,values:eR(r._formValues)});r._names.focus&&tP(r._fields,(e,t)=>{if(r._names.focus&&t.startsWith(r._names.focus)&&e.focus){e.focus();return 1}return});r._names.focus="";r._setValid();d.current=false},[s,n,r]);v.useEffect(()=>{!eU(r._formValues,n)&&r._setFieldArray(n);return()=>{const e=(e,t)=>{const n=eU(r._fields,e);if(n&&n._f){n._f.mount=t}};r._options.shouldUnregister||a?r.unregister(n):e(n,false)}},[n,r,o,a]);return{swap:v.useCallback(b,[f,n,r]),move:v.useCallback(y,[f,n,r]),prepend:v.useCallback(h,[f,n,r]),append:v.useCallback(p,[f,n,r]),remove:v.useCallback(g,[f,n,r]),insert:v.useCallback(m,[f,n,r]),update:v.useCallback(_,[f,n,r]),replace:v.useCallback(w,[f,n,r]),fields:v.useMemo(()=>s.map((e,t)=>({...e,[o]:c.current[t]||t$()})),[s,o])}}/**
 * Custom hook to manage the entire form.
 *
 * @remarks
 * [API](https://react-hook-form.com/docs/useform) • [Demo](https://codesandbox.io/s/react-hook-form-get-started-ts-5ksmm) • [Video](https://www.youtube.com/watch?v=RkXv4AXXC_4)
 *
 * @param props - form configuration and validation parameters.
 *
 * @returns methods - individual functions to manage the form state. {@link UseFormReturn}
 *
 * @example
 * ```tsx
 * function App() {
 *   const { register, handleSubmit, watch, formState: { errors } } = useForm();
 *   const onSubmit = data => console.log(data);
 *
 *   console.log(watch("example"));
 *
 *   return (
 *     <form onSubmit={handleSubmit(onSubmit)}>
 *       <input defaultValue="test" {...register("example")} />
 *       <input {...register("exampleRequired", { required: true })} />
 *       {errors.exampleRequired && <span>This field is required</span>}
 *       <button>Submit</button>
 *     </form>
 *   );
 * }
 * ```
 */function t9(e={}){const t=v.useRef(undefined);const r=v.useRef(undefined);const[n,o]=v.useState({isDirty:false,isValidating:false,isLoading:tu(e.defaultValues),isSubmitted:false,isSubmitting:false,isSubmitSuccessful:false,isValid:false,submitCount:0,dirtyFields:{},touchedFields:{},validatingFields:{},errors:e.errors||{},disabled:e.disabled||false,isReady:false,defaultValues:tu(e.defaultValues)?undefined:e.defaultValues});if(!t.current){if(e.formControl){t.current={...e.formControl,formState:n};if(e.defaultValues&&!tu(e.defaultValues)){e.formControl.reset(e.defaultValues,e.resetOptions)}}else{const{formControl:r,...o}=tX(e);t.current={...o,formState:n}}}const a=t.current.control;a._options=e;e2(()=>{const e=a._subscribe({formState:a._proxyFormState,callback:()=>o({...a._formState}),reRenderRoot:true});o(e=>({...e,isReady:true}));a._formState.isReady=true;return e},[a]);v.useEffect(()=>a._disableForm(e.disabled),[a,e.disabled]);v.useEffect(()=>{if(e.mode){a._options.mode=e.mode}if(e.reValidateMode){a._options.reValidateMode=e.reValidateMode}},[a,e.mode,e.reValidateMode]);v.useEffect(()=>{if(e.errors){a._setErrors(e.errors);a._focusError()}},[a,e.errors]);v.useEffect(()=>{e.shouldUnregister&&a._subjects.state.next({values:a._getWatch()})},[a,e.shouldUnregister]);v.useEffect(()=>{if(a._proxyFormState.isDirty){const e=a._getDirty();if(e!==n.isDirty){a._subjects.state.next({isDirty:e})}}},[a,n.isDirty]);v.useEffect(()=>{if(e.values&&!e7(e.values,r.current)){a._reset(e.values,{keepFieldsRef:true,...a._options.resetOptions});r.current=e.values;o(e=>({...e}))}else{a._resetDefaultValues()}},[a,e.values]);v.useEffect(()=>{if(!a._state.mount){a._setValid();a._state.mount=true}if(a._state.watch){a._state.watch=false;a._subjects.state.next({...a._formState})}a._removeUnmounted()});t.current.formState=e6(n,a);return t.current}//# sourceMappingURL=index.esm.mjs.map
// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Button.tsx
var re=r(3494);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/CheckBox.tsx
var rt=r(3953);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/LoadingSpinner.tsx
var rr=r(8589);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/styles.ts
var rn=r(4532);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/typography.ts
var ro=r(6439);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/controls/Show.tsx
var ra=r(1817);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/hoc/withVisibilityControl.tsx + 1 modules
var ri=r(9338);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/useDebounce.ts
var rs=function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:300;var[r,n]=(0,v.useState)(e);(0,v.useEffect)(()=>{var r=setTimeout(()=>{n(e)},t);return()=>{clearTimeout(r)}},[e,t]);return r};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/useFormWithGlobalError.ts
var rl=e=>{var[t,r]=(0,v.useState)();var n=t9(e);return(0,w._)((0,_._)({},n),{submitError:t,setSubmitError:r})};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/types.ts
var rc=r(7150);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/useIsScrolling.ts
var ru={defaultValue:false};var rd=e=>{var t=(0,v.useRef)(null);var r=(0,_._)({},ru,e);var[n,o]=(0,v.useState)(r.defaultValue);(0,v.useEffect)(()=>{if(!(0,rc/* .isDefined */.O9)(t.current)){return}if(t.current.scrollHeight<=t.current.clientHeight){o(false);return}var e=e=>{var t=e.target;if(t.scrollTop+t.clientHeight>=t.scrollHeight){o(false);return}o(t.scrollTop>=0)};t.current.addEventListener("scroll",e);return()=>{var r;(r=t.current)===null||r===void 0?void 0:r.removeEventListener("scroll",e)};// eslint-disable-next-line react-hooks/exhaustive-deps
},[t.current]);return{ref:t,isScrolling:n}};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/hooks/usePortalPopover.tsx
var rf=r(4938);// EXTERNAL MODULE: ./node_modules/@tanstack/react-query/build/legacy/useQuery.js + 6 modules
var rp=r(7359);// EXTERNAL MODULE: ./node_modules/@tanstack/react-query/build/legacy/useMutation.js + 1 modules
var rh=r(8856);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Toast.tsx
var rv=r(4857);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/api.ts + 50 modules
var rg=r(9576);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/endpoints.ts
var rm=r(7105);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/util.ts + 4 modules
var rb=r(6208);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/services/category.ts
var ry=e=>{return rg/* .wpAuthApiInstance.get */.v.get(rm/* ["default"].CATEGORIES */.A.CATEGORIES,e?{params:{per_page:100,search:e}}:{params:{per_page:100}})};var r_=e=>{return(0,rp/* .useQuery */.I)({queryKey:["CategoryList",e],queryFn:()=>ry(e).then(e=>e.data)})};var rw=e=>{return rg/* .wpAuthApiInstance.post */.v.post(rm/* ["default"].CATEGORIES */.A.CATEGORIES,e)};var rx=()=>{var e=(0,f/* .useQueryClient */.jE)();var{showToast:t}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:rw,onSuccess:()=>{e.invalidateQueries({queryKey:["CategoryList"]})},onError:e=>{// @TODO: Need to add proper type definition for wp rest api errors
t({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(e)})}})};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/style-utils.ts
var rA=r(6014);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/fields/FormFieldWrapper.tsx
var rk=r(3347);// CONCATENATED MODULE: ../tutor/node_modules/@swc/helpers/esm/_async_to_generator.js
function rY(e,t,r,n,o,a,i){try{var s=e[a](i);var l=s.value}catch(e){r(e);return}if(s.done)t(l);else Promise.resolve(l).then(n,o)}function rI(e){return function(){var t=this,r=arguments;return new Promise(function(n,o){var a=e.apply(t,r);function i(e){rY(a,n,o,i,s,"next",e)}function s(e){rY(a,n,o,i,s,"throw",e)}i(undefined)})}}// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_without_properties.js + 1 modules
var rD=r(9414);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/constants.ts
var rC=r(5781);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/create-variation.ts
var rS=r(8631);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/MagicButton.tsx
var rM=/*#__PURE__*/g().forwardRef((e,t)=>{var{className:r,variant:n,size:o,children:a,type:i="button",disabled:s=false,roundedFull:l=true,loading:c}=e,d=(0,rD._)(e,["className","variant","size","children","type","disabled","roundedFull","loading"]);return/*#__PURE__*/(0,u/* .jsx */.Y)("button",(0,w._)((0,_._)({type:i,ref:t,css:rH({variant:n,size:o,rounded:l?"true":"false"}),className:r,disabled:s},d),{children:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:rF.buttonSpan,children:c?/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* ["default"] */.Ay,{size:24}):a})}))});/* ESM default export */const rE=rM;var rF={buttonSpan:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.flexCenter */.x.flexCenter(),";z-index:",rn/* .zIndex.positive */.fE.positive,";"),base:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.small */.I.small("medium"),";display:flex;gap:",rn/* .spacing["4"] */.YK["4"],";width:100%;justify-content:center;align-items:center;white-space:nowrap;position:relative;overflow:hidden;transition:box-shadow 0.5s ease;&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}&:disabled{cursor:not-allowed;background:",rn/* .colorTokens.action.primary.disable */.I6.action.primary.disable,";pointer-events:none;color:",rn/* .colorTokens.text.disable */.I6.text.disable,";border-color:",rn/* .colorTokens.stroke.disable */.I6.stroke.disable,";}"),default:e=>/*#__PURE__*/(0,d/* .css */.AH)("background:",!e?rn/* .colorTokens.ai.gradient_1 */.I6.ai.gradient_1:rn/* .colorTokens.ai.gradient_1_rtl */.I6.ai.gradient_1_rtl,";color:",rn/* .colorTokens.text.white */.I6.text.white,";&::before{content:'';position:absolute;inset:0;background:",!e?rn/* .colorTokens.ai.gradient_2 */.I6.ai.gradient_2:rn/* .colorTokens.ai.gradient_2_rtl */.I6.ai.gradient_2_rtl,";opacity:0;transition:opacity 0.5s ease;}&:hover::before{opacity:1;}"),secondary:/*#__PURE__*/(0,d/* .css */.AH)("background-color:",rn/* .colorTokens.action.secondary["default"] */.I6.action.secondary["default"],";color:",rn/* .colorTokens.text.brand */.I6.text.brand,";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";&:hover{background-color:",rn/* .colorTokens.action.secondary.hover */.I6.action.secondary.hover,";}"),outline:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;&::before{content:'';position:absolute;inset:0;background:",rn/* .colorTokens.ai.gradient_1 */.I6.ai.gradient_1,";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";border:1px solid transparent;-webkit-mask:linear-gradient(#fff 0 0) padding-box,linear-gradient(#fff 0 0);mask:linear-gradient(#fff 0 0) padding-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;}&:hover{&::before{background:",rn/* .colorTokens.ai.gradient_2 */.I6.ai.gradient_2,";}}"),primaryOutline:/*#__PURE__*/(0,d/* .css */.AH)("border:1px solid ",rn/* .colorTokens.brand.blue */.I6.brand.blue,";color:",rn/* .colorTokens.brand.blue */.I6.brand.blue,";&:hover{background-color:",rn/* .colorTokens.brand.blue */.I6.brand.blue,";color:",rn/* .colorTokens.text.white */.I6.text.white,";}"),primary:/*#__PURE__*/(0,d/* .css */.AH)("background-color:",rn/* .colorTokens.brand.blue */.I6.brand.blue,";color:",rn/* .colorTokens.text.white */.I6.text.white,";"),ghost:/*#__PURE__*/(0,d/* .css */.AH)("background-color:transparent;color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";&:hover{color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}"),plain:/*#__PURE__*/(0,d/* .css */.AH)("span{background:",!rC/* .isRTL */.V8?rn/* .colorTokens.text.ai.gradient */.I6.text.ai.gradient:rn/* .colorTokens.ai.gradient_1_rtl */.I6.ai.gradient_1_rtl,";background-clip:text;-webkit-background-clip:text;-webkit-text-fill-color:transparent;&:hover{background:",!rC/* .isRTL */.V8?rn/* .colorTokens.ai.gradient_2 */.I6.ai.gradient_2:rn/* .colorTokens.ai.gradient_2_rtl */.I6.ai.gradient_2_rtl,";background-clip:text;-webkit-background-clip:text;-webkit-text-fill-color:transparent;}}"),size:{default:/*#__PURE__*/(0,d/* .css */.AH)("height:32px;padding-inline:",rn/* .spacing["12"] */.YK["12"],";padding-block:",rn/* .spacing["4"] */.YK["4"],";"),sm:/*#__PURE__*/(0,d/* .css */.AH)("height:24px;padding-inline:",rn/* .spacing["10"] */.YK["10"],";"),icon:/*#__PURE__*/(0,d/* .css */.AH)("width:32px;height:32px;")},rounded:{true:/*#__PURE__*/(0,d/* .css */.AH)("border-radius:",rn/* .borderRadius["54"] */.Vq["54"],";&::before{border-radius:",rn/* .borderRadius["54"] */.Vq["54"],";}"),false:/*#__PURE__*/(0,d/* .css */.AH)("border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";&::before{border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";}")}};var rH=(0,rS/* .createVariation */.s)({variants:{variant:{default:rF.default(rC/* .isRTL */.V8),primary:rF.primary,secondary:rF.secondary,outline:rF.outline,primary_outline:rF.primaryOutline,ghost:rF.ghost,plain:rF.plain},size:{default:rF.size.default,sm:rF.size.sm,icon:rF.size.icon},rounded:{true:rF.rounded.true,false:rF.rounded.false}},defaultVariants:{variant:"default",size:"default",rounded:"true"}},rF.base);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/molecules/Popover.tsx
var rT=r(1554);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/fields/FormTextareaInput.tsx
var rO=r(8466);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/controls/For.tsx
var rK=r(3313);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-content/OptionList.tsx
var rN=e=>{var{options:t,onChange:r}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:rP.wrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:t,children:(e,t)=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",onClick:()=>r(e.value),css:rP.item,children:e.label},t)}})})};var rP={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;padding-block:",rn/* .spacing["8"] */.YK["8"],";max-height:400px;overflow-y:auto;"),item:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.caption */.I.caption(),";width:100%;padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["16"] */.YK["16"],";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";display:flex;align-items:center;&:hover{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";color:",rn/* .colorTokens.text.title */.I6.text.title,";}")};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/hooks/useAnimation.tsx + 1 modules
var rL=r(4897);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/useSelectKeyboardNavigation.ts
var rW=e=>{var{options:t,isOpen:r,onSelect:n,onClose:o,selectedValue:a}=e;var[i,s]=(0,v.useState)(-1);var l=(0,v.useCallback)(e=>{if(!r)return;var a=(e,r)=>{var n;var o=e;var a=r==="down"?1:-1;do{o+=a;if(o<0)o=t.length-1;if(o>=t.length)o=0}while(o>=0&&o<t.length&&t[o].disabled)if((n=t[o])===null||n===void 0?void 0:n.disabled){return e}return o};switch(e.key){case"ArrowDown":e.preventDefault();s(e=>{var t=a(e===-1?0:e,"down");return t});break;case"ArrowUp":e.preventDefault();s(e=>{var t=a(e===-1?0:e,"up");return t});break;case"Enter":e.preventDefault();e.stopPropagation();if(i>=0&&i<t.length){var l=t[i];if(!l.disabled){o();n(l)}}break;case"Escape":e.preventDefault();e.stopPropagation();o();break;default:break}},[r,t,i,n,o]);(0,v.useEffect)(()=>{if(r){if(i===-1){var e=t.findIndex(e=>e.value===a);var n=e>=0?e:t.findIndex(e=>!e.disabled);s(n)}document.addEventListener("keydown",l,true);return()=>document.removeEventListener("keydown",l,true)}},[r,l,t,a,i]);(0,v.useEffect)(()=>{if(!r){s(-1)}},[r]);var c=(0,v.useCallback)(e=>{var r;if(!((r=t[e])===null||r===void 0?void 0:r.disabled)){s(e)}},[t]);return{activeIndex:i,setActiveIndex:c}};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormSelectInput.tsx
function rB(){var e=(0,x._)(["\n      &::before {\n        content: '';\n        position: absolute;\n        inset: 0;\n        background: ",";\n        color: ",";\n        border: 1px solid transparent;\n        -webkit-mask:\n          linear-gradient(#fff 0 0) padding-box,\n          linear-gradient(#fff 0 0);\n        -webkit-mask-composite: xor;\n        mask-composite: exclude;\n        border-radius: 6px;\n      }\n    "]);rB=function t(){return e};return e}function rR(){var e=(0,x._)(["\n        padding-left: ",";\n      "]);rR=function t(){return e};return e}function rz(){var e=(0,x._)(["\n        &.tutor-input-field {\n          height: 56px;\n          padding-bottom: ",";\n        }\n      "]);rz=function t(){return e};return e}function rV(){var e=(0,x._)(["\n        background-color: ",";\n      "]);rV=function t(){return e};return e}function rj(){var e=(0,x._)(["\n        position: relative;\n        border: none;\n        background: transparent;\n      "]);rj=function t(){return e};return e}function rq(){var e=(0,x._)(["\n          outline-color: ",";\n          background-color: ",";\n        "]);rq=function t(){return e};return e}function rU(){var e=(0,x._)(["\n          border-color: ",";\n          background-color: ",";\n        "]);rU=function t(){return e};return e}function rG(){var e=(0,x._)(["\n      padding-left: calc("," + 1px);\n    "]);rG=function t(){return e};return e}function rQ(){var e=(0,x._)(["\n        color: ",";\n\n        &:hover {\n          text-decoration: underline;\n        }\n      "]);rQ=function t(){return e};return e}function rX(){var e=(0,x._)(["\n      min-width: 200px;\n    "]);rX=function t(){return e};return e}function r$(){var e=(0,x._)(["\n      background-color: ",";\n    "]);r$=function t(){return e};return e}function rZ(){var e=(0,x._)(["\n      background-color: ",";\n      position: relative;\n\n      &::before {\n        content: '';\n        position: absolute;\n        top: 0;\n        left: 0;\n        width: 3px;\n        height: 100%;\n        background-color: ",";\n        border-radius: 0 "," "," 0;\n      }\n    "]);rZ=function t(){return e};return e}function rJ(){var e=(0,x._)(["\n      transform: rotate(180deg);\n    "]);rJ=function t(){return e};return e}var r0=e=>{var{options:t,field:r,fieldState:n,onChange:o=rb/* .noop */.lQ,label:a,placeholder:i="",disabled:s,readOnly:l,loading:c,isSearchable:d=false,isInlineLabel:f,hideCaret:p,listLabel:g,isClearable:m=false,helpText:b,removeOptionsMinWidth:x=false,leftIcon:A,removeBorder:k,dataAttribute:Y,isSecondary:I=false,isMagicAi:D=false,isAiOutline:C=false,selectOnFocus:S,optionItemCss:M}=e;var E;var F=(0,v.useCallback)(()=>t.find(e=>e.value===r.value)||{label:"",value:"",description:""},[r.value,t]);var H=(0,v.useMemo)(()=>t.some(e=>(0,rc/* .isDefined */.O9)(e.description)),[t]);var[T,O]=(0,v.useState)((E=F())===null||E===void 0?void 0:E.label);var[K,N]=(0,v.useState)(false);var[P,L]=(0,v.useState)("");var[W,B]=(0,v.useState)(false);var R=(0,v.useRef)(null);var z=(0,v.useRef)(null);var V=(0,v.useRef)(null);var j=(0,v.useRef)(null);var q=(0,v.useMemo)(()=>{if(d){return t.filter(e=>{var{label:t}=e;return t.toLowerCase().includes(P.toLowerCase())})}return t},[P,d,t]);var U=(0,v.useMemo)(()=>{return t.find(e=>e.value===r.value)},[r.value,t]);var G=(0,_._)({},(0,rc/* .isDefined */.O9)(Y)&&{[Y]:true});(0,v.useEffect)(()=>{var e;O((e=F())===null||e===void 0?void 0:e.label)},[r.value,F]);(0,v.useEffect)(()=>{if(W){var e;O((e=F())===null||e===void 0?void 0:e.label)}},[F,W]);var Q=(e,t)=>{t===null||t===void 0?void 0:t.stopPropagation();if(!e.disabled){r.onChange(e.value);o(e);L("");N(false);B(false)}};var{activeIndex:X,setActiveIndex:$}=rW({options:q,isOpen:W,selectedValue:r.value,onSelect:Q,onClose:()=>{B(false);N(false);L("")}});(0,v.useEffect)(()=>{if(W&&X>=0&&j.current){j.current.scrollIntoView({block:"nearest",behavior:"smooth"})}},[W,X]);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{fieldState:n,field:r,label:a,disabled:s||t.length===0,readOnly:l,loading:c,isInlineLabel:f,helpText:b,removeBorder:k,isSecondary:I,isMagicAi:D,children:e=>{var o,a;var{css:f}=e,v=(0,rD._)(e,["css"]);return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:r6.mainWrapper,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:r6.inputWrapper(C),ref:z,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:r6.leftIcon,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:A,children:A}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:U===null||U===void 0?void 0:U.icon,children:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:e,width:32,height:32})})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:{width:"100%"},children:[/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},v,G),{ref:e=>{r.ref(e);// @ts-ignore
R.current=e;// this is not ideal but it is the only way to set ref to the input element
},className:"tutor-input-field",css:[f,r6.input({hasLeftIcon:!!A||!!(U===null||U===void 0?void 0:U.icon),hasDescription:H,hasError:!!n.error,isMagicAi:D,isAiOutline:C})],autoComplete:"off",readOnly:l||!d,placeholder:i,value:K?P:T,title:T,onClick:e=>{var t;e.stopPropagation();B(e=>!e);(t=R.current)===null||t===void 0?void 0:t.focus()},onKeyDown:e=>{if(e.key==="Enter"){var t;e.preventDefault();B(e=>!e);(t=R.current)===null||t===void 0?void 0:t.focus()}if(e.key==="Tab"){B(false)}},onFocus:S&&d?e=>{e.target.select()}:undefined,onChange:e=>{O(e.target.value);if(d){N(true);L(e.target.value)}},"data-select":true})),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:H,children:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:r6.description({hasLeftIcon:!!A}),title:(o=F())===null||o===void 0?void 0:o.description,children:(a=F())===null||a===void 0?void 0:a.description})})]}),!p&&!c&&/*#__PURE__*/(0,u/* .jsx */.Y)("button",{tabIndex:-1,type:"button",css:r6.caretButton({isOpen:W}),onClick:()=>{var e;B(e=>!e);(e=R.current)===null||e===void 0?void 0:e.focus()},disabled:s||l||t.length===0,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"chevronDown",width:20,height:20})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{triggerRef:z,isOpen:W,dependencies:[q.length],animationType:rL/* .AnimationType.slideDown */.J6.slideDown,closePopover:()=>{B(false);N(false);L("")},children:/*#__PURE__*/(0,u/* .jsxs */.FD)("ul",{css:[r6.options(x)],children:[!!g&&/*#__PURE__*/(0,u/* .jsx */.Y)("li",{css:r6.listLabel,children:g}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:q.length>0,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("li",{css:r6.emptyState,children:(0,h.__)("No options available","tutor-pro")}),children:q.map((e,t)=>/*#__PURE__*/(0,u/* .jsx */.Y)("li",{ref:e.value===r.value?V:X===t?j:null,css:[r6.optionItem({isSelected:e.value===r.value,isActive:t===X,isDisabled:!!e.disabled}),M],children:/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:r6.label,onClick:t=>{if(!e.disabled){Q(e,t)}},disabled:e.disabled,title:e.label,onMouseOver:()=>$(t),onMouseLeave:()=>t!==X&&$(-1),onFocus:()=>$(t),"aria-selected":X===t,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:e.icon,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:e.icon,width:32,height:32})}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:e.label})]})},String(e.value)))}),m&&/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:r6.clearButton({isDisabled:T===""}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text",disabled:T==="",icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"delete"}),onClick:()=>{r.onChange(null);O("");L("");B(false)},children:(0,h.__)("Clear","tutor-pro")})})]})})]})}})};/* ESM default export */const r1=r0;var r6={mainWrapper:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;"),inputWrapper:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:false;return/*#__PURE__*/(0,d/* .css */.AH)("width:100%;display:flex;justify-content:space-between;align-items:center;position:relative;",e&&(0,d/* .css */.AH)(rB(),rn/* .colorTokens.ai.gradient_1 */.I6.ai.gradient_1,rn/* .colorTokens.text.primary */.I6.text.primary))},leftIcon:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;left:",rn/* .spacing["8"] */.YK["8"],";",rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;height:100%;color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";"),input:e=>{var{hasLeftIcon:t,hasDescription:r,hasError:n=false,isMagicAi:o=false,isAiOutline:a=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)("&[data-select]{",ro/* .typography.body */.I.body(),";width:100%;cursor:pointer;padding-right:",rn/* .spacing["32"] */.YK["32"],";",rA/* .styleUtils.textEllipsis */.x.textEllipsis,";background-color:transparent;background-color:",rn/* .colorTokens.background.white */.I6.background.white,";",t&&(0,d/* .css */.AH)(rR(),rn/* .spacing["48"] */.YK["48"])," ",r&&(0,d/* .css */.AH)(rz(),rn/* .spacing["24"] */.YK["24"])," ",n&&(0,d/* .css */.AH)(rV(),rn/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail)," ",a&&(0,d/* .css */.AH)(rj()),":focus{",rA/* .styleUtils.inputFocus */.x.inputFocus,";",o&&(0,d/* .css */.AH)(rq(),rn/* .colorTokens.stroke.magicAi */.I6.stroke.magicAi,rn/* .colorTokens.background.magicAi["8"] */.I6.background.magicAi["8"])," ",n&&(0,d/* .css */.AH)(rU(),rn/* .colorTokens.stroke.danger */.I6.stroke.danger,rn/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail),"}}")},description:e=>{var{hasLeftIcon:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small(),";",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),"    color:",rn/* .colorTokens.text.hints */.I6.text.hints,";position:absolute;bottom:",rn/* .spacing["8"] */.YK["8"],";padding-inline:calc(",rn/* .spacing["16"] */.YK["16"]," + 1px) ",rn/* .spacing["32"] */.YK["32"],";",t&&(0,d/* .css */.AH)(rG(),rn/* .spacing["48"] */.YK["48"]))},listLabel:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";min-height:40px;display:flex;align-items:center;padding-left:",rn/* .spacing["16"] */.YK["16"],";"),clearButton:e=>{var{isDisabled:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["8"] */.YK["8"],";border-top:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";& > button{padding:0;width:100%;font-size:",rn/* .fontSize["12"] */.J["12"],";> span{justify-content:center;}",!t&&(0,d/* .css */.AH)(rQ(),rn/* .colorTokens.text.title */.I6.text.title),"}")},options:e=>/*#__PURE__*/(0,d/* .css */.AH)("z-index:",rn/* .zIndex.dropdown */.fE.dropdown,";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";list-style-type:none;box-shadow:",rn/* .shadow.popover */.r7.popover,";padding:",rn/* .spacing["4"] */.YK["4"]," 0;margin:0;max-height:500px;border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";",rA/* .styleUtils.overflowYAuto */.x.overflowYAuto,";scrollbar-gutter:auto;",!e&&(0,d/* .css */.AH)(rX())),optionItem:e=>{var{isSelected:t=false,isActive:r=false,isDisabled:n=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body(),";min-height:36px;height:100%;width:100%;display:flex;align-items:center;transition:background-color 0.3s ease-in-out;cursor:",n?"not-allowed":"pointer",";opacity:",n?.5:1,";",r&&(0,d/* .css */.AH)(r$(),rn/* .colorTokens.background.hover */.I6.background.hover),"    &:hover{background-color:",!n&&rn/* .colorTokens.background.hover */.I6.background.hover,";}",!n&&t&&(0,d/* .css */.AH)(rZ(),rn/* .colorTokens.background.active */.I6.background.active,rn/* .colorTokens.action.primary["default"] */.I6.action.primary["default"],rn/* .borderRadius["6"] */.Vq["6"],rn/* .borderRadius["6"] */.Vq["6"]))},label:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),";color:",rn/* .colorTokens.text.title */.I6.text.title,";width:100%;height:100%;display:flex;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";margin:0 ",rn/* .spacing["12"] */.YK["12"],";padding:",rn/* .spacing["6"] */.YK["6"]," 0;text-align:left;line-height:",rn/* .lineHeight["24"] */.K_["24"],";word-break:break-all;cursor:pointer;&:hover,&:focus,&:active{background-color:transparent;color:",rn/* .colorTokens.text.title */.I6.text.title,";}span{flex-shrink:0;",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),"      width:100%;}"),arrowUpDown:/*#__PURE__*/(0,d/* .css */.AH)("color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";display:flex;justify-content:center;align-items:center;margin-top:",rn/* .spacing["2"] */.YK["2"],";"),optionsContainer:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;overflow:hidden auto;min-width:16px;max-width:calc(100% - 32px);"),caretButton:e=>{var{isOpen:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";position:absolute;right:",rn/* .spacing["4"] */.YK["4"],";display:flex;align-items:center;transition:transform 0.3s ease-in-out;color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";padding:",rn/* .spacing["6"] */.YK["6"],";height:100%;&:focus,&:active,&:hover{background:none;color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";}&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";}",t&&(0,d/* .css */.AH)(rJ()))},emptyState:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.flexCenter */.x.flexCenter(),";padding:",rn/* .spacing["8"] */.YK["8"],";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/config/magic-ai.ts
var r2=[{label:"English",value:"english"},{label:"简体中文",value:"simplified-chinese"},{label:"繁體中文",value:"traditional-chinese"},{label:"Español",value:"spanish"},{label:"Français",value:"french"},{label:"日本語",value:"japanese"},{label:"Deutsch",value:"german"},{label:"Português",value:"portuguese"},{label:"العربية",value:"arabic"},{label:"Русский",value:"russian"},{label:"Italiano",value:"italian"},{label:"한국어",value:"korean"},{label:"हिन्दी",value:"hindi"},{label:"Nederlands",value:"dutch"},{label:"Polski",value:"polish"},{label:"አማርኛ",value:"amharic"},{label:"Български",value:"bulgarian"},{label:"বাংলা",value:"bengali"},{label:"Čeština",value:"czech"},{label:"Dansk",value:"danish"},{label:"Ελληνικά",value:"greek"},{label:"Eesti",value:"estonian"},{label:"فارسی",value:"persian"},{label:"Filipino",value:"filipino"},{label:"Hrvatski",value:"croatian"},{label:"Magyar",value:"hungarian"},{label:"Bahasa Indonesia",value:"indonesian"},{label:"Lietuvių",value:"lithuanian"},{label:"Latviešu",value:"latvian"},{label:"Melayu",value:"malay"},{label:"Norsk",value:"norwegian"},{label:"Română",value:"romanian"},{label:"Slovenčina",value:"slovak"},{label:"Slovenščina",value:"slovenian"},{label:"Српски",value:"serbian"},{label:"Svenska",value:"swedish"},{label:"ภาษาไทย",value:"thai"},{label:"Türkçe",value:"turkish"},{label:"Українська",value:"ukrainian"},{label:"اردو",value:"urdu"},{label:"Tiếng Việt",value:"vietnamese"}];var r4=[{label:(0,h.__)("Formal","tutor-pro"),value:"formal"},{label:(0,h.__)("Casual","tutor-pro"),value:"casual"},{label:(0,h.__)("Professional","tutor-pro"),value:"professional"},{label:(0,h.__)("Enthusiastic","tutor-pro"),value:"enthusiastic"},{label:(0,h.__)("Informational","tutor-pro"),value:"informational"},{label:(0,h.__)("Funny","tutor-pro"),value:"funny"}];var r3=[{label:(0,h.__)("Title","tutor-pro"),value:"title"},{label:(0,h.__)("Essay","tutor-pro"),value:"essay"},{label:(0,h.__)("Paragraph","tutor-pro"),value:"paragraph"},{label:(0,h.__)("Outline","tutor-pro"),value:"outline"}];// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-content/PromptControls.tsx
var r5=e=>{var{form:t}=e;return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:r8.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:t.control,name:"characters",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oh,(0,w._)((0,_._)({},e),{isMagicAi:true,label:(0,h.__)("Character Limit","tutor-pro"),type:"number"}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:t.control,name:"language",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(r1,(0,w._)((0,_._)({},e),{isMagicAi:true,label:(0,h.__)("Language","tutor-pro"),options:r2}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:t.control,name:"tone",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(r1,(0,w._)((0,_._)({},e),{isMagicAi:true,options:r4,label:(0,h.__)("Tone","tutor-pro")}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:t.control,name:"format",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(r1,(0,w._)((0,_._)({},e),{isMagicAi:true,label:(0,h.__)("Format","tutor-pro"),options:r3}))})]})};var r8={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:repeat(2,1fr);gap:",rn/* .spacing["16"] */.YK["16"],";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/Skeleton.tsx
function r7(){var e=(0,x._)(["\n      border-radius: ",";\n    "]);r7=function t(){return e};return e}function r9(){var e=(0,x._)(["\n          background: linear-gradient(89.17deg, #fef4ff 0.2%, #f9d3ff 50.09%, #fef4ff 96.31%);\n        "]);r9=function t(){return e};return e}function ne(){var e=(0,x._)(["\n      :after {\n        content: '';\n        background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.05), transparent);\n        position: absolute;\n        transform: translateX(-100%);\n        inset: 0;\n        ","\n\n        animation: ","s linear 0.5s infinite normal none running ",";\n      }\n    "]);ne=function t(){return e};return e}var nt=/*#__PURE__*/(0,v.forwardRef)((e,t)=>{var{width:r="100%",height:n=16,animation:o=false,isMagicAi:a=false,isRound:i=false,animationDuration:s=1.6,className:l}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)("span",{ref:t,css:no.skeleton(r,n,o,a,i,s),className:l})});/* ESM default export */const nr=nt;var nn={wave:/*#__PURE__*/(0,d/* .keyframes */.i7)("0%{transform:translateX(-100%);}50%{transform:translateX(0%);}100%{transform:translateX(100%);}")};var no={skeleton:(e,t,r,n,o,a)=>/*#__PURE__*/(0,d/* .css */.AH)("display:block;width:",(0,rc/* .isNumber */.Et)(e)?"".concat(e,"px"):e,";height:",(0,rc/* .isNumber */.Et)(t)?"".concat(t,"px"):t,";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";background-color:",!n?"rgba(0, 0, 0, 0.11)":rn/* .colorTokens.background.magicAi.skeleton */.I6.background.magicAi.skeleton,";position:relative;-webkit-mask-image:-webkit-radial-gradient(center,white,black);overflow:hidden;",o&&(0,d/* .css */.AH)(r7(),rn/* .borderRadius.circle */.Vq.circle)," ",r&&(0,d/* .css */.AH)(ne(),n&&(0,d/* .css */.AH)(r9()),a,nn.wave))};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-content/SkeletonLoader.tsx
var na=()=>{return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:ns.container,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:ns.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,isMagicAi:true,width:"20%",height:"12px"}),/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,isMagicAi:true,width:"100%",height:"12px"}),/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,isMagicAi:true,width:"100%",height:"12px"}),/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,isMagicAi:true,width:"40%",height:"12px"})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:ns.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,isMagicAi:true,width:"80%",height:"12px"}),/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,isMagicAi:true,width:"100%",height:"12px"}),/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,isMagicAi:true,width:"80%",height:"12px"})]})]})};/* ESM default export */const ni=na;var ns={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";"),container:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["32"] */.YK["32"],";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/services/magic-ai.ts
var nl=e=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].GENERATE_AI_IMAGE */.A.GENERATE_AI_IMAGE,e)};var nc=()=>{return(0,rh/* .useMutation */.n)({mutationFn:nl})};var nu=e=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].MAGIC_FILL_AI_IMAGE */.A.MAGIC_FILL_AI_IMAGE,e).then(e=>e.data.data[0].b64_json)};var nd=()=>{var{showToast:e}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:nu,onError:t=>{e({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(t)})}})};var nf=e=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].MAGIC_TEXT_GENERATION */.A.MAGIC_TEXT_GENERATION,e)};var np=()=>{var{showToast:e}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:nf,onError:t=>{e({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(t)})}})};var nh=e=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].MAGIC_AI_MODIFY_CONTENT */.A.MAGIC_AI_MODIFY_CONTENT,e)};var nv=()=>{var{showToast:e}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:nh,onError:t=>{e({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(t)})}})};var ng=e=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].USE_AI_GENERATED_IMAGE */.A.USE_AI_GENERATED_IMAGE,e)};var nm=()=>{var{showToast:e}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:ng,onError:t=>{e({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(t)})}})};var nb=e=>{return wpAjaxInstance.post(endpoints.GENERATE_COURSE_CONTENT,e,{signal:e.signal})};var ny=e=>{var{showToast:t}=useToast();return useMutation({mutationKey:["GenerateCourseContent",e],mutationFn:nb,onError:e=>{t({type:"danger",message:convertToErrorMessage(e)})}})};var n_=e=>{return wpAjaxInstance.post(endpoints.GENERATE_COURSE_CONTENT,e,{signal:e.signal})};var nw=()=>{var{showToast:e}=useToast();return useMutation({mutationFn:n_,onError:t=>{e({type:"danger",message:convertToErrorMessage(t)})}})};var nx=e=>{return wpAjaxInstance.post(endpoints.GENERATE_COURSE_TOPIC_CONTENT,e,{signal:e.signal})};var nA=()=>{var{showToast:e}=useToast();return useMutation({mutationFn:nx,onError:t=>{e({type:"danger",message:convertToErrorMessage(t)})}})};var nk=e=>{return wpAjaxInstance.post(endpoints.SAVE_AI_GENERATED_COURSE_CONTENT,e)};var nY=()=>{var{showToast:e}=useToast();var t=useQueryClient();return useMutation({mutationFn:nk,onSuccess(){t.invalidateQueries({queryKey:["CourseDetails"]})},onError:t=>{e({type:"danger",message:convertToErrorMessage(t)})}})};var nI=e=>{return wpAjaxInstance.post(endpoints.GENERATE_QUIZ_QUESTIONS,e,{signal:e.signal})};var nD=()=>{var{showToast:e}=useToast();return useMutation({mutationFn:nI,onError:t=>{e({type:"danger",message:convertToErrorMessage(t)})}})};var nC=e=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].OPEN_AI_SAVE_SETTINGS */.A.OPEN_AI_SAVE_SETTINGS,(0,_._)({},e))};var nS=()=>{var{showToast:e}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:nC,onSuccess:t=>{e({type:"success",message:t.message})},onError:t=>{e({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(t)})}})};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/modals/BasicModalWrapper.tsx
var nM=r(9641);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/modals/AITextModal.tsx
var nE=[(0,h.__)("Mastering Digital Marketing: A Complete Guide","tutor-pro"),(0,h.__)("The Ultimate Photoshop Course for Beginners","tutor-pro"),(0,h.__)("Python Programming: From Zero to Hero","tutor-pro"),(0,h.__)("Creative Writing Essentials: Unlock Your Storytelling Potential","tutor-pro"),(0,h.__)("The Complete Guide to Web Development with React","tutor-pro"),(0,h.__)("Master Public Speaking: Deliver Powerful Presentations","tutor-pro"),(0,h.__)("Excel for Business: From Basics to Advanced Analytics","tutor-pro"),(0,h.__)("Fitness Fundamentals: Build Strength and Confidence","tutor-pro"),(0,h.__)("Photography Made Simple: Capture Stunning Shots","tutor-pro"),(0,h.__)("Financial Freedom: Learn the Basics of Investing","tutor-pro")];var nF=e=>{var{title:t,icon:r,closeModal:n,field:o,format:a="essay",characters:i=250,is_html:s=false,fieldLabel:l="",fieldPlaceholder:c=""}=e;var f=rl({defaultValues:{prompt:"",characters:i,language:"english",tone:"formal",format:a}});var p=np();var g=nv();var[m,b]=(0,v.useState)([]);var[x,A]=(0,v.useState)(0);var[k,Y]=(0,v.useState)(false);var[I,D]=(0,v.useState)(null);var C=(0,v.useRef)(null);var S=(0,v.useRef)(null);var M=(0,v.useMemo)(()=>{return m[x]},[m,x]);var E=f.watch("prompt");function F(e){b(t=>[e,...t]);A(0)}function H(e,t){return rI(function*(){if(m.length===0){return}var r=m[x];if(e==="translation"&&!!t){var n=yield g.mutateAsync({type:"translation",content:r,language:t,is_html:s});if(n.data){F(n.data)}return}if(e==="change_tone"&&!!t){var o=yield g.mutateAsync({type:"change_tone",content:r,tone:t,is_html:s});if(o.data){F(o.data)}return}var a=yield g.mutateAsync({type:e,content:r,is_html:s});if(a.data){F(a.data)}})()}(0,v.useEffect)(()=>{f.setFocus("prompt");// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);return/*#__PURE__*/(0,u/* .jsx */.Y)(nM/* ["default"] */.A,{onClose:n,title:t,icon:r,maxWidth:524,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("form",{onSubmit:f.handleSubmit(e=>rI(function*(){var t=yield p.mutateAsync((0,w._)((0,_._)({},e),{is_html:s}));if(t.data){F(t.data)}})()),children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nT.container,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nT.fieldsWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:f.control,name:"prompt",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(rO/* ["default"] */.A,(0,w._)((0,_._)({},e),{label:l||(0,h.__)("Craft Your Course Description","tutor-pro"),placeholder:c||(0,h.__)("Provide a brief overview of your course topic, target audience, and key takeaways","tutor-pro"),rows:4,isMagicAi:true}))}),/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:nT.inspireButton,onClick:()=>{var e=nE.length;var t=Math.floor(Math.random()*e);f.reset((0,w._)((0,_._)({},f.getValues()),{prompt:nE[t]}))},children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"bulbLine"}),(0,h.__)("Inspire Me","tutor-pro")]})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!p.isPending&&!g.isPending,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)(ni,{}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)(ra/* ["default"] */.A,{when:m.length>0,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)(r5,{form:f}),children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nT.actionBar,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:nT.navigation,children:/*#__PURE__*/(0,u/* .jsxs */.FD)(ra/* ["default"] */.A,{when:m.length>1,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text",onClick:()=>A(e=>Math.max(0,e-1)),disabled:x===0,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:!rC/* .isRTL */.V8?"chevronLeft":"chevronRight",width:20,height:20})}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nT.pageInfo,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:x+1})," / ",m.length]}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text",onClick:()=>A(e=>Math.min(m.length-1,e+1)),disabled:x===m.length-1,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:!rC/* .isRTL */.V8?"chevronRight":"chevronLeft",width:20,height:20})})]})}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text",onClick:()=>rI(function*(){if(m.length===0){return}var e=m[x];yield(0,rb/* .copyToClipboard */.lW)(e);Y(true);setTimeout(()=>{Y(false)},1500)})(),children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:k,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"copy",width:20,height:20}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"checkFilled",width:20,height:20,style:/*#__PURE__*/(0,d/* .css */.AH)("color:",rn/* .colorTokens.text.success */.I6.text.success," !important;")})})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:nT.content,dangerouslySetInnerHTML:{__html:M}})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nT.otherActions,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"outline",roundedFull:false,onClick:()=>H("rephrase"),children:(0,h.__)("Rephrase","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"outline",roundedFull:false,onClick:()=>H("make_shorter"),children:(0,h.__)("Make Shorter","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)(rE,{variant:"outline",roundedFull:false,ref:C,onClick:()=>D("tone"),children:[(0,h.__)("Change Tone","tutor-pro"),/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"chevronDown",width:16,height:16})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)(rE,{variant:"outline",roundedFull:false,ref:S,onClick:()=>D("translate"),children:[(0,h.__)("Translate to","tutor-pro"),/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"chevronDown",width:16,height:16})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"outline",roundedFull:false,onClick:()=>H("write_as_bullets"),children:(0,h.__)("Write as Bullets","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"outline",roundedFull:false,onClick:()=>H("make_longer"),children:(0,h.__)("Make Longer","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"outline",roundedFull:false,onClick:()=>H("simplify_language"),children:(0,h.__)("Simplify Language","tutor-pro")})]})]})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{isOpen:I==="tone",triggerRef:C,arrow:true,closePopover:()=>D(null),maxWidth:"160px",animationType:rL/* .AnimationType.slideDown */.J6.slideDown,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rN,{options:r4,onChange:e=>rI(function*(){D(null);yield H("change_tone",e)})()})}),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{isOpen:I==="translate",triggerRef:S,closePopover:()=>D(null),maxWidth:"160px",animationType:rL/* .AnimationType.slideDown */.J6.slideDown,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rN,{options:r2,onChange:e=>rI(function*(){D(null);yield H("translation",e)})()})}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:nT.footer,children:/*#__PURE__*/(0,u/* .jsxs */.FD)(ra/* ["default"] */.A,{when:m.length>0,fallback:/*#__PURE__*/(0,u/* .jsxs */.FD)(rE,{type:"submit",disabled:p.isPending||!E||g.isPending,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicWand",width:24,height:24}),(0,h.__)("Generate Now","tutor-pro")]}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"outline",type:"submit",disabled:p.isPending||!E||g.isPending,children:(0,h.__)("Generate Again","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"primary",disabled:p.isPending||m.length===0||g.isPending,onClick:()=>{o.onChange(m[x]);n()},children:(0,h.__)("Use This","tutor-pro")})]})})]})})};/* ESM default export */const nH=nF;var nT={container:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["20"] */.YK["20"],";display:flex;flex-direction:column;gap:",rn/* .spacing["16"] */.YK["16"],";"),fieldsWrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;textarea{padding-bottom:",rn/* .spacing["40"] */.YK["40"]," !important;}"),footer:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["12"] */.YK["12"]," ",rn/* .spacing["16"] */.YK["16"],";display:flex;align-items:center;justify-content:end;gap:",rn/* .spacing["10"] */.YK["10"],";box-shadow:0px 1px 0px 0px #e4e5e7 inset;button{width:fit-content;}"),pageInfo:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";& > span{font-weight:",rn/* .fontWeight.medium */.Wy.medium,";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}"),inspireButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.small */.I.small(),";position:absolute;height:28px;bottom:",rn/* .spacing["12"] */.YK["12"],";left:",rn/* .spacing["12"] */.YK["12"],";border:1px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";display:flex;align-items:center;gap:",rn/* .spacing["4"] */.YK["4"],";color:",rn/* .colorTokens.text.brand */.I6.text.brand,";padding-inline:",rn/* .spacing["12"] */.YK["12"],";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";&:hover{background-color:",rn/* .colorTokens.background.brand */.I6.background.brand,";color:",rn/* .colorTokens.text.white */.I6.text.white,";}&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}&:disabled{background-color:",rn/* .colorTokens.background.disable */.I6.background.disable,";color:",rn/* .colorTokens.text.disable */.I6.text.disable,";}"),navigation:/*#__PURE__*/(0,d/* .css */.AH)("margin-left:-",rn/* .spacing["8"] */.YK["8"],";display:flex;align-items:center;"),content:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";height:180px;overflow-y:auto;background-color:",rn/* .colorTokens.background.magicAi["default"] */.I6.background.magicAi["default"],";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";padding:",rn/* .spacing["6"] */.YK["6"]," ",rn/* .spacing["12"] */.YK["12"],";color:",rn/* .colorTokens.text.magicAi */.I6.text.magicAi,";"),actionBar:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;justify-content:space-between;"),otherActions:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;gap:",rn/* .spacing["10"] */.YK["10"],";flex-wrap:wrap;& > button{width:fit-content;}")};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/modals/Modal.tsx
var nO=r(7316);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/config.ts
var nK=r(9568);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/modals/ProIdentifierModal.tsx
var nN={title:/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[(0,h.__)("Upgrade to Tutor LMS Pro today and experience the power of ","tutor-pro"),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:rA/* .styleUtils.aiGradientText */.x.aiGradientText,children:(0,h.__)("AI Studio","tutor-pro")})]}),message:(0,h.__)("Upgrade your plan to access the AI feature","tutor-pro"),featuresTitle:(0,h.__)("Don’t miss out on this game-changing feature!","tutor-pro"),features:[(0,h.__)("Generate a complete course outline in seconds!","tutor-pro"),(0,h.__)("Let the AI Studio create Quizzes on your behalf and give your brain a well-deserved break.","tutor-pro"),(0,h.__)("Generate images, customize backgrounds, and even remove unwanted objects with ease.","tutor-pro"),(0,h.__)("Say goodbye to typos and grammar errors with AI-powered copy editing.","tutor-pro")],footer:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{onClick:()=>window.open(nK/* ["default"].TUTOR_PRICING_PAGE */.A.TUTOR_PRICING_PAGE,"_blank","noopener"),icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"crown",width:24,height:24}),children:(0,h.__)("Get Tutor LMS Pro","tutor-pro")})};var nP=e=>{var{title:t=nN.title,message:r=nN.message,featuresTitle:n=nN.featuresTitle,features:o=nN.features,closeModal:a,image:i,image2x:s,footer:l=nN.footer}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)(nM/* ["default"] */.A,{onClose:a,entireHeader:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:nW.message,children:r}),maxWidth:496,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nW.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t,children:/*#__PURE__*/(0,u/* .jsx */.Y)("h4",{css:nW.title,children:t})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:i,children:/*#__PURE__*/(0,u/* .jsx */.Y)("img",{css:nW.image,src:i,alt:typeof t==="string"?t:(0,h.__)("Illustration","tutor-pro"),srcSet:s?"".concat(i," ").concat(s," 2x"):undefined})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:n,children:/*#__PURE__*/(0,u/* .jsx */.Y)("h6",{css:nW.featuresTiTle,children:n})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:o.length,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:nW.features,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:o,children:(e,t)=>/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nW.feature,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"materialCheck",width:20,height:20,style:nW.checkIcon}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:e})]},t)})})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:l,children:l})]})})};/* ESM default export */const nL=nP;var nW={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("padding:0 ",rn/* .spacing["24"] */.YK["24"]," ",rn/* .spacing["32"] */.YK["32"]," ",rn/* .spacing["24"] */.YK["24"],";",rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["16"] */.YK["16"],";"),message:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";padding-left:",rn/* .spacing["8"] */.YK["8"],";padding-top:",rn/* .spacing["24"] */.YK["24"],";padding-bottom:",rn/* .spacing["4"] */.YK["4"],";"),title:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.heading6 */.I.heading6("medium"),";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";text-wrap:pretty;"),image:/*#__PURE__*/(0,d/* .css */.AH)("height:270px;width:100%;object-fit:cover;object-position:center;border-radius:",rn/* .borderRadius["8"] */.Vq["8"],";"),featuresTiTle:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body("medium"),";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";text-wrap:pretty;"),features:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["4"] */.YK["4"],";padding-right:",rn/* .spacing["48"] */.YK["48"],";"),feature:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";gap:",rn/* .spacing["12"] */.YK["12"],";",ro/* .typography.small */.I.small(),";color:",rn/* .colorTokens.text.title */.I6.text.title,";span{text-wrap:pretty;}"),checkIcon:/*#__PURE__*/(0,d/* .css */.AH)("flex-shrink:0;color:",rn/* .colorTokens.text.success */.I6.text.success,";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/Alert.tsx
var nB={text:{warning:"#D47E00",success:"#D47E00",danger:"#f44337",info:"#D47E00",primary:"#D47E00"},icon:{warning:"#FAB000",success:"#FAB000",danger:"#f55e53",info:"#FAB000",primary:"#FAB000"},background:{warning:"#FBFAE9",success:"#FBFAE9",danger:"#fdd9d7",info:"#FBFAE9",primary:"#FBFAE9"}};var nR=e=>{var{children:t,type:r="warning",icon:n}=e;return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nV.wrapper({type:r}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:n,children:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{style:nV.icon({type:r}),name:e,height:24,width:24})}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:t})]})};/* ESM default export */const nz=nR;var nV={wrapper:e=>{var{type:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";display:flex;align-items:start;padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["12"] */.YK["12"],";width:100%;border-radius:",rn/* .borderRadius.card */.Vq.card,";gap:",rn/* .spacing["4"] */.YK["4"],";background-color:",nB.background[t],";color:",nB.text[t],";")},icon:e=>{var{type:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("color:",nB.icon[t],";flex-shrink:0;")}};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/Switch.tsx
function nj(){var e=(0,x._)(["\n        width: 26px;\n        height: 16px;\n      "]);nj=function t(){return e};return e}function nq(){var e=(0,x._)(["\n          top: 2px;\n          left: 3px;\n          width: 12px;\n          height: 12px;\n        "]);nq=function t(){return e};return e}function nU(){var e=(0,x._)(["\n            left: 11px;\n          "]);nU=function t(){return e};return e}function nG(){var e=(0,x._)(["\n      right: 3px;\n    "]);nG=function t(){return e};return e}function nQ(){var e=(0,x._)(["\n      left: 3px;\n    "]);nQ=function t(){return e};return e}var nX={switchStyles:e=>/*#__PURE__*/(0,d/* .css */.AH)("&[data-input]{all:unset;appearance:none;border:0;width:40px;height:24px;background:",rn/* .colorTokens.color.black["10"] */.I6.color.black["10"],";border-radius:12px;position:relative;display:inline-block;vertical-align:middle;cursor:pointer;transition:background-color 0.25s cubic-bezier(0.785,0.135,0.15,0.86);",e==="small"&&(0,d/* .css */.AH)(nj()),"      &::before{display:none !important;}&:focus{border:none;outline:none;box-shadow:none;}&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}&:after{content:'';position:absolute;top:3px;left:",rn/* .spacing["4"] */.YK["4"],";width:18px;height:18px;background:",rn/* .colorTokens.background.white */.I6.background.white,";border-radius:",rn/* .borderRadius.circle */.Vq.circle,";box-shadow:",rn/* .shadow["switch"] */.r7["switch"],";transition:left 0.25s cubic-bezier(0.785,0.135,0.15,0.86);",e==="small"&&(0,d/* .css */.AH)(nq()),"}&:checked{background:",rn/* .colorTokens.primary.main */.I6.primary.main,";&:after{left:18px;",e==="small"&&(0,d/* .css */.AH)(nU()),"}}&:disabled{pointer-events:none;filter:none;opacity:0.5;}}"),labelStyles:e=>/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";color:",e?rn/* .colorTokens.text.title */.I6.text.title:rn/* .colorTokens.text.subdued */.I6.text.subdued,";"),wrapperStyle:e=>/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;justify-content:space-between;width:fit-content;flex-direction:",e==="left"?"row":"row-reverse",";column-gap:",rn/* .spacing["12"] */.YK["12"],";position:relative;"),spinner:e=>/*#__PURE__*/(0,d/* .css */.AH)("display:flex;position:absolute;top:50%;transform:translateY(-50%);",e&&(0,d/* .css */.AH)(nG())," ",!e&&(0,d/* .css */.AH)(nQ()))};var n$=/*#__PURE__*/g().forwardRef((e,t)=>{var{id:r=(0,rb/* .nanoid */.Ak)(),name:n,label:o,value:a,checked:i,disabled:s,loading:l,onChange:c,labelPosition:d="left",labelCss:f,size:p="regular"}=e;var h=e=>{c===null||c===void 0?void 0:c(e.target.checked,e)};return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:nX.wrapperStyle(d),children:[o&&/*#__PURE__*/(0,u/* .jsx */.Y)("label",{css:[nX.labelStyles(i||false),f],htmlFor:r,children:o}),/*#__PURE__*/(0,u/* .jsx */.Y)("input",{ref:t,value:a?String(a):undefined,type:"checkbox",name:n,id:r,checked:!!i,disabled:s,css:nX.switchStyles(p),onChange:h,"data-input":true}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:l,children:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:nX.spinner(!!i),children:/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* ["default"] */.Ay,{size:p==="small"?12:20})})})]})});/* ESM default export */const nZ=n$;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormSwitch.tsx
var nJ=e=>{var{field:t,fieldState:r,label:n,disabled:o,loading:a,labelPosition:i="left",helpText:s,isHidden:l,labelCss:c,onChange:d}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:n,field:t,fieldState:r,loading:a,helpText:s,isHidden:l,isInlineLabel:true,children:e=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:n1.wrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)(nZ,(0,w._)((0,_._)({},t,e),{disabled:o,checked:t.value,labelCss:c,labelPosition:i,onChange:()=>{t.onChange(!t.value);d===null||d===void 0?void 0:d(!t.value)}}))})}})};/* ESM default export */const n0=(0,ri/* .withVisibilityControl */.M)(nJ);var n1={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;justify-content:space-between;gap:",rn/* .spacing["40"] */.YK["40"],";")};// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/isValid/index.js + 1 modules
var n6=r(5487);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/utils/validation.ts
var n2=()=>({required:{value:true,message:(0,h.__)("This field is required","tutor-pro")}});var n4=e=>{var{maxValue:t,message:r}=e;return{maxLength:{value:t,message:r||__("Max. value should be ".concat(t),"tutor-pro")}}};var n3=()=>({validate:e=>{if((e===null||e===void 0?void 0:e.amount)===undefined){return __("The field is required","tutor-pro")}return undefined}});var n5=e=>{if(!(0,n6/* ["default"] */.A)(new Date(e||""))){return(0,h.__)("Invalid date entered!","tutor-pro")}return undefined};var n8=e=>({validate:t=>{if(t&&e<t.length){return __("Maximum ".concat(e," character supported"),"tutor-pro")}return undefined}});var n7=e=>{if(!e){return undefined}var t=(0,h.__)("Invalid time entered!","tutor-pro");var[r,n]=e.split(":");if(!r||!n){return t}var[o,a]=n.split(" ");if(!o||!a){return t}if(r.length!==2||o.length!==2){return t}if(Number(r)<1||Number(r)>12){return t}if(Number(o)<0||Number(o)>59){return t}if(!["am","pm"].includes(a.toLowerCase())){return t}return undefined};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/modals/SetupOpenAiModal.tsx
function n9(){var e=(0,x._)(["\n      padding: ",";\n      padding-top: ",";\n    "]);n9=function t(){return e};return e}var oe,ot;var or=((oe=nK/* .tutorConfig.settings */.P.settings)===null||oe===void 0?void 0:oe.chatgpt_enable)==="on";var on=(ot=nK/* .tutorConfig.current_user.roles */.P.current_user.roles)===null||ot===void 0?void 0:ot.includes(rC/* .TutorRoles.ADMINISTRATOR */.gt.ADMINISTRATOR);var oo=e=>{var{closeModal:t,image:r,image2x:n}=e;var o=rl({defaultValues:{openAIApiKey:"",enable_open_ai:or},shouldFocusError:true});var a=nS();var i=e=>rI(function*(){var r=yield a.mutateAsync({chatgpt_api_key:e.openAIApiKey,chatgpt_enable:e.enable_open_ai?1:0});if(r.status_code===200){t({action:"CONFIRM"});window.location.reload()}})();(0,v.useEffect)(()=>{o.setFocus("openAIApiKey");// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);return/*#__PURE__*/(0,u/* .jsx */.Y)(nM/* ["default"] */.A,{onClose:()=>t({action:"CLOSE"}),title:on?(0,h.__)("Set OpenAI API key","tutor-pro"):undefined,entireHeader:on?undefined:/*#__PURE__*/(0,u/* .jsx */.Y)(u/* .Fragment */.FK,{children:" "}),maxWidth:560,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:oi.wrapper({isCurrentUserAdmin:on}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:on,fallback:/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("img",{css:oi.image,src:r,srcSet:n?"".concat(r," 1x, ").concat(n," 2x"):"".concat(r," 1x"),alt:(0,h.__)("Connect API KEY","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:oi.message,children:(0,h.__)("API is not connected","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:oi.title,children:(0,h.__)("Please, ask your Admin to connect the API with Tutor LMS Pro.","tutor-pro")})]})]}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("form",{css:oi.formWrapper,onSubmit:o.handleSubmit(i),children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:oi.infoText,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{dangerouslySetInnerHTML:{/* translators: %1$s and %2$s are opening and closing anchor tags for the "OpenAI User settings" link */__html:(0,h.sprintf)((0,h.__)("Find your Secret API key in your %1$sOpenAI User settings%2$s and paste it here to connect OpenAI with your Tutor LMS website.","tutor-pro"),'<a href="'.concat(nK/* ["default"].CHATGPT_PLATFORM_URL */.A.CHATGPT_PLATFORM_URL,'" target="_blank" rel="noopener noreferrer">'),"</a>")}}),/*#__PURE__*/(0,u/* .jsx */.Y)(nz,{type:"info",icon:"warning",children:(0,h.__)("The page will reload after submission. Make sure to save the course information.","tutor-pro")})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"openAIApiKey",control:o.control,rules:n2(),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oh,(0,w._)((0,_._)({},e),{type:"password",isPassword:true,label:(0,h.__)("OpenAI API key","tutor-pro"),placeholder:(0,h.__)("Enter your OpenAI API key","tutor-pro")}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"enable_open_ai",control:o.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(n0,(0,w._)((0,_._)({},e),{label:(0,h.__)("Enable OpenAI","tutor-pro")}))})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:oi.formFooter,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{onClick:()=>t({action:"CLOSE"}),variant:"text",size:"small",children:(0,h.__)("Cancel","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{size:"small",onClick:o.handleSubmit(i),loading:a.isPending,children:(0,h.__)("Save","tutor-pro")})]})]})})})})};/* ESM default export */const oa=oo;var oi={wrapper:e=>{var{isCurrentUserAdmin:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["20"] */.YK["20"],";",!t&&(0,d/* .css */.AH)(n9(),rn/* .spacing["24"] */.YK["24"],rn/* .spacing["6"] */.YK["6"]))},formWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["20"] */.YK["20"],";padding:",rn/* .spacing["16"] */.YK["16"]," ",rn/* .spacing["16"] */.YK["16"]," 0 ",rn/* .spacing["16"] */.YK["16"],";"),infoText:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small(),";",rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["8"] */.YK["8"],";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";a{",rA/* .styleUtils.resetButton */.x.resetButton,"      color:",rn/* .colorTokens.text.brand */.I6.text.brand,";}"),formFooter:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";justify-content:flex-end;gap:",rn/* .spacing["16"] */.YK["16"],";border-top:1px solid ",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";padding:",rn/* .spacing["16"] */.YK["16"],";"),image:/*#__PURE__*/(0,d/* .css */.AH)("height:310px;width:100%;object-fit:cover;object-position:center;border-radius:",rn/* .borderRadius["8"] */.Vq["8"],";"),message:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";"),title:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.heading4 */.I.heading4("medium"),";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";margin-top:",rn/* .spacing["4"] */.YK["4"],";text-wrap:pretty;")};// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/pro-placeholders/generate-text-2x.webp
const os=r.p+"images/generate-text-2x-45983f4c.webp";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/pro-placeholders/generate-text.webp
const ol=r.p+"images/generate-text-269f7e17.webp";// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormInput.tsx
function oc(){var e=(0,x._)(["\n      svg {\n        color: ",";\n      }\n    "]);oc=function t(){return e};return e}var ou;var od=!!nK/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url;var of=(ou=nK/* .tutorConfig.settings */.P.settings)===null||ou===void 0?void 0:ou.chatgpt_key_exist;var op=e=>{var{label:t,type:r="text",maxLimit:n,field:o,fieldState:a,disabled:i,readOnly:s,loading:l,placeholder:c,helpText:d,onChange:f,onKeyDown:p,isHidden:g,isClearable:m=false,isSecondary:b=false,removeBorder:x,dataAttribute:A,isInlineLabel:k=false,isPassword:Y=false,style:I,selectOnFocus:D=false,autoFocus:C=false,generateWithAi:S=false,isMagicAi:M=false,allowNegative:E=false,onClickAiButton:F}=e;var[H,T]=(0,v.useState)(r);var{showModal:O}=(0,nO/* .useModal */.h)();var K=(0,v.useRef)(null);var N;var P=(N=o.value)!==null&&N!==void 0?N:"";var L=undefined;if(H==="number"){P=(0,rb/* .parseNumberOnly */.TW)("".concat(P),E).replace(/(\..*)\./g,"$1")}if(n){L={maxLimit:n,inputCharacter:P.toString().length}}var W=(0,_._)({},(0,rc/* .isDefined */.O9)(A)&&{[A]:true});var B=()=>{if(!od){O({component:nL,props:{image:ol,image2x:os}})}else if(!of){O({component:oa,props:{image:ol,image2x:os}})}else{O({component:nH,isMagicAi:true,props:{title:(0,h.__)("AI Studio","tutor-pro"),icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicAiColorize",width:24,height:24}),characters:120,field:o,fieldState:a,format:"title",is_html:false,fieldLabel:(0,h.__)("Create a Compelling Title","tutor-pro"),fieldPlaceholder:(0,h.__)("Describe the main focus of your course in a few words","tutor-pro")}});F===null||F===void 0?void 0:F()}};return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:t,field:o,fieldState:a,disabled:i,readOnly:s,loading:l,placeholder:c,helpText:d,isHidden:g,characterCount:L,isSecondary:b,removeBorder:x,isInlineLabel:k,inputStyle:I,generateWithAi:S,onClickAiButton:B,isMagicAi:M,children:e=>{return/*#__PURE__*/(0,u/* .jsx */.Y)(u/* .Fragment */.FK,{children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:ov.container(m||Y),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},o,e,W),{type:H==="number"?"text":H,value:P,autoFocus:C,onChange:e=>{var{value:t}=e.target;var r=H==="number"?(0,rb/* .parseNumberOnly */.TW)(t):t;o.onChange(r);if(f){f(r)}},onClick:e=>{e.stopPropagation()},onKeyDown:e=>{e.stopPropagation();p===null||p===void 0?void 0:p(e.key)},autoComplete:"off",ref:e=>{o.ref(e);// @ts-ignore
K.current=e;// this is not ideal but it is the only way to set ref to the input element
},onFocus:()=>{if(!D||!K.current){return}K.current.select()}})),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:Y,children:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{isIconOnly:true,variant:"text",size:"small",onClick:()=>T(e=>e==="password"?"text":"password"),icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"eye",width:24,height:24}),"aria-label":(0,h.__)("Show/Hide Password","tutor-pro"),buttonCss:ov.eyeButton({type:H})})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:m&&!!o.value&&H!=="password",children:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{isIconOnly:true,variant:"text",size:"small",onClick:()=>o.onChange(""),buttonCss:rA/* .styleUtils.inputClearButton */.x.inputClearButton,icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"cross",width:24,height:24}),"aria-label":(0,h.__)("Clear","tutor-pro")})})]})})}})};/* ESM default export */const oh=(0,ri/* .withVisibilityControl */.M)(op);var ov={container:e=>/*#__PURE__*/(0,d/* .css */.AH)("position:relative;display:flex;input{&.tutor-input-field{",e&&"padding-right: ".concat(rn/* .spacing["36"] */.YK["36"],";"),";}}"),eyeButton:e=>{var{type:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.inputClearButton */.x.inputClearButton,";",t!=="password"&&(0,d/* .css */.AH)(oc(),rn/* .colorTokens.icon.brand */.I6.icon.brand))}};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormMultiLevelSelect.tsx
function og(){var e=(0,x._)(["\n      transform: rotate(180deg);\n    "]);og=function t(){return e};return e}var om=e=>{var{label:t,field:r,fieldState:n,disabled:o,loading:a,placeholder:i,helpText:s,isInlineLabel:l,clearable:c,listItemsLabel:d,optionsWrapperStyle:f}=e;var p=(0,v.useRef)(null);var[g,m]=(0,v.useState)(false);var[b,x]=(0,v.useState)("");var A=rs(b,300);var k=r_(A);var Y;var I=(0,rb/* .generateTree */.ww)((Y=k.data)!==null&&Y!==void 0?Y:[]);(0,v.useEffect)(()=>{if(!g){x("")}},[g]);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:t,field:r,fieldState:n,disabled:o||I.length===0,loading:a,placeholder:i,helpText:s,isInlineLabel:l,children:e=>{var t,n;return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:o_.inputWrapper,ref:p,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},e),{type:"text",onClick:e=>{e.stopPropagation();m(true)},onKeyDown:e=>{if(e.key==="Enter"){e.preventDefault();m(true)}if(e.key==="Tab"){m(false)}},autoComplete:"off",readOnly:true,disabled:o||I.length===0,value:r.value?(n=k.data)===null||n===void 0?void 0:(t=n.find(e=>e.id===r.value))===null||t===void 0?void 0:t.name:"",placeholder:i})),/*#__PURE__*/(0,u/* .jsx */.Y)("button",{tabIndex:-1,type:"button",disabled:o||I.length===0,"aria-label":(0,h.__)("Toggle options","tutor-pro"),css:o_.toggleIcon(g),onClick:()=>{m(e=>!e)},children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"chevronDown",width:20,height:20})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{triggerRef:p,isOpen:g,closePopover:()=>m(false),dependencies:[I.length],animationType:rL/* .AnimationType.slideDown */.J6.slideDown,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:o_.categoryWrapper,children:[!!d&&/*#__PURE__*/(0,u/* .jsx */.Y)("p",{css:o_.listItemLabel,children:d}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:o_.searchInput,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:o_.searchIcon,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"search",width:24,height:24})}),/*#__PURE__*/(0,u/* .jsx */.Y)("input",{type:"text",placeholder:(0,h.__)("Search","tutor-pro"),value:b,onChange:e=>{x(e.target.value)}})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:I.length>0,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:o_.notFound,children:(0,h.__)("No categories found.","tutor-pro")}),children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:[o_.options,f],children:I.map(e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oy,{option:e,onChange:e=>{r.onChange(e);m(false)}},e.id))})}),c&&/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:o_.clearButton,children:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text",onClick:()=>{r.onChange(null);m(false)},children:(0,h.__)("Clear selection","tutor-pro")})})]})})]})}})};/* ESM default export */const ob=om;var oy=e=>{var{option:t,onChange:r,level:n=0}=e;var o=t.children.length>0;var a=()=>{if(!o){return null}return t.children.map(e=>{return/*#__PURE__*/(0,u/* .jsx */.Y)(oy,{option:e,onChange:r,level:n+1},e.id)})};return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:o_.branchItem(n),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",onClick:()=>r(t.id),title:t.name,children:(0,rb/* .decodeHtmlEntities */.jT)(t.name)}),a()]})};var o_={categoryWrapper:/*#__PURE__*/(0,d/* .css */.AH)("background-color:",rn/* .colorTokens.background.white */.I6.background.white,";box-shadow:",rn/* .shadow.popover */.r7.popover,";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border:1px solid ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";padding:",rn/* .spacing["8"] */.YK["8"]," 0;min-width:275px;"),options:/*#__PURE__*/(0,d/* .css */.AH)("max-height:455px;",rA/* .styleUtils.overflowYAuto */.x.overflowYAuto,";"),notFound:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;",ro/* .typography.caption */.I.caption("regular"),";padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["16"] */.YK["16"],";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";"),searchInput:/*#__PURE__*/(0,d/* .css */.AH)("position:sticky;top:0;padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["16"] */.YK["16"],";input{",ro/* .typography.body */.I.body("regular"),";width:100%;border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["16"] */.YK["16"]," ",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["32"] */.YK["32"],";color:",rn/* .colorTokens.text.title */.I6.text.title,";appearance:textfield;:focus{",rA/* .styleUtils.inputFocus */.x.inputFocus,";}}"),searchIcon:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;left:",rn/* .spacing["24"] */.YK["24"],";top:50%;transform:translateY(-50%);color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";display:flex;"),branchItem:e=>/*#__PURE__*/(0,d/* .css */.AH)("position:relative;z-index:",rn/* .zIndex.positive */.fE.positive,";button{",rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.body */.I.body("regular"),";",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),";color:",rn/* .colorTokens.text.title */.I6.text.title,";padding-left:calc(",rn/* .spacing["24"] */.YK["24"]," + ",rn/* .spacing["24"] */.YK["24"]," * ",e,");line-height:",rn/* .lineHeight["36"] */.K_["36"],";padding-right:",rn/* .spacing["16"] */.YK["16"],";width:100%;&:hover,&:focus,&:active{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";color:",rn/* .colorTokens.text.title */.I6.text.title,";}}"),toggleIcon:e=>/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";position:absolute;top:",rn/* .spacing["4"] */.YK["4"],";right:",rn/* .spacing["4"] */.YK["4"],";display:flex;align-items:center;transition:transform 0.3s ease-in-out;color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";padding:",rn/* .spacing["6"] */.YK["6"],";&:focus,&:active,&:hover{background:none;color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";}",e&&(0,d/* .css */.AH)(og())),inputWrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;input:read-only{background-color:inherit;}"),clearButton:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["24"] */.YK["24"],";box-shadow:",rn/* .shadow.dividerTop */.r7.dividerTop,";& > button{padding:0;}"),listItemLabel:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";font-weight:",rn/* .fontWeight.medium */.Wy.medium,";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";padding:",rn/* .spacing["10"] */.YK["10"]," ",rn/* .spacing["16"] */.YK["16"],";"),radioLabel:/*#__PURE__*/(0,d/* .css */.AH)("line-height:",rn/* .lineHeight["32"] */.K_["32"],";padding-left:",rn/* .spacing["2"] */.YK["2"],";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormCategoriesInput.tsx
function ow(){var e=(0,x._)(["\n      &:before {\n        content: '';\n        position: absolute;\n        height: 1px;\n        width: 10px;\n        left: -10px;\n        top: ",";\n\n        background-color: ",";\n        z-index: ",";\n      }\n    "]);ow=function t(){return e};return e}function ox(){var e=(0,x._)(["\n      box-shadow: ",";\n    "]);ox=function t(){return e};return e}var oA=e=>{var{label:t,field:r,fieldState:n,disabled:o,loading:a,placeholder:i,helpText:s,optionsWrapperStyle:l}=e;var c=rl({shouldFocusError:true});var d=c.watch("search");var f=rs(d,300);var p=r_(f);var g=rx();var[m,b]=(0,v.useState)(false);var[x,A]=(0,v.useState)(false);var{ref:k,isScrolling:Y}=rd();(0,v.useEffect)(()=>{if(!p.isLoading&&(p.data||[]).length>0){A(true)}},[p.isLoading,p.data]);(0,v.useEffect)(()=>{if(m){var e=setTimeout(()=>{c.setFocus("name")},250);return()=>{clearTimeout(e)}}// eslint-disable-next-line react-hooks/exhaustive-deps
},[m]);var{triggerRef:I,position:D,popoverRef:C}=(0,rf/* .usePortalPopover */.tP)({isOpen:m});var S;var M=(0,rb/* .generateTree */.ww)((S=p.data)!==null&&S!==void 0?S:[]);var E=()=>{b(false);c.reset({name:"",parent:null,search:d})};var F=e=>{if(e.name){g.mutate((0,_._)({name:e.name},e.parent&&{parent:e.parent}));E()}};return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:t,field:r,fieldState:n,loading:a,placeholder:i,helpText:s,children:()=>{return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:[oD.options,l],children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:oD.categoryListWrapper,ref:k,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!o&&(x||f),children:/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"search",control:c.control,render:e=>/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:oD.searchInput,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:oD.searchIcon,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"search",width:24,height:24})}),/*#__PURE__*/(0,u/* .jsx */.Y)("input",{type:"text",placeholder:(0,h.__)("Search","tutor-pro"),value:d,disabled:o||a,onChange:t=>{e.field.onChange(t.target.value)}})]})})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!p.isLoading&&!a,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* .LoadingSection */.YE,{}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:M.length>0,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:oD.notFound,children:(0,h.__)("No categories found.","tutor-pro")}),children:M.map((e,t)=>/*#__PURE__*/(0,u/* .jsx */.Y)(oI,{disabled:o,option:e,value:r.value,isLastChild:t===M.length-1,onChange:e=>{r.onChange(eA(r.value,t=>{if(Array.isArray(t)){return t.includes(e)?t.filter(t=>t!==e):[...t,e]}return[e]}))}},e.id))})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!o,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{ref:I,css:oD.addButtonWrapper({isActive:Y,hasCategories:p.isLoading||M.length>0}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{disabled:o||a,type:"button",css:oD.addNewButton,onClick:()=>b(true),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{width:24,height:24,name:"plus"})," ",(0,h.__)("Add","tutor-pro")]})})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rf/* .Portal */.ZL,{isOpen:m,onClickOutside:E,onEscape:E,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:oD.categoryFormWrapper,style:{left:D.left,top:D.top},ref:C,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"name",control:c.control,rules:{required:(0,h.__)("Category name is required","tutor-pro")},render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oh,(0,w._)((0,_._)({},e),{placeholder:(0,h.__)("Category name","tutor-pro"),selectOnFocus:true}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"parent",control:c.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(ob,(0,w._)((0,_._)({},e),{placeholder:(0,h.__)("Select parent","tutor-pro"),clearable:!!e.field.value}))}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:oD.categoryFormButtons,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text",size:"small",onClick:E,children:(0,h.__)("Cancel","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"secondary",size:"small",loading:g.isPending,onClick:c.handleSubmit(F),children:(0,h.__)("Ok","tutor-pro")})]})]})})]})}})};/* ESM default export */const ok=(0,ri/* .withVisibilityControl */.M)(oA);var oY=e=>{return e.children.reduce((e,t)=>e+oY(t),e.children.length)};var oI=e=>{var{option:t,value:r,onChange:n,isLastChild:o,disabled:a}=e;var i=oY(t);var s=i>0;var l=(0,rb/* .getCategoryLeftBarHeight */.oj)(o,i);var c=()=>{if(!s){return null}return t.children.map((e,o)=>{return/*#__PURE__*/(0,u/* .jsx */.Y)(oI,{option:e,value:r,onChange:n,isLastChild:o===t.children.length-1,disabled:a},e.id)})};return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:oD.branchItem({leftBarHeight:l,hasParent:t.parent!==0}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(rt/* ["default"] */.A,{checked:Array.isArray(r)?r.includes(t.id):r===t.id,label:(0,rb/* .decodeHtmlEntities */.jT)(t.name),onChange:()=>{n(t.id)},labelCss:oD.checkboxLabel,disabled:a}),c()]})};var oD={options:/*#__PURE__*/(0,d/* .css */.AH)("border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",rn/* .borderRadius["8"] */.Vq["8"],";padding:",rn/* .spacing["8"] */.YK["8"]," 0;background-color:",rn/* .colorTokens.bg.white */.I6.bg.white,";"),categoryListWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.overflowYAuto */.x.overflowYAuto,";max-height:208px;"),notFound:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;",ro/* .typography.caption */.I.caption("regular"),";padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["16"] */.YK["16"],";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";"),searchInput:/*#__PURE__*/(0,d/* .css */.AH)("position:sticky;top:0;padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["16"] */.YK["16"],";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";z-index:",rn/* .zIndex.dropdown */.fE.dropdown,";input{",ro/* .typography.body */.I.body("regular"),";width:100%;border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["16"] */.YK["16"]," ",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["32"] */.YK["32"],";color:",rn/* .colorTokens.text.title */.I6.text.title,";appearance:textfield;:focus{",rA/* .styleUtils.inputFocus */.x.inputFocus,";}}"),searchIcon:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;left:",rn/* .spacing["24"] */.YK["24"],";top:50%;transform:translateY(-50%);color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";display:flex;"),checkboxLabel:/*#__PURE__*/(0,d/* .css */.AH)("line-height:1.88rem !important;span:last-of-type{",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),"}"),branchItem:e=>{var{leftBarHeight:t,hasParent:r}=e;return/*#__PURE__*/(0,d/* .css */.AH)("line-height:",rn/* .spacing["32"] */.YK["32"],";position:relative;z-index:",rn/* .zIndex.positive */.fE.positive,";margin-inline:",rn/* .spacing["20"] */.YK["20"]," ",rn/* .spacing["16"] */.YK["16"],";&:after{content:'';position:absolute;height:",t,";width:1px;left:9px;top:25px;background-color:",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";z-index:",rn/* .zIndex.level */.fE.level,";}",r&&(0,d/* .css */.AH)(ow(),rn/* .spacing["16"] */.YK["16"],rn/* .colorTokens.stroke.divider */.I6.stroke.divider,rn/* .zIndex.level */.fE.level))},addNewButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.small */.I.small("medium"),";color:",rn/* .colorTokens.brand.blue */.I6.brand.blue,";padding:0 ",rn/* .spacing["8"] */.YK["8"],";display:flex;align-items:center;border-radius:",rn/* .borderRadius["2"] */.Vq["2"],";&:focus,&:active,&:hover{background:none;color:",rn/* .colorTokens.brand.blue */.I6.brand.blue,";}&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}&:disabled{color:",rn/* .colorTokens.text.disable */.I6.text.disable,";}"),categoryFormWrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;background-color:",rn/* .colorTokens.background.white */.I6.background.white,";box-shadow:",rn/* .shadow.popover */.r7.popover,";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border:1px solid ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";padding:",rn/* .spacing["16"] */.YK["16"],";min-width:306px;display:flex;flex-direction:column;gap:",rn/* .spacing["12"] */.YK["12"],";"),categoryFormButtons:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;justify-content:end;gap:",rn/* .spacing["8"] */.YK["8"],";"),addButtonWrapper:e=>{var{isActive:t=false,hasCategories:r=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)("transition:box-shadow 0.3s ease-in-out;padding-inline:",rn/* .spacing["8"] */.YK["8"],";padding-block:",r?rn/* .spacing["4"] */.YK["4"]:"0px",";",t&&(0,d/* .css */.AH)(ox(),rn/* .shadow.scrollable */.r7.scrollable))}};// EXTERNAL MODULE: ../tutor/node_modules/polished/lib/color/rgba.js
var oC=r(3458);var oS=/*#__PURE__*/r.n(oC);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/ImageInput.tsx
function oM(){var e=(0,x._)(["\n      width: 168px;\n    "]);oM=function t(){return e};return e}function oE(){var e=(0,x._)(["\n      width: 168px;\n    "]);oE=function t(){return e};return e}var oF={large:"regular",regular:"small",small:"small"};var oH=e=>{var{buttonText:t=(0,h.__)("Upload Media","tutor-pro"),infoText:r,size:n="regular",value:o,uploadHandler:a,clearHandler:i,emptyImageCss:s,previewImageCss:l,overlayCss:c,replaceButtonText:f,loading:p,disabled:v=false,isClearAble:g=true}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!p,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:oO.emptyMedia({size:n,isDisabled:v}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* .LoadingOverlay */.p8,{})}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:o===null||o===void 0?void 0:o.url,fallback:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{"aria-disabled":v,css:[oO.emptyMedia({size:n,isDisabled:v}),s],onClick:e=>{e.stopPropagation();if(v){return}a()},onKeyDown:e=>{if(!v&&e.key==="Enter"){e.preventDefault();a()}},children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"addImage",width:32,height:32}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{disabled:v,size:oF[n],variant:"secondary",buttonContentCss:oO.buttonText,"data-cy":"upload-media",children:t}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:r,children:/*#__PURE__*/(0,u/* .jsx */.Y)("p",{css:oO.infoTexts,children:r})})]}),children:e=>{return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:[oO.previewWrapper({size:n,isDisabled:v}),l],"data-cy":"media-preview",children:[/*#__PURE__*/(0,u/* .jsx */.Y)("img",{src:e,alt:o===null||o===void 0?void 0:o.title,css:oO.imagePreview}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:[oO.hoverPreview,c],"data-hover-buttons-wrapper":true,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{disabled:v,variant:"secondary",size:oF[n],buttonCss:/*#__PURE__*/(0,d/* .css */.AH)("margin-top:",g&&rn/* .spacing["16"] */.YK["16"],";"),onClick:e=>{e.stopPropagation();a()},"data-cy":"replace-media",children:f||(0,h.__)("Replace Image","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:g,children:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{disabled:v,variant:"text",size:oF[n],onClick:e=>{e.stopPropagation();i()},"data-cy":"clear-media",children:(0,h.__)("Remove","tutor-pro")})})]})]})}})})};/* ESM default export */const oT=oH;var oO={emptyMedia:e=>{var{size:t,isDisabled:r}=e;return/*#__PURE__*/(0,d/* .css */.AH)("width:100%;height:168px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:",rn/* .spacing["8"] */.YK["8"],";border:1px dashed ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";border-radius:",rn/* .borderRadius["8"] */.Vq["8"],";background-color:",rn/* .colorTokens.bg.white */.I6.bg.white,";overflow:hidden;cursor:",r?"not-allowed":"pointer",";",t==="small"&&(0,d/* .css */.AH)(oM()),"    svg{color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";}&:hover svg{color:",!r&&rn/* .colorTokens.brand.blue */.I6.brand.blue,";}")},buttonText:/*#__PURE__*/(0,d/* .css */.AH)("color:",rn/* .colorTokens.text.brand */.I6.text.brand,";"),infoTexts:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.tiny */.I.tiny(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";text-align:center;"),previewWrapper:e=>{var{size:t,isDisabled:r}=e;return/*#__PURE__*/(0,d/* .css */.AH)("width:100%;height:168px;border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",rn/* .borderRadius["8"] */.Vq["8"],";overflow:hidden;position:relative;background-color:",rn/* .colorTokens.bg.white */.I6.bg.white,";",t==="small"&&(0,d/* .css */.AH)(oE()),"    &:hover{[data-hover-buttons-wrapper]{display:",r?"none":"flex",";opacity:",r?0:1,";}}")},imagePreview:/*#__PURE__*/(0,d/* .css */.AH)("height:100%;width:100%;object-fit:contain;"),hoverPreview:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;justify-content:center;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";opacity:0;position:absolute;inset:0;background-color:",oS()(rn/* .colorTokens.color.black.main */.I6.color.black.main,.6),";button:first-of-type{box-shadow:",rn/* .shadow.button */.r7.button,";}button:last-of-type:not(:only-of-type){color:",rn/* .colorTokens.text.white */.I6.text.white,";box-shadow:none;}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-image/ImageContext.tsx
var oK=[(0,h.__)("A serene classroom setting with books and a chalkboard","tutor-pro"),(0,h.__)("An abstract representation of innovation and creativity","tutor-pro"),(0,h.__)("A vibrant workspace with a laptop and coffee cup","tutor-pro"),(0,h.__)("A modern design with digital learning icons","tutor-pro"),(0,h.__)("A futuristic cityscape with a glowing pathway","tutor-pro"),(0,h.__)("A peaceful nature scene with soft colors","tutor-pro"),(0,h.__)("A professional boardroom with sleek visuals","tutor-pro"),(0,h.__)("A stack of books with warm, inviting lighting","tutor-pro"),(0,h.__)("A dynamic collage of technology and education themes","tutor-pro"),(0,h.__)("A bold and minimalistic design with striking colors","tutor-pro")];// eslint-disable-next-line @typescript-eslint/no-explicit-any
var oN=/*#__PURE__*/g().createContext(null);var oP=()=>{var e=(0,v.useContext)(oN);if(!e){throw new Error("useMagicImageGeneration must be used within MagicImageGenerationProvider.")}return e};var oL=e=>{var{children:t,field:r,fieldState:n,onCloseModal:o}=e;var a=rl({defaultValues:{prompt:"",style:"none"}});var[i,s]=(0,v.useState)("generation");var[l,c]=(0,v.useState)("");var[d,f]=(0,v.useState)([null,null,null,null]);var p=(0,v.useCallback)(e=>{s(e)},[]);return/*#__PURE__*/(0,u/* .jsx */.Y)(oN.Provider,{value:{state:i,onDropdownMenuChange:p,images:d,setImages:f,currentImage:l,setCurrentImage:c,field:r,fieldState:n,onCloseModal:o},children:/*#__PURE__*/(0,u/* .jsx */.Y)(e1,(0,w._)((0,_._)({},a),{children:t}))})};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormImageRadioGroup.tsx
function oW(){var e=(0,x._)(["\n        img {\n          border-color: ",";\n        }\n      "]);oW=function t(){return e};return e}function oB(){var e=(0,x._)(["\n        outline-color: ",";\n      "]);oB=function t(){return e};return e}var oR=e=>{var{field:t,fieldState:r,label:n,options:o=[],disabled:a}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{field:t,fieldState:r,label:n,disabled:a,children:()=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:oV.wrapper,children:o.map((e,r)=>/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:oV.item(t.value===e.value),onClick:()=>{t.onChange(e.value)},disabled:a,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("img",{src:e.image,alt:e.label,width:64,height:64}),/*#__PURE__*/(0,u/* .jsx */.Y)("p",{children:e.label})]},r))})}})};/* ESM default export */const oz=oR;var oV={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:repeat(4,minmax(64px,1fr));gap:",rn/* .spacing["12"] */.YK["12"],";margin-top:",rn/* .spacing["4"] */.YK["4"],";"),item:e=>/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";display:flex;flex-direction:column;gap:",rn/* .spacing["4"] */.YK["4"],";align-items:center;width:100%;cursor:pointer;input{appearance:none;}p{",ro/* .typography.small */.I.small(),";width:100%;",rA/* .styleUtils.textEllipsis */.x.textEllipsis,";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";text-align:center;}&:hover,&:focus-visible{",!e&&(0,d/* .css */.AH)(oW(),rn/* .colorTokens.stroke.hover */.I6.stroke.hover),"}img{border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border:2px solid ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";outline:2px solid transparent;outline-offset:2px;transition:border-color 0.3s ease;",e&&(0,d/* .css */.AH)(oB(),rn/* .colorTokens.stroke.magicAi */.I6.stroke.magicAi),"}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/3d.png
const oj=r.p+"images/3d-d74232c4.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/black-and-white.png
const oq=r.p+"images/black-and-white-a1d197c0.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/concept.png
const oU=r.p+"images/concept-ad427b25.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/dreamy.png
const oG=r.p+"images/dreamy-72eab497.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/filmic.png
const oQ=r.p+"images/filmic-91db8802.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/illustration.png
const oX=r.p+"images/illustration-19074f05.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/neon.png
const o$=r.p+"images/neon-bfde2ac7.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/none.jpg
const oZ=r.p+"images/none-2088b52b.jpg";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/painting.png
const oJ=r.p+"images/painting-db63dd8a.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/photo.png
const o0=r.p+"images/photo-7d69e05e.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/retro.png
const o1=r.p+"images/retro-bcc8eda3.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/ai-types/sketch.png
const o6=r.p+"images/sketch-319bbedf.png";// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/utils/magic-ai.ts
function o2(e,t){e.lineTo(t.x,t.y);e.stroke()}function o4(e,t){var r=t.x-e.x;var n=t.y-e.y;return Math.sqrt(r*r+n*n)}function o3(e){var t=atob(e.split(",")[1]);var r=e.split(",")[0].split(":")[1].split(";")[0];var n=new ArrayBuffer(t.length);var o=new Uint8Array(n);for(var a=0;a<t.length;a++){o[a]=t.charCodeAt(a)}return new Blob([n],{type:r})}function o5(e,t){var r=o3(e);var n=document.createElement("a");n.href=URL.createObjectURL(r);n.download=t;document.body.appendChild(n);n.click();document.body.removeChild(n)}function o8(e,t){var r=document.createElement("canvas");r.width=1024;r.height=1024;var n=r.getContext("2d");n===null||n===void 0?void 0:n.putImageData(e,0,0);n===null||n===void 0?void 0:n.drawImage(r,0,0,1024,1024);return new Promise(e=>{r.toBlob(r=>{if(!r){e(null);return}e(new File([r],t,{type:"image/png"}))})})}var o7=e=>{if(e&&typeof e!=="function"&&e.current){var t=e.current;var r=t.getContext("2d");return{canvas:t,context:r}}return{canvas:null,context:null}};var o9=e=>{return e.toDataURL("image/png")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-image/ImageItem.tsx
function ae(){var e=(0,x._)(["\n      background-position: top left;\n    "]);ae=function t(){return e};return e}function at(){var e=(0,x._)(["\n      background-position: top right;\n      animation-delay: 0.5s;\n    "]);at=function t(){return e};return e}function ar(){var e=(0,x._)(["\n      background-position: bottom left;\n      animation-delay: 1.5s;\n    "]);ar=function t(){return e};return e}function an(){var e=(0,x._)(["\n      background-position: bottom right;\n      animation-delay: 1s;\n    "]);an=function t(){return e};return e}function ao(){var e=(0,x._)(["\n      outline-color: ",";\n\n      [data-actions] {\n        opacity: 1;\n      }\n    "]);ao=function t(){return e};return e}var aa=[{label:(0,h.__)("Magic Fill","tutor-pro"),value:"magic-fill",icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicWand",width:24,height:24})},// @TODO: will be implemented in the future
// {
//   label: __('Object eraser', __TUTOR_TEXT_DOMAIN__),
//   value: 'magic-erase',
//   icon: <SVGIcon name="eraser" width={24} height={24} />,
// },
// {
//   label: __('Variations', __TUTOR_TEXT_DOMAIN__),
//   value: 'variations',
//   icon: <SVGIcon name="reload" width={24} height={24} />,
// },
{label:(0,h.__)("Download","tutor-pro"),value:"download",icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"download",width:24,height:24})}];var ai=e=>{var{src:t,loading:r,index:n}=e;var o=(0,v.useRef)(null);var[a,i]=(0,v.useState)(false);var{onDropdownMenuChange:s,setCurrentImage:l,onCloseModal:c,field:d}=oP();var f=nm();if(r||!t){return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:al.loader(n+1)})}return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:al.image({isActive:f.isPending}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("img",{src:t,alt:(0,h.__)("Generated Image","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{"data-actions":true,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:al.useButton,children:/*#__PURE__*/(0,u/* .jsxs */.FD)(rE,{variant:"primary",disabled:f.isPending,onClick:()=>rI(function*(){if(!t){return}var e=yield f.mutateAsync({image:t});if(e.data){d.onChange(e.data);c()}})(),loading:f.isPending,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"download",width:24,height:24}),(0,h.__)("Use This","tutor-pro")]})}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"primary",size:"icon",css:al.threeDots,ref:o,onClick:()=>i(true),children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"threeDotsVertical",width:24,height:24})})]})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{triggerRef:o,isOpen:a,arrow:true,closePopover:()=>{i(false)},animationType:rL/* .AnimationType.slideDown */.J6.slideDown,maxWidth:"160px",children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:al.dropdownOptions,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:aa,children:(e,r)=>/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:al.dropdownItem,onClick:()=>{switch(e.value){case"magic-fill":{l(t);s(e.value);break}case"download":{var r="".concat((0,rb/* .nanoid */.Ak)(),".png");o5(t,r);break}default:break}i(false)},children:[e.icon,e.label]},r)})})})]})};var as=/*#__PURE__*/(0,d/* .keyframes */.i7)("		0%{opacity:0.3;}25%{opacity:0.5;}50%{opacity:0.7;}75%{opacity:0.5;}100%{opacity:0.3;}");var al={loader:e=>/*#__PURE__*/(0,d/* .css */.AH)("border-radius:",rn/* .borderRadius["12"] */.Vq["12"],";background:linear-gradient(\n      73.09deg,#ff9645 18.05%,#ff6471 30.25%,#cf6ebd 55.42%,#a477d1 71.66%,#3e64de 97.9%\n    );position:relative;width:100%;height:100%;background-size:612px 612px;opacity:0.3;transition:opacity 0.5s ease;animation:",as," 2s linear infinite;",e===1&&(0,d/* .css */.AH)(ae())," ",e===2&&(0,d/* .css */.AH)(at()),"		",e===3&&(0,d/* .css */.AH)(ar()),"		",e===4&&(0,d/* .css */.AH)(an())),image:e=>{var{isActive:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("width:100%;height:100%;overflow:hidden;border-radius:",rn/* .borderRadius["12"] */.Vq["12"],";position:relative;outline:2px solid transparent;outline-offset:2px;transition:border-radius 0.3s ease;[data-actions]{opacity:0;transition:opacity 0.3s ease;}img{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;}",t&&(0,d/* .css */.AH)(ao(),rn/* .colorTokens.stroke.brand */.I6.stroke.brand),"    &:hover,&:focus-within{outline-color:",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";[data-actions]{opacity:1;}}")},threeDots:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;top:",rn/* .spacing["8"] */.YK["8"],";right:",rn/* .spacing["8"] */.YK["8"],";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";"),useButton:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;left:50%;bottom:",rn/* .spacing["12"] */.YK["12"],";transform:translateX(-50%);button{display:inline-flex;align-items:center;gap:",rn/* .spacing["4"] */.YK["4"],";}"),dropdownOptions:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;padding-block:",rn/* .spacing["8"] */.YK["8"],";"),dropdownItem:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small(),";",rA/* .styleUtils.resetButton */.x.resetButton,";height:40px;display:flex;gap:",rn/* .spacing["10"] */.YK["10"],";align-items:center;transition:background-color 0.3s ease;color:",rn/* .colorTokens.text.title */.I6.text.title,";padding-inline:",rn/* .spacing["8"] */.YK["8"],";cursor:pointer;svg{color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";}&:hover{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-image/styles.ts
var ac={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("min-width:1000px;display:grid;grid-template-columns:1fr 330px;",rn/* .Breakpoint.tablet */.EA.tablet,"{min-width:auto;grid-template-columns:1fr;width:100%;}"),left:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;justify-content:center;align-items:center;background-color:#f7f7f7;z-index:",rn/* .zIndex.level */.fE.level,";"),right:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["20"] */.YK["20"],";display:flex;flex-direction:column;align-items:space-between;z-index:",rn/* .zIndex.positive */.fE.positive,";"),rightFooter:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";margin-top:auto;padding-top:80px;")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-image/ImageGeneration.tsx
var au=[{label:(0,h.__)("None","tutor-pro"),value:"none",image:oZ},{label:(0,h.__)("Photo","tutor-pro"),value:"photo",image:o0},{label:(0,h.__)("Neon","tutor-pro"),value:"neon",image:o$},{label:(0,h.__)("3D","tutor-pro"),value:"3d",image:oj},{label:(0,h.__)("Painting","tutor-pro"),value:"painting",image:oJ},{label:(0,h.__)("Sketch","tutor-pro"),value:"sketch",image:o6},{label:(0,h.__)("Concept","tutor-pro"),value:"concept_art",image:oU},{label:(0,h.__)("Illustration","tutor-pro"),value:"illustration",image:oX},{label:(0,h.__)("Dreamy","tutor-pro"),value:"dreamy",image:oG},{label:(0,h.__)("Filmic","tutor-pro"),value:"filmic",image:oQ},{label:(0,h.__)("Retro","tutor-pro"),value:"retrowave",image:o1},{label:(0,h.__)("Black & White","tutor-pro"),value:"black-and-white",image:oq}];var ad=()=>{var e=t9({defaultValues:{style:"none",prompt:""}});var{images:t,setImages:r}=oP();var n=nc();var{showToast:o}=(0,rv/* .useToast */.d)();var[a,i]=(0,v.useState)(t.every(e=>e===null));var[s,l]=(0,v.useState)([false,false,false,false]);var c=e.watch("style");var d=e.watch("prompt");var f=!c||!d;var p=t.some(rc/* .isDefined */.O9);(0,v.useEffect)(()=>{if(n.isError){o({type:"danger",message:n.error.response.data.message})}// eslint-disable-next-line react-hooks/exhaustive-deps
},[n.isError]);(0,v.useEffect)(()=>{e.setFocus("prompt");// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);return/*#__PURE__*/(0,u/* .jsxs */.FD)("form",{css:ac.wrapper,onSubmit:e.handleSubmit(e=>rI(function*(){l([true,true,true,true]);i(false);try{yield Promise.all(Array.from({length:4}).map((t,o)=>{return n.mutateAsync(e).then(e=>{r(t=>{var r,n;var a=[...t];var i;a[o]=(i=(n=e.data.data)===null||n===void 0?void 0:(r=n[0])===null||r===void 0?void 0:r.b64_json)!==null&&i!==void 0?i:null;return a});l(e=>{var t=[...e];t[o]=false;return t})}).catch(e=>{l(e=>{var t=[...e];t[o]=false;return t});throw e})}))}catch(e){l([false,false,false,false]);i(true)}})()),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:ac.left,children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!a,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicAiPlaceholder",width:72,height:72}),children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:af.images,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:t,children:(e,t)=>{return/*#__PURE__*/(0,u/* .jsx */.Y)(ai,{src:e,loading:s[t],index:t},t)}})})})}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:ac.right,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:af.fields,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:af.promptWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"prompt",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(rO/* ["default"] */.A,(0,w._)((0,_._)({},e),{label:(0,h.__)("Visualize Your Course","tutor-pro"),placeholder:(0,h.__)("Describe the image you want for your course thumbnail","tutor-pro"),rows:4,isMagicAi:true,disabled:n.isPending,enableResize:false}))}),/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:af.inspireButton,onClick:()=>{var t=oK.length;var r=Math.floor(Math.random()*t);e.reset((0,w._)((0,_._)({},e.getValues()),{prompt:oK[r]}))},disabled:n.isPending,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"bulbLine"}),(0,h.__)("Inspire Me","tutor-pro")]})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"style",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oz,(0,w._)((0,_._)({},e),{label:(0,h.__)("Styles","tutor-pro"),options:au,disabled:n.isPending}))})]}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:ac.rightFooter,children:/*#__PURE__*/(0,u/* .jsxs */.FD)(rE,{type:"submit",disabled:n.isPending||f,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:p?"reload":"magicAi",width:24,height:24}),p?(0,h.__)("Generate Again","tutor-pro"):(0,h.__)("Generate Now","tutor-pro")]})})]})]})};var af={images:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:repeat(2,minmax(150px,1fr));grid-template-rows:repeat(2,minmax(150px,1fr));gap:",rn/* .spacing["12"] */.YK["12"],";align-self:start;padding:",rn/* .spacing["24"] */.YK["24"],";width:100%;height:100%;> div{aspect-ratio:1 / 1;}"),fields:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["12"] */.YK["12"],";"),promptWrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;textarea{padding-bottom:",rn/* .spacing["40"] */.YK["40"]," !important;}"),inspireButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.small */.I.small(),";position:absolute;height:28px;bottom:",rn/* .spacing["12"] */.YK["12"],";left:",rn/* .spacing["12"] */.YK["12"],";border:1px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";display:flex;align-items:center;gap:",rn/* .spacing["4"] */.YK["4"],";color:",rn/* .colorTokens.text.brand */.I6.text.brand,";padding-inline:",rn/* .spacing["12"] */.YK["12"],";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";&:hover{background-color:",rn/* .colorTokens.background.brand */.I6.background.brand,";color:",rn/* .colorTokens.text.white */.I6.text.white,";}&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}&:disabled{background-color:",rn/* .colorTokens.background.disable */.I6.background.disable,";color:",rn/* .colorTokens.text.disable */.I6.text.disable,";}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/Separator.tsx
var ap=/*#__PURE__*/g().forwardRef((e,t)=>{var{className:r,variant:n}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{className:r,ref:t,css:av({variant:n})})});ap.displayName="Separator";var ah={horizontal:/*#__PURE__*/(0,d/* .css */.AH)("height:1px;width:100%;"),vertical:/*#__PURE__*/(0,d/* .css */.AH)("height:100%;width:1px;"),base:/*#__PURE__*/(0,d/* .css */.AH)("flex-shrink:0;background-color:",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";")};var av=(0,rS/* .createVariation */.s)({variants:{variant:{horizontal:ah.horizontal,vertical:ah.vertical}},defaultVariants:{variant:"horizontal"}},ah.base);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormRangeSliderField.tsx
function ag(){var e=(0,x._)(["\n      border: 1px solid ",";\n      border-radius: ",";\n      padding: "," "," "," ",";\n    "]);ag=function t(){return e};return e}function am(){var e=(0,x._)(["\n      background: ",";\n    "]);am=function t(){return e};return e}function ab(e,t,r,n){if(!t.current){return 0}var o=t.current.getBoundingClientRect();var a=o.width;var i=e-o.left;var s=Math.max(0,Math.min(i,a));var l=s/a*100;var c=Math.floor(r+l/100*(n-r));return c}var ay=e=>{var{field:t,fieldState:r,label:n,min:o=0,max:a=100,isMagicAi:i=false,hasBorder:s=false}=e;var l=(0,v.useRef)(null);var[c,d]=(0,v.useState)(t.value);var f=(0,v.useRef)(null);var p=(0,v.useRef)(null);var h=rs(c);(0,v.useEffect)(()=>{t.onChange(h);// eslint-disable-next-line react-hooks/exhaustive-deps
},[h,t.onChange]);(0,v.useEffect)(()=>{var e=false;var t=t=>{if(t.target!==p.current){return}e=true;document.body.style.userSelect="none"};var r=t=>{if(!e||!f.current){return}d(ab(t.clientX,f,o,a))};var n=()=>{e=false;document.body.style.userSelect="auto"};window.addEventListener("mousedown",t);window.addEventListener("mousemove",r);window.addEventListener("mouseup",n);return()=>{window.removeEventListener("mousedown",t);window.removeEventListener("mousemove",r);window.removeEventListener("mouseup",n)}},[o,a]);var g=(0,v.useMemo)(()=>{return Math.floor((c-o)/(a-o)*100)},[c,o,a]);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{field:t,fieldState:r,label:n,isMagicAi:i,children:()=>/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aw.wrapper(s),children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aw.track,ref:f,onKeyDown:rb/* .noop */.lQ,onClick:e=>{d(ab(e.clientX,f,o,a))},children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:aw.fill,style:{width:"".concat(g,"%")}}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:aw.thumb(i),style:{left:"".concat(g,"%")},ref:p})]}),/*#__PURE__*/(0,u/* .jsx */.Y)("input",{type:"text",css:aw.input,value:String(c),onChange:e=>{d(Number(e.target.value))},ref:l,onFocus:()=>{var e;(e=l.current)===null||e===void 0?void 0:e.select()}})]})})};/* ESM default export */const a_=ay;var aw={wrapper:e=>/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:1fr 45px;gap:",rn/* .spacing["20"] */.YK["20"],";align-items:center;",e&&(0,d/* .css */.AH)(ag(),rn/* .colorTokens.stroke.disable */.I6.stroke.disable,rn/* .borderRadius["6"] */.Vq["6"],rn/* .spacing["12"] */.YK["12"],rn/* .spacing["10"] */.YK["10"],rn/* .spacing["12"] */.YK["12"],rn/* .spacing["16"] */.YK["16"])),track:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;height:4px;background-color:",rn/* .colorTokens.bg.gray20 */.I6.bg.gray20,";border-radius:",rn/* .borderRadius["50"] */.Vq["50"],";width:100%;flex-shrink:0;cursor:pointer;"),fill:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;left:0;top:0;height:100%;background:",rn/* .colorTokens.ai.gradient_1 */.I6.ai.gradient_1,";width:50%;border-radius:",rn/* .borderRadius["50"] */.Vq["50"],";"),thumb:e=>/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;top:50%;transform:translate(-50%,-50%);width:20px;height:20px;border-radius:",rn/* .borderRadius.circle */.Vq.circle,";&::before{content:'';position:absolute;top:50%;left:50%;width:8px;height:8px;transform:translate(-50%,-50%);border-radius:",rn/* .borderRadius.circle */.Vq.circle,";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";cursor:pointer;}",e&&(0,d/* .css */.AH)(am(),rn/* .colorTokens.ai.gradient_1 */.I6.ai.gradient_1)),input:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption("medium"),";height:32px;border:1px solid ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";text-align:center;color:",rn/* .colorTokens.text.primary */.I6.text.primary,";&:focus-visible{",rA/* .styleUtils.inputFocus */.x.inputFocus,";}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-image/DrawingCanvas.tsx
var ax=/*#__PURE__*/g().forwardRef((e,t)=>{var{src:r,width:n,height:o,brushSize:a,trackStack:i,pointer:s,setTrackStack:l,setPointer:c}=e;var[d,f]=(0,v.useState)(false);var[p,h]=(0,v.useState)({x:0,y:0});var g=(0,v.useRef)(null);var m=e=>{var{canvas:r,context:n}=o7(t);if(!r||!n){return}var o=r.getBoundingClientRect();var a=(e.clientX-o.left)*(r.width/o.width);var i=(e.clientY-o.top)*(r.height/o.height);n.globalCompositeOperation="destination-out";n.beginPath();n.moveTo(a,i);f(true);h({x:a,y:i})};var b=e=>{var{canvas:r,context:n}=o7(t);if(!r||!n||!g.current){return}var o=r.getBoundingClientRect();var a={x:(e.clientX-o.left)*(r.width/o.width),y:(e.clientY-o.top)*(r.height/o.height)};if(d){o2(n,a)}g.current.style.left="".concat(a.x,"px");g.current.style.top="".concat(a.y,"px")};var y=e=>{var{canvas:r,context:n}=o7(t);if(!n||!r){return}f(false);n.closePath();var o=r.getBoundingClientRect();var a={x:(e.clientX-o.left)*(r.width/o.width),y:(e.clientY-o.top)*(r.height/o.height)};// Check if the mouse is just clicked but not drag for drawing a path, then draw a circle
if(o4(p,a)===0){o2(n,{x:a.x+1,y:a.y+1})}l(e=>{var t=e.slice(0,s);return[...t,n.getImageData(0,0,1024,1024)]});c(e=>e+1)};var _=()=>{var{canvas:e,context:n}=o7(t);if(!e||!n){return}var o=new Image;o.src=r;o.onload=()=>{n.clearRect(0,0,e.width,e.height);var t=o.width/o.height;var r=e.width/e.height;var a;var s;if(r>t){s=e.height;a=e.height*t}else{a=e.width;s=e.width/t}var c=(e.width-a)/2;var u=(e.height-s)/2;n.drawImage(o,c,u,a,s);if(i.length===0){l([n.getImageData(0,0,e.width,e.height)])}};n.lineJoin="round";n.lineCap="round"};var w=()=>{if(!g.current){return}document.body.style.cursor="none";g.current.style.display="block"};var x=()=>{if(!g.current){return}document.body.style.cursor="auto";g.current.style.display="none"};(0,v.useEffect)(()=>{_();// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aA.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("canvas",{ref:t,width:n,height:o,onMouseDown:m,onMouseMove:b,onMouseUp:y,onMouseEnter:w,onMouseLeave:x}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{ref:g,css:aA.customCursor(a)})]})});var aA={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;"),customCursor:e=>/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;width:",e,"px;height:",e,"px;border-radius:",rn/* .borderRadius.circle */.Vq.circle,";background:linear-gradient(\n      73.09deg,rgba(255,150,69,0.4) 18.05%,rgba(255,100,113,0.4) 30.25%,rgba(207,110,189,0.4) 55.42%,rgba(164,119,209,0.4) 71.66%,rgba(62,100,222,0.4) 97.9%\n    );border:3px solid ",rn/* .colorTokens.stroke.white */.I6.stroke.white,";pointer-events:none;transform:translate(-50%,-50%);z-index:",rn/* .zIndex.highest */.fE.highest,";display:none;")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/magic-ai-image/MagicFill.tsx
var ak=620;var aY=620;var aI=()=>{var e=rl({defaultValues:{brush_size:40,prompt:""}});var t=nd();var r=(0,v.useRef)(null);var{onDropdownMenuChange:n,currentImage:o,field:a,onCloseModal:i}=oP();var s=nm();var l=rs(e.watch("brush_size",40));var[c,f]=(0,v.useState)([]);var[p,g]=(0,v.useState)(1);var m=(0,v.useCallback)((e,t)=>{var n;var o=(n=r.current)===null||n===void 0?void 0:n.getContext("2d");if(!o){return}for(var a of t.slice(0,e)){o.putImageData(a,0,0)}},[]);(0,v.useEffect)(()=>{var e;var t=(e=r.current)===null||e===void 0?void 0:e.getContext("2d");if(!t){return}t.lineWidth=l},[l]);(0,v.useEffect)(()=>{var e=e=>{if(e.metaKey){if(e.shiftKey&&e.key.toUpperCase()==="Z"){m(p+1,c);g(e=>Math.min(e+1,c.length));return}if(e.key.toUpperCase()==="Z"){m(p-1,c);g(e=>Math.max(e-1,1));return}}};window.addEventListener("keydown",e);return()=>{window.removeEventListener("keydown",e)}},[p,c,m]);if(!o){return null}return/*#__PURE__*/(0,u/* .jsxs */.FD)("form",{css:ac.wrapper,onSubmit:e.handleSubmit(e=>rI(function*(){var n=r.current;var o=n===null||n===void 0?void 0:n.getContext("2d");if(!n||!o){return}var a={prompt:e.prompt,image:o9(n)};var i=yield t.mutateAsync(a);if(i){var s=new Image;s.onload=()=>{n.width=ak;n.height=aY;o.drawImage(s,0,0,n.width,n.height);o.lineWidth=l;o.lineJoin="round";o.lineCap="round"};s.src=i}})()),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:ac.left,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.leftWrapper,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.actionBar,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.backButtonWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:aS.backButton,onClick:()=>n("generation"),children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"arrowLeft"})}),(0,h.__)("Magic Fill","tutor-pro")]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.actions,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"ghost",disabled:c.length===0,onClick:()=>{m(1,c);f(c.slice(0,1));g(1)},children:(0,h.__)("Revert to Original","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(ap,{variant:"vertical",css:/*#__PURE__*/(0,d/* .css */.AH)("min-height:16px;")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.undoRedo,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"ghost",size:"icon",disabled:p<=1,onClick:()=>{m(p-1,c);g(e=>Math.max(e-1,1))},children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"undo",width:20,height:20})}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"ghost",size:"icon",disabled:p===c.length,onClick:()=>{m(p+1,c);g(e=>Math.min(e+1,c.length))},children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"redo",width:20,height:20})})]})]})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.canvasAndLoading,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ax,{ref:r,width:ak,height:aY,src:o,brushSize:l,trackStack:c,pointer:p,setTrackStack:f,setPointer:g}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t.isPending,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:aS.loading})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:aS.footerActions,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:aS.footerActionsLeft,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"secondary",onClick:()=>{var e="".concat((0,rb/* .nanoid */.Ak)(),".png");var{canvas:t}=o7(r);if(!t)return;o5(o9(t),e)},children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"download",width:24,height:24})})})})]})}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:ac.right,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.fields,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"brush_size",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(a_,(0,w._)((0,_._)({},e),{label:"Brush Size",min:1,max:100,isMagicAi:true,hasBorder:true}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"prompt",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(rO/* ["default"] */.A,(0,w._)((0,_._)({},e),{label:(0,h.__)("Describe the Fill","tutor-pro"),placeholder:(0,h.__)("Write 5 words to describe...","tutor-pro"),rows:4,isMagicAi:true}))})]}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:[ac.rightFooter,/*#__PURE__*/(0,d/* .css */.AH)("margin-top:auto;")],children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:aS.footerButtons,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)(rE,{type:"submit",disabled:t.isPending||!e.watch("prompt"),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicWand",width:24,height:24}),(0,h.__)("Generative Erase","tutor-pro")]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rE,{variant:"primary_outline",disabled:t.isPending,loading:s.isPending,onClick:()=>rI(function*(){var{canvas:e}=o7(r);if(!e)return;var t=yield s.mutateAsync({image:o9(e)});if(t.data){a.onChange(t.data);i()}})(),children:(0,h.__)("Use Image","tutor-pro")})]})})]})]})};/* ESM default export */const aD=aI;var aC={loading:/*#__PURE__*/(0,d/* .keyframes */.i7)("0%{opacity:0;}50%{opacity:0.6;}100%{opacity:0;}"),walker:/*#__PURE__*/(0,d/* .keyframes */.i7)("0%{left:0%;}100%{left:100%;}")};var aS={canvasAndLoading:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;z-index:",rn/* .zIndex.positive */.fE.positive,";"),loading:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;top:0;left:0;width:100%;height:100%;background:",rn/* .colorTokens.ai.gradient_1 */.I6.ai.gradient_1,";opacity:0.6;transition:0.5s ease opacity;animation:",aC.loading," 1s linear infinite;z-index:0;&::before{content:'';position:absolute;top:0;left:0;width:200px;height:100%;background:linear-gradient(\n        270deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.6) 51.13%,rgba(255,255,255,0) 100%\n      );animation:",aC.walker," 1s linear infinite;}"),actionBar:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;justify-content:space-between;"),fields:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["12"] */.YK["12"],";"),leftWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";padding-block:",rn/* .spacing["16"] */.YK["16"],";"),footerButtons:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";"),footerActions:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;justify-content:space-between;"),footerActionsLeft:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["12"] */.YK["12"],";"),actions:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["16"] */.YK["16"],";"),undoRedo:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["12"] */.YK["12"],";"),backButtonWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";",ro/* .typography.body */.I.body("medium"),";color:",rn/* .colorTokens.text.title */.I6.text.title,";"),backButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";width:24px;height:24px;border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";display:flex;align-items:center;justify-content:center;"),image:/*#__PURE__*/(0,d/* .css */.AH)("width:492px;height:498px;position:relative;img{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;}"),canvasWrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;"),customCursor:e=>/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;width:",e,"px;height:",e,"px;border-radius:",rn/* .borderRadius.circle */.Vq.circle,";background:linear-gradient(\n      73.09deg,rgba(255,150,69,0.4) 18.05%,rgba(255,100,113,0.4) 30.25%,rgba(207,110,189,0.4) 55.42%,rgba(164,119,209,0.4) 71.66%,rgba(62,100,222,0.4) 97.9%\n    );border:3px solid ",rn/* .colorTokens.stroke.white */.I6.stroke.white,";pointer-events:none;transform:translate(-50%,-50%);z-index:",rn/* .zIndex.highest */.fE.highest,";display:none;")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/modals/AiImageModal.tsx
function aM(){var{state:e}=oP();switch(e){case"generation":return/*#__PURE__*/(0,u/* .jsx */.Y)(ad,{});case"magic-fill":return/*#__PURE__*/(0,u/* .jsx */.Y)(aD,{});default:return null}}var aE=e=>{var{title:t,icon:r,closeModal:n,field:o,fieldState:a}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)(nM/* ["default"] */.A,{onClose:n,title:t,icon:r,maxWidth:1e3,children:/*#__PURE__*/(0,u/* .jsx */.Y)(oL,{field:o,fieldState:a,onCloseModal:n,children:/*#__PURE__*/(0,u/* .jsx */.Y)(aM,{})})})};/* ESM default export */const aF=aE;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/useWpMedia.ts
var aH=e=>{var{options:t={},onChange:r,initialFiles:n}=e;var{showToast:o}=(0,rv/* .useToast */.d)();var a=(0,v.useMemo)(()=>n?Array.isArray(n)?n:[n]:[],[n]);var i=(0,v.useMemo)(()=>(0,w._)((0,_._)({},t,t.type?{library:{type:t.type}}:{}),{multiple:t.multiple?t.multiple===true?"add":t.multiple:false}),[t]);var[s,l]=(0,v.useState)(a);(0,v.useEffect)(()=>{if(a&&!s.length){l(a)}},[s,a]);var c=(0,v.useCallback)(()=>{var e;if(!((e=window.wp)===null||e===void 0?void 0:e.media)){// eslint-disable-next-line no-console
console.error("WordPress media library is not available");return}var t=window.wp.media(i);t.on("close",()=>{if(t.$el){t.$el.parent().parent().remove()}});t.on("open",()=>{var e=t.state().get("selection");t.$el.attr("data-focus-trap","true");e.reset();s.forEach(t=>{var r=window.wp.media.attachment(t.id);if(r){r.fetch();e.add(r)}})});t.on("select",()=>{var e=t.state().get("selection").toJSON();var n=new Set(e.map(e=>e.id));var a=s.filter(e=>n.has(e.id));var c=e.reduce((e,t)=>{if(a.some(e=>e.id===t.id)){return e}if(i.maxFileSize&&t.filesizeInBytes>i.maxFileSize){o({// translators: %s is the file title
message:(0,h.sprintf)((0,h.__)("%s size exceeds the maximum allowed size","tutor-pro"),t.title),type:"danger"});return e}var r={id:t.id,title:t.title,url:t.url,name:t.title,size:t.filesizeHumanReadable,size_bytes:t.filesizeInBytes,ext:t.filename.split(".").pop()||""};e.push(r);return e},[]);var u=i.multiple?[...a,...c]:c.slice(0,1);if(i.maxFiles&&u.length>i.maxFiles){o({// translators: %d is the maximum number of files allowed
message:(0,h.sprintf)((0,h.__)("Cannot select more than %d files","tutor-pro"),i.maxFiles),type:"warning"});return}l(u);r===null||r===void 0?void 0:r(i.multiple?u:u[0]||null);t.close()});t.open()},[i,r,s,o]);var u=(0,v.useCallback)(()=>{l([]);r===null||r===void 0?void 0:r(i.multiple?[]:null)},[i.multiple,r]);return{openMediaLibrary:c,existingFiles:s,resetFiles:u}};/* ESM default export */const aT=aH;// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/pro-placeholders/generate-image-2x.webp
const aO=r.p+"images/generate-image-2x-7d387dcf.webp";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/pro-placeholders/generate-image.webp
const aK=r.p+"images/generate-image-3e5f50a6.webp";// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormImageInput.tsx
var aN;var aP=!!nK/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url;var aL=(aN=nK/* .tutorConfig.settings */.P.settings)===null||aN===void 0?void 0:aN.chatgpt_key_exist;var aW=e=>{var{field:t,fieldState:r,label:n,size:o,helpText:a,buttonText:i=(0,h.__)("Upload Media","tutor-pro"),infoText:s,onChange:l,generateWithAi:c=false,previewImageCss:d,loading:f,onClickAiButton:p}=e;var{showModal:v}=(0,nO/* .useModal */.h)();var{openMediaLibrary:g,resetFiles:m}=aT({options:{type:"image",multiple:false},onChange:e=>{if(e&&!Array.isArray(e)){var{id:r,url:n,title:o}=e;t.onChange({id:r,url:n,title:o});if(l){l({id:r,url:n,title:o})}}},initialFiles:t.value});var b=t.value;var _=()=>{g()};var w=()=>{m();t.onChange(null);if(l){l(null)}};var x=()=>{if(!aP){v({component:nL,props:{image:aK,image2x:aO}})}else if(!aL){v({component:oa,props:{image:aK,image2x:aO}})}else{v({component:aF,isMagicAi:true,props:{title:(0,h.__)("AI Studio","tutor-pro"),icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicAiColorize",width:24,height:24}),field:t,fieldState:r}});p===null||p===void 0?void 0:p()}};return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:n,field:t,fieldState:r,helpText:a,onClickAiButton:x,generateWithAi:c,children:()=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{children:/*#__PURE__*/(0,u/* .jsx */.Y)(oT,{size:o,value:b,uploadHandler:_,clearHandler:w,buttonText:i,infoText:s,previewImageCss:d,loading:f})})}})};/* ESM default export */const aB=(0,ri/* .withVisibilityControl */.M)(aW);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/fields/FormCheckbox.tsx
var aR=r(9789);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormInputWithContent.tsx
function az(){var e=(0,x._)(["\n      border: 1px solid ",";\n      border-radius: ",";\n      box-shadow: ",";\n      background-color: ",";\n    "]);az=function t(){return e};return e}function aV(){var e=(0,x._)(["\n      border-color: ",";\n      background-color: ",";\n    "]);aV=function t(){return e};return e}function aj(){var e=(0,x._)(["\n        border-color: ",";\n      "]);aj=function t(){return e};return e}function aq(){var e=(0,x._)(["\n          padding-",": ",";\n        "]);aq=function t(){return e};return e}function aU(){var e=(0,x._)(["\n            padding-",": ",";\n          "]);aU=function t(){return e};return e}function aG(){var e=(0,x._)(["\n          font-size: ",";\n          font-weight: ",";\n          height: 34px;\n          ",";\n        "]);aG=function t(){return e};return e}function aQ(){var e=(0,x._)(["\n      ","\n    "]);aQ=function t(){return e};return e}function aX(){var e=(0,x._)(["\n      border-right: 1px solid ",";\n    "]);aX=function t(){return e};return e}function a$(){var e=(0,x._)(["\n      ","\n    "]);a$=function t(){return e};return e}function aZ(){var e=(0,x._)(["\n      border-left: 1px solid ",";\n    "]);aZ=function t(){return e};return e}var aJ=e=>{var{label:t,content:r,contentPosition:n="left",showVerticalBar:o=true,size:a="regular",type:i="text",field:s,fieldState:l,disabled:c,readOnly:d,loading:f,placeholder:p,helpText:h,onChange:g,onKeyDown:m,isHidden:b,wrapperCss:y,contentCss:x,removeBorder:A=false,selectOnFocus:k=false}=e;var Y=(0,v.useRef)(null);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:t,field:s,fieldState:l,disabled:c,readOnly:d,loading:f,placeholder:p,helpText:h,isHidden:b,removeBorder:A,children:e=>{var{css:t}=e,c=(0,rD._)(e,["css"]);var d;return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:[a1.inputWrapper(!!l.error,A),y],children:[n==="left"&&/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:[a1.inputLeftContent(o,a),x],children:r}),/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},s,c),{type:"text",value:(d=s.value)!==null&&d!==void 0?d:"",onChange:e=>{var t=i==="number"?e.target.value.replace(/[^0-9.]/g,"").replace(/(\..*)\./g,"$1"):e.target.value;s.onChange(t);if(g){g(t)}},onKeyDown:e=>m===null||m===void 0?void 0:m(e.key),css:[t,a1.input(n,o,a)],autoComplete:"off",ref:e=>{s.ref(e);// @ts-ignore
Y.current=e;// this is not ideal but it is the only way to set ref to the input element
},onFocus:()=>{if(!k||!Y.current){return}Y.current.select()},"data-input":true})),n==="right"&&/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:[a1.inputRightContent(o,a),x],children:r})]})}})};/* ESM default export */const a0=(0,ri/* .withVisibilityControl */.M)(aJ);var a1={inputWrapper:(e,t)=>/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;",!t&&(0,d/* .css */.AH)(az(),rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],rn/* .borderRadius["6"] */.Vq["6"],rn/* .shadow.input */.r7.input,rn/* .colorTokens.background.white */.I6.background.white)," ",e&&(0,d/* .css */.AH)(aV(),rn/* .colorTokens.stroke.danger */.I6.stroke.danger,rn/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail),";&:focus-within{",rA/* .styleUtils.inputFocus */.x.inputFocus,";",e&&(0,d/* .css */.AH)(aj(),rn/* .colorTokens.stroke.danger */.I6.stroke.danger),"}"),input:(e,t,r)=>/*#__PURE__*/(0,d/* .css */.AH)("&[data-input]{",ro/* .typography.body */.I.body(),";border:none;box-shadow:none;background-color:transparent;padding-",e,":0;",t&&(0,d/* .css */.AH)(aq(),e,rn/* .spacing["10"] */.YK["10"]),";",r==="large"&&(0,d/* .css */.AH)(aG(),rn/* .fontSize["24"] */.J["24"],rn/* .fontWeight.medium */.Wy.medium,t&&(0,d/* .css */.AH)(aU(),e,rn/* .spacing["12"] */.YK["12"])),"  \n      &:focus{box-shadow:none;outline:none;}}"),inputLeftContent:(e,t)=>/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small()," ",rA/* .styleUtils.flexCenter */.x.flexCenter(),"    height:40px;min-width:48px;color:",rn/* .colorTokens.icon.subdued */.I6.icon.subdued,";padding-inline:",rn/* .spacing["12"] */.YK["12"],";",t==="large"&&(0,d/* .css */.AH)(aQ(),ro/* .typography.body */.I.body())," ",e&&(0,d/* .css */.AH)(aX(),rn/* .colorTokens.stroke["default"] */.I6.stroke["default"])),inputRightContent:(e,t)=>/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small()," ",rA/* .styleUtils.flexCenter */.x.flexCenter(),"    height:40px;min-width:48px;color:",rn/* .colorTokens.icon.subdued */.I6.icon.subdued,";padding-inline:",rn/* .spacing["12"] */.YK["12"],";",t==="large"&&(0,d/* .css */.AH)(a$(),ro/* .typography.body */.I.body())," ",e&&(0,d/* .css */.AH)(aZ(),rn/* .colorTokens.stroke["default"] */.I6.stroke["default"]))};// EXTERNAL MODULE: external "ReactDOM"
var a6=r(5206);// CONCATENATED MODULE: ./node_modules/@dnd-kit/utilities/dist/utilities.esm.js
function a2(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++){t[r]=arguments[r]}return(0,v.useMemo)(()=>e=>{t.forEach(t=>t(e))},t)}// https://github.com/facebook/react/blob/master/packages/shared/ExecutionEnvironment.js
const a4=typeof window!=="undefined"&&typeof window.document!=="undefined"&&typeof window.document.createElement!=="undefined";function a3(e){const t=Object.prototype.toString.call(e);return t==="[object Window]"||// In Electron context the Window object serializes to [object global]
t==="[object global]"}function a5(e){return"nodeType"in e}function a8(e){var t,r;if(!e){return window}if(a3(e)){return e}if(!a5(e)){return window}return(t=(r=e.ownerDocument)==null?void 0:r.defaultView)!=null?t:window}function a7(e){const{Document:t}=a8(e);return e instanceof t}function a9(e){if(a3(e)){return false}return e instanceof a8(e).HTMLElement}function ie(e){return e instanceof a8(e).SVGElement}function it(e){if(!e){return document}if(a3(e)){return e.document}if(!a5(e)){return document}if(a7(e)){return e}if(a9(e)||ie(e)){return e.ownerDocument}return document}/**
 * A hook that resolves to useEffect on the server and useLayoutEffect on the client
 * @param callback {function} Callback function that is invoked when the dependencies of the hook change
 */const ir=a4?v.useLayoutEffect:v.useEffect;function io(e){const t=(0,v.useRef)(e);ir(()=>{t.current=e});return(0,v.useCallback)(function(){for(var e=arguments.length,r=new Array(e),n=0;n<e;n++){r[n]=arguments[n]}return t.current==null?void 0:t.current(...r)},[])}function ia(){const e=(0,v.useRef)(null);const t=(0,v.useCallback)((t,r)=>{e.current=setInterval(t,r)},[]);const r=(0,v.useCallback)(()=>{if(e.current!==null){clearInterval(e.current);e.current=null}},[]);return[t,r]}function ii(e,t){if(t===void 0){t=[e]}const r=(0,v.useRef)(e);ir(()=>{if(r.current!==e){r.current=e}},t);return r}function is(e,t){const r=(0,v.useRef)();return(0,v.useMemo)(()=>{const t=e(r.current);r.current=t;return t},[...t])}function il(e){const t=io(e);const r=(0,v.useRef)(null);const n=(0,v.useCallback)(e=>{if(e!==r.current){t==null?void 0:t(e,r.current)}r.current=e},[]);return[r,n]}function ic(e){const t=(0,v.useRef)();(0,v.useEffect)(()=>{t.current=e},[e]);return t.current}let iu={};function id(e,t){return(0,v.useMemo)(()=>{if(t){return t}const r=iu[e]==null?0:iu[e]+1;iu[e]=r;return e+"-"+r},[e,t])}function ip(e){return function(t){for(var r=arguments.length,n=new Array(r>1?r-1:0),o=1;o<r;o++){n[o-1]=arguments[o]}return n.reduce((t,r)=>{const n=Object.entries(r);for(const[r,o]of n){const n=t[r];if(n!=null){t[r]=n+e*o}}return t},{...t})}}const ih=/*#__PURE__*/ip(1);const iv=/*#__PURE__*/ip(-1);function ig(e){return"clientX"in e&&"clientY"in e}function im(e){if(!e){return false}const{KeyboardEvent:t}=a8(e.target);return t&&e instanceof t}function ib(e){if(!e){return false}const{TouchEvent:t}=a8(e.target);return t&&e instanceof t}/**
 * Returns the normalized x and y coordinates for mouse and touch events.
 */function iy(e){if(ib(e)){if(e.touches&&e.touches.length){const{clientX:t,clientY:r}=e.touches[0];return{x:t,y:r}}else if(e.changedTouches&&e.changedTouches.length){const{clientX:t,clientY:r}=e.changedTouches[0];return{x:t,y:r}}}if(ig(e)){return{x:e.clientX,y:e.clientY}}return null}const i_=/*#__PURE__*/Object.freeze({Translate:{toString(e){if(!e){return}const{x:t,y:r}=e;return"translate3d("+(t?Math.round(t):0)+"px, "+(r?Math.round(r):0)+"px, 0)"}},Scale:{toString(e){if(!e){return}const{scaleX:t,scaleY:r}=e;return"scaleX("+t+") scaleY("+r+")"}},Transform:{toString(e){if(!e){return}return[i_.Translate.toString(e),i_.Scale.toString(e)].join(" ")}},Transition:{toString(e){let{property:t,duration:r,easing:n}=e;return t+" "+r+"ms "+n}}});const iw="a,frame,iframe,input:not([type=hidden]):not(:disabled),select:not(:disabled),textarea:not(:disabled),button:not(:disabled),*[tabindex]";function ix(e){if(e.matches(iw)){return e}return e.querySelector(iw)}//# sourceMappingURL=utilities.esm.js.map
;// CONCATENATED MODULE: ./node_modules/@dnd-kit/accessibility/dist/accessibility.esm.js
const iA={display:"none"};function ik(e){let{id:t,value:r}=e;return g().createElement("div",{id:t,style:iA},r)}function iY(e){let{id:t,announcement:r,ariaLiveType:n="assertive"}=e;// Hide element visually but keep it readable by screen readers
const o={position:"fixed",top:0,left:0,width:1,height:1,margin:-1,border:0,padding:0,overflow:"hidden",clip:"rect(0 0 0 0)",clipPath:"inset(100%)",whiteSpace:"nowrap"};return g().createElement("div",{id:t,style:o,role:"status","aria-live":n,"aria-atomic":true},r)}function iI(){const[e,t]=(0,v.useState)("");const r=(0,v.useCallback)(e=>{if(e!=null){t(e)}},[]);return{announce:r,announcement:e}}//# sourceMappingURL=accessibility.esm.js.map
;// CONCATENATED MODULE: ./node_modules/@dnd-kit/core/dist/core.esm.js
const iD=/*#__PURE__*/(0,v.createContext)(null);function iC(e){const t=(0,v.useContext)(iD);(0,v.useEffect)(()=>{if(!t){throw new Error("useDndMonitor must be used within a children of <DndContext>")}const r=t(e);return r},[e,t])}function iS(){const[e]=(0,v.useState)(()=>new Set);const t=(0,v.useCallback)(t=>{e.add(t);return()=>e.delete(t)},[e]);const r=(0,v.useCallback)(t=>{let{type:r,event:n}=t;e.forEach(e=>{var t;return(t=e[r])==null?void 0:t.call(e,n)})},[e]);return[r,t]}const iM={draggable:"\n    To pick up a draggable item, press the space bar.\n    While dragging, use the arrow keys to move the item.\n    Press space again to drop the item in its new position, or press escape to cancel.\n  "};const iE={onDragStart(e){let{active:t}=e;return"Picked up draggable item "+t.id+"."},onDragOver(e){let{active:t,over:r}=e;if(r){return"Draggable item "+t.id+" was moved over droppable area "+r.id+"."}return"Draggable item "+t.id+" is no longer over a droppable area."},onDragEnd(e){let{active:t,over:r}=e;if(r){return"Draggable item "+t.id+" was dropped over droppable area "+r.id}return"Draggable item "+t.id+" was dropped."},onDragCancel(e){let{active:t}=e;return"Dragging was cancelled. Draggable item "+t.id+" was dropped."}};function iF(e){let{announcements:t=iE,container:r,hiddenTextDescribedById:n,screenReaderInstructions:o=iM}=e;const{announce:a,announcement:i}=iI();const s=id("DndLiveRegion");const[l,c]=(0,v.useState)(false);(0,v.useEffect)(()=>{c(true)},[]);iC((0,v.useMemo)(()=>({onDragStart(e){let{active:r}=e;a(t.onDragStart({active:r}))},onDragMove(e){let{active:r,over:n}=e;if(t.onDragMove){a(t.onDragMove({active:r,over:n}))}},onDragOver(e){let{active:r,over:n}=e;a(t.onDragOver({active:r,over:n}))},onDragEnd(e){let{active:r,over:n}=e;a(t.onDragEnd({active:r,over:n}))},onDragCancel(e){let{active:r,over:n}=e;a(t.onDragCancel({active:r,over:n}))}}),[a,t]));if(!l){return null}const u=g().createElement(g().Fragment,null,g().createElement(ik,{id:n,value:o.draggable}),g().createElement(iY,{id:s,announcement:i}));return r?(0,a6.createPortal)(u,r):u}var iH;(function(e){e["DragStart"]="dragStart";e["DragMove"]="dragMove";e["DragEnd"]="dragEnd";e["DragCancel"]="dragCancel";e["DragOver"]="dragOver";e["RegisterDroppable"]="registerDroppable";e["SetDroppableDisabled"]="setDroppableDisabled";e["UnregisterDroppable"]="unregisterDroppable"})(iH||(iH={}));function iT(){}function iO(e,t){return(0,v.useMemo)(()=>({sensor:e,options:t!=null?t:{}}),[e,t])}function iK(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++){t[r]=arguments[r]}return(0,v.useMemo)(()=>[...t].filter(e=>e!=null),[...t])}const iN=/*#__PURE__*/Object.freeze({x:0,y:0});/**
 * Returns the distance between two points
 */function iP(e,t){return Math.sqrt(Math.pow(e.x-t.x,2)+Math.pow(e.y-t.y,2))}function iL(e,t){const r=iy(e);if(!r){return"0 0"}const n={x:(r.x-t.left)/t.width*100,y:(r.y-t.top)/t.height*100};return n.x+"% "+n.y+"%"}/**
 * Sort collisions from smallest to greatest value
 */function iW(e,t){let{data:{value:r}}=e;let{data:{value:n}}=t;return r-n}/**
 * Sort collisions from greatest to smallest value
 */function iB(e,t){let{data:{value:r}}=e;let{data:{value:n}}=t;return n-r}/**
 * Returns the coordinates of the corners of a given rectangle:
 * [TopLeft {x, y}, TopRight {x, y}, BottomLeft {x, y}, BottomRight {x, y}]
 */function iR(e){let{left:t,top:r,height:n,width:o}=e;return[{x:t,y:r},{x:t+o,y:r},{x:t,y:r+n},{x:t+o,y:r+n}]}function iz(e,t){if(!e||e.length===0){return null}const[r]=e;return t?r[t]:r}/**
 * Returns the coordinates of the center of a given ClientRect
 */function iV(e,t,r){if(t===void 0){t=e.left}if(r===void 0){r=e.top}return{x:t+e.width*.5,y:r+e.height*.5}}/**
 * Returns the closest rectangles from an array of rectangles to the center of a given
 * rectangle.
 */const ij=e=>{let{collisionRect:t,droppableRects:r,droppableContainers:n}=e;const o=iV(t,t.left,t.top);const a=[];for(const e of n){const{id:t}=e;const n=r.get(t);if(n){const r=iP(iV(n),o);a.push({id:t,data:{droppableContainer:e,value:r}})}}return a.sort(iW)};/**
 * Returns the closest rectangles from an array of rectangles to the corners of
 * another rectangle.
 */const iq=e=>{let{collisionRect:t,droppableRects:r,droppableContainers:n}=e;const o=iR(t);const a=[];for(const e of n){const{id:t}=e;const n=r.get(t);if(n){const r=iR(n);const i=o.reduce((e,t,n)=>{return e+iP(r[n],t)},0);const s=Number((i/4).toFixed(4));a.push({id:t,data:{droppableContainer:e,value:s}})}}return a.sort(iW)};/**
 * Returns the intersecting rectangle area between two rectangles
 */function iU(e,t){const r=Math.max(t.top,e.top);const n=Math.max(t.left,e.left);const o=Math.min(t.left+t.width,e.left+e.width);const a=Math.min(t.top+t.height,e.top+e.height);const i=o-n;const s=a-r;if(n<o&&r<a){const r=t.width*t.height;const n=e.width*e.height;const o=i*s;const a=o/(r+n-o);return Number(a.toFixed(4))}// Rectangles do not overlap, or overlap has an area of zero (edge/corner overlap)
return 0}/**
 * Returns the rectangles that has the greatest intersection area with a given
 * rectangle in an array of rectangles.
 */const iG=e=>{let{collisionRect:t,droppableRects:r,droppableContainers:n}=e;const o=[];for(const e of n){const{id:n}=e;const a=r.get(n);if(a){const r=iU(a,t);if(r>0){o.push({id:n,data:{droppableContainer:e,value:r}})}}}return o.sort(iB)};/**
 * Check if a given point is contained within a bounding rectangle
 */function iQ(e,t){const{top:r,left:n,bottom:o,right:a}=t;return r<=e.y&&e.y<=o&&n<=e.x&&e.x<=a}/**
 * Returns the rectangles that the pointer is hovering over
 */const iX=e=>{let{droppableContainers:t,droppableRects:r,pointerCoordinates:n}=e;if(!n){return[]}const o=[];for(const e of t){const{id:t}=e;const a=r.get(t);if(a&&iQ(n,a)){/* There may be more than a single rectangle intersecting
       * with the pointer coordinates. In order to sort the
       * colliding rectangles, we measure the distance between
       * the pointer and the corners of the intersecting rectangle
       */const r=iR(a);const i=r.reduce((e,t)=>{return e+iP(n,t)},0);const s=Number((i/4).toFixed(4));o.push({id:t,data:{droppableContainer:e,value:s}})}}return o.sort(iW)};function i$(e,t,r){return{...e,scaleX:t&&r?t.width/r.width:1,scaleY:t&&r?t.height/r.height:1}}function iZ(e,t){return e&&t?{x:e.left-t.left,y:e.top-t.top}:iN}function iJ(e){return function t(t){for(var r=arguments.length,n=new Array(r>1?r-1:0),o=1;o<r;o++){n[o-1]=arguments[o]}return n.reduce((t,r)=>({...t,top:t.top+e*r.y,bottom:t.bottom+e*r.y,left:t.left+e*r.x,right:t.right+e*r.x}),{...t})}}const i0=/*#__PURE__*/iJ(1);function i1(e){if(e.startsWith("matrix3d(")){const t=e.slice(9,-1).split(/, /);return{x:+t[12],y:+t[13],scaleX:+t[0],scaleY:+t[5]}}else if(e.startsWith("matrix(")){const t=e.slice(7,-1).split(/, /);return{x:+t[4],y:+t[5],scaleX:+t[0],scaleY:+t[3]}}return null}function i6(e,t,r){const n=i1(t);if(!n){return e}const{scaleX:o,scaleY:a,x:i,y:s}=n;const l=e.left-i-(1-o)*parseFloat(r);const c=e.top-s-(1-a)*parseFloat(r.slice(r.indexOf(" ")+1));const u=o?e.width/o:e.width;const d=a?e.height/a:e.height;return{width:u,height:d,top:c,right:l+u,bottom:c+d,left:l}}const i2={ignoreTransform:false};/**
 * Returns the bounding client rect of an element relative to the viewport.
 */function i4(e,t){if(t===void 0){t=i2}let r=e.getBoundingClientRect();if(t.ignoreTransform){const{transform:t,transformOrigin:n}=a8(e).getComputedStyle(e);if(t){r=i6(r,t,n)}}const{top:n,left:o,width:a,height:i,bottom:s,right:l}=r;return{top:n,left:o,width:a,height:i,bottom:s,right:l}}/**
 * Returns the bounding client rect of an element relative to the viewport.
 *
 * @remarks
 * The ClientRect returned by this method does not take into account transforms
 * applied to the element it measures.
 *
 */function i3(e){return i4(e,{ignoreTransform:true})}function i5(e){const t=e.innerWidth;const r=e.innerHeight;return{top:0,left:0,right:t,bottom:r,width:t,height:r}}function i8(e,t){if(t===void 0){t=a8(e).getComputedStyle(e)}return t.position==="fixed"}function i7(e,t){if(t===void 0){t=a8(e).getComputedStyle(e)}const r=/(auto|scroll|overlay)/;const n=["overflow","overflowX","overflowY"];return n.some(e=>{const n=t[e];return typeof n==="string"?r.test(n):false})}function i9(e,t){const r=[];function n(o){if(t!=null&&r.length>=t){return r}if(!o){return r}if(a7(o)&&o.scrollingElement!=null&&!r.includes(o.scrollingElement)){r.push(o.scrollingElement);return r}if(!a9(o)||ie(o)){return r}if(r.includes(o)){return r}const a=a8(e).getComputedStyle(o);if(o!==e){if(i7(o,a)){r.push(o)}}if(i8(o,a)){return r}return n(o.parentNode)}if(!e){return r}return n(e)}function se(e){const[t]=i9(e,1);return t!=null?t:null}function st(e){if(!a4||!e){return null}if(a3(e)){return e}if(!a5(e)){return null}if(a7(e)||e===it(e).scrollingElement){return window}if(a9(e)){return e}return null}function sr(e){if(a3(e)){return e.scrollX}return e.scrollLeft}function sn(e){if(a3(e)){return e.scrollY}return e.scrollTop}function so(e){return{x:sr(e),y:sn(e)}}var sa;(function(e){e[e["Forward"]=1]="Forward";e[e["Backward"]=-1]="Backward"})(sa||(sa={}));function si(e){if(!a4||!e){return false}return e===document.scrollingElement}function ss(e){const t={x:0,y:0};const r=si(e)?{height:window.innerHeight,width:window.innerWidth}:{height:e.clientHeight,width:e.clientWidth};const n={x:e.scrollWidth-r.width,y:e.scrollHeight-r.height};const o=e.scrollTop<=t.y;const a=e.scrollLeft<=t.x;const i=e.scrollTop>=n.y;const s=e.scrollLeft>=n.x;return{isTop:o,isLeft:a,isBottom:i,isRight:s,maxScroll:n,minScroll:t}}const sl={x:.2,y:.2};function sc(e,t,r,n,o){let{top:a,left:i,right:s,bottom:l}=r;if(n===void 0){n=10}if(o===void 0){o=sl}const{isTop:c,isBottom:u,isLeft:d,isRight:f}=ss(e);const p={x:0,y:0};const h={x:0,y:0};const v={height:t.height*o.y,width:t.width*o.x};if(!c&&a<=t.top+v.height){// Scroll Up
p.y=sa.Backward;h.y=n*Math.abs((t.top+v.height-a)/v.height)}else if(!u&&l>=t.bottom-v.height){// Scroll Down
p.y=sa.Forward;h.y=n*Math.abs((t.bottom-v.height-l)/v.height)}if(!f&&s>=t.right-v.width){// Scroll Right
p.x=sa.Forward;h.x=n*Math.abs((t.right-v.width-s)/v.width)}else if(!d&&i<=t.left+v.width){// Scroll Left
p.x=sa.Backward;h.x=n*Math.abs((t.left+v.width-i)/v.width)}return{direction:p,speed:h}}function su(e){if(e===document.scrollingElement){const{innerWidth:e,innerHeight:t}=window;return{top:0,left:0,right:e,bottom:t,width:e,height:t}}const{top:t,left:r,right:n,bottom:o}=e.getBoundingClientRect();return{top:t,left:r,right:n,bottom:o,width:e.clientWidth,height:e.clientHeight}}function sd(e){return e.reduce((e,t)=>{return ih(e,so(t))},iN)}function sf(e){return e.reduce((e,t)=>{return e+sr(t)},0)}function sp(e){return e.reduce((e,t)=>{return e+sn(t)},0)}function sh(e,t){if(t===void 0){t=i4}if(!e){return}const{top:r,left:n,bottom:o,right:a}=t(e);const i=se(e);if(!i){return}if(o<=0||a<=0||r>=window.innerHeight||n>=window.innerWidth){e.scrollIntoView({block:"center",inline:"center"})}}const sv=[["x",["left","right"],sf],["y",["top","bottom"],sp]];class sg{constructor(e,t){this.rect=void 0;this.width=void 0;this.height=void 0;this.top=void 0;this.bottom=void 0;this.right=void 0;this.left=void 0;const r=i9(t);const n=sd(r);this.rect={...e};this.width=e.width;this.height=e.height;for(const[e,t,o]of sv){for(const a of t){Object.defineProperty(this,a,{get:()=>{const t=o(r);const i=n[e]-t;return this.rect[a]+i},enumerable:true})}}Object.defineProperty(this,"rect",{enumerable:false})}}class sm{constructor(e){this.target=void 0;this.listeners=[];this.removeAll=()=>{this.listeners.forEach(e=>{var t;return(t=this.target)==null?void 0:t.removeEventListener(...e)})};this.target=e}add(e,t,r){var n;(n=this.target)==null?void 0:n.addEventListener(e,t,r);this.listeners.push([e,t,r])}}function sb(e){// If the `event.target` element is removed from the document events will still be targeted
// at it, and hence won't always bubble up to the window or document anymore.
// If there is any risk of an element being removed while it is being dragged,
// the best practice is to attach the event listeners directly to the target.
// https://developer.mozilla.org/en-US/docs/Web/API/EventTarget
const{EventTarget:t}=a8(e);return e instanceof t?e:it(e)}function sy(e,t){const r=Math.abs(e.x);const n=Math.abs(e.y);if(typeof t==="number"){return Math.sqrt(r**2+n**2)>t}if("x"in t&&"y"in t){return r>t.x&&n>t.y}if("x"in t){return r>t.x}if("y"in t){return n>t.y}return false}var s_;(function(e){e["Click"]="click";e["DragStart"]="dragstart";e["Keydown"]="keydown";e["ContextMenu"]="contextmenu";e["Resize"]="resize";e["SelectionChange"]="selectionchange";e["VisibilityChange"]="visibilitychange"})(s_||(s_={}));function sw(e){e.preventDefault()}function sx(e){e.stopPropagation()}var sA;(function(e){e["Space"]="Space";e["Down"]="ArrowDown";e["Right"]="ArrowRight";e["Left"]="ArrowLeft";e["Up"]="ArrowUp";e["Esc"]="Escape";e["Enter"]="Enter";e["Tab"]="Tab"})(sA||(sA={}));const sk={start:[sA.Space,sA.Enter],cancel:[sA.Esc],end:[sA.Space,sA.Enter,sA.Tab]};const sY=(e,t)=>{let{currentCoordinates:r}=t;switch(e.code){case sA.Right:return{...r,x:r.x+25};case sA.Left:return{...r,x:r.x-25};case sA.Down:return{...r,y:r.y+25};case sA.Up:return{...r,y:r.y-25}}return undefined};class sI{constructor(e){this.props=void 0;this.autoScrollEnabled=false;this.referenceCoordinates=void 0;this.listeners=void 0;this.windowListeners=void 0;this.props=e;const{event:{target:t}}=e;this.props=e;this.listeners=new sm(it(t));this.windowListeners=new sm(a8(t));this.handleKeyDown=this.handleKeyDown.bind(this);this.handleCancel=this.handleCancel.bind(this);this.attach()}attach(){this.handleStart();this.windowListeners.add(s_.Resize,this.handleCancel);this.windowListeners.add(s_.VisibilityChange,this.handleCancel);setTimeout(()=>this.listeners.add(s_.Keydown,this.handleKeyDown))}handleStart(){const{activeNode:e,onStart:t}=this.props;const r=e.node.current;if(r){sh(r)}t(iN)}handleKeyDown(e){if(im(e)){const{active:t,context:r,options:n}=this.props;const{keyboardCodes:o=sk,coordinateGetter:a=sY,scrollBehavior:i="smooth"}=n;const{code:s}=e;if(o.end.includes(s)){this.handleEnd(e);return}if(o.cancel.includes(s)){this.handleCancel(e);return}const{collisionRect:l}=r.current;const c=l?{x:l.left,y:l.top}:iN;if(!this.referenceCoordinates){this.referenceCoordinates=c}const u=a(e,{active:t,context:r.current,currentCoordinates:c});if(u){const t=iv(u,c);const n={x:0,y:0};const{scrollableAncestors:o}=r.current;for(const r of o){const o=e.code;const{isTop:a,isRight:s,isLeft:l,isBottom:c,maxScroll:d,minScroll:f}=ss(r);const p=su(r);const h={x:Math.min(o===sA.Right?p.right-p.width/2:p.right,Math.max(o===sA.Right?p.left:p.left+p.width/2,u.x)),y:Math.min(o===sA.Down?p.bottom-p.height/2:p.bottom,Math.max(o===sA.Down?p.top:p.top+p.height/2,u.y))};const v=o===sA.Right&&!s||o===sA.Left&&!l;const g=o===sA.Down&&!c||o===sA.Up&&!a;if(v&&h.x!==u.x){const e=r.scrollLeft+t.x;const a=o===sA.Right&&e<=d.x||o===sA.Left&&e>=f.x;if(a&&!t.y){// We don't need to update coordinates, the scroll adjustment alone will trigger
// logic to auto-detect the new container we are over
r.scrollTo({left:e,behavior:i});return}if(a){n.x=r.scrollLeft-e}else{n.x=o===sA.Right?r.scrollLeft-d.x:r.scrollLeft-f.x}if(n.x){r.scrollBy({left:-n.x,behavior:i})}break}else if(g&&h.y!==u.y){const e=r.scrollTop+t.y;const a=o===sA.Down&&e<=d.y||o===sA.Up&&e>=f.y;if(a&&!t.x){// We don't need to update coordinates, the scroll adjustment alone will trigger
// logic to auto-detect the new container we are over
r.scrollTo({top:e,behavior:i});return}if(a){n.y=r.scrollTop-e}else{n.y=o===sA.Down?r.scrollTop-d.y:r.scrollTop-f.y}if(n.y){r.scrollBy({top:-n.y,behavior:i})}break}}this.handleMove(e,ih(iv(u,this.referenceCoordinates),n))}}}handleMove(e,t){const{onMove:r}=this.props;e.preventDefault();r(t)}handleEnd(e){const{onEnd:t}=this.props;e.preventDefault();this.detach();t()}handleCancel(e){const{onCancel:t}=this.props;e.preventDefault();this.detach();t()}detach(){this.listeners.removeAll();this.windowListeners.removeAll()}}sI.activators=[{eventName:"onKeyDown",handler:(e,t,r)=>{let{keyboardCodes:n=sk,onActivation:o}=t;let{active:a}=r;const{code:i}=e.nativeEvent;if(n.start.includes(i)){const t=a.activatorNode.current;if(t&&e.target!==t){return false}e.preventDefault();o==null?void 0:o({event:e.nativeEvent});return true}return false}}];function sD(e){return Boolean(e&&"distance"in e)}function sC(e){return Boolean(e&&"delay"in e)}class sS{constructor(e,t,r){var n;if(r===void 0){r=sb(e.event.target)}this.props=void 0;this.events=void 0;this.autoScrollEnabled=true;this.document=void 0;this.activated=false;this.initialCoordinates=void 0;this.timeoutId=null;this.listeners=void 0;this.documentListeners=void 0;this.windowListeners=void 0;this.props=e;this.events=t;const{event:o}=e;const{target:a}=o;this.props=e;this.events=t;this.document=it(a);this.documentListeners=new sm(this.document);this.listeners=new sm(r);this.windowListeners=new sm(a8(a));this.initialCoordinates=(n=iy(o))!=null?n:iN;this.handleStart=this.handleStart.bind(this);this.handleMove=this.handleMove.bind(this);this.handleEnd=this.handleEnd.bind(this);this.handleCancel=this.handleCancel.bind(this);this.handleKeydown=this.handleKeydown.bind(this);this.removeTextSelection=this.removeTextSelection.bind(this);this.attach()}attach(){const{events:e,props:{options:{activationConstraint:t,bypassActivationConstraint:r}}}=this;this.listeners.add(e.move.name,this.handleMove,{passive:false});this.listeners.add(e.end.name,this.handleEnd);if(e.cancel){this.listeners.add(e.cancel.name,this.handleCancel)}this.windowListeners.add(s_.Resize,this.handleCancel);this.windowListeners.add(s_.DragStart,sw);this.windowListeners.add(s_.VisibilityChange,this.handleCancel);this.windowListeners.add(s_.ContextMenu,sw);this.documentListeners.add(s_.Keydown,this.handleKeydown);if(t){if(r!=null&&r({event:this.props.event,activeNode:this.props.activeNode,options:this.props.options})){return this.handleStart()}if(sC(t)){this.timeoutId=setTimeout(this.handleStart,t.delay);this.handlePending(t);return}if(sD(t)){this.handlePending(t);return}}this.handleStart()}detach(){this.listeners.removeAll();this.windowListeners.removeAll();// Wait until the next event loop before removing document listeners
// This is necessary because we listen for `click` and `selection` events on the document
setTimeout(this.documentListeners.removeAll,50);if(this.timeoutId!==null){clearTimeout(this.timeoutId);this.timeoutId=null}}handlePending(e,t){const{active:r,onPending:n}=this.props;n(r,e,this.initialCoordinates,t)}handleStart(){const{initialCoordinates:e}=this;const{onStart:t}=this.props;if(e){this.activated=true;// Stop propagation of click events once activation constraints are met
this.documentListeners.add(s_.Click,sx,{capture:true});// Remove any text selection from the document
this.removeTextSelection();// Prevent further text selection while dragging
this.documentListeners.add(s_.SelectionChange,this.removeTextSelection);t(e)}}handleMove(e){var t;const{activated:r,initialCoordinates:n,props:o}=this;const{onMove:a,options:{activationConstraint:i}}=o;if(!n){return}const s=(t=iy(e))!=null?t:iN;const l=iv(n,s);// Constraint validation
if(!r&&i){if(sD(i)){if(i.tolerance!=null&&sy(l,i.tolerance)){return this.handleCancel()}if(sy(l,i.distance)){return this.handleStart()}}if(sC(i)){if(sy(l,i.tolerance)){return this.handleCancel()}}this.handlePending(i,l);return}if(e.cancelable){e.preventDefault()}a(s)}handleEnd(){const{onAbort:e,onEnd:t}=this.props;this.detach();if(!this.activated){e(this.props.active)}t()}handleCancel(){const{onAbort:e,onCancel:t}=this.props;this.detach();if(!this.activated){e(this.props.active)}t()}handleKeydown(e){if(e.code===sA.Esc){this.handleCancel()}}removeTextSelection(){var e;(e=this.document.getSelection())==null?void 0:e.removeAllRanges()}}const sM={cancel:{name:"pointercancel"},move:{name:"pointermove"},end:{name:"pointerup"}};class sE extends sS{constructor(e){const{event:t}=e;// Pointer events stop firing if the target is unmounted while dragging
// Therefore we attach listeners to the owner document instead
const r=it(t.target);super(e,sM,r)}}sE.activators=[{eventName:"onPointerDown",handler:(e,t)=>{let{nativeEvent:r}=e;let{onActivation:n}=t;if(!r.isPrimary||r.button!==0){return false}n==null?void 0:n({event:r});return true}}];const sF={move:{name:"mousemove"},end:{name:"mouseup"}};var sH;(function(e){e[e["RightClick"]=2]="RightClick"})(sH||(sH={}));class sT extends sS{constructor(e){super(e,sF,it(e.event.target))}}sT.activators=[{eventName:"onMouseDown",handler:(e,t)=>{let{nativeEvent:r}=e;let{onActivation:n}=t;if(r.button===sH.RightClick){return false}n==null?void 0:n({event:r});return true}}];const sO={cancel:{name:"touchcancel"},move:{name:"touchmove"},end:{name:"touchend"}};class sK extends sS{constructor(e){super(e,sO)}static setup(){// Adding a non-capture and non-passive `touchmove` listener in order
// to force `event.preventDefault()` calls to work in dynamically added
// touchmove event handlers. This is required for iOS Safari.
window.addEventListener(sO.move.name,e,{capture:false,passive:false});return function t(){window.removeEventListener(sO.move.name,e)};// We create a new handler because the teardown function of another sensor
// could remove our event listener if we use a referentially equal listener.
function e(){}}}sK.activators=[{eventName:"onTouchStart",handler:(e,t)=>{let{nativeEvent:r}=e;let{onActivation:n}=t;const{touches:o}=r;if(o.length>1){return false}n==null?void 0:n({event:r});return true}}];var sN;(function(e){e[e["Pointer"]=0]="Pointer";e[e["DraggableRect"]=1]="DraggableRect"})(sN||(sN={}));var sP;(function(e){e[e["TreeOrder"]=0]="TreeOrder";e[e["ReversedTreeOrder"]=1]="ReversedTreeOrder"})(sP||(sP={}));function sL(e){let{acceleration:t,activator:r=sN.Pointer,canScroll:n,draggingRect:o,enabled:a,interval:i=5,order:s=sP.TreeOrder,pointerCoordinates:l,scrollableAncestors:c,scrollableAncestorRects:u,delta:d,threshold:f}=e;const p=sB({delta:d,disabled:!a});const[h,g]=ia();const m=(0,v.useRef)({x:0,y:0});const b=(0,v.useRef)({x:0,y:0});const y=(0,v.useMemo)(()=>{switch(r){case sN.Pointer:return l?{top:l.y,bottom:l.y,left:l.x,right:l.x}:null;case sN.DraggableRect:return o}},[r,o,l]);const _=(0,v.useRef)(null);const w=(0,v.useCallback)(()=>{const e=_.current;if(!e){return}const t=m.current.x*b.current.x;const r=m.current.y*b.current.y;e.scrollBy(t,r)},[]);const x=(0,v.useMemo)(()=>s===sP.TreeOrder?[...c].reverse():c,[s,c]);(0,v.useEffect)(()=>{if(!a||!c.length||!y){g();return}for(const e of x){if((n==null?void 0:n(e))===false){continue}const r=c.indexOf(e);const o=u[r];if(!o){continue}const{direction:a,speed:s}=sc(e,o,y,t,f);for(const e of["x","y"]){if(!p[e][a[e]]){s[e]=0;a[e]=0}}if(s.x>0||s.y>0){g();_.current=e;h(w,i);m.current=s;b.current=a;return}}m.current={x:0,y:0};b.current={x:0,y:0};g()},[t,w,n,g,a,i,JSON.stringify(y),JSON.stringify(p),h,c,x,u,JSON.stringify(f)])}const sW={x:{[sa.Backward]:false,[sa.Forward]:false},y:{[sa.Backward]:false,[sa.Forward]:false}};function sB(e){let{delta:t,disabled:r}=e;const n=ic(t);return is(e=>{if(r||!n||!e){// Reset scroll intent tracking when auto-scrolling is disabled
return sW}const o={x:Math.sign(t.x-n.x),y:Math.sign(t.y-n.y)};// Keep track of the user intent to scroll in each direction for both axis
return{x:{[sa.Backward]:e.x[sa.Backward]||o.x===-1,[sa.Forward]:e.x[sa.Forward]||o.x===1},y:{[sa.Backward]:e.y[sa.Backward]||o.y===-1,[sa.Forward]:e.y[sa.Forward]||o.y===1}}},[r,t,n])}function sR(e,t){const r=t!=null?e.get(t):undefined;const n=r?r.node.current:null;return is(e=>{var r;if(t==null){return null}// In some cases, the draggable node can unmount while dragging
// This is the case for virtualized lists. In those situations,
// we fall back to the last known value for that node.
return(r=n!=null?n:e)!=null?r:null},[n,t])}function sz(e,t){return(0,v.useMemo)(()=>e.reduce((e,r)=>{const{sensor:n}=r;const o=n.activators.map(e=>({eventName:e.eventName,handler:t(e.handler,r)}));return[...e,...o]},[]),[e,t])}var sV;(function(e){e[e["Always"]=0]="Always";e[e["BeforeDragging"]=1]="BeforeDragging";e[e["WhileDragging"]=2]="WhileDragging"})(sV||(sV={}));var sj;(function(e){e["Optimized"]="optimized"})(sj||(sj={}));const sq=/*#__PURE__*/new Map;function sU(e,t){let{dragging:r,dependencies:n,config:o}=t;const[a,i]=(0,v.useState)(null);const{frequency:s,measure:l,strategy:c}=o;const u=(0,v.useRef)(e);const d=m();const f=ii(d);const p=(0,v.useCallback)(function(e){if(e===void 0){e=[]}if(f.current){return}i(t=>{if(t===null){return e}return t.concat(e.filter(e=>!t.includes(e)))})},[f]);const h=(0,v.useRef)(null);const g=is(t=>{if(d&&!r){return sq}if(!t||t===sq||u.current!==e||a!=null){const t=new Map;for(let r of e){if(!r){continue}if(a&&a.length>0&&!a.includes(r.id)&&r.rect.current){// This container does not need to be re-measured
t.set(r.id,r.rect.current);continue}const e=r.node.current;const n=e?new sg(l(e),e):null;r.rect.current=n;if(n){t.set(r.id,n)}}return t}return t},[e,a,r,d,l]);(0,v.useEffect)(()=>{u.current=e},[e]);(0,v.useEffect)(()=>{if(d){return}p()},[r,d]);(0,v.useEffect)(()=>{if(a&&a.length>0){i(null)}},[JSON.stringify(a)]);(0,v.useEffect)(()=>{if(d||typeof s!=="number"||h.current!==null){return}h.current=setTimeout(()=>{p();h.current=null},s)},[s,d,p,...n]);return{droppableRects:g,measureDroppableContainers:p,measuringScheduled:a!=null};function m(){switch(c){case sV.Always:return false;case sV.BeforeDragging:return r;default:return!r}}}function sG(e,t){return is(r=>{if(!e){return null}if(r){return r}return typeof t==="function"?t(e):e},[t,e])}function sQ(e,t){return sG(e,t)}/**
 * Returns a new MutationObserver instance.
 * If `MutationObserver` is undefined in the execution environment, returns `undefined`.
 */function sX(e){let{callback:t,disabled:r}=e;const n=io(t);const o=(0,v.useMemo)(()=>{if(r||typeof window==="undefined"||typeof window.MutationObserver==="undefined"){return undefined}const{MutationObserver:e}=window;return new e(n)},[n,r]);(0,v.useEffect)(()=>{return()=>o==null?void 0:o.disconnect()},[o]);return o}/**
 * Returns a new ResizeObserver instance bound to the `onResize` callback.
 * If `ResizeObserver` is undefined in the execution environment, returns `undefined`.
 */function s$(e){let{callback:t,disabled:r}=e;const n=io(t);const o=(0,v.useMemo)(()=>{if(r||typeof window==="undefined"||typeof window.ResizeObserver==="undefined"){return undefined}const{ResizeObserver:e}=window;return new e(n)},[r]);(0,v.useEffect)(()=>{return()=>o==null?void 0:o.disconnect()},[o]);return o}function sZ(e){return new sg(i4(e),e)}function sJ(e,t,r){if(t===void 0){t=sZ}const[n,o]=(0,v.useState)(null);function a(){o(n=>{if(!e){return null}if(e.isConnected===false){var o;// Fall back to last rect we measured if the element is
// no longer connected to the DOM.
return(o=n!=null?n:r)!=null?o:null}const a=t(e);if(JSON.stringify(n)===JSON.stringify(a)){return n}return a})}const i=sX({callback(t){if(!e){return}for(const r of t){const{type:t,target:n}=r;if(t==="childList"&&n instanceof HTMLElement&&n.contains(e)){a();break}}}});const s=s$({callback:a});ir(()=>{a();if(e){s==null?void 0:s.observe(e);i==null?void 0:i.observe(document.body,{childList:true,subtree:true})}else{s==null?void 0:s.disconnect();i==null?void 0:i.disconnect()}},[e]);return n}function s0(e){const t=sG(e);return iZ(e,t)}const s1=[];function s6(e){const t=(0,v.useRef)(e);const r=is(r=>{if(!e){return s1}if(r&&r!==s1&&e&&t.current&&e.parentNode===t.current.parentNode){return r}return i9(e)},[e]);(0,v.useEffect)(()=>{t.current=e},[e]);return r}function s2(e){const[t,r]=(0,v.useState)(null);const n=(0,v.useRef)(e);// To-do: Throttle the handleScroll callback
const o=(0,v.useCallback)(e=>{const t=st(e.target);if(!t){return}r(e=>{if(!e){return null}e.set(t,so(t));return new Map(e)})},[]);(0,v.useEffect)(()=>{const t=n.current;if(e!==t){a(t);const i=e.map(e=>{const t=st(e);if(t){t.addEventListener("scroll",o,{passive:true});return[t,so(t)]}return null}).filter(e=>e!=null);r(i.length?new Map(i):null);n.current=e}return()=>{a(e);a(t)};function a(e){e.forEach(e=>{const t=st(e);t==null?void 0:t.removeEventListener("scroll",o)})}},[o,e]);return(0,v.useMemo)(()=>{if(e.length){return t?Array.from(t.values()).reduce((e,t)=>ih(e,t),iN):sd(e)}return iN},[e,t])}function s4(e,t){if(t===void 0){t=[]}const r=(0,v.useRef)(null);(0,v.useEffect)(()=>{r.current=null},t);(0,v.useEffect)(()=>{const t=e!==iN;if(t&&!r.current){r.current=e}if(!t&&r.current){r.current=null}},[e]);return r.current?iv(e,r.current):iN}function s3(e){(0,v.useEffect)(()=>{if(!a4){return}const t=e.map(e=>{let{sensor:t}=e;return t.setup==null?void 0:t.setup()});return()=>{for(const e of t){e==null?void 0:e()}}},// eslint-disable-next-line react-hooks/exhaustive-deps
e.map(e=>{let{sensor:t}=e;return t}))}function s5(e,t){return(0,v.useMemo)(()=>{return e.reduce((e,r)=>{let{eventName:n,handler:o}=r;e[n]=e=>{o(e,t)};return e},{})},[e,t])}function s8(e){return(0,v.useMemo)(()=>e?i5(e):null,[e])}const s7=[];function s9(e,t){if(t===void 0){t=i4}const[r]=e;const n=s8(r?a8(r):null);const[o,a]=(0,v.useState)(s7);function i(){a(()=>{if(!e.length){return s7}return e.map(e=>si(e)?n:new sg(t(e),e))})}const s=s$({callback:i});ir(()=>{s==null?void 0:s.disconnect();i();e.forEach(e=>s==null?void 0:s.observe(e))},[e]);return o}function le(e){if(!e){return null}if(e.children.length>1){return e}const t=e.children[0];return a9(t)?t:e}function lt(e){let{measure:t}=e;const[r,n]=(0,v.useState)(null);const o=(0,v.useCallback)(e=>{for(const{target:r}of e){if(a9(r)){n(e=>{const n=t(r);return e?{...e,width:n.width,height:n.height}:n});break}}},[t]);const a=s$({callback:o});const i=(0,v.useCallback)(e=>{const r=le(e);a==null?void 0:a.disconnect();if(r){a==null?void 0:a.observe(r)}n(r?t(r):null)},[t,a]);const[s,l]=il(i);return(0,v.useMemo)(()=>({nodeRef:s,rect:r,setRef:l}),[r,s,l])}const lr=[{sensor:sE,options:{}},{sensor:sI,options:{}}];const ln={current:{}};const lo={draggable:{measure:i3},droppable:{measure:i3,strategy:sV.WhileDragging,frequency:sj.Optimized},dragOverlay:{measure:i4}};class la extends Map{get(e){var t;return e!=null?(t=super.get(e))!=null?t:undefined:undefined}toArray(){return Array.from(this.values())}getEnabled(){return this.toArray().filter(e=>{let{disabled:t}=e;return!t})}getNodeFor(e){var t,r;return(t=(r=this.get(e))==null?void 0:r.node.current)!=null?t:undefined}}const li={activatorEvent:null,active:null,activeNode:null,activeNodeRect:null,collisions:null,containerNodeRect:null,draggableNodes:/*#__PURE__*/new Map,droppableRects:/*#__PURE__*/new Map,droppableContainers:/*#__PURE__*/new la,over:null,dragOverlay:{nodeRef:{current:null},rect:null,setRef:iT},scrollableAncestors:[],scrollableAncestorRects:[],measuringConfiguration:lo,measureDroppableContainers:iT,windowRect:null,measuringScheduled:false};const ls={activatorEvent:null,activators:[],active:null,activeNodeRect:null,ariaDescribedById:{draggable:""},dispatch:iT,draggableNodes:/*#__PURE__*/new Map,over:null,measureDroppableContainers:iT};const ll=/*#__PURE__*/(0,v.createContext)(ls);const lc=/*#__PURE__*/(0,v.createContext)(li);function lu(){return{draggable:{active:null,initialCoordinates:{x:0,y:0},nodes:new Map,translate:{x:0,y:0}},droppable:{containers:new la}}}function ld(e,t){switch(t.type){case iH.DragStart:return{...e,draggable:{...e.draggable,initialCoordinates:t.initialCoordinates,active:t.active}};case iH.DragMove:if(e.draggable.active==null){return e}return{...e,draggable:{...e.draggable,translate:{x:t.coordinates.x-e.draggable.initialCoordinates.x,y:t.coordinates.y-e.draggable.initialCoordinates.y}}};case iH.DragEnd:case iH.DragCancel:return{...e,draggable:{...e.draggable,active:null,initialCoordinates:{x:0,y:0},translate:{x:0,y:0}}};case iH.RegisterDroppable:{const{element:r}=t;const{id:n}=r;const o=new la(e.droppable.containers);o.set(n,r);return{...e,droppable:{...e.droppable,containers:o}}}case iH.SetDroppableDisabled:{const{id:r,key:n,disabled:o}=t;const a=e.droppable.containers.get(r);if(!a||n!==a.key){return e}const i=new la(e.droppable.containers);i.set(r,{...a,disabled:o});return{...e,droppable:{...e.droppable,containers:i}}}case iH.UnregisterDroppable:{const{id:r,key:n}=t;const o=e.droppable.containers.get(r);if(!o||n!==o.key){return e}const a=new la(e.droppable.containers);a.delete(r);return{...e,droppable:{...e.droppable,containers:a}}}default:{return e}}}function lf(e){let{disabled:t}=e;const{active:r,activatorEvent:n,draggableNodes:o}=(0,v.useContext)(ll);const a=ic(n);const i=ic(r==null?void 0:r.id);// Restore keyboard focus on the activator node
(0,v.useEffect)(()=>{if(t){return}if(!n&&a&&i!=null){if(!im(a)){return}if(document.activeElement===a.target){// No need to restore focus
return}const e=o.get(i);if(!e){return}const{activatorNode:t,node:r}=e;if(!t.current&&!r.current){return}requestAnimationFrame(()=>{for(const e of[t.current,r.current]){if(!e){continue}const t=ix(e);if(t){t.focus();break}}})}},[n,t,o,i,a]);return null}function lp(e,t){let{transform:r,...n}=t;return e!=null&&e.length?e.reduce((e,t)=>{return t({transform:e,...n})},r):r}function lh(e){return(0,v.useMemo)(()=>({draggable:{...lo.draggable,...e==null?void 0:e.draggable},droppable:{...lo.droppable,...e==null?void 0:e.droppable},dragOverlay:{...lo.dragOverlay,...e==null?void 0:e.dragOverlay}}),[e==null?void 0:e.draggable,e==null?void 0:e.droppable,e==null?void 0:e.dragOverlay])}function lv(e){let{activeNode:t,measure:r,initialRect:n,config:o=true}=e;const a=(0,v.useRef)(false);const{x:i,y:s}=typeof o==="boolean"?{x:o,y:o}:o;ir(()=>{const e=!i&&!s;if(e||!t){a.current=false;return}if(a.current||!n){// Return early if layout shift scroll compensation was already attempted
// or if there is no initialRect to compare to.
return}// Get the most up to date node ref for the active draggable
const o=t==null?void 0:t.node.current;if(!o||o.isConnected===false){// Return early if there is no attached node ref or if the node is
// disconnected from the document.
return}const l=r(o);const c=iZ(l,n);if(!i){c.x=0}if(!s){c.y=0}// Only perform layout shift scroll compensation once
a.current=true;if(Math.abs(c.x)>0||Math.abs(c.y)>0){const e=se(o);if(e){e.scrollBy({top:c.y,left:c.x})}}},[t,i,s,n,r])}const lg=/*#__PURE__*/(0,v.createContext)({...iN,scaleX:1,scaleY:1});var lm;(function(e){e[e["Uninitialized"]=0]="Uninitialized";e[e["Initializing"]=1]="Initializing";e[e["Initialized"]=2]="Initialized"})(lm||(lm={}));const lb=/*#__PURE__*/(0,v.memo)(function e(e){var t,r,n,o;let{id:a,accessibility:i,autoScroll:s=true,children:l,sensors:c=lr,collisionDetection:u=iG,measuring:d,modifiers:f,...p}=e;const h=(0,v.useReducer)(ld,undefined,lu);const[m,b]=h;const[y,_]=iS();const[w,x]=(0,v.useState)(lm.Uninitialized);const A=w===lm.Initialized;const{draggable:{active:k,nodes:Y,translate:I},droppable:{containers:D}}=m;const C=k!=null?Y.get(k):null;const S=(0,v.useRef)({initial:null,translated:null});const M=(0,v.useMemo)(()=>{var e;return k!=null?{id:k,// It's possible for the active node to unmount while dragging
data:(e=C==null?void 0:C.data)!=null?e:ln,rect:S}:null},[k,C]);const E=(0,v.useRef)(null);const[F,H]=(0,v.useState)(null);const[T,O]=(0,v.useState)(null);const K=ii(p,Object.values(p));const N=id("DndDescribedBy",a);const P=(0,v.useMemo)(()=>D.getEnabled(),[D]);const L=lh(d);const{droppableRects:W,measureDroppableContainers:B,measuringScheduled:R}=sU(P,{dragging:A,dependencies:[I.x,I.y],config:L.droppable});const z=sR(Y,k);const V=(0,v.useMemo)(()=>T?iy(T):null,[T]);const j=ek();const q=sQ(z,L.draggable.measure);lv({activeNode:k!=null?Y.get(k):null,config:j.layoutShiftCompensation,initialRect:q,measure:L.draggable.measure});const U=sJ(z,L.draggable.measure,q);const G=sJ(z?z.parentElement:null);const Q=(0,v.useRef)({activatorEvent:null,active:null,activeNode:z,collisionRect:null,collisions:null,droppableRects:W,draggableNodes:Y,draggingNode:null,draggingNodeRect:null,droppableContainers:D,over:null,scrollableAncestors:[],scrollAdjustedTranslate:null});const X=D.getNodeFor((t=Q.current.over)==null?void 0:t.id);const $=lt({measure:L.dragOverlay.measure});// Use the rect of the drag overlay if it is mounted
const Z=(r=$.nodeRef.current)!=null?r:z;const J=A?(n=$.rect)!=null?n:U:null;const ee=Boolean($.nodeRef.current&&$.rect);// The delta between the previous and new position of the draggable node
// is only relevant when there is no drag overlay
const et=s0(ee?null:U);// Get the window rect of the dragging node
const er=s8(Z?a8(Z):null);// Get scrollable ancestors of the dragging node
const en=s6(A?X!=null?X:z:null);const eo=s9(en);// Apply modifiers
const ea=lp(f,{transform:{x:I.x-et.x,y:I.y-et.y,scaleX:1,scaleY:1},activatorEvent:T,active:M,activeNodeRect:U,containerNodeRect:G,draggingNodeRect:J,over:Q.current.over,overlayNodeRect:$.rect,scrollableAncestors:en,scrollableAncestorRects:eo,windowRect:er});const ei=V?ih(V,I):null;const es=s2(en);// Represents the scroll delta since dragging was initiated
const el=s4(es);// Represents the scroll delta since the last time the active node rect was measured
const ec=s4(es,[U]);const eu=ih(ea,el);const ed=J?i0(J,ea):null;const ef=M&&ed?u({active:M,collisionRect:ed,droppableRects:W,droppableContainers:P,pointerCoordinates:ei}):null;const ep=iz(ef,"id");const[eh,ev]=(0,v.useState)(null);// When there is no drag overlay used, we need to account for the
// window scroll delta
const eg=ee?ea:ih(ea,ec);const em=i$(eg,(o=eh==null?void 0:eh.rect)!=null?o:null,U);const eb=(0,v.useRef)(null);const ey=(0,v.useCallback)((e,t)=>{let{sensor:r,options:n}=t;if(E.current==null){return}const o=Y.get(E.current);if(!o){return}const a=e.nativeEvent;const i=new r({active:E.current,activeNode:o,event:a,options:n,// Sensors need to be instantiated with refs for arguments that change over time
// otherwise they are frozen in time with the stale arguments
context:Q,onAbort(e){const t=Y.get(e);if(!t){return}const{onDragAbort:r}=K.current;const n={id:e};r==null?void 0:r(n);y({type:"onDragAbort",event:n})},onPending(e,t,r,n){const o=Y.get(e);if(!o){return}const{onDragPending:a}=K.current;const i={id:e,constraint:t,initialCoordinates:r,offset:n};a==null?void 0:a(i);y({type:"onDragPending",event:i})},onStart(e){const t=E.current;if(t==null){return}const r=Y.get(t);if(!r){return}const{onDragStart:n}=K.current;const o={activatorEvent:a,active:{id:t,data:r.data,rect:S}};(0,a6.unstable_batchedUpdates)(()=>{n==null?void 0:n(o);x(lm.Initializing);b({type:iH.DragStart,initialCoordinates:e,active:t});y({type:"onDragStart",event:o});H(eb.current);O(a)})},onMove(e){b({type:iH.DragMove,coordinates:e})},onEnd:s(iH.DragEnd),onCancel:s(iH.DragCancel)});eb.current=i;function s(e){return async function t(){const{active:t,collisions:r,over:n,scrollAdjustedTranslate:o}=Q.current;let i=null;if(t&&o){const{cancelDrop:s}=K.current;i={activatorEvent:a,active:t,collisions:r,delta:o,over:n};if(e===iH.DragEnd&&typeof s==="function"){const t=await Promise.resolve(s(i));if(t){e=iH.DragCancel}}}E.current=null;(0,a6.unstable_batchedUpdates)(()=>{b({type:e});x(lm.Uninitialized);ev(null);H(null);O(null);eb.current=null;const t=e===iH.DragEnd?"onDragEnd":"onDragCancel";if(i){const e=K.current[t];e==null?void 0:e(i);y({type:t,event:i})}})}}},[Y]);const e_=(0,v.useCallback)((e,t)=>{return(r,n)=>{const o=r.nativeEvent;const a=Y.get(n);if(E.current!==null||// No active draggable
!a||// Event has already been captured
o.dndKit||o.defaultPrevented){return}const i={active:a};const s=e(r,t.options,i);if(s===true){o.dndKit={capturedBy:t.sensor};E.current=n;ey(r,t)}}},[Y,ey]);const ew=sz(c,e_);s3(c);ir(()=>{if(U&&w===lm.Initializing){x(lm.Initialized)}},[U,w]);(0,v.useEffect)(()=>{const{onDragMove:e}=K.current;const{active:t,activatorEvent:r,collisions:n,over:o}=Q.current;if(!t||!r){return}const a={active:t,activatorEvent:r,collisions:n,delta:{x:eu.x,y:eu.y},over:o};(0,a6.unstable_batchedUpdates)(()=>{e==null?void 0:e(a);y({type:"onDragMove",event:a})})},[eu.x,eu.y]);(0,v.useEffect)(()=>{const{active:e,activatorEvent:t,collisions:r,droppableContainers:n,scrollAdjustedTranslate:o}=Q.current;if(!e||E.current==null||!t||!o){return}const{onDragOver:a}=K.current;const i=n.get(ep);const s=i&&i.rect.current?{id:i.id,rect:i.rect.current,data:i.data,disabled:i.disabled}:null;const l={active:e,activatorEvent:t,collisions:r,delta:{x:o.x,y:o.y},over:s};(0,a6.unstable_batchedUpdates)(()=>{ev(s);a==null?void 0:a(l);y({type:"onDragOver",event:l})})},[ep]);ir(()=>{Q.current={activatorEvent:T,active:M,activeNode:z,collisionRect:ed,collisions:ef,droppableRects:W,draggableNodes:Y,draggingNode:Z,draggingNodeRect:J,droppableContainers:D,over:eh,scrollableAncestors:en,scrollAdjustedTranslate:eu};S.current={initial:J,translated:ed}},[M,z,ef,ed,Y,Z,J,W,D,eh,en,eu]);sL({...j,delta:I,draggingRect:ed,pointerCoordinates:ei,scrollableAncestors:en,scrollableAncestorRects:eo});const ex=(0,v.useMemo)(()=>{const e={active:M,activeNode:z,activeNodeRect:U,activatorEvent:T,collisions:ef,containerNodeRect:G,dragOverlay:$,draggableNodes:Y,droppableContainers:D,droppableRects:W,over:eh,measureDroppableContainers:B,scrollableAncestors:en,scrollableAncestorRects:eo,measuringConfiguration:L,measuringScheduled:R,windowRect:er};return e},[M,z,U,T,ef,G,$,Y,D,W,eh,B,en,eo,L,R,er]);const eA=(0,v.useMemo)(()=>{const e={activatorEvent:T,activators:ew,active:M,activeNodeRect:U,ariaDescribedById:{draggable:N},dispatch:b,draggableNodes:Y,over:eh,measureDroppableContainers:B};return e},[T,ew,M,U,b,N,Y,eh,B]);return g().createElement(iD.Provider,{value:_},g().createElement(ll.Provider,{value:eA},g().createElement(lc.Provider,{value:ex},g().createElement(lg.Provider,{value:em},l)),g().createElement(lf,{disabled:(i==null?void 0:i.restoreFocus)===false})),g().createElement(iF,{...i,hiddenTextDescribedById:N}));function ek(){const e=(F==null?void 0:F.autoScrollEnabled)===false;const t=typeof s==="object"?s.enabled===false:s===false;const r=A&&!e&&!t;if(typeof s==="object"){return{...s,enabled:r}}return{enabled:r}}});const ly=/*#__PURE__*/(0,v.createContext)(null);const l_="button";const lw="Draggable";function lx(e){let{id:t,data:r,disabled:n=false,attributes:o}=e;const a=id(lw);const{activators:i,activatorEvent:s,active:l,activeNodeRect:c,ariaDescribedById:u,draggableNodes:d,over:f}=(0,v.useContext)(ll);const{role:p=l_,roleDescription:h="draggable",tabIndex:g=0}=o!=null?o:{};const m=(l==null?void 0:l.id)===t;const b=(0,v.useContext)(m?lg:ly);const[y,_]=il();const[w,x]=il();const A=s5(i,t);const k=ii(r);ir(()=>{d.set(t,{id:t,key:a,node:y,activatorNode:w,data:k});return()=>{const e=d.get(t);if(e&&e.key===a){d.delete(t)}}},[d,t]);const Y=(0,v.useMemo)(()=>({role:p,tabIndex:g,"aria-disabled":n,"aria-pressed":m&&p===l_?true:undefined,"aria-roledescription":h,"aria-describedby":u.draggable}),[n,p,g,m,h,u.draggable]);return{active:l,activatorEvent:s,activeNodeRect:c,attributes:Y,isDragging:m,listeners:n?undefined:A,node:y,over:f,setNodeRef:_,setActivatorNodeRef:x,transform:b}}function lA(){return(0,v.useContext)(lc)}const lk="Droppable";const lY={timeout:25};function lI(e){let{data:t,disabled:r=false,id:n,resizeObserverConfig:o}=e;const a=id(lk);const{active:i,dispatch:s,over:l,measureDroppableContainers:c}=(0,v.useContext)(ll);const u=(0,v.useRef)({disabled:r});const d=(0,v.useRef)(false);const f=(0,v.useRef)(null);const p=(0,v.useRef)(null);const{disabled:h,updateMeasurementsFor:g,timeout:m}={...lY,...o};const b=ii(g!=null?g:n);const y=(0,v.useCallback)(()=>{if(!d.current){// ResizeObserver invokes the `handleResize` callback as soon as `observe` is called,
// assuming the element is rendered and displayed.
d.current=true;return}if(p.current!=null){clearTimeout(p.current)}p.current=setTimeout(()=>{c(Array.isArray(b.current)?b.current:[b.current]);p.current=null},m)},[m]);const _=s$({callback:y,disabled:h||!i});const w=(0,v.useCallback)((e,t)=>{if(!_){return}if(t){_.unobserve(t);d.current=false}if(e){_.observe(e)}},[_]);const[x,A]=il(w);const k=ii(t);(0,v.useEffect)(()=>{if(!_||!x.current){return}_.disconnect();d.current=false;_.observe(x.current)},[x,_]);(0,v.useEffect)(()=>{s({type:iH.RegisterDroppable,element:{id:n,key:a,disabled:r,node:x,rect:f,data:k}});return()=>s({type:iH.UnregisterDroppable,key:a,id:n})},[n]);(0,v.useEffect)(()=>{if(r!==u.current.disabled){s({type:iH.SetDroppableDisabled,id:n,key:a,disabled:r});u.current.disabled=r}},[n,a,r,s]);return{active:i,rect:f,isOver:(l==null?void 0:l.id)===n,node:x,over:l,setNodeRef:A}}function lD(e){let{animation:t,children:r}=e;const[n,o]=(0,v.useState)(null);const[a,i]=(0,v.useState)(null);const s=ic(r);if(!r&&!n&&s){o(s)}ir(()=>{if(!a){return}const e=n==null?void 0:n.key;const r=n==null?void 0:n.props.id;if(e==null||r==null){o(null);return}Promise.resolve(t(r,a)).then(()=>{o(null)})},[t,n,a]);return g().createElement(g().Fragment,null,r,n?(0,v.cloneElement)(n,{ref:i}):null)}const lC={x:0,y:0,scaleX:1,scaleY:1};function lS(e){let{children:t}=e;return g().createElement(ll.Provider,{value:ls},g().createElement(lg.Provider,{value:lC},t))}const lM={position:"fixed",touchAction:"none"};const lE=e=>{const t=im(e);return t?"transform 250ms ease":undefined};const lF=/*#__PURE__*/(0,v.forwardRef)((e,t)=>{let{as:r,activatorEvent:n,adjustScale:o,children:a,className:i,rect:s,style:l,transform:c,transition:u=lE}=e;if(!s){return null}const d=o?c:{...c,scaleX:1,scaleY:1};const f={...lM,width:s.width,height:s.height,top:s.top,left:s.left,transform:i_.Transform.toString(d),transformOrigin:o&&n?iL(n,s):undefined,transition:typeof u==="function"?u(n):u,...l};return g().createElement(r,{className:i,style:f,ref:t},a)});const lH=e=>t=>{let{active:r,dragOverlay:n}=t;const o={};const{styles:a,className:i}=e;if(a!=null&&a.active){for(const[e,t]of Object.entries(a.active)){if(t===undefined){continue}o[e]=r.node.style.getPropertyValue(e);r.node.style.setProperty(e,t)}}if(a!=null&&a.dragOverlay){for(const[e,t]of Object.entries(a.dragOverlay)){if(t===undefined){continue}n.node.style.setProperty(e,t)}}if(i!=null&&i.active){r.node.classList.add(i.active)}if(i!=null&&i.dragOverlay){n.node.classList.add(i.dragOverlay)}return function e(){for(const[e,t]of Object.entries(o)){r.node.style.setProperty(e,t)}if(i!=null&&i.active){r.node.classList.remove(i.active)}}};const lT=e=>{let{transform:{initial:t,final:r}}=e;return[{transform:i_.Transform.toString(t)},{transform:i_.Transform.toString(r)}]};const lO={duration:250,easing:"ease",keyframes:lT,sideEffects:/*#__PURE__*/lH({styles:{active:{opacity:"0"}}})};function lK(e){let{config:t,draggableNodes:r,droppableContainers:n,measuringConfiguration:o}=e;return io((e,a)=>{if(t===null){return}const i=r.get(e);if(!i){return}const s=i.node.current;if(!s){return}const l=le(a);if(!l){return}const{transform:c}=a8(a).getComputedStyle(a);const u=i1(c);if(!u){return}const d=typeof t==="function"?t:lN(t);sh(s,o.draggable.measure);return d({active:{id:e,data:i.data,node:s,rect:o.draggable.measure(s)},draggableNodes:r,dragOverlay:{node:a,rect:o.dragOverlay.measure(l)},droppableContainers:n,measuringConfiguration:o,transform:u})})}function lN(e){const{duration:t,easing:r,sideEffects:n,keyframes:o}={...lO,...e};return e=>{let{active:a,dragOverlay:i,transform:s,...l}=e;if(!t){// Do not animate if animation duration is zero.
return}const c={x:i.rect.left-a.rect.left,y:i.rect.top-a.rect.top};const u={scaleX:s.scaleX!==1?a.rect.width*s.scaleX/i.rect.width:1,scaleY:s.scaleY!==1?a.rect.height*s.scaleY/i.rect.height:1};const d={x:s.x-c.x,y:s.y-c.y,...u};const f=o({...l,active:a,dragOverlay:i,transform:{initial:s,final:d}});const[p]=f;const h=f[f.length-1];if(JSON.stringify(p)===JSON.stringify(h)){// The start and end keyframes are the same, infer that there is no animation needed.
return}const v=n==null?void 0:n({active:a,dragOverlay:i,...l});const g=i.node.animate(f,{duration:t,easing:r,fill:"forwards"});return new Promise(e=>{g.onfinish=()=>{v==null?void 0:v();e()}})}}let lP=0;function lL(e){return(0,v.useMemo)(()=>{if(e==null){return}lP++;return lP},[e])}const lW=/*#__PURE__*/g().memo(e=>{let{adjustScale:t=false,children:r,dropAnimation:n,style:o,transition:a,modifiers:i,wrapperElement:s="div",className:l,zIndex:c=999}=e;const{activatorEvent:u,active:d,activeNodeRect:f,containerNodeRect:p,draggableNodes:h,droppableContainers:m,dragOverlay:b,over:y,measuringConfiguration:_,scrollableAncestors:w,scrollableAncestorRects:x,windowRect:A}=lA();const k=(0,v.useContext)(lg);const Y=lL(d==null?void 0:d.id);const I=lp(i,{activatorEvent:u,active:d,activeNodeRect:f,containerNodeRect:p,draggingNodeRect:b.rect,over:y,overlayNodeRect:b.rect,scrollableAncestors:w,scrollableAncestorRects:x,transform:k,windowRect:A});const D=sG(f);const C=lK({config:n,draggableNodes:h,droppableContainers:m,measuringConfiguration:_});// We need to wait for the active node to be measured before connecting the drag overlay ref
// otherwise collisions can be computed against a mispositioned drag overlay
const S=D?b.setRef:undefined;return g().createElement(lS,null,g().createElement(lD,{animation:C},d&&Y?g().createElement(lF,{key:Y,id:d.id,ref:S,as:s,activatorEvent:u,adjustScale:t,className:l,transition:a,rect:D,style:{zIndex:c,...o},transform:I},r):null))});//# sourceMappingURL=core.esm.js.map
;// CONCATENATED MODULE: ./node_modules/@dnd-kit/modifiers/dist/modifiers.esm.js
function lB(e){return t=>{let{transform:r}=t;return{...r,x:Math.ceil(r.x/e)*e,y:Math.ceil(r.y/e)*e}}}const lR=e=>{let{transform:t}=e;return{...t,y:0}};function lz(e,t,r){const n={...e};if(t.top+e.y<=r.top){n.y=r.top-t.top}else if(t.bottom+e.y>=r.top+r.height){n.y=r.top+r.height-t.bottom}if(t.left+e.x<=r.left){n.x=r.left-t.left}else if(t.right+e.x>=r.left+r.width){n.x=r.left+r.width-t.right}return n}const lV=e=>{let{containerNodeRect:t,draggingNodeRect:r,transform:n}=e;if(!r||!t){return n}return lz(n,r,t)};const lj=e=>{let{draggingNodeRect:t,transform:r,scrollableAncestorRects:n}=e;const o=n[0];if(!t||!o){return r}return lz(r,t,o)};const lq=e=>{let{transform:t}=e;return{...t,x:0}};const lU=e=>{let{transform:t,draggingNodeRect:r,windowRect:n}=e;if(!r||!n){return t}return lz(t,r,n)};const lG=e=>{let{activatorEvent:t,draggingNodeRect:r,transform:n}=e;if(r&&t){const e=getEventCoordinates(t);if(!e){return n}const o=e.x-r.left;const a=e.y-r.top;return{...n,x:n.x+o-r.width/2,y:n.y+a-r.height/2}}return n};//# sourceMappingURL=modifiers.esm.js.map
;// CONCATENATED MODULE: ./node_modules/@dnd-kit/sortable/dist/sortable.esm.js
/**
 * Move an array item to a different position. Returns a new array with the item moved to the new position.
 */function lQ(e,t,r){const n=e.slice();n.splice(r<0?n.length+r:r,0,n.splice(t,1)[0]);return n}/**
 * Swap an array item to a different position. Returns a new array with the item swapped to the new position.
 */function lX(e,t,r){const n=e.slice();n[t]=e[r];n[r]=e[t];return n}function l$(e,t){return e.reduce((e,r,n)=>{const o=t.get(r);if(o){e[n]=o}return e},Array(e.length))}function lZ(e){return e!==null&&e>=0}function lJ(e,t){if(e===t){return true}if(e.length!==t.length){return false}for(let r=0;r<e.length;r++){if(e[r]!==t[r]){return false}}return true}function l0(e){if(typeof e==="boolean"){return{draggable:e,droppable:e}}return e}// To-do: We should be calculating scale transformation
const l1=/* unused pure expression or super */null&&{scaleX:1,scaleY:1};const l6=e=>{var t;let{rects:r,activeNodeRect:n,activeIndex:o,overIndex:a,index:i}=e;const s=(t=r[o])!=null?t:n;if(!s){return null}const l=l2(r,i,o);if(i===o){const e=r[a];if(!e){return null}return{x:o<a?e.left+e.width-(s.left+s.width):e.left-s.left,y:0,...l1}}if(i>o&&i<=a){return{x:-s.width-l,y:0,...l1}}if(i<o&&i>=a){return{x:s.width+l,y:0,...l1}}return{x:0,y:0,...l1}};function l2(e,t,r){const n=e[t];const o=e[t-1];const a=e[t+1];if(!n||!o&&!a){return 0}if(r<t){return o?n.left-(o.left+o.width):a.left-(n.left+n.width)}return a?a.left-(n.left+n.width):n.left-(o.left+o.width)}const l4=e=>{let{rects:t,activeIndex:r,overIndex:n,index:o}=e;const a=lQ(t,n,r);const i=t[o];const s=a[o];if(!s||!i){return null}return{x:s.left-i.left,y:s.top-i.top,scaleX:s.width/i.width,scaleY:s.height/i.height}};const l3=e=>{let{activeIndex:t,index:r,rects:n,overIndex:o}=e;let a;let i;if(r===t){a=n[r];i=n[o]}if(r===o){a=n[r];i=n[t]}if(!i||!a){return null}return{x:i.left-a.left,y:i.top-a.top,scaleX:i.width/a.width,scaleY:i.height/a.height}};// To-do: We should be calculating scale transformation
const l5={scaleX:1,scaleY:1};const l8=e=>{var t;let{activeIndex:r,activeNodeRect:n,index:o,rects:a,overIndex:i}=e;const s=(t=a[r])!=null?t:n;if(!s){return null}if(o===r){const e=a[i];if(!e){return null}return{x:0,y:r<i?e.top+e.height-(s.top+s.height):e.top-s.top,...l5}}const l=l7(a,o,r);if(o>r&&o<=i){return{x:0,y:-s.height-l,...l5}}if(o<r&&o>=i){return{x:0,y:s.height+l,...l5}}return{x:0,y:0,...l5}};function l7(e,t,r){const n=e[t];const o=e[t-1];const a=e[t+1];if(!n){return 0}if(r<t){return o?n.top-(o.top+o.height):a?a.top-(n.top+n.height):0}return a?a.top-(n.top+n.height):o?n.top-(o.top+o.height):0}const l9="Sortable";const ce=/*#__PURE__*/g().createContext({activeIndex:-1,containerId:l9,disableTransforms:false,items:[],overIndex:-1,useDragOverlay:false,sortedRects:[],strategy:l4,disabled:{draggable:false,droppable:false}});function ct(e){let{children:t,id:r,items:n,strategy:o=l4,disabled:a=false}=e;const{active:i,dragOverlay:s,droppableRects:l,over:c,measureDroppableContainers:u}=lA();const d=id(l9,r);const f=Boolean(s.rect!==null);const p=(0,v.useMemo)(()=>n.map(e=>typeof e==="object"&&"id"in e?e.id:e),[n]);const h=i!=null;const m=i?p.indexOf(i.id):-1;const b=c?p.indexOf(c.id):-1;const y=(0,v.useRef)(p);const _=!lJ(p,y.current);const w=b!==-1&&m===-1||_;const x=l0(a);ir(()=>{if(_&&h){u(p)}},[_,p,h,u]);(0,v.useEffect)(()=>{y.current=p},[p]);const A=(0,v.useMemo)(()=>({activeIndex:m,containerId:d,disabled:x,disableTransforms:w,items:p,overIndex:b,useDragOverlay:f,sortedRects:l$(p,l),strategy:o}),[m,d,x.draggable,x.droppable,w,p,b,l,f,o]);return g().createElement(ce.Provider,{value:A},t)}const cr=e=>{let{id:t,items:r,activeIndex:n,overIndex:o}=e;return lQ(r,n,o).indexOf(t)};const cn=e=>{let{containerId:t,isSorting:r,wasDragging:n,index:o,items:a,newIndex:i,previousItems:s,previousContainerId:l,transition:c}=e;if(!c||!n){return false}if(s!==a&&o===i){return false}if(r){return true}return i!==o&&t===l};const co={duration:200,easing:"ease"};const ca="transform";const ci=/*#__PURE__*/i_.Transition.toString({property:ca,duration:0,easing:"linear"});const cs={roleDescription:"sortable"};/*
 * When the index of an item changes while sorting,
 * we need to temporarily disable the transforms
 */function cl(e){let{disabled:t,index:r,node:n,rect:o}=e;const[a,i]=(0,v.useState)(null);const s=(0,v.useRef)(r);ir(()=>{if(!t&&r!==s.current&&n.current){const e=o.current;if(e){const t=i4(n.current,{ignoreTransform:true});const r={x:e.left-t.left,y:e.top-t.top,scaleX:e.width/t.width,scaleY:e.height/t.height};if(r.x||r.y){i(r)}}}if(r!==s.current){s.current=r}},[t,r,n,o]);(0,v.useEffect)(()=>{if(a){i(null)}},[a]);return a}function cc(e){let{animateLayoutChanges:t=cn,attributes:r,disabled:n,data:o,getNewIndex:a=cr,id:i,strategy:s,resizeObserverConfig:l,transition:c=co}=e;const{items:u,containerId:d,activeIndex:f,disabled:p,disableTransforms:h,sortedRects:g,overIndex:m,useDragOverlay:b,strategy:y}=(0,v.useContext)(ce);const _=cu(n,p);const w=u.indexOf(i);const x=(0,v.useMemo)(()=>({sortable:{containerId:d,index:w,items:u},...o}),[d,o,w,u]);const A=(0,v.useMemo)(()=>u.slice(u.indexOf(i)),[u,i]);const{rect:k,node:Y,isOver:I,setNodeRef:D}=lI({id:i,data:x,disabled:_.droppable,resizeObserverConfig:{updateMeasurementsFor:A,...l}});const{active:C,activatorEvent:S,activeNodeRect:M,attributes:E,setNodeRef:F,listeners:H,isDragging:T,over:O,setActivatorNodeRef:K,transform:N}=lx({id:i,data:x,attributes:{...cs,...r},disabled:_.draggable});const P=a2(D,F);const L=Boolean(C);const W=L&&!h&&lZ(f)&&lZ(m);const B=!b&&T;const R=B&&W?N:null;const z=s!=null?s:y;const V=W?R!=null?R:z({rects:g,activeNodeRect:M,activeIndex:f,overIndex:m,index:w}):null;const j=lZ(f)&&lZ(m)?a({id:i,items:u,activeIndex:f,overIndex:m}):w;const q=C==null?void 0:C.id;const U=(0,v.useRef)({activeId:q,items:u,newIndex:j,containerId:d});const G=u!==U.current.items;const Q=t({active:C,containerId:d,isDragging:T,isSorting:L,id:i,index:w,items:u,newIndex:U.current.newIndex,previousItems:U.current.items,previousContainerId:U.current.containerId,transition:c,wasDragging:U.current.activeId!=null});const X=cl({disabled:!Q,index:w,node:Y,rect:k});(0,v.useEffect)(()=>{if(L&&U.current.newIndex!==j){U.current.newIndex=j}if(d!==U.current.containerId){U.current.containerId=d}if(u!==U.current.items){U.current.items=u}},[L,j,d,u]);(0,v.useEffect)(()=>{if(q===U.current.activeId){return}if(q!=null&&U.current.activeId==null){U.current.activeId=q;return}const e=setTimeout(()=>{U.current.activeId=q},50);return()=>clearTimeout(e)},[q]);return{active:C,activeIndex:f,attributes:E,data:x,rect:k,index:w,newIndex:j,items:u,isOver:I,isSorting:L,isDragging:T,listeners:H,node:Y,overIndex:m,over:O,setNodeRef:P,setActivatorNodeRef:K,setDroppableNodeRef:D,setDraggableNodeRef:F,transform:X!=null?X:V,transition:$()};function $(){if(X||// Or to prevent items jumping to back to their "new" position when items change
G&&U.current.newIndex===w){return ci}if(B&&!im(S)||!c){return undefined}if(L||Q){return i_.Transition.toString({...c,property:ca})}return undefined}}function cu(e,t){var r,n;if(typeof e==="boolean"){return{draggable:e,// Backwards compatibility
droppable:false}}return{draggable:(r=e==null?void 0:e.draggable)!=null?r:t.draggable,droppable:(n=e==null?void 0:e.droppable)!=null?n:t.droppable}}function cd(e){if(!e){return false}const t=e.data.current;if(t&&"sortable"in t&&typeof t.sortable==="object"&&"containerId"in t.sortable&&"items"in t.sortable&&"index"in t.sortable){return true}return false}const cf=[sA.Down,sA.Right,sA.Up,sA.Left];const cp=(e,t)=>{let{context:{active:r,collisionRect:n,droppableRects:o,droppableContainers:a,over:i,scrollableAncestors:s}}=t;if(cf.includes(e.code)){e.preventDefault();if(!r||!n){return}const t=[];a.getEnabled().forEach(r=>{if(!r||r!=null&&r.disabled){return}const a=o.get(r.id);if(!a){return}switch(e.code){case sA.Down:if(n.top<a.top){t.push(r)}break;case sA.Up:if(n.top>a.top){t.push(r)}break;case sA.Left:if(n.left>a.left){t.push(r)}break;case sA.Right:if(n.left<a.left){t.push(r)}break}});const l=iq({active:r,collisionRect:n,droppableRects:o,droppableContainers:t,pointerCoordinates:null});let c=iz(l,"id");if(c===(i==null?void 0:i.id)&&l.length>1){c=l[1].id}if(c!=null){const e=a.get(r.id);const t=a.get(c);const i=t?o.get(t.id):null;const l=t==null?void 0:t.node.current;if(l&&i&&e&&t){const r=i9(l);const o=r.some((e,t)=>s[t]!==e);const a=ch(e,t);const c=cv(e,t);const u=o||!a?{x:0,y:0}:{x:c?n.width-i.width:0,y:c?n.height-i.height:0};const d={x:i.left,y:i.top};const f=u.x&&u.y?d:iv(d,u);return f}}}return undefined};function ch(e,t){if(!cd(e)||!cd(t)){return false}return e.data.current.sortable.containerId===t.data.current.sortable.containerId}function cv(e,t){if(!cd(e)||!cd(t)){return false}if(!ch(e,t)){return false}return e.data.current.sortable.index<t.data.current.sortable.index}//# sourceMappingURL=sortable.esm.js.map
// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/ErrorBoundary.tsx
var cg=r(74);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/FocusTrap.tsx
var cm=r(4459);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/hooks/useScrollLock.ts
var cb=r(6967);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/modals/ModalWrapper.tsx
var cy=e=>{var{children:t,onClose:r,title:n,subtitle:o,icon:a,headerChildren:i,entireHeader:s,actions:l,maxWidth:c=1218,blurTriggerElement:d=true}=e;(0,cb/* .useScrollLock */.K$)();return/*#__PURE__*/(0,u/* .jsx */.Y)(cm/* ["default"] */.A,{blurPrevious:d,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:cw.container({maxWidth:c}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:cw.header({hasHeaderChildren:!!i}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:s,fallback:/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:cw.headerContent,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:cw.iconWithTitle,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:a,children:a}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:n,children:/*#__PURE__*/(0,u/* .jsx */.Y)("h6",{css:cw.title,title:typeof n==="string"?n:"",children:n})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:o,children:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:cw.subtitle,children:o})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:cw.headerChildren,children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:i,children:i})}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:cw.actionsWrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:l,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:cw.closeButton,onClick:r,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"times",width:14,height:14})}),children:l})})]}),children:s})}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:cw.content,children:/*#__PURE__*/(0,u/* .jsx */.Y)(cg/* ["default"] */.A,{children:t})})]})})};/* ESM default export */const c_=cy;var cw={container:e=>{var{maxWidth:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("position:relative;background:",rn/* .colorTokens.background.white */.I6.background.white,";margin:",rC/* .modal.MARGIN_TOP */.yl.MARGIN_TOP,"px auto ",rn/* .spacing["24"] */.YK["24"],";height:100%;max-width:",t,"px;box-shadow:",rn/* .shadow.modal */.r7.modal,";border-radius:",rn/* .borderRadius["10"] */.Vq["10"],";overflow:hidden;bottom:0;z-index:",rn/* .zIndex.modal */.fE.modal,";width:100%;",rn/* .Breakpoint.smallTablet */.EA.smallTablet,"{width:90%;}")},header:e=>{var{hasHeaderChildren:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:",t?"1fr auto 1fr":"1fr auto auto",";gap:",rn/* .spacing["8"] */.YK["8"],";align-items:center;width:100%;height:",rC/* .modal.HEADER_HEIGHT */.yl.HEADER_HEIGHT,"px;background:",rn/* .colorTokens.background.white */.I6.background.white,";border-bottom:1px solid ",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";position:sticky;")},headerContent:/*#__PURE__*/(0,d/* .css */.AH)("place-self:center start;display:inline-flex;align-items:center;gap:",rn/* .spacing["12"] */.YK["12"],";padding-left:",rn/* .spacing["24"] */.YK["24"],";",rn/* .Breakpoint.smallMobile */.EA.smallMobile,"{padding-left:",rn/* .spacing["16"] */.YK["16"],";}"),headerChildren:/*#__PURE__*/(0,d/* .css */.AH)("place-self:center center;"),iconWithTitle:/*#__PURE__*/(0,d/* .css */.AH)("display:inline-flex;align-items:center;gap:",rn/* .spacing["4"] */.YK["4"],";flex-shrink:0;color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";"),title:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.heading6 */.I.heading6("medium"),";color:",rn/* .colorTokens.text.title */.I6.text.title,";text-transform:none;letter-spacing:normal;"),subtitle:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1)," ",ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";padding-left:",rn/* .spacing["12"] */.YK["12"],";border-left:1px solid ",rn/* .colorTokens.icon.hints */.I6.icon.hints,";"),actionsWrapper:/*#__PURE__*/(0,d/* .css */.AH)("place-self:center end;display:inline-flex;gap:",rn/* .spacing["16"] */.YK["16"],";padding-right:",rn/* .spacing["24"] */.YK["24"],";",rn/* .Breakpoint.smallMobile */.EA.smallMobile,"{padding-right:",rn/* .spacing["16"] */.YK["16"],";}"),closeButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:",rn/* .borderRadius.circle */.Vq.circle,";background:",rn/* .colorTokens.background.white */.I6.background.white,";&:focus,&:active,&:hover{background:",rn/* .colorTokens.background.white */.I6.background.white,";}svg{color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";transition:color 0.3s ease-in-out;}:hover{svg{color:",rn/* .colorTokens.icon.hover */.I6.icon.hover,";}}:focus{box-shadow:",rn/* .shadow.focus */.r7.focus,";}"),content:/*#__PURE__*/(0,d/* .css */.AH)("height:calc(100% - ",rC/* .modal.HEADER_HEIGHT */.yl.HEADER_HEIGHT+rC/* .modal.MARGIN_TOP */.yl.MARGIN_TOP,"px);background-color:",rn/* .colorTokens.surface.courseBuilder */.I6.surface.courseBuilder,";overflow-x:hidden;",rA/* .styleUtils.overflowYAuto */.x.overflowYAuto)};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormInputWithPresets.tsx
function cx(){var e=(0,x._)(["\n      border: 1px solid ",";\n      border-radius: ",";\n      box-shadow: ",";\n      background-color: ",";\n    "]);cx=function t(){return e};return e}function cA(){var e=(0,x._)(["\n      border-color: ",";\n      background-color: ",";\n    "]);cA=function t(){return e};return e}function ck(){var e=(0,x._)(["\n        border-color: ",";\n      "]);ck=function t(){return e};return e}function cY(){var e=(0,x._)(["\n          padding-",": ",";\n        "]);cY=function t(){return e};return e}function cI(){var e=(0,x._)(["\n              padding-",": ",";\n            "]);cI=function t(){return e};return e}function cD(){var e=(0,x._)(["\n        font-size: ",";\n        font-weight: ",";\n        height: 34px;\n        ",";\n      "]);cD=function t(){return e};return e}function cC(){var e=(0,x._)(["\n      min-width: 200px;\n    "]);cC=function t(){return e};return e}function cS(){var e=(0,x._)(["\n      background-color: ",";\n      position: relative;\n\n      &::before {\n        content: '';\n        position: absolute;\n        top: 0;\n        left: 0;\n        width: 3px;\n        height: 100%;\n        background-color: ",";\n        border-radius: 0 "," "," 0;\n      }\n    "]);cS=function t(){return e};return e}function cM(){var e=(0,x._)(["\n      ","\n    "]);cM=function t(){return e};return e}function cE(){var e=(0,x._)(["\n      border-right: 1px solid ",";\n    "]);cE=function t(){return e};return e}function cF(){var e=(0,x._)(["\n      ","\n    "]);cF=function t(){return e};return e}function cH(){var e=(0,x._)(["\n      border-left: 1px solid ",";\n    "]);cH=function t(){return e};return e}var cT=e=>{var{field:t,fieldState:r,content:n,contentPosition:o="left",showVerticalBar:a=true,type:i="text",size:s="regular",label:l,placeholder:c="",disabled:d,readOnly:f,loading:p,helpText:h,removeOptionsMinWidth:g=true,onChange:m,presetOptions:b=[],selectOnFocus:x=false,wrapperCss:A,contentCss:k,removeBorder:Y=false}=e;var I;var D=(I=t.value)!==null&&I!==void 0?I:"";var C=(0,v.useRef)(null);var S=(0,v.useRef)(null);var[M,E]=(0,v.useState)(false);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{fieldState:r,field:t,label:l,disabled:d,readOnly:f,loading:p,helpText:h,removeBorder:Y,placeholder:c,children:e=>{var{css:l}=e,c=(0,rD._)(e,["css"]);return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:[cK.inputWrapper(!!r.error,Y),A],ref:S,children:[n&&o==="left"&&/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:[cK.inputLeftContent(a,s),k],children:n}),/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},c),{css:[l,cK.input(o,a,s)],onClick:()=>E(true),autoComplete:"off",readOnly:f,ref:e=>{t.ref(e);// @ts-ignore
C.current=e;// this is not ideal but it is the only way to set ref to the input element
},onFocus:()=>{if(!x||!C.current){return}C.current.select()},value:D,onChange:e=>{var r=i==="number"?e.target.value.replace(/[^0-9.]/g,"").replace(/(\..*)\./g,"$1"):e.target.value;t.onChange(r);if(m){m(r)}},"data-input":true})),n&&o==="right"&&/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:cK.inputRightContent(a,s),children:n})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{triggerRef:S,isOpen:M,closePopover:()=>E(false),animationType:rL/* .AnimationType.slideDown */.J6.slideDown,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:[cK.optionsWrapper],children:/*#__PURE__*/(0,u/* .jsx */.Y)("ul",{css:[cK.options(g)],children:b.map(e=>/*#__PURE__*/(0,u/* .jsx */.Y)("li",{css:cK.optionItem({isSelected:e.value===t.value}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:cK.label,onClick:()=>{t.onChange(e.value);m===null||m===void 0?void 0:m(e.value);E(false)},children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:e.icon,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:e.icon,width:32,height:32})}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:e.label})]})},String(e.value)))})})})]})}})};/* ESM default export */const cO=cT;var cK={mainWrapper:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;"),inputWrapper:(e,t)=>/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;",!t&&(0,d/* .css */.AH)(cx(),rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],rn/* .borderRadius["6"] */.Vq["6"],rn/* .shadow.input */.r7.input,rn/* .colorTokens.background.white */.I6.background.white)," ",e&&(0,d/* .css */.AH)(cA(),rn/* .colorTokens.stroke.danger */.I6.stroke.danger,rn/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail),";&:focus-within{",rA/* .styleUtils.inputFocus */.x.inputFocus,";",e&&(0,d/* .css */.AH)(ck(),rn/* .colorTokens.stroke.danger */.I6.stroke.danger),"}"),input:(e,t,r)=>/*#__PURE__*/(0,d/* .css */.AH)("&[data-input]{",ro/* .typography.body */.I.body(),";border:none;box-shadow:none;background-color:transparent;","padding-".concat(e),":0;",t&&(0,d/* .css */.AH)(cY(),e,rn/* .spacing["10"] */.YK["10"]),";",r==="large"&&(0,d/* .css */.AH)(cD(),rn/* .fontSize["24"] */.J["24"],rn/* .fontWeight.medium */.Wy.medium,t&&(0,d/* .css */.AH)(cI(),e,rn/* .spacing["12"] */.YK["12"])),"      &:focus{box-shadow:none;outline:none;}}"),label:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";width:100%;height:100%;display:flex;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";margin:0 ",rn/* .spacing["12"] */.YK["12"],";padding:",rn/* .spacing["6"] */.YK["6"]," 0;text-align:left;line-height:",rn/* .lineHeight["24"] */.K_["24"],";word-break:break-all;cursor:pointer;span{flex-shrink:0;}"),optionsWrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;width:100%;"),options:e=>/*#__PURE__*/(0,d/* .css */.AH)("z-index:",rn/* .zIndex.dropdown */.fE.dropdown,";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";list-style-type:none;box-shadow:",rn/* .shadow.popover */.r7.popover,";padding:",rn/* .spacing["4"] */.YK["4"]," 0;margin:0;max-height:500px;border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";",rA/* .styleUtils.overflowYAuto */.x.overflowYAuto,";",!e&&(0,d/* .css */.AH)(cC())),optionItem:e=>{var{isSelected:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body(),";min-height:36px;height:100%;width:100%;display:flex;align-items:center;transition:background-color 0.3s ease-in-out;cursor:pointer;&:hover{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";}",t&&(0,d/* .css */.AH)(cS(),rn/* .colorTokens.background.active */.I6.background.active,rn/* .colorTokens.action.primary["default"] */.I6.action.primary["default"],rn/* .borderRadius["6"] */.Vq["6"],rn/* .borderRadius["6"] */.Vq["6"]))},inputLeftContent:(e,t)=>/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small()," ",rA/* .styleUtils.flexCenter */.x.flexCenter(),"    height:40px;min-width:48px;color:",rn/* .colorTokens.icon.subdued */.I6.icon.subdued,";padding-inline:",rn/* .spacing["12"] */.YK["12"],";",t==="large"&&(0,d/* .css */.AH)(cM(),ro/* .typography.body */.I.body())," ",e&&(0,d/* .css */.AH)(cE(),rn/* .colorTokens.stroke["default"] */.I6.stroke["default"])),inputRightContent:(e,t)=>/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small()," ",rA/* .styleUtils.flexCenter */.x.flexCenter(),"    height:40px;min-width:48px;color:",rn/* .colorTokens.icon.subdued */.I6.icon.subdued,";padding-inline:",rn/* .spacing["12"] */.YK["12"],";",t==="large"&&(0,d/* .css */.AH)(cF(),ro/* .typography.body */.I.body())," ",e&&(0,d/* .css */.AH)(cH(),rn/* .colorTokens.stroke["default"] */.I6.stroke["default"]))};// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/format/index.js + 28 modules
var cN=r(988);// CONCATENATED MODULE: ../tutor/node_modules/@date-fns/tz/constants/index.js
/**
 * The symbol to access the `TZDate`'s function to construct a new instance from
 * the provided value. It helps date-fns to inherit the time zone.
 */const cP=Symbol.for("constructDateFrom");// CONCATENATED MODULE: ../tutor/node_modules/@date-fns/tz/tzName/index.js
/**
 * Time zone name format.
 *//**
 * The function returns the time zone name for the given date in the specified
 * time zone.
 *
 * It uses the `Intl.DateTimeFormat` API and by default outputs the time zone
 * name in a long format, e.g. "Pacific Standard Time" or
 * "Singapore Standard Time".
 *
 * It is possible to specify the format as the third argument using one of the following options
 *
 * - "short": e.g. "EDT" or "GMT+8".
 * - "long": e.g. "Eastern Daylight Time".
 * - "shortGeneric": e.g. "ET" or "Singapore Time".
 * - "longGeneric": e.g. "Eastern Time" or "Singapore Standard Time".
 *
 * These options correspond to TR35 tokens `z..zzz`, `zzzz`, `v`, and `vvvv` respectively: https://www.unicode.org/reports/tr35/tr35-dates.html#dfst-zone
 *
 * @param timeZone - Time zone name (IANA or UTC offset)
 * @param date - Date object to get the time zone name for
 * @param format - Optional format of the time zone name. Defaults to "long". Can be "short", "long", "shortGeneric", or "longGeneric".
 *
 * @returns Time zone name (e.g. "Singapore Standard Time")
 */function cL(e,t,r="long"){return new Intl.DateTimeFormat("en-US",{// Enforces engine to render the time. Without the option JavaScriptCore omits it.
hour:"numeric",timeZone:e,timeZoneName:r}).format(t).split(/\s/g)// Format.JS uses non-breaking spaces
.slice(2)// Skip the hour and AM/PM parts
.join(" ")};// CONCATENATED MODULE: ../tutor/node_modules/@date-fns/tz/tzOffset/index.js
const cW={};const cB={};/**
 * The function extracts UTC offset in minutes from the given date in specified
 * time zone.
 *
 * Unlike `Date.prototype.getTimezoneOffset`, this function returns the value
 * mirrored to the sign of the offset in the time zone. For Asia/Singapore
 * (UTC+8), `tzOffset` returns 480, while `getTimezoneOffset` returns -480.
 *
 * @param timeZone - Time zone name (IANA or UTC offset)
 * @param date - Date to check the offset for
 *
 * @returns UTC offset in minutes
 */function cR(e,t){try{const r=cW[e]||=new Intl.DateTimeFormat("en-US",{timeZone:e,timeZoneName:"longOffset"}).format;const n=r(t).split("GMT")[1];if(n in cB)return cB[n];return cV(n,n.split(":"))}catch{// Fallback to manual parsing if the runtime doesn't support ±HH:MM/±HHMM/±HH
// See: https://github.com/nodejs/node/issues/53419
if(e in cB)return cB[e];const t=e?.match(cz);if(t)return cV(e,t.slice(1));return NaN}}const cz=/([+-]\d\d):?(\d\d)?/;function cV(e,t){const r=+(t[0]||0);const n=+(t[1]||0);// Convert seconds to minutes by dividing by 60 to keep the function return in minutes.
const o=+(t[2]||0)/60;return cB[e]=r*60+n>0?r*60+n+o:r*60-n-o};// CONCATENATED MODULE: ../tutor/node_modules/@date-fns/tz/date/mini.js
class cj extends Date{//#region static
constructor(...e){super();if(e.length>1&&typeof e[e.length-1]==="string"){this.timeZone=e.pop()}this.internal=new Date;if(isNaN(cR(this.timeZone,this))){this.setTime(NaN)}else{if(!e.length){this.setTime(Date.now())}else if(typeof e[0]==="number"&&(e.length===1||e.length===2&&typeof e[1]!=="number")){this.setTime(e[0])}else if(typeof e[0]==="string"){this.setTime(+new Date(e[0]))}else if(e[0]instanceof Date){this.setTime(+e[0])}else{this.setTime(+new Date(...e));cQ(this,NaN);cU(this)}}}static tz(e,...t){return t.length?new cj(...t,e):new cj(Date.now(),e)}//#endregion
//#region time zone
withTimeZone(e){return new cj(+this,e)}getTimezoneOffset(){const e=-cR(this.timeZone,this);// Remove the seconds offset
// use Math.floor for negative GMT timezones and Math.ceil for positive GMT timezones.
return e>0?Math.floor(e):Math.ceil(e)}//#endregion
//#region time
setTime(e){Date.prototype.setTime.apply(this,arguments);cU(this);return+this}//#endregion
//#region date-fns integration
[Symbol.for("constructDateFrom")](e){return new cj(+new Date(e),this.timeZone)}}// Assign getters and setters
const cq=/^(get|set)(?!UTC)/;Object.getOwnPropertyNames(Date.prototype).forEach(e=>{if(!cq.test(e))return;const t=e.replace(cq,"$1UTC");// Filter out methods without UTC counterparts
if(!cj.prototype[t])return;if(e.startsWith("get")){// Delegate to internal date's UTC method
cj.prototype[e]=function(){return this.internal[t]()}}else{// Assign regular setter
cj.prototype[e]=function(){Date.prototype[t].apply(this.internal,arguments);cG(this);return+this};// Assign UTC setter
cj.prototype[t]=function(){Date.prototype[t].apply(this,arguments);cU(this);return+this}}});/**
 * Function syncs time to internal date, applying the time zone offset.
 *
 * @param {Date} date - Date to sync
 */function cU(e){e.internal.setTime(+e);e.internal.setUTCSeconds(e.internal.getUTCSeconds()-Math.round(-cR(e.timeZone,e)*60))}/**
 * Function syncs the internal date UTC values to the date. It allows to get
 * accurate timestamp value.
 *
 * @param {Date} date - The date to sync
 */function cG(e){// First we transpose the internal values
Date.prototype.setFullYear.call(e,e.internal.getUTCFullYear(),e.internal.getUTCMonth(),e.internal.getUTCDate());Date.prototype.setHours.call(e,e.internal.getUTCHours(),e.internal.getUTCMinutes(),e.internal.getUTCSeconds(),e.internal.getUTCMilliseconds());// Now we have to adjust the date to the system time zone
cQ(e)}/**
 * Function adjusts the date to the system time zone. It uses the time zone
 * differences to calculate the offset and adjust the date.
 *
 * @param {Date} date - Date to adjust
 */function cQ(e){// Save the time zone offset before all the adjustments
const t=cR(e.timeZone,e);// Remove the seconds offset
// use Math.floor for negative GMT timezones and Math.ceil for positive GMT timezones.
const r=t>0?Math.floor(t):Math.ceil(t);//#region System DST adjustment
// The biggest problem with using the system time zone is that when we create
// a date from internal values stored in UTC, the system time zone might end
// up on the DST hour:
//
//   $ TZ=America/New_York node
//   > new Date(2020, 2, 8, 1).toString()
//   'Sun Mar 08 2020 01:00:00 GMT-0500 (Eastern Standard Time)'
//   > new Date(2020, 2, 8, 2).toString()
//   'Sun Mar 08 2020 03:00:00 GMT-0400 (Eastern Daylight Time)'
//   > new Date(2020, 2, 8, 3).toString()
//   'Sun Mar 08 2020 03:00:00 GMT-0400 (Eastern Daylight Time)'
//   > new Date(2020, 2, 8, 4).toString()
//   'Sun Mar 08 2020 04:00:00 GMT-0400 (Eastern Daylight Time)'
//
// Here we get the same hour for both 2 and 3, because the system time zone
// has DST beginning at 8 March 2020, 2 a.m. and jumps to 3 a.m. So we have
// to adjust the internal date to reflect that.
//
// However we want to adjust only if that's the DST hour the change happenes,
// not the hour where DST moves to.
// We calculate the previous hour to see if the time zone offset has changed
// and we have landed on the DST hour.
const n=new Date(+e);// We use UTC methods here as we don't want to land on the same hour again
// in case of DST.
n.setUTCHours(n.getUTCHours()-1);// Calculate if we are on the system DST hour.
const o=-new Date(+e).getTimezoneOffset();const a=-new Date(+n).getTimezoneOffset();const i=o-a;// Detect the DST shift. System DST change will occur both on
const s=Date.prototype.getHours.apply(e)!==e.internal.getUTCHours();// Move the internal date when we are on the system DST hour.
if(i&&s)e.internal.setUTCMinutes(e.internal.getUTCMinutes()+i);//#endregion
//#region System diff adjustment
// Now we need to adjust the date, since we just applied internal values.
// We need to calculate the difference between the system and date time zones
// and apply it to the date.
const l=o-r;if(l)Date.prototype.setUTCMinutes.call(e,Date.prototype.getUTCMinutes.call(e)+l);//#endregion
//#region Seconds System diff adjustment
const c=new Date(+e);// Set the UTC seconds to 0 to isolate the timezone offset in seconds.
c.setUTCSeconds(0);// For negative systemOffset, invert the seconds.
const u=o>0?c.getSeconds():(c.getSeconds()-60)%60;// Calculate the seconds offset based on the timezone offset.
const d=Math.round(-(cR(e.timeZone,e)*60))%60;if(d||u){e.internal.setUTCSeconds(e.internal.getUTCSeconds()+d);Date.prototype.setUTCSeconds.call(e,Date.prototype.getUTCSeconds.call(e)+d+u)}//#endregion
//#region Post-adjustment DST fix
const f=cR(e.timeZone,e);// Remove the seconds offset
// use Math.floor for negative GMT timezones and Math.ceil for positive GMT timezones.
const p=f>0?Math.floor(f):Math.ceil(f);const h=-new Date(+e).getTimezoneOffset();const v=h-p;const g=p!==r;const m=v-l;if(g&&m){Date.prototype.setUTCMinutes.call(e,Date.prototype.getUTCMinutes.call(e)+m);// Now we need to check if got offset change during the post-adjustment.
// If so, we also need both dates to reflect that.
const t=cR(e.timeZone,e);// Remove the seconds offset
// use Math.floor for negative GMT timezones and Math.ceil for positive GMT timezones.
const r=t>0?Math.floor(t):Math.ceil(t);const n=p-r;if(n){e.internal.setUTCMinutes(e.internal.getUTCMinutes()+n);Date.prototype.setUTCMinutes.call(e,Date.prototype.getUTCMinutes.call(e)+n)}}//#endregion
};// CONCATENATED MODULE: ../tutor/node_modules/@date-fns/tz/date/index.js
class cX extends cj{//#region static
static tz(e,...t){return t.length?new cX(...t,e):new cX(Date.now(),e)}//#endregion
//#region representation
toISOString(){const[e,t,r]=this.tzComponents();const n=`${e}${t}:${r}`;return this.internal.toISOString().slice(0,-1)+n}toString(){// "Tue Aug 13 2024 07:50:19 GMT+0800 (Singapore Standard Time)";
return`${this.toDateString()} ${this.toTimeString()}`}toDateString(){// toUTCString returns RFC 7231 ("Mon, 12 Aug 2024 23:36:08 GMT")
const[e,t,r,n]=this.internal.toUTCString().split(" ");// "Tue Aug 13 2024"
return`${e?.slice(0,-1)} ${r} ${t} ${n}`}toTimeString(){// toUTCString returns RFC 7231 ("Mon, 12 Aug 2024 23:36:08 GMT")
const e=this.internal.toUTCString().split(" ")[4];const[t,r,n]=this.tzComponents();// "07:42:23 GMT+0800 (Singapore Standard Time)"
return`${e} GMT${t}${r}${n} (${cL(this.timeZone,this)})`}toLocaleString(e,t){return Date.prototype.toLocaleString.call(this,e,{...t,timeZone:t?.timeZone||this.timeZone})}toLocaleDateString(e,t){return Date.prototype.toLocaleDateString.call(this,e,{...t,timeZone:t?.timeZone||this.timeZone})}toLocaleTimeString(e,t){return Date.prototype.toLocaleTimeString.call(this,e,{...t,timeZone:t?.timeZone||this.timeZone})}//#endregion
//#region private
tzComponents(){const e=this.getTimezoneOffset();const t=e>0?"-":"+";const r=String(Math.floor(Math.abs(e)/60)).padStart(2,"0");const n=String(Math.abs(e)%60).padStart(2,"0");return[t,r,n]}//#endregion
withTimeZone(e){return new cX(+this,e)}//#region date-fns integration
[Symbol.for("constructDateFrom")](e){return new cX(+new Date(e),this.timeZone)}};// CONCATENATED MODULE: ../tutor/node_modules/@date-fns/tz/tz/index.js
/**
 * The function creates accepts a time zone and returns a function that creates
 * a new `TZDate` instance in the time zone from the provided value. Use it to
 * provide the context for the date-fns functions, via the `in` option.
 *
 * @param timeZone - Time zone name (IANA or UTC offset)
 *
 * @returns Function that creates a new `TZDate` instance in the time zone
 */const c$=e=>t=>TZDate.tz(e,+new Date(t));// CONCATENATED MODULE: ../tutor/node_modules/@date-fns/tz/index.js
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/UI.js
/**
 * Enum representing the UI elements composing DayPicker. These elements are
 * mapped to {@link CustomComponents}, {@link ClassNames}, and {@link Styles}.
 *
 * Some elements are extended by flags and modifiers.
 */var cZ;(function(e){/** The root component displaying the months and the navigation bar. */e["Root"]="root";/** The Chevron SVG element used by navigation buttons and dropdowns. */e["Chevron"]="chevron";/**
     * The grid cell with the day's date. Extended by {@link DayFlag} and
     * {@link SelectionState}.
     */e["Day"]="day";/** The button containing the formatted day's date, inside the grid cell. */e["DayButton"]="day_button";/** The caption label of the month (when not showing the dropdown navigation). */e["CaptionLabel"]="caption_label";/** The container of the dropdown navigation (when enabled). */e["Dropdowns"]="dropdowns";/** The dropdown element to select for years and months. */e["Dropdown"]="dropdown";/** The container element of the dropdown. */e["DropdownRoot"]="dropdown_root";/** The root element of the footer. */e["Footer"]="footer";/** The month grid. */e["MonthGrid"]="month_grid";/** Contains the dropdown navigation or the caption label. */e["MonthCaption"]="month_caption";/** The dropdown with the months. */e["MonthsDropdown"]="months_dropdown";/** Wrapper of the month grid. */e["Month"]="month";/** The container of the displayed months. */e["Months"]="months";/** The navigation bar with the previous and next buttons. */e["Nav"]="nav";/**
     * The next month button in the navigation. *
     *
     * @since 9.1.0
     */e["NextMonthButton"]="button_next";/**
     * The previous month button in the navigation.
     *
     * @since 9.1.0
     */e["PreviousMonthButton"]="button_previous";/** The row containing the week. */e["Week"]="week";/** The group of row weeks in a month (`tbody`). */e["Weeks"]="weeks";/** The column header with the weekday. */e["Weekday"]="weekday";/** The row grouping the weekdays in the column headers. */e["Weekdays"]="weekdays";/** The cell containing the week number. */e["WeekNumber"]="week_number";/** The cell header of the week numbers column. */e["WeekNumberHeader"]="week_number_header";/** The dropdown with the years. */e["YearsDropdown"]="years_dropdown"})(cZ||(cZ={}));/** Enum representing flags for the {@link UI.Day} element. */var cJ;(function(e){/** The day is disabled. */e["disabled"]="disabled";/** The day is hidden. */e["hidden"]="hidden";/** The day is outside the current month. */e["outside"]="outside";/** The day is focused. */e["focused"]="focused";/** The day is today. */e["today"]="today"})(cJ||(cJ={}));/**
 * Enum representing selection states that can be applied to the {@link UI.Day}
 * element in selection mode.
 */var c0;(function(e){/** The day is at the end of a selected range. */e["range_end"]="range_end";/** The day is at the middle of a selected range. */e["range_middle"]="range_middle";/** The day is at the start of a selected range. */e["range_start"]="range_start";/** The day is selected. */e["selected"]="selected"})(c0||(c0={}));/**
 * Enum representing different animation states for transitioning between
 * months.
 */var c1;(function(e){/** The entering weeks when they appear before the exiting month. */e["weeks_before_enter"]="weeks_before_enter";/** The exiting weeks when they disappear before the entering month. */e["weeks_before_exit"]="weeks_before_exit";/** The entering weeks when they appear after the exiting month. */e["weeks_after_enter"]="weeks_after_enter";/** The exiting weeks when they disappear after the entering month. */e["weeks_after_exit"]="weeks_after_exit";/** The entering caption when it appears after the exiting month. */e["caption_after_enter"]="caption_after_enter";/** The exiting caption when it disappears after the entering month. */e["caption_after_exit"]="caption_after_exit";/** The entering caption when it appears before the exiting month. */e["caption_before_enter"]="caption_before_enter";/** The exiting caption when it disappears before the entering month. */e["caption_before_exit"]="caption_before_exit"})(c1||(c1={}));//# sourceMappingURL=UI.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/en-US/_lib/formatDistance.js
const c6={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXWeeks:{one:"about 1 week",other:"about {{count}} weeks"},xWeeks:{one:"1 week",other:"{{count}} weeks"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}};const c2=(e,t,r)=>{let n;const o=c6[e];if(typeof o==="string"){n=o}else if(t===1){n=o.one}else{n=o.other.replace("{{count}}",t.toString())}if(r?.addSuffix){if(r.comparison&&r.comparison>0){return"in "+n}else{return n+" ago"}}return n};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/_lib/buildFormatLongFn.js
function c4(e){return (t={})=>{// TODO: Remove String()
const r=t.width?String(t.width):e.defaultWidth;const n=e.formats[r]||e.formats[e.defaultWidth];return n}};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/en-US/_lib/formatLong.js
const c3={full:"EEEE, MMMM do, y",long:"MMMM do, y",medium:"MMM d, y",short:"MM/dd/yyyy"};const c5={full:"h:mm:ss a zzzz",long:"h:mm:ss a z",medium:"h:mm:ss a",short:"h:mm a"};const c8={full:"{{date}} 'at' {{time}}",long:"{{date}} 'at' {{time}}",medium:"{{date}}, {{time}}",short:"{{date}}, {{time}}"};const c7={date:c4({formats:c3,defaultWidth:"full"}),time:c4({formats:c5,defaultWidth:"full"}),dateTime:c4({formats:c8,defaultWidth:"full"})};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/en-US/_lib/formatRelative.js
const c9={lastWeek:"'last' eeee 'at' p",yesterday:"'yesterday at' p",today:"'today at' p",tomorrow:"'tomorrow at' p",nextWeek:"eeee 'at' p",other:"P"};const ue=(e,t,r,n)=>c9[e];// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/_lib/buildLocalizeFn.js
/**
 * The localize function argument callback which allows to convert raw value to
 * the actual type.
 *
 * @param value - The value to convert
 *
 * @returns The converted value
 *//**
 * The map of localized values for each width.
 *//**
 * The index type of the locale unit value. It types conversion of units of
 * values that don't start at 0 (i.e. quarters).
 *//**
 * Converts the unit value to the tuple of values.
 *//**
 * The tuple of localized era values. The first element represents BC,
 * the second element represents AD.
 *//**
 * The tuple of localized quarter values. The first element represents Q1.
 *//**
 * The tuple of localized day values. The first element represents Sunday.
 *//**
 * The tuple of localized month values. The first element represents January.
 */function ut(e){return(t,r)=>{const n=r?.context?String(r.context):"standalone";let o;if(n==="formatting"&&e.formattingValues){const t=e.defaultFormattingWidth||e.defaultWidth;const n=r?.width?String(r.width):t;o=e.formattingValues[n]||e.formattingValues[t]}else{const t=e.defaultWidth;const n=r?.width?String(r.width):e.defaultWidth;o=e.values[n]||e.values[t]}const a=e.argumentCallback?e.argumentCallback(t):t;// @ts-expect-error - For some reason TypeScript just don't want to match it, no matter how hard we try. I challenge you to try to remove it!
return o[a]}};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/en-US/_lib/localize.js
const ur={narrow:["B","A"],abbreviated:["BC","AD"],wide:["Before Christ","Anno Domini"]};const un={narrow:["1","2","3","4"],abbreviated:["Q1","Q2","Q3","Q4"],wide:["1st quarter","2nd quarter","3rd quarter","4th quarter"]};// Note: in English, the names of days of the week and months are capitalized.
// If you are making a new locale based on this one, check if the same is true for the language you're working on.
// Generally, formatted dates should look like they are in the middle of a sentence,
// e.g. in Spanish language the weekdays and months should be in the lowercase.
const uo={narrow:["J","F","M","A","M","J","J","A","S","O","N","D"],abbreviated:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],wide:["January","February","March","April","May","June","July","August","September","October","November","December"]};const ua={narrow:["S","M","T","W","T","F","S"],short:["Su","Mo","Tu","We","Th","Fr","Sa"],abbreviated:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],wide:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]};const ui={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"}};const us={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"}};const ul=(e,t)=>{const r=Number(e);// If ordinal numbers depend on context, for example,
// if they are different for different grammatical genders,
// use `options.unit`.
//
// `unit` can be 'year', 'quarter', 'month', 'week', 'date', 'dayOfYear',
// 'day', 'hour', 'minute', 'second'.
const n=r%100;if(n>20||n<10){switch(n%10){case 1:return r+"st";case 2:return r+"nd";case 3:return r+"rd"}}return r+"th"};const uc={ordinalNumber:ul,era:ut({values:ur,defaultWidth:"wide"}),quarter:ut({values:un,defaultWidth:"wide",argumentCallback:e=>e-1}),month:ut({values:uo,defaultWidth:"wide"}),day:ut({values:ua,defaultWidth:"wide"}),dayPeriod:ut({values:ui,defaultWidth:"wide",formattingValues:us,defaultFormattingWidth:"wide"})};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/_lib/buildMatchFn.js
function uu(e){return(t,r={})=>{const n=r.width;const o=n&&e.matchPatterns[n]||e.matchPatterns[e.defaultMatchWidth];const a=t.match(o);if(!a){return null}const i=a[0];const s=n&&e.parsePatterns[n]||e.parsePatterns[e.defaultParseWidth];const l=Array.isArray(s)?uf(s,e=>e.test(i)):ud(s,e=>e.test(i));let c;c=e.valueCallback?e.valueCallback(l):l;c=r.valueCallback?r.valueCallback(c):c;const u=t.slice(i.length);return{value:c,rest:u}}}function ud(e,t){for(const r in e){if(Object.prototype.hasOwnProperty.call(e,r)&&t(e[r])){return r}}return undefined}function uf(e,t){for(let r=0;r<e.length;r++){if(t(e[r])){return r}}return undefined};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/_lib/buildMatchPatternFn.js
function up(e){return(t,r={})=>{const n=t.match(e.matchPattern);if(!n)return null;const o=n[0];const a=t.match(e.parsePattern);if(!a)return null;let i=e.valueCallback?e.valueCallback(a[0]):a[0];// [TODO] I challenge you to fix the type
i=r.valueCallback?r.valueCallback(i):i;const s=t.slice(o.length);return{value:i,rest:s}}};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/en-US/_lib/match.js
const uh=/^(\d+)(th|st|nd|rd)?/i;const uv=/\d+/i;const ug={narrow:/^(b|a)/i,abbreviated:/^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i,wide:/^(before christ|before common era|anno domini|common era)/i};const um={any:[/^b/i,/^(a|c)/i]};const ub={narrow:/^[1234]/i,abbreviated:/^q[1234]/i,wide:/^[1234](th|st|nd|rd)? quarter/i};const uy={any:[/1/i,/2/i,/3/i,/4/i]};const u_={narrow:/^[jfmasond]/i,abbreviated:/^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,wide:/^(january|february|march|april|may|june|july|august|september|october|november|december)/i};const uw={narrow:[/^j/i,/^f/i,/^m/i,/^a/i,/^m/i,/^j/i,/^j/i,/^a/i,/^s/i,/^o/i,/^n/i,/^d/i],any:[/^ja/i,/^f/i,/^mar/i,/^ap/i,/^may/i,/^jun/i,/^jul/i,/^au/i,/^s/i,/^o/i,/^n/i,/^d/i]};const ux={narrow:/^[smtwf]/i,short:/^(su|mo|tu|we|th|fr|sa)/i,abbreviated:/^(sun|mon|tue|wed|thu|fri|sat)/i,wide:/^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i};const uA={narrow:[/^s/i,/^m/i,/^t/i,/^w/i,/^t/i,/^f/i,/^s/i],any:[/^su/i,/^m/i,/^tu/i,/^w/i,/^th/i,/^f/i,/^sa/i]};const uk={narrow:/^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i,any:/^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i};const uY={any:{am:/^a/i,pm:/^p/i,midnight:/^mi/i,noon:/^no/i,morning:/morning/i,afternoon:/afternoon/i,evening:/evening/i,night:/night/i}};const uI={ordinalNumber:up({matchPattern:uh,parsePattern:uv,valueCallback:e=>parseInt(e,10)}),era:uu({matchPatterns:ug,defaultMatchWidth:"wide",parsePatterns:um,defaultParseWidth:"any"}),quarter:uu({matchPatterns:ub,defaultMatchWidth:"wide",parsePatterns:uy,defaultParseWidth:"any",valueCallback:e=>e+1}),month:uu({matchPatterns:u_,defaultMatchWidth:"wide",parsePatterns:uw,defaultParseWidth:"any"}),day:uu({matchPatterns:ux,defaultMatchWidth:"wide",parsePatterns:uA,defaultParseWidth:"any"}),dayPeriod:uu({matchPatterns:uk,defaultMatchWidth:"any",parsePatterns:uY,defaultParseWidth:"any"})};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/locale/en-US.js
/**
 * @category Locales
 * @summary English locale (United States).
 * @language English
 * @iso-639-2 eng
 * @author Sasha Koss [@kossnocorp](https://github.com/kossnocorp)
 * @author Lesha Koss [@leshakoss](https://github.com/leshakoss)
 */const uD={code:"en-US",formatDistance:c2,formatLong:c7,formatRelative:ue,localize:uc,match:uI,options:{weekStartsOn:0/* Sunday */,firstWeekContainsDate:1}};// Fallback for modularized imports:
/* ESM default export */const uC=/* unused pure expression or super */null&&uD;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/constants.js
/**
 * @module constants
 * @summary Useful constants
 * @description
 * Collection of useful date constants.
 *
 * The constants could be imported from `date-fns/constants`:
 *
 * ```ts
 * import { maxTime, minTime } from "./constants/date-fns/constants";
 *
 * function isAllowedTime(time) {
 *   return time <= maxTime && time >= minTime;
 * }
 * ```
 *//**
 * @constant
 * @name daysInWeek
 * @summary Days in 1 week.
 */const uS=7;/**
 * @constant
 * @name daysInYear
 * @summary Days in 1 year.
 *
 * @description
 * How many days in a year.
 *
 * One years equals 365.2425 days according to the formula:
 *
 * > Leap year occurs every 4 years, except for years that are divisible by 100 and not divisible by 400.
 * > 1 mean year = (365+1/4-1/100+1/400) days = 365.2425 days
 */const uM=365.2425;/**
 * @constant
 * @name maxTime
 * @summary Maximum allowed time.
 *
 * @example
 * import { maxTime } from "./constants/date-fns/constants";
 *
 * const isValid = 8640000000000001 <= maxTime;
 * //=> false
 *
 * new Date(8640000000000001);
 * //=> Invalid Date
 */const uE=Math.pow(10,8)*24*60*60*1e3;/**
 * @constant
 * @name minTime
 * @summary Minimum allowed time.
 *
 * @example
 * import { minTime } from "./constants/date-fns/constants";
 *
 * const isValid = -8640000000000001 >= minTime;
 * //=> false
 *
 * new Date(-8640000000000001)
 * //=> Invalid Date
 */const uF=/* unused pure expression or super */null&&-uE;/**
 * @constant
 * @name millisecondsInWeek
 * @summary Milliseconds in 1 week.
 */const uH=6048e5;/**
 * @constant
 * @name millisecondsInDay
 * @summary Milliseconds in 1 day.
 */const uT=864e5;/**
 * @constant
 * @name millisecondsInMinute
 * @summary Milliseconds in 1 minute
 */const uO=6e4;/**
 * @constant
 * @name millisecondsInHour
 * @summary Milliseconds in 1 hour
 */const uK=36e5;/**
 * @constant
 * @name millisecondsInSecond
 * @summary Milliseconds in 1 second
 */const uN=1e3;/**
 * @constant
 * @name minutesInYear
 * @summary Minutes in 1 year.
 */const uP=525600;/**
 * @constant
 * @name minutesInMonth
 * @summary Minutes in 1 month.
 */const uL=43200;/**
 * @constant
 * @name minutesInDay
 * @summary Minutes in 1 day.
 */const uW=1440;/**
 * @constant
 * @name minutesInHour
 * @summary Minutes in 1 hour.
 */const uB=60;/**
 * @constant
 * @name monthsInQuarter
 * @summary Months in 1 quarter.
 */const uR=3;/**
 * @constant
 * @name monthsInYear
 * @summary Months in 1 year.
 */const uz=12;/**
 * @constant
 * @name quartersInYear
 * @summary Quarters in 1 year
 */const uV=4;/**
 * @constant
 * @name secondsInHour
 * @summary Seconds in 1 hour.
 */const uj=3600;/**
 * @constant
 * @name secondsInMinute
 * @summary Seconds in 1 minute.
 */const uq=60;/**
 * @constant
 * @name secondsInDay
 * @summary Seconds in 1 day.
 */const uU=/* unused pure expression or super */null&&uj*24;/**
 * @constant
 * @name secondsInWeek
 * @summary Seconds in 1 week.
 */const uG=/* unused pure expression or super */null&&uU*7;/**
 * @constant
 * @name secondsInYear
 * @summary Seconds in 1 year.
 */const uQ=/* unused pure expression or super */null&&uU*uM;/**
 * @constant
 * @name secondsInMonth
 * @summary Seconds in 1 month
 */const uX=/* unused pure expression or super */null&&uQ/12;/**
 * @constant
 * @name secondsInQuarter
 * @summary Seconds in 1 quarter.
 */const u$=/* unused pure expression or super */null&&uX*3;/**
 * @constant
 * @name constructFromSymbol
 * @summary Symbol enabling Date extensions to inherit properties from the reference date.
 *
 * The symbol is used to enable the `constructFrom` function to construct a date
 * using a reference date and a value. It allows to transfer extra properties
 * from the reference date to the new date. It's useful for extensions like
 * [`TZDate`](https://github.com/date-fns/tz) that accept a time zone as
 * a constructor argument.
 */const uZ=Symbol.for("constructDateFrom");// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/constructFrom.js
/**
 * @name constructFrom
 * @category Generic Helpers
 * @summary Constructs a date using the reference date and the value
 *
 * @description
 * The function constructs a new date using the constructor from the reference
 * date and the given value. It helps to build generic functions that accept
 * date extensions.
 *
 * It defaults to `Date` if the passed reference date is a number or a string.
 *
 * Starting from v3.7.0, it allows to construct a date using `[Symbol.for("constructDateFrom")]`
 * enabling to transfer extra properties from the reference date to the new date.
 * It's useful for extensions like [`TZDate`](https://github.com/date-fns/tz)
 * that accept a time zone as a constructor argument.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 *
 * @param date - The reference date to take constructor from
 * @param value - The value to create the date
 *
 * @returns Date initialized using the given date and value
 *
 * @example
 * import { constructFrom } from "./constructFrom/date-fns";
 *
 * // A function that clones a date preserving the original type
 * function cloneDate<DateType extends Date>(date: DateType): DateType {
 *   return constructFrom(
 *     date, // Use constructor from the given date
 *     date.getTime() // Use the date value to create a new date
 *   );
 * }
 */function uJ(e,t){if(typeof e==="function")return e(t);if(e&&typeof e==="object"&&uZ in e)return e[uZ](t);if(e instanceof Date)return new e.constructor(t);return new Date(t)}// Fallback for modularized imports:
/* ESM default export */const u0=/* unused pure expression or super */null&&uJ;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/toDate.js
/**
 * @name toDate
 * @category Common Helpers
 * @summary Convert the given argument to an instance of Date.
 *
 * @description
 * Convert the given argument to an instance of Date.
 *
 * If the argument is an instance of Date, the function returns its clone.
 *
 * If the argument is a number, it is treated as a timestamp.
 *
 * If the argument is none of the above, the function returns Invalid Date.
 *
 * Starting from v3.7.0, it clones a date using `[Symbol.for("constructDateFrom")]`
 * enabling to transfer extra properties from the reference date to the new date.
 * It's useful for extensions like [`TZDate`](https://github.com/date-fns/tz)
 * that accept a time zone as a constructor argument.
 *
 * **Note**: *all* Date arguments passed to any *date-fns* function is processed by `toDate`.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param argument - The value to convert
 *
 * @returns The parsed date in the local time zone
 *
 * @example
 * // Clone the date:
 * const result = toDate(new Date(2014, 1, 11, 11, 30, 30))
 * //=> Tue Feb 11 2014 11:30:30
 *
 * @example
 * // Convert the timestamp to date:
 * const result = toDate(1392098430000)
 * //=> Tue Feb 11 2014 11:30:30
 */function u1(e,t){// [TODO] Get rid of `toDate` or `constructFrom`?
return uJ(t||e,e)}// Fallback for modularized imports:
/* ESM default export */const u6=/* unused pure expression or super */null&&u1;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/addDays.js
/**
 * The {@link addDays} function options.
 *//**
 * @name addDays
 * @category Day Helpers
 * @summary Add the specified number of days to the given date.
 *
 * @description
 * Add the specified number of days to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The date to be changed
 * @param amount - The amount of days to be added.
 * @param options - An object with options
 *
 * @returns The new date with the days added
 *
 * @example
 * // Add 10 days to 1 September 2014:
 * const result = addDays(new Date(2014, 8, 1), 10)
 * //=> Thu Sep 11 2014 00:00:00
 */function u2(e,t,r){const n=u1(e,r?.in);if(isNaN(t))return uJ(r?.in||e,NaN);// If 0 days, no-op to avoid changing times in the hour before end of DST
if(!t)return n;n.setDate(n.getDate()+t);return n}// Fallback for modularized imports:
/* ESM default export */const u4=/* unused pure expression or super */null&&u2;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/addMonths.js
/**
 * The {@link addMonths} function options.
 *//**
 * @name addMonths
 * @category Month Helpers
 * @summary Add the specified number of months to the given date.
 *
 * @description
 * Add the specified number of months to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The date to be changed
 * @param amount - The amount of months to be added.
 * @param options - The options object
 *
 * @returns The new date with the months added
 *
 * @example
 * // Add 5 months to 1 September 2014:
 * const result = addMonths(new Date(2014, 8, 1), 5)
 * //=> Sun Feb 01 2015 00:00:00
 *
 * // Add one month to 30 January 2023:
 * const result = addMonths(new Date(2023, 0, 30), 1)
 * //=> Tue Feb 28 2023 00:00:00
 */function u3(e,t,r){const n=u1(e,r?.in);if(isNaN(t))return uJ(r?.in||e,NaN);if(!t){// If 0 months, no-op to avoid changing times in the hour before end of DST
return n}const o=n.getDate();// The JS Date object supports date math by accepting out-of-bounds values for
// month, day, etc. For example, new Date(2020, 0, 0) returns 31 Dec 2019 and
// new Date(2020, 13, 1) returns 1 Feb 2021.  This is *almost* the behavior we
// want except that dates will wrap around the end of a month, meaning that
// new Date(2020, 13, 31) will return 3 Mar 2021 not 28 Feb 2021 as desired. So
// we'll default to the end of the desired month by adding 1 to the desired
// month and using a date of 0 to back up one day to the end of the desired
// month.
const a=uJ(r?.in||e,n.getTime());a.setMonth(n.getMonth()+t+1,0);const i=a.getDate();if(o>=i){// If we're already at the end of the month, then this is the correct date
// and we're done.
return a}else{// Otherwise, we now know that setting the original day-of-month value won't
// cause an overflow, so set the desired day-of-month. Note that we can't
// just set the date of `endOfDesiredMonth` because that object may have had
// its time changed in the unusual case where where a DST transition was on
// the last day of the month and its local time was in the hour skipped or
// repeated next to a DST transition.  So we use `date` instead which is
// guaranteed to still have the original time.
n.setFullYear(a.getFullYear(),a.getMonth(),o);return n}}// Fallback for modularized imports:
/* ESM default export */const u5=/* unused pure expression or super */null&&u3;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/addWeeks.js
/**
 * The {@link addWeeks} function options.
 *//**
 * @name addWeeks
 * @category Week Helpers
 * @summary Add the specified number of weeks to the given date.
 *
 * @description
 * Add the specified number of weeks to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The date to be changed
 * @param amount - The amount of weeks to be added.
 * @param options - An object with options
 *
 * @returns The new date with the weeks added
 *
 * @example
 * // Add 4 weeks to 1 September 2014:
 * const result = addWeeks(new Date(2014, 8, 1), 4)
 * //=> Mon Sep 29 2014 00:00:00
 */function u8(e,t,r){return u2(e,t*7,r)}// Fallback for modularized imports:
/* ESM default export */const u7=/* unused pure expression or super */null&&u8;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/addYears.js
/**
 * The {@link addYears} function options.
 *//**
 * @name addYears
 * @category Year Helpers
 * @summary Add the specified number of years to the given date.
 *
 * @description
 * Add the specified number of years to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type.
 *
 * @param date - The date to be changed
 * @param amount - The amount of years to be added.
 * @param options - The options
 *
 * @returns The new date with the years added
 *
 * @example
 * // Add 5 years to 1 September 2014:
 * const result = addYears(new Date(2014, 8, 1), 5)
 * //=> Sun Sep 01 2019 00:00:00
 */function u9(e,t,r){return u3(e,t*12,r)}// Fallback for modularized imports:
/* ESM default export */const de=/* unused pure expression or super */null&&u9;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/getTimezoneOffsetInMilliseconds.js
/**
 * Google Chrome as of 67.0.3396.87 introduced timezones with offset that includes seconds.
 * They usually appear for dates that denote time before the timezones were introduced
 * (e.g. for 'Europe/Prague' timezone the offset is GMT+00:57:44 before 1 October 1891
 * and GMT+01:00:00 after that date)
 *
 * Date#getTimezoneOffset returns the offset in minutes and would return 57 for the example above,
 * which would lead to incorrect calculations.
 *
 * This function returns the timezone offset in milliseconds that takes seconds in account.
 */function dt(e){const t=u1(e);const r=new Date(Date.UTC(t.getFullYear(),t.getMonth(),t.getDate(),t.getHours(),t.getMinutes(),t.getSeconds(),t.getMilliseconds()));r.setUTCFullYear(t.getFullYear());return+e-+r};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/normalizeDates.js
function dr(e,...t){const r=uJ.bind(null,e||t.find(e=>typeof e==="object"));return t.map(r)};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/startOfDay.js
/**
 * The {@link startOfDay} function options.
 *//**
 * @name startOfDay
 * @category Day Helpers
 * @summary Return the start of a day for the given date.
 *
 * @description
 * Return the start of a day for the given date.
 * The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - The options
 *
 * @returns The start of a day
 *
 * @example
 * // The start of a day for 2 September 2014 11:55:00:
 * const result = startOfDay(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Tue Sep 02 2014 00:00:00
 */function dn(e,t){const r=u1(e,t?.in);r.setHours(0,0,0,0);return r}// Fallback for modularized imports:
/* ESM default export */const da=/* unused pure expression or super */null&&dn;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/differenceInCalendarDays.js
/**
 * The {@link differenceInCalendarDays} function options.
 *//**
 * @name differenceInCalendarDays
 * @category Day Helpers
 * @summary Get the number of calendar days between the given dates.
 *
 * @description
 * Get the number of calendar days between the given dates. This means that the times are removed
 * from the dates and then the difference in days is calculated.
 *
 * @param laterDate - The later date
 * @param earlierDate - The earlier date
 * @param options - The options object
 *
 * @returns The number of calendar days
 *
 * @example
 * // How many calendar days are between
 * // 2 July 2011 23:00:00 and 2 July 2012 00:00:00?
 * const result = differenceInCalendarDays(
 *   new Date(2012, 6, 2, 0, 0),
 *   new Date(2011, 6, 2, 23, 0)
 * )
 * //=> 366
 * // How many calendar days are between
 * // 2 July 2011 23:59:00 and 3 July 2011 00:01:00?
 * const result = differenceInCalendarDays(
 *   new Date(2011, 6, 3, 0, 1),
 *   new Date(2011, 6, 2, 23, 59)
 * )
 * //=> 1
 */function di(e,t,r){const[n,o]=dr(r?.in,e,t);const a=dn(n);const i=dn(o);const s=+a-dt(a);const l=+i-dt(i);// Round the number of days to the nearest integer because the number of
// milliseconds in a day is not constant (e.g. it's different in the week of
// the daylight saving time clock shift).
return Math.round((s-l)/uT)}// Fallback for modularized imports:
/* ESM default export */const ds=/* unused pure expression or super */null&&di;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/differenceInCalendarMonths.js
/**
 * The {@link differenceInCalendarMonths} function options.
 *//**
 * @name differenceInCalendarMonths
 * @category Month Helpers
 * @summary Get the number of calendar months between the given dates.
 *
 * @description
 * Get the number of calendar months between the given dates.
 *
 * @param laterDate - The later date
 * @param earlierDate - The earlier date
 * @param options - An object with options
 *
 * @returns The number of calendar months
 *
 * @example
 * // How many calendar months are between 31 January 2014 and 1 September 2014?
 * const result = differenceInCalendarMonths(
 *   new Date(2014, 8, 1),
 *   new Date(2014, 0, 31)
 * )
 * //=> 8
 */function dl(e,t,r){const[n,o]=dr(r?.in,e,t);const a=n.getFullYear()-o.getFullYear();const i=n.getMonth()-o.getMonth();return a*12+i}// Fallback for modularized imports:
/* ESM default export */const dc=/* unused pure expression or super */null&&dl;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/normalizeInterval.js
function du(e,t){const[r,n]=dr(e,t.start,t.end);return{start:r,end:n}};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/eachMonthOfInterval.js
/**
 * The {@link eachMonthOfInterval} function options.
 *//**
 * The {@link eachMonthOfInterval} function result type. It resolves the proper data type.
 *//**
 * @name eachMonthOfInterval
 * @category Interval Helpers
 * @summary Return the array of months within the specified time interval.
 *
 * @description
 * Return the array of months within the specified time interval.
 *
 * @typeParam IntervalType - Interval type.
 * @typeParam Options - Options type.
 *
 * @param interval - The interval.
 * @param options - An object with options.
 *
 * @returns The array with starts of months from the month of the interval start to the month of the interval end
 *
 * @example
 * // Each month between 6 February 2014 and 10 August 2014:
 * const result = eachMonthOfInterval({
 *   start: new Date(2014, 1, 6),
 *   end: new Date(2014, 7, 10)
 * })
 * //=> [
 * //   Sat Feb 01 2014 00:00:00,
 * //   Sat Mar 01 2014 00:00:00,
 * //   Tue Apr 01 2014 00:00:00,
 * //   Thu May 01 2014 00:00:00,
 * //   Sun Jun 01 2014 00:00:00,
 * //   Tue Jul 01 2014 00:00:00,
 * //   Fri Aug 01 2014 00:00:00
 * // ]
 */function dd(e,t){const{start:r,end:n}=du(t?.in,e);let o=+r>+n;const a=o?+r:+n;const i=o?n:r;i.setHours(0,0,0,0);i.setDate(1);let s=t?.step??1;if(!s)return[];if(s<0){s=-s;o=!o}const l=[];while(+i<=a){l.push(uJ(r,i));i.setMonth(i.getMonth()+s)}return o?l.reverse():l}// Fallback for modularized imports:
/* ESM default export */const df=/* unused pure expression or super */null&&dd;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/defaultOptions.js
let dp={};function dh(){return dp}function dv(e){dp=e};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/endOfWeek.js
/**
 * The {@link endOfWeek} function options.
 *//**
 * @name endOfWeek
 * @category Week Helpers
 * @summary Return the end of a week for the given date.
 *
 * @description
 * Return the end of a week for the given date.
 * The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The end of a week
 *
 * @example
 * // The end of a week for 2 September 2014 11:55:00:
 * const result = endOfWeek(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Sat Sep 06 2014 23:59:59.999
 *
 * @example
 * // If the week starts on Monday, the end of the week for 2 September 2014 11:55:00:
 * const result = endOfWeek(new Date(2014, 8, 2, 11, 55, 0), { weekStartsOn: 1 })
 * //=> Sun Sep 07 2014 23:59:59.999
 */function dg(e,t){const r=dh();const n=t?.weekStartsOn??t?.locale?.options?.weekStartsOn??r.weekStartsOn??r.locale?.options?.weekStartsOn??0;const o=u1(e,t?.in);const a=o.getDay();const i=(a<n?-7:0)+6-(a-n);o.setDate(o.getDate()+i);o.setHours(23,59,59,999);return o}// Fallback for modularized imports:
/* ESM default export */const dm=/* unused pure expression or super */null&&dg;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/endOfISOWeek.js
/**
 * The {@link endOfISOWeek} function options.
 *//**
 * @name endOfISOWeek
 * @category ISO Week Helpers
 * @summary Return the end of an ISO week for the given date.
 *
 * @description
 * Return the end of an ISO week for the given date.
 * The result will be in the local timezone.
 *
 * ISO week-numbering year: http://en.wikipedia.org/wiki/ISO_week_date
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The end of an ISO week
 *
 * @example
 * // The end of an ISO week for 2 September 2014 11:55:00:
 * const result = endOfISOWeek(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Sun Sep 07 2014 23:59:59.999
 */function db(e,t){return dg(e,{...t,weekStartsOn:1})}// Fallback for modularized imports:
/* ESM default export */const dy=/* unused pure expression or super */null&&db;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/endOfMonth.js
/**
 * The {@link endOfMonth} function options.
 *//**
 * @name endOfMonth
 * @category Month Helpers
 * @summary Return the end of a month for the given date.
 *
 * @description
 * Return the end of a month for the given date.
 * The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The end of a month
 *
 * @example
 * // The end of a month for 2 September 2014 11:55:00:
 * const result = endOfMonth(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Tue Sep 30 2014 23:59:59.999
 */function d_(e,t){const r=u1(e,t?.in);const n=r.getMonth();r.setFullYear(r.getFullYear(),n+1,0);r.setHours(23,59,59,999);return r}// Fallback for modularized imports:
/* ESM default export */const dw=/* unused pure expression or super */null&&d_;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/endOfYear.js
/**
 * The {@link endOfYear} function options.
 *//**
 * @name endOfYear
 * @category Year Helpers
 * @summary Return the end of a year for the given date.
 *
 * @description
 * Return the end of a year for the given date.
 * The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - The options
 *
 * @returns The end of a year
 *
 * @example
 * // The end of a year for 2 September 2014 11:55:00:
 * const result = endOfYear(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Wed Dec 31 2014 23:59:59.999
 */function dx(e,t){const r=u1(e,t?.in);const n=r.getFullYear();r.setFullYear(n+1,0,0);r.setHours(23,59,59,999);return r}// Fallback for modularized imports:
/* ESM default export */const dA=/* unused pure expression or super */null&&dx;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/startOfYear.js
/**
 * The {@link startOfYear} function options.
 *//**
 * @name startOfYear
 * @category Year Helpers
 * @summary Return the start of a year for the given date.
 *
 * @description
 * Return the start of a year for the given date.
 * The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - The options
 *
 * @returns The start of a year
 *
 * @example
 * // The start of a year for 2 September 2014 11:55:00:
 * const result = startOfYear(new Date(2014, 8, 2, 11, 55, 00))
 * //=> Wed Jan 01 2014 00:00:00
 */function dk(e,t){const r=u1(e,t?.in);r.setFullYear(r.getFullYear(),0,1);r.setHours(0,0,0,0);return r}// Fallback for modularized imports:
/* ESM default export */const dY=/* unused pure expression or super */null&&dk;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getDayOfYear.js
/**
 * The {@link getDayOfYear} function options.
 *//**
 * @name getDayOfYear
 * @category Day Helpers
 * @summary Get the day of the year of the given date.
 *
 * @description
 * Get the day of the year of the given date.
 *
 * @param date - The given date
 * @param options - The options
 *
 * @returns The day of year
 *
 * @example
 * // Which day of the year is 2 July 2014?
 * const result = getDayOfYear(new Date(2014, 6, 2))
 * //=> 183
 */function dI(e,t){const r=u1(e,t?.in);const n=di(r,dk(r));const o=n+1;return o}// Fallback for modularized imports:
/* ESM default export */const dD=/* unused pure expression or super */null&&dI;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/startOfWeek.js
/**
 * The {@link startOfWeek} function options.
 *//**
 * @name startOfWeek
 * @category Week Helpers
 * @summary Return the start of a week for the given date.
 *
 * @description
 * Return the start of a week for the given date.
 * The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The start of a week
 *
 * @example
 * // The start of a week for 2 September 2014 11:55:00:
 * const result = startOfWeek(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Sun Aug 31 2014 00:00:00
 *
 * @example
 * // If the week starts on Monday, the start of the week for 2 September 2014 11:55:00:
 * const result = startOfWeek(new Date(2014, 8, 2, 11, 55, 0), { weekStartsOn: 1 })
 * //=> Mon Sep 01 2014 00:00:00
 */function dC(e,t){const r=dh();const n=t?.weekStartsOn??t?.locale?.options?.weekStartsOn??r.weekStartsOn??r.locale?.options?.weekStartsOn??0;const o=u1(e,t?.in);const a=o.getDay();const i=(a<n?7:0)+a-n;o.setDate(o.getDate()-i);o.setHours(0,0,0,0);return o}// Fallback for modularized imports:
/* ESM default export */const dS=/* unused pure expression or super */null&&dC;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/startOfISOWeek.js
/**
 * The {@link startOfISOWeek} function options.
 *//**
 * @name startOfISOWeek
 * @category ISO Week Helpers
 * @summary Return the start of an ISO week for the given date.
 *
 * @description
 * Return the start of an ISO week for the given date.
 * The result will be in the local timezone.
 *
 * ISO week-numbering year: http://en.wikipedia.org/wiki/ISO_week_date
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The start of an ISO week
 *
 * @example
 * // The start of an ISO week for 2 September 2014 11:55:00:
 * const result = startOfISOWeek(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Mon Sep 01 2014 00:00:00
 */function dM(e,t){return dC(e,{...t,weekStartsOn:1})}// Fallback for modularized imports:
/* ESM default export */const dE=/* unused pure expression or super */null&&dM;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getISOWeekYear.js
/**
 * The {@link getISOWeekYear} function options.
 *//**
 * @name getISOWeekYear
 * @category ISO Week-Numbering Year Helpers
 * @summary Get the ISO week-numbering year of the given date.
 *
 * @description
 * Get the ISO week-numbering year of the given date,
 * which always starts 3 days before the year's first Thursday.
 *
 * ISO week-numbering year: http://en.wikipedia.org/wiki/ISO_week_date
 *
 * @param date - The given date
 *
 * @returns The ISO week-numbering year
 *
 * @example
 * // Which ISO-week numbering year is 2 January 2005?
 * const result = getISOWeekYear(new Date(2005, 0, 2))
 * //=> 2004
 */function dF(e,t){const r=u1(e,t?.in);const n=r.getFullYear();const o=uJ(r,0);o.setFullYear(n+1,0,4);o.setHours(0,0,0,0);const a=dM(o);const i=uJ(r,0);i.setFullYear(n,0,4);i.setHours(0,0,0,0);const s=dM(i);if(r.getTime()>=a.getTime()){return n+1}else if(r.getTime()>=s.getTime()){return n}else{return n-1}}// Fallback for modularized imports:
/* ESM default export */const dH=/* unused pure expression or super */null&&dF;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/startOfISOWeekYear.js
/**
 * The {@link startOfISOWeekYear} function options.
 *//**
 * @name startOfISOWeekYear
 * @category ISO Week-Numbering Year Helpers
 * @summary Return the start of an ISO week-numbering year for the given date.
 *
 * @description
 * Return the start of an ISO week-numbering year,
 * which always starts 3 days before the year's first Thursday.
 * The result will be in the local timezone.
 *
 * ISO week-numbering year: http://en.wikipedia.org/wiki/ISO_week_date
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The start of an ISO week-numbering year
 *
 * @example
 * // The start of an ISO week-numbering year for 2 July 2005:
 * const result = startOfISOWeekYear(new Date(2005, 6, 2))
 * //=> Mon Jan 03 2005 00:00:00
 */function dT(e,t){const r=dF(e,t);const n=uJ(t?.in||e,0);n.setFullYear(r,0,4);n.setHours(0,0,0,0);return dM(n)}// Fallback for modularized imports:
/* ESM default export */const dO=/* unused pure expression or super */null&&dT;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getISOWeek.js
/**
 * The {@link getISOWeek} function options.
 *//**
 * @name getISOWeek
 * @category ISO Week Helpers
 * @summary Get the ISO week of the given date.
 *
 * @description
 * Get the ISO week of the given date.
 *
 * ISO week-numbering year: http://en.wikipedia.org/wiki/ISO_week_date
 *
 * @param date - The given date
 * @param options - The options
 *
 * @returns The ISO week
 *
 * @example
 * // Which week of the ISO-week numbering year is 2 January 2005?
 * const result = getISOWeek(new Date(2005, 0, 2))
 * //=> 53
 */function dK(e,t){const r=u1(e,t?.in);const n=+dM(r)-+dT(r);// Round the number of weeks to the nearest integer because the number of
// milliseconds in a week is not constant (e.g. it's different in the week of
// the daylight saving time clock shift).
return Math.round(n/uH)+1}// Fallback for modularized imports:
/* ESM default export */const dN=/* unused pure expression or super */null&&dK;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getWeekYear.js
/**
 * The {@link getWeekYear} function options.
 *//**
 * @name getWeekYear
 * @category Week-Numbering Year Helpers
 * @summary Get the local week-numbering year of the given date.
 *
 * @description
 * Get the local week-numbering year of the given date.
 * The exact calculation depends on the values of
 * `options.weekStartsOn` (which is the index of the first day of the week)
 * and `options.firstWeekContainsDate` (which is the day of January, which is always in
 * the first week of the week-numbering year)
 *
 * Week numbering: https://en.wikipedia.org/wiki/Week#The_ISO_week_date_system
 *
 * @param date - The given date
 * @param options - An object with options.
 *
 * @returns The local week-numbering year
 *
 * @example
 * // Which week numbering year is 26 December 2004 with the default settings?
 * const result = getWeekYear(new Date(2004, 11, 26))
 * //=> 2005
 *
 * @example
 * // Which week numbering year is 26 December 2004 if week starts on Saturday?
 * const result = getWeekYear(new Date(2004, 11, 26), { weekStartsOn: 6 })
 * //=> 2004
 *
 * @example
 * // Which week numbering year is 26 December 2004 if the first week contains 4 January?
 * const result = getWeekYear(new Date(2004, 11, 26), { firstWeekContainsDate: 4 })
 * //=> 2004
 */function dP(e,t){const r=u1(e,t?.in);const n=r.getFullYear();const o=dh();const a=t?.firstWeekContainsDate??t?.locale?.options?.firstWeekContainsDate??o.firstWeekContainsDate??o.locale?.options?.firstWeekContainsDate??1;const i=uJ(t?.in||e,0);i.setFullYear(n+1,0,a);i.setHours(0,0,0,0);const s=dC(i,t);const l=uJ(t?.in||e,0);l.setFullYear(n,0,a);l.setHours(0,0,0,0);const c=dC(l,t);if(+r>=+s){return n+1}else if(+r>=+c){return n}else{return n-1}}// Fallback for modularized imports:
/* ESM default export */const dL=/* unused pure expression or super */null&&dP;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/startOfWeekYear.js
/**
 * The {@link startOfWeekYear} function options.
 *//**
 * @name startOfWeekYear
 * @category Week-Numbering Year Helpers
 * @summary Return the start of a local week-numbering year for the given date.
 *
 * @description
 * Return the start of a local week-numbering year.
 * The exact calculation depends on the values of
 * `options.weekStartsOn` (which is the index of the first day of the week)
 * and `options.firstWeekContainsDate` (which is the day of January, which is always in
 * the first week of the week-numbering year)
 *
 * Week numbering: https://en.wikipedia.org/wiki/Week#The_ISO_week_date_system
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The start of a week-numbering year
 *
 * @example
 * // The start of an a week-numbering year for 2 July 2005 with default settings:
 * const result = startOfWeekYear(new Date(2005, 6, 2))
 * //=> Sun Dec 26 2004 00:00:00
 *
 * @example
 * // The start of a week-numbering year for 2 July 2005
 * // if Monday is the first day of week
 * // and 4 January is always in the first week of the year:
 * const result = startOfWeekYear(new Date(2005, 6, 2), {
 *   weekStartsOn: 1,
 *   firstWeekContainsDate: 4
 * })
 * //=> Mon Jan 03 2005 00:00:00
 */function dW(e,t){const r=dh();const n=t?.firstWeekContainsDate??t?.locale?.options?.firstWeekContainsDate??r.firstWeekContainsDate??r.locale?.options?.firstWeekContainsDate??1;const o=dP(e,t);const a=uJ(t?.in||e,0);a.setFullYear(o,0,n);a.setHours(0,0,0,0);const i=dC(a,t);return i}// Fallback for modularized imports:
/* ESM default export */const dB=/* unused pure expression or super */null&&dW;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getWeek.js
/**
 * The {@link getWeek} function options.
 *//**
 * @name getWeek
 * @category Week Helpers
 * @summary Get the local week index of the given date.
 *
 * @description
 * Get the local week index of the given date.
 * The exact calculation depends on the values of
 * `options.weekStartsOn` (which is the index of the first day of the week)
 * and `options.firstWeekContainsDate` (which is the day of January, which is always in
 * the first week of the week-numbering year)
 *
 * Week numbering: https://en.wikipedia.org/wiki/Week#The_ISO_week_date_system
 *
 * @param date - The given date
 * @param options - An object with options
 *
 * @returns The week
 *
 * @example
 * // Which week of the local week numbering year is 2 January 2005 with default options?
 * const result = getWeek(new Date(2005, 0, 2))
 * //=> 2
 *
 * @example
 * // Which week of the local week numbering year is 2 January 2005,
 * // if Monday is the first day of the week,
 * // and the first week of the year always contains 4 January?
 * const result = getWeek(new Date(2005, 0, 2), {
 *   weekStartsOn: 1,
 *   firstWeekContainsDate: 4
 * })
 * //=> 53
 */function dR(e,t){const r=u1(e,t?.in);const n=+dC(r,t)-+dW(r,t);// Round the number of weeks to the nearest integer because the number of
// milliseconds in a week is not constant (e.g. it's different in the week of
// the daylight saving time clock shift).
return Math.round(n/uH)+1}// Fallback for modularized imports:
/* ESM default export */const dz=/* unused pure expression or super */null&&dR;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/addLeadingZeros.js
function dV(e,t){const r=e<0?"-":"";const n=Math.abs(e).toString().padStart(t,"0");return r+n};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/format/lightFormatters.js
/*
 * |     | Unit                           |     | Unit                           |
 * |-----|--------------------------------|-----|--------------------------------|
 * |  a  | AM, PM                         |  A* |                                |
 * |  d  | Day of month                   |  D  |                                |
 * |  h  | Hour [1-12]                    |  H  | Hour [0-23]                    |
 * |  m  | Minute                         |  M  | Month                          |
 * |  s  | Second                         |  S  | Fraction of second             |
 * |  y  | Year (abs)                     |  Y  |                                |
 *
 * Letters marked by * are not implemented but reserved by Unicode standard.
 */const dj={// Year
y(e,t){// From http://www.unicode.org/reports/tr35/tr35-31/tr35-dates.html#Date_Format_tokens
// | Year     |     y | yy |   yyy |  yyyy | yyyyy |
// |----------|-------|----|-------|-------|-------|
// | AD 1     |     1 | 01 |   001 |  0001 | 00001 |
// | AD 12    |    12 | 12 |   012 |  0012 | 00012 |
// | AD 123   |   123 | 23 |   123 |  0123 | 00123 |
// | AD 1234  |  1234 | 34 |  1234 |  1234 | 01234 |
// | AD 12345 | 12345 | 45 | 12345 | 12345 | 12345 |
const r=e.getFullYear();// Returns 1 for 1 BC (which is year 0 in JavaScript)
const n=r>0?r:1-r;return dV(t==="yy"?n%100:n,t.length)},// Month
M(e,t){const r=e.getMonth();return t==="M"?String(r+1):dV(r+1,2)},// Day of the month
d(e,t){return dV(e.getDate(),t.length)},// AM or PM
a(e,t){const r=e.getHours()/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.toUpperCase();case"aaa":return r;case"aaaaa":return r[0];case"aaaa":default:return r==="am"?"a.m.":"p.m."}},// Hour [1-12]
h(e,t){return dV(e.getHours()%12||12,t.length)},// Hour [0-23]
H(e,t){return dV(e.getHours(),t.length)},// Minute
m(e,t){return dV(e.getMinutes(),t.length)},// Second
s(e,t){return dV(e.getSeconds(),t.length)},// Fraction of second
S(e,t){const r=t.length;const n=e.getMilliseconds();const o=Math.trunc(n*Math.pow(10,r-3));return dV(o,t.length)}};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/format/formatters.js
const dq={am:"am",pm:"pm",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"};/*
 * |     | Unit                           |     | Unit                           |
 * |-----|--------------------------------|-----|--------------------------------|
 * |  a  | AM, PM                         |  A* | Milliseconds in day            |
 * |  b  | AM, PM, noon, midnight         |  B  | Flexible day period            |
 * |  c  | Stand-alone local day of week  |  C* | Localized hour w/ day period   |
 * |  d  | Day of month                   |  D  | Day of year                    |
 * |  e  | Local day of week              |  E  | Day of week                    |
 * |  f  |                                |  F* | Day of week in month           |
 * |  g* | Modified Julian day            |  G  | Era                            |
 * |  h  | Hour [1-12]                    |  H  | Hour [0-23]                    |
 * |  i! | ISO day of week                |  I! | ISO week of year               |
 * |  j* | Localized hour w/ day period   |  J* | Localized hour w/o day period  |
 * |  k  | Hour [1-24]                    |  K  | Hour [0-11]                    |
 * |  l* | (deprecated)                   |  L  | Stand-alone month              |
 * |  m  | Minute                         |  M  | Month                          |
 * |  n  |                                |  N  |                                |
 * |  o! | Ordinal number modifier        |  O  | Timezone (GMT)                 |
 * |  p! | Long localized time            |  P! | Long localized date            |
 * |  q  | Stand-alone quarter            |  Q  | Quarter                        |
 * |  r* | Related Gregorian year         |  R! | ISO week-numbering year        |
 * |  s  | Second                         |  S  | Fraction of second             |
 * |  t! | Seconds timestamp              |  T! | Milliseconds timestamp         |
 * |  u  | Extended year                  |  U* | Cyclic year                    |
 * |  v* | Timezone (generic non-locat.)  |  V* | Timezone (location)            |
 * |  w  | Local week of year             |  W* | Week of month                  |
 * |  x  | Timezone (ISO-8601 w/o Z)      |  X  | Timezone (ISO-8601)            |
 * |  y  | Year (abs)                     |  Y  | Local week-numbering year      |
 * |  z  | Timezone (specific non-locat.) |  Z* | Timezone (aliases)             |
 *
 * Letters marked by * are not implemented but reserved by Unicode standard.
 *
 * Letters marked by ! are non-standard, but implemented by date-fns:
 * - `o` modifies the previous token to turn it into an ordinal (see `format` docs)
 * - `i` is ISO day of week. For `i` and `ii` is returns numeric ISO week days,
 *   i.e. 7 for Sunday, 1 for Monday, etc.
 * - `I` is ISO week of year, as opposed to `w` which is local week of year.
 * - `R` is ISO week-numbering year, as opposed to `Y` which is local week-numbering year.
 *   `R` is supposed to be used in conjunction with `I` and `i`
 *   for universal ISO week-numbering date, whereas
 *   `Y` is supposed to be used in conjunction with `w` and `e`
 *   for week-numbering date specific to the locale.
 * - `P` is long localized date format
 * - `p` is long localized time format
 */const dU={// Era
G:function(e,t,r){const n=e.getFullYear()>0?1:0;switch(t){// AD, BC
case"G":case"GG":case"GGG":return r.era(n,{width:"abbreviated"});// A, B
case"GGGGG":return r.era(n,{width:"narrow"});// Anno Domini, Before Christ
case"GGGG":default:return r.era(n,{width:"wide"})}},// Year
y:function(e,t,r){// Ordinal number
if(t==="yo"){const t=e.getFullYear();// Returns 1 for 1 BC (which is year 0 in JavaScript)
const n=t>0?t:1-t;return r.ordinalNumber(n,{unit:"year"})}return dj.y(e,t)},// Local week-numbering year
Y:function(e,t,r,n){const o=dP(e,n);// Returns 1 for 1 BC (which is year 0 in JavaScript)
const a=o>0?o:1-o;// Two digit year
if(t==="YY"){const e=a%100;return dV(e,2)}// Ordinal number
if(t==="Yo"){return r.ordinalNumber(a,{unit:"year"})}// Padding
return dV(a,t.length)},// ISO week-numbering year
R:function(e,t){const r=dF(e);// Padding
return dV(r,t.length)},// Extended year. This is a single number designating the year of this calendar system.
// The main difference between `y` and `u` localizers are B.C. years:
// | Year | `y` | `u` |
// |------|-----|-----|
// | AC 1 |   1 |   1 |
// | BC 1 |   1 |   0 |
// | BC 2 |   2 |  -1 |
// Also `yy` always returns the last two digits of a year,
// while `uu` pads single digit years to 2 characters and returns other years unchanged.
u:function(e,t){const r=e.getFullYear();return dV(r,t.length)},// Quarter
Q:function(e,t,r){const n=Math.ceil((e.getMonth()+1)/3);switch(t){// 1, 2, 3, 4
case"Q":return String(n);// 01, 02, 03, 04
case"QQ":return dV(n,2);// 1st, 2nd, 3rd, 4th
case"Qo":return r.ordinalNumber(n,{unit:"quarter"});// Q1, Q2, Q3, Q4
case"QQQ":return r.quarter(n,{width:"abbreviated",context:"formatting"});// 1, 2, 3, 4 (narrow quarter; could be not numerical)
case"QQQQQ":return r.quarter(n,{width:"narrow",context:"formatting"});// 1st quarter, 2nd quarter, ...
case"QQQQ":default:return r.quarter(n,{width:"wide",context:"formatting"})}},// Stand-alone quarter
q:function(e,t,r){const n=Math.ceil((e.getMonth()+1)/3);switch(t){// 1, 2, 3, 4
case"q":return String(n);// 01, 02, 03, 04
case"qq":return dV(n,2);// 1st, 2nd, 3rd, 4th
case"qo":return r.ordinalNumber(n,{unit:"quarter"});// Q1, Q2, Q3, Q4
case"qqq":return r.quarter(n,{width:"abbreviated",context:"standalone"});// 1, 2, 3, 4 (narrow quarter; could be not numerical)
case"qqqqq":return r.quarter(n,{width:"narrow",context:"standalone"});// 1st quarter, 2nd quarter, ...
case"qqqq":default:return r.quarter(n,{width:"wide",context:"standalone"})}},// Month
M:function(e,t,r){const n=e.getMonth();switch(t){case"M":case"MM":return dj.M(e,t);// 1st, 2nd, ..., 12th
case"Mo":return r.ordinalNumber(n+1,{unit:"month"});// Jan, Feb, ..., Dec
case"MMM":return r.month(n,{width:"abbreviated",context:"formatting"});// J, F, ..., D
case"MMMMM":return r.month(n,{width:"narrow",context:"formatting"});// January, February, ..., December
case"MMMM":default:return r.month(n,{width:"wide",context:"formatting"})}},// Stand-alone month
L:function(e,t,r){const n=e.getMonth();switch(t){// 1, 2, ..., 12
case"L":return String(n+1);// 01, 02, ..., 12
case"LL":return dV(n+1,2);// 1st, 2nd, ..., 12th
case"Lo":return r.ordinalNumber(n+1,{unit:"month"});// Jan, Feb, ..., Dec
case"LLL":return r.month(n,{width:"abbreviated",context:"standalone"});// J, F, ..., D
case"LLLLL":return r.month(n,{width:"narrow",context:"standalone"});// January, February, ..., December
case"LLLL":default:return r.month(n,{width:"wide",context:"standalone"})}},// Local week of year
w:function(e,t,r,n){const o=dR(e,n);if(t==="wo"){return r.ordinalNumber(o,{unit:"week"})}return dV(o,t.length)},// ISO week of year
I:function(e,t,r){const n=dK(e);if(t==="Io"){return r.ordinalNumber(n,{unit:"week"})}return dV(n,t.length)},// Day of the month
d:function(e,t,r){if(t==="do"){return r.ordinalNumber(e.getDate(),{unit:"date"})}return dj.d(e,t)},// Day of year
D:function(e,t,r){const n=dI(e);if(t==="Do"){return r.ordinalNumber(n,{unit:"dayOfYear"})}return dV(n,t.length)},// Day of week
E:function(e,t,r){const n=e.getDay();switch(t){// Tue
case"E":case"EE":case"EEE":return r.day(n,{width:"abbreviated",context:"formatting"});// T
case"EEEEE":return r.day(n,{width:"narrow",context:"formatting"});// Tu
case"EEEEEE":return r.day(n,{width:"short",context:"formatting"});// Tuesday
case"EEEE":default:return r.day(n,{width:"wide",context:"formatting"})}},// Local day of week
e:function(e,t,r,n){const o=e.getDay();const a=(o-n.weekStartsOn+8)%7||7;switch(t){// Numerical value (Nth day of week with current locale or weekStartsOn)
case"e":return String(a);// Padded numerical value
case"ee":return dV(a,2);// 1st, 2nd, ..., 7th
case"eo":return r.ordinalNumber(a,{unit:"day"});case"eee":return r.day(o,{width:"abbreviated",context:"formatting"});// T
case"eeeee":return r.day(o,{width:"narrow",context:"formatting"});// Tu
case"eeeeee":return r.day(o,{width:"short",context:"formatting"});// Tuesday
case"eeee":default:return r.day(o,{width:"wide",context:"formatting"})}},// Stand-alone local day of week
c:function(e,t,r,n){const o=e.getDay();const a=(o-n.weekStartsOn+8)%7||7;switch(t){// Numerical value (same as in `e`)
case"c":return String(a);// Padded numerical value
case"cc":return dV(a,t.length);// 1st, 2nd, ..., 7th
case"co":return r.ordinalNumber(a,{unit:"day"});case"ccc":return r.day(o,{width:"abbreviated",context:"standalone"});// T
case"ccccc":return r.day(o,{width:"narrow",context:"standalone"});// Tu
case"cccccc":return r.day(o,{width:"short",context:"standalone"});// Tuesday
case"cccc":default:return r.day(o,{width:"wide",context:"standalone"})}},// ISO day of week
i:function(e,t,r){const n=e.getDay();const o=n===0?7:n;switch(t){// 2
case"i":return String(o);// 02
case"ii":return dV(o,t.length);// 2nd
case"io":return r.ordinalNumber(o,{unit:"day"});// Tue
case"iii":return r.day(n,{width:"abbreviated",context:"formatting"});// T
case"iiiii":return r.day(n,{width:"narrow",context:"formatting"});// Tu
case"iiiiii":return r.day(n,{width:"short",context:"formatting"});// Tuesday
case"iiii":default:return r.day(n,{width:"wide",context:"formatting"})}},// AM or PM
a:function(e,t,r){const n=e.getHours();const o=n/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.dayPeriod(o,{width:"abbreviated",context:"formatting"});case"aaa":return r.dayPeriod(o,{width:"abbreviated",context:"formatting"}).toLowerCase();case"aaaaa":return r.dayPeriod(o,{width:"narrow",context:"formatting"});case"aaaa":default:return r.dayPeriod(o,{width:"wide",context:"formatting"})}},// AM, PM, midnight, noon
b:function(e,t,r){const n=e.getHours();let o;if(n===12){o=dq.noon}else if(n===0){o=dq.midnight}else{o=n/12>=1?"pm":"am"}switch(t){case"b":case"bb":return r.dayPeriod(o,{width:"abbreviated",context:"formatting"});case"bbb":return r.dayPeriod(o,{width:"abbreviated",context:"formatting"}).toLowerCase();case"bbbbb":return r.dayPeriod(o,{width:"narrow",context:"formatting"});case"bbbb":default:return r.dayPeriod(o,{width:"wide",context:"formatting"})}},// in the morning, in the afternoon, in the evening, at night
B:function(e,t,r){const n=e.getHours();let o;if(n>=17){o=dq.evening}else if(n>=12){o=dq.afternoon}else if(n>=4){o=dq.morning}else{o=dq.night}switch(t){case"B":case"BB":case"BBB":return r.dayPeriod(o,{width:"abbreviated",context:"formatting"});case"BBBBB":return r.dayPeriod(o,{width:"narrow",context:"formatting"});case"BBBB":default:return r.dayPeriod(o,{width:"wide",context:"formatting"})}},// Hour [1-12]
h:function(e,t,r){if(t==="ho"){let t=e.getHours()%12;if(t===0)t=12;return r.ordinalNumber(t,{unit:"hour"})}return dj.h(e,t)},// Hour [0-23]
H:function(e,t,r){if(t==="Ho"){return r.ordinalNumber(e.getHours(),{unit:"hour"})}return dj.H(e,t)},// Hour [0-11]
K:function(e,t,r){const n=e.getHours()%12;if(t==="Ko"){return r.ordinalNumber(n,{unit:"hour"})}return dV(n,t.length)},// Hour [1-24]
k:function(e,t,r){let n=e.getHours();if(n===0)n=24;if(t==="ko"){return r.ordinalNumber(n,{unit:"hour"})}return dV(n,t.length)},// Minute
m:function(e,t,r){if(t==="mo"){return r.ordinalNumber(e.getMinutes(),{unit:"minute"})}return dj.m(e,t)},// Second
s:function(e,t,r){if(t==="so"){return r.ordinalNumber(e.getSeconds(),{unit:"second"})}return dj.s(e,t)},// Fraction of second
S:function(e,t){return dj.S(e,t)},// Timezone (ISO-8601. If offset is 0, output is always `'Z'`)
X:function(e,t,r){const n=e.getTimezoneOffset();if(n===0){return"Z"}switch(t){// Hours and optional minutes
case"X":return dQ(n);// Hours, minutes and optional seconds without `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `XX`
case"XXXX":case"XX":return dX(n);// Hours, minutes and optional seconds with `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `XXX`
case"XXXXX":case"XXX":default:return dX(n,":")}},// Timezone (ISO-8601. If offset is 0, output is `'+00:00'` or equivalent)
x:function(e,t,r){const n=e.getTimezoneOffset();switch(t){// Hours and optional minutes
case"x":return dQ(n);// Hours, minutes and optional seconds without `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `xx`
case"xxxx":case"xx":return dX(n);// Hours, minutes and optional seconds with `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `xxx`
case"xxxxx":case"xxx":default:return dX(n,":")}},// Timezone (GMT)
O:function(e,t,r){const n=e.getTimezoneOffset();switch(t){// Short
case"O":case"OO":case"OOO":return"GMT"+dG(n,":");// Long
case"OOOO":default:return"GMT"+dX(n,":")}},// Timezone (specific non-location)
z:function(e,t,r){const n=e.getTimezoneOffset();switch(t){// Short
case"z":case"zz":case"zzz":return"GMT"+dG(n,":");// Long
case"zzzz":default:return"GMT"+dX(n,":")}},// Seconds timestamp
t:function(e,t,r){const n=Math.trunc(+e/1e3);return dV(n,t.length)},// Milliseconds timestamp
T:function(e,t,r){return dV(+e,t.length)}};function dG(e,t=""){const r=e>0?"-":"+";const n=Math.abs(e);const o=Math.trunc(n/60);const a=n%60;if(a===0){return r+String(o)}return r+String(o)+t+dV(a,2)}function dQ(e,t){if(e%60===0){const t=e>0?"-":"+";return t+dV(Math.abs(e)/60,2)}return dX(e,t)}function dX(e,t=""){const r=e>0?"-":"+";const n=Math.abs(e);const o=dV(Math.trunc(n/60),2);const a=dV(n%60,2);return r+o+t+a};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/format/longFormatters.js
const d$=(e,t)=>{switch(e){case"P":return t.date({width:"short"});case"PP":return t.date({width:"medium"});case"PPP":return t.date({width:"long"});case"PPPP":default:return t.date({width:"full"})}};const dZ=(e,t)=>{switch(e){case"p":return t.time({width:"short"});case"pp":return t.time({width:"medium"});case"ppp":return t.time({width:"long"});case"pppp":default:return t.time({width:"full"})}};const dJ=(e,t)=>{const r=e.match(/(P+)(p+)?/)||[];const n=r[1];const o=r[2];if(!o){return d$(e,t)}let a;switch(n){case"P":a=t.dateTime({width:"short"});break;case"PP":a=t.dateTime({width:"medium"});break;case"PPP":a=t.dateTime({width:"long"});break;case"PPPP":default:a=t.dateTime({width:"full"});break}return a.replace("{{date}}",d$(n,t)).replace("{{time}}",dZ(o,t))};const d0={p:dZ,P:dJ};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/_lib/protectedTokens.js
const d1=/^D+$/;const d6=/^Y+$/;const d2=["D","DD","YY","YYYY"];function d4(e){return d1.test(e)}function d3(e){return d6.test(e)}function d5(e,t,r){const n=d8(e,t,r);console.warn(n);if(d2.includes(e))throw new RangeError(n)}function d8(e,t,r){const n=e[0]==="Y"?"years":"days of the month";return`Use \`${e.toLowerCase()}\` instead of \`${e}\` (in \`${t}\`) for formatting ${n} to the input \`${r}\`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md`};// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/isDate.js
/**
 * @name isDate
 * @category Common Helpers
 * @summary Is the given value a date?
 *
 * @description
 * Returns true if the given value is an instance of Date. The function works for dates transferred across iframes.
 *
 * @param value - The value to check
 *
 * @returns True if the given value is a date
 *
 * @example
 * // For a valid date:
 * const result = isDate(new Date())
 * //=> true
 *
 * @example
 * // For an invalid date:
 * const result = isDate(new Date(NaN))
 * //=> true
 *
 * @example
 * // For some value:
 * const result = isDate('2014-02-31')
 * //=> false
 *
 * @example
 * // For an object:
 * const result = isDate({})
 * //=> false
 */function d7(e){return e instanceof Date||typeof e==="object"&&Object.prototype.toString.call(e)==="[object Date]"}// Fallback for modularized imports:
/* ESM default export */const d9=/* unused pure expression or super */null&&d7;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/isValid.js
/**
 * @name isValid
 * @category Common Helpers
 * @summary Is the given date valid?
 *
 * @description
 * Returns false if argument is Invalid Date and true otherwise.
 * Argument is converted to Date using `toDate`. See [toDate](https://date-fns.org/docs/toDate)
 * Invalid Date is a Date, whose time value is NaN.
 *
 * Time value of Date: http://es5.github.io/#x15.9.1.1
 *
 * @param date - The date to check
 *
 * @returns The date is valid
 *
 * @example
 * // For the valid date:
 * const result = isValid(new Date(2014, 1, 31))
 * //=> true
 *
 * @example
 * // For the value, convertible into a date:
 * const result = isValid(1393804800000)
 * //=> true
 *
 * @example
 * // For the invalid date:
 * const result = isValid(new Date(''))
 * //=> false
 */function fe(e){return!(!d7(e)&&typeof e!=="number"||isNaN(+u1(e)))}// Fallback for modularized imports:
/* ESM default export */const ft=/* unused pure expression or super */null&&fe;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/format.js
// Rexports of internal for libraries to use.
// See: https://github.com/date-fns/date-fns/issues/3638#issuecomment-1877082874
// This RegExp consists of three parts separated by `|`:
// - [yYQqMLwIdDecihHKkms]o matches any available ordinal number token
//   (one of the certain letters followed by `o`)
// - (\w)\1* matches any sequences of the same letter
// - '' matches two quote characters in a row
// - '(''|[^'])+('|$) matches anything surrounded by two quote characters ('),
//   except a single quote symbol, which ends the sequence.
//   Two quote characters do not end the sequence.
//   If there is no matching single quote
//   then the sequence will continue until the end of the string.
// - . matches any single character unmatched by previous parts of the RegExps
const fr=/[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g;// This RegExp catches symbols escaped by quotes, and also
// sequences of symbols P, p, and the combinations like `PPPPPPPppppp`
const fn=/P+p+|P+|p+|''|'(''|[^'])+('|$)|./g;const fo=/^'([^]*?)'?$/;const fa=/''/g;const fi=/[a-zA-Z]/;/**
 * The {@link format} function options.
 *//**
 * @name format
 * @alias formatDate
 * @category Common Helpers
 * @summary Format the date.
 *
 * @description
 * Return the formatted date string in the given format. The result may vary by locale.
 *
 * > ⚠️ Please note that the `format` tokens differ from Moment.js and other libraries.
 * > See: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 *
 * The characters wrapped between two single quotes characters (') are escaped.
 * Two single quotes in a row, whether inside or outside a quoted sequence, represent a 'real' single quote.
 * (see the last example)
 *
 * Format of the string is based on Unicode Technical Standard #35:
 * https://www.unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table
 * with a few additions (see note 7 below the table).
 *
 * Accepted patterns:
 * | Unit                            | Pattern | Result examples                   | Notes |
 * |---------------------------------|---------|-----------------------------------|-------|
 * | Era                             | G..GGG  | AD, BC                            |       |
 * |                                 | GGGG    | Anno Domini, Before Christ        | 2     |
 * |                                 | GGGGG   | A, B                              |       |
 * | Calendar year                   | y       | 44, 1, 1900, 2017                 | 5     |
 * |                                 | yo      | 44th, 1st, 0th, 17th              | 5,7   |
 * |                                 | yy      | 44, 01, 00, 17                    | 5     |
 * |                                 | yyy     | 044, 001, 1900, 2017              | 5     |
 * |                                 | yyyy    | 0044, 0001, 1900, 2017            | 5     |
 * |                                 | yyyyy   | ...                               | 3,5   |
 * | Local week-numbering year       | Y       | 44, 1, 1900, 2017                 | 5     |
 * |                                 | Yo      | 44th, 1st, 1900th, 2017th         | 5,7   |
 * |                                 | YY      | 44, 01, 00, 17                    | 5,8   |
 * |                                 | YYY     | 044, 001, 1900, 2017              | 5     |
 * |                                 | YYYY    | 0044, 0001, 1900, 2017            | 5,8   |
 * |                                 | YYYYY   | ...                               | 3,5   |
 * | ISO week-numbering year         | R       | -43, 0, 1, 1900, 2017             | 5,7   |
 * |                                 | RR      | -43, 00, 01, 1900, 2017           | 5,7   |
 * |                                 | RRR     | -043, 000, 001, 1900, 2017        | 5,7   |
 * |                                 | RRRR    | -0043, 0000, 0001, 1900, 2017     | 5,7   |
 * |                                 | RRRRR   | ...                               | 3,5,7 |
 * | Extended year                   | u       | -43, 0, 1, 1900, 2017             | 5     |
 * |                                 | uu      | -43, 01, 1900, 2017               | 5     |
 * |                                 | uuu     | -043, 001, 1900, 2017             | 5     |
 * |                                 | uuuu    | -0043, 0001, 1900, 2017           | 5     |
 * |                                 | uuuuu   | ...                               | 3,5   |
 * | Quarter (formatting)            | Q       | 1, 2, 3, 4                        |       |
 * |                                 | Qo      | 1st, 2nd, 3rd, 4th                | 7     |
 * |                                 | QQ      | 01, 02, 03, 04                    |       |
 * |                                 | QQQ     | Q1, Q2, Q3, Q4                    |       |
 * |                                 | QQQQ    | 1st quarter, 2nd quarter, ...     | 2     |
 * |                                 | QQQQQ   | 1, 2, 3, 4                        | 4     |
 * | Quarter (stand-alone)           | q       | 1, 2, 3, 4                        |       |
 * |                                 | qo      | 1st, 2nd, 3rd, 4th                | 7     |
 * |                                 | qq      | 01, 02, 03, 04                    |       |
 * |                                 | qqq     | Q1, Q2, Q3, Q4                    |       |
 * |                                 | qqqq    | 1st quarter, 2nd quarter, ...     | 2     |
 * |                                 | qqqqq   | 1, 2, 3, 4                        | 4     |
 * | Month (formatting)              | M       | 1, 2, ..., 12                     |       |
 * |                                 | Mo      | 1st, 2nd, ..., 12th               | 7     |
 * |                                 | MM      | 01, 02, ..., 12                   |       |
 * |                                 | MMM     | Jan, Feb, ..., Dec                |       |
 * |                                 | MMMM    | January, February, ..., December  | 2     |
 * |                                 | MMMMM   | J, F, ..., D                      |       |
 * | Month (stand-alone)             | L       | 1, 2, ..., 12                     |       |
 * |                                 | Lo      | 1st, 2nd, ..., 12th               | 7     |
 * |                                 | LL      | 01, 02, ..., 12                   |       |
 * |                                 | LLL     | Jan, Feb, ..., Dec                |       |
 * |                                 | LLLL    | January, February, ..., December  | 2     |
 * |                                 | LLLLL   | J, F, ..., D                      |       |
 * | Local week of year              | w       | 1, 2, ..., 53                     |       |
 * |                                 | wo      | 1st, 2nd, ..., 53th               | 7     |
 * |                                 | ww      | 01, 02, ..., 53                   |       |
 * | ISO week of year                | I       | 1, 2, ..., 53                     | 7     |
 * |                                 | Io      | 1st, 2nd, ..., 53th               | 7     |
 * |                                 | II      | 01, 02, ..., 53                   | 7     |
 * | Day of month                    | d       | 1, 2, ..., 31                     |       |
 * |                                 | do      | 1st, 2nd, ..., 31st               | 7     |
 * |                                 | dd      | 01, 02, ..., 31                   |       |
 * | Day of year                     | D       | 1, 2, ..., 365, 366               | 9     |
 * |                                 | Do      | 1st, 2nd, ..., 365th, 366th       | 7     |
 * |                                 | DD      | 01, 02, ..., 365, 366             | 9     |
 * |                                 | DDD     | 001, 002, ..., 365, 366           |       |
 * |                                 | DDDD    | ...                               | 3     |
 * | Day of week (formatting)        | E..EEE  | Mon, Tue, Wed, ..., Sun           |       |
 * |                                 | EEEE    | Monday, Tuesday, ..., Sunday      | 2     |
 * |                                 | EEEEE   | M, T, W, T, F, S, S               |       |
 * |                                 | EEEEEE  | Mo, Tu, We, Th, Fr, Sa, Su        |       |
 * | ISO day of week (formatting)    | i       | 1, 2, 3, ..., 7                   | 7     |
 * |                                 | io      | 1st, 2nd, ..., 7th                | 7     |
 * |                                 | ii      | 01, 02, ..., 07                   | 7     |
 * |                                 | iii     | Mon, Tue, Wed, ..., Sun           | 7     |
 * |                                 | iiii    | Monday, Tuesday, ..., Sunday      | 2,7   |
 * |                                 | iiiii   | M, T, W, T, F, S, S               | 7     |
 * |                                 | iiiiii  | Mo, Tu, We, Th, Fr, Sa, Su        | 7     |
 * | Local day of week (formatting)  | e       | 2, 3, 4, ..., 1                   |       |
 * |                                 | eo      | 2nd, 3rd, ..., 1st                | 7     |
 * |                                 | ee      | 02, 03, ..., 01                   |       |
 * |                                 | eee     | Mon, Tue, Wed, ..., Sun           |       |
 * |                                 | eeee    | Monday, Tuesday, ..., Sunday      | 2     |
 * |                                 | eeeee   | M, T, W, T, F, S, S               |       |
 * |                                 | eeeeee  | Mo, Tu, We, Th, Fr, Sa, Su        |       |
 * | Local day of week (stand-alone) | c       | 2, 3, 4, ..., 1                   |       |
 * |                                 | co      | 2nd, 3rd, ..., 1st                | 7     |
 * |                                 | cc      | 02, 03, ..., 01                   |       |
 * |                                 | ccc     | Mon, Tue, Wed, ..., Sun           |       |
 * |                                 | cccc    | Monday, Tuesday, ..., Sunday      | 2     |
 * |                                 | ccccc   | M, T, W, T, F, S, S               |       |
 * |                                 | cccccc  | Mo, Tu, We, Th, Fr, Sa, Su        |       |
 * | AM, PM                          | a..aa   | AM, PM                            |       |
 * |                                 | aaa     | am, pm                            |       |
 * |                                 | aaaa    | a.m., p.m.                        | 2     |
 * |                                 | aaaaa   | a, p                              |       |
 * | AM, PM, noon, midnight          | b..bb   | AM, PM, noon, midnight            |       |
 * |                                 | bbb     | am, pm, noon, midnight            |       |
 * |                                 | bbbb    | a.m., p.m., noon, midnight        | 2     |
 * |                                 | bbbbb   | a, p, n, mi                       |       |
 * | Flexible day period             | B..BBB  | at night, in the morning, ...     |       |
 * |                                 | BBBB    | at night, in the morning, ...     | 2     |
 * |                                 | BBBBB   | at night, in the morning, ...     |       |
 * | Hour [1-12]                     | h       | 1, 2, ..., 11, 12                 |       |
 * |                                 | ho      | 1st, 2nd, ..., 11th, 12th         | 7     |
 * |                                 | hh      | 01, 02, ..., 11, 12               |       |
 * | Hour [0-23]                     | H       | 0, 1, 2, ..., 23                  |       |
 * |                                 | Ho      | 0th, 1st, 2nd, ..., 23rd          | 7     |
 * |                                 | HH      | 00, 01, 02, ..., 23               |       |
 * | Hour [0-11]                     | K       | 1, 2, ..., 11, 0                  |       |
 * |                                 | Ko      | 1st, 2nd, ..., 11th, 0th          | 7     |
 * |                                 | KK      | 01, 02, ..., 11, 00               |       |
 * | Hour [1-24]                     | k       | 24, 1, 2, ..., 23                 |       |
 * |                                 | ko      | 24th, 1st, 2nd, ..., 23rd         | 7     |
 * |                                 | kk      | 24, 01, 02, ..., 23               |       |
 * | Minute                          | m       | 0, 1, ..., 59                     |       |
 * |                                 | mo      | 0th, 1st, ..., 59th               | 7     |
 * |                                 | mm      | 00, 01, ..., 59                   |       |
 * | Second                          | s       | 0, 1, ..., 59                     |       |
 * |                                 | so      | 0th, 1st, ..., 59th               | 7     |
 * |                                 | ss      | 00, 01, ..., 59                   |       |
 * | Fraction of second              | S       | 0, 1, ..., 9                      |       |
 * |                                 | SS      | 00, 01, ..., 99                   |       |
 * |                                 | SSS     | 000, 001, ..., 999                |       |
 * |                                 | SSSS    | ...                               | 3     |
 * | Timezone (ISO-8601 w/ Z)        | X       | -08, +0530, Z                     |       |
 * |                                 | XX      | -0800, +0530, Z                   |       |
 * |                                 | XXX     | -08:00, +05:30, Z                 |       |
 * |                                 | XXXX    | -0800, +0530, Z, +123456          | 2     |
 * |                                 | XXXXX   | -08:00, +05:30, Z, +12:34:56      |       |
 * | Timezone (ISO-8601 w/o Z)       | x       | -08, +0530, +00                   |       |
 * |                                 | xx      | -0800, +0530, +0000               |       |
 * |                                 | xxx     | -08:00, +05:30, +00:00            | 2     |
 * |                                 | xxxx    | -0800, +0530, +0000, +123456      |       |
 * |                                 | xxxxx   | -08:00, +05:30, +00:00, +12:34:56 |       |
 * | Timezone (GMT)                  | O...OOO | GMT-8, GMT+5:30, GMT+0            |       |
 * |                                 | OOOO    | GMT-08:00, GMT+05:30, GMT+00:00   | 2     |
 * | Timezone (specific non-locat.)  | z...zzz | GMT-8, GMT+5:30, GMT+0            | 6     |
 * |                                 | zzzz    | GMT-08:00, GMT+05:30, GMT+00:00   | 2,6   |
 * | Seconds timestamp               | t       | 512969520                         | 7     |
 * |                                 | tt      | ...                               | 3,7   |
 * | Milliseconds timestamp          | T       | 512969520900                      | 7     |
 * |                                 | TT      | ...                               | 3,7   |
 * | Long localized date             | P       | 04/29/1453                        | 7     |
 * |                                 | PP      | Apr 29, 1453                      | 7     |
 * |                                 | PPP     | April 29th, 1453                  | 7     |
 * |                                 | PPPP    | Friday, April 29th, 1453          | 2,7   |
 * | Long localized time             | p       | 12:00 AM                          | 7     |
 * |                                 | pp      | 12:00:00 AM                       | 7     |
 * |                                 | ppp     | 12:00:00 AM GMT+2                 | 7     |
 * |                                 | pppp    | 12:00:00 AM GMT+02:00             | 2,7   |
 * | Combination of date and time    | Pp      | 04/29/1453, 12:00 AM              | 7     |
 * |                                 | PPpp    | Apr 29, 1453, 12:00:00 AM         | 7     |
 * |                                 | PPPppp  | April 29th, 1453 at ...           | 7     |
 * |                                 | PPPPpppp| Friday, April 29th, 1453 at ...   | 2,7   |
 * Notes:
 * 1. "Formatting" units (e.g. formatting quarter) in the default en-US locale
 *    are the same as "stand-alone" units, but are different in some languages.
 *    "Formatting" units are declined according to the rules of the language
 *    in the context of a date. "Stand-alone" units are always nominative singular:
 *
 *    `format(new Date(2017, 10, 6), 'do LLLL', {locale: cs}) //=> '6. listopad'`
 *
 *    `format(new Date(2017, 10, 6), 'do MMMM', {locale: cs}) //=> '6. listopadu'`
 *
 * 2. Any sequence of the identical letters is a pattern, unless it is escaped by
 *    the single quote characters (see below).
 *    If the sequence is longer than listed in table (e.g. `EEEEEEEEEEE`)
 *    the output will be the same as default pattern for this unit, usually
 *    the longest one (in case of ISO weekdays, `EEEE`). Default patterns for units
 *    are marked with "2" in the last column of the table.
 *
 *    `format(new Date(2017, 10, 6), 'MMM') //=> 'Nov'`
 *
 *    `format(new Date(2017, 10, 6), 'MMMM') //=> 'November'`
 *
 *    `format(new Date(2017, 10, 6), 'MMMMM') //=> 'N'`
 *
 *    `format(new Date(2017, 10, 6), 'MMMMMM') //=> 'November'`
 *
 *    `format(new Date(2017, 10, 6), 'MMMMMMM') //=> 'November'`
 *
 * 3. Some patterns could be unlimited length (such as `yyyyyyyy`).
 *    The output will be padded with zeros to match the length of the pattern.
 *
 *    `format(new Date(2017, 10, 6), 'yyyyyyyy') //=> '00002017'`
 *
 * 4. `QQQQQ` and `qqqqq` could be not strictly numerical in some locales.
 *    These tokens represent the shortest form of the quarter.
 *
 * 5. The main difference between `y` and `u` patterns are B.C. years:
 *
 *    | Year | `y` | `u` |
 *    |------|-----|-----|
 *    | AC 1 |   1 |   1 |
 *    | BC 1 |   1 |   0 |
 *    | BC 2 |   2 |  -1 |
 *
 *    Also `yy` always returns the last two digits of a year,
 *    while `uu` pads single digit years to 2 characters and returns other years unchanged:
 *
 *    | Year | `yy` | `uu` |
 *    |------|------|------|
 *    | 1    |   01 |   01 |
 *    | 14   |   14 |   14 |
 *    | 376  |   76 |  376 |
 *    | 1453 |   53 | 1453 |
 *
 *    The same difference is true for local and ISO week-numbering years (`Y` and `R`),
 *    except local week-numbering years are dependent on `options.weekStartsOn`
 *    and `options.firstWeekContainsDate` (compare [getISOWeekYear](https://date-fns.org/docs/getISOWeekYear)
 *    and [getWeekYear](https://date-fns.org/docs/getWeekYear)).
 *
 * 6. Specific non-location timezones are currently unavailable in `date-fns`,
 *    so right now these tokens fall back to GMT timezones.
 *
 * 7. These patterns are not in the Unicode Technical Standard #35:
 *    - `i`: ISO day of week
 *    - `I`: ISO week of year
 *    - `R`: ISO week-numbering year
 *    - `t`: seconds timestamp
 *    - `T`: milliseconds timestamp
 *    - `o`: ordinal number modifier
 *    - `P`: long localized date
 *    - `p`: long localized time
 *
 * 8. `YY` and `YYYY` tokens represent week-numbering years but they are often confused with years.
 *    You should enable `options.useAdditionalWeekYearTokens` to use them. See: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 *
 * 9. `D` and `DD` tokens represent days of the year but they are often confused with days of the month.
 *    You should enable `options.useAdditionalDayOfYearTokens` to use them. See: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 *
 * @param date - The original date
 * @param format - The string of tokens
 * @param options - An object with options
 *
 * @returns The formatted date string
 *
 * @throws `date` must not be Invalid Date
 * @throws `options.locale` must contain `localize` property
 * @throws `options.locale` must contain `formatLong` property
 * @throws use `yyyy` instead of `YYYY` for formatting years using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws use `yy` instead of `YY` for formatting years using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws use `d` instead of `D` for formatting days of the month using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws use `dd` instead of `DD` for formatting days of the month using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws format string contains an unescaped latin alphabet character
 *
 * @example
 * // Represent 11 February 2014 in middle-endian format:
 * const result = format(new Date(2014, 1, 11), 'MM/dd/yyyy')
 * //=> '02/11/2014'
 *
 * @example
 * // Represent 2 July 2014 in Esperanto:
 * import { eoLocale } from 'date-fns/locale/eo'
 * const result = format(new Date(2014, 6, 2), "do 'de' MMMM yyyy", {
 *   locale: eoLocale
 * })
 * //=> '2-a de julio 2014'
 *
 * @example
 * // Escape string by single quote characters:
 * const result = format(new Date(2014, 6, 2, 15), "h 'o''clock'")
 * //=> "3 o'clock"
 */function fs(e,t,r){const n=dh();const o=r?.locale??n.locale??uD;const a=r?.firstWeekContainsDate??r?.locale?.options?.firstWeekContainsDate??n.firstWeekContainsDate??n.locale?.options?.firstWeekContainsDate??1;const i=r?.weekStartsOn??r?.locale?.options?.weekStartsOn??n.weekStartsOn??n.locale?.options?.weekStartsOn??0;const s=u1(e,r?.in);if(!fe(s)){throw new RangeError("Invalid time value")}let l=t.match(fn).map(e=>{const t=e[0];if(t==="p"||t==="P"){const r=d0[t];return r(e,o.formatLong)}return e}).join("").match(fr).map(e=>{// Replace two single quote characters with one single quote character
if(e==="''"){return{isToken:false,value:"'"}}const t=e[0];if(t==="'"){return{isToken:false,value:fl(e)}}if(dU[t]){return{isToken:true,value:e}}if(t.match(fi)){throw new RangeError("Format string contains an unescaped latin alphabet character `"+t+"`")}return{isToken:false,value:e}});// invoke localize preprocessor (only for french locales at the moment)
if(o.localize.preprocessor){l=o.localize.preprocessor(s,l)}const c={firstWeekContainsDate:a,weekStartsOn:i,locale:o};return l.map(n=>{if(!n.isToken)return n.value;const a=n.value;if(!r?.useAdditionalWeekYearTokens&&d3(a)||!r?.useAdditionalDayOfYearTokens&&d4(a)){d5(a,t,String(e))}const i=dU[a[0]];return i(s,a,o.localize,c)}).join("")}function fl(e){const t=e.match(fo);if(!t){return e}return t[1].replace(fa,"'")}// Fallback for modularized imports:
/* ESM default export */const fc=/* unused pure expression or super */null&&fs;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getMonth.js
/**
 * The {@link getMonth} function options.
 *//**
 * @name getMonth
 * @category Month Helpers
 * @summary Get the month of the given date.
 *
 * @description
 * Get the month of the given date.
 *
 * @param date - The given date
 * @param options - An object with options
 *
 * @returns The month index (0-11)
 *
 * @example
 * // Which month is 29 February 2012?
 * const result = getMonth(new Date(2012, 1, 29))
 * //=> 1
 */function fu(e,t){return u1(e,t?.in).getMonth()}// Fallback for modularized imports:
/* ESM default export */const fd=/* unused pure expression or super */null&&fu;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getYear.js
/**
 * The {@link getYear} function options.
 *//**
 * @name getYear
 * @category Year Helpers
 * @summary Get the year of the given date.
 *
 * @description
 * Get the year of the given date.
 *
 * @param date - The given date
 * @param options - An object with options
 *
 * @returns The year
 *
 * @example
 * // Which year is 2 July 2014?
 * const result = getYear(new Date(2014, 6, 2))
 * //=> 2014
 */function ff(e,t){return u1(e,t?.in).getFullYear()}// Fallback for modularized imports:
/* ESM default export */const fp=/* unused pure expression or super */null&&ff;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/isAfter.js
/**
 * @name isAfter
 * @category Common Helpers
 * @summary Is the first date after the second one?
 *
 * @description
 * Is the first date after the second one?
 *
 * @param date - The date that should be after the other one to return true
 * @param dateToCompare - The date to compare with
 *
 * @returns The first date is after the second date
 *
 * @example
 * // Is 10 July 1989 after 11 February 1987?
 * const result = isAfter(new Date(1989, 6, 10), new Date(1987, 1, 11))
 * //=> true
 */function fh(e,t){return+u1(e)>+u1(t)}// Fallback for modularized imports:
/* ESM default export */const fv=/* unused pure expression or super */null&&fh;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/isBefore.js
/**
 * @name isBefore
 * @category Common Helpers
 * @summary Is the first date before the second one?
 *
 * @description
 * Is the first date before the second one?
 *
 * @param date - The date that should be before the other one to return true
 * @param dateToCompare - The date to compare with
 *
 * @returns The first date is before the second date
 *
 * @example
 * // Is 10 July 1989 before 11 February 1987?
 * const result = isBefore(new Date(1989, 6, 10), new Date(1987, 1, 11))
 * //=> false
 */function fg(e,t){return+u1(e)<+u1(t)}// Fallback for modularized imports:
/* ESM default export */const fm=/* unused pure expression or super */null&&fg;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/isSameDay.js
/**
 * The {@link isSameDay} function options.
 *//**
 * @name isSameDay
 * @category Day Helpers
 * @summary Are the given dates in the same day (and year and month)?
 *
 * @description
 * Are the given dates in the same day (and year and month)?
 *
 * @param laterDate - The first date to check
 * @param earlierDate - The second date to check
 * @param options - An object with options
 *
 * @returns The dates are in the same day (and year and month)
 *
 * @example
 * // Are 4 September 06:00:00 and 4 September 18:00:00 in the same day?
 * const result = isSameDay(new Date(2014, 8, 4, 6, 0), new Date(2014, 8, 4, 18, 0))
 * //=> true
 *
 * @example
 * // Are 4 September and 4 October in the same day?
 * const result = isSameDay(new Date(2014, 8, 4), new Date(2014, 9, 4))
 * //=> false
 *
 * @example
 * // Are 4 September, 2014 and 4 September, 2015 in the same day?
 * const result = isSameDay(new Date(2014, 8, 4), new Date(2015, 8, 4))
 * //=> false
 */function fb(e,t,r){const[n,o]=dr(r?.in,e,t);return+dn(n)===+dn(o)}// Fallback for modularized imports:
/* ESM default export */const fy=/* unused pure expression or super */null&&fb;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/isSameMonth.js
/**
 * The {@link isSameMonth} function options.
 *//**
 * @name isSameMonth
 * @category Month Helpers
 * @summary Are the given dates in the same month (and year)?
 *
 * @description
 * Are the given dates in the same month (and year)?
 *
 * @param laterDate - The first date to check
 * @param earlierDate - The second date to check
 * @param options - An object with options
 *
 * @returns The dates are in the same month (and year)
 *
 * @example
 * // Are 2 September 2014 and 25 September 2014 in the same month?
 * const result = isSameMonth(new Date(2014, 8, 2), new Date(2014, 8, 25))
 * //=> true
 *
 * @example
 * // Are 2 September 2014 and 25 September 2015 in the same month?
 * const result = isSameMonth(new Date(2014, 8, 2), new Date(2015, 8, 25))
 * //=> false
 */function f_(e,t,r){const[n,o]=dr(r?.in,e,t);return n.getFullYear()===o.getFullYear()&&n.getMonth()===o.getMonth()}// Fallback for modularized imports:
/* ESM default export */const fw=/* unused pure expression or super */null&&f_;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/isSameYear.js
/**
 * The {@link isSameYear} function options.
 *//**
 * @name isSameYear
 * @category Year Helpers
 * @summary Are the given dates in the same year?
 *
 * @description
 * Are the given dates in the same year?
 *
 * @param laterDate - The first date to check
 * @param earlierDate - The second date to check
 * @param options - An object with options
 *
 * @returns The dates are in the same year
 *
 * @example
 * // Are 2 September 2014 and 25 September 2014 in the same year?
 * const result = isSameYear(new Date(2014, 8, 2), new Date(2014, 8, 25))
 * //=> true
 */function fx(e,t,r){const[n,o]=dr(r?.in,e,t);return n.getFullYear()===o.getFullYear()}// Fallback for modularized imports:
/* ESM default export */const fA=/* unused pure expression or super */null&&fx;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/max.js
/**
 * The {@link max} function options.
 *//**
 * @name max
 * @category Common Helpers
 * @summary Return the latest of the given dates.
 *
 * @description
 * Return the latest of the given dates.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param dates - The dates to compare
 *
 * @returns The latest of the dates
 *
 * @example
 * // Which of these dates is the latest?
 * const result = max([
 *   new Date(1989, 6, 10),
 *   new Date(1987, 1, 11),
 *   new Date(1995, 6, 2),
 *   new Date(1990, 0, 1)
 * ])
 * //=> Sun Jul 02 1995 00:00:00
 */function fk(e,t){let r;let n=t?.in;e.forEach(e=>{// Use the first date object as the context function
if(!n&&typeof e==="object")n=uJ.bind(null,e);const t=u1(e,n);if(!r||r<t||isNaN(+t))r=t});return uJ(n,r||NaN)}// Fallback for modularized imports:
/* ESM default export */const fY=/* unused pure expression or super */null&&fk;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/min.js
/**
 * The {@link min} function options.
 *//**
 * @name min
 * @category Common Helpers
 * @summary Returns the earliest of the given dates.
 *
 * @description
 * Returns the earliest of the given dates.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param dates - The dates to compare
 *
 * @returns The earliest of the dates
 *
 * @example
 * // Which of these dates is the earliest?
 * const result = min([
 *   new Date(1989, 6, 10),
 *   new Date(1987, 1, 11),
 *   new Date(1995, 6, 2),
 *   new Date(1990, 0, 1)
 * ])
 * //=> Wed Feb 11 1987 00:00:00
 */function fI(e,t){let r;let n=t?.in;e.forEach(e=>{// Use the first date object as the context function
if(!n&&typeof e==="object")n=uJ.bind(null,e);const t=u1(e,n);if(!r||r>t||isNaN(+t))r=t});return uJ(n,r||NaN)}// Fallback for modularized imports:
/* ESM default export */const fD=/* unused pure expression or super */null&&fI;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/getDaysInMonth.js
/**
 * The {@link getDaysInMonth} function options.
 *//**
 * @name getDaysInMonth
 * @category Month Helpers
 * @summary Get the number of days in a month of the given date.
 *
 * @description
 * Get the number of days in a month of the given date, considering the context if provided.
 *
 * @param date - The given date
 * @param options - An object with options
 *
 * @returns The number of days in a month
 *
 * @example
 * // How many days are in February 2000?
 * const result = getDaysInMonth(new Date(2000, 1))
 * //=> 29
 */function fC(e,t){const r=u1(e,t?.in);const n=r.getFullYear();const o=r.getMonth();const a=uJ(r,0);a.setFullYear(n,o+1,0);a.setHours(0,0,0,0);return a.getDate()}// Fallback for modularized imports:
/* ESM default export */const fS=/* unused pure expression or super */null&&fC;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/setMonth.js
/**
 * The {@link setMonth} function options.
 *//**
 * @name setMonth
 * @category Month Helpers
 * @summary Set the month to the given date.
 *
 * @description
 * Set the month to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The date to be changed
 * @param month - The month index to set (0-11)
 * @param options - The options
 *
 * @returns The new date with the month set
 *
 * @example
 * // Set February to 1 September 2014:
 * const result = setMonth(new Date(2014, 8, 1), 1)
 * //=> Sat Feb 01 2014 00:00:00
 */function fM(e,t,r){const n=u1(e,r?.in);const o=n.getFullYear();const a=n.getDate();const i=uJ(r?.in||e,0);i.setFullYear(o,t,15);i.setHours(0,0,0,0);const s=fC(i);// Set the earlier date, allows to wrap Jan 31 to Feb 28
n.setMonth(t,Math.min(a,s));return n}// Fallback for modularized imports:
/* ESM default export */const fE=/* unused pure expression or super */null&&fM;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/setYear.js
/**
 * The {@link setYear} function options.
 *//**
 * @name setYear
 * @category Year Helpers
 * @summary Set the year to the given date.
 *
 * @description
 * Set the year to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The date to be changed
 * @param year - The year of the new date
 * @param options - An object with options.
 *
 * @returns The new date with the year set
 *
 * @example
 * // Set year 2013 to 1 September 2014:
 * const result = setYear(new Date(2014, 8, 1), 2013)
 * //=> Sun Sep 01 2013 00:00:00
 */function fF(e,t,r){const n=u1(e,r?.in);// Check if date is Invalid Date because Date.prototype.setFullYear ignores the value of Invalid Date
if(isNaN(+n))return uJ(r?.in||e,NaN);n.setFullYear(t);return n}// Fallback for modularized imports:
/* ESM default export */const fH=/* unused pure expression or super */null&&fF;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/node_modules/date-fns/startOfMonth.js
/**
 * The {@link startOfMonth} function options.
 *//**
 * @name startOfMonth
 * @category Month Helpers
 * @summary Return the start of a month for the given date.
 *
 * @description
 * Return the start of a month for the given date. The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments.
 * Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed,
 * or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The start of a month
 *
 * @example
 * // The start of a month for 2 September 2014 11:55:00:
 * const result = startOfMonth(new Date(2014, 8, 2, 11, 55, 0))
 * //=> Mon Sep 01 2014 00:00:00
 */function fT(e,t){const r=u1(e,t?.in);r.setDate(1);r.setHours(0,0,0,0);return r}// Fallback for modularized imports:
/* ESM default export */const fO=/* unused pure expression or super */null&&fT;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getBroadcastWeeksInMonth.js
const fK=5;const fN=4;/**
 * Returns the number of weeks to display in the broadcast calendar for a given
 * month.
 *
 * The broadcast calendar may have either 4 or 5 weeks in a month, depending on
 * the start and end dates of the broadcast weeks.
 *
 * @since 9.4.0
 * @param month The month for which to calculate the number of weeks.
 * @param dateLib The date library to use for date manipulation.
 * @returns The number of weeks in the broadcast calendar (4 or 5).
 */function fP(e,t){// Get the first day of the month
const r=t.startOfMonth(e);// Get the day of the week for the first day of the month (1-7, where 1 is Monday)
const n=r.getDay()>0?r.getDay():7;const o=t.addDays(e,-n+1);const a=t.addDays(o,fK*7-1);const i=t.getMonth(e)===t.getMonth(a)?fK:fN;return i}//# sourceMappingURL=getBroadcastWeeksInMonth.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/startOfBroadcastWeek.js
/**
 * Returns the start date of the week in the broadcast calendar.
 *
 * The broadcast week starts on Monday. If the first day of the month is not a
 * Monday, this function calculates the previous Monday as the start of the
 * broadcast week.
 *
 * @since 9.4.0
 * @param date The date for which to calculate the start of the broadcast week.
 * @param dateLib The date library to use for date manipulation.
 * @returns The start date of the broadcast week.
 */function fL(e,t){const r=t.startOfMonth(e);const n=r.getDay();if(n===1){return r}else if(n===0){return t.addDays(r,-1*6)}else{return t.addDays(r,-1*(n-1))}}//# sourceMappingURL=startOfBroadcastWeek.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/endOfBroadcastWeek.js
/**
 * Returns the end date of the week in the broadcast calendar.
 *
 * The broadcast week ends on the last day of the last broadcast week for the
 * given date.
 *
 * @since 9.4.0
 * @param date The date for which to calculate the end of the broadcast week.
 * @param dateLib The date library to use for date manipulation.
 * @returns The end date of the broadcast week.
 */function fW(e,t){const r=fL(e,t);const n=fP(e,t);const o=t.addDays(r,n*7-1);return o}//# sourceMappingURL=endOfBroadcastWeek.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/classes/DateLib.js
/**
 * A wrapper class around [date-fns](http://date-fns.org) that provides utility
 * methods for date manipulation and formatting.
 *
 * @since 9.2.0
 * @example
 *   const dateLib = new DateLib({ locale: es });
 *   const newDate = dateLib.addDays(new Date(), 5);
 */class fB{/**
     * Creates an instance of `DateLib`.
     *
     * @param options Configuration options for the date library.
     * @param overrides Custom overrides for the date library functions.
     */constructor(e,t){/**
         * Reference to the built-in Date constructor.
         *
         * @deprecated Use `newDate()` or `today()`.
         */this.Date=Date;/**
         * Creates a new `Date` object representing today's date.
         *
         * @since 9.5.0
         * @returns A `Date` object for today's date.
         */this.today=()=>{if(this.overrides?.today){return this.overrides.today()}if(this.options.timeZone){return cX.tz(this.options.timeZone)}return new this.Date};/**
         * Creates a new `Date` object with the specified year, month, and day.
         *
         * @since 9.5.0
         * @param year The year.
         * @param monthIndex The month (0-11).
         * @param date The day of the month.
         * @returns A new `Date` object.
         */this.newDate=(e,t,r)=>{if(this.overrides?.newDate){return this.overrides.newDate(e,t,r)}if(this.options.timeZone){return new cX(e,t,r,this.options.timeZone)}return new Date(e,t,r)};/**
         * Adds the specified number of days to the given date.
         *
         * @param date The date to add days to.
         * @param amount The number of days to add.
         * @returns The new date with the days added.
         */this.addDays=(e,t)=>{return this.overrides?.addDays?this.overrides.addDays(e,t):u2(e,t)};/**
         * Adds the specified number of months to the given date.
         *
         * @param date The date to add months to.
         * @param amount The number of months to add.
         * @returns The new date with the months added.
         */this.addMonths=(e,t)=>{return this.overrides?.addMonths?this.overrides.addMonths(e,t):u3(e,t)};/**
         * Adds the specified number of weeks to the given date.
         *
         * @param date The date to add weeks to.
         * @param amount The number of weeks to add.
         * @returns The new date with the weeks added.
         */this.addWeeks=(e,t)=>{return this.overrides?.addWeeks?this.overrides.addWeeks(e,t):u8(e,t)};/**
         * Adds the specified number of years to the given date.
         *
         * @param date The date to add years to.
         * @param amount The number of years to add.
         * @returns The new date with the years added.
         */this.addYears=(e,t)=>{return this.overrides?.addYears?this.overrides.addYears(e,t):u9(e,t)};/**
         * Returns the number of calendar days between the given dates.
         *
         * @param dateLeft The later date.
         * @param dateRight The earlier date.
         * @returns The number of calendar days between the dates.
         */this.differenceInCalendarDays=(e,t)=>{return this.overrides?.differenceInCalendarDays?this.overrides.differenceInCalendarDays(e,t):di(e,t)};/**
         * Returns the number of calendar months between the given dates.
         *
         * @param dateLeft The later date.
         * @param dateRight The earlier date.
         * @returns The number of calendar months between the dates.
         */this.differenceInCalendarMonths=(e,t)=>{return this.overrides?.differenceInCalendarMonths?this.overrides.differenceInCalendarMonths(e,t):dl(e,t)};/**
         * Returns the months between the given dates.
         *
         * @param interval The interval to get the months for.
         */this.eachMonthOfInterval=e=>{return this.overrides?.eachMonthOfInterval?this.overrides.eachMonthOfInterval(e):dd(e)};/**
         * Returns the end of the broadcast week for the given date.
         *
         * @param date The original date.
         * @returns The end of the broadcast week.
         */this.endOfBroadcastWeek=e=>{return this.overrides?.endOfBroadcastWeek?this.overrides.endOfBroadcastWeek(e):fW(e,this)};/**
         * Returns the end of the ISO week for the given date.
         *
         * @param date The original date.
         * @returns The end of the ISO week.
         */this.endOfISOWeek=e=>{return this.overrides?.endOfISOWeek?this.overrides.endOfISOWeek(e):db(e)};/**
         * Returns the end of the month for the given date.
         *
         * @param date The original date.
         * @returns The end of the month.
         */this.endOfMonth=e=>{return this.overrides?.endOfMonth?this.overrides.endOfMonth(e):d_(e)};/**
         * Returns the end of the week for the given date.
         *
         * @param date The original date.
         * @returns The end of the week.
         */this.endOfWeek=(e,t)=>{return this.overrides?.endOfWeek?this.overrides.endOfWeek(e,t):dg(e,this.options)};/**
         * Returns the end of the year for the given date.
         *
         * @param date The original date.
         * @returns The end of the year.
         */this.endOfYear=e=>{return this.overrides?.endOfYear?this.overrides.endOfYear(e):dx(e)};/**
         * Formats the given date using the specified format string.
         *
         * @param date The date to format.
         * @param formatStr The format string.
         * @returns The formatted date string.
         */this.format=(e,t,r)=>{const n=this.overrides?.format?this.overrides.format(e,t,this.options):fs(e,t,this.options);if(this.options.numerals&&this.options.numerals!=="latn"){return this.replaceDigits(n)}return n};/**
         * Returns the ISO week number for the given date.
         *
         * @param date The date to get the ISO week number for.
         * @returns The ISO week number.
         */this.getISOWeek=e=>{return this.overrides?.getISOWeek?this.overrides.getISOWeek(e):dK(e)};/**
         * Returns the month of the given date.
         *
         * @param date The date to get the month for.
         * @returns The month.
         */this.getMonth=(e,t)=>{return this.overrides?.getMonth?this.overrides.getMonth(e,this.options):fu(e,this.options)};/**
         * Returns the year of the given date.
         *
         * @param date The date to get the year for.
         * @returns The year.
         */this.getYear=(e,t)=>{return this.overrides?.getYear?this.overrides.getYear(e,this.options):ff(e,this.options)};/**
         * Returns the local week number for the given date.
         *
         * @param date The date to get the week number for.
         * @returns The week number.
         */this.getWeek=(e,t)=>{return this.overrides?.getWeek?this.overrides.getWeek(e,this.options):dR(e,this.options)};/**
         * Checks if the first date is after the second date.
         *
         * @param date The date to compare.
         * @param dateToCompare The date to compare with.
         * @returns True if the first date is after the second date.
         */this.isAfter=(e,t)=>{return this.overrides?.isAfter?this.overrides.isAfter(e,t):fh(e,t)};/**
         * Checks if the first date is before the second date.
         *
         * @param date The date to compare.
         * @param dateToCompare The date to compare with.
         * @returns True if the first date is before the second date.
         */this.isBefore=(e,t)=>{return this.overrides?.isBefore?this.overrides.isBefore(e,t):fg(e,t)};/**
         * Checks if the given value is a Date object.
         *
         * @param value The value to check.
         * @returns True if the value is a Date object.
         */this.isDate=e=>{return this.overrides?.isDate?this.overrides.isDate(e):d7(e)};/**
         * Checks if the given dates are on the same day.
         *
         * @param dateLeft The first date to compare.
         * @param dateRight The second date to compare.
         * @returns True if the dates are on the same day.
         */this.isSameDay=(e,t)=>{return this.overrides?.isSameDay?this.overrides.isSameDay(e,t):fb(e,t)};/**
         * Checks if the given dates are in the same month.
         *
         * @param dateLeft The first date to compare.
         * @param dateRight The second date to compare.
         * @returns True if the dates are in the same month.
         */this.isSameMonth=(e,t)=>{return this.overrides?.isSameMonth?this.overrides.isSameMonth(e,t):f_(e,t)};/**
         * Checks if the given dates are in the same year.
         *
         * @param dateLeft The first date to compare.
         * @param dateRight The second date to compare.
         * @returns True if the dates are in the same year.
         */this.isSameYear=(e,t)=>{return this.overrides?.isSameYear?this.overrides.isSameYear(e,t):fx(e,t)};/**
         * Returns the latest date in the given array of dates.
         *
         * @param dates The array of dates to compare.
         * @returns The latest date.
         */this.max=e=>{return this.overrides?.max?this.overrides.max(e):fk(e)};/**
         * Returns the earliest date in the given array of dates.
         *
         * @param dates The array of dates to compare.
         * @returns The earliest date.
         */this.min=e=>{return this.overrides?.min?this.overrides.min(e):fI(e)};/**
         * Sets the month of the given date.
         *
         * @param date The date to set the month on.
         * @param month The month to set (0-11).
         * @returns The new date with the month set.
         */this.setMonth=(e,t)=>{return this.overrides?.setMonth?this.overrides.setMonth(e,t):fM(e,t)};/**
         * Sets the year of the given date.
         *
         * @param date The date to set the year on.
         * @param year The year to set.
         * @returns The new date with the year set.
         */this.setYear=(e,t)=>{return this.overrides?.setYear?this.overrides.setYear(e,t):fF(e,t)};/**
         * Returns the start of the broadcast week for the given date.
         *
         * @param date The original date.
         * @returns The start of the broadcast week.
         */this.startOfBroadcastWeek=(e,t)=>{return this.overrides?.startOfBroadcastWeek?this.overrides.startOfBroadcastWeek(e,this):fL(e,this)};/**
         * Returns the start of the day for the given date.
         *
         * @param date The original date.
         * @returns The start of the day.
         */this.startOfDay=e=>{return this.overrides?.startOfDay?this.overrides.startOfDay(e):dn(e)};/**
         * Returns the start of the ISO week for the given date.
         *
         * @param date The original date.
         * @returns The start of the ISO week.
         */this.startOfISOWeek=e=>{return this.overrides?.startOfISOWeek?this.overrides.startOfISOWeek(e):dM(e)};/**
         * Returns the start of the month for the given date.
         *
         * @param date The original date.
         * @returns The start of the month.
         */this.startOfMonth=e=>{return this.overrides?.startOfMonth?this.overrides.startOfMonth(e):fT(e)};/**
         * Returns the start of the week for the given date.
         *
         * @param date The original date.
         * @returns The start of the week.
         */this.startOfWeek=(e,t)=>{return this.overrides?.startOfWeek?this.overrides.startOfWeek(e,this.options):dC(e,this.options)};/**
         * Returns the start of the year for the given date.
         *
         * @param date The original date.
         * @returns The start of the year.
         */this.startOfYear=e=>{return this.overrides?.startOfYear?this.overrides.startOfYear(e):dk(e)};this.options={locale:uD,...e};this.overrides=t}/**
     * Generates a mapping of Arabic digits (0-9) to the target numbering system
     * digits.
     *
     * @since 9.5.0
     * @returns A record mapping Arabic digits to the target numerals.
     */getDigitMap(){const{numerals:e="latn"}=this.options;// Use Intl.NumberFormat to create a formatter with the specified numbering system
const t=new Intl.NumberFormat("en-US",{numberingSystem:e});// Map Arabic digits (0-9) to the target numerals
const r={};for(let e=0;e<10;e++){r[e.toString()]=t.format(e)}return r}/**
     * Replaces Arabic digits in a string with the target numbering system digits.
     *
     * @since 9.5.0
     * @param input The string containing Arabic digits.
     * @returns The string with digits replaced.
     */replaceDigits(e){const t=this.getDigitMap();return e.replace(/\d/g,e=>t[e]||e)}/**
     * Formats a number using the configured numbering system.
     *
     * @since 9.5.0
     * @param value The number to format.
     * @returns The formatted number as a string.
     */formatNumber(e){return this.replaceDigits(e.toString())}}/** The default locale (English). *//**
 * The default date library with English locale.
 *
 * @since 9.2.0
 */const fR=new fB;/**
 * @ignore
 * @deprecated Use `defaultDateLib`.
 */const fz=/* unused pure expression or super */null&&fR;//# sourceMappingURL=DateLib.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/utils/rangeIncludesDate.js
/**
 * Checks if a given date is within a specified date range.
 *
 * @since 9.0.0
 * @param range - The date range to check against.
 * @param date - The date to check.
 * @param excludeEnds - If `true`, the range's start and end dates are excluded.
 * @param dateLib - The date utility library instance.
 * @returns `true` if the date is within the range, otherwise `false`.
 * @group Utilities
 */function fV(e,t,r=false,n=fR){let{from:o,to:a}=e;const{differenceInCalendarDays:i,isSameDay:s}=n;if(o&&a){const e=i(a,o)<0;if(e){[o,a]=[a,o]}const n=i(t,o)>=(r?1:0)&&i(a,t)>=(r?1:0);return n}if(!r&&a){return s(a,t)}if(!r&&o){return s(o,t)}return false}/**
 * @private
 * @deprecated Use {@link rangeIncludesDate} instead.
 */const fj=(e,t)=>fV(e,t,false,defaultDateLib);//# sourceMappingURL=rangeIncludesDate.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/utils/typeguards.js
/**
 * Checks if the given value is of type {@link DateInterval}.
 *
 * @param matcher - The value to check.
 * @returns `true` if the value is a {@link DateInterval}, otherwise `false`.
 * @group Utilities
 */function fq(e){return Boolean(e&&typeof e==="object"&&"before"in e&&"after"in e)}/**
 * Checks if the given value is of type {@link DateRange}.
 *
 * @param value - The value to check.
 * @returns `true` if the value is a {@link DateRange}, otherwise `false`.
 * @group Utilities
 */function fU(e){return Boolean(e&&typeof e==="object"&&"from"in e)}/**
 * Checks if the given value is of type {@link DateAfter}.
 *
 * @param value - The value to check.
 * @returns `true` if the value is a {@link DateAfter}, otherwise `false`.
 * @group Utilities
 */function fG(e){return Boolean(e&&typeof e==="object"&&"after"in e)}/**
 * Checks if the given value is of type {@link DateBefore}.
 *
 * @param value - The value to check.
 * @returns `true` if the value is a {@link DateBefore}, otherwise `false`.
 * @group Utilities
 */function fQ(e){return Boolean(e&&typeof e==="object"&&"before"in e)}/**
 * Checks if the given value is of type {@link DayOfWeek}.
 *
 * @param value - The value to check.
 * @returns `true` if the value is a {@link DayOfWeek}, otherwise `false`.
 * @group Utilities
 */function fX(e){return Boolean(e&&typeof e==="object"&&"dayOfWeek"in e)}/**
 * Checks if the given value is an array of valid dates.
 *
 * @private
 * @param value - The value to check.
 * @param dateLib - The date utility library instance.
 * @returns `true` if the value is an array of valid dates, otherwise `false`.
 */function f$(e,t){return Array.isArray(e)&&e.every(t.isDate)}//# sourceMappingURL=typeguards.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/utils/dateMatchModifiers.js
/**
 * Checks if a given date matches at least one of the specified {@link Matcher}.
 *
 * @param date - The date to check.
 * @param matchers - The matchers to check against.
 * @param dateLib - The date utility library instance.
 * @returns `true` if the date matches any of the matchers, otherwise `false`.
 * @group Utilities
 */function fZ(e,t,r=fR){const n=!Array.isArray(t)?[t]:t;const{isSameDay:o,differenceInCalendarDays:a,isAfter:i}=r;return n.some(t=>{if(typeof t==="boolean"){return t}if(r.isDate(t)){return o(e,t)}if(f$(t,r)){return t.includes(e)}if(fU(t)){return fV(t,e,false,r)}if(fX(t)){if(!Array.isArray(t.dayOfWeek)){return t.dayOfWeek===e.getDay()}return t.dayOfWeek.includes(e.getDay())}if(fq(t)){const r=a(t.before,e);const n=a(t.after,e);const o=r>0;const s=n<0;const l=i(t.before,t.after);if(l){return s&&o}else{return o||s}}if(fG(t)){return a(e,t.after)>0}if(fQ(t)){return a(t.before,e)>0}if(typeof t==="function"){return t(e)}return false})}/**
 * @private
 * @deprecated Use {@link dateMatchModifiers} instead.
 */const fJ=/* unused pure expression or super */null&&fZ;//# sourceMappingURL=dateMatchModifiers.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/createGetModifiers.js
/**
 * Creates a function to retrieve the modifiers for a given day.
 *
 * This function calculates both internal and custom modifiers for each day
 * based on the provided calendar days and DayPicker props.
 *
 * @private
 * @param days The array of `CalendarDay` objects to process.
 * @param props The DayPicker props, including modifiers and configuration
 *   options.
 * @param dateLib The date library to use for date manipulation.
 * @returns A function that retrieves the modifiers for a given `CalendarDay`.
 */function f0(e,t,r,n,o){const{disabled:a,hidden:i,modifiers:s,showOutsideDays:l,broadcastCalendar:c,today:u}=t;const{isSameDay:d,isSameMonth:f,startOfMonth:p,isBefore:h,endOfMonth:v,isAfter:g}=o;const m=r&&p(r);const b=n&&v(n);const y={[cJ.focused]:[],[cJ.outside]:[],[cJ.disabled]:[],[cJ.hidden]:[],[cJ.today]:[]};const _={};for(const t of e){const{date:e,displayMonth:r}=t;const n=Boolean(r&&!f(e,r));const p=Boolean(m&&h(e,m));const v=Boolean(b&&g(e,b));const w=Boolean(a&&fZ(e,a,o));const x=Boolean(i&&fZ(e,i,o))||p||v||// Broadcast calendar will show outside days as default
!c&&!l&&n||c&&l===false&&n;const A=d(e,u??o.today());if(n)y.outside.push(t);if(w)y.disabled.push(t);if(x)y.hidden.push(t);if(A)y.today.push(t);// Add custom modifiers
if(s){Object.keys(s).forEach(r=>{const n=s?.[r];const a=n?fZ(e,n,o):false;if(!a)return;if(_[r]){_[r].push(t)}else{_[r]=[t]}})}}return e=>{// Initialize all the modifiers to false
const t={[cJ.focused]:false,[cJ.disabled]:false,[cJ.hidden]:false,[cJ.outside]:false,[cJ.today]:false};const r={};// Find the modifiers for the given day
for(const r in y){const n=y[r];t[r]=n.some(t=>t===e)}for(const t in _){r[t]=_[t].some(t=>t===e)}return{...t,// custom modifiers should override all the previous ones
...r}}}//# sourceMappingURL=createGetModifiers.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getClassNamesForModifiers.js
/**
 * Returns the class names for a day based on its modifiers.
 *
 * This function combines the base class name for the day with any class names
 * associated with active modifiers.
 *
 * @param modifiers The modifiers applied to the day.
 * @param classNames The base class names for the calendar elements.
 * @param modifiersClassNames The class names associated with specific
 *   modifiers.
 * @returns An array of class names for the day.
 */function f1(e,t,r={}){const n=Object.entries(e).filter(([,e])=>e===true).reduce((e,[n])=>{if(r[n]){e.push(r[n])}else if(t[cJ[n]]){e.push(t[cJ[n]])}else if(t[c0[n]]){e.push(t[c0[n]])}return e},[t[cZ.Day]]);return n}//# sourceMappingURL=getClassNamesForModifiers.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Button.js
/**
 * Render the button elements in the calendar.
 *
 * @private
 * @deprecated Use `PreviousMonthButton` or `@link NextMonthButton` instead.
 */function f6(e){return v.createElement("button",{...e})}//# sourceMappingURL=Button.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/CaptionLabel.js
/**
 * Render the label in the month caption.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function f2(e){return v.createElement("span",{...e})}//# sourceMappingURL=CaptionLabel.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Chevron.js
/**
 * Render the chevron icon used in the navigation buttons and dropdowns.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function f4(e){const{size:t=24,orientation:r="left",className:n}=e;return v.createElement("svg",{className:n,width:t,height:t,viewBox:"0 0 24 24"},r==="up"&&v.createElement("polygon",{points:"6.77 17 12.5 11.43 18.24 17 20 15.28 12.5 8 5 15.28"}),r==="down"&&v.createElement("polygon",{points:"6.77 8 12.5 13.57 18.24 8 20 9.72 12.5 17 5 9.72"}),r==="left"&&v.createElement("polygon",{points:"16 18.112 9.81111111 12 16 5.87733333 14.0888889 4 6 12 14.0888889 20"}),r==="right"&&v.createElement("polygon",{points:"8 18.112 14.18888889 12 8 5.87733333 9.91111111 4 18 12 9.91111111 20"}))}//# sourceMappingURL=Chevron.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Day.js
/**
 * Render a grid cell for a specific day in the calendar.
 *
 * Handles interaction and focus for the day. If you only need to change the
 * content of the day cell, consider swapping the `DayButton` component
 * instead.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function f3(e){const{day:t,modifiers:r,...n}=e;return v.createElement("td",{...n})}//# sourceMappingURL=Day.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/DayButton.js
/**
 * Render a button for a specific day in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function f5(e){const{day:t,modifiers:r,...n}=e;const o=v.useRef(null);v.useEffect(()=>{if(r.focused)o.current?.focus()},[r.focused]);return v.createElement("button",{ref:o,...n})}//# sourceMappingURL=DayButton.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Dropdown.js
/**
 * Render a dropdown component for navigation in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function f8(e){const{options:t,className:r,components:n,classNames:o,...a}=e;const i=[o[cZ.Dropdown],r].join(" ");const s=t?.find(({value:e})=>e===a.value);return v.createElement("span",{"data-disabled":a.disabled,className:o[cZ.DropdownRoot]},v.createElement(n.Select,{className:i,...a},t?.map(({value:e,label:t,disabled:r})=>v.createElement(n.Option,{key:e,value:e,disabled:r},t))),v.createElement("span",{className:o[cZ.CaptionLabel],"aria-hidden":true},s?.label,v.createElement(n.Chevron,{orientation:"down",size:18,className:o[cZ.Chevron]})))}//# sourceMappingURL=Dropdown.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/DropdownNav.js
/**
 * Render the navigation dropdowns for the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function f7(e){return v.createElement("div",{...e})}//# sourceMappingURL=DropdownNav.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Footer.js
/**
 * Render the footer of the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function f9(e){return v.createElement("div",{...e})}//# sourceMappingURL=Footer.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Month.js
/**
 * Render the grid with the weekday header row and the weeks for a specific
 * month.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pe(e){const{calendarMonth:t,displayIndex:r,...n}=e;return v.createElement("div",{...n},e.children)}//# sourceMappingURL=Month.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/MonthCaption.js
/**
 * Render the caption for a month in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pt(e){const{calendarMonth:t,displayIndex:r,...n}=e;return v.createElement("div",{...n})}//# sourceMappingURL=MonthCaption.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/MonthGrid.js
/**
 * Render the grid of days for a specific month.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pr(e){return v.createElement("table",{...e})}//# sourceMappingURL=MonthGrid.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Months.js
/**
 * Render a container wrapping the month grids.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pn(e){return v.createElement("div",{...e})}//# sourceMappingURL=Months.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/useDayPicker.js
/** @ignore */const po=(0,v.createContext)(undefined);/**
 * Provides access to the DayPicker context, which includes properties and
 * methods to interact with the DayPicker component. This hook must be used
 * within a custom component.
 *
 * @template T - Use this type to refine the returned context type with a
 *   specific selection mode.
 * @returns The context to work with DayPicker.
 * @throws {Error} If the hook is used outside of a DayPicker provider.
 * @group Hooks
 * @see https://daypicker.dev/guides/custom-components
 */function pa(){const e=(0,v.useContext)(po);if(e===undefined){throw new Error("useDayPicker() must be used within a custom component.")}return e}//# sourceMappingURL=useDayPicker.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/MonthsDropdown.js
/**
 * Render a dropdown to navigate between months in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pi(e){const{components:t}=pa();return v.createElement(t.Dropdown,{...e})}//# sourceMappingURL=MonthsDropdown.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Nav.js
/**
 * Render the navigation toolbar with buttons to navigate between months.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function ps(e){const{onPreviousClick:t,onNextClick:r,previousMonth:n,nextMonth:o,...a}=e;const{components:i,classNames:s,labels:{labelPrevious:l,labelNext:c}}=pa();const u=(0,v.useCallback)(e=>{if(o){r?.(e)}},[o,r]);const d=(0,v.useCallback)(e=>{if(n){t?.(e)}},[n,t]);return v.createElement("nav",{...a},v.createElement(i.PreviousMonthButton,{type:"button",className:s[cZ.PreviousMonthButton],tabIndex:n?undefined:-1,"aria-disabled":n?undefined:true,"aria-label":l(n),onClick:d},v.createElement(i.Chevron,{disabled:n?undefined:true,className:s[cZ.Chevron],orientation:"left"})),v.createElement(i.NextMonthButton,{type:"button",className:s[cZ.NextMonthButton],tabIndex:o?undefined:-1,"aria-disabled":o?undefined:true,"aria-label":c(o),onClick:u},v.createElement(i.Chevron,{disabled:o?undefined:true,orientation:"right",className:s[cZ.Chevron]})))}//# sourceMappingURL=Nav.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/NextMonthButton.js
/**
 * Render the button to navigate to the next month in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pl(e){const{components:t}=pa();return v.createElement(t.Button,{...e})}//# sourceMappingURL=NextMonthButton.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Option.js
/**
 * Render an `option` element.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pc(e){return v.createElement("option",{...e})}//# sourceMappingURL=Option.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/PreviousMonthButton.js
/**
 * Render the button to navigate to the previous month in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pu(e){const{components:t}=pa();return v.createElement(t.Button,{...e})}//# sourceMappingURL=PreviousMonthButton.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Root.js
/**
 * Render the root element of the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pd(e){const{rootRef:t,...r}=e;return v.createElement("div",{...r,ref:t})}//# sourceMappingURL=Root.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Select.js
/**
 * Render a `select` element.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pf(e){return v.createElement("select",{...e})}//# sourceMappingURL=Select.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Week.js
/**
 * Render a table row representing a week in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pp(e){const{week:t,...r}=e;return v.createElement("tr",{...r})}//# sourceMappingURL=Week.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Weekday.js
/**
 * Render a table header cell with the name of a weekday (e.g., "Mo", "Tu").
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function ph(e){return v.createElement("th",{...e})}//# sourceMappingURL=Weekday.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Weekdays.js
/**
 * Render the table row containing the weekday names.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pv(e){return v.createElement("thead",{"aria-hidden":true},v.createElement("tr",{...e}))}//# sourceMappingURL=Weekdays.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/WeekNumber.js
/**
 * Render a table cell displaying the number of the week.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pg(e){const{week:t,...r}=e;return v.createElement("th",{...r})}//# sourceMappingURL=WeekNumber.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/WeekNumberHeader.js
/**
 * Render the header cell for the week numbers column.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pm(e){return v.createElement("th",{...e})}//# sourceMappingURL=WeekNumberHeader.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/Weeks.js
/**
 * Render the container for the weeks in the month grid.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function pb(e){return v.createElement("tbody",{...e})}//# sourceMappingURL=Weeks.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/YearsDropdown.js
/**
 * Render a dropdown to navigate between years in the calendar.
 *
 * @group Components
 * @see https://daypicker.dev/guides/custom-components
 */function py(e){const{components:t}=pa();return v.createElement(t.Dropdown,{...e})}//# sourceMappingURL=YearsDropdown.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/components/custom-components.js
//# sourceMappingURL=custom-components.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getComponents.js
/**
 * Merges custom components from the props with the default components.
 *
 * This function ensures that any custom components provided in the props
 * override the default components.
 *
 * @param customComponents The custom components provided in the DayPicker
 *   props.
 * @returns An object containing the merged components.
 */function p_(e){return{...n,...e}}//# sourceMappingURL=getComponents.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getDataAttributes.js
/**
 * Extracts `data-` attributes from the DayPicker props.
 *
 * This function collects all `data-` attributes from the props and adds
 * additional attributes based on the DayPicker configuration.
 *
 * @param props The DayPicker props.
 * @returns An object containing the `data-` attributes.
 */function pw(e){const t={"data-mode":e.mode??undefined,"data-required":"required"in e?e.required:undefined,"data-multiple-months":e.numberOfMonths&&e.numberOfMonths>1||undefined,"data-week-numbers":e.showWeekNumber||undefined,"data-broadcast-calendar":e.broadcastCalendar||undefined,"data-nav-layout":e.navLayout||undefined};Object.entries(e).forEach(([e,r])=>{if(e.startsWith("data-")){t[e]=r}});return t}//# sourceMappingURL=getDataAttributes.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getDefaultClassNames.js
/**
 * Returns the default class names for the UI elements.
 *
 * This function generates a mapping of default class names for various UI
 * elements, day flags, selection states, and animations.
 *
 * @returns An object containing the default class names.
 * @group Utilities
 */function px(){const e={};for(const t in cZ){e[cZ[t]]=`rdp-${cZ[t]}`}for(const t in cJ){e[cJ[t]]=`rdp-${cJ[t]}`}for(const t in c0){e[c0[t]]=`rdp-${c0[t]}`}for(const t in c1){e[c1[t]]=`rdp-${c1[t]}`}return e}//# sourceMappingURL=getDefaultClassNames.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/formatCaption.js
/**
 * Formats the caption of the month.
 *
 * @defaultValue `LLLL y` (e.g., "November 2022").
 * @param month The date representing the month.
 * @param options Configuration options for the date library.
 * @param dateLib The date library to use for formatting. If not provided, a new
 *   instance is created.
 * @returns The formatted caption as a string.
 * @group Formatters
 * @see https://daypicker.dev/docs/translation#custom-formatters
 */function pA(e,t,r){return(r??new fB(t)).format(e,"LLLL y")}/**
 * @private
 * @deprecated Use {@link formatCaption} instead.
 * @group Formatters
 */const pk=pA;//# sourceMappingURL=formatCaption.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/formatDay.js
/**
 * Formats the day date shown in the day cell.
 *
 * @defaultValue `d` (e.g., "1").
 * @param date The date to format.
 * @param options Configuration options for the date library.
 * @param dateLib The date library to use for formatting. If not provided, a new
 *   instance is created.
 * @returns The formatted day as a string.
 * @group Formatters
 * @see https://daypicker.dev/docs/translation#custom-formatters
 */function pY(e,t,r){return(r??new fB(t)).format(e,"d")}//# sourceMappingURL=formatDay.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/formatMonthDropdown.js
/**
 * Formats the month for the dropdown option label.
 *
 * @defaultValue The localized full month name.
 * @param month The date representing the month.
 * @param dateLib The date library to use for formatting. Defaults to
 *   `defaultDateLib`.
 * @returns The formatted month name as a string.
 * @group Formatters
 * @see https://daypicker.dev/docs/translation#custom-formatters
 */function pI(e,t=fR){return t.format(e,"LLLL")}//# sourceMappingURL=formatMonthDropdown.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/formatWeekNumber.js
/**
 * Formats the week number.
 *
 * @defaultValue The week number as a string, with a leading zero for single-digit numbers.
 * @param weekNumber The week number to format.
 * @param dateLib The date library to use for formatting. Defaults to
 *   `defaultDateLib`.
 * @returns The formatted week number as a string.
 * @group Formatters
 * @see https://daypicker.dev/docs/translation#custom-formatters
 */function pD(e,t=fR){if(e<10){return t.formatNumber(`0${e.toLocaleString()}`)}return t.formatNumber(`${e.toLocaleString()}`)}//# sourceMappingURL=formatWeekNumber.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/formatWeekNumberHeader.js
/**
 * Formats the header for the week number column.
 *
 * @defaultValue An empty string `""`.
 * @returns The formatted week number header as a string.
 * @group Formatters
 * @see https://daypicker.dev/docs/translation#custom-formatters
 */function pC(){return``}//# sourceMappingURL=formatWeekNumberHeader.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/formatWeekdayName.js
/**
 * Formats the name of a weekday to be displayed in the weekdays header.
 *
 * @defaultValue `cccccc` (e.g., "Mo" for Monday).
 * @param weekday The date representing the weekday.
 * @param options Configuration options for the date library.
 * @param dateLib The date library to use for formatting. If not provided, a new
 *   instance is created.
 * @returns The formatted weekday name as a string.
 * @group Formatters
 * @see https://daypicker.dev/docs/translation#custom-formatters
 */function pS(e,t,r){return(r??new fB(t)).format(e,"cccccc")}//# sourceMappingURL=formatWeekdayName.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/formatYearDropdown.js
/**
 * Formats the year for the dropdown option label.
 *
 * @param year The year to format.
 * @param dateLib The date library to use for formatting. Defaults to
 *   `defaultDateLib`.
 * @returns The formatted year as a string.
 * @group Formatters
 * @see https://daypicker.dev/docs/translation#custom-formatters
 */function pM(e,t=fR){return t.format(e,"yyyy")}/**
 * @private
 * @deprecated Use `formatYearDropdown` instead.
 * @group Formatters
 */const pE=pM;//# sourceMappingURL=formatYearDropdown.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/formatters/index.js
//# sourceMappingURL=index.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getFormatters.js
/**
 * Merges custom formatters from the props with the default formatters.
 *
 * @param customFormatters The custom formatters provided in the DayPicker
 *   props.
 * @returns The merged formatters object.
 */function pF(e){if(e?.formatMonthCaption&&!e.formatCaption){e.formatCaption=e.formatMonthCaption}if(e?.formatYearCaption&&!e.formatYearDropdown){e.formatYearDropdown=e.formatYearCaption}return{...o,...e}}//# sourceMappingURL=getFormatters.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getMonthOptions.js
/**
 * Returns the months to show in the dropdown.
 *
 * This function generates a list of months for the current year, formatted
 * using the provided formatter, and determines whether each month should be
 * disabled based on the navigation range.
 *
 * @param displayMonth The currently displayed month.
 * @param navStart The start date for navigation.
 * @param navEnd The end date for navigation.
 * @param formatters The formatters to use for formatting the month labels.
 * @param dateLib The date library to use for date manipulation.
 * @returns An array of dropdown options representing the months, or `undefined`
 *   if no months are available.
 */function pH(e,t,r,n,o){const{startOfMonth:a,startOfYear:i,endOfYear:s,eachMonthOfInterval:l,getMonth:c}=o;const u=l({start:i(e),end:s(e)});const d=u.map(e=>{const i=n.formatMonthDropdown(e,o);const s=c(e);const l=t&&e<a(t)||r&&e>a(r)||false;return{value:s,label:i,disabled:l}});return d}//# sourceMappingURL=getMonthOptions.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getStyleForModifiers.js
/**
 * Returns the computed style for a day based on its modifiers.
 *
 * This function merges the base styles for the day with any styles associated
 * with active modifiers.
 *
 * @param dayModifiers The modifiers applied to the day.
 * @param styles The base styles for the calendar elements.
 * @param modifiersStyles The styles associated with specific modifiers.
 * @returns The computed style for the day.
 */function pT(e,t={},r={}){let n={...t?.[cZ.Day]};Object.entries(e).filter(([,e])=>e===true).forEach(([e])=>{n={...n,...r?.[e]}});return n}//# sourceMappingURL=getStyleForModifiers.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getWeekdays.js
/**
 * Generates a series of 7 days, starting from the beginning of the week, to use
 * for formatting weekday names (e.g., Monday, Tuesday, etc.).
 *
 * @param dateLib The date library to use for date manipulation.
 * @param ISOWeek Whether to use ISO week numbering (weeks start on Monday).
 * @param broadcastCalendar Whether to use the broadcast calendar (weeks start
 *   on Monday, but may include adjustments for broadcast-specific rules).
 * @returns An array of 7 dates representing the weekdays.
 */function pO(e,t,r){const n=e.today();const o=r?e.startOfBroadcastWeek(n,e):t?e.startOfISOWeek(n):e.startOfWeek(n);const a=[];for(let t=0;t<7;t++){const r=e.addDays(o,t);a.push(r)}return a}//# sourceMappingURL=getWeekdays.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getYearOptions.js
/**
 * Returns the years to display in the dropdown.
 *
 * This function generates a list of years between the navigation start and end
 * dates, formatted using the provided formatter.
 *
 * @param navStart The start date for navigation.
 * @param navEnd The end date for navigation.
 * @param formatters The formatters to use for formatting the year labels.
 * @param dateLib The date library to use for date manipulation.
 * @returns An array of dropdown options representing the years, or `undefined`
 *   if `navStart` or `navEnd` is not provided.
 */function pK(e,t,r,n){if(!e)return undefined;if(!t)return undefined;const{startOfYear:o,endOfYear:a,addYears:i,getYear:s,isBefore:l,isSameYear:c}=n;const u=o(e);const d=a(t);const f=[];let p=u;while(l(p,d)||c(p,d)){f.push(p);p=i(p,1)}return f.map(e=>{const t=r.formatYearDropdown(e,n);return{value:s(e),label:t,disabled:false}})}//# sourceMappingURL=getYearOptions.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelGrid.js
/**
 * Generates the ARIA label for the month grid, which is announced when entering
 * the grid.
 *
 * @defaultValue `LLLL y` (e.g., "November 2022").
 * @param date - The date representing the month.
 * @param options - Optional configuration for the date formatting library.
 * @param dateLib - An optional instance of the date formatting library.
 * @returns The ARIA label for the month grid.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pN(e,t,r){return(r??new fB(t)).format(e,"LLLL y")}/**
 * @ignore
 * @deprecated Use {@link labelGrid} instead.
 */const pP=pN;//# sourceMappingURL=labelGrid.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelGridcell.js
/**
 * Generates the label for a day grid cell when the calendar is not interactive.
 *
 * @param date - The date to format.
 * @param modifiers - Optional modifiers providing context for the day.
 * @param options - Optional configuration for the date formatting library.
 * @param dateLib - An optional instance of the date formatting library.
 * @returns The label for the day grid cell.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pL(e,t,r,n){let o=(n??new fB(r)).format(e,"PPPP");if(t?.today){o=`Today, ${o}`}return o}//# sourceMappingURL=labelGridcell.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelDayButton.js
/**
 * Generates the ARIA label for a day button.
 *
 * Use the `modifiers` argument to provide additional context for the label,
 * such as indicating if the day is "today" or "selected."
 *
 * @defaultValue The formatted date.
 * @param date - The date to format.
 * @param modifiers - The modifiers providing context for the day.
 * @param options - Optional configuration for the date formatting library.
 * @param dateLib - An optional instance of the date formatting library.
 * @returns The ARIA label for the day button.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pW(e,t,r,n){let o=(n??new fB(r)).format(e,"PPPP");if(t.today)o=`Today, ${o}`;if(t.selected)o=`${o}, selected`;return o}/**
 * @ignore
 * @deprecated Use `labelDayButton` instead.
 */const pB=pW;//# sourceMappingURL=labelDayButton.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelNav.js
/**
 * Generates the ARIA label for the navigation toolbar.
 *
 * @defaultValue `""`
 * @returns The ARIA label for the navigation toolbar.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pR(){return""}//# sourceMappingURL=labelNav.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelMonthDropdown.js
/**
 * Generates the ARIA label for the months dropdown.
 *
 * @defaultValue `"Choose the Month"`
 * @param options - Optional configuration for the date formatting library.
 * @returns The ARIA label for the months dropdown.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pz(e){return"Choose the Month"}//# sourceMappingURL=labelMonthDropdown.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelNext.js
/**
 * Generates the ARIA label for the "next month" button.
 *
 * @defaultValue `"Go to the Next Month"`
 * @param month - The date representing the next month, or `undefined` if there
 *   is no next month.
 * @returns The ARIA label for the "next month" button.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pV(e){return"Go to the Next Month"}//# sourceMappingURL=labelNext.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelPrevious.js
/**
 * Generates the ARIA label for the "previous month" button.
 *
 * @defaultValue `"Go to the Previous Month"`
 * @param month - The date representing the previous month, or `undefined` if
 *   there is no previous month.
 * @returns The ARIA label for the "previous month" button.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pj(e){return"Go to the Previous Month"}//# sourceMappingURL=labelPrevious.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelWeekday.js
/**
 * Generates the ARIA label for a weekday column header.
 *
 * @defaultValue `"Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"`
 * @param date - The date representing the weekday.
 * @param options - Optional configuration for the date formatting library.
 * @param dateLib - An optional instance of the date formatting library.
 * @returns The ARIA label for the weekday column header.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pq(e,t,r){return(r??new fB(t)).format(e,"cccc")}//# sourceMappingURL=labelWeekday.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelWeekNumber.js
/**
 * Generates the ARIA label for the week number cell (the first cell in a row).
 *
 * @defaultValue `Week ${weekNumber}`
 * @param weekNumber - The number of the week.
 * @param options - Optional configuration for the date formatting library.
 * @returns The ARIA label for the week number cell.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pU(e,t){return`Week ${e}`}//# sourceMappingURL=labelWeekNumber.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelWeekNumberHeader.js
/**
 * Generates the ARIA label for the week number header element.
 *
 * @defaultValue `"Week Number"`
 * @param options - Optional configuration for the date formatting library.
 * @returns The ARIA label for the week number header.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pG(e){return"Week Number"}//# sourceMappingURL=labelWeekNumberHeader.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/labelYearDropdown.js
/**
 * Generates the ARIA label for the years dropdown.
 *
 * @defaultValue `"Choose the Year"`
 * @param options - Optional configuration for the date formatting library.
 * @returns The ARIA label for the years dropdown.
 * @group Labels
 * @see https://daypicker.dev/docs/translation#aria-labels
 */function pQ(e){return"Choose the Year"}//# sourceMappingURL=labelYearDropdown.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/labels/index.js
//# sourceMappingURL=index.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/useAnimation.js
const pX=e=>{if(e instanceof HTMLElement)return e;return null};const p$=e=>[...e.querySelectorAll("[data-animated-month]")??[]];const pZ=e=>pX(e.querySelector("[data-animated-month]"));const pJ=e=>pX(e.querySelector("[data-animated-caption]"));const p0=e=>pX(e.querySelector("[data-animated-weeks]"));const p1=e=>pX(e.querySelector("[data-animated-nav]"));const p6=e=>pX(e.querySelector("[data-animated-weekdays]"));/**
 * Handles animations for transitioning between months in the DayPicker
 * component.
 *
 * @private
 * @param rootElRef - A reference to the root element of the DayPicker
 *   component.
 * @param enabled - Whether animations are enabled.
 * @param options - Configuration options for the animation, including class
 *   names, months, focused day, and the date utility library.
 */function p2(e,t,{classNames:r,months:n,focused:o,dateLib:a}){const i=(0,v.useRef)(null);const s=(0,v.useRef)(n);const l=(0,v.useRef)(false);(0,v.useLayoutEffect)(()=>{// get previous months before updating the previous months ref
const c=s.current;// update previous months ref for next effect trigger
s.current=n;if(!t||!e.current||// safety check because the ref can be set to anything by consumers
!(e.current instanceof HTMLElement)||// validation required for the animation to work as expected
n.length===0||c.length===0||n.length!==c.length){return}const u=a.isSameMonth(n[0].date,c[0].date);const d=a.isAfter(n[0].date,c[0].date);const f=d?r[c1.caption_after_enter]:r[c1.caption_before_enter];const p=d?r[c1.weeks_after_enter]:r[c1.weeks_before_enter];// get previous root element snapshot before updating the snapshot ref
const h=i.current;// update snapshot for next effect trigger
const v=e.current.cloneNode(true);if(v instanceof HTMLElement){// if this effect is triggered while animating, we need to clean up the new root snapshot
// to put it in the same state as when not animating, to correctly animate the next month change
const e=p$(v);e.forEach(e=>{if(!(e instanceof HTMLElement))return;// remove the old month snapshots from the new root snapshot
const t=pZ(e);if(t&&e.contains(t)){e.removeChild(t)}// remove animation classes from the new month snapshots
const r=pJ(e);if(r){r.classList.remove(f)}const n=p0(e);if(n){n.classList.remove(p)}});i.current=v}else{i.current=null}if(l.current||u||// skip animation if a day is focused because it can cause issues to the animation and is better for a11y
o){return}const g=h instanceof HTMLElement?p$(h):[];const m=p$(e.current);if(m&&m.every(e=>e instanceof HTMLElement)&&g&&g.every(e=>e instanceof HTMLElement)){l.current=true;const t=[];// set isolation to isolate to isolate the stacking context during animation
e.current.style.isolation="isolate";// set z-index to 1 to ensure the nav is clickable over the other elements being animated
const n=p1(e.current);if(n){n.style.zIndex="1"}m.forEach((o,a)=>{const i=g[a];if(!i){return}// animate new displayed month
o.style.position="relative";o.style.overflow="hidden";const s=pJ(o);if(s){s.classList.add(f)}const c=p0(o);if(c){c.classList.add(p)}// animate new displayed month end
const u=()=>{l.current=false;if(e.current){e.current.style.isolation=""}if(n){n.style.zIndex=""}if(s){s.classList.remove(f)}if(c){c.classList.remove(p)}o.style.position="";o.style.overflow="";if(o.contains(i)){o.removeChild(i)}};t.push(u);// animate old displayed month
i.style.pointerEvents="none";i.style.position="absolute";i.style.overflow="hidden";i.setAttribute("aria-hidden","true");// hide the weekdays container of the old month and only the new one
const h=p6(i);if(h){h.style.opacity="0"}const v=pJ(i);if(v){v.classList.add(d?r[c1.caption_before_exit]:r[c1.caption_after_exit]);v.addEventListener("animationend",u)}const m=p0(i);if(m){m.classList.add(d?r[c1.weeks_before_exit]:r[c1.weeks_after_exit])}o.insertBefore(i,o.firstChild)})}})}//# sourceMappingURL=useAnimation.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getDates.js
/**
 * Returns all the dates to display in the calendar.
 *
 * This function calculates the range of dates to display based on the provided
 * display months, constraints, and calendar configuration.
 *
 * @param displayMonths The months to display in the calendar.
 * @param maxDate The maximum date to include in the range.
 * @param props The DayPicker props, including calendar configuration options.
 * @param dateLib The date library to use for date manipulation.
 * @returns An array of dates to display in the calendar.
 */function p4(e,t,r,n){const o=e[0];const a=e[e.length-1];const{ISOWeek:i,fixedWeeks:s,broadcastCalendar:l}=r??{};const{addDays:c,differenceInCalendarDays:u,differenceInCalendarMonths:d,endOfBroadcastWeek:f,endOfISOWeek:p,endOfMonth:h,endOfWeek:v,isAfter:g,startOfBroadcastWeek:m,startOfISOWeek:b,startOfWeek:y}=n;const _=l?m(o,n):i?b(o):y(o);const w=l?f(a):i?p(h(a)):v(h(a));const x=u(w,_);const A=d(a,o)+1;const k=[];for(let e=0;e<=x;e++){const r=c(_,e);if(t&&g(r,t)){break}k.push(r)}// If fixed weeks is enabled, add the extra dates to the array
const Y=l?35:42;const I=Y*A;if(s&&k.length<I){const e=I-k.length;for(let t=0;t<e;t++){const e=c(k[k.length-1],1);k.push(e)}}return k}//# sourceMappingURL=getDates.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getDays.js
/**
 * Returns all the days belonging to the calendar by merging the days in the
 * weeks for each month.
 *
 * @param calendarMonths The array of calendar months.
 * @returns An array of `CalendarDay` objects representing all the days in the
 *   calendar.
 */function p3(e){const t=[];return e.reduce((e,r)=>{const n=r.weeks.reduce((e,t)=>{return[...e,...t.days]},t);return[...e,...n]},t)}//# sourceMappingURL=getDays.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getDisplayMonths.js
/**
 * Returns the months to display in the calendar.
 *
 * @param firstDisplayedMonth The first month currently displayed in the
 *   calendar.
 * @param calendarEndMonth The latest month the user can navigate to.
 * @param props The DayPicker props, including `numberOfMonths`.
 * @param dateLib The date library to use for date manipulation.
 * @returns An array of dates representing the months to display.
 */function p5(e,t,r,n){const{numberOfMonths:o=1}=r;const a=[];for(let r=0;r<o;r++){const o=n.addMonths(e,r);if(t&&o>t){break}a.push(o)}return a}//# sourceMappingURL=getDisplayMonths.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getInitialMonth.js
/**
 * Determines the initial month to display in the calendar based on the provided
 * props.
 *
 * This function calculates the starting month, considering constraints such as
 * `startMonth`, `endMonth`, and the number of months to display.
 *
 * @param props The DayPicker props, including navigation and date constraints.
 * @param dateLib The date library to use for date manipulation.
 * @returns The initial month to display.
 */function p8(e,t,r,n){const{month:o,defaultMonth:a,today:i=n.today(),numberOfMonths:s=1}=e;let l=o||a||i;const{differenceInCalendarMonths:c,addMonths:u,startOfMonth:d}=n;if(r&&c(r,l)<s-1){const e=-1*(s-1);l=u(r,e)}if(t&&c(l,t)<0){l=t}return d(l)}//# sourceMappingURL=getInitialMonth.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/classes/CalendarDay.js
/**
 * Represents a day displayed in the calendar.
 *
 * In DayPicker, a `CalendarDay` is a wrapper around a `Date` object that
 * provides additional information about the day, such as whether it belongs to
 * the displayed month.
 */class p7{constructor(e,t,r=fR){this.date=e;this.displayMonth=t;this.outside=Boolean(t&&!r.isSameMonth(e,t));this.dateLib=r}/**
     * Checks if this day is equal to another `CalendarDay`, considering both the
     * date and the displayed month.
     *
     * @param day The `CalendarDay` to compare with.
     * @returns `true` if the days are equal, otherwise `false`.
     */isEqualTo(e){return this.dateLib.isSameDay(e.date,this.date)&&this.dateLib.isSameMonth(e.displayMonth,this.displayMonth)}}//# sourceMappingURL=CalendarDay.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/classes/CalendarWeek.js
/**
 * Represents a week in a calendar month.
 *
 * A `CalendarWeek` contains the days within the week and the week number.
 */class p9{constructor(e,t){this.days=t;this.weekNumber=e}}//# sourceMappingURL=CalendarWeek.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/classes/CalendarMonth.js
/**
 * Represents a month in a calendar year.
 *
 * A `CalendarMonth` contains the weeks within the month and the date of the
 * month.
 */class he{constructor(e,t){this.date=e;this.weeks=t}}//# sourceMappingURL=CalendarMonth.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getMonths.js
/**
 * Returns the months to display in the calendar.
 *
 * This function generates `CalendarMonth` objects for each month to be
 * displayed, including their weeks and days, based on the provided display
 * months and dates.
 *
 * @param displayMonths The months (as dates) to display in the calendar.
 * @param dates The dates to display in the calendar.
 * @param props Options from the DayPicker props context.
 * @param dateLib The date library to use for date manipulation.
 * @returns An array of `CalendarMonth` objects representing the months to
 *   display.
 */function ht(e,t,r,n){const{addDays:o,endOfBroadcastWeek:a,endOfISOWeek:i,endOfMonth:s,endOfWeek:l,getISOWeek:c,getWeek:u,startOfBroadcastWeek:d,startOfISOWeek:f,startOfWeek:p}=n;const h=e.reduce((e,h)=>{const v=r.broadcastCalendar?d(h,n):r.ISOWeek?f(h):p(h);const g=r.broadcastCalendar?a(h):r.ISOWeek?i(s(h)):l(s(h));/** The dates to display in the month. */const m=t.filter(e=>{return e>=v&&e<=g});const b=r.broadcastCalendar?35:42;if(r.fixedWeeks&&m.length<b){const e=t.filter(e=>{const t=b-m.length;return e>g&&e<=o(g,t)});m.push(...e)}const y=m.reduce((e,t)=>{const o=r.ISOWeek?c(t):u(t);const a=e.find(e=>e.weekNumber===o);const i=new p7(t,h,n);if(!a){e.push(new p9(o,[i]))}else{a.days.push(i)}return e},[]);const _=new he(h,y);e.push(_);return e},[]);if(!r.reverseMonths){return h}else{return h.reverse()}}//# sourceMappingURL=getMonths.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getNavMonth.js
/**
 * Returns the start and end months for calendar navigation.
 *
 * @param props The DayPicker props, including navigation and layout options.
 * @param dateLib The date library to use for date manipulation.
 * @returns A tuple containing the start and end months for navigation.
 */function hr(e,t){let{startMonth:r,endMonth:n}=e;const{startOfYear:o,startOfDay:a,startOfMonth:i,endOfMonth:s,addYears:l,endOfYear:c,newDate:u,today:d}=t;// Handle deprecated code
const{fromYear:f,toYear:p,fromMonth:h,toMonth:v}=e;if(!r&&h){r=h}if(!r&&f){r=t.newDate(f,0,1)}if(!n&&v){n=v}if(!n&&p){n=u(p,11,31)}const g=e.captionLayout==="dropdown"||e.captionLayout==="dropdown-years";if(r){r=i(r)}else if(f){r=u(f,0,1)}else if(!r&&g){r=o(l(e.today??d(),-100))}if(n){n=s(n)}else if(p){n=u(p,11,31)}else if(!n&&g){n=c(e.today??d())}return[r?a(r):r,n?a(n):n]}//# sourceMappingURL=getNavMonth.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getNextMonth.js
/**
 * Returns the next month the user can navigate to, based on the given options.
 *
 * The next month is not always the next calendar month:
 *
 * - If it is after the `calendarEndMonth`, it returns `undefined`.
 * - If paged navigation is enabled, it skips forward by the number of displayed
 *   months.
 *
 * @param firstDisplayedMonth The first month currently displayed in the
 *   calendar.
 * @param calendarEndMonth The latest month the user can navigate to.
 * @param options Navigation options, including `numberOfMonths` and
 *   `pagedNavigation`.
 * @param dateLib The date library to use for date manipulation.
 * @returns The next month, or `undefined` if navigation is not possible.
 */function hn(e,t,r,n){if(r.disableNavigation){return undefined}const{pagedNavigation:o,numberOfMonths:a=1}=r;const{startOfMonth:i,addMonths:s,differenceInCalendarMonths:l}=n;const c=o?a:1;const u=i(e);if(!t){return s(u,c)}const d=l(t,e);if(d<a){return undefined}return s(u,c)}//# sourceMappingURL=getNextMonth.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getPreviousMonth.js
/**
 * Returns the previous month the user can navigate to, based on the given
 * options.
 *
 * The previous month is not always the previous calendar month:
 *
 * - If it is before the `calendarStartMonth`, it returns `undefined`.
 * - If paged navigation is enabled, it skips back by the number of displayed
 *   months.
 *
 * @param firstDisplayedMonth The first month currently displayed in the
 *   calendar.
 * @param calendarStartMonth The earliest month the user can navigate to.
 * @param options Navigation options, including `numberOfMonths` and
 *   `pagedNavigation`.
 * @param dateLib The date library to use for date manipulation.
 * @returns The previous month, or `undefined` if navigation is not possible.
 */function ho(e,t,r,n){if(r.disableNavigation){return undefined}const{pagedNavigation:o,numberOfMonths:a}=r;const{startOfMonth:i,addMonths:s,differenceInCalendarMonths:l}=n;const c=o?a??1:1;const u=i(e);if(!t){return s(u,-c)}const d=l(u,t);if(d<=0){return undefined}return s(u,-c)}//# sourceMappingURL=getPreviousMonth.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getWeeks.js
/**
 * Returns an array of calendar weeks from an array of calendar months.
 *
 * @param months The array of calendar months.
 * @returns An array of calendar weeks.
 */function ha(e){const t=[];return e.reduce((e,t)=>{return[...e,...t.weeks]},t)}//# sourceMappingURL=getWeeks.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/useControlledValue.js
/**
 * A custom hook for managing both controlled and uncontrolled component states.
 *
 * This hook allows a component to support both controlled and uncontrolled
 * states by determining whether the `controlledValue` is provided. If it is
 * undefined, the hook falls back to using the internal state.
 *
 * @example
 *   // Uncontrolled usage
 *   const [value, setValue] = useControlledValue(0, undefined);
 *
 *   // Controlled usage
 *   const [value, setValue] = useControlledValue(0, props.value);
 *
 * @template T - The type of the value.
 * @param defaultValue The initial value for the uncontrolled state.
 * @param controlledValue The value for the controlled state. If undefined, the
 *   component will use the uncontrolled state.
 * @returns A tuple where the first element is the current value (either
 *   controlled or uncontrolled) and the second element is a setter function to
 *   update the value.
 */function hi(e,t){const[r,n]=(0,v.useState)(e);const o=t===undefined?r:t;return[o,n]}//# sourceMappingURL=useControlledValue.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/useCalendar.js
/**
 * Provides the calendar object to work with the calendar in custom components.
 *
 * @private
 * @param props - The DayPicker props related to calendar configuration.
 * @param dateLib - The date utility library instance.
 * @returns The calendar object containing displayed days, weeks, months, and
 *   navigation methods.
 */function hs(e,t){const[r,n]=hr(e,t);const{startOfMonth:o,endOfMonth:a}=t;const i=p8(e,r,n,t);const[s,l]=hi(i,// initialMonth is always computed from props.month if provided
e.month?i:undefined);(0,v.useEffect)(()=>{const o=p8(e,r,n,t);l(o);// eslint-disable-next-line react-hooks/exhaustive-deps
},[e.timeZone]);/** The months displayed in the calendar. */const c=p5(s,n,e,t);/** The dates displayed in the calendar. */const u=p4(c,e.endMonth?a(e.endMonth):undefined,e,t);/** The Months displayed in the calendar. */const d=ht(c,u,e,t);/** The Weeks displayed in the calendar. */const f=ha(d);/** The Days displayed in the calendar. */const p=p3(d);const h=ho(s,r,e,t);const g=hn(s,n,e,t);const{disableNavigation:m,onMonthChange:b}=e;const y=e=>f.some(t=>t.days.some(t=>t.isEqualTo(e)));const _=e=>{if(m){return}let t=o(e);// if month is before start, use the first month instead
if(r&&t<o(r)){t=o(r)}// if month is after endMonth, use the last month instead
if(n&&t>o(n)){t=o(n)}l(t);b?.(t)};const w=e=>{// is this check necessary?
if(y(e)){return}_(e.date)};const x={months:d,weeks:f,days:p,navStart:r,navEnd:n,previousMonth:h,nextMonth:g,goToMonth:_,goToDay:w};return x}//# sourceMappingURL=useCalendar.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/calculateFocusTarget.js
var hl;(function(e){e[e["Today"]=0]="Today";e[e["Selected"]=1]="Selected";e[e["LastFocused"]=2]="LastFocused";e[e["FocusedModifier"]=3]="FocusedModifier"})(hl||(hl={}));/**
 * Determines if a day is focusable based on its modifiers.
 *
 * A day is considered focusable if it is not disabled, hidden, or outside the
 * displayed month.
 *
 * @param modifiers The modifiers applied to the day.
 * @returns `true` if the day is focusable, otherwise `false`.
 */function hc(e){return!e[cJ.disabled]&&!e[cJ.hidden]&&!e[cJ.outside]}/**
 * Calculates the focus target day based on priority.
 *
 * This function determines the day that should receive focus in the calendar,
 * prioritizing days with specific modifiers (e.g., "focused", "today") or
 * selection states.
 *
 * @param days The array of `CalendarDay` objects to evaluate.
 * @param getModifiers A function to retrieve the modifiers for a given day.
 * @param isSelected A function to determine if a day is selected.
 * @param lastFocused The last focused day, if any.
 * @returns The `CalendarDay` that should receive focus, or `undefined` if no
 *   focusable day is found.
 */function hu(e,t,r,n){let o;let a=-1;for(const i of e){const e=t(i);if(hc(e)){if(e[cJ.focused]&&a<hl.FocusedModifier){o=i;a=hl.FocusedModifier}else if(n?.isEqualTo(i)&&a<hl.LastFocused){o=i;a=hl.LastFocused}else if(r(i.date)&&a<hl.Selected){o=i;a=hl.Selected}else if(e[cJ.today]&&a<hl.Today){o=i;a=hl.Today}}}if(!o){// Return the first day that is focusable
o=e.find(e=>hc(t(e)))}return o}//# sourceMappingURL=calculateFocusTarget.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getFocusableDate.js
/**
 * Calculates the next date that should be focused in the calendar.
 *
 * This function determines the next focusable date based on the movement
 * direction, constraints, and calendar configuration.
 *
 * @param moveBy The unit of movement (e.g., "day", "week").
 * @param moveDir The direction of movement ("before" or "after").
 * @param refDate The reference date from which to calculate the next focusable
 *   date.
 * @param navStart The earliest date the user can navigate to.
 * @param navEnd The latest date the user can navigate to.
 * @param props The DayPicker props, including calendar configuration options.
 * @param dateLib The date library to use for date manipulation.
 * @returns The next focusable date.
 */function hd(e,t,r,n,o,a,i){const{ISOWeek:s,broadcastCalendar:l}=a;const{addDays:c,addMonths:u,addWeeks:d,addYears:f,endOfBroadcastWeek:p,endOfISOWeek:h,endOfWeek:v,max:g,min:m,startOfBroadcastWeek:b,startOfISOWeek:y,startOfWeek:_}=i;const w={day:c,week:d,month:u,year:f,startOfWeek:e=>l?b(e,i):s?y(e):_(e),endOfWeek:e=>l?p(e):s?h(e):v(e)};let x=w[e](r,t==="after"?1:-1);if(t==="before"&&n){x=g([n,x])}else if(t==="after"&&o){x=m([o,x])}return x}//# sourceMappingURL=getFocusableDate.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/helpers/getNextFocus.js
/**
 * Determines the next focusable day in the calendar.
 *
 * This function recursively calculates the next focusable day based on the
 * movement direction and modifiers applied to the days.
 *
 * @param moveBy The unit of movement (e.g., "day", "week").
 * @param moveDir The direction of movement ("before" or "after").
 * @param refDay The currently focused day.
 * @param calendarStartMonth The earliest month the user can navigate to.
 * @param calendarEndMonth The latest month the user can navigate to.
 * @param props The DayPicker props, including modifiers and configuration
 *   options.
 * @param dateLib The date library to use for date manipulation.
 * @param attempt The current recursion attempt (used to limit recursion depth).
 * @returns The next focusable day, or `undefined` if no focusable day is found.
 */function hf(e,t,r,n,o,a,i,s=0){if(s>365){// Limit the recursion to 365 attempts
return undefined}const l=hd(e,t,r.date,n,o,a,i);const c=Boolean(a.disabled&&fZ(l,a.disabled,i));const u=Boolean(a.hidden&&fZ(l,a.hidden,i));const d=l;const f=new p7(l,d,i);if(!c&&!u){return f}// Recursively attempt to find the next focusable date
return hf(e,t,f,n,o,a,i,s+1)}//# sourceMappingURL=getNextFocus.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/useFocus.js
/**
 * Manages focus behavior for the DayPicker component, including setting,
 * moving, and blurring focus on calendar days.
 *
 * @template T - The type of DayPicker props.
 * @param props - The DayPicker props.
 * @param calendar - The calendar object containing the displayed days and
 *   months.
 * @param getModifiers - A function to retrieve modifiers for a given day.
 * @param isSelected - A function to check if a date is selected.
 * @param dateLib - The date utility library instance.
 * @returns An object containing focus-related methods and the currently focused
 *   day.
 */function hp(e,t,r,n,o){const{autoFocus:a}=e;const[i,s]=(0,v.useState)();const l=hu(t.days,r,n||(()=>false),i);const[c,u]=(0,v.useState)(a?l:undefined);const d=()=>{s(c);u(undefined)};const f=(r,n)=>{if(!c)return;const a=hf(r,n,c,t.navStart,t.navEnd,e,o);if(!a)return;t.goToDay(a);u(a)};const p=e=>{return Boolean(l?.isEqualTo(e))};const h={isFocusTarget:p,setFocused:u,focused:c,blur:d,moveFocus:f};return h}//# sourceMappingURL=useFocus.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/selection/useMulti.js
/**
 * Hook to manage multiple-date selection in the DayPicker component.
 *
 * @template T - The type of DayPicker props.
 * @param props - The DayPicker props.
 * @param dateLib - The date utility library instance.
 * @returns An object containing the selected dates, a function to select dates,
 *   and a function to check if a date is selected.
 */function hh(e,t){const{selected:r,required:n,onSelect:o}=e;const[a,i]=hi(r,o?r:undefined);const s=!o?a:r;const{isSameDay:l}=t;const c=e=>{return s?.some(t=>l(t,e))??false};const{min:u,max:d}=e;const f=(e,t,r)=>{let a=[...s??[]];if(c(e)){if(s?.length===u){// Min value reached, do nothing
return}if(n&&s?.length===1){// Required value already selected do nothing
return}a=s?.filter(t=>!l(t,e))}else{if(s?.length===d){// Max value reached, reset the selection to date
a=[e]}else{// Add the date to the selection
a=[...a,e]}}if(!o){i(a)}o?.(a,e,t,r);return a};return{selected:s,select:f,isSelected:c}}//# sourceMappingURL=useMulti.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/utils/addToRange.js
/**
 * Adds a date to an existing range, considering constraints like minimum and
 * maximum range size.
 *
 * @param date - The date to add to the range.
 * @param initialRange - The initial range to which the date will be added.
 * @param min - The minimum number of days in the range.
 * @param max - The maximum number of days in the range.
 * @param required - Whether the range must always include at least one date.
 * @param dateLib - The date utility library instance.
 * @returns The updated date range, or `undefined` if the range is cleared.
 * @group Utilities
 */function hv(e,t,r=0,n=0,o=false,a=fR){const{from:i,to:s}=t||{};const{isSameDay:l,isAfter:c,isBefore:u}=a;let d;if(!i&&!s){// the range is empty, add the date
d={from:e,to:r>0?undefined:e}}else if(i&&!s){// adding date to an incomplete range
if(l(i,e)){// adding a date equal to the start of the range
if(o){d={from:i,to:undefined}}else{d=undefined}}else if(u(e,i)){// adding a date before the start of the range
d={from:e,to:i}}else{// adding a date after the start of the range
d={from:i,to:e}}}else if(i&&s){// adding date to a complete range
if(l(i,e)&&l(s,e)){// adding a date that is equal to both start and end of the range
if(o){d={from:i,to:s}}else{d=undefined}}else if(l(i,e)){// adding a date equal to the the start of the range
d={from:i,to:r>0?undefined:e}}else if(l(s,e)){// adding a dare equal to the end of the range
d={from:e,to:r>0?undefined:e}}else if(u(e,i)){// adding a date before the start of the range
d={from:e,to:s}}else if(c(e,i)){// adding a date after the start of the range
d={from:i,to:e}}else if(c(e,s)){// adding a date after the end of the range
d={from:i,to:e}}else{throw new Error("Invalid range")}}// check for min / max
if(d?.from&&d?.to){const t=a.differenceInCalendarDays(d.to,d.from);if(n>0&&t>n){d={from:e,to:undefined}}else if(r>1&&t<r){d={from:e,to:undefined}}}return d}//# sourceMappingURL=addToRange.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/utils/rangeContainsDayOfWeek.js
/**
 * Checks if a date range contains one or more specified days of the week.
 *
 * @since 9.2.2
 * @param range - The date range to check.
 * @param dayOfWeek - The day(s) of the week to check for (`0-6`, where `0` is
 *   Sunday).
 * @param dateLib - The date utility library instance.
 * @returns `true` if the range contains the specified day(s) of the week,
 *   otherwise `false`.
 * @group Utilities
 */function hg(e,t,r=fR){const n=!Array.isArray(t)?[t]:t;let o=e.from;const a=r.differenceInCalendarDays(e.to,e.from);// iterate at maximum one week or the total days if the range is shorter than one week
const i=Math.min(a,6);for(let e=0;e<=i;e++){if(n.includes(o.getDay())){return true}o=r.addDays(o,1)}return false}//# sourceMappingURL=rangeContainsDayOfWeek.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/utils/rangeOverlaps.js
/**
 * Determines if two date ranges overlap.
 *
 * @since 9.2.2
 * @param rangeLeft - The first date range.
 * @param rangeRight - The second date range.
 * @param dateLib - The date utility library instance.
 * @returns `true` if the ranges overlap, otherwise `false`.
 * @group Utilities
 */function hm(e,t,r=fR){return fV(e,t.from,false,r)||fV(e,t.to,false,r)||fV(t,e.from,false,r)||fV(t,e.to,false,r)}//# sourceMappingURL=rangeOverlaps.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/utils/rangeContainsModifiers.js
/**
 * Checks if a date range contains dates that match the given modifiers.
 *
 * @since 9.2.2
 * @param range - The date range to check.
 * @param modifiers - The modifiers to match against.
 * @param dateLib - The date utility library instance.
 * @returns `true` if the range contains matching dates, otherwise `false`.
 * @group Utilities
 */function hb(e,t,r=fR){const n=Array.isArray(t)?t:[t];// Defer function matchers evaluation as they are the least performant.
const o=n.filter(e=>typeof e!=="function");const a=o.some(t=>{if(typeof t==="boolean")return t;if(r.isDate(t)){return fV(e,t,false,r)}if(f$(t,r)){return t.some(t=>fV(e,t,false,r))}if(fU(t)){if(t.from&&t.to){return hm(e,{from:t.from,to:t.to},r)}return false}if(fX(t)){return hg(e,t.dayOfWeek,r)}if(fq(t)){const n=r.isAfter(t.before,t.after);if(n){return hm(e,{from:r.addDays(t.after,1),to:r.addDays(t.before,-1)},r)}return fZ(e.from,t,r)||fZ(e.to,t,r)}if(fG(t)||fQ(t)){return fZ(e.from,t,r)||fZ(e.to,t,r)}return false});if(a){return true}const i=n.filter(e=>typeof e==="function");if(i.length){let t=e.from;const n=r.differenceInCalendarDays(e.to,e.from);for(let e=0;e<=n;e++){if(i.some(e=>e(t))){return true}t=r.addDays(t,1)}}return false}//# sourceMappingURL=rangeContainsModifiers.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/selection/useRange.js
/**
 * Hook to manage range selection in the DayPicker component.
 *
 * @template T - The type of DayPicker props.
 * @param props - The DayPicker props.
 * @param dateLib - The date utility library instance.
 * @returns An object containing the selected range, a function to select a
 *   range, and a function to check if a date is within the range.
 */function hy(e,t){const{disabled:r,excludeDisabled:n,selected:o,required:a,onSelect:i}=e;const[s,l]=hi(o,i?o:undefined);const c=!i?s:o;const u=e=>c&&fV(c,e,false,t);const d=(o,s,u)=>{const{min:d,max:f}=e;const p=o?hv(o,c,d,f,a,t):undefined;if(n&&r&&p?.from&&p.to){if(hb({from:p.from,to:p.to},r,t)){// if a disabled days is found, the range is reset
p.from=o;p.to=undefined}}if(!i){l(p)}i?.(p,o,s,u);return p};return{selected:c,select:d,isSelected:u}}//# sourceMappingURL=useRange.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/selection/useSingle.js
/**
 * Hook to manage single-date selection in the DayPicker component.
 *
 * @template T - The type of DayPicker props.
 * @param props - The DayPicker props.
 * @param dateLib - The date utility library instance.
 * @returns An object containing the selected date, a function to select a date,
 *   and a function to check if a date is selected.
 */function h_(e,t){const{selected:r,required:n,onSelect:o}=e;const[a,i]=hi(r,o?r:undefined);const s=!o?a:r;const{isSameDay:l}=t;const c=e=>{return s?l(s,e):false};const u=(e,t,r)=>{let a=e;if(!n&&s&&s&&l(e,s)){// If the date is the same, clear the selection.
a=undefined}if(!o){i(a)}if(n){o?.(a,e,t,r)}else{o?.(a,e,t,r)}return a};return{selected:s,select:u,isSelected:c}}//# sourceMappingURL=useSingle.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/useSelection.js
/**
 * Determines the appropriate selection hook to use based on the selection mode
 * and returns the corresponding selection object.
 *
 * @template T - The type of DayPicker props.
 * @param props - The DayPicker props.
 * @param dateLib - The date utility library instance.
 * @returns The selection object for the specified mode, or `undefined` if no
 *   mode is set.
 */function hw(e,t){const r=h_(e,t);const n=hh(e,t);const o=hy(e,t);switch(e.mode){case"single":return r;case"multiple":return n;case"range":return o;default:return undefined}}//# sourceMappingURL=useSelection.js.map
;// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/dist/esm/DayPicker.js
/**
 * Renders the DayPicker calendar component.
 *
 * @param initialProps - The props for the DayPicker component.
 * @returns The rendered DayPicker component.
 * @group DayPicker
 * @see https://daypicker.dev
 */function hx(e){let t=e;if(t.timeZone){t={...e};if(t.today){t.today=new cX(t.today,t.timeZone)}if(t.month){t.month=new cX(t.month,t.timeZone)}if(t.defaultMonth){t.defaultMonth=new cX(t.defaultMonth,t.timeZone)}if(t.startMonth){t.startMonth=new cX(t.startMonth,t.timeZone)}if(t.endMonth){t.endMonth=new cX(t.endMonth,t.timeZone)}if(t.mode==="single"&&t.selected){t.selected=new cX(t.selected,t.timeZone)}else if(t.mode==="multiple"&&t.selected){t.selected=t.selected?.map(e=>new cX(e,t.timeZone))}else if(t.mode==="range"&&t.selected){t.selected={from:t.selected.from?new cX(t.selected.from,t.timeZone):undefined,to:t.selected.to?new cX(t.selected.to,t.timeZone):undefined}}}const{components:r,formatters:n,labels:o,dateLib:i,locale:s,classNames:l}=(0,v.useMemo)(()=>{const e={...uD,...t.locale};const r=new fB({locale:e,weekStartsOn:t.broadcastCalendar?1:t.weekStartsOn,firstWeekContainsDate:t.firstWeekContainsDate,useAdditionalWeekYearTokens:t.useAdditionalWeekYearTokens,useAdditionalDayOfYearTokens:t.useAdditionalDayOfYearTokens,timeZone:t.timeZone,numerals:t.numerals},t.dateLib);return{dateLib:r,components:p_(t.components),formatters:pF(t.formatters),labels:{...a,...t.labels},locale:e,classNames:{...px(),...t.classNames}}},[t.locale,t.broadcastCalendar,t.weekStartsOn,t.firstWeekContainsDate,t.useAdditionalWeekYearTokens,t.useAdditionalDayOfYearTokens,t.timeZone,t.numerals,t.dateLib,t.components,t.formatters,t.labels,t.classNames]);const{captionLayout:c,mode:u,navLayout:d,numberOfMonths:f=1,onDayBlur:p,onDayClick:h,onDayFocus:g,onDayKeyDown:m,onDayMouseEnter:b,onDayMouseLeave:y,onNextClick:_,onPrevClick:w,showWeekNumber:x,styles:A}=t;const{formatCaption:k,formatDay:Y,formatMonthDropdown:I,formatWeekNumber:D,formatWeekNumberHeader:C,formatWeekdayName:S,formatYearDropdown:M}=n;const E=hs(t,i);const{days:F,months:H,navStart:T,navEnd:O,previousMonth:K,nextMonth:N,goToMonth:P}=E;const L=f0(F,t,T,O,i);const{isSelected:W,select:B,selected:R}=hw(t,i)??{};const{blur:z,focused:V,isFocusTarget:j,moveFocus:q,setFocused:U}=hp(t,E,L,W??(()=>false),i);const{labelDayButton:G,labelGridcell:Q,labelGrid:X,labelMonthDropdown:$,labelNav:Z,labelPrevious:J,labelNext:ee,labelWeekday:et,labelWeekNumber:er,labelWeekNumberHeader:en,labelYearDropdown:eo}=o;const ea=(0,v.useMemo)(()=>pO(i,t.ISOWeek),[i,t.ISOWeek]);const ei=u!==undefined||h!==undefined;const es=(0,v.useCallback)(()=>{if(!K)return;P(K);w?.(K)},[K,P,w]);const el=(0,v.useCallback)(()=>{if(!N)return;P(N);_?.(N)},[P,N,_]);const ec=(0,v.useCallback)((e,t)=>r=>{r.preventDefault();r.stopPropagation();U(e);B?.(e.date,t,r);h?.(e.date,t,r)},[B,h,U]);const eu=(0,v.useCallback)((e,t)=>r=>{U(e);g?.(e.date,t,r)},[g,U]);const ed=(0,v.useCallback)((e,t)=>r=>{z();p?.(e.date,t,r)},[z,p]);const ef=(0,v.useCallback)((e,r)=>n=>{const o={ArrowLeft:[n.shiftKey?"month":"day",t.dir==="rtl"?"after":"before"],ArrowRight:[n.shiftKey?"month":"day",t.dir==="rtl"?"before":"after"],ArrowDown:[n.shiftKey?"year":"week","after"],ArrowUp:[n.shiftKey?"year":"week","before"],PageUp:[n.shiftKey?"year":"month","before"],PageDown:[n.shiftKey?"year":"month","after"],Home:["startOfWeek","before"],End:["endOfWeek","after"]};if(o[n.key]){n.preventDefault();n.stopPropagation();const[e,t]=o[n.key];q(e,t)}m?.(e.date,r,n)},[q,m,t.dir]);const ep=(0,v.useCallback)((e,t)=>r=>{b?.(e.date,t,r)},[b]);const eh=(0,v.useCallback)((e,t)=>r=>{y?.(e.date,t,r)},[y]);const ev=(0,v.useCallback)(e=>t=>{const r=Number(t.target.value);const n=i.setMonth(i.startOfMonth(e),r);P(n)},[i,P]);const eg=(0,v.useCallback)(e=>t=>{const r=Number(t.target.value);const n=i.setYear(i.startOfMonth(e),r);P(n)},[i,P]);const{className:em,style:eb}=(0,v.useMemo)(()=>({className:[l[cZ.Root],t.className].filter(Boolean).join(" "),style:{...A?.[cZ.Root],...t.style}}),[l,t.className,t.style,A]);const ey=pw(t);const e_=(0,v.useRef)(null);p2(e_,Boolean(t.animate),{classNames:l,months:H,focused:V,dateLib:i});const ew={dayPickerProps:t,selected:R,select:B,isSelected:W,months:H,nextMonth:N,previousMonth:K,goToMonth:P,getModifiers:L,components:r,classNames:l,styles:A,labels:o,formatters:n};return v.createElement(po.Provider,{value:ew},v.createElement(r.Root,{rootRef:t.animate?e_:undefined,className:em,style:eb,dir:t.dir,id:t.id,lang:t.lang,nonce:t.nonce,title:t.title,role:t.role,"aria-label":t["aria-label"],...ey},v.createElement(r.Months,{className:l[cZ.Months],style:A?.[cZ.Months]},!t.hideNavigation&&!d&&v.createElement(r.Nav,{"data-animated-nav":t.animate?"true":undefined,className:l[cZ.Nav],style:A?.[cZ.Nav],"aria-label":Z(),onPreviousClick:es,onNextClick:el,previousMonth:K,nextMonth:N}),H.map((e,o)=>{const a=pH(e.date,T,O,n,i);const p=pK(T,O,n,i);return v.createElement(r.Month,{"data-animated-month":t.animate?"true":undefined,className:l[cZ.Month],style:A?.[cZ.Month],key:o,displayIndex:o,calendarMonth:e},d==="around"&&!t.hideNavigation&&o===0&&v.createElement(r.PreviousMonthButton,{type:"button",className:l[cZ.PreviousMonthButton],tabIndex:K?undefined:-1,"aria-disabled":K?undefined:true,"aria-label":J(K),onClick:es,"data-animated-button":t.animate?"true":undefined},v.createElement(r.Chevron,{disabled:K?undefined:true,className:l[cZ.Chevron],orientation:t.dir==="rtl"?"right":"left"})),v.createElement(r.MonthCaption,{"data-animated-caption":t.animate?"true":undefined,className:l[cZ.MonthCaption],style:A?.[cZ.MonthCaption],calendarMonth:e,displayIndex:o},c?.startsWith("dropdown")?v.createElement(r.DropdownNav,{className:l[cZ.Dropdowns],style:A?.[cZ.Dropdowns]},c==="dropdown"||c==="dropdown-months"?v.createElement(r.MonthsDropdown,{className:l[cZ.MonthsDropdown],"aria-label":$(),classNames:l,components:r,disabled:Boolean(t.disableNavigation),onChange:ev(e.date),options:a,style:A?.[cZ.Dropdown],value:i.getMonth(e.date)}):v.createElement("span",null,I(e.date,i)),c==="dropdown"||c==="dropdown-years"?v.createElement(r.YearsDropdown,{className:l[cZ.YearsDropdown],"aria-label":eo(i.options),classNames:l,components:r,disabled:Boolean(t.disableNavigation),onChange:eg(e.date),options:p,style:A?.[cZ.Dropdown],value:i.getYear(e.date)}):v.createElement("span",null,M(e.date,i)),v.createElement("span",{role:"status","aria-live":"polite",style:{border:0,clip:"rect(0 0 0 0)",height:"1px",margin:"-1px",overflow:"hidden",padding:0,position:"absolute",width:"1px",whiteSpace:"nowrap",wordWrap:"normal"}},k(e.date,i.options,i))):v.createElement(r.CaptionLabel,{className:l[cZ.CaptionLabel],role:"status","aria-live":"polite"},k(e.date,i.options,i))),d==="around"&&!t.hideNavigation&&o===f-1&&v.createElement(r.NextMonthButton,{type:"button",className:l[cZ.NextMonthButton],tabIndex:N?undefined:-1,"aria-disabled":N?undefined:true,"aria-label":ee(N),onClick:el,"data-animated-button":t.animate?"true":undefined},v.createElement(r.Chevron,{disabled:N?undefined:true,className:l[cZ.Chevron],orientation:t.dir==="rtl"?"left":"right"})),o===f-1&&d==="after"&&!t.hideNavigation&&v.createElement(r.Nav,{"data-animated-nav":t.animate?"true":undefined,className:l[cZ.Nav],style:A?.[cZ.Nav],"aria-label":Z(),onPreviousClick:es,onNextClick:el,previousMonth:K,nextMonth:N}),v.createElement(r.MonthGrid,{role:"grid","aria-multiselectable":u==="multiple"||u==="range","aria-label":X(e.date,i.options,i)||undefined,className:l[cZ.MonthGrid],style:A?.[cZ.MonthGrid]},!t.hideWeekdays&&v.createElement(r.Weekdays,{"data-animated-weekdays":t.animate?"true":undefined,className:l[cZ.Weekdays],style:A?.[cZ.Weekdays]},x&&v.createElement(r.WeekNumberHeader,{"aria-label":en(i.options),className:l[cZ.WeekNumberHeader],style:A?.[cZ.WeekNumberHeader],scope:"col"},C()),ea.map((e,t)=>v.createElement(r.Weekday,{"aria-label":et(e,i.options,i),className:l[cZ.Weekday],key:t,style:A?.[cZ.Weekday],scope:"col"},S(e,i.options,i)))),v.createElement(r.Weeks,{"data-animated-weeks":t.animate?"true":undefined,className:l[cZ.Weeks],style:A?.[cZ.Weeks]},e.weeks.map((e,n)=>{return v.createElement(r.Week,{className:l[cZ.Week],key:e.weekNumber,style:A?.[cZ.Week],week:e},x&&v.createElement(r.WeekNumber,{week:e,style:A?.[cZ.WeekNumber],"aria-label":er(e.weekNumber,{locale:s}),className:l[cZ.WeekNumber],scope:"row",role:"rowheader"},D(e.weekNumber,i)),e.days.map(e=>{const{date:n}=e;const o=L(e);o[cJ.focused]=!o.hidden&&Boolean(V?.isEqualTo(e));o[c0.selected]=W?.(n)||o.selected;if(fU(R)){// add range modifiers
const{from:e,to:t}=R;o[c0.range_start]=Boolean(e&&t&&i.isSameDay(n,e));o[c0.range_end]=Boolean(e&&t&&i.isSameDay(n,t));o[c0.range_middle]=fV(R,n,true,i)}const a=pT(o,A,t.modifiersStyles);const s=f1(o,l,t.modifiersClassNames);const c=!ei&&!o.hidden?Q(n,o,i.options,i):undefined;return v.createElement(r.Day,{key:`${i.format(n,"yyyy-MM-dd")}_${i.format(e.displayMonth,"yyyy-MM")}`,day:e,modifiers:o,className:s.join(" "),style:a,role:"gridcell","aria-selected":o.selected||undefined,"aria-label":c,"data-day":i.format(n,"yyyy-MM-dd"),"data-month":e.outside?i.format(n,"yyyy-MM"):undefined,"data-selected":o.selected||undefined,"data-disabled":o.disabled||undefined,"data-hidden":o.hidden||undefined,"data-outside":e.outside||undefined,"data-focused":o.focused||undefined,"data-today":o.today||undefined},!o.hidden&&ei?v.createElement(r.DayButton,{className:l[cZ.DayButton],style:A?.[cZ.DayButton],type:"button",day:e,modifiers:o,disabled:o.disabled||undefined,tabIndex:j(e)?0:-1,"aria-label":G(n,o,i.options,i),onClick:ec(e,o),onBlur:ed(e,o),onFocus:eu(e,o),onKeyDown:ef(e,o),onMouseEnter:ep(e,o),onMouseLeave:eh(e,o)},Y(n,i.options,i)):!o.hidden&&Y(e.date,i.options,i))}))}))))})),t.footer&&v.createElement(r.Footer,{className:l[cZ.Footer],style:A?.[cZ.Footer],role:"status","aria-live":"polite"},t.footer)))}//# sourceMappingURL=DayPicker.js.map
// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js
var hA=r(5072);var hk=/*#__PURE__*/r.n(hA);// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/styleDomAPI.js
var hY=r(7825);var hI=/*#__PURE__*/r.n(hY);// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/insertBySelector.js
var hD=r(7659);var hC=/*#__PURE__*/r.n(hD);// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/setAttributesWithoutAttributes.js
var hS=r(5056);var hM=/*#__PURE__*/r.n(hS);// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/insertStyleElement.js
var hE=r(540);var hF=/*#__PURE__*/r.n(hE);// EXTERNAL MODULE: ./node_modules/style-loader/dist/runtime/styleTagTransform.js
var hH=r(1113);var hT=/*#__PURE__*/r.n(hH);// EXTERNAL MODULE: ./node_modules/css-loader/dist/cjs.js!../tutor/node_modules/react-day-picker/src/style.css
var hO=r(1543);// CONCATENATED MODULE: ../tutor/node_modules/react-day-picker/src/style.css
var hK={};hK.styleTagTransform=hT();hK.setAttributes=hM();hK.insert=hC().bind(null,"head");hK.domAPI=hI();hK.insertStyleElement=hF();var hN=hk()(hO/* ["default"] */.A,hK);/* ESM default export */const hP=hO/* ["default"] */.A&&hO/* ["default"].locals */.A.locals?hO/* ["default"].locals */.A.locals:undefined;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormDateInput.tsx
// Create DayPicker formatters based on WordPress locale
var hL=()=>{if(typeof window==="undefined"||!window.wp||!window.wp.date){return}var{format:e}=wp.date;return{formatMonthDropdown:t=>e("F",t),formatMonthCaption:t=>e("F",t),formatCaption:t=>e("F",t),formatWeekdayName:t=>e("D",t)}};var hW=e=>{if(!e)return undefined;return(0,n6/* ["default"] */.A)(new Date(e))?new Date(e.length===10?e+"T00:00:00":e):undefined};var hB=e=>{var{label:t,field:r,fieldState:n,disabled:o,disabledBefore:a,disabledAfter:i,loading:s,placeholder:l,helpText:c,isClearable:d=true,onChange:f,dateFormat:p=rC/* .DateFormats.monthDayYear */.UA.monthDayYear}=e;var g=(0,v.useRef)(null);var[m,b]=(0,v.useState)(false);var x=hW(r.value);var A=typeof window!=="undefined"&&window.wp&&window.wp.date;var k=x?A?window.wp.date.format("F j, Y",x):(0,cN/* ["default"] */.A)(x,p):"";var{triggerRef:Y,position:I,popoverRef:D}=(0,rf/* .usePortalPopover */.tP)({isOpen:m,placement:rf/* .POPOVER_PLACEMENTS.BOTTOM_LEFT */.zA.BOTTOM_LEFT});var C=()=>{var e;b(false);(e=g.current)===null||e===void 0?void 0:e.focus()};var S=hW(a);var M=hW(i);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:t,field:r,fieldState:n,disabled:o,loading:s,placeholder:l,helpText:c,children:e=>{var{css:t}=e,n=(0,rD._)(e,["css"]);return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:hz.wrapper,ref:Y,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},n),{css:[t,hz.input],title:k,ref:e=>{r.ref(e);// @ts-ignore
g.current=e},type:"text",value:k,onClick:e=>{e.stopPropagation();b(e=>!e)},onKeyDown:e=>{if(e.key==="Enter"){e.preventDefault();b(e=>!e)}},autoComplete:"off","data-input":true})),/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"calendarLine",width:30,height:32,style:hz.icon}),d&&r.value&&/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{isIconOnly:true,"aria-label":(0,h.__)("Clear","tutor-pro"),size:"small",variant:"text",buttonCss:rA/* .styleUtils.inputClearButton */.x.inputClearButton,onClick:()=>{r.onChange("")},icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"times",width:12,height:12})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rf/* .Portal */.ZL,{isOpen:m,onClickOutside:C,onEscape:C,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:hz.pickerWrapper,style:{left:I.left,top:I.top},ref:D,children:/*#__PURE__*/(0,u/* .jsx */.Y)(hx,{dir:rC/* .isRTL */.V8?"rtl":"ltr",animate:true,mode:"single",formatters:hL(),disabled:[!!S&&{before:S},!!M&&{after:M}],selected:x,onSelect:e=>{if(e){var t=(0,cN/* ["default"] */.A)(e,rC/* .DateFormats.yearMonthDay */.UA.yearMonthDay);r.onChange(t);C();if(f){f(t)}}},showOutsideDays:true,captionLayout:"dropdown",autoFocus:true,defaultMonth:x||new Date,startMonth:S||new Date(new Date().getFullYear()-10,0),endMonth:M||new Date(new Date().getFullYear()+10,11),weekStartsOn:A?window.wp.date.getSettings().l10n.startOfWeek:0})})})]})}})};/* ESM default export */const hR=hB;var hz={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;&:hover,&:focus-within{& > button{opacity:1;}}"),input:/*#__PURE__*/(0,d/* .css */.AH)("&[data-input]{padding-left:",rn/* .spacing["40"] */.YK["40"],";}"),icon:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;top:50%;left:",rn/* .spacing["8"] */.YK["8"],";transform:translateY(-50%);color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";"),pickerWrapper:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body("regular"),";position:absolute;background-color:",rn/* .colorTokens.background.white */.I6.background.white,";box-shadow:",rn/* .shadow.popover */.r7.popover,";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";.rdp-root{--rdp-day-height:40px;--rdp-day-width:40px;--rdp-day_button-height:40px;--rdp-day_button-width:40px;--rdp-nav-height:40px;--rdp-today-color:",rn/* .colorTokens.text.title */.I6.text.title,";--rdp-caption-font-size:",rn/* .fontSize["18"] */.J["18"],";--rdp-accent-color:",rn/* .colorTokens.action.primary["default"] */.I6.action.primary["default"],";--rdp-background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";--rdp-accent-color-dark:",rn/* .colorTokens.action.primary.active */.I6.action.primary.active,";--rdp-background-color-dark:",rn/* .colorTokens.action.primary.hover */.I6.action.primary.hover,";--rdp-selected-color:",rn/* .colorTokens.text.white */.I6.text.white,";--rdp-day_button-border-radius:",rn/* .borderRadius.circle */.Vq.circle,";--rdp-outside-opacity:0.5;--rdp-disabled-opacity:0.25;}.rdp-months{margin:",rn/* .spacing["16"] */.YK["16"],";}.rdp-month_grid{margin:0px;}.rdp-day{padding:0px;}.rdp-nav{--rdp-accent-color:",rn/* .colorTokens.text.primary */.I6.text.primary,";button{border-radius:",rn/* .borderRadius.circle */.Vq.circle,";&:hover,&:focus,&:active{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}&:focus-visible:not(:disabled){--rdp-accent-color:",rn/* .colorTokens.text.white */.I6.text.white,";background-color:",rn/* .colorTokens.background.brand */.I6.background.brand,";}}}.rdp-dropdown_root{.rdp-caption_label{padding:",rn/* .spacing["8"] */.YK["8"],";}}.rdp-today{.rdp-day_button{font-weight:",rn/* .fontWeight.bold */.Wy.bold,";}}.rdp-selected{color:var(--rdp-selected-color);background-color:var(--rdp-accent-color);border-radius:",rn/* .borderRadius.circle */.Vq.circle,";font-weight:",rn/* .fontWeight.regular */.Wy.regular,";.rdp-day_button{&:hover,&:focus,&:active{background-color:var(--rdp-accent-color);color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}&:focus-visible{outline:2px solid var(--rdp-accent-color);outline-offset:2px;}&:not(.rdp-outside){color:var(--rdp-selected-color);}}}.rdp-day_button{&:hover,&:focus,&:active{background-color:var(--rdp-background-color);color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}&:focus-visible:not([disabled]){color:var(--rdp-selected-color);opacity:1;background-color:var(--rdp-accent-color);}}")};// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/_lib/toInteger/index.js
var hV=r(7801);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/toDate/index.js
var hj=r(3298);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/_lib/requiredArgs/index.js
var hq=r(8672);// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/setMinutes/index.js
/**
 * @name setMinutes
 * @category Minute Helpers
 * @summary Set the minutes to the given date.
 *
 * @description
 * Set the minutes to the given date.
 *
 * @param {Date|Number} date - the date to be changed
 * @param {Number} minutes - the minutes of the new date
 * @returns {Date} the new date with the minutes set
 * @throws {TypeError} 2 arguments required
 *
 * @example
 * // Set 45 minutes to 1 September 2014 11:30:40:
 * const result = setMinutes(new Date(2014, 8, 1, 11, 30, 40), 45)
 * //=> Mon Sep 01 2014 11:45:40
 */function hU(e,t){(0,hq/* ["default"] */.A)(2,arguments);var r=(0,hj/* ["default"] */.A)(e);var n=(0,hV/* ["default"] */.A)(t);r.setMinutes(n);return r};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/setHours/index.js
/**
 * @name setHours
 * @category Hour Helpers
 * @summary Set the hours to the given date.
 *
 * @description
 * Set the hours to the given date.
 *
 * @param {Date|Number} date - the date to be changed
 * @param {Number} hours - the hours of the new date
 * @returns {Date} the new date with the hours set
 * @throws {TypeError} 2 arguments required
 *
 * @example
 * // Set 4 hours to 1 September 2014 11:30:00:
 * const result = setHours(new Date(2014, 8, 1, 11, 30), 4)
 * //=> Mon Sep 01 2014 04:30:00
 */function hG(e,t){(0,hq/* ["default"] */.A)(2,arguments);var r=(0,hj/* ["default"] */.A)(e);var n=(0,hV/* ["default"] */.A)(t);r.setHours(n);return r}// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/addMinutes/index.js
var hQ=r(8443);// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/startOfMinute/index.js
/**
 * @name startOfMinute
 * @category Minute Helpers
 * @summary Return the start of a minute for the given date.
 *
 * @description
 * Return the start of a minute for the given date.
 * The result will be in the local timezone.
 *
 * @param {Date|Number} date - the original date
 * @returns {Date} the start of a minute
 * @throws {TypeError} 1 argument required
 *
 * @example
 * // The start of a minute for 1 December 2014 22:15:45.400:
 * const result = startOfMinute(new Date(2014, 11, 1, 22, 15, 45, 400))
 * //=> Mon Dec 01 2014 22:15:00
 */function hX(e){(0,hq/* ["default"] */.A)(1,arguments);var t=(0,hj/* ["default"] */.A)(e);t.setSeconds(0,0);return t};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/eachMinuteOfInterval/index.js
/**
 * @name eachMinuteOfInterval
 * @category Interval Helpers
 * @summary Return the array of minutes within the specified time interval.
 *
 * @description
 * Returns the array of minutes within the specified time interval.
 *
 * @param {Interval} interval - the interval. See [Interval]{@link https://date-fns.org/docs/Interval}
 * @param {Object} [options] - an object with options.
 * @param {Number} [options.step=1] - the step to increment by. The step must be equal to or greater than 1
 * @throws {TypeError} 1 argument required
 * @returns {Date[]} the array with starts of minutes from the minute of the interval start to the minute of the interval end
 * @throws {RangeError} `options.step` must be a number equal to or greater than 1
 * @throws {RangeError} The start of an interval cannot be after its end
 * @throws {RangeError} Date in interval cannot be `Invalid Date`
 *
 * @example
 * // Each minute between 14 October 2020, 13:00 and 14 October 2020, 13:03
 * const result = eachMinuteOfInterval({
 *   start: new Date(2014, 9, 14, 13),
 *   end: new Date(2014, 9, 14, 13, 3)
 * })
 * //=> [
 * //   Wed Oct 14 2014 13:00:00,
 * //   Wed Oct 14 2014 13:01:00,
 * //   Wed Oct 14 2014 13:02:00,
 * //   Wed Oct 14 2014 13:03:00
 * // ]
 */function h$(e,t){var r;(0,hq/* ["default"] */.A)(1,arguments);var n=hX((0,hj/* ["default"] */.A)(e.start));var o=(0,hj/* ["default"] */.A)(e.end);var a=n.getTime();var i=o.getTime();if(a>=i){throw new RangeError("Invalid interval")}var s=[];var l=n;var c=Number((r=t===null||t===void 0?void 0:t.step)!==null&&r!==void 0?r:1);if(c<1||isNaN(c))throw new RangeError("`options.step` must be a number equal to or greater than 1");while(l.getTime()<=i){s.push((0,hj/* ["default"] */.A)(l));l=(0,hQ/* ["default"] */.A)(l,c)}return s};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormTimeInput.tsx
var hZ=e=>{var{label:t,field:r,fieldState:n,interval:o=30,disabled:a,loading:i,placeholder:s,helpText:l,isClearable:c=true}=e;var[d,f]=(0,v.useState)(false);var p=(0,v.useRef)(null);var g=(0,v.useRef)(null);var m=(0,v.useMemo)(()=>{var e=hU(hG(new Date,0),0);var t=hU(hG(new Date,23),59);var r=h$({start:e,end:t},{step:o});return r.map(e=>(0,cN/* ["default"] */.A)(e,rC/* .DateFormats.hoursMinutes */.UA.hoursMinutes))},[o]);var{activeIndex:b,setActiveIndex:x}=rW({options:m.map(e=>({label:e,value:e})),isOpen:d,selectedValue:r.value,onSelect:e=>{r.onChange(e.value);f(false)},onClose:()=>f(false)});(0,v.useEffect)(()=>{if(d&&b>=0&&g.current){g.current.scrollIntoView({block:"nearest",behavior:"smooth"})}},[d,b]);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:t,field:r,fieldState:n,disabled:a,loading:i,placeholder:s,helpText:l,children:e=>{var{css:t}=e,n=(0,rD._)(e,["css"]);var o;return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:h0.wrapper,ref:p,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},n),{ref:r.ref,css:[t,h0.input],type:"text",onClick:e=>{e.stopPropagation();f(e=>!e)},onKeyDown:e=>{if(e.key==="Enter"){e.preventDefault();f(e=>!e)}if(e.key==="Tab"){f(false)}},value:(o=r.value)!==null&&o!==void 0?o:"",onChange:e=>{var{value:t}=e.target;r.onChange(t)},autoComplete:"off","data-input":true})),/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"clock",width:32,height:32,style:h0.icon}),c&&r.value&&/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{isIconOnly:true,"aria-label":(0,h.__)("Clear","tutor-pro"),size:"small",variant:"text",buttonCss:rA/* .styleUtils.inputClearButton */.x.inputClearButton,onClick:()=>r.onChange(""),icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"times",width:12,height:12})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{triggerRef:p,isOpen:d,closePopover:()=>f(false),animationType:rL/* .AnimationType.slideDown */.J6.slideDown,children:/*#__PURE__*/(0,u/* .jsx */.Y)("ul",{css:h0.list,children:m.map((e,t)=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("li",{css:h0.listItem,ref:b===t?g:null,"data-active":b===t,children:/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:h0.itemButton,onClick:()=>{r.onChange(e);f(false)},onMouseOver:()=>x(t),onMouseLeave:()=>t!==b&&x(-1),onFocus:()=>x(t),children:e})},t)})})})]})}})};/* ESM default export */const hJ=hZ;var h0={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("position:relative;&:hover,&:focus-within{& > button{opacity:1;}}"),input:/*#__PURE__*/(0,d/* .css */.AH)("&[data-input]{padding-left:",rn/* .spacing["40"] */.YK["40"],";}"),icon:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;top:50%;left:",rn/* .spacing["8"] */.YK["8"],";transform:translateY(-50%);color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";"),list:/*#__PURE__*/(0,d/* .css */.AH)("height:380px;list-style:none;padding:0;margin:0;",rA/* .styleUtils.overflowYAuto */.x.overflowYAuto,";"),listItem:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;height:40px;cursor:pointer;display:flex;align-items:center;transition:background-color 0.3s ease-in-out;&[data-active='true']{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";}:hover{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";}"),itemButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.body */.I.body(),";margin:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["12"] */.YK["12"],";width:100%;height:100%;&:focus,&:active,&:hover{background:none;color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/subscription/OfferSalePrice.tsx
var{tutor_currency:h1}=nK/* .tutorConfig */.P;function h6(){var e=e0();var t=e.watch("offer_sale_price");var r=e.watch("regular_price");var n=!!e.watch("schedule_sale_price");return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:h2.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{children:/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"offer_sale_price",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(n0,(0,w._)((0,_._)({},e),{label:(0,h.__)("Offer sale price","tutor-pro")}))})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:h2.inputWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"sale_price",rules:(0,w._)((0,_._)({},n2()),{validate:e=>{if(e&&r&&Number(e)>=Number(r)){return(0,h.__)("Sale price should be less than regular price","tutor-pro")}if(e&&r&&Number(e)<=0){return(0,h.__)("Sale price should be greater than 0","tutor-pro")}return undefined}}),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(a0,(0,w._)((0,_._)({},e),{type:"number",label:(0,h.__)("Sale Price","tutor-pro"),content:(h1===null||h1===void 0?void 0:h1.symbol)||"$",selectOnFocus:true,contentCss:rA/* .styleUtils.inputCurrencyStyle */.x.inputCurrencyStyle}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"schedule_sale_price",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(aR/* ["default"] */.A,(0,w._)((0,_._)({},e),{label:(0,h.__)("Schedule the sale price","tutor-pro")}))}),/*#__PURE__*/(0,u/* .jsxs */.FD)(ra/* ["default"] */.A,{when:n,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:h2.datetimeWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("label",{children:(0,h.__)("Sale starts from","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:rA/* .styleUtils.dateAndTimeWrapper */.x.dateAndTimeWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"sale_price_from_date",control:e.control,rules:{required:(0,h.__)("Schedule date is required","tutor-pro")},render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(hR,(0,w._)((0,_._)({},e),{isClearable:false,placeholder:"yyyy-mm-dd",disabledBefore:new Date().toISOString()}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"sale_price_from_time",control:e.control,rules:{required:(0,h.__)("Schedule time is required","tutor-pro")},render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(hJ,(0,w._)((0,_._)({},e),{interval:60,isClearable:false,placeholder:"hh:mm A"}))})]})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:h2.datetimeWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("label",{children:(0,h.__)("Sale ends to","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:rA/* .styleUtils.dateAndTimeWrapper */.x.dateAndTimeWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"sale_price_to_date",control:e.control,rules:{required:(0,h.__)("Schedule date is required","tutor-pro"),validate:{checkEndDate:t=>{var r=e.watch("sale_price_from_date");var n=t;if(r&&n){return new Date(r)>new Date(n)?(0,h.__)("Sales End date should be greater than start date","tutor-pro"):undefined}return undefined}},deps:["sale_price_from_date"]},render:t=>/*#__PURE__*/(0,u/* .jsx */.Y)(hR,(0,w._)((0,_._)({},t),{isClearable:false,placeholder:"yyyy-mm-dd",disabledBefore:e.watch("sale_price_from_date")||undefined}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{name:"sale_price_to_time",control:e.control,rules:{required:(0,h.__)("Schedule time is required","tutor-pro"),validate:{checkEndTime:t=>{var r=e.watch("sale_price_from_date");var n=e.watch("sale_price_from_time");var o=e.watch("sale_price_to_date");var a=t;if(r&&o&&n&&a){return new Date("".concat(r," ").concat(n))>new Date("".concat(o," ").concat(a))?(0,h.__)("Sales End time should be greater than start time","tutor-pro"):undefined}return undefined}},deps:["sale_price_from_date","sale_price_from_time","sale_price_to_date"]},render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(hJ,(0,w._)((0,_._)({},e),{interval:60,isClearable:false,placeholder:"hh:mm A"}))})]})]})]})]})})]})}var h2={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("background-color:",rn/* .colorTokens.background.white */.I6.background.white,";padding:",rn/* .spacing["12"] */.YK["12"],";border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",rn/* .borderRadius["8"] */.Vq["8"],";display:flex;flex-direction:column;gap:",rn/* .spacing["20"] */.YK["20"],";"),inputWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["12"] */.YK["12"],";padding:",rn/* .spacing["4"] */.YK["4"],";margin:-",rn/* .spacing["4"] */.YK["4"],";"),datetimeWrapper:/*#__PURE__*/(0,d/* .css */.AH)("label{",ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.title */.I6.text.title,";}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/services/subscription.ts
var h4=[3,6,9,12];var h3={untilCancelled:(0,h.__)("Until cancelled","tutor-pro"),noRenewal:(0,h.__)("No Renewal","tutor-pro")};var h5={id:"0",payment_type:"recurring",plan_type:"course",assign_id:"0",plan_name:"",plan_order:"0",recurring_value:"1",recurring_interval:"month",is_featured:false,is_enabled:true,regular_price:"0",sale_price:"0",sale_price_from_date:"",sale_price_from_time:"",sale_price_to_date:"",sale_price_to_time:"",recurring_limit:(0,h.__)("Until cancelled","tutor-pro"),do_not_provide_certificate:false,enrollment_fee:"0",trial_value:"1",trial_interval:"day",charge_enrollment_fee:false,enable_free_trial:false,offer_sale_price:false,schedule_sale_price:false};var h8=e=>{var t=()=>{if(e.recurring_limit==="0"){return h3.untilCancelled}if(e.recurring_limit==="-1"){return h3.noRenewal}return e.recurring_limit||""};var r,n,o,a,i,s,l,c,u,d,f;return{id:e.id,payment_type:(r=e.payment_type)!==null&&r!==void 0?r:"recurring",plan_type:(n=e.plan_type)!==null&&n!==void 0?n:"course",assign_id:e.assign_id,plan_name:(o=e.plan_name)!==null&&o!==void 0?o:"",plan_order:(a=e.plan_order)!==null&&a!==void 0?a:"0",recurring_value:(i=e.recurring_value)!==null&&i!==void 0?i:"0",recurring_interval:(s=e.recurring_interval)!==null&&s!==void 0?s:"month",is_featured:!!Number(e.is_featured),is_enabled:!!Number(e.is_enabled),regular_price:(l=e.regular_price)!==null&&l!==void 0?l:"0",recurring_limit:t(),enrollment_fee:(c=e.enrollment_fee)!==null&&c!==void 0?c:"0",trial_value:(u=e.trial_value)!==null&&u!==void 0?u:"0",trial_interval:(d=e.trial_interval)!==null&&d!==void 0?d:"day",sale_price:(f=e.sale_price)!==null&&f!==void 0?f:"0",charge_enrollment_fee:!!Number(e.enrollment_fee),enable_free_trial:!!Number(e.trial_value),offer_sale_price:!!Number(e.sale_price),schedule_sale_price:!!e.sale_price_from,do_not_provide_certificate:!Number(e.provide_certificate),sale_price_from_date:e.sale_price_from?(0,cN/* ["default"] */.A)((0,rb/* .convertGMTtoLocalDate */.g1)(e.sale_price_from),rC/* .DateFormats.yearMonthDay */.UA.yearMonthDay):"",sale_price_from_time:e.sale_price_from?(0,cN/* ["default"] */.A)((0,rb/* .convertGMTtoLocalDate */.g1)(e.sale_price_from),rC/* .DateFormats.hoursMinutes */.UA.hoursMinutes):"",sale_price_to_date:e.sale_price_to?(0,cN/* ["default"] */.A)((0,rb/* .convertGMTtoLocalDate */.g1)(e.sale_price_to),rC/* .DateFormats.yearMonthDay */.UA.yearMonthDay):"",sale_price_to_time:e.sale_price_to?(0,cN/* ["default"] */.A)((0,rb/* .convertGMTtoLocalDate */.g1)(e.sale_price_to),rC/* .DateFormats.hoursMinutes */.UA.hoursMinutes):""}};var h7=e=>{var t=()=>{if(e.recurring_limit===h3.untilCancelled){return"0"}if(e.recurring_limit===h3.noRenewal){return"-1"}return e.recurring_limit};return(0,w._)((0,_._)((0,w._)((0,_._)((0,w._)((0,_._)((0,w._)((0,_._)({},e.id&&String(e.id)!=="0"&&{id:e.id}),{payment_type:e.payment_type,plan_type:e.plan_type,assign_id:e.assign_id,plan_name:e.plan_name}),e.id&&String(e.id)==="0"&&{plan_order:e.plan_order},e.payment_type==="recurring"&&{recurring_value:e.recurring_value,recurring_interval:e.recurring_interval}),{regular_price:e.regular_price,recurring_limit:t(),is_featured:e.is_featured?"1":"0",is_enabled:e.is_enabled?"1":"0"}),e.charge_enrollment_fee&&{enrollment_fee:e.enrollment_fee},e.enable_free_trial&&{trial_value:e.trial_value,trial_interval:e.trial_interval}),{sale_price:e.offer_sale_price?e.sale_price:"0"}),e.schedule_sale_price&&{sale_price_from:(0,rb/* .convertToGMT */.dn)(new Date("".concat(e.sale_price_from_date," ").concat(e.sale_price_from_time))),sale_price_to:(0,rb/* .convertToGMT */.dn)(new Date("".concat(e.sale_price_to_date," ").concat(e.sale_price_to_time)))}),{provide_certificate:e.do_not_provide_certificate?"0":"1"})};var h9=e=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].GET_SUBSCRIPTIONS_LIST */.A.GET_SUBSCRIPTIONS_LIST,{object_id:e})};var ve=e=>{return(0,rp/* .useQuery */.I)({queryKey:["SubscriptionsList",e],queryFn:()=>h9(e).then(e=>e.data)})};var vt=(e,t)=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].SAVE_SUBSCRIPTION */.A.SAVE_SUBSCRIPTION,(0,_._)({object_id:e},t.id&&{id:t.id},t))};var vr=e=>{var t=(0,f/* .useQueryClient */.jE)();var{showToast:r}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:t=>vt(e,t),onSuccess:n=>{if(n.status_code===200||n.status_code===201){r({message:n.message,type:"success"});t.invalidateQueries({queryKey:["SubscriptionsList",e]})}},onError:e=>{r({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(e)})}})};var vn=(e,t)=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].DELETE_SUBSCRIPTION */.A.DELETE_SUBSCRIPTION,{object_id:e,id:t})};var vo=e=>{var t=(0,f/* .useQueryClient */.jE)();var{showToast:r}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:t=>vn(e,t),onSuccess:(n,o)=>{if(n.status_code===200){r({message:n.message,type:"success"});t.setQueryData(["SubscriptionsList",e],e=>{return e.filter(e=>e.id!==String(o))})}},onError:e=>{r({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(e)})}})};var va=(e,t)=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].DUPLICATE_SUBSCRIPTION */.A.DUPLICATE_SUBSCRIPTION,{object_id:e,id:t})};var vi=e=>{var t=(0,f/* .useQueryClient */.jE)();var{showToast:r}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:t=>va(e,t),onSuccess:n=>{if(n.data){r({message:n.message,type:"success"});t.invalidateQueries({queryKey:["SubscriptionsList",e]})}},onError:e=>{r({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(e)})}})};var vs=(e,t)=>{return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].SORT_SUBSCRIPTION */.A.SORT_SUBSCRIPTION,{object_id:e,plan_ids:t})};var vl=e=>{var t=(0,f/* .useQueryClient */.jE)();var{showToast:r}=(0,rv/* .useToast */.d)();return(0,rh/* .useMutation */.n)({mutationFn:t=>vs(e,t),onSuccess:(r,n)=>{if(r.status_code===200){t.setQueryData(["SubscriptionsList",e],e=>{var t=n.map(e=>String(e));return e.sort((e,r)=>t.indexOf(e.id)-t.indexOf(r.id))});t.invalidateQueries({queryKey:["SubscriptionsList",e]})}},onError:n=>{r({type:"danger",message:(0,rb/* .convertToErrorMessage */.EL)(n)});t.invalidateQueries({queryKey:["SubscriptionsList",e]})}})};var vc=()=>{return wpAjaxInstance.get(endpoints.GET_MEMBERSHIP_PLANS).then(e=>e.data)};var vu=()=>{return useQuery({queryKey:["MembershipPlans"],queryFn:vc})};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/subscription/SubscriptionItem.tsx
var vd=250;// this is hack to fix layout shifting while animating.
var{tutor_currency:vf}=nK/* .tutorConfig */.P;function vp(){var e=e0();(0,v.useEffect)(()=>{var t=setTimeout(()=>{e.setFocus("plan_name")},vd);return()=>{clearTimeout(t)};// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);var t=e.watch("charge_enrollment_fee");// @TODO: Will be added after confirmation
// const enableTrial = form.watch(`subscriptions.${index}.enable_free_trial` as `subscriptions.0.enable_free_trial`);
var r=Object.values(h3);var n=[...h4.map(e=>({/* translators: %s: number of times. */label:(0,h.sprintf)((0,h.__)("%s times","tutor-pro"),e.toString()),value:String(e)})),...r.map(e=>({label:e,value:e}))];return/*#__PURE__*/(0,u/* .jsx */.Y)("form",{css:vh.subscription,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:rA/* .styleUtils.display.flex */.x.display.flex("column"),children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:vh.subscriptionContent,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"plan_name",rules:n2(),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oh,(0,w._)((0,_._)({},e),{placeholder:(0,h.__)("Enter plan name","tutor-pro"),label:(0,h.__)("Plan Name","tutor-pro")}))}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:vh.inputGroup,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"regular_price",rules:(0,w._)((0,_._)({},n2()),{validate:e=>{if(Number(e)<=0){return(0,h.__)("Price must be greater than 0","tutor-pro")}}}),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(a0,(0,w._)((0,_._)({},e),{label:(0,h.__)("Price","tutor-pro"),content:(vf===null||vf===void 0?void 0:vf.symbol)||"$",placeholder:(0,h.__)("Plan price","tutor-pro"),selectOnFocus:true,contentCss:rA/* .styleUtils.inputCurrencyStyle */.x.inputCurrencyStyle,type:"number"}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"recurring_value",rules:(0,w._)((0,_._)({},n2()),{validate:e=>{if(Number(e)<1){return(0,h.__)("This value must be equal to or greater than 1","tutor-pro")}}}),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oh,(0,w._)((0,_._)({},e),{label:(0,h.__)("Billing Interval","tutor-pro"),placeholder:(0,h.__)("12","tutor-pro"),selectOnFocus:true,type:"number"}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"recurring_interval",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(r1,(0,w._)((0,_._)({},e),{label:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{children:" "}),options:[{label:(0,h.__)("Day(s)","tutor-pro"),value:"day"},{label:(0,h.__)("Week(s)","tutor-pro"),value:"week"},{label:(0,h.__)("Month(s)","tutor-pro"),value:"month"},{label:(0,h.__)("Year(s)","tutor-pro"),value:"year"}],removeOptionsMinWidth:true}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"recurring_limit",rules:(0,w._)((0,_._)({},n2()),{validate:e=>{if(r.includes(e)){return true}if(Number(e)<=0){return(0,h.__)("Renew plan must be greater than 0","tutor-pro")}return true}}),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(cO,(0,w._)((0,_._)({},e),{label:(0,h.__)("Billing Cycles","tutor-pro"),placeholder:(0,h.__)("Select or type times to renewing the plan","tutor-pro"),content:!r.includes(e.field.value)&&(0,h.__)("Times","tutor-pro"),contentPosition:"right",type:"number",presetOptions:n,selectOnFocus:true}))})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"charge_enrollment_fee",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(aR/* ["default"] */.A,(0,w._)((0,_._)({},e),{label:(0,h.__)("Charge enrollment fee","tutor-pro")}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t,children:/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"enrollment_fee",rules:(0,w._)((0,_._)({},n2()),{validate:e=>{if(Number(e)<=0){return(0,h.__)("Enrollment fee must be greater than 0","tutor-pro")}return true}}),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(a0,(0,w._)((0,_._)({},e),{label:(0,h.__)("Enrollment fee","tutor-pro"),content:(vf===null||vf===void 0?void 0:vf.symbol)||"$",placeholder:(0,h.__)("Enter enrollment fee","tutor-pro"),selectOnFocus:true,contentCss:rA/* .styleUtils.inputCurrencyStyle */.x.inputCurrencyStyle,type:"number"}))})}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"do_not_provide_certificate",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(aR/* ["default"] */.A,(0,w._)((0,_._)({},e),{label:(0,h.__)("Do not provide certificate","tutor-pro")}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(tt,{control:e.control,name:"is_featured",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(aR/* ["default"] */.A,(0,w._)((0,_._)({},e),{label:(0,h.__)("Mark as featured","tutor-pro")}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(h6,{})]})})})}var vh={trialWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:1fr 1fr;align-items:start;gap:",rn/* .spacing["8"] */.YK["8"],";"),subscription:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",rn/* .borderRadius.card */.Vq.card,";overflow:hidden;transition:border-color 0.3s ease;"),subscriptionContent:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["16"] */.YK["16"],";display:flex;flex-direction:column;gap:",rn/* .spacing["12"] */.YK["12"],";"),inputGroup:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:1fr 0.7fr 1fr 1fr;align-items:start;gap:",rn/* .spacing["8"] */.YK["8"],";",rn/* .Breakpoint.smallMobile */.EA.smallMobile,"{grid-template-columns:1fr;}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/modals/SubscriptionModal.tsx
function vv(e){var{courseId:t,isBundle:r=false,icon:n,closeModal:o,subscription:a}=e;var i=rl({defaultValues:a||h5,mode:"onChange"});var s=vr(t);var l=i.formState.isDirty;var c=a.isSaved;var d=e=>rI(function*(){var n=h7((0,w._)((0,_._)({},e),{id:e.isSaved?e.id:"0",assign_id:String(t),plan_type:r?"bundle":"course"}));var a=yield s.mutateAsync(n);if(a.status_code===200||a.status_code===201){o({action:"CONFIRM"})}})();return/*#__PURE__*/(0,u/* .jsx */.Y)(e1,(0,w._)((0,_._)({},i),{children:/*#__PURE__*/(0,u/* .jsx */.Y)(c_,{onClose:()=>o({action:"CLOSE"}),icon:l?/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"warning",width:24,height:24}):n,title:l?rC/* .CURRENT_VIEWPORT.isAboveMobile */.vN.isAboveMobile?(0,h.__)("Unsaved Changes","tutor-pro"):"":(0,h.__)("Subscription Plan","tutor-pro"),subtitle:a.isSaved?(0,h.__)("Update plan","tutor-pro"):(0,h.__)("Create plan","tutor-pro"),maxWidth:1218,actions:l&&/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text",size:"small",onClick:()=>c?i.reset():o({action:"CLOSE"}),children:c?(0,h.__)("Discard Changes","tutor-pro"):(0,h.__)("Cancel","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{"data-cy":"save-subscription",loading:s.isPending,variant:"primary",size:"small",onClick:i.handleSubmit(d),children:c?(0,h.__)("Update","tutor-pro"):(0,h.__)("Save","tutor-pro")})]}),children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:vg.wrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:vg.container,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:vg.content,children:/*#__PURE__*/(0,u/* .jsx */.Y)(vp,{},a.id)})})})})}))}var vg={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;height:100%;"),container:/*#__PURE__*/(0,d/* .css */.AH)("max-width:640px;width:100%;padding-block:",rn/* .spacing["40"] */.YK["40"],";margin-inline:auto;display:flex;flex-direction:column;gap:",rn/* .spacing["32"] */.YK["32"],";",rn/* .Breakpoint.smallMobile */.EA.smallMobile,"{padding-block:",rn/* .spacing["24"] */.YK["24"],";padding-inline:",rn/* .spacing["8"] */.YK["8"],";}"),content:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["16"] */.YK["16"],";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/TutorBadge.tsx
var vm={default:{background:rn/* .colorTokens.background.status.drip */.I6.background.status.drip,foreground:rn/* .colorTokens.text.status.primary */.I6.text.status.primary,border:rn/* .colorTokens.stroke.neutral */.I6.stroke.neutral},secondary:{background:rn/* .colorTokens.background.status.cancelled */.I6.background.status.cancelled,foreground:rn/* .colorTokens.text.status.cancelled */.I6.text.status.cancelled,border:rn/* .colorTokens.stroke.status.cancelled */.I6.stroke.status.cancelled},critical:{background:rn/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,foreground:rn/* .colorTokens.text.status.failed */.I6.text.status.failed,border:rn/* .colorTokens.stroke.status.fail */.I6.stroke.status.fail},warning:{background:rn/* .colorTokens.background.status.warning */.I6.background.status.warning,foreground:rn/* .colorTokens.text.status.pending */.I6.text.status.pending,border:rn/* .colorTokens.stroke.status.warning */.I6.stroke.status.warning},success:{background:rn/* .colorTokens.background.status.success */.I6.background.status.success,foreground:rn/* .colorTokens.text.status.completed */.I6.text.status.completed,border:rn/* .colorTokens.stroke.status.success */.I6.stroke.status.success},outline:{background:rn/* .colorTokens.background.white */.I6.background.white,foreground:rn/* .colorTokens.text.status.cancelled */.I6.text.status.cancelled,border:rn/* .colorTokens.stroke.status.cancelled */.I6.stroke.status.cancelled}};var vb=/*#__PURE__*/g().forwardRef((e,t)=>{var{className:r,children:n,variant:o="default"}=e;return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{ref:t,className:r,css:vy.badge(o),children:n})});vb.displayName="TutorBadge";var vy={badge:e=>/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small("medium"),";display:inline-flex;align-items:center;border-radius:",rn/* .borderRadius["30"] */.Vq["30"],";padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["8"] */.YK["8"],";max-height:24px;",rA/* .styleUtils.textEllipsis */.x.textEllipsis,";border:1px solid ",vm[e].border,";background-color:",vm[e].background,";color:",vm[e].foreground,";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/molecules/ThreeDots.tsx
function v_(){var e=(0,x._)(["\n      padding-block: ",";\n    "]);v_=function t(){return e};return e}function vw(){var e=(0,x._)(["\n      padding: "," ",";\n      ",";\n    "]);vw=function t(){return e};return e}function vx(){var e=(0,x._)(["\n      color: ",";\n      svg {\n        color: ",";\n      }\n\n      &:hover:not(:disabled) {\n        color: ",";\n        background-color: ",";\n\n        svg {\n          color: ",";\n        }\n      }\n\n      &:active {\n        color: ",";\n        background-color: ",";\n\n        svg {\n          color: ",";\n        }\n      }\n    "]);vx=function t(){return e};return e}function vA(){var e=(0,x._)(["\n      background-color: ",";\n      svg {\n        color: ",";\n      }\n    "]);vA=function t(){return e};return e}function vk(){var e=(0,x._)(["\n      background-color: ",";\n      :hover {\n        background-color: ",";\n        svg {\n          color: ",";\n        }\n      }\n    "]);vk=function t(){return e};return e}var vY=e=>{var{text:t,icon:r,onClick:n,onClosePopover:o,isTrash:a=false,size:i="medium",buttonCss:s,disabled:l}=e,c=(0,rD._)(e,["text","icon","onClick","onClosePopover","isTrash","size","buttonCss","disabled"]);return/*#__PURE__*/(0,u/* .jsxs */.FD)("button",(0,w._)((0,_._)({type:"button",css:[vC.option({isTrash:a,size:i}),s],onClick:e=>{if(n){n(e)}if(o){o()}},disabled:l},c),{children:[r&&r,/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:t})]}))};var vI=e=>{var{onClick:t,isOpen:r,disabled:n=false,closePopover:o,placement:a=rf/* .POPOVER_PLACEMENTS.BOTTOM_RIGHT */.zA.BOTTOM_RIGHT,children:i,animationType:s=rL/* .AnimationType.slideLeft */.J6.slideLeft,dotsOrientation:l="horizontal",maxWidth:c="148px",isInverse:d=false,arrow:f=false,size:p="medium",closeOnEscape:h=true,wrapperCss:m}=e,b=(0,rD._)(e,["onClick","isOpen","disabled","closePopover","placement","children","animationType","dotsOrientation","maxWidth","isInverse","arrow","size","closeOnEscape","wrapperCss"]);var x=(0,v.useRef)(null);return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("button",(0,w._)((0,_._)({type:"button",ref:x,onClick:t,css:[vC.button({isOpen:r,isInverse:d,isDisabled:n}),m],disabled:n},b),{children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:l==="horizontal"?"threeDots":"threeDotsVertical",width:32,height:32})})),/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{gap:13,maxWidth:c,placement:a,triggerRef:x,isOpen:r,closePopover:o,animationType:s,arrow:f,closeOnEscape:h,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:vC.wrapper({size:p}),children:g().Children.map(i,e=>{if(/*#__PURE__*/g().isValidElement(e)){var t={size:p};return /*#__PURE__*/g().cloneElement(e,t)}return e})})})]})};vI.Option=vY;/* ESM default export */const vD=vI;var vC={wrapper:e=>{var{size:t="medium"}=e;return/*#__PURE__*/(0,d/* .css */.AH)("padding-block:",rn/* .spacing["8"] */.YK["8"],";position:relative;",t==="small"&&(0,d/* .css */.AH)(v_(),rn/* .spacing["4"] */.YK["4"]))},option:e=>{var{isTrash:t=false,size:r="medium"}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.body */.I.body(),";width:100%;padding:",rn/* .spacing["10"] */.YK["10"]," ",rn/* .spacing["20"] */.YK["20"],";transition:background-color 0.3s ease-in-out;cursor:pointer;display:flex;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";&:focus,&:active,&:hover{background:none;color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}svg{flex-shrink:0;color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";}",r==="small"&&(0,d/* .css */.AH)(vw(),rn/* .spacing["8"] */.YK["8"],rn/* .spacing["16"] */.YK["16"],ro/* .typography.small */.I.small("medium")),":hover:not(:disabled){background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";color:",rn/* .colorTokens.text.title */.I6.text.title,";svg{color:",rn/* .colorTokens.icon.hover */.I6.icon.hover,";filter:grayscale(0%);}}:disabled{cursor:not-allowed;color:",rn/* .colorTokens.text.disable */.I6.text.disable,";svg{color:",rn/* .colorTokens.icon.disable.background */.I6.icon.disable.background,";}}",t&&(0,d/* .css */.AH)(vx(),rn/* .colorTokens.text.error */.I6.text.error,rn/* .colorTokens.icon.error */.I6.icon.error,rn/* .colorTokens.text.error */.I6.text.error,oS()(rn/* .colorTokens.bg.error */.I6.bg.error,.1),rn/* .colorTokens.icon.error */.I6.icon.error,rn/* .colorTokens.text.error */.I6.text.error,rn/* .colorTokens.color.danger["40"] */.I6.color.danger["40"],rn/* .colorTokens.icon.error */.I6.icon.error),":focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:-4px;border-radius:",rn/* .borderRadius.input */.Vq.input,";}")},button:e=>{var{isOpen:t=false,isInverse:r=false,isDisabled:n=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";width:32px;height:32px;border-radius:",rn/* .borderRadius.circle */.Vq.circle,";display:flex;justify-content:center;align-items:center;transition:background-color 0.3s ease-in-out;svg{color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";flex-shrink:0;}:hover{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";svg{color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";}}&:focus,&:active{background:none;}&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}",t&&(0,d/* .css */.AH)(vA(),rn/* .colorTokens.background.hover */.I6.background.hover,rn/* .colorTokens.icon.brand */.I6.icon.brand)," ",r&&(0,d/* .css */.AH)(vk(),rn/* .colorTokens.background.white */.I6.background.white,rn/* .colorTokens.background.white */.I6.background.white,!n&&rn/* .colorTokens.icon.brand */.I6.icon.brand),":disabled{cursor:not-allowed;}")}};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/modals/ConfirmationModal.tsx
var vS=r(1385);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/utils/dndkit.ts
var vM=e=>cn((0,w._)((0,_._)({},e),{wasDragging:true}));var vE={droppable:{strategy:sV.Always}};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/subscription/PreviewItem.tsx
function vF(){var e=(0,x._)(["\n        overflow: hidden;\n        text-overflow: ellipsis;\n        max-width: 100%;\n        min-width: 0;\n      "]);vF=function t(){return e};return e}function vH(){var e=(0,x._)(["\n          overflow: unset;\n          text-overflow: unset;\n          animation: marquee-slide ","s ease-out forwards;\n          will-change: transform;\n\n          @keyframes marquee-slide {\n            0% {\n              transform: translateX(0);\n            }\n            100% {\n              transform: translateX(-","px);\n            }\n          }\n        "]);vH=function t(){return e};return e}function vT(){var e=(0,x._)(["\n      border-radius: ",";\n      box-shadow: ",";\n\n      [data-grabber] {\n        cursor: grabbing;\n      }\n    "]);vT=function t(){return e};return e}function vO(){var e=(0,x._)(["\n      overflow: hidden;\n      text-overflow: ellipsis;\n      max-width: 100%;\n      min-width: 0;\n    "]);vO=function t(){return e};return e}var vK=60;var vN=(e,t)=>{switch(e){case"hour":return t>1?(0,h.__)("Hours","tutor-pro"):(0,h.__)("Hour","tutor-pro");case"day":return t>1?(0,h.__)("Days","tutor-pro"):(0,h.__)("Day","tutor-pro");case"week":return t>1?(0,h.__)("Weeks","tutor-pro"):(0,h.__)("Week","tutor-pro");case"month":return t>1?(0,h.__)("Months","tutor-pro"):(0,h.__)("Month","tutor-pro");case"year":return t>1?(0,h.__)("Years","tutor-pro"):(0,h.__)("Year","tutor-pro");case"until_cancellation":return(0,h.__)("Until Cancellation","tutor-pro")}};var vP=e=>{var{subscription:t,courseId:r,isBundle:n,isOverlay:o}=e;var a;var[i,s]=(0,v.useState)(false);var[l,c]=(0,v.useState)(0);var[d,f]=(0,v.useState)(0);var{showModal:p,updateModal:g,closeModal:m}=(0,nO/* .useModal */.h)();var b=vr(r);var x=vo(r);var A=vi(r);var k=(0,v.useRef)(null);var Y=(0,v.useRef)(null);var{attributes:I,listeners:D,setNodeRef:C,transform:S,transition:M,isDragging:E}=cc({id:t.id||"",animateLayoutChanges:vM});var F={transform:i_.Transform.toString(S),transition:M,opacity:E?.3:undefined,background:E?rn/* .colorTokens.stroke.hover */.I6.stroke.hover:undefined};var H=(0,v.useMemo)(()=>{var e="".concat(t.recurring_limit.toString().padStart(2,"0")," ").concat((0,h.__)("Billing Cycles","tutor-pro"));if(t.recurring_limit===h3.untilCancelled){e=(0,h.__)("Until Cancellation","tutor-pro")}if(t.recurring_limit===h3.noRenewal){e=(0,h.__)("No Renewal","tutor-pro")}return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:"•"}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:e})]})},[t.recurring_limit]);var T=(0,v.useMemo)(()=>/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t.payment_type==="recurring",fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:(0,h.__)("Lifetime","tutor-pro")}),children:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t.recurring_limit!==h3.noRenewal,fallback:"".concat(t.recurring_value.toString().padStart(2,"0")," ").concat(vN(t.recurring_interval,Number(t.recurring_value))),children:(0,h.sprintf)((0,h.__)("Renew every %1$s %2$s","tutor-pro"),t.recurring_value.toString().padStart(2,"0"),vN(t.recurring_interval,Number(t.recurring_value)))})})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t.payment_type!=="onetime",children:H})]}),[t.payment_type,t.recurring_limit,t.recurring_interval,t.recurring_value,H]);var O=(0,v.useCallback)(e=>{var r=h7(t);b.mutate((0,w._)((0,_._)({},r),{is_enabled:e?"1":"0"}))},[t,b]);var K=(0,v.useCallback)(()=>{var e=(0,w._)((0,_._)({},t),{isSaved:true});p({component:vv,props:{icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"dollarRecurring",width:24,height:24}),subscription:e,courseId:r,isBundle:n}});s(false)},[t,p,r,n]);var N=(0,v.useCallback)(()=>rI(function*(){g("subscription-delete-modal",{isLoading:true});var e=yield x.mutateAsync(Number(t.id));if(e.status_code===200){m()}})(),[g,x,t.id,m]);var P=(0,v.useCallback)(()=>rI(function*(){var e=yield A.mutateAsync(Number(t.id));if(e.data){s(false)}})(),[A,t.id]);var L=(0,v.useCallback)(e=>{if(e.key==="Enter"||e.key===" "){K()}},[K]);var W=(0,v.useCallback)(()=>{s(false);p({id:"subscription-delete-modal",component:vS/* ["default"] */.A,props:{title:(0,h.sprintf)((0,h.__)('Delete "%s"',"tutor-pro"),t.plan_name),description:(0,h.__)("Are you sure you want to delete this plan? This cannot be undone.","tutor-pro"),onConfirm:N,confirmButtonVariant:"danger"}})},[p,t.plan_name,N]);(0,v.useEffect)(()=>{var e=k.current;var t=Y.current;if(!e||!t){return}var r=t.scrollWidth>e.clientWidth;if(r){var n=t.scrollWidth-e.clientWidth;f(n);c(n/vK)}},[t.plan_name,t.payment_type,t.recurring_value,t.recurring_interval,t.recurring_limit]);return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{"data-cy":"subscription-preview-item",css:vL.wrapper({isActionButtonVisible:i||b.isPending,isOverlay:o,marqueeDuration:l,marqueeDistance:d}),style:F,ref:C,"aria-label":(0,h.__)("Subscription plan item","tutor-pro"),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,(0,w._)((0,_._)({},D,I),{"data-grabber":true,name:"threeDotsVerticalDouble",width:20,height:20})),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:vL.item,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:vL.header,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("p",{css:vL.title,onClick:K,onKeyDown:L,tabIndex:0,"aria-label":(0,h.__)("Edit subscription plan","tutor-pro"),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("span",{"data-plan-name":true,title:t.plan_name,children:t.plan_name}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t.is_featured,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{style:vL.featuredIcon,name:"star",height:20,width:20})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!t.is_enabled,children:/*#__PURE__*/(0,u/* .jsx */.Y)(vb,{css:vL.badge,variant:"secondary",title:(0,h.__)("Inactive","tutor-pro"),children:(0,h.__)("Inactive","tutor-pro")})})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:vL.actionButtons,"data-action-buttons":true,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(nZ,{checked:t.is_enabled,onChange:O,loading:b.isPending,size:"small"}),/*#__PURE__*/(0,u/* .jsxs */.FD)(vD,{isOpen:i,closePopover:()=>s(false),onClick:()=>s(!i),dotsOrientation:"vertical",size:"small",arrow:true,"data-three-dot":true,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(vD.Option,{icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"edit",width:16,height:16}),text:(0,h.__)("Edit","tutor-pro"),"data-cy":"edit-subscription",onClick:K}),/*#__PURE__*/(0,u/* .jsx */.Y)(vD.Option,{icon:A.isPending?/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* ["default"] */.Ay,{size:16}):/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"duplicate",width:16,height:16}),text:(0,h.__)("Duplicate","tutor-pro"),onClick:P}),/*#__PURE__*/(0,u/* .jsx */.Y)(vD.Option,{icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"delete",width:16,height:16}),text:(0,h.__)("Delete","tutor-pro"),isTrash:true,onClick:W})]})]})]}),/*#__PURE__*/(0,u/* .jsx */.Y)("p",{css:vL.information,ref:k,"aria-label":(0,h.__)("Subscription plan details","tutor-pro"),title:(a=k.current)===null||a===void 0?void 0:a.textContent,children:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:vL.marqueeSlide,ref:Y,"data-marquee-content":true,children:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:T})})})]})]})};var vL={wrapper:e=>{var{isActionButtonVisible:t=false,isOverlay:r=false,marqueeDuration:n=0,marqueeDistance:o=0}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";gap:",rn/* .spacing["4"] */.YK["4"],";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["12"] */.YK["12"]," ",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["4"] */.YK["4"],";min-width:0;[data-grabber]{align-self:flex-start;margin-top:",rn/* .spacing["2"] */.YK["2"],";color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";flex-shrink:0;cursor:grab;&:focus-visible{border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";}}[data-three-dot]{height:20px;width:20px;svg{height:24px;width:24px;flex-shrink:0;}}[data-action-buttons]{opacity:",t?1:0,";background-color:inherit;}[data-marquee-content]{",o>0&&(0,d/* .css */.AH)(vF()),"}&:hover{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";[data-action-buttons]{opacity:1;}[data-marquee-content]{",o>0&&(0,d/* .css */.AH)(vH(),n,o),"}}&:not(:last-of-type){border-bottom:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";}&:focus-within{[data-action-buttons]{opacity:1;}}",r&&(0,d/* .css */.AH)(vT(),rn/* .borderRadius.card */.Vq.card,rn/* .shadow.drag */.r7.drag))},item:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;min-height:48px;",rA/* .styleUtils.display.flex */.x.display.flex("column"),";justify-content:center;gap:",rn/* .spacing["4"] */.YK["4"],";min-width:0;"),header:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";justify-content:space-between;gap:",rn/* .spacing["8"] */.YK["8"],";min-width:0;"),title:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption("medium"),";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";display:flex;align-items:center;cursor:pointer;[data-plan-name]{",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),";}&:focus-visible{border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";}"),information:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;max-width:100%;min-width:0;",ro/* .typography.small */.I.small(),";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";display:flex;align-items:center;flex-grow:1;overflow:hidden;position:relative;white-space:nowrap;"),marqueeContent:e=>{var{shouldEllipsis:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)("display:inline-block;white-space:nowrap;vertical-align:middle;min-width:100%;span{margin-right:",rn/* .spacing["4"] */.YK["4"],";white-space:nowrap;&:last-child{margin-right:0;}}",t&&(0,d/* .css */.AH)(vO()))},marqueeSlide:/*#__PURE__*/(0,d/* .css */.AH)("display:inline-block;white-space:nowrap;vertical-align:middle;min-width:100%;span{margin-right:",rn/* .spacing["4"] */.YK["4"],";white-space:nowrap;&:last-child{margin-right:0;}}"),featuredIcon:/*#__PURE__*/(0,d/* .css */.AH)("flex-shrink:0;color:",rn/* .colorTokens.icon.brand */.I6.icon.brand,";"),actionButtons:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";height:100%;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";"),badge:/*#__PURE__*/(0,d/* .css */.AH)("flex-shrink:0;margin-left:",rn/* .spacing["8"] */.YK["8"],";font-size:",rn/* .fontSize["11"] */.J["11"],";padding:0 ",rn/* .spacing["6"] */.YK["6"],";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/subscription/SubscriptionPreview.tsx
function vW(){var e=(0,x._)(["\n      border: none;\n    "]);vW=function t(){return e};return e}var vB=e=>{var{courseId:t,isBundle:r=false}=e;var n=ve(t);var o=vl(t);var{showModal:a}=(0,nO/* .useModal */.h)();var[i,s]=(0,v.useState)(null);var l=iK(iO(sE,{activationConstraint:{distance:10}}),iO(sI,{coordinateGetter:cp}));var c=rl({defaultValues:{subscriptions:[]},mode:"onChange"});var{move:d,fields:f}=t7({control:c.control,name:"subscriptions",keyName:"_id"});var p=n.data;(0,v.useEffect)(()=>{if(!p){return}if(f.length===0){return c.reset({subscriptions:p.map(e=>(0,w._)((0,_._)({},h8(e)),{isSaved:true}))})}var e=p.map(e=>{var t=f.find(t=>t.id===e.id);if(t){return(0,_._)({},t,(0,w._)((0,_._)({},h8(e)),{isSaved:true}))}return(0,w._)((0,_._)({},h8(e)),{isSaved:true})});c.reset({subscriptions:e});// eslint-disable-next-line react-hooks/exhaustive-deps
},[p,n.isLoading]);if(n.isLoading){return/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* .LoadingSection */.YE,{})}if(!n.data){return null}return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:vz.outer,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:f.length>0,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:vz.header,children:(0,h.__)("Subscriptions","tutor-pro")})}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:vz.inner({hasSubscriptions:f.length>0}),children:[/*#__PURE__*/(0,u/* .jsxs */.FD)(lb,{sensors:l,collisionDetection:ij,measuring:vE,modifiers:[lU],onDragStart:e=>{s(e.active.id)},onDragEnd:e=>rI(function*(){var{active:t,over:r}=e;if(!r){s(null);return}if(t.id!==r.id){var n=f.findIndex(e=>e.id===t.id);var a=f.findIndex(e=>e.id===r.id);var i=(0,rb/* .moveTo */.tw)(f,n,a);d(n,a);o.mutateAsync(i.map(e=>Number(e.id)))}s(null)})(),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ct,{items:f,strategy:l8,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:f,children:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(vP,{subscription:e,courseId:t,isBundle:r},e.id)})}),/*#__PURE__*/(0,a6.createPortal)(/*#__PURE__*/(0,u/* .jsx */.Y)(lW,{children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:i,children:e=>{var n=f.find(t=>t.id===e);if(!n){return null}return/*#__PURE__*/(0,u/* .jsx */.Y)(vP,{subscription:n,courseId:t,isBundle:r,isOverlay:true},e)}})}),document.body)]}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:vz.emptyState({hasSubscriptions:f.length>0}),children:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{"data-cy":"add-subscription",variant:"secondary",icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"dollarRecurring",width:24,height:24}),onClick:()=>{a({component:vv,props:{title:(0,h.__)("Manage Subscription Plans","tutor-pro"),icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"dollarRecurring",width:24,height:24}),subscription:(0,w._)((0,_._)({},h5),{plan_order:String(f.length+1),isSaved:false}),courseId:t,isBundle:r}})},children:(0,h.__)("Add Subscription","tutor-pro")})})]})]})};/* ESM default export */const vR=vB;var vz={outer:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";"),inner:e=>{var{hasSubscriptions:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("background:",rn/* .colorTokens.background.white */.I6.background.white,";border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",rn/* .borderRadius.card */.Vq.card,";width:100%;overflow:hidden;",!t&&(0,d/* .css */.AH)(vW()))},header:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;justify-content:space-between;",ro/* .typography.body */.I.body(),";color:",rn/* .colorTokens.text.title */.I6.text.title,";"),emptyState:e=>{var{hasSubscriptions:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("padding:",t?"".concat(rn/* .spacing["8"] */.YK["8"]," ").concat(rn/* .spacing["12"] */.YK["12"]):0,";width:100%;& > button{width:100%;}")}};// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/utils/utils.ts
var vV=r(2621);// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/BundlePricing.tsx
var vj,vq,vU,vG;var vQ=(0,vV/* .getBundleId */.w)();var{tutor_currency:vX}=nK/* .tutorConfig */.P;var v$=!!((vj=nK/* .tutorConfig.settings */.P.settings)===null||vj===void 0?void 0:vj.enable_tax);var vZ=!!((vq=nK/* .tutorConfig.settings */.P.settings)===null||vq===void 0?void 0:vq.enable_individual_tax_control);var vJ=!!((vU=nK/* .tutorConfig.settings */.P.settings)===null||vU===void 0?void 0:vU.is_tax_included_in_price);var v0=(vG=nK/* .tutorConfig.settings */.P.settings)===null||vG===void 0?void 0:vG.monetize_by;var v1=()=>{var e,t,r;var n=(0,m/* .useFormContext */.xW)();var o=(0,p/* .useIsFetching */.C)({queryKey:["CourseBundle",vQ]});var a=Number(n.getValues("details.subtotal_raw_price")).toFixed(2)||0;var i=(0,m/* .useWatch */.FH)({control:n.control,name:"course_selling_option"});var c=[{label:(0,h.__)("One-time purchase only","tutor-pro"),value:"one_time"},{label:(0,h.__)("Subscription only","tutor-pro"),value:"subscription"},{label:(0,h.__)("Subscription & one-time purchase","tutor-pro"),value:"both"}];// prettier-ignore
var d=(0,h.__)("You have unchecked the Tax Collection option. Please review your pricing, as your tax settings currently indicate that prices are inclusive of tax.","tutor-pro");return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:(0,rb/* .isAddonEnabled */.GR)(rC/* .Addons.SUBSCRIPTION */.oW.SUBSCRIPTION)&&((e=nK/* .tutorConfig.settings */.P.settings)===null||e===void 0?void 0:e.monetize_by)==="tutor",children:/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"course_selling_option",control:n.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(r1,(0,l._)((0,s._)({},e),{label:(0,h.__)("Purchase Options","tutor-pro"),options:c}))})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!["subscription"].includes(i)||((t=nK/* .tutorConfig.settings */.P.settings)===null||t===void 0?void 0:t.monetize_by)==="wc",children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:v2.coursePriceWrapper,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:v2.regularPrice,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("label",{children:(0,h.__)("Regular Price","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{children:[(vX===null||vX===void 0?void 0:vX.symbol)||"$"," ",a]})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"details.subtotal_raw_sale_price",control:n.control,rules:{validate:e=>{if(!e){return true}if(Number(e)>=Number(a)){return(0,h.__)("Sale price must be less than regular price","tutor-pro")}return true}},render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(a0,(0,l._)((0,s._)({},e),{label:(0,h.__)("Sale Price","tutor-pro"),content:(vX===null||vX===void 0?void 0:vX.symbol)||"$",placeholder:(0,h.__)("0","tutor-pro"),type:"number",loading:!!o&&!e.field.value,selectOnFocus:true,contentCss:rA/* .styleUtils.inputCurrencyStyle */.x.inputCurrencyStyle}))})]})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:(0,rb/* .isAddonEnabled */.GR)(rC/* .Addons.SUBSCRIPTION */.oW.SUBSCRIPTION)&&((r=nK/* .tutorConfig.settings */.P.settings)===null||r===void 0?void 0:r.monetize_by)==="tutor",children:/*#__PURE__*/(0,u/* .jsx */.Y)(vR,{courseId:vQ,isBundle:true})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:v0==="tutor"&&v$&&vZ,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:v2.taxWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("label",{children:(0,h.__)("Tax Collection","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:v2.checkboxWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:["one_time","both","all"].includes(i),children:/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"tax_on_single",control:n.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(aR/* ["default"] */.A,(0,l._)((0,s._)({},e),{label:(0,h.__)("Charge tax on one-time purchase ","tutor-pro"),helpText:vJ&&!e.field.value?d:""}))})}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:(0,rb/* .isAddonEnabled */.GR)(rC/* .Addons.SUBSCRIPTION */.oW.SUBSCRIPTION)&&["subscription","both","all"].includes(i),children:/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"tax_on_subscription",control:n.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(aR/* ["default"] */.A,(0,l._)((0,s._)({},e),{label:(0,h.__)("Charge tax on subscription","tutor-pro"),helpText:vJ&&!e.field.value?d:""}))})})]})]})})]})};/* ESM default export */const v6=v1;var v2={priceRadioGroup:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["36"] */.YK["36"],";"),coursePriceWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:1fr 1fr;place-items:start;gap:",rn/* .spacing["16"] */.YK["16"],";"),regularPrice:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["4"] */.YK["4"],";label{",ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.title */.I6.text.title,";}div{",ro/* .typography.body */.I.body(),";",rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;color:",rn/* .colorTokens.text.title */.I6.text.title,";height:40px;}"),taxWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),"    gap:",rn/* .spacing["4"] */.YK["4"],";label{",ro/* .typography.body */.I.body(),"      color:",rn/* .colorTokens.text.title */.I6.text.title,";}"),checkboxWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),"    gap:",rn/* .spacing["4"] */.YK["4"],";"),taxAlert:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),"    gap:",rn/* .spacing["8"] */.YK["8"],";margin-top:",rn/* .spacing["8"] */.YK["8"],";padding:",rn/* .spacing["12"] */.YK["12"],";background-color:",rn/* .colorTokens.color.warning["40"] */.I6.color.warning["40"],";border:1px solid ",rn/* .colorTokens.color.warning["50"] */.I6.color.warning["50"],";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";"),alertTitle:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),"    gap:",rn/* .spacing["4"] */.YK["4"],";align-items:center;",ro/* .typography.caption */.I.caption("medium"),";color:",rn/* .colorTokens.color.warning["100"] */.I6.color.warning["100"],";svg{color:",rn/* .colorTokens.design.warning */.I6.design.warning,";flex-shrink:0;}"),alertDescription:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),"    color:",rn/* .colorTokens.color.warning["100"] */.I6.color.warning["100"],";")};// EXTERNAL MODULE: ./node_modules/date-fns/constructFrom.js
var v4=r(3753);// EXTERNAL MODULE: ./node_modules/date-fns/toDate.js
var v3=r(4007);// CONCATENATED MODULE: ./node_modules/date-fns/addMilliseconds.js
/**
 * The {@link addMilliseconds} function options.
 *//**
 * @name addMilliseconds
 * @category Millisecond Helpers
 * @summary Add the specified number of milliseconds to the given date.
 *
 * @description
 * Add the specified number of milliseconds to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The date to be changed
 * @param amount - The amount of milliseconds to be added.
 * @param options - The options object
 *
 * @returns The new date with the milliseconds added
 *
 * @example
 * // Add 750 milliseconds to 10 July 2014 12:45:30.000:
 * const result = addMilliseconds(new Date(2014, 6, 10, 12, 45, 30, 0), 750)
 * //=> Thu Jul 10 2014 12:45:30.750
 */function v5(e,t,r){return(0,v4/* .constructFrom */.w)(r?.in||e,+(0,v3/* .toDate */.a)(e)+t)}// Fallback for modularized imports:
/* ESM default export */const v8=/* unused pure expression or super */null&&v5;// EXTERNAL MODULE: ./node_modules/date-fns/constants.js
var v7=r(7669);// CONCATENATED MODULE: ./node_modules/date-fns/addHours.js
/**
 * The {@link addHours} function options.
 *//**
 * @name addHours
 * @category Hour Helpers
 * @summary Add the specified number of hours to the given date.
 *
 * @description
 * Add the specified number of hours to the given date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The date to be changed
 * @param amount - The amount of hours to be added
 * @param options - An object with options
 *
 * @returns The new date with the hours added
 *
 * @example
 * // Add 2 hours to 10 July 2014 23:00:00:
 * const result = addHours(new Date(2014, 6, 10, 23, 0), 2)
 * //=> Fri Jul 11 2014 01:00:00
 */function v9(e,t,r){return v5(e,t*v7/* .millisecondsInHour */.s0,r)}// Fallback for modularized imports:
/* ESM default export */const ge=/* unused pure expression or super */null&&v9;// EXTERNAL MODULE: ./node_modules/date-fns/isValid.js + 1 modules
var gt=r(8775);// EXTERNAL MODULE: ./node_modules/date-fns/isBefore.js
var gr=r(9817);// EXTERNAL MODULE: ./node_modules/date-fns/parseISO.js
var gn=r(4522);// EXTERNAL MODULE: ./node_modules/date-fns/startOfDay.js
var go=r(1671);// CONCATENATED MODULE: ./node_modules/date-fns/startOfMinute.js
/**
 * The {@link startOfMinute} function options.
 *//**
 * @name startOfMinute
 * @category Minute Helpers
 * @summary Return the start of a minute for the given date.
 *
 * @description
 * Return the start of a minute for the given date.
 * The result will be in the local timezone.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param date - The original date
 * @param options - An object with options
 *
 * @returns The start of a minute
 *
 * @example
 * // The start of a minute for 1 December 2014 22:15:45.400:
 * const result = startOfMinute(new Date(2014, 11, 1, 22, 15, 45, 400))
 * //=> Mon Dec 01 2014 22:15:00
 */function ga(e,t){const r=(0,v3/* .toDate */.a)(e,t?.in);r.setSeconds(0,0);return r}// Fallback for modularized imports:
/* ESM default export */const gi=/* unused pure expression or super */null&&ga;// CONCATENATED MODULE: ./node_modules/date-fns/isSameMinute.js
/**
 * @name isSameMinute
 * @category Minute Helpers
 * @summary Are the given dates in the same minute (and hour and day)?
 *
 * @description
 * Are the given dates in the same minute (and hour and day)?
 *
 * @param laterDate - The first date to check
 * @param earlierDate - The second date to check
 *
 * @returns The dates are in the same minute (and hour and day)
 *
 * @example
 * // Are 4 September 2014 06:30:00 and 4 September 2014 06:30:15 in the same minute?
 * const result = isSameMinute(
 *   new Date(2014, 8, 4, 6, 30),
 *   new Date(2014, 8, 4, 6, 30, 15)
 * )
 * //=> true
 *
 * @example
 * // Are 4 September 2014 06:30:00 and 5 September 2014 06:30:00 in the same minute?
 * const result = isSameMinute(
 *   new Date(2014, 8, 4, 6, 30),
 *   new Date(2014, 8, 5, 6, 30)
 * )
 * //=> false
 */function gs(e,t){return+ga(e)===+ga(t)}// Fallback for modularized imports:
/* ESM default export */const gl=/* unused pure expression or super */null&&gs;// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/ScheduleOptions.tsx
var gc=()=>{var e=(0,m/* .useFormContext */.xW)();var t=(0,m/* .useWatch */.FH)({name:"post_date"});var r;var n=(r=(0,m/* .useWatch */.FH)({name:"schedule_date"}))!==null&&r!==void 0?r:"";var o;var a=(o=(0,m/* .useWatch */.FH)({name:"schedule_time"}))!==null&&o!==void 0?o:(0,b/* .format */.GP)(v9(new Date,1),rC/* .DateFormats.hoursMinutes */.UA.hoursMinutes);var i;var c=(i=(0,m/* .useWatch */.FH)({name:"isScheduleEnabled"}))!==null&&i!==void 0?i:false;var d;var f=(d=(0,m/* .useWatch */.FH)({name:"showScheduleForm"}))!==null&&d!==void 0?d:false;var[p,g]=(0,v.useState)(n&&a&&(0,gt/* .isValid */.f)(new Date("".concat(n," ").concat(a)))?(0,b/* .format */.GP)(new Date("".concat(n," ").concat(a)),rC/* .DateFormats.yearMonthDayHourMinuteSecond24H */.UA.yearMonthDayHourMinuteSecond24H):"");var _=()=>{e.setValue("schedule_date","",{shouldDirty:true});e.setValue("schedule_time","",{shouldDirty:true});e.setValue("showScheduleForm",true,{shouldDirty:true})};var w=()=>{var r=(0,gr/* .isBefore */.Y)(new Date(t),new Date);e.setValue("schedule_date",r&&p?(0,b/* .format */.GP)((0,gn/* .parseISO */.H)(p),rC/* .DateFormats.yearMonthDay */.UA.yearMonthDay):"",{shouldDirty:true});e.setValue("schedule_time",r&&p?(0,b/* .format */.GP)((0,gn/* .parseISO */.H)(p),rC/* .DateFormats.hoursMinutes */.UA.hoursMinutes):"",{shouldDirty:true})};var x=()=>{if(!n||!a){return}e.setValue("showScheduleForm",false,{shouldDirty:true});g((0,b/* .format */.GP)(new Date("".concat(n," ").concat(a)),rC/* .DateFormats.yearMonthDayHourMinuteSecond24H */.UA.yearMonthDayHourMinuteSecond24H))};(0,v.useEffect)(()=>{if(c&&f){e.setFocus("schedule_date")}// eslint-disable-next-line react-hooks/exhaustive-deps
},[f,c]);return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gd.scheduleOptions,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"isScheduleEnabled",control:e.control,render:t=>/*#__PURE__*/(0,u/* .jsx */.Y)(n0,(0,l._)((0,s._)({},t),{label:(0,h.__)("Schedule","tutor-pro"),onChange:t=>{if(!t&&n&&a){e.setValue("showScheduleForm",false,{shouldDirty:true})}}}))}),c&&f&&/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gd.formWrapper,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:rA/* .styleUtils.dateAndTimeWrapper */.x.dateAndTimeWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"schedule_date",control:e.control,rules:{required:(0,h.__)("Schedule date is required.","tutor-pro"),validate:{invalidDateRule:n5,futureDate:e=>{if((0,gr/* .isBefore */.Y)(new Date("".concat(e)),(0,go/* .startOfDay */.o)(new Date))){return(0,h.__)("Schedule date should be in the future.","tutor-pro")}return true}}},render:t=>/*#__PURE__*/(0,u/* .jsx */.Y)(hR,(0,l._)((0,s._)({},t),{isClearable:false,placeholder:(0,h.__)("Select date","tutor-pro"),disabledBefore:(0,b/* .format */.GP)(new Date,rC/* .DateFormats.yearMonthDay */.UA.yearMonthDay),onChange:()=>{e.setFocus("schedule_time")},dateFormat:rC/* .DateFormats.monthDayYear */.UA.monthDayYear}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"schedule_time",control:e.control,rules:{required:(0,h.__)("Schedule time is required.","tutor-pro"),validate:{invalidTimeRule:n7,futureDate:t=>{if((0,gr/* .isBefore */.Y)(new Date("".concat(e.watch("schedule_date")," ").concat(t)),new Date)){return(0,h.__)("Schedule time should be in the future.","tutor-pro")}return true}}},render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(hJ,(0,l._)((0,s._)({},e),{interval:60,isClearable:false,placeholder:"hh:mm A"}))})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gd.scheduleButtonsWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"tertiary",size:"small",onClick:w,disabled:!n&&!a||(0,gt/* .isValid */.f)(new Date("".concat(n," ").concat(a)))&&gs(new Date("".concat(n," ").concat(a)),new Date(p)),children:(0,h.__)("Cancel","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"secondary",size:"small",onClick:e.handleSubmit(x),disabled:!n||!a,children:(0,h.__)("Ok","tutor-pro")})]})]}),c&&!f&&/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gd.scheduleInfoWrapper,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gd.scheduledFor,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gd.scheduleLabel,children:(0,h.__)("Scheduled for","tutor-pro")}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gd.scheduleInfoButtons,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:rA/* .styleUtils.actionButton */.x.actionButton,onClick:_,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"delete",width:24,height:24})}),/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:rA/* .styleUtils.actionButton */.x.actionButton,onClick:()=>{e.setValue("showScheduleForm",true,{shouldDirty:true})},children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"edit",width:24,height:24})})]})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:n&&a&&(0,gt/* .isValid */.f)(new Date("".concat(n," ").concat(a))),children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gd.scheduleInfo,children:(0,h.sprintf)((0,h.__)("%1$s at %2$s","tutor-pro"),(0,b/* .format */.GP)((0,gn/* .parseISO */.H)(n),rC/* .DateFormats.monthDayYear */.UA.monthDayYear),a)})})]})]})};/* ESM default export */const gu=gc;var gd={scheduleOptions:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["12"] */.YK["12"],";border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",rn/* .borderRadius["8"] */.Vq["8"],";gap:",rn/* .spacing["8"] */.YK["8"],";background-color:",rn/* .colorTokens.bg.white */.I6.bg.white,";"),formWrapper:/*#__PURE__*/(0,d/* .css */.AH)("margin-top:",rn/* .spacing["16"] */.YK["16"],";"),scheduleButtonsWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;gap:",rn/* .spacing["12"] */.YK["12"],";margin-top:",rn/* .spacing["8"] */.YK["8"],";button{width:100%;span{justify-content:center;}}"),scheduleInfoWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";margin-top:",rn/* .spacing["12"] */.YK["12"],";"),scheduledFor:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;justify-content:space-between;"),scheduleLabel:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";"),scheduleInfoButtons:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";"),scheduleInfo:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";background-color:",rn/* .colorTokens.background.status.processing */.I6.background.status.processing,";padding:",rn/* .spacing["8"] */.YK["8"],";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";text-align:center;")};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/BundleSidebar.tsx
var gf,gp;var gh=(0,vV/* .getBundleId */.w)();var gv=!!nK/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url;var gg=((gf=nK/* .tutorConfig.settings */.P.settings)===null||gf===void 0?void 0:gf.chatgpt_enable)==="on";var gm=(0,rb/* .isAddonEnabled */.GR)(rC/* .Addons.SUBSCRIPTION */.oW.SUBSCRIPTION)&&((gp=nK/* .tutorConfig.settings */.P.settings)===null||gp===void 0?void 0:gp.membership_only_mode);var gb=[{label:(0,h.__)("Show Discount % Off","tutor-pro"),value:"in_percentage"},{label:(0,h.sprintf)((0,h.__)("Show Discount Amount (%s)","tutor-pro"),nK/* .tutorConfig.tutor_currency.symbol */.P.tutor_currency.symbol),value:"in_amount"},{label:(0,h.__)("Show None","tutor-pro"),value:"none"}];var gy=()=>{var e=(0,m/* .useFormContext */.xW)();var t=(0,p/* .useIsFetching */.C)({queryKey:["CourseBundle",gh]});var r=e.watch("details.authors");var n=e.watch("post_modified");var o=e.watch("visibility");return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gw.sidebar,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gw.statusAndDate,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"visibility",control:e.control,render:r=>/*#__PURE__*/(0,u/* .jsx */.Y)(r1,(0,l._)((0,s._)({},r),{label:(0,h.__)("Visibility","tutor-pro"),placeholder:(0,h.__)("Select visibility status","tutor-pro"),options:rC/* .visibilityStatusOptions */.tv,leftIcon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"eye",width:32,height:32}),loading:!!t&&!r.field.value,onChange:()=>{e.setValue("post_password","")}}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:n,children:e=>/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gw.updatedOn,children:(0,h.sprintf)((0,h.__)("Last updated on %s","tutor-pro"),(0,b/* .format */.GP)(new Date(e),rC/* .DateFormats.dayMonthYear */.UA.dayMonthYear)||"")})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:o==="password_protected",children:/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"post_password",control:e.control,rules:{required:(0,h.__)("Password is required","tutor-pro")},render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oh,(0,l._)((0,s._)({},e),{label:(0,h.__)("Password","tutor-pro"),placeholder:(0,h.__)("Enter password","tutor-pro"),type:"password",isPassword:true,loading:!!t&&!e.field.value}))})}),/*#__PURE__*/(0,u/* .jsx */.Y)(gu,{}),/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"thumbnail",control:e.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(aB,(0,l._)((0,s._)({},e),{label:(0,h.__)("Featured Image","tutor-pro"),buttonText:(0,h.__)("Upload Thumbnail","tutor-pro"),infoText:(0,h.sprintf)((0,h.__)("JPEG, PNG, GIF, and WebP formats, up to %s","tutor-pro"),nK/* .tutorConfig.max_upload_size */.P.max_upload_size),generateWithAi:!gv||gg,loading:!!t&&!e.field.value}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!gm,children:/*#__PURE__*/(0,u/* .jsx */.Y)(v6,{})}),/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"ribbon_type",control:e.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(r1,(0,l._)((0,s._)({},e),{label:(0,h.__)("Select Ribbon to Display","tutor-pro"),placeholder:(0,h.__)("Select ribbon","tutor-pro"),options:gb,loading:!!t&&!e.field.value}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"details.categories",control:e.control,render:e=>{var r;return/*#__PURE__*/(0,u/* .jsx */.Y)(ok,(0,l._)((0,s._)({},e),{field:(0,l._)((0,s._)({},e.field),{value:(r=e.field.value)===null||r===void 0?void 0:r.map(e=>e.term_id)}),label:(0,h.__)("Categories","tutor-pro"),disabled:true,loading:!!t&&!e.field.value}))}}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:r.length>0,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gw.labelWithContent,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("label",{children:(0,h.__)("Instructors","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gw.instructorsWrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:r,children:e=>/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gw.instructor,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:e.avatar_url,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{"data-avatar":true,children:e.display_name.charAt(0).toUpperCase()}),children:/*#__PURE__*/(0,u/* .jsx */.Y)("img",{src:e.avatar_url,alt:e.display_name,"data-avatar":true})}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{"data-name":"instructor-name",children:e.display_name}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{"data-name":"instructor-email",children:e.user_email})]})]},e.user_id)})})]})})]})};/* ESM default export */const g_=gy;var gw={sidebar:/*#__PURE__*/(0,d/* .css */.AH)("border-left:1px solid ",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";min-height:calc(100vh - ",rn/* .headerHeight */.$A,"px);padding-left:",rn/* .spacing["32"] */.YK["32"],";padding-block:",rn/* .spacing["24"] */.YK["24"],";display:flex;flex-direction:column;gap:",rn/* .spacing["16"] */.YK["16"],";",rn/* .Breakpoint.smallTablet */.EA.smallTablet,"{border-left:none;border-top:1px solid ",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";padding-block:",rn/* .spacing["16"] */.YK["16"],";padding-left:0;}"),statusAndDate:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["4"] */.YK["4"],";"),updatedOn:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";"),priceRadioGroup:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;gap:",rn/* .spacing["36"] */.YK["36"],";"),coursePriceWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:flex-start;gap:",rn/* .spacing["16"] */.YK["16"],";"),labelWithContent:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["4"] */.YK["4"],";label{",ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.title */.I6.text.title,";}"),categoriesWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";gap:",rn/* .spacing["8"] */.YK["8"],";"),category:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["8"] */.YK["8"],";border-radius:",rn/* .borderRadius["24"] */.Vq["24"],";background-color:",rn/* .colorTokens.surface.wordpress */.I6.surface.wordpress,";",ro/* .typography.small */.I.small(),";color:",rn/* .colorTokens.text.title */.I6.text.title,";"),instructorsWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["8"] */.YK["8"],";"),instructor:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;gap:",rn/* .spacing["10"] */.YK["10"],";padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["12"] */.YK["12"],";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";[data-avatar]{width:40px;height:40px;",rA/* .styleUtils.flexCenter */.x.flexCenter(),";border-radius:",rn/* .borderRadius.circle */.Vq.circle,";border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";background-color:",rn/* .colorTokens.background["default"] */.I6.background["default"],";}[data-name='instructor-name']{",ro/* .typography.caption */.I.caption("medium"),";}[data-name='instructor-email']{",ro/* .typography.small */.I.small(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";}")};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Box.tsx
var gx=r(6847);// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/CourseSelectionHeader.tsx
var gA=e=>{var{onAddCourse:t,selectedCourses:r}=e;return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gY.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gY.left,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:ro/* .typography.body */.I.body("medium"),children:(0,h.sprintf)((0,h._n)("%d Course selected","%d Courses selected",r.length,"tutor-pro"),r.length)})}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{"data-cy":"add-course",variant:"secondary",isOutlined:true,icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"plusSquareBrand",width:24,height:24}),buttonCss:gY.addCourseButton,onClick:t,children:(0,h.__)("Add Courses","tutor-pro")})]})};/* ESM default export */const gk=gA;var gY={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;justify-content:space-between;align-items:center;padding:0 ",rn/* .spacing["12"] */.YK["12"]," ",rn/* .spacing["12"] */.YK["12"]," ",rn/* .spacing["20"] */.YK["20"],";border-bottom:1px solid ",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";"),left:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";"),addCourseButton:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["32"] */.YK["32"]," ",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["24"] */.YK["24"],";box-shadow:inset 0px 0px 0px 1px ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";&:hover{box-shadow:inset 0px 0px 0px 1px ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";}")};// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/services/bundle.ts
var gI=r(8247);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/molecules/ConfirmationPopover.tsx
function gD(){var e=(0,x._)(["\n      button:last-of-type {\n        color: ",";\n      }\n    "]);gD=function t(){return e};return e}var gC=e=>{var{placement:t,triggerRef:r,isOpen:n,title:o,message:a,onConfirmation:i,onCancel:s,isLoading:l=false,gap:c,maxWidth:d,closePopover:f,animationType:p=rL/* .AnimationType.slideLeft */.J6.slideLeft,arrow:v=false,confirmButton:g,cancelButton:m,positionModifier:b}=e;var y,_,w,x,A;return/*#__PURE__*/(0,u/* .jsx */.Y)(rT/* ["default"] */.A,{triggerRef:r,isOpen:n,arrow:v,placement:t,closePopover:f,animationType:p,maxWidth:d,positionModifier:b,gap:c,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gM.content,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gM.body,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gM.title,children:o}),/*#__PURE__*/(0,u/* .jsx */.Y)("p",{css:gM.description,children:a})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gM.footer({isDelete:(y=g===null||g===void 0?void 0:g.isDelete)!==null&&y!==void 0?y:false}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:(_=m===null||m===void 0?void 0:m.variant)!==null&&_!==void 0?_:"text",size:"small",onClick:s!==null&&s!==void 0?s:f,children:(w=m===null||m===void 0?void 0:m.text)!==null&&w!==void 0?w:(0,h.__)("Cancel","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{"data-cy":"confirm-button",variant:(x=g===null||g===void 0?void 0:g.variant)!==null&&x!==void 0?x:"text",onClick:()=>{i();f()},loading:l,size:"small",children:(A=g===null||g===void 0?void 0:g.text)!==null&&A!==void 0?A:(0,h.__)("Ok","tutor-pro")})]})]})})};/* ESM default export */const gS=gC;var gM={content:/*#__PURE__*/(0,d/* .css */.AH)("background-color:",rn/* .colorTokens.surface.tutor */.I6.surface.tutor,";box-shadow:",rn/* .shadow.popover */.r7.popover,";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";::-webkit-scrollbar{background-color:",rn/* .colorTokens.surface.tutor */.I6.surface.tutor,";width:10px;}::-webkit-scrollbar-thumb{background-color:",rn/* .colorTokens.action.secondary["default"] */.I6.action.secondary["default"],";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";}"),title:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small("medium"),";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";"),description:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.small */.I.small(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";"),body:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["16"] */.YK["16"]," ",rn/* .spacing["20"] */.YK["20"]," ",rn/* .spacing["12"] */.YK["12"],";",rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["8"] */.YK["8"],";"),footer:e=>{var{isDelete:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["16"] */.YK["16"]," ",rn/* .spacing["8"] */.YK["8"],";justify-content:end;gap:",rn/* .spacing["10"] */.YK["10"],";",t&&(0,d/* .css */.AH)(gD(),rn/* .colorTokens.text.error */.I6.text.error))}};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/CourseItem.tsx
function gE(){var e=(0,c._)(["\n      box-shadow: ",";\n      border-bottom: none;\n      border-radius: ",";\n      background-color: ",";\n      cursor: grabbing;\n    "]);gE=function t(){return e};return e}var gF=(0,vV/* .getBundleId */.w)();var gH=e=>{var{course:t,index:r,isOverlay:n}=e;var{attributes:o,listeners:a,setNodeRef:c,transform:d,transition:f,isDragging:p}=cc({id:t.id});var g=(0,m/* .useFormContext */.xW)();var b=(0,v.useRef)(null);var[_,w]=(0,v.useState)(false);var x=(0,gI/* .useAddRemoveCourseToBundleMutation */.YH)();var A={transform:i_.Transform.toString(d),transition:f,opacity:p?.3:1,background:p?rn/* .colorTokens.stroke.hover */.I6.stroke.hover:undefined};var k=e=>(0,i._)(function*(){var t=yield x.mutateAsync({ID:gF,course_ids:[e],user_action:"remove_course"});if(t.data){g.setValue("details",t.data);w(false)}})();return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",(0,l._)((0,s._)({},o),{ref:c,style:A,css:gO.wrapper({isOverlay:n}),children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gO.left,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("button",(0,l._)((0,s._)({},a),{"data-drag-button":true,css:rA/* .styleUtils.resetButton */.x.resetButton,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"dragVertical",width:24,height:24})})),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{"data-index":true,children:r}),/*#__PURE__*/(0,u/* .jsx */.Y)("img",{src:t.image,alt:t.title}),/*#__PURE__*/(0,u/* .jsx */.Y)("p",{children:t.title})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gO.right,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t.is_purchasable,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{"data-price":true,css:gO.price({hasSalePrice:false}),children:(0,h.__)("Free","tutor-pro")}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)(ra/* ["default"] */.A,{when:t.sale_price,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)("span",{"data-price":true,css:gO.price({hasSalePrice:false}),children:t.regular_price}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("span",{"data-price":true,css:gO.price({hasSalePrice:true}),children:t.regular_price}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{"data-price":true,css:gO.price({hasSalePrice:false}),children:t.sale_price})]})}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"text","data-cy":"remove-course","data-remove-bundle-course":true,onClick:()=>w(true),loading:x.isPending,ref:b,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"cross",width:24,height:24})})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(gS,{isOpen:_,triggerRef:b,closePopover:rb/* .noop */.lQ,maxWidth:"258px",title:(0,h.__)("Remove course","tutor-pro"),message:(0,h.__)("Are you sure you want to remove this course?","tutor-pro"),animationType:rL/* .AnimationType.slideUp */.J6.slideUp,isLoading:x.isPending,confirmButton:{text:(0,h.__)("Remove","tutor-pro"),variant:"text",isDelete:true},cancelButton:{text:(0,h.__)("Cancel","tutor-pro"),variant:"text"},onConfirmation:()=>{k(t.id)},onCancel:()=>{w(false)}})]}))};/* ESM default export */const gT=gH;var gO={wrapper:e=>{var{isOverlay:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";justify-content:space-between;align-items:center;padding:",rn/* .spacing["16"] */.YK["16"]," ",rn/* .spacing["20"] */.YK["20"],";border-bottom:1px solid ",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";gap:",rn/* .spacing["28"] */.YK["28"],";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";[data-drag-button]{cursor:grab;display:none;color:",rn/* .colorTokens.icon.hints */.I6.icon.hints,";}[data-remove-bundle-course]{display:none;color:",rn/* .colorTokens.color.black["50"] */.I6.color.black["50"],";padding:",rn/* .spacing["4"] */.YK["4"],";box-shadow:none;transition:color 0.3s ease-in-out;}",t&&(0,d/* .css */.AH)(gE(),rn/* .shadow.drag */.r7.drag,rn/* .borderRadius.card */.Vq.card,rn/* .colorTokens.background.hover */.I6.background.hover),"    &:hover{background-color:",rn/* .colorTokens.background.hover */.I6.background.hover,";[data-index],[data-price]{display:none;}[data-drag-button],[data-remove-bundle-course]{display:block;}}")},left:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;gap:",rn/* .spacing["16"] */.YK["16"],";img{width:76px;height:",rn/* .spacing["48"] */.YK["48"],";object-fit:cover;object-position:center;border-radius:",rn/* .borderRadius["2"] */.Vq["2"],";flex-shrink:0;}p,span{",ro/* .typography.caption */.I.caption(),";",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(2),";}span{flex-shrink:0;width:",rn/* .spacing["24"] */.YK["24"],";",rA/* .styleUtils.flexCenter */.x.flexCenter(),";}"),right:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;justify-content:flex-end;flex-shrink:0;max-width:120px;width:100%;gap:",rn/* .spacing["8"] */.YK["8"],";position:relative;"),price:e=>{var{hasSalePrice:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";color:",t?rn/* .colorTokens.text.subdued */.I6.text.subdued:rn/* .colorTokens.text.primary */.I6.text.primary,";text-decoration:",t?"line-through":"none",";")}};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/SelectedCourseList.tsx
var gK=e=>{var{courses:t,onSort:r}=e;var[n,o]=(0,v.useState)(null);var a=(0,v.useMemo)(()=>{return t.find(e=>e.id===n)},[n,t]);var i=iK(iO(sE,{activationConstraint:{distance:10}}),iO(sI,{coordinateGetter:cp}));return/*#__PURE__*/(0,u/* .jsxs */.FD)(lb,{sensors:i,collisionDetection:ij,measuring:vE,modifiers:[lU],onDragStart:e=>{o(e.active.id)},onDragEnd:e=>{var{active:n,over:a}=e;if(!a||n.id===a.id){o(null);return}var i=t.findIndex(e=>e.id===n.id);var s=t.findIndex(e=>e.id===a.id);r(i,s)},children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ct,{items:t,strategy:l8,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:t,children:(e,t)=>/*#__PURE__*/(0,u/* .jsx */.Y)(gT,{course:e,index:t+1},e.id)})}),/*#__PURE__*/(0,a6.createPortal)(/*#__PURE__*/(0,u/* .jsx */.Y)(lW,{children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:a,children:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(gT,{course:e,index:0,isOverlay:true})})}),document.body)]})};/* ESM default export */const gN=gK;// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/SelectionOverview.tsx
var gP=()=>{var e=(0,m/* .useFormContext */.xW)();var t=e.watch("details.overview");var r={total_duration:"clock",total_quizzes:"questionCircle",total_video_contents:"videoCamera",total_resources:"download"};var n={total_duration:(0,h.__)("Total Duration","tutor-pro"),total_quizzes:(0,h.__)("Quiz Papers","tutor-pro"),total_video_contents:(0,h.__)("Lesson Content","tutor-pro"),total_resources:(0,h.__)("Downloadable Resources","tutor-pro")};return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gW.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gW.title,children:(0,h.__)("Selection Overview","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:gW.overview,children:Object.keys(r).map(e=>{var o=t[e];return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gW.overviewItem,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:r[e],width:32,height:32}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:e==="total_duration"?String(o).replace(/:\d{2}$/,""):o}),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:n[e]})]},e)})})]})};/* ESM default export */const gL=gP;var gW={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["12"] */.YK["12"]," ",rn/* .spacing["20"] */.YK["20"]," 0 ",rn/* .spacing["20"] */.YK["20"],";"),title:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body("medium"),";padding-bottom:",rn/* .spacing["12"] */.YK["12"],";"),overview:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:1fr 1fr;gap:",rn/* .spacing["4"] */.YK["4"],";"),overviewItem:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex(),";gap:",rn/* .spacing["8"] */.YK["8"],";align-items:center;",ro/* .typography.caption */.I.caption(),";svg{color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";flex-shrink:0;}span:first-of-type:not(:only-of-type){font-weight:",rn/* .fontWeight.semiBold */.Wy.semiBold,";flex-shrink:0;}")};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/modals/CourseListModal/SearchField.tsx
var gB=e=>{var{onFilterItems:t}=e;var r=rl({defaultValues:{search:""}});var n=rs(r.watch("search"));(0,v.useEffect)(()=>{t((0,s._)({},n.length>0&&{search:n}))},[t,n]);return/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{control:r.control,name:"search",render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(a0,(0,l._)((0,s._)({},e),{content:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"search",width:24,height:24}),placeholder:(0,h.__)("Search...","tutor-pro"),showVerticalBar:false}))})};/* ESM default export */const gR=gB;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/usePaginatedTable.ts
var gz=function(){var{limit:e=rC/* .ITEMS_PER_PAGE */.re}=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{};var[t,r]=(0,v.useState)({page:1,sortProperty:"",sortDirection:undefined,filter:{}});var n=t;var o=e*Math.max(0,n.page-1);var a=(0,v.useCallback)(e=>{r(t=>(0,_._)({},t,e))},[r]);var i=e=>a({page:e});var s=(0,v.useCallback)(e=>a({page:1,filter:e}),[a]);var l=e=>{var t={};if(e!==n.sortProperty){t={sortDirection:"asc",sortProperty:e}}else{t={sortDirection:n.sortDirection==="asc"?"desc":"asc",sortProperty:e}}a(t)};return{pageInfo:n,onPageChange:i,onColumnSort:l,offset:o,itemsPerPage:e,onFilterItems:s}};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/molecules/Paginator.tsx
var gV=e=>{var{currentPage:t,onPageChange:r,totalItems:n,itemsPerPage:o}=e;var a=Math.max(Math.ceil(n/o),1);var[i,s]=(0,v.useState)("");(0,v.useEffect)(()=>{s(t.toString())},[t]);var l=e=>{if(e<1||e>a){return}r(e)};return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gq.wrapper,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gq.pageStatus,children:[(0,h.__)("Page","tutor-pro"),/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:/*#__PURE__*/(0,u/* .jsx */.Y)("input",{type:"text",css:gq.paginationInput,value:i,onChange:e=>{var{value:t}=e.currentTarget;var n=t.replace(/[^0-9]/g,"");var o=Number(n);if(o>0&&o<=a){s(n);r(o)}else if(!n){s(n)}},autoComplete:"off"})}),(0,h.__)("of","tutor-pro")," ",/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:a})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:gq.pageController,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:gq.paginationButton,onClick:()=>l(t-1),disabled:t===1,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:!rC/* .isRTL */.V8?"chevronLeft":"chevronRight",width:32,height:32})}),/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:gq.paginationButton,onClick:()=>l(t+1),disabled:t===a,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:!rC/* .isRTL */.V8?"chevronRight":"chevronLeft",width:32,height:32})})]})]})};/* ESM default export */const gj=gV;var gq={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;justify-content:end;align-items:center;flex-wrap:wrap;gap:",rn/* .spacing["8"] */.YK["8"],";height:36px;"),pageStatus:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body(),"    color:",rn/* .colorTokens.text.title */.I6.text.title,";min-width:100px;"),paginationInput:/*#__PURE__*/(0,d/* .css */.AH)("outline:0;border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";margin:0 ",rn/* .spacing["8"] */.YK["8"],";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";padding:8px 12px;width:72px;&::-webkit-outer-spin-button,&::-webkit-inner-spin-button{-webkit-appearance:none;margin:",rn/* .spacing["0"] */.YK["0"],";}&[type='number']{-moz-appearance:textfield;}"),pageController:/*#__PURE__*/(0,d/* .css */.AH)("gap:",rn/* .spacing["8"] */.YK["8"],";display:flex;justify-content:center;align-items:center;height:100%;"),paginationButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";background:",rn/* .colorTokens.background.white */.I6.background.white,";color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";height:32px;width:32px;display:grid;place-items:center;transition:background-color 0.2s ease-in-out,color 0.3s ease-in-out;svg{color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";}&:hover{background:",rn/* .colorTokens.background["default"] */.I6.background["default"],";& > svg{color:",rn/* .colorTokens.icon.brand */.I6.icon.brand,";}}&:disabled{background:",rn/* .colorTokens.background.white */.I6.background.white,";& > svg{color:",rn/* .colorTokens.icon.disable["default"] */.I6.icon.disable["default"],";}}")};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/molecules/Table.tsx
function gU(){var e=(0,x._)(["\n      border: 1px solid ",";\n      border-radius: ",";\n    "]);gU=function t(){return e};return e}function gG(){var e=(0,x._)(["\n      border-bottom: 1px solid ",";\n    "]);gG=function t(){return e};return e}function gQ(){var e=(0,x._)(["\n      &:nth-of-type(even) {\n        background-color: ",";\n      }\n    "]);gQ=function t(){return e};return e}function gX(){var e=(0,x._)(["\n        background-color: ",";\n      "]);gX=function t(){return e};return e}function g$(){var e=(0,x._)(["\n        background-color: ",";\n      "]);g$=function t(){return e};return e}function gZ(){var e=(0,x._)(["\n        :last-of-type {\n          border-bottom: none;\n        }\n      "]);gZ=function t(){return e};return e}var gJ={bodyRowSelected:rn/* .colorTokens.background.active */.I6.background.active,bodyRowHover:rn/* .colorTokens.background.hover */.I6.background.hover};var g0=e=>{var{columns:t,data:r,entireHeader:n=null,headerHeight:o=60,noHeader:a=false,isStriped:i=false,isRounded:s=false,stripedBySelectedIndex:l=[],colors:c={},isBordered:f=true,loading:p=false,itemsPerPage:h=1,querySortProperties:v,querySortDirections:g={},onSortClick:m,renderInLastRow:b,rowStyle:_,sortIcons:w={asc:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"sortASC",height:16,width:16}),desc:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"sortDESC",height:16,width:16})}}=e;var x=(e,r)=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("tr",{css:[g6.tableRow({isBordered:f,isStriped:i}),g6.bodyTr({colors:c,isSelected:l.includes(e),isRounded:s}),_],children:t.map((e,t)=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("td",{css:[g6.td,{width:e.width}],children:r(e)},t)})},e)};var A=e=>{var t=null;var r=e.sortProperty;if(!r){return e.Header}if(v===null||v===void 0?void 0:v.includes(r)){if((g===null||g===void 0?void 0:g[r])==="asc"){t=w.asc}else{t=w.desc}}return/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:g6.headerWithIcon,onClick:()=>m===null||m===void 0?void 0:m(r),children:[e.Header,t&&t]})};var k=()=>{if(n){return/*#__PURE__*/(0,u/* .jsx */.Y)("th",{css:g6.th,colSpan:t.length,children:n})}return t.map((e,t)=>{if(e.Header!==null){return/*#__PURE__*/(0,u/* .jsx */.Y)("th",{css:[g6.th,e.css,{width:e.width}],colSpan:e.headerColSpan,children:A(e)},t)}})};var Y=()=>{if(p){return(0,rb/* .range */.y1)(h).map(e=>x(e,()=>/*#__PURE__*/(0,u/* .jsx */.Y)(nr,{animation:true,height:20,width:"".concat((0,rb/* .getRandom */.G0)(40,80),"%")})))}if(!r.length){return/*#__PURE__*/(0,u/* .jsx */.Y)("tr",{css:g6.tableRow({isBordered:false,isStriped:false}),children:/*#__PURE__*/(0,u/* .jsx */.Y)("td",{colSpan:t.length,css:[g6.td,/*#__PURE__*/(0,d/* .css */.AH)("text-align:center;")],children:"No Data!"})})}var e=r.map((e,t)=>{return x(t,r=>{return"Cell"in r?r.Cell(e,t):r.accessor(e,t)})});if(b){b=/*#__PURE__*/(0,u/* .jsx */.Y)("tr",{children:/*#__PURE__*/(0,u/* .jsx */.Y)("td",{css:g6.td,children:b})},e.length);e.push(b)}return e};return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:g6.tableContainer({isRounded:s}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)("table",{css:g6.table,children:[!a&&/*#__PURE__*/(0,u/* .jsx */.Y)("thead",{children:/*#__PURE__*/(0,u/* .jsx */.Y)("tr",{css:[g6.tableRow({isBordered:f,isStriped:i}),{height:o}],children:k()})}),/*#__PURE__*/(0,u/* .jsx */.Y)("tbody",{children:Y()})]})})};/* ESM default export */const g1=g0;var g6={tableContainer:e=>{var{isRounded:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("display:block;width:100%;overflow-x:auto;",t&&(0,d/* .css */.AH)(gU(),rn/* .colorTokens.stroke.divider */.I6.stroke.divider,rn/* .borderRadius["6"] */.Vq["6"]))},headerWithIcon:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",ro/* .typography.body */.I.body(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";display:flex;gap:",rn/* .spacing["8"] */.YK["8"],";align-items:center;svg{color:",rn/* .colorTokens.text.primary */.I6.text.primary,";}"),table:/*#__PURE__*/(0,d/* .css */.AH)("width:100%;border-collapse:collapse;border:none;"),tableRow:e=>{var{isBordered:t,isStriped:r}=e;return/*#__PURE__*/(0,d/* .css */.AH)(t&&(0,d/* .css */.AH)(gG(),rn/* .colorTokens.stroke.divider */.I6.stroke.divider)," ",r&&(0,d/* .css */.AH)(gQ(),rn/* .colorTokens.background.active */.I6.background.active))},th:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body(),";background-color:",rn/* .colorTokens.background.white */.I6.background.white,";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";padding:0 ",rn/* .spacing["16"] */.YK["16"],";border:none;"),bodyTr:e=>{var{colors:t,isSelected:r,isRounded:n}=e;var{bodyRowDefault:o,bodyRowSelectedHover:a,bodyRowHover:i=gJ.bodyRowHover,bodyRowSelected:s=gJ.bodyRowSelected}=t;return/*#__PURE__*/(0,d/* .css */.AH)(o&&(0,d/* .css */.AH)(gX(),o),"      &:hover{background-color:",r&&a?a:i,";}",r&&(0,d/* .css */.AH)(g$(),s)," ",n&&(0,d/* .css */.AH)(gZ()))},td:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body(),";padding:",rn/* .spacing["16"] */.YK["16"],";border:none;")};// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/utils.js
var g2=r(3160);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/services/course.ts
var g4=e=>{return rg/* .wpAjaxInstance.get */.b.get(rm/* ["default"].GET_COURSE_LIST */.A.GET_COURSE_LIST,{params:e})};var g3=e=>{var{params:t,isEnabled:r}=e;return(0,rp/* .useQuery */.I)({queryKey:["PrerequisiteCourses",t],queryFn:()=>g4((0,_._)({exclude:t.exclude,limit:t.limit,offset:t.offset,filter:t.filter},t.post_status&&{post_status:t.post_status})).then(e=>e.data),placeholderData:g2/* .keepPreviousData */.rX,enabled:r})};var g5=e=>{var{courseId:t,builder:r}=e;return rg/* .wpAjaxInstance.post */.b.post(rm/* ["default"].TUTOR_UNLINK_PAGE_BUILDER */.A.TUTOR_UNLINK_PAGE_BUILDER,{course_id:t,builder:r})};var g8=()=>{return(0,rh/* .useMutation */.n)({mutationFn:g5})};var g7=e=>{return wpAjaxInstance.get(endpoints.BUNDLE_LIST,{params:e})};var g9=e=>{var{params:t,isEnabled:r}=e;return useQuery({queryKey:["PrerequisiteCourses",t],queryFn:()=>g7(_object_spread({exclude:t.exclude,limit:t.limit,offset:t.offset,filter:t.filter},t.post_status&&{post_status:t.post_status})).then(e=>e.data),placeholderData:keepPreviousData,enabled:r})};// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/course-placeholder.png
const me=r.p+"images/course-placeholder-3ae4bdaf.png";// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/modals/CourseListModal/CourseListTable.tsx
var mt=e=>{var{form:t,addedCourseIds:r}=e;var n,o;var a=t.watch("courses")||[];var{pageInfo:i,onPageChange:s,itemsPerPage:l,offset:c,onFilterItems:d}=gz();var f=g3({params:{offset:c,limit:l,filter:i.filter,exclude:r},isEnabled:true});var p;var v=(0,vV/* .fixWCMonetizationFormat */.o)((p=(n=f.data)===null||n===void 0?void 0:n.results)!==null&&p!==void 0?p:[]);function g(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:false;var r=a.map(e=>e.id);var n=v.map(e=>e.id);if(e){var o=v.filter(e=>!r.includes(e.id));t.setValue("courses",[...a,...o]);return}var i=a.filter(e=>!n.includes(e.id));t.setValue("courses",i)}function m(){return v.every(e=>a.map(e=>e.id).includes(e.id))}var b=[{Header:((o=f.data)===null||o===void 0?void 0:o.results.length)?/*#__PURE__*/(0,u/* .jsx */.Y)(rt/* ["default"] */.A,{onChange:g,checked:f.isLoading||f.isRefetching?false:m(),label:(0,h.__)("Name","tutor-pro"),labelCss:mn.checkboxLabel,"data-cy":"select-all-courses"}):"#",Cell:e=>{return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mn.checkboxWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(rt/* ["default"] */.A,{onChange:()=>{var r=a.filter(t=>t.id!==e.id);var n=(r===null||r===void 0?void 0:r.length)===a.length;if(n){t.setValue("courses",[...r,e])}else{t.setValue("courses",r)}},checked:a.map(e=>e.id).includes(e.id),"data-cy":"select-course"}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mn.courseItemWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("img",{src:e.image||me,css:mn.thumbnail,alt:(0,h.__)("Course item","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.title,children:e.title})]})]})}},{Header:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.tablePriceLabel,children:(0,h.__)("Price","tutor-pro")}),Cell:e=>{return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.priceWrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.price,children:/*#__PURE__*/(0,u/* .jsxs */.FD)(ra/* ["default"] */.A,{when:e.is_purchasable,fallback:(0,h.__)("Free","tutor-pro"),children:[/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:e.sale_price?e.sale_price:e.regular_price}),e.sale_price&&/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:mn.discountPrice,children:e.regular_price})]})})})}}];if(f.isLoading){return/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* .LoadingSection */.YE,{})}if(!f.data){return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.errorMessage,children:(0,h.__)("Something went wrong","tutor-pro")})}var y;return/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.tableActions,children:/*#__PURE__*/(0,u/* .jsx */.Y)(gR,{onFilterItems:d})}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.tableWrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)(g1,{columns:b,data:(y=f.data.results)!==null&&y!==void 0?y:[],itemsPerPage:l,loading:f.isFetching||f.isRefetching})}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mn.paginatorWrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)(gj,{currentPage:i.page,onPageChange:s,totalItems:f.data.total_items,itemsPerPage:l})})]})};/* ESM default export */const mr=mt;var mn={tableLabel:/*#__PURE__*/(0,d/* .css */.AH)("text-align:left;"),tablePriceLabel:/*#__PURE__*/(0,d/* .css */.AH)("text-align:right;"),tableActions:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["20"] */.YK["20"],";"),tableWrapper:/*#__PURE__*/(0,d/* .css */.AH)("max-height:calc(100vh - 350px);overflow:auto;"),checkboxWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["12"] */.YK["12"],";"),checkboxLabel:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.body */.I.body(),";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";"),paginatorWrapper:/*#__PURE__*/(0,d/* .css */.AH)("margin:",rn/* .spacing["20"] */.YK["20"]," ",rn/* .spacing["16"] */.YK["16"],";"),courseItemWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["16"] */.YK["16"],";"),bundleBadge:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.tiny */.I.tiny(),";display:inline-block;padding:0px ",rn/* .spacing["8"] */.YK["8"],";background-color:#9342e7;color:",rn/* .colorTokens.text.white */.I6.text.white,";border-radius:",rn/* .borderRadius["40"] */.Vq["40"],";"),subscriptionBadge:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.tiny */.I.tiny(),";display:flex;align-items:center;width:fit-content;padding:0px ",rn/* .spacing["6"] */.YK["6"]," 0px ",rn/* .spacing["4"] */.YK["4"],";background-color:",rn/* .colorTokens.color.warning["90"] */.I6.color.warning["90"],";color:",rn/* .colorTokens.text.white */.I6.text.white,";border-radius:",rn/* .borderRadius["40"] */.Vq["40"],";"),selectedBadge:/*#__PURE__*/(0,d/* .css */.AH)("margin-left:",rn/* .spacing["4"] */.YK["4"],";",ro/* .typography.tiny */.I.tiny(),";padding:",rn/* .spacing["4"] */.YK["4"]," ",rn/* .spacing["8"] */.YK["8"],";background-color:",rn/* .colorTokens.background.disable */.I6.background.disable,";color:",rn/* .colorTokens.text.title */.I6.text.title,";border-radius:",rn/* .borderRadius["2"] */.Vq["2"],";white-space:nowrap;"),title:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(2),";text-wrap:pretty;"),thumbnail:/*#__PURE__*/(0,d/* .css */.AH)("width:76px;height:48px;border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";object-fit:cover;object-position:center;"),priceWrapper:/*#__PURE__*/(0,d/* .css */.AH)("min-width:200px;text-align:right;[data-button]{display:none;}"),price:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";display:flex;gap:",rn/* .spacing["4"] */.YK["4"],";justify-content:end;"),startingFrom:/*#__PURE__*/(0,d/* .css */.AH)("color:",rn/* .colorTokens.text.hints */.I6.text.hints,";"),discountPrice:/*#__PURE__*/(0,d/* .css */.AH)("text-decoration:line-through;color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";"),errorMessage:/*#__PURE__*/(0,d/* .css */.AH)("height:100px;display:flex;align-items:center;justify-content:center;")};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/modals/CourseListModal/index.tsx
var mo=(0,vV/* .getBundleId */.w)();function ma(e){var{title:t,closeModal:r,actions:n,form:o,addedCourseIds:a}=e;var s=(0,m/* .useForm */.mN)({defaultValues:{courses:[]}});var l=s.watch("courses");var c=(0,gI/* .useAddRemoveCourseToBundleMutation */.YH)();function d(){return(0,i._)(function*(){var e=yield c.mutateAsync({ID:mo,course_ids:l.map(e=>e.id),user_action:"add_course"});if(e.data){o.setValue("details",e.data);r({action:"CONFIRM"})}})()}return/*#__PURE__*/(0,u/* .jsxs */.FD)(nM/* ["default"] */.A,{onClose:()=>r({action:"CLOSE"}),title:t,actions:n,maxWidth:720,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(mr,{form:s,addedCourseIds:a}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:ms.footer,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{size:"small",variant:"text",onClick:()=>r({action:"CLOSE"}),children:(0,h.__)("Cancel","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{size:"small",variant:"primary",onClick:d,loading:c.isPending,disabled:l.length===0,"data-cy":"add-selected-courses",children:(0,h.__)("Add","tutor-pro")})]})]})}/* ESM default export */const mi=ma;var ms={footer:/*#__PURE__*/(0,d/* .css */.AH)("box-shadow:0px 1px 0px 0px #e4e5e7 inset;height:56px;display:flex;align-items:center;justify-content:end;gap:",rn/* .spacing["16"] */.YK["16"],";padding-inline:",rn/* .spacing["16"] */.YK["16"],";")};// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/bundle-empty-state.webp
const ml=r.p+"images/bundle-empty-state-7f831b6a.webp";// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/course-bundle/CourseSelection.tsx
var mc=e=>{var{loading:t}=e;var r=(0,m/* .useFormContext */.xW)();var{showModal:n}=(0,nO/* .useModal */.h)();var{fields:o,move:a}=(0,m/* .useFieldArray */.jz)({control:r.control,name:"details.courses",keyName:"_id"});return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:md.wrapper,"data-cy":"course-selection",children:[/*#__PURE__*/(0,u/* .jsx */.Y)("label",{css:ro/* .typography.caption */.I.caption(),children:(0,h.__)("Courses","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(gx/* .Box */.az,{wrapperCss:md.boxWrapper,children:/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!t,fallback:/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* .LoadingSection */.YE,{}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)(ra/* ["default"] */.A,{when:o.length>0,fallback:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:md.emptyState,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("img",{src:ml,alt:(0,h.__)("Empty State","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)("p",{children:(0,h.__)("No Courses Added Yet","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{"data-cy":"add-course",variant:"secondary",isOutlined:true,icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"plusSquareBrand",width:24,height:24}),css:md.addCourseButton,onClick:()=>{n({component:mi,props:{title:(0,h.__)("Select Courses","tutor-pro"),form:r,addedCourseIds:o.map(e=>e.id)}})},children:(0,h.__)("Add Courses","tutor-pro")})]}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(gk,{onAddCourse:()=>{n({component:mi,props:{title:(0,h.__)("Select Courses","tutor-pro"),form:r,addedCourseIds:o.map(e=>e.id)}})},selectedCourses:o}),/*#__PURE__*/(0,u/* .jsx */.Y)(gN,{courses:(0,vV/* .fixWCMonetizationFormat */.o)(o),onSort:a}),/*#__PURE__*/(0,u/* .jsx */.Y)(gL,{})]})})})]})};/* ESM default export */const mu=mc;var md={wrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["6"] */.YK["6"],";"),boxWrapper:/*#__PURE__*/(0,d/* .css */.AH)("padding-inline:0;border:1px solid ",rn/* .colorTokens.stroke.divider */.I6.stroke.divider,";"),emptyState:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",rn/* .spacing["12"] */.YK["12"],";align-items:center;padding-block:",rn/* .spacing["32"] */.YK["32"],";img{max-width:60px;width:100%;object-fit:contain;object-position:center;}p{",ro/* .typography.body */.I.body("medium"),";}"),addCourseButton:/*#__PURE__*/(0,d/* .css */.AH)("padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["32"] */.YK["32"]," ",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["24"] */.YK["24"],";box-shadow:inset 0px 0px 0px 1px ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";&:hover{box-shadow:inset 0px 0px 0px 1px ",rn/* .colorTokens.stroke.border */.I6.stroke.border,";}")};// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/layouts/Navigator.tsx
var mf=r(8906);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormEditableAlias.tsx
var mp=e=>{var{field:t,fieldState:r,label:n="",baseURL:o,onChange:a}=e;var{value:i=""}=t;var s="".concat(o,"/").concat(i);var[l,c]=(0,v.useState)(false);var[d,f]=(0,v.useState)(s);var p="".concat(o,"/");var[g,m]=(0,v.useState)(i);(0,v.useEffect)(()=>{if(o){f("".concat(o,"/").concat(i))}if(i){m(i)}},[o,i]);return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{field:t,fieldState:r,children:e=>{return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mh.aliasWrapper,children:[n&&/*#__PURE__*/(0,u/* .jsxs */.FD)("label",{css:mh.label,children:[n,": "]}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mh.linkWrapper,children:!l?/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("a",{"data-cy":"course-slug",href:d,target:"_blank",css:mh.link,title:d,rel:"noreferrer",children:d}),/*#__PURE__*/(0,u/* .jsx */.Y)("button",{css:mh.iconWrapper,type:"button",onClick:()=>c(e=>!e),children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"edit",width:24,height:24,style:mh.editIcon})})]}):/*#__PURE__*/(0,u/* .jsxs */.FD)(u/* .Fragment */.FK,{children:[/*#__PURE__*/(0,u/* .jsx */.Y)("span",{css:mh.prefix,title:p,children:p}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mh.editWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("input",(0,w._)((0,_._)({},e),{className:"tutor-input-field",css:mh.editable,type:"text",value:g,onChange:e=>m(e.target.value),autoComplete:"off"})),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"secondary",isOutlined:true,size:"small",buttonCss:mh.saveBtn,onClick:()=>{c(false);t.onChange((0,rb/* .convertToSlug */.qz)(g.replace(o,"")));a===null||a===void 0?void 0:a((0,rb/* .convertToSlug */.qz)(g.replace(o,"")))},children:(0,h.__)("Save","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{buttonContentCss:mh.cancelButton,variant:"text",size:"small",onClick:()=>{c(false);m(i)},children:(0,h.__)("Cancel","tutor-pro")})]})]})})]})}})};var mh={aliasWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;min-height:32px;align-items:center;gap:",rn/* .spacing["4"] */.YK["4"],";",rn/* .Breakpoint.smallMobile */.EA.smallMobile,"{flex-direction:column;gap:",rn/* .spacing["4"] */.YK["4"],";align-items:flex-start;}"),label:/*#__PURE__*/(0,d/* .css */.AH)("flex-shrink:0;",ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";margin:0px;"),linkWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;width:fit-content;font-size:",rn/* .fontSize["14"] */.J["14"],";",rn/* .Breakpoint.smallMobile */.EA.smallMobile,"{gap:",rn/* .spacing["4"] */.YK["4"],";flex-wrap:wrap;}"),link:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),";color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";text-decoration:none;",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),"    max-width:fit-content;word-break:break-all;"),iconWrapper:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,"    margin-left:",rn/* .spacing["8"] */.YK["8"],";height:24px;width:24px;background-color:",rn/* .colorTokens.background.white */.I6.background.white,";border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";:focus{",rA/* .styleUtils.inputFocus */.x.inputFocus,"}"),editIcon:/*#__PURE__*/(0,d/* .css */.AH)("color:",rn/* .colorTokens.icon["default"] */.I6.icon["default"],";:hover{color:",rn/* .colorTokens.icon.brand */.I6.icon.brand,";}"),prefix:/*#__PURE__*/(0,d/* .css */.AH)(ro/* .typography.caption */.I.caption(),"    color:",rn/* .colorTokens.text.subdued */.I6.text.subdued,";",rA/* .styleUtils.text.ellipsis */.x.text.ellipsis(1),"    word-break:break-all;max-width:fit-content;"),editWrapper:/*#__PURE__*/(0,d/* .css */.AH)("margin-left:",rn/* .spacing["2"] */.YK["2"],";display:flex;align-items:center;width:fit-content;"),editable:/*#__PURE__*/(0,d/* .css */.AH)("&.tutor-input-field{",ro/* .typography.caption */.I.caption(),"      background:",rn/* .colorTokens.background.white */.I6.background.white,";width:208px;height:32px;border:1px solid ",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";padding:",rn/* .spacing["8"] */.YK["8"]," ",rn/* .spacing["12"] */.YK["12"],";border-radius:",rn/* .borderRadius.input */.Vq.input,";margin-right:",rn/* .spacing["8"] */.YK["8"],";outline:none;&:focus{border-color:",rn/* .colorTokens.stroke["default"] */.I6.stroke["default"],";box-shadow:none;outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}}"),saveBtn:/*#__PURE__*/(0,d/* .css */.AH)("flex-shrink:0;margin-right:",rn/* .spacing["8"] */.YK["8"],";"),cancelButton:/*#__PURE__*/(0,d/* .css */.AH)("color:",rn/* .colorTokens.text.brand */.I6.text.brand,";")};/* ESM default export */const mv=mp;// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Tooltip.tsx + 56 modules
var mg=r(9773);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/WPEditor.tsx
function mm(){var e=(0,x._)(["\n        ","\n      "]);mm=function t(){return e};return e}function mb(){var e=(0,x._)(["\n        border-top-right-radius: ",";\n      "]);mb=function t(){return e};return e}function my(){var e=(0,x._)(["\n          ","\n        "]);my=function t(){return e};return e}function m_(){var e=(0,x._)(["\n      .mce-tinymce.mce-container {\n        border: ",";\n        border-radius: ",";\n\n        ","\n      }\n    "]);m_=function t(){return e};return e}var mw=!!nK/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url;// Without getDefaultSettings function editor does not initiate
if(!window.wp.editor.getDefaultSettings){window.wp.editor.getDefaultSettings=()=>({})}function mx(e,t,r,n,o,a,i,s,l,c,u,d,f){var p=d!==null&&d!==void 0?d:n?"bold italic underline | image | ".concat(mw?"codesample":""):"formatselect bold italic underline | bullist numlist | blockquote | alignleft aligncenter alignright | link unlink | wp_more ".concat(mw?" codesample":""," | wp_adv");var v=f!==null&&f!==void 0?f:"strikethrough hr | forecolor pastetext removeformat | charmap | outdent indent | undo redo | wp_help | fullscreen | tutor_button | undoRedoDropdown";p=u?p:p.replaceAll(" | "," ");return{tinymce:{wpautop:true,menubar:false,autoresize_min_height:l||200,autoresize_max_height:c||500,wp_autoresize_on:true,browser_spellcheck:!s,convert_urls:false,end_container_on_empty_block:true,entities:"38,amp,60,lt,62,gt",entity_encoding:"raw",fix_list_elements:true,indent:false,relative_urls:0,remove_script_host:0,plugins:"charmap,colorpicker,hr,lists,image,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview".concat(mw?",codesample":""),skin:"light",skin_url:"".concat(nK/* .tutorConfig.site_url */.P.site_url,"/wp-content/plugins/tutor/assets/lib/tinymce/light"),submit_patch:true,link_context_toolbar:false,theme:"modern",toolbar:!s,toolbar1:p,toolbar2:n?false:v,content_css:"".concat(nK/* .tutorConfig.site_url */.P.site_url,"/wp-includes/css/dashicons.min.css,").concat(nK/* .tutorConfig.site_url */.P.site_url,"/wp-includes/js/tinymce/skins/wordpress/wp-content.css,").concat(nK/* .tutorConfig.site_url */.P.site_url,"/wp-content/plugins/tutor/assets/lib/tinymce/light/content.min.css"),statusbar:!s,branding:false,// eslint-disable-next-line @typescript-eslint/no-explicit-any
setup:o=>{o.on("init",()=>{if(e&&!s){o.getBody().focus()}if(s){o.setMode("readonly");var t=o.contentDocument.querySelector(".mce-content-body");t.style.backgroundColor="transparent";setTimeout(()=>{var e=t.scrollHeight;if(e){o.iframeElement.style.height="".concat(e,"px")}},500)}});if(!n){o.addButton("tutor_button",{text:(0,h.__)("Tutor ShortCode","tutor-pro"),icon:false,type:"menubutton",menu:[{text:(0,h.__)("Student Registration Form","tutor-pro"),onclick:()=>{o.insertContent("[tutor_student_registration_form]")}},{text:(0,h.__)("Instructor Registration Form","tutor-pro"),onclick:()=>{o.insertContent("[tutor_instructor_registration_form]")}},{text:(0,h.__)("Courses","tutor-pro"),onclick:()=>{o.windowManager.open({title:(0,h.__)("Courses Shortcode","tutor-pro"),body:[{type:"textbox",name:"id",label:(0,h.__)("Course id, separate by (,) comma","tutor-pro"),value:""},{type:"textbox",name:"exclude_ids",label:(0,h.__)("Exclude Course IDS","tutor-pro"),value:""},{type:"textbox",name:"category",label:(0,h.__)("Category IDS","tutor-pro"),value:""},{type:"listbox",name:"orderby",label:(0,h.__)("Order By","tutor-pro"),onselect:()=>{},values:[{text:"ID",value:"ID"},{text:"title",value:"title"},{text:"rand",value:"rand"},{text:"date",value:"date"},{text:"menu_order",value:"menu_order"},{text:"post__in",value:"post__in"}]},{type:"listbox",name:"order",label:(0,h.__)("Order","tutor-pro"),onselect:()=>{},values:[{text:"DESC",value:"DESC"},{text:"ASC",value:"ASC"}]},{type:"textbox",name:"count",label:(0,h.__)("Count","tutor-pro"),value:"6"}],// eslint-disable-next-line @typescript-eslint/no-explicit-any
onsubmit:e=>{o.insertContent('[tutor_course id="'.concat(e.data.id,'" exclude_ids="').concat(e.data.exclude_ids,'" category="').concat(e.data.category,'" orderby="').concat(e.data.orderby,'" order="').concat(e.data.order,'" count="').concat(e.data.count,'"]'))}})}}]})}o.on("change keyup paste",()=>{t(o.getContent())});o.on("focus",()=>{r(true)});o.on("blur",()=>r(false));o.on("FullscreenStateChanged",e=>{var t=document.getElementById("tutor-course-builder");var r=document.getElementById("tutor-course-bundle-builder-root");var n=t||r;if(n){if(e.state){n.style.position="relative";n.style.zIndex="100000"}else{n.removeAttribute("style")}}i===null||i===void 0?void 0:i(e.state)})},wp_keep_scroll_position:false,wpeditimage_html5_captions:true},mediaButtons:!o&&!n&&!s,drag_drop_upload:true,quicktags:a||n||s?false:{buttons:["strong","em","block","del","ins","img","ul","ol","li","code","more","close"]}}}var mA=e=>{var{value:t="",onChange:r,isMinimal:n,hideMediaButtons:o,hideQuickTags:a,autoFocus:i=false,onFullScreenChange:s,readonly:l=false,min_height:c,max_height:d,toolbar1:f,toolbar2:p}=e;var h=(0,v.useRef)(null);var{current:g}=(0,v.useRef)((0,rb/* .nanoid */.Ak)());var[m,b]=(0,v.useState)(i);var y=e=>{var t=e.target;r(t.value)};var _=(0,v.useCallback)(e=>{var{tinymce:t}=window;if(!t||m){return}var r=window.tinymce.get(g);if(r){if(e!==r.getContent()){r.setContent(e)}}},[g,m]);(0,v.useEffect)(()=>{_(t);// eslint-disable-next-line react-hooks/exhaustive-deps
},[t]);(0,v.useEffect)(()=>{if(typeof window.wp!=="undefined"&&window.wp.editor){window.wp.editor.remove(g);window.wp.editor.initialize(g,mx(m,r,b,n,o,a,s,l,c,d,rC/* .CURRENT_VIEWPORT.isAboveMobile */.vN.isAboveMobile,f,p));var e=h.current;e===null||e===void 0?void 0:e.addEventListener("change",y);e===null||e===void 0?void 0:e.addEventListener("input",y);return()=>{window.wp.editor.remove(g);e===null||e===void 0?void 0:e.removeEventListener("change",y);e===null||e===void 0?void 0:e.removeEventListener("input",y)}}// eslint-disable-next-line react-hooks/exhaustive-deps
},[l]);return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mY.wrapper({hideQuickTags:a,isMinimal:n,isFocused:m,isReadOnly:l}),children:/*#__PURE__*/(0,u/* .jsx */.Y)("textarea",{"data-cy":"tutor-tinymce",ref:h,id:g,defaultValue:t})})};/* ESM default export */const mk=mA;var mY={wrapper:e=>{var{hideQuickTags:t,isMinimal:r,isFocused:n,isReadOnly:o}=e;return/*#__PURE__*/(0,d/* .css */.AH)("flex:1;.wp-editor-tools{z-index:auto;}.wp-editor-container{border-top-left-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border-bottom-left-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border-bottom-right-radius:",rn/* .borderRadius["6"] */.Vq["6"],";",n&&!o&&(0,d/* .css */.AH)(mm(),rA/* .styleUtils.inputFocus */.x.inputFocus),":focus-within{",!o&&rA/* .styleUtils.inputFocus */.x.inputFocus,"}}.wp-switch-editor{height:auto;border:1px solid #dcdcde;border-radius:0px;border-top-left-radius:",rn/* .borderRadius["4"] */.Vq["4"],";border-top-right-radius:",rn/* .borderRadius["4"] */.Vq["4"],";top:2px;padding:3px 8px 4px;font-size:13px;color:#646970;&:focus,&:active,&:hover{background:#f0f0f1;color:#646970;}}.mce-btn button{&:focus,&:active,&:hover{background:none;color:#50575e;}}.mce-toolbar-grp,.quicktags-toolbar{border-top-left-radius:",rn/* .borderRadius["6"] */.Vq["6"],";",(t||r)&&(0,d/* .css */.AH)(mb(),rn/* .borderRadius["6"] */.Vq["6"]),"}.mce-top-part::before{display:none;}.mce-statusbar{border-bottom-left-radius:",rn/* .borderRadius["6"] */.Vq["6"],";border-bottom-right-radius:",rn/* .borderRadius["6"] */.Vq["6"],";}.mce-tinymce{box-shadow:none;background-color:transparent;}.mce-edit-area{background-color:unset;}",(t||r)&&(0,d/* .css */.AH)(m_(),!o?"1px solid ".concat(rn/* .colorTokens.stroke["default"] */.I6.stroke["default"]):"none",rn/* .borderRadius["6"] */.Vq["6"],n&&!o&&(0,d/* .css */.AH)(my(),rA/* .styleUtils.inputFocus */.x.inputFocus)),"    textarea{visibility:visible !important;width:100%;resize:none;border:none;outline:none;padding:",rn/* .spacing["10"] */.YK["10"],";}")}};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/fields/FormWPEditor.tsx
function mI(){var e=(0,x._)(["\n      overflow: hidden;\n      border-radius: ",";\n    "]);mI=function t(){return e};return e}var mD;var mC={droip:"droipColorized",elementor:"elementorColorized",gutenberg:"gutenbergColorized",divi:"diviColorized"};var mS=!!nK/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url;var mM=(mD=nK/* .tutorConfig.settings */.P.settings)===null||mD===void 0?void 0:mD.chatgpt_key_exist;var mE=e=>{var{editorUsed:t,onBackToWPEditorClick:r,onCustomEditorButtonClick:n}=e;var{showModal:o}=(0,nO/* .useModal */.h)();var[a,i]=(0,v.useState)("");return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mT.editorOverlay,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:t.name!=="gutenberg",children:/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"tertiary",size:"small",buttonCss:mT.editWithButton,icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"arrowLeft",height:24,width:24}),loading:a==="back_to",onClick:()=>rI(function*(){var{action:e}=yield o({component:vS/* ["default"] */.A,props:{title:(0,h.__)("Back to WordPress Editor","tutor-pro"),description:/*#__PURE__*/(0,u/* .jsx */.Y)(nz,{type:"warning",icon:"warning",children:(0,h.__)("Warning: Switching to the WordPress default editor may cause issues with your current layout, design, and content.","tutor-pro")}),confirmButtonText:(0,h.__)("Confirm","tutor-pro"),confirmButtonVariant:"primary"},depthIndex:rn/* .zIndex.highest */.fE.highest});if(e==="CONFIRM"){try{i("back_to");yield r===null||r===void 0?void 0:r(t.name)}finally{i("")}}})(),children:(0,h.__)("Back to WordPress Editor","tutor-pro")})}),/*#__PURE__*/(0,u/* .jsx */.Y)(re/* ["default"] */.A,{variant:"tertiary",size:"small",buttonCss:mT.editWithButton,loading:a==="edit_with",icon:mC[t.name]&&/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:mC[t.name],height:24,width:24}),onClick:()=>rI(function*(){try{i("edit_with");yield n===null||n===void 0?void 0:n(t);window.location.href=t.link}finally{i("")}})(),children:/* translators: %s is the editor name */(0,h.sprintf)((0,h.__)("Edit with %s","tutor-pro"),t===null||t===void 0?void 0:t.label)})]})};var mF=e=>{var{label:t,field:r,fieldState:n,disabled:o,readOnly:a,loading:i,placeholder:s,helpText:l,onChange:c,generateWithAi:d=false,onClickAiButton:f,hasCustomEditorSupport:p=false,isMinimal:g=false,hideMediaButtons:m=false,hideQuickTags:b=false,editors:_=[],editorUsed:w={name:"classic",label:"Classic Editor",link:""},isMagicAi:x=false,autoFocus:A=false,onCustomEditorButtonClick:k,onBackToWPEditorClick:Y,onFullScreenChange:I,min_height:D,max_height:C,toolbar1:S,toolbar2:M}=e;var E,F,H,T,O;var{showModal:K}=(0,nO/* .useModal */.h)();var N=((E=nK/* .tutorConfig.settings */.P.settings)===null||E===void 0?void 0:E.hide_admin_bar_for_users)==="off";var P=(H=nK/* .tutorConfig.current_user */.P.current_user)===null||H===void 0?void 0:(F=H.roles)===null||F===void 0?void 0:F.includes(rC/* .TutorRoles.ADMINISTRATOR */.gt.ADMINISTRATOR);var L=(O=nK/* .tutorConfig.current_user */.P.current_user)===null||O===void 0?void 0:(T=O.roles)===null||T===void 0?void 0:T.includes(rC/* .TutorRoles.TUTOR_INSTRUCTOR */.gt.TUTOR_INSTRUCTOR);var[W,B]=(0,v.useState)(null);var R=_.filter(e=>P||L&&N||e.name==="droip");var z=p&&R.length>0;var V=z&&w.name!=="classic";var j=()=>{if(!mS){K({component:nL,props:{image:ol,image2x:os}})}else if(!mM){K({component:oa,props:{image:ol,image2x:os}})}else{K({component:nH,isMagicAi:true,props:{title:(0,h.__)("AI Studio","tutor-pro"),icon:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicAiColorize",width:24,height:24}),characters:1e3,field:r,fieldState:n,is_html:true}});f===null||f===void 0?void 0:f()}};var q=/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mT.editorLabel,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("span",{css:mT.labelWithAi,children:[t,/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:d,children:/*#__PURE__*/(0,u/* .jsx */.Y)("button",{type:"button",css:mT.aiButton,onClick:j,children:/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:"magicAiColorize",width:32,height:32})})})]}),/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mT.editorsButtonWrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("span",{children:(0,h.__)("Edit with","tutor-pro")}),/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mT.customEditorButtons,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rK/* ["default"] */.A,{each:R,children:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(mg/* ["default"] */.A,{content:e.label,delay:200,children:/*#__PURE__*/(0,u/* .jsxs */.FD)("button",{type:"button",css:mT.customEditorButton,disabled:W===e.name,onClick:()=>rI(function*(){try{B(e.name);yield k===null||k===void 0?void 0:k(e);window.location.href=e.link}finally{B(null)}})(),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:W===e.name,children:/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* .LoadingOverlay */.p8,{})}),/*#__PURE__*/(0,u/* .jsx */.Y)(y/* ["default"] */.A,{name:mC[e.name],height:24,width:24})]})},e.name)})})]})]});return/*#__PURE__*/(0,u/* .jsx */.Y)(rk/* ["default"] */.A,{label:z?q:t,field:r,fieldState:n,disabled:o,readOnly:a,placeholder:s,helpText:l,isMagicAi:x,generateWithAi:!z&&d,onClickAiButton:j,replaceEntireLabel:z,children:()=>{if(i){return/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:rA/* .styleUtils.flexCenter */.x.flexCenter(),children:/*#__PURE__*/(0,u/* .jsx */.Y)(rr/* ["default"] */.Ay,{size:20,color:rn/* .colorTokens.icon["default"] */.I6.icon["default"]})})}var e;return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mT.wrapper({isOverlayVisible:V}),children:[/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:V,children:/*#__PURE__*/(0,u/* .jsx */.Y)(mE,{editorUsed:w,onBackToWPEditorClick:Y,onCustomEditorButtonClick:k})}),/*#__PURE__*/(0,u/* .jsx */.Y)(mk,{value:(e=r.value)!==null&&e!==void 0?e:"",onChange:e=>{r.onChange(e);if(c){c(e)}},isMinimal:g,hideMediaButtons:m,hideQuickTags:b,autoFocus:A,onFullScreenChange:I,readonly:a,min_height:D,max_height:C,toolbar1:S,toolbar2:M})]})}})};/* ESM default export */const mH=mF;var mT={wrapper:e=>{var{isOverlayVisible:t=false}=e;return/*#__PURE__*/(0,d/* .css */.AH)("position:relative;",t&&(0,d/* .css */.AH)(mI(),rn/* .borderRadius["6"] */.Vq["6"]))},editorLabel:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;width:100%;align-items:center;justify-content:space-between;"),aiButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,";",rA/* .styleUtils.flexCenter */.x.flexCenter(),";width:32px;height:32px;border-radius:",rn/* .borderRadius["4"] */.Vq["4"],";:disabled{cursor:not-allowed;}&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";}"),labelWithAi:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["4"] */.YK["4"],";"),editorsButtonWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["8"] */.YK["8"],";color:",rn/* .colorTokens.text.hints */.I6.text.hints,";"),customEditorButtons:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;align-items:center;gap:",rn/* .spacing["4"] */.YK["4"],";"),customEditorButton:/*#__PURE__*/(0,d/* .css */.AH)(rA/* .styleUtils.resetButton */.x.resetButton,"    display:flex;align-items:center;justify-content:center;position:relative;border-radius:",rn/* .borderRadius.circle */.Vq.circle,";&:focus-visible{outline:2px solid ",rn/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}"),editorOverlay:/*#__PURE__*/(0,d/* .css */.AH)("position:absolute;height:100%;width:100%;",rA/* .styleUtils.flexCenter */.x.flexCenter(),";gap:",rn/* .spacing["8"] */.YK["8"],";background-color:",oS()(rn/* .colorTokens.background.modal */.I6.background.modal,.6),";border-radius:",rn/* .borderRadius["6"] */.Vq["6"],";z-index:",rn/* .zIndex.positive */.fE.positive,";backdrop-filter:blur(8px);"),editWithButton:/*#__PURE__*/(0,d/* .css */.AH)("background:",rn/* .colorTokens.action.secondary["default"] */.I6.action.secondary["default"],";color:",rn/* .colorTokens.text.primary */.I6.text.primary,";box-shadow:inset 0 -1px 0 0 ",oS()("#1112133D",.24),",0 1px 0 0 ",oS()("#1112133D",.8),";")};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/pages/BundleBasic.tsx
function mO(){var e=(0,c._)(["\n      z-index: ",";\n    "]);mO=function t(){return e};return e}var mK=(0,vV/* .getBundleId */.w)();var mN=false;var mP=()=>{var e;var t=(0,m/* .useFormContext */.xW)();var r=(0,f/* .useQueryClient */.jE)();var n=(0,gI/* .useSaveCourseBundleMutation */.BT)();var o=r.getQueryData(["CourseBundle",mK]);var a=g8();var[c,d]=(0,v.useState)(false);var g=(0,p/* .useIsFetching */.C)({queryKey:["CourseBundle",mK]});var b=!!nK/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url;var y=((e=nK/* .tutorConfig.settings */.P.settings)===null||e===void 0?void 0:e.chatgpt_enable)==="on";var _=t.watch("post_status");var w=t.watch("editor_used");return/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mW.wrapper,children:[/*#__PURE__*/(0,u/* .jsx */.Y)("div",{css:mW.mainForm({isWpEditorFullScreen:c}),children:/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mW.fieldsWrapper,children:[/*#__PURE__*/(0,u/* .jsxs */.FD)("div",{css:mW.titleAndSlug,children:[/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"post_title",control:t.control,rules:(0,s._)({},n2()),render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(oh,(0,l._)((0,s._)({},e),{label:(0,h.__)("Title","tutor-pro"),placeholder:(0,h.__)("ex. Learn Photoshop CS6 from scratch","tutor-pro"),isClearable:true,generateWithAi:!b||y,loading:!!g&&!e.field.value,onChange:e=>{if(_==="draft"&&!mN){t.setValue("post_name",(0,rb/* .convertToSlug */.qz)(String(e)),{shouldValidate:true,shouldDirty:true})}}}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"post_name",control:t.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(mv,(0,l._)((0,s._)({},e),{label:(0,h.__)("Bundle URL","tutor-pro"),baseURL:"".concat(nK/* .tutorConfig.home_url */.P.home_url,"/course-bundle"),onChange:()=>mN=true}))})]}),/*#__PURE__*/(0,u/* .jsx */.Y)(m/* .Controller */.xI,{name:"post_content",control:t.control,render:e=>/*#__PURE__*/(0,u/* .jsx */.Y)(mH,(0,l._)((0,s._)({},e),{label:(0,h.__)("Description","tutor-pro"),loading:!!g&&!e.field.value,max_height:280,hasCustomEditorSupport:true,editorUsed:w,editors:o===null||o===void 0?void 0:o.editors,generateWithAi:!b||y,onFullScreenChange:e=>{d(e)},onCustomEditorButtonClick:()=>{return t.handleSubmit(e=>{var r=(0,gI/* .convertBundleFormDataToPayload */.r)(e);return n.mutateAsync((0,l._)((0,s._)({ID:mK},r),{post_status:(0,rb/* .determinePostStatus */.q9)(t.getValues("post_status"),t.getValues("visibility"))}))})()},onBackToWPEditorClick:e=>(0,i._)(function*(){return a.mutateAsync({courseId:mK,builder:e}).then(e=>{t.setValue("editor_used",{name:"classic",label:(0,h.__)("Classic Editor","tutor-pro"),link:""});return e})})()}))}),/*#__PURE__*/(0,u/* .jsx */.Y)(mu,{loading:!!g&&!t.getValues("details.courses").length}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:rC/* .CURRENT_VIEWPORT.isAboveTablet */.vN.isAboveTablet,children:/*#__PURE__*/(0,u/* .jsx */.Y)(mf/* ["default"] */.A,{})})]})}),/*#__PURE__*/(0,u/* .jsx */.Y)(g_,{}),/*#__PURE__*/(0,u/* .jsx */.Y)(ra/* ["default"] */.A,{when:!rC/* .CURRENT_VIEWPORT.isAboveTablet */.vN.isAboveTablet,children:/*#__PURE__*/(0,u/* .jsx */.Y)(mf/* ["default"] */.A,{})})]})};/* ESM default export */const mL=mP;var mW={wrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:grid;grid-template-columns:1fr 338px;gap:",rn/* .spacing["32"] */.YK["32"],";width:100%;",rn/* .Breakpoint.smallTablet */.EA.smallTablet,"{grid-template-columns:1fr;gap:0;}"),mainForm:e=>{var{isWpEditorFullScreen:t}=e;return/*#__PURE__*/(0,d/* .css */.AH)("padding-block:",rn/* .spacing["32"] */.YK["32"]," ",rn/* .spacing["24"] */.YK["24"],";align-self:start;top:",rn/* .headerHeight */.$A,"px;position:sticky;",t&&(0,d/* .css */.AH)(mO(),rn/* .zIndex.header */.fE.header+1)," ",rn/* .Breakpoint.smallTablet */.EA.smallTablet,"{padding-top:",rn/* .spacing["16"] */.YK["16"],";position:unset;}")},fieldsWrapper:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["24"] */.YK["24"],";"),titleAndSlug:/*#__PURE__*/(0,d/* .css */.AH)("display:flex;flex-direction:column;gap:",rn/* .spacing["8"] */.YK["8"],";")}},6847:function(e,t,r){r.d(t,{IF:()=>g,M6:()=>m,az:()=>v});/* ESM import */var n=r(6154);/* ESM import */var o=r(3747);/* ESM import */var a=r(4532);/* ESM import */var i=r(6439);/* ESM import */var s=r(1817);/* ESM import */var l=r(1699);/* ESM import */var c=r(1594);/* ESM import */var u=/*#__PURE__*/r.n(c);/* ESM import */var d=r(6277);/* ESM import */var f=r(9773);function p(){var e=(0,n._)(["\n      border: 1px solid ",";\n    "]);p=function t(){return e};return e}function h(){var e=(0,n._)(["\n      border-bottom: 1px solid ",";\n      padding: "," ",";\n    "]);h=function t(){return e};return e}var v=/*#__PURE__*/u().forwardRef((e,t)=>{var{children:r,className:n,bordered:a=false,wrapperCss:i}=e;return/*#__PURE__*/(0,o/* .jsx */.Y)("div",{ref:t,className:n,css:[b.wrapper(a),i],children:r})});v.displayName="Box";var g=/*#__PURE__*/u().forwardRef((e,t)=>{var{children:r,className:n,separator:a=false,tooltip:i}=e;return/*#__PURE__*/(0,o/* .jsxs */.FD)("div",{ref:t,className:n,css:b.title(a),children:[/*#__PURE__*/(0,o/* .jsx */.Y)("span",{children:r}),/*#__PURE__*/(0,o/* .jsx */.Y)(s/* ["default"] */.A,{when:i,children:/*#__PURE__*/(0,o/* .jsx */.Y)(f/* ["default"] */.A,{content:i,children:/*#__PURE__*/(0,o/* .jsx */.Y)(d/* ["default"] */.A,{name:"info",width:20,height:20})})})]})});g.displayName="BoxTitle";var m=/*#__PURE__*/u().forwardRef((e,t)=>{var{children:r,className:n}=e;return/*#__PURE__*/(0,o/* .jsx */.Y)("div",{ref:t,className:n,css:b.subtitle,children:/*#__PURE__*/(0,o/* .jsx */.Y)("span",{children:r})})});m.displayName="BoxSubtitle";var b={wrapper:e=>/*#__PURE__*/(0,l/* .css */.AH)("background-color:",a/* .colorTokens.background.white */.I6.background.white,";border-radius:",a/* .borderRadius["8"] */.Vq["8"],";padding:",a/* .spacing["12"] */.YK["12"]," ",a/* .spacing["20"] */.YK["20"]," ",a/* .spacing["20"] */.YK["20"],";",e&&(0,l/* .css */.AH)(p(),a/* .colorTokens.stroke.divider */.I6.stroke.divider)),title:e=>/*#__PURE__*/(0,l/* .css */.AH)(i/* .typography.body */.I.body("medium"),";color:",a/* .colorTokens.text.title */.I6.text.title,";display:flex;gap:",a/* .spacing["4"] */.YK["4"],";align-items:center;",e&&(0,l/* .css */.AH)(h(),a/* .colorTokens.stroke.divider */.I6.stroke.divider,a/* .spacing["12"] */.YK["12"],a/* .spacing["20"] */.YK["20"]),"    & > div{height:20px;svg{color:",a/* .colorTokens.icon.hints */.I6.icon.hints,";}}& > span{display:inline-block;}"),subtitle:/*#__PURE__*/(0,l/* .css */.AH)(i/* .typography.caption */.I.caption(),";color:",a/* .colorTokens.text.hints */.I6.text.hints,";")}},3953:function(e,t,r){r.d(t,{A:()=>w});/* ESM import */var n=r(7317);/* ESM import */var o=r(8015);/* ESM import */var a=r(6154);/* ESM import */var i=r(3747);/* ESM import */var s=r(4532);/* ESM import */var l=r(6439);/* ESM import */var c=r(6208);/* ESM import */var u=r(1699);/* ESM import */var d=r(1594);/* ESM import */var f=/*#__PURE__*/r.n(d);function p(){var e=(0,a._)(["\n      cursor: not-allowed;\n    "]);p=function t(){return e};return e}function h(){var e=(0,a._)(["\n      color: ",";\n    "]);h=function t(){return e};return e}function v(){var e=(0,a._)(["\n        margin-right: ",";\n      "]);v=function t(){return e};return e}function g(){var e=(0,a._)(["\n        background-color: ",";\n      "]);g=function t(){return e};return e}function m(){var e=(0,a._)(["\n      & + span::before {\n        background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='2' fill='none'%3E%3Crect width='10' height='1.5' y='.25' fill='%23fff' rx='.75'/%3E%3C/svg%3E\");\n        background-repeat: no-repeat;\n        background-size: 10px;\n        background-position: center center;\n        background-color: ",";\n        border: 0.5px solid ",";\n      }\n    "]);m=function t(){return e};return e}function b(){var e=(0,a._)(["\n      & + span {\n        cursor: not-allowed;\n\n        &::before {\n          border-color: ",";\n        }\n      }\n    "]);b=function t(){return e};return e}var y=/*#__PURE__*/f().forwardRef((e,t)=>{var{id:r=(0,c/* .nanoid */.Ak)(),name:a,labelCss:s,inputCss:l,label:u="",checked:d,value:p,disabled:h=false,onChange:v,onBlur:g,isIndeterminate:m=false}=e;var b=e=>{v===null||v===void 0?void 0:v(!m?e.target.checked:true,e)};var y=e=>{if(typeof e==="string"){return e}if(typeof e==="number"||typeof e==="boolean"||e===null){return String(e)}if(e===undefined){return""}if(/*#__PURE__*/f().isValidElement(e)){var t;var r=(t=e.props)===null||t===void 0?void 0:t.children;if(typeof r==="string"){return r}if(Array.isArray(r)){return r.map(e=>typeof e==="string"?e:"").filter(Boolean).join(" ")}}return""};return/*#__PURE__*/(0,i/* .jsxs */.FD)("label",{htmlFor:r,css:[_.container({disabled:h}),s],children:[/*#__PURE__*/(0,i/* .jsx */.Y)("input",(0,o._)((0,n._)({},e),{ref:t,id:r,name:a,type:"checkbox",value:p,checked:!!d,disabled:h,"aria-invalid":e["aria-invalid"],onChange:b,onBlur:g,css:[l,_.checkbox({label:!!u,isIndeterminate:m,disabled:h})]})),/*#__PURE__*/(0,i/* .jsx */.Y)("span",{}),/*#__PURE__*/(0,i/* .jsx */.Y)("span",{css:[_.label({isDisabled:h}),s],title:y(u),children:u})]})});var _={container:e=>{var{disabled:t=false}=e;return/*#__PURE__*/(0,u/* .css */.AH)("position:relative;display:flex;align-items:center;cursor:pointer;user-select:none;color:",s/* .colorTokens.text.title */.I6.text.title,";",t&&(0,u/* .css */.AH)(p()))},label:e=>{var{isDisabled:t=false}=e;return/*#__PURE__*/(0,u/* .css */.AH)(l/* .typography.caption */.I.caption(),";color:",s/* .colorTokens.text.title */.I6.text.title,";",t&&(0,u/* .css */.AH)(h(),s/* .colorTokens.text.disable */.I6.text.disable))},checkbox:e=>{var{label:t,isIndeterminate:r,disabled:n}=e;return/*#__PURE__*/(0,u/* .css */.AH)("position:absolute;opacity:0 !important;height:0;width:0;& + span{position:relative;cursor:pointer;display:inline-flex;align-items:center;",t&&(0,u/* .css */.AH)(v(),s/* .spacing["10"] */.YK["10"]),"}& + span::before{content:'';background-color:",s/* .colorTokens.background.white */.I6.background.white,";border:1px solid ",s/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:3px;width:20px;height:20px;}&:checked + span::before{background-image:url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIiIGhlaWdodD0iOSIgdmlld0JveD0iMCAwIDEyIDkiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0wLjE2NTM0NCA0Ljg5OTQ2QzAuMTEzMjM1IDQuODQ0OTcgMC4wNzE3MzQ2IDQuNzgxMTUgMC4wNDI5ODg3IDQuNzExM0MtMC4wMTQzMjk2IDQuNTU1NjQgLTAuMDE0MzI5NiA0LjM4NDQ5IDAuMDQyOTg4NyA0LjIyODg0QzAuMDcxMTU0OSA0LjE1ODY4IDAuMTEyNzIzIDQuMDk0NzUgMC4xNjUzNDQgNC4wNDA2OEwxLjAzMzgyIDMuMjAzNkMxLjA4NDkzIDMuMTQzNCAxLjE0ODkgMy4wOTU1NyAxLjIyMDk2IDMuMDYzNjlDMS4yOTAzMiAzLjAzMjEzIDEuMzY1NTQgMy4wMTU2OSAxLjQ0MTY3IDMuMDE1NDRDMS41MjQxOCAzLjAxMzgzIDEuNjA2MDUgMy4wMzAyOSAxLjY4MTU5IDMuMDYzNjlDMS43NTYyNiAzLjA5NzA3IDEuODIzODYgMy4xNDQ1NyAxLjg4MDcxIDMuMjAzNkw0LjUwMDU1IDUuODQyNjhMMTAuMTI0MSAwLjE4ODIwNUMxMC4xNzk0IDAuMTI5NTQ0IDEwLjI0NTQgMC4wODIwNTQyIDEwLjMxODQgMC4wNDgyOTA4QzEwLjM5NDEgMC4wMTU0NjYxIDEwLjQ3NTkgLTAuMDAwOTcyMDU3IDEwLjU1ODMgNC40NDIyOGUtMDVDMTAuNjM1NyAwLjAwMDQ3NTMxOCAxMC43MTIxIDAuMDE3NDc5NSAxMC43ODI0IDAuMDQ5OTI0MkMxMC44NTI3IDAuMDgyMzY4OSAxMC45MTU0IDAuMTI5NTA5IDEwLjk2NjIgMC4xODgyMDVMMTEuODM0NyAxLjAzNzM0QzExLjg4NzMgMS4wOTE0MiAxMS45Mjg4IDEuMTU1MzQgMTEuOTU3IDEuMjI1NUMxMi4wMTQzIDEuMzgxMTYgMTIuMDE0MyAxLjU1MjMxIDExLjk1NyAxLjcwNzk2QzExLjkyODMgMS43Nzc4MSAxMS44ODY4IDEuODQxNjMgMTEuODM0NyAxLjg5NjEzTDQuOTIyOCA4LjgwOTgyQzQuODcxMjkgOC44NzAyMSA0LjgwNzQ3IDguOTE4NzUgNC43MzU2NiA4Ljk1MjE1QzQuNTgyMDIgOS4wMTU5NSA0LjQwOTQ5IDkuMDE1OTUgNC4yNTU4NCA4Ljk1MjE1QzQuMTg0MDQgOC45MTg3NSA0LjEyMDIyIDguODcwMjEgNC4wNjg3MSA4LjgwOTgyTDAuMTY1MzQ0IDQuODk5NDZaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K');background-repeat:no-repeat;background-size:10px 10px;background-position:center center;border-color:transparent;background-color:",s/* .colorTokens.icon.brand */.I6.icon.brand,";border-radius:",s/* .borderRadius["4"] */.Vq["4"],";",n&&(0,u/* .css */.AH)(g(),s/* .colorTokens.icon.disable["default"] */.I6.icon.disable["default"]),"}",r&&(0,u/* .css */.AH)(m(),s/* .colorTokens.brand.blue */.I6.brand.blue,s/* .colorTokens.stroke.white */.I6.stroke.white)," ",n&&(0,u/* .css */.AH)(b(),s/* .colorTokens.stroke.disable */.I6.stroke.disable),"    &:focus-visible{& + span{border-radius:",s/* .borderRadius["2"] */.Vq["2"],";outline:2px solid ",s/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}}")}};/* ESM default export */const w=y},9789:function(e,t,r){r.d(t,{A:()=>v});/* ESM import */var n=r(7317);/* ESM import */var o=r(8015);/* ESM import */var a=r(9414);/* ESM import */var i=r(3747);/* ESM import */var s=r(3953);/* ESM import */var l=r(4532);/* ESM import */var c=r(6439);/* ESM import */var u=r(1699);/* ESM import */var d=r(6277);/* ESM import */var f=r(9773);/* ESM import */var p=r(3347);var h=e=>{var{field:t,fieldState:r,disabled:l,value:c,onChange:u,label:h,description:v,helpText:m,isHidden:b,labelCss:y}=e;return/*#__PURE__*/(0,i/* .jsx */.Y)(p/* ["default"] */.A,{field:t,fieldState:r,isHidden:b,children:e=>{var{css:r}=e,p=(0,a._)(e,["css"]);return/*#__PURE__*/(0,i/* .jsxs */.FD)("div",{children:[/*#__PURE__*/(0,i/* .jsxs */.FD)("div",{css:g.wrapper,children:[/*#__PURE__*/(0,i/* .jsx */.Y)(s/* ["default"] */.A,(0,o._)((0,n._)({},t,p),{inputCss:r,labelCss:y,value:c,disabled:l,checked:t.value,label:h,onChange:()=>{t.onChange(!t.value);if(u){u(!t.value)}}})),m&&/*#__PURE__*/(0,i/* .jsx */.Y)(f/* ["default"] */.A,{content:m,placement:"top",allowHTML:true,children:/*#__PURE__*/(0,i/* .jsx */.Y)(d/* ["default"] */.A,{name:"info",width:20,height:20})})]}),v&&/*#__PURE__*/(0,i/* .jsx */.Y)("p",{css:g.description,children:v})]})}})};/* ESM default export */const v=h;var g={wrapper:/*#__PURE__*/(0,u/* .css */.AH)("display:flex;align-items:center;gap:",l/* .spacing["6"] */.YK["6"],";& > div{display:flex;color:",l/* .colorTokens.icon["default"] */.I6.icon["default"],";}"),description:/*#__PURE__*/(0,u/* .css */.AH)(c/* .typography.small */.I.small(),"    color:",l/* .colorTokens.text.hints */.I6.text.hints,";padding-left:30px;margin-top:",l/* .spacing["6"] */.YK["6"],";")}},3347:function(e,t,r){r.d(t,{A:()=>F});/* ESM import */var n=r(6154);/* ESM import */var o=r(3747);/* ESM import */var a=r(1699);/* ESM import */var i=r(2470);/* ESM import */var s=/*#__PURE__*/r.n(i);/* ESM import */var l=r(8589);/* ESM import */var c=r(6277);/* ESM import */var u=r(9773);/* ESM import */var d=r(4532);/* ESM import */var f=r(6439);/* ESM import */var p=r(1817);/* ESM import */var h=r(6014);/* ESM import */var v=r(7150);/* ESM import */var g=r(6208);function m(){var e=(0,n._)(["\n      opacity: 0.5;\n    "]);m=function t(){return e};return e}function b(){var e=(0,n._)(["\n      display: none;\n    "]);b=function t(){return e};return e}function y(){var e=(0,n._)(["\n      flex-direction: row;\n      align-items: center;\n      justify-content: space-between;\n      gap: ",";\n    "]);y=function t(){return e};return e}function _(){var e=(0,n._)(["\n        padding: 0 "," 0 ",";\n      "]);_=function t(){return e};return e}function w(){var e=(0,n._)(["\n        border-radius: 0;\n        border: none;\n        box-shadow: none;\n      "]);w=function t(){return e};return e}function x(){var e=(0,n._)(["\n        border-color: transparent;\n      "]);x=function t(){return e};return e}function A(){var e=(0,n._)(["\n          outline-color: ",";\n          background-color: ",";\n        "]);A=function t(){return e};return e}function k(){var e=(0,n._)(["\n          border-color: ",";\n        "]);k=function t(){return e};return e}function Y(){var e=(0,n._)(["\n          color: ",";\n        "]);Y=function t(){return e};return e}function I(){var e=(0,n._)(["\n        border-color: ",";\n        background-color: ",";\n      "]);I=function t(){return e};return e}function D(){var e=(0,n._)(["\n        border-color: ",";\n        background-color: ",";\n      "]);D=function t(){return e};return e}function C(){var e=(0,n._)(["\n      justify-content: end;\n    "]);C=function t(){return e};return e}function S(){var e=(0,n._)(["\n      color: ",";\n    "]);S=function t(){return e};return e}function M(){var e=(0,n._)(["\n      ",";\n    "]);M=function t(){return e};return e}var E=e=>{var{field:t,fieldState:r,children:n,disabled:a=false,readOnly:s=false,label:f,isInlineLabel:h=false,variant:m,loading:b,placeholder:y,helpText:_,isHidden:w=false,removeBorder:x=false,characterCount:A,isSecondary:k=false,inputStyle:Y,onClickAiButton:I,isMagicAi:D=false,generateWithAi:C=false,replaceEntireLabel:S=false}=e;var M;var E=(0,g/* .nanoid */.Ak)();var F=[H.input({variant:m,hasFieldError:!!r.error,removeBorder:x,readOnly:s,hasHelpText:!!_,isSecondary:k,isMagicAi:D})];if((0,v/* .isDefined */.O9)(Y)){F.push(Y)}var T=/*#__PURE__*/(0,o/* .jsxs */.FD)("div",{css:H.inputWrapper,children:[n({id:E,name:t.name,css:F,"aria-invalid":r.error?"true":"false",disabled:a,readOnly:s,placeholder:y,className:"tutor-input-field"}),b&&/*#__PURE__*/(0,o/* .jsx */.Y)("div",{css:H.loader,children:/*#__PURE__*/(0,o/* .jsx */.Y)(l/* ["default"] */.Ay,{size:20,color:d/* .colorTokens.icon["default"] */.I6.icon["default"]})})]});return/*#__PURE__*/(0,o/* .jsxs */.FD)("div",{css:H.container({disabled:a,isHidden:w}),"data-cy":"form-field-wrapper",children:[/*#__PURE__*/(0,o/* .jsxs */.FD)("div",{css:H.inputContainer(h),children:[(f||_)&&/*#__PURE__*/(0,o/* .jsxs */.FD)("div",{css:H.labelContainer,children:[f&&/*#__PURE__*/(0,o/* .jsxs */.FD)("label",{htmlFor:E,css:H.label(h,S),children:[f,/*#__PURE__*/(0,o/* .jsx */.Y)(p/* ["default"] */.A,{when:C,children:/*#__PURE__*/(0,o/* .jsx */.Y)("button",{type:"button",onClick:()=>{I===null||I===void 0?void 0:I()},css:H.aiButton,children:/*#__PURE__*/(0,o/* .jsx */.Y)(c/* ["default"] */.A,{name:"magicAiColorize",width:32,height:32})})})]}),_&&!S&&/*#__PURE__*/(0,o/* .jsx */.Y)(u/* ["default"] */.A,{content:_,placement:"top",allowHTML:true,children:/*#__PURE__*/(0,o/* .jsx */.Y)(c/* ["default"] */.A,{name:"info",width:20,height:20})})]}),A?/*#__PURE__*/(0,o/* .jsx */.Y)(u/* ["default"] */.A,{placement:"right",hideOnClick:false,content:A.maxLimit-A.inputCharacter>=0?A.maxLimit-A.inputCharacter:(0,i.__)("Limit exceeded","tutor-pro"),children:T}):T]}),((M=r.error)===null||M===void 0?void 0:M.message)&&/*#__PURE__*/(0,o/* .jsxs */.FD)("p",{css:H.errorLabel(!!r.error,h),children:[/*#__PURE__*/(0,o/* .jsx */.Y)(c/* ["default"] */.A,{style:H.alertIcon,name:"info",width:20,height:20})," ",r.error.message]})]})};/* ESM default export */const F=E;var H={container:e=>{var{disabled:t,isHidden:r}=e;return/*#__PURE__*/(0,a/* .css */.AH)("display:flex;flex-direction:column;position:relative;background:inherit;width:100%;",t&&(0,a/* .css */.AH)(m())," ",r&&(0,a/* .css */.AH)(b()))},inputContainer:e=>/*#__PURE__*/(0,a/* .css */.AH)("display:flex;flex-direction:column;gap:",d/* .spacing["4"] */.YK["4"],";width:100%;",e&&(0,a/* .css */.AH)(y(),d/* .spacing["12"] */.YK["12"])),input:e=>/*#__PURE__*/(0,a/* .css */.AH)("&.tutor-input-field{",f/* .typography.body */.I.body("regular"),";width:100%;border-radius:",d/* .borderRadius["6"] */.Vq["6"],";border:1px solid ",d/* .colorTokens.stroke["default"] */.I6.stroke["default"],";padding:",d/* .spacing["8"] */.YK["8"]," ",d/* .spacing["16"] */.YK["16"],";color:",d/* .colorTokens.text.title */.I6.text.title,";appearance:textfield;&:not(textarea){height:40px;}",e.hasHelpText&&(0,a/* .css */.AH)(_(),d/* .spacing["32"] */.YK["32"],d/* .spacing["12"] */.YK["12"])," ",e.removeBorder&&(0,a/* .css */.AH)(w())," ",e.isSecondary&&(0,a/* .css */.AH)(x()),":focus{",h/* .styleUtils.inputFocus */.x.inputFocus,";",e.isMagicAi&&(0,a/* .css */.AH)(A(),d/* .colorTokens.stroke.magicAi */.I6.stroke.magicAi,d/* .colorTokens.background.magicAi["8"] */.I6.background.magicAi["8"])," ",e.hasFieldError&&(0,a/* .css */.AH)(k(),d/* .colorTokens.stroke.danger */.I6.stroke.danger),"}::-webkit-outer-spin-button,::-webkit-inner-spin-button{-webkit-appearance:none;margin:0;}::placeholder{",f/* .typography.caption */.I.caption("regular"),";color:",d/* .colorTokens.text.hints */.I6.text.hints,";",e.isSecondary&&(0,a/* .css */.AH)(Y(),d/* .colorTokens.text.hints */.I6.text.hints),"}",e.hasFieldError&&(0,a/* .css */.AH)(I(),d/* .colorTokens.stroke.danger */.I6.stroke.danger,d/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail)," ",e.readOnly&&(0,a/* .css */.AH)(D(),d/* .colorTokens.background.disable */.I6.background.disable,d/* .colorTokens.background.disable */.I6.background.disable),"}"),errorLabel:(e,t)=>/*#__PURE__*/(0,a/* .css */.AH)(f/* .typography.small */.I.small(),";line-height:",d/* .lineHeight["20"] */.K_["20"],";display:flex;align-items:start;margin-top:",d/* .spacing["4"] */.YK["4"],";",t&&(0,a/* .css */.AH)(C())," ",e&&(0,a/* .css */.AH)(S(),d/* .colorTokens.text.status.onHold */.I6.text.status.onHold),"    & svg{margin-right:",d/* .spacing["2"] */.YK["2"],";transform:rotate(180deg);}"),labelContainer:/*#__PURE__*/(0,a/* .css */.AH)("display:flex;align-items:center;gap:",d/* .spacing["4"] */.YK["4"],";> div{display:flex;color:",d/* .colorTokens.color.black["30"] */.I6.color.black["30"],";}"),label:(e,t)=>/*#__PURE__*/(0,a/* .css */.AH)(f/* .typography.caption */.I.caption(),";margin:0px;width:",t?"100%":"auto",";color:",d/* .colorTokens.text.title */.I6.text.title,";display:flex;align-items:center;gap:",d/* .spacing["4"] */.YK["4"],";",e&&(0,a/* .css */.AH)(M(),f/* .typography.caption */.I.caption())),aiButton:/*#__PURE__*/(0,a/* .css */.AH)(h/* .styleUtils.resetButton */.x.resetButton,";width:32px;height:32px;border-radius:",d/* .borderRadius["4"] */.Vq["4"],";display:flex;align-items:center;justify-content:center;:disabled{cursor:not-allowed;}&:focus,&:active,&:hover{background:none;}&:focus-visible{outline:2px solid ",d/* .colorTokens.stroke.brand */.I6.stroke.brand,";}"),inputWrapper:/*#__PURE__*/(0,a/* .css */.AH)("position:relative;"),loader:/*#__PURE__*/(0,a/* .css */.AH)("position:absolute;top:50%;right:",d/* .spacing["12"] */.YK["12"],";transform:translateY(-50%);display:flex;"),alertIcon:/*#__PURE__*/(0,a/* .css */.AH)("flex-shrink:0;")}},8466:function(e,t,r){r.d(t,{A:()=>b});/* ESM import */var n=r(7317);/* ESM import */var o=r(8015);/* ESM import */var a=r(6154);/* ESM import */var i=r(3747);/* ESM import */var s=r(1699);/* ESM import */var l=r(1594);/* ESM import */var c=/*#__PURE__*/r.n(l);/* ESM import */var u=r(4532);/* ESM import */var d=r(6439);/* ESM import */var f=r(9338);/* ESM import */var p=r(6014);/* ESM import */var h=r(3347);function v(){var e=(0,a._)(["\n        resize: vertical;\n      "]);v=function t(){return e};return e}var g=6;var m=e=>{var{label:t,rows:r=g,columns:a,maxLimit:s,field:c,fieldState:u,disabled:d,readOnly:f,loading:p,placeholder:v,helpText:m,onChange:b,onKeyDown:_,isHidden:w,enableResize:x=true,isSecondary:A=false,isMagicAi:k=false,inputCss:Y,maxHeight:I,autoResize:D=false}=e;var C;var S=(C=c.value)!==null&&C!==void 0?C:"";var M=(0,l.useRef)(null);var E=undefined;if(s){E={maxLimit:s,inputCharacter:S.toString().length}}var F=()=>{if(M.current){if(I){M.current.style.maxHeight="".concat(I,"px")}M.current.style.height="auto";M.current.style.height="".concat(M.current.scrollHeight,"px")}};(0,l.useLayoutEffect)(()=>{if(D){F()}// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);return/*#__PURE__*/(0,i/* .jsx */.Y)(h/* ["default"] */.A,{label:t,field:c,fieldState:u,disabled:d,readOnly:f,loading:p,placeholder:v,helpText:m,isHidden:w,characterCount:E,isSecondary:A,isMagicAi:k,children:e=>{return/*#__PURE__*/(0,i/* .jsx */.Y)(i/* .Fragment */.FK,{children:/*#__PURE__*/(0,i/* .jsx */.Y)("div",{css:y.container(x,Y),children:/*#__PURE__*/(0,i/* .jsx */.Y)("textarea",(0,o._)((0,n._)({},c,e),{ref:e=>{c.ref(e);// @ts-ignore
M.current=e;// this is not ideal but it is the only way to set ref to the input element
},style:{maxHeight:I?"".concat(I,"px"):"none"},className:"tutor-input-field",value:S,onChange:e=>{var{value:t}=e.target;if(s&&t.trim().length>s){return}c.onChange(t);if(b){b(t)}if(D){F()}},onKeyDown:e=>{_===null||_===void 0?void 0:_(e.key)},autoComplete:"off",rows:r,cols:a}))})})}})};/* ESM default export */const b=(0,f/* .withVisibilityControl */.M)(m);var y={container:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:false,t=arguments.length>1?arguments[1]:void 0;return/*#__PURE__*/(0,s/* .css */.AH)("position:relative;display:flex;textarea{",d/* .typography.body */.I.body(),";height:auto;padding:",u/* .spacing["8"] */.YK["8"]," ",u/* .spacing["12"] */.YK["12"],";resize:none;",p/* .styleUtils.overflowYAuto */.x.overflowYAuto,";&.tutor-input-field{",t,";}",e&&(0,s/* .css */.AH)(v()),"}")}}},9338:function(e,t,r){// EXPORTS
r.d(t,{M:()=>/* binding */d});// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var n=r(7317);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_without_properties.js + 1 modules
var o=r(9414);// EXTERNAL MODULE: ./node_modules/@emotion/react/jsx-runtime/dist/emotion-react-jsx-runtime.esm.js
var a=r(3747);// EXTERNAL MODULE: external "React"
var i=r(1594);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/config.ts
var s=r(9568);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/types.ts
var l=r(7150);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/useVisibilityControl.tsx
/**
 * Custom hook to control the visibility of fields based on the provided visibility key and context.
 *
 * @param {string} visibilityKey - The key used to determine the visibility of the field.
 * @returns {boolean} - Returns true if the field should be visible, false otherwise.
 */var c=function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"";return(0,i.useMemo)(()=>{var t;// If no visibility key provided, always show the field
if(!(0,l/* .isDefined */.O9)(e)){return true}var[r,n]=(e===null||e===void 0?void 0:e.split("."))||[];if(!(0,l/* .isDefined */.O9)(r)||!(0,l/* .isDefined */.O9)(n)){return true}var o=s/* .tutorConfig */.P===null||s/* .tutorConfig */.P===void 0?void 0:(t=s/* .tutorConfig.visibility_control */.P.visibility_control)===null||t===void 0?void 0:t[r];if(!o){return true}var a=s/* .tutorConfig.current_user.roles */.P.current_user.roles;var i=a.includes("administrator")?"admin":"instructor";var c="".concat(n,"_").concat(i);if(!Object.keys(o).includes(c)){return true}return o[c]==="on"},[e])};/* ESM default export */const u=c;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hoc/withVisibilityControl.tsx
var d=e=>{return t=>{var{visibilityKey:r}=t,i=(0,o._)(t,["visibilityKey"]);var s=u(r);if(!s){return null}// @ts-ignore
return/*#__PURE__*/(0,a/* .jsx */.Y)(e,(0,n._)({},i))}}},9272:function(e,t,r){r.d(t,{C:()=>i});/* ESM import */var n=r(1594);/* ESM import */var o=r(1629);/* ESM import */var a=r(241);"use client";// src/useIsFetching.ts
function i(e,t){const r=(0,a/* .useQueryClient */.jE)(t);const i=r.getQueryCache();return n.useSyncExternalStore(n.useCallback(e=>i.subscribe(o/* .notifyManager.batchCalls */.jG.batchCalls(e)),[i]),()=>r.isFetching(e),()=>r.isFetching(e))}//# sourceMappingURL=useIsFetching.js.map
}}]);