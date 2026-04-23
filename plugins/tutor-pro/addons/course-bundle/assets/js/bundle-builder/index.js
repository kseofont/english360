(()=>{var e={6694:function(e,t,r){"use strict";// EXPORTS
r.d(t,{A:()=>/* binding */eP});// CONCATENATED MODULE: ./node_modules/@emotion/sheet/dist/emotion-sheet.esm.js
var n=false;/*

Based off glamor's StyleSheet, thanks Sunil ❤️

high performance StyleSheet for css-in-js systems

- uses multiple style tags behind the scenes for millions of rules
- uses `insertRule` for appending in production for *much* faster performance

// usage

import { StyleSheet } from '@emotion/sheet'

let styleSheet = new StyleSheet({ key: '', container: document.head })

styleSheet.insert('#box { border: 1px solid red; }')
- appends a css rule into the stylesheet

styleSheet.flush()
- empties the stylesheet of all its contents

*/function a(e){if(e.sheet){return e.sheet}// this weirdness brought to you by firefox
/* istanbul ignore next */for(var t=0;t<document.styleSheets.length;t++){if(document.styleSheets[t].ownerNode===e){return document.styleSheets[t]}}// this function should always return with a value
// TS can't understand it though so we make it stop complaining here
return undefined}function i(e){var t=document.createElement("style");t.setAttribute("data-emotion",e.key);if(e.nonce!==undefined){t.setAttribute("nonce",e.nonce)}t.appendChild(document.createTextNode(""));t.setAttribute("data-s","");return t}var o=/*#__PURE__*/function(){// Using Node instead of HTMLElement since container may be a ShadowRoot
function e(e){var t=this;this._insertTag=function(e){var r;if(t.tags.length===0){if(t.insertionPoint){r=t.insertionPoint.nextSibling}else if(t.prepend){r=t.container.firstChild}else{r=t.before}}else{r=t.tags[t.tags.length-1].nextSibling}t.container.insertBefore(e,r);t.tags.push(e)};this.isSpeedy=e.speedy===undefined?!n:e.speedy;this.tags=[];this.ctr=0;this.nonce=e.nonce;// key is the value of the data-emotion attribute, it's used to identify different sheets
this.key=e.key;this.container=e.container;this.prepend=e.prepend;this.insertionPoint=e.insertionPoint;this.before=null}var t=e.prototype;t.hydrate=function e(e){e.forEach(this._insertTag)};t.insert=function e(e){// the max length is how many rules we have per style tag, it's 65000 in speedy mode
// it's 1 in dev because we insert source maps that map a single rule to a location
// and you can only have one source map per style tag
if(this.ctr%(this.isSpeedy?65e3:1)===0){this._insertTag(i(this))}var t=this.tags[this.tags.length-1];if(this.isSpeedy){var r=a(t);try{// this is the ultrafast version, works across browsers
// the big drawback is that the css won't be editable in devtools
r.insertRule(e,r.cssRules.length)}catch(e){}}else{t.appendChild(document.createTextNode(e))}this.ctr++};t.flush=function e(){this.tags.forEach(function(e){var t;return(t=e.parentNode)==null?void 0:t.removeChild(e)});this.tags=[];this.ctr=0};return e}();// CONCATENATED MODULE: ./node_modules/stylis/src/Utility.js
/**
 * @param {number}
 * @return {number}
 */var s=Math.abs;/**
 * @param {number}
 * @return {string}
 */var u=String.fromCharCode;/**
 * @param {object}
 * @return {object}
 */var l=Object.assign;/**
 * @param {string} value
 * @param {number} length
 * @return {number}
 */function c(e,t){return v(e,0)^45?(((t<<2^v(e,0))<<2^v(e,1))<<2^v(e,2))<<2^v(e,3):0}/**
 * @param {string} value
 * @return {string}
 */function f(e){return e.trim()}/**
 * @param {string} value
 * @param {RegExp} pattern
 * @return {string?}
 */function d(e,t){return(e=t.exec(e))?e[0]:e}/**
 * @param {string} value
 * @param {(string|RegExp)} pattern
 * @param {string} replacement
 * @return {string}
 */function h(e,t,r){return e.replace(t,r)}/**
 * @param {string} value
 * @param {string} search
 * @return {number}
 */function p(e,t){return e.indexOf(t)}/**
 * @param {string} value
 * @param {number} index
 * @return {number}
 */function v(e,t){return e.charCodeAt(t)|0}/**
 * @param {string} value
 * @param {number} begin
 * @param {number} end
 * @return {string}
 */function m(e,t,r){return e.slice(t,r)}/**
 * @param {string} value
 * @return {number}
 */function g(e){return e.length}/**
 * @param {any[]} value
 * @return {number}
 */function b(e){return e.length}/**
 * @param {any} value
 * @param {any[]} array
 * @return {any}
 */function y(e,t){return t.push(e),e}/**
 * @param {string[]} array
 * @param {function} callback
 * @return {string}
 */function w(e,t){return e.map(t).join("")};// CONCATENATED MODULE: ./node_modules/stylis/src/Tokenizer.js
var _=1;var x=1;var E=0;var O=0;var S=0;var A="";/**
 * @param {string} value
 * @param {object | null} root
 * @param {object | null} parent
 * @param {string} type
 * @param {string[] | string} props
 * @param {object[] | string} children
 * @param {number} length
 */function T(e,t,r,n,a,i,o){return{value:e,root:t,parent:r,type:n,props:a,children:i,line:_,column:x,length:o,return:""}}/**
 * @param {object} root
 * @param {object} props
 * @return {object}
 */function k(e,t){return l(T("",null,null,"",null,null,0),e,{length:-e.length},t)}/**
 * @return {number}
 */function R(){return S}/**
 * @return {number}
 */function C(){S=O>0?v(A,--O):0;if(x--,S===10)x=1,_--;return S}/**
 * @return {number}
 */function P(){S=O<E?v(A,O++):0;if(x++,S===10)x=1,_++;return S}/**
 * @return {number}
 */function I(){return v(A,O)}/**
 * @return {number}
 */function D(){return O}/**
 * @param {number} begin
 * @param {number} end
 * @return {string}
 */function M(e,t){return m(A,e,t)}/**
 * @param {number} type
 * @return {number}
 */function F(e){switch(e){// \0 \t \n \r \s whitespace token
case 0:case 9:case 10:case 13:case 32:return 5;// ! + , / > @ ~ isolate token
case 33:case 43:case 44:case 47:case 62:case 64:case 126:// ; { } breakpoint token
case 59:case 123:case 125:return 4;// : accompanied token
case 58:return 3;// " ' ( [ opening delimit token
case 34:case 39:case 40:case 91:return 2;// ) ] closing delimit token
case 41:case 93:return 1}return 0}/**
 * @param {string} value
 * @return {any[]}
 */function L(e){return _=x=1,E=g(A=e),O=0,[]}/**
 * @param {any} value
 * @return {any}
 */function N(e){return A="",e}/**
 * @param {number} type
 * @return {string}
 */function j(e){return f(M(O-1,z(e===91?e+2:e===40?e+1:e)))}/**
 * @param {string} value
 * @return {string[]}
 */function U(e){return N(B(L(e)))}/**
 * @param {number} type
 * @return {string}
 */function H(e){while(S=I())if(S<33)P();else break;return F(e)>2||F(S)>3?"":" "}/**
 * @param {string[]} children
 * @return {string[]}
 */function B(e){while(P())switch(F(S)){case 0:append(V(O-1),e);break;case 2:append(j(S),e);break;default:append(from(S),e)}return e}/**
 * @param {number} index
 * @param {number} count
 * @return {string}
 */function Y(e,t){while(--t&&P())// not 0-9 A-F a-f
if(S<48||S>102||S>57&&S<65||S>70&&S<97)break;return M(e,D()+(t<6&&I()==32&&P()==32))}/**
 * @param {number} type
 * @return {number}
 */function z(e){while(P())switch(S){// ] ) " '
case e:return O;// " '
case 34:case 39:if(e!==34&&e!==39)z(S);break;// (
case 40:if(e===41)z(e);break;// \
case 92:P();break}return O}/**
 * @param {number} type
 * @param {number} index
 * @return {number}
 */function q(e,t){while(P())// //
if(e+S===47+10)break;else if(e+S===42+42&&I()===47)break;return"/*"+M(t,O-1)+"*"+u(e===47?e:P())}/**
 * @param {number} index
 * @return {string}
 */function V(e){while(!F(I()))P();return M(e,O)};// CONCATENATED MODULE: ./node_modules/stylis/src/Enum.js
var W="-ms-";var $="-moz-";var G="-webkit-";var K="comm";var Q="rule";var X="decl";var J="@page";var Z="@media";var ee="@import";var et="@charset";var er="@viewport";var en="@supports";var ea="@document";var ei="@namespace";var eo="@keyframes";var es="@font-face";var eu="@counter-style";var el="@font-feature-values";var ec="@layer";// CONCATENATED MODULE: ./node_modules/stylis/src/Serializer.js
/**
 * @param {object[]} children
 * @param {function} callback
 * @return {string}
 */function ef(e,t){var r="";var n=b(e);for(var a=0;a<n;a++)r+=t(e[a],a,e,t)||"";return r}/**
 * @param {object} element
 * @param {number} index
 * @param {object[]} children
 * @param {function} callback
 * @return {string}
 */function ed(e,t,r,n){switch(e.type){case ec:if(e.children.length)break;case ee:case X:return e.return=e.return||e.value;case K:return"";case eo:return e.return=e.value+"{"+ef(e.children,n)+"}";case Q:e.value=e.props.join(",")}return g(r=ef(e.children,n))?e.return=e.value+"{"+r+"}":""};// CONCATENATED MODULE: ./node_modules/stylis/src/Middleware.js
/**
 * @param {function[]} collection
 * @return {function}
 */function eh(e){var t=b(e);return function(r,n,a,i){var o="";for(var s=0;s<t;s++)o+=e[s](r,n,a,i)||"";return o}}/**
 * @param {function} callback
 * @return {function}
 */function ep(e){return function(t){if(!t.root){if(t=t.return)e(t)}}}/**
 * @param {object} element
 * @param {number} index
 * @param {object[]} children
 * @param {function} callback
 */function ev(e,t,r,n){if(e.length>-1){if(!e.return)switch(e.type){case DECLARATION:e.return=prefix(e.value,e.length,r);return;case KEYFRAMES:return serialize([copy(e,{value:replace(e.value,"@","@"+WEBKIT)})],n);case RULESET:if(e.length)return combine(e.props,function(t){switch(match(t,/(::plac\w+|:read-\w+)/)){// :read-(only|write)
case":read-only":case":read-write":return serialize([copy(e,{props:[replace(t,/:(read-\w+)/,":"+MOZ+"$1")]})],n);// :placeholder
case"::placeholder":return serialize([copy(e,{props:[replace(t,/:(plac\w+)/,":"+WEBKIT+"input-$1")]}),copy(e,{props:[replace(t,/:(plac\w+)/,":"+MOZ+"$1")]}),copy(e,{props:[replace(t,/:(plac\w+)/,MS+"input-$1")]})],n)}return""})}}}/**
 * @param {object} element
 * @param {number} index
 * @param {object[]} children
 */function em(e){switch(e.type){case RULESET:e.props=e.props.map(function(t){return combine(tokenize(t),function(t,r,n){switch(charat(t,0)){// \f
case 12:return substr(t,1,strlen(t));// \0 ( + > ~
case 0:case 40:case 43:case 62:case 126:return t;// :
case 58:if(n[++r]==="global")n[r]="",n[++r]="\f"+substr(n[r],r=1,-1);// \s
case 32:return r===1?"":t;default:switch(r){case 0:e=t;return sizeof(n)>1?"":t;case r=sizeof(n)-1:case 2:return r===2?t+e+e:t+e;default:return t}}})})}};// CONCATENATED MODULE: ./node_modules/stylis/src/Parser.js
/**
 * @param {string} value
 * @return {object[]}
 */function eg(e){return N(eb("",null,null,null,[""],e=L(e),0,[0],e))}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {string[]} rule
 * @param {string[]} rules
 * @param {string[]} rulesets
 * @param {number[]} pseudo
 * @param {number[]} points
 * @param {string[]} declarations
 * @return {object}
 */function eb(e,t,r,n,a,i,o,s,l){var c=0;var f=0;var d=o;var m=0;var b=0;var w=0;var _=1;var x=1;var E=1;var O=0;var S="";var A=a;var T=i;var k=n;var R=S;while(x)switch(w=O,O=P()){// (
case 40:if(w!=108&&v(R,d-1)==58){if(p(R+=h(j(O),"&","&\f"),"&\f")!=-1)E=-1;break}// " ' [
case 34:case 39:case 91:R+=j(O);break;// \t \n \r \s
case 9:case 10:case 13:case 32:R+=H(w);break;// \
case 92:R+=Y(D()-1,7);continue;// /
case 47:switch(I()){case 42:case 47:y(ew(q(P(),D()),t,r),l);break;default:R+="/"}break;// {
case 123*_:s[c++]=g(R)*E;// } ; \0
case 125*_:case 59:case 0:switch(O){// \0 }
case 0:case 125:x=0;// ;
case 59+f:if(E==-1)R=h(R,/\f/g,"");if(b>0&&g(R)-d)y(b>32?e_(R+";",n,r,d-1):e_(h(R," ","")+";",n,r,d-2),l);break;// @ ;
case 59:R+=";";// { rule/at-rule
default:y(k=ey(R,t,r,c,f,a,s,S,A=[],T=[],d),i);if(O===123)if(f===0)eb(R,t,k,k,A,i,d,s,T);else switch(m===99&&v(R,3)===110?100:m){// d l m s
case 100:case 108:case 109:case 115:eb(e,k,k,n&&y(ey(e,k,k,0,0,a,s,S,a,A=[],d),T),a,T,d,s,n?A:T);break;default:eb(R,k,k,k,[""],T,0,s,T)}}c=f=b=0,_=E=1,S=R="",d=o;break;// :
case 58:d=1+g(R),b=w;default:if(_<1){if(O==123)--_;else if(O==125&&_++==0&&C()==125)continue}switch(R+=u(O),O*_){// &
case 38:E=f>0?1:(R+="\f",-1);break;// ,
case 44:s[c++]=(g(R)-1)*E,E=1;break;// @
case 64:// -
if(I()===45)R+=j(P());m=I(),f=d=g(S=R+=V(D())),O++;break;// -
case 45:if(w===45&&g(R)==2)_=0}}return i}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {number} index
 * @param {number} offset
 * @param {string[]} rules
 * @param {number[]} points
 * @param {string} type
 * @param {string[]} props
 * @param {string[]} children
 * @param {number} length
 * @return {object}
 */function ey(e,t,r,n,a,i,o,u,l,c,d){var p=a-1;var v=a===0?i:[""];var g=b(v);for(var y=0,w=0,_=0;y<n;++y)for(var x=0,E=m(e,p+1,p=s(w=o[y])),O=e;x<g;++x)if(O=f(w>0?v[x]+" "+E:h(E,/&\f/g,v[x])))l[_++]=O;return T(e,t,r,a===0?Q:u,l,c,d)}/**
 * @param {number} value
 * @param {object} root
 * @param {object?} parent
 * @return {object}
 */function ew(e,t,r){return T(e,t,r,K,u(R()),m(e,2,-2),0)}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {number} length
 * @return {object}
 */function e_(e,t,r,n){return T(e,t,r,X,m(e,0,n),m(e,n+1,-1),n)};// CONCATENATED MODULE: ./node_modules/@emotion/cache/dist/emotion-cache.browser.esm.js
var ex=function e(e,t,r){var n=0;var a=0;while(true){n=a;a=I();// &\f
if(n===38&&a===12){t[r]=1}if(F(a)){break}P()}return M(e,O)};var eE=function e(e,t){// pretend we've started with a comma
var r=-1;var n=44;do{switch(F(n)){case 0:// &\f
if(n===38&&I()===12){// this is not 100% correct, we don't account for literal sequences here - like for example quoted strings
// stylis inserts \f after & to know when & where it should replace this sequence with the context selector
// and when it should just concatenate the outer and inner selectors
// it's very unlikely for this sequence to actually appear in a different context, so we just leverage this fact here
t[r]=1}e[r]+=ex(O-1,t,r);break;case 2:e[r]+=j(n);break;case 4:// comma
if(n===44){// colon
e[++r]=I()===58?"&\f":"";t[r]=e[r].length;break}// fallthrough
default:e[r]+=u(n)}}while(n=P())return e};var eO=function e(e,t){return N(eE(L(e),t))};// WeakSet would be more appropriate, but only WeakMap is supported in IE11
var eS=/* #__PURE__ */new WeakMap;var eA=function e(e){if(e.type!=="rule"||!e.parent||// positive .length indicates that this rule contains pseudo
// negative .length indicates that this rule has been already prefixed
e.length<1){return}var t=e.value;var r=e.parent;var n=e.column===r.column&&e.line===r.line;while(r.type!=="rule"){r=r.parent;if(!r)return}// short-circuit for the simplest case
if(e.props.length===1&&t.charCodeAt(0)!==58&&!eS.get(r)){return}// if this is an implicitly inserted rule (the one eagerly inserted at the each new nested level)
// then the props has already been manipulated beforehand as they that array is shared between it and its "rule parent"
if(n){return}eS.set(e,true);var a=[];var i=eO(t,a);var o=r.props;for(var s=0,u=0;s<i.length;s++){for(var l=0;l<o.length;l++,u++){e.props[u]=a[s]?i[s].replace(/&\f/g,o[l]):o[l]+" "+i[s]}}};var eT=function e(e){if(e.type==="decl"){var t=e.value;if(t.charCodeAt(0)===108&&// charcode for b
t.charCodeAt(2)===98){// this ignores label
e["return"]="";e.value=""}}};/* eslint-disable no-fallthrough */function ek(e,t){switch(c(e,t)){// color-adjust
case 5103:return G+"print-"+e+e;// animation, animation-(delay|direction|duration|fill-mode|iteration-count|name|play-state|timing-function)
case 5737:case 4201:case 3177:case 3433:case 1641:case 4457:case 2921:case 5572:case 6356:case 5844:case 3191:case 6645:case 3005:case 6391:case 5879:case 5623:case 6135:case 4599:case 4855:case 4215:case 6389:case 5109:case 5365:case 5621:case 3829:return G+e+e;// appearance, user-select, transform, hyphens, text-size-adjust
case 5349:case 4246:case 4810:case 6968:case 2756:return G+e+$+e+W+e+e;// flex, flex-direction
case 6828:case 4268:return G+e+W+e+e;// order
case 6165:return G+e+W+"flex-"+e+e;// align-items
case 5187:return G+e+h(e,/(\w+).+(:[^]+)/,G+"box-$1$2"+W+"flex-$1$2")+e;// align-self
case 5443:return G+e+W+"flex-item-"+h(e,/flex-|-self/,"")+e;// align-content
case 4675:return G+e+W+"flex-line-pack"+h(e,/align-content|flex-|-self/,"")+e;// flex-shrink
case 5548:return G+e+W+h(e,"shrink","negative")+e;// flex-basis
case 5292:return G+e+W+h(e,"basis","preferred-size")+e;// flex-grow
case 6060:return G+"box-"+h(e,"-grow","")+G+e+W+h(e,"grow","positive")+e;// transition
case 4554:return G+h(e,/([^-])(transform)/g,"$1"+G+"$2")+e;// cursor
case 6187:return h(h(h(e,/(zoom-|grab)/,G+"$1"),/(image-set)/,G+"$1"),e,"")+e;// background, background-image
case 5495:case 3959:return h(e,/(image-set\([^]*)/,G+"$1"+"$`$1");// justify-content
case 4968:return h(h(e,/(.+:)(flex-)?(.*)/,G+"box-pack:$3"+W+"flex-pack:$3"),/s.+-b[^;]+/,"justify")+G+e+e;// (margin|padding)-inline-(start|end)
case 4095:case 3583:case 4068:case 2532:return h(e,/(.+)-inline(.+)/,G+"$1$2")+e;// (min|max)?(width|height|inline-size|block-size)
case 8116:case 7059:case 5753:case 5535:case 5445:case 5701:case 4933:case 4677:case 5533:case 5789:case 5021:case 4765:// stretch, max-content, min-content, fill-available
if(g(e)-1-t>6)switch(v(e,t+1)){// (m)ax-content, (m)in-content
case 109:// -
if(v(e,t+4)!==45)break;// (f)ill-available, (f)it-content
case 102:return h(e,/(.+:)(.+)-([^]+)/,"$1"+G+"$2-$3"+"$1"+$+(v(e,t+3)==108?"$3":"$2-$3"))+e;// (s)tretch
case 115:return~p(e,"stretch")?ek(h(e,"stretch","fill-available"),t)+e:e}break;// position: sticky
case 4949:// (s)ticky?
if(v(e,t+1)!==115)break;// display: (flex|inline-flex)
case 6444:switch(v(e,g(e)-3-(~p(e,"!important")&&10))){// stic(k)y
case 107:return h(e,":",":"+G)+e;// (inline-)?fl(e)x
case 101:return h(e,/(.+:)([^;!]+)(;|!.+)?/,"$1"+G+(v(e,14)===45?"inline-":"")+"box$3"+"$1"+G+"$2$3"+"$1"+W+"$2box$3")+e}break;// writing-mode
case 5936:switch(v(e,t+11)){// vertical-l(r)
case 114:return G+e+W+h(e,/[svh]\w+-[tblr]{2}/,"tb")+e;// vertical-r(l)
case 108:return G+e+W+h(e,/[svh]\w+-[tblr]{2}/,"tb-rl")+e;// horizontal(-)tb
case 45:return G+e+W+h(e,/[svh]\w+-[tblr]{2}/,"lr")+e}return G+e+W+e+e}return e}var eR=function e(e,t,r,n){if(e.length>-1){if(!e["return"])switch(e.type){case X:e["return"]=ek(e.value,e.length);break;case eo:return ef([k(e,{value:h(e.value,"@","@"+G)})],n);case Q:if(e.length)return w(e.props,function(t){switch(d(t,/(::plac\w+|:read-\w+)/)){// :read-(only|write)
case":read-only":case":read-write":return ef([k(e,{props:[h(t,/:(read-\w+)/,":"+$+"$1")]})],n);// :placeholder
case"::placeholder":return ef([k(e,{props:[h(t,/:(plac\w+)/,":"+G+"input-$1")]}),k(e,{props:[h(t,/:(plac\w+)/,":"+$+"$1")]}),k(e,{props:[h(t,/:(plac\w+)/,W+"input-$1")]})],n)}return""})}}};var eC=[eR];var eP=function e(e){var t=e.key;if(t==="css"){var r=document.querySelectorAll("style[data-emotion]:not([data-s])");// get SSRed styles out of the way of React's hydration
// document.head is a safe place to move them to(though note document.head is not necessarily the last place they will be)
// note this very very intentionally targets all style elements regardless of the key to ensure
// that creating a cache works inside of render of a React component
Array.prototype.forEach.call(r,function(e){// we want to only move elements which have a space in the data-emotion attribute value
// because that indicates that it is an Emotion 11 server-side rendered style elements
// while we will already ignore Emotion 11 client-side inserted styles because of the :not([data-s]) part in the selector
// Emotion 10 client-side inserted styles did not have data-s (but importantly did not have a space in their data-emotion attributes)
// so checking for the space ensures that loading Emotion 11 after Emotion 10 has inserted some styles
// will not result in the Emotion 10 styles being destroyed
var t=e.getAttribute("data-emotion");if(t.indexOf(" ")===-1){return}document.head.appendChild(e);e.setAttribute("data-s","")})}var n=e.stylisPlugins||eC;var a={};var i;var s=[];{i=e.container||document.head;Array.prototype.forEach.call(// means that the style elements we're looking at are only Emotion 11 server-rendered style elements
document.querySelectorAll('style[data-emotion^="'+t+' "]'),function(e){var t=e.getAttribute("data-emotion").split(" ");for(var r=1;r<t.length;r++){a[t[r]]=true}s.push(e)})}var u;var l=[eA,eT];{var c;var f=[ed,ep(function(e){c.insert(e)})];var d=eh(l.concat(n,f));var h=function e(e){return ef(eg(e),d)};u=function e(e,t,r,n){c=r;h(e?e+"{"+t.styles+"}":t.styles);if(n){p.inserted[t.name]=true}}}var p={key:t,sheet:new o({key:t,container:i,nonce:e.nonce,speedy:e.speedy,prepend:e.prepend,insertionPoint:e.insertionPoint}),nonce:e.nonce,inserted:a,registered:{},insert:u};p.sheet.hydrate(s);return p}},8663:function(e,t,r){"use strict";r.d(t,{C:()=>d,E:()=>A,T:()=>v,c:()=>E,h:()=>_,i:()=>c,w:()=>p});/* ESM import */var n=r(1594);/* ESM import */var a=/*#__PURE__*/r.n(n);/* ESM import */var i=r(6694);/* ESM import */var o=r(41);/* ESM import */var s=r(4614);/* ESM import */var u=r(1287);var l=false;var c=typeof document!=="undefined";var f=/* #__PURE__ */n.createContext(// because this module is primarily intended for the browser and node
// but it's also required in react native and similar environments sometimes
// and we could have a special build just for that
// but this is much easier and the native packages
// might use a different theme context in the future anyway
typeof HTMLElement!=="undefined"?/* #__PURE__ */(0,i/* ["default"] */.A)({key:"css"}):null);var d=f.Provider;var h=function e(){return useContext(f)};var p=function e(e){return/*#__PURE__*/(0,n.forwardRef)(function(t,r){// the cache will never be null in the browser
var a=(0,n.useContext)(f);return e(t,a,r)})};if(!c){p=function e(e){return function(t){var r=(0,n.useContext)(f);if(r===null){// yes, we're potentially creating this on every render
// it doesn't actually matter though since it's only on the server
// so there will only every be a single render
// that could change in the future because of suspense and etc. but for now,
// this works and i don't want to optimise for a future thing that we aren't sure about
r=(0,i/* ["default"] */.A)({key:"css"});return /*#__PURE__*/n.createElement(f.Provider,{value:r},e(t,r))}else{return e(t,r)}}}}var v=/* #__PURE__ */n.createContext({});var m=function e(){return React.useContext(v)};var g=function e(e,t){if(typeof t==="function"){var r=t(e);return r}return _extends({},e,t)};var b=/* #__PURE__ *//* unused pure expression or super */null&&weakMemoize(function(e){return weakMemoize(function(t){return g(e,t)})});var y=function e(e){var t=React.useContext(v);if(e.theme!==t){t=b(t)(e.theme)}return /*#__PURE__*/React.createElement(v.Provider,{value:t},e.children)};function w(e){var t=e.displayName||e.name||"Component";var r=/*#__PURE__*/React.forwardRef(function t(t,r){var n=React.useContext(v);return /*#__PURE__*/React.createElement(e,_extends({theme:n,ref:r},t))});r.displayName="WithTheme("+t+")";return hoistNonReactStatics(r,e)}var _={}.hasOwnProperty;var x="__EMOTION_TYPE_PLEASE_DO_NOT_USE__";var E=function e(e,t){var r={};for(var n in t){if(_.call(t,n)){r[n]=t[n]}}r[x]=e;// Runtime labeling is an opt-in feature because:
return r};var O=function e(e){var t=e.cache,r=e.serialized,a=e.isStringTag;(0,o/* .registerStyles */.SF)(t,r,a);var i=(0,u/* .useInsertionEffectAlwaysWithSyncFallback */.s)(function(){return(0,o/* .insertStyles */.sk)(t,r,a)});if(!c&&i!==undefined){var s;var l=r.name;var f=r.next;while(f!==undefined){l+=" "+f.name;f=f.next}return /*#__PURE__*/n.createElement("style",(s={},s["data-emotion"]=t.key+" "+l,s.dangerouslySetInnerHTML={__html:i},s.nonce=t.sheet.nonce,s))}return null};var S=/* #__PURE__ */p(function(e,t,r){var a=e.css;// so that using `css` from `emotion` and passing the result to the css prop works
// not passing the registered cache to serializeStyles because it would
// make certain babel optimisations not possible
if(typeof a==="string"&&t.registered[a]!==undefined){a=t.registered[a]}var i=e[x];var u=[a];var c="";if(typeof e.className==="string"){c=(0,o/* .getRegisteredStyles */.Rk)(t.registered,u,e.className)}else if(e.className!=null){c=e.className+" "}var f=(0,s/* .serializeStyles */.J)(u,undefined,n.useContext(v));c+=t.key+"-"+f.name;var d={};for(var h in e){if(_.call(e,h)&&h!=="css"&&h!==x&&!l){d[h]=e[h]}}d.className=c;if(r){d.ref=r}return /*#__PURE__*/n.createElement(n.Fragment,null,/*#__PURE__*/n.createElement(O,{cache:t,serialized:f,isStringTag:typeof i==="string"}),/*#__PURE__*/n.createElement(i,d))});var A=S},1699:function(e,t,r){"use strict";r.d(t,{AH:()=>p,i7:()=>v,mL:()=>h});/* ESM import */var n=r(8663);/* ESM import */var a=r(1594);/* ESM import */var i=/*#__PURE__*/r.n(a);/* ESM import */var o=r(41);/* ESM import */var s=r(1287);/* ESM import */var u=r(4614);/* ESM import */var l=r(6694);/* ESM import */var c=r(4146);/* ESM import */var f=/*#__PURE__*/r.n(c);var d=function e(e,t){// eslint-disable-next-line prefer-rest-params
var r=arguments;if(t==null||!n.h.call(t,"css")){return a.createElement.apply(undefined,r)}var i=r.length;var o=new Array(i);o[0]=n.E;o[1]=(0,n.c)(e,t);for(var s=2;s<i;s++){o[s]=r[s]}return a.createElement.apply(null,o)};(function(e){var t;(function(e){})(t||(t=e.JSX||(e.JSX={})))})(d||(d={}));// initial render from browser, insertBefore context.sheet.tags[0] or if a style hasn't been inserted there yet, appendChild
// initial client-side render from SSR, use place of hydrating tag
var h=/* #__PURE__ */(0,n.w)(function(e,t){var r=e.styles;var i=(0,u/* .serializeStyles */.J)([r],undefined,a.useContext(n.T));if(!n.i){var l;var c=i.name;var f=i.styles;var d=i.next;while(d!==undefined){c+=" "+d.name;f+=d.styles;d=d.next}var h=t.compat===true;var p=t.insert("",{name:c,styles:f},t.sheet,h);if(h){return null}return /*#__PURE__*/a.createElement("style",(l={},l["data-emotion"]=t.key+"-global "+c,l.dangerouslySetInnerHTML={__html:p},l.nonce=t.sheet.nonce,l))}// yes, i know these hooks are used conditionally
// but it is based on a constant that will never change at runtime
// it's effectively like having two implementations and switching them out
// so it's not actually breaking anything
var v=a.useRef();(0,s/* .useInsertionEffectWithLayoutFallback */.i)(function(){var e=t.key+"-global";// use case of https://github.com/emotion-js/emotion/issues/2675
var r=new t.sheet.constructor({key:e,nonce:t.sheet.nonce,container:t.sheet.container,speedy:t.sheet.isSpeedy});var n=false;var a=document.querySelector('style[data-emotion="'+e+" "+i.name+'"]');if(t.sheet.tags.length){r.before=t.sheet.tags[0]}if(a!==null){n=true;// clear the hash so this node won't be recognizable as rehydratable by other <Global/>s
a.setAttribute("data-emotion",e);r.hydrate([a])}v.current=[r,n];return function(){r.flush()}},[t]);(0,s/* .useInsertionEffectWithLayoutFallback */.i)(function(){var e=v.current;var r=e[0],n=e[1];if(n){e[1]=false;return}if(i.next!==undefined){// insert keyframes
(0,o/* .insertStyles */.sk)(t,i.next,true)}if(r.tags.length){// if this doesn't exist then it will be null so the style element will be appended
var a=r.tags[r.tags.length-1].nextElementSibling;r.before=a;r.flush()}t.insert("",i,r,false)},[t,i.name]);return null});function p(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++){t[r]=arguments[r]}return(0,u/* .serializeStyles */.J)(t)}function v(){var e=p.apply(void 0,arguments);var t="animation-"+e.name;return{name:t,styles:"@keyframes "+t+"{"+e.styles+"}",anim:1,toString:function e(){return"_EMO_"+this.name+"_"+this.styles+"_EMO_"}}}var m=function e(t){var r=t.length;var n=0;var a="";for(;n<r;n++){var i=t[n];if(i==null)continue;var o=void 0;switch(typeof i){case"boolean":break;case"object":{if(Array.isArray(i)){o=e(i)}else{o="";for(var s in i){if(i[s]&&s){o&&(o+=" ");o+=s}}}break}default:{o=i}}if(o){a&&(a+=" ");a+=o}}return a};function g(e,t,r){var n=[];var a=getRegisteredStyles(e,n,r);if(n.length<2){return r}return a+t(n)}var b=function e(e){var t=e.cache,r=e.serializedArr;var n=useInsertionEffectAlwaysWithSyncFallback(function(){var e="";for(var n=0;n<r.length;n++){var a=insertStyles(t,r[n],false);if(!isBrowser&&a!==undefined){e+=a}}if(!isBrowser){return e}});if(!isBrowser&&n.length!==0){var a;return /*#__PURE__*/React.createElement("style",(a={},a["data-emotion"]=t.key+" "+r.map(function(e){return e.name}).join(" "),a.dangerouslySetInnerHTML={__html:n},a.nonce=t.sheet.nonce,a))}return null};var y=/* #__PURE__ *//* unused pure expression or super */null&&withEmotionCache(function(e,t){var r=false;var n=[];var a=function e(){if(r&&isDevelopment){throw new Error("css can only be used during render")}for(var e=arguments.length,a=new Array(e),i=0;i<e;i++){a[i]=arguments[i]}var o=serializeStyles(a,t.registered);n.push(o);// registration has to happen here as the result of this might get consumed by `cx`
registerStyles(t,o,false);return t.key+"-"+o.name};var i=function e(){if(r&&isDevelopment){throw new Error("cx can only be used during render")}for(var e=arguments.length,n=new Array(e),i=0;i<e;i++){n[i]=arguments[i]}return g(t.registered,a,m(n))};var o={css:a,cx:i,theme:React.useContext(ThemeContext)};var s=e.children(o);r=true;return /*#__PURE__*/React.createElement(React.Fragment,null,/*#__PURE__*/React.createElement(b,{cache:t,serializedArr:n}),s)})},3747:function(e,t,r){"use strict";r.d(t,{FD:()=>h,FK:()=>f,Y:()=>d});/* ESM import */var n=r(4848);/* ESM import */var a=r(8663);/* ESM import */var i=r(1594);/* ESM import */var o=/*#__PURE__*/r.n(i);/* ESM import */var s=r(6694);/* ESM import */var u=r(4146);/* ESM import */var l=/*#__PURE__*/r.n(u);/* ESM import */var c=r(1287);var f=n.Fragment;var d=function e(e,t,r){if(!a.h.call(t,"css")){return n.jsx(e,t,r)}return n.jsx(a.E,(0,a.c)(e,t),r)};var h=function e(e,t,r){if(!a.h.call(t,"css")){return n.jsxs(e,t,r)}return n.jsxs(a.E,(0,a.c)(e,t),r)}},4614:function(e,t,r){"use strict";// EXPORTS
r.d(t,{J:()=>/* binding */b});// CONCATENATED MODULE: ./node_modules/@emotion/hash/dist/emotion-hash.esm.js
/* eslint-disable */// Inspired by https://github.com/garycourt/murmurhash-js
// Ported from https://github.com/aappleby/smhasher/blob/61a0530f28277f2e850bfc39600ce61d02b518de/src/MurmurHash2.cpp#L37-L86
function n(e){// 'm' and 'r' are mixing constants generated offline.
// They're not really 'magic', they just happen to work well.
// const m = 0x5bd1e995;
// const r = 24;
// Initialize the hash
var t=0;// Mix 4 bytes at a time into the hash
var r,n=0,a=e.length;for(;a>=4;++n,a-=4){r=e.charCodeAt(n)&255|(e.charCodeAt(++n)&255)<<8|(e.charCodeAt(++n)&255)<<16|(e.charCodeAt(++n)&255)<<24;r=/* Math.imul(k, m): */(r&65535)*0x5bd1e995+((r>>>16)*59797<<16);r^=/* k >>> r: */r>>>24;t=/* Math.imul(k, m): */(r&65535)*0x5bd1e995+((r>>>16)*59797<<16)^/* Math.imul(h, m): */(t&65535)*0x5bd1e995+((t>>>16)*59797<<16)}// Handle the last few bytes of the input array
switch(a){case 3:t^=(e.charCodeAt(n+2)&255)<<16;case 2:t^=(e.charCodeAt(n+1)&255)<<8;case 1:t^=e.charCodeAt(n)&255;t=/* Math.imul(h, m): */(t&65535)*0x5bd1e995+((t>>>16)*59797<<16)}// Do a few final mixes of the hash to ensure the last few
// bytes are well-incorporated.
t^=t>>>13;t=/* Math.imul(h, m): */(t&65535)*0x5bd1e995+((t>>>16)*59797<<16);return((t^t>>>15)>>>0).toString(36)};// CONCATENATED MODULE: ./node_modules/@emotion/unitless/dist/emotion-unitless.esm.js
var a={animationIterationCount:1,aspectRatio:1,borderImageOutset:1,borderImageSlice:1,borderImageWidth:1,boxFlex:1,boxFlexGroup:1,boxOrdinalGroup:1,columnCount:1,columns:1,flex:1,flexGrow:1,flexPositive:1,flexShrink:1,flexNegative:1,flexOrder:1,gridRow:1,gridRowEnd:1,gridRowSpan:1,gridRowStart:1,gridColumn:1,gridColumnEnd:1,gridColumnSpan:1,gridColumnStart:1,msGridRow:1,msGridRowSpan:1,msGridColumn:1,msGridColumnSpan:1,fontWeight:1,lineHeight:1,opacity:1,order:1,orphans:1,scale:1,tabSize:1,widows:1,zIndex:1,zoom:1,WebkitLineClamp:1,// SVG-related properties
fillOpacity:1,floodOpacity:1,stopOpacity:1,strokeDasharray:1,strokeDashoffset:1,strokeMiterlimit:1,strokeOpacity:1,strokeWidth:1};// CONCATENATED MODULE: ./node_modules/@emotion/memoize/dist/emotion-memoize.esm.js
function i(e){var t=Object.create(null);return function(r){if(t[r]===undefined)t[r]=e(r);return t[r]}};// CONCATENATED MODULE: ./node_modules/@emotion/serialize/dist/emotion-serialize.esm.js
var o=false;var s=/[A-Z]|^ms/g;var u=/_EMO_([^_]+?)_([^]*?)_EMO_/g;var l=function e(e){return e.charCodeAt(1)===45};var c=function e(e){return e!=null&&typeof e!=="boolean"};var f=/* #__PURE__ */i(function(e){return l(e)?e:e.replace(s,"-$&").toLowerCase()});var d=function e(e,t){switch(e){case"animation":case"animationName":{if(typeof t==="string"){return t.replace(u,function(e,t,r){g={name:t,styles:r,next:g};return t})}}}if(a[e]!==1&&!l(e)&&typeof t==="number"&&t!==0){return t+"px"}return t};var h="Component selectors can only be used in conjunction with "+"@emotion/babel-plugin, the swc Emotion plugin, or another Emotion-aware "+"compiler transform.";function p(e,t,r){if(r==null){return""}var n=r;if(n.__emotion_styles!==undefined){return n}switch(typeof r){case"boolean":{return""}case"object":{var a=r;if(a.anim===1){g={name:a.name,styles:a.styles,next:g};return a.name}var i=r;if(i.styles!==undefined){var o=i.next;if(o!==undefined){// not the most efficient thing ever but this is a pretty rare case
// and there will be very few iterations of this generally
while(o!==undefined){g={name:o.name,styles:o.styles,next:g};o=o.next}}var s=i.styles+";";return s}return v(e,t,r)}case"function":{if(e!==undefined){var u=g;var l=r(e);g=u;return p(e,t,l)}break}}// finalize string values (regular strings and functions interpolated into css calls)
var c=r;if(t==null){return c}var f=t[c];return f!==undefined?f:c}function v(e,t,r){var n="";if(Array.isArray(r)){for(var a=0;a<r.length;a++){n+=p(e,t,r[a])+";"}}else{for(var i in r){var s=r[i];if(typeof s!=="object"){var u=s;if(t!=null&&t[u]!==undefined){n+=i+"{"+t[u]+"}"}else if(c(u)){n+=f(i)+":"+d(i,u)+";"}}else{if(i==="NO_COMPONENT_SELECTOR"&&o){throw new Error(h)}if(Array.isArray(s)&&typeof s[0]==="string"&&(t==null||t[s[0]]===undefined)){for(var l=0;l<s.length;l++){if(c(s[l])){n+=f(i)+":"+d(i,s[l])+";"}}}else{var v=p(e,t,s);switch(i){case"animation":case"animationName":{n+=f(i)+":"+v+";";break}default:{n+=i+"{"+v+"}"}}}}}}return n}var m=/label:\s*([^\s;{]+)\s*(;|$)/g;// this is the cursor for keyframes
// keyframes are stored on the SerializedStyles object as a linked list
var g;function b(e,t,r){if(e.length===1&&typeof e[0]==="object"&&e[0]!==null&&e[0].styles!==undefined){return e[0]}var a=true;var i="";g=undefined;var o=e[0];if(o==null||o.raw===undefined){a=false;i+=p(r,t,o)}else{var s=o;i+=s[0]}// we start at 1 since we've already handled the first arg
for(var u=1;u<e.length;u++){i+=p(r,t,e[u]);if(a){var l=o;i+=l[u]}}// using a global regex with .exec is stateful so lastIndex has to be reset each time
m.lastIndex=0;var c="";var f;// https://esbench.com/bench/5b809c2cf2949800a0f61fb5
while((f=m.exec(i))!==null){c+="-"+f[1]}var d=n(i)+c;return{name:d,styles:i,next:g}}},1287:function(e,t,r){"use strict";r.d(t,{i:()=>u,s:()=>s});/* ESM import */var n=r(1594);/* ESM import */var a=/*#__PURE__*/r.n(n);var i=function e(e){return e()};var o=n["useInsertion"+"Effect"]?n["useInsertion"+"Effect"]:false;var s=o||i;var u=o||n.useLayoutEffect},41:function(e,t,r){"use strict";r.d(t,{Rk:()=>a,SF:()=>i,sk:()=>o});var n=true;function a(e,t,r){var n="";r.split(" ").forEach(function(r){if(e[r]!==undefined){t.push(e[r]+";")}else if(r){n+=r+" "}});return n}var i=function e(e,t,r){var a=e.key+"-"+t.name;if(// class name could be used further down
// the tree but if it's a string tag, we know it won't
// so we don't have to add it to registered cache.
// this improves memory usage since we can avoid storing the whole style string
(r===false||// we need to always store it if we're in compat mode and
// in node since emotion-server relies on whether a style is in
// the registered cache to know whether a style is global or not
// also, note that this check will be dead code eliminated in the browser
n===false)&&e.registered[a]===undefined){e.registered[a]=t.styles}};var o=function e(e,t,r){i(e,t,r);var n=e.key+"-"+t.name;if(e.inserted[t.name]===undefined){var a=t;do{e.insert(t===a?"."+n:"",a,e.sheet,true);a=a.next}while(a!==undefined)}}},5588:function(e,t,r){"use strict";r.d(t,{Gh:()=>$,HS:()=>K,Oi:()=>l,Rr:()=>v,TM:()=>u,pX:()=>ef,pb:()=>B,rc:()=>a,tH:()=>er,ue:()=>_,yD:()=>W});/**
 * @remix-run/router v1.23.0
 *
 * Copyright (c) Remix Software Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.md file in the root directory of this source tree.
 *
 * @license MIT
 */function n(){n=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r){if(Object.prototype.hasOwnProperty.call(r,n)){e[n]=r[n]}}}return e};return n.apply(this,arguments)}////////////////////////////////////////////////////////////////////////////////
//#region Types and Constants
////////////////////////////////////////////////////////////////////////////////
/**
 * Actions represent the type of change to a location value.
 */var a;(function(e){/**
   * A POP indicates a change to an arbitrary index in the history stack, such
   * as a back or forward navigation. It does not describe the direction of the
   * navigation, only that the current index changed.
   *
   * Note: This is the default action for newly created history objects.
   */e["Pop"]="POP";/**
   * A PUSH indicates a new entry being added to the history stack, such as when
   * a link is clicked and a new page loads. When this happens, all subsequent
   * entries in the stack are lost.
   */e["Push"]="PUSH";/**
   * A REPLACE indicates the entry at the current index in the history stack
   * being replaced by a new one.
   */e["Replace"]="REPLACE"})(a||(a={}));const i="popstate";/**
 * Memory history stores the current location in memory. It is designed for use
 * in stateful non-browser environments like tests and React Native.
 */function o(e){if(e===void 0){e={}}let{initialEntries:t=["/"],initialIndex:r,v5Compat:n=false}=e;let i;// Declare so we can access from createMemoryLocation
i=t.map((e,t)=>d(e,typeof e==="string"?null:e.state,t===0?"default":undefined));let o=l(r==null?i.length-1:r);let s=a.Pop;let u=null;function l(e){return Math.min(Math.max(e,0),i.length-1)}function f(){return i[o]}function d(e,t,r){if(t===void 0){t=null}let n=h(i?f().pathname:"/",e,t,r);c(n.pathname.charAt(0)==="/","relative pathnames are not supported in memory history: "+JSON.stringify(e));return n}function m(e){return typeof e==="string"?e:p(e)}let g={get index(){return o},get action(){return s},get location(){return f()},createHref:m,createURL(e){return new URL(m(e),"http://localhost")},encodeLocation(e){let t=typeof e==="string"?v(e):e;return{pathname:t.pathname||"",search:t.search||"",hash:t.hash||""}},push(e,t){s=a.Push;let r=d(e,t);o+=1;i.splice(o,i.length,r);if(n&&u){u({action:s,location:r,delta:1})}},replace(e,t){s=a.Replace;let r=d(e,t);i[o]=r;if(n&&u){u({action:s,location:r,delta:0})}},go(e){s=a.Pop;let t=l(o+e);let r=i[t];o=t;if(u){u({action:s,location:r,delta:e})}},listen(e){u=e;return()=>{u=null}}};return g}/**
 * Browser history stores the location in regular URLs. This is the standard for
 * most web apps, but it requires some configuration on the server to ensure you
 * serve the same app at multiple URLs.
 *
 * @see https://github.com/remix-run/history/tree/main/docs/api-reference.md#createbrowserhistory
 */function s(e){if(e===void 0){e={}}function t(e,t){let{pathname:r,search:n,hash:a}=e.location;return h("",{pathname:r,search:n,hash:a},// state defaults to `null` because `window.history.state` does
t.state&&t.state.usr||null,t.state&&t.state.key||"default")}function r(e,t){return typeof t==="string"?t:p(t)}return m(t,r,null,e)}/**
 * Hash history stores the location in window.location.hash. This makes it ideal
 * for situations where you don't want to send the location to the server for
 * some reason, either because you do cannot configure it or the URL space is
 * reserved for something else.
 *
 * @see https://github.com/remix-run/history/tree/main/docs/api-reference.md#createhashhistory
 */function u(e){if(e===void 0){e={}}function t(e,t){let{pathname:r="/",search:n="",hash:a=""}=v(e.location.hash.substr(1));// Hash URL should always have a leading / just like window.location.pathname
// does, so if an app ends up at a route like /#something then we add a
// leading slash so all of our path-matching behaves the same as if it would
// in a browser router.  This is particularly important when there exists a
// root splat route (<Route path="*">) since that matches internally against
// "/*" and we'd expect /#something to 404 in a hash router app.
if(!r.startsWith("/")&&!r.startsWith(".")){r="/"+r}return h("",{pathname:r,search:n,hash:a},// state defaults to `null` because `window.history.state` does
t.state&&t.state.usr||null,t.state&&t.state.key||"default")}function r(e,t){let r=e.document.querySelector("base");let n="";if(r&&r.getAttribute("href")){let t=e.location.href;let r=t.indexOf("#");n=r===-1?t:t.slice(0,r)}return n+"#"+(typeof t==="string"?t:p(t))}function n(e,t){c(e.pathname.charAt(0)==="/","relative pathnames are not supported in hash history.push("+JSON.stringify(t)+")")}return m(t,r,n,e)}function l(e,t){if(e===false||e===null||typeof e==="undefined"){throw new Error(t)}}function c(e,t){if(!e){// eslint-disable-next-line no-console
if(typeof console!=="undefined")console.warn(t);try{// Welcome to debugging history!
//
// This error is thrown as a convenience, so you can more easily
// find the source for a warning that appears in the console by
// enabling "pause on exceptions" in your JavaScript debugger.
throw new Error(t);// eslint-disable-next-line no-empty
}catch(e){}}}function f(){return Math.random().toString(36).substr(2,8)}/**
 * For browser-based histories, we combine the state and key into an object
 */function d(e,t){return{usr:e.state,key:e.key,idx:t}}/**
 * Creates a Location object with a unique key from the given Path
 */function h(e,t,r,a){if(r===void 0){r=null}let i=n({pathname:typeof e==="string"?e:e.pathname,search:"",hash:""},typeof t==="string"?v(t):t,{state:r,// TODO: This could be cleaned up.  push/replace should probably just take
// full Locations now and avoid the need to run through this flow at all
// But that's a pretty big refactor to the current test suite so going to
// keep as is for the time being and just let any incoming keys take precedence
key:t&&t.key||a||f()});return i}/**
 * Creates a string URL path from the given pathname, search, and hash components.
 */function p(e){let{pathname:t="/",search:r="",hash:n=""}=e;if(r&&r!=="?")t+=r.charAt(0)==="?"?r:"?"+r;if(n&&n!=="#")t+=n.charAt(0)==="#"?n:"#"+n;return t}/**
 * Parses a string URL path into its separate pathname, search, and hash components.
 */function v(e){let t={};if(e){let r=e.indexOf("#");if(r>=0){t.hash=e.substr(r);e=e.substr(0,r)}let n=e.indexOf("?");if(n>=0){t.search=e.substr(n);e=e.substr(0,n)}if(e){t.pathname=e}}return t}function m(e,t,r,o){if(o===void 0){o={}}let{window:s=document.defaultView,v5Compat:u=false}=o;let c=s.history;let f=a.Pop;let v=null;let m=g();// Index should only be null when we initialize. If not, it's because the
// user called history.pushState or history.replaceState directly, in which
// case we should log a warning as it will result in bugs.
if(m==null){m=0;c.replaceState(n({},c.state,{idx:m}),"")}function g(){let e=c.state||{idx:null};return e.idx}function b(){f=a.Pop;let e=g();let t=e==null?null:e-m;m=e;if(v){v({action:f,location:x.location,delta:t})}}function y(e,t){f=a.Push;let n=h(x.location,e,t);if(r)r(n,e);m=g()+1;let i=d(n,m);let o=x.createHref(n);// try...catch because iOS limits us to 100 pushState calls :/
try{c.pushState(i,"",o)}catch(e){// If the exception is because `state` can't be serialized, let that throw
// outwards just like a replace call would so the dev knows the cause
// https://html.spec.whatwg.org/multipage/nav-history-apis.html#shared-history-push/replace-state-steps
// https://html.spec.whatwg.org/multipage/structured-data.html#structuredserializeinternal
if(e instanceof DOMException&&e.name==="DataCloneError"){throw e}// They are going to lose state here, but there is no real
// way to warn them about it since the page will refresh...
s.location.assign(o)}if(u&&v){v({action:f,location:x.location,delta:1})}}function w(e,t){f=a.Replace;let n=h(x.location,e,t);if(r)r(n,e);m=g();let i=d(n,m);let o=x.createHref(n);c.replaceState(i,"",o);if(u&&v){v({action:f,location:x.location,delta:0})}}function _(e){// window.location.origin is "null" (the literal string value) in Firefox
// under certain conditions, notably when serving from a local HTML file
// See https://bugzilla.mozilla.org/show_bug.cgi?id=878297
let t=s.location.origin!=="null"?s.location.origin:s.location.href;let r=typeof e==="string"?e:p(e);// Treating this as a full URL will strip any trailing spaces so we need to
// pre-encode them since they might be part of a matching splat param from
// an ancestor route
r=r.replace(/ $/,"%20");l(t,"No window.location.(origin|href) available to create URL for href: "+r);return new URL(r,t)}let x={get action(){return f},get location(){return e(s,c)},listen(e){if(v){throw new Error("A history only accepts one active listener")}s.addEventListener(i,b);v=e;return()=>{s.removeEventListener(i,b);v=null}},createHref(e){return t(s,e)},createURL:_,encodeLocation(e){// Encode a Location the same way window.location would
let t=_(e);return{pathname:t.pathname,search:t.search,hash:t.hash}},push:y,replace:w,go(e){return c.go(e)}};return x}//#endregion
var g;(function(e){e["data"]="data";e["deferred"]="deferred";e["redirect"]="redirect";e["error"]="error"})(g||(g={}));const b=new Set(["lazy","caseSensitive","path","id","index","children"]);function y(e){return e.index===true}// Walk the route tree generating unique IDs where necessary, so we are working
// solely with AgnosticDataRouteObject's within the Router
function w(e,t,r,a){if(r===void 0){r=[]}if(a===void 0){a={}}return e.map((e,i)=>{let o=[...r,String(i)];let s=typeof e.id==="string"?e.id:o.join("-");l(e.index!==true||!e.children,"Cannot specify children on an index route");l(!a[s],'Found a route id collision on id "'+s+'".  Route '+"id's must be globally unique within Data Router usages");if(y(e)){let r=n({},e,t(e),{id:s});a[s]=r;return r}else{let r=n({},e,t(e),{id:s,children:undefined});a[s]=r;if(e.children){r.children=w(e.children,t,o,a)}return r}})}/**
 * Matches the given routes to a location and returns the match data.
 *
 * @see https://reactrouter.com/v6/utils/match-routes
 */function _(e,t,r){if(r===void 0){r="/"}return x(e,t,r,false)}function x(e,t,r,n){let a=typeof t==="string"?v(t):t;let i=B(a.pathname||"/",r);if(i==null){return null}let o=O(e);A(o);let s=null;for(let e=0;s==null&&e<o.length;++e){// Incoming pathnames are generally encoded from either window.location
// or from router.navigate, but we want to match against the unencoded
// paths in the route definitions.  Memory router locations won't be
// encoded here but there also shouldn't be anything to decode so this
// should be a safe operation.  This avoids needing matchRoutes to be
// history-aware.
let t=H(i);s=L(o[e],t,n)}return s}function E(e,t){let{route:r,pathname:n,params:a}=e;return{id:r.id,pathname:n,params:a,data:t[r.id],handle:r.handle}}function O(e,t,r,n){if(t===void 0){t=[]}if(r===void 0){r=[]}if(n===void 0){n=""}let a=(e,a,i)=>{let o={relativePath:i===undefined?e.path||"":i,caseSensitive:e.caseSensitive===true,childrenIndex:a,route:e};if(o.relativePath.startsWith("/")){l(o.relativePath.startsWith(n),'Absolute route path "'+o.relativePath+'" nested under path '+('"'+n+'" is not valid. An absolute child route path ')+"must start with the combined path of all its parent routes.");o.relativePath=o.relativePath.slice(n.length)}let s=K([n,o.relativePath]);let u=r.concat(o);// Add the children before adding this route to the array, so we traverse the
// route tree depth-first and child routes appear before their parents in
// the "flattened" version.
if(e.children&&e.children.length>0){l(// Our types know better, but runtime JS may not!
// @ts-expect-error
e.index!==true,"Index routes must not have child routes. Please remove "+('all child routes from route path "'+s+'".'));O(e.children,t,u,s)}// Routes without a path shouldn't ever match by themselves unless they are
// index routes, so don't add them to the list of possible branches.
if(e.path==null&&!e.index){return}t.push({path:s,score:M(s,e.index),routesMeta:u})};e.forEach((e,t)=>{var r;// coarse-grain check for optional params
if(e.path===""||!((r=e.path)!=null&&r.includes("?"))){a(e,t)}else{for(let r of S(e.path)){a(e,t,r)}}});return t}/**
 * Computes all combinations of optional path segments for a given path,
 * excluding combinations that are ambiguous and of lower priority.
 *
 * For example, `/one/:two?/three/:four?/:five?` explodes to:
 * - `/one/three`
 * - `/one/:two/three`
 * - `/one/three/:four`
 * - `/one/three/:five`
 * - `/one/:two/three/:four`
 * - `/one/:two/three/:five`
 * - `/one/three/:four/:five`
 * - `/one/:two/three/:four/:five`
 */function S(e){let t=e.split("/");if(t.length===0)return[];let[r,...n]=t;// Optional path segments are denoted by a trailing `?`
let a=r.endsWith("?");// Compute the corresponding required segment: `foo?` -> `foo`
let i=r.replace(/\?$/,"");if(n.length===0){// Intepret empty string as omitting an optional segment
// `["one", "", "three"]` corresponds to omitting `:two` from `/one/:two?/three` -> `/one/three`
return a?[i,""]:[i]}let o=S(n.join("/"));let s=[];// All child paths with the prefix.  Do this for all children before the
// optional version for all children, so we get consistent ordering where the
// parent optional aspect is preferred as required.  Otherwise, we can get
// child sections interspersed where deeper optional segments are higher than
// parent optional segments, where for example, /:two would explode _earlier_
// then /:one.  By always including the parent as required _for all children_
// first, we avoid this issue
s.push(...o.map(e=>e===""?i:[i,e].join("/")));// Then, if this is an optional value, add all child versions without
if(a){s.push(...o)}// for absolute paths, ensure `/` instead of empty segment
return s.map(t=>e.startsWith("/")&&t===""?"/":t)}function A(e){e.sort((e,t)=>e.score!==t.score?t.score-e.score// Higher score first
    :F(e.routesMeta.map(e=>e.childrenIndex),t.routesMeta.map(e=>e.childrenIndex)))}const T=/^:[\w-]+$/;const k=3;const R=2;const C=1;const P=10;const I=-2;const D=e=>e==="*";function M(e,t){let r=e.split("/");let n=r.length;if(r.some(D)){n+=I}if(t){n+=R}return r.filter(e=>!D(e)).reduce((e,t)=>e+(T.test(t)?k:t===""?C:P),n)}function F(e,t){let r=e.length===t.length&&e.slice(0,-1).every((e,r)=>e===t[r]);return r?// If two routes are siblings, we should try to match the earlier sibling
// first. This allows people to have fine-grained control over the matching
// behavior by simply putting routes with identical paths in the order they
// want them tried.
e[e.length-1]-t[t.length-1]:// Otherwise, it doesn't really make sense to rank non-siblings by index,
// so they sort equally.
0}function L(e,t,r){if(r===void 0){r=false}let{routesMeta:n}=e;let a={};let i="/";let o=[];for(let e=0;e<n.length;++e){let s=n[e];let u=e===n.length-1;let l=i==="/"?t:t.slice(i.length)||"/";let c=j({path:s.relativePath,caseSensitive:s.caseSensitive,end:u},l);let f=s.route;if(!c&&u&&r&&!n[n.length-1].route.index){c=j({path:s.relativePath,caseSensitive:s.caseSensitive,end:false},l)}if(!c){return null}Object.assign(a,c.params);o.push({// TODO: Can this as be avoided?
params:a,pathname:K([i,c.pathname]),pathnameBase:Q(K([i,c.pathnameBase])),route:f});if(c.pathnameBase!=="/"){i=K([i,c.pathnameBase])}}return o}/**
 * Returns a path with params interpolated.
 *
 * @see https://reactrouter.com/v6/utils/generate-path
 */function N(e,t){if(t===void 0){t={}}let r=e;if(r.endsWith("*")&&r!=="*"&&!r.endsWith("/*")){c(false,'Route path "'+r+'" will be treated as if it were '+('"'+r.replace(/\*$/,"/*")+'" because the `*` character must ')+"always follow a `/` in the pattern. To get rid of this warning, "+('please change the route path to "'+r.replace(/\*$/,"/*")+'".'));r=r.replace(/\*$/,"/*")}// ensure `/` is added at the beginning if the path is absolute
const n=r.startsWith("/")?"/":"";const a=e=>e==null?"":typeof e==="string"?e:String(e);const i=r.split(/\/+/).map((e,r,n)=>{const i=r===n.length-1;// only apply the splat if it's the last segment
if(i&&e==="*"){const e="*";// Apply the splat
return a(t[e])}const o=e.match(/^:([\w-]+)(\??)$/);if(o){const[,e,r]=o;let n=t[e];l(r==="?"||n!=null,'Missing ":'+e+'" param');return a(n)}// Remove any optional markers from optional static segments
return e.replace(/\?$/g,"")})// Remove empty segments
.filter(e=>!!e);return n+i.join("/")}/**
 * Performs pattern matching on a URL pathname and returns information about
 * the match.
 *
 * @see https://reactrouter.com/v6/utils/match-path
 */function j(e,t){if(typeof e==="string"){e={path:e,caseSensitive:false,end:true}}let[r,n]=U(e.path,e.caseSensitive,e.end);let a=t.match(r);if(!a)return null;let i=a[0];let o=i.replace(/(.)\/+$/,"$1");let s=a.slice(1);let u=n.reduce((e,t,r)=>{let{paramName:n,isOptional:a}=t;// We need to compute the pathnameBase here using the raw splat value
// instead of using params["*"] later because it will be decoded then
if(n==="*"){let e=s[r]||"";o=i.slice(0,i.length-e.length).replace(/(.)\/+$/,"$1")}const u=s[r];if(a&&!u){e[n]=undefined}else{e[n]=(u||"").replace(/%2F/g,"/")}return e},{});return{params:u,pathname:i,pathnameBase:o,pattern:e}}function U(e,t,r){if(t===void 0){t=false}if(r===void 0){r=true}c(e==="*"||!e.endsWith("*")||e.endsWith("/*"),'Route path "'+e+'" will be treated as if it were '+('"'+e.replace(/\*$/,"/*")+'" because the `*` character must ')+"always follow a `/` in the pattern. To get rid of this warning, "+('please change the route path to "'+e.replace(/\*$/,"/*")+'".'));let n=[];let a="^"+e.replace(/\/*\*?$/,"")// Ignore trailing / and /*, we'll handle it below
.replace(/^\/*/,"/")// Make sure it has a leading /
.replace(/[\\.*+^${}|()[\]]/g,"\\$&")// Escape special regex chars
.replace(/\/:([\w-]+)(\?)?/g,(e,t,r)=>{n.push({paramName:t,isOptional:r!=null});return r?"/?([^\\/]+)?":"/([^\\/]+)"});if(e.endsWith("*")){n.push({paramName:"*"});a+=e==="*"||e==="/*"?"(.*)$"// Already matched the initial /, just match the rest
:"(?:\\/(.+)|\\/*)$";// Don't include the / in params["*"]
}else if(r){// When matching to the end, ignore trailing slashes
a+="\\/*$"}else if(e!==""&&e!=="/"){// If our path is non-empty and contains anything beyond an initial slash,
// then we have _some_ form of path in our regex, so we should expect to
// match only if we find the end of this path segment.  Look for an optional
// non-captured trailing slash (to match a portion of the URL) or the end
// of the path (if we've matched to the end).  We used to do this with a
// word boundary but that gives false positives on routes like
// /user-preferences since `-` counts as a word boundary.
a+="(?:(?=\\/|$))"}else;let i=new RegExp(a,t?undefined:"i");return[i,n]}function H(e){try{return e.split("/").map(e=>decodeURIComponent(e).replace(/\//g,"%2F")).join("/")}catch(t){c(false,'The URL path "'+e+'" could not be decoded because it is is a '+"malformed URL segment. This is probably due to a bad percent "+("encoding ("+t+")."));return e}}/**
 * @private
 */function B(e,t){if(t==="/")return e;if(!e.toLowerCase().startsWith(t.toLowerCase())){return null}// We want to leave trailing slash behavior in the user's control, so if they
// specify a basename with a trailing slash, we should support it
let r=t.endsWith("/")?t.length-1:t.length;let n=e.charAt(r);if(n&&n!=="/"){// pathname does not start with basename/
return null}return e.slice(r)||"/"}/**
 * Returns a resolved path object relative to the given pathname.
 *
 * @see https://reactrouter.com/v6/utils/resolve-path
 */function Y(e,t){if(t===void 0){t="/"}let{pathname:r,search:n="",hash:a=""}=typeof e==="string"?v(e):e;let i=r?r.startsWith("/")?r:z(r,t):t;return{pathname:i,search:X(n),hash:J(a)}}function z(e,t){let r=t.replace(/\/+$/,"").split("/");let n=e.split("/");n.forEach(e=>{if(e===".."){// Keep the root "" segment so the pathname starts at /
if(r.length>1)r.pop()}else if(e!=="."){r.push(e)}});return r.length>1?r.join("/"):"/"}function q(e,t,r,n){return"Cannot include a '"+e+"' character in a manually specified "+("`to."+t+"` field ["+JSON.stringify(n)+"].  Please separate it out to the ")+("`to."+r+"` field. Alternatively you may provide the full path as ")+'a string in <Link to="..."> and the router will parse it for you.'}/**
 * @private
 *
 * When processing relative navigation we want to ignore ancestor routes that
 * do not contribute to the path, such that index/pathless layout routes don't
 * interfere.
 *
 * For example, when moving a route element into an index route and/or a
 * pathless layout route, relative link behavior contained within should stay
 * the same.  Both of the following examples should link back to the root:
 *
 *   <Route path="/">
 *     <Route path="accounts" element={<Link to=".."}>
 *   </Route>
 *
 *   <Route path="/">
 *     <Route path="accounts">
 *       <Route element={<AccountsLayout />}>       // <-- Does not contribute
 *         <Route index element={<Link to=".."} />  // <-- Does not contribute
 *       </Route
 *     </Route>
 *   </Route>
 */function V(e){return e.filter((e,t)=>t===0||e.route.path&&e.route.path.length>0)}// Return the array of pathnames for the current route matches - used to
// generate the routePathnames input for resolveTo()
function W(e,t){let r=V(e);// When v7_relativeSplatPath is enabled, use the full pathname for the leaf
// match so we include splat values for "." links.  See:
// https://github.com/remix-run/react-router/issues/11052#issuecomment-1836589329
if(t){return r.map((e,t)=>t===r.length-1?e.pathname:e.pathnameBase)}return r.map(e=>e.pathnameBase)}/**
 * @private
 */function $(e,t,r,a){if(a===void 0){a=false}let i;if(typeof e==="string"){i=v(e)}else{i=n({},e);l(!i.pathname||!i.pathname.includes("?"),q("?","pathname","search",i));l(!i.pathname||!i.pathname.includes("#"),q("#","pathname","hash",i));l(!i.search||!i.search.includes("#"),q("#","search","hash",i))}let o=e===""||i.pathname==="";let s=o?"/":i.pathname;let u;// Routing is relative to the current pathname if explicitly requested.
//
// If a pathname is explicitly provided in `to`, it should be relative to the
// route context. This is explained in `Note on `<Link to>` values` in our
// migration guide from v5 as a means of disambiguation between `to` values
// that begin with `/` and those that do not. However, this is problematic for
// `to` values that do not provide a pathname. `to` can simply be a search or
// hash string, in which case we should assume that the navigation is relative
// to the current location's pathname and *not* the route pathname.
if(s==null){u=r}else{let e=t.length-1;// With relative="route" (the default), each leading .. segment means
// "go up one route" instead of "go up one URL segment".  This is a key
// difference from how <a href> works and a major reason we call this a
// "to" value instead of a "href".
if(!a&&s.startsWith("..")){let t=s.split("/");while(t[0]===".."){t.shift();e-=1}i.pathname=t.join("/")}u=e>=0?t[e]:"/"}let c=Y(i,u);// Ensure the pathname has a trailing slash if the original "to" had one
let f=s&&s!=="/"&&s.endsWith("/");// Or if this was a link to the current path which has a trailing slash
let d=(o||s===".")&&r.endsWith("/");if(!c.pathname.endsWith("/")&&(f||d)){c.pathname+="/"}return c}/**
 * @private
 */function G(e){// Empty strings should be treated the same as / paths
return e===""||e.pathname===""?"/":typeof e==="string"?v(e).pathname:e.pathname}/**
 * @private
 */const K=e=>e.join("/").replace(/\/\/+/g,"/");/**
 * @private
 */const Q=e=>e.replace(/\/+$/,"").replace(/^\/*/,"/");/**
 * @private
 */const X=e=>!e||e==="?"?"":e.startsWith("?")?e:"?"+e;/**
 * @private
 */const J=e=>!e||e==="#"?"":e.startsWith("#")?e:"#"+e;/**
 * This is a shortcut for creating `application/json` responses. Converts `data`
 * to JSON and sets the `Content-Type` header.
 *
 * @deprecated The `json` method is deprecated in favor of returning raw objects.
 * This method will be removed in v7.
 */const Z=function e(e,t){if(t===void 0){t={}}let r=typeof t==="number"?{status:t}:t;let a=new Headers(r.headers);if(!a.has("Content-Type")){a.set("Content-Type","application/json; charset=utf-8")}return new Response(JSON.stringify(e),n({},r,{headers:a}))};class ee{constructor(e,t){this.type="DataWithResponseInit";this.data=e;this.init=t||null}}/**
 * Create "responses" that contain `status`/`headers` without forcing
 * serialization into an actual `Response` - used by Remix single fetch
 */function et(e,t){return new ee(e,typeof t==="number"?{status:t}:t)}class er extends Error{}class en{constructor(e,t){this.pendingKeysSet=new Set;this.subscribers=new Set;this.deferredKeys=[];l(e&&typeof e==="object"&&!Array.isArray(e),"defer() only accepts plain objects");// Set up an AbortController + Promise we can race against to exit early
// cancellation
let r;this.abortPromise=new Promise((e,t)=>r=t);this.controller=new AbortController;let n=()=>r(new er("Deferred data aborted"));this.unlistenAbortSignal=()=>this.controller.signal.removeEventListener("abort",n);this.controller.signal.addEventListener("abort",n);this.data=Object.entries(e).reduce((e,t)=>{let[r,n]=t;return Object.assign(e,{[r]:this.trackPromise(r,n)})},{});if(this.done){// All incoming values were resolved
this.unlistenAbortSignal()}this.init=t}trackPromise(e,t){if(!(t instanceof Promise)){return t}this.deferredKeys.push(e);this.pendingKeysSet.add(e);// We store a little wrapper promise that will be extended with
// _data/_error props upon resolve/reject
let r=Promise.race([t,this.abortPromise]).then(t=>this.onSettle(r,e,undefined,t),t=>this.onSettle(r,e,t));// Register rejection listeners to avoid uncaught promise rejections on
// errors or aborted deferred values
r.catch(()=>{});Object.defineProperty(r,"_tracked",{get:()=>true});return r}onSettle(e,t,r,n){if(this.controller.signal.aborted&&r instanceof er){this.unlistenAbortSignal();Object.defineProperty(e,"_error",{get:()=>r});return Promise.reject(r)}this.pendingKeysSet.delete(t);if(this.done){// Nothing left to abort!
this.unlistenAbortSignal()}// If the promise was resolved/rejected with undefined, we'll throw an error as you
// should always resolve with a value or null
if(r===undefined&&n===undefined){let r=new Error('Deferred data for key "'+t+'" resolved/rejected with `undefined`, '+"you must resolve/reject with a value or `null`.");Object.defineProperty(e,"_error",{get:()=>r});this.emit(false,t);return Promise.reject(r)}if(n===undefined){Object.defineProperty(e,"_error",{get:()=>r});this.emit(false,t);return Promise.reject(r)}Object.defineProperty(e,"_data",{get:()=>n});this.emit(false,t);return n}emit(e,t){this.subscribers.forEach(r=>r(e,t))}subscribe(e){this.subscribers.add(e);return()=>this.subscribers.delete(e)}cancel(){this.controller.abort();this.pendingKeysSet.forEach((e,t)=>this.pendingKeysSet.delete(t));this.emit(true)}async resolveData(e){let t=false;if(!this.done){let r=()=>this.cancel();e.addEventListener("abort",r);t=await new Promise(t=>{this.subscribe(n=>{e.removeEventListener("abort",r);if(n||this.done){t(n)}})})}return t}get done(){return this.pendingKeysSet.size===0}get unwrappedData(){l(this.data!==null&&this.done,"Can only unwrap data on initialized and settled deferreds");return Object.entries(this.data).reduce((e,t)=>{let[r,n]=t;return Object.assign(e,{[r]:ei(n)})},{})}get pendingKeys(){return Array.from(this.pendingKeysSet)}}function ea(e){return e instanceof Promise&&e._tracked===true}function ei(e){if(!ea(e)){return e}if(e._error){throw e._error}return e._data}/**
 * @deprecated The `defer` method is deprecated in favor of returning raw
 * objects. This method will be removed in v7.
 */const eo=function e(e,t){if(t===void 0){t={}}let r=typeof t==="number"?{status:t}:t;return new en(e,r)};/**
 * A redirect response. Sets the status code and the `Location` header.
 * Defaults to "302 Found".
 */const es=function e(e,t){if(t===void 0){t=302}let r=t;if(typeof r==="number"){r={status:r}}else if(typeof r.status==="undefined"){r.status=302}let a=new Headers(r.headers);a.set("Location",e);return new Response(null,n({},r,{headers:a}))};/**
 * A redirect response that will force a document reload to the new location.
 * Sets the status code and the `Location` header.
 * Defaults to "302 Found".
 */const eu=(e,t)=>{let r=es(e,t);r.headers.set("X-Remix-Reload-Document","true");return r};/**
 * A redirect response that will perform a `history.replaceState` instead of a
 * `history.pushState` for client-side navigation redirects.
 * Sets the status code and the `Location` header.
 * Defaults to "302 Found".
 */const el=(e,t)=>{let r=es(e,t);r.headers.set("X-Remix-Replace","true");return r};/**
 * @private
 * Utility class we use to hold auto-unwrapped 4xx/5xx Response bodies
 *
 * We don't export the class for public use since it's an implementation
 * detail, but we export the interface above so folks can build their own
 * abstractions around instances via isRouteErrorResponse()
 */class ec{constructor(e,t,r,n){if(n===void 0){n=false}this.status=e;this.statusText=t||"";this.internal=n;if(r instanceof Error){this.data=r.toString();this.error=r}else{this.data=r}}}/**
 * Check if the given error is an ErrorResponse generated from a 4xx/5xx
 * Response thrown from an action/loader
 */function ef(e){return e!=null&&typeof e.status==="number"&&typeof e.statusText==="string"&&typeof e.internal==="boolean"&&"data"in e}const ed=["post","put","patch","delete"];const eh=new Set(ed);const ep=["get",...ed];const ev=new Set(ep);const em=new Set([301,302,303,307,308]);const eg=new Set([307,308]);const eb=/* unused pure expression or super */null&&{state:"idle",location:undefined,formMethod:undefined,formAction:undefined,formEncType:undefined,formData:undefined,json:undefined,text:undefined};const ey=/* unused pure expression or super */null&&{state:"idle",data:undefined,formMethod:undefined,formAction:undefined,formEncType:undefined,formData:undefined,json:undefined,text:undefined};const ew=/* unused pure expression or super */null&&{state:"unblocked",proceed:undefined,reset:undefined,location:undefined};const e_=/^(?:[a-z][a-z0-9+.-]*:|\/\/)/i;const ex=e=>({hasErrorBoundary:Boolean(e.hasErrorBoundary)});const eE="remix-router-transitions";//#endregion
////////////////////////////////////////////////////////////////////////////////
//#region createRouter
////////////////////////////////////////////////////////////////////////////////
/**
 * Create a router and listen to history POP navigations
 */function eO(e){const t=e.window?e.window:typeof window!=="undefined"?window:undefined;const r=typeof t!=="undefined"&&typeof t.document!=="undefined"&&typeof t.document.createElement!=="undefined";const i=!r;l(e.routes.length>0,"You must provide a non-empty routes array to createRouter");let o;if(e.mapRouteProperties){o=e.mapRouteProperties}else if(e.detectErrorBoundary){// If they are still using the deprecated version, wrap it with the new API
let t=e.detectErrorBoundary;o=e=>({hasErrorBoundary:t(e)})}else{o=ex}// Routes keyed by ID
let s={};// Routes in tree format for matching
let u=w(e.routes,o,undefined,s);let f;let d=e.basename||"/";let p=e.dataStrategy||eB;let v=e.patchRoutesOnNavigation;// Config driven behavior flags
let m=n({v7_fetcherPersist:false,v7_normalizeFormMethod:false,v7_partialHydration:false,v7_prependBasename:false,v7_relativeSplatPath:false,v7_skipActionErrorRevalidation:false},e.future);// Cleanup function for history
let b=null;// Externally-provided functions to call on all state changes
let y=new Set;// Externally-provided object to hold scroll restoration locations during routing
let O=null;// Externally-provided function to get scroll restoration keys
let S=null;// Externally-provided function to get current scroll position
let A=null;// One-time flag to control the initial hydration scroll restoration.  Because
// we don't get the saved positions from <ScrollRestoration /> until _after_
// the initial render, we need to manually trigger a separate updateState to
// send along the restoreScrollPosition
// Set to true if we have `hydrationData` since we assume we were SSR'd and that
// SSR did the initial scroll restoration.
let T=e.hydrationData!=null;let k=_(u,e.history.location,d);let R=false;let C=null;if(k==null&&!v){// If we do not match a user-provided-route, fall back to the root
// to allow the error boundary to take over
let t=e2(404,{pathname:e.history.location.pathname});let{matches:r,route:n}=e1(u);k=r;C={[n.id]:t}}// In SPA apps, if the user provided a patchRoutesOnNavigation implementation and
// our initial match is a splat route, clear them out so we run through lazy
// discovery on hydration in case there's a more accurate lazy route match.
// In SSR apps (with `hydrationData`), we expect that the server will send
// up the proper matched routes so we don't want to run lazy discovery on
// initial hydration and want to hydrate into the splat route.
if(k&&!e.hydrationData){let t=tc(k,u,e.history.location.pathname);if(t.active){k=null}}let P;if(!k){P=false;k=[];// If partial hydration and fog of war is enabled, we will be running
// `patchRoutesOnNavigation` during hydration so include any partial matches as
// the initial matches so we can properly render `HydrateFallback`'s
if(m.v7_partialHydration){let t=tc(null,u,e.history.location.pathname);if(t.active&&t.matches){R=true;k=t.matches}}}else if(k.some(e=>e.route.lazy)){// All initialMatches need to be loaded before we're ready.  If we have lazy
// functions around still then we'll need to run them in initialize()
P=false}else if(!k.some(e=>e.route.loader)){// If we've got no loaders to run, then we're good to go
P=true}else if(m.v7_partialHydration){// If partial hydration is enabled, we're initialized so long as we were
// provided with hydrationData for every route with a loader, and no loaders
// were marked for explicit hydration
let t=e.hydrationData?e.hydrationData.loaderData:null;let r=e.hydrationData?e.hydrationData.errors:null;// If errors exist, don't consider routes below the boundary
if(r){let e=k.findIndex(e=>r[e.route.id]!==undefined);P=k.slice(0,e+1).every(e=>!eM(e.route,t,r))}else{P=k.every(e=>!eM(e.route,t,r))}}else{// Without partial hydration - we're initialized if we were provided any
// hydrationData - which is expected to be complete
P=e.hydrationData!=null}let I;let D={historyAction:e.history.action,location:e.history.location,matches:k,initialized:P,navigation:eb,// Don't restore on initial updateState() if we were SSR'd
restoreScrollPosition:e.hydrationData!=null?false:null,preventScrollReset:false,revalidation:"idle",loaderData:e.hydrationData&&e.hydrationData.loaderData||{},actionData:e.hydrationData&&e.hydrationData.actionData||null,errors:e.hydrationData&&e.hydrationData.errors||C,fetchers:new Map,blockers:new Map};// -- Stateful internal variables to manage navigations --
// Current navigation in progress (to be committed in completeNavigation)
let M=a.Pop;// Should the current navigation prevent the scroll reset if scroll cannot
// be restored?
let F=false;// AbortController for the active navigation
let L;// Should the current navigation enable document.startViewTransition?
let N=false;// Store applied view transitions so we can apply them on POP
let j=new Map;// Cleanup function for persisting applied transitions to sessionStorage
let U=null;// We use this to avoid touching history in completeNavigation if a
// revalidation is entirely uninterrupted
let H=false;// Use this internal flag to force revalidation of all loaders:
//  - submissions (completed or interrupted)
//  - useRevalidator()
//  - X-Remix-Revalidate (from redirect)
let Y=false;// Use this internal array to capture routes that require revalidation due
// to a cancelled deferred on action submission
let z=[];// Use this internal array to capture fetcher loads that were cancelled by an
// action navigation and require revalidation
let q=new Set;// AbortControllers for any in-flight fetchers
let V=new Map;// Track loads based on the order in which they started
let W=0;// Track the outstanding pending navigation data load to be compared against
// the globally incrementing load when a fetcher load lands after a completed
// navigation
let $=-1;// Fetchers that triggered data reloads as a result of their actions
let G=new Map;// Fetchers that triggered redirect navigations
let K=new Set;// Most recent href/match for fetcher.load calls for fetchers
let Q=new Map;// Ref-count mounted fetchers so we know when it's ok to clean them up
let X=new Map;// Fetchers that have requested a delete when using v7_fetcherPersist,
// they'll be officially removed after they return to idle
let J=new Set;// Store DeferredData instances for active route matches.  When a
// route loader returns defer() we stick one in here.  Then, when a nested
// promise resolves we update loaderData.  If a new navigation starts we
// cancel active deferreds for eliminated routes.
let Z=new Map;// Store blocker functions in a separate Map outside of router state since
// we don't need to update UI state if they change
let ee=new Map;// Flag to ignore the next history update, so we can revert the URL change on
// a POP navigation that was blocked by the user without touching router state
let et=undefined;// Initialize the router, all side effects should be kicked off from here.
// Implemented as a Fluent API for ease of:
//   let router = createRouter(init).initialize();
function er(){// If history informs us of a POP navigation, start the navigation but do not update
// state.  We'll update our own state once the navigation completes
b=e.history.listen(t=>{let{action:r,location:n,delta:a}=t;// Ignore this event if it was just us resetting the URL from a
// blocked POP navigation
if(et){et();et=undefined;return}c(ee.size===0||a!=null,"You are trying to use a blocker on a POP navigation to a location "+"that was not created by @remix-run/router. This will fail silently in "+"production. This can happen if you are navigating outside the router "+"via `window.history.pushState`/`window.location.hash` instead of using "+"router navigation APIs.  This can also happen if you are using "+"createHashRouter and the user manually changes the URL.");let i=e6({currentLocation:D.location,nextLocation:n,historyAction:r});if(i&&a!=null){// Restore the URL to match the current UI, but don't update router state
let t=new Promise(e=>{et=e});e.history.go(a*-1);// Put the blocker into a blocked state
eQ(i,{state:"blocked",location:n,proceed(){eQ(i,{state:"proceeding",proceed:undefined,reset:undefined,location:n});// Re-do the same POP navigation we just blocked, after the url
// restoration is also complete.  See:
// https://github.com/remix-run/react-router/issues/11613
t.then(()=>e.history.go(a))},reset(){let e=new Map(D.blockers);e.set(i,ew);ei({blockers:e})}});return}return el(r,n)});if(r){// FIXME: This feels gross.  How can we cleanup the lines between
// scrollRestoration/appliedTransitions persistance?
tb(t,j);let e=()=>ty(t,j);t.addEventListener("pagehide",e);U=()=>t.removeEventListener("pagehide",e)}// Kick off initial data load if needed.  Use Pop to avoid modifying history
// Note we don't do any handling of lazy here.  For SPA's it'll get handled
// in the normal navigation flow.  For SSR it's expected that lazy modules are
// resolved prior to router creation since we can't go into a fallbackElement
// UI for SSR'd apps
if(!D.initialized){el(a.Pop,D.location,{initialHydration:true})}return I}// Clean up a router and it's side effects
function en(){if(b){b()}if(U){U()}y.clear();L&&L.abort();D.fetchers.forEach((e,t)=>eF(t));D.blockers.forEach((e,t)=>eK(t))}// Subscribe to state updates for the router
function ea(e){y.add(e);return()=>y.delete(e)}// Update our state and notify the calling context of the change
function ei(e,t){if(t===void 0){t={}}D=n({},D,e);// Prep fetcher cleanup so we can tell the UI which fetcher data entries
// can be removed
let r=[];let a=[];if(m.v7_fetcherPersist){D.fetchers.forEach((e,t)=>{if(e.state==="idle"){if(J.has(t)){// Unmounted from the UI and can be totally removed
a.push(t)}else{// Returned to idle but still mounted in the UI, so semi-remains for
// revalidations and such
r.push(t)}}})}// Remove any lingering deleted fetchers that have already been removed
// from state.fetchers
J.forEach(e=>{if(!D.fetchers.has(e)&&!V.has(e)){a.push(e)}});// Iterate over a local copy so that if flushSync is used and we end up
// removing and adding a new subscriber due to the useCallback dependencies,
// we don't get ourselves into a loop calling the new subscriber immediately
[...y].forEach(e=>e(D,{deletedFetchers:a,viewTransitionOpts:t.viewTransitionOpts,flushSync:t.flushSync===true}));// Remove idle fetchers from state since we only care about in-flight fetchers.
if(m.v7_fetcherPersist){r.forEach(e=>D.fetchers.delete(e));a.forEach(e=>eF(e))}else{// We already called deleteFetcher() on these, can remove them from this
// Set now that we've handed the keys off to the data layer
a.forEach(e=>J.delete(e))}}// Complete a navigation returning the state.navigation back to the IDLE_NAVIGATION
// and setting state.[historyAction/location/matches] to the new route.
// - Location is a required param
// - Navigation will always be set to IDLE_NAVIGATION
// - Can pass any other state in newState
function eo(t,r,i){var o,s;let{flushSync:l}=i===void 0?{}:i;// Deduce if we're in a loading/actionReload state:
// - We have committed actionData in the store
// - The current navigation was a mutation submission
// - We're past the submitting state and into the loading state
// - The location being loaded is not the result of a redirect
let c=D.actionData!=null&&D.navigation.formMethod!=null&&to(D.navigation.formMethod)&&D.navigation.state==="loading"&&((o=t.state)==null?void 0:o._isRedirect)!==true;let d;if(r.actionData){if(Object.keys(r.actionData).length>0){d=r.actionData}else{// Empty actionData -> clear prior actionData due to an action error
d=null}}else if(c){// Keep the current data if we're wrapping up the action reload
d=D.actionData}else{// Clear actionData on any other completed navigations
d=null}// Always preserve any existing loaderData from re-used routes
let h=r.loaderData?eJ(D.loaderData,r.loaderData,r.matches||[],r.errors):D.loaderData;// On a successful navigation we can assume we got through all blockers
// so we can start fresh
let p=D.blockers;if(p.size>0){p=new Map(p);p.forEach((e,t)=>p.set(t,ew))}// Always respect the user flag.  Otherwise don't reset on mutation
// submission navigations unless they redirect
let v=F===true||D.navigation.formMethod!=null&&to(D.navigation.formMethod)&&((s=t.state)==null?void 0:s._isRedirect)!==true;// Commit any in-flight routes at the end of the HMR revalidation "navigation"
if(f){u=f;f=undefined}if(H);else if(M===a.Pop);else if(M===a.Push){e.history.push(t,t.state)}else if(M===a.Replace){e.history.replace(t,t.state)}let m;// On POP, enable transitions if they were enabled on the original navigation
if(M===a.Pop){// Forward takes precedence so they behave like the original navigation
let e=j.get(D.location.pathname);if(e&&e.has(t.pathname)){m={currentLocation:D.location,nextLocation:t}}else if(j.has(t.pathname)){// If we don't have a previous forward nav, assume we're popping back to
// the new location and enable if that location previously enabled
m={currentLocation:t,nextLocation:D.location}}}else if(N){// Store the applied transition on PUSH/REPLACE
let e=j.get(D.location.pathname);if(e){e.add(t.pathname)}else{e=new Set([t.pathname]);j.set(D.location.pathname,e)}m={currentLocation:D.location,nextLocation:t}}ei(n({},r,{actionData:d,loaderData:h,historyAction:M,location:t,initialized:true,navigation:eb,revalidation:"idle",restoreScrollPosition:ti(t,r.matches||D.matches),preventScrollReset:v,blockers:p}),{viewTransitionOpts:m,flushSync:l===true});// Reset stateful navigation vars
M=a.Pop;F=false;N=false;H=false;Y=false;z=[]}// Trigger a navigation event, which can either be a numerical POP or a PUSH
// replace with an optional submission
async function es(t,r){if(typeof t==="number"){e.history.go(t);return}let i=eC(D.location,D.matches,d,m.v7_prependBasename,t,m.v7_relativeSplatPath,r==null?void 0:r.fromRouteId,r==null?void 0:r.relative);let{path:o,submission:s,error:u}=eP(m.v7_normalizeFormMethod,false,i,r);let l=D.location;let c=h(D.location,o,r&&r.state);// When using navigate as a PUSH/REPLACE we aren't reading an already-encoded
// URL from window.location, so we need to encode it here so the behavior
// remains the same as POP and non-data-router usages.  new URL() does all
// the same encoding we'd get from a history.pushState/window.location read
// without having to touch history
c=n({},c,e.history.encodeLocation(c));let f=r&&r.replace!=null?r.replace:undefined;let p=a.Push;if(f===true){p=a.Replace}else if(f===false);else if(s!=null&&to(s.formMethod)&&s.formAction===D.location.pathname+D.location.search){// By default on submissions to the current location we REPLACE so that
// users don't have to double-click the back button to get to the prior
// location.  If the user redirects to a different location from the
// action/loader this will be ignored and the redirect will be a PUSH
p=a.Replace}let v=r&&"preventScrollReset"in r?r.preventScrollReset===true:undefined;let g=(r&&r.flushSync)===true;let b=e6({currentLocation:l,nextLocation:c,historyAction:p});if(b){// Put the blocker into a blocked state
eQ(b,{state:"blocked",location:c,proceed(){eQ(b,{state:"proceeding",proceed:undefined,reset:undefined,location:c});// Send the same navigation through
es(t,r)},reset(){let e=new Map(D.blockers);e.set(b,ew);ei({blockers:e})}});return}return await el(p,c,{submission:s,// Send through the formData serialization error if we have one so we can
// render at the right error boundary after we match routes
pendingError:u,preventScrollReset:v,replace:r&&r.replace,enableViewTransition:r&&r.viewTransition,flushSync:g})}// Revalidate all current loaders.  If a navigation is in progress or if this
// is interrupted by a navigation, allow this to "succeed" by calling all
// loaders during the next loader round
function eu(){eT();ei({revalidation:"loading"});// If we're currently submitting an action, we don't need to start a new
// navigation, we'll just let the follow up loader execution call all loaders
if(D.navigation.state==="submitting"){return}// If we're currently in an idle state, start a new navigation for the current
// action/location and mark it as uninterrupted, which will skip the history
// update in completeNavigation
if(D.navigation.state==="idle"){el(D.historyAction,D.location,{startUninterruptedRevalidation:true});return}// Otherwise, if we're currently in a loading state, just start a new
// navigation to the navigation.location but do not trigger an uninterrupted
// revalidation so that history correctly updates once the navigation completes
el(M||D.historyAction,D.navigation.location,{overrideNavigation:D.navigation,// Proxy through any rending view transition
enableViewTransition:N===true})}// Start a navigation to the given action/location.  Can optionally provide a
// overrideNavigation which will override the normalLoad in the case of a redirect
// navigation
async function el(t,r,a){// Abort any in-progress navigations and start a new one. Unset any ongoing
// uninterrupted revalidations unless told otherwise, since we want this
// new navigation to update history normally
L&&L.abort();L=null;M=t;H=(a&&a.startUninterruptedRevalidation)===true;// Save the current scroll position every time we start a new navigation,
// and track whether we should reset scroll on completion
ta(D.location,D.matches);F=(a&&a.preventScrollReset)===true;N=(a&&a.enableViewTransition)===true;let i=f||u;let o=a&&a.overrideNavigation;let s=a!=null&&a.initialHydration&&D.matches&&D.matches.length>0&&!R?// `matchRoutes()` has already been called if we're in here via `router.initialize()`
D.matches:_(i,r,d);let l=(a&&a.flushSync)===true;// Short circuit if it's only a hash change and not a revalidation or
// mutation submission.
//
// Ignore on initial page loads because since the initial hydration will always
// be "same hash".  For example, on /page#hash and submit a <Form method="post">
// which will default to a navigation to /page
if(s&&D.initialized&&!Y&&e5(D.location,r)&&!(a&&a.submission&&to(a.submission.formMethod))){eo(r,{matches:s},{flushSync:l});return}let c=tc(s,i,r.pathname);if(c.active&&c.matches){s=c.matches}// Short circuit with a 404 on the root error boundary if we match nothing
if(!s){let{error:e,notFoundMatches:t,route:n}=e3(r.pathname);eo(r,{matches:t,loaderData:{},errors:{[n.id]:e}},{flushSync:l});return}// Create a controller/Request for this navigation
L=new AbortController;let h=e$(e.history,r,L.signal,a&&a.submission);let p;if(a&&a.pendingError){// If we have a pendingError, it means the user attempted a GET submission
// with binary FormData so assign here and skip to handleLoaders.  That
// way we handle calling loaders above the boundary etc.  It's not really
// different from an actionError in that sense.
p=[e0(s).route.id,{type:g.error,error:a.pendingError}]}else if(a&&a.submission&&to(a.submission.formMethod)){// Call action if we received an action submission
let t=await ec(h,r,a.submission,s,c.active,{replace:a.replace,flushSync:l});if(t.shortCircuited){return}// If we received a 404 from handleAction, it's because we couldn't lazily
// discover the destination route so we don't want to call loaders
if(t.pendingActionResult){let[e,n]=t.pendingActionResult;if(e9(n)&&ef(n.error)&&n.error.status===404){L=null;eo(r,{matches:t.matches,loaderData:{},errors:{[e]:n.error}});return}}s=t.matches||s;p=t.pendingActionResult;o=th(r,a.submission);l=false;// No need to do fog of war matching again on loader execution
c.active=false;// Create a GET request for the loaders
h=e$(e.history,h.url,h.signal)}// Call loaders
let{shortCircuited:v,matches:m,loaderData:b,errors:y}=await ed(h,r,s,c.active,o,a&&a.submission,a&&a.fetcherSubmission,a&&a.replace,a&&a.initialHydration===true,l,p);if(v){return}// Clean up now that the action/loaders have completed.  Don't clean up if
// we short circuited because pendingNavigationController will have already
// been assigned to a new controller for the next navigation
L=null;eo(r,n({matches:m||s},eZ(p),{loaderData:b,errors:y}))}// Call the action matched by the leaf route for this navigation and handle
// redirects/errors
async function ec(e,t,r,n,i,o){if(o===void 0){o={}}eT();// Put us in a submitting state
let s=tp(t,r);ei({navigation:s},{flushSync:o.flushSync===true});if(i){let r=await tw(n,t.pathname,e.signal);if(r.type==="aborted"){return{shortCircuited:true}}else if(r.type==="error"){let e=e0(r.partialMatches).route.id;return{matches:r.partialMatches,pendingActionResult:[e,{type:g.error,error:r.error}]}}else if(!r.matches){let{notFoundMatches:e,error:r,route:n}=e3(t.pathname);return{matches:e,pendingActionResult:[n.id,{type:g.error,error:r}]}}else{n=r.matches}}// Call our action and get the result
let u;let l=tf(n,t);if(!l.route.action&&!l.route.lazy){u={type:g.error,error:e2(405,{method:e.method,pathname:t.pathname,routeId:l.route.id})}}else{let t=await eS("action",D,e,[l],n,null);u=t[l.route.id];if(e.signal.aborted){return{shortCircuited:true}}}if(te(u)){let t;if(o&&o.replace!=null){t=o.replace}else{// If the user didn't explicity indicate replace behavior, replace if
// we redirected to the exact same location we're currently at to avoid
// double back-buttons
let r=eW(u.response.headers.get("Location"),new URL(e.url),d);t=r===D.location.pathname+D.location.search}await eO(e,u,true,{submission:r,replace:t});return{shortCircuited:true}}if(e8(u)){throw e2(400,{type:"defer-action"})}if(e9(u)){// Store off the pending error - we use it to determine which loaders
// to call and will commit it when we complete the navigation
let e=e0(n,l.route.id);// By default, all submissions to the current location are REPLACE
// navigations, but if the action threw an error that'll be rendered in
// an errorElement, we fall back to PUSH so that the user can use the
// back button to get back to the pre-submission form location to try
// again
if((o&&o.replace)!==true){M=a.Push}return{matches:n,pendingActionResult:[e.route.id,u]}}return{matches:n,pendingActionResult:[l.route.id,u]}}// Call all applicable loaders for the given matches, handling redirects,
// errors, etc.
async function ed(t,r,a,i,o,s,l,c,h,p,v){// Figure out the right navigation we want to use for data loading
let g=o||th(r,s);// If this was a redirect from an action we don't have a "submission" but
// we have it on the loading navigation so use that if available
let b=s||l||td(g);// If this is an uninterrupted revalidation, we remain in our current idle
// state.  If not, we need to switch to our loading state and load data,
// preserving any new action data or existing action data (in the case of
// a revalidation interrupting an actionReload)
// If we have partialHydration enabled, then don't update the state for the
// initial data load since it's not a "navigation"
let y=!H&&(!m.v7_partialHydration||!h);// When fog of war is enabled, we enter our `loading` state earlier so we
// can discover new routes during the `loading` state.  We skip this if
// we've already run actions since we would have done our matching already.
// If the children() function threw then, we want to proceed with the
// partial matches it discovered.
if(i){if(y){let e=eh(v);ei(n({navigation:g},e!==undefined?{actionData:e}:{}),{flushSync:p})}let e=await tw(a,r.pathname,t.signal);if(e.type==="aborted"){return{shortCircuited:true}}else if(e.type==="error"){let t=e0(e.partialMatches).route.id;return{matches:e.partialMatches,loaderData:{},errors:{[t]:e.error}}}else if(!e.matches){let{error:e,notFoundMatches:t,route:n}=e3(r.pathname);return{matches:t,loaderData:{},errors:{[n.id]:e}}}else{a=e.matches}}let w=f||u;let[_,x]=eD(e.history,D,a,b,r,m.v7_partialHydration&&h===true,m.v7_skipActionErrorRevalidation,Y,z,q,J,Q,K,w,d,v);// Cancel pending deferreds for no-longer-matched routes or routes we're
// about to reload.  Note that if this is an action reload we would have
// already cancelled all pending deferreds so this would be a no-op
tt(e=>!(a&&a.some(t=>t.route.id===e))||_&&_.some(t=>t.route.id===e));$=++W;// Short circuit if we have no loaders to run
if(_.length===0&&x.length===0){let e=eH();eo(r,n({matches:a,loaderData:{},// Commit pending error if we're short circuiting
errors:v&&e9(v[1])?{[v[0]]:v[1].error}:null},eZ(v),e?{fetchers:new Map(D.fetchers)}:{}),{flushSync:p});return{shortCircuited:true}}if(y){let e={};if(!i){// Only update navigation/actionNData if we didn't already do it above
e.navigation=g;let t=eh(v);if(t!==undefined){e.actionData=t}}if(x.length>0){e.fetchers=ep(x)}ei(e,{flushSync:p})}x.forEach(e=>{eN(e.key);if(e.controller){// Fetchers use an independent AbortController so that aborting a fetcher
// (via deleteFetcher) does not abort the triggering navigation that
// triggered the revalidation
V.set(e.key,e.controller)}});// Proxy navigation abort through to revalidation fetchers
let E=()=>x.forEach(e=>eN(e.key));if(L){L.signal.addEventListener("abort",E)}let{loaderResults:O,fetcherResults:S}=await eA(D,a,_,x,t);if(t.signal.aborted){return{shortCircuited:true}}// Clean up _after_ loaders have completed.  Don't clean up if we short
// circuited because fetchControllers would have been aborted and
// reassigned to new controllers for the next navigation
if(L){L.signal.removeEventListener("abort",E)}x.forEach(e=>V.delete(e.key));// If any loaders returned a redirect Response, start a new REPLACE navigation
let A=e4(O);if(A){await eO(t,A.result,true,{replace:c});return{shortCircuited:true}}A=e4(S);if(A){// If this redirect came from a fetcher make sure we mark it in
// fetchRedirectIds so it doesn't get revalidated on the next set of
// loader executions
K.add(A.key);await eO(t,A.result,true,{replace:c});return{shortCircuited:true}}// Process and commit output from loaders
let{loaderData:T,errors:k}=eX(D,a,O,v,x,S,Z);// Wire up subscribers to update loaderData as promises settle
Z.forEach((e,t)=>{e.subscribe(r=>{// Note: No need to updateState here since the TrackedPromise on
// loaderData is stable across resolve/reject
// Remove this instance if we were aborted or if promises have settled
if(r||e.done){Z.delete(t)}})});// Preserve SSR errors during partial hydration
if(m.v7_partialHydration&&h&&D.errors){k=n({},D.errors,k)}let R=eH();let C=ez($);let P=R||C||x.length>0;return n({matches:a,loaderData:T,errors:k},P?{fetchers:new Map(D.fetchers)}:{})}function eh(e){if(e&&!e9(e[1])){// This is cast to `any` currently because `RouteData`uses any and it
// would be a breaking change to use any.
// TODO: v7 - change `RouteData` to use `unknown` instead of `any`
return{[e[0]]:e[1].data}}else if(D.actionData){if(Object.keys(D.actionData).length===0){return null}else{return D.actionData}}}function ep(e){e.forEach(e=>{let t=D.fetchers.get(e.key);let r=tv(undefined,t?t.data:undefined);D.fetchers.set(e.key,r)});return new Map(D.fetchers)}// Trigger a fetcher load/submit for the given fetcher key
function ev(e,t,r,n){if(i){throw new Error("router.fetch() was called during the server render, but it shouldn't be. "+"You are likely calling a useFetcher() method in the body of your component. "+"Try moving it to a useEffect or a callback.")}eN(e);let a=(n&&n.flushSync)===true;let o=f||u;let s=eC(D.location,D.matches,d,m.v7_prependBasename,r,m.v7_relativeSplatPath,t,n==null?void 0:n.relative);let l=_(o,s,d);let c=tc(l,o,s);if(c.active&&c.matches){l=c.matches}if(!l){eR(e,t,e2(404,{pathname:s}),{flushSync:a});return}let{path:h,submission:p,error:v}=eP(m.v7_normalizeFormMethod,true,s,n);if(v){eR(e,t,v,{flushSync:a});return}let g=tf(l,h);let b=(n&&n.preventScrollReset)===true;if(p&&to(p.formMethod)){em(e,t,h,g,l,c.active,a,b,p);return}// Store off the match so we can call it's shouldRevalidate on subsequent
// revalidations
Q.set(e,{routeId:t,path:h});eE(e,t,h,g,l,c.active,a,b,p)}// Call the action for the matched fetcher.submit(), and then handle redirects,
// errors, and revalidation
async function em(t,r,n,a,i,o,s,c,h){eT();Q.delete(t);function p(e){if(!e.route.action&&!e.route.lazy){let e=e2(405,{method:h.formMethod,pathname:n,routeId:r});eR(t,r,e,{flushSync:s});return true}return false}if(!o&&p(a)){return}// Put this fetcher into it's submitting state
let v=D.fetchers.get(t);ek(t,tm(h,v),{flushSync:s});let g=new AbortController;let b=e$(e.history,n,g.signal,h);if(o){let e=await tw(i,new URL(b.url).pathname,b.signal,t);if(e.type==="aborted"){return}else if(e.type==="error"){eR(t,r,e.error,{flushSync:s});return}else if(!e.matches){eR(t,r,e2(404,{pathname:n}),{flushSync:s});return}else{i=e.matches;a=tf(i,n);if(p(a)){return}}}// Call the action for the fetcher
V.set(t,g);let y=W;let w=await eS("action",D,b,[a],i,t);let x=w[a.route.id];if(b.signal.aborted){// We can delete this so long as we weren't aborted by our own fetcher
// re-submit which would have put _new_ controller is in fetchControllers
if(V.get(t)===g){V.delete(t)}return}// When using v7_fetcherPersist, we don't want errors bubbling up to the UI
// or redirects processed for unmounted fetchers so we just revert them to
// idle
if(m.v7_fetcherPersist&&J.has(t)){if(te(x)||e9(x)){ek(t,tg(undefined));return}// Let SuccessResult's fall through for revalidation
}else{if(te(x)){V.delete(t);if($>y){// A new navigation was kicked off after our action started, so that
// should take precedence over this redirect navigation.  We already
// set isRevalidationRequired so all loaders for the new route should
// fire unless opted out via shouldRevalidate
ek(t,tg(undefined));return}else{K.add(t);ek(t,tv(h));return eO(b,x,false,{fetcherSubmission:h,preventScrollReset:c})}}// Process any non-redirect errors thrown
if(e9(x)){eR(t,r,x.error);return}}if(e8(x)){throw e2(400,{type:"defer-action"})}// Start the data load for current matches, or the next location if we're
// in the middle of a navigation
let E=D.navigation.location||D.location;let O=e$(e.history,E,g.signal);let S=f||u;let A=D.navigation.state!=="idle"?_(S,D.navigation.location,d):D.matches;l(A,"Didn't find any matches after fetcher action");let T=++W;G.set(t,T);let k=tv(h,x.data);D.fetchers.set(t,k);let[R,C]=eD(e.history,D,A,h,E,false,m.v7_skipActionErrorRevalidation,Y,z,q,J,Q,K,S,d,[a.route.id,x]);// Put all revalidating fetchers into the loading state, except for the
// current fetcher which we want to keep in it's current loading state which
// contains it's action submission info + action data
C.filter(e=>e.key!==t).forEach(e=>{let t=e.key;let r=D.fetchers.get(t);let n=tv(undefined,r?r.data:undefined);D.fetchers.set(t,n);eN(t);if(e.controller){V.set(t,e.controller)}});ei({fetchers:new Map(D.fetchers)});let P=()=>C.forEach(e=>eN(e.key));g.signal.addEventListener("abort",P);let{loaderResults:I,fetcherResults:F}=await eA(D,A,R,C,O);if(g.signal.aborted){return}g.signal.removeEventListener("abort",P);G.delete(t);V.delete(t);C.forEach(e=>V.delete(e.key));let N=e4(I);if(N){return eO(O,N.result,false,{preventScrollReset:c})}N=e4(F);if(N){// If this redirect came from a fetcher make sure we mark it in
// fetchRedirectIds so it doesn't get revalidated on the next set of
// loader executions
K.add(N.key);return eO(O,N.result,false,{preventScrollReset:c})}// Process and commit output from loaders
let{loaderData:j,errors:U}=eX(D,A,I,undefined,C,F,Z);// Since we let revalidations complete even if the submitting fetcher was
// deleted, only put it back to idle if it hasn't been deleted
if(D.fetchers.has(t)){let e=tg(x.data);D.fetchers.set(t,e)}ez(T);// If we are currently in a navigation loading state and this fetcher is
// more recent than the navigation, we want the newer data so abort the
// navigation and complete it with the fetcher data
if(D.navigation.state==="loading"&&T>$){l(M,"Expected pending action");L&&L.abort();eo(D.navigation.location,{matches:A,loaderData:j,errors:U,fetchers:new Map(D.fetchers)})}else{// otherwise just update with the fetcher data, preserving any existing
// loaderData for loaders that did not need to reload.  We have to
// manually merge here since we aren't going through completeNavigation
ei({errors:U,loaderData:eJ(D.loaderData,j,A,U),fetchers:new Map(D.fetchers)});Y=false}}// Call the matched loader for fetcher.load(), handling redirects, errors, etc.
async function eE(t,r,n,a,i,o,s,u,c){let f=D.fetchers.get(t);ek(t,tv(c,f?f.data:undefined),{flushSync:s});let d=new AbortController;let h=e$(e.history,n,d.signal);if(o){let e=await tw(i,new URL(h.url).pathname,h.signal,t);if(e.type==="aborted"){return}else if(e.type==="error"){eR(t,r,e.error,{flushSync:s});return}else if(!e.matches){eR(t,r,e2(404,{pathname:n}),{flushSync:s});return}else{i=e.matches;a=tf(i,n)}}// Call the loader for this fetcher route match
V.set(t,d);let p=W;let v=await eS("loader",D,h,[a],i,t);let m=v[a.route.id];// Deferred isn't supported for fetcher loads, await everything and treat it
// as a normal load.  resolveDeferredData will return undefined if this
// fetcher gets aborted, so we just leave result untouched and short circuit
// below if that happens
if(e8(m)){m=await tl(m,h.signal,true)||m}// We can delete this so long as we weren't aborted by our our own fetcher
// re-load which would have put _new_ controller is in fetchControllers
if(V.get(t)===d){V.delete(t)}if(h.signal.aborted){return}// We don't want errors bubbling up or redirects followed for unmounted
// fetchers, so short circuit here if it was removed from the UI
if(J.has(t)){ek(t,tg(undefined));return}// If the loader threw a redirect Response, start a new REPLACE navigation
if(te(m)){if($>p){// A new navigation was kicked off after our loader started, so that
// should take precedence over this redirect navigation
ek(t,tg(undefined));return}else{K.add(t);await eO(h,m,false,{preventScrollReset:u});return}}// Process any non-redirect errors thrown
if(e9(m)){eR(t,r,m.error);return}l(!e8(m),"Unhandled fetcher deferred data");// Put the fetcher back into an idle state
ek(t,tg(m.data))}/**
   * Utility function to handle redirects returned from an action or loader.
   * Normally, a redirect "replaces" the navigation that triggered it.  So, for
   * example:
   *
   *  - user is on /a
   *  - user clicks a link to /b
   *  - loader for /b redirects to /c
   *
   * In a non-JS app the browser would track the in-flight navigation to /b and
   * then replace it with /c when it encountered the redirect response.  In
   * the end it would only ever update the URL bar with /c.
   *
   * In client-side routing using pushState/replaceState, we aim to emulate
   * this behavior and we also do not update history until the end of the
   * navigation (including processed redirects).  This means that we never
   * actually touch history until we've processed redirects, so we just use
   * the history action from the original navigation (PUSH or REPLACE).
   */async function eO(i,o,s,u){let{submission:c,fetcherSubmission:f,preventScrollReset:p,replace:v}=u===void 0?{}:u;if(o.response.headers.has("X-Remix-Revalidate")){Y=true}let m=o.response.headers.get("Location");l(m,"Expected a Location header on the redirect Response");m=eW(m,new URL(i.url),d);let g=h(D.location,m,{_isRedirect:true});if(r){let r=false;if(o.response.headers.has("X-Remix-Reload-Document")){// Hard reload if the response contained X-Remix-Reload-Document
r=true}else if(e_.test(m)){const n=e.history.createURL(m);r=// Hard reload if it's an absolute URL to a new origin
n.origin!==t.location.origin||// Hard reload if it's an absolute URL that does not match our basename
B(n.pathname,d)==null}if(r){if(v){t.location.replace(m)}else{t.location.assign(m)}return}}// There's no need to abort on redirects, since we don't detect the
// redirect until the action/loaders have settled
L=null;let b=v===true||o.response.headers.has("X-Remix-Replace")?a.Replace:a.Push;// Use the incoming submission if provided, fallback on the active one in
// state.navigation
let{formMethod:y,formAction:w,formEncType:_}=D.navigation;if(!c&&!f&&y&&w&&_){c=td(D.navigation)}// If this was a 307/308 submission we want to preserve the HTTP method and
// re-submit the GET/POST/PUT/PATCH/DELETE as a submission navigation to the
// redirected location
let x=c||f;if(eg.has(o.response.status)&&x&&to(x.formMethod)){await el(b,g,{submission:n({},x,{formAction:m}),// Preserve these flags across redirects
preventScrollReset:p||F,enableViewTransition:s?N:undefined})}else{// If we have a navigation submission, we will preserve it through the
// redirect navigation
let e=th(g,c);await el(b,g,{overrideNavigation:e,// Send fetcher submissions through for shouldRevalidate
fetcherSubmission:f,// Preserve these flags across redirects
preventScrollReset:p||F,enableViewTransition:s?N:undefined})}}// Utility wrapper for calling dataStrategy client-side without having to
// pass around the manifest, mapRouteProperties, etc.
async function eS(e,t,r,n,a,i){let u;let l={};try{u=await eY(p,e,t,r,n,a,i,s,o)}catch(e){// If the outer dataStrategy method throws, just return the error for all
// matches - and it'll naturally bubble to the root
n.forEach(t=>{l[t.route.id]={type:g.error,error:e}});return l}for(let[e,t]of Object.entries(u)){if(e7(t)){let n=t.result;l[e]={type:g.redirect,response:eV(n,r,e,a,d,m.v7_relativeSplatPath)}}else{l[e]=await eq(t)}}return l}async function eA(t,r,n,a,i){let o=t.matches;// Kick off loaders and fetchers in parallel
let s=eS("loader",t,i,n,r,null);let u=Promise.all(a.map(async r=>{if(r.matches&&r.match&&r.controller){let n=await eS("loader",t,e$(e.history,r.path,r.controller.signal),[r.match],r.matches,r.key);let a=n[r.match.route.id];// Fetcher results are keyed by fetcher key from here on out, not routeId
return{[r.key]:a}}else{return Promise.resolve({[r.key]:{type:g.error,error:e2(404,{pathname:r.path})}})}}));let l=await s;let c=(await u).reduce((e,t)=>Object.assign(e,t),{});await Promise.all([ts(r,l,i.signal,o,t.loaderData),tu(r,c,a)]);return{loaderResults:l,fetcherResults:c}}function eT(){// Every interruption triggers a revalidation
Y=true;// Cancel pending route-level deferreds and mark cancelled routes for
// revalidation
z.push(...tt());// Abort in-flight fetcher loads
Q.forEach((e,t)=>{if(V.has(t)){q.add(t)}eN(t)})}function ek(e,t,r){if(r===void 0){r={}}D.fetchers.set(e,t);ei({fetchers:new Map(D.fetchers)},{flushSync:(r&&r.flushSync)===true})}function eR(e,t,r,n){if(n===void 0){n={}}let a=e0(D.matches,t);eF(e);ei({errors:{[a.route.id]:r},fetchers:new Map(D.fetchers)},{flushSync:(n&&n.flushSync)===true})}function eI(e){X.set(e,(X.get(e)||0)+1);// If this fetcher was previously marked for deletion, unmark it since we
// have a new instance
if(J.has(e)){J.delete(e)}return D.fetchers.get(e)||ey}function eF(e){let t=D.fetchers.get(e);// Don't abort the controller if this is a deletion of a fetcher.submit()
// in it's loading phase since - we don't want to abort the corresponding
// revalidation and want them to complete and land
if(V.has(e)&&!(t&&t.state==="loading"&&G.has(e))){eN(e)}Q.delete(e);G.delete(e);K.delete(e);// If we opted into the flag we can clear this now since we're calling
// deleteFetcher() at the end of updateState() and we've already handed the
// deleted fetcher keys off to the data layer.
// If not, we're eagerly calling deleteFetcher() and we need to keep this
// Set populated until the next updateState call, and we'll clear
// `deletedFetchers` then
if(m.v7_fetcherPersist){J.delete(e)}q.delete(e);D.fetchers.delete(e)}function eL(e){let t=(X.get(e)||0)-1;if(t<=0){X.delete(e);J.add(e);if(!m.v7_fetcherPersist){eF(e)}}else{X.set(e,t)}ei({fetchers:new Map(D.fetchers)})}function eN(e){let t=V.get(e);if(t){t.abort();V.delete(e)}}function eU(e){for(let t of e){let e=eI(t);let r=tg(e.data);D.fetchers.set(t,r)}}function eH(){let e=[];let t=false;for(let r of K){let n=D.fetchers.get(r);l(n,"Expected fetcher: "+r);if(n.state==="loading"){K.delete(r);e.push(r);t=true}}eU(e);return t}function ez(e){let t=[];for(let[r,n]of G){if(n<e){let e=D.fetchers.get(r);l(e,"Expected fetcher: "+r);if(e.state==="loading"){eN(r);G.delete(r);t.push(r)}}}eU(t);return t.length>0}function eG(e,t){let r=D.blockers.get(e)||ew;if(ee.get(e)!==t){ee.set(e,t)}return r}function eK(e){D.blockers.delete(e);ee.delete(e)}// Utility function to update blockers, ensuring valid state transitions
function eQ(e,t){let r=D.blockers.get(e)||ew;// Poor mans state machine :)
// https://mermaid.live/edit#pako:eNqVkc9OwzAMxl8l8nnjAYrEtDIOHEBIgwvKJTReGy3_lDpIqO27k6awMG0XcrLlnz87nwdonESogKXXBuE79rq75XZO3-yHds0RJVuv70YrPlUrCEe2HfrORS3rubqZfuhtpg5C9wk5tZ4VKcRUq88q9Z8RS0-48cE1iHJkL0ugbHuFLus9L6spZy8nX9MP2CNdomVaposqu3fGayT8T8-jJQwhepo_UtpgBQaDEUom04dZhAN1aJBDlUKJBxE1ceB2Smj0Mln-IBW5AFU2dwUiktt_2Qaq2dBfaKdEup85UV7Yd-dKjlnkabl2Pvr0DTkTreM
l(r.state==="unblocked"&&t.state==="blocked"||r.state==="blocked"&&t.state==="blocked"||r.state==="blocked"&&t.state==="proceeding"||r.state==="blocked"&&t.state==="unblocked"||r.state==="proceeding"&&t.state==="unblocked","Invalid blocker state transition: "+r.state+" -> "+t.state);let n=new Map(D.blockers);n.set(e,t);ei({blockers:n})}function e6(e){let{currentLocation:t,nextLocation:r,historyAction:n}=e;if(ee.size===0){return}// We ony support a single active blocker at the moment since we don't have
// any compelling use cases for multi-blocker yet
if(ee.size>1){c(false,"A router only supports one blocker at a time")}let a=Array.from(ee.entries());let[i,o]=a[a.length-1];let s=D.blockers.get(i);if(s&&s.state==="proceeding"){// If the blocker is currently proceeding, we don't need to re-check
// it and can let this navigation continue
return}// At this point, we know we're unblocked/blocked so we need to check the
// user-provided blocker function
if(o({currentLocation:t,nextLocation:r,historyAction:n})){return i}}function e3(e){let t=e2(404,{pathname:e});let r=f||u;let{matches:n,route:a}=e1(r);// Cancel all pending deferred on 404s since we don't keep any routes
tt();return{notFoundMatches:n,route:a,error:t}}function tt(e){let t=[];Z.forEach((r,n)=>{if(!e||e(n)){// Cancel the deferred - but do not remove from activeDeferreds here -
// we rely on the subscribers to do that so our tests can assert proper
// cleanup via _internalActiveDeferreds
r.cancel();t.push(n);Z.delete(n)}});return t}// Opt in to capturing and reporting scroll positions during navigations,
// used by the <ScrollRestoration> component
function tr(e,t,r){O=e;A=t;S=r||null;// Perform initial hydration scroll restoration, since we miss the boat on
// the initial updateState() because we've not yet rendered <ScrollRestoration/>
// and therefore have no savedScrollPositions available
if(!T&&D.navigation===eb){T=true;let e=ti(D.location,D.matches);if(e!=null){ei({restoreScrollPosition:e})}}return()=>{O=null;A=null;S=null}}function tn(e,t){if(S){let r=S(e,t.map(e=>E(e,D.loaderData)));return r||e.key}return e.key}function ta(e,t){if(O&&A){let r=tn(e,t);O[r]=A()}}function ti(e,t){if(O){let r=tn(e,t);let n=O[r];if(typeof n==="number"){return n}}return null}function tc(e,t,r){if(v){if(!e){let e=x(t,r,d,true);return{active:true,matches:e||[]}}else{if(Object.keys(e[0].params).length>0){// If we matched a dynamic param or a splat, it might only be because
// we haven't yet discovered other routes that would match with a
// higher score.  Call patchRoutesOnNavigation just to be sure
let e=x(t,r,d,true);return{active:true,matches:e}}}}return{active:false,matches:null}}async function tw(e,t,r,n){if(!v){return{type:"success",matches:e}}let a=e;while(true){let e=f==null;let i=f||u;let l=s;try{await v({signal:r,path:t,matches:a,fetcherKey:n,patch:(e,t)=>{if(r.aborted)return;ej(e,t,i,l,o)}})}catch(e){return{type:"error",error:e,partialMatches:a}}finally{// If we are not in the middle of an HMR revalidation and we changed the
// routes, provide a new identity so when we `updateState` at the end of
// this navigation/fetch `router.routes` will be a new identity and
// trigger a re-run of memoized `router.routes` dependencies.
// HMR will already update the identity and reflow when it lands
// `inFlightDataRoutes` in `completeNavigation`
if(e&&!r.aborted){u=[...u]}}if(r.aborted){return{type:"aborted"}}let c=_(i,t,d);if(c){return{type:"success",matches:c}}let h=x(i,t,d,true);// Avoid loops if the second pass results in the same partial matches
if(!h||a.length===h.length&&a.every((e,t)=>e.route.id===h[t].route.id)){return{type:"success",matches:null}}a=h}}function t_(e){s={};f=w(e,o,undefined,s)}function tx(e,t){let r=f==null;let n=f||u;ej(e,t,n,s,o);// If we are not in the middle of an HMR revalidation and we changed the
// routes, provide a new identity and trigger a reflow via `updateState`
// to re-run memoized `router.routes` dependencies.
// HMR will already update the identity and reflow when it lands
// `inFlightDataRoutes` in `completeNavigation`
if(r){u=[...u];ei({})}}I={get basename(){return d},get future(){return m},get state(){return D},get routes(){return u},get window(){return t},initialize:er,subscribe:ea,enableScrollRestoration:tr,navigate:es,fetch:ev,revalidate:eu,// Passthrough to history-aware createHref used by useHref so we get proper
// hash-aware URLs in DOM paths
createHref:t=>e.history.createHref(t),encodeLocation:t=>e.history.encodeLocation(t),getFetcher:eI,deleteFetcher:eL,dispose:en,getBlocker:eG,deleteBlocker:eK,patchRoutes:tx,_internalFetchControllers:V,_internalActiveDeferreds:Z,// TODO: Remove setRoutes, it's temporary to avoid dealing with
// updating the tree while validating the update algorithm.
_internalSetRoutes:t_};return I}//#endregion
////////////////////////////////////////////////////////////////////////////////
//#region createStaticHandler
////////////////////////////////////////////////////////////////////////////////
const eS=Symbol("deferred");function eA(e,t){l(e.length>0,"You must provide a non-empty routes array to createStaticHandler");let r={};let a=(t?t.basename:null)||"/";let i;if(t!=null&&t.mapRouteProperties){i=t.mapRouteProperties}else if(t!=null&&t.detectErrorBoundary){// If they are still using the deprecated version, wrap it with the new API
let e=t.detectErrorBoundary;i=t=>({hasErrorBoundary:e(t)})}else{i=ex}// Config driven behavior flags
let o=n({v7_relativeSplatPath:false,v7_throwAbortReason:false},t?t.future:null);let s=w(e,i,undefined,r);/**
   * The query() method is intended for document requests, in which we want to
   * call an optional action and potentially multiple loaders for all nested
   * routes.  It returns a StaticHandlerContext object, which is very similar
   * to the router state (location, loaderData, actionData, errors, etc.) and
   * also adds SSR-specific information such as the statusCode and headers
   * from action/loaders Responses.
   *
   * It _should_ never throw and should report all errors through the
   * returned context.errors object, properly associating errors to their error
   * boundary.  Additionally, it tracks _deepestRenderedBoundaryId which can be
   * used to emulate React error boundaries during SSr by performing a second
   * pass only down to the boundaryId.
   *
   * The one exception where we do not return a StaticHandlerContext is when a
   * redirect response is returned or thrown from any action/loader.  We
   * propagate that out and return the raw Response so the HTTP server can
   * return it directly.
   *
   * - `opts.requestContext` is an optional server context that will be passed
   *   to actions/loaders in the `context` parameter
   * - `opts.skipLoaderErrorBubbling` is an optional parameter that will prevent
   *   the bubbling of errors which allows single-fetch-type implementations
   *   where the client will handle the bubbling and we may need to return data
   *   for the handling route
   */async function u(e,t){let{requestContext:r,skipLoaderErrorBubbling:i,dataStrategy:o}=t===void 0?{}:t;let u=new URL(e.url);let l=e.method;let c=h("",p(u),null,"default");let d=_(s,c,a);// SSR supports HEAD requests while SPA doesn't
if(!ti(l)&&l!=="HEAD"){let e=e2(405,{method:l});let{matches:t,route:r}=e1(s);return{basename:a,location:c,matches:t,loaderData:{},actionData:null,errors:{[r.id]:e},statusCode:e.status,loaderHeaders:{},actionHeaders:{},activeDeferreds:null}}else if(!d){let e=e2(404,{pathname:c.pathname});let{matches:t,route:r}=e1(s);return{basename:a,location:c,matches:t,loaderData:{},actionData:null,errors:{[r.id]:e},statusCode:e.status,loaderHeaders:{},actionHeaders:{},activeDeferreds:null}}let v=await f(e,c,d,r,o||null,i===true,null);if(tn(v)){return v}// When returning StaticHandlerContext, we patch back in the location here
// since we need it for React Context.  But this helps keep our submit and
// loadRouteData operating on a Request instead of a Location
return n({location:c,basename:a},v)}/**
   * The queryRoute() method is intended for targeted route requests, either
   * for fetch ?_data requests or resource route requests.  In this case, we
   * are only ever calling a single action or loader, and we are returning the
   * returned value directly.  In most cases, this will be a Response returned
   * from the action/loader, but it may be a primitive or other value as well -
   * and in such cases the calling context should handle that accordingly.
   *
   * We do respect the throw/return differentiation, so if an action/loader
   * throws, then this method will throw the value.  This is important so we
   * can do proper boundary identification in Remix where a thrown Response
   * must go to the Catch Boundary but a returned Response is happy-path.
   *
   * One thing to note is that any Router-initiated Errors that make sense
   * to associate with a status code will be thrown as an ErrorResponse
   * instance which include the raw Error, such that the calling context can
   * serialize the error as they see fit while including the proper response
   * code.  Examples here are 404 and 405 errors that occur prior to reaching
   * any user-defined loaders.
   *
   * - `opts.routeId` allows you to specify the specific route handler to call.
   *   If not provided the handler will determine the proper route by matching
   *   against `request.url`
   * - `opts.requestContext` is an optional server context that will be passed
   *    to actions/loaders in the `context` parameter
   */async function c(e,t){let{routeId:r,requestContext:n,dataStrategy:i}=t===void 0?{}:t;let o=new URL(e.url);let u=e.method;let l=h("",p(o),null,"default");let c=_(s,l,a);// SSR supports HEAD requests while SPA doesn't
if(!ti(u)&&u!=="HEAD"&&u!=="OPTIONS"){throw e2(405,{method:u})}else if(!c){throw e2(404,{pathname:l.pathname})}let d=r?c.find(e=>e.route.id===r):tf(c,l);if(r&&!d){throw e2(403,{pathname:l.pathname,routeId:r})}else if(!d){// This should never hit I don't think?
throw e2(404,{pathname:l.pathname})}let v=await f(e,l,c,n,i||null,false,d);if(tn(v)){return v}let m=v.errors?Object.values(v.errors)[0]:undefined;if(m!==undefined){// If we got back result.errors, that means the loader/action threw
// _something_ that wasn't a Response, but it's not guaranteed/required
// to be an `instanceof Error` either, so we have to use throw here to
// preserve the "error" state outside of queryImpl.
throw m}// Pick off the right state value to return
if(v.actionData){return Object.values(v.actionData)[0]}if(v.loaderData){var g;let e=Object.values(v.loaderData)[0];if((g=v.activeDeferreds)!=null&&g[d.route.id]){e[eS]=v.activeDeferreds[d.route.id]}return e}return undefined}async function f(e,t,r,a,i,o,s){l(e.signal,"query()/queryRoute() requests must contain an AbortController signal");try{if(to(e.method.toLowerCase())){let n=await d(e,r,s||tf(r,t),a,i,o,s!=null);return n}let u=await v(e,r,a,i,o,s);return tn(u)?u:n({},u,{actionData:null,actionHeaders:{}})}catch(e){// If the user threw/returned a Response in callLoaderOrAction for a
// `queryRoute` call, we throw the `DataStrategyResult` to bail out early
// and then return or throw the raw Response here accordingly
if(e3(e)&&tn(e.result)){if(e.type===g.error){throw e.result}return e.result}// Redirects are always returned since they don't propagate to catch
// boundaries
if(ta(e)){return e}throw e}}async function d(e,t,r,a,i,s,u){let l;if(!r.route.action&&!r.route.lazy){let t=e2(405,{method:e.method,pathname:new URL(e.url).pathname,routeId:r.route.id});if(u){throw t}l={type:g.error,error:t}}else{let n=await m("action",e,[r],t,u,a,i);l=n[r.route.id];if(e.signal.aborted){ek(e,u,o)}}if(te(l)){// Uhhhh - this should never happen, we should always throw these from
// callLoaderOrAction, but the type narrowing here keeps TS happy and we
// can get back on the "throw all redirect responses" train here should
// this ever happen :/
throw new Response(null,{status:l.response.status,headers:{Location:l.response.headers.get("Location")}})}if(e8(l)){let e=e2(400,{type:"defer-action"});if(u){throw e}l={type:g.error,error:e}}if(u){// Note: This should only be non-Response values if we get here, since
// isRouteRequest should throw any Response received in callLoaderOrAction
if(e9(l)){throw l.error}return{matches:[r],loaderData:{},actionData:{[r.route.id]:l.data},errors:null,// Note: statusCode + headers are unused here since queryRoute will
// return the raw Response or value
statusCode:200,loaderHeaders:{},actionHeaders:{},activeDeferreds:null}}// Create a GET request for the loaders
let c=new Request(e.url,{headers:e.headers,redirect:e.redirect,signal:e.signal});if(e9(l)){// Store off the pending error - we use it to determine which loaders
// to call and will commit it when we complete the navigation
let e=s?r:e0(t,r.route.id);let o=await v(c,t,a,i,s,null,[e.route.id,l]);// action status codes take precedence over loader status codes
return n({},o,{statusCode:ef(l.error)?l.error.status:l.statusCode!=null?l.statusCode:500,actionData:null,actionHeaders:n({},l.headers?{[r.route.id]:l.headers}:{})})}let f=await v(c,t,a,i,s,null);return n({},f,{actionData:{[r.route.id]:l.data}},l.statusCode?{statusCode:l.statusCode}:{},{actionHeaders:l.headers?{[r.route.id]:l.headers}:{}})}async function v(e,t,r,a,i,s,u){let l=s!=null;// Short circuit if we have no loaders to run (queryRoute())
if(l&&!(s!=null&&s.route.loader)&&!(s!=null&&s.route.lazy)){throw e2(400,{method:e.method,pathname:new URL(e.url).pathname,routeId:s==null?void 0:s.route.id})}let c=s?[s]:u&&e9(u[1])?eI(t,u[0]):t;let f=c.filter(e=>e.route.loader||e.route.lazy);// Short circuit if we have no loaders to run (query())
if(f.length===0){return{matches:t,// Add a null for all matched routes for proper revalidation on the client
loaderData:t.reduce((e,t)=>Object.assign(e,{[t.route.id]:null}),{}),errors:u&&e9(u[1])?{[u[0]]:u[1].error}:null,statusCode:200,loaderHeaders:{},activeDeferreds:null}}let d=await m("loader",e,f,t,l,r,a);if(e.signal.aborted){ek(e,l,o)}// Process and commit output from loaders
let h=new Map;let p=eQ(t,d,u,h,i);// Add a null for any non-loader matches for proper revalidation on the client
let v=new Set(f.map(e=>e.route.id));t.forEach(e=>{if(!v.has(e.route.id)){p.loaderData[e.route.id]=null}});return n({},p,{matches:t,activeDeferreds:h.size>0?Object.fromEntries(h.entries()):null})}// Utility wrapper for calling dataStrategy server-side without having to
// pass around the manifest, mapRouteProperties, etc.
async function m(e,t,n,s,u,l,c){let f=await eY(c||eB,e,null,t,n,s,null,r,i,l);let d={};await Promise.all(s.map(async e=>{if(!(e.route.id in f)){return}let r=f[e.route.id];if(e7(r)){let n=r.result;// Throw redirects and let the server handle them with an HTTP redirect
throw eV(n,t,e.route.id,s,a,o.v7_relativeSplatPath)}if(tn(r.result)&&u){// For SSR single-route requests, we want to hand Responses back
// directly without unwrapping
throw r}d[e.route.id]=await eq(r)}));return d}return{dataRoutes:s,query:u,queryRoute:c}}//#endregion
////////////////////////////////////////////////////////////////////////////////
//#region Helpers
////////////////////////////////////////////////////////////////////////////////
/**
 * Given an existing StaticHandlerContext and an error thrown at render time,
 * provide an updated StaticHandlerContext suitable for a second SSR render
 */function eT(e,t,r){let a=n({},t,{statusCode:ef(r)?r.status:500,errors:{[t._deepestRenderedBoundaryId||e[0].id]:r}});return a}function ek(e,t,r){if(r.v7_throwAbortReason&&e.signal.reason!==undefined){throw e.signal.reason}let n=t?"queryRoute":"query";throw new Error(n+"() call aborted: "+e.method+" "+e.url)}function eR(e){return e!=null&&("formData"in e&&e.formData!=null||"body"in e&&e.body!==undefined)}function eC(e,t,r,n,a,i,o,s){let u;let l;if(o){// Grab matches up to the calling route so our route-relative logic is
// relative to the correct source route
u=[];for(let e of t){u.push(e);if(e.route.id===o){l=e;break}}}else{u=t;l=t[t.length-1]}// Resolve the relative path
let c=$(a?a:".",W(u,i),B(e.pathname,r)||e.pathname,s==="path");// When `to` is not specified we inherit search/hash from the current
// location, unlike when to="." and we just inherit the path.
// See https://github.com/remix-run/remix/issues/927
if(a==null){c.search=e.search;c.hash=e.hash}// Account for `?index` params when routing to the current location
if((a==null||a===""||a===".")&&l){let e=tc(c.search);if(l.route.index&&!e){// Add one when we're targeting an index route
c.search=c.search?c.search.replace(/^\?/,"?index&"):"?index"}else if(!l.route.index&&e){// Remove existing ones when we're not
let e=new URLSearchParams(c.search);let t=e.getAll("index");e.delete("index");t.filter(e=>e).forEach(t=>e.append("index",t));let r=e.toString();c.search=r?"?"+r:""}}// If we're operating within a basename, prepend it to the pathname.  If
// this is a root navigation, then just use the raw basename which allows
// the basename to have full control over the presence of a trailing slash
// on root actions
if(n&&r!=="/"){c.pathname=c.pathname==="/"?r:K([r,c.pathname])}return p(c)}// Normalize navigation options by converting formMethod=GET formData objects to
// URLSearchParams so they behave identically to links with query params
function eP(e,t,r,n){// Return location verbatim on non-submission navigations
if(!n||!eR(n)){return{path:r}}if(n.formMethod&&!ti(n.formMethod)){return{path:r,error:e2(405,{method:n.formMethod})}}let a=()=>({path:r,error:e2(400,{type:"invalid-body"})});// Create a Submission on non-GET navigations
let i=n.formMethod||"get";let o=e?i.toUpperCase():i.toLowerCase();let s=e6(r);if(n.body!==undefined){if(n.formEncType==="text/plain"){// text only support POST/PUT/PATCH/DELETE submissions
if(!to(o)){return a()}let e=typeof n.body==="string"?n.body:n.body instanceof FormData||n.body instanceof URLSearchParams?// https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#plain-text-form-data
Array.from(n.body.entries()).reduce((e,t)=>{let[r,n]=t;return""+e+r+"="+n+"\n"},""):String(n.body);return{path:r,submission:{formMethod:o,formAction:s,formEncType:n.formEncType,formData:undefined,json:undefined,text:e}}}else if(n.formEncType==="application/json"){// json only supports POST/PUT/PATCH/DELETE submissions
if(!to(o)){return a()}try{let e=typeof n.body==="string"?JSON.parse(n.body):n.body;return{path:r,submission:{formMethod:o,formAction:s,formEncType:n.formEncType,formData:undefined,json:e,text:undefined}}}catch(e){return a()}}}l(typeof FormData==="function","FormData is not available in this environment");let u;let c;if(n.formData){u=eG(n.formData);c=n.formData}else if(n.body instanceof FormData){u=eG(n.body);c=n.body}else if(n.body instanceof URLSearchParams){u=n.body;c=eK(u)}else if(n.body==null){u=new URLSearchParams;c=new FormData}else{try{u=new URLSearchParams(n.body);c=eK(u)}catch(e){return a()}}let f={formMethod:o,formAction:s,formEncType:n&&n.formEncType||"application/x-www-form-urlencoded",formData:c,json:undefined,text:undefined};if(to(f.formMethod)){return{path:r,submission:f}}// Flatten submission onto URLSearchParams for GET submissions
let d=v(r);// On GET navigation submissions we can drop the ?index param from the
// resulting location since all loaders will run.  But fetcher GET submissions
// only run a single loader so we need to preserve any incoming ?index params
if(t&&d.search&&tc(d.search)){u.append("index","")}d.search="?"+u;return{path:p(d),submission:f}}// Filter out all routes at/below any caught error as they aren't going to
// render so we don't need to load them
function eI(e,t,r){if(r===void 0){r=false}let n=e.findIndex(e=>e.route.id===t);if(n>=0){return e.slice(0,r?n+1:n)}return e}function eD(e,t,r,a,i,o,s,u,l,c,f,d,h,p,v,m){let g=m?e9(m[1])?m[1].error:m[1].data:undefined;let b=e.createURL(t.location);let y=e.createURL(i);// Pick navigation matches that are net-new or qualify for revalidation
let w=r;if(o&&t.errors){// On initial hydration, only consider matches up to _and including_ the boundary.
// This is inclusive to handle cases where a server loader ran successfully,
// a child server loader bubbled up to this route, but this route has
// `clientLoader.hydrate` so we want to still run the `clientLoader` so that
// we have a complete version of `loaderData`
w=eI(r,Object.keys(t.errors)[0],true)}else if(m&&e9(m[1])){// If an action threw an error, we call loaders up to, but not including the
// boundary
w=eI(r,m[0])}// Don't revalidate loaders by default after action 4xx/5xx responses
// when the flag is enabled.  They can still opt-into revalidation via
// `shouldRevalidate` via `actionResult`
let x=m?m[1].statusCode:undefined;let E=s&&x&&x>=400;let O=w.filter((e,r)=>{let{route:i}=e;if(i.lazy){// We haven't loaded this route yet so we don't know if it's got a loader!
return true}if(i.loader==null){return false}if(o){return eM(i,t.loaderData,t.errors)}// Always call the loader on new route instances and pending defer cancellations
if(eF(t.loaderData,t.matches[r],e)||l.some(t=>t===e.route.id)){return true}// This is the default implementation for when we revalidate.  If the route
// provides it's own implementation, then we give them full control but
// provide this value so they can leverage it if needed after they check
// their own specific use cases
let s=t.matches[r];let c=e;return eN(e,n({currentUrl:b,currentParams:s.params,nextUrl:y,nextParams:c.params},a,{actionResult:g,actionStatus:x,defaultShouldRevalidate:E?false:// Forced revalidation due to submission, useRevalidator, or X-Remix-Revalidate
u||b.pathname+b.search===y.pathname+y.search||// Search params affect all loaders
b.search!==y.search||eL(s,c)}))});// Pick fetcher.loads that need to be revalidated
let S=[];d.forEach((e,i)=>{// Don't revalidate:
//  - on initial hydration (shouldn't be any fetchers then anyway)
//  - if fetcher won't be present in the subsequent render
//    - no longer matches the URL (v7_fetcherPersist=false)
//    - was unmounted but persisted due to v7_fetcherPersist=true
if(o||!r.some(t=>t.route.id===e.routeId)||f.has(i)){return}let s=_(p,e.path,v);// If the fetcher path no longer matches, push it in with null matches so
// we can trigger a 404 in callLoadersAndMaybeResolveData.  Note this is
// currently only a use-case for Remix HMR where the route tree can change
// at runtime and remove a route previously loaded via a fetcher
if(!s){S.push({key:i,routeId:e.routeId,path:e.path,matches:null,match:null,controller:null});return}// Revalidating fetchers are decoupled from the route matches since they
// load from a static href.  They revalidate based on explicit revalidation
// (submission, useRevalidator, or X-Remix-Revalidate)
let l=t.fetchers.get(i);let d=tf(s,e.path);let m=false;if(h.has(i)){// Never trigger a revalidation of an actively redirecting fetcher
m=false}else if(c.has(i)){// Always mark for revalidation if the fetcher was cancelled
c.delete(i);m=true}else if(l&&l.state!=="idle"&&l.data===undefined){// If the fetcher hasn't ever completed loading yet, then this isn't a
// revalidation, it would just be a brand new load if an explicit
// revalidation is required
m=u}else{// Otherwise fall back on any user-defined shouldRevalidate, defaulting
// to explicit revalidations only
m=eN(d,n({currentUrl:b,currentParams:t.matches[t.matches.length-1].params,nextUrl:y,nextParams:r[r.length-1].params},a,{actionResult:g,actionStatus:x,defaultShouldRevalidate:E?false:u}))}if(m){S.push({key:i,routeId:e.routeId,path:e.path,matches:s,match:d,controller:new AbortController})}});return[O,S]}function eM(e,t,r){// We dunno if we have a loader - gotta find out!
if(e.lazy){return true}// No loader, nothing to initialize
if(!e.loader){return false}let n=t!=null&&t[e.id]!==undefined;let a=r!=null&&r[e.id]!==undefined;// Don't run if we error'd during SSR
if(!n&&a){return false}// Explicitly opting-in to running on hydration
if(typeof e.loader==="function"&&e.loader.hydrate===true){return true}// Otherwise, run if we're not yet initialized with anything
return!n&&!a}function eF(e,t,r){let n=// [a] -> [a, b]
!t||// [a, b] -> [a, c]
r.route.id!==t.route.id;// Handle the case that we don't have data for a re-used route, potentially
// from a prior error or from a cancelled pending deferred
let a=e[r.route.id]===undefined;// Always load if this is a net-new route or we don't yet have data
return n||a}function eL(e,t){let r=e.route.path;return(// param change for this match, /users/123 -> /users/456
e.pathname!==t.pathname||// splat param changed, which is not present in match.path
// e.g. /files/images/avatar.jpg -> files/finances.xls
r!=null&&r.endsWith("*")&&e.params["*"]!==t.params["*"])}function eN(e,t){if(e.route.shouldRevalidate){let r=e.route.shouldRevalidate(t);if(typeof r==="boolean"){return r}}return t.defaultShouldRevalidate}function ej(e,t,r,n,a){var i;let o;if(e){let t=n[e];l(t,"No route found to patch children into: routeId = "+e);if(!t.children){t.children=[]}o=t.children}else{o=r}// Don't patch in routes we already know about so that `patch` is idempotent
// to simplify user-land code. This is useful because we re-call the
// `patchRoutesOnNavigation` function for matched routes with params.
let s=t.filter(e=>!o.some(t=>eU(e,t)));let u=w(s,a,[e||"_","patch",String(((i=o)==null?void 0:i.length)||"0")],n);o.push(...u)}function eU(e,t){// Most optimal check is by id
if("id"in e&&"id"in t&&e.id===t.id){return true}// Second is by pathing differences
if(!(e.index===t.index&&e.path===t.path&&e.caseSensitive===t.caseSensitive)){return false}// Pathless layout routes are trickier since we need to check children.
// If they have no children then they're the same as far as we can tell
if((!e.children||e.children.length===0)&&(!t.children||t.children.length===0)){return true}// Otherwise, we look to see if every child in the new route is already
// represented in the existing route's children
return e.children.every((e,r)=>{var n;return(n=t.children)==null?void 0:n.some(t=>eU(e,t))})}/**
 * Execute route.lazy() methods to lazily load route modules (loader, action,
 * shouldRevalidate) and update the routeManifest in place which shares objects
 * with dataRoutes so those get updated as well.
 */async function eH(e,t,r){if(!e.lazy){return}let a=await e.lazy();// If the lazy route function was executed and removed by another parallel
// call then we can return - first lazy() to finish wins because the return
// value of lazy is expected to be static
if(!e.lazy){return}let i=r[e.id];l(i,"No route found in manifest");// Update the route in place.  This should be safe because there's no way
// we could yet be sitting on this route as we can't get there without
// resolving lazy() first.
//
// This is different than the HMR "update" use-case where we may actively be
// on the route being updated.  The main concern boils down to "does this
// mutation affect any ongoing navigations or any current state.matches
// values?".  If not, it should be safe to update in place.
let o={};for(let e in a){let t=i[e];let r=t!==undefined&&// This property isn't static since it should always be updated based
// on the route updates
e!=="hasErrorBoundary";c(!r,'Route "'+i.id+'" has a static property "'+e+'" '+"defined but its lazy function is also returning a value for this property. "+('The lazy route property "'+e+'" will be ignored.'));if(!r&&!b.has(e)){o[e]=a[e]}}// Mutate the route with the provided updates.  Do this first so we pass
// the updated version to mapRouteProperties
Object.assign(i,o);// Mutate the `hasErrorBoundary` property on the route based on the route
// updates and remove the `lazy` function so we don't resolve the lazy
// route again.
Object.assign(i,n({},t(i),{lazy:undefined}))}// Default implementation of `dataStrategy` which fetches all loaders in parallel
async function eB(e){let{matches:t}=e;let r=t.filter(e=>e.shouldLoad);let n=await Promise.all(r.map(e=>e.resolve()));return n.reduce((e,t,n)=>Object.assign(e,{[r[n].route.id]:t}),{})}async function eY(e,t,r,a,i,o,s,u,l,c){let f=o.map(e=>e.route.lazy?eH(e.route,l,u):undefined);let d=o.map((e,r)=>{let o=f[r];let s=i.some(t=>t.route.id===e.route.id);// `resolve` encapsulates route.lazy(), executing the loader/action,
// and mapping return values/thrown errors to a `DataStrategyResult`.  Users
// can pass a callback to take fine-grained control over the execution
// of the loader/action
let u=async r=>{if(r&&a.method==="GET"&&(e.route.lazy||e.route.loader)){s=true}return s?ez(t,a,e,o,r,c):Promise.resolve({type:g.data,result:undefined})};return n({},e,{shouldLoad:s,resolve:u})});// Send all matches here to allow for a middleware-type implementation.
// handler will be a no-op for unneeded routes and we filter those results
// back out below.
let h=await e({matches:d,request:a,params:o[0].params,fetcherKey:s,context:c});// Wait for all routes to load here but 'swallow the error since we want
// it to bubble up from the `await loadRoutePromise` in `callLoaderOrAction` -
// called from `match.resolve()`
try{await Promise.all(f)}catch(e){// No-op
}return h}// Default logic for calling a loader/action is the user has no specified a dataStrategy
async function ez(e,t,r,n,a,i){let o;let s;let u=n=>{// Setup a promise we can race against so that abort signals short circuit
let o;// This will never resolve so safe to type it as Promise<DataStrategyResult> to
// satisfy the function return value
let u=new Promise((e,t)=>o=t);s=()=>o();t.signal.addEventListener("abort",s);let l=a=>{if(typeof n!=="function"){return Promise.reject(new Error("You cannot call the handler for a route which defines a boolean "+('"'+e+'" [routeId: '+r.route.id+"]")))}return n({request:t,params:r.params,context:i},...a!==undefined?[a]:[])};let c=(async()=>{try{let e=await (a?a(e=>l(e)):l());return{type:"data",result:e}}catch(e){return{type:"error",result:e}}})();return Promise.race([c,u])};try{let a=r.route[e];// If we have a route.lazy promise, await that first
if(n){if(a){// Run statically defined handler in parallel with lazy()
let e;let[t]=await Promise.all([// If the handler throws, don't let it immediately bubble out,
// since we need to let the lazy() execution finish so we know if this
// route has a boundary that can handle the error
u(a).catch(t=>{e=t}),n]);if(e!==undefined){throw e}o=t}else{// Load lazy route module, then run any returned handler
await n;a=r.route[e];if(a){// Handler still runs even if we got interrupted to maintain consistency
// with un-abortable behavior of handler execution on non-lazy or
// previously-lazy-loaded routes
o=await u(a)}else if(e==="action"){let e=new URL(t.url);let n=e.pathname+e.search;throw e2(405,{method:t.method,pathname:n,routeId:r.route.id})}else{// lazy() route has no loader to run.  Short circuit here so we don't
// hit the invariant below that errors on returning undefined.
return{type:g.data,result:undefined}}}}else if(!a){let e=new URL(t.url);let r=e.pathname+e.search;throw e2(404,{pathname:r})}else{o=await u(a)}l(o.result!==undefined,"You defined "+(e==="action"?"an action":"a loader")+" for route "+('"'+r.route.id+"\" but didn't return anything from your `"+e+"` ")+"function. Please return a value or `null`.")}catch(e){// We should already be catching and converting normal handler executions to
// DataStrategyResults and returning them, so anything that throws here is an
// unexpected error we still need to wrap
return{type:g.error,result:e}}finally{if(s){t.signal.removeEventListener("abort",s)}}return o}async function eq(e){let{result:t,type:r}=e;if(tn(t)){let e;try{let r=t.headers.get("Content-Type");// Check between word boundaries instead of startsWith() due to the last
// paragraph of https://httpwg.org/specs/rfc9110.html#field.content-type
if(r&&/\bapplication\/json\b/.test(r)){if(t.body==null){e=null}else{e=await t.json()}}else{e=await t.text()}}catch(e){return{type:g.error,error:e}}if(r===g.error){return{type:g.error,error:new ec(t.status,t.statusText,e),statusCode:t.status,headers:t.headers}}return{type:g.data,data:e,statusCode:t.status,headers:t.headers}}if(r===g.error){if(tt(t)){var n,a;if(t.data instanceof Error){var i,o;return{type:g.error,error:t.data,statusCode:(i=t.init)==null?void 0:i.status,headers:(o=t.init)!=null&&o.headers?new Headers(t.init.headers):undefined}}// Convert thrown data() to ErrorResponse instances
return{type:g.error,error:new ec(((n=t.init)==null?void 0:n.status)||500,undefined,t.data),statusCode:ef(t)?t.status:undefined,headers:(a=t.init)!=null&&a.headers?new Headers(t.init.headers):undefined}}return{type:g.error,error:t,statusCode:ef(t)?t.status:undefined}}if(tr(t)){var s,u;return{type:g.deferred,deferredData:t,statusCode:(s=t.init)==null?void 0:s.status,headers:((u=t.init)==null?void 0:u.headers)&&new Headers(t.init.headers)}}if(tt(t)){var l,c;return{type:g.data,data:t.data,statusCode:(l=t.init)==null?void 0:l.status,headers:(c=t.init)!=null&&c.headers?new Headers(t.init.headers):undefined}}return{type:g.data,data:t}}// Support relative routing in internal redirects
function eV(e,t,r,n,a,i){let o=e.headers.get("Location");l(o,"Redirects returned/thrown from loaders/actions must have a Location header");if(!e_.test(o)){let s=n.slice(0,n.findIndex(e=>e.route.id===r)+1);o=eC(new URL(t.url),s,a,true,o,i);e.headers.set("Location",o)}return e}function eW(e,t,r){if(e_.test(e)){// Strip off the protocol+origin for same-origin + same-basename absolute redirects
let n=e;let a=n.startsWith("//")?new URL(t.protocol+n):new URL(n);let i=B(a.pathname,r)!=null;if(a.origin===t.origin&&i){return a.pathname+a.search+a.hash}}return e}// Utility method for creating the Request instances for loaders/actions during
// client-side navigations and fetches.  During SSR we will always have a
// Request instance from the static handler (query/queryRoute)
function e$(e,t,r,n){let a=e.createURL(e6(t)).toString();let i={signal:r};if(n&&to(n.formMethod)){let{formMethod:e,formEncType:t}=n;// Didn't think we needed this but it turns out unlike other methods, patch
// won't be properly normalized to uppercase and results in a 405 error.
// See: https://fetch.spec.whatwg.org/#concept-method
i.method=e.toUpperCase();if(t==="application/json"){i.headers=new Headers({"Content-Type":t});i.body=JSON.stringify(n.json)}else if(t==="text/plain"){// Content-Type is inferred (https://fetch.spec.whatwg.org/#dom-request)
i.body=n.text}else if(t==="application/x-www-form-urlencoded"&&n.formData){// Content-Type is inferred (https://fetch.spec.whatwg.org/#dom-request)
i.body=eG(n.formData)}else{// Content-Type is inferred (https://fetch.spec.whatwg.org/#dom-request)
i.body=n.formData}}return new Request(a,i)}function eG(e){let t=new URLSearchParams;for(let[r,n]of e.entries()){// https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#converting-an-entry-list-to-a-list-of-name-value-pairs
t.append(r,typeof n==="string"?n:n.name)}return t}function eK(e){let t=new FormData;for(let[r,n]of e.entries()){t.append(r,n)}return t}function eQ(e,t,r,n,a){// Fill in loaderData/errors from our loaders
let i={};let o=null;let s;let u=false;let c={};let f=r&&e9(r[1])?r[1].error:undefined;// Process loader results into state.loaderData/state.errors
e.forEach(r=>{if(!(r.route.id in t)){return}let d=r.route.id;let h=t[d];l(!te(h),"Cannot handle redirect results in processLoaderData");if(e9(h)){let t=h.error;// If we have a pending action error, we report it at the highest-route
// that throws a loader error, and then clear it out to indicate that
// it was consumed
if(f!==undefined){t=f;f=undefined}o=o||{};if(a){o[d]=t}else{// Look upwards from the matched route for the closest ancestor error
// boundary, defaulting to the root match.  Prefer higher error values
// if lower errors bubble to the same boundary
let r=e0(e,d);if(o[r.route.id]==null){o[r.route.id]=t}}// Clear our any prior loaderData for the throwing route
i[d]=undefined;// Once we find our first (highest) error, we set the status code and
// prevent deeper status codes from overriding
if(!u){u=true;s=ef(h.error)?h.error.status:500}if(h.headers){c[d]=h.headers}}else{if(e8(h)){n.set(d,h.deferredData);i[d]=h.deferredData.data;// Error status codes always override success status codes, but if all
// loaders are successful we take the deepest status code.
if(h.statusCode!=null&&h.statusCode!==200&&!u){s=h.statusCode}if(h.headers){c[d]=h.headers}}else{i[d]=h.data;// Error status codes always override success status codes, but if all
// loaders are successful we take the deepest status code.
if(h.statusCode&&h.statusCode!==200&&!u){s=h.statusCode}if(h.headers){c[d]=h.headers}}}});// If we didn't consume the pending action error (i.e., all loaders
// resolved), then consume it here.  Also clear out any loaderData for the
// throwing route
if(f!==undefined&&r){o={[r[0]]:f};i[r[0]]=undefined}return{loaderData:i,errors:o,statusCode:s||200,loaderHeaders:c}}function eX(e,t,r,a,i,o,s){let{loaderData:u,errors:c}=eQ(t,r,a,s,false// This method is only called client side so we always want to bubble
);// Process results from our revalidating fetchers
i.forEach(t=>{let{key:r,match:a,controller:i}=t;let s=o[r];l(s,"Did not find corresponding fetcher result");// Process fetcher non-redirect errors
if(i&&i.signal.aborted){// Nothing to do for aborted fetchers
return}else if(e9(s)){let t=e0(e.matches,a==null?void 0:a.route.id);if(!(c&&c[t.route.id])){c=n({},c,{[t.route.id]:s.error})}e.fetchers.delete(r)}else if(te(s)){// Should never get here, redirects should get processed above, but we
// keep this to type narrow to a success result in the else
l(false,"Unhandled fetcher revalidation redirect")}else if(e8(s)){// Should never get here, deferred data should be awaited for fetchers
// in resolveDeferredResults
l(false,"Unhandled fetcher deferred data")}else{let t=tg(s.data);e.fetchers.set(r,t)}});return{loaderData:u,errors:c}}function eJ(e,t,r,a){let i=n({},t);for(let n of r){let r=n.route.id;if(t.hasOwnProperty(r)){if(t[r]!==undefined){i[r]=t[r]}}else if(e[r]!==undefined&&n.route.loader){// Preserve existing keys not included in newLoaderData and where a loader
// wasn't removed by HMR
i[r]=e[r]}if(a&&a.hasOwnProperty(r)){break}}return i}function eZ(e){if(!e){return{}}return e9(e[1])?{// Clear out prior actionData on errors
actionData:{}}:{actionData:{[e[0]]:e[1].data}}}// Find the nearest error boundary, looking upwards from the leaf route (or the
// route specified by routeId) for the closest ancestor error boundary,
// defaulting to the root match
function e0(e,t){let r=t?e.slice(0,e.findIndex(e=>e.route.id===t)+1):[...e];return r.reverse().find(e=>e.route.hasErrorBoundary===true)||e[0]}function e1(e){// Prefer a root layout route if present, otherwise shim in a route object
let t=e.length===1?e[0]:e.find(e=>e.index||!e.path||e.path==="/")||{id:"__shim-error-route__"};return{matches:[{params:{},pathname:"",pathnameBase:"",route:t}],route:t}}function e2(e,t){let{pathname:r,routeId:n,method:a,type:i,message:o}=t===void 0?{}:t;let s="Unknown Server Error";let u="Unknown @remix-run/router error";if(e===400){s="Bad Request";if(a&&r&&n){u="You made a "+a+' request to "'+r+'" but '+('did not provide a `loader` for route "'+n+'", ')+"so there is no way to handle the request."}else if(i==="defer-action"){u="defer() is not supported in actions"}else if(i==="invalid-body"){u="Unable to encode submission body"}}else if(e===403){s="Forbidden";u='Route "'+n+'" does not match URL "'+r+'"'}else if(e===404){s="Not Found";u='No route matches URL "'+r+'"'}else if(e===405){s="Method Not Allowed";if(a&&r&&n){u="You made a "+a.toUpperCase()+' request to "'+r+'" but '+('did not provide an `action` for route "'+n+'", ')+"so there is no way to handle the request."}else if(a){u='Invalid request method "'+a.toUpperCase()+'"'}}return new ec(e||500,s,new Error(u),true)}// Find any returned redirect errors, starting from the lowest match
function e4(e){let t=Object.entries(e);for(let e=t.length-1;e>=0;e--){let[r,n]=t[e];if(te(n)){return{key:r,result:n}}}}function e6(e){let t=typeof e==="string"?v(e):e;return p(n({},t,{hash:""}))}function e5(e,t){if(e.pathname!==t.pathname||e.search!==t.search){return false}if(e.hash===""){// /page -> /page#hash
return t.hash!==""}else if(e.hash===t.hash){// /page#hash -> /page#hash
return true}else if(t.hash!==""){// /page#hash -> /page#other
return true}// If the hash is removed the browser will re-perform a request to the server
// /page#hash -> /page
return false}function e3(e){return e!=null&&typeof e==="object"&&"type"in e&&"result"in e&&(e.type===g.data||e.type===g.error)}function e7(e){return tn(e.result)&&em.has(e.result.status)}function e8(e){return e.type===g.deferred}function e9(e){return e.type===g.error}function te(e){return(e&&e.type)===g.redirect}function tt(e){return typeof e==="object"&&e!=null&&"type"in e&&"data"in e&&"init"in e&&e.type==="DataWithResponseInit"}function tr(e){let t=e;return t&&typeof t==="object"&&typeof t.data==="object"&&typeof t.subscribe==="function"&&typeof t.cancel==="function"&&typeof t.resolveData==="function"}function tn(e){return e!=null&&typeof e.status==="number"&&typeof e.statusText==="string"&&typeof e.headers==="object"&&typeof e.body!=="undefined"}function ta(e){if(!tn(e)){return false}let t=e.status;let r=e.headers.get("Location");return t>=300&&t<=399&&r!=null}function ti(e){return ev.has(e.toLowerCase())}function to(e){return eh.has(e.toLowerCase())}async function ts(e,t,r,n,a){let i=Object.entries(t);for(let o=0;o<i.length;o++){let[s,u]=i[o];let l=e.find(e=>(e==null?void 0:e.route.id)===s);// If we don't have a match, then we can have a deferred result to do
// anything with.  This is for revalidating fetchers where the route was
// removed during HMR
if(!l){continue}let c=n.find(e=>e.route.id===l.route.id);let f=c!=null&&!eL(c,l)&&(a&&a[l.route.id])!==undefined;if(e8(u)&&f){// Note: we do not have to touch activeDeferreds here since we race them
// against the signal in resolveDeferredData and they'll get aborted
// there if needed
await tl(u,r,false).then(e=>{if(e){t[s]=e}})}}}async function tu(e,t,r){for(let n=0;n<r.length;n++){let{key:a,routeId:i,controller:o}=r[n];let s=t[a];let u=e.find(e=>(e==null?void 0:e.route.id)===i);// If we don't have a match, then we can have a deferred result to do
// anything with.  This is for revalidating fetchers where the route was
// removed during HMR
if(!u){continue}if(e8(s)){// Note: we do not have to touch activeDeferreds here since we race them
// against the signal in resolveDeferredData and they'll get aborted
// there if needed
l(o,"Expected an AbortController for revalidating fetcher deferred result");await tl(s,o.signal,true).then(e=>{if(e){t[a]=e}})}}}async function tl(e,t,r){if(r===void 0){r=false}let n=await e.deferredData.resolveData(t);if(n){return}if(r){try{return{type:g.data,data:e.deferredData.unwrappedData}}catch(e){// Handle any TrackedPromise._error values encountered while unwrapping
return{type:g.error,error:e}}}return{type:g.data,data:e.deferredData.data}}function tc(e){return new URLSearchParams(e).getAll("index").some(e=>e==="")}function tf(e,t){let r=typeof t==="string"?v(t).search:t.search;if(e[e.length-1].route.index&&tc(r||"")){// Return the leaf index route when index is present
return e[e.length-1]}// Otherwise grab the deepest "path contributing" match (ignoring index and
// pathless layout routes)
let n=V(e);return n[n.length-1]}function td(e){let{formMethod:t,formAction:r,formEncType:n,text:a,formData:i,json:o}=e;if(!t||!r||!n){return}if(a!=null){return{formMethod:t,formAction:r,formEncType:n,formData:undefined,json:undefined,text:a}}else if(i!=null){return{formMethod:t,formAction:r,formEncType:n,formData:i,json:undefined,text:undefined}}else if(o!==undefined){return{formMethod:t,formAction:r,formEncType:n,formData:undefined,json:o,text:undefined}}}function th(e,t){if(t){let r={state:"loading",location:e,formMethod:t.formMethod,formAction:t.formAction,formEncType:t.formEncType,formData:t.formData,json:t.json,text:t.text};return r}else{let t={state:"loading",location:e,formMethod:undefined,formAction:undefined,formEncType:undefined,formData:undefined,json:undefined,text:undefined};return t}}function tp(e,t){let r={state:"submitting",location:e,formMethod:t.formMethod,formAction:t.formAction,formEncType:t.formEncType,formData:t.formData,json:t.json,text:t.text};return r}function tv(e,t){if(e){let r={state:"loading",formMethod:e.formMethod,formAction:e.formAction,formEncType:e.formEncType,formData:e.formData,json:e.json,text:e.text,data:t};return r}else{let e={state:"loading",formMethod:undefined,formAction:undefined,formEncType:undefined,formData:undefined,json:undefined,text:undefined,data:t};return e}}function tm(e,t){let r={state:"submitting",formMethod:e.formMethod,formAction:e.formAction,formEncType:e.formEncType,formData:e.formData,json:e.json,text:e.text,data:t?t.data:undefined};return r}function tg(e){let t={state:"idle",formMethod:undefined,formAction:undefined,formEncType:undefined,formData:undefined,json:undefined,text:undefined,data:e};return t}function tb(e,t){try{let r=e.sessionStorage.getItem(eE);if(r){let e=JSON.parse(r);for(let[r,n]of Object.entries(e||{})){if(n&&Array.isArray(n)){t.set(r,new Set(n||[]))}}}}catch(e){// no-op, use default empty object
}}function ty(e,t){if(t.size>0){let r={};for(let[e,n]of t){r[e]=[...n]}try{e.sessionStorage.setItem(eE,JSON.stringify(r))}catch(e){c(false,"Failed to save applied view transitions in sessionStorage ("+e+").")}}}//#endregion
//# sourceMappingURL=router.js.map
},4146:function(e,t,r){"use strict";var n=r(4363);/**
 * Copyright 2015, Yahoo! Inc.
 * Copyrights licensed under the New BSD License. See the accompanying LICENSE file for terms.
 */var a={childContextTypes:true,contextType:true,contextTypes:true,defaultProps:true,displayName:true,getDefaultProps:true,getDerivedStateFromError:true,getDerivedStateFromProps:true,mixins:true,propTypes:true,type:true};var i={name:true,length:true,prototype:true,caller:true,callee:true,arguments:true,arity:true};var o={"$$typeof":true,render:true,defaultProps:true,displayName:true,propTypes:true};var s={"$$typeof":true,compare:true,defaultProps:true,displayName:true,propTypes:true,type:true};var u={};u[n.ForwardRef]=o;u[n.Memo]=s;function l(e){// React v16.11 and below
if(n.isMemo(e)){return s}// React v16.12 and above
return u[e["$$typeof"]]||a}var c=Object.defineProperty;var f=Object.getOwnPropertyNames;var d=Object.getOwnPropertySymbols;var h=Object.getOwnPropertyDescriptor;var p=Object.getPrototypeOf;var v=Object.prototype;function m(e,t,r){if(typeof t!=="string"){// don't hoist over string (html) components
if(v){var n=p(t);if(n&&n!==v){m(e,n,r)}}var a=f(t);if(d){a=a.concat(d(t))}var o=l(e);var s=l(t);for(var u=0;u<a.length;++u){var g=a[u];if(!i[g]&&!(r&&r[g])&&!(s&&s[g])&&!(o&&o[g])){var b=h(t,g);try{// Avoid failures from read-only properties
c(e,g,b)}catch(e){}}}}return e}e.exports=m},5338:function(e,t,r){"use strict";var n=r(5206);if(true){t.createRoot=n.createRoot;t.hydrateRoot=n.hydrateRoot}else{var a}},2799:function(e,t){"use strict";/** @license React v16.13.1
 * react-is.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var r="function"===typeof Symbol&&Symbol.for,n=r?Symbol.for("react.element"):60103,a=r?Symbol.for("react.portal"):60106,i=r?Symbol.for("react.fragment"):60107,o=r?Symbol.for("react.strict_mode"):60108,s=r?Symbol.for("react.profiler"):60114,u=r?Symbol.for("react.provider"):60109,l=r?Symbol.for("react.context"):60110,c=r?Symbol.for("react.async_mode"):60111,f=r?Symbol.for("react.concurrent_mode"):60111,d=r?Symbol.for("react.forward_ref"):60112,h=r?Symbol.for("react.suspense"):60113,p=r?Symbol.for("react.suspense_list"):60120,v=r?Symbol.for("react.memo"):60115,m=r?Symbol.for("react.lazy"):60116,g=r?Symbol.for("react.block"):60121,b=r?Symbol.for("react.fundamental"):60117,y=r?Symbol.for("react.responder"):60118,w=r?Symbol.for("react.scope"):60119;function _(e){if("object"===typeof e&&null!==e){var t=e.$$typeof;switch(t){case n:switch(e=e.type,e){case c:case f:case i:case s:case o:case h:return e;default:switch(e=e&&e.$$typeof,e){case l:case d:case m:case v:case u:return e;default:return t}}case a:return t}}}function x(e){return _(e)===f}t.AsyncMode=c;t.ConcurrentMode=f;t.ContextConsumer=l;t.ContextProvider=u;t.Element=n;t.ForwardRef=d;t.Fragment=i;t.Lazy=m;t.Memo=v;t.Portal=a;t.Profiler=s;t.StrictMode=o;t.Suspense=h;t.isAsyncMode=function(e){return x(e)||_(e)===c};t.isConcurrentMode=x;t.isContextConsumer=function(e){return _(e)===l};t.isContextProvider=function(e){return _(e)===u};t.isElement=function(e){return"object"===typeof e&&null!==e&&e.$$typeof===n};t.isForwardRef=function(e){return _(e)===d};t.isFragment=function(e){return _(e)===i};t.isLazy=function(e){return _(e)===m};t.isMemo=function(e){return _(e)===v};t.isPortal=function(e){return _(e)===a};t.isProfiler=function(e){return _(e)===s};t.isStrictMode=function(e){return _(e)===o};t.isSuspense=function(e){return _(e)===h};t.isValidElementType=function(e){return"string"===typeof e||"function"===typeof e||e===i||e===f||e===s||e===o||e===h||e===p||"object"===typeof e&&null!==e&&(e.$$typeof===m||e.$$typeof===v||e.$$typeof===u||e.$$typeof===l||e.$$typeof===d||e.$$typeof===b||e.$$typeof===y||e.$$typeof===w||e.$$typeof===g)};t.typeOf=_},4363:function(e,t,r){"use strict";if(true){e.exports=r(2799)}else{}},7767:function(e,t,r){"use strict";r.d(t,{C5:()=>ed,Ix:()=>ev,V8:()=>eo,Ye:()=>k,Zp:()=>_,sv:()=>eh,zy:()=>m});/* ESM import */var n=r(1594);/* ESM import */var a=/*#__PURE__*/r.n(n);/* ESM import */var i=r(5588);/**
 * React Router v6.30.1
 *
 * Copyright (c) Remix Software Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.md file in the root directory of this source tree.
 *
 * @license MIT
 */function o(){o=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r){if(Object.prototype.hasOwnProperty.call(r,n)){e[n]=r[n]}}}return e};return o.apply(this,arguments)}// Create react-specific types from the agnostic types in @remix-run/router to
// export from react-router
const s=/*#__PURE__*/n.createContext(null);if(false){}const u=/*#__PURE__*/n.createContext(null);if(false){}const l=/*#__PURE__*/n.createContext(null);if(false){}/**
 * A Navigator is a "location changer"; it's how you get to different locations.
 *
 * Every history instance conforms to the Navigator interface, but the
 * distinction is useful primarily when it comes to the low-level `<Router>` API
 * where both the location and a navigator must be provided separately in order
 * to avoid "tearing" that may occur in a suspense-enabled app if the action
 * and/or location were to be read directly from the history instance.
 */const c=/*#__PURE__*/n.createContext(null);if(false){}const f=/*#__PURE__*/n.createContext(null);if(false){}const d=/*#__PURE__*/n.createContext({outlet:null,matches:[],isDataRoute:false});if(false){}const h=/*#__PURE__*/n.createContext(null);if(false){}/**
 * Returns the full href for the given "to" value. This is useful for building
 * custom links that are also accessible and preserve right-click behavior.
 *
 * @see https://reactrouter.com/v6/hooks/use-href
 */function p(e,t){let{relative:r}=t===void 0?{}:t;!v()?false?0:UNSAFE_invariant(false):void 0;let{basename:n,navigator:a}=React.useContext(c);let{hash:i,pathname:o,search:s}=T(e,{relative:r});let u=o;// If we're operating within a basename, prepend it to the pathname prior
// to creating the href.  If this is a root navigation, then just use the raw
// basename which allows the basename to have full control over the presence
// of a trailing slash on root links
if(n!=="/"){u=o==="/"?n:joinPaths([n,o])}return a.createHref({pathname:u,search:s,hash:i})}/**
 * Returns true if this component is a descendant of a `<Router>`.
 *
 * @see https://reactrouter.com/v6/hooks/use-in-router-context
 */function v(){return n.useContext(f)!=null}/**
 * Returns the current location object, which represents the current URL in web
 * browsers.
 *
 * Note: If you're using this it may mean you're doing some of your own
 * "routing" in your app, and we'd like to know what your use case is. We may
 * be able to provide something higher-level to better suit your needs.
 *
 * @see https://reactrouter.com/v6/hooks/use-location
 */function m(){!v()?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;return n.useContext(f).location}/**
 * Returns the current navigation action which describes how the router came to
 * the current location, either by a pop, push, or replace on the history stack.
 *
 * @see https://reactrouter.com/v6/hooks/use-navigation-type
 */function g(){return React.useContext(f).navigationType}/**
 * Returns a PathMatch object if the given pattern matches the current URL.
 * This is useful for components that need to know "active" state, e.g.
 * `<NavLink>`.
 *
 * @see https://reactrouter.com/v6/hooks/use-match
 */function b(e){!v()?false?0:UNSAFE_invariant(false):void 0;let{pathname:t}=m();return React.useMemo(()=>matchPath(e,UNSAFE_decodePath(t)),[t,e])}/**
 * The interface for the navigate() function returned from useNavigate().
 */const y=/* unused pure expression or super */null&&"You should call navigate() in a React.useEffect(), not when "+"your component is first rendered.";// Mute warnings for calls to useNavigate in SSR environments
function w(e){let t=n.useContext(c).static;if(!t){// We should be able to get rid of this once react 18.3 is released
// See: https://github.com/facebook/react/pull/26395
// eslint-disable-next-line react-hooks/rules-of-hooks
n.useLayoutEffect(e)}}/**
 * Returns an imperative method for changing the location. Used by `<Link>`s, but
 * may also be used by other elements to change the location.
 *
 * @see https://reactrouter.com/v6/hooks/use-navigate
 */function _(){let{isDataRoute:e}=n.useContext(d);// Conditional usage is OK here because the usage of a data router is static
// eslint-disable-next-line react-hooks/rules-of-hooks
return e?ee():x()}function x(){!v()?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;let e=n.useContext(s);let{basename:t,future:r,navigator:a}=n.useContext(c);let{matches:o}=n.useContext(d);let{pathname:u}=m();let l=JSON.stringify((0,i/* .UNSAFE_getResolveToMatches */.yD)(o,r.v7_relativeSplatPath));let f=n.useRef(false);w(()=>{f.current=true});let h=n.useCallback(function(r,n){if(n===void 0){n={}}false?0:void 0;// Short circuit here since if this happens on first render the navigate
// is useless because we haven't wired up our history listener yet
if(!f.current)return;if(typeof r==="number"){a.go(r);return}let o=(0,i/* .resolveTo */.Gh)(r,JSON.parse(l),u,n.relative==="path");// If we're operating within a basename, prepend it to the pathname prior
// to handing off to history (but only if we're not in a data router,
// otherwise it'll prepend the basename inside of the router).
// If this is a root navigation, then we navigate to the raw basename
// which allows the basename to have full control over the presence of a
// trailing slash on root links
if(e==null&&t!=="/"){o.pathname=o.pathname==="/"?t:(0,i/* .joinPaths */.HS)([t,o.pathname])}(!!n.replace?a.replace:a.push)(o,n.state,n)},[t,a,l,u,e]);return h}const E=/*#__PURE__*/n.createContext(null);/**
 * Returns the context (if provided) for the child route at this level of the route
 * hierarchy.
 * @see https://reactrouter.com/v6/hooks/use-outlet-context
 */function O(){return React.useContext(E)}/**
 * Returns the element for the child route at this level of the route
 * hierarchy. Used internally by `<Outlet>` to render child routes.
 *
 * @see https://reactrouter.com/v6/hooks/use-outlet
 */function S(e){let t=n.useContext(d).outlet;if(t){return /*#__PURE__*/n.createElement(E.Provider,{value:e},t)}return t}/**
 * Returns an object of key/value pairs of the dynamic params from the current
 * URL that were matched by the route path.
 *
 * @see https://reactrouter.com/v6/hooks/use-params
 */function A(){let{matches:e}=React.useContext(d);let t=e[e.length-1];return t?t.params:{}}/**
 * Resolves the pathname of the given `to` value against the current location.
 *
 * @see https://reactrouter.com/v6/hooks/use-resolved-path
 */function T(e,t){let{relative:r}=t===void 0?{}:t;let{future:n}=React.useContext(c);let{matches:a}=React.useContext(d);let{pathname:i}=m();let o=JSON.stringify(UNSAFE_getResolveToMatches(a,n.v7_relativeSplatPath));return React.useMemo(()=>resolveTo(e,JSON.parse(o),i,r==="path"),[e,o,i,r])}/**
 * Returns the element of the route that matched the current location, prepared
 * with the correct context to render the remainder of the route tree. Route
 * elements in the tree must render an `<Outlet>` to render their child route's
 * element.
 *
 * @see https://reactrouter.com/v6/hooks/use-routes
 */function k(e,t){return R(e,t)}// Internal implementation with accept optional param for RouterProvider usage
function R(e,t,r,a){!v()?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;let{navigator:s}=n.useContext(c);let{matches:u}=n.useContext(d);let l=u[u.length-1];let h=l?l.params:{};let p=l?l.pathname:"/";let g=l?l.pathnameBase:"/";let b=l&&l.route;if(false){}let y=m();let w;if(t){var _;let e=typeof t==="string"?(0,i/* .parsePath */.Rr)(t):t;!(g==="/"||((_=e.pathname)==null?void 0:_.startsWith(g)))?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;w=e}else{w=y}let x=w.pathname||"/";let E=x;if(g!=="/"){// Determine the remaining pathname by removing the # of URL segments the
// parentPathnameBase has, instead of removing based on character count.
// This is because we can't guarantee that incoming/outgoing encodings/
// decodings will match exactly.
// We decode paths before matching on a per-segment basis with
// decodeURIComponent(), but we re-encode pathnames via `new URL()` so they
// match what `window.location.pathname` would reflect.  Those don't 100%
// align when it comes to encoded URI characters such as % and &.
//
// So we may end up with:
//   pathname:           "/descendant/a%25b/match"
//   parentPathnameBase: "/descendant/a%b"
//
// And the direct substring removal approach won't work :/
let e=g.replace(/^\//,"").split("/");let t=x.replace(/^\//,"").split("/");E="/"+t.slice(e.length).join("/")}let O=(0,i/* .matchRoutes */.ue)(e,{pathname:E});if(false){}let S=M(O&&O.map(e=>Object.assign({},e,{params:Object.assign({},h,e.params),pathname:(0,i/* .joinPaths */.HS)([g,// Re-encode pathnames that were decoded inside matchRoutes
    s.encodeLocation?s.encodeLocation(e.pathname).pathname:e.pathname]),pathnameBase:e.pathnameBase==="/"?g:(0,i/* .joinPaths */.HS)([g,// Re-encode pathnames that were decoded inside matchRoutes
    s.encodeLocation?s.encodeLocation(e.pathnameBase).pathname:e.pathnameBase])})),u,r,a);// When a user passes in a `locationArg`, the associated routes need to
// be wrapped in a new `LocationContext.Provider` in order for `useLocation`
// to use the scoped location instead of the global location.
if(t&&S){return /*#__PURE__*/n.createElement(f.Provider,{value:{location:o({pathname:"/",search:"",hash:"",state:null,key:"default"},w),navigationType:i/* .Action.Pop */.rc.Pop}},S)}return S}function C(){let e=K();let t=(0,i/* .isRouteErrorResponse */.pX)(e)?e.status+" "+e.statusText:e instanceof Error?e.message:JSON.stringify(e);let r=e instanceof Error?e.stack:null;let a="rgba(200,200,200, 0.5)";let o={padding:"0.5rem",backgroundColor:a};let s={padding:"2px 4px",backgroundColor:a};let u=null;if(false){}return /*#__PURE__*/n.createElement(n.Fragment,null,/*#__PURE__*/n.createElement("h2",null,"Unexpected Application Error!"),/*#__PURE__*/n.createElement("h3",{style:{fontStyle:"italic"}},t),r?/*#__PURE__*/n.createElement("pre",{style:o},r):null,u)}const P=/*#__PURE__*/n.createElement(C,null);class I extends n.Component{constructor(e){super(e);this.state={location:e.location,revalidation:e.revalidation,error:e.error}}static getDerivedStateFromError(e){return{error:e}}static getDerivedStateFromProps(e,t){// When we get into an error state, the user will likely click "back" to the
// previous page that didn't have an error. Because this wraps the entire
// application, that will have no effect--the error page continues to display.
// This gives us a mechanism to recover from the error when the location changes.
//
// Whether we're in an error state or not, we update the location in state
// so that when we are in an error state, it gets reset when a new location
// comes in and the user recovers from the error.
if(t.location!==e.location||t.revalidation!=="idle"&&e.revalidation==="idle"){return{error:e.error,location:e.location,revalidation:e.revalidation}}// If we're not changing locations, preserve the location but still surface
// any new errors that may come through. We retain the existing error, we do
// this because the error provided from the app state may be cleared without
// the location changing.
return{error:e.error!==undefined?e.error:t.error,location:t.location,revalidation:e.revalidation||t.revalidation}}componentDidCatch(e,t){console.error("React Router caught the following error during render",e,t)}render(){return this.state.error!==undefined?/*#__PURE__*/n.createElement(d.Provider,{value:this.props.routeContext},/*#__PURE__*/n.createElement(h.Provider,{value:this.state.error,children:this.props.component})):this.props.children}}function D(e){let{routeContext:t,match:r,children:a}=e;let i=n.useContext(s);// Track how deep we got in our render pass to emulate SSR componentDidCatch
// in a DataStaticRouter
if(i&&i.static&&i.staticContext&&(r.route.errorElement||r.route.ErrorBoundary)){i.staticContext._deepestRenderedBoundaryId=r.route.id}return /*#__PURE__*/n.createElement(d.Provider,{value:t},a)}function M(e,t,r,a){var o;if(t===void 0){t=[]}if(r===void 0){r=null}if(a===void 0){a=null}if(e==null){var s;if(!r){return null}if(r.errors){// Don't bail if we have data router errors so we can render them in the
// boundary.  Use the pre-matched (or shimmed) matches
e=r.matches}else if((s=a)!=null&&s.v7_partialHydration&&t.length===0&&!r.initialized&&r.matches.length>0){// Don't bail if we're initializing with partial hydration and we have
// router matches.  That means we're actively running `patchRoutesOnNavigation`
// so we should render down the partial matches to the appropriate
// `HydrateFallback`.  We only do this if `parentMatches` is empty so it
// only impacts the root matches for `RouterProvider` and no descendant
// `<Routes>`
e=r.matches}else{return null}}let u=e;// If we have data errors, trim matches to the highest error boundary
let l=(o=r)==null?void 0:o.errors;if(l!=null){let e=u.findIndex(e=>e.route.id&&(l==null?void 0:l[e.route.id])!==undefined);!(e>=0)?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;u=u.slice(0,Math.min(u.length,e+1))}// If we're in a partial hydration mode, detect if we need to render down to
// a given HydrateFallback while we load the rest of the hydration data
let c=false;let f=-1;if(r&&a&&a.v7_partialHydration){for(let e=0;e<u.length;e++){let t=u[e];// Track the deepest fallback up until the first route without data
if(t.route.HydrateFallback||t.route.hydrateFallbackElement){f=e}if(t.route.id){let{loaderData:e,errors:n}=r;let a=t.route.loader&&e[t.route.id]===undefined&&(!n||n[t.route.id]===undefined);if(t.route.lazy||a){// We found the first route that's not ready to render (waiting on
// lazy, or has a loader that hasn't run yet).  Flag that we need to
// render a fallback and render up until the appropriate fallback
c=true;if(f>=0){u=u.slice(0,f+1)}else{u=[u[0]]}break}}}}return u.reduceRight((e,a,i)=>{// Only data routers handle errors/fallbacks
let o;let s=false;let d=null;let h=null;if(r){o=l&&a.route.id?l[a.route.id]:undefined;d=a.route.errorElement||P;if(c){if(f<0&&i===0){er("route-fallback",false,"No `HydrateFallback` element provided to render during initial hydration");s=true;h=null}else if(f===i){s=true;h=a.route.hydrateFallbackElement||null}}}let p=t.concat(u.slice(0,i+1));let v=()=>{let t;if(o){t=d}else if(s){t=h}else if(a.route.Component){// Note: This is a de-optimized path since React won't re-use the
// ReactElement since it's identity changes with each new
// React.createElement call.  We keep this so folks can use
// `<Route Component={...}>` in `<Routes>` but generally `Component`
// usage is only advised in `RouterProvider` when we can convert it to
// `element` ahead of time.
t=/*#__PURE__*/n.createElement(a.route.Component,null)}else if(a.route.element){t=a.route.element}else{t=e}return /*#__PURE__*/n.createElement(D,{match:a,routeContext:{outlet:e,matches:p,isDataRoute:r!=null},children:t})};// Only wrap in an error boundary within data router usages when we have an
// ErrorBoundary/errorElement on this route.  Otherwise let it bubble up to
// an ancestor ErrorBoundary/errorElement
return r&&(a.route.ErrorBoundary||a.route.errorElement||i===0)?/*#__PURE__*/n.createElement(I,{location:r.location,revalidation:r.revalidation,component:d,error:o,children:v(),routeContext:{outlet:null,matches:p,isDataRoute:true}}):v()},null)}var F=/*#__PURE__*/function(e){e["UseBlocker"]="useBlocker";e["UseRevalidator"]="useRevalidator";e["UseNavigateStable"]="useNavigate";return e}(F||{});var L=/*#__PURE__*/function(e){e["UseBlocker"]="useBlocker";e["UseLoaderData"]="useLoaderData";e["UseActionData"]="useActionData";e["UseRouteError"]="useRouteError";e["UseNavigation"]="useNavigation";e["UseRouteLoaderData"]="useRouteLoaderData";e["UseMatches"]="useMatches";e["UseRevalidator"]="useRevalidator";e["UseNavigateStable"]="useNavigate";e["UseRouteId"]="useRouteId";return e}(L||{});function N(e){return e+" must be used within a data router.  See https://reactrouter.com/v6/routers/picking-a-router."}function j(e){let t=n.useContext(s);!t?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;return t}function U(e){let t=n.useContext(u);!t?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;return t}function H(e){let t=n.useContext(d);!t?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;return t}// Internal version with hookName-aware debugging
function B(e){let t=H(e);let r=t.matches[t.matches.length-1];!r.route.id?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;return r.route.id}/**
 * Returns the ID for the nearest contextual route
 */function Y(){return B(L.UseRouteId)}/**
 * Returns the current navigation, defaulting to an "idle" navigation when
 * no navigation is in progress
 */function z(){let e=U(L.UseNavigation);return e.navigation}/**
 * Returns a revalidate function for manually triggering revalidation, as well
 * as the current state of any manual revalidations
 */function q(){let e=j(F.UseRevalidator);let t=U(L.UseRevalidator);return React.useMemo(()=>({revalidate:e.router.revalidate,state:t.revalidation}),[e.router.revalidate,t.revalidation])}/**
 * Returns the active route matches, useful for accessing loaderData for
 * parent/child routes or the route "handle" property
 */function V(){let{matches:e,loaderData:t}=U(L.UseMatches);return React.useMemo(()=>e.map(e=>UNSAFE_convertRouteMatchToUiMatch(e,t)),[e,t])}/**
 * Returns the loader data for the nearest ancestor Route loader
 */function W(){let e=U(L.UseLoaderData);let t=B(L.UseLoaderData);if(e.errors&&e.errors[t]!=null){console.error("You cannot `useLoaderData` in an errorElement (routeId: "+t+")");return undefined}return e.loaderData[t]}/**
 * Returns the loaderData for the given routeId
 */function $(e){let t=U(L.UseRouteLoaderData);return t.loaderData[e]}/**
 * Returns the action data for the nearest ancestor Route action
 */function G(){let e=U(L.UseActionData);let t=B(L.UseLoaderData);return e.actionData?e.actionData[t]:undefined}/**
 * Returns the nearest ancestor Route error, which could be a loader/action
 * error or a render error.  This is intended to be called from your
 * ErrorBoundary/errorElement to display a proper error message.
 */function K(){var e;let t=n.useContext(h);let r=U(L.UseRouteError);let a=B(L.UseRouteError);// If this was a render error, we put it in a RouteError context inside
// of RenderErrorBoundary
if(t!==undefined){return t}// Otherwise look for errors from our data router state
return(e=r.errors)==null?void 0:e[a]}/**
 * Returns the happy-path data from the nearest ancestor `<Await />` value
 */function Q(){let e=React.useContext(l);return e==null?void 0:e._data}/**
 * Returns the error from the nearest ancestor `<Await />` value
 */function X(){let e=React.useContext(l);return e==null?void 0:e._error}let J=0;/**
 * Allow the application to block navigations within the SPA and present the
 * user a confirmation dialog to confirm the navigation.  Mostly used to avoid
 * using half-filled form data.  This does not handle hard-reloads or
 * cross-origin navigations.
 */function Z(e){let{router:t,basename:r}=j(F.UseBlocker);let n=U(L.UseBlocker);let[a,i]=React.useState("");let s=React.useCallback(t=>{if(typeof e!=="function"){return!!e}if(r==="/"){return e(t)}// If they provided us a function and we've got an active basename, strip
// it from the locations we expose to the user to match the behavior of
// useLocation
let{currentLocation:n,nextLocation:a,historyAction:i}=t;return e({currentLocation:o({},n,{pathname:stripBasename(n.pathname,r)||n.pathname}),nextLocation:o({},a,{pathname:stripBasename(a.pathname,r)||a.pathname}),historyAction:i})},[r,e]);// This effect is in charge of blocker key assignment and deletion (which is
// tightly coupled to the key)
React.useEffect(()=>{let e=String(++J);i(e);return()=>t.deleteBlocker(e)},[t]);// This effect handles assigning the blockerFunction.  This is to handle
// unstable blocker function identities, and happens only after the prior
// effect so we don't get an orphaned blockerFunction in the router with a
// key of "".  Until then we just have the IDLE_BLOCKER.
React.useEffect(()=>{if(a!==""){t.getBlocker(a,s)}},[t,a,s]);// Prefer the blocker from `state` not `router.state` since DataRouterContext
// is memoized so this ensures we update on blocker state updates
return a&&n.blockers.has(a)?n.blockers.get(a):IDLE_BLOCKER}/**
 * Stable version of useNavigate that is used when we are in the context of
 * a RouterProvider.
 */function ee(){let{router:e}=j(F.UseNavigateStable);let t=B(L.UseNavigateStable);let r=n.useRef(false);w(()=>{r.current=true});let a=n.useCallback(function(n,a){if(a===void 0){a={}}false?0:void 0;// Short circuit here since if this happens on first render the navigate
// is useless because we haven't wired up our router subscriber yet
if(!r.current)return;if(typeof n==="number"){e.navigate(n)}else{e.navigate(n,o({fromRouteId:t},a))}},[e,t]);return a}const et={};function er(e,t,r){if(!t&&!et[e]){et[e]=true;false?0:void 0}}const en=/* unused pure expression or super */null&&{};function ea(e,t){if(false){}}const ei=(e,t,r)=>ea(e,"⚠️ React Router Future Flag Warning: "+t+". "+("You can use the `"+e+"` future flag to opt-in early. ")+("For more information, see "+r+"."));function eo(e,t){if((e==null?void 0:e.v7_startTransition)===undefined){ei("v7_startTransition","React Router will begin wrapping state updates in `React.startTransition` in v7","https://reactrouter.com/v6/upgrading/future#v7_starttransition")}if((e==null?void 0:e.v7_relativeSplatPath)===undefined&&(!t||t.v7_relativeSplatPath===undefined)){ei("v7_relativeSplatPath","Relative route resolution within Splat routes is changing in v7","https://reactrouter.com/v6/upgrading/future#v7_relativesplatpath")}if(t){if(t.v7_fetcherPersist===undefined){ei("v7_fetcherPersist","The persistence behavior of fetchers is changing in v7","https://reactrouter.com/v6/upgrading/future#v7_fetcherpersist")}if(t.v7_normalizeFormMethod===undefined){ei("v7_normalizeFormMethod","Casing of `formMethod` fields is being normalized to uppercase in v7","https://reactrouter.com/v6/upgrading/future#v7_normalizeformmethod")}if(t.v7_partialHydration===undefined){ei("v7_partialHydration","`RouterProvider` hydration behavior is changing in v7","https://reactrouter.com/v6/upgrading/future#v7_partialhydration")}if(t.v7_skipActionErrorRevalidation===undefined){ei("v7_skipActionErrorRevalidation","The revalidation behavior after 4xx/5xx `action` responses is changing in v7","https://reactrouter.com/v6/upgrading/future#v7_skipactionerrorrevalidation")}}}/**
  Webpack + React 17 fails to compile on any of the following because webpack
  complains that `startTransition` doesn't exist in `React`:
  * import { startTransition } from "react"
  * import * as React from from "react";
    "startTransition" in React ? React.startTransition(() => setState()) : setState()
  * import * as React from from "react";
    "startTransition" in React ? React["startTransition"](() => setState()) : setState()

  Moving it to a constant such as the following solves the Webpack/React 17 issue:
  * import * as React from from "react";
    const START_TRANSITION = "startTransition";
    START_TRANSITION in React ? React[START_TRANSITION](() => setState()) : setState()

  However, that introduces webpack/terser minification issues in production builds
  in React 18 where minification/obfuscation ends up removing the call of
  React.startTransition entirely from the first half of the ternary.  Grabbing
  this exported reference once up front resolves that issue.

  See https://github.com/remix-run/react-router/issues/10579
*/const es="startTransition";const eu=n[es];/**
 * Given a Remix Router instance, render the appropriate UI
 */function el(e){let{fallbackElement:t,router:r,future:n}=e;let[a,i]=React.useState(r.state);let{v7_startTransition:o}=n||{};let l=React.useCallback(e=>{if(o&&eu){eu(()=>i(e))}else{i(e)}},[i,o]);// Need to use a layout effect here so we are subscribed early enough to
// pick up on any render-driven redirects/navigations (useEffect/<Navigate>)
React.useLayoutEffect(()=>r.subscribe(l),[r,l]);React.useEffect(()=>{false?0:void 0;// Only log this once on initial mount
// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);let c=React.useMemo(()=>{return{createHref:r.createHref,encodeLocation:r.encodeLocation,go:e=>r.navigate(e),push:(e,t,n)=>r.navigate(e,{state:t,preventScrollReset:n==null?void 0:n.preventScrollReset}),replace:(e,t,n)=>r.navigate(e,{replace:true,state:t,preventScrollReset:n==null?void 0:n.preventScrollReset})}},[r]);let f=r.basename||"/";let d=React.useMemo(()=>({router:r,navigator:c,static:false,basename:f}),[r,c,f]);React.useEffect(()=>eo(n,r.future),[r,n]);// The fragment and {null} here are important!  We need them to keep React 18's
// useId happy when we are server-rendering since we may have a <script> here
// containing the hydrated server-side staticContext (from StaticRouterProvider).
// useId relies on the component tree structure to generate deterministic id's
// so we need to ensure it remains the same on the client even though
// we don't need the <script> tag
return /*#__PURE__*/React.createElement(React.Fragment,null,/*#__PURE__*/React.createElement(s.Provider,{value:d},/*#__PURE__*/React.createElement(u.Provider,{value:a},/*#__PURE__*/React.createElement(ev,{basename:f,location:a.location,navigationType:a.historyAction,navigator:c,future:{v7_relativeSplatPath:r.future.v7_relativeSplatPath}},a.initialized||r.future.v7_partialHydration?/*#__PURE__*/React.createElement(ec,{routes:r.routes,future:r.future,state:a}):t))),null)}function ec(e){let{routes:t,future:r,state:n}=e;return R(t,undefined,n,r)}/**
 * A `<Router>` that stores all entries in memory.
 *
 * @see https://reactrouter.com/v6/router-components/memory-router
 */function ef(e){let{basename:t,children:r,initialEntries:n,initialIndex:a,future:i}=e;let o=React.useRef();if(o.current==null){o.current=createMemoryHistory({initialEntries:n,initialIndex:a,v5Compat:true})}let s=o.current;let[u,l]=React.useState({action:s.action,location:s.location});let{v7_startTransition:c}=i||{};let f=React.useCallback(e=>{c&&eu?eu(()=>l(e)):l(e)},[l,c]);React.useLayoutEffect(()=>s.listen(f),[s,f]);React.useEffect(()=>eo(i),[i]);return /*#__PURE__*/React.createElement(ev,{basename:t,children:r,location:u.location,navigationType:u.action,navigator:s,future:i})}/**
 * Changes the current location.
 *
 * Note: This API is mostly useful in React.Component subclasses that are not
 * able to use hooks. In functional components, we recommend you use the
 * `useNavigate` hook instead.
 *
 * @see https://reactrouter.com/v6/components/navigate
 */function ed(e){let{to:t,replace:r,state:a,relative:o}=e;!v()?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;let{future:s,static:u}=n.useContext(c);false?0:void 0;let{matches:l}=n.useContext(d);let{pathname:f}=m();let h=_();// Resolve the path outside of the effect so that when effects run twice in
// StrictMode they navigate to the same place
let p=(0,i/* .resolveTo */.Gh)(t,(0,i/* .UNSAFE_getResolveToMatches */.yD)(l,s.v7_relativeSplatPath),f,o==="path");let g=JSON.stringify(p);n.useEffect(()=>h(JSON.parse(g),{replace:r,state:a,relative:o}),[h,g,o,r,a]);return null}/**
 * Renders the child route's element, if there is one.
 *
 * @see https://reactrouter.com/v6/components/outlet
 */function eh(e){return S(e.context)}/**
 * Declares an element that should be rendered at a certain URL path.
 *
 * @see https://reactrouter.com/v6/components/route
 */function ep(e){false?0:UNSAFE_invariant(false)}/**
 * Provides location context for the rest of the app.
 *
 * Note: You usually won't render a `<Router>` directly. Instead, you'll render a
 * router that is more specific to your environment such as a `<BrowserRouter>`
 * in web browsers or a `<StaticRouter>` for server rendering.
 *
 * @see https://reactrouter.com/v6/router-components/router
 */function ev(e){let{basename:t="/",children:r=null,location:a,navigationType:s=i/* .Action.Pop */.rc.Pop,navigator:u,static:l=false,future:d}=e;!!v()?false?0:(0,i/* .UNSAFE_invariant */.Oi)(false):void 0;// Preserve trailing slashes on basename, so we can let the user control
// the enforcement of trailing slashes throughout the app
let h=t.replace(/^\/*/,"/");let p=n.useMemo(()=>({basename:h,navigator:u,static:l,future:o({v7_relativeSplatPath:false},d)}),[h,d,u,l]);if(typeof a==="string"){a=(0,i/* .parsePath */.Rr)(a)}let{pathname:m="/",search:g="",hash:b="",state:y=null,key:w="default"}=a;let _=n.useMemo(()=>{let e=(0,i/* .stripBasename */.pb)(m,h);if(e==null){return null}return{location:{pathname:e,search:g,hash:b,state:y,key:w},navigationType:s}},[h,m,g,b,y,w,s]);false?0:void 0;if(_==null){return null}return /*#__PURE__*/n.createElement(c.Provider,{value:p},/*#__PURE__*/n.createElement(f.Provider,{children:r,value:_}))}/**
 * A container for a nested tree of `<Route>` elements that renders the branch
 * that best matches the current location.
 *
 * @see https://reactrouter.com/v6/components/routes
 */function em(e){let{children:t,location:r}=e;return k(ex(t),r)}/**
 * Component to use for rendering lazily loaded data from returning defer()
 * in a loader function
 */function eg(e){let{children:t,errorElement:r,resolve:n}=e;return /*#__PURE__*/React.createElement(ew,{resolve:n,errorElement:r},/*#__PURE__*/React.createElement(e_,null,t))}var eb=/*#__PURE__*/function(e){e[e["pending"]=0]="pending";e[e["success"]=1]="success";e[e["error"]=2]="error";return e}(eb||{});const ey=new Promise(()=>{});class ew extends n.Component{constructor(e){super(e);this.state={error:null}}static getDerivedStateFromError(e){return{error:e}}componentDidCatch(e,t){console.error("<Await> caught the following error during render",e,t)}render(){let{children:e,errorElement:t,resolve:r}=this.props;let a=null;let o=eb.pending;if(!(r instanceof Promise)){// Didn't get a promise - provide as a resolved promise
o=eb.success;a=Promise.resolve();Object.defineProperty(a,"_tracked",{get:()=>true});Object.defineProperty(a,"_data",{get:()=>r})}else if(this.state.error){// Caught a render error, provide it as a rejected promise
o=eb.error;let e=this.state.error;a=Promise.reject().catch(()=>{});// Avoid unhandled rejection warnings
Object.defineProperty(a,"_tracked",{get:()=>true});Object.defineProperty(a,"_error",{get:()=>e})}else if(r._tracked){// Already tracked promise - check contents
a=r;o="_error"in a?eb.error:"_data"in a?eb.success:eb.pending}else{// Raw (untracked) promise - track it
o=eb.pending;Object.defineProperty(r,"_tracked",{get:()=>true});a=r.then(e=>Object.defineProperty(r,"_data",{get:()=>e}),e=>Object.defineProperty(r,"_error",{get:()=>e}))}if(o===eb.error&&a._error instanceof i/* .AbortedDeferredError */.tH){// Freeze the UI by throwing a never resolved promise
throw ey}if(o===eb.error&&!t){// No errorElement, throw to the nearest route-level error boundary
throw a._error}if(o===eb.error){// Render via our errorElement
return /*#__PURE__*/n.createElement(l.Provider,{value:a,children:t})}if(o===eb.success){// Render children with resolved value
return /*#__PURE__*/n.createElement(l.Provider,{value:a,children:e})}// Throw to the suspense boundary
throw a}}/**
 * @private
 * Indirection to leverage useAsyncValue for a render-prop API on `<Await>`
 */function e_(e){let{children:t}=e;let r=Q();let n=typeof t==="function"?t(r):t;return /*#__PURE__*/React.createElement(React.Fragment,null,n)}///////////////////////////////////////////////////////////////////////////////
// UTILS
///////////////////////////////////////////////////////////////////////////////
/**
 * Creates a route config from a React "children" object, which is usually
 * either a `<Route>` element or an array of them. Used internally by
 * `<Routes>` to create a route config from its children.
 *
 * @see https://reactrouter.com/v6/utils/create-routes-from-children
 */function ex(e,t){if(t===void 0){t=[]}let r=[];React.Children.forEach(e,(e,n)=>{if(!/*#__PURE__*/React.isValidElement(e)){// Ignore non-elements. This allows people to more easily inline
// conditionals in their route config.
return}let a=[...t,n];if(e.type===React.Fragment){// Transparently support React.Fragment and its children.
r.push.apply(r,ex(e.props.children,a));return}!(e.type===ep)?false?0:UNSAFE_invariant(false):void 0;!(!e.props.index||!e.props.children)?false?0:UNSAFE_invariant(false):void 0;let i={id:e.props.id||a.join("-"),caseSensitive:e.props.caseSensitive,element:e.props.element,Component:e.props.Component,index:e.props.index,path:e.props.path,loader:e.props.loader,action:e.props.action,errorElement:e.props.errorElement,ErrorBoundary:e.props.ErrorBoundary,hasErrorBoundary:e.props.ErrorBoundary!=null||e.props.errorElement!=null,shouldRevalidate:e.props.shouldRevalidate,handle:e.props.handle,lazy:e.props.lazy};if(e.props.children){i.children=ex(e.props.children,a)}r.push(i)});return r}/**
 * Renders the result of `matchRoutes()` into a React element.
 */function eE(e){return M(e)}function eO(e){let t={// Note: this check also occurs in createRoutesFromChildren so update
// there if you change this -- please and thank you!
hasErrorBoundary:e.ErrorBoundary!=null||e.errorElement!=null};if(e.Component){if(false){}Object.assign(t,{element:/*#__PURE__*/React.createElement(e.Component),Component:undefined})}if(e.HydrateFallback){if(false){}Object.assign(t,{hydrateFallbackElement:/*#__PURE__*/React.createElement(e.HydrateFallback),HydrateFallback:undefined})}if(e.ErrorBoundary){if(false){}Object.assign(t,{errorElement:/*#__PURE__*/React.createElement(e.ErrorBoundary),ErrorBoundary:undefined})}return t}function eS(e,t){return createRouter({basename:t==null?void 0:t.basename,future:o({},t==null?void 0:t.future,{v7_prependBasename:true}),history:createMemoryHistory({initialEntries:t==null?void 0:t.initialEntries,initialIndex:t==null?void 0:t.initialIndex}),hydrationData:t==null?void 0:t.hydrationData,routes:e,mapRouteProperties:eO,dataStrategy:t==null?void 0:t.dataStrategy,patchRoutesOnNavigation:t==null?void 0:t.patchRoutesOnNavigation}).initialize()}//# sourceMappingURL=index.js.map
},1020:function(e,t,r){"use strict";/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var n=r(1594),a=Symbol.for("react.element"),i=Symbol.for("react.fragment"),o=Object.prototype.hasOwnProperty,s=n.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,u={key:!0,ref:!0,__self:!0,__source:!0};function l(e,t,r){var n,i={},l=null,c=null;void 0!==r&&(l=""+r);void 0!==t.key&&(l=""+t.key);void 0!==t.ref&&(c=t.ref);for(n in t)o.call(t,n)&&!u.hasOwnProperty(n)&&(i[n]=t[n]);if(e&&e.defaultProps)for(n in t=e.defaultProps,t)void 0===i[n]&&(i[n]=t[n]);return{$$typeof:a,type:e,key:l,ref:c,props:i,_owner:s.current}}t.Fragment=i;t.jsx=l;t.jsxs=l},4848:function(e,t,r){"use strict";if(true){e.exports=r(1020)}else{}},4131:function(e,t){/*!
 * CSSJanus. https://www.mediawiki.org/wiki/CSSJanus
 *
 * Copyright 2014 Trevor Parscal
 * Copyright 2010 Roan Kattouw
 * Copyright 2008 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */var r;/**
 * Create a tokenizer object.
 *
 * This utility class is used by CSSJanus to protect strings by replacing them temporarily with
 * tokens and later transforming them back.
 *
 * @class
 * @constructor
 * @param {RegExp} regex Regular expression whose matches to replace by a token
 * @param {string} token Placeholder text
 */function n(e,t){var r=[],n=0;/**
	 * Add a match.
	 *
	 * @private
	 * @param {string} match Matched string
	 * @return {string} Token to leave in the matched string's place
	 */function a(e){r.push(e);return t}/**
	 * Get a match.
	 *
	 * @private
	 * @return {string} Original matched string to restore
	 */function i(){return r[n++]}return{/**
		 * Replace matching strings with tokens.
		 *
		 * @param {string} str String to tokenize
		 * @return {string} Tokenized string
		 */tokenize:function(t){return t.replace(e,a)},/**
		 * Restores tokens to their original values.
		 *
		 * @param {string} str String previously run through tokenize()
		 * @return {string} Original string
		 */detokenize:function(e){return e.replace(new RegExp("("+t+")","g"),i)}}}/**
 * Create a CSSJanus object.
 *
 * CSSJanus transforms CSS rules with horizontal relevance so that a left-to-right stylesheet can
 * become a right-to-left stylesheet automatically. Processing can be bypassed for an entire rule
 * or a single property by adding a / * @noflip * / comment above the rule or property.
 *
 * @class
 * @constructor
 */function a(){var // Tokens
e="`TMP`",t="`TMPLTR`",r="`TMPRTL`",a="`NOFLIP_SINGLE`",i="`NOFLIP_CLASS`",o="`COMMENT`",// Patterns
s="[^\\u0020-\\u007e]",u="(?:(?:\\\\[0-9a-f]{1,6})(?:\\r\\n|\\s)?)",l="(?:[0-9]*\\.[0-9]+|[0-9]+)",c="(?:em|ex|px|cm|mm|in|pt|pc|deg|rad|grad|ms|s|hz|khz|%)",f="direction\\s*:\\s*",d="[!#$%&*-~]",h="['\"]?\\s*",p="(^|[^a-zA-Z])",v="[^\\}]*?",m="\\/\\*\\!?\\s*@noflip\\s*\\*\\/",g="\\/\\*[^*]*\\*+([^\\/*][^*]*\\*+)*\\/",b="(?:"+u+"|\\\\[^\\r\\n\\f0-9a-f])",y="(?:[_a-z]|"+s+"|"+b+")",w="(?:[_a-z0-9-]|"+s+"|"+b+")",_="-?"+y+w+"*",x=l+"(?:\\s*"+c+"|"+_+")?",E="((?:-?"+x+")|(?:inherit|auto))",O="(?:-?"+l+"(?:\\s*"+c+")?)",S="(?:\\+|\\-|\\*|\\/)",A="(?:\\(|\\)|\\t| )",T="(?:"+A+"|"+O+"|"+S+"){3,}",k="(?:calc\\((?:"+T+")\\))",R="((?:-?"+x+")|(?:inherit|auto)|"+k+")",C="((?:margin|padding|border-width)\\s*:\\s*)",P="((?:-color|border-style)\\s*:\\s*)",I="(#?"+w+"+|(?:rgba?|hsla?)\\([ \\d.,%-]+\\))",// The use of a lazy match ("*?") may cause a backtrack limit to be exceeded before finding
// the intended match. This affects 'urlCharsPattern' and 'lookAheadNotOpenBracePattern'.
// We have not yet found this problem on Node.js, but we have on PHP 7, where it was
// mitigated by using a possessive quantifier ("*+"), which are not supported in JS.
// See <https://phabricator.wikimedia.org/T215746#4944830>.
D="(?:"+d+"|"+s+"|"+b+")*?",M="(?![a-zA-Z])",F="(?!("+w+"|\\r?\\n|\\s|#|\\:|\\.|\\,|\\+|>|~|\\(|\\)|\\[|\\]|=|\\*=|~=|\\^=|'[^']*'|\"[^\"]*\"|"+o+")*?{)",L="(?!"+D+h+"\\))",N="(?="+D+h+"\\))",j="(\\s*(?:!important\\s*)?[;}])",// Regular expressions
U=/`TMP`/g,H=/`TMPLTR`/g,B=/`TMPRTL`/g,Y=new RegExp(g,"gi"),z=new RegExp("("+m+F+"[^;}]+;?)","gi"),q=new RegExp("("+m+v+"})","gi"),V=new RegExp("("+f+")ltr","gi"),W=new RegExp("("+f+")rtl","gi"),$=new RegExp(p+"(left)"+M+L+F,"gi"),G=new RegExp(p+"(right)"+M+L+F,"gi"),K=new RegExp(p+"(left)"+N,"gi"),Q=new RegExp(p+"(right)"+N,"gi"),X=/(:dir\( *)ltr( *\))/g,J=/(:dir\( *)rtl( *\))/g,Z=new RegExp(p+"(ltr)"+N,"gi"),ee=new RegExp(p+"(rtl)"+N,"gi"),et=new RegExp(p+"([ns]?)e-resize","gi"),er=new RegExp(p+"([ns]?)w-resize","gi"),en=new RegExp(C+R+"(\\s+)"+R+"(\\s+)"+R+"(\\s+)"+R+j,"gi"),ea=new RegExp(P+I+"(\\s+)"+I+"(\\s+)"+I+"(\\s+)"+I+j,"gi"),ei=new RegExp("(background(?:-position)?\\s*:\\s*(?:[^:;}\\s]+\\s+)*?)("+x+")","gi"),eo=new RegExp("(background-position-x\\s*:\\s*)(-?"+l+"%)","gi"),// border-radius: <length or percentage>{1,4} [optional: / <length or percentage>{1,4} ]
es=new RegExp("(border-radius\\s*:\\s*)"+E+"(?:(?:\\s+"+E+")(?:\\s+"+E+")?(?:\\s+"+E+")?)?"+"(?:(?:(?:\\s*\\/\\s*)"+E+")(?:\\s+"+E+")?(?:\\s+"+E+")?(?:\\s+"+E+")?)?"+j,"gi"),eu=new RegExp("(box-shadow\\s*:\\s*(?:inset\\s*)?)"+E,"gi"),el=new RegExp("(text-shadow\\s*:\\s*)"+E+"(\\s*)"+I,"gi"),ec=new RegExp("(text-shadow\\s*:\\s*)"+I+"(\\s*)"+E,"gi"),ef=new RegExp("(text-shadow\\s*:\\s*)"+E,"gi"),ed=new RegExp("(transform\\s*:[^;}]*)(translateX\\s*\\(\\s*)"+E+"(\\s*\\))","gi"),eh=new RegExp("(transform\\s*:[^;}]*)(translate\\s*\\(\\s*)"+E+"((?:\\s*,\\s*"+E+"){0,2}\\s*\\))","gi");/**
	 * Invert the horizontal value of a background position property.
	 *
	 * @private
	 * @param {string} match Matched property
	 * @param {string} pre Text before value
	 * @param {string} value Horizontal value
	 * @return {string} Inverted property
	 */function ep(e,t,r){var n,a;if(r.slice(-1)==="%"){n=r.indexOf(".");if(n!==-1){// Two off, one for the "%" at the end, one for the dot itself
a=r.length-n-2;r=100-parseFloat(r);r=r.toFixed(a)+"%"}else{r=100-parseFloat(r)+"%"}}return t+r}/**
	 * Invert a set of border radius values.
	 *
	 * @private
	 * @param {Array} values Matched values
	 * @return {string} Inverted values
	 */function ev(e){switch(e.length){case 4:e=[e[1],e[0],e[3],e[2]];break;case 3:e=[e[1],e[0],e[1],e[2]];break;case 2:e=[e[1],e[0]];break;case 1:e=[e[0]];break}return e.join(" ")}/**
	 * Invert a set of border radius values.
	 *
	 * @private
	 * @param {string} match Matched property
	 * @param {string} pre Text before value
	 * @param {string} [firstGroup1]
	 * @param {string} [firstGroup2]
	 * @param {string} [firstGroup3]
	 * @param {string} [firstGroup4]
	 * @param {string} [secondGroup1]
	 * @param {string} [secondGroup2]
	 * @param {string} [secondGroup3]
	 * @param {string} [secondGroup4]
	 * @param {string} [post] Text after value
	 * @return {string} Inverted property
	 */function em(e,t){var r,n=[].slice.call(arguments),a=n.slice(2,6).filter(function(e){return e}),i=n.slice(6,10).filter(function(e){return e}),o=n[10]||"";if(i.length){r=ev(a)+" / "+ev(i)}else{r=ev(a)}return t+r+o}/**
	 * Flip the sign of a CSS value, possibly with a unit.
	 *
	 * We can't just negate the value with unary minus due to the units.
	 *
	 * @private
	 * @param {string} value
	 * @return {string}
	 */function eg(e){if(parseFloat(e)===0){// Don't mangle zeroes
return e}if(e[0]==="-"){return e.slice(1)}return"-"+e}/**
	 * @private
	 * @param {string} match
	 * @param {string} property
	 * @param {string} offset
	 * @return {string}
	 */function eb(e,t,r){return t+eg(r)}/**
	 * @private
	 * @param {string} match
	 * @param {string} property
	 * @param {string} prefix
	 * @param {string} offset
	 * @param {string} suffix
	 * @return {string}
	 */function ey(e,t,r,n,a){return t+r+eg(n)+a}/**
	 * @private
	 * @param {string} match
	 * @param {string} property
	 * @param {string} color
	 * @param {string} space
	 * @param {string} offset
	 * @return {string}
	 */function ew(e,t,r,n,a){return t+r+n+eg(a)}return{/**
		 * Transform a left-to-right stylesheet to right-to-left.
		 *
		 * @param {string} css Stylesheet to transform
		 * @param {Object} options Options
		 * @param {boolean} [options.transformDirInUrl=false] Transform directions in URLs
		 * (e.g. 'ltr', 'rtl')
		 * @param {boolean} [options.transformEdgeInUrl=false] Transform edges in URLs
		 * (e.g. 'left', 'right')
		 * @return {string} Transformed stylesheet
		 */"transform":function(s,u){// Use single quotes in this object literal key for closure compiler.
// Tokenizers
var l=new n(z,a),c=new n(q,i),f=new n(Y,o);// Tokenize
s=f.tokenize(c.tokenize(l.tokenize(// We wrap tokens in ` , not ~ like the original implementation does.
// This was done because ` is not a legal character in CSS and can only
// occur in URLs, where we escape it to %60 before inserting our tokens.
s.replace("`","%60"))));// Transform URLs
if(u.transformDirInUrl){// Replace 'ltr' with 'rtl' and vice versa in background URLs
s=s.replace(X,"$1"+t+"$2").replace(J,"$1"+r+"$2").replace(Z,"$1"+e).replace(ee,"$1ltr").replace(U,"rtl").replace(H,"ltr").replace(B,"rtl")}if(u.transformEdgeInUrl){// Replace 'left' with 'right' and vice versa in background URLs
s=s.replace(K,"$1"+e).replace(Q,"$1left").replace(U,"right")}// Transform rules
s=s// Replace direction: ltr; with direction: rtl; and vice versa.
.replace(V,"$1"+e).replace(W,"$1ltr").replace(U,"rtl")// Flip rules like left: , padding-right: , etc.
.replace($,"$1"+e).replace(G,"$1left").replace(U,"right")// Flip East and West in rules like cursor: nw-resize;
.replace(et,"$1$2"+e).replace(er,"$1$2e-resize").replace(U,"w-resize")// Border radius
.replace(es,em)// Shadows
.replace(eu,eb).replace(el,ew).replace(ec,ew).replace(ef,eb)// Translate
.replace(ed,ey).replace(eh,ey)// Swap the second and fourth parts in four-part notation rules
// like padding: 1px 2px 3px 4px;
.replace(en,"$1$2$3$8$5$6$7$4$9").replace(ea,"$1$2$3$8$5$6$7$4$9")// Flip horizontal background percentages
.replace(ei,ep).replace(eo,ep);// Detokenize
s=l.detokenize(c.detokenize(f.detokenize(s)));return s}}}/* Initialization */r=new a;/* Exports */if(true&&e.exports){/**
	 * Transform a left-to-right stylesheet to right-to-left.
	 *
	 * This function is a static wrapper around the transform method of an instance of CSSJanus.
	 *
	 * @param {string} css Stylesheet to transform
	 * @param {Object|boolean} [options] Options object, or transformDirInUrl option (back-compat)
	 * @param {boolean} [options.transformDirInUrl=false] Transform directions in URLs
	 * (e.g. 'ltr', 'rtl')
	 * @param {boolean} [options.transformEdgeInUrl=false] Transform edges in URLs
	 * (e.g. 'left', 'right')
	 * @param {boolean} [transformEdgeInUrl] Back-compat parameter
	 * @return {string} Transformed stylesheet
	 */t.transform=function(e,t,n){var a;if(typeof t==="object"){a=t}else{a={};if(typeof t==="boolean"){a.transformDirInUrl=t}if(typeof n==="boolean"){a.transformEdgeInUrl=n}}return r.transform(e,a)}}else if(typeof window!=="undefined"){/* global window */// Allow cssjanus to be used in a browser.
// eslint-disable-next-line dot-notation
window["cssjanus"]=r}},8672:function(e,t,r){"use strict";r.d(t,{A:()=>n});function n(e,t){if(t.length<e){throw new TypeError(e+" argument"+(e>1?"s":"")+" required, but only "+t.length+" present")}}},7801:function(e,t,r){"use strict";r.d(t,{A:()=>n});function n(e){if(e===null||e===true||e===false){return NaN}var t=Number(e);if(isNaN(t)){return t}return t<0?Math.ceil(t):Math.floor(t)}},5124:function(e,t,r){"use strict";r.d(t,{A:()=>o});/* ESM import */var n=r(7801);/* ESM import */var a=r(3298);/* ESM import */var i=r(8672);/**
 * @name addMilliseconds
 * @category Millisecond Helpers
 * @summary Add the specified number of milliseconds to the given date.
 *
 * @description
 * Add the specified number of milliseconds to the given date.
 *
 * @param {Date|Number} date - the date to be changed
 * @param {Number} amount - the amount of milliseconds to be added. Positive decimals will be rounded using `Math.floor`, decimals less than zero will be rounded using `Math.ceil`.
 * @returns {Date} the new date with the milliseconds added
 * @throws {TypeError} 2 arguments required
 *
 * @example
 * // Add 750 milliseconds to 10 July 2014 12:45:30.000:
 * const result = addMilliseconds(new Date(2014, 6, 10, 12, 45, 30, 0), 750)
 * //=> Thu Jul 10 2014 12:45:30.750
 */function o(e,t){(0,i/* ["default"] */.A)(2,arguments);var r=(0,a/* ["default"] */.A)(e).getTime();var o=(0,n/* ["default"] */.A)(t);return new Date(r+o)}},8443:function(e,t,r){"use strict";r.d(t,{A:()=>s});/* ESM import */var n=r(7801);/* ESM import */var a=r(5124);/* ESM import */var i=r(8672);var o=6e4;/**
 * @name addMinutes
 * @category Minute Helpers
 * @summary Add the specified number of minutes to the given date.
 *
 * @description
 * Add the specified number of minutes to the given date.
 *
 * @param {Date|Number} date - the date to be changed
 * @param {Number} amount - the amount of minutes to be added. Positive decimals will be rounded using `Math.floor`, decimals less than zero will be rounded using `Math.ceil`.
 * @returns {Date} the new date with the minutes added
 * @throws {TypeError} 2 arguments required
 *
 * @example
 * // Add 30 minutes to 10 July 2014 12:00:00:
 * const result = addMinutes(new Date(2014, 6, 10, 12, 0), 30)
 * //=> Thu Jul 10 2014 12:30:00
 */function s(e,t){(0,i/* ["default"] */.A)(2,arguments);var r=(0,n/* ["default"] */.A)(t);return(0,a/* ["default"] */.A)(e,r*o)}},988:function(e,t,r){"use strict";// EXPORTS
r.d(t,{A:()=>/* binding */ej});// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/isValid/index.js + 1 modules
var n=r(5487);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/addMilliseconds/index.js
var a=r(5124);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/_lib/requiredArgs/index.js
var i=r(8672);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/_lib/toInteger/index.js
var o=r(7801);// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/subMilliseconds/index.js
/**
 * @name subMilliseconds
 * @category Millisecond Helpers
 * @summary Subtract the specified number of milliseconds from the given date.
 *
 * @description
 * Subtract the specified number of milliseconds from the given date.
 *
 * @param {Date|Number} date - the date to be changed
 * @param {Number} amount - the amount of milliseconds to be subtracted. Positive decimals will be rounded using `Math.floor`, decimals less than zero will be rounded using `Math.ceil`.
 * @returns {Date} the new date with the milliseconds subtracted
 * @throws {TypeError} 2 arguments required
 *
 * @example
 * // Subtract 750 milliseconds from 10 July 2014 12:45:30.000:
 * const result = subMilliseconds(new Date(2014, 6, 10, 12, 45, 30, 0), 750)
 * //=> Thu Jul 10 2014 12:45:29.250
 */function s(e,t){(0,i/* ["default"] */.A)(2,arguments);var r=(0,o/* ["default"] */.A)(t);return(0,a/* ["default"] */.A)(e,-r)}// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/toDate/index.js
var u=r(3298);// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/getUTCDayOfYear/index.js
var l=864e5;function c(e){(0,i/* ["default"] */.A)(1,arguments);var t=(0,u/* ["default"] */.A)(e);var r=t.getTime();t.setUTCMonth(0,1);t.setUTCHours(0,0,0,0);var n=t.getTime();var a=r-n;return Math.floor(a/l)+1};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/startOfUTCISOWeek/index.js
function f(e){(0,i/* ["default"] */.A)(1,arguments);var t=1;var r=(0,u/* ["default"] */.A)(e);var n=r.getUTCDay();var a=(n<t?7:0)+n-t;r.setUTCDate(r.getUTCDate()-a);r.setUTCHours(0,0,0,0);return r};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/getUTCISOWeekYear/index.js
function d(e){(0,i/* ["default"] */.A)(1,arguments);var t=(0,u/* ["default"] */.A)(e);var r=t.getUTCFullYear();var n=new Date(0);n.setUTCFullYear(r+1,0,4);n.setUTCHours(0,0,0,0);var a=f(n);var o=new Date(0);o.setUTCFullYear(r,0,4);o.setUTCHours(0,0,0,0);var s=f(o);if(t.getTime()>=a.getTime()){return r+1}else if(t.getTime()>=s.getTime()){return r}else{return r-1}};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/startOfUTCISOWeekYear/index.js
function h(e){(0,i/* ["default"] */.A)(1,arguments);var t=d(e);var r=new Date(0);r.setUTCFullYear(t,0,4);r.setUTCHours(0,0,0,0);var n=f(r);return n};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/getUTCISOWeek/index.js
var p=6048e5;function v(e){(0,i/* ["default"] */.A)(1,arguments);var t=(0,u/* ["default"] */.A)(e);var r=f(t).getTime()-h(t).getTime();// Round the number of days to the nearest integer
// because the number of milliseconds in a week is not constant
// (e.g. it's different in the week of the daylight saving time clock shift)
return Math.round(r/p)+1};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/defaultOptions/index.js
var m={};function g(){return m}function b(e){m=e};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/startOfUTCWeek/index.js
function y(e,t){var r,n,a,s,l,c,f,d;(0,i/* ["default"] */.A)(1,arguments);var h=g();var p=(0,o/* ["default"] */.A)((r=(n=(a=(s=t===null||t===void 0?void 0:t.weekStartsOn)!==null&&s!==void 0?s:t===null||t===void 0?void 0:(l=t.locale)===null||l===void 0?void 0:(c=l.options)===null||c===void 0?void 0:c.weekStartsOn)!==null&&a!==void 0?a:h.weekStartsOn)!==null&&n!==void 0?n:(f=h.locale)===null||f===void 0?void 0:(d=f.options)===null||d===void 0?void 0:d.weekStartsOn)!==null&&r!==void 0?r:0);// Test if weekStartsOn is between 0 and 6 _and_ is not NaN
if(!(p>=0&&p<=6)){throw new RangeError("weekStartsOn must be between 0 and 6 inclusively")}var v=(0,u/* ["default"] */.A)(e);var m=v.getUTCDay();var b=(m<p?7:0)+m-p;v.setUTCDate(v.getUTCDate()-b);v.setUTCHours(0,0,0,0);return v};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/getUTCWeekYear/index.js
function w(e,t){var r,n,a,s,l,c,f,d;(0,i/* ["default"] */.A)(1,arguments);var h=(0,u/* ["default"] */.A)(e);var p=h.getUTCFullYear();var v=g();var m=(0,o/* ["default"] */.A)((r=(n=(a=(s=t===null||t===void 0?void 0:t.firstWeekContainsDate)!==null&&s!==void 0?s:t===null||t===void 0?void 0:(l=t.locale)===null||l===void 0?void 0:(c=l.options)===null||c===void 0?void 0:c.firstWeekContainsDate)!==null&&a!==void 0?a:v.firstWeekContainsDate)!==null&&n!==void 0?n:(f=v.locale)===null||f===void 0?void 0:(d=f.options)===null||d===void 0?void 0:d.firstWeekContainsDate)!==null&&r!==void 0?r:1);// Test if weekStartsOn is between 1 and 7 _and_ is not NaN
if(!(m>=1&&m<=7)){throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively")}var b=new Date(0);b.setUTCFullYear(p+1,0,m);b.setUTCHours(0,0,0,0);var w=y(b,t);var _=new Date(0);_.setUTCFullYear(p,0,m);_.setUTCHours(0,0,0,0);var x=y(_,t);if(h.getTime()>=w.getTime()){return p+1}else if(h.getTime()>=x.getTime()){return p}else{return p-1}};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/startOfUTCWeekYear/index.js
function _(e,t){var r,n,a,s,u,l,c,f;(0,i/* ["default"] */.A)(1,arguments);var d=g();var h=(0,o/* ["default"] */.A)((r=(n=(a=(s=t===null||t===void 0?void 0:t.firstWeekContainsDate)!==null&&s!==void 0?s:t===null||t===void 0?void 0:(u=t.locale)===null||u===void 0?void 0:(l=u.options)===null||l===void 0?void 0:l.firstWeekContainsDate)!==null&&a!==void 0?a:d.firstWeekContainsDate)!==null&&n!==void 0?n:(c=d.locale)===null||c===void 0?void 0:(f=c.options)===null||f===void 0?void 0:f.firstWeekContainsDate)!==null&&r!==void 0?r:1);var p=w(e,t);var v=new Date(0);v.setUTCFullYear(p,0,h);v.setUTCHours(0,0,0,0);var m=y(v,t);return m};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/getUTCWeek/index.js
var x=6048e5;function E(e,t){(0,i/* ["default"] */.A)(1,arguments);var r=(0,u/* ["default"] */.A)(e);var n=y(r,t).getTime()-_(r,t).getTime();// Round the number of days to the nearest integer
// because the number of milliseconds in a week is not constant
// (e.g. it's different in the week of the daylight saving time clock shift)
return Math.round(n/x)+1};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/addLeadingZeros/index.js
function O(e,t){var r=e<0?"-":"";var n=Math.abs(e).toString();while(n.length<t){n="0"+n}return r+n};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/format/lightFormatters/index.js
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
 */var S={// Year
y:function e(e,t){// From http://www.unicode.org/reports/tr35/tr35-31/tr35-dates.html#Date_Format_tokens
// | Year     |     y | yy |   yyy |  yyyy | yyyyy |
// |----------|-------|----|-------|-------|-------|
// | AD 1     |     1 | 01 |   001 |  0001 | 00001 |
// | AD 12    |    12 | 12 |   012 |  0012 | 00012 |
// | AD 123   |   123 | 23 |   123 |  0123 | 00123 |
// | AD 1234  |  1234 | 34 |  1234 |  1234 | 01234 |
// | AD 12345 | 12345 | 45 | 12345 | 12345 | 12345 |
var r=e.getUTCFullYear();// Returns 1 for 1 BC (which is year 0 in JavaScript)
var n=r>0?r:1-r;return O(t==="yy"?n%100:n,t.length)},// Month
M:function e(e,t){var r=e.getUTCMonth();return t==="M"?String(r+1):O(r+1,2)},// Day of the month
d:function e(e,t){return O(e.getUTCDate(),t.length)},// AM or PM
a:function e(e,t){var r=e.getUTCHours()/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.toUpperCase();case"aaa":return r;case"aaaaa":return r[0];case"aaaa":default:return r==="am"?"a.m.":"p.m."}},// Hour [1-12]
h:function e(e,t){return O(e.getUTCHours()%12||12,t.length)},// Hour [0-23]
H:function e(e,t){return O(e.getUTCHours(),t.length)},// Minute
m:function e(e,t){return O(e.getUTCMinutes(),t.length)},// Second
s:function e(e,t){return O(e.getUTCSeconds(),t.length)},// Fraction of second
S:function e(e,t){var r=t.length;var n=e.getUTCMilliseconds();var a=Math.floor(n*Math.pow(10,r-3));return O(a,t.length)}};/* ESM default export */const A=S;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/format/formatters/index.js
var T={am:"am",pm:"pm",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"};/*
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
 */var k={// Era
G:function e(e,t,r){var n=e.getUTCFullYear()>0?1:0;switch(t){// AD, BC
case"G":case"GG":case"GGG":return r.era(n,{width:"abbreviated"});// A, B
case"GGGGG":return r.era(n,{width:"narrow"});// Anno Domini, Before Christ
case"GGGG":default:return r.era(n,{width:"wide"})}},// Year
y:function e(e,t,r){// Ordinal number
if(t==="yo"){var n=e.getUTCFullYear();// Returns 1 for 1 BC (which is year 0 in JavaScript)
var a=n>0?n:1-n;return r.ordinalNumber(a,{unit:"year"})}return A.y(e,t)},// Local week-numbering year
Y:function e(e,t,r,n){var a=w(e,n);// Returns 1 for 1 BC (which is year 0 in JavaScript)
var i=a>0?a:1-a;// Two digit year
if(t==="YY"){var o=i%100;return O(o,2)}// Ordinal number
if(t==="Yo"){return r.ordinalNumber(i,{unit:"year"})}// Padding
return O(i,t.length)},// ISO week-numbering year
R:function e(e,t){var r=d(e);// Padding
return O(r,t.length)},// Extended year. This is a single number designating the year of this calendar system.
// The main difference between `y` and `u` localizers are B.C. years:
// | Year | `y` | `u` |
// |------|-----|-----|
// | AC 1 |   1 |   1 |
// | BC 1 |   1 |   0 |
// | BC 2 |   2 |  -1 |
// Also `yy` always returns the last two digits of a year,
// while `uu` pads single digit years to 2 characters and returns other years unchanged.
u:function e(e,t){var r=e.getUTCFullYear();return O(r,t.length)},// Quarter
Q:function e(e,t,r){var n=Math.ceil((e.getUTCMonth()+1)/3);switch(t){// 1, 2, 3, 4
case"Q":return String(n);// 01, 02, 03, 04
case"QQ":return O(n,2);// 1st, 2nd, 3rd, 4th
case"Qo":return r.ordinalNumber(n,{unit:"quarter"});// Q1, Q2, Q3, Q4
case"QQQ":return r.quarter(n,{width:"abbreviated",context:"formatting"});// 1, 2, 3, 4 (narrow quarter; could be not numerical)
case"QQQQQ":return r.quarter(n,{width:"narrow",context:"formatting"});// 1st quarter, 2nd quarter, ...
case"QQQQ":default:return r.quarter(n,{width:"wide",context:"formatting"})}},// Stand-alone quarter
q:function e(e,t,r){var n=Math.ceil((e.getUTCMonth()+1)/3);switch(t){// 1, 2, 3, 4
case"q":return String(n);// 01, 02, 03, 04
case"qq":return O(n,2);// 1st, 2nd, 3rd, 4th
case"qo":return r.ordinalNumber(n,{unit:"quarter"});// Q1, Q2, Q3, Q4
case"qqq":return r.quarter(n,{width:"abbreviated",context:"standalone"});// 1, 2, 3, 4 (narrow quarter; could be not numerical)
case"qqqqq":return r.quarter(n,{width:"narrow",context:"standalone"});// 1st quarter, 2nd quarter, ...
case"qqqq":default:return r.quarter(n,{width:"wide",context:"standalone"})}},// Month
M:function e(e,t,r){var n=e.getUTCMonth();switch(t){case"M":case"MM":return A.M(e,t);// 1st, 2nd, ..., 12th
case"Mo":return r.ordinalNumber(n+1,{unit:"month"});// Jan, Feb, ..., Dec
case"MMM":return r.month(n,{width:"abbreviated",context:"formatting"});// J, F, ..., D
case"MMMMM":return r.month(n,{width:"narrow",context:"formatting"});// January, February, ..., December
case"MMMM":default:return r.month(n,{width:"wide",context:"formatting"})}},// Stand-alone month
L:function e(e,t,r){var n=e.getUTCMonth();switch(t){// 1, 2, ..., 12
case"L":return String(n+1);// 01, 02, ..., 12
case"LL":return O(n+1,2);// 1st, 2nd, ..., 12th
case"Lo":return r.ordinalNumber(n+1,{unit:"month"});// Jan, Feb, ..., Dec
case"LLL":return r.month(n,{width:"abbreviated",context:"standalone"});// J, F, ..., D
case"LLLLL":return r.month(n,{width:"narrow",context:"standalone"});// January, February, ..., December
case"LLLL":default:return r.month(n,{width:"wide",context:"standalone"})}},// Local week of year
w:function e(e,t,r,n){var a=E(e,n);if(t==="wo"){return r.ordinalNumber(a,{unit:"week"})}return O(a,t.length)},// ISO week of year
I:function e(e,t,r){var n=v(e);if(t==="Io"){return r.ordinalNumber(n,{unit:"week"})}return O(n,t.length)},// Day of the month
d:function e(e,t,r){if(t==="do"){return r.ordinalNumber(e.getUTCDate(),{unit:"date"})}return A.d(e,t)},// Day of year
D:function e(e,t,r){var n=c(e);if(t==="Do"){return r.ordinalNumber(n,{unit:"dayOfYear"})}return O(n,t.length)},// Day of week
E:function e(e,t,r){var n=e.getUTCDay();switch(t){// Tue
case"E":case"EE":case"EEE":return r.day(n,{width:"abbreviated",context:"formatting"});// T
case"EEEEE":return r.day(n,{width:"narrow",context:"formatting"});// Tu
case"EEEEEE":return r.day(n,{width:"short",context:"formatting"});// Tuesday
case"EEEE":default:return r.day(n,{width:"wide",context:"formatting"})}},// Local day of week
e:function e(e,t,r,n){var a=e.getUTCDay();var i=(a-n.weekStartsOn+8)%7||7;switch(t){// Numerical value (Nth day of week with current locale or weekStartsOn)
case"e":return String(i);// Padded numerical value
case"ee":return O(i,2);// 1st, 2nd, ..., 7th
case"eo":return r.ordinalNumber(i,{unit:"day"});case"eee":return r.day(a,{width:"abbreviated",context:"formatting"});// T
case"eeeee":return r.day(a,{width:"narrow",context:"formatting"});// Tu
case"eeeeee":return r.day(a,{width:"short",context:"formatting"});// Tuesday
case"eeee":default:return r.day(a,{width:"wide",context:"formatting"})}},// Stand-alone local day of week
c:function e(e,t,r,n){var a=e.getUTCDay();var i=(a-n.weekStartsOn+8)%7||7;switch(t){// Numerical value (same as in `e`)
case"c":return String(i);// Padded numerical value
case"cc":return O(i,t.length);// 1st, 2nd, ..., 7th
case"co":return r.ordinalNumber(i,{unit:"day"});case"ccc":return r.day(a,{width:"abbreviated",context:"standalone"});// T
case"ccccc":return r.day(a,{width:"narrow",context:"standalone"});// Tu
case"cccccc":return r.day(a,{width:"short",context:"standalone"});// Tuesday
case"cccc":default:return r.day(a,{width:"wide",context:"standalone"})}},// ISO day of week
i:function e(e,t,r){var n=e.getUTCDay();var a=n===0?7:n;switch(t){// 2
case"i":return String(a);// 02
case"ii":return O(a,t.length);// 2nd
case"io":return r.ordinalNumber(a,{unit:"day"});// Tue
case"iii":return r.day(n,{width:"abbreviated",context:"formatting"});// T
case"iiiii":return r.day(n,{width:"narrow",context:"formatting"});// Tu
case"iiiiii":return r.day(n,{width:"short",context:"formatting"});// Tuesday
case"iiii":default:return r.day(n,{width:"wide",context:"formatting"})}},// AM or PM
a:function e(e,t,r){var n=e.getUTCHours();var a=n/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"});case"aaa":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"}).toLowerCase();case"aaaaa":return r.dayPeriod(a,{width:"narrow",context:"formatting"});case"aaaa":default:return r.dayPeriod(a,{width:"wide",context:"formatting"})}},// AM, PM, midnight, noon
b:function e(e,t,r){var n=e.getUTCHours();var a;if(n===12){a=T.noon}else if(n===0){a=T.midnight}else{a=n/12>=1?"pm":"am"}switch(t){case"b":case"bb":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"});case"bbb":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"}).toLowerCase();case"bbbbb":return r.dayPeriod(a,{width:"narrow",context:"formatting"});case"bbbb":default:return r.dayPeriod(a,{width:"wide",context:"formatting"})}},// in the morning, in the afternoon, in the evening, at night
B:function e(e,t,r){var n=e.getUTCHours();var a;if(n>=17){a=T.evening}else if(n>=12){a=T.afternoon}else if(n>=4){a=T.morning}else{a=T.night}switch(t){case"B":case"BB":case"BBB":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"});case"BBBBB":return r.dayPeriod(a,{width:"narrow",context:"formatting"});case"BBBB":default:return r.dayPeriod(a,{width:"wide",context:"formatting"})}},// Hour [1-12]
h:function e(e,t,r){if(t==="ho"){var n=e.getUTCHours()%12;if(n===0)n=12;return r.ordinalNumber(n,{unit:"hour"})}return A.h(e,t)},// Hour [0-23]
H:function e(e,t,r){if(t==="Ho"){return r.ordinalNumber(e.getUTCHours(),{unit:"hour"})}return A.H(e,t)},// Hour [0-11]
K:function e(e,t,r){var n=e.getUTCHours()%12;if(t==="Ko"){return r.ordinalNumber(n,{unit:"hour"})}return O(n,t.length)},// Hour [1-24]
k:function e(e,t,r){var n=e.getUTCHours();if(n===0)n=24;if(t==="ko"){return r.ordinalNumber(n,{unit:"hour"})}return O(n,t.length)},// Minute
m:function e(e,t,r){if(t==="mo"){return r.ordinalNumber(e.getUTCMinutes(),{unit:"minute"})}return A.m(e,t)},// Second
s:function e(e,t,r){if(t==="so"){return r.ordinalNumber(e.getUTCSeconds(),{unit:"second"})}return A.s(e,t)},// Fraction of second
S:function e(e,t){return A.S(e,t)},// Timezone (ISO-8601. If offset is 0, output is always `'Z'`)
X:function e(e,t,r,n){var a=n._originalDate||e;var i=a.getTimezoneOffset();if(i===0){return"Z"}switch(t){// Hours and optional minutes
case"X":return C(i);// Hours, minutes and optional seconds without `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `XX`
case"XXXX":case"XX":// Hours and minutes without `:` delimiter
return P(i);// Hours, minutes and optional seconds with `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `XXX`
case"XXXXX":case"XXX":default:return P(i,":")}},// Timezone (ISO-8601. If offset is 0, output is `'+00:00'` or equivalent)
x:function e(e,t,r,n){var a=n._originalDate||e;var i=a.getTimezoneOffset();switch(t){// Hours and optional minutes
case"x":return C(i);// Hours, minutes and optional seconds without `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `xx`
case"xxxx":case"xx":// Hours and minutes without `:` delimiter
return P(i);// Hours, minutes and optional seconds with `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `xxx`
case"xxxxx":case"xxx":default:return P(i,":")}},// Timezone (GMT)
O:function e(e,t,r,n){var a=n._originalDate||e;var i=a.getTimezoneOffset();switch(t){// Short
case"O":case"OO":case"OOO":return"GMT"+R(i,":");// Long
case"OOOO":default:return"GMT"+P(i,":")}},// Timezone (specific non-location)
z:function e(e,t,r,n){var a=n._originalDate||e;var i=a.getTimezoneOffset();switch(t){// Short
case"z":case"zz":case"zzz":return"GMT"+R(i,":");// Long
case"zzzz":default:return"GMT"+P(i,":")}},// Seconds timestamp
t:function e(e,t,r,n){var a=n._originalDate||e;var i=Math.floor(a.getTime()/1e3);return O(i,t.length)},// Milliseconds timestamp
T:function e(e,t,r,n){var a=n._originalDate||e;var i=a.getTime();return O(i,t.length)}};function R(e,t){var r=e>0?"-":"+";var n=Math.abs(e);var a=Math.floor(n/60);var i=n%60;if(i===0){return r+String(a)}var o=t||"";return r+String(a)+o+O(i,2)}function C(e,t){if(e%60===0){var r=e>0?"-":"+";return r+O(Math.abs(e)/60,2)}return P(e,t)}function P(e,t){var r=t||"";var n=e>0?"-":"+";var a=Math.abs(e);var i=O(Math.floor(a/60),2);var o=O(a%60,2);return n+i+r+o}/* ESM default export */const I=k;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/format/longFormatters/index.js
var D=function e(e,t){switch(e){case"P":return t.date({width:"short"});case"PP":return t.date({width:"medium"});case"PPP":return t.date({width:"long"});case"PPPP":default:return t.date({width:"full"})}};var M=function e(e,t){switch(e){case"p":return t.time({width:"short"});case"pp":return t.time({width:"medium"});case"ppp":return t.time({width:"long"});case"pppp":default:return t.time({width:"full"})}};var F=function e(e,t){var r=e.match(/(P+)(p+)?/)||[];var n=r[1];var a=r[2];if(!a){return D(e,t)}var i;switch(n){case"P":i=t.dateTime({width:"short"});break;case"PP":i=t.dateTime({width:"medium"});break;case"PPP":i=t.dateTime({width:"long"});break;case"PPPP":default:i=t.dateTime({width:"full"});break}return i.replace("{{date}}",D(n,t)).replace("{{time}}",M(a,t))};var L={p:M,P:F};/* ESM default export */const N=L;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/getTimezoneOffsetInMilliseconds/index.js
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
 */function j(e){var t=new Date(Date.UTC(e.getFullYear(),e.getMonth(),e.getDate(),e.getHours(),e.getMinutes(),e.getSeconds(),e.getMilliseconds()));t.setUTCFullYear(e.getFullYear());return e.getTime()-t.getTime()};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/protectedTokens/index.js
var U=["D","DD"];var H=["YY","YYYY"];function B(e){return U.indexOf(e)!==-1}function Y(e){return H.indexOf(e)!==-1}function z(e,t,r){if(e==="YYYY"){throw new RangeError("Use `yyyy` instead of `YYYY` (in `".concat(t,"`) for formatting years to the input `").concat(r,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"))}else if(e==="YY"){throw new RangeError("Use `yy` instead of `YY` (in `".concat(t,"`) for formatting years to the input `").concat(r,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"))}else if(e==="D"){throw new RangeError("Use `d` instead of `D` (in `".concat(t,"`) for formatting days of the month to the input `").concat(r,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"))}else if(e==="DD"){throw new RangeError("Use `dd` instead of `DD` (in `".concat(t,"`) for formatting days of the month to the input `").concat(r,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"))}};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/en-US/_lib/formatDistance/index.js
var q={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXWeeks:{one:"about 1 week",other:"about {{count}} weeks"},xWeeks:{one:"1 week",other:"{{count}} weeks"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}};var V=function e(e,t,r){var n;var a=q[e];if(typeof a==="string"){n=a}else if(t===1){n=a.one}else{n=a.other.replace("{{count}}",t.toString())}if(r!==null&&r!==void 0&&r.addSuffix){if(r.comparison&&r.comparison>0){return"in "+n}else{return n+" ago"}}return n};/* ESM default export */const W=V;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/_lib/buildFormatLongFn/index.js
function $(e){return function(){var t=arguments.length>0&&arguments[0]!==undefined?arguments[0]:{};// TODO: Remove String()
var r=t.width?String(t.width):e.defaultWidth;var n=e.formats[r]||e.formats[e.defaultWidth];return n}};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/en-US/_lib/formatLong/index.js
var G={full:"EEEE, MMMM do, y",long:"MMMM do, y",medium:"MMM d, y",short:"MM/dd/yyyy"};var K={full:"h:mm:ss a zzzz",long:"h:mm:ss a z",medium:"h:mm:ss a",short:"h:mm a"};var Q={full:"{{date}} 'at' {{time}}",long:"{{date}} 'at' {{time}}",medium:"{{date}}, {{time}}",short:"{{date}}, {{time}}"};var X={date:$({formats:G,defaultWidth:"full"}),time:$({formats:K,defaultWidth:"full"}),dateTime:$({formats:Q,defaultWidth:"full"})};/* ESM default export */const J=X;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/en-US/_lib/formatRelative/index.js
var Z={lastWeek:"'last' eeee 'at' p",yesterday:"'yesterday at' p",today:"'today at' p",tomorrow:"'tomorrow at' p",nextWeek:"eeee 'at' p",other:"P"};var ee=function e(e,t,r,n){return Z[e]};/* ESM default export */const et=ee;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/_lib/buildLocalizeFn/index.js
function er(e){return function(t,r){var n=r!==null&&r!==void 0&&r.context?String(r.context):"standalone";var a;if(n==="formatting"&&e.formattingValues){var i=e.defaultFormattingWidth||e.defaultWidth;var o=r!==null&&r!==void 0&&r.width?String(r.width):i;a=e.formattingValues[o]||e.formattingValues[i]}else{var s=e.defaultWidth;var u=r!==null&&r!==void 0&&r.width?String(r.width):e.defaultWidth;a=e.values[u]||e.values[s]}var l=e.argumentCallback?e.argumentCallback(t):t;// @ts-ignore: For some reason TypeScript just don't want to match it, no matter how hard we try. I challenge you to try to remove it!
return a[l]}};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/en-US/_lib/localize/index.js
var en={narrow:["B","A"],abbreviated:["BC","AD"],wide:["Before Christ","Anno Domini"]};var ea={narrow:["1","2","3","4"],abbreviated:["Q1","Q2","Q3","Q4"],wide:["1st quarter","2nd quarter","3rd quarter","4th quarter"]};// Note: in English, the names of days of the week and months are capitalized.
// If you are making a new locale based on this one, check if the same is true for the language you're working on.
// Generally, formatted dates should look like they are in the middle of a sentence,
// e.g. in Spanish language the weekdays and months should be in the lowercase.
var ei={narrow:["J","F","M","A","M","J","J","A","S","O","N","D"],abbreviated:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],wide:["January","February","March","April","May","June","July","August","September","October","November","December"]};var eo={narrow:["S","M","T","W","T","F","S"],short:["Su","Mo","Tu","We","Th","Fr","Sa"],abbreviated:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],wide:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]};var es={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"}};var eu={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"}};var el=function e(e,t){var r=Number(e);// If ordinal numbers depend on context, for example,
// if they are different for different grammatical genders,
// use `options.unit`.
//
// `unit` can be 'year', 'quarter', 'month', 'week', 'date', 'dayOfYear',
// 'day', 'hour', 'minute', 'second'.
var n=r%100;if(n>20||n<10){switch(n%10){case 1:return r+"st";case 2:return r+"nd";case 3:return r+"rd"}}return r+"th"};var ec={ordinalNumber:el,era:er({values:en,defaultWidth:"wide"}),quarter:er({values:ea,defaultWidth:"wide",argumentCallback:function e(e){return e-1}}),month:er({values:ei,defaultWidth:"wide"}),day:er({values:eo,defaultWidth:"wide"}),dayPeriod:er({values:es,defaultWidth:"wide",formattingValues:eu,defaultFormattingWidth:"wide"})};/* ESM default export */const ef=ec;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/_lib/buildMatchFn/index.js
function ed(e){return function(t){var r=arguments.length>1&&arguments[1]!==undefined?arguments[1]:{};var n=r.width;var a=n&&e.matchPatterns[n]||e.matchPatterns[e.defaultMatchWidth];var i=t.match(a);if(!i){return null}var o=i[0];var s=n&&e.parsePatterns[n]||e.parsePatterns[e.defaultParseWidth];var u=Array.isArray(s)?ep(s,function(e){return e.test(o)}):eh(s,function(e){return e.test(o)});var l;l=e.valueCallback?e.valueCallback(u):u;l=r.valueCallback?r.valueCallback(l):l;var c=t.slice(o.length);return{value:l,rest:c}}}function eh(e,t){for(var r in e){if(e.hasOwnProperty(r)&&t(e[r])){return r}}return undefined}function ep(e,t){for(var r=0;r<e.length;r++){if(t(e[r])){return r}}return undefined};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/_lib/buildMatchPatternFn/index.js
function ev(e){return function(t){var r=arguments.length>1&&arguments[1]!==undefined?arguments[1]:{};var n=t.match(e.matchPattern);if(!n)return null;var a=n[0];var i=t.match(e.parsePattern);if(!i)return null;var o=e.valueCallback?e.valueCallback(i[0]):i[0];o=r.valueCallback?r.valueCallback(o):o;var s=t.slice(a.length);return{value:o,rest:s}}};// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/en-US/_lib/match/index.js
var em=/^(\d+)(th|st|nd|rd)?/i;var eg=/\d+/i;var eb={narrow:/^(b|a)/i,abbreviated:/^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i,wide:/^(before christ|before common era|anno domini|common era)/i};var ey={any:[/^b/i,/^(a|c)/i]};var ew={narrow:/^[1234]/i,abbreviated:/^q[1234]/i,wide:/^[1234](th|st|nd|rd)? quarter/i};var e_={any:[/1/i,/2/i,/3/i,/4/i]};var ex={narrow:/^[jfmasond]/i,abbreviated:/^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,wide:/^(january|february|march|april|may|june|july|august|september|october|november|december)/i};var eE={narrow:[/^j/i,/^f/i,/^m/i,/^a/i,/^m/i,/^j/i,/^j/i,/^a/i,/^s/i,/^o/i,/^n/i,/^d/i],any:[/^ja/i,/^f/i,/^mar/i,/^ap/i,/^may/i,/^jun/i,/^jul/i,/^au/i,/^s/i,/^o/i,/^n/i,/^d/i]};var eO={narrow:/^[smtwf]/i,short:/^(su|mo|tu|we|th|fr|sa)/i,abbreviated:/^(sun|mon|tue|wed|thu|fri|sat)/i,wide:/^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i};var eS={narrow:[/^s/i,/^m/i,/^t/i,/^w/i,/^t/i,/^f/i,/^s/i],any:[/^su/i,/^m/i,/^tu/i,/^w/i,/^th/i,/^f/i,/^sa/i]};var eA={narrow:/^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i,any:/^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i};var eT={any:{am:/^a/i,pm:/^p/i,midnight:/^mi/i,noon:/^no/i,morning:/morning/i,afternoon:/afternoon/i,evening:/evening/i,night:/night/i}};var ek={ordinalNumber:ev({matchPattern:em,parsePattern:eg,valueCallback:function e(e){return parseInt(e,10)}}),era:ed({matchPatterns:eb,defaultMatchWidth:"wide",parsePatterns:ey,defaultParseWidth:"any"}),quarter:ed({matchPatterns:ew,defaultMatchWidth:"wide",parsePatterns:e_,defaultParseWidth:"any",valueCallback:function e(e){return e+1}}),month:ed({matchPatterns:ex,defaultMatchWidth:"wide",parsePatterns:eE,defaultParseWidth:"any"}),day:ed({matchPatterns:eO,defaultMatchWidth:"wide",parsePatterns:eS,defaultParseWidth:"any"}),dayPeriod:ed({matchPatterns:eA,defaultMatchWidth:"any",parsePatterns:eT,defaultParseWidth:"any"})};/* ESM default export */const eR=ek;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/locale/en-US/index.js
/**
 * @type {Locale}
 * @category Locales
 * @summary English locale (United States).
 * @language English
 * @iso-639-2 eng
 * @author Sasha Koss [@kossnocorp]{@link https://github.com/kossnocorp}
 * @author Lesha Koss [@leshakoss]{@link https://github.com/leshakoss}
 */var eC={code:"en-US",formatDistance:W,formatLong:J,formatRelative:et,localize:ef,match:eR,options:{weekStartsOn:0/* Sunday */,firstWeekContainsDate:1}};/* ESM default export */const eP=eC;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/_lib/defaultLocale/index.js
/* ESM default export */const eI=eP;// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/format/index.js
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
var eD=/[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g;// This RegExp catches symbols escaped by quotes, and also
// sequences of symbols P, p, and the combinations like `PPPPPPPppppp`
var eM=/P+p+|P+|p+|''|'(''|[^'])+('|$)|./g;var eF=/^'([^]*?)'?$/;var eL=/''/g;var eN=/[a-zA-Z]/;/**
 * @name format
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
 *    and `options.firstWeekContainsDate` (compare [getISOWeekYear]{@link https://date-fns.org/docs/getISOWeekYear}
 *    and [getWeekYear]{@link https://date-fns.org/docs/getWeekYear}).
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
 * @param {Date|Number} date - the original date
 * @param {String} format - the string of tokens
 * @param {Object} [options] - an object with options.
 * @param {Locale} [options.locale=defaultLocale] - the locale object. See [Locale]{@link https://date-fns.org/docs/Locale}
 * @param {0|1|2|3|4|5|6} [options.weekStartsOn=0] - the index of the first day of the week (0 - Sunday)
 * @param {Number} [options.firstWeekContainsDate=1] - the day of January, which is
 * @param {Boolean} [options.useAdditionalWeekYearTokens=false] - if true, allows usage of the week-numbering year tokens `YY` and `YYYY`;
 *   see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @param {Boolean} [options.useAdditionalDayOfYearTokens=false] - if true, allows usage of the day of year tokens `D` and `DD`;
 *   see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @returns {String} the formatted date string
 * @throws {TypeError} 2 arguments required
 * @throws {RangeError} `date` must not be Invalid Date
 * @throws {RangeError} `options.locale` must contain `localize` property
 * @throws {RangeError} `options.locale` must contain `formatLong` property
 * @throws {RangeError} `options.weekStartsOn` must be between 0 and 6
 * @throws {RangeError} `options.firstWeekContainsDate` must be between 1 and 7
 * @throws {RangeError} use `yyyy` instead of `YYYY` for formatting years using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws {RangeError} use `yy` instead of `YY` for formatting years using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws {RangeError} use `d` instead of `D` for formatting days of the month using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws {RangeError} use `dd` instead of `DD` for formatting days of the month using [format provided] to the input [input provided]; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md
 * @throws {RangeError} format string contains an unescaped latin alphabet character
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
 */function ej(e,t,r){var a,l,c,f,d,h,p,v,m,b,y,w,_,x,E,O,S,A;(0,i/* ["default"] */.A)(2,arguments);var T=String(t);var k=g();var R=(a=(l=r===null||r===void 0?void 0:r.locale)!==null&&l!==void 0?l:k.locale)!==null&&a!==void 0?a:eI;var C=(0,o/* ["default"] */.A)((c=(f=(d=(h=r===null||r===void 0?void 0:r.firstWeekContainsDate)!==null&&h!==void 0?h:r===null||r===void 0?void 0:(p=r.locale)===null||p===void 0?void 0:(v=p.options)===null||v===void 0?void 0:v.firstWeekContainsDate)!==null&&d!==void 0?d:k.firstWeekContainsDate)!==null&&f!==void 0?f:(m=k.locale)===null||m===void 0?void 0:(b=m.options)===null||b===void 0?void 0:b.firstWeekContainsDate)!==null&&c!==void 0?c:1);// Test if weekStartsOn is between 1 and 7 _and_ is not NaN
if(!(C>=1&&C<=7)){throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively")}var P=(0,o/* ["default"] */.A)((y=(w=(_=(x=r===null||r===void 0?void 0:r.weekStartsOn)!==null&&x!==void 0?x:r===null||r===void 0?void 0:(E=r.locale)===null||E===void 0?void 0:(O=E.options)===null||O===void 0?void 0:O.weekStartsOn)!==null&&_!==void 0?_:k.weekStartsOn)!==null&&w!==void 0?w:(S=k.locale)===null||S===void 0?void 0:(A=S.options)===null||A===void 0?void 0:A.weekStartsOn)!==null&&y!==void 0?y:0);// Test if weekStartsOn is between 0 and 6 _and_ is not NaN
if(!(P>=0&&P<=6)){throw new RangeError("weekStartsOn must be between 0 and 6 inclusively")}if(!R.localize){throw new RangeError("locale must contain localize property")}if(!R.formatLong){throw new RangeError("locale must contain formatLong property")}var D=(0,u/* ["default"] */.A)(e);if(!(0,n/* ["default"] */.A)(D)){throw new RangeError("Invalid time value")}// Convert the date in system timezone to the same date in UTC+00:00 timezone.
// This ensures that when UTC functions will be implemented, locales will be compatible with them.
// See an issue about UTC functions: https://github.com/date-fns/date-fns/issues/376
var M=j(D);var F=s(D,M);var L={firstWeekContainsDate:C,weekStartsOn:P,locale:R,_originalDate:D};var U=T.match(eM).map(function(e){var t=e[0];if(t==="p"||t==="P"){var r=N[t];return r(e,R.formatLong)}return e}).join("").match(eD).map(function(n){// Replace two single quote characters with one single quote character
if(n==="''"){return"'"}var a=n[0];if(a==="'"){return eU(n)}var i=I[a];if(i){if(!(r!==null&&r!==void 0&&r.useAdditionalWeekYearTokens)&&Y(n)){z(n,t,String(e))}if(!(r!==null&&r!==void 0&&r.useAdditionalDayOfYearTokens)&&B(n)){z(n,t,String(e))}return i(F,n,R.localize,L)}if(a.match(eN)){throw new RangeError("Format string contains an unescaped latin alphabet character `"+a+"`")}return n}).join("");return U}function eU(e){var t=e.match(eF);if(!t){return e}return t[1].replace(eL,"'")}},5487:function(e,t,r){"use strict";// EXPORTS
r.d(t,{A:()=>/* binding */s});// EXTERNAL MODULE: ../tutor/node_modules/@babel/runtime/helpers/esm/typeof.js
var n=r(9239);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/_lib/requiredArgs/index.js
var a=r(8672);// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/isDate/index.js
/**
 * @name isDate
 * @category Common Helpers
 * @summary Is the given value a date?
 *
 * @description
 * Returns true if the given value is an instance of Date. The function works for dates transferred across iframes.
 *
 * @param {*} value - the value to check
 * @returns {boolean} true if the given value is a date
 * @throws {TypeError} 1 arguments required
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
 */function i(e){(0,a/* ["default"] */.A)(1,arguments);return e instanceof Date||(0,n/* ["default"] */.A)(e)==="object"&&Object.prototype.toString.call(e)==="[object Date]"}// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/toDate/index.js
var o=r(3298);// CONCATENATED MODULE: ../tutor/node_modules/date-fns/esm/isValid/index.js
/**
 * @name isValid
 * @category Common Helpers
 * @summary Is the given date valid?
 *
 * @description
 * Returns false if argument is Invalid Date and true otherwise.
 * Argument is converted to Date using `toDate`. See [toDate]{@link https://date-fns.org/docs/toDate}
 * Invalid Date is a Date, whose time value is NaN.
 *
 * Time value of Date: http://es5.github.io/#x15.9.1.1
 *
 * @param {*} date - the date to check
 * @returns {Boolean} the date is valid
 * @throws {TypeError} 1 argument required
 *
 * @example
 * // For the valid date:
 * const result = isValid(new Date(2014, 1, 31))
 * //=> true
 *
 * @example
 * // For the value, convertable into a date:
 * const result = isValid(1393804800000)
 * //=> true
 *
 * @example
 * // For the invalid date:
 * const result = isValid(new Date(''))
 * //=> false
 */function s(e){(0,a/* ["default"] */.A)(1,arguments);if(!i(e)&&typeof e!=="number"){return false}var t=(0,o/* ["default"] */.A)(e);return!isNaN(Number(t))}},3298:function(e,t,r){"use strict";r.d(t,{A:()=>i});/* ESM import */var n=r(9239);/* ESM import */var a=r(8672);/**
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
 * **Note**: *all* Date arguments passed to any *date-fns* function is processed by `toDate`.
 *
 * @param {Date|Number} argument - the value to convert
 * @returns {Date} the parsed date in the local time zone
 * @throws {TypeError} 1 argument required
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
 */function i(e){(0,a/* ["default"] */.A)(1,arguments);var t=Object.prototype.toString.call(e);// Clone the date
if(e instanceof Date||(0,n/* ["default"] */.A)(e)==="object"&&t==="[object Date]"){// Prevent the date to lose the milliseconds when passed to new Date() in IE10
return new Date(e.getTime())}else if(typeof e==="number"||t==="[object Number]"){return new Date(e)}else{if((typeof e==="string"||t==="[object String]")&&typeof console!=="undefined"){// eslint-disable-next-line no-console
console.warn("Starting with v2.0.0-beta.1 date-fns doesn't accept strings as date arguments. Please use `parseISO` to parse strings. See: https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#string-arguments");// eslint-disable-next-line no-console
console.warn(new Error().stack)}return new Date(NaN)}}},2053:function(e,t,r){"use strict";t.__esModule=true;t["default"]=v;var n=o(r(187));var a=o(r(7303));var i=o(r(9677));function o(e){return e&&e.__esModule?e:{"default":e}}var s=/^#[a-fA-F0-9]{6}$/;var u=/^#[a-fA-F0-9]{8}$/;var l=/^#[a-fA-F0-9]{3}$/;var c=/^#[a-fA-F0-9]{4}$/;var f=/^rgb\(\s*(\d{1,3})\s*(?:,)?\s*(\d{1,3})\s*(?:,)?\s*(\d{1,3})\s*\)$/i;var d=/^rgb(?:a)?\(\s*(\d{1,3})\s*(?:,)?\s*(\d{1,3})\s*(?:,)?\s*(\d{1,3})\s*(?:,|\/)\s*([-+]?\d*[.]?\d+[%]?)\s*\)$/i;var h=/^hsl\(\s*(\d{0,3}[.]?[0-9]+(?:deg)?)\s*(?:,)?\s*(\d{1,3}[.]?[0-9]?)%\s*(?:,)?\s*(\d{1,3}[.]?[0-9]?)%\s*\)$/i;var p=/^hsl(?:a)?\(\s*(\d{0,3}[.]?[0-9]+(?:deg)?)\s*(?:,)?\s*(\d{1,3}[.]?[0-9]?)%\s*(?:,)?\s*(\d{1,3}[.]?[0-9]?)%\s*(?:,|\/)\s*([-+]?\d*[.]?\d+[%]?)\s*\)$/i;/**
 * Returns an RgbColor or RgbaColor object. This utility function is only useful
 * if want to extract a color component. With the color util `toColorString` you
 * can convert a RgbColor or RgbaColor object back to a string.
 *
 * @example
 * // Assigns `{ red: 255, green: 0, blue: 0 }` to color1
 * const color1 = parseToRgb('rgb(255, 0, 0)');
 * // Assigns `{ red: 92, green: 102, blue: 112, alpha: 0.75 }` to color2
 * const color2 = parseToRgb('hsla(210, 10%, 40%, 0.75)');
 */function v(e){if(typeof e!=="string"){throw new i["default"](3)}var t=(0,a["default"])(e);if(t.match(s)){return{red:parseInt(""+t[1]+t[2],16),green:parseInt(""+t[3]+t[4],16),blue:parseInt(""+t[5]+t[6],16)}}if(t.match(u)){var r=parseFloat((parseInt(""+t[7]+t[8],16)/255).toFixed(2));return{red:parseInt(""+t[1]+t[2],16),green:parseInt(""+t[3]+t[4],16),blue:parseInt(""+t[5]+t[6],16),alpha:r}}if(t.match(l)){return{red:parseInt(""+t[1]+t[1],16),green:parseInt(""+t[2]+t[2],16),blue:parseInt(""+t[3]+t[3],16)}}if(t.match(c)){var o=parseFloat((parseInt(""+t[4]+t[4],16)/255).toFixed(2));return{red:parseInt(""+t[1]+t[1],16),green:parseInt(""+t[2]+t[2],16),blue:parseInt(""+t[3]+t[3],16),alpha:o}}var v=f.exec(t);if(v){return{red:parseInt(""+v[1],10),green:parseInt(""+v[2],10),blue:parseInt(""+v[3],10)}}var m=d.exec(t.substring(0,50));if(m){return{red:parseInt(""+m[1],10),green:parseInt(""+m[2],10),blue:parseInt(""+m[3],10),alpha:parseFloat(""+m[4])>1?parseFloat(""+m[4])/100:parseFloat(""+m[4])}}var g=h.exec(t);if(g){var b=parseInt(""+g[1],10);var y=parseInt(""+g[2],10)/100;var w=parseInt(""+g[3],10)/100;var _="rgb("+(0,n["default"])(b,y,w)+")";var x=f.exec(_);if(!x){throw new i["default"](4,t,_)}return{red:parseInt(""+x[1],10),green:parseInt(""+x[2],10),blue:parseInt(""+x[3],10)}}var E=p.exec(t.substring(0,50));if(E){var O=parseInt(""+E[1],10);var S=parseInt(""+E[2],10)/100;var A=parseInt(""+E[3],10)/100;var T="rgb("+(0,n["default"])(O,S,A)+")";var k=f.exec(T);if(!k){throw new i["default"](4,t,T)}return{red:parseInt(""+k[1],10),green:parseInt(""+k[2],10),blue:parseInt(""+k[3],10),alpha:parseFloat(""+E[4])>1?parseFloat(""+E[4])/100:parseFloat(""+E[4])}}throw new i["default"](5)}e.exports=t["default"]},493:function(e,t,r){"use strict";t.__esModule=true;t["default"]=s;var n=o(r(5622));var a=o(r(3813));var i=o(r(9677));function o(e){return e&&e.__esModule?e:{"default":e}}/**
 * Returns a string value for the color. The returned result is the smallest possible hex notation.
 *
 * @example
 * // Styles as object usage
 * const styles = {
 *   background: rgb(255, 205, 100),
 *   background: rgb({ red: 255, green: 205, blue: 100 }),
 * }
 *
 * // styled-components usage
 * const div = styled.div`
 *   background: ${rgb(255, 205, 100)};
 *   background: ${rgb({ red: 255, green: 205, blue: 100 })};
 * `
 *
 * // CSS in JS Output
 *
 * element {
 *   background: "#ffcd64";
 *   background: "#ffcd64";
 * }
 */function s(e,t,r){if(typeof e==="number"&&typeof t==="number"&&typeof r==="number"){return(0,n["default"])("#"+(0,a["default"])(e)+(0,a["default"])(t)+(0,a["default"])(r))}else if(typeof e==="object"&&t===undefined&&r===undefined){return(0,n["default"])("#"+(0,a["default"])(e.red)+(0,a["default"])(e.green)+(0,a["default"])(e.blue))}throw new i["default"](6)}e.exports=t["default"]},3458:function(e,t,r){"use strict";t.__esModule=true;t["default"]=s;var n=o(r(2053));var a=o(r(493));var i=o(r(9677));function o(e){return e&&e.__esModule?e:{"default":e}}/**
 * Returns a string value for the color. The returned result is the smallest possible rgba or hex notation.
 *
 * Can also be used to fade a color by passing a hex value or named CSS color along with an alpha value.
 *
 * @example
 * // Styles as object usage
 * const styles = {
 *   background: rgba(255, 205, 100, 0.7),
 *   background: rgba({ red: 255, green: 205, blue: 100, alpha: 0.7 }),
 *   background: rgba(255, 205, 100, 1),
 *   background: rgba('#ffffff', 0.4),
 *   background: rgba('black', 0.7),
 * }
 *
 * // styled-components usage
 * const div = styled.div`
 *   background: ${rgba(255, 205, 100, 0.7)};
 *   background: ${rgba({ red: 255, green: 205, blue: 100, alpha: 0.7 })};
 *   background: ${rgba(255, 205, 100, 1)};
 *   background: ${rgba('#ffffff', 0.4)};
 *   background: ${rgba('black', 0.7)};
 * `
 *
 * // CSS in JS Output
 *
 * element {
 *   background: "rgba(255,205,100,0.7)";
 *   background: "rgba(255,205,100,0.7)";
 *   background: "#ffcd64";
 *   background: "rgba(255,255,255,0.4)";
 *   background: "rgba(0,0,0,0.7)";
 * }
 */function s(e,t,r,o){if(typeof e==="string"&&typeof t==="number"){var s=(0,n["default"])(e);return"rgba("+s.red+","+s.green+","+s.blue+","+t+")"}else if(typeof e==="number"&&typeof t==="number"&&typeof r==="number"&&typeof o==="number"){return o>=1?(0,a["default"])(e,t,r):"rgba("+e+","+t+","+r+","+o+")"}else if(typeof e==="object"&&t===undefined&&r===undefined&&o===undefined){return e.alpha>=1?(0,a["default"])(e.red,e.green,e.blue):"rgba("+e.red+","+e.green+","+e.blue+","+e.alpha+")"}throw new i["default"](7)}e.exports=t["default"]},9677:function(e,t){"use strict";t.__esModule=true;t["default"]=void 0;function r(e){if(e===void 0){throw new ReferenceError("this hasn't been initialised - super() hasn't been called")}return e}function n(e,t){e.prototype=Object.create(t.prototype);e.prototype.constructor=e;u(e,t)}function a(e){var t=typeof Map==="function"?new Map:undefined;a=function e(e){if(e===null||!s(e))return e;if(typeof e!=="function"){throw new TypeError("Super expression must either be null or a function")}if(typeof t!=="undefined"){if(t.has(e))return t.get(e);t.set(e,r)}function r(){return i(e,arguments,l(this).constructor)}r.prototype=Object.create(e.prototype,{constructor:{value:r,enumerable:false,writable:true,configurable:true}});return u(r,e)};return a(e)}function i(e,t,r){if(o())return Reflect.construct.apply(null,arguments);var n=[null];n.push.apply(n,t);var a=new(e.bind.apply(e,n));return r&&u(a,r.prototype),a}function o(){try{var e=!Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],function(){}))}catch(e){}return(o=function t(){return!!e})()}function s(e){try{return Function.toString.call(e).indexOf("[native code]")!==-1}catch(t){return typeof e==="function"}}function u(e,t){u=Object.setPrototypeOf?Object.setPrototypeOf.bind():function e(e,t){e.__proto__=t;return e};return u(e,t)}function l(e){l=Object.setPrototypeOf?Object.getPrototypeOf.bind():function e(e){return e.__proto__||Object.getPrototypeOf(e)};return l(e)}// based on https://github.com/styled-components/styled-components/blob/fcf6f3804c57a14dd7984dfab7bc06ee2edca044/src/utils/error.js
/**
 * Parse errors.md and turn it into a simple hash of code: message
 * @private
 */var c=/* unused pure expression or super */null&&{"1":"Passed invalid arguments to hsl, please pass multiple numbers e.g. hsl(360, 0.75, 0.4) or an object e.g. rgb({ hue: 255, saturation: 0.4, lightness: 0.75 }).\n\n","2":"Passed invalid arguments to hsla, please pass multiple numbers e.g. hsla(360, 0.75, 0.4, 0.7) or an object e.g. rgb({ hue: 255, saturation: 0.4, lightness: 0.75, alpha: 0.7 }).\n\n","3":"Passed an incorrect argument to a color function, please pass a string representation of a color.\n\n","4":"Couldn't generate valid rgb string from %s, it returned %s.\n\n","5":"Couldn't parse the color string. Please provide the color as a string in hex, rgb, rgba, hsl or hsla notation.\n\n","6":"Passed invalid arguments to rgb, please pass multiple numbers e.g. rgb(255, 205, 100) or an object e.g. rgb({ red: 255, green: 205, blue: 100 }).\n\n","7":"Passed invalid arguments to rgba, please pass multiple numbers e.g. rgb(255, 205, 100, 0.75) or an object e.g. rgb({ red: 255, green: 205, blue: 100, alpha: 0.75 }).\n\n","8":"Passed invalid argument to toColorString, please pass a RgbColor, RgbaColor, HslColor or HslaColor object.\n\n","9":"Please provide a number of steps to the modularScale helper.\n\n","10":"Please pass a number or one of the predefined scales to the modularScale helper as the ratio.\n\n","11":'Invalid value passed as base to modularScale, expected number or em string but got "%s"\n\n',"12":'Expected a string ending in "px" or a number passed as the first argument to %s(), got "%s" instead.\n\n',"13":'Expected a string ending in "px" or a number passed as the second argument to %s(), got "%s" instead.\n\n',"14":'Passed invalid pixel value ("%s") to %s(), please pass a value like "12px" or 12.\n\n',"15":'Passed invalid base value ("%s") to %s(), please pass a value like "12px" or 12.\n\n',"16":"You must provide a template to this method.\n\n","17":"You passed an unsupported selector state to this method.\n\n","18":"minScreen and maxScreen must be provided as stringified numbers with the same units.\n\n","19":"fromSize and toSize must be provided as stringified numbers with the same units.\n\n","20":"expects either an array of objects or a single object with the properties prop, fromSize, and toSize.\n\n","21":"expects the objects in the first argument array to have the properties `prop`, `fromSize`, and `toSize`.\n\n","22":"expects the first argument object to have the properties `prop`, `fromSize`, and `toSize`.\n\n","23":"fontFace expects a name of a font-family.\n\n","24":"fontFace expects either the path to the font file(s) or a name of a local copy.\n\n","25":"fontFace expects localFonts to be an array.\n\n","26":"fontFace expects fileFormats to be an array.\n\n","27":"radialGradient requries at least 2 color-stops to properly render.\n\n","28":"Please supply a filename to retinaImage() as the first argument.\n\n","29":"Passed invalid argument to triangle, please pass correct pointingDirection e.g. 'right'.\n\n","30":"Passed an invalid value to `height` or `width`. Please provide a pixel based unit.\n\n","31":"The animation shorthand only takes 8 arguments. See the specification for more information: http://mdn.io/animation\n\n","32":"To pass multiple animations please supply them in arrays, e.g. animation(['rotate', '2s'], ['move', '1s'])\nTo pass a single animation please supply them in simple values, e.g. animation('rotate', '2s')\n\n","33":"The animation shorthand arrays can only have 8 elements. See the specification for more information: http://mdn.io/animation\n\n","34":"borderRadius expects a radius value as a string or number as the second argument.\n\n","35":'borderRadius expects one of "top", "bottom", "left" or "right" as the first argument.\n\n',"36":"Property must be a string value.\n\n","37":"Syntax Error at %s.\n\n","38":"Formula contains a function that needs parentheses at %s.\n\n","39":"Formula is missing closing parenthesis at %s.\n\n","40":"Formula has too many closing parentheses at %s.\n\n","41":"All values in a formula must have the same unit or be unitless.\n\n","42":"Please provide a number of steps to the modularScale helper.\n\n","43":"Please pass a number or one of the predefined scales to the modularScale helper as the ratio.\n\n","44":"Invalid value passed as base to modularScale, expected number or em/rem string but got %s.\n\n","45":"Passed invalid argument to hslToColorString, please pass a HslColor or HslaColor object.\n\n","46":"Passed invalid argument to rgbToColorString, please pass a RgbColor or RgbaColor object.\n\n","47":"minScreen and maxScreen must be provided as stringified numbers with the same units.\n\n","48":"fromSize and toSize must be provided as stringified numbers with the same units.\n\n","49":"Expects either an array of objects or a single object with the properties prop, fromSize, and toSize.\n\n","50":"Expects the objects in the first argument array to have the properties prop, fromSize, and toSize.\n\n","51":"Expects the first argument object to have the properties prop, fromSize, and toSize.\n\n","52":"fontFace expects either the path to the font file(s) or a name of a local copy.\n\n","53":"fontFace expects localFonts to be an array.\n\n","54":"fontFace expects fileFormats to be an array.\n\n","55":"fontFace expects a name of a font-family.\n\n","56":"linearGradient requries at least 2 color-stops to properly render.\n\n","57":"radialGradient requries at least 2 color-stops to properly render.\n\n","58":"Please supply a filename to retinaImage() as the first argument.\n\n","59":"Passed invalid argument to triangle, please pass correct pointingDirection e.g. 'right'.\n\n","60":"Passed an invalid value to `height` or `width`. Please provide a pixel based unit.\n\n","61":"Property must be a string value.\n\n","62":"borderRadius expects a radius value as a string or number as the second argument.\n\n","63":'borderRadius expects one of "top", "bottom", "left" or "right" as the first argument.\n\n',"64":"The animation shorthand only takes 8 arguments. See the specification for more information: http://mdn.io/animation.\n\n","65":"To pass multiple animations please supply them in arrays, e.g. animation(['rotate', '2s'], ['move', '1s'])\\nTo pass a single animation please supply them in simple values, e.g. animation('rotate', '2s').\n\n","66":"The animation shorthand arrays can only have 8 elements. See the specification for more information: http://mdn.io/animation.\n\n","67":"You must provide a template to this method.\n\n","68":"You passed an unsupported selector state to this method.\n\n","69":'Expected a string ending in "px" or a number passed as the first argument to %s(), got %s instead.\n\n',"70":'Expected a string ending in "px" or a number passed as the second argument to %s(), got %s instead.\n\n',"71":'Passed invalid pixel value %s to %s(), please pass a value like "12px" or 12.\n\n',"72":'Passed invalid base value %s to %s(), please pass a value like "12px" or 12.\n\n',"73":"Please provide a valid CSS variable.\n\n","74":"CSS variable not found and no default was provided.\n\n","75":"important requires a valid style object, got a %s instead.\n\n","76":"fromSize and toSize must be provided as stringified numbers with the same units as minScreen and maxScreen.\n\n","77":'remToPx expects a value in "rem" but you provided it in "%s".\n\n',"78":'base must be set in "px" or "%" but you set it in "%s".\n'};/**
 * super basic version of sprintf
 * @private
 */function f(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++){t[r]=arguments[r]}var n=t[0];var a=[];var i;for(i=1;i<t.length;i+=1){a.push(t[i])}a.forEach(function(e){n=n.replace(/%[a-z]/,e)});return n}/**
 * Create an error file out of errors.md for development and a simple web link to the full errors
 * in production mode.
 * @private
 */var d=t["default"]=/*#__PURE__*/function(e){n(t,e);function t(t){var n;if(true){n=e.call(this,"An error occurred. See https://github.com/styled-components/polished/blob/main/src/internalHelpers/errors.md#"+t+" for more information.")||this}else{var a,i,o}return r(n)}return t}(/*#__PURE__*/a(Error));e.exports=t["default"]},187:function(e,t){"use strict";t.__esModule=true;t["default"]=void 0;function r(e){return Math.round(e*255)}function n(e,t,n){return r(e)+","+r(t)+","+r(n)}function a(e,t,r,a){if(a===void 0){a=n}if(t===0){// achromatic
return a(r,r,r)}// formulae from https://en.wikipedia.org/wiki/HSL_and_HSV
var i=(e%360+360)%360/60;var o=(1-Math.abs(2*r-1))*t;var s=o*(1-Math.abs(i%2-1));var u=0;var l=0;var c=0;if(i>=0&&i<1){u=o;l=s}else if(i>=1&&i<2){u=s;l=o}else if(i>=2&&i<3){l=o;c=s}else if(i>=3&&i<4){l=s;c=o}else if(i>=4&&i<5){u=s;c=o}else if(i>=5&&i<6){u=o;c=s}var f=r-o/2;var d=u+f;var h=l+f;var p=c+f;return a(d,h,p)}var i=t["default"]=a;e.exports=t["default"]},7303:function(e,t){"use strict";t.__esModule=true;t["default"]=void 0;var r={aliceblue:"f0f8ff",antiquewhite:"faebd7",aqua:"00ffff",aquamarine:"7fffd4",azure:"f0ffff",beige:"f5f5dc",bisque:"ffe4c4",black:"000",blanchedalmond:"ffebcd",blue:"0000ff",blueviolet:"8a2be2",brown:"a52a2a",burlywood:"deb887",cadetblue:"5f9ea0",chartreuse:"7fff00",chocolate:"d2691e",coral:"ff7f50",cornflowerblue:"6495ed",cornsilk:"fff8dc",crimson:"dc143c",cyan:"00ffff",darkblue:"00008b",darkcyan:"008b8b",darkgoldenrod:"b8860b",darkgray:"a9a9a9",darkgreen:"006400",darkgrey:"a9a9a9",darkkhaki:"bdb76b",darkmagenta:"8b008b",darkolivegreen:"556b2f",darkorange:"ff8c00",darkorchid:"9932cc",darkred:"8b0000",darksalmon:"e9967a",darkseagreen:"8fbc8f",darkslateblue:"483d8b",darkslategray:"2f4f4f",darkslategrey:"2f4f4f",darkturquoise:"00ced1",darkviolet:"9400d3",deeppink:"ff1493",deepskyblue:"00bfff",dimgray:"696969",dimgrey:"696969",dodgerblue:"1e90ff",firebrick:"b22222",floralwhite:"fffaf0",forestgreen:"228b22",fuchsia:"ff00ff",gainsboro:"dcdcdc",ghostwhite:"f8f8ff",gold:"ffd700",goldenrod:"daa520",gray:"808080",green:"008000",greenyellow:"adff2f",grey:"808080",honeydew:"f0fff0",hotpink:"ff69b4",indianred:"cd5c5c",indigo:"4b0082",ivory:"fffff0",khaki:"f0e68c",lavender:"e6e6fa",lavenderblush:"fff0f5",lawngreen:"7cfc00",lemonchiffon:"fffacd",lightblue:"add8e6",lightcoral:"f08080",lightcyan:"e0ffff",lightgoldenrodyellow:"fafad2",lightgray:"d3d3d3",lightgreen:"90ee90",lightgrey:"d3d3d3",lightpink:"ffb6c1",lightsalmon:"ffa07a",lightseagreen:"20b2aa",lightskyblue:"87cefa",lightslategray:"789",lightslategrey:"789",lightsteelblue:"b0c4de",lightyellow:"ffffe0",lime:"0f0",limegreen:"32cd32",linen:"faf0e6",magenta:"f0f",maroon:"800000",mediumaquamarine:"66cdaa",mediumblue:"0000cd",mediumorchid:"ba55d3",mediumpurple:"9370db",mediumseagreen:"3cb371",mediumslateblue:"7b68ee",mediumspringgreen:"00fa9a",mediumturquoise:"48d1cc",mediumvioletred:"c71585",midnightblue:"191970",mintcream:"f5fffa",mistyrose:"ffe4e1",moccasin:"ffe4b5",navajowhite:"ffdead",navy:"000080",oldlace:"fdf5e6",olive:"808000",olivedrab:"6b8e23",orange:"ffa500",orangered:"ff4500",orchid:"da70d6",palegoldenrod:"eee8aa",palegreen:"98fb98",paleturquoise:"afeeee",palevioletred:"db7093",papayawhip:"ffefd5",peachpuff:"ffdab9",peru:"cd853f",pink:"ffc0cb",plum:"dda0dd",powderblue:"b0e0e6",purple:"800080",rebeccapurple:"639",red:"f00",rosybrown:"bc8f8f",royalblue:"4169e1",saddlebrown:"8b4513",salmon:"fa8072",sandybrown:"f4a460",seagreen:"2e8b57",seashell:"fff5ee",sienna:"a0522d",silver:"c0c0c0",skyblue:"87ceeb",slateblue:"6a5acd",slategray:"708090",slategrey:"708090",snow:"fffafa",springgreen:"00ff7f",steelblue:"4682b4",tan:"d2b48c",teal:"008080",thistle:"d8bfd8",tomato:"ff6347",turquoise:"40e0d0",violet:"ee82ee",wheat:"f5deb3",white:"fff",whitesmoke:"f5f5f5",yellow:"ff0",yellowgreen:"9acd32"};/**
 * Checks if a string is a CSS named color and returns its equivalent hex value, otherwise returns the original color.
 * @private
 */function n(e){if(typeof e!=="string")return e;var t=e.toLowerCase();return r[t]?"#"+r[t]:e}var a=t["default"]=n;e.exports=t["default"]},3813:function(e,t){"use strict";t.__esModule=true;t["default"]=void 0;function r(e){var t=e.toString(16);return t.length===1?"0"+t:t}var n=t["default"]=r;e.exports=t["default"]},5622:function(e,t){"use strict";t.__esModule=true;t["default"]=void 0;/**
 * Reduces hex values if possible e.g. #ff8866 to #f86
 * @private
 */var r=function e(e){if(e.length===7&&e[1]===e[2]&&e[3]===e[4]&&e[5]===e[6]){return"#"+e[1]+e[3]+e[5]}return e};var n=t["default"]=r;e.exports=t["default"]},4469:function(e){"use strict";// Copyright Joyent, Inc. and other Node contributors.
//
// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to permit
// persons to whom the Software is furnished to do so, subject to the
// following conditions:
//
// The above copyright notice and this permission notice shall be included
// in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
// OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
// NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
// DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
// OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
// USE OR OTHER DEALINGS IN THE SOFTWARE.
// If obj.hasOwnProperty has been overridden, then calling
// obj.hasOwnProperty(prop) will break.
// See: https://github.com/joyent/node/issues/1707
function t(e,t){return Object.prototype.hasOwnProperty.call(e,t)}e.exports=function(e,r,n,a){r=r||"&";n=n||"=";var i={};if(typeof e!=="string"||e.length===0){return i}var o=/\+/g;e=e.split(r);var s=1e3;if(a&&typeof a.maxKeys==="number"){s=a.maxKeys}var u=e.length;// maxKeys <= 0 means that we should not limit keys count
if(s>0&&u>s){u=s}for(var l=0;l<u;++l){var c=e[l].replace(o,"%20"),f=c.indexOf(n),d,h,p,v;if(f>=0){d=c.substr(0,f);h=c.substr(f+1)}else{d=c;h=""}p=decodeURIComponent(d);v=decodeURIComponent(h);if(!t(i,p)){i[p]=v}else if(Array.isArray(i[p])){i[p].push(v)}else{i[p]=[i[p],v]}}return i}},541:function(e){"use strict";// Copyright Joyent, Inc. and other Node contributors.
//
// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to permit
// persons to whom the Software is furnished to do so, subject to the
// following conditions:
//
// The above copyright notice and this permission notice shall be included
// in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
// OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
// NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
// DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
// OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
// USE OR OTHER DEALINGS IN THE SOFTWARE.
var t=function(e){switch(typeof e){case"string":return e;case"boolean":return e?"true":"false";case"number":return isFinite(e)?e:"";default:return""}};e.exports=function(e,r,n,a){r=r||"&";n=n||"=";if(e===null){e=undefined}if(typeof e==="object"){return Object.keys(e).map(function(a){var i=encodeURIComponent(t(a))+n;if(Array.isArray(e[a])){return e[a].map(function(e){return i+encodeURIComponent(t(e))}).join(r)}else{return i+encodeURIComponent(t(e[a]))}}).filter(Boolean).join(r)}if(!a)return"";return encodeURIComponent(t(a))+n+encodeURIComponent(t(e))}},4059:function(e,t,r){"use strict";var n;n=/* unused reexport */r(4469);n=t.stringify=r(541)},2594:function(e,t,r){"use strict";// EXPORTS
r.d(t,{_:()=>/* binding */i});// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/config/route-configs.ts
var n=function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return Object.keys(t).reduce((e,r)=>e.replace(":".concat(r),String(t[r])),e)};var a=e=>{return{template:e,buildLink:t=>n(e,t)}};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/config/route-configs.ts
var i={Home:a("/"),BundleBasics:a("/basics"),BundleAdditional:a("/additional")}},9185:function(e,t,r){"use strict";// EXPORTS
r.d(t,{A:()=>/* binding */eZ});// EXTERNAL MODULE: ./node_modules/@emotion/react/jsx-runtime/dist/emotion-react-jsx-runtime.esm.js
var n=r(3747);// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var a=r(7584);// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_object_spread_props.js
var i=r(408);// EXTERNAL MODULE: external "React"
var o=r(1594);var s=/*#__PURE__*/r.n(o);// EXTERNAL MODULE: ./node_modules/react-hook-form/dist/index.esm.mjs
var u=r(3937);// EXTERNAL MODULE: ./node_modules/@emotion/react/dist/emotion-react.esm.js
var l=r(1699);// EXTERNAL MODULE: external "wp.i18n"
var c=r(2470);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/SVGIcon.tsx
var f=r(6277);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Tooltip.tsx + 56 modules
var d=r(9773);// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_async_to_generator.js
var h=r(6838);// EXTERNAL MODULE: ./node_modules/date-fns/format.js + 29 modules
var p=r(1181);// EXTERNAL MODULE: ./node_modules/date-fns/isBefore.js
var v=r(9817);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Button.tsx
var m=r(3494);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var g=r(7317);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread_props.js
var b=r(8015);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_without_properties.js + 1 modules
var y=r(9414);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_tagged_template_literal.js
var w=r(6154);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/styles.ts
var _=r(4532);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/hooks/useAnimation.tsx + 1 modules
var x=r(4897);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/style-utils.ts
var E=r(6014);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/typography.ts
var O=r(6439);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/hooks/usePortalPopover.tsx
var S=r(4938);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/molecules/Popover.tsx
var A=r(1554);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/molecules/DropdownButton.tsx
function T(){var e=(0,w._)(["\n      padding: "," ",";\n    "]);T=function t(){return e};return e}function k(){var e=(0,w._)(["\n      font-size: ",";\n      line-height: ",";\n      padding: "," ",";\n    "]);k=function t(){return e};return e}function R(){var e=(0,w._)(["\n        background-color: ",";\n        color: ",";\n\n        &:hover,\n        &:focus,\n        &:active {\n          background-color: ",";\n          color: ",";\n        }\n      "]);R=function t(){return e};return e}function C(){var e=(0,w._)(["\n      background-color: ",";\n      color: ",";\n\n      &:not(:disabled) {\n        &:hover,\n        &:focus {\n          background-color: ",";\n          color: ",";\n        }\n\n        &:active {\n          background-color: ",";\n          color: ",";\n        }\n      }\n\n      ","\n    "]);C=function t(){return e};return e}function P(){var e=(0,w._)(["\n        background-color: ",";\n        color: ",";\n      "]);P=function t(){return e};return e}function I(){var e=(0,w._)(["\n      background-color: ",";\n      color: ",";\n\n      &:hover:not(:disabled) {\n        background-color: ",";\n      }\n\n      &:active:not(:disabled) {\n        background-color: ",";\n      }\n\n      ","\n    "]);I=function t(){return e};return e}function D(){var e=(0,w._)(["\n        color: ",";\n        box-shadow: 0 0 0 1px ",";\n      "]);D=function t(){return e};return e}function M(){var e=(0,w._)(["\n      background-color: ",";\n      color: ",";\n      box-shadow: 0 0 0 1px ",";\n\n      &:hover:not(:disabled) {\n        background-color: ",";\n      }\n\n      &:active:not(:disabled) {\n        background-color: ",";\n      }\n\n      ","\n    "]);M=function t(){return e};return e}function F(){var e=(0,w._)(["\n        color: ",";\n        box-shadow: 0 0 0 1px ",";\n      "]);F=function t(){return e};return e}function L(){var e=(0,w._)(["\n      background-color: ",";\n      color: ",";\n      box-shadow: 0 0 0 1px ",";\n\n      &:hover:not(:disabled) {\n        background-color: ",";\n        box-shadow: 0 0 0 1px ",";\n        z-index: ",";\n      }\n\n      &:active:not(:disabled) {\n        background-color: ",";\n        box-shadow: 0 0 0 1px ",";\n      }\n\n      ","\n    "]);L=function t(){return e};return e}function N(){var e=(0,w._)(["\n        background-color: ",";\n        color: ",";\n      "]);N=function t(){return e};return e}function j(){var e=(0,w._)(["\n      background-color: ",";\n      color: ",";\n\n      &:hover:not(:disabled) {\n        background-color: ",";\n      }\n\n      &:active:not(:disabled) {\n        background-color: ",";\n      }\n\n      ","\n    "]);j=function t(){return e};return e}function U(){var e=(0,w._)(["\n        color: ",";\n\n        svg {\n          color: ",";\n        }\n      "]);U=function t(){return e};return e}function H(){var e=(0,w._)(["\n      background-color: transparent;\n      color: ",";\n      padding: "," ",";\n\n      svg {\n        color: ",";\n      }\n\n      &:hover:not(:disabled) {\n        text-decoration: underline;\n        color: ",";\n\n        svg {\n          color: ",";\n        }\n      }\n\n      &:active:not(:disabled) {\n        color: ",";\n      }\n\n      &:focus:not(:disabled) {\n        color: ",";\n        svg {\n          color: ",";\n        }\n      }\n\n      ","\n    "]);H=function t(){return e};return e}function B(){var e=(0,w._)(["\n      color: transparent;\n    "]);B=function t(){return e};return e}function Y(){var e=(0,w._)(["\n      margin-right: 0;\n      margin-left: ",";\n    "]);Y=function t(){return e};return e}function z(){var e=(0,w._)(["\n      border-color: ",";\n    "]);z=function t(){return e};return e}function q(){var e=(0,w._)(["\n      border-color: ",";\n    "]);q=function t(){return e};return e}function V(){var e=(0,w._)(["\n      border-color: ",";\n    "]);V=function t(){return e};return e}function W(){var e=(0,w._)(["\n      padding-inline: ",";\n\n      svg {\n        width: 30px;\n        height: 30px;\n      }\n    "]);W=function t(){return e};return e}function $(){var e=(0,w._)(["\n      padding-inline: ",";\n\n      svg {\n        width: 20px;\n        height: 20px;\n      }\n    "]);$=function t(){return e};return e}function G(){var e=(0,w._)(["\n      color: ",";\n    "]);G=function t(){return e};return e}function K(){var e=(0,w._)(["\n      pointer-events: none;\n      color: ",";\n    "]);K=function t(){return e};return e}var Q=e=>{var{text:t,type:r="button",disabled:a=false,onClick:i,buttonContentCss:o,isDanger:s=false,icon:u}=e,l=(0,y._)(e,["text","type","disabled","onClick","buttonContentCss","isDanger","icon"]);return/*#__PURE__*/(0,n/* .jsxs */.FD)("button",(0,b._)((0,g._)({type:r,css:ee.dropdownOption({disabled:a,isDanger:s}),disabled:a,onClick:i},l),{children:[u&&/*#__PURE__*/(0,n/* .jsx */.Y)(n/* .Fragment */.FK,{children:u}),/*#__PURE__*/(0,n/* .jsx */.Y)("span",{css:[ee.dropdownOptionContent,o],children:t})]}))};var X=e=>{var{type:t="button",text:r,children:a,variant:i="primary",placement:u=S/* .POPOVER_PLACEMENTS.BOTTOM_RIGHT */.zA.BOTTOM_RIGHT,animationType:l=x/* .AnimationType.slideUp */.J6.slideUp,size:c="regular",icon:d,iconPosition:h="left",loading:p=false,disabled:v=false,tabIndex:m=-1,onClick:w,buttonCss:_,buttonContentCss:E,dropdownMaxWidth:O="140px",disabledDropdown:T=false}=e,k=(0,y._)(e,["type","text","children","variant","placement","animationType","size","icon","iconPosition","loading","disabled","tabIndex","onClick","buttonCss","buttonContentCss","dropdownMaxWidth","disabledDropdown"]);var R=(0,o.useRef)(null);var[C,P]=(0,o.useState)(false);return/*#__PURE__*/(0,n/* .jsxs */.FD)(n/* .Fragment */.FK,{children:[/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:ee.wrapper,children:[/*#__PURE__*/(0,n/* .jsxs */.FD)("button",(0,b._)((0,g._)({type:t,css:[ee.button({variant:i,size:c,loading:p,disabled:v}),_],onClick:w,tabIndex:m,disabled:v||p},k),{children:[p&&!v&&/*#__PURE__*/(0,n/* .jsx */.Y)("span",{css:ee.spinner,children:/*#__PURE__*/(0,n/* .jsx */.Y)(f/* ["default"] */.A,{name:"spinner",width:18,height:18})}),/*#__PURE__*/(0,n/* .jsxs */.FD)("span",{css:[ee.buttonContent({loading:p,disabled:v}),E],children:[d&&h==="left"&&/*#__PURE__*/(0,n/* .jsx */.Y)("span",{css:ee.buttonIcon({iconPosition:h}),children:d}),r,d&&h==="right"&&/*#__PURE__*/(0,n/* .jsx */.Y)("span",{css:ee.buttonIcon({iconPosition:h}),children:d})]})]})),/*#__PURE__*/(0,n/* .jsx */.Y)("button",{"data-cy":"dropdown-trigger",ref:R,type:"button",disabled:v||T,css:[ee.button({variant:i,size:c,loading:false,disabled:v||T}),ee.dropdownButton({variant:i,size:c,disabled:v||T})],onClick:()=>P(!C),children:/*#__PURE__*/(0,n/* .jsx */.Y)(f/* ["default"] */.A,{name:"chevronDown",width:24,height:24})})]}),/*#__PURE__*/(0,n/* .jsx */.Y)(A/* ["default"] */.A,{gap:4,maxWidth:O,placement:u,triggerRef:R,isOpen:C,closePopover:()=>P(false),animationType:l,children:/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:ee.dropdownWrapper,children:s().Children.map(a,e=>{if(/*#__PURE__*/s().isValidElement(e)){var t=(0,b._)((0,g._)({},e.props),{onClick:t=>{var r;P(false);(r=e.props)===null||r===void 0?void 0:r.onClick(t)}});return /*#__PURE__*/s().cloneElement(e,t)}return e})})})]})};X.Item=Q;/* ESM default export */const J=X;var Z=/*#__PURE__*/(0,l/* .keyframes */.i7)("0%{transform:rotate(0);}100%{transform:rotate(360deg);}");var ee={wrapper:/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.display.inlineFlex */.x.display.inlineFlex(),";align-items:center;border-radius:",_/* .borderRadius["6"] */.Vq["6"],";:focus-within{box-shadow:",_/* .shadow.focus */.r7.focus,";}"),button:e=>{var{variant:t,size:r,loading:n,disabled:a}=e;return/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.resetButton */.x.resetButton,";",O/* .typography.caption */.I.caption("medium"),"    display:inline-block;text-align:center;text-decoration:none;vertical-align:middle;cursor:pointer;user-select:none;background-color:transparent;color:",_/* .colorTokens.text.primary */.I6.text.primary,";border:0;padding:",_/* .spacing["8"] */.YK["8"]," ",_/* .spacing["16"] */.YK["16"],";border-radius:",_/* .borderRadius["6"] */.Vq["6"]," 0 0 ",_/* .borderRadius["6"] */.Vq["6"],";z-index:",_/* .zIndex.level */.fE.level,";transition-property:box-shadow,background-color,opacity;transition-duration:150ms;transition-timing-function:ease-in-out;position:relative;",r==="large"&&(0,l/* .css */.AH)(T(),_/* .spacing["12"] */.YK["12"],_/* .spacing["32"] */.YK["32"])," ",r==="small"&&(0,l/* .css */.AH)(k(),_/* .fontSize["13"] */.J["13"],_/* .lineHeight["20"] */.K_["20"],_/* .spacing["6"] */.YK["6"],_/* .spacing["16"] */.YK["16"]),"    \n    ",t==="primary"&&(0,l/* .css */.AH)(C(),_/* .colorTokens.action.primary["default"] */.I6.action.primary["default"],_/* .colorTokens.text.white */.I6.text.white,_/* .colorTokens.action.primary.hover */.I6.action.primary.hover,_/* .colorTokens.text.white */.I6.text.white,_/* .colorTokens.action.primary.active */.I6.action.primary.active,_/* .colorTokens.text.white */.I6.text.white,(a||n)&&(0,l/* .css */.AH)(R(),_/* .colorTokens.action.primary.disable */.I6.action.primary.disable,_/* .colorTokens.text.disable */.I6.text.disable,_/* .colorTokens.action.primary.disable */.I6.action.primary.disable,_/* .colorTokens.text.disable */.I6.text.disable))," ",t==="secondary"&&(0,l/* .css */.AH)(I(),_/* .colorTokens.action.secondary["default"] */.I6.action.secondary["default"],_/* .colorTokens.text.brand */.I6.text.brand,_/* .colorTokens.action.secondary.hover */.I6.action.secondary.hover,_/* .colorTokens.action.secondary.active */.I6.action.secondary.active,(a||n)&&(0,l/* .css */.AH)(P(),_/* .colorTokens.action.primary.disable */.I6.action.primary.disable,_/* .colorTokens.text.disable */.I6.text.disable))," ",t==="secondary"&&(0,l/* .css */.AH)(M(),_/* .colorTokens.action.outline["default"] */.I6.action.outline["default"],_/* .colorTokens.text.brand */.I6.text.brand,_/* .colorTokens.stroke.brand */.I6.stroke.brand,_/* .colorTokens.action.outline.hover */.I6.action.outline.hover,_/* .colorTokens.action.outline.active */.I6.action.outline.active,(a||n)&&(0,l/* .css */.AH)(D(),_/* .colorTokens.text.disable */.I6.text.disable,_/* .colorTokens.action.outline.disable */.I6.action.outline.disable))," ",t==="tertiary"&&(0,l/* .css */.AH)(L(),_/* .colorTokens.background.white */.I6.background.white,_/* .colorTokens.text.subdued */.I6.text.subdued,_/* .colorTokens.stroke["default"] */.I6.stroke["default"],_/* .colorTokens.background.hover */.I6.background.hover,_/* .colorTokens.stroke.hover */.I6.stroke.hover,_/* .zIndex.positive */.fE.positive,_/* .colorTokens.background.active */.I6.background.active,_/* .colorTokens.stroke.hover */.I6.stroke.hover,(a||n)&&(0,l/* .css */.AH)(F(),_/* .colorTokens.text.disable */.I6.text.disable,_/* .colorTokens.action.outline.disable */.I6.action.outline.disable))," ",t==="danger"&&(0,l/* .css */.AH)(j(),_/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,_/* .colorTokens.text.error */.I6.text.error,_/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,_/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,(a||n)&&(0,l/* .css */.AH)(N(),_/* .colorTokens.action.primary.disable */.I6.action.primary.disable,_/* .colorTokens.text.disable */.I6.text.disable))," ",t==="text"&&(0,l/* .css */.AH)(H(),_/* .colorTokens.text.subdued */.I6.text.subdued,_/* .spacing["4"] */.YK["4"],_/* .spacing["8"] */.YK["8"],_/* .colorTokens.icon["default"] */.I6.icon["default"],_/* .colorTokens.text.primary */.I6.text.primary,_/* .colorTokens.icon.brand */.I6.icon.brand,_/* .colorTokens.text.title */.I6.text.title,_/* .colorTokens.text.title */.I6.text.title,_/* .colorTokens.icon.brand */.I6.icon.brand,(a||n)&&(0,l/* .css */.AH)(U(),_/* .colorTokens.text.disable */.I6.text.disable,_/* .colorTokens.icon.disable */.I6.icon.disable)),":disabled{cursor:not-allowed;}")},buttonContent:e=>{var{loading:t,disabled:r}=e;return/*#__PURE__*/(0,l/* .css */.AH)("display:flex;align-items:center;",t&&!r&&(0,l/* .css */.AH)(B()))},buttonIcon:e=>{var{iconPosition:t}=e;return/*#__PURE__*/(0,l/* .css */.AH)("display:grid;place-items:center;margin-right:",_/* .spacing["6"] */.YK["6"],";",t==="right"&&(0,l/* .css */.AH)(Y(),_/* .spacing["6"] */.YK["6"]))},spinner:/*#__PURE__*/(0,l/* .css */.AH)("position:absolute;visibility:visible;display:flex;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);& svg{animation:",Z," 1.5s linear infinite;}"),dropdownButton:e=>{var{variant:t,size:r,disabled:n}=e;return/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.flexCenter */.x.flexCenter(),"    padding-inline:",_/* .spacing["8"] */.YK["8"],";border-left:1px solid transparent;border-radius:0 ",_/* .borderRadius["6"] */.Vq["6"]," ",_/* .borderRadius["6"] */.Vq["6"]," 0;svg{width:24px;height:24px;}",t==="primary"&&(0,l/* .css */.AH)(z(),_/* .colorTokens.stroke.brand */.I6.stroke.brand)," ",t==="danger"&&(0,l/* .css */.AH)(q(),_/* .colorTokens.stroke.danger */.I6.stroke.danger)," ",n&&(0,l/* .css */.AH)(V(),_/* .colorTokens.stroke.disable */.I6.stroke.disable)," ",r==="large"&&(0,l/* .css */.AH)(W(),_/* .spacing["12"] */.YK["12"])," ",r==="small"&&(0,l/* .css */.AH)($(),_/* .spacing["6"] */.YK["6"]))},dropdownWrapper:/*#__PURE__*/(0,l/* .css */.AH)("display:flex;flex-direction:column;padding-block:",_/* .spacing["6"] */.YK["6"],";"),dropdownOption:e=>{var{disabled:t,isDanger:r}=e;return/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.resetButton */.x.resetButton,";",O/* .typography.body */.I.body(),";color:",_/* .colorTokens.text.primary */.I6.text.primary,";width:100%;padding:",_/* .spacing["6"] */.YK["6"]," ",_/* .spacing["16"] */.YK["16"]," ",_/* .spacing["6"] */.YK["6"]," ",_/* .spacing["20"] */.YK["20"],";transition:background-color 0.3s ease-in-out;cursor:pointer;display:flex;align-items:center;gap:",_/* .spacing["8"] */.YK["8"],";outline:2px solid transparent;outline-offset:-2px;",r&&(0,l/* .css */.AH)(G(),_/* .colorTokens.text.error */.I6.text.error),":hover{background-color:",_/* .colorTokens.background.hover */.I6.background.hover,";color:",r?_/* .colorTokens.text.error */.I6.text.error:_/* .colorTokens.text.title */.I6.text.title,";}:focus,:active{outline-color:",_/* .colorTokens.stroke.brand */.I6.stroke.brand,";}",t&&(0,l/* .css */.AH)(K(),_/* .colorTokens.text.disable */.I6.text.disable),"    svg:first-of-type{color:",_/* .colorTokens.icon["default"] */.I6.icon["default"],";}")},dropdownOptionContent:/*#__PURE__*/(0,l/* .css */.AH)("display:flex;align-items:center;svg{flex-shrink:0;}")};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/modals/Modal.tsx
var et=r(7316);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/modals/BasicModalWrapper.tsx
var er=r(9641);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/controls/Show.tsx
var en=r(1817);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/modals/SuccessModal.tsx
var ea=e=>{var{title:t,description:r,image:a,image2x:i,imageAlt:o,closeModal:s,actions:u,wrapperCss:l,bodyCss:f}=e;return/*#__PURE__*/(0,n/* .jsx */.Y)(er/* ["default"] */.A,{onClose:()=>s({action:"CLOSE"}),entireHeader:/*#__PURE__*/(0,n/* .jsx */.Y)(n/* .Fragment */.FK,{children:" "}),maxWidth:408,children:/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:[eo.wrapper,l],children:[/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:a,children:/*#__PURE__*/(0,n/* .jsx */.Y)("img",{src:a,srcSet:i?"".concat(a," 1x, ").concat(i," 2x"):undefined,alt:o,css:eo.image})}),/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:[eo.body,f],children:[/*#__PURE__*/(0,n/* .jsx */.Y)("h5",{css:O/* .typography.heading5 */.I.heading5("medium"),children:t}),/*#__PURE__*/(0,n/* .jsx */.Y)("p",{css:eo.message,children:r})]}),/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:eo.footer,children:/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:u,fallback:/*#__PURE__*/(0,n/* .jsx */.Y)(m/* ["default"] */.A,{onClick:()=>s({action:"CLOSE"}),size:"small",children:(0,c.__)("Ok","tutor-pro")}),children:u})})]})})};/* ESM default export */const ei=ea;var eo={wrapper:/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.display.flex */.x.display.flex("column"),";padding:",_/* .spacing["24"] */.YK["24"],";gap:",_/* .spacing["24"] */.YK["24"],";"),image:/*#__PURE__*/(0,l/* .css */.AH)("width:100%;height:auto;object-position:center;object-fit:contain;"),body:/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",_/* .spacing["8"] */.YK["8"],";"),message:/*#__PURE__*/(0,l/* .css */.AH)(O/* .typography.caption */.I.caption(),";color:",_/* .colorTokens.text.subdued */.I6.text.subdued,";"),footer:/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.display.flex */.x.display.flex(),";justify-content:flex-end;gap:",_/* .spacing["16"] */.YK["16"],";padding-top:",_/* .spacing["8"] */.YK["8"],";")};// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/services/bundle.ts
var es=r(8247);// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/utils/utils.ts
var eu=r(2621);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/config.ts
var el=r(9568);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/constants.ts
var ec=r(5781);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/util.ts + 4 modules
var ef=r(6208);// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/review-submitted-2x.webp
const ed=r.p+"images/review-submitted-2x-e2f2f56c.webp";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/review-submitted.webp
const eh=r.p+"images/review-submitted-edf6b690.webp";// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/layouts/header/HeaderActions.tsx
var ep=(0,eu/* .getBundleId */.w)();var ev=()=>{var e,t,r,s,d;var g=(0,u/* .useFormContext */.xW)();var{showModal:b}=(0,et/* .useModal */.h)();var y=(0,u/* .useWatch */.FH)({name:"post_status"});var w=(0,u/* .useWatch */.FH)({name:"visibility"});var x=(0,u/* .useWatch */.FH)({name:"preview_link"});var O=(0,u/* .useWatch */.FH)({name:"isScheduleEnabled"});var S=(0,u/* .useWatch */.FH)({name:"schedule_date"});var A=(0,u/* .useWatch */.FH)({name:"schedule_time"});var[T,k]=(0,o.useState)(y);var R=(0,es/* .useSaveCourseBundleMutation */.BT)();var C=g.formState.dirtyFields.schedule_date||g.formState.dirtyFields.schedule_time;var P=(e=el/* .tutorConfig.current_user.roles */.P.current_user.roles)===null||e===void 0?void 0:e.includes(ec/* .TutorRoles.ADMINISTRATOR */.gt.ADMINISTRATOR);var I=(t=el/* .tutorConfig.current_user.roles */.P.current_user.roles)===null||t===void 0?void 0:t.includes(ec/* .TutorRoles.TUTOR_INSTRUCTOR */.gt.TUTOR_INSTRUCTOR);var D=((r=el/* .tutorConfig.settings */.P.settings)===null||r===void 0?void 0:r.instructor_can_delete_course)==="on"||P;var M=((s=el/* .tutorConfig.settings */.P.settings)===null||s===void 0?void 0:s.hide_admin_bar_for_users)==="off";var F=((d=el/* .tutorConfig.settings */.P.settings)===null||d===void 0?void 0:d.instructor_can_publish_course)==="on";var L=(e,t)=>(0,h._)(function*(){var r=(0,es/* .convertBundleFormDataToPayload */.r)(e);k(t);if(ep){var o=(0,ef/* .determinePostStatus */.q9)(t,w);var s=yield R.mutateAsync((0,a._)((0,i._)((0,a._)({},r,ep?{ID:ep}:{}),{post_status:o}),!e.isScheduleEnabled?{post_date:(0,p/* .format */.GP)(new Date,ec/* .DateFormats.yearMonthDayHourMinuteSecond24H */.UA.yearMonthDayHourMinuteSecond24H),post_date_gmt:(0,ef/* .convertToGMT */.dn)(new Date)}:{},e.isScheduleEnabled&&{edit_date:true}));if(!s.data){return}if(t==="pending"){b({component:ei,props:{title:(0,c.__)("Course Bundle submitted for review","tutor-pro"),description:(0,c.__)("Thank you for submitting your course bundle. It will be reviewed by our team shortly.","tutor-pro"),image:eh,image2x:ed,imageAlt:(0,c.__)("Course Bundle submitted for review","tutor-pro"),wrapperCss:/*#__PURE__*/(0,l/* .css */.AH)("align-items:center;text-align:center;"),actions:/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:E/* .styleUtils.flexCenter */.x.flexCenter(),children:/*#__PURE__*/(0,n/* .jsx */.Y)(m/* ["default"] */.A,{"data-cy":"back-to-course-bundles",onClick:()=>{if(window.location.href.includes("wp-admin")){window.location.href=el/* .tutorConfig.backend_bundle_list_url */.P.backend_bundle_list_url}else{window.location.href=el/* .tutorConfig.frontend_bundle_list_url */.P.frontend_bundle_list_url}},size:"small",children:(0,c.__)("Back to Course Bundles","tutor-pro")})})}})}return}})();var N=()=>{if(!F&&!P&&I){return{text:(0,c.__)("Submit","tutor-pro"),action:"pending"}}var e=(0,v/* .isBefore */.Y)(new Date,new Date("".concat(S," ").concat(A)));var t=!ep||["pending","draft"].includes(y);if(t){var r=C&&O&&e;return{text:r?(0,c.__)("Schedule","tutor-pro"):(0,c.__)("Publish","tutor-pro"),action:r?"future":"publish"}}if(O){var n=C&&e;return{text:n?(0,c.__)("Schedule","tutor-pro"):(0,c.__)("Update","tutor-pro"),action:"future"}}return{text:(0,c.__)("Update","tutor-pro"),action:"publish"}};var j=()=>{var e={text:/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:[E/* .styleUtils.display.flex */.x.display.flex(),{alignItems:"center"}],children:[(0,c.__)("Preview","tutor-pro"),/*#__PURE__*/(0,n/* .jsx */.Y)(f/* ["default"] */.A,{name:"linkExternal",width:24,height:24})]}),onClick:!ep||y==="draft"&&ep?()=>window.open(x,"_blank","noopener"):ef/* .noop */.lQ,isDanger:false,dataCy:"preview-bundle"};var t={text:/*#__PURE__*/(0,n/* .jsx */.Y)(n/* .Fragment */.FK,{children:(0,c.__)("Move to Trash","tutor-pro")}),onClick:()=>(0,h._)(function*(){if(D){try{yield g.handleSubmit(e=>L(e,"trash"))()}finally{window.location.href=window.location.href.includes("wp-admin")?el/* .tutorConfig.backend_bundle_list_url */.P.backend_bundle_list_url:el/* .tutorConfig.frontend_bundle_list_url */.P.frontend_bundle_list_url}}})(),isDanger:true,dataCy:"move-to-trash"};var r={text:/*#__PURE__*/(0,n/* .jsx */.Y)(n/* .Fragment */.FK,{children:(0,c.__)("Switch to Draft","tutor-pro")}),onClick:g.handleSubmit(e=>L(e,"draft")),isDanger:false,dataCy:"switch-to-draft"};var o={text:/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:[E/* .styleUtils.display.flex */.x.display.flex(),{alignItems:"center"}],children:[(0,c.__)("Legacy Mode","tutor-pro"),/*#__PURE__*/(0,n/* .jsx */.Y)(f/* ["default"] */.A,{name:"linkExternal",width:24,height:24})]}),onClick:()=>{var e=ep?"".concat(el/* ["default"].TUTOR_SITE_URL */.A.TUTOR_SITE_URL,"/wp-admin/post.php?post=").concat(ep,"&action=edit"):"".concat(el/* ["default"].TUTOR_SITE_URL */.A.TUTOR_SITE_URL,"/wp-admin/post-new.php?post_type=courses");window.open(e,"_blank","noopener")},isDanger:false,dataCy:"back-to-legacy"};var s={text:/*#__PURE__*/(0,n/* .jsx */.Y)(n/* .Fragment */.FK,{children:(0,c.__)("Publish Immediately","tutor-pro")}),onClick:g.handleSubmit(e=>L((0,i._)((0,a._)({},e),{isScheduleEnabled:false}),"publish")),isDanger:false,dataCy:"publish-immediately"};var u=[e];if((P||F)&&O&&(0,v/* .isBefore */.Y)(new Date,new Date("".concat(S," ").concat(A)))){u.unshift(s)}if(ep&&y!=="draft"){u.pop();if(P||F){u.push(r)}}if(y!=="trash"&&(P||D)){u.push(t)}if(P||M){u.push(o)}return u};(0,o.useEffect)(()=>{if(R.isSuccess){g.reset(g.getValues())}// eslint-disable-next-line react-hooks/exhaustive-deps
},[R.isSuccess]);return/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:em.headerRight,children:[/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:y==="draft"&&w!=="private",fallback:/*#__PURE__*/(0,n/* .jsx */.Y)(m/* ["default"] */.A,{variant:"text",icon:/*#__PURE__*/(0,n/* .jsx */.Y)(f/* ["default"] */.A,{name:"linkExternal",width:24,height:24}),iconPosition:"right",onClick:()=>window.open(x,"_blank","noopener"),disabled:!x,size:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop?"regular":"small",children:/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop,children:(0,c.__)("Preview","tutor-pro")})}),children:/*#__PURE__*/(0,n/* .jsx */.Y)(m/* ["default"] */.A,{variant:"secondary",icon:/*#__PURE__*/(0,n/* .jsx */.Y)(f/* ["default"] */.A,{name:"upload",width:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop?24:20,height:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop?24:20}),loading:T==="draft"&&R.isPending,iconPosition:"left",buttonCss:/*#__PURE__*/(0,l/* .css */.AH)("padding-inline:",_/* .spacing["16"] */.YK["16"],";"),onClick:g.handleSubmit(e=>L(e,"draft")),size:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop?"regular":"small",children:/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop,children:(0,c.__)("Save as Draft","tutor-pro")})})}),/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:j().length>1,fallback:/*#__PURE__*/(0,n/* .jsx */.Y)(m/* ["default"] */.A,{"data-cy":"bundle-builder-submit-button",size:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop?"regular":"small",loading:["publish","future","pending"].includes(T)&&R.isPending,onClick:g.handleSubmit(e=>L(e,N().action)),children:N().text}),children:/*#__PURE__*/(0,n/* .jsx */.Y)(J,{"data-cy":"bundle-builder-submit-button",text:N().text,size:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop?"regular":"small",variant:"primary",loading:["publish","future","pending"].includes(T)&&R.isPending,onClick:g.handleSubmit(e=>L(e,N().action)),dropdownMaxWidth:O&&(0,v/* .isBefore */.Y)(new Date,new Date("".concat(S," ").concat(A)))?"190px":"164px",disabledDropdown:j().length===0,children:j().map((e,t)=>/*#__PURE__*/(0,n/* .jsx */.Y)(J.Item,{text:e.text,onClick:e.onClick,isDanger:e.isDanger,"data-cy":e.dataCy},t))})})]})};var em={headerRight:/*#__PURE__*/(0,l/* .css */.AH)("display:flex;align-items:center;gap:",_/* .spacing["12"] */.YK["12"],";")};/* ESM default export */const eg=ev;// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/logo.svg
var eb,ey,ew;function e_(){return e_=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)({}).hasOwnProperty.call(r,n)&&(e[n]=r[n])}return e},e_.apply(null,arguments)}var ex=function e(e){return /*#__PURE__*/o.createElement("svg",e_({xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 108 24"},e),eb||(eb=/*#__PURE__*/o.createElement("path",{fill:"#000",fillRule:"evenodd",d:"M79.285 19.01h5.639v1.163H78.05V7.838h1.234V19.01ZM97.436 7.838v12.336h-1.234V9.706l-4.318 7.225h-.176l-4.317-7.225v10.468h-1.234V7.838h1.513l4.126 6.905 4.126-6.905zm5.991 12.548q-1.691 0-2.898-.802a4.18 4.18 0 0 1-1.683-2.212l1.057-.616q.335 1.146 1.234 1.788.898.644 2.308.643 1.374 0 2.141-.607.767-.608.767-1.613 0-.968-.705-1.463-.705-.493-2.326-1.021-1.92-.635-2.538-1.023-1.41-.845-1.41-2.45 0-1.567 1.093-2.476 1.092-.907 2.696-.907 1.445 0 2.503.749a4.55 4.55 0 0 1 1.568 1.912l-1.04.582q-.846-2.045-3.031-2.045-1.145 0-1.85.564-.705.565-.705 1.569 0 .916.635 1.374.634.459 2.096.934l.961.327q.291.097.846.316.555.221.82.388t.643.459q.379.29.546.581.168.292.299.705.133.414.132.89 0 1.57-1.145 2.51-1.145.944-3.014.944m-37.14-.202V8.099h2.337v1.207h.038c1.052-1.5 2.766-1.538 3.389-1.558v2.571a4.6 4.6 0 0 0-1.811.487c-.798.428-1.46 1.44-1.46 3.35v6.047l-2.493-.02Zm-3.635-6.034c0 2.055-1.659 3.727-3.698 3.727-2.04 0-3.698-1.672-3.698-3.728s1.659-3.727 3.698-3.727c2.04 0 3.698 1.672 3.698 3.727Zm.64-4.275a6.12 6.12 0 0 0-4.338-1.79 6.12 6.12 0 0 0-4.338 1.79 6 6 0 0 0-1.777 4.274 6 6 0 0 0 1.777 4.274 6.13 6.13 0 0 0 4.338 1.79 6.13 6.13 0 0 0 4.338-1.79 6 6 0 0 0 1.777-4.274c0-1.613-.63-3.13-1.777-4.274M50.087 20.174h-2.493V10.36h-1.81V8.082h1.81V2.906h2.493v5.176h2.18v2.278h-2.18zM34.8 8.082v5.666c0 3.292 1.46 4.168 3.31 4.168 2.065 0 3.486-1.325 3.486-4.245V8.082h2.493v12.093H41.81v-1.773h-.058c-.681 1.15-2.24 1.773-3.914 1.773-1.52 0-2.843-.487-3.797-1.325-1.11-.954-1.753-2.453-1.753-5.121V8.082zm-6.387 12.126H25.92v-9.856h-1.81V8.074h1.81V2.906h2.493v5.168h2.18v2.278h-2.18z",clipRule:"evenodd"})),ey||(ey=/*#__PURE__*/o.createElement("path",{fill:"#0049F8",fillRule:"evenodd",d:"M5.054 14.882a1.13 1.13 0 0 1-1.075-1.075V11.36c0-.592.482-1.075 1.075-1.075.592 0 1.075.483 1.075 1.075v2.447c0 .592-.445 1.075-1.002 1.075zm7.71 0c-.593 0-1.075-.444-1.075-1.037V11.36c0-.592.482-1.075 1.075-1.075.592 0 1.075.483 1.075 1.075v2.447a1.08 1.08 0 0 1-1.075 1.076Z",clipRule:"evenodd"})),ew||(ew=/*#__PURE__*/o.createElement("path",{fill:"#0049F8",fillRule:"evenodd",d:"M2.546 9.52c.48-1 1.44-1.64 2.56-1.68 1.598.04 2.88 1.398 2.841 3v5.404c.08.6.64 1 1.24.918.48-.08.88-.439.918-.918v-5.4c-.041-1.6 1.24-2.96 2.842-3.001 1.081 0 2.04.6 2.48 1.561 1.799 3.56.4 7.88-3.16 9.683a7.18 7.18 0 0 1-9.68-3.164c-1-2-1.038-4.4-.041-6.402ZM7.067 2.4h4.04v1.561A9 9 0 0 0 9.03 3.72c-.681 0-1.36.08-2 .2zm11.002 11.08c0-.24.04-.438.04-.721 0-3.28-1.76-6.281-4.64-7.881V2.4h1.761a1.18 1.18 0 0 0 1.202-1.202C16.432.518 15.91 0 15.23 0H2.946c-.68.041-1.198.559-1.198 1.24s.521 1.201 1.202 1.201h1.76v2.442c-4.363 2.396-6.003 7.88-3.603 12.239.12.2.2.359.321.558 3.4 5.722 12.521 6.281 15.602 6.32.28 0 .521-.12.76-.28.2-.2.28-.48.28-.76-.002.004-.002-9.48-.002-9.48Z",clipRule:"evenodd"})))};/* ESM default export */const eE=ex;// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/layouts/header/Logo.tsx
var eO=()=>{var e;var t=!!el/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url;return/*#__PURE__*/(0,n/* .jsx */.Y)("button",{type:"button",css:[E/* .styleUtils.resetButton */.x.resetButton,eS.logo],children:/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:t&&((e=el/* .tutorConfig.settings */.P.settings)===null||e===void 0?void 0:e.course_builder_logo_url),fallback:/*#__PURE__*/(0,n/* .jsx */.Y)(eE,{width:108,height:24}),children:e=>/*#__PURE__*/(0,n/* .jsx */.Y)("img",{src:e,alt:"Tutor LMS"})})})};var eS={logo:/*#__PURE__*/(0,l/* .css */.AH)("padding-left:",_/* .spacing["32"] */.YK["32"],";cursor:default;img{max-height:24px;width:auto;object-fit:contain;object-position:center;}",_/* .Breakpoint.smallTablet */.EA.smallTablet,"{padding-left:",_/* .spacing["24"] */.YK["24"],";}",_/* .Breakpoint.smallMobile */.EA.smallMobile,"{grid-area:logo;padding-left:",_/* .spacing["16"] */.YK["16"],";}")};/* ESM default export */const eA=eO;// EXTERNAL MODULE: ./node_modules/@swc/helpers/esm/_tagged_template_literal.js
var eT=r(9785);// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/contexts/BundleNavigatorContext.tsx
var ek=r(1573);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/controls/For.tsx
var eR=r(3313);// EXTERNAL MODULE: ./node_modules/react-router/dist/index.js
var eC=r(7767);// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/layouts/Tracker.tsx
function eP(){var e=(0,eT._)(["\n      color: ",";\n    "]);eP=function t(){return e};return e}function eI(){var e=(0,eT._)(["\n      color: ",";\n      cursor: not-allowed;\n    "]);eI=function t(){return e};return e}function eD(){var e=(0,eT._)(["\n        border-color: ",";\n        border-color: ",";\n        background-color: ",";\n        color: ",";\n      "]);eD=function t(){return e};return e}var eM=()=>{var{steps:e}=(0,ek/* .useBundleNavigator */.h)();var t=(0,eC/* .useNavigate */.Zp)();var r=(0,u/* .useFormContext */.xW)();var a=r.watch("post_title");var i=e=>(0,h._)(function*(){t(e.path)})();return/*#__PURE__*/(0,n/* .jsx */.Y)("div",{"data-cy":"tutor-tracker",css:eL.wrapper,children:/*#__PURE__*/(0,n/* .jsx */.Y)(eR/* ["default"] */.A,{each:e,children:t=>/*#__PURE__*/(0,n/* .jsxs */.FD)("button",{type:"button",css:eL.element({isActive:t.isActive,isDisabled:t.id!=="basic"&&!a}),onClick:()=>i(t),disabled:t.id!=="basic"&&!a,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("span",{"data-element-id":true,children:t.indicator}),/*#__PURE__*/(0,n/* .jsx */.Y)("span",{"data-element-name":true,"data-isActive":t.isActive,children:t.label}),/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:t.indicator<e.length,children:/*#__PURE__*/(0,n/* .jsx */.Y)("span",{"data-element-indicator":true})})]},t.id)})})};/* ESM default export */const eF=eM;var eL={wrapper:/*#__PURE__*/(0,l/* .css */.AH)("display:flex;align-items:center;"),element:e=>{var{isActive:t=false,isDisabled:r=false}=e;return/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.resetButton */.x.resetButton,";",E/* .styleUtils.display.flex */.x.display.flex(),";",O/* .typography.small */.I.small(),";padding:",_/* .spacing["4"] */.YK["4"]," ",_/* .spacing["0"] */.YK["0"]," ",_/* .spacing["4"] */.YK["4"]," ",_/* .spacing["8"] */.YK["8"],";gap:",_/* .spacing["8"] */.YK["8"],";align-items:center;&:hover,&:focus{background:none;box-shadow:none;color:",_/* .colorTokens.text.primary */.I6.text.primary,";}&:focus-visible{outline:2px solid ",_/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;border-radius:",_/* .borderRadius["4"] */.Vq["4"],";}&:is(:first-of-type){padding-left:0;}",t&&(0,l/* .css */.AH)(eP(),_/* .colorTokens.text.primary */.I6.text.primary)," ",r&&(0,l/* .css */.AH)(eI(),_/* .colorTokens.text.hints */.I6.text.hints),"    [data-element-id]{",E/* .styleUtils.display.flex */.x.display.flex(),";",O/* .typography.small */.I.small("bold"),";line-height:",_/* .lineHeight["20"] */.K_["20"],";width:24px;height:24px;border-radius:",_/* .borderRadius.circle */.Vq.circle,";justify-content:center;align-items:center;border:1px solid ",_/* .colorTokens.color.black["10"] */.I6.color.black["10"],";color:",_/* .colorTokens.text.hints */.I6.text.hints,";",t&&(0,l/* .css */.AH)(eD(),_/* .colorTokens.stroke.brand */.I6.stroke.brand,_/* .colorTokens.stroke.brand */.I6.stroke.brand,_/* .colorTokens.design.brand */.I6.design.brand,_/* .colorTokens.text.white */.I6.text.white),"}[data-element-indicator]{width:16px;height:2px;border-radius:",_/* .spacing["6"] */.YK["6"],";background-color:",_/* .colorTokens.stroke["default"] */.I6.stroke["default"],";margin-inline:4px;}",_/* .Breakpoint.smallTablet */.EA.smallTablet,"{[data-element-name]:not([data-isActive='true']){display:none;}}")}};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/modals/ConfirmationModal.tsx
var eN=r(1385);// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/layouts/header/Header.tsx
var ej=()=>{var e,t;var r=(0,u/* .useFormContext */.xW)();var{showModal:a}=(0,et/* .useModal */.h)();var i=(e=el/* .tutorConfig.current_user.roles */.P.current_user.roles)===null||e===void 0?void 0:e.includes(ec/* .TutorRoles.ADMINISTRATOR */.gt.ADMINISTRATOR);var o=((t=el/* .tutorConfig.settings */.P.settings)===null||t===void 0?void 0:t.hide_admin_bar_for_users)==="off";var s=r.formState.isDirty;var l=()=>{if(s){a({component:eN/* ["default"] */.A,props:{title:(0,c.__)("Do you want to exit without saving?","tutor-pro"),description:(0,c.__)("You’re about to leave the course bundle creation process without saving your changes.","tutor-pro"),confirmButtonText:(0,c.__)("Yes, exit without saving","tutor-pro"),confirmButtonVariant:"danger",cancelButtonText:(0,c.__)("Continue editing","tutor-pro"),maxWidth:445}}).then(e=>{if(e.action==="CONFIRM"){var t=window.location.href.includes("wp-admin");window.location.href=t?el/* .tutorConfig.backend_bundle_list_url */.P.backend_bundle_list_url:el/* .tutorConfig.frontend_bundle_list_url */.P.frontend_bundle_list_url}})}else{var e=window.location.href.includes("wp-admin");window.location.href=e?el/* .tutorConfig.backend_bundle_list_url */.P.backend_bundle_list_url:el/* .tutorConfig.frontend_bundle_list_url */.P.frontend_bundle_list_url}};return/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:eH.wrapper(i||o),children:[/*#__PURE__*/(0,n/* .jsx */.Y)(eA,{}),/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:eH.container,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:eH.titleAndTackerWrapper,children:/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:eH.titleAndTacker,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("h6",{css:eH.title,children:(0,c.__)("Course Bundle","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)("span",{css:eH.divider,"data-title-divider":true}),/*#__PURE__*/(0,n/* .jsx */.Y)(eF,{})]})}),/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop,children:/*#__PURE__*/(0,n/* .jsx */.Y)(eg,{})})]}),/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:eH.closeButtonWrapper,children:[/*#__PURE__*/(0,n/* .jsx */.Y)(en/* ["default"] */.A,{when:!ec/* .CURRENT_VIEWPORT.isAboveDesktop */.vN.isAboveDesktop,children:/*#__PURE__*/(0,n/* .jsx */.Y)(eg,{})}),/*#__PURE__*/(0,n/* .jsx */.Y)(d/* ["default"] */.A,{delay:200,content:(0,c.__)("Exit","tutor-pro"),placement:"left",children:/*#__PURE__*/(0,n/* .jsx */.Y)("button",{type:"button",css:eH.closeButton,onClick:l,children:/*#__PURE__*/(0,n/* .jsx */.Y)(f/* ["default"] */.A,{name:"cross",width:32,height:32})})})]})]})};/* ESM default export */const eU=ej;var eH={wrapper:e=>/*#__PURE__*/(0,l/* .css */.AH)("height:",_/* .headerHeight */.$A,"px;width:100%;background-color:",_/* .colorTokens.surface.navbar */.I6.surface.navbar,";border-bottom:1px solid ",_/* .colorTokens.stroke.divider */.I6.stroke.divider,";display:grid;grid-template-columns:1fr ",_/* .containerMaxWidth */.iL,"px 1fr;align-items:center;position:sticky;top:",e?ec/* .WP_ADMIN_BAR_HEIGHT */.I4:"0px",";z-index:",_/* .zIndex.header */.fE.header,";",_/* .Breakpoint.tablet */.EA.tablet,"{grid-template-columns:auto 1fr auto;top:0;}",_/* .Breakpoint.smallMobile */.EA.smallMobile,"{height:auto;padding-block:",_/* .spacing["8"] */.YK["8"],";grid-template-areas:'logo closeButton'\n        'container container';row-gap:",_/* .spacing["8"] */.YK["8"],";}"),container:/*#__PURE__*/(0,l/* .css */.AH)("max-width:",_/* .containerMaxWidth */.iL,"px;width:100%;height:",_/* .headerHeight */.$A,"px;",E/* .styleUtils.display.flex */.x.display.flex(),";justify-content:space-between;align-items:center;",_/* .Breakpoint.tablet */.EA.tablet,"{[data-title-divider]{margin-left:",_/* .spacing["12"] */.YK["12"],";}}",_/* .Breakpoint.smallMobile */.EA.smallMobile,"{height:auto;grid-area:container;order:2;justify-content:center;[data-title-divider]{display:none;}}"),titleAndTackerWrapper:/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;"),titleAndTacker:/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.display.flex */.x.display.flex(),";gap:",_/* .spacing["12"] */.YK["12"],";align-items:center;margin-right:",_/* .spacing["16"] */.YK["16"],";"),divider:/*#__PURE__*/(0,l/* .css */.AH)("width:2px;height:16px;background-color:",_/* .colorTokens.stroke.divider */.I6.stroke.divider,";border-radius:",_/* .borderRadius["20"] */.Vq["20"],";"),title:/*#__PURE__*/(0,l/* .css */.AH)(O/* .typography.body */.I.body("medium"),";color:",_/* .colorTokens.text.subdued */.I6.text.subdued,";text-transform:none;letter-spacing:normal;",_/* .Breakpoint.tablet */.EA.tablet,"{display:none;[data-title-divider]{display:none;}}"),closeButtonWrapper:/*#__PURE__*/(0,l/* .css */.AH)("display:flex;align-items:center;justify-content:flex-end;margin-right:",_/* .spacing["16"] */.YK["16"],";",_/* .Breakpoint.smallMobile */.EA.smallMobile,"{grid-area:closeButton;order:1;margin-right:",_/* .spacing["8"] */.YK["8"],";}"),closeButton:/*#__PURE__*/(0,l/* .css */.AH)(E/* .styleUtils.resetButton */.x.resetButton,";",E/* .styleUtils.flexCenter */.x.flexCenter(),";cursor:pointer;color:",_/* .colorTokens.icon["default"] */.I6.icon["default"],";margin-left:",_/* .spacing["4"] */.YK["4"],";border-radius:",_/* .borderRadius["4"] */.Vq["4"],";transition:all 0.2s ease-in-out;&:hover{background-color:",_/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,";color:",_/* .colorTokens.icon.error */.I6.icon.error,";}&:focus{box-shadow:",_/* .shadow.focus */.r7.focus,";}"),previewButton:/*#__PURE__*/(0,l/* .css */.AH)("color:",_/* .colorTokens.text.title */.I6.text.title,";svg{color:",_/* .colorTokens.icon["default"] */.I6.icon["default"],";}"),magicButton:/*#__PURE__*/(0,l/* .css */.AH)("display:inline-flex;align-items:center;gap:",_/* .spacing["4"] */.YK["4"],";padding-inline:",_/* .spacing["4"] */.YK["4"],";margin-left:",_/* .spacing["4"] */.YK["4"],";")};// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/layouts/Layout.tsx
var eB=(0,eu/* .getBundleId */.w)();var eY=()=>{var e=(0,u/* .useForm */.mN)({defaultValues:es/* .defaultCourseBundleData */.jS,shouldFocusError:true});var t=(0,es/* .useGetBundleDetailsQuery */.CV)(eB);(0,o.useEffect)(()=>{if(t.data){var r=(0,es/* .convertBundleToFormData */.vs)(t.data);e.reset(r,{keepDirtyValues:true})}// eslint-disable-next-line react-hooks/exhaustive-deps
},[t.data]);return/*#__PURE__*/(0,n/* .jsx */.Y)(u/* .FormProvider */.Op,(0,i._)((0,a._)({},e),{children:/*#__PURE__*/(0,n/* .jsx */.Y)(ek/* .BundleNavigatorProvider */.F,{children:/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:eq.wrapper,children:[/*#__PURE__*/(0,n/* .jsx */.Y)(eU,{}),/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:eq.contentWrapper,children:/*#__PURE__*/(0,n/* .jsx */.Y)(eC/* .Outlet */.sv,{})})]})})}))};/* ESM default export */const ez=eY;var eq={wrapper:/*#__PURE__*/(0,l/* .css */.AH)("background-color:",_/* .colorTokens.surface.courseBuilder */.I6.surface.courseBuilder,";"),contentWrapper:/*#__PURE__*/(0,l/* .css */.AH)("display:flex;max-width:",_/* .containerMaxWidth */.iL,"px;width:100%;min-height:calc(100vh - ",_/* .headerHeight */.$A,"px);margin:0 auto;",_/* .Breakpoint.smallTablet */.EA.smallTablet,"{padding-inline:",_/* .spacing["12"] */.YK["12"],";padding-bottom:",_/* .spacing["56"] */.YK["56"],";}")};// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/LoadingSpinner.tsx
var eV=r(8589);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/ErrorBoundary.tsx
var eW=r(74);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/RouteSuspense.tsx
var e$=e=>{var{component:t}=e;var{pathname:r}=(0,eC/* .useLocation */.zy)();return/*#__PURE__*/(0,n/* .jsx */.Y)(eW/* ["default"] */.A,{children:/*#__PURE__*/(0,n/* .jsx */.Y)(o.Suspense,{fallback:/*#__PURE__*/(0,n/* .jsx */.Y)(eV/* .LoadingOverlay */.p8,{}),children:t})},r)};/* ESM default export */const eG=e$;// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/config/route-configs.ts + 1 modules
var eK=r(2594);// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/config/routes.tsx
var eQ,eX;if(false){}else{eQ=/*#__PURE__*/s().lazy(()=>{return r.e(/* import() | bundle-builder-basic */"421").then(r.bind(r,6567))});eX=/*#__PURE__*/s().lazy(()=>{return r.e(/* import() | bundle-builder-additional */"626").then(r.bind(r,8872))})}var eJ=[{path:eK/* .BundleBuilderRouteConfigs.Home.template */._.Home.template,element:/*#__PURE__*/(0,n/* .jsx */.Y)(ez,{}),children:[{index:true,element:/*#__PURE__*/(0,n/* .jsx */.Y)(eC/* .Navigate */.C5,{to:eK/* .BundleBuilderRouteConfigs.BundleBasics.template */._.BundleBasics.template,replace:true})},{path:eK/* .BundleBuilderRouteConfigs.BundleBasics.template */._.BundleBasics.template,element:/*#__PURE__*/(0,n/* .jsx */.Y)(eG,{component:/*#__PURE__*/(0,n/* .jsx */.Y)(eQ,{})})},{path:eK/* .BundleBuilderRouteConfigs.BundleAdditional.template */._.BundleAdditional.template,element:/*#__PURE__*/(0,n/* .jsx */.Y)(eG,{component:/*#__PURE__*/(0,n/* .jsx */.Y)(eX,{})})}]},{path:"*",element:/*#__PURE__*/(0,n/* .jsx */.Y)(eC/* .Navigate */.C5,{to:eK/* .BundleBuilderRouteConfigs.Home.template */._.Home.template,replace:true})}];/* ESM default export */const eZ=eJ},1573:function(e,t,r){"use strict";r.d(t,{F:()=>w,h:()=>y});/* ESM import */var n=r(7584);/* ESM import */var a=r(408);/* ESM import */var i=r(3747);/* ESM import */var o=r(2594);/* ESM import */var s=r(9185);/* ESM import */var u=r(8247);/* ESM import */var l=r(2621);/* ESM import */var c=r(6783);/* ESM import */var f=r(7150);/* ESM import */var d=r(6208);/* ESM import */var h=r(2470);/* ESM import */var p=/*#__PURE__*/r.n(h);/* ESM import */var v=r(1594);/* ESM import */var m=/*#__PURE__*/r.n(v);var g=[{indicator:1,id:"basic",label:(0,h.__)("Basics","tutor-pro"),path:o/* .BundleBuilderRouteConfigs.BundleBasics.buildLink */._.BundleBasics.buildLink(),isDisabled:false,isActive:true},{indicator:2,id:"additional",label:(0,h.__)("Additional","tutor-pro"),path:o/* .BundleBuilderRouteConfigs.BundleAdditional.buildLink */._.BundleAdditional.buildLink(),isDisabled:true,isActive:false}];var b=/*#__PURE__*/m().createContext({steps:g,setSteps:d/* .noop */.lQ,updateStepByIndex:d/* .noop */.lQ,currentIndex:0,bundleContent:null});var y=()=>(0,v.useContext)(b);var w=e=>{var{children:t}=e;var[r,o]=(0,v.useState)(g);var d=(0,c/* .useCurrentPath */.G)(s/* ["default"] */.A);var h=(0,l/* .getBundleId */.w)();var p=(0,u/* .useGetBundleDetailsQuery */.CV)(Number(h));var m=(0,v.useMemo)(()=>{if(!p.data){return null}return p.data},[p.data]);var y=(0,v.useCallback)((e,t)=>{o(r=>{return r.map((r,a)=>{if(a===e){return(0,n._)({},r,t)}return r})})},[]);var w=(0,v.useMemo)(()=>{return r.findIndex(e=>e.path===d)},[r,d]);(0,v.useEffect)(()=>{o(e=>e.map((e,t)=>{return(0,a._)((0,n._)({},e),{isActive:t===w})}))},[w]);(0,v.useEffect)(()=>{if(!(0,f/* .isDefined */.O9)(m)){return}o(e=>e.map(e=>{return(0,a._)((0,n._)({},e),{isDisabled:false})}))},[m]);return/*#__PURE__*/(0,i/* .jsx */.Y)(b.Provider,{value:{steps:r,setSteps:o,updateStepByIndex:y,currentIndex:w,bundleContent:m},children:t})}},8247:function(e,t,r){"use strict";r.d(t,{BT:()=>T,CV:()=>S,YH:()=>R,jS:()=>_,r:()=>E,vs:()=>x});/* ESM import */var n=r(6838);/* ESM import */var a=r(7584);/* ESM import */var i=r(408);/* ESM import */var o=r(7359);/* ESM import */var s=r(241);/* ESM import */var u=r(8856);/* ESM import */var l=r(2470);/* ESM import */var c=/*#__PURE__*/r.n(l);/* ESM import */var f=r(9817);/* ESM import */var d=r(4522);/* ESM import */var h=r(1181);/* ESM import */var p=r(4857);/* ESM import */var v=r(9568);/* ESM import */var m=r(5781);/* ESM import */var g=r(9576);/* ESM import */var b=r(7105);/* ESM import */var y=r(7150);/* ESM import */var w=r(6208);var _={post_name:"",post_title:"",post_date:"",post_content:"",post_status:"draft",post_password:"",post_modified:"",course_benefits:"",visibility:"publish",thumbnail:{id:0,url:"",title:""},ribbon_type:"in_percentage",schedule_date:"",schedule_time:"",showScheduleForm:false,isScheduleEnabled:false,course_selling_option:"one_time",preview_link:"",total_enrolled:0,editor_used:{name:"classic",label:(0,l.__)("Classic Editor","tutor-pro"),link:""},tax_on_single:true,tax_on_subscription:true,certificate_for_individual_courses:true,tutor_course_certificate_template:"none",course_certificates_templates:[],details:{overview:{total_courses:0,total_topics:0,total_quizzes:0,total_assignments:0,total_video_contents:0,total_video_duration:"",total_resources:0,total_duration:"",certificate:false},authors:[],courses:[],categories:[],subtotal_price:"",subtotal_sale_price:"",subtotal_raw_price:"",subtotal_raw_sale_price:"",course_ids:[]}};var x=e=>{var t,r,n,a;var i,o,s,u,l,c,p,v,g,b,w,_,x,E,O,S,A,T,k,R,C,P,I,D,M,F,L,N,j;return{post_name:(i=e.post_name)!==null&&i!==void 0?i:"",post_title:(o=e.post_title)!==null&&o!==void 0?o:"",post_date:(s=e.post_date)!==null&&s!==void 0?s:"",post_content:(u=e.post_content)!==null&&u!==void 0?u:"",post_status:(l=e.post_status)!==null&&l!==void 0?l:"draft",post_password:(c=e.post_password)!==null&&c!==void 0?c:"",post_modified:e.post_modified,course_benefits:(p=e.course_benefits)!==null&&p!==void 0?p:"",visibility:(()=>{var t;if((t=e.post_password)===null||t===void 0?void 0:t.length){return"password_protected"}if(e.post_status==="private"){return"private"}return"publish"})(),thumbnail:{id:e.thumbnail_id,url:e.thumbnail,title:""},ribbon_type:(v=e.ribbon_type)!==null&&v!==void 0?v:"in_percentage",isScheduleEnabled:(0,f/* .isBefore */.Y)(new Date,new Date(e.post_date)),showScheduleForm:!(0,f/* .isBefore */.Y)(new Date,new Date(e.post_date)),schedule_date:!(0,f/* .isBefore */.Y)((0,d/* .parseISO */.H)(e.post_date),new Date)?(0,h/* .format */.GP)((0,d/* .parseISO */.H)(e.post_date),m/* .DateFormats.yearMonthDay */.UA.yearMonthDay):"",schedule_time:!(0,f/* .isBefore */.Y)((0,d/* .parseISO */.H)(e.post_date),new Date)?(0,h/* .format */.GP)((0,d/* .parseISO */.H)(e.post_date),m/* .DateFormats.hoursMinutes */.UA.hoursMinutes):"",course_selling_option:(g=e.course_selling_option)!==null&&g!==void 0?g:"one_time",preview_link:(b=e.preview_link)!==null&&b!==void 0?b:"",total_enrolled:(w=e.total_enrolled)!==null&&w!==void 0?w:0,editor_used:e.editor_used,tax_on_single:(0,y/* .isDefined */.O9)((t=e.tax_collection)===null||t===void 0?void 0:t.tax_on_single)?((r=e.tax_collection)===null||r===void 0?void 0:r.tax_on_single)==="1":true,tax_on_subscription:(0,y/* .isDefined */.O9)((n=e.tax_collection)===null||n===void 0?void 0:n.tax_on_subscription)?((a=e.tax_collection)===null||a===void 0?void 0:a.tax_on_subscription)==="1":true,certificate_for_individual_courses:e.certificate_for_individual_courses!=="0",tutor_course_certificate_template:(_=e.course_certificate_template)!==null&&_!==void 0?_:"none",course_certificates_templates:(x=e.course_certificates_templates)!==null&&x!==void 0?x:[],details:{overview:{total_courses:(E=e.details.overview.total_courses)!==null&&E!==void 0?E:0,total_topics:(O=e.details.overview.total_topics)!==null&&O!==void 0?O:0,total_quizzes:(S=e.details.overview.total_quizzes)!==null&&S!==void 0?S:0,total_assignments:(A=e.details.overview.total_assignments)!==null&&A!==void 0?A:0,total_video_contents:(T=e.details.overview.total_video_contents)!==null&&T!==void 0?T:0,total_video_duration:(k=e.details.overview.total_video_duration)!==null&&k!==void 0?k:"",total_resources:(R=e.details.overview.total_resources)!==null&&R!==void 0?R:0,total_duration:(C=e.details.overview.total_duration)!==null&&C!==void 0?C:"",certificate:(P=e.details.overview.certificate)!==null&&P!==void 0?P:false},authors:(I=e.details.authors)!==null&&I!==void 0?I:[],courses:(D=e.details.courses)!==null&&D!==void 0?D:[],categories:(M=e.details.categories)!==null&&M!==void 0?M:[],subtotal_price:(F=e.details.subtotal_price)!==null&&F!==void 0?F:"",subtotal_sale_price:(L=e.details.subtotal_sale_price)!==null&&L!==void 0?L:"",subtotal_raw_price:(N=e.details.subtotal_raw_price)!==null&&N!==void 0?N:"",subtotal_raw_sale_price:e.details.subtotal_raw_sale_price||"",course_ids:(j=e.details.course_ids)!==null&&j!==void 0?j:[]}}};var E=e=>{var t,r;var n;return(0,i._)((0,a._)((0,i._)((0,a._)({},e.isScheduleEnabled&&{post_date:(0,h/* .format */.GP)(new Date("".concat(e.schedule_date," ").concat(e.schedule_time)),m/* .DateFormats.yearMonthDayHourMinuteSecond24H */.UA.yearMonthDayHourMinuteSecond24H),post_date_gmt:(0,w/* .convertToGMT */.dn)(new Date("".concat(e.schedule_date," ").concat(e.schedule_time)))}),{post_name:e.post_name,post_title:e.post_title,post_content:e.post_content,post_status:e.visibility==="private"?"private":"publish",post_password:e.visibility==="password_protected"?e.post_password:"",post_modified:e.post_modified,course_benefits:e.course_benefits,thumbnail_id:(n=(t=e.thumbnail)===null||t===void 0?void 0:t.id)!==null&&n!==void 0?n:"-1",ribbon_type:e.ribbon_type,sale_price:e.details.subtotal_raw_sale_price.toString(),course_selling_option:e.course_selling_option,course_ids:e.details.courses.map(e=>e.id)}),!!((r=v/* .tutorConfig.settings */.P.settings)===null||r===void 0?void 0:r.enable_individual_tax_control)&&{tax_on_single:e.tax_on_single?"1":"0",tax_on_subscription:e.tax_on_subscription?"1":"0"}),{certificate_for_individual_courses:e.certificate_for_individual_courses?"1":"0",tutor_course_certificate_template:e.tutor_course_certificate_template})};var O=e=>(0,n._)(function*(){return g/* .wpAjaxInstance.get */.b.get(b/* ["default"].GET_BUNDLE_DETAILS */.A.GET_BUNDLE_DETAILS,{params:{bundle_id:e}})})();var S=e=>{return(0,o/* .useQuery */.I)({queryKey:["CourseBundle",e],queryFn:()=>O(e).then(e=>e.data)})};var A=e=>(0,n._)(function*(){return g/* .wpAjaxInstance.post */.b.post(b/* ["default"].UPDATE_BUNDLE */.A.UPDATE_BUNDLE,e)})();var T=()=>{var{showToast:e}=(0,p/* .useToast */.d)();var t=(0,s/* .useQueryClient */.jE)();return(0,u/* .useMutation */.n)({mutationFn:A,onSuccess:r=>{e({message:r.message,type:"success"});var n=new URLSearchParams(window.location.search).get("id");if(n){t.invalidateQueries({queryKey:["CourseBundle",parseInt(n,10)]})}},onError:t=>{e({message:(0,w/* .convertToErrorMessage */.EL)(t),type:"danger"})}})};var k=e=>(0,n._)(function*(){return g/* .wpAjaxInstance.post */.b.post(b/* ["default"].ADD_REMOVE_COURSE_TO_BUNDLE */.A.ADD_REMOVE_COURSE_TO_BUNDLE,e)})();var R=()=>{var{showToast:e}=(0,p/* .useToast */.d)();var t=(0,s/* .useQueryClient */.jE)();return(0,u/* .useMutation */.n)({mutationFn:k,onSuccess:(r,n)=>{e({message:r.message,type:"success"});t.setQueryData(["CourseBundle",n.ID],e=>{return(0,i._)((0,a._)({},e),{details:(0,a._)({},e.details,r.data)})})},onError:t=>{e({message:(0,w/* .convertToErrorMessage */.EL)(t),type:"danger"})}})}},2621:function(e,t,r){"use strict";r.d(t,{o:()=>o,w:()=>i});/* ESM import */var n=r(9568);/* ESM import */var a=r(6208);var i=()=>{var e=new URLSearchParams(window.location.search);var t=e.get("id");return Number(t)};var o=e=>{var t;// If from woocommerce convert the monetization data to appropriate format.
if(e&&((t=n/* .tutorConfig.settings */.P.settings)===null||t===void 0?void 0:t.monetize_by)==="wc"){e.map(e=>{var t;// Remove the span html tags returned by woocommerce.
var r=e.regular_price.replace(/<\/?[^>]+(>|$)/g,"");var n;var i=(n=(t=e.sale_price)===null||t===void 0?void 0:t.replace(/<\/?[^>]+(>|$)/g,""))!==null&&n!==void 0?n:null;// Get the html encoded currency string and decode it.
e.regular_price=(0,a/* .decodeHtmlEntities */.jT)(r);e.sale_price=i?(0,a/* .decodeHtmlEntities */.jT)(i):"";return e})}return e}},3494:function(e,t,r){"use strict";r.d(t,{A:()=>_});/* ESM import */var n=r(7317);/* ESM import */var a=r(8015);/* ESM import */var i=r(9414);/* ESM import */var o=r(6154);/* ESM import */var s=r(3747);/* ESM import */var u=r(1699);/* ESM import */var l=r(1594);/* ESM import */var c=/*#__PURE__*/r.n(l);/* ESM import */var f=r(6277);/* ESM import */var d=r(4532);/* ESM import */var h=r(6439);/* ESM import */var p=r(8631);/* ESM import */var v=r(6014);function m(){var e=(0,o._)(["\n      color: transparent;\n    "]);m=function t(){return e};return e}function g(){var e=(0,o._)(["\n      margin-right: 0;\n      margin-left: ",";\n    "]);g=function t(){return e};return e}function b(){var e=(0,o._)(["\n      opacity: 0;\n    "]);b=function t(){return e};return e}function y(){var e=(0,o._)(["\n      margin-inline: 0;\n    "]);y=function t(){return e};return e}var w=/*#__PURE__*/c().forwardRef((e,t)=>{var{variant:r="primary",isOutlined:o=false,size:u="regular",loading:l=false,children:c,disabled:d=false,icon:h,iconPosition:p="left",buttonCss:v,buttonContentCss:m,as:g="button",tabIndex:b,isIconOnly:y=false}=e,w=(0,i._)(e,["variant","isOutlined","size","loading","children","disabled","icon","iconPosition","buttonCss","buttonContentCss","as","tabIndex","isIconOnly"]);var _=[S({variant:r,outlined:o?r:"none",size:u,isLoading:l?"true":"false",iconOnly:y?"true":"false"}),v];var x=/*#__PURE__*/(0,s/* .jsxs */.FD)(s/* .Fragment */.FK,{children:[l&&!d&&/*#__PURE__*/(0,s/* .jsx */.Y)("span",{css:O.spinner,children:/*#__PURE__*/(0,s/* .jsx */.Y)(f/* ["default"] */.A,{name:"spinner",width:18,height:18})}),/*#__PURE__*/(0,s/* .jsxs */.FD)("span",{css:[O.buttonContent({loading:l,disabled:d}),m],children:[h&&p==="left"&&/*#__PURE__*/(0,s/* .jsx */.Y)("span",{css:O.buttonIcon({iconPosition:p,loading:l,hasChildren:!!c}),children:h}),c,h&&p==="right"&&/*#__PURE__*/(0,s/* .jsx */.Y)("span",{css:O.buttonIcon({iconPosition:p,loading:l,hasChildren:!!c}),children:h})]})]});if(g==="a"){var{href:E,target:A,rel:T,download:k,onClick:R}=w,C=(0,i._)(w,["href","target","rel","download","onClick"]);// Auto-add security attributes for external links
var P=typeof E==="string"&&(E.startsWith("http")||E.startsWith("//"));var I=A==="_blank"&&P?"".concat(T?"".concat(T," "):"","noopener noreferrer"):T;return/*#__PURE__*/(0,s/* .jsx */.Y)("a",(0,a._)((0,n._)({ref:t,css:_,href:d||l?undefined:E,target:d||l?undefined:A,rel:I,download:d||l?undefined:k,tabIndex:d||l?-1:b,"aria-disabled":d||l,onClick:d||l?e=>e.preventDefault():R,role:"button","data-size":u},C),{children:x}))}var{type:D="button",onClick:M,form:F,name:L,value:N}=w,j=(0,i._)(w,["type","onClick","form","name","value"]);return/*#__PURE__*/(0,s/* .jsx */.Y)("button",(0,a._)((0,n._)({ref:t,type:D,css:_,disabled:d||l,tabIndex:b,onClick:M,form:F,name:L,value:N,"data-size":u},j),{children:x}))});w.displayName="Button";/* ESM default export */const _=w;var x=/*#__PURE__*/(0,u/* .keyframes */.i7)("0%{transform:rotate(0);}100%{transform:rotate(360deg);}");var E={notOutlined:/*#__PURE__*/(0,u/* .css */.AH)("&:disabled,&[aria-disabled='true']{background-color:",d/* .colorTokens.action.primary.disable */.I6.action.primary.disable,";color:",d/* .colorTokens.text.disable */.I6.text.disable,";svg{color:",d/* .colorTokens.icon.disable["default"] */.I6.icon.disable["default"],";}}"),outlined:/*#__PURE__*/(0,u/* .css */.AH)("&:disabled,&[aria-disabled='true']{background-color:transparent;border:none;box-shadow:inset 0px 0px 0px 1px ",d/* .colorTokens.action.outline.disable */.I6.action.outline.disable,";color:",d/* .colorTokens.text.disable */.I6.text.disable,";svg{color:",d/* .colorTokens.icon.disable["default"] */.I6.icon.disable["default"],";}}"),text:/*#__PURE__*/(0,u/* .css */.AH)("&:disabled,&[aria-disabled='true']{color:",d/* .colorTokens.text.disable */.I6.text.disable,";svg{color:",d/* .colorTokens.icon.disable["default"] */.I6.icon.disable["default"],";}}")};var O={base:/*#__PURE__*/(0,u/* .css */.AH)(v/* .styleUtils.resetButton */.x.resetButton,";",v/* .styleUtils.display.inlineFlex */.x.display.inlineFlex(),";justify-content:center;align-items:center;",h/* .typography.caption */.I.caption("medium"),";",v/* .styleUtils.text.align.center */.x.text.align.center,";color:",d/* .colorTokens.text.white */.I6.text.white,";text-decoration:none;vertical-align:middle;cursor:pointer;user-select:none;background-color:transparent;border:0;padding:",d/* .spacing["8"] */.YK["8"]," ",d/* .spacing["32"] */.YK["32"],";border-radius:",d/* .borderRadius["6"] */.Vq["6"],";z-index:",d/* .zIndex.level */.fE.level,";transition:all 150ms ease-in-out;position:relative;svg{color:",d/* .colorTokens.icon.white */.I6.icon.white,";}&:disabled,&[aria-disabled='true']{cursor:not-allowed;}&:not(:disabled):not([aria-disabled='true']){&:focus{box-shadow:",d/* .shadow.focus */.r7.focus,";}&:focus-visible{box-shadow:none;outline:2px solid ",d/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}}"),variant:{primary:/*#__PURE__*/(0,u/* .css */.AH)("background-color:",d/* .colorTokens.action.primary["default"] */.I6.action.primary["default"],";",E.notOutlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{color:",d/* .colorTokens.text.white */.I6.text.white,";background-color:",d/* .colorTokens.action.primary.hover */.I6.action.primary.hover,";}&:active{background-color:",d/* .colorTokens.action.primary.active */.I6.action.primary.active,";color:",d/* .colorTokens.text.white */.I6.text.white,";svg{color:",d/* .colorTokens.icon.white */.I6.icon.white,";}}}"),secondary:/*#__PURE__*/(0,u/* .css */.AH)("background-color:",d/* .colorTokens.action.secondary["default"] */.I6.action.secondary["default"],";color:",d/* .colorTokens.text.brand */.I6.text.brand,";svg{color:",d/* .colorTokens.icon.brand */.I6.icon.brand,";}",E.notOutlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{background-color:",d/* .colorTokens.action.secondary.hover */.I6.action.secondary.hover,";color:",d/* .colorTokens.text.brand */.I6.text.brand,";}&:active{background-color:",d/* .colorTokens.action.secondary.active */.I6.action.secondary.active,";color:",d/* .colorTokens.text.brand */.I6.text.brand,";}}"),tertiary:/*#__PURE__*/(0,u/* .css */.AH)("box-shadow:inset 0px 0px 0px 1px ",d/* .colorTokens.stroke["default"] */.I6.stroke["default"],";color:",d/* .colorTokens.text.subdued */.I6.text.subdued,";svg{color:",d/* .colorTokens.icon.hints */.I6.icon.hints,";}",E.outlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{background-color:",d/* .colorTokens.background.hover */.I6.background.hover,";box-shadow:inset 0px 0px 0px 1px ",d/* .colorTokens.stroke.hover */.I6.stroke.hover,";color:",d/* .colorTokens.text.title */.I6.text.title,";svg{color:",d/* .colorTokens.icon.brand */.I6.icon.brand,";}}&:active{background-color:",d/* .colorTokens.background.active */.I6.background.active,";svg{color:",d/* .colorTokens.icon.hints */.I6.icon.hints,";}}}"),danger:/*#__PURE__*/(0,u/* .css */.AH)("background-color:",d/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,";color:",d/* .colorTokens.text.error */.I6.text.error,";svg{color:",d/* .colorTokens.icon.error */.I6.icon.error,";}",E.notOutlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus,&:active{background-color:",d/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,";color:",d/* .colorTokens.text.error */.I6.text.error,";}}"),WP:/*#__PURE__*/(0,u/* .css */.AH)("background-color:",d/* .colorTokens.action.primary.wp */.I6.action.primary.wp,";",E.notOutlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{background-color:",d/* .colorTokens.action.primary.wp_hover */.I6.action.primary.wp_hover,";color:",d/* .colorTokens.text.white */.I6.text.white,";}&:active{background-color:",d/* .colorTokens.action.primary.wp */.I6.action.primary.wp,";}}"),text:/*#__PURE__*/(0,u/* .css */.AH)("background-color:transparent;color:",d/* .colorTokens.text.subdued */.I6.text.subdued,";padding:",d/* .spacing["8"] */.YK["8"],";svg{color:",d/* .colorTokens.icon.hints */.I6.icon.hints,";}",E.text,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{background-color:transparent;color:",d/* .colorTokens.text.brand */.I6.text.brand,";svg{color:",d/* .colorTokens.icon.brand */.I6.icon.brand,";}}&:active{background-color:transparent;color:",d/* .colorTokens.text.subdued */.I6.text.subdued,";}}")},outlined:{primary:/*#__PURE__*/(0,u/* .css */.AH)("background-color:transparent;box-shadow:inset 0px 0px 0px 1px ",d/* .colorTokens.stroke.brand */.I6.stroke.brand,";color:",d/* .colorTokens.text.brand */.I6.text.brand,";svg{color:",d/* .colorTokens.icon.brand */.I6.icon.brand,";}",E.outlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{color:",d/* .colorTokens.text.white */.I6.text.white,";svg{color:",d/* .colorTokens.icon.white */.I6.icon.white,";}}}"),secondary:/*#__PURE__*/(0,u/* .css */.AH)("background-color:transparent;box-shadow:inset 0px 0px 0px 1px ",d/* .colorTokens.stroke.brand */.I6.stroke.brand,";color:",d/* .colorTokens.text.brand */.I6.text.brand,";svg{color:",d/* .colorTokens.icon.brand */.I6.icon.brand,";}",E.outlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{background-color:",d/* .colorTokens.action.secondary.hover */.I6.action.secondary.hover,";}}"),tertiary:/*#__PURE__*/(0,u/* .css */.AH)("background-color:transparent;",E.outlined,";"),danger:/*#__PURE__*/(0,u/* .css */.AH)("background-color:transparent;border:1px solid ",d/* .colorTokens.stroke.danger */.I6.stroke.danger,";",E.outlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{background-color:",d/* .colorTokens.background.status.errorFail */.I6.background.status.errorFail,";}}"),WP:/*#__PURE__*/(0,u/* .css */.AH)("background-color:transparent;border:1px solid ",d/* .colorTokens.action.primary.wp */.I6.action.primary.wp,";color:",d/* .colorTokens.action.primary.wp */.I6.action.primary.wp,";svg{color:",d/* .colorTokens.icon.wp */.I6.icon.wp,";}",E.outlined,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{background-color:",d/* .colorTokens.action.primary.wp_hover */.I6.action.primary.wp_hover,";color:",d/* .colorTokens.text.white */.I6.text.white,";svg{color:",d/* .colorTokens.icon.white */.I6.icon.white,";}}}"),text:/*#__PURE__*/(0,u/* .css */.AH)("background-color:transparent;border:none;color:",d/* .colorTokens.text.primary */.I6.text.primary,";",E.text,";&:not(:disabled):not([aria-disabled='true']){&:hover,&:focus{color:",d/* .colorTokens.text.brand */.I6.text.brand,";}}"),none:/*#__PURE__*/(0,u/* .css */.AH)()},size:{regular:/*#__PURE__*/(0,u/* .css */.AH)("padding:",d/* .spacing["8"] */.YK["8"]," ",d/* .spacing["32"] */.YK["32"],";",h/* .typography.caption */.I.caption("medium"),";color:",d/* .colorTokens.text.white */.I6.text.white,";min-height:40px;"),large:/*#__PURE__*/(0,u/* .css */.AH)("padding:",d/* .spacing["12"] */.YK["12"]," ",d/* .spacing["40"] */.YK["40"],";",h/* .typography.body */.I.body("medium"),";color:",d/* .colorTokens.text.white */.I6.text.white,";min-height:48px;"),small:/*#__PURE__*/(0,u/* .css */.AH)("padding:",d/* .spacing["6"] */.YK["6"]," ",d/* .spacing["16"] */.YK["16"],";",h/* .typography.small */.I.small("medium"),";color:",d/* .colorTokens.text.white */.I6.text.white,";min-height:32px;")},isIconOnly:{true:/*#__PURE__*/(0,u/* .css */.AH)("aspect-ratio:1 / 1;&[data-size='regular']{padding:",d/* .spacing["8"] */.YK["8"],";width:40px;}&[data-size='large']{padding:",d/* .spacing["12"] */.YK["12"],";width:48px;}&[data-size='small']{padding:",d/* .spacing["6"] */.YK["6"],";width:32px;}"),false:/*#__PURE__*/(0,u/* .css */.AH)()},isLoading:{true:/*#__PURE__*/(0,u/* .css */.AH)("opacity:0.8;cursor:wait;"),false:/*#__PURE__*/(0,u/* .css */.AH)()},iconWrapper:{left:/*#__PURE__*/(0,u/* .css */.AH)("order:-1;"),right:/*#__PURE__*/(0,u/* .css */.AH)("order:1;")},buttonContent:e=>{var{loading:t,disabled:r,isIconOnly:n}=e;return/*#__PURE__*/(0,u/* .css */.AH)(v/* .styleUtils.display.flex */.x.display.flex(),";align-items:center;",n&&"justify-content: center;"," ",t&&!r&&(0,u/* .css */.AH)(m()))},buttonIcon:e=>{var{iconPosition:t,loading:r,hasChildren:n=true}=e;return/*#__PURE__*/(0,u/* .css */.AH)("display:grid;place-items:center;margin-right:",d/* .spacing["4"] */.YK["4"],";",t==="right"&&(0,u/* .css */.AH)(g(),d/* .spacing["4"] */.YK["4"])," ",r&&(0,u/* .css */.AH)(b())," ",!n&&(0,u/* .css */.AH)(y()))},spinner:/*#__PURE__*/(0,u/* .css */.AH)("position:absolute;visibility:visible;display:flex;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);& svg{animation:",x," 1s linear infinite;}")};var S=(0,p/* .createVariation */.s)({variants:{size:{regular:O.size.regular,large:O.size.large,small:O.size.small},isLoading:{true:O.isLoading.true,false:O.isLoading.false},iconOnly:{true:O.isIconOnly.true,false:O.isIconOnly.false},variant:{primary:O.variant.primary,secondary:O.variant.secondary,tertiary:O.variant.tertiary,danger:O.variant.danger,WP:O.variant.WP,text:O.variant.text},outlined:{primary:O.outlined.primary,secondary:O.outlined.secondary,tertiary:O.outlined.tertiary,danger:O.outlined.danger,WP:O.outlined.WP,text:O.outlined.text,none:O.outlined.none}},defaultVariants:{variant:"primary",outlined:"none",size:"regular",isLoading:"false",iconOnly:"false"}},O.base)},8589:function(e,t,r){"use strict";r.d(t,{Ay:()=>v,YE:()=>d,p8:()=>f});/* ESM import */var n=r(3747);/* ESM import */var a=r(4532);/* ESM import */var i=r(1699);var o=/*#__PURE__*/(0,i/* .keyframes */.i7)("0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}");var s=/*#__PURE__*/(0,i/* .keyframes */.i7)("0%{stroke-dashoffset:180;transform:rotate(0deg);}50%{stroke-dashoffset:",180/4,";transform:rotate(135deg);}100%{stroke-dashoffset:180;transform:rotate(360deg);}");var u=/*#__PURE__*/(0,i/* .keyframes */.i7)("	0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}");var l={fullscreen:/*#__PURE__*/(0,i/* .css */.AH)("display:flex;align-items:center;justify-content:center;height:100vh;width:100vw;"),loadingOverlay:/*#__PURE__*/(0,i/* .css */.AH)("position:absolute;top:0;bottom:0;right:0;left:0;display:flex;align-items:center;justify-content:center;"),loadingSection:/*#__PURE__*/(0,i/* .css */.AH)("width:100%;height:100px;display:flex;justify-content:center;align-items:center;"),svg:/*#__PURE__*/(0,i/* .css */.AH)("animation:",o," 1.4s linear infinite;"),spinnerPath:/*#__PURE__*/(0,i/* .css */.AH)("stroke-dasharray:180;stroke-dashoffset:0;transform-origin:center;animation:",s," 1.4s linear infinite;"),spinGradient:/*#__PURE__*/(0,i/* .css */.AH)("transition:transform;transform-origin:center;animation:",u," 1s infinite linear;")};var c=e=>{var{size:t=30,color:r=a/* .colorTokens.icon.disable["default"] */.I6.icon.disable["default"]}=e;return/*#__PURE__*/(0,n/* .jsx */.Y)("svg",{width:t,height:t,css:l.svg,viewBox:"0 0 86 86",xmlns:"http://www.w3.org/2000/svg",children:/*#__PURE__*/(0,n/* .jsx */.Y)("circle",{css:l.spinnerPath,fill:"none",stroke:r,strokeWidth:"6",strokeLinecap:"round",cx:"43",cy:"43",r:"30"})})};var f=()=>{return/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:l.loadingOverlay,children:/*#__PURE__*/(0,n/* .jsx */.Y)(c,{})})};var d=()=>{return/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:l.loadingSection,children:/*#__PURE__*/(0,n/* .jsx */.Y)(c,{})})};var h=()=>{return /*#__PURE__*/_jsx("div",{css:l.fullscreen,children:/*#__PURE__*/_jsx(c,{})})};var p=e=>{var{size:t=24}=e;return /*#__PURE__*/_jsxs("svg",{width:t,height:t,viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[/*#__PURE__*/_jsx("path",{d:"M12 3C10.22 3 8.47991 3.52784 6.99987 4.51677C5.51983 5.50571 4.36628 6.91131 3.68509 8.55585C3.0039 10.2004 2.82567 12.01 3.17294 13.7558C3.5202 15.5016 4.37737 17.1053 5.63604 18.364C6.89472 19.6226 8.49836 20.4798 10.2442 20.8271C11.99 21.1743 13.7996 20.9961 15.4442 20.3149C17.0887 19.6337 18.4943 18.4802 19.4832 17.0001C20.4722 15.5201 21 13.78 21 12",stroke:"url(#paint0_linear_2402_3559)",strokeWidth:"2",strokeLinecap:"round",strokeLinejoin:"round",css:l.spinGradient}),/*#__PURE__*/_jsx("defs",{children:/*#__PURE__*/_jsxs("linearGradient",{id:"paint0_linear_2402_3559",x1:"4.50105",y1:"12",x2:"21.6571",y2:"6.7847",gradientUnits:"userSpaceOnUse",children:[/*#__PURE__*/_jsx("stop",{stopColor:"#FF9645"}),/*#__PURE__*/_jsx("stop",{offset:"0.152804",stopColor:"#FF6471"}),/*#__PURE__*/_jsx("stop",{offset:"0.467993",stopColor:"#CF6EBD"}),/*#__PURE__*/_jsx("stop",{offset:"0.671362",stopColor:"#A477D1"}),/*#__PURE__*/_jsx("stop",{offset:"1",stopColor:"#3E64DE"})]})})]})};/* ESM default export */const v=c},6277:function(e,t,r){"use strict";r.d(t,{A:()=>m});/* ESM import */var n=r(7317);/* ESM import */var a=r(8015);/* ESM import */var i=r(9414);/* ESM import */var o=r(6154);/* ESM import */var s=r(3747);/* ESM import */var u=r(9568);/* ESM import */var l=r(1699);/* ESM import */var c=r(1594);/* ESM import */var f=/*#__PURE__*/r.n(c);function d(){var e=(0,o._)(["\n      filter: grayscale(100%);\n    "]);d=function t(){return e};return e}var h={};var p=e=>{var{name:t,width:r=16,height:o=16,style:u,isColorIcon:l=false}=e,f=(0,i._)(e,["name","width","height","style","isColorIcon"]);var d,p;var[m,b]=(0,c.useState)(((d=h[t])===null||d===void 0?void 0:d.icon)||null);var[y,w]=(0,c.useState)(!((p=h[t])===null||p===void 0?void 0:p.icon));(0,c.useEffect)(()=>{var e;if((e=h[t])===null||e===void 0?void 0:e.icon){b(h[t].icon);w(false);return}w(true);v(t,r,o).then(e=>{b(e)}).catch(()=>{b(null)}).finally(()=>{w(false)})},[t,r,o]);var _=(0,n._)({},l&&{"data-colorize":true},f);var x=m?m.viewBox:"0 0 ".concat(r," ").concat(o);if(!m&&!y){return/*#__PURE__*/(0,s/* .jsx */.Y)("svg",{viewBox:x,children:/*#__PURE__*/(0,s/* .jsx */.Y)("rect",{width:r,height:o,fill:"transparent"})})}return/*#__PURE__*/(0,s/* .jsx */.Y)("svg",(0,a._)((0,n._)({css:[u,{width:r,height:o},g.svg({isColorIcon:l})],xmlns:"http://www.w3.org/2000/svg",viewBox:x},_),{role:"presentation","aria-hidden":true,dangerouslySetInnerHTML:{__html:m?m.icon:""}}))};function v(e,t,r){var n,a;if((n=h[e])===null||n===void 0?void 0:n.icon){// Icon already loaded
return Promise.resolve(h[e].icon)}if((a=h[e])===null||a===void 0?void 0:a.promise){// Fetch already in progress, return existing promise
return h[e].promise}var i=e.trim().replace(/[A-Z]/g,e=>"-"+e.toLowerCase());var o="".concat(u/* .tutorConfig.tutor_url */.P.tutor_url,"/assets/icons/").concat(i,".svg");var s=fetch(o).then(t=>{if(!t.ok){throw new Error("Failed to load icon: ".concat(e))}return t.text()}).then(n=>{var a=new DOMParser;var i=a.parseFromString(n,"image/svg+xml");var o=i.querySelector("svg");var s=(o===null||o===void 0?void 0:o.getAttribute("viewBox"))||"0 0 ".concat(t," ").concat(r);var u=(o===null||o===void 0?void 0:o.innerHTML)||"";var l={viewBox:s,icon:u};h[e]={icon:l};return l}).catch(t=>{h[e]={error:t};throw t});h[e]={loading:true,promise:s};return s}p.displayName="SVGIcon";/* ESM default export */const m=/*#__PURE__*/(0,c.memo)(p,(e,t)=>{var r,n;return e.name===t.name&&e.height===t.height&&e.width===t.height&&e.isColorIcon===t.isColorIcon&&((r=e.style)===null||r===void 0?void 0:r.name)===((n=t.style)===null||n===void 0?void 0:n.name)});var g={svg:e=>{var{isColorIcon:t=false}=e;return/*#__PURE__*/(0,l/* .css */.AH)("transition:filter 0.3s ease-in-out;",t&&(0,l/* .css */.AH)(d()),";")}}},4857:function(e,t,r){"use strict";r.d(t,{A:()=>I,d:()=>C});/* ESM import */var n=r(7317);/* ESM import */var a=r(8015);/* ESM import */var i=r(6154);/* ESM import */var o=r(3747);/* ESM import */var s=r(1699);/* ESM import */var u=r(28);/* ESM import */var l=r(1594);/* ESM import */var c=/*#__PURE__*/r.n(l);/* ESM import */var f=r(4532);/* ESM import */var d=r(6439);/* ESM import */var h=r(4897);/* ESM import */var p=r(7150);/* ESM import */var v=r(6208);/* ESM import */var m=r(3494);/* ESM import */var g=r(6277);function b(){var e=(0,i._)(["\n      left: ",";\n      top: calc("," + 60px);\n    "]);b=function t(){return e};return e}function y(){var e=(0,i._)(["\n      right: ",";\n      top: calc("," + 60px);\n    "]);y=function t(){return e};return e}function w(){var e=(0,i._)(["\n      left: 50%;\n      top: calc("," + 60px);\n      transform: translateX(-50%);\n    "]);w=function t(){return e};return e}function _(){var e=(0,i._)(["\n      left: ",";\n      bottom: ",";\n    "]);_=function t(){return e};return e}function x(){var e=(0,i._)(["\n      right: ",";\n      bottom: ",";\n    "]);x=function t(){return e};return e}function E(){var e=(0,i._)(["\n      left: 50%;\n      bottom: ",";\n      transform: translateX(-50%);\n    "]);E=function t(){return e};return e}function O(){var e=(0,i._)(["\n      background: ",";\n    "]);O=function t(){return e};return e}function S(){var e=(0,i._)(["\n      background: ",";\n    "]);S=function t(){return e};return e}function A(){var e=(0,i._)(["\n      background: ",";\n    "]);A=function t(){return e};return e}function T(){var e=(0,i._)(["\n      background: ",";\n\n      h5 {\n        color: ",";\n      }\n\n      svg > path {\n        color: ",";\n      }\n    "]);T=function t(){return e};return e}var k={type:"dark",message:"",autoCloseDelay:3e3,position:"bottom-right"};var R=/*#__PURE__*/c().createContext({showToast:()=>{}});var C=()=>(0,l.useContext)(R);var P=e=>{var{children:t,position:r="bottom-right"}=e;var[i,s]=(0,l.useState)([]);var c=(0,u/* .useTransition */.pn)(i,{from:{opacity:0,y:-40},enter:{opacity:1,y:0},leave:{opacity:.5,y:100},config:{duration:300}});var f=(0,l.useCallback)(e=>{var t=(0,a._)((0,n._)({},k,e),{id:(0,v/* .nanoid */.Ak)()});s(e=>[t,...e]);var r;if(!(0,p/* .isBoolean */.Lm)(t.autoCloseDelay)&&t.autoCloseDelay){r=setTimeout(()=>{s(e=>e.slice(0,-1))},t.autoCloseDelay)}return()=>{clearTimeout(r)}},[]);return/*#__PURE__*/(0,o/* .jsxs */.FD)(R.Provider,{value:{showToast:f},children:[t,/*#__PURE__*/(0,o/* .jsx */.Y)("div",{css:D.toastWrapper(r),children:c((e,t)=>{return/*#__PURE__*/(0,o/* .jsxs */.FD)(h/* .AnimatedDiv */.LK,{"data-cy":"tutor-toast",style:e,css:D.toastItem(t.type),children:[/*#__PURE__*/(0,o/* .jsx */.Y)("h5",{css:D.message,children:t.message}),/*#__PURE__*/(0,o/* .jsx */.Y)(m/* ["default"] */.A,{variant:"text",onClick:()=>{s(e=>e.filter(e=>e.id!==t.id))},children:/*#__PURE__*/(0,o/* .jsx */.Y)(g/* ["default"] */.A,{name:"timesAlt",width:16,height:16})})]},t.id)})})]})};/* ESM default export */const I=P;var D={toastWrapper:e=>/*#__PURE__*/(0,s/* .css */.AH)("display:flex;flex-direction:column;gap:",f/* .spacing["16"] */.YK["16"],";max-width:400px;position:fixed;z-index:",f/* .zIndex.highest */.fE.highest,";",e==="top-left"&&(0,s/* .css */.AH)(b(),f/* .spacing["20"] */.YK["20"],f/* .spacing["20"] */.YK["20"])," ",e==="top-right"&&(0,s/* .css */.AH)(y(),f/* .spacing["20"] */.YK["20"],f/* .spacing["20"] */.YK["20"])," ",e==="top-center"&&(0,s/* .css */.AH)(w(),f/* .spacing["20"] */.YK["20"])," ",e==="bottom-left"&&(0,s/* .css */.AH)(_(),f/* .spacing["20"] */.YK["20"],f/* .spacing["20"] */.YK["20"])," ",e==="bottom-right"&&(0,s/* .css */.AH)(x(),f/* .spacing["20"] */.YK["20"],f/* .spacing["20"] */.YK["20"])," ",e==="bottom-center"&&(0,s/* .css */.AH)(E(),f/* .spacing["20"] */.YK["20"])),toastItem:e=>/*#__PURE__*/(0,s/* .css */.AH)("width:100%;min-height:60px;display:flex;align-items:center;justify-content:space-between;gap:",f/* .spacing["16"] */.YK["16"],";border-radius:",f/* .borderRadius["6"] */.Vq["6"],";padding:",f/* .spacing["16"] */.YK["16"],";svg > path{color:",f/* .colorTokens.icon.white */.I6.icon.white,";}",e==="dark"&&(0,s/* .css */.AH)(O(),f/* .colorTokens.color.black.main */.I6.color.black.main)," ",e==="danger"&&(0,s/* .css */.AH)(S(),f/* .colorTokens.design.error */.I6.design.error)," ",e==="success"&&(0,s/* .css */.AH)(A(),f/* .colorTokens.design.success */.I6.design.success)," ",e==="warning"&&(0,s/* .css */.AH)(T(),f/* .colorTokens.color.warning["70"] */.I6.color.warning["70"],f/* .colorTokens.text.primary */.I6.text.primary,f/* .colorTokens.text.primary */.I6.text.primary)),message:/*#__PURE__*/(0,s/* .css */.AH)(d/* .typography.body */.I.body(),";color:",f/* .colorTokens.text.white */.I6.text.white,";"),timesIcon:/*#__PURE__*/(0,s/* .css */.AH)("path{color:",f/* .colorTokens.icon.white */.I6.icon.white,";}")}},9773:function(e,t,r){"use strict";// EXPORTS
r.d(t,{A:()=>/* binding */r0});// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var n=r(7317);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread_props.js
var a=r(8015);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_tagged_template_literal.js
var i=r(6154);// EXTERNAL MODULE: ./node_modules/@emotion/react/jsx-runtime/dist/emotion-react-jsx-runtime.esm.js
var o=r(3747);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/styles.ts
var s=r(4532);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/hooks/useAnimation.tsx + 1 modules
var u=r(4897);// EXTERNAL MODULE: ./node_modules/@emotion/react/dist/emotion-react.esm.js
var l=r(1699);// EXTERNAL MODULE: ../tutor/node_modules/@react-spring/web/dist/react-spring_web.modern.mjs + 4 modules
var c=r(28);// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getWindow.js
function f(e){if(e==null){return window}if(e.toString()!=="[object Window]"){var t=e.ownerDocument;return t?t.defaultView||window:window}return e};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/instanceOf.js
function d(e){var t=f(e).Element;return e instanceof t||e instanceof Element}function h(e){var t=f(e).HTMLElement;return e instanceof t||e instanceof HTMLElement}function p(e){// IE 11 has no ShadowRoot
if(typeof ShadowRoot==="undefined"){return false}var t=f(e).ShadowRoot;return e instanceof t||e instanceof ShadowRoot};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/math.js
var v=Math.max;var m=Math.min;var g=Math.round;// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/userAgent.js
function b(){var e=navigator.userAgentData;if(e!=null&&e.brands&&Array.isArray(e.brands)){return e.brands.map(function(e){return e.brand+"/"+e.version}).join(" ")}return navigator.userAgent};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/isLayoutViewport.js
function y(){return!/^((?!chrome|android).)*safari/i.test(b())};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js
function w(e,t,r){if(t===void 0){t=false}if(r===void 0){r=false}var n=e.getBoundingClientRect();var a=1;var i=1;if(t&&h(e)){a=e.offsetWidth>0?g(n.width)/e.offsetWidth||1:1;i=e.offsetHeight>0?g(n.height)/e.offsetHeight||1:1}var o=d(e)?f(e):window,s=o.visualViewport;var u=!y()&&r;var l=(n.left+(u&&s?s.offsetLeft:0))/a;var c=(n.top+(u&&s?s.offsetTop:0))/i;var p=n.width/a;var v=n.height/i;return{width:p,height:v,top:c,right:l+p,bottom:c+v,left:l,x:l,y:c}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js
function _(e){var t=f(e);var r=t.pageXOffset;var n=t.pageYOffset;return{scrollLeft:r,scrollTop:n}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getHTMLElementScroll.js
function x(e){return{scrollLeft:e.scrollLeft,scrollTop:e.scrollTop}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getNodeScroll.js
function E(e){if(e===f(e)||!h(e)){return _(e)}else{return x(e)}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getNodeName.js
function O(e){return e?(e.nodeName||"").toLowerCase():null};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js
function S(e){// $FlowFixMe[incompatible-return]: assume body is always available
return((d(e)?e.ownerDocument:e.document)||window.document).documentElement};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js
function A(e){// If <html> has a CSS width greater than the viewport, then this will be
// incorrect for RTL.
// Popper 1 is broken in this case and never had a bug report so let's assume
// it's not an issue. I don't think anyone ever specifies width on <html>
// anyway.
// Browsers where the left scrollbar doesn't cause an issue report `0` for
// this (e.g. Edge 2019, IE11, Safari)
return w(S(e)).left+_(e).scrollLeft};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js
function T(e){return f(e).getComputedStyle(e)};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js
function k(e){// Firefox wants us to check `-x` and `-y` variations as well
var t=T(e),r=t.overflow,n=t.overflowX,a=t.overflowY;return/auto|scroll|overlay|hidden/.test(r+a+n)};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getCompositeRect.js
function R(e){var t=e.getBoundingClientRect();var r=g(t.width)/e.offsetWidth||1;var n=g(t.height)/e.offsetHeight||1;return r!==1||n!==1}// Returns the composite rect of an element relative to its offsetParent.
// Composite means it takes into account transforms as well as layout.
function C(e,t,r){if(r===void 0){r=false}var n=h(t);var a=h(t)&&R(t);var i=S(t);var o=w(e,a,r);var s={scrollLeft:0,scrollTop:0};var u={x:0,y:0};if(n||!n&&!r){if(O(t)!=="body"||// https://github.com/popperjs/popper-core/issues/1078
k(i)){s=E(t)}if(h(t)){u=w(t,true);u.x+=t.clientLeft;u.y+=t.clientTop}else if(i){u.x=A(i)}}return{x:o.left+s.scrollLeft-u.x,y:o.top+s.scrollTop-u.y,width:o.width,height:o.height}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js
// Returns the layout rect of an element relative to its offsetParent. Layout
// means it doesn't take into account transforms.
function P(e){var t=w(e);// Use the clientRect sizes if it's not been transformed.
// Fixes https://github.com/popperjs/popper-core/issues/1223
var r=e.offsetWidth;var n=e.offsetHeight;if(Math.abs(t.width-r)<=1){r=t.width}if(Math.abs(t.height-n)<=1){n=t.height}return{x:e.offsetLeft,y:e.offsetTop,width:r,height:n}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getParentNode.js
function I(e){if(O(e)==="html"){return e}return(// $FlowFixMe[incompatible-return]
// $FlowFixMe[prop-missing]
e.assignedSlot||// step into the shadow DOM of the parent of a slotted node
e.parentNode||(p(e)?e.host:null)||// ShadowRoot detected
// $FlowFixMe[incompatible-call]: HTMLElement is a Node
S(e)// fallback
)};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getScrollParent.js
function D(e){if(["html","body","#document"].indexOf(O(e))>=0){// $FlowFixMe[incompatible-return]: assume body is always available
return e.ownerDocument.body}if(h(e)&&k(e)){return e}return D(I(e))};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js
/*
given a DOM element, return the list of all scroll parents, up the list of ancesors
until we get to the top window object. This list is what we attach scroll listeners
to, because if any of these parent elements scroll, we'll need to re-calculate the
reference element's position.
*/function M(e,t){var r;if(t===void 0){t=[]}var n=D(e);var a=n===((r=e.ownerDocument)==null?void 0:r.body);var i=f(n);var o=a?[i].concat(i.visualViewport||[],k(n)?n:[]):n;var s=t.concat(o);return a?s:s.concat(M(I(o)))};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/isTableElement.js
function F(e){return["table","td","th"].indexOf(O(e))>=0};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js
function L(e){if(!h(e)||// https://github.com/popperjs/popper-core/issues/837
T(e).position==="fixed"){return null}return e.offsetParent}// `.offsetParent` reports `null` for fixed elements, while absolute elements
// return the containing block
function N(e){var t=/firefox/i.test(b());var r=/Trident/i.test(b());if(r&&h(e)){// In IE 9, 10 and 11 fixed elements containing block is always established by the viewport
var n=T(e);if(n.position==="fixed"){return null}}var a=I(e);if(p(a)){a=a.host}while(h(a)&&["html","body"].indexOf(O(a))<0){var i=T(a);// This is non-exhaustive but covers the most common CSS properties that
// create a containing block.
// https://developer.mozilla.org/en-US/docs/Web/CSS/Containing_block#identifying_the_containing_block
if(i.transform!=="none"||i.perspective!=="none"||i.contain==="paint"||["transform","perspective"].indexOf(i.willChange)!==-1||t&&i.willChange==="filter"||t&&i.filter&&i.filter!=="none"){return a}else{a=a.parentNode}}return null}// Gets the closest ancestor positioned element. Handles some edge cases,
// such as table ancestors and cross browser bugs.
function j(e){var t=f(e);var r=L(e);while(r&&F(r)&&T(r).position==="static"){r=L(r)}if(r&&(O(r)==="html"||O(r)==="body"&&T(r).position==="static")){return t}return r||N(e)||t};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/enums.js
var U="top";var H="bottom";var B="right";var Y="left";var z="auto";var q=[U,H,B,Y];var V="start";var W="end";var $="clippingParents";var G="viewport";var K="popper";var Q="reference";var X=/*#__PURE__*/q.reduce(function(e,t){return e.concat([t+"-"+V,t+"-"+W])},[]);var J=/*#__PURE__*/[].concat(q,[z]).reduce(function(e,t){return e.concat([t,t+"-"+V,t+"-"+W])},[]);// modifiers that need to read the DOM
var Z="beforeRead";var ee="read";var et="afterRead";// pure-logic modifiers
var er="beforeMain";var en="main";var ea="afterMain";// modifier with the purpose to write to the DOM (or write into a framework state)
var ei="beforeWrite";var eo="write";var es="afterWrite";var eu=[Z,ee,et,er,en,ea,ei,eo,es];// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/orderModifiers.js
// source: https://stackoverflow.com/questions/49875255
function el(e){var t=new Map;var r=new Set;var n=[];e.forEach(function(e){t.set(e.name,e)});// On visiting object, check for its dependencies and visit them recursively
function a(e){r.add(e.name);var i=[].concat(e.requires||[],e.requiresIfExists||[]);i.forEach(function(e){if(!r.has(e)){var n=t.get(e);if(n){a(n)}}});n.push(e)}e.forEach(function(e){if(!r.has(e.name)){// check for visited object
a(e)}});return n}function ec(e){// order based on dependencies
var t=el(e);// order based on phase
return eu.reduce(function(e,r){return e.concat(t.filter(function(e){return e.phase===r}))},[])};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/debounce.js
function ef(e){var t;return function(){if(!t){t=new Promise(function(r){Promise.resolve().then(function(){t=undefined;r(e())})})}return t}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/mergeByName.js
function ed(e){var t=e.reduce(function(e,t){var r=e[t.name];e[t.name]=r?Object.assign({},r,t,{options:Object.assign({},r.options,t.options),data:Object.assign({},r.data,t.data)}):t;return e},{});// IE11 does not support Object.values
return Object.keys(t).map(function(e){return t[e]})};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/createPopper.js
var eh={placement:"bottom",modifiers:[],strategy:"absolute"};function ep(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++){t[r]=arguments[r]}return!t.some(function(e){return!(e&&typeof e.getBoundingClientRect==="function")})}function ev(e){if(e===void 0){e={}}var t=e,r=t.defaultModifiers,n=r===void 0?[]:r,a=t.defaultOptions,i=a===void 0?eh:a;return function e(e,t,r){if(r===void 0){r=i}var a={placement:"bottom",orderedModifiers:[],options:Object.assign({},eh,i),modifiersData:{},elements:{reference:e,popper:t},attributes:{},styles:{}};var o=[];var s=false;var u={state:a,setOptions:function r(r){var o=typeof r==="function"?r(a.options):r;c();a.options=Object.assign({},i,a.options,o);a.scrollParents={reference:d(e)?M(e):e.contextElement?M(e.contextElement):[],popper:M(t)};// Orders the modifiers based on their dependencies and `phase`
// properties
var s=ec(ed([].concat(n,a.options.modifiers)));// Strip out disabled modifiers
a.orderedModifiers=s.filter(function(e){return e.enabled});l();return u.update()},// Sync update – it will always be executed, even if not necessary. This
// is useful for low frequency updates where sync behavior simplifies the
// logic.
// For high frequency updates (e.g. `resize` and `scroll` events), always
// prefer the async Popper#update method
forceUpdate:function e(){if(s){return}var e=a.elements,t=e.reference,r=e.popper;// Don't proceed if `reference` or `popper` are not valid elements
// anymore
if(!ep(t,r)){return}// Store the reference and popper rects to be read by modifiers
a.rects={reference:C(t,j(r),a.options.strategy==="fixed"),popper:P(r)};// Modifiers have the ability to reset the current update cycle. The
// most common use case for this is the `flip` modifier changing the
// placement, which then needs to re-run all the modifiers, because the
// logic was previously ran for the previous placement and is therefore
// stale/incorrect
a.reset=false;a.placement=a.options.placement;// On each update cycle, the `modifiersData` property for each modifier
// is filled with the initial data specified by the modifier. This means
// it doesn't persist and is fresh on each update.
// To ensure persistent data, use `${name}#persistent`
a.orderedModifiers.forEach(function(e){return a.modifiersData[e.name]=Object.assign({},e.data)});for(var n=0;n<a.orderedModifiers.length;n++){if(a.reset===true){a.reset=false;n=-1;continue}var i=a.orderedModifiers[n],o=i.fn,l=i.options,c=l===void 0?{}:l,f=i.name;if(typeof o==="function"){a=o({state:a,options:c,name:f,instance:u})||a}}},// Async and optimistically optimized update – it will not be executed if
// not necessary (debounced to run at most once-per-tick)
update:ef(function(){return new Promise(function(e){u.forceUpdate();e(a)})}),destroy:function e(){c();s=true}};if(!ep(e,t)){return u}u.setOptions(r).then(function(e){if(!s&&r.onFirstUpdate){r.onFirstUpdate(e)}});// Modifiers have the ability to execute arbitrary code before the first
// update cycle runs. They will be executed in the same order as the update
// cycle. This is useful when a modifier adds some persistent data that
// other modifiers need to use, but the modifier is run after the dependent
// one.
function l(){a.orderedModifiers.forEach(function(e){var t=e.name,r=e.options,n=r===void 0?{}:r,i=e.effect;if(typeof i==="function"){var s=i({state:a,name:t,instance:u,options:n});var l=function e(){};o.push(s||l)}})}function c(){o.forEach(function(e){return e()});o=[]}return u}}var em=/*#__PURE__*//* unused pure expression or super */null&&ev();// eslint-disable-next-line import/no-unused-modules
;// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/eventListeners.js
// eslint-disable-next-line import/no-unused-modules
var eg={passive:true};function eb(e){var t=e.state,r=e.instance,n=e.options;var a=n.scroll,i=a===void 0?true:a,o=n.resize,s=o===void 0?true:o;var u=f(t.elements.popper);var l=[].concat(t.scrollParents.reference,t.scrollParents.popper);if(i){l.forEach(function(e){e.addEventListener("scroll",r.update,eg)})}if(s){u.addEventListener("resize",r.update,eg)}return function(){if(i){l.forEach(function(e){e.removeEventListener("scroll",r.update,eg)})}if(s){u.removeEventListener("resize",r.update,eg)}}}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const ey={name:"eventListeners",enabled:true,phase:"write",fn:function e(){},effect:eb,data:{}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/getBasePlacement.js
function ew(e){return e.split("-")[0]};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/getVariation.js
function e_(e){return e.split("-")[1]};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js
function ex(e){return["top","bottom"].indexOf(e)>=0?"x":"y"};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/computeOffsets.js
function eE(e){var t=e.reference,r=e.element,n=e.placement;var a=n?ew(n):null;var i=n?e_(n):null;var o=t.x+t.width/2-r.width/2;var s=t.y+t.height/2-r.height/2;var u;switch(a){case U:u={x:o,y:t.y-r.height};break;case H:u={x:o,y:t.y+t.height};break;case B:u={x:t.x+t.width,y:s};break;case Y:u={x:t.x-r.width,y:s};break;default:u={x:t.x,y:t.y}}var l=a?ex(a):null;if(l!=null){var c=l==="y"?"height":"width";switch(i){case V:u[l]=u[l]-(t[c]/2-r[c]/2);break;case W:u[l]=u[l]+(t[c]/2-r[c]/2);break;default:}}return u};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/popperOffsets.js
function eO(e){var t=e.state,r=e.name;// Offsets are the actual position the popper needs to have to be
// properly positioned near its reference element
// This is the most basic placement, and will be adjusted by
// the modifiers in the next step
t.modifiersData[r]=eE({reference:t.rects.reference,element:t.rects.popper,strategy:"absolute",placement:t.placement})}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const eS={name:"popperOffsets",enabled:true,phase:"read",fn:eO,data:{}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/computeStyles.js
// eslint-disable-next-line import/no-unused-modules
var eA={top:"auto",right:"auto",bottom:"auto",left:"auto"};// Round the offsets to the nearest suitable subpixel based on the DPR.
// Zooming can change the DPR, but it seems to report a value that will
// cleanly divide the values into the appropriate subpixels.
function eT(e,t){var r=e.x,n=e.y;var a=t.devicePixelRatio||1;return{x:g(r*a)/a||0,y:g(n*a)/a||0}}function ek(e){var t;var r=e.popper,n=e.popperRect,a=e.placement,i=e.variation,o=e.offsets,s=e.position,u=e.gpuAcceleration,l=e.adaptive,c=e.roundOffsets,d=e.isFixed;var h=o.x,p=h===void 0?0:h,v=o.y,m=v===void 0?0:v;var g=typeof c==="function"?c({x:p,y:m}):{x:p,y:m};p=g.x;m=g.y;var b=o.hasOwnProperty("x");var y=o.hasOwnProperty("y");var w=Y;var _=U;var x=window;if(l){var E=j(r);var O="clientHeight";var A="clientWidth";if(E===f(r)){E=S(r);if(T(E).position!=="static"&&s==="absolute"){O="scrollHeight";A="scrollWidth"}}// $FlowFixMe[incompatible-cast]: force type refinement, we compare offsetParent with window above, but Flow doesn't detect it
E=E;if(a===U||(a===Y||a===B)&&i===W){_=H;var k=d&&E===x&&x.visualViewport?x.visualViewport.height:E[O];m-=k-n.height;m*=u?1:-1}if(a===Y||(a===U||a===H)&&i===W){w=B;var R=d&&E===x&&x.visualViewport?x.visualViewport.width:E[A];p-=R-n.width;p*=u?1:-1}}var C=Object.assign({position:s},l&&eA);var P=c===true?eT({x:p,y:m},f(r)):{x:p,y:m};p=P.x;m=P.y;if(u){var I;return Object.assign({},C,(I={},I[_]=y?"0":"",I[w]=b?"0":"",I.transform=(x.devicePixelRatio||1)<=1?"translate("+p+"px, "+m+"px)":"translate3d("+p+"px, "+m+"px, 0)",I))}return Object.assign({},C,(t={},t[_]=y?m+"px":"",t[w]=b?p+"px":"",t.transform="",t))}function eR(e){var t=e.state,r=e.options;var n=r.gpuAcceleration,a=n===void 0?true:n,i=r.adaptive,o=i===void 0?true:i,s=r.roundOffsets,u=s===void 0?true:s;var l={placement:ew(t.placement),variation:e_(t.placement),popper:t.elements.popper,popperRect:t.rects.popper,gpuAcceleration:a,isFixed:t.options.strategy==="fixed"};if(t.modifiersData.popperOffsets!=null){t.styles.popper=Object.assign({},t.styles.popper,ek(Object.assign({},l,{offsets:t.modifiersData.popperOffsets,position:t.options.strategy,adaptive:o,roundOffsets:u})))}if(t.modifiersData.arrow!=null){t.styles.arrow=Object.assign({},t.styles.arrow,ek(Object.assign({},l,{offsets:t.modifiersData.arrow,position:"absolute",adaptive:false,roundOffsets:u})))}t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-placement":t.placement})}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const eC={name:"computeStyles",enabled:true,phase:"beforeWrite",fn:eR,data:{}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/applyStyles.js
// This modifier takes the styles prepared by the `computeStyles` modifier
// and applies them to the HTMLElements such as popper and arrow
function eP(e){var t=e.state;Object.keys(t.elements).forEach(function(e){var r=t.styles[e]||{};var n=t.attributes[e]||{};var a=t.elements[e];// arrow is optional + virtual elements
if(!h(a)||!O(a)){return}// Flow doesn't support to extend this property, but it's the most
// effective way to apply styles to an HTMLElement
// $FlowFixMe[cannot-write]
Object.assign(a.style,r);Object.keys(n).forEach(function(e){var t=n[e];if(t===false){a.removeAttribute(e)}else{a.setAttribute(e,t===true?"":t)}})})}function eI(e){var t=e.state;var r={popper:{position:t.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};Object.assign(t.elements.popper.style,r.popper);t.styles=r;if(t.elements.arrow){Object.assign(t.elements.arrow.style,r.arrow)}return function(){Object.keys(t.elements).forEach(function(e){var n=t.elements[e];var a=t.attributes[e]||{};var i=Object.keys(t.styles.hasOwnProperty(e)?t.styles[e]:r[e]);// Set all values to an empty string to unset them
var o=i.reduce(function(e,t){e[t]="";return e},{});// arrow is optional + virtual elements
if(!h(n)||!O(n)){return}Object.assign(n.style,o);Object.keys(a).forEach(function(e){n.removeAttribute(e)})})}}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const eD={name:"applyStyles",enabled:true,phase:"write",fn:eP,effect:eI,requires:["computeStyles"]};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/offset.js
// eslint-disable-next-line import/no-unused-modules
function eM(e,t,r){var n=ew(e);var a=[Y,U].indexOf(n)>=0?-1:1;var i=typeof r==="function"?r(Object.assign({},t,{placement:e})):r,o=i[0],s=i[1];o=o||0;s=(s||0)*a;return[Y,B].indexOf(n)>=0?{x:s,y:o}:{x:o,y:s}}function eF(e){var t=e.state,r=e.options,n=e.name;var a=r.offset,i=a===void 0?[0,0]:a;var o=J.reduce(function(e,r){e[r]=eM(r,t.rects,i);return e},{});var s=o[t.placement],u=s.x,l=s.y;if(t.modifiersData.popperOffsets!=null){t.modifiersData.popperOffsets.x+=u;t.modifiersData.popperOffsets.y+=l}t.modifiersData[n]=o}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const eL={name:"offset",enabled:true,phase:"main",requires:["popperOffsets"],fn:eF};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/getOppositePlacement.js
var eN={left:"right",right:"left",bottom:"top",top:"bottom"};function ej(e){return e.replace(/left|right|bottom|top/g,function(e){return eN[e]})};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/getOppositeVariationPlacement.js
var eU={start:"end",end:"start"};function eH(e){return e.replace(/start|end/g,function(e){return eU[e]})};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getViewportRect.js
function eB(e,t){var r=f(e);var n=S(e);var a=r.visualViewport;var i=n.clientWidth;var o=n.clientHeight;var s=0;var u=0;if(a){i=a.width;o=a.height;var l=y();if(l||!l&&t==="fixed"){s=a.offsetLeft;u=a.offsetTop}}return{width:i,height:o,x:s+A(e),y:u}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getDocumentRect.js
// Gets the entire size of the scrollable document area, even extending outside
// of the `<html>` and `<body>` rect bounds if horizontally scrollable
function eY(e){var t;var r=S(e);var n=_(e);var a=(t=e.ownerDocument)==null?void 0:t.body;var i=v(r.scrollWidth,r.clientWidth,a?a.scrollWidth:0,a?a.clientWidth:0);var o=v(r.scrollHeight,r.clientHeight,a?a.scrollHeight:0,a?a.clientHeight:0);var s=-n.scrollLeft+A(e);var u=-n.scrollTop;if(T(a||r).direction==="rtl"){s+=v(r.clientWidth,a?a.clientWidth:0)-i}return{width:i,height:o,x:s,y:u}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/contains.js
function ez(e,t){var r=t.getRootNode&&t.getRootNode();// First, attempt with faster native method
if(e.contains(t)){return true}else if(r&&p(r)){var n=t;do{if(n&&e.isSameNode(n)){return true}// $FlowFixMe[prop-missing]: need a better way to handle this...
n=n.parentNode||n.host}while(n)}// Give up, the result is false
return false};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/rectToClientRect.js
function eq(e){return Object.assign({},e,{left:e.x,top:e.y,right:e.x+e.width,bottom:e.y+e.height})};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/dom-utils/getClippingRect.js
function eV(e,t){var r=w(e,false,t==="fixed");r.top=r.top+e.clientTop;r.left=r.left+e.clientLeft;r.bottom=r.top+e.clientHeight;r.right=r.left+e.clientWidth;r.width=e.clientWidth;r.height=e.clientHeight;r.x=r.left;r.y=r.top;return r}function eW(e,t,r){return t===G?eq(eB(e,r)):d(t)?eV(t,r):eq(eY(S(e)))}// A "clipping parent" is an overflowable container with the characteristic of
// clipping (or hiding) overflowing elements with a position different from
// `initial`
function e$(e){var t=M(I(e));var r=["absolute","fixed"].indexOf(T(e).position)>=0;var n=r&&h(e)?j(e):e;if(!d(n)){return[]}// $FlowFixMe[incompatible-return]: https://github.com/facebook/flow/issues/1414
return t.filter(function(e){return d(e)&&ez(e,n)&&O(e)!=="body"})}// Gets the maximum area that the element is visible in due to any number of
// clipping parents
function eG(e,t,r,n){var a=t==="clippingParents"?e$(e):[].concat(t);var i=[].concat(a,[r]);var o=i[0];var s=i.reduce(function(t,r){var a=eW(e,r,n);t.top=v(a.top,t.top);t.right=m(a.right,t.right);t.bottom=m(a.bottom,t.bottom);t.left=v(a.left,t.left);return t},eW(e,o,n));s.width=s.right-s.left;s.height=s.bottom-s.top;s.x=s.left;s.y=s.top;return s};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/getFreshSideObject.js
function eK(){return{top:0,right:0,bottom:0,left:0}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/mergePaddingObject.js
function eQ(e){return Object.assign({},eK(),e)};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/expandToHashMap.js
function eX(e,t){return t.reduce(function(t,r){t[r]=e;return t},{})};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/detectOverflow.js
// eslint-disable-next-line import/no-unused-modules
function eJ(e,t){if(t===void 0){t={}}var r=t,n=r.placement,a=n===void 0?e.placement:n,i=r.strategy,o=i===void 0?e.strategy:i,s=r.boundary,u=s===void 0?$:s,l=r.rootBoundary,c=l===void 0?G:l,f=r.elementContext,h=f===void 0?K:f,p=r.altBoundary,v=p===void 0?false:p,m=r.padding,g=m===void 0?0:m;var b=eQ(typeof g!=="number"?g:eX(g,q));var y=h===K?Q:K;var _=e.rects.popper;var x=e.elements[v?y:h];var E=eG(d(x)?x:x.contextElement||S(e.elements.popper),u,c,o);var O=w(e.elements.reference);var A=eE({reference:O,element:_,strategy:"absolute",placement:a});var T=eq(Object.assign({},_,A));var k=h===K?T:O;// positive = overflowing the clipping rect
// 0 or negative = within the clipping rect
var R={top:E.top-k.top+b.top,bottom:k.bottom-E.bottom+b.bottom,left:E.left-k.left+b.left,right:k.right-E.right+b.right};var C=e.modifiersData.offset;// Offsets can be applied only to the popper element
if(h===K&&C){var P=C[a];Object.keys(R).forEach(function(e){var t=[B,H].indexOf(e)>=0?1:-1;var r=[U,H].indexOf(e)>=0?"y":"x";R[e]+=P[r]*t})}return R};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/computeAutoPlacement.js
function eZ(e,t){if(t===void 0){t={}}var r=t,n=r.placement,a=r.boundary,i=r.rootBoundary,o=r.padding,s=r.flipVariations,u=r.allowedAutoPlacements,l=u===void 0?J:u;var c=e_(n);var f=c?s?X:X.filter(function(e){return e_(e)===c}):q;var d=f.filter(function(e){return l.indexOf(e)>=0});if(d.length===0){d=f}// $FlowFixMe[incompatible-type]: Flow seems to have problems with two array unions...
var h=d.reduce(function(t,r){t[r]=eJ(e,{placement:r,boundary:a,rootBoundary:i,padding:o})[ew(r)];return t},{});return Object.keys(h).sort(function(e,t){return h[e]-h[t]})};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/flip.js
// eslint-disable-next-line import/no-unused-modules
function e0(e){if(ew(e)===z){return[]}var t=ej(e);return[eH(e),t,eH(t)]}function e1(e){var t=e.state,r=e.options,n=e.name;if(t.modifiersData[n]._skip){return}var a=r.mainAxis,i=a===void 0?true:a,o=r.altAxis,s=o===void 0?true:o,u=r.fallbackPlacements,l=r.padding,c=r.boundary,f=r.rootBoundary,d=r.altBoundary,h=r.flipVariations,p=h===void 0?true:h,v=r.allowedAutoPlacements;var m=t.options.placement;var g=ew(m);var b=g===m;var y=u||(b||!p?[ej(m)]:e0(m));var w=[m].concat(y).reduce(function(e,r){return e.concat(ew(r)===z?eZ(t,{placement:r,boundary:c,rootBoundary:f,padding:l,flipVariations:p,allowedAutoPlacements:v}):r)},[]);var _=t.rects.reference;var x=t.rects.popper;var E=new Map;var O=true;var S=w[0];for(var A=0;A<w.length;A++){var T=w[A];var k=ew(T);var R=e_(T)===V;var C=[U,H].indexOf(k)>=0;var P=C?"width":"height";var I=eJ(t,{placement:T,boundary:c,rootBoundary:f,altBoundary:d,padding:l});var D=C?R?B:Y:R?H:U;if(_[P]>x[P]){D=ej(D)}var M=ej(D);var F=[];if(i){F.push(I[k]<=0)}if(s){F.push(I[D]<=0,I[M]<=0)}if(F.every(function(e){return e})){S=T;O=false;break}E.set(T,F)}if(O){// `2` may be desired in some cases – research later
var L=p?3:1;var N=function e(e){var t=w.find(function(t){var r=E.get(t);if(r){return r.slice(0,e).every(function(e){return e})}});if(t){S=t;return"break"}};for(var j=L;j>0;j--){var q=N(j);if(q==="break")break}}if(t.placement!==S){t.modifiersData[n]._skip=true;t.placement=S;t.reset=true}}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const e2={name:"flip",enabled:true,phase:"main",fn:e1,requiresIfExists:["offset"],data:{_skip:false}};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/getAltAxis.js
function e4(e){return e==="x"?"y":"x"};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/utils/within.js
function e6(e,t,r){return v(e,m(t,r))}function e5(e,t,r){var n=e6(e,t,r);return n>r?r:n};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/preventOverflow.js
function e3(e){var t=e.state,r=e.options,n=e.name;var a=r.mainAxis,i=a===void 0?true:a,o=r.altAxis,s=o===void 0?false:o,u=r.boundary,l=r.rootBoundary,c=r.altBoundary,f=r.padding,d=r.tether,h=d===void 0?true:d,p=r.tetherOffset,g=p===void 0?0:p;var b=eJ(t,{boundary:u,rootBoundary:l,padding:f,altBoundary:c});var y=ew(t.placement);var w=e_(t.placement);var _=!w;var x=ex(y);var E=e4(x);var O=t.modifiersData.popperOffsets;var S=t.rects.reference;var A=t.rects.popper;var T=typeof g==="function"?g(Object.assign({},t.rects,{placement:t.placement})):g;var k=typeof T==="number"?{mainAxis:T,altAxis:T}:Object.assign({mainAxis:0,altAxis:0},T);var R=t.modifiersData.offset?t.modifiersData.offset[t.placement]:null;var C={x:0,y:0};if(!O){return}if(i){var I;var D=x==="y"?U:Y;var M=x==="y"?H:B;var F=x==="y"?"height":"width";var L=O[x];var N=L+b[D];var z=L-b[M];var q=h?-A[F]/2:0;var W=w===V?S[F]:A[F];var $=w===V?-A[F]:-S[F];// We need to include the arrow in the calculation so the arrow doesn't go
// outside the reference bounds
var G=t.elements.arrow;var K=h&&G?P(G):{width:0,height:0};var Q=t.modifiersData["arrow#persistent"]?t.modifiersData["arrow#persistent"].padding:eK();var X=Q[D];var J=Q[M];// If the reference length is smaller than the arrow length, we don't want
// to include its full size in the calculation. If the reference is small
// and near the edge of a boundary, the popper can overflow even if the
// reference is not overflowing as well (e.g. virtual elements with no
// width or height)
var Z=e6(0,S[F],K[F]);var ee=_?S[F]/2-q-Z-X-k.mainAxis:W-Z-X-k.mainAxis;var et=_?-S[F]/2+q+Z+J+k.mainAxis:$+Z+J+k.mainAxis;var er=t.elements.arrow&&j(t.elements.arrow);var en=er?x==="y"?er.clientTop||0:er.clientLeft||0:0;var ea=(I=R==null?void 0:R[x])!=null?I:0;var ei=L+ee-ea-en;var eo=L+et-ea;var es=e6(h?m(N,ei):N,L,h?v(z,eo):z);O[x]=es;C[x]=es-L}if(s){var eu;var el=x==="x"?U:Y;var ec=x==="x"?H:B;var ef=O[E];var ed=E==="y"?"height":"width";var eh=ef+b[el];var ep=ef-b[ec];var ev=[U,Y].indexOf(y)!==-1;var em=(eu=R==null?void 0:R[E])!=null?eu:0;var eg=ev?eh:ef-S[ed]-A[ed]-em+k.altAxis;var eb=ev?ef+S[ed]+A[ed]-em-k.altAxis:ep;var ey=h&&ev?e5(eg,ef,eb):e6(h?eg:eh,ef,h?eb:ep);O[E]=ey;C[E]=ey-ef}t.modifiersData[n]=C}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const e7={name:"preventOverflow",enabled:true,phase:"main",fn:e3,requiresIfExists:["offset"]};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/arrow.js
// eslint-disable-next-line import/no-unused-modules
var e8=function e(e,t){e=typeof e==="function"?e(Object.assign({},t.rects,{placement:t.placement})):e;return eQ(typeof e!=="number"?e:eX(e,q))};function e9(e){var t;var r=e.state,n=e.name,a=e.options;var i=r.elements.arrow;var o=r.modifiersData.popperOffsets;var s=ew(r.placement);var u=ex(s);var l=[Y,B].indexOf(s)>=0;var c=l?"height":"width";if(!i||!o){return}var f=e8(a.padding,r);var d=P(i);var h=u==="y"?U:Y;var p=u==="y"?H:B;var v=r.rects.reference[c]+r.rects.reference[u]-o[u]-r.rects.popper[c];var m=o[u]-r.rects.reference[u];var g=j(i);var b=g?u==="y"?g.clientHeight||0:g.clientWidth||0:0;var y=v/2-m/2;// Make sure the arrow doesn't overflow the popper if the center point is
// outside of the popper bounds
var w=f[h];var _=b-d[c]-f[p];var x=b/2-d[c]/2+y;var E=e6(w,x,_);// Prevents breaking syntax highlighting...
var O=u;r.modifiersData[n]=(t={},t[O]=E,t.centerOffset=E-x,t)}function te(e){var t=e.state,r=e.options;var n=r.element,a=n===void 0?"[data-popper-arrow]":n;if(a==null){return}// CSS selector
if(typeof a==="string"){a=t.elements.popper.querySelector(a);if(!a){return}}if(!ez(t.elements.popper,a)){return}t.elements.arrow=a}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const tt={name:"arrow",enabled:true,phase:"main",fn:e9,effect:te,requires:["popperOffsets"],requiresIfExists:["preventOverflow"]};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/modifiers/hide.js
function tr(e,t,r){if(r===void 0){r={x:0,y:0}}return{top:e.top-t.height-r.y,right:e.right-t.width+r.x,bottom:e.bottom-t.height+r.y,left:e.left-t.width-r.x}}function tn(e){return[U,B,H,Y].some(function(t){return e[t]>=0})}function ta(e){var t=e.state,r=e.name;var n=t.rects.reference;var a=t.rects.popper;var i=t.modifiersData.preventOverflow;var o=eJ(t,{elementContext:"reference"});var s=eJ(t,{altBoundary:true});var u=tr(o,n);var l=tr(s,a,i);var c=tn(u);var f=tn(l);t.modifiersData[r]={referenceClippingOffsets:u,popperEscapeOffsets:l,isReferenceHidden:c,hasPopperEscaped:f};t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-reference-hidden":c,"data-popper-escaped":f})}// eslint-disable-next-line import/no-unused-modules
/* ESM default export */const ti={name:"hide",enabled:true,phase:"main",requiresIfExists:["preventOverflow"],fn:ta};// CONCATENATED MODULE: ../tutor/node_modules/@popperjs/core/lib/popper.js
var to=[ey,eS,eC,eD,eL,e2,e7,tt,ti];var ts=/*#__PURE__*/ev({defaultModifiers:to});// eslint-disable-next-line import/no-unused-modules
// eslint-disable-next-line import/no-unused-modules
// eslint-disable-next-line import/no-unused-modules
;// CONCATENATED MODULE: ../tutor/node_modules/tippy.js/headless/dist/tippy-headless.esm.js
/**!
* tippy.js v6.3.7
* (c) 2017-2021 atomiks
* MIT License
*/var tu='<svg width="16" height="6" xmlns="http://www.w3.org/2000/svg"><path d="M0 6s1.796-.013 4.67-3.615C5.851.9 6.93.006 8 0c1.07-.006 2.148.887 3.343 2.385C14.233 6.005 16 6 16 6H0z"></svg>';var tl="tippy-content";var tc="tippy-backdrop";var tf="tippy-arrow";var td="tippy-svg-arrow";var th={passive:true,capture:true};var tp=function e(){return document.body};function tv(e,t){return({}).hasOwnProperty.call(e,t)}function tm(e,t,r){if(Array.isArray(e)){var n=e[t];return n==null?Array.isArray(r)?r[t]:r:n}return e}function tg(e,t){var r=({}).toString.call(e);return r.indexOf("[object")===0&&r.indexOf(t+"]")>-1}function tb(e,t){return typeof e==="function"?e.apply(void 0,t):e}function ty(e,t){// Avoid wrapping in `setTimeout` if ms is 0 anyway
if(t===0){return e}var r;return function(n){clearTimeout(r);r=setTimeout(function(){e(n)},t)}}function tw(e,t){var r=Object.assign({},e);t.forEach(function(e){delete r[e]});return r}function t_(e){return e.split(/\s+/).filter(Boolean)}function tx(e){return[].concat(e)}function tE(e,t){if(e.indexOf(t)===-1){e.push(t)}}function tO(e){return e.filter(function(t,r){return e.indexOf(t)===r})}function tS(e){return e.split("-")[0]}function tA(e){return[].slice.call(e)}function tT(e){return Object.keys(e).reduce(function(t,r){if(e[r]!==undefined){t[r]=e[r]}return t},{})}function tk(){return document.createElement("div")}function tR(e){return["Element","Fragment"].some(function(t){return tg(e,t)})}function tC(e){return tg(e,"NodeList")}function tP(e){return tg(e,"MouseEvent")}function tI(e){return!!(e&&e._tippy&&e._tippy.reference===e)}function tD(e){if(tR(e)){return[e]}if(tC(e)){return tA(e)}if(Array.isArray(e)){return e}return tA(document.querySelectorAll(e))}function tM(e,t){e.forEach(function(e){if(e){e.style.transitionDuration=t+"ms"}})}function tF(e,t){e.forEach(function(e){if(e){e.setAttribute("data-state",t)}})}function tL(e){var t;var r=tx(e),n=r[0];// Elements created via a <template> have an ownerDocument with no reference to the body
return n!=null&&(t=n.ownerDocument)!=null&&t.body?n.ownerDocument:document}function tN(e,t){var r=t.clientX,n=t.clientY;return e.every(function(e){var t=e.popperRect,a=e.popperState,i=e.props;var o=i.interactiveBorder;var s=tS(a.placement);var u=a.modifiersData.offset;if(!u){return true}var l=s==="bottom"?u.top.y:0;var c=s==="top"?u.bottom.y:0;var f=s==="right"?u.left.x:0;var d=s==="left"?u.right.x:0;var h=t.top-n+l>o;var p=n-t.bottom-c>o;var v=t.left-r+f>o;var m=r-t.right-d>o;return h||p||v||m})}function tj(e,t,r){var n=t+"EventListener";// some browsers apparently support `transition` (unprefixed) but only fire
// `webkitTransitionEnd`...
["transitionend","webkitTransitionEnd"].forEach(function(t){e[n](t,r)})}/**
 * Compared to xxx.contains, this function works for dom structures with shadow
 * dom
 */function tU(e,t){var r=t;while(r){var n;if(e.contains(r)){return true}r=r.getRootNode==null?void 0:(n=r.getRootNode())==null?void 0:n.host}return false}var tH={isTouch:false};var tB=0;/**
 * When a `touchstart` event is fired, it's assumed the user is using touch
 * input. We'll bind a `mousemove` event listener to listen for mouse input in
 * the future. This way, the `isTouch` property is fully dynamic and will handle
 * hybrid devices that use a mix of touch + mouse input.
 */function tY(){if(tH.isTouch){return}tH.isTouch=true;if(window.performance){document.addEventListener("mousemove",tz)}}/**
 * When two `mousemove` event are fired consecutively within 20ms, it's assumed
 * the user is using mouse input again. `mousemove` can fire on touch devices as
 * well, but very rarely that quickly.
 */function tz(){var e=performance.now();if(e-tB<20){tH.isTouch=false;document.removeEventListener("mousemove",tz)}tB=e}/**
 * When an element is in focus and has a tippy, leaving the tab/window and
 * returning causes it to show again. For mouse users this is unexpected, but
 * for keyboard use it makes sense.
 * TODO: find a better technique to solve this problem
 */function tq(){var e=document.activeElement;if(tI(e)){var t=e._tippy;if(e.blur&&!t.state.isVisible){e.blur()}}}function tV(){document.addEventListener("touchstart",tY,th);window.addEventListener("blur",tq)}var tW=typeof window!=="undefined"&&typeof document!=="undefined";var t$=tW?!!window.msCrypto:false;function tG(e){var t=e==="destroy"?"n already-":" ";return[e+"() was called on a"+t+"destroyed instance. This is a no-op but","indicates a potential memory leak."].join(" ")}function tK(e){var t=/[ \t]{2,}/g;var r=/^[ \t]*/gm;return e.replace(t," ").replace(r,"").trim()}function tQ(e){return tK("\n  %ctippy.js\n\n  %c"+tK(e)+"\n\n  %c\uD83D\uDC77‍ This is a development-only message. It will be removed in production.\n  ")}function tX(e){return[tQ(e),"color: #00C584; font-size: 1.3em; font-weight: bold;","line-height: 1.5","color: #a6a095;"]}// Assume warnings and errors never have the same message
var tJ;if(false){}function tZ(){tJ=new Set}function t0(e,t){if(e&&!tJ.has(t)){var r;tJ.add(t);(r=console).warn.apply(r,tX(t))}}function t1(e,t){if(e&&!tJ.has(t)){var r;tJ.add(t);(r=console).error.apply(r,tX(t))}}function t2(e){var t=!e;var r=Object.prototype.toString.call(e)==="[object Object]"&&!e.addEventListener;t1(t,["tippy() was passed","`"+String(e)+"`","as its targets (first) argument. Valid types are: String, Element,","Element[], or NodeList."].join(" "));t1(r,["tippy() was passed a plain object which is not supported as an argument","for virtual positioning. Use props.getReferenceClientRect instead."].join(" "))}var t4={animateFill:false,followCursor:false,inlinePositioning:false,sticky:false};var t6={allowHTML:false,animation:"fade",arrow:true,content:"",inertia:false,maxWidth:350,role:"tooltip",theme:"",zIndex:9999};var t5=Object.assign({appendTo:tp,aria:{content:"auto",expanded:"auto"},delay:0,duration:[300,250],getReferenceClientRect:null,hideOnClick:true,ignoreAttributes:false,interactive:false,interactiveBorder:2,interactiveDebounce:0,moveTransition:"",offset:[0,10],onAfterUpdate:function e(){},onBeforeUpdate:function e(){},onCreate:function e(){},onDestroy:function e(){},onHidden:function e(){},onHide:function e(){},onMount:function e(){},onShow:function e(){},onShown:function e(){},onTrigger:function e(){},onUntrigger:function e(){},onClickOutside:function e(){},placement:"top",plugins:[],popperOptions:{},render:null,showOnCreate:false,touch:true,trigger:"mouseenter focus",triggerTarget:null},t4,t6);var t3=Object.keys(t5);var t7=function e(e){/* istanbul ignore else */if(false){}var t=Object.keys(e);t.forEach(function(t){t5[t]=e[t]})};function t8(e){var t=e.plugins||[];var r=t.reduce(function(t,r){var n=r.name,a=r.defaultValue;if(n){var i;t[n]=e[n]!==undefined?e[n]:(i=t5[n])!=null?i:a}return t},{});return Object.assign({},e,r)}function t9(e,t){var r=t?Object.keys(t8(Object.assign({},t5,{plugins:t}))):t3;var n=r.reduce(function(t,r){var n=(e.getAttribute("data-tippy-"+r)||"").trim();if(!n){return t}if(r==="content"){t[r]=n}else{try{t[r]=JSON.parse(n)}catch(e){t[r]=n}}return t},{});return n}function re(e,t){var r=Object.assign({},t,{content:tb(t.content,[e])},t.ignoreAttributes?{}:t9(e,t.plugins));r.aria=Object.assign({},t5.aria,r.aria);r.aria={expanded:r.aria.expanded==="auto"?t.interactive:r.aria.expanded,content:r.aria.content==="auto"?t.interactive?null:"describedby":r.aria.content};return r}function rt(e,t){if(e===void 0){e={}}if(t===void 0){t=[]}var r=Object.keys(e);r.forEach(function(e){var r=tw(t5,Object.keys(t4));var n=!tv(r,e);// Check if the prop exists in `plugins`
if(n){n=t.filter(function(t){return t.name===e}).length===0}t0(n,["`"+e+"`","is not a valid prop. You may have spelled it incorrectly, or if it's","a plugin, forgot to pass it in an array as props.plugins.","\n\n","All props: https://atomiks.github.io/tippyjs/v6/all-props/\n","Plugins: https://atomiks.github.io/tippyjs/v6/plugins/"].join(" "))})}function rr(e){var t=e.firstElementChild;var r=tA(t.children);return{box:t,content:r.find(function(e){return e.classList.contains(tl)}),arrow:r.find(function(e){return e.classList.contains(tf)||e.classList.contains(td)}),backdrop:r.find(function(e){return e.classList.contains(tc)})}}var rn=1;var ra=[];// Used by `hideAll()`
var ri=[];function ro(e,t){var r=re(e,Object.assign({},t5,t8(tT(t))));// ===========================================================================
// 🔒 Private members
// ===========================================================================
var n;var a;var i;var o=false;var s=false;var u=false;var l=false;var c;var f;var d;var h=[];var p=ty(Q,r.interactiveDebounce);var v;// ===========================================================================
// 🔑 Public members
// ===========================================================================
var m=rn++;var g=null;var b=tO(r.plugins);var y={// Is the instance currently enabled?
isEnabled:true,// Is the tippy currently showing and not transitioning out?
isVisible:false,// Has the instance been destroyed?
isDestroyed:false,// Is the tippy currently mounted to the DOM?
isMounted:false,// Has the tippy finished transitioning in?
isShown:false};var w={// properties
id:m,reference:e,popper:tk(),popperInstance:g,props:r,state:y,plugins:b,// methods
clearDelayTimeouts:eu,setProps:el,setContent:ec,show:ef,hide:ed,hideWithInteractivity:eh,enable:eo,disable:es,unmount:ep,destroy:ev};// TODO: Investigate why this early return causes a TDZ error in the tests —
// it doesn't seem to happen in the browser
/* istanbul ignore if */if(!r.render){if(false){}return w}// ===========================================================================
// Initial mutations
// ===========================================================================
var _=r.render(w),x=_.popper,E=_.onUpdate;x.setAttribute("data-tippy-root","");x.id="tippy-"+w.id;w.popper=x;e._tippy=w;x._tippy=w;var O=b.map(function(e){return e.fn(w)});var S=e.hasAttribute("aria-expanded");$();L();D();M("onCreate",[w]);if(r.showOnCreate){ea()}// Prevent a tippy with a delay from hiding if the cursor left then returned
// before it started hiding
x.addEventListener("mouseenter",function(){if(w.props.interactive&&w.state.isVisible){w.clearDelayTimeouts()}});x.addEventListener("mouseleave",function(){if(w.props.interactive&&w.props.trigger.indexOf("mouseenter")>=0){C().addEventListener("mousemove",p)}});return w;// ===========================================================================
// 🔒 Private methods
// ===========================================================================
function A(){var e=w.props.touch;return Array.isArray(e)?e:[e,0]}function T(){return A()[0]==="hold"}function k(){var e;// @ts-ignore
return!!((e=w.props.render)!=null&&e.$$tippy)}function R(){return v||e}function C(){var e=R().parentNode;return e?tL(e):document}function P(){return rr(x)}function I(e){// For touch or keyboard input, force `0` delay for UX reasons
// Also if the instance is mounted but not visible (transitioning out),
// ignore delay
if(w.state.isMounted&&!w.state.isVisible||tH.isTouch||c&&c.type==="focus"){return 0}return tm(w.props.delay,e?0:1,t5.delay)}function D(e){if(e===void 0){e=false}x.style.pointerEvents=w.props.interactive&&!e?"":"none";x.style.zIndex=""+w.props.zIndex}function M(e,t,r){if(r===void 0){r=true}O.forEach(function(r){if(r[e]){r[e].apply(r,t)}});if(r){var n;(n=w.props)[e].apply(n,t)}}function F(){var t=w.props.aria;if(!t.content){return}var r="aria-"+t.content;var n=x.id;var a=tx(w.props.triggerTarget||e);a.forEach(function(e){var t=e.getAttribute(r);if(w.state.isVisible){e.setAttribute(r,t?t+" "+n:n)}else{var a=t&&t.replace(n,"").trim();if(a){e.setAttribute(r,a)}else{e.removeAttribute(r)}}})}function L(){if(S||!w.props.aria.expanded){return}var t=tx(w.props.triggerTarget||e);t.forEach(function(e){if(w.props.interactive){e.setAttribute("aria-expanded",w.state.isVisible&&e===R()?"true":"false")}else{e.removeAttribute("aria-expanded")}})}function N(){C().removeEventListener("mousemove",p);ra=ra.filter(function(e){return e!==p})}function j(t){// Moved finger to scroll instead of an intentional tap outside
if(tH.isTouch){if(u||t.type==="mousedown"){return}}var r=t.composedPath&&t.composedPath()[0]||t.target;// Clicked on interactive popper
if(w.props.interactive&&tU(x,r)){return}// Clicked on the event listeners target
if(tx(w.props.triggerTarget||e).some(function(e){return tU(e,r)})){if(tH.isTouch){return}if(w.state.isVisible&&w.props.trigger.indexOf("click")>=0){return}}else{M("onClickOutside",[w,t])}if(w.props.hideOnClick===true){w.clearDelayTimeouts();w.hide();// `mousedown` event is fired right before `focus` if pressing the
// currentTarget. This lets a tippy with `focus` trigger know that it
// should not show
s=true;setTimeout(function(){s=false});// The listener gets added in `scheduleShow()`, but this may be hiding it
// before it shows, and hide()'s early bail-out behavior can prevent it
// from being cleaned up
if(!w.state.isMounted){Y()}}}function U(){u=true}function H(){u=false}function B(){var e=C();e.addEventListener("mousedown",j,true);e.addEventListener("touchend",j,th);e.addEventListener("touchstart",H,th);e.addEventListener("touchmove",U,th)}function Y(){var e=C();e.removeEventListener("mousedown",j,true);e.removeEventListener("touchend",j,th);e.removeEventListener("touchstart",H,th);e.removeEventListener("touchmove",U,th)}function z(e,t){V(e,function(){if(!w.state.isVisible&&x.parentNode&&x.parentNode.contains(x)){t()}})}function q(e,t){V(e,t)}function V(e,t){var r=P().box;function n(e){if(e.target===r){tj(r,"remove",n);t()}}// Make callback synchronous if duration is 0
// `transitionend` won't fire otherwise
if(e===0){return t()}tj(r,"remove",f);tj(r,"add",n);f=n}function W(t,r,n){if(n===void 0){n=false}var a=tx(w.props.triggerTarget||e);a.forEach(function(e){e.addEventListener(t,r,n);h.push({node:e,eventType:t,handler:r,options:n})})}function $(){if(T()){W("touchstart",K,{passive:true});W("touchend",X,{passive:true})}t_(w.props.trigger).forEach(function(e){if(e==="manual"){return}W(e,K);switch(e){case"mouseenter":W("mouseleave",X);break;case"focus":W(t$?"focusout":"blur",J);break;case"focusin":W("focusout",J);break}})}function G(){h.forEach(function(e){var t=e.node,r=e.eventType,n=e.handler,a=e.options;t.removeEventListener(r,n,a)});h=[]}function K(e){var t;var r=false;if(!w.state.isEnabled||Z(e)||s){return}var n=((t=c)==null?void 0:t.type)==="focus";c=e;v=e.currentTarget;L();if(!w.state.isVisible&&tP(e)){// If scrolling, `mouseenter` events can be fired if the cursor lands
// over a new target, but `mousemove` events don't get fired. This
// causes interactive tooltips to get stuck open until the cursor is
// moved
ra.forEach(function(t){return t(e)})}// Toggle show/hide when clicking click-triggered tooltips
if(e.type==="click"&&(w.props.trigger.indexOf("mouseenter")<0||o)&&w.props.hideOnClick!==false&&w.state.isVisible){r=true}else{ea(e)}if(e.type==="click"){o=!r}if(r&&!n){ei(e)}}function Q(e){var t=e.target;var n=R().contains(t)||x.contains(t);if(e.type==="mousemove"&&n){return}var a=en().concat(x).map(function(e){var t;var n=e._tippy;var a=(t=n.popperInstance)==null?void 0:t.state;if(a){return{popperRect:e.getBoundingClientRect(),popperState:a,props:r}}return null}).filter(Boolean);if(tN(a,e)){N();ei(e)}}function X(e){var t=Z(e)||w.props.trigger.indexOf("click")>=0&&o;if(t){return}if(w.props.interactive){w.hideWithInteractivity(e);return}ei(e)}function J(e){if(w.props.trigger.indexOf("focusin")<0&&e.target!==R()){return}// If focus was moved to within the popper
if(w.props.interactive&&e.relatedTarget&&x.contains(e.relatedTarget)){return}ei(e)}function Z(e){return tH.isTouch?T()!==e.type.indexOf("touch")>=0:false}function ee(){et();var t=w.props,r=t.popperOptions,n=t.placement,a=t.offset,i=t.getReferenceClientRect,o=t.moveTransition;var s=k()?rr(x).arrow:null;var u=i?{getBoundingClientRect:i,contextElement:i.contextElement||R()}:e;var l={name:"$$tippy",enabled:true,phase:"beforeWrite",requires:["computeStyles"],fn:function e(e){var t=e.state;if(k()){var r=P(),n=r.box;["placement","reference-hidden","escaped"].forEach(function(e){if(e==="placement"){n.setAttribute("data-placement",t.placement)}else{if(t.attributes.popper["data-popper-"+e]){n.setAttribute("data-"+e,"")}else{n.removeAttribute("data-"+e)}}});t.attributes.popper={}}}};var c=[{name:"offset",options:{offset:a}},{name:"preventOverflow",options:{padding:{top:2,bottom:2,left:5,right:5}}},{name:"flip",options:{padding:5}},{name:"computeStyles",options:{adaptive:!o}},l];if(k()&&s){c.push({name:"arrow",options:{element:s,padding:3}})}c.push.apply(c,(r==null?void 0:r.modifiers)||[]);w.popperInstance=ts(u,x,Object.assign({},r,{placement:n,onFirstUpdate:d,modifiers:c}))}function et(){if(w.popperInstance){w.popperInstance.destroy();w.popperInstance=null}}function er(){var e=w.props.appendTo;var t;// By default, we'll append the popper to the triggerTargets's parentNode so
// it's directly after the reference element so the elements inside the
// tippy can be tabbed to
// If there are clipping issues, the user can specify a different appendTo
// and ensure focus management is handled correctly manually
var r=R();if(w.props.interactive&&e===tp||e==="parent"){t=r.parentNode}else{t=tb(e,[r])}// The popper element needs to exist on the DOM before its position can be
// updated as Popper needs to read its dimensions
if(!t.contains(x)){t.appendChild(x)}w.state.isMounted=true;ee();/* istanbul ignore else */if(false){}}function en(){return tA(x.querySelectorAll("[data-tippy-root]"))}function ea(e){w.clearDelayTimeouts();if(e){M("onTrigger",[w,e])}B();var t=I(true);var r=A(),a=r[0],i=r[1];if(tH.isTouch&&a==="hold"&&i){t=i}if(t){n=setTimeout(function(){w.show()},t)}else{w.show()}}function ei(e){w.clearDelayTimeouts();M("onUntrigger",[w,e]);if(!w.state.isVisible){Y();return}// For interactive tippies, scheduleHide is added to a document.body handler
// from onMouseLeave so must intercept scheduled hides from mousemove/leave
// events when trigger contains mouseenter and click, and the tip is
// currently shown as a result of a click.
if(w.props.trigger.indexOf("mouseenter")>=0&&w.props.trigger.indexOf("click")>=0&&["mouseleave","mousemove"].indexOf(e.type)>=0&&o){return}var t=I(false);if(t){a=setTimeout(function(){if(w.state.isVisible){w.hide()}},t)}else{// Fixes a `transitionend` problem when it fires 1 frame too
// late sometimes, we don't want hide() to be called.
i=requestAnimationFrame(function(){w.hide()})}}// ===========================================================================
// 🔑 Public methods
// ===========================================================================
function eo(){w.state.isEnabled=true}function es(){// Disabling the instance should also hide it
// https://github.com/atomiks/tippy.js-react/issues/106
w.hide();w.state.isEnabled=false}function eu(){clearTimeout(n);clearTimeout(a);cancelAnimationFrame(i)}function el(t){/* istanbul ignore else */if(false){}if(w.state.isDestroyed){return}M("onBeforeUpdate",[w,t]);G();var r=w.props;var n=re(e,Object.assign({},r,tT(t),{ignoreAttributes:true}));w.props=n;$();if(r.interactiveDebounce!==n.interactiveDebounce){N();p=ty(Q,n.interactiveDebounce)}// Ensure stale aria-expanded attributes are removed
if(r.triggerTarget&&!n.triggerTarget){tx(r.triggerTarget).forEach(function(e){e.removeAttribute("aria-expanded")})}else if(n.triggerTarget){e.removeAttribute("aria-expanded")}L();D();if(E){E(r,n)}if(w.popperInstance){ee();// Fixes an issue with nested tippies if they are all getting re-rendered,
// and the nested ones get re-rendered first.
// https://github.com/atomiks/tippyjs-react/issues/177
// TODO: find a cleaner / more efficient solution(!)
en().forEach(function(e){// React (and other UI libs likely) requires a rAF wrapper as it flushes
// its work in one
requestAnimationFrame(e._tippy.popperInstance.forceUpdate)})}M("onAfterUpdate",[w,t])}function ec(e){w.setProps({content:e})}function ef(){/* istanbul ignore else */if(false){}// Early bail-out
var e=w.state.isVisible;var t=w.state.isDestroyed;var r=!w.state.isEnabled;var n=tH.isTouch&&!w.props.touch;var a=tm(w.props.duration,0,t5.duration);if(e||t||r||n){return}// Normalize `disabled` behavior across browsers.
// Firefox allows events on disabled elements, but Chrome doesn't.
// Using a wrapper element (i.e. <span>) is recommended.
if(R().hasAttribute("disabled")){return}M("onShow",[w],false);if(w.props.onShow(w)===false){return}w.state.isVisible=true;if(k()){x.style.visibility="visible"}D();B();if(!w.state.isMounted){x.style.transition="none"}// If flipping to the opposite side after hiding at least once, the
// animation will use the wrong placement without resetting the duration
if(k()){var i=P(),o=i.box,s=i.content;tM([o,s],0)}d=function e(){var e;if(!w.state.isVisible||l){return}l=true;// reflow
void x.offsetHeight;x.style.transition=w.props.moveTransition;if(k()&&w.props.animation){var t=P(),r=t.box,n=t.content;tM([r,n],a);tF([r,n],"visible")}F();L();tE(ri,w);// certain modifiers (e.g. `maxSize`) require a second update after the
// popper has been positioned for the first time
(e=w.popperInstance)==null?void 0:e.forceUpdate();M("onMount",[w]);if(w.props.animation&&k()){q(a,function(){w.state.isShown=true;M("onShown",[w])})}};er()}function ed(){/* istanbul ignore else */if(false){}// Early bail-out
var e=!w.state.isVisible;var t=w.state.isDestroyed;var r=!w.state.isEnabled;var n=tm(w.props.duration,1,t5.duration);if(e||t||r){return}M("onHide",[w],false);if(w.props.onHide(w)===false){return}w.state.isVisible=false;w.state.isShown=false;l=false;o=false;if(k()){x.style.visibility="hidden"}N();Y();D(true);if(k()){var a=P(),i=a.box,s=a.content;if(w.props.animation){tM([i,s],n);tF([i,s],"hidden")}}F();L();if(w.props.animation){if(k()){z(n,w.unmount)}}else{w.unmount()}}function eh(e){/* istanbul ignore else */if(false){}C().addEventListener("mousemove",p);tE(ra,p);p(e)}function ep(){/* istanbul ignore else */if(false){}if(w.state.isVisible){w.hide()}if(!w.state.isMounted){return}et();// If a popper is not interactive, it will be appended outside the popper
// tree by default. This seems mainly for interactive tippies, but we should
// find a workaround if possible
en().forEach(function(e){e._tippy.unmount()});if(x.parentNode){x.parentNode.removeChild(x)}ri=ri.filter(function(e){return e!==w});w.state.isMounted=false;M("onHidden",[w])}function ev(){/* istanbul ignore else */if(false){}if(w.state.isDestroyed){return}w.clearDelayTimeouts();w.unmount();G();delete e._tippy;w.state.isDestroyed=true;M("onDestroy",[w])}}function rs(e,t){if(t===void 0){t={}}var r=t5.plugins.concat(t.plugins||[]);/* istanbul ignore else */if(false){}tV();var n=Object.assign({},t,{plugins:r});var a=tD(e);/* istanbul ignore else */if(false){var i,o}var s=a.reduce(function(e,t){var r=t&&ro(t,n);if(r){e.push(r)}return e},[]);return tR(e)?s[0]:s}rs.defaultProps=t5;rs.setDefaultProps=t7;rs.currentInput=tH;var ru=function e(e){var t=e===void 0?{}:e,r=t.exclude,n=t.duration;ri.forEach(function(e){var t=false;if(r){t=tI(r)?e.reference===r:e.popper===r.popper}if(!t){var a=e.props.duration;e.setProps({duration:n});e.hide();if(!e.state.isDestroyed){e.setProps({duration:a})}}})};// every time the popper is destroyed (i.e. a new target), removing the styles
// and causing transitions to break for singletons when the console is open, but
// most notably for non-transform styles being used, `gpuAcceleration: false`.
var rl=Object.assign({},eD,{effect:function e(e){var t=e.state;var r={popper:{position:t.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};Object.assign(t.elements.popper.style,r.popper);t.styles=r;if(t.elements.arrow){Object.assign(t.elements.arrow.style,r.arrow)}// intentionally return no cleanup function
// return () => { ... }
}});var rc=function e(e,t){var r;if(t===void 0){t={}}/* istanbul ignore else */if(false){}var n=e;var a=[];var i=[];var o;var s=t.overrides;var u=[];var l=false;function c(){i=n.map(function(e){return tx(e.props.triggerTarget||e.reference)}).reduce(function(e,t){return e.concat(t)},[])}function f(){a=n.map(function(e){return e.reference})}function d(e){n.forEach(function(t){if(e){t.enable()}else{t.disable()}})}function h(e){return n.map(function(t){var r=t.setProps;t.setProps=function(n){r(n);if(t.reference===o){e.setProps(n)}};return function(){t.setProps=r}})}// have to pass singleton, as it maybe undefined on first call
function p(e,t){var r=i.indexOf(t);// bail-out
if(t===o){return}o=t;var u=(s||[]).concat("content").reduce(function(e,t){e[t]=n[r].props[t];return e},{});e.setProps(Object.assign({},u,{getReferenceClientRect:typeof u.getReferenceClientRect==="function"?u.getReferenceClientRect:function(){var e;return(e=a[r])==null?void 0:e.getBoundingClientRect()}}))}d(false);f();c();var v={fn:function e(){return{onDestroy:function e(){d(true)},onHidden:function e(){o=null},onClickOutside:function e(e){if(e.props.showOnCreate&&!l){l=true;o=null}},onShow:function e(e){if(e.props.showOnCreate&&!l){l=true;p(e,a[0])}},onTrigger:function e(e,t){p(e,t.currentTarget)}}}};var m=rs(tk(),Object.assign({},tw(t,["overrides"]),{plugins:[v].concat(t.plugins||[]),triggerTarget:i,popperOptions:Object.assign({},t.popperOptions,{modifiers:[].concat(((r=t.popperOptions)==null?void 0:r.modifiers)||[],[rl])})}));var g=m.show;m.show=function(e){g();// first time, showOnCreate or programmatic call with no params
// default to showing first instance
if(!o&&e==null){return p(m,a[0])}// triggered from event (do nothing as prepareInstance already called by onTrigger)
// programmatic call with no params when already visible (do nothing again)
if(o&&e==null){return}// target is index of instance
if(typeof e==="number"){return a[e]&&p(m,a[e])}// target is a child tippy instance
if(n.indexOf(e)>=0){var t=e.reference;return p(m,t)}// target is a ReferenceElement
if(a.indexOf(e)>=0){return p(m,e)}};m.showNext=function(){var e=a[0];if(!o){return m.show(0)}var t=a.indexOf(o);m.show(a[t+1]||e)};m.showPrevious=function(){var e=a[a.length-1];if(!o){return m.show(e)}var t=a.indexOf(o);var r=a[t-1]||e;m.show(r)};var b=m.setProps;m.setProps=function(e){s=e.overrides||s;b(e)};m.setInstances=function(e){d(true);u.forEach(function(e){return e()});n=e;d(false);f();c();u=h(m);m.setProps({triggerTarget:i})};u=h(m);return m};var rf=/* unused pure expression or super */null&&{mouseover:"mouseenter",focusin:"focus",click:"click"};/**
 * Creates a delegate instance that controls the creation of tippy instances
 * for child elements (`target` CSS selector).
 */function rd(e,t){/* istanbul ignore else */if(false){}var r=[];var n=[];var a=false;var i=t.target;var o=tw(t,["target"]);var s=Object.assign({},o,{trigger:"manual",touch:false});var u=Object.assign({touch:t5.touch},o,{showOnCreate:true});var l=rs(e,s);var c=tx(l);function f(e){if(!e.target||a){return}var r=e.target.closest(i);if(!r){return}// Get relevant trigger with fallbacks:
// 1. Check `data-tippy-trigger` attribute on target node
// 2. Fallback to `trigger` passed to `delegate()`
// 3. Fallback to `defaultProps.trigger`
var o=r.getAttribute("data-tippy-trigger")||t.trigger||t5.trigger;// @ts-ignore
if(r._tippy){return}if(e.type==="touchstart"&&typeof u.touch==="boolean"){return}if(e.type!=="touchstart"&&o.indexOf(rf[e.type])<0){return}var s=rs(r,u);if(s){n=n.concat(s)}}function d(e,t,n,a){if(a===void 0){a=false}e.addEventListener(t,n,a);r.push({node:e,eventType:t,handler:n,options:a})}function h(e){var t=e.reference;d(t,"touchstart",f,th);d(t,"mouseover",f);d(t,"focusin",f);d(t,"click",f)}function p(){r.forEach(function(e){var t=e.node,r=e.eventType,n=e.handler,a=e.options;t.removeEventListener(r,n,a)});r=[]}function v(e){var t=e.destroy;var r=e.enable;var i=e.disable;e.destroy=function(e){if(e===void 0){e=true}if(e){n.forEach(function(e){e.destroy()})}n=[];p();t()};e.enable=function(){r();n.forEach(function(e){return e.enable()});a=false};e.disable=function(){i();n.forEach(function(e){return e.disable()});a=true};h(e)}c.forEach(v);return l}var rh=/* unused pure expression or super */null&&{name:"animateFill",defaultValue:false,fn:function e(e){var t;// @ts-ignore
if(!((t=e.props.render)!=null&&t.$$tippy)){if(false){}return{}}var r=rr(e.popper),n=r.box,a=r.content;var i=e.props.animateFill?rp():null;return{onCreate:function t(){if(i){n.insertBefore(i,n.firstElementChild);n.setAttribute("data-animatefill","");n.style.overflow="hidden";e.setProps({arrow:false,animation:"shift-away"})}},onMount:function e(){if(i){var e=n.style.transitionDuration;var t=Number(e.replace("ms",""));// The content should fade in after the backdrop has mostly filled the
// tooltip element. `clip-path` is the other alternative but is not
// well-supported and is buggy on some devices.
a.style.transitionDelay=Math.round(t/10)+"ms";i.style.transitionDuration=e;tF([i],"visible")}},onShow:function e(){if(i){i.style.transitionDuration="0ms"}},onHide:function e(){if(i){tF([i],"hidden")}}}}};function rp(){var e=tk();e.className=tc;tF([e],"hidden");return e}var rv=/* unused pure expression or super */null&&{clientX:0,clientY:0};var rm=/* unused pure expression or super */null&&[];function rg(e){var t=e.clientX,r=e.clientY;rv={clientX:t,clientY:r}}function rb(e){e.addEventListener("mousemove",rg)}function ry(e){e.removeEventListener("mousemove",rg)}var rw=/* unused pure expression or super */null&&{name:"followCursor",defaultValue:false,fn:function e(e){var t=e.reference;var r=tL(e.props.triggerTarget||t);var n=false;var a=false;var i=true;var o=e.props;function s(){return e.props.followCursor==="initial"&&e.state.isVisible}function u(){r.addEventListener("mousemove",f)}function l(){r.removeEventListener("mousemove",f)}function c(){n=true;e.setProps({getReferenceClientRect:null});n=false}function f(r){// If the instance is interactive, avoid updating the position unless it's
// over the reference element
var n=r.target?t.contains(r.target):true;var a=e.props.followCursor;var i=r.clientX,o=r.clientY;var s=t.getBoundingClientRect();var u=i-s.left;var l=o-s.top;if(n||!e.props.interactive){e.setProps({// @ts-ignore - unneeded DOMRect properties
getReferenceClientRect:function e(){var e=t.getBoundingClientRect();var r=i;var n=o;if(a==="initial"){r=e.left+u;n=e.top+l}var s=a==="horizontal"?e.top:n;var c=a==="vertical"?e.right:r;var f=a==="horizontal"?e.bottom:n;var d=a==="vertical"?e.left:r;return{width:c-d,height:f-s,top:s,right:c,bottom:f,left:d}}})}}function d(){if(e.props.followCursor){rm.push({instance:e,doc:r});rb(r)}}function h(){rm=rm.filter(function(t){return t.instance!==e});if(rm.filter(function(e){return e.doc===r}).length===0){ry(r)}}return{onCreate:d,onDestroy:h,onBeforeUpdate:function t(){o=e.props},onAfterUpdate:function t(t,r){var i=r.followCursor;if(n){return}if(i!==undefined&&o.followCursor!==i){h();if(i){d();if(e.state.isMounted&&!a&&!s()){u()}}else{l();c()}}},onMount:function t(){if(e.props.followCursor&&!a){if(i){f(rv);i=false}if(!s()){u()}}},onTrigger:function e(e,t){if(tP(t)){rv={clientX:t.clientX,clientY:t.clientY}}a=t.type==="focus"},onHidden:function t(){if(e.props.followCursor){c();l();i=true}}}}};function r_(e,t){var r;return{popperOptions:Object.assign({},e.popperOptions,{modifiers:[].concat((((r=e.popperOptions)==null?void 0:r.modifiers)||[]).filter(function(e){var r=e.name;return r!==t.name}),[t])})}}var rx=/* unused pure expression or super */null&&{name:"inlinePositioning",defaultValue:false,fn:function e(e){var t=e.reference;function r(){return!!e.props.inlinePositioning}var n;var a=-1;var i=false;var o=[];var s={name:"tippyInlinePositioning",enabled:true,phase:"afterWrite",fn:function t(t){var a=t.state;if(r()){if(o.indexOf(a.placement)!==-1){o=[]}if(n!==a.placement&&o.indexOf(a.placement)===-1){o.push(a.placement);e.setProps({// @ts-ignore - unneeded DOMRect properties
getReferenceClientRect:function e(){return u(a.placement)}})}n=a.placement}}};function u(e){return rE(tS(e),t.getBoundingClientRect(),tA(t.getClientRects()),a)}function l(t){i=true;e.setProps(t);i=false}function c(){if(!i){l(r_(e.props,s))}}return{onCreate:c,onAfterUpdate:c,onTrigger:function t(t,r){if(tP(r)){var n=tA(e.reference.getClientRects());var i=n.find(function(e){return e.left-2<=r.clientX&&e.right+2>=r.clientX&&e.top-2<=r.clientY&&e.bottom+2>=r.clientY});var o=n.indexOf(i);a=o>-1?o:a}},onHidden:function e(){a=-1}}}};function rE(e,t,r,n){// Not an inline element, or placement is not yet known
if(r.length<2||e===null){return t}// There are two rects and they are disjoined
if(r.length===2&&n>=0&&r[0].left>r[1].right){return r[n]||t}switch(e){case"top":case"bottom":{var a=r[0];var i=r[r.length-1];var o=e==="top";var s=a.top;var u=i.bottom;var l=o?a.left:i.left;var c=o?a.right:i.right;var f=c-l;var d=u-s;return{top:s,bottom:u,left:l,right:c,width:f,height:d}}case"left":case"right":{var h=Math.min.apply(Math,r.map(function(e){return e.left}));var p=Math.max.apply(Math,r.map(function(e){return e.right}));var v=r.filter(function(t){return e==="left"?t.left===h:t.right===p});var m=v[0].top;var g=v[v.length-1].bottom;var b=h;var y=p;var w=y-b;var _=g-m;return{top:m,bottom:g,left:b,right:y,width:w,height:_}}default:{return t}}}var rO=/* unused pure expression or super */null&&{name:"sticky",defaultValue:false,fn:function e(e){var t=e.reference,r=e.popper;function n(){return e.popperInstance?e.popperInstance.state.elements.reference:t}function a(t){return e.props.sticky===true||e.props.sticky===t}var i=null;var o=null;function s(){var t=a("reference")?n().getBoundingClientRect():null;var u=a("popper")?r.getBoundingClientRect():null;if(t&&rS(i,t)||u&&rS(o,u)){if(e.popperInstance){e.popperInstance.update()}}i=t;o=u;if(e.state.isMounted){requestAnimationFrame(s)}}return{onMount:function t(){if(e.props.sticky){s()}}}}};function rS(e,t){if(e&&t){return e.top!==t.top||e.right!==t.right||e.bottom!==t.bottom||e.left!==t.left}return true}rs.setDefaultProps({animation:false});/* ESM default export */const rA=rs;//# sourceMappingURL=tippy-headless.esm.js.map
// EXTERNAL MODULE: external "React"
var rT=r(1594);var rk=/*#__PURE__*/r.n(rT);// EXTERNAL MODULE: external "ReactDOM"
var rR=r(5206);// CONCATENATED MODULE: ../tutor/node_modules/@tippyjs/react/headless/dist/tippy-react-headless.esm.js
function rC(e,t){if(e==null)return{};var r={};var n=Object.keys(e);var a,i;for(i=0;i<n.length;i++){a=n[i];if(t.indexOf(a)>=0)continue;r[a]=e[a]}return r}var rP=typeof window!=="undefined"&&typeof document!=="undefined";function rI(e,t){if(e){if(typeof e==="function"){e(t)}if(({}).hasOwnProperty.call(e,"current")){e.current=t}}}function rD(){return rP&&document.createElement("div")}function rM(e){var t={"data-placement":e.placement};if(e.referenceHidden){t["data-reference-hidden"]=""}if(e.escaped){t["data-escaped"]=""}return t}function rF(e,t){if(e===t){return true}else if(typeof e==="object"&&e!=null&&typeof t==="object"&&t!=null){if(Object.keys(e).length!==Object.keys(t).length){return false}for(var r in e){if(t.hasOwnProperty(r)){if(!rF(e[r],t[r])){return false}}else{return false}}return true}else{return false}}function rL(e){var t=[];e.forEach(function(e){if(!t.find(function(t){return rF(e,t)})){t.push(e)}});return t}function rN(e,t){var r,n;return Object.assign({},t,{popperOptions:Object.assign({},e.popperOptions,t.popperOptions,{modifiers:rL([].concat(((r=e.popperOptions)==null?void 0:r.modifiers)||[],((n=t.popperOptions)==null?void 0:n.modifiers)||[]))})})}var rj=rP?rT.useLayoutEffect:rT.useEffect;function rU(e){// Using refs instead of state as it's recommended to not store imperative
// values in state due to memory problems in React(?)
var t=(0,rT.useRef)();if(!t.current){t.current=typeof e==="function"?e():e}return t.current}function rH(e,t,r){r.split(/\s+/).forEach(function(r){if(r){e.classList[t](r)}})}var rB={name:"className",defaultValue:"",fn:function e(e){var t=e.popper.firstElementChild;var r=function t(){var t;return!!((t=e.props.render)==null?void 0:t.$$tippy)};function n(){if(e.props.className&&!r()){if(false){}return}rH(t,"add",e.props.className)}function a(){if(r()){rH(t,"remove",e.props.className)}}return{onCreate:n,onBeforeUpdate:a,onAfterUpdate:n}}};function rY(e){function t(t){var r=t.children,n=t.content,a=t.visible,i=t.singleton,o=t.render,s=t.reference,u=t.disabled,l=u===void 0?false:u,c=t.ignoreAttributes,f=c===void 0?true:c,d=t.__source,h=t.__self,p=rC(t,["children","content","visible","singleton","render","reference","disabled","ignoreAttributes","__source","__self"]);var v=a!==undefined;var m=i!==undefined;var g=(0,rT.useState)(false),b=g[0],y=g[1];var w=(0,rT.useState)({}),_=w[0],x=w[1];var E=(0,rT.useState)(),O=E[0],S=E[1];var A=rU(function(){return{container:rD(),renders:1}});var T=Object.assign({ignoreAttributes:f},p,{content:A.container});if(v){if(false){}T.trigger="manual";T.hideOnClick=false}if(m){l=true}var k=T;var R=T.plugins||[];if(o){k=Object.assign({},T,{plugins:m&&i.data!=null?[].concat(R,[{fn:function e(){return{onTrigger:function e(e,t){var r=i.data.children.find(function(e){var r=e.instance;return r.reference===t.currentTarget});e.state.$$activeSingletonInstance=r.instance;S(r.content)}}}}]):R,render:function e(){return{popper:A.container}}})}var C=[s].concat(r?[r.type]:[]);// CREATE
rj(function(){var t=s;if(s&&s.hasOwnProperty("current")){t=s.current}var r=e(t||A.ref||rD(),Object.assign({},k,{plugins:[rB].concat(T.plugins||[])}));A.instance=r;if(l){r.disable()}if(a){r.show()}if(m){i.hook({instance:r,content:n,props:k,setSingletonContent:S})}y(true);return function(){r.destroy();i==null?void 0:i.cleanup(r)}},C);// UPDATE
rj(function(){var e;// Prevent this effect from running on 1st render
if(A.renders===1){A.renders++;return}var t=A.instance;t.setProps(rN(t.props,k));// Fixes #264
(e=t.popperInstance)==null?void 0:e.forceUpdate();if(l){t.disable()}else{t.enable()}if(v){if(a){t.show()}else{t.hide()}}if(m){i.hook({instance:t,content:n,props:k,setSingletonContent:S})}});rj(function(){var e;if(!o){return}var t=A.instance;t.setProps({popperOptions:Object.assign({},t.props.popperOptions,{modifiers:[].concat((((e=t.props.popperOptions)==null?void 0:e.modifiers)||[]).filter(function(e){var t=e.name;return t!=="$$tippyReact"}),[{name:"$$tippyReact",enabled:true,phase:"beforeWrite",requires:["computeStyles"],fn:function e(e){var t;var r=e.state;var n=(t=r.modifiersData)==null?void 0:t.hide;// WARNING: this is a high-risk path that can cause an infinite
// loop. This expression _must_ evaluate to false when required
if(_.placement!==r.placement||_.referenceHidden!==(n==null?void 0:n.isReferenceHidden)||_.escaped!==(n==null?void 0:n.hasPopperEscaped)){x({placement:r.placement,referenceHidden:n==null?void 0:n.isReferenceHidden,escaped:n==null?void 0:n.hasPopperEscaped})}r.attributes.popper={}}}])})})},[_.placement,_.referenceHidden,_.escaped].concat(C));return /*#__PURE__*/rk().createElement(rk().Fragment,null,r?/*#__PURE__*/(0,rT.cloneElement)(r,{ref:function e(e){A.ref=e;rI(r.ref,e)}}):null,b&&/*#__PURE__*/(0,rR.createPortal)(o?o(rM(_),O,A.instance):n,A.container))}return t}function rz(e){return function t(t){var r=t===void 0?{}:t,n=r.disabled,a=n===void 0?false:n,i=r.overrides,o=i===void 0?[]:i;var s=useState(false),u=s[0],l=s[1];var c=rU({children:[],renders:1});rj(function(){if(!u){l(true);return}var t=c.children,r=c.sourceData;if(!r){if(false){}return}var n=e(t.map(function(e){return e.instance}),Object.assign({},r.props,{popperOptions:r.instance.props.popperOptions,overrides:o,plugins:[rB].concat(r.props.plugins||[])}));c.instance=n;if(a){n.disable()}return function(){n.destroy();c.children=t.filter(function(e){var t=e.instance;return!t.state.isDestroyed})}},[u]);rj(function(){if(!u){return}if(c.renders===1){c.renders++;return}var e=c.children,t=c.instance,r=c.sourceData;if(!(t&&r)){return}var n=r.props,i=n.content,s=rC(n,["content"]);t.setProps(rN(t.props,Object.assign({},s,{overrides:o})));t.setInstances(e.map(function(e){return e.instance}));if(a){t.disable()}else{t.enable()}});return useMemo(function(){var e={data:c,hook:function e(e){c.sourceData=e;c.setSingletonContent=e.setSingletonContent},cleanup:function e(){c.sourceData=null}};var t={hook:function e(e){var t,r;c.children=c.children.filter(function(t){var r=t.instance;return e.instance!==r});c.children.push(e);if(((t=c.instance)==null?void 0:t.state.isMounted)&&((r=c.instance)==null?void 0:r.state.$$activeSingletonInstance)===e.instance){c.setSingletonContent==null?void 0:c.setSingletonContent(e.content)}if(c.instance&&!c.instance.state.isDestroyed){c.instance.setInstances(c.children.map(function(e){return e.instance}))}},cleanup:function e(e){c.children=c.children.filter(function(t){return t.instance!==e});if(c.instance&&!c.instance.state.isDestroyed){c.instance.setInstances(c.children.map(function(e){return e.instance}))}}};return[e,t]},[])}}var rq=function(e,t){return/*#__PURE__*/(0,rT.forwardRef)(function r(r,n){var a=r.children,i=rC(r,["children"]);return(/*#__PURE__*/// If I spread them separately here, Babel adds the _extends ponyfill for
// some reason
rk().createElement(e,Object.assign({},t,i),a?/*#__PURE__*/(0,rT.cloneElement)(a,{ref:function e(e){rI(n,e);rI(a.ref,e)}}):null))})};var rV=/*#__PURE__*//* unused pure expression or super */null&&rz(createSingleton);var rW=/*#__PURE__*/rq(/*#__PURE__*/rY(rA),{render:function e(){return""}});/* ESM default export */const r$=rW;//# sourceMappingURL=tippy-react-headless.esm.js.map
;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/atoms/Tooltip.tsx
function rG(){var e=(0,i._)(["\n        bottom: auto;\n        left: -4px;\n        top: 50%;\n        transform: translateY(-50%) rotate(45deg);\n      "]);rG=function t(){return e};return e}function rK(){var e=(0,i._)(["\n        bottom: auto;\n        top: -4px;\n        left: 50%;\n        transform: translateX(-50%) rotate(45deg);\n      "]);rK=function t(){return e};return e}function rQ(){var e=(0,i._)(["\n        bottom: auto;\n        top: 50%;\n        left: auto;\n        right: -4px;\n        transform: translateY(-50%) rotate(45deg);\n      "]);rQ=function t(){return e};return e}var rX={opacity:0,transform:"scale(0.8)"};var rJ={tension:300,friction:15};var rZ=e=>{var{children:t,content:r,allowHTML:i,placement:l="top",hideOnClick:f,delay:d=0,disabled:h=false,visible:p}=e;var[v,m]=(0,c/* .useSpring */.zh)(()=>rX);if(h)return t;var g=()=>{m.start({opacity:1,transform:"scale(1)",config:rJ})};var b=e=>{var{unmount:t}=e;m.start((0,a._)((0,n._)({},rX),{onRest:t,config:(0,a._)((0,n._)({},rJ),{clamp:true})}))};return/*#__PURE__*/(0,o/* .jsx */.Y)(r$,{render:e=>{return/*#__PURE__*/(0,o/* .jsx */.Y)(u/* .AnimatedDiv */.LK,(0,a._)((0,n._)({style:v,hideOnOverflow:false},e),{css:r1.contentBox(l),children:r}))},animation:true,onMount:g,onHide:b,allowHTML:i,delay:[d,100],hideOnClick:f,placement:l,visible:p,zIndex:s/* .zIndex.highest */.fE.highest,children:/*#__PURE__*/(0,o/* .jsx */.Y)("div",{children:t})})};/* ESM default export */const r0=rZ;var r1={contentBox:e=>/*#__PURE__*/(0,l/* .css */.AH)("max-width:250px;width:100%;background-color:",s/* .colorTokens.color.black.main */.I6.color.black.main,";color:",s/* .colorTokens.text.white */.I6.text.white,";border-radius:",s/* .borderRadius["6"] */.Vq["6"],";padding:",s/* .spacing["4"] */.YK["4"]," ",s/* .spacing["8"] */.YK["8"],";font-size:",s/* .fontSize["15"] */.J["15"],";line-height:",s/* .lineHeight["20"] */.K_["20"],";position:relative;&::before{content:'';height:8px;width:8px;background-color:",s/* .colorTokens.color.black.main */.I6.color.black.main,";position:absolute;bottom:-4px;left:50%;transform:translateX(-50%) rotate(45deg);",e==="right"&&(0,l/* .css */.AH)(rG())," ",e==="bottom"&&(0,l/* .css */.AH)(rK())," ",e==="left"&&(0,l/* .css */.AH)(rQ()),"}")}},74:function(e,t,r){"use strict";r.d(t,{A:()=>o});/* ESM import */var n=r(3747);var a;if(false){}else{// eslint-disable-next-line @typescript-eslint/no-require-imports
a=r(5226)/* ["default"] */.A}var i=e=>{var{children:t}=e;return/*#__PURE__*/(0,n/* .jsx */.Y)(a,{children:t})};/* ESM default export */const o=i},5226:function(e,t,r){"use strict";// EXPORTS
r.d(t,{A:()=>/* binding */g});// EXTERNAL MODULE: ./node_modules/@emotion/react/jsx-runtime/dist/emotion-react-jsx-runtime.esm.js
var n=r(3747);// EXTERNAL MODULE: ./node_modules/@emotion/react/dist/emotion-react.esm.js
var a=r(1699);// EXTERNAL MODULE: external "wp.i18n"
var i=r(2470);// EXTERNAL MODULE: external "React"
var o=r(1594);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Button.tsx
var s=r(3494);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/SVGIcon.tsx
var u=r(6277);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/config.ts
var l=r(9568);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/styles.ts
var c=r(4532);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/typography.ts
var f=r(6439);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/controls/Show.tsx
var d=r(1817);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/style-utils.ts
var h=r(6014);// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/production-error-2x.webp
const p=r.p+"images/production-error-2x-dc6519df.webp";// CONCATENATED MODULE: ../tutor/assets/react/v3/public/images/production-error.webp
const v=r.p+"images/production-error-24158233.webp";// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/ErrorBoundaryProd.tsx
class m extends o.Component{static getDerivedStateFromError(){return{hasError:true}}componentDidCatch(e,t){// eslint-disable-next-line no-console
console.error(e,t)}render(){if(this.state.hasError){return/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:b.container,children:/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:b.productionErrorWrapper,children:[/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:b.productionErrorHeader,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("img",{src:v,srcSet:"".concat(p," 2x"),alt:(0,i.__)("Error","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)("h5",{css:f/* .typography.heading5 */.I.heading5("medium"),children:(0,i.__)("Oops! Something went wrong","tutor-pro")}),/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:b.instructions,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("p",{children:(0,i.__)("Try the following steps to resolve the issue:","tutor-pro")}),/*#__PURE__*/(0,n/* .jsxs */.FD)("ul",{children:[/*#__PURE__*/(0,n/* .jsx */.Y)("li",{children:(0,i.__)("Refresh the page.","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)("li",{children:(0,i.__)("Clear your browser cache.","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)(d/* ["default"] */.A,{when:l/* .tutorConfig.tutor_pro_url */.P.tutor_pro_url,children:/*#__PURE__*/(0,n/* .jsx */.Y)("li",{children:(0,i.__)("Ensure the Free and Pro plugins are on the same version.","tutor-pro")})})]})]})]}),/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:b.productionFooter,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("div",{children:/*#__PURE__*/(0,n/* .jsx */.Y)(s/* ["default"] */.A,{variant:"secondary",icon:/*#__PURE__*/(0,n/* .jsx */.Y)(u/* ["default"] */.A,{name:"refresh",height:24,width:24}),onClick:()=>window.location.reload(),children:(0,i.__)("Reload","tutor-pro")})}),/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:b.support,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("span",{children:(0,i.__)("Still having trouble?","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)("span",{children:(0,i.__)("Contact","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)("a",{href:l/* ["default"].TUTOR_SUPPORT_PAGE_URL */.A.TUTOR_SUPPORT_PAGE_URL,children:(0,i.__)("Support","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)("span",{children:(0,i.__)("for assistance.","tutor-pro")})]})]})]})})}return this.props.children}constructor(e){super(e);this.state={hasError:false}}}/* ESM default export */const g=m;var b={container:/*#__PURE__*/(0,a/* .css */.AH)("width:100%;height:auto;display:flex;justify-content:center;align-items:center;"),productionErrorWrapper:/*#__PURE__*/(0,a/* .css */.AH)(h/* .styleUtils.display.flex */.x.display.flex("column"),";gap:",c/* .spacing["20"] */.YK["20"],";max-width:500px;width:100%;"),productionErrorHeader:/*#__PURE__*/(0,a/* .css */.AH)(h/* .styleUtils.display.flex */.x.display.flex("column"),";align-items:center;padding:",c/* .spacing["32"] */.YK["32"],";background:",c/* .colorTokens.background.white */.I6.background.white,";border-radius:",c/* .borderRadius["12"] */.Vq["12"],";box-shadow:0px -4px 0px 0px #ff0000;gap:",c/* .spacing["16"] */.YK["16"],";h5{text-align:center;}img{height:104px;width:101px;object-position:center;object-fit:contain;}"),instructions:/*#__PURE__*/(0,a/* .css */.AH)("width:100%;max-width:333px;p{width:100%;",f/* .typography.caption */.I.caption(),";margin-bottom:",c/* .spacing["4"] */.YK["4"],";}ul{padding-left:",c/* .spacing["16"] */.YK["16"],";li{",f/* .typography.caption */.I.caption(),";color:",c/* .colorTokens.text.title */.I6.text.title,";list-style:unset;margin-bottom:",c/* .spacing["2"] */.YK["2"],";&::marker{color:",c/* .colorTokens.icon["default"] */.I6.icon["default"],";}}}"),productionFooter:/*#__PURE__*/(0,a/* .css */.AH)(h/* .styleUtils.display.flex */.x.display.flex("column"),";align-items:center;gap:",c/* .spacing["12"] */.YK["12"],";"),support:/*#__PURE__*/(0,a/* .css */.AH)(h/* .styleUtils.flexCenter */.x.flexCenter("row"),";text-align:center;flex-wrap:wrap;gap:",c/* .spacing["4"] */.YK["4"],";",f/* .typography.caption */.I.caption(),";color:",c/* .colorTokens.text.title */.I6.text.title,";a{color:",c/* .colorTokens.text.brand */.I6.text.brand,";text-decoration:none;}")}},4459:function(e,t,r){"use strict";r.d(t,{A:()=>o});/* ESM import */var n=r(1594);/* ESM import */var a=/*#__PURE__*/r.n(n);var i=e=>{var{children:t,blurPrevious:r=false}=e;var a=(0,n.useRef)(null);var i=(0,n.useRef)(null);(0,n.useEffect)(()=>{var e=a.current;if(!e){return}i.current=document.activeElement;if(r&&i.current&&i.current!==document.body){i.current.blur()}var t=e=>{if(!e||!e.isConnected){return false}var t=getComputedStyle(e);return t.display!=="none"&&t.visibility!=="hidden"&&!e.hidden&&e.offsetParent!==null};var n=()=>{var r='a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])';return Array.from(e.querySelectorAll(r)).filter(e=>{return!e.hasAttribute("disabled")&&t(e)})};var o=()=>{var t=document.querySelectorAll('[data-focus-trap="true"]');return t.length>0&&t[t.length-1]===e};var s=t=>{if(!o()||t.key!=="Tab"){return}var r=n();if(r.length===0){return}var a=r[0];var i=r[r.length-1];var s=document.activeElement;if(!e.contains(s)&&document.body!==s){t.preventDefault();a.focus();return}if(t.shiftKey&&s===a){t.preventDefault();i.focus();return}if(!t.shiftKey&&s===i){t.preventDefault();a.focus();return}};document.addEventListener("keydown",s,true);return()=>{document.removeEventListener("keydown",s,true);if(i.current&&t(i.current)){i.current.focus()}};// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);return/*#__PURE__*/(0,n.cloneElement)(n.Children.only(t),{ref:a,"data-focus-trap":"true",tabIndex:-1})};/* ESM default export */const o=i},9641:function(e,t,r){"use strict";r.d(t,{A:()=>y});/* ESM import */var n=r(6154);/* ESM import */var a=r(3747);/* ESM import */var i=r(1699);/* ESM import */var o=r(6277);/* ESM import */var s=r(74);/* ESM import */var u=r(4459);/* ESM import */var l=r(5781);/* ESM import */var c=r(4532);/* ESM import */var f=r(6439);/* ESM import */var d=r(1817);/* ESM import */var h=r(6967);/* ESM import */var p=r(6014);function v(){var e=(0,n._)(["\n      max-width: 100vw;\n      width: 100vw;\n      height: 95vh;\n    "]);v=function t(){return e};return e}function m(){var e=(0,n._)(["\n      position: absolute;\n      right: ",";\n      top: ",";\n    "]);m=function t(){return e};return e}function g(){var e=(0,n._)(["\n      height: calc(100% - ","px);\n    "]);g=function t(){return e};return e}var b=e=>{var{children:t,onClose:r,title:n,subtitle:i,icon:c,entireHeader:f,actions:p,fullScreen:v,modalStyle:m,maxWidth:g=l/* .modal.BASIC_MODAL_MAX_WIDTH */.yl.BASIC_MODAL_MAX_WIDTH,isCloseAble:b=true,blurTriggerElement:y=true}=e;(0,h/* .useScrollLock */.K$)();return/*#__PURE__*/(0,a/* .jsx */.Y)(u/* ["default"] */.A,{blurPrevious:y,children:/*#__PURE__*/(0,a/* .jsxs */.FD)("div",{css:[w.container({isFullScreen:v}),m],style:{maxWidth:"".concat(g,"px")},children:[/*#__PURE__*/(0,a/* .jsxs */.FD)("div",{css:w.header({hasEntireHeader:!!f}),children:[/*#__PURE__*/(0,a/* .jsx */.Y)(d/* ["default"] */.A,{when:!f,fallback:f,children:/*#__PURE__*/(0,a/* .jsxs */.FD)("div",{css:w.headerContent,children:[/*#__PURE__*/(0,a/* .jsxs */.FD)("div",{css:w.iconWithTitle,children:[/*#__PURE__*/(0,a/* .jsx */.Y)(d/* ["default"] */.A,{when:c,children:c}),/*#__PURE__*/(0,a/* .jsx */.Y)(d/* ["default"] */.A,{when:n,children:/*#__PURE__*/(0,a/* .jsx */.Y)("p",{css:w.title,children:n})})]}),/*#__PURE__*/(0,a/* .jsx */.Y)(d/* ["default"] */.A,{when:i,children:/*#__PURE__*/(0,a/* .jsx */.Y)("span",{css:w.subtitle,children:i})})]})}),/*#__PURE__*/(0,a/* .jsx */.Y)("div",{css:w.actionsWrapper({hasEntireHeader:!!f}),children:/*#__PURE__*/(0,a/* .jsx */.Y)(d/* ["default"] */.A,{when:p,fallback:/*#__PURE__*/(0,a/* .jsx */.Y)(d/* ["default"] */.A,{when:b,children:/*#__PURE__*/(0,a/* .jsx */.Y)("button",{"data-cy":"close-modal",type:"button",css:w.closeButton,onClick:r,children:/*#__PURE__*/(0,a/* .jsx */.Y)(o/* ["default"] */.A,{name:"timesThin",width:24,height:24})})}),children:p})})]}),/*#__PURE__*/(0,a/* .jsx */.Y)("div",{css:w.content({isFullScreen:v}),children:/*#__PURE__*/(0,a/* .jsx */.Y)(s/* ["default"] */.A,{children:t})})]})})};/* ESM default export */const y=b;var w={container:e=>{var{isFullScreen:t}=e;return/*#__PURE__*/(0,i/* .css */.AH)("position:relative;background:",c/* .colorTokens.background.white */.I6.background.white,";box-shadow:",c/* .shadow.modal */.r7.modal,";border-radius:",c/* .borderRadius["10"] */.Vq["10"],";overflow:hidden;top:50%;left:50%;transform:translate(-50%,-50%);",t&&(0,i/* .css */.AH)(v())," ",c/* .Breakpoint.smallTablet */.EA.smallTablet,"{width:90%;}")},header:e=>{var{hasEntireHeader:t}=e;return/*#__PURE__*/(0,i/* .css */.AH)("display:flex;align-items:center;justify-content:space-between;width:100%;height:",!t?"".concat(l/* .modal.BASIC_MODAL_HEADER_HEIGHT */.yl.BASIC_MODAL_HEADER_HEIGHT,"px"):"auto",";background:",c/* .colorTokens.background.white */.I6.background.white,";border-bottom:",!t?"1px solid ".concat(c/* .colorTokens.stroke.divider */.I6.stroke.divider):"none",";padding-inline:",c/* .spacing["16"] */.YK["16"],";")},headerContent:/*#__PURE__*/(0,i/* .css */.AH)("place-self:center start;display:inline-flex;align-items:center;gap:",c/* .spacing["12"] */.YK["12"],";"),iconWithTitle:/*#__PURE__*/(0,i/* .css */.AH)("display:inline-flex;align-items:center;gap:",c/* .spacing["4"] */.YK["4"],";color:",c/* .colorTokens.icon["default"] */.I6.icon["default"],";"),title:/*#__PURE__*/(0,i/* .css */.AH)(f/* .typography.body */.I.body("medium"),";color:",c/* .colorTokens.text.title */.I6.text.title,";"),subtitle:/*#__PURE__*/(0,i/* .css */.AH)(p/* .styleUtils.text.ellipsis */.x.text.ellipsis(1)," ",f/* .typography.caption */.I.caption(),";color:",c/* .colorTokens.text.hints */.I6.text.hints,";"),actionsWrapper:e=>{var{hasEntireHeader:t}=e;return/*#__PURE__*/(0,i/* .css */.AH)("place-self:center end;display:inline-flex;gap:",c/* .spacing["16"] */.YK["16"],";",t&&(0,i/* .css */.AH)(m(),c/* .spacing["16"] */.YK["16"],c/* .spacing["16"] */.YK["16"]))},closeButton:/*#__PURE__*/(0,i/* .css */.AH)(p/* .styleUtils.resetButton */.x.resetButton,";display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:",c/* .borderRadius.circle */.Vq.circle,";background:",c/* .colorTokens.background.white */.I6.background.white,";&:focus,&:active,&:hover{background:",c/* .colorTokens.background.white */.I6.background.white,";}svg{color:",c/* .colorTokens.icon["default"] */.I6.icon["default"],";transition:color 0.3s ease-in-out;}:hover{svg{color:",c/* .colorTokens.icon.hover */.I6.icon.hover,";}}:focus{box-shadow:",c/* .shadow.focus */.r7.focus,";}"),content:e=>{var{isFullScreen:t}=e;return/*#__PURE__*/(0,i/* .css */.AH)("background-color:",c/* .colorTokens.background.white */.I6.background.white,";overflow-y:auto;max-height:90vh;",t&&(0,i/* .css */.AH)(g(),l/* .modal.BASIC_MODAL_HEADER_HEIGHT */.yl.BASIC_MODAL_HEADER_HEIGHT))}}},1385:function(e,t,r){"use strict";r.d(t,{A:()=>f});/* ESM import */var n=r(3747);/* ESM import */var a=r(1699);/* ESM import */var i=r(2470);/* ESM import */var o=/*#__PURE__*/r.n(i);/* ESM import */var s=r(3494);/* ESM import */var u=r(9641);/* ESM import */var l=r(4532);var c=e=>{var{title:t,description:r,confirmButtonText:a,cancelButtonText:o,confirmButtonVariant:l,closeModal:c,onConfirm:f,isLoading:h=false,icon:p,maxWidth:v=460}=e;return/*#__PURE__*/(0,n/* .jsxs */.FD)(u/* ["default"] */.A,{icon:p,onClose:()=>c({action:"CLOSE"}),title:t,maxWidth:v,children:[/*#__PURE__*/(0,n/* .jsx */.Y)("div",{css:d.content,children:r!==null&&r!==void 0?r:(0,i.__)("Once you perform this action this can’t be undone.","tutor-pro")}),/*#__PURE__*/(0,n/* .jsxs */.FD)("div",{css:d.footerWrapper,children:[/*#__PURE__*/(0,n/* .jsx */.Y)(s/* ["default"] */.A,{variant:"text",onClick:()=>c({action:"CLOSE"}),size:"small",children:o!==null&&o!==void 0?o:(0,i.__)("Cancel","tutor-pro")}),/*#__PURE__*/(0,n/* .jsx */.Y)(s/* ["default"] */.A,{variant:l!==null&&l!==void 0?l:"danger",size:"small",loading:h,onClick:()=>{if(f){f()}else{c({action:"CONFIRM"})}},children:a!==null&&a!==void 0?a:(0,i.__)("Delete","tutor-pro")})]})]})};/* ESM default export */const f=c;var d={content:/*#__PURE__*/(0,a/* .css */.AH)("font-size:",l/* .fontSize["14"] */.J["14"],";line-height:",l/* .lineHeight["20"] */.K_["20"],";color:",l/* .colorTokens.text.subdued */.I6.text.subdued,";padding:",l/* .spacing["20"] */.YK["20"],";"),footerWrapper:/*#__PURE__*/(0,a/* .css */.AH)("display:flex;justify-content:end;gap:",l/* .spacing["8"] */.YK["8"],";padding:",l/* .spacing["12"] */.YK["12"]," ",l/* .spacing["16"] */.YK["16"],";box-shadow:",l/* .shadow.dividerTop */.r7.dividerTop,";")}},7316:function(e,t,r){"use strict";r.d(t,{Z:()=>g,h:()=>m});/* ESM import */var n=r(7317);/* ESM import */var a=r(8015);/* ESM import */var i=r(6154);/* ESM import */var o=r(3747);/* ESM import */var s=r(1699);/* ESM import */var u=r(1594);/* ESM import */var l=/*#__PURE__*/r.n(u);/* ESM import */var c=r(4532);/* ESM import */var f=r(4897);/* ESM import */var d=r(6208);function h(){var e=(0,i._)(["\n      background: linear-gradient(\n        73.09deg,\n        rgba(255, 150, 69, 0.4) 18.05%,\n        rgba(255, 100, 113, 0.4) 30.25%,\n        rgba(207, 110, 189, 0.4) 55.42%,\n        rgba(164, 119, 209, 0.4) 71.66%,\n        rgba(62, 100, 222, 0.4) 97.9%\n      );\n      opacity: 1;\n      backdrop-filter: blur(10px);\n    "]);h=function t(){return e};return e}var p={backdrop:e=>{var{magicAi:t=false}=e;return/*#__PURE__*/(0,s/* .css */.AH)("position:fixed;background-color:",c/* .colorTokens.background.modal */.I6.background.modal,";opacity:0.7;inset:0;z-index:",c/* .zIndex.negative */.fE.negative,";",t&&(0,s/* .css */.AH)(h()))},container:/*#__PURE__*/(0,s/* .css */.AH)("z-index:",c/* .zIndex.highest */.fE.highest,";position:fixed;display:flex;justify-content:center;top:0;left:0;width:100%;height:100%;")};var v=/*#__PURE__*/l().createContext({showModal:()=>Promise.resolve({action:"CLOSE"}),closeModal:d/* .noop */.lQ,updateModal:d/* .noop */.lQ,hasModalOnStack:false});var m=()=>(0,u.useContext)(v);var g=e=>{var{children:t}=e;var[r,i]=(0,u.useState)({modals:[]});var s=(0,u.useCallback)(e=>{var{component:t,props:r,closeOnOutsideClick:o=false,closeOnEscape:s=true,isMagicAi:u=false,depthIndex:l=c/* .zIndex.modal */.fE.modal,id:f}=e;return new Promise(e=>{i(i=>(0,a._)((0,n._)({},i),{modals:[...i.modals,{component:t,props:r,resolve:e,closeOnOutsideClick:o,closeOnEscape:s,id:f||(0,d/* .nanoid */.Ak)(),depthIndex:l,isMagicAi:u}]}))})},[]);var h=(0,u.useCallback)(function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{action:"CLOSE"};i(t=>{var r=t.modals[t.modals.length-1];r===null||r===void 0?void 0:r.resolve(e);return(0,a._)((0,n._)({},t),{modals:t.modals.slice(0,t.modals.length-1)})})},[]);var m=(0,u.useCallback)((e,t)=>{i(r=>{var i=r.modals.findIndex(t=>t.id===e);if(i===-1)return r;var o=[...r.modals];var s=o[i];o[i]=(0,a._)((0,n._)({},s),{props:(0,n._)({},s.props,t)});return(0,a._)((0,n._)({},r),{modals:o})})},[]);var{transitions:g}=(0,f/* .useAnimation */.sM)({keys:e=>e.id,data:r.modals,animationType:f/* .AnimationType.slideUp */.J6.slideUp,animationDuration:250});var b=(0,u.useMemo)(()=>{return r.modals.length>0},[r.modals]);(0,u.useEffect)(()=>{var e=e=>{var t;var n=document.querySelectorAll(".tutor-portal-popover");var a=!!document.body.classList.contains("modal-open");if(e.key==="Escape"&&((t=r.modals[r.modals.length-1])===null||t===void 0?void 0:t.closeOnEscape)&&!n.length&&!a){h({action:"CLOSE"})}};if(r.modals.length>0){document.addEventListener("keydown",e,true)}return()=>{document.removeEventListener("keydown",e,true)};// eslint-disable-next-line react-hooks/exhaustive-deps
},[r.modals.length,h]);return/*#__PURE__*/(0,o/* .jsxs */.FD)(v.Provider,{value:{showModal:s,closeModal:h,updateModal:m,hasModalOnStack:b},children:[t,g((e,t,r,i)=>{return/*#__PURE__*/(0,o/* .jsxs */.FD)("div",{"data-cy":"tutor-modal",css:[p.container,{zIndex:t.depthIndex||c/* .zIndex.modal */.fE.modal+i}],children:[/*#__PURE__*/(0,o/* .jsx */.Y)(f/* .AnimatedDiv */.LK,{style:(0,a._)((0,n._)({},e),{width:"100%"}),hideOnOverflow:false,children:/*#__PURE__*/l().createElement(t.component,(0,a._)((0,n._)({},t.props),{closeModal:h}))}),/*#__PURE__*/(0,o/* .jsx */.Y)("div",{css:p.backdrop({magicAi:t.isMagicAi}),onKeyUp:d/* .noop */.lQ,tabIndex:-1,// This is not ideal to attach a click event on a non-interactive element like div,
// but in this case we have to do it.
onClick:()=>{if(t.closeOnOutsideClick){h({action:"CLOSE"})}}})]},t.id)})]})}},9568:function(e,t,r){"use strict";r.d(t,{A:()=>u,P:()=>o});var n,a;var i={ID:0,ajaxurl:"",site_url:"",home_url:"",site_title:"",base_path:"",tutor_url:"",tutor_pro_url:"",dashboard_url:"",nonce_key:"",_tutor_nonce:"",loading_icon_url:"",placeholder_img_src:"",enable_lesson_classic_editor:"",tutor_frontend_dashboard_url:"",backend_course_list_url:"",backend_bundle_list_url:"",frontend_course_list_url:"",frontend_bundle_list_url:"",wp_date_format:"",wp_rest_nonce:"",is_admin:"",is_admin_bar_showing:"",max_upload_size:"",content_change_event:"",is_tutor_course_edit:"",assignment_max_file_allowed:"",current_page:"",quiz_answer_display_time:"",is_ssl:"",course_list_page_url:"",course_post_type:"",local:"",difficulty_levels:[],supported_video_sources:[],edd_products:[],bp_groups:[],timezones:{},addons_data:[],current_user:{data:{id:"",user_login:"",user_pass:"",user_nicename:"",user_email:"",user_url:"",user_registered:"",user_activation_key:"",user_status:"",display_name:""},caps:{},cap_key:"",roles:[],allcaps:{},filter:null},settings:{monetize_by:"tutor",enable_course_marketplace:"off",course_permalink_base:"",supported_video_sources:"",enrollment_expiry_enabled:"off",enable_q_and_a_on_course:"off",instructor_can_delete_course:"off",instructor_can_change_course_author:"off",instructor_can_manage_co_instructors:"off",chatgpt_enable:"off",course_builder_logo_url:"",chatgpt_key_exist:false,hide_admin_bar_for_users:"off",enable_redirect_on_course_publish_from_frontend:"off",instructor_can_publish_course:"off",youtube_api_key_exist:false,membership_only_mode:false,enable_tax:false,enable_individual_tax_control:false,is_tax_included_in_price:false},tutor_currency:{symbol:"",currency:"",position:"",thousand_separator:"",decimal_separator:"",no_of_decimal:""},visibility_control:{course_builder:{}}};var o=window._tutorobject||i;window.ajaxurl=o.ajaxurl;var s={TUTOR_SITE_URL:o.site_url,WP_AJAX_BASE_URL:o.ajaxurl,WP_API_BASE_URL:"".concat(((n=window.wpApiSettings)===null||n===void 0?void 0:n.root)||"").concat(((a=window.wpApiSettings)===null||a===void 0?void 0:a.versionString)||""),VIDEO_SOURCES_SETTINGS_URL:"".concat(o.site_url,"/wp-admin/admin.php?page=tutor_settings&tab_page=course#field_supported_video_sources"),MONETIZATION_SETTINGS_URL:"".concat(o.site_url,"/wp-admin/admin.php?page=tutor_settings&tab_page=monetization"),TUTOR_PRICING_PAGE:"https://tutorlms.com/pricing/",TUTOR_ADDONS_PAGE:"".concat(o.site_url,"/wp-admin/admin.php?page=tutor-addons"),CHATGPT_PLATFORM_URL:"https://platform.openai.com/account/api-keys",TUTOR_MY_COURSES_PAGE_URL:"".concat(o.tutor_frontend_dashboard_url,"/my-courses"),TUTOR_SUPPORT_PAGE_URL:"https://tutorlms.com/support",TUTOR_SUBSCRIPTIONS_PAGE:"".concat(o.site_url,"/wp-admin/admin.php?page=tutor-subscriptions"),TUTOR_ENROLLMENTS_PAGE:"".concat(o.site_url,"/wp-admin/admin.php?page=enrollments"),TUTOR_COUPONS_PAGE:"".concat(o.site_url,"/wp-admin/admin.php?page=tutor_coupons"),TUTOR_IMPORT_EXPORT_PAGE:"".concat(o.site_url,"/wp-admin/admin.php?page=tutor-tools&sub_page=import_export")};/* ESM default export */const u=s},5781:function(e,t,r){"use strict";r.d(t,{I4:()=>m,UA:()=>O,V8:()=>v,gt:()=>x,oW:()=>S,re:()=>u,tv:()=>T,vN:()=>y,yl:()=>w});/* ESM import */var n=r(2470);/* ESM import */var a=/*#__PURE__*/r.n(n);/* ESM import */var i=r(4532);var o=/* unused pure expression or super */null&&5*1024*1024;var s=/* unused pure expression or super */null&&["image/jpeg","image/png","image/gif"];var u=10;var l=48;var c=7;var f=3;var d="/product";var h="/category";var p="/tag";var v=document.dir==="rtl";var m="32px";var g="46px";var b=window.innerWidth;var y={isAboveDesktop:b>=i/* .DesktopBreakpoint */.cH,isAboveTablet:b>=i/* .TabletBreakpoint */.uh,isAboveMobile:b>=i/* .MobileBreakpoint */.G2,isAboveSmallMobile:b>=i/* .SmallMobileBreakpoint */.PB};var w={HEADER_HEIGHT:56,MARGIN_TOP:88,BASIC_MODAL_HEADER_HEIGHT:50,BASIC_MODAL_MAX_WIDTH:1218};var _=/* unused pure expression or super */null&&{MIN_NOTEBOOK_HEIGHT:430,MIN_NOTEBOOK_WIDTH:360,NOTEBOOK_HEADER:50};var x={ADMINISTRATOR:"administrator",TUTOR_INSTRUCTOR:"tutor_instructor",SUBSCRIBER:"subscriber"};var E=/*#__PURE__*//* unused pure expression or super */null&&function(e){e["notebook"]="tutor_course_builder_notebook";return e}({});var O=/*#__PURE__*/function(e){e["day"]="dd";e["month"]="MMM";e["year"]="yyyy";e["yearMonthDay"]="yyyy-LL-dd";e["monthDayYear"]="MMM dd, yyyy";e["hoursMinutes"]="hh:mm a";e["yearMonthDayHourMinuteSecond"]="yyyy-MM-dd hh:mm:ss";e["yearMonthDayHourMinuteSecond24H"]="yyyy-MM-dd HH:mm:ss";e["monthDayYearHoursMinutes"]="MMM dd, yyyy, hh:mm a";e["localMonthDayYearHoursMinutes"]="PPp";e["activityDate"]="MMM dd, yyyy hh:mm aa";e["validityDate"]="dd MMMM yyyy";e["dayMonthYear"]="do MMMM, yyyy";return e}({});var S=/*#__PURE__*/function(e){e["COURSE_BUNDLE"]="course-bundle";e["SUBSCRIPTION"]="subscription";e["SOCIAL_LOGIN"]="social-login";e["CONTENT_DRIP"]="content-drip";e["TUTOR_MULTI_INSTRUCTORS"]="tutor-multi-instructors";e["TUTOR_ASSIGNMENTS"]="tutor-assignments";e["TUTOR_COURSE_PREVIEW"]="tutor-course-preview";e["TUTOR_COURSE_ATTACHMENTS"]="tutor-course-attachments";e["TUTOR_GOOGLE_MEET_INTEGRATION"]="google-meet";e["TUTOR_REPORT"]="tutor-report";e["EMAIL"]="tutor-email";e["CALENDAR"]="calendar";e["NOTIFICATIONS"]="tutor-notifications";e["GOOGLE_CLASSROOM_INTEGRATION"]="google-classroom";e["TUTOR_ZOOM_INTEGRATION"]="tutor-zoom";e["QUIZ_EXPORT_IMPORT"]="quiz-import-export";e["ENROLLMENT"]="enrollments";e["TUTOR_CERTIFICATE"]="tutor-certificate";e["GRADEBOOK"]="gradebook";e["TUTOR_PREREQUISITES"]="tutor-prerequisites";e["BUDDYPRESS"]="buddypress";e["WOOCOMMERCE_SUBSCRIPTIONS"]="wc-subscriptions";e["PAID_MEMBERSHIPS_PRO"]="pmpro";e["RESTRICT_CONTENT_PRO"]="restrict-content-pro";e["WEGLOT"]="tutor-weglot";e["WPML_MULTILINGUAL_CMS"]="tutor-wpml";e["H5P_INTEGRATION"]="h5p";e["CONTENT_BANK"]="content-bank";return e}({});var A=/* unused pure expression or super */null&&{YOUTUBE:/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/,VIMEO:/^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/,// eslint-disable-next-line no-useless-escape
EXTERNAL_URL:/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,SHORTCODE:/^\[.*\]$/};var T=[{label:(0,n.__)("Public","tutor-pro"),value:"publish"},{label:(0,n.__)("Password Protected","tutor-pro"),value:"password_protected"},{label:(0,n.__)("Private","tutor-pro"),value:"private"}];var k={COURSE_BUILDER:{BASICS:{FEATURED_IMAGE:"course_builder.basics_featured_image",INTRO_VIDEO:"course_builder.basics_intro_video",SCHEDULING_OPTIONS:"course_builder.basics_scheduling_options",PRICING_OPTIONS:"course_builder.basics_pricing_options",CATEGORIES:"course_builder.basics_categories",TAGS:"course_builder.basics_tags",AUTHOR:"course_builder.basics_author",INSTRUCTORS:"course_builder.basics_instructors",OPTIONS:{GENERAL:"course_builder.basics_options_general",CONTENT_DRIP:"course_builder.basics_options_content_drip",ENROLLMENT:"course_builder.basics_options_enrollment"}},CURRICULUM:{LESSON:{FEATURED_IMAGE:"course_builder.curriculum_lesson_featured_image",VIDEO:"course_builder.curriculum_lesson_video",VIDEO_PLAYBACK_TIME:"course_builder.curriculum_lesson_video_playback_time",EXERCISE_FILES:"course_builder.curriculum_lesson_exercise_files",LESSON_PREVIEW:"course_builder.curriculum_lesson_lesson_preview"}},ADDITIONAL:{COURSE_BENEFITS:"course_builder.additional_course_benefits",COURSE_TARGET_AUDIENCE:"course_builder.additional_course_target_audience",TOTAL_COURSE_DURATION:"course_builder.additional_total_course_duration",COURSE_MATERIALS_INCLUDES:"course_builder.additional_course_material_includes",COURSE_REQUIREMENTS:"course_builder.additional_course_requirements",CERTIFICATES:"course_builder.additional_certificate",ATTACHMENTS:"course_builder.additional_attachments",SCHEDULE_LIVE_CLASS:"course_builder.additional_schedule_live_class"}}};var R=/* unused pure expression or super */null&&{NEW:"new",UPDATE:"update",NO_CHANGE:"no_change"};var C=/* unused pure expression or super */null&&{name:"checkbox",// eslint-disable-next-line @typescript-eslint/no-explicit-any
value:"",onChange:()=>{},onBlur:()=>{},ref:()=>{}};var P=/* unused pure expression or super */null&&{invalid:false,isTouched:false,isDirty:false,isValidating:false,error:undefined}},4532:function(e,t,r){"use strict";r.d(t,{$A:()=>i,EA:()=>x,G2:()=>y,I6:()=>l,J:()=>f,K_:()=>h,PB:()=>b,Vq:()=>m,Wy:()=>d,YK:()=>c,cH:()=>_,fE:()=>g,iL:()=>E,mw:()=>u,r7:()=>v,uh:()=>w});/* ESM import */var n=r(3458);/* ESM import */var a=/*#__PURE__*/r.n(n);var i=64;var o=355;var s=56;var u={inter:"'Inter', sans-serif;",roboto:"'Roboto', sans-serif;",sfProDisplay:"'SF Pro Display', sans-serif;"};var l={brand:{blue:"#0049f8",black:"#092844"},ai:{gradient_1:"linear-gradient(73.09deg, #FF9645 18.05%, #FF6471 30.25%, #CF6EBD 55.42%, #A477D1 71.66%, #3E64DE 97.9%)",gradient_1_rtl:"linear-gradient(73.09deg, #3E64DE 97.9%, #A477D1 28.34%, #CF6EBD 44.58%, #FF6471 69.75%, #FF9645 81.95%)",gradient_2:"linear-gradient(71.97deg, #FF9645 18.57%, #FF6471 63.71%, #CF6EBD 87.71%, #9B62D4 107.71%, #3E64DE 132.85%)",gradient_2_rtl:"linear-gradient(71.97deg, #3E64DE -67.15%, #9B62D4 -92.29%, #CF6EBD 87.71%, #FF6471 36.29%, #FF9645 81.43%)"},text:{primary:"#212327",title:"#41454f",subdued:"#5b616f",hints:"#767c8e",disable:"#a4a8b2",white:"#ffffff",brand:"#3a62e0",success:"#239c46",warning:"#bd7e00",error:"#f44337",status:{processing:"#007a66",pending:"#a8710d",failed:"#cc1213",completed:"#097336",onHold:"#ac0640",cancelled:"#6f7073",primary:"#3e64de"},wp:"#2271b1",magicAi:"#484F66",ai:{purple:"#9D50FF",gradient:"linear-gradient(73.09deg, #FF9645 18.05%, #FF6471 30.25%, #CF6EBD 55.42%, #A477D1 71.66%, #3E64DE 97.9%)"}},surface:{tutor:"#ffffff",wordpress:"#f1f1f1",navbar:"#F5F5F5",courseBuilder:"#F8F8F8"},background:{brand:"#3e64de",white:"#ffffff",black:"#000000",default:"#f4f6f9",hover:"#f5f6fa",active:"#f0f1f5",disable:"#ebecf0",modal:"#161616",dark10:"#212327",dark20:"#31343b",dark30:"#41454f",null:"#ffffff",success:{fill30:"#F5FBF7",fill40:"#E5F5EB"},warning:{fill40:"#FDF4E3"},status:{success:"#e5f5eb",warning:"#fdf4e3",drip:"#e9edfb",onHold:"#fae8ef",processing:"#e5f9f6",errorFail:"#ffebeb",cancelled:"#eceef2",refunded:"#e5f5f5"},magicAi:{default:"#FBF6FF",skeleton:"#FEF4FF",8:a()("#C984FE",.08)}},icon:{default:"#9197a8",hover:"#4b505c",subdued:"#7e838f",hints:"#b6b9c2",disable:{default:"#b8bdcc",background:"#cbced6",muted:"#dedede"},white:"#ffffff",brand:"#446ef5",wp:"#007cba",error:"#f55e53",warning:"#ffb505",success:"#22a848",drop:"#4761b8",processing:"#00a388"},stroke:{default:"#c3c5cb",hover:"#9095a3",bold:"#41454f",disable:"#dcdfe5",divider:"#e0e2ea",border:"#cdcfd5",white:"#ffffff",brand:"#577fff",neutral:"#7391f0",success:{default:"#4eba6d",fill70:"#6AC088"},warning:"#f5ba63",danger:"#ff9f99",status:{success:"#c8e5d2",warning:"#fae5c5",processing:"#c3e5e0",onHold:"#f1c1d2",cancelled:"#e1e1e8",refunded:"#ccebea",fail:"#fdd9d7"},magicAi:"#C984FE"},border:{neutral:"#C8C8C8",tertiary:"#F5F5F5"},action:{primary:{default:"#3e64de",hover:"#3a5ccc",focus:"#00cceb",active:"#3453b8",disable:"#e3e6eb",wp:"#2271b1",wp_hover:"#135e96"},secondary:{default:"#e9edfb",hover:"#d6dffa",active:"#d0d9f2"},outline:{default:"#ffffff",hover:"#e9edfb",active:"#e1e7fa",disable:"#cacfe0"}},wordpress:{primary:"#2271b1",primaryLight:"#007cba",hoverShape:"#7faee6",sidebarChildText:"#4ea2e6",childBg:"#2d3337",mainBg:"#1e2327",text:"#b5bcc2"},design:{dark:"#1a1b1e",grey:"#41454f",white:"#ffffff",brand:"#3e64de",success:"#24a148",warning:"#ed9700",error:"#f44337"},primary:{main:"#3e64de",100:"#28408e",90:"#395bca",80:"#6180e4",70:"#95aaed",60:"#bdcaf1",50:"#d2dbf5",40:"#e9edfb",30:"#f6f8fd"},color:{black:{main:"#212327",100:"#0b0c0e",90:"#1a1b1e",80:"#31343b",70:"#41454f",60:"#5b616f",50:"#727889",40:"#9ca0ac",30:"#b4b7c0",20:"#c0c3cb",10:"#cdcfd5",8:"#e3e6eb",5:"#eff1f6",3:"#f4f6f9",2:"#fcfcfd",0:"#ffffff"},danger:{main:"#f44337",100:"#c62828",90:"#e53935",80:"#ef5350",70:"#e57373",60:"#fbb4af",50:"#fdd9d7",40:"#feeceb",30:"#fff7f7"},success:{main:"#24a148",100:"#075a2a",90:"#007a38",80:"#3aaa5a",70:"#6ac088",60:"#99d4ae",50:"#cbe9d5",40:"#e5f5eb",30:"#f5fbf7"},warning:{main:"#ed9700",100:"#895800",90:"#e08e00",80:"#f3a33c",70:"#f5ba63",60:"#f9d093",50:"#fce7c7",40:"#fdf4e3",30:"#fefbf4"}},bg:{gray20:"#e3e5eb",white:"#ffffff",error:"#f46363",success:"#24a148",light:"#f9fafc",brand:"#E6ECFF"},ribbon:{red:"linear-gradient(to bottom, #ee0014 0%,#c10010 12.23%,#ee0014 100%)",orange:"linear-gradient(to bottom, #ff7c02 0%,#df6c00 12.23%,#f78010 100%)",green:"linear-gradient(to bottom, #02ff49 0%,#00bb35 12.23%,#04ca3c 100%)",blue:"linear-gradient(to bottom, #0267ff 3.28%,#004bbb 12.23%,#0453ca 100%)"},additionals:{lightMint:"#ebfffb",lightPurple:"#f4e8f8",lightRed:"#ffebeb",lightYellow:"#fffaeb",lightCoffee:"#fcf4ee",lightPurple2:"#f7ebfe",lightBlue:"#edf1fd"}};var c={0:"0",2:"2px",4:"4px",6:"6px",8:"8px",10:"10px",12:"12px",16:"16px",20:"20px",24:"24px",28:"28px",32:"32px",36:"36px",40:"40px",48:"48px",56:"56px",64:"64px",72:"72px",96:"96px",128:"128px",256:"256px",512:"512px"};var f={10:"0.625rem",11:"0.688rem",12:"0.75rem",13:"0.813rem",14:"0.875rem",15:"0.938rem",16:"1rem",18:"1.125rem",20:"1.25rem",24:"1.5rem",28:"1.75rem",30:"1.875rem",32:"2rem",36:"2.25rem",40:"2.5rem",48:"3rem",56:"3.5rem",60:"3.75rem",64:"4rem",80:"5rem"};var d={thin:100,extraLight:200,light:300,regular:400,medium:500,semiBold:600,bold:700,extraBold:800,black:900};var h={12:"0.5rem",14:"0.75rem",15:"0.90rem",16:"1rem",18:"1.125rem",20:"1.25rem",21:"1.313rem",22:"1.375rem",24:"1.5rem",26:"1.625rem",28:"1.75rem",32:"2rem",30:"1.875rem",34:"2.125rem",36:"2.25rem",40:"2.5rem",44:"2.75rem",48:"3rem",56:"3.5rem",58:"3.625rem",64:"4rem",70:"4.375rem",81:"5.063rem"};var p=/* unused pure expression or super */null&&{tight:"-0.05em",normal:"0",wide:"0.05em",extraWide:"0.1em"};var v={focus:"0px 0px 0px 0px rgba(255, 255, 255, 1), 0px 0px 0px 3px rgba(0, 73, 248, 0.9)",button:"0px 1px 0.25px rgba(17, 18, 19, 0.08), inset 0px -1px 0.25px rgba(17, 18, 19, 0.24)",combinedButton:"0px 1px 0px rgba(0, 0, 0, 0.05), inset 0px -1px 0px #bcbfc3, inset 1px 0px 0px #bbbfc3, inset 0px 1px 0px #bbbfc3",combinedButtonExtend:"0px 1px 0px rgba(0, 0, 0, 0.05), inset 0px -1px 0px #bcbfc3, inset 1px 0px 0px #bbbfc3, inset 0px 1px 0px #bbbfc3, inset -1px 0px 0px #bbbfc3",insetButtonPressed:"inset 0px 2px 0px rgba(17, 18, 19, 0.08)",card:"0px 2px 1px rgba(17, 18, 19, 0.05), 0px 0px 1px rgba(17, 18, 19, 0.25)",popover:"0px 6px 22px rgba(17, 18, 19, 0.08), 0px 4px 10px rgba(17, 18, 19, 0.1)",modal:"0px 0px 2px rgba(17, 18, 19, 0.2), 0px 30px 72px rgba(17, 18, 19, 0.2)",base:"0px 1px 3px rgba(17, 18, 19, 0.15)",input:"0px 1px 0px rgba(17, 18, 19, 0.05)",switch:"0px 2px 4px 0px #0000002A",tabs:"inset 0px -1px 0px #dbdcdf",dividerTop:"inset 0px 1px 0px #E4E5E7",underline:"0px 1px 0px #C9CBCF",drag:"3px 7px 8px 0px #00000014",dropList:"0px 6px 20px 0px rgba(28, 49, 104, 0.1)",notebook:"0 0 4px 0 rgba(0, 30, 43, 0.16)",scrollable:"0px -2px 2px 0px #00000014",footer:"0px 1px 0px 0px #E4E5E7 inset"};var m={2:"2px",4:"4px",5:"5px",6:"6px",8:"8px",10:"10px",12:"12px",14:"14px",20:"20px",24:"24px",30:"30px",40:"40px",50:"50px",54:"54px",circle:"50%",card:"8px",min:"4px",input:"6px"};var g={negative:-1,positive:1,dropdown:2,level:0,sidebar:9,header:10,footer:10,modal:25,notebook:1e5,highest:99999};var b=480;var y=782;var w=992;var _=1280;var x={smallMobile:"@media(max-width: ".concat(b,"px)"),mobile:"@media(max-width: ".concat(y,"px)"),smallTablet:"@media(max-width: ".concat(w-1,"px)"),tablet:"@media(max-width: ".concat(_-1,"px)"),desktop:"@media(min-width: ".concat(_,"px)")};var E=1006},6439:function(e,t,r){"use strict";r.d(t,{I:()=>i});/* ESM import */var n=r(4532);/* ESM import */var a=r(1699);var i={heading1:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["80"] */.J["80"],";line-height:",n/* .lineHeight["81"] */.K_["81"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},heading2:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["60"] */.J["60"],";line-height:",n/* .lineHeight["70"] */.K_["70"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},heading3:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["40"] */.J["40"],";line-height:",n/* .lineHeight["48"] */.K_["48"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},heading4:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["30"] */.J["30"],";line-height:",n/* .lineHeight["40"] */.K_["40"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},heading5:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["24"] */.J["24"],";line-height:",n/* .lineHeight["34"] */.K_["34"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},heading6:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["20"] */.J["20"],";line-height:",n/* .lineHeight["30"] */.K_["30"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},body:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["16"] */.J["16"],";line-height:",n/* .lineHeight["26"] */.K_["26"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},caption:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["15"] */.J["15"],";line-height:",n/* .lineHeight["24"] */.K_["24"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},small:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["13"] */.J["13"],";line-height:",n/* .lineHeight["18"] */.K_["18"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")},tiny:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"regular";return/*#__PURE__*/(0,a/* .css */.AH)("font-size:",n/* .fontSize["11"] */.J["11"],";line-height:",n/* .lineHeight["16"] */.K_["16"],";color:",n/* .colorTokens.text.primary */.I6.text.primary,";font-weight:",n/* .fontWeight */.Wy[e],";font-family:",n/* .fontFamily.inter */.mw.inter,";")}}},3313:function(e,t,r){"use strict";r.d(t,{A:()=>a});var n=e=>{var{each:t,children:r,fallback:n=null}=e;if(t.length===0){return n}return t.map((e,t)=>{return r(e,t)})};/* ESM default export */const a=n},1817:function(e,t,r){"use strict";r.d(t,{A:()=>o});/* ESM import */var n=r(7150);var a=e=>{return(0,n/* .isDefined */.O9)(e)&&!!e};var i=e=>{var{when:t,children:r,fallback:n=null}=e;var i=a(t);if(i){return typeof r==="function"?r(t):r}return n};/* ESM default export */const o=i},4897:function(e,t,r){"use strict";// EXPORTS
r.d(t,{J6:()=>/* binding */m,sM:()=>/* binding */b,LK:()=>/* binding */y});// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var n=r(7317);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread_props.js
var a=r(8015);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_without_properties.js + 1 modules
var i=r(9414);// EXTERNAL MODULE: ./node_modules/@emotion/react/jsx-runtime/dist/emotion-react-jsx-runtime.esm.js
var o=r(3747);// EXTERNAL MODULE: ../tutor/node_modules/@react-spring/web/dist/react-spring_web.modern.mjs + 4 modules
var s=r(28);// EXTERNAL MODULE: external "React"
var u=r(1594);// CONCATENATED MODULE: ../tutor/node_modules/react-use-measure/dist/index.js
function l(e,t){let r;return(...n)=>{window.clearTimeout(r),r=window.setTimeout(()=>e(...n),t)}}function c({debounce:e,scroll:t,polyfill:r,offsetSize:n}={debounce:0,scroll:!1,offsetSize:!1}){const a=r||(typeof window=="undefined"?class{}:window.ResizeObserver);if(!a)throw new Error("This browser does not support ResizeObserver out of the box. See: https://github.com/react-spring/react-use-measure/#resize-observer-polyfills");const[i,o]=(0,u.useState)({left:0,top:0,width:0,height:0,bottom:0,right:0,x:0,y:0}),s=(0,u.useRef)({element:null,scrollContainers:null,resizeObserver:null,lastBounds:i,orientationHandler:null}),p=e?typeof e=="number"?e:e.scroll:null,m=e?typeof e=="number"?e:e.resize:null,g=(0,u.useRef)(!1);(0,u.useEffect)(()=>(g.current=!0,()=>void(g.current=!1)));const[b,y,w]=(0,u.useMemo)(()=>{const e=()=>{if(!s.current.element)return;const{left:e,top:t,width:r,height:a,bottom:i,right:u,x:l,y:c}=s.current.element.getBoundingClientRect(),f={left:e,top:t,width:r,height:a,bottom:i,right:u,x:l,y:c};s.current.element instanceof HTMLElement&&n&&(f.height=s.current.element.offsetHeight,f.width=s.current.element.offsetWidth),Object.freeze(f),g.current&&!v(s.current.lastBounds,f)&&o(s.current.lastBounds=f)};return[e,m?l(e,m):e,p?l(e,p):e]},[o,n,p,m]);function _(){s.current.scrollContainers&&(s.current.scrollContainers.forEach(e=>e.removeEventListener("scroll",w,!0)),s.current.scrollContainers=null),s.current.resizeObserver&&(s.current.resizeObserver.disconnect(),s.current.resizeObserver=null),s.current.orientationHandler&&("orientation"in screen&&"removeEventListener"in screen.orientation?screen.orientation.removeEventListener("change",s.current.orientationHandler):"onorientationchange"in window&&window.removeEventListener("orientationchange",s.current.orientationHandler))}function x(){s.current.element&&(s.current.resizeObserver=new a(w),s.current.resizeObserver.observe(s.current.element),t&&s.current.scrollContainers&&s.current.scrollContainers.forEach(e=>e.addEventListener("scroll",w,{capture:!0,passive:!0})),s.current.orientationHandler=()=>{w()},"orientation"in screen&&"addEventListener"in screen.orientation?screen.orientation.addEventListener("change",s.current.orientationHandler):"onorientationchange"in window&&window.addEventListener("orientationchange",s.current.orientationHandler))}const E=e=>{!e||e===s.current.element||(_(),s.current.element=e,s.current.scrollContainers=h(e),x())};return d(w,!!t),f(y),(0,u.useEffect)(()=>{_(),x()},[t,w,y]),(0,u.useEffect)(()=>_,[]),[E,i,b]}function f(e){(0,u.useEffect)(()=>{const t=e;return window.addEventListener("resize",t),()=>void window.removeEventListener("resize",t)},[e])}function d(e,t){(0,u.useEffect)(()=>{if(t){const t=e;return window.addEventListener("scroll",t,{capture:!0,passive:!0}),()=>void window.removeEventListener("scroll",t,!0)}},[e,t])}function h(e){const t=[];if(!e||e===document.body)return t;const{overflow:r,overflowX:n,overflowY:a}=window.getComputedStyle(e);return[r,n,a].some(e=>e==="auto"||e==="scroll")&&t.push(e),[...t,...h(e.parentElement)]}const p=["x","y","top","bottom","left","right","width","height"],v=(e,t)=>p.every(r=>e[r]===t[r]);//# sourceMappingURL=index.js.map
;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/hooks/useAnimation.tsx
var m=/*#__PURE__*/function(e){e[e["slideDown"]=0]="slideDown";e[e["slideUp"]=1]="slideUp";e[e["slideLeft"]=2]="slideLeft";e[e["slideRight"]=3]="slideRight";e[e["collapseExpand"]=4]="collapseExpand";e[e["zoomIn"]=5]="zoomIn";e[e["zoomOut"]=6]="zoomOut";e[e["fadeIn"]=7]="fadeIn";e[e["sidebar"]=8]="sidebar";return e}({});var g=100;var b=e=>{var{data:t,animationType:r=4,slideThreshold:a=20,animationDuration:i=150,minOpacity:o=0,maxOpacity:u=1,easing:l=s/* .easings.easeInOutQuad */.le.easeInOutQuad,debounceMeasure:f=false,keys:d}=e;var h=Array.isArray(t)?t.length>0:!!t;var[p,v]=c({debounce:f?i+g:0});var m=(0,s/* .useSpring */.zh)({from:{height:0,opacity:o,y:0},to:{height:h?v.height:0,opacity:h?u:o,y:h?0:a*-1},config:{duration:i,easing:l}});var b=(0,s/* .useSpring */.zh)({from:{x:0},to:{x:h?0:a*-1},config:{duration:i,easing:l}});var y={x:0,y:0};switch(r){case 0:y.y=a*-1;y.x=0;break;case 1:y.y=a;y.x=0;break;case 2:y.x=a;y.y=0;break;case 3:y.x=a*-1;y.y=0;break}var w=(0,s/* .useTransition */.pn)(t,{keys:d||(e=>{return e}),from:(0,n._)({opacity:o},y,r===5&&{transform:"scale(0.8)"},r===6&&{transform:"scale(1.2)"},r===7&&{opacity:0}),enter:(0,n._)({opacity:u,x:0,y:0},r===5&&{transform:"scale(1)"},r===6&&{transform:"scale(1)"},r===7&&{opacity:1}),leave:(0,n._)({opacity:o},y,r===5&&{transform:"scale(0.8)"},r===6&&{transform:"scale(1.2)"},r===7&&{opacity:0}),config:{duration:i,easing:l}});return{animationStyle:r===8?b:m,ref:p,transitions:w}};var y=e=>{var{children:t,style:r,hideOnOverflow:u=true}=e,l=(0,i._)(e,["children","style","hideOnOverflow"]);return/*#__PURE__*/(0,o/* .jsx */.Y)(s/* .animated.div */.CS.div,(0,a._)((0,n._)({},l),{style:(0,a._)((0,n._)({},r),{overflow:u?"hidden":"initial"}),children:t}))}},6783:function(e,t,r){"use strict";r.d(t,{G:()=>o});/* ESM import */var n=r(7150);/* ESM import */var a=r(7767);/* ESM import */var i=r(5588);var o=e=>{var t=(0,a/* .useLocation */.zy)();var r=(0,i/* .matchRoutes */.ue)(e,t);if(!(0,n/* .isDefined */.O9)(r)){return t.pathname}var o=r.find(e=>e.pathname===t.pathname);return(o===null||o===void 0?void 0:o.route.path)||""}},4938:function(e,t,r){"use strict";r.d(t,{ZL:()=>P,tP:()=>C,ym:()=>x,zA:()=>_});/* ESM import */var n=r(7317);/* ESM import */var a=r(8015);/* ESM import */var i=r(3747);/* ESM import */var o=r(1699);/* ESM import */var s=r(1594);/* ESM import */var u=/*#__PURE__*/r.n(s);/* ESM import */var l=r(5206);/* ESM import */var c=/*#__PURE__*/r.n(l);/* ESM import */var f=r(4459);/* ESM import */var d=r(7316);/* ESM import */var h=r(5781);/* ESM import */var p=r(4532);/* ESM import */var v=r(4897);/* ESM import */var m=r(6967);/* ESM import */var g=r(6014);/* ESM import */var b=r(6208);var y={SAFE_MARGIN:12,MAX_OFFSET_VERTICAL:6,MAX_OFFSET_HORIZONTAL:12,CENTER_OFFSET:8};var w=4;var _={TOP:"top",TOP_LEFT:"topLeft",TOP_RIGHT:"topRight",RIGHT:"right",RIGHT_TOP:"rightTop",RIGHT_BOTTOM:"rightBottom",BOTTOM:"bottom",BOTTOM_LEFT:"bottomLeft",BOTTOM_RIGHT:"bottomRight",LEFT:"left",LEFT_TOP:"leftTop",LEFT_BOTTOM:"leftBottom",MIDDLE:"middle",ABSOLUTE_CENTER:"absoluteCenter"};var x=e=>{var t={[_.TOP]:_.TOP,[_.TOP_LEFT]:_.TOP_RIGHT,[_.TOP_RIGHT]:_.TOP_LEFT,[_.RIGHT]:_.LEFT,[_.RIGHT_TOP]:_.LEFT_TOP,[_.RIGHT_BOTTOM]:_.LEFT_BOTTOM,[_.BOTTOM]:_.BOTTOM,[_.BOTTOM_LEFT]:_.BOTTOM_RIGHT,[_.BOTTOM_RIGHT]:_.BOTTOM_LEFT,[_.LEFT]:_.RIGHT,[_.LEFT_TOP]:_.RIGHT_TOP,[_.LEFT_BOTTOM]:_.RIGHT_BOTTOM,[_.MIDDLE]:_.MIDDLE,[_.ABSOLUTE_CENTER]:_.ABSOLUTE_CENTER};return t[e]||e};var E=e=>{return{top:e.top,left:-e.left}};var O=(e,t)=>{var{width:r,height:n}=t;return{top:e.top<0,bottom:e.top+n>window.innerHeight,left:e.left<0,right:e.left+r>window.innerWidth}};var S=(e,t)=>{return e.startsWith("top")&&t.top||e.startsWith("bottom")&&t.bottom||e.startsWith("left")&&t.left||e.startsWith("right")&&t.right};var A=(e,t,r,n,a)=>{var{width:i,height:o}=r;var{top:s,left:u}=a;var l=t.left+t.width/2-i/2;var c=t.top+t.height/2-o/2;var f={[_.TOP]:{top:t.top-o-n,left:l},[_.TOP_LEFT]:{top:t.top-o-n,left:t.left},[_.TOP_RIGHT]:{top:t.top-o-n,left:t.right-i},[_.BOTTOM]:{top:t.bottom+n,left:l},[_.BOTTOM_LEFT]:{top:t.bottom+n,left:t.left},[_.BOTTOM_RIGHT]:{top:t.bottom+n,left:t.right-i},[_.LEFT]:{top:c,left:t.left-i-n},[_.LEFT_TOP]:{top:t.top,left:t.left-i-n},[_.LEFT_BOTTOM]:{top:t.bottom-o,left:t.left-i-n},[_.RIGHT]:{top:c,left:t.right+n},[_.RIGHT_TOP]:{top:t.top,left:t.right+n},[_.RIGHT_BOTTOM]:{top:t.bottom-o,left:t.right+n},[_.MIDDLE]:{top:c,left:l},[_.ABSOLUTE_CENTER]:{top:window.innerHeight/2-o/2,left:window.innerWidth/2-i/2}};var d=f[e]||f[_.BOTTOM];return{top:d.top+s,left:d.left+u}};var T=(e,t,r,n,a,i)=>{var o={[_.TOP]:_.BOTTOM,[_.TOP_LEFT]:_.BOTTOM_LEFT,[_.TOP_RIGHT]:_.BOTTOM_RIGHT,[_.BOTTOM]:_.TOP,[_.BOTTOM_LEFT]:_.TOP_LEFT,[_.BOTTOM_RIGHT]:_.TOP_RIGHT,[_.LEFT]:_.RIGHT,[_.LEFT_TOP]:_.RIGHT_TOP,[_.LEFT_BOTTOM]:_.RIGHT_BOTTOM,[_.RIGHT]:_.LEFT,[_.RIGHT_TOP]:_.LEFT_TOP,[_.RIGHT_BOTTOM]:_.LEFT_BOTTOM,[_.MIDDLE]:_.MIDDLE,[_.ABSOLUTE_CENTER]:_.ABSOLUTE_CENTER};var s=O(e,r);var u=S(t,s);if(!u){return{position:e,placement:t}}// Try opposite placement
var l=o[t];var c=A(l,n,r,a,i);var f=O(c,r);var d=S(l,f);if(!d){return{position:c,placement:l}}return{position:e,placement:t}};var k=(e,t,r,n)=>{var{width:a,height:i}=n;// Skip arrow for covered triggers or special placements
var o=[_.MIDDLE,_.ABSOLUTE_CENTER].includes(e);var s=r.left<t.left+y.SAFE_MARGIN&&r.left+a>t.right-y.SAFE_MARGIN&&r.top<t.top+y.SAFE_MARGIN&&r.top+i>t.bottom-y.SAFE_MARGIN;if(o||s)return{};var u=e.startsWith("top")||e.startsWith("bottom");var l=e.startsWith("left")||e.startsWith("right");if(u){var c=t.left+t.width/2;var f=Math.max(y.SAFE_MARGIN,Math.min(a-y.MAX_OFFSET_VERTICAL,c-r.left))-y.CENTER_OFFSET;if(h/* .isRTL */.V8){f=a-f-y.CENTER_OFFSET*2}return{arrowLeft:f}}if(l){var d=t.top+t.height/2;var p=Math.max(y.SAFE_MARGIN,Math.min(i-y.MAX_OFFSET_HORIZONTAL,d-r.top))-y.CENTER_OFFSET;return{arrowTop:p}}return{}};var R=function(e,t){var r=arguments.length>2&&arguments[2]!==void 0?arguments[2]:w;var{width:n,height:a}=t;return{left:Math.max(r,Math.min(window.innerWidth-n-r,e.left)),top:Math.max(r,Math.min(window.innerHeight-a-r,e.top))}};var C=e=>{var{isOpen:t,triggerRef:r,placement:i=_.BOTTOM,arrow:o=false,gap:u=10,autoAdjustOverflow:l=true,positionModifier:c={top:0,left:0},dependencies:f=[]}=e;var d=(0,s.useMemo)(()=>r||{current:null},[r]);var p=(0,s.useRef)(null);var[v,m]=(0,s.useState)(0);var[g,b]=(0,s.useState)({left:0,top:0,placement:_.BOTTOM});var y=(0,s.useMemo)(()=>{return h/* .isRTL */.V8?x(i):i},[i]);var w=(0,s.useMemo)(()=>{return h/* .isRTL */.V8?E(c):c},[c]);(0,s.useEffect)(()=>{if(!d.current)return;m(d.current.getBoundingClientRect().width)},[d]);(0,s.useEffect)(()=>{if(!t||!d.current||!p.current)return;var e=d.current.getBoundingClientRect();var r=p.current.getBoundingClientRect();var i={width:r.width||e.width,height:r.height};var s=A(y,e,i,u,w);var c=y;if(l){var f=T(s,y,i,e,u,w);s=f.position;c=f.placement}s=R(s,i);var h=o?k(c,e,s,i):{};b((0,n._)((0,a._)((0,n._)({},s),{placement:c}),h))},[d,p,t,y,w,u,o,l,// eslint-disable-next-line react-hooks/exhaustive-deps
...f]);return{position:g,triggerWidth:v,triggerRef:d,popoverRef:p}};var P=e=>{var{isOpen:t,children:r,onClickOutside:n,onEscape:a,animationType:o=v/* .AnimationType.slideDown */.J6.slideDown}=e;var{hasModalOnStack:u}=(0,d/* .useModal */.h)();(0,m/* .useScrollLock */.K$)(t);(0,s.useEffect)(()=>{var e=e=>{if(e.key==="Escape"){a===null||a===void 0?void 0:a()}};if(!t)return;document.addEventListener("keydown",e,true);return()=>{document.removeEventListener("keydown",e,true)}},[t,u,a]);var{transitions:c}=(0,v/* .useAnimation */.sM)({data:t,animationType:o});return c((e,t)=>{if(!t){return null}return/*#__PURE__*/(0,l.createPortal)(/*#__PURE__*/(0,i/* .jsx */.Y)(v/* .AnimatedDiv */.LK,{css:I.wrapper,style:e,children:/*#__PURE__*/(0,i/* .jsx */.Y)(f/* ["default"] */.A,{children:/*#__PURE__*/(0,i/* .jsxs */.FD)("div",{className:"tutor-portal-popover",role:"presentation",children:[/*#__PURE__*/(0,i/* .jsx */.Y)("div",{css:I.backdrop,onKeyUp:b/* .noop */.lQ,onClick:e=>{e.stopPropagation();n===null||n===void 0?void 0:n()}}),r]})})}),document.body)})};var I={wrapper:/*#__PURE__*/(0,o/* .css */.AH)("position:fixed;z-index:",p/* .zIndex.highest */.fE.highest,";inset:0;"),backdrop:/*#__PURE__*/(0,o/* .css */.AH)(g/* .styleUtils.centeredFlex */.x.centeredFlex,";position:fixed;inset:0;z-index:",p/* .zIndex.negative */.fE.negative,";")}},6967:function(e,t,r){"use strict";r.d(t,{K$:()=>p});/* ESM import */var n=r(1594);/* ESM import */var a=/*#__PURE__*/r.n(n);var i=null;var o=[];var s=null;var u=()=>{if(i!==null)return i;var e=document.createElement("div");e.style.visibility="hidden";e.style.overflow="scroll";e.style.width="100px";document.body.appendChild(e);var t=document.createElement("div");t.style.width="100%";e.appendChild(t);i=e.offsetWidth-t.offsetWidth;document.body.removeChild(e);return i};var l=()=>{if(s){return}var e=u();var t=window.innerWidth>document.documentElement.clientWidth;s={overflow:document.body.style.overflow,paddingRight:document.body.style.paddingRight};document.body.style.overflow="hidden";if(t&&e>0){var r=parseInt(window.getComputedStyle(document.body).paddingRight||"0",10);document.body.style.paddingRight="".concat(r+e,"px")}};var c=()=>{if(!s){return}document.body.style.overflow=s.overflow;document.body.style.paddingRight=s.paddingRight;s=null};var f=()=>{var e=Symbol("scroll-lock");o.push(e);if(o.length===1){l()}return e};var d=new Set;var h=e=>{var t=o.indexOf(e);if(t===-1){return}o.splice(t,1);d.delete(e);if(o.length===0&&d.size===0){c()}};var p=function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:true;var t=(0,n.useRef)(null);(0,n.useEffect)(()=>{if(!e){if(t.current){h(t.current);t.current=null}return}t.current=f();return()=>{if(t.current){var e=t.current;t.current=null;d.add(e);requestAnimationFrame(()=>{h(e)})}}},[e])}},1554:function(e,t,r){"use strict";r.d(t,{A:()=>g});/* ESM import */var n=r(6154);/* ESM import */var a=r(3747);/* ESM import */var i=r(1699);/* ESM import */var o=r(5781);/* ESM import */var s=r(4532);/* ESM import */var u=r(4897);/* ESM import */var l=r(4938);function c(){var e=(0,n._)(["\n              border-left: 8px solid transparent;\n              border-right: 8px solid transparent;\n              border-top: 8px solid ",";\n              border-bottom: none;\n              left: ",";\n              bottom: -8px;\n              transform: ",";\n            "]);c=function t(){return e};return e}function f(){var e=(0,n._)(["\n              border-left: 8px solid transparent;\n              border-right: 8px solid transparent;\n              border-bottom: 8px solid ",";\n              border-top: none;\n              left: ",";\n              top: -8px;\n              transform: ",";\n            "]);f=function t(){return e};return e}function d(){var e=(0,n._)(["\n              border-top: 8px solid transparent;\n              border-bottom: 8px solid transparent;\n              border-left: 8px solid ",";\n              border-right: none;\n              right: -8px;\n              top: ",";\n              transform: ",";\n            "]);d=function t(){return e};return e}function h(){var e=(0,n._)(["\n              border-top: 8px solid transparent;\n              border-bottom: 8px solid transparent;\n              border-right: 8px solid ",";\n              border-left: none;\n              left: -8px;\n              top: ",";\n              transform: ",";\n            "]);h=function t(){return e};return e}function p(){var e=(0,n._)(["\n            content: '';\n            position: absolute;\n            width: 0;\n            height: 0;\n            border-color: transparent;\n            border-style: solid;\n            ","\n            ","\n            ","\n            ","\n          "]);p=function t(){return e};return e}var v=e=>{var{children:t,placement:r=l/* .POPOVER_PLACEMENTS.BOTTOM */.zA.BOTTOM,triggerRef:n,isOpen:i,gap:s,maxWidth:c,closePopover:f,closeOnEscape:d=true,animationType:h=u/* .AnimationType.slideLeft */.J6.slideLeft,arrow:p=false,autoAdjustOverflow:v=true,positionModifier:g={top:0,left:0},dependencies:b=[]}=e;var{position:y,triggerWidth:w,popoverRef:_}=(0,l/* .usePortalPopover */.tP)({triggerRef:n,isOpen:i,autoAdjustOverflow:v,placement:r,arrow:p,gap:s,positionModifier:g,dependencies:b});return/*#__PURE__*/(0,a/* .jsx */.Y)(l/* .Portal */.ZL,{isOpen:i,onClickOutside:f,animationType:h,onEscape:d?f:undefined,children:/*#__PURE__*/(0,a/* .jsx */.Y)("div",{css:m.wrapper({placement:o/* .isRTL */.V8?(0,l/* .getMirroredPlacement */.ym)(y.placement):y.placement,hideArrow:!p||y.arrowLeft===undefined&&y.arrowTop===undefined,arrowLeft:y.arrowLeft,arrowTop:y.arrowTop}),style:{left:y.left,top:y.top,maxWidth:c!==null&&c!==void 0?c:w},ref:_,children:/*#__PURE__*/(0,a/* .jsx */.Y)("div",{css:m.content,children:t})})})};var m={wrapper:e=>{var{placement:t,hideArrow:r,arrowLeft:n,arrowTop:a}=e;return/*#__PURE__*/(0,i/* .css */.AH)("position:absolute;width:100%;z-index:",s/* .zIndex.dropdown */.fE.dropdown,";&::before{",t&&!r?(0,i/* .css */.AH)(p(),t.startsWith("top")&&(0,i/* .css */.AH)(c(),s/* .colorTokens.stroke.white */.I6.stroke.white,n!==undefined?"".concat(n,"px"):"50%",n===undefined?"translateX(-50%)":"none"),t.startsWith("bottom")&&(0,i/* .css */.AH)(f(),s/* .colorTokens.stroke.white */.I6.stroke.white,n!==undefined?"".concat(n,"px"):"50%",n===undefined?"translateX(-50%)":"none"),t.startsWith("left")&&(0,i/* .css */.AH)(d(),s/* .colorTokens.stroke.white */.I6.stroke.white,a!==undefined?"".concat(a,"px"):"50%",a===undefined?"translateY(-50%)":"none"),t.startsWith("right")&&(0,i/* .css */.AH)(h(),s/* .colorTokens.stroke.white */.I6.stroke.white,a!==undefined?"".concat(a,"px"):"50%",a===undefined?"translateY(-50%)":"none")):"","}")},content:/*#__PURE__*/(0,i/* .css */.AH)("background-color:",s/* .colorTokens.background.white */.I6.background.white,";box-shadow:",s/* .shadow.popover */.r7.popover,";border-radius:",s/* .borderRadius["6"] */.Vq["6"],";::-webkit-scrollbar{background-color:",s/* .colorTokens.background.white */.I6.background.white,";width:10px;}::-webkit-scrollbar-thumb{background-color:",s/* .colorTokens.action.secondary["default"] */.I6.action.secondary["default"],";border-radius:",s/* .borderRadius["6"] */.Vq["6"],";}")};/* ESM default export */const g=v},9576:function(e,t,r){"use strict";// EXPORTS
r.d(t,{b:()=>/* binding */rd,v:()=>/* binding */rf});// NAMESPACE OBJECT: ../tutor/node_modules/axios/lib/platform/common/utils.js
var n={};r.r(n);r.d(n,{hasBrowserEnv:()=>eH,hasStandardBrowserEnv:()=>eY,hasStandardBrowserWebWorkerEnv:()=>ez,navigator:()=>eB,origin:()=>eq});// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var a=r(7317);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread_props.js
var i=r(8015);// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/bind.js
function o(e,t){return function r(){return e.apply(t,arguments)}};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/utils.js
// utils is a library of generic helper functions non-specific to axios
const{toString:s}=Object.prototype;const{getPrototypeOf:u}=Object;const{iterator:l,toStringTag:c}=Symbol;const f=(e=>t=>{const r=s.call(t);return e[r]||(e[r]=r.slice(8,-1).toLowerCase())})(Object.create(null));const d=e=>{e=e.toLowerCase();return t=>f(t)===e};const h=e=>t=>typeof t===e;/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 *
 * @returns {boolean} True if value is an Array, otherwise false
 */const{isArray:p}=Array;/**
 * Determine if a value is undefined
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if the value is undefined, otherwise false
 */const v=h("undefined");/**
 * Determine if a value is a Buffer
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a Buffer, otherwise false
 */function m(e){return e!==null&&!v(e)&&e.constructor!==null&&!v(e.constructor)&&w(e.constructor.isBuffer)&&e.constructor.isBuffer(e)}/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */const g=d("ArrayBuffer");/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */function b(e){let t;if(typeof ArrayBuffer!=="undefined"&&ArrayBuffer.isView){t=ArrayBuffer.isView(e)}else{t=e&&e.buffer&&g(e.buffer)}return t}/**
 * Determine if a value is a String
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a String, otherwise false
 */const y=h("string");/**
 * Determine if a value is a Function
 *
 * @param {*} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */const w=h("function");/**
 * Determine if a value is a Number
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a Number, otherwise false
 */const _=h("number");/**
 * Determine if a value is an Object
 *
 * @param {*} thing The value to test
 *
 * @returns {boolean} True if value is an Object, otherwise false
 */const x=e=>e!==null&&typeof e==="object";/**
 * Determine if a value is a Boolean
 *
 * @param {*} thing The value to test
 * @returns {boolean} True if value is a Boolean, otherwise false
 */const E=e=>e===true||e===false;/**
 * Determine if a value is a plain Object
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a plain Object, otherwise false
 */const O=e=>{if(f(e)!=="object"){return false}const t=u(e);return(t===null||t===Object.prototype||Object.getPrototypeOf(t)===null)&&!(c in e)&&!(l in e)};/**
 * Determine if a value is an empty object (safely handles Buffers)
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is an empty object, otherwise false
 */const S=e=>{// Early return for non-objects or Buffers to prevent RangeError
if(!x(e)||m(e)){return false}try{return Object.keys(e).length===0&&Object.getPrototypeOf(e)===Object.prototype}catch(e){// Fallback for any other objects that might cause RangeError with Object.keys()
return false}};/**
 * Determine if a value is a Date
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a Date, otherwise false
 */const A=d("Date");/**
 * Determine if a value is a File
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a File, otherwise false
 */const T=d("File");/**
 * Determine if a value is a Blob
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a Blob, otherwise false
 */const k=d("Blob");/**
 * Determine if a value is a FileList
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a File, otherwise false
 */const R=d("FileList");/**
 * Determine if a value is a Stream
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a Stream, otherwise false
 */const C=e=>x(e)&&w(e.pipe);/**
 * Determine if a value is a FormData
 *
 * @param {*} thing The value to test
 *
 * @returns {boolean} True if value is an FormData, otherwise false
 */const P=e=>{let t;return e&&(typeof FormData==="function"&&e instanceof FormData||w(e.append)&&((t=f(e))==="formdata"||// detect form-data instance
t==="object"&&w(e.toString)&&e.toString()==="[object FormData]"))};/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */const I=d("URLSearchParams");const[D,M,F,L]=["ReadableStream","Request","Response","Headers"].map(d);/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 *
 * @returns {String} The String freed of excess whitespace
 */const N=e=>e.trim?e.trim():e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"");/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 *
 * @param {Boolean} [allOwnKeys = false]
 * @returns {any}
 */function j(e,t,{allOwnKeys:r=false}={}){// Don't bother if no value provided
if(e===null||typeof e==="undefined"){return}let n;let a;// Force an array if not already something iterable
if(typeof e!=="object"){/*eslint no-param-reassign:0*/e=[e]}if(p(e)){// Iterate over array values
for(n=0,a=e.length;n<a;n++){t.call(null,e[n],n,e)}}else{// Buffer check
if(m(e)){return}// Iterate over object keys
const a=r?Object.getOwnPropertyNames(e):Object.keys(e);const i=a.length;let o;for(n=0;n<i;n++){o=a[n];t.call(null,e[o],o,e)}}}function U(e,t){if(m(e)){return null}t=t.toLowerCase();const r=Object.keys(e);let n=r.length;let a;while(n-- >0){a=r[n];if(t===a.toLowerCase()){return a}}return null}const H=(()=>{/*eslint no-undef:0*/if(typeof globalThis!=="undefined")return globalThis;return typeof self!=="undefined"?self:typeof window!=="undefined"?window:global})();const B=e=>!v(e)&&e!==H;/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 *
 * @returns {Object} Result of all merge properties
 */function Y(){const{caseless:e}=B(this)&&this||{};const t={};const r=(r,n)=>{const a=e&&U(t,n)||n;if(O(t[a])&&O(r)){t[a]=Y(t[a],r)}else if(O(r)){t[a]=Y({},r)}else if(p(r)){t[a]=r.slice()}else{t[a]=r}};for(let e=0,t=arguments.length;e<t;e++){arguments[e]&&j(arguments[e],r)}return t}/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 *
 * @param {Boolean} [allOwnKeys]
 * @returns {Object} The resulting value of object a
 */const z=(e,t,r,{allOwnKeys:n}={})=>{j(t,(t,n)=>{if(r&&w(t)){e[n]=o(t,r)}else{e[n]=t}},{allOwnKeys:n});return e};/**
 * Remove byte order marker. This catches EF BB BF (the UTF-8 BOM)
 *
 * @param {string} content with BOM
 *
 * @returns {string} content value without BOM
 */const q=e=>{if(e.charCodeAt(0)===65279){e=e.slice(1)}return e};/**
 * Inherit the prototype methods from one constructor into another
 * @param {function} constructor
 * @param {function} superConstructor
 * @param {object} [props]
 * @param {object} [descriptors]
 *
 * @returns {void}
 */const V=(e,t,r,n)=>{e.prototype=Object.create(t.prototype,n);e.prototype.constructor=e;Object.defineProperty(e,"super",{value:t.prototype});r&&Object.assign(e.prototype,r)};/**
 * Resolve object with deep prototype chain to a flat object
 * @param {Object} sourceObj source object
 * @param {Object} [destObj]
 * @param {Function|Boolean} [filter]
 * @param {Function} [propFilter]
 *
 * @returns {Object}
 */const W=(e,t,r,n)=>{let a;let i;let o;const s={};t=t||{};// eslint-disable-next-line no-eq-null,eqeqeq
if(e==null)return t;do{a=Object.getOwnPropertyNames(e);i=a.length;while(i-- >0){o=a[i];if((!n||n(o,e,t))&&!s[o]){t[o]=e[o];s[o]=true}}e=r!==false&&u(e)}while(e&&(!r||r(e,t))&&e!==Object.prototype)return t};/**
 * Determines whether a string ends with the characters of a specified string
 *
 * @param {String} str
 * @param {String} searchString
 * @param {Number} [position= 0]
 *
 * @returns {boolean}
 */const $=(e,t,r)=>{e=String(e);if(r===undefined||r>e.length){r=e.length}r-=t.length;const n=e.indexOf(t,r);return n!==-1&&n===r};/**
 * Returns new array from array like object or null if failed
 *
 * @param {*} [thing]
 *
 * @returns {?Array}
 */const G=e=>{if(!e)return null;if(p(e))return e;let t=e.length;if(!_(t))return null;const r=new Array(t);while(t-- >0){r[t]=e[t]}return r};/**
 * Checking if the Uint8Array exists and if it does, it returns a function that checks if the
 * thing passed in is an instance of Uint8Array
 *
 * @param {TypedArray}
 *
 * @returns {Array}
 */// eslint-disable-next-line func-names
const K=(e=>{// eslint-disable-next-line func-names
return t=>{return e&&t instanceof e}})(typeof Uint8Array!=="undefined"&&u(Uint8Array));/**
 * For each entry in the object, call the function with the key and value.
 *
 * @param {Object<any, any>} obj - The object to iterate over.
 * @param {Function} fn - The function to call for each entry.
 *
 * @returns {void}
 */const Q=(e,t)=>{const r=e&&e[l];const n=r.call(e);let a;while((a=n.next())&&!a.done){const r=a.value;t.call(e,r[0],r[1])}};/**
 * It takes a regular expression and a string, and returns an array of all the matches
 *
 * @param {string} regExp - The regular expression to match against.
 * @param {string} str - The string to search.
 *
 * @returns {Array<boolean>}
 */const X=(e,t)=>{let r;const n=[];while((r=e.exec(t))!==null){n.push(r)}return n};/* Checking if the kindOfTest function returns true when passed an HTMLFormElement. */const J=d("HTMLFormElement");const Z=e=>{return e.toLowerCase().replace(/[-_\s]([a-z\d])(\w*)/g,function e(e,t,r){return t.toUpperCase()+r})};/* Creating a function that will check if an object has a property. */const ee=(({hasOwnProperty:e})=>(t,r)=>e.call(t,r))(Object.prototype);/**
 * Determine if a value is a RegExp object
 *
 * @param {*} val The value to test
 *
 * @returns {boolean} True if value is a RegExp object, otherwise false
 */const et=d("RegExp");const er=(e,t)=>{const r=Object.getOwnPropertyDescriptors(e);const n={};j(r,(r,a)=>{let i;if((i=t(r,a,e))!==false){n[a]=i||r}});Object.defineProperties(e,n)};/**
 * Makes all methods read-only
 * @param {Object} obj
 */const en=e=>{er(e,(t,r)=>{// skip restricted props in strict mode
if(w(e)&&["arguments","caller","callee"].indexOf(r)!==-1){return false}const n=e[r];if(!w(n))return;t.enumerable=false;if("writable"in t){t.writable=false;return}if(!t.set){t.set=()=>{throw Error("Can not rewrite read-only method '"+r+"'")}}})};const ea=(e,t)=>{const r={};const n=e=>{e.forEach(e=>{r[e]=true})};p(e)?n(e):n(String(e).split(t));return r};const ei=()=>{};const eo=(e,t)=>{return e!=null&&Number.isFinite(e=+e)?e:t};/**
 * If the thing is a FormData object, return true, otherwise return false.
 *
 * @param {unknown} thing - The thing to check.
 *
 * @returns {boolean}
 */function es(e){return!!(e&&w(e.append)&&e[c]==="FormData"&&e[l])}const eu=e=>{const t=new Array(10);const r=(e,n)=>{if(x(e)){if(t.indexOf(e)>=0){return}//Buffer check
if(m(e)){return e}if(!("toJSON"in e)){t[n]=e;const a=p(e)?[]:{};j(e,(e,t)=>{const i=r(e,n+1);!v(i)&&(a[t]=i)});t[n]=undefined;return a}}return e};return r(e,0)};const el=d("AsyncFunction");const ec=e=>e&&(x(e)||w(e))&&w(e.then)&&w(e.catch);// original code
// https://github.com/DigitalBrainJS/AxiosPromise/blob/16deab13710ec09779922131f3fa5954320f83ab/lib/utils.js#L11-L34
const ef=((e,t)=>{if(e){return setImmediate}return t?((e,t)=>{H.addEventListener("message",({source:r,data:n})=>{if(r===H&&n===e){t.length&&t.shift()()}},false);return r=>{t.push(r);H.postMessage(e,"*")}})(`axios@${Math.random()}`,[]):e=>setTimeout(e)})(typeof setImmediate==="function",w(H.postMessage));const ed=typeof queueMicrotask!=="undefined"?queueMicrotask.bind(H):typeof process!=="undefined"&&process.nextTick||ef;// *********************
const eh=e=>e!=null&&w(e[l]);/* ESM default export */const ep={isArray:p,isArrayBuffer:g,isBuffer:m,isFormData:P,isArrayBufferView:b,isString:y,isNumber:_,isBoolean:E,isObject:x,isPlainObject:O,isEmptyObject:S,isReadableStream:D,isRequest:M,isResponse:F,isHeaders:L,isUndefined:v,isDate:A,isFile:T,isBlob:k,isRegExp:et,isFunction:w,isStream:C,isURLSearchParams:I,isTypedArray:K,isFileList:R,forEach:j,merge:Y,extend:z,trim:N,stripBOM:q,inherits:V,toFlatObject:W,kindOf:f,kindOfTest:d,endsWith:$,toArray:G,forEachEntry:Q,matchAll:X,isHTMLForm:J,hasOwnProperty:ee,hasOwnProp:ee,reduceDescriptors:er,freezeMethods:en,toObjectSet:ea,toCamelCase:Z,noop:ei,toFiniteNumber:eo,findKey:U,global:H,isContextDefined:B,isSpecCompliantForm:es,toJSONObject:eu,isAsyncFn:el,isThenable:ec,setImmediate:ef,asap:ed,isIterable:eh};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/AxiosError.js
/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [config] The config.
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 *
 * @returns {Error} The created error.
 */function ev(e,t,r,n,a){Error.call(this);if(Error.captureStackTrace){Error.captureStackTrace(this,this.constructor)}else{this.stack=new Error().stack}this.message=e;this.name="AxiosError";t&&(this.code=t);r&&(this.config=r);n&&(this.request=n);if(a){this.response=a;this.status=a.status?a.status:null}}ep.inherits(ev,Error,{toJSON:function e(){return{// Standard
message:this.message,name:this.name,// Microsoft
description:this.description,number:this.number,// Mozilla
fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,// Axios
config:ep.toJSONObject(this.config),code:this.code,status:this.status}}});const em=ev.prototype;const eg={};["ERR_BAD_OPTION_VALUE","ERR_BAD_OPTION","ECONNABORTED","ETIMEDOUT","ERR_NETWORK","ERR_FR_TOO_MANY_REDIRECTS","ERR_DEPRECATED","ERR_BAD_RESPONSE","ERR_BAD_REQUEST","ERR_CANCELED","ERR_NOT_SUPPORT","ERR_INVALID_URL"].forEach(e=>{eg[e]={value:e}});Object.defineProperties(ev,eg);Object.defineProperty(em,"isAxiosError",{value:true});// eslint-disable-next-line func-names
ev.from=(e,t,r,n,a,i)=>{const o=Object.create(em);ep.toFlatObject(e,o,function e(e){return e!==Error.prototype},e=>{return e!=="isAxiosError"});ev.call(o,e.message,t,r,n,a);o.cause=e;o.name=e.name;i&&Object.assign(o,i);return o};/* ESM default export */const eb=ev;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/null.js
// eslint-disable-next-line strict
/* ESM default export */const ey=null;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/toFormData.js
// temporary hotfix to avoid circular references until AxiosURLSearchParams is refactored
/**
 * Determines if the given thing is a array or js object.
 *
 * @param {string} thing - The object or array to be visited.
 *
 * @returns {boolean}
 */function ew(e){return ep.isPlainObject(e)||ep.isArray(e)}/**
 * It removes the brackets from the end of a string
 *
 * @param {string} key - The key of the parameter.
 *
 * @returns {string} the key without the brackets.
 */function e_(e){return ep.endsWith(e,"[]")?e.slice(0,-2):e}/**
 * It takes a path, a key, and a boolean, and returns a string
 *
 * @param {string} path - The path to the current key.
 * @param {string} key - The key of the current object being iterated over.
 * @param {string} dots - If true, the key will be rendered with dots instead of brackets.
 *
 * @returns {string} The path to the current key.
 */function ex(e,t,r){if(!e)return t;return e.concat(t).map(function e(e,t){// eslint-disable-next-line no-param-reassign
e=e_(e);return!r&&t?"["+e+"]":e}).join(r?".":"")}/**
 * If the array is an array and none of its elements are visitable, then it's a flat array.
 *
 * @param {Array<any>} arr - The array to check
 *
 * @returns {boolean}
 */function eE(e){return ep.isArray(e)&&!e.some(ew)}const eO=ep.toFlatObject(ep,{},null,function e(e){return/^is[A-Z]/.test(e)});/**
 * Convert a data object to FormData
 *
 * @param {Object} obj
 * @param {?Object} [formData]
 * @param {?Object} [options]
 * @param {Function} [options.visitor]
 * @param {Boolean} [options.metaTokens = true]
 * @param {Boolean} [options.dots = false]
 * @param {?Boolean} [options.indexes = false]
 *
 * @returns {Object}
 **//**
 * It converts an object into a FormData object
 *
 * @param {Object<any, any>} obj - The object to convert to form data.
 * @param {string} formData - The FormData object to append to.
 * @param {Object<string, any>} options
 *
 * @returns
 */function eS(e,t,r){if(!ep.isObject(e)){throw new TypeError("target must be an object")}// eslint-disable-next-line no-param-reassign
t=t||new(ey||FormData);// eslint-disable-next-line no-param-reassign
r=ep.toFlatObject(r,{metaTokens:true,dots:false,indexes:false},false,function e(e,t){// eslint-disable-next-line no-eq-null,eqeqeq
return!ep.isUndefined(t[e])});const n=r.metaTokens;// eslint-disable-next-line no-use-before-define
const a=r.visitor||c;const i=r.dots;const o=r.indexes;const s=r.Blob||typeof Blob!=="undefined"&&Blob;const u=s&&ep.isSpecCompliantForm(t);if(!ep.isFunction(a)){throw new TypeError("visitor must be a function")}function l(e){if(e===null)return"";if(ep.isDate(e)){return e.toISOString()}if(ep.isBoolean(e)){return e.toString()}if(!u&&ep.isBlob(e)){throw new eb("Blob is not supported. Use a Buffer instead.")}if(ep.isArrayBuffer(e)||ep.isTypedArray(e)){return u&&typeof Blob==="function"?new Blob([e]):Buffer.from(e)}return e}/**
   * Default visitor.
   *
   * @param {*} value
   * @param {String|Number} key
   * @param {Array<String|Number>} path
   * @this {FormData}
   *
   * @returns {boolean} return true to visit the each prop of the value recursively
   */function c(e,r,a){let s=e;if(e&&!a&&typeof e==="object"){if(ep.endsWith(r,"{}")){// eslint-disable-next-line no-param-reassign
r=n?r:r.slice(0,-2);// eslint-disable-next-line no-param-reassign
e=JSON.stringify(e)}else if(ep.isArray(e)&&eE(e)||(ep.isFileList(e)||ep.endsWith(r,"[]"))&&(s=ep.toArray(e))){// eslint-disable-next-line no-param-reassign
r=e_(r);s.forEach(function e(e,n){!(ep.isUndefined(e)||e===null)&&t.append(// eslint-disable-next-line no-nested-ternary
o===true?ex([r],n,i):o===null?r:r+"[]",l(e))});return false}}if(ew(e)){return true}t.append(ex(a,r,i),l(e));return false}const f=[];const d=Object.assign(eO,{defaultVisitor:c,convertValue:l,isVisitable:ew});function h(e,r){if(ep.isUndefined(e))return;if(f.indexOf(e)!==-1){throw Error("Circular reference detected in "+r.join("."))}f.push(e);ep.forEach(e,function e(e,n){const i=!(ep.isUndefined(e)||e===null)&&a.call(t,e,ep.isString(n)?n.trim():n,r,d);if(i===true){h(e,r?r.concat(n):[n])}});f.pop()}if(!ep.isObject(e)){throw new TypeError("data must be an object")}h(e);return t}/* ESM default export */const eA=eS;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/AxiosURLSearchParams.js
/**
 * It encodes a string by replacing all characters that are not in the unreserved set with
 * their percent-encoded equivalents
 *
 * @param {string} str - The string to encode.
 *
 * @returns {string} The encoded string.
 */function eT(e){const t={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"};return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g,function e(e){return t[e]})}/**
 * It takes a params object and converts it to a FormData object
 *
 * @param {Object<string, any>} params - The parameters to be converted to a FormData object.
 * @param {Object<string, any>} options - The options object passed to the Axios constructor.
 *
 * @returns {void}
 */function ek(e,t){this._pairs=[];e&&eA(e,this,t)}const eR=ek.prototype;eR.append=function e(e,t){this._pairs.push([e,t])};eR.toString=function e(e){const t=e?function(t){return e.call(this,t,eT)}:eT;return this._pairs.map(function e(e){return t(e[0])+"="+t(e[1])},"").join("&")};/* ESM default export */const eC=ek;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/buildURL.js
/**
 * It replaces all instances of the characters `:`, `$`, `,`, `+`, `[`, and `]` with their
 * URI encoded counterparts
 *
 * @param {string} val The value to be encoded.
 *
 * @returns {string} The encoded value.
 */function eP(e){return encodeURIComponent(e).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @param {?(object|Function)} options
 *
 * @returns {string} The formatted url
 */function eI(e,t,r){/*eslint no-param-reassign:0*/if(!t){return e}const n=r&&r.encode||eP;if(ep.isFunction(r)){r={serialize:r}}const a=r&&r.serialize;let i;if(a){i=a(t,r)}else{i=ep.isURLSearchParams(t)?t.toString():new eC(t,r).toString(n)}if(i){const t=e.indexOf("#");if(t!==-1){e=e.slice(0,t)}e+=(e.indexOf("?")===-1?"?":"&")+i}return e};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/InterceptorManager.js
class eD{constructor(){this.handlers=[]}/**
   * Add a new interceptor to the stack
   *
   * @param {Function} fulfilled The function to handle `then` for a `Promise`
   * @param {Function} rejected The function to handle `reject` for a `Promise`
   *
   * @return {Number} An ID used to remove interceptor later
   */use(e,t,r){this.handlers.push({fulfilled:e,rejected:t,synchronous:r?r.synchronous:false,runWhen:r?r.runWhen:null});return this.handlers.length-1}/**
   * Remove an interceptor from the stack
   *
   * @param {Number} id The ID that was returned by `use`
   *
   * @returns {Boolean} `true` if the interceptor was removed, `false` otherwise
   */eject(e){if(this.handlers[e]){this.handlers[e]=null}}/**
   * Clear all interceptors from the stack
   *
   * @returns {void}
   */clear(){if(this.handlers){this.handlers=[]}}/**
   * Iterate over all the registered interceptors
   *
   * This method is particularly useful for skipping over any
   * interceptors that may have become `null` calling `eject`.
   *
   * @param {Function} fn The function to call for each interceptor
   *
   * @returns {void}
   */forEach(e){ep.forEach(this.handlers,function t(t){if(t!==null){e(t)}})}}/* ESM default export */const eM=eD;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/defaults/transitional.js
/* ESM default export */const eF={silentJSONParsing:true,forcedJSONParsing:true,clarifyTimeoutError:false};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/platform/browser/classes/URLSearchParams.js
/* ESM default export */const eL=typeof URLSearchParams!=="undefined"?URLSearchParams:eC;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/platform/browser/classes/FormData.js
/* ESM default export */const eN=typeof FormData!=="undefined"?FormData:null;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/platform/browser/classes/Blob.js
/* ESM default export */const ej=typeof Blob!=="undefined"?Blob:null;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/platform/browser/index.js
/* ESM default export */const eU={isBrowser:true,classes:{URLSearchParams:eL,FormData:eN,Blob:ej},protocols:["http","https","file","blob","url","data"]};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/platform/common/utils.js
const eH=typeof window!=="undefined"&&typeof document!=="undefined";const eB=typeof navigator==="object"&&navigator||undefined;/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 * nativescript
 *  navigator.product -> 'NativeScript' or 'NS'
 *
 * @returns {boolean}
 */const eY=eH&&(!eB||["ReactNative","NativeScript","NS"].indexOf(eB.product)<0);/**
 * Determine if we're running in a standard browser webWorker environment
 *
 * Although the `isStandardBrowserEnv` method indicates that
 * `allows axios to run in a web worker`, the WebWorker will still be
 * filtered out due to its judgment standard
 * `typeof window !== 'undefined' && typeof document !== 'undefined'`.
 * This leads to a problem when axios post `FormData` in webWorker
 */const ez=(()=>{return typeof WorkerGlobalScope!=="undefined"&&// eslint-disable-next-line no-undef
self instanceof WorkerGlobalScope&&typeof self.importScripts==="function"})();const eq=eH&&window.location.href||"http://localhost";// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/platform/index.js
/* ESM default export */const eV={...n,...eU};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/toURLEncodedForm.js
function eW(e,t){return eA(e,new eV.classes.URLSearchParams,{visitor:function(e,t,r,n){if(eV.isNode&&ep.isBuffer(e)){this.append(t,e.toString("base64"));return false}return n.defaultVisitor.apply(this,arguments)},...t})};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/formDataToJSON.js
/**
 * It takes a string like `foo[x][y][z]` and returns an array like `['foo', 'x', 'y', 'z']
 *
 * @param {string} name - The name of the property to get.
 *
 * @returns An array of strings.
 */function e$(e){// foo[x][y][z]
// foo.x.y.z
// foo-x-y-z
// foo x y z
return ep.matchAll(/\w+|\[(\w*)]/g,e).map(e=>{return e[0]==="[]"?"":e[1]||e[0]})}/**
 * Convert an array to an object.
 *
 * @param {Array<any>} arr - The array to convert to an object.
 *
 * @returns An object with the same keys and values as the array.
 */function eG(e){const t={};const r=Object.keys(e);let n;const a=r.length;let i;for(n=0;n<a;n++){i=r[n];t[i]=e[i]}return t}/**
 * It takes a FormData object and returns a JavaScript object
 *
 * @param {string} formData The FormData object to convert to JSON.
 *
 * @returns {Object<string, any> | null} The converted object.
 */function eK(e){function t(e,r,n,a){let i=e[a++];if(i==="__proto__")return true;const o=Number.isFinite(+i);const s=a>=e.length;i=!i&&ep.isArray(n)?n.length:i;if(s){if(ep.hasOwnProp(n,i)){n[i]=[n[i],r]}else{n[i]=r}return!o}if(!n[i]||!ep.isObject(n[i])){n[i]=[]}const u=t(e,r,n[i],a);if(u&&ep.isArray(n[i])){n[i]=eG(n[i])}return!o}if(ep.isFormData(e)&&ep.isFunction(e.entries)){const r={};ep.forEachEntry(e,(e,n)=>{t(e$(e),n,r,0)});return r}return null}/* ESM default export */const eQ=eK;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/defaults/index.js
/**
 * It takes a string, tries to parse it, and if it fails, it returns the stringified version
 * of the input
 *
 * @param {any} rawValue - The value to be stringified.
 * @param {Function} parser - A function that parses a string into a JavaScript object.
 * @param {Function} encoder - A function that takes a value and returns a string.
 *
 * @returns {string} A stringified version of the rawValue.
 */function eX(e,t,r){if(ep.isString(e)){try{(t||JSON.parse)(e);return ep.trim(e)}catch(e){if(e.name!=="SyntaxError"){throw e}}}return(r||JSON.stringify)(e)}const eJ={transitional:eF,adapter:["xhr","http","fetch"],transformRequest:[function e(e,t){const r=t.getContentType()||"";const n=r.indexOf("application/json")>-1;const a=ep.isObject(e);if(a&&ep.isHTMLForm(e)){e=new FormData(e)}const i=ep.isFormData(e);if(i){return n?JSON.stringify(eQ(e)):e}if(ep.isArrayBuffer(e)||ep.isBuffer(e)||ep.isStream(e)||ep.isFile(e)||ep.isBlob(e)||ep.isReadableStream(e)){return e}if(ep.isArrayBufferView(e)){return e.buffer}if(ep.isURLSearchParams(e)){t.setContentType("application/x-www-form-urlencoded;charset=utf-8",false);return e.toString()}let o;if(a){if(r.indexOf("application/x-www-form-urlencoded")>-1){return eW(e,this.formSerializer).toString()}if((o=ep.isFileList(e))||r.indexOf("multipart/form-data")>-1){const t=this.env&&this.env.FormData;return eA(o?{"files[]":e}:e,t&&new t,this.formSerializer)}}if(a||n){t.setContentType("application/json",false);return eX(e)}return e}],transformResponse:[function e(e){const t=this.transitional||eJ.transitional;const r=t&&t.forcedJSONParsing;const n=this.responseType==="json";if(ep.isResponse(e)||ep.isReadableStream(e)){return e}if(e&&ep.isString(e)&&(r&&!this.responseType||n)){const r=t&&t.silentJSONParsing;const a=!r&&n;try{return JSON.parse(e)}catch(e){if(a){if(e.name==="SyntaxError"){throw eb.from(e,eb.ERR_BAD_RESPONSE,this,null,this.response)}throw e}}}return e}],/**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,env:{FormData:eV.classes.FormData,Blob:eV.classes.Blob},validateStatus:function e(e){return e>=200&&e<300},headers:{common:{"Accept":"application/json, text/plain, */*","Content-Type":undefined}}};ep.forEach(["delete","get","head","post","put","patch"],e=>{eJ.headers[e]={}});/* ESM default export */const eZ=eJ;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/parseHeaders.js
// RawAxiosHeaders whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
const e0=ep.toObjectSet(["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"]);/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} rawHeaders Headers needing to be parsed
 *
 * @returns {Object} Headers parsed into an object
 *//* ESM default export */const e1=e=>{const t={};let r;let n;let a;e&&e.split("\n").forEach(function e(e){a=e.indexOf(":");r=e.substring(0,a).trim().toLowerCase();n=e.substring(a+1).trim();if(!r||t[r]&&e0[r]){return}if(r==="set-cookie"){if(t[r]){t[r].push(n)}else{t[r]=[n]}}else{t[r]=t[r]?t[r]+", "+n:n}});return t};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/AxiosHeaders.js
const e2=Symbol("internals");function e4(e){return e&&String(e).trim().toLowerCase()}function e6(e){if(e===false||e==null){return e}return ep.isArray(e)?e.map(e6):String(e)}function e5(e){const t=Object.create(null);const r=/([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;let n;while(n=r.exec(e)){t[n[1]]=n[2]}return t}const e3=e=>/^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());function e7(e,t,r,n,a){if(ep.isFunction(n)){return n.call(this,t,r)}if(a){t=r}if(!ep.isString(t))return;if(ep.isString(n)){return t.indexOf(n)!==-1}if(ep.isRegExp(n)){return n.test(t)}}function e8(e){return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g,(e,t,r)=>{return t.toUpperCase()+r})}function e9(e,t){const r=ep.toCamelCase(" "+t);["get","set","has"].forEach(n=>{Object.defineProperty(e,n+r,{value:function(e,r,a){return this[n].call(this,t,e,r,a)},configurable:true})})}class te{constructor(e){e&&this.set(e)}set(e,t,r){const n=this;function a(e,t,r){const a=e4(t);if(!a){throw new Error("header name must be a non-empty string")}const i=ep.findKey(n,a);if(!i||n[i]===undefined||r===true||r===undefined&&n[i]!==false){n[i||t]=e6(e)}}const i=(e,t)=>ep.forEach(e,(e,r)=>a(e,r,t));if(ep.isPlainObject(e)||e instanceof this.constructor){i(e,t)}else if(ep.isString(e)&&(e=e.trim())&&!e3(e)){i(e1(e),t)}else if(ep.isObject(e)&&ep.isIterable(e)){let r={},n,a;for(const t of e){if(!ep.isArray(t)){throw TypeError("Object iterator must return a key-value pair")}r[a=t[0]]=(n=r[a])?ep.isArray(n)?[...n,t[1]]:[n,t[1]]:t[1]}i(r,t)}else{e!=null&&a(t,e,r)}return this}get(e,t){e=e4(e);if(e){const r=ep.findKey(this,e);if(r){const e=this[r];if(!t){return e}if(t===true){return e5(e)}if(ep.isFunction(t)){return t.call(this,e,r)}if(ep.isRegExp(t)){return t.exec(e)}throw new TypeError("parser must be boolean|regexp|function")}}}has(e,t){e=e4(e);if(e){const r=ep.findKey(this,e);return!!(r&&this[r]!==undefined&&(!t||e7(this,this[r],r,t)))}return false}delete(e,t){const r=this;let n=false;function a(e){e=e4(e);if(e){const a=ep.findKey(r,e);if(a&&(!t||e7(r,r[a],a,t))){delete r[a];n=true}}}if(ep.isArray(e)){e.forEach(a)}else{a(e)}return n}clear(e){const t=Object.keys(this);let r=t.length;let n=false;while(r--){const a=t[r];if(!e||e7(this,this[a],a,e,true)){delete this[a];n=true}}return n}normalize(e){const t=this;const r={};ep.forEach(this,(n,a)=>{const i=ep.findKey(r,a);if(i){t[i]=e6(n);delete t[a];return}const o=e?e8(a):String(a).trim();if(o!==a){delete t[a]}t[o]=e6(n);r[o]=true});return this}concat(...e){return this.constructor.concat(this,...e)}toJSON(e){const t=Object.create(null);ep.forEach(this,(r,n)=>{r!=null&&r!==false&&(t[n]=e&&ep.isArray(r)?r.join(", "):r)});return t}[Symbol.iterator](){return Object.entries(this.toJSON())[Symbol.iterator]()}toString(){return Object.entries(this.toJSON()).map(([e,t])=>e+": "+t).join("\n")}getSetCookie(){return this.get("set-cookie")||[]}get[Symbol.toStringTag](){return"AxiosHeaders"}static from(e){return e instanceof this?e:new this(e)}static concat(e,...t){const r=new this(e);t.forEach(e=>r.set(e));return r}static accessor(e){const t=this[e2]=this[e2]={accessors:{}};const r=t.accessors;const n=this.prototype;function a(e){const t=e4(e);if(!r[t]){e9(n,e);r[t]=true}}ep.isArray(e)?e.forEach(a):a(e);return this}}te.accessor(["Content-Type","Content-Length","Accept","Accept-Encoding","User-Agent","Authorization"]);// reserved names hotfix
ep.reduceDescriptors(te.prototype,({value:e},t)=>{let r=t[0].toUpperCase()+t.slice(1);// map `set` => `Set`
return{get:()=>e,set(e){this[r]=e}}});ep.freezeMethods(te);/* ESM default export */const tt=te;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/transformData.js
/**
 * Transform the data for a request or a response
 *
 * @param {Array|Function} fns A single function or Array of functions
 * @param {?Object} response The response object
 *
 * @returns {*} The resulting transformed data
 */function tr(e,t){const r=this||eZ;const n=t||r;const a=tt.from(n.headers);let i=n.data;ep.forEach(e,function e(e){i=e.call(r,i,a.normalize(),t?t.status:undefined)});a.normalize();return i};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/cancel/isCancel.js
function tn(e){return!!(e&&e.__CANCEL__)};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/cancel/CanceledError.js
/**
 * A `CanceledError` is an object that is thrown when an operation is canceled.
 *
 * @param {string=} message The message.
 * @param {Object=} config The config.
 * @param {Object=} request The request.
 *
 * @returns {CanceledError} The created error.
 */function ta(e,t,r){// eslint-disable-next-line no-eq-null,eqeqeq
eb.call(this,e==null?"canceled":e,eb.ERR_CANCELED,t,r);this.name="CanceledError"}ep.inherits(ta,eb,{__CANCEL__:true});/* ESM default export */const ti=ta;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/settle.js
/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 *
 * @returns {object} The response.
 */function to(e,t,r){const n=r.config.validateStatus;if(!r.status||!n||n(r.status)){e(r)}else{t(new eb("Request failed with status code "+r.status,[eb.ERR_BAD_REQUEST,eb.ERR_BAD_RESPONSE][Math.floor(r.status/100)-4],r.config,r.request,r))}};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/parseProtocol.js
function ts(e){const t=/^([-+\w]{1,25})(:?\/\/|:)/.exec(e);return t&&t[1]||""};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/speedometer.js
/**
 * Calculate data maxRate
 * @param {Number} [samplesCount= 10]
 * @param {Number} [min= 1000]
 * @returns {Function}
 */function tu(e,t){e=e||10;const r=new Array(e);const n=new Array(e);let a=0;let i=0;let o;t=t!==undefined?t:1e3;return function s(s){const u=Date.now();const l=n[i];if(!o){o=u}r[a]=s;n[a]=u;let c=i;let f=0;while(c!==a){f+=r[c++];c=c%e}a=(a+1)%e;if(a===i){i=(i+1)%e}if(u-o<t){return}const d=l&&u-l;return d?Math.round(f*1e3/d):undefined}}/* ESM default export */const tl=tu;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/throttle.js
/**
 * Throttle decorator
 * @param {Function} fn
 * @param {Number} freq
 * @return {Function}
 */function tc(e,t){let r=0;let n=1e3/t;let a;let i;const o=(t,n=Date.now())=>{r=n;a=null;if(i){clearTimeout(i);i=null}e(...t)};const s=(...e)=>{const t=Date.now();const s=t-r;if(s>=n){o(e,t)}else{a=e;if(!i){i=setTimeout(()=>{i=null;o(a)},n-s)}}};const u=()=>a&&o(a);return[s,u]}/* ESM default export */const tf=tc;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/progressEventReducer.js
const td=(e,t,r=3)=>{let n=0;const a=tl(50,250);return tf(r=>{const i=r.loaded;const o=r.lengthComputable?r.total:undefined;const s=i-n;const u=a(s);const l=i<=o;n=i;const c={loaded:i,total:o,progress:o?i/o:undefined,bytes:s,rate:u?u:undefined,estimated:u&&o&&l?(o-i)/u:undefined,event:r,lengthComputable:o!=null,[t?"download":"upload"]:true};e(c)},r)};const th=(e,t)=>{const r=e!=null;return[n=>t[0]({lengthComputable:r,total:e,loaded:n}),t[1]]};const tp=e=>(...t)=>ep.asap(()=>e(...t));// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/isURLSameOrigin.js
/* ESM default export */const tv=eV.hasStandardBrowserEnv?((e,t)=>r=>{r=new URL(r,eV.origin);return e.protocol===r.protocol&&e.host===r.host&&(t||e.port===r.port)})(new URL(eV.origin),eV.navigator&&/(msie|trident)/i.test(eV.navigator.userAgent)):()=>true;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/cookies.js
/* ESM default export */const tm=eV.hasStandardBrowserEnv?// Standard browser envs support document.cookie
{write(e,t,r,n,a,i){const o=[e+"="+encodeURIComponent(t)];ep.isNumber(r)&&o.push("expires="+new Date(r).toGMTString());ep.isString(n)&&o.push("path="+n);ep.isString(a)&&o.push("domain="+a);i===true&&o.push("secure");document.cookie=o.join("; ")},read(e){const t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove(e){this.write(e,"",Date.now()-864e5)}}:// Non-standard browser env (web workers, react-native) lack needed support.
{write(){},read(){return null},remove(){}};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/isAbsoluteURL.js
/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 *
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */function tg(e){// A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
// RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
// by any combination of letters, digits, plus, period, or hyphen.
return/^([a-z][a-z\d+\-.]*:)?\/\//i.test(e)};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/combineURLs.js
/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 *
 * @returns {string} The combined URL
 */function tb(e,t){return t?e.replace(/\/?\/$/,"")+"/"+t.replace(/^\/+/,""):e};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/buildFullPath.js
/**
 * Creates a new URL by combining the baseURL with the requestedURL,
 * only when the requestedURL is not already an absolute URL.
 * If the requestURL is absolute, this function returns the requestedURL untouched.
 *
 * @param {string} baseURL The base URL
 * @param {string} requestedURL Absolute or relative URL to combine
 *
 * @returns {string} The combined full path
 */function ty(e,t,r){let n=!tg(t);if(e&&(n||r==false)){return tb(e,t)}return t};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/mergeConfig.js
const tw=e=>e instanceof tt?{...e}:e;/**
 * Config-specific merge-function which creates a new config-object
 * by merging two configuration objects together.
 *
 * @param {Object} config1
 * @param {Object} config2
 *
 * @returns {Object} New object resulting from merging config2 to config1
 */function t_(e,t){// eslint-disable-next-line no-param-reassign
t=t||{};const r={};function n(e,t,r,n){if(ep.isPlainObject(e)&&ep.isPlainObject(t)){return ep.merge.call({caseless:n},e,t)}else if(ep.isPlainObject(t)){return ep.merge({},t)}else if(ep.isArray(t)){return t.slice()}return t}// eslint-disable-next-line consistent-return
function a(e,t,r,a){if(!ep.isUndefined(t)){return n(e,t,r,a)}else if(!ep.isUndefined(e)){return n(undefined,e,r,a)}}// eslint-disable-next-line consistent-return
function i(e,t){if(!ep.isUndefined(t)){return n(undefined,t)}}// eslint-disable-next-line consistent-return
function o(e,t){if(!ep.isUndefined(t)){return n(undefined,t)}else if(!ep.isUndefined(e)){return n(undefined,e)}}// eslint-disable-next-line consistent-return
function s(r,a,i){if(i in t){return n(r,a)}else if(i in e){return n(undefined,r)}}const u={url:i,method:i,data:i,baseURL:o,transformRequest:o,transformResponse:o,paramsSerializer:o,timeout:o,timeoutMessage:o,withCredentials:o,withXSRFToken:o,adapter:o,responseType:o,xsrfCookieName:o,xsrfHeaderName:o,onUploadProgress:o,onDownloadProgress:o,decompress:o,maxContentLength:o,maxBodyLength:o,beforeRedirect:o,transport:o,httpAgent:o,httpsAgent:o,cancelToken:o,socketPath:o,responseEncoding:o,validateStatus:s,headers:(e,t,r)=>a(tw(e),tw(t),r,true)};ep.forEach(Object.keys({...e,...t}),function n(n){const i=u[n]||a;const o=i(e[n],t[n],n);ep.isUndefined(o)&&i!==s||(r[n]=o)});return r};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/resolveConfig.js
/* ESM default export */const tx=e=>{const t=t_({},e);let{data:r,withXSRFToken:n,xsrfHeaderName:a,xsrfCookieName:i,headers:o,auth:s}=t;t.headers=o=tt.from(o);t.url=eI(ty(t.baseURL,t.url,t.allowAbsoluteUrls),e.params,e.paramsSerializer);// HTTP basic authentication
if(s){o.set("Authorization","Basic "+btoa((s.username||"")+":"+(s.password?unescape(encodeURIComponent(s.password)):"")))}let u;if(ep.isFormData(r)){if(eV.hasStandardBrowserEnv||eV.hasStandardBrowserWebWorkerEnv){o.setContentType(undefined);// Let the browser set it
}else if((u=o.getContentType())!==false){// fix semicolon duplication issue for ReactNative FormData implementation
const[e,...t]=u?u.split(";").map(e=>e.trim()).filter(Boolean):[];o.setContentType([e||"multipart/form-data",...t].join("; "))}}// Add xsrf header
// This is only done if running in a standard browser environment.
// Specifically not if we're in a web worker, or react-native.
if(eV.hasStandardBrowserEnv){n&&ep.isFunction(n)&&(n=n(t));if(n||n!==false&&tv(t.url)){// Add xsrf header
const e=a&&i&&tm.read(i);if(e){o.set(a,e)}}}return t};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/adapters/xhr.js
const tE=typeof XMLHttpRequest!=="undefined";/* ESM default export */const tO=tE&&function(e){return new Promise(function t(t,r){const n=tx(e);let a=n.data;const i=tt.from(n.headers).normalize();let{responseType:o,onUploadProgress:s,onDownloadProgress:u}=n;let l;let c,f;let d,h;function p(){d&&d();// flush events
h&&h();// flush events
n.cancelToken&&n.cancelToken.unsubscribe(l);n.signal&&n.signal.removeEventListener("abort",l)}let v=new XMLHttpRequest;v.open(n.method.toUpperCase(),n.url,true);// Set the request timeout in MS
v.timeout=n.timeout;function m(){if(!v){return}// Prepare the response
const n=tt.from("getAllResponseHeaders"in v&&v.getAllResponseHeaders());const a=!o||o==="text"||o==="json"?v.responseText:v.response;const i={data:a,status:v.status,statusText:v.statusText,headers:n,config:e,request:v};to(function e(e){t(e);p()},function e(e){r(e);p()},i);// Clean up request
v=null}if("onloadend"in v){// Use onloadend if available
v.onloadend=m}else{// Listen for ready state to emulate onloadend
v.onreadystatechange=function e(){if(!v||v.readyState!==4){return}// The request errored out and we didn't get a response, this will be
// handled by onerror instead
// With one exception: request that using file: protocol, most browsers
// will return status as 0 even though it's a successful request
if(v.status===0&&!(v.responseURL&&v.responseURL.indexOf("file:")===0)){return}// readystate handler is calling before onerror or ontimeout handlers,
// so we should call onloadend on the next 'tick'
setTimeout(m)}}// Handle browser request cancellation (as opposed to a manual cancellation)
v.onabort=function t(){if(!v){return}r(new eb("Request aborted",eb.ECONNABORTED,e,v));// Clean up request
v=null};// Handle low level network errors
v.onerror=function t(){// Real errors are hidden from us by the browser
// onerror should only fire if it's a network error
r(new eb("Network Error",eb.ERR_NETWORK,e,v));// Clean up request
v=null};// Handle timeout
v.ontimeout=function t(){let t=n.timeout?"timeout of "+n.timeout+"ms exceeded":"timeout exceeded";const a=n.transitional||eF;if(n.timeoutErrorMessage){t=n.timeoutErrorMessage}r(new eb(t,a.clarifyTimeoutError?eb.ETIMEDOUT:eb.ECONNABORTED,e,v));// Clean up request
v=null};// Remove Content-Type if data is undefined
a===undefined&&i.setContentType(null);// Add headers to the request
if("setRequestHeader"in v){ep.forEach(i.toJSON(),function e(e,t){v.setRequestHeader(t,e)})}// Add withCredentials to request if needed
if(!ep.isUndefined(n.withCredentials)){v.withCredentials=!!n.withCredentials}// Add responseType to request if needed
if(o&&o!=="json"){v.responseType=n.responseType}// Handle progress if needed
if(u){[f,h]=td(u,true);v.addEventListener("progress",f)}// Not all browsers support upload events
if(s&&v.upload){[c,d]=td(s);v.upload.addEventListener("progress",c);v.upload.addEventListener("loadend",d)}if(n.cancelToken||n.signal){// Handle cancellation
// eslint-disable-next-line func-names
l=t=>{if(!v){return}r(!t||t.type?new ti(null,e,v):t);v.abort();v=null};n.cancelToken&&n.cancelToken.subscribe(l);if(n.signal){n.signal.aborted?l():n.signal.addEventListener("abort",l)}}const g=ts(n.url);if(g&&eV.protocols.indexOf(g)===-1){r(new eb("Unsupported protocol "+g+":",eb.ERR_BAD_REQUEST,e));return}// Send the request
v.send(a||null)})};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/composeSignals.js
const tS=(e,t)=>{const{length:r}=e=e?e.filter(Boolean):[];if(t||r){let r=new AbortController;let n;const a=function(e){if(!n){n=true;o();const t=e instanceof Error?e:this.reason;r.abort(t instanceof eb?t:new ti(t instanceof Error?t.message:t))}};let i=t&&setTimeout(()=>{i=null;a(new eb(`timeout ${t} of ms exceeded`,eb.ETIMEDOUT))},t);const o=()=>{if(e){i&&clearTimeout(i);i=null;e.forEach(e=>{e.unsubscribe?e.unsubscribe(a):e.removeEventListener("abort",a)});e=null}};e.forEach(e=>e.addEventListener("abort",a));const{signal:s}=r;s.unsubscribe=()=>ep.asap(o);return s}};/* ESM default export */const tA=tS;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/trackStream.js
const tT=function*(e,t){let r=e.byteLength;if(!t||r<t){yield e;return}let n=0;let a;while(n<r){a=n+t;yield e.slice(n,a);n=a}};const tk=async function*(e,t){for await(const r of tR(e)){yield*tT(r,t)}};const tR=async function*(e){if(e[Symbol.asyncIterator]){yield*e;return}const t=e.getReader();try{for(;;){const{done:e,value:r}=await t.read();if(e){break}yield r}}finally{await t.cancel()}};const tC=(e,t,r,n)=>{const a=tk(e,t);let i=0;let o;let s=e=>{if(!o){o=true;n&&n(e)}};return new ReadableStream({async pull(e){try{const{done:t,value:n}=await a.next();if(t){s();e.close();return}let o=n.byteLength;if(r){let e=i+=o;r(e)}e.enqueue(new Uint8Array(n))}catch(e){s(e);throw e}},cancel(e){s(e);return a.return()}},{highWaterMark:2})};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/adapters/fetch.js
const tP=typeof fetch==="function"&&typeof Request==="function"&&typeof Response==="function";const tI=tP&&typeof ReadableStream==="function";// used only inside the fetch adapter
const tD=tP&&(typeof TextEncoder==="function"?(e=>t=>e.encode(t))(new TextEncoder):async e=>new Uint8Array(await new Response(e).arrayBuffer()));const tM=(e,...t)=>{try{return!!e(...t)}catch(e){return false}};const tF=tI&&tM(()=>{let e=false;const t=new Request(eV.origin,{body:new ReadableStream,method:"POST",get duplex(){e=true;return"half"}}).headers.has("Content-Type");return e&&!t});const tL=64*1024;const tN=tI&&tM(()=>ep.isReadableStream(new Response("").body));const tj={stream:tN&&(e=>e.body)};tP&&(e=>{["text","arrayBuffer","blob","formData","stream"].forEach(t=>{!tj[t]&&(tj[t]=ep.isFunction(e[t])?e=>e[t]():(e,r)=>{throw new eb(`Response type '${t}' is not supported`,eb.ERR_NOT_SUPPORT,r)})})})(new Response);const tU=async e=>{if(e==null){return 0}if(ep.isBlob(e)){return e.size}if(ep.isSpecCompliantForm(e)){const t=new Request(eV.origin,{method:"POST",body:e});return(await t.arrayBuffer()).byteLength}if(ep.isArrayBufferView(e)||ep.isArrayBuffer(e)){return e.byteLength}if(ep.isURLSearchParams(e)){e=e+""}if(ep.isString(e)){return(await tD(e)).byteLength}};const tH=async(e,t)=>{const r=ep.toFiniteNumber(e.getContentLength());return r==null?tU(t):r};/* ESM default export */const tB=tP&&(async e=>{let{url:t,method:r,data:n,signal:a,cancelToken:i,timeout:o,onDownloadProgress:s,onUploadProgress:u,responseType:l,headers:c,withCredentials:f="same-origin",fetchOptions:d}=tx(e);l=l?(l+"").toLowerCase():"text";let h=tA([a,i&&i.toAbortSignal()],o);let p;const v=h&&h.unsubscribe&&(()=>{h.unsubscribe()});let m;try{if(u&&tF&&r!=="get"&&r!=="head"&&(m=await tH(c,n))!==0){let e=new Request(t,{method:"POST",body:n,duplex:"half"});let r;if(ep.isFormData(n)&&(r=e.headers.get("content-type"))){c.setContentType(r)}if(e.body){const[t,r]=th(m,td(tp(u)));n=tC(e.body,tL,t,r)}}if(!ep.isString(f)){f=f?"include":"omit"}// Cloudflare Workers throws when credentials are defined
// see https://github.com/cloudflare/workerd/issues/902
const a="credentials"in Request.prototype;p=new Request(t,{...d,signal:h,method:r.toUpperCase(),headers:c.normalize().toJSON(),body:n,duplex:"half",credentials:a?f:undefined});let i=await fetch(p,d);const o=tN&&(l==="stream"||l==="response");if(tN&&(s||o&&v)){const e={};["status","statusText","headers"].forEach(t=>{e[t]=i[t]});const t=ep.toFiniteNumber(i.headers.get("content-length"));const[r,n]=s&&th(t,td(tp(s),true))||[];i=new Response(tC(i.body,tL,r,()=>{n&&n();v&&v()}),e)}l=l||"text";let g=await tj[ep.findKey(tj,l)||"text"](i,e);!o&&v&&v();return await new Promise((t,r)=>{to(t,r,{data:g,headers:tt.from(i.headers),status:i.status,statusText:i.statusText,config:e,request:p})})}catch(t){v&&v();if(t&&t.name==="TypeError"&&/Load failed|fetch/i.test(t.message)){throw Object.assign(new eb("Network Error",eb.ERR_NETWORK,e,p),{cause:t.cause||t})}throw eb.from(t,t&&t.code,e,p)}});// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/adapters/adapters.js
const tY={http:ey,xhr:tO,fetch:tB};ep.forEach(tY,(e,t)=>{if(e){try{Object.defineProperty(e,"name",{value:t})}catch(e){// eslint-disable-next-line no-empty
}Object.defineProperty(e,"adapterName",{value:t})}});const tz=e=>`- ${e}`;const tq=e=>ep.isFunction(e)||e===null||e===false;/* ESM default export */const tV={getAdapter:e=>{e=ep.isArray(e)?e:[e];const{length:t}=e;let r;let n;const a={};for(let i=0;i<t;i++){r=e[i];let t;n=r;if(!tq(r)){n=tY[(t=String(r)).toLowerCase()];if(n===undefined){throw new eb(`Unknown adapter '${t}'`)}}if(n){break}a[t||"#"+i]=n}if(!n){const e=Object.entries(a).map(([e,t])=>`adapter ${e} `+(t===false?"is not supported by the environment":"is not available in the build"));let r=t?e.length>1?"since :\n"+e.map(tz).join("\n"):" "+tz(e[0]):"as no adapter specified";throw new eb(`There is no suitable adapter to dispatch the request `+r,"ERR_NOT_SUPPORT")}return n},adapters:tY};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/dispatchRequest.js
/**
 * Throws a `CanceledError` if cancellation has been requested.
 *
 * @param {Object} config The config that is to be used for the request
 *
 * @returns {void}
 */function tW(e){if(e.cancelToken){e.cancelToken.throwIfRequested()}if(e.signal&&e.signal.aborted){throw new ti(null,e)}}/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 *
 * @returns {Promise} The Promise to be fulfilled
 */function t$(e){tW(e);e.headers=tt.from(e.headers);// Transform request data
e.data=tr.call(e,e.transformRequest);if(["post","put","patch"].indexOf(e.method)!==-1){e.headers.setContentType("application/x-www-form-urlencoded",false)}const t=tV.getAdapter(e.adapter||eZ.adapter);return t(e).then(function t(t){tW(e);// Transform response data
t.data=tr.call(e,e.transformResponse,t);t.headers=tt.from(t.headers);return t},function t(t){if(!tn(t)){tW(e);// Transform response data
if(t&&t.response){t.response.data=tr.call(e,e.transformResponse,t.response);t.response.headers=tt.from(t.response.headers)}}return Promise.reject(t)})};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/env/data.js
const tG="1.11.0";// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/validator.js
const tK={};// eslint-disable-next-line func-names
["object","boolean","number","function","string","symbol"].forEach((e,t)=>{tK[e]=function r(r){return typeof r===e||"a"+(t<1?"n ":" ")+e}});const tQ={};/**
 * Transitional option validator
 *
 * @param {function|boolean?} validator - set to false if the transitional option has been removed
 * @param {string?} version - deprecated version / removed since version
 * @param {string?} message - some message with additional info
 *
 * @returns {function}
 */tK.transitional=function e(e,t,r){function n(e,t){return"[Axios v"+tG+"] Transitional option '"+e+"'"+t+(r?". "+r:"")}// eslint-disable-next-line func-names
return(r,a,i)=>{if(e===false){throw new eb(n(a," has been removed"+(t?" in "+t:"")),eb.ERR_DEPRECATED)}if(t&&!tQ[a]){tQ[a]=true;// eslint-disable-next-line no-console
console.warn(n(a," has been deprecated since v"+t+" and will be removed in the near future"))}return e?e(r,a,i):true}};tK.spelling=function e(e){return(t,r)=>{// eslint-disable-next-line no-console
console.warn(`${r} is likely a misspelling of ${e}`);return true}};/**
 * Assert object's properties type
 *
 * @param {object} options
 * @param {object} schema
 * @param {boolean?} allowUnknown
 *
 * @returns {object}
 */function tX(e,t,r){if(typeof e!=="object"){throw new eb("options must be an object",eb.ERR_BAD_OPTION_VALUE)}const n=Object.keys(e);let a=n.length;while(a-- >0){const i=n[a];const o=t[i];if(o){const t=e[i];const r=t===undefined||o(t,i,e);if(r!==true){throw new eb("option "+i+" must be "+r,eb.ERR_BAD_OPTION_VALUE)}continue}if(r!==true){throw new eb("Unknown option "+i,eb.ERR_BAD_OPTION)}}}/* ESM default export */const tJ={assertOptions:tX,validators:tK};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/core/Axios.js
const tZ=tJ.validators;/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 *
 * @return {Axios} A new instance of Axios
 */class t0{constructor(e){this.defaults=e||{};this.interceptors={request:new eM,response:new eM}}/**
   * Dispatch a request
   *
   * @param {String|Object} configOrUrl The config specific for this request (merged with this.defaults)
   * @param {?Object} config
   *
   * @returns {Promise} The Promise to be fulfilled
   */async request(e,t){try{return await this._request(e,t)}catch(e){if(e instanceof Error){let t={};Error.captureStackTrace?Error.captureStackTrace(t):t=new Error;// slice off the Error: ... line
const r=t.stack?t.stack.replace(/^.+\n/,""):"";try{if(!e.stack){e.stack=r;// match without the 2 top stack lines
}else if(r&&!String(e.stack).endsWith(r.replace(/^.+\n.+\n/,""))){e.stack+="\n"+r}}catch(e){// ignore the case where "stack" is an un-writable property
}}throw e}}_request(e,t){/*eslint no-param-reassign:0*/// Allow for axios('example/url'[, config]) a la fetch API
if(typeof e==="string"){t=t||{};t.url=e}else{t=e||{}}t=t_(this.defaults,t);const{transitional:r,paramsSerializer:n,headers:a}=t;if(r!==undefined){tJ.assertOptions(r,{silentJSONParsing:tZ.transitional(tZ.boolean),forcedJSONParsing:tZ.transitional(tZ.boolean),clarifyTimeoutError:tZ.transitional(tZ.boolean)},false)}if(n!=null){if(ep.isFunction(n)){t.paramsSerializer={serialize:n}}else{tJ.assertOptions(n,{encode:tZ.function,serialize:tZ.function},true)}}// Set config.allowAbsoluteUrls
if(t.allowAbsoluteUrls!==undefined){// do nothing
}else if(this.defaults.allowAbsoluteUrls!==undefined){t.allowAbsoluteUrls=this.defaults.allowAbsoluteUrls}else{t.allowAbsoluteUrls=true}tJ.assertOptions(t,{baseUrl:tZ.spelling("baseURL"),withXsrfToken:tZ.spelling("withXSRFToken")},true);// Set config.method
t.method=(t.method||this.defaults.method||"get").toLowerCase();// Flatten headers
let i=a&&ep.merge(a.common,a[t.method]);a&&ep.forEach(["delete","get","head","post","put","patch","common"],e=>{delete a[e]});t.headers=tt.concat(i,a);// filter out skipped interceptors
const o=[];let s=true;this.interceptors.request.forEach(function e(e){if(typeof e.runWhen==="function"&&e.runWhen(t)===false){return}s=s&&e.synchronous;o.unshift(e.fulfilled,e.rejected)});const u=[];this.interceptors.response.forEach(function e(e){u.push(e.fulfilled,e.rejected)});let l;let c=0;let f;if(!s){const e=[t$.bind(this),undefined];e.unshift(...o);e.push(...u);f=e.length;l=Promise.resolve(t);while(c<f){l=l.then(e[c++],e[c++])}return l}f=o.length;let d=t;c=0;while(c<f){const e=o[c++];const t=o[c++];try{d=e(d)}catch(e){t.call(this,e);break}}try{l=t$.call(this,d)}catch(e){return Promise.reject(e)}c=0;f=u.length;while(c<f){l=l.then(u[c++],u[c++])}return l}getUri(e){e=t_(this.defaults,e);const t=ty(e.baseURL,e.url,e.allowAbsoluteUrls);return eI(t,e.params,e.paramsSerializer)}}// Provide aliases for supported request methods
ep.forEach(["delete","get","head","options"],function e(e){/*eslint func-names:0*/t0.prototype[e]=function(t,r){return this.request(t_(r||{},{method:e,url:t,data:(r||{}).data}))}});ep.forEach(["post","put","patch"],function e(e){/*eslint func-names:0*/function t(t){return function r(r,n,a){return this.request(t_(a||{},{method:e,headers:t?{"Content-Type":"multipart/form-data"}:{},url:r,data:n}))}}t0.prototype[e]=t();t0.prototype[e+"Form"]=t(true)});/* ESM default export */const t1=t0;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/cancel/CancelToken.js
/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @param {Function} executor The executor function.
 *
 * @returns {CancelToken}
 */class t2{constructor(e){if(typeof e!=="function"){throw new TypeError("executor must be a function.")}let t;this.promise=new Promise(function e(e){t=e});const r=this;// eslint-disable-next-line func-names
this.promise.then(e=>{if(!r._listeners)return;let t=r._listeners.length;while(t-- >0){r._listeners[t](e)}r._listeners=null});// eslint-disable-next-line func-names
this.promise.then=e=>{let t;// eslint-disable-next-line func-names
const n=new Promise(e=>{r.subscribe(e);t=e}).then(e);n.cancel=function e(){r.unsubscribe(t)};return n};e(function e(e,n,a){if(r.reason){// Cancellation has already been requested
return}r.reason=new ti(e,n,a);t(r.reason)})}/**
   * Throws a `CanceledError` if cancellation has been requested.
   */throwIfRequested(){if(this.reason){throw this.reason}}/**
   * Subscribe to the cancel signal
   */subscribe(e){if(this.reason){e(this.reason);return}if(this._listeners){this._listeners.push(e)}else{this._listeners=[e]}}/**
   * Unsubscribe from the cancel signal
   */unsubscribe(e){if(!this._listeners){return}const t=this._listeners.indexOf(e);if(t!==-1){this._listeners.splice(t,1)}}toAbortSignal(){const e=new AbortController;const t=t=>{e.abort(t)};this.subscribe(t);e.signal.unsubscribe=()=>this.unsubscribe(t);return e.signal}/**
   * Returns an object that contains a new `CancelToken` and a function that, when called,
   * cancels the `CancelToken`.
   */static source(){let e;const t=new t2(function t(t){e=t});return{token:t,cancel:e}}}/* ESM default export */const t4=t2;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/spread.js
/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 *
 * @returns {Function}
 */function t6(e){return function t(t){return e.apply(null,t)}};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/isAxiosError.js
/**
 * Determines whether the payload is an error thrown by Axios
 *
 * @param {*} payload The value to test
 *
 * @returns {boolean} True if the payload is an error thrown by Axios, otherwise false
 */function t5(e){return ep.isObject(e)&&e.isAxiosError===true};// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/helpers/HttpStatusCode.js
const t3={Continue:100,SwitchingProtocols:101,Processing:102,EarlyHints:103,Ok:200,Created:201,Accepted:202,NonAuthoritativeInformation:203,NoContent:204,ResetContent:205,PartialContent:206,MultiStatus:207,AlreadyReported:208,ImUsed:226,MultipleChoices:300,MovedPermanently:301,Found:302,SeeOther:303,NotModified:304,UseProxy:305,Unused:306,TemporaryRedirect:307,PermanentRedirect:308,BadRequest:400,Unauthorized:401,PaymentRequired:402,Forbidden:403,NotFound:404,MethodNotAllowed:405,NotAcceptable:406,ProxyAuthenticationRequired:407,RequestTimeout:408,Conflict:409,Gone:410,LengthRequired:411,PreconditionFailed:412,PayloadTooLarge:413,UriTooLong:414,UnsupportedMediaType:415,RangeNotSatisfiable:416,ExpectationFailed:417,ImATeapot:418,MisdirectedRequest:421,UnprocessableEntity:422,Locked:423,FailedDependency:424,TooEarly:425,UpgradeRequired:426,PreconditionRequired:428,TooManyRequests:429,RequestHeaderFieldsTooLarge:431,UnavailableForLegalReasons:451,InternalServerError:500,NotImplemented:501,BadGateway:502,ServiceUnavailable:503,GatewayTimeout:504,HttpVersionNotSupported:505,VariantAlsoNegotiates:506,InsufficientStorage:507,LoopDetected:508,NotExtended:510,NetworkAuthenticationRequired:511};Object.entries(t3).forEach(([e,t])=>{t3[t]=e});/* ESM default export */const t7=t3;// CONCATENATED MODULE: ../tutor/node_modules/axios/lib/axios.js
/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 *
 * @returns {Axios} A new instance of Axios
 */function t8(e){const t=new t1(e);const r=o(t1.prototype.request,t);// Copy axios.prototype to instance
ep.extend(r,t1.prototype,t,{allOwnKeys:true});// Copy context to instance
ep.extend(r,t,null,{allOwnKeys:true});// Factory for creating new instances
r.create=function t(t){return t8(t_(e,t))};return r}// Create the default instance to be exported
const t9=t8(eZ);// Expose Axios class to allow class inheritance
t9.Axios=t1;// Expose Cancel & CancelToken
t9.CanceledError=ti;t9.CancelToken=t4;t9.isCancel=tn;t9.VERSION=tG;t9.toFormData=eA;// Expose AxiosError class
t9.AxiosError=eb;// alias for CanceledError for backward compatibility
t9.Cancel=t9.CanceledError;// Expose all/spread
t9.all=function e(e){return Promise.all(e)};t9.spread=t6;// Expose isAxiosError
t9.isAxiosError=t5;// Expose mergeConfig
t9.mergeConfig=t_;t9.AxiosHeaders=tt;t9.formToJSON=e=>eQ(ep.isHTMLForm(e)?new FormData(e):e);t9.getAdapter=tV.getAdapter;t9.HttpStatusCode=t7;t9.default=t9;// this module should only have a default export
/* ESM default export */const re=t9;// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/config.ts
var rt=r(9568);// EXTERNAL MODULE: ../tutor/node_modules/querystring/index.js
var rr=r(4059);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/util.ts + 4 modules
var rn=r(6208);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/types.ts
var ra=r(7150);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/utils/form.ts
var ri=function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:"";return Object.keys(e).reduce((r,n)=>{var a=e[n];if(typeof a==="object"&&!isPrimitivesArray(a)&&!isFileOrBlob(a)){return _object_spread({},r,ri(_object_spread({},a),"".concat(t).concat(n,".")))}return _object_spread_props(_object_spread({},r),{["".concat(t).concat(n)]:a})},{})};var ro=(e,t)=>{var r=e;if(r.status===404||r.status===403||r.status===500){return{nonFieldErrors:["Unexpected error!"]}}var n=ri(t);var a=ri(r.data);var{non_field_errors:i}=a,o=_object_without_properties(a,["non_field_errors"]);var s=isStringArray(i)?i:[];for(var u of Object.keys(o)){if(!(u in n)){var l=a[u];if(isStringArray(l)){s.push(...l)}}}return{nonFieldErrors:s.map(translateBeErrorMessage),fieldErrors:Object.keys(a).filter(e=>e in n).reduce((e,t)=>{var r=a[t];if(isStringArray(r)){return _object_spread_props(_object_spread({},e),{[t]:r.map(translateBeErrorMessage)})}return e},{})}};var rs=(e,t,r)=>{if(!isAxiosError(e)||!e.response){throw e}var{fieldErrors:n,nonFieldErrors:a}=ro(e.response,r);if(a===null||a===void 0?void 0:a.length){t.setSubmitError(a[0])}if(n){for(var i of Object.keys(n)){var o=n[i];if(o.length>0){t.setError(i,{message:o[0]})}}}};var ru=(e,t)=>{return r=>_async_to_generator(function*(){e.setSubmitError(undefined);try{yield t(r)}catch(t){rs(t,e,r)}})()};var rl=(e,t)=>{var r=function(t){var r=e[t];if(Array.isArray(r)){r.forEach((e,r)=>{if((0,rn/* .isFileOrBlob */.$X)(e)||(0,ra/* .isString */.Kg)(e)){n.append("".concat(t,"[").concat(r,"]"),e)}else if((0,ra/* .isBoolean */.Lm)(e)||(0,ra/* .isNumber */.Et)(e)){n.append("".concat(t,"[").concat(r,"]"),e.toString())}else if(typeof e==="object"&&e!==null){n.append("".concat(t,"[").concat(r,"]"),JSON.stringify(e))}else{n.append("".concat(t,"[").concat(r,"]"),e)}})}else{if((0,rn/* .isFileOrBlob */.$X)(r)||(0,ra/* .isString */.Kg)(r)){n.append(t,r)}else if((0,ra/* .isBoolean */.Lm)(r)){n.append(t,r.toString())}else if((0,ra/* .isNumber */.Et)(r)){n.append(t,"".concat(r))}else if(typeof r==="object"&&r!==null){n.append(t,JSON.stringify(r))}else{n.append(t,r)}}};var n=new FormData;for(var a of Object.keys(e))r(a);n.append("_method",t.toUpperCase());return n};var rc=e=>{var t={};for(var r in e){var n=e[r];if(!(0,ra/* .isDefined */.O9)(n)){t[r]="null"}else if((0,ra/* .isBoolean */.Lm)(n)){t[r]=n===true?"true":"false"}else{t[r]=n}}return t};// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/utils/api.ts
re.defaults.paramsSerializer=e=>{return rr.stringify(e)};var rf=re.create({baseURL:rt/* ["default"].WP_API_BASE_URL */.A.WP_API_BASE_URL});rf.interceptors.request.use(e=>{var t;(t=e).headers||(t.headers={});e.headers["X-WP-Nonce"]=rt/* .tutorConfig.wp_rest_nonce */.P.wp_rest_nonce;if(e.method&&["post","put","patch"].includes(e.method.toLocaleLowerCase())){if(e.data){e.data=rl(e.data,e.method)}if(["put","patch"].includes(e.method.toLowerCase())){e.method="POST"}}if(e.params){e.params=rc(e.params)}if(e.method&&["get","delete"].includes(e.method.toLowerCase())){e.params=(0,i._)((0,a._)({},e.params),{_method:e.method})}return e},e=>{return Promise.reject(e)});rf.interceptors.response.use(e=>{return Promise.resolve(e).then(e=>e)});var rd=re.create({baseURL:rt/* ["default"].WP_AJAX_BASE_URL */.A.WP_AJAX_BASE_URL});rd.interceptors.request.use(e=>{var t,r;(t=e).headers||(t.headers={});// config.headers['X-WP-Nonce'] = tutorConfig._tutor_nonce;
// We will use REST methods while using but wp ajax only sent via post method.
e.method="POST";if(e.params){e.params=rc(e.params)}(r=e).data||(r.data={});var n=rt/* .tutorConfig.nonce_key */.P.nonce_key;var o=rt/* .tutorConfig._tutor_nonce */.P._tutor_nonce;e.data=(0,i._)((0,a._)({},e.data,e.params),{action:e.url,[n]:o});e.data=rl(e.data,e.method);e.params={};e.url=undefined;return e},e=>Promise.reject(e));rd.interceptors.response.use(e=>Promise.resolve(e).then(e=>e.data))},8631:function(e,t,r){"use strict";r.d(t,{s:()=>i});/* ESM import */var n=r(7150);/* ESM import */var a=r(6208);var i=(e,t)=>{return r=>{var{variants:i,defaultVariants:o}=e;var s=[];if((0,n/* .isDefined */.O9)(t)){s.push(t)}var u=(0,a/* .getObjectKeys */.Co)(i).map(e=>{var t=r[e];var n=o[e];if(t===null){return null}var a=t||n;return i[e][a]});s.push(...u.filter(n/* .isDefined */.O9));return s}}},7105:function(e,t,r){"use strict";r.d(t,{A:()=>a});var n={ADMIN_AJAX:"wp-admin/admin-ajax.php",TAGS:"course-tag",CATEGORIES:"course-category",USERS:"users",USERS_LIST:"tutor_user_list",ORDER_DETAILS:"tutor_order_details",ADMIN_COMMENT:"tutor_order_comment",ORDER_MARK_AS_PAID:"tutor_order_paid",ORDER_REFUND:"tutor_order_refund",ORDER_CANCEL:"tutor_order_cancel",ADD_ORDER_DISCOUNT:"tutor_order_discount",COURSE_LIST:"course_list",BUNDLE_LIST:"tutor_get_bundle_list",CATEGORY_LIST:"category_list",CREATED_COURSE:"tutor_create_course",TUTOR_INSTRUCTOR_SEARCH:"tutor_course_instructor_search",TUTOR_YOUTUBE_VIDEO_DURATION:"tutor_youtube_video_duration",TUTOR_UNLINK_PAGE_BUILDER:"tutor_unlink_page_builder",// AI CONTENT GENERATION
GENERATE_AI_IMAGE:"tutor_pro_generate_image",MAGIC_FILL_AI_IMAGE:"tutor_pro_magic_fill_image",MAGIC_TEXT_GENERATION:"tutor_pro_generate_text_content",MAGIC_AI_MODIFY_CONTENT:"tutor_pro_modify_text_content",USE_AI_GENERATED_IMAGE:"tutor_pro_use_magic_image",OPEN_AI_SAVE_SETTINGS:"tutor_pro_chatgpt_save_settings",GENERATE_COURSE_CONTENT:"tutor_pro_generate_course_content",GENERATE_COURSE_TOPIC_CONTENT:"tutor_pro_generate_course_topic_content",SAVE_AI_GENERATED_COURSE_CONTENT:"tutor_pro_ai_course_create",GENERATE_QUIZ_QUESTIONS:"tutor_pro_generate_quiz_questions",// SUBSCRIPTION
GET_SUBSCRIPTIONS_LIST:"tutor_subscription_plans",SAVE_SUBSCRIPTION:"tutor_subscription_plan_save",DELETE_SUBSCRIPTION:"tutor_subscription_plan_delete",DUPLICATE_SUBSCRIPTION:"tutor_subscription_plan_duplicate",SORT_SUBSCRIPTION:"tutor_subscription_plan_sort",// COURSE
GET_COURSE_DETAILS:"tutor_course_details",UPDATE_COURSE:"tutor_update_course",GET_COURSE_LIST:"tutor_course_list",// WOO COMMERCE PRODUCTS
GET_WC_PRODUCTS:"tutor_get_wc_products",GET_WC_PRODUCT_DETAILS:"tutor_get_wc_product",// QUIZ
GET_QUIZ_DETAILS:"tutor_quiz_details",SAVE_QUIZ:"tutor_quiz_builder_save",QUIZ_IMPORT_DATA:"quiz_import_data",QUIZ_EXPORT_DATA:"quiz_export_data",DELETE_QUIZ:"tutor_quiz_delete",// ZOOM
GET_ZOOM_MEETING_DETAILS:"tutor_zoom_meeting_details",SAVE_ZOOM_MEETING:"tutor_zoom_save_meeting",DELETE_ZOOM_MEETING:"tutor_zoom_delete_meeting",// GOOGLE MEET
GET_GOOGLE_MEET_DETAILS:"tutor_google_meet_meeting_details",SAVE_GOOGLE_MEET:"tutor_google_meet_new_meeting",DELETE_GOOGLE_MEET:"tutor_google_meet_delete",// TOPIC
GET_COURSE_CONTENTS:"tutor_course_contents",SAVE_TOPIC:"tutor_save_topic",DELETE_TOPIC:"tutor_delete_topic",DELETE_TOPIC_CONTENT:"tutor_delete_lesson",UPDATE_COURSE_CONTENT_ORDER:"tutor_update_course_content_order",DUPLICATE_CONTENT:"tutor_duplicate_content",ADD_CONTENT_BANK_CONTENT_TO_COURSE:"tutor_content_bank_add_content_to_course",DELETE_CONTENT_BANK_CONTENT_FROM_COURSE:"tutor_content_bank_remove_content_from_course",// LESSON
GET_LESSON_DETAILS:"tutor_lesson_details",SAVE_LESSON:"tutor_save_lesson",// ASSIGNMENT
GET_ASSIGNMENT_DETAILS:"tutor_assignment_details",SAVE_ASSIGNMENT:"tutor_assignment_save",// TAX SETTINGS
GET_TAX_SETTINGS:"tutor_get_tax_settings",GET_H5P_QUIZ_CONTENT:"tutor_h5p_list_quiz_contents",GET_H5P_LESSON_CONTENT:"tutor_h5p_list_lesson_contents",GET_H5P_QUIZ_CONTENT_BY_ID:"tutor_h5p_quiz_content_by_id",// PAYMENT SETTINGS
GET_PAYMENT_SETTINGS:"tutor_payment_settings",GET_PAYMENT_GATEWAYS:"tutor_payment_gateways",INSTALL_PAYMENT_GATEWAY:"tutor_install_payment_gateway",REMOVE_PAYMENT_GATEWAY:"tutor_remove_payment_gateway",// ADDON LIST
GET_ADDON_LIST:"tutor_get_all_addons",ADDON_ENABLE_DISABLE:"addon_enable_disable",// INSTALL PLUGIN
TUTOR_INSTALL_PLUGIN:"tutor_install_plugin",// COUPON
GET_COUPON_DETAILS:"tutor_coupon_details",CREATE_COUPON:"tutor_coupon_create",UPDATE_COUPON:"tutor_coupon_update",COUPON_APPLIES_TO:"tutor_coupon_applies_to_list",// ENROLLMENT
CREATE_ENROLLMENT:"tutor_enroll_bulk_student",GET_COURSE_BUNDLE_LIST:"tutor_course_bundle_list",GET_UNENROLLED_USERS:"tutor_unenrolled_users",// MEMBERSHIP
GET_MEMBERSHIP_PLANS:"tutor_membership_plans",SAVE_MEMBERSHIP_PLAN:"tutor_membership_plan_save",DUPLICATE_MEMBERSHIP_PLAN:"tutor_membership_plan_duplicate",DELETE_MEMBERSHIP_PLAN:"tutor_membership_plan_delete",// COURSE BUNDLE
GET_BUNDLE_DETAILS:"tutor_get_course_bundle_data",UPDATE_BUNDLE:"tutor_create_course_bundle",ADD_REMOVE_COURSE_TO_BUNDLE:"tutor_add_remove_course_to_bundle",// IMPORT EXPORT
GET_EXPORTABLE_CONTENT:"tutor_pro_exportable_contents",EXPORT_CONTENTS:"tutor_pro_export",EXPORT_SETTINGS_FREE:"tutor_export_settings",IMPORT_CONTENTS:"tutor_pro_import",IMPORT_SETTINGS_FREE:"tutor_import_settings",GET_IMPORT_EXPORT_HISTORY:"tutor_pro_export_import_history",DELETE_IMPORT_EXPORT_HISTORY:"tutor_pro_delete_export_import_history",// CONTENT BANK
GET_CONTENT_BANK_COLLECTIONS:"tutor_content_bank_collections",SAVE_CONTENT_BANK_COLLECTION:"tutor_content_bank_collection_save",DELETE_CONTENT_BANK_COLLECTION:"tutor_content_bank_collection_delete",GET_CONTENT_BANK_CONTENTS:"tutor_content_bank_contents",DELETE_CONTENT_BANK_CONTENTS:"tutor_content_bank_content_delete",GET_CONTENT_DETAILS:"tutor_pro_get_content_details",GET_CONTENT_BANK_LESSON_DETAILS:"tutor_content_bank_lesson_details",GET_CONTENT_BANK_ASSIGNMENT_DETAILS:"tutor_content_bank_assignment_details",SAVE_CONTENT_BANK_LESSON_CONTENT:"tutor_content_bank_lesson_save",SAVE_CONTENT_BANK_ASSIGNMENT_CONTENT:"tutor_content_bank_assignment_save",SAVE_QUESTION_CONTENT:"tutor_content_bank_question_save",GET_CONTENT_BANK_QUESTION_DETAILS:"tutor_content_bank_question_details",DUPLICATE_CONTENT_BANK_CONTENT:"tutor_content_bank_content_duplicate",MOVE_CONTENT_BANK_CONTENT:"tutor_content_bank_content_move",DUPLICATE_CONTENT_BANK_COLLECTION:"tutor_content_bank_collection_duplicate",IMPORT_FROM_COURSES:"tutor_content_bank_content_synchronize"};/* ESM default export */const a=n},6014:function(e,t,r){"use strict";r.d(t,{v:()=>c,x:()=>f});/* ESM import */var n=r(6154);/* ESM import */var a=r(4532);/* ESM import */var i=r(1699);/* ESM import */var o=r(6439);function s(){var e=(0,n._)(["\n      flex-direction: column;\n    "]);s=function t(){return e};return e}function u(){var e=(0,n._)(["\n      background-color: ",";\n    "]);u=function t(){return e};return e}function l(){var e=(0,n._)(["\n      cursor: grabbing;\n    "]);l=function t(){return e};return e}var c=()=>/*#__PURE__*/(0,i/* .css */.AH)("body.tutor-backend-tutor-content-bank{@media screen and (max-width:600px){#wpadminbar{position:fixed;}}}*,::after,::before{box-sizing:border-box;}html{line-height:1.15;-webkit-text-size-adjust:100%;}body{margin:0;font-family:",a/* .fontFamily.inter */.mw.inter,";height:100%;}main{display:block;}h1{font-size:2em;margin:0.67em 0;}hr{box-sizing:content-box;height:0;overflow:visible;}pre{font-family:monospace,monospace;font-size:1em;}a{background-color:transparent;&:hover{color:inherit;}}li{list-style:none;margin:0;}abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted;}b,strong{font-weight:bolder;}code,kbd,samp{font-family:monospace,monospace;font-size:1em;}small{font-size:80%;}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline;}sub{bottom:-0.25em;}sup{top:-0.5em;}img{border-style:none;}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0;}button,input{overflow:visible;}button,select{text-transform:none;}button,[type='button'],[type='reset'],[type='submit']{-webkit-appearance:button;}button::-moz-focus-inner,[type='button']::-moz-focus-inner,[type='reset']::-moz-focus-inner,[type='submit']::-moz-focus-inner{border-style:none;padding:0;}button:-moz-focusring,[type='button']:-moz-focusring,[type='reset']:-moz-focusring,[type='submit']:-moz-focusring{outline:1px dotted ButtonText;}fieldset{padding:0.35em 0.75em 0.625em;}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal;}progress{vertical-align:baseline;}textarea{overflow:auto;height:auto;}[type='checkbox'],[type='radio']{box-sizing:border-box;padding:0;}[type='number']::-webkit-inner-spin-button,[type='number']::-webkit-outer-spin-button{height:auto;}[type='search']{-webkit-appearance:textfield;outline-offset:-2px;}[type='search']::-webkit-search-decoration{-webkit-appearance:none;}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit;}details{display:block;}summary{display:list-item;}template{display:none;}[hidden]{display:none;}:is(h1,h2,h3,h4,h5,h6,p){padding:0;margin:0;text-transform:unset;}table{th{text-align:-webkit-match-parent;}}");var f={centeredFlex:/*#__PURE__*/(0,i/* .css */.AH)("display:flex;justify-content:center;align-items:center;width:100%;height:100%;"),flexCenter:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"row";return/*#__PURE__*/(0,i/* .css */.AH)("display:flex;justify-content:center;align-items:center;flex-direction:row;",e==="column"&&(0,i/* .css */.AH)(s()))},boxReset:/*#__PURE__*/(0,i/* .css */.AH)("padding:0;"),ulReset:/*#__PURE__*/(0,i/* .css */.AH)("list-style:none;padding:0;margin:0;"),resetButton:/*#__PURE__*/(0,i/* .css */.AH)("background:none;border:none;outline:none;box-shadow:none;padding:0;margin:0;text-align:inherit;font-family:",a/* .fontFamily.inter */.mw.inter,";cursor:pointer;"),cardInnerSection:/*#__PURE__*/(0,i/* .css */.AH)("padding:",a/* .spacing["20"] */.YK["20"]," ",a/* .spacing["20"] */.YK["20"]," ",a/* .spacing["24"] */.YK["24"]," ",a/* .spacing["20"] */.YK["20"],";display:flex;flex-direction:column;gap:",a/* .spacing["24"] */.YK["24"],";"),fieldGroups:e=>/*#__PURE__*/(0,i/* .css */.AH)("display:flex;flex-direction:column;gap:",a/* .spacing */.YK[e],";"),titleAliasWrapper:/*#__PURE__*/(0,i/* .css */.AH)("display:flex;flex-direction:column;gap:",a/* .spacing["12"] */.YK["12"],";"),inlineSwitch:/*#__PURE__*/(0,i/* .css */.AH)("display:flex;justify-content:space-between;align-items:center;"),overflowYAuto:/*#__PURE__*/(0,i/* .css */.AH)("overflow-y:auto;scrollbar-gutter:stable;::-webkit-scrollbar{background-color:",a/* .colorTokens.primary["40"] */.I6.primary["40"],";width:3px;}::-webkit-scrollbar-thumb{background-color:",a/* .colorTokens.design.brand */.I6.design.brand,";border-radius:",a/* .borderRadius["30"] */.Vq["30"],";}"),overflowXAuto:/*#__PURE__*/(0,i/* .css */.AH)("overflow-x:auto;scrollbar-gutter:stable;::-webkit-scrollbar{background-color:",a/* .colorTokens.primary["40"] */.I6.primary["40"],";height:3px;}::-webkit-scrollbar-thumb{background-color:",a/* .colorTokens.design.brand */.I6.design.brand,";border-radius:",a/* .borderRadius["30"] */.Vq["30"],";}"),textEllipsis:/*#__PURE__*/(0,i/* .css */.AH)("text-overflow:ellipsis;overflow:hidden;white-space:nowrap;"),container:/*#__PURE__*/(0,i/* .css */.AH)("width:",a/* .containerMaxWidth */.iL,"px;margin:0 auto;"),display:{flex:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"row";return/*#__PURE__*/(0,i/* .css */.AH)("display:flex;flex-direction:",e,";")},inlineFlex:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:"row";return/*#__PURE__*/(0,i/* .css */.AH)("display:inline-flex;flex-direction:",e,";")},none:/*#__PURE__*/(0,i/* .css */.AH)("display:none;"),block:/*#__PURE__*/(0,i/* .css */.AH)("display:block;"),inlineBlock:/*#__PURE__*/(0,i/* .css */.AH)("display:inline-block;")},text:{ellipsis:function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:1;return/*#__PURE__*/(0,i/* .css */.AH)("white-space:normal;display:-webkit-box;-webkit-line-clamp:",e,";-webkit-box-orient:vertical;overflow:hidden;-webkit-box-pack:end;")},align:{center:/*#__PURE__*/(0,i/* .css */.AH)("text-align:center;"),left:/*#__PURE__*/(0,i/* .css */.AH)("text-align:left;"),right:/*#__PURE__*/(0,i/* .css */.AH)("text-align:right;"),justify:/*#__PURE__*/(0,i/* .css */.AH)("text-align:justify;")}},inputFocus:/*#__PURE__*/(0,i/* .css */.AH)("box-shadow:none;border-color:",a/* .colorTokens.stroke["default"] */.I6.stroke["default"],";outline:2px solid ",a/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;"),dateAndTimeWrapper:/*#__PURE__*/(0,i/* .css */.AH)("display:grid;grid-template-columns:5.5fr 4.5fr;border-radius:",a/* .borderRadius["6"] */.Vq["6"],";position:relative;&::before{content:'';position:absolute;top:0;left:0;right:0;height:40px;outline:2px solid transparent;outline-offset:1px;border-radius:",a/* .borderRadius["6"] */.Vq["6"],";pointer-events:none;z-index:1;transition:outline-color 0.2s ease-in-out;}&:focus-within::before{outline-color:",a/* .colorTokens.stroke.brand */.I6.stroke.brand,";}> div{&:first-of-type{input{border-top-right-radius:0;border-bottom-right-radius:0;&:focus{box-shadow:none;outline:none;}}}&:last-of-type{input{border-top-left-radius:0;border-bottom-left-radius:0;border-left:none;&:focus{box-shadow:none;outline:none;}}}}"),inputCurrencyStyle:/*#__PURE__*/(0,i/* .css */.AH)("font-size:",a/* .fontSize["18"] */.J["18"],";color:",a/* .colorTokens.icon.subdued */.I6.icon.subdued,";"),crossButton:/*#__PURE__*/(0,i/* .css */.AH)("border:none;outline:none;padding:0;margin:0;text-align:inherit;cursor:pointer;display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:",a/* .borderRadius.circle */.Vq.circle,";background:",a/* .colorTokens.background.white */.I6.background.white,";transition:opacity 0.3s ease-in-out;svg{color:",a/* .colorTokens.icon["default"] */.I6.icon["default"],";transition:color 0.3s ease-in-out;}:hover{svg{color:",a/* .colorTokens.icon.hover */.I6.icon.hover,";}}:focus{box-shadow:",a/* .shadow.focus */.r7.focus,";}"),aiGradientText:/*#__PURE__*/(0,i/* .css */.AH)("background:",a/* .colorTokens.text.ai.gradient */.I6.text.ai.gradient,";background-clip:text;-webkit-background-clip:text;-webkit-text-fill-color:transparent;"),actionButton:/*#__PURE__*/(0,i/* .css */.AH)("background:none;border:none;outline:none;padding:0;margin:0;text-align:inherit;color:",a/* .colorTokens.icon["default"] */.I6.icon["default"],";display:flex;cursor:pointer;transition:color 0.3s ease-in-out;:hover:not(:disabled),:focus:not(:disabled),:active:not(:disabled){background:none;color:",a/* .colorTokens.icon.brand */.I6.icon.brand,";}:disabled{color:",a/* .colorTokens.icon.disable.background */.I6.icon.disable.background,";cursor:not-allowed;}:focus-visible{outline:2px solid ",a/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;border-radius:",a/* .borderRadius["2"] */.Vq["2"],";}"),backButton:/*#__PURE__*/(0,i/* .css */.AH)("background-color:transparent;width:32px;height:32px;padding:0;margin:0;flex-shrink:0;display:flex;align-items:center;justify-content:center;border:1px solid ",a/* .colorTokens.border.neutral */.I6.border.neutral,";border-radius:",a/* .borderRadius["4"] */.Vq["4"],";outline:none;color:",a/* .colorTokens.icon["default"] */.I6.icon["default"],";transition:color 0.3s ease-in-out;cursor:pointer;:hover{color:",a/* .colorTokens.icon.hover */.I6.icon.hover,";}&:focus-visible{outline:2px solid ",a/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}"),optionCheckButton:/*#__PURE__*/(0,i/* .css */.AH)("background:none;border:none;outline:none;padding:0;margin:0;text-align:inherit;font-family:",a/* .fontFamily.inter */.mw.inter,";cursor:pointer;height:32px;width:32px;border-radius:",a/* .borderRadius.circle */.Vq.circle,";opacity:0;:focus-visible{outline:2px solid ",a/* .colorTokens.stroke.brand */.I6.stroke.brand,";}"),optionCounter:e=>{var{isEditing:t,isSelected:r=false}=e;return/*#__PURE__*/(0,i/* .css */.AH)("height:",a/* .spacing["24"] */.YK["24"],";width:",a/* .spacing["24"] */.YK["24"],";border-radius:",a/* .borderRadius.min */.Vq.min,";",o/* .typography.caption */.I.caption("medium"),";color:",a/* .colorTokens.text.subdued */.I6.text.subdued,";background-color:",a/* .colorTokens.background["default"] */.I6.background["default"],";text-align:center;",r&&!t&&(0,i/* .css */.AH)(u(),a/* .colorTokens.bg.white */.I6.bg.white))},optionDragButton:e=>{var{isOverlay:t}=e;return/*#__PURE__*/(0,i/* .css */.AH)("background:none;border:none;outline:none;padding:0;margin:0;text-align:inherit;font-family:",a/* .fontFamily.inter */.mw.inter,";cursor:grab;display:flex;align-items:center;justify-content:center;transform:rotate(90deg);color:",a/* .colorTokens.icon["default"] */.I6.icon["default"],";cursor:grab;place-self:center center;border-radius:",a/* .borderRadius["2"] */.Vq["2"],";&:focus,&:active,&:hover{background:none;color:",a/* .colorTokens.icon["default"] */.I6.icon["default"],";}:focus-visible{outline:2px solid ",a/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}",t&&(0,i/* .css */.AH)(l()))},optionInputWrapper:/*#__PURE__*/(0,i/* .css */.AH)("display:flex;flex-direction:column;width:100%;gap:",a/* .spacing["12"] */.YK["12"],";input,textarea{background:none;border:none;outline:none;padding:0;margin:0;text-align:inherit;font-family:",a/* .fontFamily.inter */.mw.inter,";",o/* .typography.caption */.I.caption(),";flex:1;color:",a/* .colorTokens.text.subdued */.I6.text.subdued,";padding:",a/* .spacing["4"] */.YK["4"]," ",a/* .spacing["10"] */.YK["10"],";border:1px solid ",a/* .colorTokens.stroke["default"] */.I6.stroke["default"],";border-radius:",a/* .borderRadius["6"] */.Vq["6"],";resize:vertical;cursor:text;&:focus{box-shadow:none;border-color:",a/* .colorTokens.stroke["default"] */.I6.stroke["default"],";outline:2px solid ",a/* .colorTokens.stroke.brand */.I6.stroke.brand,";outline-offset:1px;}}"),objectFit:function(){var{fit:e,position:t}=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{fit:"cover",position:"center"};return/*#__PURE__*/(0,i/* .css */.AH)("object-fit:",e,";object-position:",t,";")},inputClearButton:/*#__PURE__*/(0,i/* .css */.AH)("position:absolute;top:50%;right:",a/* .spacing["4"] */.YK["4"],";transform:translateY(-50%);background-color:",a/* .colorTokens.background.white */.I6.background.white,";border-radius:",a/* .borderRadius["2"] */.Vq["2"],";&:not(:disabled):not([aria-disabled='true']):hover,&:not(:disabled):not([aria-disabled='true']):focus{background-color:",a/* .colorTokens.background.hover */.I6.background.hover,";}")}},7150:function(e,t,r){"use strict";r.d(t,{Et:()=>l,Gv:()=>f,Kg:()=>o,Lm:()=>c,O9:()=>i});var n=(e,t)=>{return t in e};var a=e=>{return e.isAxiosError};var i=e=>{return e!==undefined&&e!==null};function o(e){return typeof e==="string"||e instanceof String}function s(e){return!!e&&Array.isArray(e)&&(!e.length||typeof e[0]!=="object")}function u(e){return s(e)&&(!e.length||typeof e[0]==="string"||e[0]instanceof String)}function l(e){return typeof e==="number"||e instanceof Number}function c(e){return typeof e==="boolean"||e instanceof Boolean}function f(e){return typeof e==="object"&&e!==null&&!Array.isArray(e)}var d=/* unused pure expression or super */null&&{NEW:"new",UPDATE:"update",NO_CHANGE:"no_change"}},6208:function(e,t,r){"use strict";// EXPORTS
r.d(t,{dn:()=>/* binding */J,$X:()=>/* binding */A,Ak:()=>/* binding */k,lQ:()=>/* binding */E,qz:()=>/* binding */eo,g1:()=>/* binding */Z,y1:()=>/* binding */O,q9:()=>/* binding */ea,TW:()=>/* binding */q,ww:()=>/* binding */M,EL:()=>/* binding */er,tw:()=>/* binding */P,G0:()=>/* binding */N,GR:()=>/* binding */ei,Co:()=>/* binding */G,oj:()=>/* binding */F,lW:()=>/* binding */et,jT:()=>/* binding */eu});// UNUSED EXPORTS: generateCouponCode, formatSeconds, formatBytes, fetchImageUrlAsBase64, objectToQueryParams, makeFirstCharacterUpperCase, jsonParse, getValueInArray, wait, arrayRange, transformParams, formatSubscriptionRepeatUnit, arrayIntersect, covertSecondsToHMS, extractIdOnly, assertIsDefined, formatReadAbleBytesToBytes, findSlotFields, getFileExtensionFromName, getObjectEntries, getObjectValues, hasDuplicateEntries, mapInBetween, normalizeLineEndings, throttle
// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js + 1 modules
var n=r(7317);// EXTERNAL MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread_props.js
var a=r(8015);// EXTERNAL MODULE: external "wp.i18n"
var i=r(2470);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/addMinutes/index.js
var o=r(8443);// EXTERNAL MODULE: ../tutor/node_modules/date-fns/esm/format/index.js + 28 modules
var s=r(988);// CONCATENATED MODULE: ../tutor/node_modules/uuid/dist/esm-browser/native.js
const u=typeof crypto!=="undefined"&&crypto.randomUUID&&crypto.randomUUID.bind(crypto);/* ESM default export */const l={randomUUID:u};// CONCATENATED MODULE: ../tutor/node_modules/uuid/dist/esm-browser/rng.js
// Unique ID creation requires a high quality random # generator. In the browser we therefore
// require the crypto API and do not support built-in fallback to lower quality random number
// generators (like Math.random()).
let c;const f=new Uint8Array(16);function d(){// lazy load so that environments that need to polyfill have a chance to do so
if(!c){// getRandomValues needs to be invoked in a context where "this" is a Crypto implementation.
c=typeof crypto!=="undefined"&&crypto.getRandomValues&&crypto.getRandomValues.bind(crypto);if(!c){throw new Error("crypto.getRandomValues() not supported. See https://github.com/uuidjs/uuid#getrandomvalues-not-supported")}}return c(f)};// CONCATENATED MODULE: ../tutor/node_modules/uuid/dist/esm-browser/stringify.js
/**
 * Convert array of 16 byte values to UUID string format of the form:
 * XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX
 */const h=[];for(let e=0;e<256;++e){h.push((e+256).toString(16).slice(1))}function p(e,t=0){// Note: Be careful editing this code!  It's been tuned for performance
// and works in ways you may not expect. See https://github.com/uuidjs/uuid/pull/434
return h[e[t+0]]+h[e[t+1]]+h[e[t+2]]+h[e[t+3]]+"-"+h[e[t+4]]+h[e[t+5]]+"-"+h[e[t+6]]+h[e[t+7]]+"-"+h[e[t+8]]+h[e[t+9]]+"-"+h[e[t+10]]+h[e[t+11]]+h[e[t+12]]+h[e[t+13]]+h[e[t+14]]+h[e[t+15]]}function v(e,t=0){const r=p(e,t);// Consistency check for valid UUID.  If this throws, it's likely due to one
// of the following:
// - One or more input array values don't map to a hex octet (leading to
// "undefined" in the uuid)
// - Invalid input values for the RFC `version` or `variant` fields
if(!validate(r)){throw TypeError("Stringified UUID is invalid")}return r}/* ESM default export */const m=/* unused pure expression or super */null&&v;// CONCATENATED MODULE: ../tutor/node_modules/uuid/dist/esm-browser/v4.js
function g(e,t,r){if(l.randomUUID&&!t&&!e){return l.randomUUID()}e=e||{};const n=e.random||(e.rng||d)();// Per 4.4, set bits for version and `clock_seq_hi_and_reserved`
n[6]=n[6]&15|64;n[8]=n[8]&63|128;// Copy bytes to buffer, if provided
if(t){r=r||0;for(let e=0;e<16;++e){t[r+e]=n[e]}return t}return p(n)}/* ESM default export */const b=g;// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/config.ts
var y=r(9568);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/constants.ts
var w=r(5781);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/types.ts
var _=r(7150);// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/utils/util.ts
function x(e,t){if(e===undefined||e===null){throw new Error(t)}}var E=()=>{};var O=e=>Array.from(Array(e).keys());var S=(e,t)=>Array.from({length:t-e},(t,r)=>r+e);var A=e=>{return e instanceof Blob||e instanceof File};var T=e=>{return Array.isArray(e)?e:e?[e]:[]};// Generate unique id
var k=()=>b();// Generate coupon code
var R=function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:8;var t=e;var r="MSOP0123456789ABCDEFGHNRVUKYTJLZXIW";var n="";while(t--){n+=r[Math.random()*35|0]}return n};// Useful for mock api call
var C=function(){var e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:0;return new Promise(t=>setTimeout(t,e))};/**
 * Move one array item from one index to another index
 * (don't change the original array) instead return a new one.
 *
 * @param arr Array
 * @param fromIndex Number
 * @param toIndex Number
 * @returns new Array
 */var P=(e,t,r)=>{var n=[...e];var a=t;var i=r;if(t<0){a=e.length+t}if(t>=0&&t<e.length){if(r<0){i=e.length+r}var[o]=n.splice(a,1);if(o){n.splice(i,0,o)}}return n};var I=e=>{var t=e.split(".");var r=t.pop();return r?".".concat(r):""};var D=function(e,t){var r=arguments.length>2&&arguments[2]!==void 0?arguments[2]:true;var n={};for(var a of e){var i,o;var s=t(a);s=r?s:s.toString().toLowerCase();(i=n)[o=s]||(i[o]=0);n[s]++;var u=n[s];if(u&&u>1){return true}}return false};var M=function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:0,r=arguments.length>2&&arguments[2]!==void 0?arguments[2]:new Set;var i=new Set(e.map(e=>e.id));var o=e.filter(e=>{if(r.has(e.id)){return false}if(t===0){return e.parent===0||!i.has(e.parent)}return e.parent===t});return o.reduce((t,i)=>{r.add(i.id);var o=M(e,i.id,r);return[...t,(0,a._)((0,n._)({},i),{children:o})]},[])};var F=(e,t)=>{var r="0";if(!e){r="100%"}else if(e&&t>0){if(t>1){r="".concat(23+32*(t-1),"px")}else{r="23px"}}return r};var L=e=>{var t,r;var n=((t=e.sort)===null||t===void 0?void 0:t.direction)==="desc"?"-":"";return _object_spread({limit:e.limit,offset:e.offset,sort:((r=e.sort)===null||r===void 0?void 0:r.property)&&"".concat(n).concat(e.sort.property)},e.filter)};var N=(e,t)=>Math.floor(Math.random()*(t-e))+e;var j=(e,t,r,n,a)=>{return(e-t)*(a-n)/(r-t)+n};var U=e=>{return e.map(e=>e.id)};var H=(e,t)=>{var r=new Set(e);var n=new Set(t);var a=[];for(var i of r){if(n.has(i)){a.push(i)}}return a};var B=e=>{if(!e)return e;var t=e.charAt(0).toUpperCase();var r=e.slice(1);return"".concat(t).concat(r)};var Y=function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:2;if(!e||e<=1){return"0 Bytes"}var r=1024;var n=Math.max(0,t);var a=[__("Bytes","tutor-pro"),__("KB","tutor-pro"),__("MB","tutor-pro"),__("GB","tutor-pro"),__("TB","tutor-pro"),__("PB","tutor-pro"),__("EB","tutor-pro"),__("ZB","tutor-pro"),__("YB","tutor-pro")];var i=Math.floor(Math.log(e)/Math.log(r));return"".concat(Number.parseFloat((e/r**i).toFixed(n))," ").concat(a[i])};var z=e=>{if(!e||typeof e!=="string"){return 0}var[t,r]=e.split(" ");var n=parseFloat(t);var a=["Bytes","KB","MB","GB","TB","PB","EB","ZB","YB"];var i=a.indexOf(r);if(i===-1){return 0}return n*1024**i};var q=(e,t)=>{return e.replace(t?/[^0-9.-]/g:/[^0-9.]/g,"").replace(/(?!^)-/g,"").replace(/(\..*)\./g,"$1")};var V=(e,t)=>{var r=false;return function n(){for(var n=arguments.length,a=new Array(n),i=0;i<n;i++){a[i]=arguments[i]}if(!r){e.apply(this,a);r=true;setTimeout(()=>{r=false},t)}}};var W=e=>{return JSON.parse(e)};var $=e=>{var t=Math.floor(e/3600).toString().padStart(2,"0");var r=Math.floor(e%3600/60).toString().padStart(2,"0");var n=Math.floor(e%60);if(t==="00"){return"".concat(r,":").concat(n," mins")}return"".concat(t,":").concat(r,":").concat(n," hrs")};var G=e=>{if(!(0,_/* .isDefined */.O9)(e)||!(0,_/* .isObject */.Gv)(e)){return[]}return Object.keys(e)};var K=e=>{return Object.values(e)};var Q=e=>{return Object.entries(e)};function X(e){var t=new URLSearchParams;for(var r in e){if(r in e){t.append(r,e[r])}}return t.toString()}var J=function(e){var t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:w/* .DateFormats.yearMonthDayHourMinuteSecond24H */.UA.yearMonthDayHourMinuteSecond24H;var r=e.getTimezoneOffset();var n=(0,o/* ["default"] */.A)(e,r);return(0,s/* ["default"] */.A)(n,t)};var Z=e=>{var t=new Date(e);var r=t.getTimezoneOffset();return(0,o/* ["default"] */.A)(t,-r)};var ee=e=>{return(e||"").replace(/\r\n/g,"\n")};var et=e=>{return new Promise((t,r)=>{if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(e).then(()=>t()).catch(e=>r(e))}else{var n=document.createElement("textarea");n.value=e;document.body.appendChild(n);n.select();try{// if navigator.clipboard is not available, use document.execCommand('copy')
document.execCommand("copy");t()}catch(e){r(e)}finally{document.body.removeChild(n);// Clean up
}}})};var er=e=>{if(!e||!e.response||!e.response.data){return(0,i.__)("Something went wrong","tutor-pro")}var t=e.response.data.message;if(e.response.data.status_code===422&&e.response.data.data){t=e.response.data.data[Object.keys(e.response.data.data)[0]]}return t||(0,i.__)("Something went wrong","tutor-pro")};var en=e=>_async_to_generator(function*(){try{var t=yield fetch(e);var r=yield t.blob();var n=new FileReader;return new Promise((e,t)=>{n.readAsDataURL(r);n.onload=()=>e(n.result);n.onerror=e=>t(e)})}catch(e){throw new Error("Failed to fetch and convert image: ".concat(e))}})();var ea=(e,t)=>{if(e==="trash"){return"trash"}if(t==="private"){return"private"}if(e==="future"){return"future"}if(t==="password_protected"&&e!=="draft"){return"publish"}return e};var ei=e=>{var t;return!!((t=y/* .tutorConfig.addons_data.find */.P.addons_data.find(t=>t.base_name===e))===null||t===void 0?void 0:t.is_enabled)};var eo=e=>{if(!e||typeof e!=="string"){return""}return e.normalize("NFKD")// Normalize accented characters into base forms + diacritics
.replace(/[\u0300-\u036f]/g,"")// Remove combining diacritical marks
.toLowerCase()// Remove special characters !~@#$%^&*(){}[]|\;:"',./?
// Remove characters that are NOT:
// - Basic Latin letters and numbers (a-z, 0-9)
// - Spaces and hyphens
// - Latin Extended (À-ž, etc.)
// - Greek and Coptic (Α-ω)
// - Cyrillic (А-я)
// - Hebrew (א-ת)
// - Arabic (ا-ي)
// - Devanagari (Hindi)
// - Thai
// - Tamil
// - Georgian
// - Hangul Jamo (Korean building blocks)
// - Hiragana (Japanese)
// - Katakana (Japanese)
// - CJK Unified Ideographs (Chinese/Japanese/Korean characters)
// - Hangul Syllables (Korean)
// - Hangul Compatibility Jamo
// - Hangul Jamo Extended-A
// - Hangul Jamo Extended-B
.replace(/[^a-z0-9\s\-\u00C0-\u024F\u0370-\u03FF\u0400-\u04FF\u0590-\u05FF\u0600-\u06FF\u0900-\u097F\u0E00-\u0E7F\u0B80-\u0BFF\u10A0-\u10FF\u1100-\u11FF\u3130-\u318F\u3040-\u309F\u30A0-\u30FF\u4E00-\u9FFF\uA960-\uA97F\uAC00-\uD7AF\uD7B0-\uD7FF]/g,"").replace(/\s+/g,"-")// Replace multiple spaces with single dash
.replace(/-+/g,"-")// Replace multiple dashes with single dash
.replace(/^-+|-+$/g,"")// Remove leading and trailing dashes
};var es=function(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++){t[r]=arguments[r]}var n=[];t.forEach(e=>{if(e.slotKey){e.fields[e.slotKey].forEach(e=>{n.push(e.name)})}else{Object.keys(e.fields).forEach(t=>{e.fields[t].forEach(e=>{n.push(e.name)})})}});return n};var eu=e=>{var t=new DOMParser;var r=t.parseFromString(e,"text/html");return r.body.textContent||""};var el=e=>{var{unit:t="hour",value:r,useLySuffix:n=false,capitalize:a=true,showSingular:i=false}=e;if(t==="until_cancellation"){var o=__("Until Cancellation","tutor-pro");return a?ec(o):o}var s={hour:{// translators: %d is the number of hours
plural:__("%d hours","tutor-pro"),// translators: %d is the number of hours
singular:__("%d hour","tutor-pro"),suffix:__("hourly","tutor-pro"),base:__("hour","tutor-pro")},day:{// translators: %d is the number of days
plural:__("%d days","tutor-pro"),// translators: %d is the number of days
singular:__("%d day","tutor-pro"),suffix:__("daily","tutor-pro"),base:__("day","tutor-pro")},week:{// translators: %d is the number of weeks
plural:__("%d weeks","tutor-pro"),// translators: %d is the number of weeks
singular:__("%d week","tutor-pro"),suffix:__("weekly","tutor-pro"),base:__("week","tutor-pro")},month:{// translators: %d is the number of months
plural:__("%d months","tutor-pro"),// translators: %d is the number of months
singular:__("%d month","tutor-pro"),suffix:__("monthly","tutor-pro"),base:__("month","tutor-pro")},year:{// translators: %d is the number of years
plural:__("%d years","tutor-pro"),// translators: %d is the number of years
singular:__("%d year","tutor-pro"),suffix:__("yearly","tutor-pro"),base:__("year","tutor-pro")}};if(!s[t]){return""}var u="";if(r>1){u=sprintf(s[t].plural,r)}else if(i){u=sprintf(s[t].singular,r)}else if(n){u=s[t].suffix}else{u=s[t].base}return a?ec(u):u};var ec=e=>{return e.split(" ").map(e=>e.charAt(0).toUpperCase()+e.slice(1)).join(" ")};var ef=e=>{var t=Math.floor(e/3600);var r=Math.floor(e%3600/60);var n=e%60;return{hours:t,minutes:r,seconds:n}}},1594:function(e){"use strict";e.exports=React},5206:function(e){"use strict";e.exports=ReactDOM},2470:function(e){"use strict";e.exports=wp.i18n},6838:function(e,t,r){"use strict";r.d(t,{_:()=>a});function n(e,t,r,n,a,i,o){try{var s=e[i](o);var u=s.value}catch(e){r(e);return}if(s.done)t(u);else Promise.resolve(u).then(n,a)}function a(e){return function(){var t=this,r=arguments;return new Promise(function(a,i){var o=e.apply(t,r);function s(e){n(o,a,i,s,u,"next",e)}function u(e){n(o,a,i,s,u,"throw",e)}s(undefined)})}}},7584:function(e,t,r){"use strict";// EXPORTS
r.d(t,{_:()=>/* binding */a});// CONCATENATED MODULE: ./node_modules/@swc/helpers/esm/_define_property.js
function n(e,t,r){if(t in e){Object.defineProperty(e,t,{value:r,enumerable:true,configurable:true,writable:true})}else e[t]=r;return e};// CONCATENATED MODULE: ./node_modules/@swc/helpers/esm/_object_spread.js
function a(e){for(var t=1;t<arguments.length;t++){var r=arguments[t]!=null?arguments[t]:{};var a=Object.keys(r);if(typeof Object.getOwnPropertySymbols==="function"){a=a.concat(Object.getOwnPropertySymbols(r).filter(function(e){return Object.getOwnPropertyDescriptor(r,e).enumerable}))}a.forEach(function(t){n(e,t,r[t])})}return e}},408:function(e,t,r){"use strict";r.d(t,{_:()=>a});function n(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);if(t){n=n.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})}r.push.apply(r,n)}return r}function a(e,t){t=t!=null?t:{};if(Object.getOwnPropertyDescriptors)Object.defineProperties(e,Object.getOwnPropertyDescriptors(t));else{n(Object(t)).forEach(function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))})}return e}},9785:function(e,t,r){"use strict";r.d(t,{_:()=>n});function n(e,t){if(!t)t=e.slice(0);return Object.freeze(Object.defineProperties(e,{raw:{value:Object.freeze(t)}}))}},8978:function(e,t,r){"use strict";r.d(t,{m:()=>o});/* ESM import */var n=r(7484);/* ESM import */var a=r(3160);// src/focusManager.ts
var i=class extends n/* .Subscribable */.Q{#e;#t;#r;constructor(){super();this.#r=e=>{if(!a/* .isServer */.S$&&window.addEventListener){const t=()=>e();window.addEventListener("visibilitychange",t,false);return()=>{window.removeEventListener("visibilitychange",t)}}return}}onSubscribe(){if(!this.#t){this.setEventListener(this.#r)}}onUnsubscribe(){if(!this.hasListeners()){this.#t?.();this.#t=void 0}}setEventListener(e){this.#r=e;this.#t?.();this.#t=e(e=>{if(typeof e==="boolean"){this.setFocused(e)}else{this.onFocus()}})}setFocused(e){const t=this.#e!==e;if(t){this.#e=e;this.onFocus()}}onFocus(){const e=this.isFocused();this.listeners.forEach(t=>{t(e)})}isFocused(){if(typeof this.#e==="boolean"){return this.#e}return globalThis.document?.visibilityState!=="hidden"}};var o=new i;//# sourceMappingURL=focusManager.js.map
},3094:function(e,t,r){"use strict";r.d(t,{$:()=>s,s:()=>o});/* ESM import */var n=r(1629);/* ESM import */var a=r(3908);/* ESM import */var i=r(4992);// src/mutation.ts
var o=class extends a/* .Removable */.k{#n;#a;#i;constructor(e){super();this.mutationId=e.mutationId;this.#a=e.mutationCache;this.#n=[];this.state=e.state||s();this.setOptions(e.options);this.scheduleGc()}setOptions(e){this.options=e;this.updateGcTime(this.options.gcTime)}get meta(){return this.options.meta}addObserver(e){if(!this.#n.includes(e)){this.#n.push(e);this.clearGcTimeout();this.#a.notify({type:"observerAdded",mutation:this,observer:e})}}removeObserver(e){this.#n=this.#n.filter(t=>t!==e);this.scheduleGc();this.#a.notify({type:"observerRemoved",mutation:this,observer:e})}optionalRemove(){if(!this.#n.length){if(this.state.status==="pending"){this.scheduleGc()}else{this.#a.remove(this)}}}continue(){return this.#i?.continue()??// continuing a mutation assumes that variables are set, mutation must have been dehydrated before
this.execute(this.state.variables)}async execute(e){const t=()=>{this.#o({type:"continue"})};this.#i=(0,i/* .createRetryer */.II)({fn:()=>{if(!this.options.mutationFn){return Promise.reject(new Error("No mutationFn found"))}return this.options.mutationFn(e)},onFail:(e,t)=>{this.#o({type:"failed",failureCount:e,error:t})},onPause:()=>{this.#o({type:"pause"})},onContinue:t,retry:this.options.retry??0,retryDelay:this.options.retryDelay,networkMode:this.options.networkMode,canRun:()=>this.#a.canRun(this)});const r=this.state.status==="pending";const n=!this.#i.canStart();try{if(r){t()}else{this.#o({type:"pending",variables:e,isPaused:n});await this.#a.config.onMutate?.(e,this);const t=await this.options.onMutate?.(e);if(t!==this.state.context){this.#o({type:"pending",context:t,variables:e,isPaused:n})}}const a=await this.#i.start();await this.#a.config.onSuccess?.(a,e,this.state.context,this);await this.options.onSuccess?.(a,e,this.state.context);await this.#a.config.onSettled?.(a,null,this.state.variables,this.state.context,this);await this.options.onSettled?.(a,null,e,this.state.context);this.#o({type:"success",data:a});return a}catch(t){try{await this.#a.config.onError?.(t,e,this.state.context,this);await this.options.onError?.(t,e,this.state.context);await this.#a.config.onSettled?.(void 0,t,this.state.variables,this.state.context,this);await this.options.onSettled?.(void 0,t,e,this.state.context);throw t}finally{this.#o({type:"error",error:t})}}finally{this.#a.runNext(this)}}#o(e){const t=t=>{switch(e.type){case"failed":return{...t,failureCount:e.failureCount,failureReason:e.error};case"pause":return{...t,isPaused:true};case"continue":return{...t,isPaused:false};case"pending":return{...t,context:e.context,data:void 0,failureCount:0,failureReason:null,error:null,isPaused:e.isPaused,status:"pending",variables:e.variables,submittedAt:Date.now()};case"success":return{...t,data:e.data,failureCount:0,failureReason:null,error:null,status:"success",isPaused:false};case"error":return{...t,data:void 0,error:e.error,failureCount:t.failureCount+1,failureReason:e.error,isPaused:false,status:"error"}}};this.state=t(this.state);n/* .notifyManager.batch */.jG.batch(()=>{this.#n.forEach(t=>{t.onMutationUpdate(e)});this.#a.notify({mutation:this,type:"updated",action:e})})}};function s(){return{context:void 0,data:void 0,error:null,failureCount:0,failureReason:null,isPaused:false,status:"idle",variables:void 0,submittedAt:0}}//# sourceMappingURL=mutation.js.map
},1629:function(e,t,r){"use strict";r.d(t,{jG:()=>i});// src/notifyManager.ts
var n=e=>setTimeout(e,0);function a(){let e=[];let t=0;let r=e=>{e()};let a=e=>{e()};let i=n;const o=n=>{if(t){e.push(n)}else{i(()=>{r(n)})}};const s=()=>{const t=e;e=[];if(t.length){i(()=>{a(()=>{t.forEach(e=>{r(e)})})})}};return{batch:e=>{let r;t++;try{r=e()}finally{t--;if(!t){s()}}return r},/**
     * All calls to the wrapped function will be batched.
     */batchCalls:e=>{return(...t)=>{o(()=>{e(...t)})}},schedule:o,/**
     * Use this method to set a custom notify function.
     * This can be used to for example wrap notifications with `React.act` while running tests.
     */setNotifyFunction:e=>{r=e},/**
     * Use this method to set a custom function to batch notifications together into a single tick.
     * By default React Query will use the batch function provided by ReactDOM or React Native.
     */setBatchNotifyFunction:e=>{a=e},setScheduler:e=>{i=e}}}var i=a();//# sourceMappingURL=notifyManager.js.map
},8747:function(e,t,r){"use strict";r.d(t,{t:()=>o});/* ESM import */var n=r(7484);/* ESM import */var a=r(3160);// src/onlineManager.ts
var i=class extends n/* .Subscribable */.Q{#s=true;#t;#r;constructor(){super();this.#r=e=>{if(!a/* .isServer */.S$&&window.addEventListener){const t=()=>e(true);const r=()=>e(false);window.addEventListener("online",t,false);window.addEventListener("offline",r,false);return()=>{window.removeEventListener("online",t);window.removeEventListener("offline",r)}}return}}onSubscribe(){if(!this.#t){this.setEventListener(this.#r)}}onUnsubscribe(){if(!this.hasListeners()){this.#t?.();this.#t=void 0}}setEventListener(e){this.#r=e;this.#t?.();this.#t=e(this.setOnline.bind(this))}setOnline(e){const t=this.#s!==e;if(t){this.#s=e;this.listeners.forEach(t=>{t(e)})}}isOnline(){return this.#s}};var o=new i;//# sourceMappingURL=onlineManager.js.map
},1317:function(e,t,r){"use strict";r.d(t,{X:()=>s,k:()=>u});/* ESM import */var n=r(3160);/* ESM import */var a=r(1629);/* ESM import */var i=r(4992);/* ESM import */var o=r(3908);// src/query.ts
var s=class extends o/* .Removable */.k{#u;#l;#c;#f;#i;#d;#h;constructor(e){super();this.#h=false;this.#d=e.defaultOptions;this.setOptions(e.options);this.observers=[];this.#f=e.client;this.#c=this.#f.getQueryCache();this.queryKey=e.queryKey;this.queryHash=e.queryHash;this.#u=l(this.options);this.state=e.state??this.#u;this.scheduleGc()}get meta(){return this.options.meta}get promise(){return this.#i?.promise}setOptions(e){this.options={...this.#d,...e};this.updateGcTime(this.options.gcTime)}optionalRemove(){if(!this.observers.length&&this.state.fetchStatus==="idle"){this.#c.remove(this)}}setData(e,t){const r=(0,n/* .replaceData */.pl)(this.state.data,e,this.options);this.#o({data:r,type:"success",dataUpdatedAt:t?.updatedAt,manual:t?.manual});return r}setState(e,t){this.#o({type:"setState",state:e,setStateOptions:t})}cancel(e){const t=this.#i?.promise;this.#i?.cancel(e);return t?t.then(n/* .noop */.lQ).catch(n/* .noop */.lQ):Promise.resolve()}destroy(){super.destroy();this.cancel({silent:true})}reset(){this.destroy();this.setState(this.#u)}isActive(){return this.observers.some(e=>(0,n/* .resolveEnabled */.Eh)(e.options.enabled,this)!==false)}isDisabled(){if(this.getObserversCount()>0){return!this.isActive()}return this.options.queryFn===n/* .skipToken */.hT||this.state.dataUpdateCount+this.state.errorUpdateCount===0}isStatic(){if(this.getObserversCount()>0){return this.observers.some(e=>(0,n/* .resolveStaleTime */.d2)(e.options.staleTime,this)==="static")}return false}isStale(){if(this.getObserversCount()>0){return this.observers.some(e=>e.getCurrentResult().isStale)}return this.state.data===void 0||this.state.isInvalidated}isStaleByTime(e=0){if(this.state.data===void 0){return true}if(e==="static"){return false}if(this.state.isInvalidated){return true}return!(0,n/* .timeUntilStale */.j3)(this.state.dataUpdatedAt,e)}onFocus(){const e=this.observers.find(e=>e.shouldFetchOnWindowFocus());e?.refetch({cancelRefetch:false});this.#i?.continue()}onOnline(){const e=this.observers.find(e=>e.shouldFetchOnReconnect());e?.refetch({cancelRefetch:false});this.#i?.continue()}addObserver(e){if(!this.observers.includes(e)){this.observers.push(e);this.clearGcTimeout();this.#c.notify({type:"observerAdded",query:this,observer:e})}}removeObserver(e){if(this.observers.includes(e)){this.observers=this.observers.filter(t=>t!==e);if(!this.observers.length){if(this.#i){if(this.#h){this.#i.cancel({revert:true})}else{this.#i.cancelRetry()}}this.scheduleGc()}this.#c.notify({type:"observerRemoved",query:this,observer:e})}}getObserversCount(){return this.observers.length}invalidate(){if(!this.state.isInvalidated){this.#o({type:"invalidate"})}}fetch(e,t){if(this.state.fetchStatus!=="idle"){if(this.state.data!==void 0&&t?.cancelRefetch){this.cancel({silent:true})}else if(this.#i){this.#i.continueRetry();return this.#i.promise}}if(e){this.setOptions(e)}if(!this.options.queryFn){const e=this.observers.find(e=>e.options.queryFn);if(e){this.setOptions(e.options)}}if(false){}const r=new AbortController;const a=e=>{Object.defineProperty(e,"signal",{enumerable:true,get:()=>{this.#h=true;return r.signal}})};const o=()=>{const e=(0,n/* .ensureQueryFn */.ZM)(this.options,t);const r=()=>{const e={client:this.#f,queryKey:this.queryKey,meta:this.meta};a(e);return e};const i=r();this.#h=false;if(this.options.persister){return this.options.persister(e,i,this)}return e(i)};const s=()=>{const e={fetchOptions:t,options:this.options,queryKey:this.queryKey,client:this.#f,state:this.state,fetchFn:o};a(e);return e};const u=s();this.options.behavior?.onFetch(u,this);this.#l=this.state;if(this.state.fetchStatus==="idle"||this.state.fetchMeta!==u.fetchOptions?.meta){this.#o({type:"fetch",meta:u.fetchOptions?.meta})}const l=e=>{if(!((0,i/* .isCancelledError */.wm)(e)&&e.silent)){this.#o({type:"error",error:e})}if(!(0,i/* .isCancelledError */.wm)(e)){this.#c.config.onError?.(e,this);this.#c.config.onSettled?.(this.state.data,e,this)}this.scheduleGc()};this.#i=(0,i/* .createRetryer */.II)({initialPromise:t?.initialPromise,fn:u.fetchFn,abort:r.abort.bind(r),onSuccess:e=>{if(e===void 0){if(false){}l(new Error(`${this.queryHash} data is undefined`));return}try{this.setData(e)}catch(e){l(e);return}this.#c.config.onSuccess?.(e,this);this.#c.config.onSettled?.(e,this.state.error,this);this.scheduleGc()},onError:l,onFail:(e,t)=>{this.#o({type:"failed",failureCount:e,error:t})},onPause:()=>{this.#o({type:"pause"})},onContinue:()=>{this.#o({type:"continue"})},retry:u.options.retry,retryDelay:u.options.retryDelay,networkMode:u.options.networkMode,canRun:()=>true});return this.#i.start()}#o(e){const t=t=>{switch(e.type){case"failed":return{...t,fetchFailureCount:e.failureCount,fetchFailureReason:e.error};case"pause":return{...t,fetchStatus:"paused"};case"continue":return{...t,fetchStatus:"fetching"};case"fetch":return{...t,...u(t.data,this.options),fetchMeta:e.meta??null};case"success":this.#l=void 0;return{...t,data:e.data,dataUpdateCount:t.dataUpdateCount+1,dataUpdatedAt:e.dataUpdatedAt??Date.now(),error:null,isInvalidated:false,status:"success",...!e.manual&&{fetchStatus:"idle",fetchFailureCount:0,fetchFailureReason:null}};case"error":const r=e.error;if((0,i/* .isCancelledError */.wm)(r)&&r.revert&&this.#l){return{...this.#l,fetchStatus:"idle"}}return{...t,error:r,errorUpdateCount:t.errorUpdateCount+1,errorUpdatedAt:Date.now(),fetchFailureCount:t.fetchFailureCount+1,fetchFailureReason:r,fetchStatus:"idle",status:"error"};case"invalidate":return{...t,isInvalidated:true};case"setState":return{...t,...e.state}}};this.state=t(this.state);a/* .notifyManager.batch */.jG.batch(()=>{this.observers.forEach(e=>{e.onQueryUpdate()});this.#c.notify({query:this,type:"updated",action:e})})}};function u(e,t){return{fetchFailureCount:0,fetchFailureReason:null,fetchStatus:(0,i/* .canFetch */.v_)(t.networkMode)?"fetching":"paused",...e===void 0&&{error:null,status:"pending"}}}function l(e){const t=typeof e.initialData==="function"?e.initialData():e.initialData;const r=t!==void 0;const n=r?typeof e.initialDataUpdatedAt==="function"?e.initialDataUpdatedAt():e.initialDataUpdatedAt:0;return{data:t,dataUpdateCount:0,dataUpdatedAt:r?n??Date.now():0,error:null,errorUpdateCount:0,errorUpdatedAt:0,fetchFailureCount:0,fetchFailureReason:null,fetchMeta:null,isInvalidated:false,status:r?"success":"pending",fetchStatus:"idle"}}//# sourceMappingURL=query.js.map
},3908:function(e,t,r){"use strict";r.d(t,{k:()=>a});/* ESM import */var n=r(3160);// src/removable.ts
var a=class{#p;destroy(){this.clearGcTimeout()}scheduleGc(){this.clearGcTimeout();if((0,n/* .isValidTimeout */.gn)(this.gcTime)){this.#p=setTimeout(()=>{this.optionalRemove()},this.gcTime)}}updateGcTime(e){this.gcTime=Math.max(this.gcTime||0,e??(n/* .isServer */.S$?Infinity:5*60*1e3))}clearGcTimeout(){if(this.#p){clearTimeout(this.#p);this.#p=void 0}}};//# sourceMappingURL=removable.js.map
},4992:function(e,t,r){"use strict";r.d(t,{II:()=>f,v_:()=>u,wm:()=>c});/* ESM import */var n=r(8978);/* ESM import */var a=r(8747);/* ESM import */var i=r(8410);/* ESM import */var o=r(3160);// src/retryer.ts
function s(e){return Math.min(1e3*2**e,3e4)}function u(e){return(e??"online")==="online"?a/* .onlineManager.isOnline */.t.isOnline():true}var l=class extends Error{constructor(e){super("CancelledError");this.revert=e?.revert;this.silent=e?.silent}};function c(e){return e instanceof l}function f(e){let t=false;let r=0;let c=false;let f;const d=(0,i/* .pendingThenable */.T)();const h=t=>{if(!c){y(new l(t));e.abort?.()}};const p=()=>{t=true};const v=()=>{t=false};const m=()=>n/* .focusManager.isFocused */.m.isFocused()&&(e.networkMode==="always"||a/* .onlineManager.isOnline */.t.isOnline())&&e.canRun();const g=()=>u(e.networkMode)&&e.canRun();const b=t=>{if(!c){c=true;e.onSuccess?.(t);f?.();d.resolve(t)}};const y=t=>{if(!c){c=true;e.onError?.(t);f?.();d.reject(t)}};const w=()=>{return new Promise(t=>{f=e=>{if(c||m()){t(e)}};e.onPause?.()}).then(()=>{f=void 0;if(!c){e.onContinue?.()}})};const _=()=>{if(c){return}let n;const a=r===0?e.initialPromise:void 0;try{n=a??e.fn()}catch(e){n=Promise.reject(e)}Promise.resolve(n).then(b).catch(n=>{if(c){return}const a=e.retry??(o/* .isServer */.S$?0:3);const i=e.retryDelay??s;const u=typeof i==="function"?i(r,n):i;const l=a===true||typeof a==="number"&&r<a||typeof a==="function"&&a(r,n);if(t||!l){y(n);return}r++;e.onFail?.(r,n);(0,o/* .sleep */.yy)(u).then(()=>{return m()?void 0:w()}).then(()=>{if(t){y(n)}else{_()}})})};return{promise:d,cancel:h,continue:()=>{f?.();return d},cancelRetry:p,continueRetry:v,canStart:g,start:()=>{if(g()){_()}else{w().then(_)}return d}}}//# sourceMappingURL=retryer.js.map
},7484:function(e,t,r){"use strict";r.d(t,{Q:()=>n});// src/subscribable.ts
var n=class{constructor(){this.listeners=/* @__PURE__ */new Set;this.subscribe=this.subscribe.bind(this)}subscribe(e){this.listeners.add(e);this.onSubscribe();return()=>{this.listeners.delete(e);this.onUnsubscribe()}}hasListeners(){return this.listeners.size>0}onSubscribe(){}onUnsubscribe(){}};//# sourceMappingURL=subscribable.js.map
},8410:function(e,t,r){"use strict";r.d(t,{T:()=>n});// src/thenable.ts
function n(){let e;let t;const r=new Promise((r,n)=>{e=r;t=n});r.status="pending";r.catch(()=>{});function n(e){Object.assign(r,e);delete r.resolve;delete r.reject}r.resolve=t=>{n({status:"fulfilled",value:t});e(t)};r.reject=e=>{n({status:"rejected",reason:e});t(e)};return r}function a(e){let t;e.then(e=>{t=e;return e},noop)?.catch(noop);if(t!==void 0){return{data:t}}return void 0}//# sourceMappingURL=thenable.js.map
},3160:function(e,t,r){"use strict";r.d(t,{Cp:()=>p,EN:()=>h,Eh:()=>l,F$:()=>d,GU:()=>T,MK:()=>c,S$:()=>n,ZM:()=>A,ZZ:()=>O,Zw:()=>i,d2:()=>u,f8:()=>m,gn:()=>o,hT:()=>S,j3:()=>s,lQ:()=>a,nJ:()=>f,pl:()=>_,rX:()=>x,y9:()=>E,yy:()=>w});// src/utils.ts
var n=typeof window==="undefined"||"Deno"in globalThis;function a(){}function i(e,t){return typeof e==="function"?e(t):e}function o(e){return typeof e==="number"&&e>=0&&e!==Infinity}function s(e,t){return Math.max(e+(t||0)-Date.now(),0)}function u(e,t){return typeof e==="function"?e(t):e}function l(e,t){return typeof e==="function"?e(t):e}function c(e,t){const{type:r="all",exact:n,fetchStatus:a,predicate:i,queryKey:o,stale:s}=e;if(o){if(n){if(t.queryHash!==d(o,t.options)){return false}}else if(!p(t.queryKey,o)){return false}}if(r!=="all"){const e=t.isActive();if(r==="active"&&!e){return false}if(r==="inactive"&&e){return false}}if(typeof s==="boolean"&&t.isStale()!==s){return false}if(a&&a!==t.state.fetchStatus){return false}if(i&&!i(t)){return false}return true}function f(e,t){const{exact:r,status:n,predicate:a,mutationKey:i}=e;if(i){if(!t.options.mutationKey){return false}if(r){if(h(t.options.mutationKey)!==h(i)){return false}}else if(!p(t.options.mutationKey,i)){return false}}if(n&&t.state.status!==n){return false}if(a&&!a(t)){return false}return true}function d(e,t){const r=t?.queryKeyHashFn||h;return r(e)}function h(e){return JSON.stringify(e,(e,t)=>b(t)?Object.keys(t).sort().reduce((e,r)=>{e[r]=t[r];return e},{}):t)}function p(e,t){if(e===t){return true}if(typeof e!==typeof t){return false}if(e&&t&&typeof e==="object"&&typeof t==="object"){return Object.keys(t).every(r=>p(e[r],t[r]))}return false}function v(e,t){if(e===t){return e}const r=g(e)&&g(t);if(r||b(e)&&b(t)){const n=r?e:Object.keys(e);const a=n.length;const i=r?t:Object.keys(t);const o=i.length;const s=r?[]:{};const u=new Set(n);let l=0;for(let n=0;n<o;n++){const a=r?n:i[n];if((!r&&u.has(a)||r)&&e[a]===void 0&&t[a]===void 0){s[a]=void 0;l++}else{s[a]=v(e[a],t[a]);if(s[a]===e[a]&&e[a]!==void 0){l++}}}return a===o&&l===a?e:s}return t}function m(e,t){if(!t||Object.keys(e).length!==Object.keys(t).length){return false}for(const r in e){if(e[r]!==t[r]){return false}}return true}function g(e){return Array.isArray(e)&&e.length===Object.keys(e).length}function b(e){if(!y(e)){return false}const t=e.constructor;if(t===void 0){return true}const r=t.prototype;if(!y(r)){return false}if(!r.hasOwnProperty("isPrototypeOf")){return false}if(Object.getPrototypeOf(e)!==Object.prototype){return false}return true}function y(e){return Object.prototype.toString.call(e)==="[object Object]"}function w(e){return new Promise(t=>{setTimeout(t,e)})}function _(e,t,r){if(typeof r.structuralSharing==="function"){return r.structuralSharing(e,t)}else if(r.structuralSharing!==false){if(false){}return v(e,t)}return t}function x(e){return e}function E(e,t,r=0){const n=[...e,t];return r&&n.length>r?n.slice(1):n}function O(e,t,r=0){const n=[t,...e];return r&&n.length>r?n.slice(0,-1):n}var S=Symbol();function A(e,t){if(false){}if(!e.queryFn&&t?.initialPromise){return()=>t.initialPromise}if(!e.queryFn||e.queryFn===S){return()=>Promise.reject(new Error(`Missing queryFn: '${e.queryHash}'`))}return e.queryFn}function T(e,t){if(typeof e==="function"){return e(...t)}return!!e}//# sourceMappingURL=utils.js.map
},241:function(e,t,r){"use strict";r.d(t,{Ht:()=>s,jE:()=>o});/* ESM import */var n=r(1594);/* ESM import */var a=r(4848);"use client";// src/QueryClientProvider.tsx
var i=n.createContext(void 0);var o=e=>{const t=n.useContext(i);if(e){return e}if(!t){throw new Error("No QueryClient set, use QueryClientProvider to set one")}return t};var s=({client:e,children:t})=>{n.useEffect(()=>{e.mount();return()=>{e.unmount()}},[e]);return/* @__PURE__ */(0,a.jsx)(i.Provider,{value:e,children:t})};//# sourceMappingURL=QueryClientProvider.js.map
},8856:function(e,t,r){"use strict";// EXPORTS
r.d(t,{n:()=>/* binding */c});// EXTERNAL MODULE: external "React"
var n=r(1594);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/mutation.js
var a=r(3094);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/notifyManager.js
var i=r(1629);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/subscribable.js
var o=r(7484);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/utils.js
var s=r(3160);// CONCATENATED MODULE: ./node_modules/@tanstack/query-core/build/modern/mutationObserver.js
// src/mutationObserver.ts
var u=class extends o/* .Subscribable */.Q{#f;#v=void 0;#m;#g;constructor(e,t){super();this.#f=e;this.setOptions(t);this.bindMethods();this.#b()}bindMethods(){this.mutate=this.mutate.bind(this);this.reset=this.reset.bind(this)}setOptions(e){const t=this.options;this.options=this.#f.defaultMutationOptions(e);if(!(0,s/* .shallowEqualObjects */.f8)(this.options,t)){this.#f.getMutationCache().notify({type:"observerOptionsUpdated",mutation:this.#m,observer:this})}if(t?.mutationKey&&this.options.mutationKey&&(0,s/* .hashKey */.EN)(t.mutationKey)!==(0,s/* .hashKey */.EN)(this.options.mutationKey)){this.reset()}else if(this.#m?.state.status==="pending"){this.#m.setOptions(this.options)}}onUnsubscribe(){if(!this.hasListeners()){this.#m?.removeObserver(this)}}onMutationUpdate(e){this.#b();this.#y(e)}getCurrentResult(){return this.#v}reset(){this.#m?.removeObserver(this);this.#m=void 0;this.#b();this.#y()}mutate(e,t){this.#g=t;this.#m?.removeObserver(this);this.#m=this.#f.getMutationCache().build(this.#f,this.options);this.#m.addObserver(this);return this.#m.execute(e)}#b(){const e=this.#m?.state??(0,a/* .getDefaultState */.$)();this.#v={...e,isPending:e.status==="pending",isSuccess:e.status==="success",isError:e.status==="error",isIdle:e.status==="idle",mutate:this.mutate,reset:this.reset}}#y(e){i/* .notifyManager.batch */.jG.batch(()=>{if(this.#g&&this.hasListeners()){const t=this.#v.variables;const r=this.#v.context;if(e?.type==="success"){this.#g.onSuccess?.(e.data,t,r);this.#g.onSettled?.(e.data,null,t,r)}else if(e?.type==="error"){this.#g.onError?.(e.error,t,r);this.#g.onSettled?.(void 0,e.error,t,r)}}this.listeners.forEach(e=>{e(this.#v)})})}};//# sourceMappingURL=mutationObserver.js.map
// EXTERNAL MODULE: ./node_modules/@tanstack/react-query/build/legacy/QueryClientProvider.js
var l=r(241);// CONCATENATED MODULE: ./node_modules/@tanstack/react-query/build/legacy/useMutation.js
"use client";// src/useMutation.ts
function c(e,t){const r=(0,l/* .useQueryClient */.jE)(t);const[a]=n.useState(()=>new u(r,e));n.useEffect(()=>{a.setOptions(e)},[a,e]);const o=n.useSyncExternalStore(n.useCallback(e=>a.subscribe(i/* .notifyManager.batchCalls */.jG.batchCalls(e)),[a]),()=>a.getCurrentResult(),()=>a.getCurrentResult());const c=n.useCallback((e,t)=>{a.mutate(e,t).catch(s/* .noop */.lQ)},[a]);if(o.error&&(0,s/* .shouldThrowError */.GU)(a.options.throwOnError,[o.error])){throw o.error}return{...o,mutate:c,mutateAsync:o.mutate}}//# sourceMappingURL=useMutation.js.map
},7359:function(e,t,r){"use strict";// EXPORTS
r.d(t,{I:()=>/* binding */F});// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/focusManager.js
var n=r(8978);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/notifyManager.js
var a=r(1629);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/query.js
var i=r(1317);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/subscribable.js
var o=r(7484);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/thenable.js
var s=r(8410);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/utils.js
var u=r(3160);// CONCATENATED MODULE: ./node_modules/@tanstack/query-core/build/modern/queryObserver.js
// src/queryObserver.ts
var l=class extends o/* .Subscribable */.Q{constructor(e,t){super();this.options=t;this.#f=e;this.#w=null;this.#_=(0,s/* .pendingThenable */.T)();if(!this.options.experimental_prefetchInRender){this.#_.reject(new Error("experimental_prefetchInRender feature flag is not enabled"))}this.bindMethods();this.setOptions(t)}#f;#x=void 0;#E=void 0;#v=void 0;#O;#S;#_;#w;#A;#T;// This property keeps track of the last query with defined data.
// It will be used to pass the previous data and query to the placeholder function between renders.
#k;#R;#C;#P;#I=/* @__PURE__ */new Set;bindMethods(){this.refetch=this.refetch.bind(this)}onSubscribe(){if(this.listeners.size===1){this.#x.addObserver(this);if(f(this.#x,this.options)){this.#D()}else{this.updateResult()}this.#M()}}onUnsubscribe(){if(!this.hasListeners()){this.destroy()}}shouldFetchOnReconnect(){return d(this.#x,this.options,this.options.refetchOnReconnect)}shouldFetchOnWindowFocus(){return d(this.#x,this.options,this.options.refetchOnWindowFocus)}destroy(){this.listeners=/* @__PURE__ */new Set;this.#F();this.#L();this.#x.removeObserver(this)}setOptions(e){const t=this.options;const r=this.#x;this.options=this.#f.defaultQueryOptions(e);if(this.options.enabled!==void 0&&typeof this.options.enabled!=="boolean"&&typeof this.options.enabled!=="function"&&typeof(0,u/* .resolveEnabled */.Eh)(this.options.enabled,this.#x)!=="boolean"){throw new Error("Expected enabled to be a boolean or a callback that returns a boolean")}this.#N();this.#x.setOptions(this.options);if(t._defaulted&&!(0,u/* .shallowEqualObjects */.f8)(this.options,t)){this.#f.getQueryCache().notify({type:"observerOptionsUpdated",query:this.#x,observer:this})}const n=this.hasListeners();if(n&&h(this.#x,r,this.options,t)){this.#D()}this.updateResult();if(n&&(this.#x!==r||(0,u/* .resolveEnabled */.Eh)(this.options.enabled,this.#x)!==(0,u/* .resolveEnabled */.Eh)(t.enabled,this.#x)||(0,u/* .resolveStaleTime */.d2)(this.options.staleTime,this.#x)!==(0,u/* .resolveStaleTime */.d2)(t.staleTime,this.#x))){this.#j()}const a=this.#U();if(n&&(this.#x!==r||(0,u/* .resolveEnabled */.Eh)(this.options.enabled,this.#x)!==(0,u/* .resolveEnabled */.Eh)(t.enabled,this.#x)||a!==this.#P)){this.#H(a)}}getOptimisticResult(e){const t=this.#f.getQueryCache().build(this.#f,e);const r=this.createResult(t,e);if(v(this,r)){this.#v=r;this.#S=this.options;this.#O=this.#x.state}return r}getCurrentResult(){return this.#v}trackResult(e,t){return new Proxy(e,{get:(e,r)=>{this.trackProp(r);t?.(r);return Reflect.get(e,r)}})}trackProp(e){this.#I.add(e)}getCurrentQuery(){return this.#x}refetch({...e}={}){return this.fetch({...e})}fetchOptimistic(e){const t=this.#f.defaultQueryOptions(e);const r=this.#f.getQueryCache().build(this.#f,t);return r.fetch().then(()=>this.createResult(r,t))}fetch(e){return this.#D({...e,cancelRefetch:e.cancelRefetch??true}).then(()=>{this.updateResult();return this.#v})}#D(e){this.#N();let t=this.#x.fetch(this.options,e);if(!e?.throwOnError){t=t.catch(u/* .noop */.lQ)}return t}#j(){this.#F();const e=(0,u/* .resolveStaleTime */.d2)(this.options.staleTime,this.#x);if(u/* .isServer */.S$||this.#v.isStale||!(0,u/* .isValidTimeout */.gn)(e)){return}const t=(0,u/* .timeUntilStale */.j3)(this.#v.dataUpdatedAt,e);const r=t+1;this.#R=setTimeout(()=>{if(!this.#v.isStale){this.updateResult()}},r)}#U(){return(typeof this.options.refetchInterval==="function"?this.options.refetchInterval(this.#x):this.options.refetchInterval)??false}#H(e){this.#L();this.#P=e;if(u/* .isServer */.S$||(0,u/* .resolveEnabled */.Eh)(this.options.enabled,this.#x)===false||!(0,u/* .isValidTimeout */.gn)(this.#P)||this.#P===0){return}this.#C=setInterval(()=>{if(this.options.refetchIntervalInBackground||n/* .focusManager.isFocused */.m.isFocused()){this.#D()}},this.#P)}#M(){this.#j();this.#H(this.#U())}#F(){if(this.#R){clearTimeout(this.#R);this.#R=void 0}}#L(){if(this.#C){clearInterval(this.#C);this.#C=void 0}}createResult(e,t){const r=this.#x;const n=this.options;const a=this.#v;const o=this.#O;const l=this.#S;const c=e!==r;const d=c?e.state:this.#E;const{state:v}=e;let m={...v};let g=false;let b;if(t._optimisticResults){const a=this.hasListeners();const o=!a&&f(e,t);const s=a&&h(e,r,t,n);if(o||s){m={...m,...(0,i/* .fetchState */.k)(v.data,e.options)}}if(t._optimisticResults==="isRestoring"){m.fetchStatus="idle"}}let{error:y,errorUpdatedAt:w,status:_}=m;b=m.data;let x=false;if(t.placeholderData!==void 0&&b===void 0&&_==="pending"){let e;if(a?.isPlaceholderData&&t.placeholderData===l?.placeholderData){e=a.data;x=true}else{e=typeof t.placeholderData==="function"?t.placeholderData(this.#k?.state.data,this.#k):t.placeholderData}if(e!==void 0){_="success";b=(0,u/* .replaceData */.pl)(a?.data,e,t);g=true}}if(t.select&&b!==void 0&&!x){if(a&&b===o?.data&&t.select===this.#A){b=this.#T}else{try{this.#A=t.select;b=t.select(b);b=(0,u/* .replaceData */.pl)(a?.data,b,t);this.#T=b;this.#w=null}catch(e){this.#w=e}}}if(this.#w){y=this.#w;b=this.#T;w=Date.now();_="error"}const E=m.fetchStatus==="fetching";const O=_==="pending";const S=_==="error";const A=O&&E;const T=b!==void 0;const k={status:_,fetchStatus:m.fetchStatus,isPending:O,isSuccess:_==="success",isError:S,isInitialLoading:A,isLoading:A,data:b,dataUpdatedAt:m.dataUpdatedAt,error:y,errorUpdatedAt:w,failureCount:m.fetchFailureCount,failureReason:m.fetchFailureReason,errorUpdateCount:m.errorUpdateCount,isFetched:m.dataUpdateCount>0||m.errorUpdateCount>0,isFetchedAfterMount:m.dataUpdateCount>d.dataUpdateCount||m.errorUpdateCount>d.errorUpdateCount,isFetching:E,isRefetching:E&&!O,isLoadingError:S&&!T,isPaused:m.fetchStatus==="paused",isPlaceholderData:g,isRefetchError:S&&T,isStale:p(e,t),refetch:this.refetch,promise:this.#_,isEnabled:(0,u/* .resolveEnabled */.Eh)(t.enabled,e)!==false};const R=k;if(this.options.experimental_prefetchInRender){const t=e=>{if(R.status==="error"){e.reject(R.error)}else if(R.data!==void 0){e.resolve(R.data)}};const n=()=>{const e=this.#_=R.promise=(0,s/* .pendingThenable */.T)();t(e)};const a=this.#_;switch(a.status){case"pending":if(e.queryHash===r.queryHash){t(a)}break;case"fulfilled":if(R.status==="error"||R.data!==a.value){n()}break;case"rejected":if(R.status!=="error"||R.error!==a.reason){n()}break}}return R}updateResult(){const e=this.#v;const t=this.createResult(this.#x,this.options);this.#O=this.#x.state;this.#S=this.options;if(this.#O.data!==void 0){this.#k=this.#x}if((0,u/* .shallowEqualObjects */.f8)(t,e)){return}this.#v=t;const r=()=>{if(!e){return true}const{notifyOnChangeProps:t}=this.options;const r=typeof t==="function"?t():t;if(r==="all"||!r&&!this.#I.size){return true}const n=new Set(r??this.#I);if(this.options.throwOnError){n.add("error")}return Object.keys(this.#v).some(t=>{const r=t;const a=this.#v[r]!==e[r];return a&&n.has(r)})};this.#y({listeners:r()})}#N(){const e=this.#f.getQueryCache().build(this.#f,this.options);if(e===this.#x){return}const t=this.#x;this.#x=e;this.#E=e.state;if(this.hasListeners()){t?.removeObserver(this);e.addObserver(this)}}onQueryUpdate(){this.updateResult();if(this.hasListeners()){this.#M()}}#y(e){a/* .notifyManager.batch */.jG.batch(()=>{if(e.listeners){this.listeners.forEach(e=>{e(this.#v)})}this.#f.getQueryCache().notify({query:this.#x,type:"observerResultsUpdated"})})}};function c(e,t){return(0,u/* .resolveEnabled */.Eh)(t.enabled,e)!==false&&e.state.data===void 0&&!(e.state.status==="error"&&t.retryOnMount===false)}function f(e,t){return c(e,t)||e.state.data!==void 0&&d(e,t,t.refetchOnMount)}function d(e,t,r){if((0,u/* .resolveEnabled */.Eh)(t.enabled,e)!==false&&(0,u/* .resolveStaleTime */.d2)(t.staleTime,e)!=="static"){const n=typeof r==="function"?r(e):r;return n==="always"||n!==false&&p(e,t)}return false}function h(e,t,r,n){return(e!==t||(0,u/* .resolveEnabled */.Eh)(n.enabled,e)===false)&&(!r.suspense||e.state.status!=="error")&&p(e,r)}function p(e,t){return(0,u/* .resolveEnabled */.Eh)(t.enabled,e)!==false&&e.isStaleByTime((0,u/* .resolveStaleTime */.d2)(t.staleTime,e))}function v(e,t){if(!(0,u/* .shallowEqualObjects */.f8)(e.getCurrentResult(),t)){return true}return false}//# sourceMappingURL=queryObserver.js.map
// EXTERNAL MODULE: external "React"
var m=r(1594);// EXTERNAL MODULE: ./node_modules/@tanstack/react-query/build/legacy/QueryClientProvider.js
var g=r(241);// EXTERNAL MODULE: ./node_modules/react/jsx-runtime.js
var b=r(4848);// CONCATENATED MODULE: ./node_modules/@tanstack/react-query/build/legacy/QueryErrorResetBoundary.js
"use client";// src/QueryErrorResetBoundary.tsx
function y(){let e=false;return{clearReset:()=>{e=false},reset:()=>{e=true},isReset:()=>{return e}}}var w=m.createContext(y());var _=()=>m.useContext(w);var x=({children:e})=>{const[t]=React.useState(()=>y());return /* @__PURE__ */jsx(w.Provider,{value:t,children:typeof e==="function"?e(t):e})};//# sourceMappingURL=QueryErrorResetBoundary.js.map
;// CONCATENATED MODULE: ./node_modules/@tanstack/react-query/build/legacy/errorBoundaryUtils.js
"use client";// src/errorBoundaryUtils.ts
var E=(e,t)=>{if(e.suspense||e.throwOnError||e.experimental_prefetchInRender){if(!t.isReset()){e.retryOnMount=false}}};var O=e=>{m.useEffect(()=>{e.clearReset()},[e])};var S=({result:e,errorResetBoundary:t,throwOnError:r,query:n,suspense:a})=>{return e.isError&&!t.isReset()&&!e.isFetching&&n&&(a&&e.data===void 0||(0,u/* .shouldThrowError */.GU)(r,[e.error,n]))};//# sourceMappingURL=errorBoundaryUtils.js.map
;// CONCATENATED MODULE: ./node_modules/@tanstack/react-query/build/legacy/IsRestoringProvider.js
"use client";// src/IsRestoringProvider.ts
var A=m.createContext(false);var T=()=>m.useContext(A);var k=A.Provider;//# sourceMappingURL=IsRestoringProvider.js.map
;// CONCATENATED MODULE: ./node_modules/@tanstack/react-query/build/legacy/suspense.js
// src/suspense.ts
var R=(e,t)=>t.state.data===void 0;var C=e=>{if(e.suspense){const t=e=>e==="static"?e:Math.max(e??1e3,1e3);const r=e.staleTime;e.staleTime=typeof r==="function"?(...e)=>t(r(...e)):t(r);if(typeof e.gcTime==="number"){e.gcTime=Math.max(e.gcTime,1e3)}}};var P=(e,t)=>e.isLoading&&e.isFetching&&!t;var I=(e,t)=>(e==null?void 0:e.suspense)&&t.isPending;var D=(e,t,r)=>t.fetchOptimistic(e).catch(()=>{r.clearReset()});//# sourceMappingURL=suspense.js.map
;// CONCATENATED MODULE: ./node_modules/@tanstack/react-query/build/legacy/useBaseQuery.js
"use client";// src/useBaseQuery.ts
function M(e,t,r){var n,i,o,s,l;if(false){}const c=T();const f=_();const d=(0,g/* .useQueryClient */.jE)(r);const h=d.defaultQueryOptions(e);(i=(n=d.getDefaultOptions().queries)==null?void 0:n._experimental_beforeQuery)==null?void 0:i.call(n,h);if(false){}h._optimisticResults=c?"isRestoring":"optimistic";C(h);E(h,f);O(f);const p=!d.getQueryCache().get(h.queryHash);const[v]=m.useState(()=>new t(d,h));const b=v.getOptimisticResult(h);const y=!c&&e.subscribed!==false;m.useSyncExternalStore(m.useCallback(e=>{const t=y?v.subscribe(a/* .notifyManager.batchCalls */.jG.batchCalls(e)):u/* .noop */.lQ;v.updateResult();return t},[v,y]),()=>v.getCurrentResult(),()=>v.getCurrentResult());m.useEffect(()=>{v.setOptions(h)},[h,v]);if(I(h,b)){throw D(h,v,f)}if(S({result:b,errorResetBoundary:f,throwOnError:h.throwOnError,query:d.getQueryCache().get(h.queryHash),suspense:h.suspense})){throw b.error};(s=(o=d.getDefaultOptions().queries)==null?void 0:o._experimental_afterQuery)==null?void 0:s.call(o,h,b);if(h.experimental_prefetchInRender&&!u/* .isServer */.S$&&P(b,c)){const e=p?// Fetch immediately on render in order to ensure `.promise` is resolved even if the component is unmounted
D(h,v,f):// subscribe to the "cache promise" so that we can finalize the currentThenable once data comes in
(l=d.getQueryCache().get(h.queryHash))==null?void 0:l.promise;e==null?void 0:e.catch(u/* .noop */.lQ).finally(()=>{v.updateResult()})}return!h.notifyOnChangeProps?v.trackResult(b):b}//# sourceMappingURL=useBaseQuery.js.map
;// CONCATENATED MODULE: ./node_modules/@tanstack/react-query/build/legacy/useQuery.js
"use client";// src/useQuery.ts
function F(e,t){return M(e,l,t)}//# sourceMappingURL=useQuery.js.map
},7669:function(e,t,r){"use strict";r.d(t,{Cg:()=>l,_P:()=>A,my:()=>s,s0:()=>c,w4:()=>u});/**
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
 */const n=7;/**
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
 */const a=365.2425;/**
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
 */const i=Math.pow(10,8)*24*60*60*1e3;/**
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
 */const o=/* unused pure expression or super */null&&-i;/**
 * @constant
 * @name millisecondsInWeek
 * @summary Milliseconds in 1 week.
 */const s=6048e5;/**
 * @constant
 * @name millisecondsInDay
 * @summary Milliseconds in 1 day.
 */const u=864e5;/**
 * @constant
 * @name millisecondsInMinute
 * @summary Milliseconds in 1 minute
 */const l=6e4;/**
 * @constant
 * @name millisecondsInHour
 * @summary Milliseconds in 1 hour
 */const c=36e5;/**
 * @constant
 * @name millisecondsInSecond
 * @summary Milliseconds in 1 second
 */const f=1e3;/**
 * @constant
 * @name minutesInYear
 * @summary Minutes in 1 year.
 */const d=525600;/**
 * @constant
 * @name minutesInMonth
 * @summary Minutes in 1 month.
 */const h=43200;/**
 * @constant
 * @name minutesInDay
 * @summary Minutes in 1 day.
 */const p=1440;/**
 * @constant
 * @name minutesInHour
 * @summary Minutes in 1 hour.
 */const v=60;/**
 * @constant
 * @name monthsInQuarter
 * @summary Months in 1 quarter.
 */const m=3;/**
 * @constant
 * @name monthsInYear
 * @summary Months in 1 year.
 */const g=12;/**
 * @constant
 * @name quartersInYear
 * @summary Quarters in 1 year
 */const b=4;/**
 * @constant
 * @name secondsInHour
 * @summary Seconds in 1 hour.
 */const y=3600;/**
 * @constant
 * @name secondsInMinute
 * @summary Seconds in 1 minute.
 */const w=60;/**
 * @constant
 * @name secondsInDay
 * @summary Seconds in 1 day.
 */const _=/* unused pure expression or super */null&&y*24;/**
 * @constant
 * @name secondsInWeek
 * @summary Seconds in 1 week.
 */const x=/* unused pure expression or super */null&&_*7;/**
 * @constant
 * @name secondsInYear
 * @summary Seconds in 1 year.
 */const E=/* unused pure expression or super */null&&_*a;/**
 * @constant
 * @name secondsInMonth
 * @summary Seconds in 1 month
 */const O=/* unused pure expression or super */null&&E/12;/**
 * @constant
 * @name secondsInQuarter
 * @summary Seconds in 1 quarter.
 */const S=/* unused pure expression or super */null&&O*3;/**
 * @constant
 * @name constructFromSymbol
 * @summary Symbol enabling Date extensions to inherit properties from the reference date.
 *
 * The symbol is used to enable the `constructFrom` function to construct a date
 * using a reference date and a value. It allows to transfer extra properties
 * from the reference date to the new date. It's useful for extensions like
 * [`TZDate`](https://github.com/date-fns/tz) that accept a time zone as
 * a constructor argument.
 */const A=Symbol.for("constructDateFrom")},3753:function(e,t,r){"use strict";r.d(t,{w:()=>a});/* ESM import */var n=r(7669);/**
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
 */function a(e,t){if(typeof e==="function")return e(t);if(e&&typeof e==="object"&&n/* .constructFromSymbol */._P in e)return e[n/* .constructFromSymbol */._P](t);if(e instanceof Date)return new e.constructor(t);return new Date(t)}// Fallback for modularized imports:
/* unused ESM default export */var i=/* unused pure expression or super */null&&a},1181:function(e,t,r){"use strict";// EXPORTS
r.d(t,{GP:()=>/* binding */eB});// UNUSED EXPORTS: default, longFormatters, formatDate, formatters
;// CONCATENATED MODULE: ./node_modules/date-fns/locale/en-US/_lib/formatDistance.js
const n={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXWeeks:{one:"about 1 week",other:"about {{count}} weeks"},xWeeks:{one:"1 week",other:"{{count}} weeks"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}};const a=(e,t,r)=>{let a;const i=n[e];if(typeof i==="string"){a=i}else if(t===1){a=i.one}else{a=i.other.replace("{{count}}",t.toString())}if(r?.addSuffix){if(r.comparison&&r.comparison>0){return"in "+a}else{return a+" ago"}}return a};// CONCATENATED MODULE: ./node_modules/date-fns/locale/_lib/buildFormatLongFn.js
function i(e){return (t={})=>{// TODO: Remove String()
const r=t.width?String(t.width):e.defaultWidth;const n=e.formats[r]||e.formats[e.defaultWidth];return n}};// CONCATENATED MODULE: ./node_modules/date-fns/locale/en-US/_lib/formatLong.js
const o={full:"EEEE, MMMM do, y",long:"MMMM do, y",medium:"MMM d, y",short:"MM/dd/yyyy"};const s={full:"h:mm:ss a zzzz",long:"h:mm:ss a z",medium:"h:mm:ss a",short:"h:mm a"};const u={full:"{{date}} 'at' {{time}}",long:"{{date}} 'at' {{time}}",medium:"{{date}}, {{time}}",short:"{{date}}, {{time}}"};const l={date:i({formats:o,defaultWidth:"full"}),time:i({formats:s,defaultWidth:"full"}),dateTime:i({formats:u,defaultWidth:"full"})};// CONCATENATED MODULE: ./node_modules/date-fns/locale/en-US/_lib/formatRelative.js
const c={lastWeek:"'last' eeee 'at' p",yesterday:"'yesterday at' p",today:"'today at' p",tomorrow:"'tomorrow at' p",nextWeek:"eeee 'at' p",other:"P"};const f=(e,t,r,n)=>c[e];// CONCATENATED MODULE: ./node_modules/date-fns/locale/_lib/buildLocalizeFn.js
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
 */function d(e){return(t,r)=>{const n=r?.context?String(r.context):"standalone";let a;if(n==="formatting"&&e.formattingValues){const t=e.defaultFormattingWidth||e.defaultWidth;const n=r?.width?String(r.width):t;a=e.formattingValues[n]||e.formattingValues[t]}else{const t=e.defaultWidth;const n=r?.width?String(r.width):e.defaultWidth;a=e.values[n]||e.values[t]}const i=e.argumentCallback?e.argumentCallback(t):t;// @ts-expect-error - For some reason TypeScript just don't want to match it, no matter how hard we try. I challenge you to try to remove it!
return a[i]}};// CONCATENATED MODULE: ./node_modules/date-fns/locale/en-US/_lib/localize.js
const h={narrow:["B","A"],abbreviated:["BC","AD"],wide:["Before Christ","Anno Domini"]};const p={narrow:["1","2","3","4"],abbreviated:["Q1","Q2","Q3","Q4"],wide:["1st quarter","2nd quarter","3rd quarter","4th quarter"]};// Note: in English, the names of days of the week and months are capitalized.
// If you are making a new locale based on this one, check if the same is true for the language you're working on.
// Generally, formatted dates should look like they are in the middle of a sentence,
// e.g. in Spanish language the weekdays and months should be in the lowercase.
const v={narrow:["J","F","M","A","M","J","J","A","S","O","N","D"],abbreviated:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],wide:["January","February","March","April","May","June","July","August","September","October","November","December"]};const m={narrow:["S","M","T","W","T","F","S"],short:["Su","Mo","Tu","We","Th","Fr","Sa"],abbreviated:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],wide:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]};const g={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"}};const b={narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"}};const y=(e,t)=>{const r=Number(e);// If ordinal numbers depend on context, for example,
// if they are different for different grammatical genders,
// use `options.unit`.
//
// `unit` can be 'year', 'quarter', 'month', 'week', 'date', 'dayOfYear',
// 'day', 'hour', 'minute', 'second'.
const n=r%100;if(n>20||n<10){switch(n%10){case 1:return r+"st";case 2:return r+"nd";case 3:return r+"rd"}}return r+"th"};const w={ordinalNumber:y,era:d({values:h,defaultWidth:"wide"}),quarter:d({values:p,defaultWidth:"wide",argumentCallback:e=>e-1}),month:d({values:v,defaultWidth:"wide"}),day:d({values:m,defaultWidth:"wide"}),dayPeriod:d({values:g,defaultWidth:"wide",formattingValues:b,defaultFormattingWidth:"wide"})};// CONCATENATED MODULE: ./node_modules/date-fns/locale/_lib/buildMatchFn.js
function _(e){return(t,r={})=>{const n=r.width;const a=n&&e.matchPatterns[n]||e.matchPatterns[e.defaultMatchWidth];const i=t.match(a);if(!i){return null}const o=i[0];const s=n&&e.parsePatterns[n]||e.parsePatterns[e.defaultParseWidth];const u=Array.isArray(s)?E(s,e=>e.test(o)):x(s,e=>e.test(o));let l;l=e.valueCallback?e.valueCallback(u):u;l=r.valueCallback?r.valueCallback(l):l;const c=t.slice(o.length);return{value:l,rest:c}}}function x(e,t){for(const r in e){if(Object.prototype.hasOwnProperty.call(e,r)&&t(e[r])){return r}}return undefined}function E(e,t){for(let r=0;r<e.length;r++){if(t(e[r])){return r}}return undefined};// CONCATENATED MODULE: ./node_modules/date-fns/locale/_lib/buildMatchPatternFn.js
function O(e){return(t,r={})=>{const n=t.match(e.matchPattern);if(!n)return null;const a=n[0];const i=t.match(e.parsePattern);if(!i)return null;let o=e.valueCallback?e.valueCallback(i[0]):i[0];// [TODO] I challenge you to fix the type
o=r.valueCallback?r.valueCallback(o):o;const s=t.slice(a.length);return{value:o,rest:s}}};// CONCATENATED MODULE: ./node_modules/date-fns/locale/en-US/_lib/match.js
const S=/^(\d+)(th|st|nd|rd)?/i;const A=/\d+/i;const T={narrow:/^(b|a)/i,abbreviated:/^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i,wide:/^(before christ|before common era|anno domini|common era)/i};const k={any:[/^b/i,/^(a|c)/i]};const R={narrow:/^[1234]/i,abbreviated:/^q[1234]/i,wide:/^[1234](th|st|nd|rd)? quarter/i};const C={any:[/1/i,/2/i,/3/i,/4/i]};const P={narrow:/^[jfmasond]/i,abbreviated:/^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,wide:/^(january|february|march|april|may|june|july|august|september|october|november|december)/i};const I={narrow:[/^j/i,/^f/i,/^m/i,/^a/i,/^m/i,/^j/i,/^j/i,/^a/i,/^s/i,/^o/i,/^n/i,/^d/i],any:[/^ja/i,/^f/i,/^mar/i,/^ap/i,/^may/i,/^jun/i,/^jul/i,/^au/i,/^s/i,/^o/i,/^n/i,/^d/i]};const D={narrow:/^[smtwf]/i,short:/^(su|mo|tu|we|th|fr|sa)/i,abbreviated:/^(sun|mon|tue|wed|thu|fri|sat)/i,wide:/^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i};const M={narrow:[/^s/i,/^m/i,/^t/i,/^w/i,/^t/i,/^f/i,/^s/i],any:[/^su/i,/^m/i,/^tu/i,/^w/i,/^th/i,/^f/i,/^sa/i]};const F={narrow:/^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i,any:/^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i};const L={any:{am:/^a/i,pm:/^p/i,midnight:/^mi/i,noon:/^no/i,morning:/morning/i,afternoon:/afternoon/i,evening:/evening/i,night:/night/i}};const N={ordinalNumber:O({matchPattern:S,parsePattern:A,valueCallback:e=>parseInt(e,10)}),era:_({matchPatterns:T,defaultMatchWidth:"wide",parsePatterns:k,defaultParseWidth:"any"}),quarter:_({matchPatterns:R,defaultMatchWidth:"wide",parsePatterns:C,defaultParseWidth:"any",valueCallback:e=>e+1}),month:_({matchPatterns:P,defaultMatchWidth:"wide",parsePatterns:I,defaultParseWidth:"any"}),day:_({matchPatterns:D,defaultMatchWidth:"wide",parsePatterns:M,defaultParseWidth:"any"}),dayPeriod:_({matchPatterns:F,defaultMatchWidth:"any",parsePatterns:L,defaultParseWidth:"any"})};// CONCATENATED MODULE: ./node_modules/date-fns/locale/en-US.js
/**
 * @category Locales
 * @summary English locale (United States).
 * @language English
 * @iso-639-2 eng
 * @author Sasha Koss [@kossnocorp](https://github.com/kossnocorp)
 * @author Lesha Koss [@leshakoss](https://github.com/leshakoss)
 */const j={code:"en-US",formatDistance:a,formatLong:l,formatRelative:f,localize:w,match:N,options:{weekStartsOn:0/* Sunday */,firstWeekContainsDate:1}};// Fallback for modularized imports:
/* ESM default export */const U=/* unused pure expression or super */null&&j;// CONCATENATED MODULE: ./node_modules/date-fns/_lib/defaultOptions.js
let H={};function B(){return H}function Y(e){H=e}// EXTERNAL MODULE: ./node_modules/date-fns/toDate.js
var z=r(4007);// CONCATENATED MODULE: ./node_modules/date-fns/_lib/getTimezoneOffsetInMilliseconds.js
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
 */function q(e){const t=(0,z/* .toDate */.a)(e);const r=new Date(Date.UTC(t.getFullYear(),t.getMonth(),t.getDate(),t.getHours(),t.getMinutes(),t.getSeconds(),t.getMilliseconds()));r.setUTCFullYear(t.getFullYear());return+e-+r}// EXTERNAL MODULE: ./node_modules/date-fns/constructFrom.js
var V=r(3753);// CONCATENATED MODULE: ./node_modules/date-fns/_lib/normalizeDates.js
function W(e,...t){const r=V/* .constructFrom.bind */.w.bind(null,e||t.find(e=>typeof e==="object"));return t.map(r)}// EXTERNAL MODULE: ./node_modules/date-fns/constants.js
var $=r(7669);// EXTERNAL MODULE: ./node_modules/date-fns/startOfDay.js
var G=r(1671);// CONCATENATED MODULE: ./node_modules/date-fns/differenceInCalendarDays.js
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
 */function K(e,t,r){const[n,a]=W(r?.in,e,t);const i=(0,G/* .startOfDay */.o)(n);const o=(0,G/* .startOfDay */.o)(a);const s=+i-q(i);const u=+o-q(o);// Round the number of days to the nearest integer because the number of
// milliseconds in a day is not constant (e.g. it's different in the week of
// the daylight saving time clock shift).
return Math.round((s-u)/$/* .millisecondsInDay */.w4)}// Fallback for modularized imports:
/* ESM default export */const Q=/* unused pure expression or super */null&&K;// CONCATENATED MODULE: ./node_modules/date-fns/startOfYear.js
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
 */function X(e,t){const r=(0,z/* .toDate */.a)(e,t?.in);r.setFullYear(r.getFullYear(),0,1);r.setHours(0,0,0,0);return r}// Fallback for modularized imports:
/* ESM default export */const J=/* unused pure expression or super */null&&X;// CONCATENATED MODULE: ./node_modules/date-fns/getDayOfYear.js
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
 */function Z(e,t){const r=(0,z/* .toDate */.a)(e,t?.in);const n=K(r,X(r));const a=n+1;return a}// Fallback for modularized imports:
/* ESM default export */const ee=/* unused pure expression or super */null&&Z;// CONCATENATED MODULE: ./node_modules/date-fns/startOfWeek.js
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
 */function et(e,t){const r=B();const n=t?.weekStartsOn??t?.locale?.options?.weekStartsOn??r.weekStartsOn??r.locale?.options?.weekStartsOn??0;const a=(0,z/* .toDate */.a)(e,t?.in);const i=a.getDay();const o=(i<n?7:0)+i-n;a.setDate(a.getDate()-o);a.setHours(0,0,0,0);return a}// Fallback for modularized imports:
/* ESM default export */const er=/* unused pure expression or super */null&&et;// CONCATENATED MODULE: ./node_modules/date-fns/startOfISOWeek.js
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
 */function en(e,t){return et(e,{...t,weekStartsOn:1})}// Fallback for modularized imports:
/* ESM default export */const ea=/* unused pure expression or super */null&&en;// CONCATENATED MODULE: ./node_modules/date-fns/getISOWeekYear.js
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
 */function ei(e,t){const r=(0,z/* .toDate */.a)(e,t?.in);const n=r.getFullYear();const a=(0,V/* .constructFrom */.w)(r,0);a.setFullYear(n+1,0,4);a.setHours(0,0,0,0);const i=en(a);const o=(0,V/* .constructFrom */.w)(r,0);o.setFullYear(n,0,4);o.setHours(0,0,0,0);const s=en(o);if(r.getTime()>=i.getTime()){return n+1}else if(r.getTime()>=s.getTime()){return n}else{return n-1}}// Fallback for modularized imports:
/* ESM default export */const eo=/* unused pure expression or super */null&&ei;// CONCATENATED MODULE: ./node_modules/date-fns/startOfISOWeekYear.js
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
 */function es(e,t){const r=ei(e,t);const n=(0,V/* .constructFrom */.w)(t?.in||e,0);n.setFullYear(r,0,4);n.setHours(0,0,0,0);return en(n)}// Fallback for modularized imports:
/* ESM default export */const eu=/* unused pure expression or super */null&&es;// CONCATENATED MODULE: ./node_modules/date-fns/getISOWeek.js
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
 */function el(e,t){const r=(0,z/* .toDate */.a)(e,t?.in);const n=+en(r)-+es(r);// Round the number of weeks to the nearest integer because the number of
// milliseconds in a week is not constant (e.g. it's different in the week of
// the daylight saving time clock shift).
return Math.round(n/$/* .millisecondsInWeek */.my)+1}// Fallback for modularized imports:
/* ESM default export */const ec=/* unused pure expression or super */null&&el;// CONCATENATED MODULE: ./node_modules/date-fns/getWeekYear.js
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
 */function ef(e,t){const r=(0,z/* .toDate */.a)(e,t?.in);const n=r.getFullYear();const a=B();const i=t?.firstWeekContainsDate??t?.locale?.options?.firstWeekContainsDate??a.firstWeekContainsDate??a.locale?.options?.firstWeekContainsDate??1;const o=(0,V/* .constructFrom */.w)(t?.in||e,0);o.setFullYear(n+1,0,i);o.setHours(0,0,0,0);const s=et(o,t);const u=(0,V/* .constructFrom */.w)(t?.in||e,0);u.setFullYear(n,0,i);u.setHours(0,0,0,0);const l=et(u,t);if(+r>=+s){return n+1}else if(+r>=+l){return n}else{return n-1}}// Fallback for modularized imports:
/* ESM default export */const ed=/* unused pure expression or super */null&&ef;// CONCATENATED MODULE: ./node_modules/date-fns/startOfWeekYear.js
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
 */function eh(e,t){const r=B();const n=t?.firstWeekContainsDate??t?.locale?.options?.firstWeekContainsDate??r.firstWeekContainsDate??r.locale?.options?.firstWeekContainsDate??1;const a=ef(e,t);const i=(0,V/* .constructFrom */.w)(t?.in||e,0);i.setFullYear(a,0,n);i.setHours(0,0,0,0);const o=et(i,t);return o}// Fallback for modularized imports:
/* ESM default export */const ep=/* unused pure expression or super */null&&eh;// CONCATENATED MODULE: ./node_modules/date-fns/getWeek.js
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
 */function ev(e,t){const r=(0,z/* .toDate */.a)(e,t?.in);const n=+et(r,t)-+eh(r,t);// Round the number of weeks to the nearest integer because the number of
// milliseconds in a week is not constant (e.g. it's different in the week of
// the daylight saving time clock shift).
return Math.round(n/$/* .millisecondsInWeek */.my)+1}// Fallback for modularized imports:
/* ESM default export */const em=/* unused pure expression or super */null&&ev;// CONCATENATED MODULE: ./node_modules/date-fns/_lib/addLeadingZeros.js
function eg(e,t){const r=e<0?"-":"";const n=Math.abs(e).toString().padStart(t,"0");return r+n};// CONCATENATED MODULE: ./node_modules/date-fns/_lib/format/lightFormatters.js
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
 */const eb={// Year
y(e,t){// From http://www.unicode.org/reports/tr35/tr35-31/tr35-dates.html#Date_Format_tokens
// | Year     |     y | yy |   yyy |  yyyy | yyyyy |
// |----------|-------|----|-------|-------|-------|
// | AD 1     |     1 | 01 |   001 |  0001 | 00001 |
// | AD 12    |    12 | 12 |   012 |  0012 | 00012 |
// | AD 123   |   123 | 23 |   123 |  0123 | 00123 |
// | AD 1234  |  1234 | 34 |  1234 |  1234 | 01234 |
// | AD 12345 | 12345 | 45 | 12345 | 12345 | 12345 |
const r=e.getFullYear();// Returns 1 for 1 BC (which is year 0 in JavaScript)
const n=r>0?r:1-r;return eg(t==="yy"?n%100:n,t.length)},// Month
M(e,t){const r=e.getMonth();return t==="M"?String(r+1):eg(r+1,2)},// Day of the month
d(e,t){return eg(e.getDate(),t.length)},// AM or PM
a(e,t){const r=e.getHours()/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.toUpperCase();case"aaa":return r;case"aaaaa":return r[0];case"aaaa":default:return r==="am"?"a.m.":"p.m."}},// Hour [1-12]
h(e,t){return eg(e.getHours()%12||12,t.length)},// Hour [0-23]
H(e,t){return eg(e.getHours(),t.length)},// Minute
m(e,t){return eg(e.getMinutes(),t.length)},// Second
s(e,t){return eg(e.getSeconds(),t.length)},// Fraction of second
S(e,t){const r=t.length;const n=e.getMilliseconds();const a=Math.trunc(n*Math.pow(10,r-3));return eg(a,t.length)}};// CONCATENATED MODULE: ./node_modules/date-fns/_lib/format/formatters.js
const ey={am:"am",pm:"pm",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"};/*
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
 */const ew={// Era
G:function(e,t,r){const n=e.getFullYear()>0?1:0;switch(t){// AD, BC
case"G":case"GG":case"GGG":return r.era(n,{width:"abbreviated"});// A, B
case"GGGGG":return r.era(n,{width:"narrow"});// Anno Domini, Before Christ
case"GGGG":default:return r.era(n,{width:"wide"})}},// Year
y:function(e,t,r){// Ordinal number
if(t==="yo"){const t=e.getFullYear();// Returns 1 for 1 BC (which is year 0 in JavaScript)
const n=t>0?t:1-t;return r.ordinalNumber(n,{unit:"year"})}return eb.y(e,t)},// Local week-numbering year
Y:function(e,t,r,n){const a=ef(e,n);// Returns 1 for 1 BC (which is year 0 in JavaScript)
const i=a>0?a:1-a;// Two digit year
if(t==="YY"){const e=i%100;return eg(e,2)}// Ordinal number
if(t==="Yo"){return r.ordinalNumber(i,{unit:"year"})}// Padding
return eg(i,t.length)},// ISO week-numbering year
R:function(e,t){const r=ei(e);// Padding
return eg(r,t.length)},// Extended year. This is a single number designating the year of this calendar system.
// The main difference between `y` and `u` localizers are B.C. years:
// | Year | `y` | `u` |
// |------|-----|-----|
// | AC 1 |   1 |   1 |
// | BC 1 |   1 |   0 |
// | BC 2 |   2 |  -1 |
// Also `yy` always returns the last two digits of a year,
// while `uu` pads single digit years to 2 characters and returns other years unchanged.
u:function(e,t){const r=e.getFullYear();return eg(r,t.length)},// Quarter
Q:function(e,t,r){const n=Math.ceil((e.getMonth()+1)/3);switch(t){// 1, 2, 3, 4
case"Q":return String(n);// 01, 02, 03, 04
case"QQ":return eg(n,2);// 1st, 2nd, 3rd, 4th
case"Qo":return r.ordinalNumber(n,{unit:"quarter"});// Q1, Q2, Q3, Q4
case"QQQ":return r.quarter(n,{width:"abbreviated",context:"formatting"});// 1, 2, 3, 4 (narrow quarter; could be not numerical)
case"QQQQQ":return r.quarter(n,{width:"narrow",context:"formatting"});// 1st quarter, 2nd quarter, ...
case"QQQQ":default:return r.quarter(n,{width:"wide",context:"formatting"})}},// Stand-alone quarter
q:function(e,t,r){const n=Math.ceil((e.getMonth()+1)/3);switch(t){// 1, 2, 3, 4
case"q":return String(n);// 01, 02, 03, 04
case"qq":return eg(n,2);// 1st, 2nd, 3rd, 4th
case"qo":return r.ordinalNumber(n,{unit:"quarter"});// Q1, Q2, Q3, Q4
case"qqq":return r.quarter(n,{width:"abbreviated",context:"standalone"});// 1, 2, 3, 4 (narrow quarter; could be not numerical)
case"qqqqq":return r.quarter(n,{width:"narrow",context:"standalone"});// 1st quarter, 2nd quarter, ...
case"qqqq":default:return r.quarter(n,{width:"wide",context:"standalone"})}},// Month
M:function(e,t,r){const n=e.getMonth();switch(t){case"M":case"MM":return eb.M(e,t);// 1st, 2nd, ..., 12th
case"Mo":return r.ordinalNumber(n+1,{unit:"month"});// Jan, Feb, ..., Dec
case"MMM":return r.month(n,{width:"abbreviated",context:"formatting"});// J, F, ..., D
case"MMMMM":return r.month(n,{width:"narrow",context:"formatting"});// January, February, ..., December
case"MMMM":default:return r.month(n,{width:"wide",context:"formatting"})}},// Stand-alone month
L:function(e,t,r){const n=e.getMonth();switch(t){// 1, 2, ..., 12
case"L":return String(n+1);// 01, 02, ..., 12
case"LL":return eg(n+1,2);// 1st, 2nd, ..., 12th
case"Lo":return r.ordinalNumber(n+1,{unit:"month"});// Jan, Feb, ..., Dec
case"LLL":return r.month(n,{width:"abbreviated",context:"standalone"});// J, F, ..., D
case"LLLLL":return r.month(n,{width:"narrow",context:"standalone"});// January, February, ..., December
case"LLLL":default:return r.month(n,{width:"wide",context:"standalone"})}},// Local week of year
w:function(e,t,r,n){const a=ev(e,n);if(t==="wo"){return r.ordinalNumber(a,{unit:"week"})}return eg(a,t.length)},// ISO week of year
I:function(e,t,r){const n=el(e);if(t==="Io"){return r.ordinalNumber(n,{unit:"week"})}return eg(n,t.length)},// Day of the month
d:function(e,t,r){if(t==="do"){return r.ordinalNumber(e.getDate(),{unit:"date"})}return eb.d(e,t)},// Day of year
D:function(e,t,r){const n=Z(e);if(t==="Do"){return r.ordinalNumber(n,{unit:"dayOfYear"})}return eg(n,t.length)},// Day of week
E:function(e,t,r){const n=e.getDay();switch(t){// Tue
case"E":case"EE":case"EEE":return r.day(n,{width:"abbreviated",context:"formatting"});// T
case"EEEEE":return r.day(n,{width:"narrow",context:"formatting"});// Tu
case"EEEEEE":return r.day(n,{width:"short",context:"formatting"});// Tuesday
case"EEEE":default:return r.day(n,{width:"wide",context:"formatting"})}},// Local day of week
e:function(e,t,r,n){const a=e.getDay();const i=(a-n.weekStartsOn+8)%7||7;switch(t){// Numerical value (Nth day of week with current locale or weekStartsOn)
case"e":return String(i);// Padded numerical value
case"ee":return eg(i,2);// 1st, 2nd, ..., 7th
case"eo":return r.ordinalNumber(i,{unit:"day"});case"eee":return r.day(a,{width:"abbreviated",context:"formatting"});// T
case"eeeee":return r.day(a,{width:"narrow",context:"formatting"});// Tu
case"eeeeee":return r.day(a,{width:"short",context:"formatting"});// Tuesday
case"eeee":default:return r.day(a,{width:"wide",context:"formatting"})}},// Stand-alone local day of week
c:function(e,t,r,n){const a=e.getDay();const i=(a-n.weekStartsOn+8)%7||7;switch(t){// Numerical value (same as in `e`)
case"c":return String(i);// Padded numerical value
case"cc":return eg(i,t.length);// 1st, 2nd, ..., 7th
case"co":return r.ordinalNumber(i,{unit:"day"});case"ccc":return r.day(a,{width:"abbreviated",context:"standalone"});// T
case"ccccc":return r.day(a,{width:"narrow",context:"standalone"});// Tu
case"cccccc":return r.day(a,{width:"short",context:"standalone"});// Tuesday
case"cccc":default:return r.day(a,{width:"wide",context:"standalone"})}},// ISO day of week
i:function(e,t,r){const n=e.getDay();const a=n===0?7:n;switch(t){// 2
case"i":return String(a);// 02
case"ii":return eg(a,t.length);// 2nd
case"io":return r.ordinalNumber(a,{unit:"day"});// Tue
case"iii":return r.day(n,{width:"abbreviated",context:"formatting"});// T
case"iiiii":return r.day(n,{width:"narrow",context:"formatting"});// Tu
case"iiiiii":return r.day(n,{width:"short",context:"formatting"});// Tuesday
case"iiii":default:return r.day(n,{width:"wide",context:"formatting"})}},// AM or PM
a:function(e,t,r){const n=e.getHours();const a=n/12>=1?"pm":"am";switch(t){case"a":case"aa":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"});case"aaa":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"}).toLowerCase();case"aaaaa":return r.dayPeriod(a,{width:"narrow",context:"formatting"});case"aaaa":default:return r.dayPeriod(a,{width:"wide",context:"formatting"})}},// AM, PM, midnight, noon
b:function(e,t,r){const n=e.getHours();let a;if(n===12){a=ey.noon}else if(n===0){a=ey.midnight}else{a=n/12>=1?"pm":"am"}switch(t){case"b":case"bb":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"});case"bbb":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"}).toLowerCase();case"bbbbb":return r.dayPeriod(a,{width:"narrow",context:"formatting"});case"bbbb":default:return r.dayPeriod(a,{width:"wide",context:"formatting"})}},// in the morning, in the afternoon, in the evening, at night
B:function(e,t,r){const n=e.getHours();let a;if(n>=17){a=ey.evening}else if(n>=12){a=ey.afternoon}else if(n>=4){a=ey.morning}else{a=ey.night}switch(t){case"B":case"BB":case"BBB":return r.dayPeriod(a,{width:"abbreviated",context:"formatting"});case"BBBBB":return r.dayPeriod(a,{width:"narrow",context:"formatting"});case"BBBB":default:return r.dayPeriod(a,{width:"wide",context:"formatting"})}},// Hour [1-12]
h:function(e,t,r){if(t==="ho"){let t=e.getHours()%12;if(t===0)t=12;return r.ordinalNumber(t,{unit:"hour"})}return eb.h(e,t)},// Hour [0-23]
H:function(e,t,r){if(t==="Ho"){return r.ordinalNumber(e.getHours(),{unit:"hour"})}return eb.H(e,t)},// Hour [0-11]
K:function(e,t,r){const n=e.getHours()%12;if(t==="Ko"){return r.ordinalNumber(n,{unit:"hour"})}return eg(n,t.length)},// Hour [1-24]
k:function(e,t,r){let n=e.getHours();if(n===0)n=24;if(t==="ko"){return r.ordinalNumber(n,{unit:"hour"})}return eg(n,t.length)},// Minute
m:function(e,t,r){if(t==="mo"){return r.ordinalNumber(e.getMinutes(),{unit:"minute"})}return eb.m(e,t)},// Second
s:function(e,t,r){if(t==="so"){return r.ordinalNumber(e.getSeconds(),{unit:"second"})}return eb.s(e,t)},// Fraction of second
S:function(e,t){return eb.S(e,t)},// Timezone (ISO-8601. If offset is 0, output is always `'Z'`)
X:function(e,t,r){const n=e.getTimezoneOffset();if(n===0){return"Z"}switch(t){// Hours and optional minutes
case"X":return ex(n);// Hours, minutes and optional seconds without `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `XX`
case"XXXX":case"XX":return eE(n);// Hours, minutes and optional seconds with `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `XXX`
case"XXXXX":case"XXX":default:return eE(n,":")}},// Timezone (ISO-8601. If offset is 0, output is `'+00:00'` or equivalent)
x:function(e,t,r){const n=e.getTimezoneOffset();switch(t){// Hours and optional minutes
case"x":return ex(n);// Hours, minutes and optional seconds without `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `xx`
case"xxxx":case"xx":return eE(n);// Hours, minutes and optional seconds with `:` delimiter
// Note: neither ISO-8601 nor JavaScript supports seconds in timezone offsets
// so this token always has the same output as `xxx`
case"xxxxx":case"xxx":default:return eE(n,":")}},// Timezone (GMT)
O:function(e,t,r){const n=e.getTimezoneOffset();switch(t){// Short
case"O":case"OO":case"OOO":return"GMT"+e_(n,":");// Long
case"OOOO":default:return"GMT"+eE(n,":")}},// Timezone (specific non-location)
z:function(e,t,r){const n=e.getTimezoneOffset();switch(t){// Short
case"z":case"zz":case"zzz":return"GMT"+e_(n,":");// Long
case"zzzz":default:return"GMT"+eE(n,":")}},// Seconds timestamp
t:function(e,t,r){const n=Math.trunc(+e/1e3);return eg(n,t.length)},// Milliseconds timestamp
T:function(e,t,r){return eg(+e,t.length)}};function e_(e,t=""){const r=e>0?"-":"+";const n=Math.abs(e);const a=Math.trunc(n/60);const i=n%60;if(i===0){return r+String(a)}return r+String(a)+t+eg(i,2)}function ex(e,t){if(e%60===0){const t=e>0?"-":"+";return t+eg(Math.abs(e)/60,2)}return eE(e,t)}function eE(e,t=""){const r=e>0?"-":"+";const n=Math.abs(e);const a=eg(Math.trunc(n/60),2);const i=eg(n%60,2);return r+a+t+i};// CONCATENATED MODULE: ./node_modules/date-fns/_lib/format/longFormatters.js
const eO=(e,t)=>{switch(e){case"P":return t.date({width:"short"});case"PP":return t.date({width:"medium"});case"PPP":return t.date({width:"long"});case"PPPP":default:return t.date({width:"full"})}};const eS=(e,t)=>{switch(e){case"p":return t.time({width:"short"});case"pp":return t.time({width:"medium"});case"ppp":return t.time({width:"long"});case"pppp":default:return t.time({width:"full"})}};const eA=(e,t)=>{const r=e.match(/(P+)(p+)?/)||[];const n=r[1];const a=r[2];if(!a){return eO(e,t)}let i;switch(n){case"P":i=t.dateTime({width:"short"});break;case"PP":i=t.dateTime({width:"medium"});break;case"PPP":i=t.dateTime({width:"long"});break;case"PPPP":default:i=t.dateTime({width:"full"});break}return i.replace("{{date}}",eO(n,t)).replace("{{time}}",eS(a,t))};const eT={p:eS,P:eA};// CONCATENATED MODULE: ./node_modules/date-fns/_lib/protectedTokens.js
const ek=/^D+$/;const eR=/^Y+$/;const eC=["D","DD","YY","YYYY"];function eP(e){return ek.test(e)}function eI(e){return eR.test(e)}function eD(e,t,r){const n=eM(e,t,r);console.warn(n);if(eC.includes(e))throw new RangeError(n)}function eM(e,t,r){const n=e[0]==="Y"?"years":"days of the month";return`Use \`${e.toLowerCase()}\` instead of \`${e}\` (in \`${t}\`) for formatting ${n} to the input \`${r}\`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md`}// EXTERNAL MODULE: ./node_modules/date-fns/isValid.js + 1 modules
var eF=r(8775);// CONCATENATED MODULE: ./node_modules/date-fns/format.js
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
const eL=/[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g;// This RegExp catches symbols escaped by quotes, and also
// sequences of symbols P, p, and the combinations like `PPPPPPPppppp`
const eN=/P+p+|P+|p+|''|'(''|[^'])+('|$)|./g;const ej=/^'([^]*?)'?$/;const eU=/''/g;const eH=/[a-zA-Z]/;/**
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
 */function eB(e,t,r){const n=B();const a=r?.locale??n.locale??j;const i=r?.firstWeekContainsDate??r?.locale?.options?.firstWeekContainsDate??n.firstWeekContainsDate??n.locale?.options?.firstWeekContainsDate??1;const o=r?.weekStartsOn??r?.locale?.options?.weekStartsOn??n.weekStartsOn??n.locale?.options?.weekStartsOn??0;const s=(0,z/* .toDate */.a)(e,r?.in);if(!(0,eF/* .isValid */.f)(s)){throw new RangeError("Invalid time value")}let u=t.match(eN).map(e=>{const t=e[0];if(t==="p"||t==="P"){const r=eT[t];return r(e,a.formatLong)}return e}).join("").match(eL).map(e=>{// Replace two single quote characters with one single quote character
if(e==="''"){return{isToken:false,value:"'"}}const t=e[0];if(t==="'"){return{isToken:false,value:eY(e)}}if(ew[t]){return{isToken:true,value:e}}if(t.match(eH)){throw new RangeError("Format string contains an unescaped latin alphabet character `"+t+"`")}return{isToken:false,value:e}});// invoke localize preprocessor (only for french locales at the moment)
if(a.localize.preprocessor){u=a.localize.preprocessor(s,u)}const l={firstWeekContainsDate:i,weekStartsOn:o,locale:a};return u.map(n=>{if(!n.isToken)return n.value;const i=n.value;if(!r?.useAdditionalWeekYearTokens&&eI(i)||!r?.useAdditionalDayOfYearTokens&&eP(i)){eD(i,t,String(e))}const o=ew[i[0]];return o(s,i,a.localize,l)}).join("")}function eY(e){const t=e.match(ej);if(!t){return e}return t[1].replace(eU,"'")}// Fallback for modularized imports:
/* ESM default export */const ez=/* unused pure expression or super */null&&eB},9817:function(e,t,r){"use strict";r.d(t,{Y:()=>a});/* ESM import */var n=r(4007);/**
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
 */function a(e,t){return+(0,n/* .toDate */.a)(e)<+(0,n/* .toDate */.a)(t)}// Fallback for modularized imports:
/* unused ESM default export */var i=/* unused pure expression or super */null&&a},8775:function(e,t,r){"use strict";// EXPORTS
r.d(t,{f:()=>/* binding */o});// UNUSED EXPORTS: default
;// CONCATENATED MODULE: ./node_modules/date-fns/isDate.js
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
 */function n(e){return e instanceof Date||typeof e==="object"&&Object.prototype.toString.call(e)==="[object Date]"}// Fallback for modularized imports:
/* ESM default export */const a=/* unused pure expression or super */null&&n;// EXTERNAL MODULE: ./node_modules/date-fns/toDate.js
var i=r(4007);// CONCATENATED MODULE: ./node_modules/date-fns/isValid.js
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
 */function o(e){return!(!n(e)&&typeof e!=="number"||isNaN(+(0,i/* .toDate */.a)(e)))}// Fallback for modularized imports:
/* ESM default export */const s=/* unused pure expression or super */null&&o},4522:function(e,t,r){"use strict";r.d(t,{H:()=>o});/* ESM import */var n=r(7669);/* ESM import */var a=r(3753);/* ESM import */var i=r(4007);/**
 * The {@link parseISO} function options.
 *//**
 * @name parseISO
 * @category Common Helpers
 * @summary Parse ISO string
 *
 * @description
 * Parse the given string in ISO 8601 format and return an instance of Date.
 *
 * Function accepts complete ISO 8601 formats as well as partial implementations.
 * ISO 8601: http://en.wikipedia.org/wiki/ISO_8601
 *
 * If the argument isn't a string, the function cannot parse the string or
 * the values are invalid, it returns Invalid Date.
 *
 * @typeParam DateType - The `Date` type, the function operates on. Gets inferred from passed arguments. Allows to use extensions like [`UTCDate`](https://github.com/date-fns/utc).
 * @typeParam ResultDate - The result `Date` type, it is the type returned from the context function if it is passed, or inferred from the arguments.
 *
 * @param argument - The value to convert
 * @param options - An object with options
 *
 * @returns The parsed date in the local time zone
 *
 * @example
 * // Convert string '2014-02-11T11:30:30' to date:
 * const result = parseISO('2014-02-11T11:30:30')
 * //=> Tue Feb 11 2014 11:30:30
 *
 * @example
 * // Convert string '+02014101' to date,
 * // if the additional number of digits in the extended year format is 1:
 * const result = parseISO('+02014101', { additionalDigits: 1 })
 * //=> Fri Apr 11 2014 00:00:00
 */function o(e,t){const r=()=>(0,a/* .constructFrom */.w)(t?.in,NaN);const n=t?.additionalDigits??2;const o=f(e);let s;if(o.date){const e=d(o.date,n);s=h(e.restDateString,e.year)}if(!s||isNaN(+s))return r();const u=+s;let l=0;let c;if(o.time){l=v(o.time);if(isNaN(l))return r()}if(o.timezone){c=g(o.timezone);if(isNaN(c))return r()}else{const e=new Date(u+l);const r=(0,i/* .toDate */.a)(0,t?.in);r.setFullYear(e.getUTCFullYear(),e.getUTCMonth(),e.getUTCDate());r.setHours(e.getUTCHours(),e.getUTCMinutes(),e.getUTCSeconds(),e.getUTCMilliseconds());return r}return(0,i/* .toDate */.a)(u+l+c,t?.in)}const s={dateTimeDelimiter:/[T ]/,timeZoneDelimiter:/[Z ]/i,timezone:/([Z+-].*)$/};const u=/^-?(?:(\d{3})|(\d{2})(?:-?(\d{2}))?|W(\d{2})(?:-?(\d{1}))?|)$/;const l=/^(\d{2}(?:[.,]\d*)?)(?::?(\d{2}(?:[.,]\d*)?))?(?::?(\d{2}(?:[.,]\d*)?))?$/;const c=/^([+-])(\d{2})(?::?(\d{2}))?$/;function f(e){const t={};const r=e.split(s.dateTimeDelimiter);let n;// The regex match should only return at maximum two array elements.
// [date], [time], or [date, time].
if(r.length>2){return t}if(/:/.test(r[0])){n=r[0]}else{t.date=r[0];n=r[1];if(s.timeZoneDelimiter.test(t.date)){t.date=e.split(s.timeZoneDelimiter)[0];n=e.substr(t.date.length,e.length)}}if(n){const e=s.timezone.exec(n);if(e){t.time=n.replace(e[1],"");t.timezone=e[1]}else{t.time=n}}return t}function d(e,t){const r=new RegExp("^(?:(\\d{4}|[+-]\\d{"+(4+t)+"})|(\\d{2}|[+-]\\d{"+(2+t)+"})$)");const n=e.match(r);// Invalid ISO-formatted year
if(!n)return{year:NaN,restDateString:""};const a=n[1]?parseInt(n[1]):null;const i=n[2]?parseInt(n[2]):null;// either year or century is null, not both
return{year:i===null?a:i*100,restDateString:e.slice((n[1]||n[2]).length)}}function h(e,t){// Invalid ISO-formatted year
if(t===null)return new Date(NaN);const r=e.match(u);// Invalid ISO-formatted string
if(!r)return new Date(NaN);const n=!!r[4];const a=p(r[1]);const i=p(r[2])-1;const o=p(r[3]);const s=p(r[4]);const l=p(r[5])-1;if(n){if(!E(t,s,l)){return new Date(NaN)}return b(t,s,l)}else{const e=new Date(0);if(!_(t,i,o)||!x(t,a)){return new Date(NaN)}e.setUTCFullYear(t,i,Math.max(a,o));return e}}function p(e){return e?parseInt(e):1}function v(e){const t=e.match(l);if(!t)return NaN;// Invalid ISO-formatted time
const r=m(t[1]);const a=m(t[2]);const i=m(t[3]);if(!O(r,a,i)){return NaN}return r*n/* .millisecondsInHour */.s0+a*n/* .millisecondsInMinute */.Cg+i*1e3}function m(e){return e&&parseFloat(e.replace(",","."))||0}function g(e){if(e==="Z")return 0;const t=e.match(c);if(!t)return 0;const r=t[1]==="+"?-1:1;const a=parseInt(t[2]);const i=t[3]&&parseInt(t[3])||0;if(!S(a,i)){return NaN}return r*(a*n/* .millisecondsInHour */.s0+i*n/* .millisecondsInMinute */.Cg)}function b(e,t,r){const n=new Date(0);n.setUTCFullYear(e,0,4);const a=n.getUTCDay()||7;const i=(t-1)*7+r+1-a;n.setUTCDate(n.getUTCDate()+i);return n}// Validation functions
// February is null to handle the leap year (using ||)
const y=[31,null,31,30,31,30,31,31,30,31,30,31];function w(e){return e%400===0||e%4===0&&e%100!==0}function _(e,t,r){return t>=0&&t<=11&&r>=1&&r<=(y[t]||(w(e)?29:28))}function x(e,t){return t>=1&&t<=(w(e)?366:365)}function E(e,t,r){return t>=1&&t<=53&&r>=0&&r<=6}function O(e,t,r){if(e===24){return t===0&&r===0}return r>=0&&r<60&&t>=0&&t<60&&e>=0&&e<25}function S(e,t){return t>=0&&t<=59}// Fallback for modularized imports:
/* unused ESM default export */var A=/* unused pure expression or super */null&&o},1671:function(e,t,r){"use strict";r.d(t,{o:()=>a});/* ESM import */var n=r(4007);/**
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
 */function a(e,t){const r=(0,n/* .toDate */.a)(e,t?.in);r.setHours(0,0,0,0);return r}// Fallback for modularized imports:
/* unused ESM default export */var i=/* unused pure expression or super */null&&a},4007:function(e,t,r){"use strict";r.d(t,{a:()=>a});/* ESM import */var n=r(3753);/**
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
 */function a(e,t){// [TODO] Get rid of `toDate` or `constructFrom`?
return(0,n/* .constructFrom */.w)(t||e,e)}// Fallback for modularized imports:
/* unused ESM default export */var i=/* unused pure expression or super */null&&a},3937:function(e,t,r){"use strict";r.d(t,{FH:()=>F,Op:()=>T,jz:()=>eq,mN:()=>eV,xI:()=>N,xW:()=>A});/* ESM import */var n=r(1594);var a=e=>e.type==="checkbox";var i=e=>e instanceof Date;var o=e=>e==null;const s=e=>typeof e==="object";var u=e=>!o(e)&&!Array.isArray(e)&&s(e)&&!i(e);var l=e=>u(e)&&e.target?a(e.target)?e.target.checked:e.target.value:e;var c=e=>e.substring(0,e.search(/\.\d+(\.|$)/))||e;var f=(e,t)=>e.has(c(t));var d=e=>{const t=e.constructor&&e.constructor.prototype;return u(t)&&t.hasOwnProperty("isPrototypeOf")};var h=typeof window!=="undefined"&&typeof window.HTMLElement!=="undefined"&&typeof document!=="undefined";function p(e){let t;const r=Array.isArray(e);const n=typeof FileList!=="undefined"?e instanceof FileList:false;if(e instanceof Date){t=new Date(e)}else if(!(h&&(e instanceof Blob||n))&&(r||u(e))){t=r?[]:Object.create(Object.getPrototypeOf(e));if(!r&&!d(e)){t=e}else{for(const r in e){if(e.hasOwnProperty(r)){t[r]=p(e[r])}}}}else{return e}return t}var v=e=>/^\w*$/.test(e);var m=e=>e===undefined;var g=e=>Array.isArray(e)?e.filter(Boolean):[];var b=e=>g(e.replace(/["|']|\]/g,"").split(/\.|\[/));var y=(e,t,r)=>{if(!t||!u(e)){return r}const n=(v(t)?[t]:b(t)).reduce((e,t)=>o(e)?e:e[t],e);return m(n)||n===e?m(e[t])?r:e[t]:n};var w=e=>typeof e==="boolean";var _=(e,t,r)=>{let n=-1;const a=v(t)?[t]:b(t);const i=a.length;const o=i-1;while(++n<i){const t=a[n];let i=r;if(n!==o){const r=e[t];i=u(r)||Array.isArray(r)?r:!isNaN(+a[n+1])?[]:{}}if(t==="__proto__"||t==="constructor"||t==="prototype"){return}e[t]=i;e=e[t]}};const x={BLUR:"blur",FOCUS_OUT:"focusout",CHANGE:"change"};const E={onBlur:"onBlur",onChange:"onChange",onSubmit:"onSubmit",onTouched:"onTouched",all:"all"};const O={max:"max",min:"min",maxLength:"maxLength",minLength:"minLength",pattern:"pattern",required:"required",validate:"validate"};const S=n.createContext(null);S.displayName="HookFormContext";/**
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
 */const A=()=>n.useContext(S);/**
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
 */const T=e=>{const{children:t,...r}=e;return n.createElement(S.Provider,{value:r},t)};var k=(e,t,r,n=true)=>{const a={defaultValues:t._defaultValues};for(const i in e){Object.defineProperty(a,i,{get:()=>{const a=i;if(t._proxyFormState[a]!==E.all){t._proxyFormState[a]=!n||E.all}r&&(r[a]=true);return e[a]}})}return a};const R=typeof window!=="undefined"?n.useLayoutEffect:n.useEffect;/**
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
 */function C(e){const t=A();const{control:r=t.control,disabled:a,name:i,exact:o}=e||{};const[s,u]=n.useState(r._formState);const l=n.useRef({isDirty:false,isLoading:false,dirtyFields:false,touchedFields:false,validatingFields:false,isValidating:false,isValid:false,errors:false});R(()=>r._subscribe({name:i,formState:l.current,exact:o,callback:e=>{!a&&u({...r._formState,...e})}}),[i,a,o]);n.useEffect(()=>{l.current.isValid&&r._setValid(true)},[r]);return n.useMemo(()=>k(s,r,l.current,false),[s,r])}var P=e=>typeof e==="string";var I=(e,t,r,n,a)=>{if(P(e)){n&&t.watch.add(e);return y(r,e,a)}if(Array.isArray(e)){return e.map(e=>(n&&t.watch.add(e),y(r,e)))}n&&(t.watchAll=true);return r};var D=e=>o(e)||!s(e);function M(e,t,r=new WeakSet){if(D(e)||D(t)){return e===t}if(i(e)&&i(t)){return e.getTime()===t.getTime()}const n=Object.keys(e);const a=Object.keys(t);if(n.length!==a.length){return false}if(r.has(e)||r.has(t)){return true}r.add(e);r.add(t);for(const o of n){const n=e[o];if(!a.includes(o)){return false}if(o!=="ref"){const e=t[o];if(i(n)&&i(e)||u(n)&&u(e)||Array.isArray(n)&&Array.isArray(e)?!M(n,e,r):n!==e){return false}}}return true}/**
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
 */function F(e){const t=A();const{control:r=t.control,name:a,defaultValue:i,disabled:o,exact:s,compute:u}=e||{};const l=n.useRef(i);const c=n.useRef(u);const f=n.useRef(undefined);c.current=u;const d=n.useMemo(()=>r._getWatch(a,l.current),[r,a]);const[h,p]=n.useState(c.current?c.current(d):d);R(()=>r._subscribe({name:a,formState:{values:true},exact:s,callback:e=>{if(!o){const t=I(a,r._names,e.values||r._formValues,false,l.current);if(c.current){const e=c.current(t);if(!M(e,f.current)){p(e);f.current=e}}else{p(t)}}}}),[r,o,a,s]);n.useEffect(()=>r._removeUnmounted());return h}/**
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
 */function L(e){const t=A();const{name:r,disabled:a,control:i=t.control,shouldUnregister:o,defaultValue:s}=e;const u=f(i._names.array,r);const c=n.useMemo(()=>y(i._formValues,r,y(i._defaultValues,r,s)),[i,r,s]);const d=F({control:i,name:r,defaultValue:c,exact:true});const h=C({control:i,name:r,exact:true});const v=n.useRef(e);const g=n.useRef(i.register(r,{...e.rules,value:d,...w(e.disabled)?{disabled:e.disabled}:{}}));v.current=e;const b=n.useMemo(()=>Object.defineProperties({},{invalid:{enumerable:true,get:()=>!!y(h.errors,r)},isDirty:{enumerable:true,get:()=>!!y(h.dirtyFields,r)},isTouched:{enumerable:true,get:()=>!!y(h.touchedFields,r)},isValidating:{enumerable:true,get:()=>!!y(h.validatingFields,r)},error:{enumerable:true,get:()=>y(h.errors,r)}}),[h,r]);const E=n.useCallback(e=>g.current.onChange({target:{value:l(e),name:r},type:x.CHANGE}),[r]);const O=n.useCallback(()=>g.current.onBlur({target:{value:y(i._formValues,r),name:r},type:x.BLUR}),[r,i._formValues]);const S=n.useCallback(e=>{const t=y(i._fields,r);if(t&&e){t._f.ref={focus:()=>e.focus&&e.focus(),select:()=>e.select&&e.select(),setCustomValidity:t=>e.setCustomValidity(t),reportValidity:()=>e.reportValidity()}}},[i._fields,r]);const T=n.useMemo(()=>({name:r,value:d,...w(a)||h.disabled?{disabled:h.disabled||a}:{},onChange:E,onBlur:O,ref:S}),[r,a,h.disabled,E,O,S,d]);n.useEffect(()=>{const e=i._options.shouldUnregister||o;i.register(r,{...v.current.rules,...w(v.current.disabled)?{disabled:v.current.disabled}:{}});const t=(e,t)=>{const r=y(i._fields,e);if(r&&r._f){r._f.mount=t}};t(r,true);if(e){const e=p(y(i._options.defaultValues,r));_(i._defaultValues,r,e);if(m(y(i._formValues,r))){_(i._formValues,r,e)}}!u&&i.register(r);return()=>{(u?e&&!i._state.action:e)?i.unregister(r):t(r,false)}},[r,i,u,o]);n.useEffect(()=>{i._setDisabledField({disabled:a,name:r})},[a,r,i]);return n.useMemo(()=>({field:T,formState:h,fieldState:b}),[T,h,b])}/**
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
 */const N=e=>e.render(L(e));const j=e=>{const t={};for(const r of Object.keys(e)){if(s(e[r])&&e[r]!==null){const n=j(e[r]);for(const e of Object.keys(n)){t[`${r}.${e}`]=n[e]}}else{t[r]=e[r]}}return t};const U="post";/**
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
 */function H(e){const t=A();const[r,n]=React.useState(false);const{control:a=t.control,onSubmit:i,children:o,action:s,method:u=U,headers:l,encType:c,onError:f,render:d,onSuccess:h,validateStatus:p,...v}=e;const m=async t=>{let r=false;let n="";await a.handleSubmit(async e=>{const o=new FormData;let d="";try{d=JSON.stringify(e)}catch(e){}const v=j(a._formValues);for(const e in v){o.append(e,v[e])}if(i){await i({data:e,event:t,method:u,formData:o,formDataJson:d})}if(s){try{const e=[l&&l["Content-Type"],c].some(e=>e&&e.includes("json"));const t=await fetch(String(s),{method:u,headers:{...l,...c&&c!=="multipart/form-data"?{"Content-Type":c}:{}},body:e?d:o});if(t&&(p?!p(t.status):t.status<200||t.status>=300)){r=true;f&&f({response:t});n=String(t.status)}else{h&&h({response:t})}}catch(e){r=true;f&&f({error:e})}}})(t);if(r&&e.control){e.control._subjects.state.next({isSubmitSuccessful:false});e.control.setError("root.server",{type:n})}};React.useEffect(()=>{n(true)},[]);return d?React.createElement(React.Fragment,null,d({submit:m})):React.createElement("form",{noValidate:r,action:s,method:u,encType:c,onSubmit:m,...v},o)}var B=(e,t,r,n,a)=>t?{...r[e],types:{...r[e]&&r[e].types?r[e].types:{},[n]:a||true}}:{};var Y=e=>Array.isArray(e)?e:[e];var z=()=>{let e=[];const t=t=>{for(const r of e){r.next&&r.next(t)}};const r=t=>{e.push(t);return{unsubscribe:()=>{e=e.filter(e=>e!==t)}}};const n=()=>{e=[]};return{get observers(){return e},next:t,subscribe:r,unsubscribe:n}};var q=e=>u(e)&&!Object.keys(e).length;var V=e=>e.type==="file";var W=e=>typeof e==="function";var $=e=>{if(!h){return false}const t=e?e.ownerDocument:0;return e instanceof(t&&t.defaultView?t.defaultView.HTMLElement:HTMLElement)};var G=e=>e.type===`select-multiple`;var K=e=>e.type==="radio";var Q=e=>K(e)||a(e);var X=e=>$(e)&&e.isConnected;function J(e,t){const r=t.slice(0,-1).length;let n=0;while(n<r){e=m(e)?n++:e[t[n++]]}return e}function Z(e){for(const t in e){if(e.hasOwnProperty(t)&&!m(e[t])){return false}}return true}function ee(e,t){const r=Array.isArray(t)?t:v(t)?[t]:b(t);const n=r.length===1?e:J(e,r);const a=r.length-1;const i=r[a];if(n){delete n[i]}if(a!==0&&(u(n)&&q(n)||Array.isArray(n)&&Z(n))){ee(e,r.slice(0,-1))}return e}var et=e=>{for(const t in e){if(W(e[t])){return true}}return false};function er(e,t={}){const r=Array.isArray(e);if(u(e)||r){for(const r in e){if(Array.isArray(e[r])||u(e[r])&&!et(e[r])){t[r]=Array.isArray(e[r])?[]:{};er(e[r],t[r])}else if(!o(e[r])){t[r]=true}}}return t}function en(e,t,r){const n=Array.isArray(e);if(u(e)||n){for(const n in e){if(Array.isArray(e[n])||u(e[n])&&!et(e[n])){if(m(t)||D(r[n])){r[n]=Array.isArray(e[n])?er(e[n],[]):{...er(e[n])}}else{en(e[n],o(t)?{}:t[n],r[n])}}else{r[n]=!M(e[n],t[n])}}}return r}var ea=(e,t)=>en(e,t,er(t));const ei={value:false,isValid:false};const eo={value:true,isValid:true};var es=e=>{if(Array.isArray(e)){if(e.length>1){const t=e.filter(e=>e&&e.checked&&!e.disabled).map(e=>e.value);return{value:t,isValid:!!t.length}}return e[0].checked&&!e[0].disabled?e[0].attributes&&!m(e[0].attributes.value)?m(e[0].value)||e[0].value===""?eo:{value:e[0].value,isValid:true}:eo:ei}return ei};var eu=(e,{valueAsNumber:t,valueAsDate:r,setValueAs:n})=>m(e)?e:t?e===""?NaN:e?+e:e:r&&P(e)?new Date(e):n?n(e):e;const el={isValid:false,value:null};var ec=e=>Array.isArray(e)?e.reduce((e,t)=>t&&t.checked&&!t.disabled?{isValid:true,value:t.value}:e,el):el;function ef(e){const t=e.ref;if(V(t)){return t.files}if(K(t)){return ec(e.refs).value}if(G(t)){return[...t.selectedOptions].map(({value:e})=>e)}if(a(t)){return es(e.refs).value}return eu(m(t.value)?e.ref.value:t.value,e)}var ed=(e,t,r,n)=>{const a={};for(const r of e){const e=y(t,r);e&&_(a,r,e._f)}return{criteriaMode:r,names:[...e],fields:a,shouldUseNativeValidation:n}};var eh=e=>e instanceof RegExp;var ep=e=>m(e)?e:eh(e)?e.source:u(e)?eh(e.value)?e.value.source:e.value:e;var ev=e=>({isOnSubmit:!e||e===E.onSubmit,isOnBlur:e===E.onBlur,isOnChange:e===E.onChange,isOnAll:e===E.all,isOnTouch:e===E.onTouched});const em="AsyncFunction";var eg=e=>!!e&&!!e.validate&&!!(W(e.validate)&&e.validate.constructor.name===em||u(e.validate)&&Object.values(e.validate).find(e=>e.constructor.name===em));var eb=e=>e.mount&&(e.required||e.min||e.max||e.maxLength||e.minLength||e.pattern||e.validate);var ey=(e,t,r)=>!r&&(t.watchAll||t.watch.has(e)||[...t.watch].some(t=>e.startsWith(t)&&/^\.\w+/.test(e.slice(t.length))));const ew=(e,t,r,n)=>{for(const a of r||Object.keys(e)){const r=y(e,a);if(r){const{_f:e,...i}=r;if(e){if(e.refs&&e.refs[0]&&t(e.refs[0],a)&&!n){return true}else if(e.ref&&t(e.ref,e.name)&&!n){return true}else{if(ew(i,t)){break}}}else if(u(i)){if(ew(i,t)){break}}}}return};function e_(e,t,r){const n=y(e,r);if(n||v(r)){return{error:n,name:r}}const a=r.split(".");while(a.length){const n=a.join(".");const i=y(t,n);const o=y(e,n);if(i&&!Array.isArray(i)&&r!==n){return{name:r}}if(o&&o.type){return{name:n,error:o}}if(o&&o.root&&o.root.type){return{name:`${n}.root`,error:o.root}}a.pop()}return{name:r}}var ex=(e,t,r,n)=>{r(e);const{name:a,...i}=e;return q(i)||Object.keys(i).length>=Object.keys(t).length||Object.keys(i).find(e=>t[e]===(!n||E.all))};var eE=(e,t,r)=>!e||!t||e===t||Y(e).some(e=>e&&(r?e===t:e.startsWith(t)||t.startsWith(e)));var eO=(e,t,r,n,a)=>{if(a.isOnAll){return false}else if(!r&&a.isOnTouch){return!(t||e)}else if(r?n.isOnBlur:a.isOnBlur){return!e}else if(r?n.isOnChange:a.isOnChange){return e}return true};var eS=(e,t)=>!g(y(e,t)).length&&ee(e,t);var eA=(e,t,r)=>{const n=Y(y(e,r));_(n,"root",t[r]);_(e,r,n);return e};var eT=e=>P(e);function ek(e,t,r="validate"){if(eT(e)||Array.isArray(e)&&e.every(eT)||w(e)&&!e){return{type:r,message:eT(e)?e:"",ref:t}}}var eR=e=>u(e)&&!eh(e)?e:{value:e,message:""};var eC=async(e,t,r,n,i,s)=>{const{ref:l,refs:c,required:f,maxLength:d,minLength:h,min:p,max:v,pattern:g,validate:b,name:_,valueAsNumber:x,mount:E}=e._f;const S=y(r,_);if(!E||t.has(_)){return{}}const A=c?c[0]:l;const T=e=>{if(i&&A.reportValidity){A.setCustomValidity(w(e)?"":e||"");A.reportValidity()}};const k={};const R=K(l);const C=a(l);const I=R||C;const D=(x||V(l))&&m(l.value)&&m(S)||$(l)&&l.value===""||S===""||Array.isArray(S)&&!S.length;const M=B.bind(null,_,n,k);const F=(e,t,r,n=O.maxLength,a=O.minLength)=>{const i=e?t:r;k[_]={type:e?n:a,message:i,ref:l,...M(e?n:a,i)}};if(s?!Array.isArray(S)||!S.length:f&&(!I&&(D||o(S))||w(S)&&!S||C&&!es(c).isValid||R&&!ec(c).isValid)){const{value:e,message:t}=eT(f)?{value:!!f,message:f}:eR(f);if(e){k[_]={type:O.required,message:t,ref:A,...M(O.required,t)};if(!n){T(t);return k}}}if(!D&&(!o(p)||!o(v))){let e;let t;const r=eR(v);const a=eR(p);if(!o(S)&&!isNaN(S)){const n=l.valueAsNumber||(S?+S:S);if(!o(r.value)){e=n>r.value}if(!o(a.value)){t=n<a.value}}else{const n=l.valueAsDate||new Date(S);const i=e=>new Date(new Date().toDateString()+" "+e);const o=l.type=="time";const s=l.type=="week";if(P(r.value)&&S){e=o?i(S)>i(r.value):s?S>r.value:n>new Date(r.value)}if(P(a.value)&&S){t=o?i(S)<i(a.value):s?S<a.value:n<new Date(a.value)}}if(e||t){F(!!e,r.message,a.message,O.max,O.min);if(!n){T(k[_].message);return k}}}if((d||h)&&!D&&(P(S)||s&&Array.isArray(S))){const e=eR(d);const t=eR(h);const r=!o(e.value)&&S.length>+e.value;const a=!o(t.value)&&S.length<+t.value;if(r||a){F(r,e.message,t.message);if(!n){T(k[_].message);return k}}}if(g&&!D&&P(S)){const{value:e,message:t}=eR(g);if(eh(e)&&!S.match(e)){k[_]={type:O.pattern,message:t,ref:l,...M(O.pattern,t)};if(!n){T(t);return k}}}if(b){if(W(b)){const e=await b(S,r);const t=ek(e,A);if(t){k[_]={...t,...M(O.validate,t.message)};if(!n){T(t.message);return k}}}else if(u(b)){let e={};for(const t in b){if(!q(e)&&!n){break}const a=ek(await b[t](S,r),A,t);if(a){e={...a,...M(t,a.message)};T(a.message);if(n){k[_]=e}}}if(!q(e)){k[_]={ref:A,...e};if(!n){return k}}}}T(true);return k};const eP={mode:E.onSubmit,reValidateMode:E.onChange,shouldFocusError:true};function eI(e={}){let t={...eP,...e};let r={submitCount:0,isDirty:false,isReady:false,isLoading:W(t.defaultValues),isValidating:false,isSubmitted:false,isSubmitting:false,isSubmitSuccessful:false,isValid:false,touchedFields:{},dirtyFields:{},validatingFields:{},errors:t.errors||{},disabled:t.disabled||false};let n={};let s=u(t.defaultValues)||u(t.values)?p(t.defaultValues||t.values)||{}:{};let c=t.shouldUnregister?{}:p(s);let d={action:false,mount:false,watch:false};let v={mount:new Set,disabled:new Set,unMount:new Set,array:new Set,watch:new Set};let b;let O=0;const S={isDirty:false,dirtyFields:false,validatingFields:false,touchedFields:false,isValidating:false,isValid:false,errors:false};let A={...S};const T={array:z(),state:z()};const k=t.criteriaMode===E.all;const R=e=>t=>{clearTimeout(O);O=setTimeout(e,t)};const C=async e=>{if(!t.disabled&&(S.isValid||A.isValid||e)){const e=t.resolver?q((await B()).errors):await J(n,true);if(e!==r.isValid){T.state.next({isValid:e})}}};const D=(e,n)=>{if(!t.disabled&&(S.isValidating||S.validatingFields||A.isValidating||A.validatingFields)){(e||Array.from(v.mount)).forEach(e=>{if(e){n?_(r.validatingFields,e,n):ee(r.validatingFields,e)}});T.state.next({validatingFields:r.validatingFields,isValidating:!q(r.validatingFields)})}};const F=(e,a=[],i,o,u=true,l=true)=>{if(o&&i&&!t.disabled){d.action=true;if(l&&Array.isArray(y(n,e))){const t=i(y(n,e),o.argA,o.argB);u&&_(n,e,t)}if(l&&Array.isArray(y(r.errors,e))){const t=i(y(r.errors,e),o.argA,o.argB);u&&_(r.errors,e,t);eS(r.errors,e)}if((S.touchedFields||A.touchedFields)&&l&&Array.isArray(y(r.touchedFields,e))){const t=i(y(r.touchedFields,e),o.argA,o.argB);u&&_(r.touchedFields,e,t)}if(S.dirtyFields||A.dirtyFields){r.dirtyFields=ea(s,c)}T.state.next({name:e,isDirty:et(e,a),dirtyFields:r.dirtyFields,errors:r.errors,isValid:r.isValid})}else{_(c,e,a)}};const L=(e,t)=>{_(r.errors,e,t);T.state.next({errors:r.errors})};const N=e=>{r.errors=e;T.state.next({errors:r.errors,isValid:false})};const j=(e,t,r,a)=>{const i=y(n,e);if(i){const n=y(c,e,m(r)?y(s,e):r);m(n)||a&&a.defaultChecked||t?_(c,e,t?n:ef(i._f)):ei(e,n);d.mount&&C()}};const U=(e,n,a,i,o)=>{let u=false;let l=false;const c={name:e};if(!t.disabled){if(!a||i){if(S.isDirty||A.isDirty){l=r.isDirty;r.isDirty=c.isDirty=et();u=l!==c.isDirty}const t=M(y(s,e),n);l=!!y(r.dirtyFields,e);t?ee(r.dirtyFields,e):_(r.dirtyFields,e,true);c.dirtyFields=r.dirtyFields;u=u||(S.dirtyFields||A.dirtyFields)&&l!==!t}if(a){const t=y(r.touchedFields,e);if(!t){_(r.touchedFields,e,a);c.touchedFields=r.touchedFields;u=u||(S.touchedFields||A.touchedFields)&&t!==a}}u&&o&&T.state.next(c)}return u?c:{}};const H=(e,n,a,i)=>{const o=y(r.errors,e);const s=(S.isValid||A.isValid)&&w(n)&&r.isValid!==n;if(t.delayError&&a){b=R(()=>L(e,a));b(t.delayError)}else{clearTimeout(O);b=null;a?_(r.errors,e,a):ee(r.errors,e)}if((a?!M(o,a):o)||!q(i)||s){const t={...i,...s&&w(n)?{isValid:n}:{},errors:r.errors,name:e};r={...r,...t};T.state.next(t)}};const B=async e=>{D(e,true);const r=await t.resolver(c,t.context,ed(e||v.mount,n,t.criteriaMode,t.shouldUseNativeValidation));D(e);return r};const K=async e=>{const{errors:t}=await B(e);if(e){for(const n of e){const e=y(t,n);e?_(r.errors,n,e):ee(r.errors,n)}}else{r.errors=t}return t};const J=async(e,n,a={valid:true})=>{for(const i in e){const o=e[i];if(o){const{_f:e,...s}=o;if(e){const s=v.array.has(e.name);const u=o._f&&eg(o._f);if(u&&S.validatingFields){D([i],true)}const l=await eC(o,v.disabled,c,k,t.shouldUseNativeValidation&&!n,s);if(u&&S.validatingFields){D([i])}if(l[e.name]){a.valid=false;if(n){break}}!n&&(y(l,e.name)?s?eA(r.errors,l,e.name):_(r.errors,e.name,l[e.name]):ee(r.errors,e.name))}!q(s)&&await J(s,n,a)}}return a.valid};const Z=()=>{for(const e of v.unMount){const t=y(n,e);t&&(t._f.refs?t._f.refs.every(e=>!X(e)):!X(t._f.ref))&&eL(e)}v.unMount=new Set};const et=(e,r)=>!t.disabled&&(e&&r&&_(c,e,r),!M(em(),s));const er=(e,t,r)=>I(e,v,{...d.mount?c:m(t)?s:P(e)?{[e]:t}:t},r,t);const en=e=>g(y(d.mount?c:s,e,t.shouldUnregister?y(s,e,[]):[]));const ei=(e,t,r={})=>{const i=y(n,e);let s=t;if(i){const r=i._f;if(r){!r.disabled&&_(c,e,eu(t,r));s=$(r.ref)&&o(t)?"":t;if(G(r.ref)){[...r.ref.options].forEach(e=>e.selected=s.includes(e.value))}else if(r.refs){if(a(r.ref)){r.refs.forEach(e=>{if(!e.defaultChecked||!e.disabled){if(Array.isArray(s)){e.checked=!!s.find(t=>t===e.value)}else{e.checked=s===e.value||!!s}}})}else{r.refs.forEach(e=>e.checked=e.value===s)}}else if(V(r.ref)){r.ref.value=""}else{r.ref.value=s;if(!r.ref.type){T.state.next({name:e,values:p(c)})}}}}(r.shouldDirty||r.shouldTouch)&&U(e,s,r.shouldTouch,r.shouldDirty,true);r.shouldValidate&&eh(e)};const eo=(e,t,r)=>{for(const a in t){if(!t.hasOwnProperty(a)){return}const o=t[a];const s=e+"."+a;const l=y(n,s);(v.array.has(e)||u(o)||l&&!l._f)&&!i(o)?eo(s,o,r):ei(s,o,r)}};const es=(e,t,a={})=>{const i=y(n,e);const u=v.array.has(e);const l=p(t);_(c,e,l);if(u){T.array.next({name:e,values:p(c)});if((S.isDirty||S.dirtyFields||A.isDirty||A.dirtyFields)&&a.shouldDirty){T.state.next({name:e,dirtyFields:ea(s,c),isDirty:et(e,l)})}}else{i&&!i._f&&!o(l)?eo(e,l,a):ei(e,l,a)}ey(e,v)&&T.state.next({...r,name:e});T.state.next({name:d.mount?e:undefined,values:p(c)})};const el=async e=>{d.mount=true;const a=e.target;let o=a.name;let s=true;const u=y(n,o);const f=e=>{s=Number.isNaN(e)||i(e)&&isNaN(e.getTime())||M(e,y(c,o,e))};const h=ev(t.mode);const m=ev(t.reValidateMode);if(u){let i;let d;const g=a.type?ef(u._f):l(e);const w=e.type===x.BLUR||e.type===x.FOCUS_OUT;const E=!eb(u._f)&&!t.resolver&&!y(r.errors,o)&&!u._f.deps||eO(w,y(r.touchedFields,o),r.isSubmitted,m,h);const O=ey(o,v,w);_(c,o,g);if(w){if(!a||!a.readOnly){u._f.onBlur&&u._f.onBlur(e);b&&b(0)}}else if(u._f.onChange){u._f.onChange(e)}const R=U(o,g,w);const P=!q(R)||O;!w&&T.state.next({name:o,type:e.type,values:p(c)});if(E){if(S.isValid||A.isValid){if(t.mode==="onBlur"){if(w){C()}}else if(!w){C()}}return P&&T.state.next({name:o,...O?{}:R})}!w&&O&&T.state.next({...r});if(t.resolver){const{errors:e}=await B([o]);f(g);if(s){const t=e_(r.errors,n,o);const a=e_(e,n,t.name||o);i=a.error;o=a.name;d=q(e)}}else{D([o],true);i=(await eC(u,v.disabled,c,k,t.shouldUseNativeValidation))[o];D([o]);f(g);if(s){if(i){d=false}else if(S.isValid||A.isValid){d=await J(n,true)}}}if(s){u._f.deps&&eh(u._f.deps);H(o,d,i,R)}}};const ec=(e,t)=>{if(y(r.errors,t)&&e.focus){e.focus();return 1}return};const eh=async(e,a={})=>{let i;let o;const s=Y(e);if(t.resolver){const t=await K(m(e)?e:s);i=q(t);o=e?!s.some(e=>y(t,e)):i}else if(e){o=(await Promise.all(s.map(async e=>{const t=y(n,e);return await J(t&&t._f?{[e]:t}:t)}))).every(Boolean);!(!o&&!r.isValid)&&C()}else{o=i=await J(n)}T.state.next({...!P(e)||(S.isValid||A.isValid)&&i!==r.isValid?{}:{name:e},...t.resolver||!e?{isValid:i}:{},errors:r.errors});a.shouldFocus&&!o&&ew(n,ec,e?s:v.mount);return o};const em=e=>{const t={...d.mount?c:s};return m(e)?t:P(e)?y(t,e):e.map(e=>y(t,e))};const eT=(e,t)=>({invalid:!!y((t||r).errors,e),isDirty:!!y((t||r).dirtyFields,e),error:y((t||r).errors,e),isValidating:!!y(r.validatingFields,e),isTouched:!!y((t||r).touchedFields,e)});const ek=e=>{e&&Y(e).forEach(e=>ee(r.errors,e));T.state.next({errors:e?r.errors:{}})};const eR=(e,t,a)=>{const i=(y(n,e,{_f:{}})._f||{}).ref;const o=y(r.errors,e)||{};// Don't override existing error messages elsewhere in the object tree.
const{ref:s,message:u,type:l,...c}=o;_(r.errors,e,{...c,...t,ref:i});T.state.next({name:e,errors:r.errors,isValid:false});a&&a.shouldFocus&&i&&i.focus&&i.focus()};const eD=(e,t)=>W(e)?T.state.subscribe({next:r=>"values"in r&&e(er(undefined,t),r)}):er(e,t,true);const eM=e=>T.state.subscribe({next:t=>{if(eE(e.name,t.name,e.exact)&&ex(t,e.formState||S,eW,e.reRenderRoot)){e.callback({values:{...c},...r,...t,defaultValues:s})}}}).unsubscribe;const eF=e=>{d.mount=true;A={...A,...e.formState};return eM({...e,formState:A})};const eL=(e,a={})=>{for(const i of e?Y(e):v.mount){v.mount.delete(i);v.array.delete(i);if(!a.keepValue){ee(n,i);ee(c,i)}!a.keepError&&ee(r.errors,i);!a.keepDirty&&ee(r.dirtyFields,i);!a.keepTouched&&ee(r.touchedFields,i);!a.keepIsValidating&&ee(r.validatingFields,i);!t.shouldUnregister&&!a.keepDefaultValue&&ee(s,i)}T.state.next({values:p(c)});T.state.next({...r,...!a.keepDirty?{}:{isDirty:et()}});!a.keepIsValid&&C()};const eN=({disabled:e,name:t})=>{if(w(e)&&d.mount||!!e||v.disabled.has(t)){e?v.disabled.add(t):v.disabled.delete(t)}};const ej=(e,r={})=>{let a=y(n,e);const i=w(r.disabled)||w(t.disabled);_(n,e,{...a||{},_f:{...a&&a._f?a._f:{ref:{name:e}},name:e,mount:true,...r}});v.mount.add(e);if(a){eN({disabled:w(r.disabled)?r.disabled:t.disabled,name:e})}else{j(e,true,r.value)}return{...i?{disabled:r.disabled||t.disabled}:{},...t.progressive?{required:!!r.required,min:ep(r.min),max:ep(r.max),minLength:ep(r.minLength),maxLength:ep(r.maxLength),pattern:ep(r.pattern)}:{},name:e,onChange:el,onBlur:el,ref:i=>{if(i){ej(e,r);a=y(n,e);const t=m(i.value)?i.querySelectorAll?i.querySelectorAll("input,select,textarea")[0]||i:i:i;const o=Q(t);const u=a._f.refs||[];if(o?u.find(e=>e===t):t===a._f.ref){return}_(n,e,{_f:{...a._f,...o?{refs:[...u.filter(X),t,...Array.isArray(y(s,e))?[{}]:[]],ref:{type:t.type,name:e}}:{ref:t}}});j(e,false,undefined,t)}else{a=y(n,e,{});if(a._f){a._f.mount=false}(t.shouldUnregister||r.shouldUnregister)&&!(f(v.array,e)&&d.action)&&v.unMount.add(e)}}}};const eU=()=>t.shouldFocusError&&ew(n,ec,v.mount);const eH=e=>{if(w(e)){T.state.next({disabled:e});ew(n,(t,r)=>{const a=y(n,r);if(a){t.disabled=a._f.disabled||e;if(Array.isArray(a._f.refs)){a._f.refs.forEach(t=>{t.disabled=a._f.disabled||e})}}},0,false)}};const eB=(e,a)=>async i=>{let o=undefined;if(i){i.preventDefault&&i.preventDefault();i.persist&&i.persist()}let s=p(c);T.state.next({isSubmitting:true});if(t.resolver){const{errors:e,values:t}=await B();r.errors=e;s=p(t)}else{await J(n)}if(v.disabled.size){for(const e of v.disabled){ee(s,e)}}ee(r.errors,"root");if(q(r.errors)){T.state.next({errors:{}});try{await e(s,i)}catch(e){o=e}}else{if(a){await a({...r.errors},i)}eU();setTimeout(eU)}T.state.next({isSubmitted:true,isSubmitting:false,isSubmitSuccessful:q(r.errors)&&!o,submitCount:r.submitCount+1,errors:r.errors});if(o){throw o}};const eY=(e,t={})=>{if(y(n,e)){if(m(t.defaultValue)){es(e,p(y(s,e)))}else{es(e,t.defaultValue);_(s,e,p(t.defaultValue))}if(!t.keepTouched){ee(r.touchedFields,e)}if(!t.keepDirty){ee(r.dirtyFields,e);r.isDirty=t.defaultValue?et(e,p(y(s,e))):et()}if(!t.keepError){ee(r.errors,e);S.isValid&&C()}T.state.next({...r})}};const ez=(e,a={})=>{const i=e?p(e):s;const o=p(i);const u=q(e);const l=u?s:o;if(!a.keepDefaultValues){s=i}if(!a.keepValues){if(a.keepDirtyValues){const e=new Set([...v.mount,...Object.keys(ea(s,c))]);for(const t of Array.from(e)){y(r.dirtyFields,t)?_(l,t,y(c,t)):es(t,y(l,t))}}else{if(h&&m(e)){for(const e of v.mount){const t=y(n,e);if(t&&t._f){const e=Array.isArray(t._f.refs)?t._f.refs[0]:t._f.ref;if($(e)){const t=e.closest("form");if(t){t.reset();break}}}}}if(a.keepFieldsRef){for(const e of v.mount){es(e,y(l,e))}}else{n={}}}c=t.shouldUnregister?a.keepDefaultValues?p(s):{}:p(l);T.array.next({values:{...l}});T.state.next({values:{...l}})}v={mount:a.keepDirtyValues?v.mount:new Set,unMount:new Set,array:new Set,disabled:new Set,watch:new Set,watchAll:false,focus:""};d.mount=!S.isValid||!!a.keepIsValid||!!a.keepDirtyValues;d.watch=!!t.shouldUnregister;T.state.next({submitCount:a.keepSubmitCount?r.submitCount:0,isDirty:u?false:a.keepDirty?r.isDirty:!!(a.keepDefaultValues&&!M(e,s)),isSubmitted:a.keepIsSubmitted?r.isSubmitted:false,dirtyFields:u?{}:a.keepDirtyValues?a.keepDefaultValues&&c?ea(s,c):r.dirtyFields:a.keepDefaultValues&&e?ea(s,e):a.keepDirty?r.dirtyFields:{},touchedFields:a.keepTouched?r.touchedFields:{},errors:a.keepErrors?r.errors:{},isSubmitSuccessful:a.keepIsSubmitSuccessful?r.isSubmitSuccessful:false,isSubmitting:false,defaultValues:s})};const eq=(e,t)=>ez(W(e)?e(c):e,t);const eV=(e,t={})=>{const r=y(n,e);const a=r&&r._f;if(a){const e=a.refs?a.refs[0]:a.ref;if(e.focus){e.focus();t.shouldSelect&&W(e.select)&&e.select()}}};const eW=e=>{r={...r,...e}};const e$=()=>W(t.defaultValues)&&t.defaultValues().then(e=>{eq(e,t.resetOptions);T.state.next({isLoading:false})});const eG={control:{register:ej,unregister:eL,getFieldState:eT,handleSubmit:eB,setError:eR,_subscribe:eM,_runSchema:B,_focusError:eU,_getWatch:er,_getDirty:et,_setValid:C,_setFieldArray:F,_setDisabledField:eN,_setErrors:N,_getFieldArray:en,_reset:ez,_resetDefaultValues:e$,_removeUnmounted:Z,_disableForm:eH,_subjects:T,_proxyFormState:S,get _fields(){return n},get _formValues(){return c},get _state(){return d},set _state(value){d=value},get _defaultValues(){return s},get _names(){return v},set _names(value){v=value},get _formState(){return r},get _options(){return t},set _options(value){t={...t,...value}}},subscribe:eF,trigger:eh,register:ej,handleSubmit:eB,watch:eD,setValue:es,getValues:em,reset:eq,resetField:eY,clearErrors:ek,unregister:eL,setError:eR,setFocus:eV,getFieldState:eT};return{...eG,formControl:eG}}var eD=()=>{if(typeof crypto!=="undefined"&&crypto.randomUUID){return crypto.randomUUID()}const e=typeof performance==="undefined"?Date.now():performance.now()*1e3;return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,t=>{const r=(Math.random()*16+e)%16|0;return(t=="x"?r:r&3|8).toString(16)})};var eM=(e,t,r={})=>r.shouldFocus||m(r.shouldFocus)?r.focusName||`${e}.${m(r.focusIndex)?t:r.focusIndex}.`:"";var eF=(e,t)=>[...e,...Y(t)];var eL=e=>Array.isArray(e)?e.map(()=>undefined):undefined;function eN(e,t,r){return[...e.slice(0,t),...Y(r),...e.slice(t)]}var ej=(e,t,r)=>{if(!Array.isArray(e)){return[]}if(m(e[r])){e[r]=undefined}e.splice(r,0,e.splice(t,1)[0]);return e};var eU=(e,t)=>[...Y(t),...Y(e)];function eH(e,t){let r=0;const n=[...e];for(const e of t){n.splice(e-r,1);r++}return g(n).length?n:[]}var eB=(e,t)=>m(t)?[]:eH(e,Y(t).sort((e,t)=>e-t));var eY=(e,t,r)=>{[e[t],e[r]]=[e[r],e[t]]};var ez=(e,t,r)=>{e[t]=r;return e};/**
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
 */function eq(e){const t=A();const{control:r=t.control,name:a,keyName:i="id",shouldUnregister:o,rules:s}=e;const[u,l]=n.useState(r._getFieldArray(a));const c=n.useRef(r._getFieldArray(a).map(eD));const f=n.useRef(u);const d=n.useRef(false);f.current=u;r._names.array.add(a);n.useMemo(()=>s&&r.register(a,s),[r,s,a]);R(()=>r._subjects.array.subscribe({next:({values:e,name:t})=>{if(t===a||!t){const t=y(e,a);if(Array.isArray(t)){l(t);c.current=t.map(eD)}}}}).unsubscribe,[r,a]);const h=n.useCallback(e=>{d.current=true;r._setFieldArray(a,e)},[r,a]);const v=(e,t)=>{const n=Y(p(e));const i=eF(r._getFieldArray(a),n);r._names.focus=eM(a,i.length-1,t);c.current=eF(c.current,n.map(eD));h(i);l(i);r._setFieldArray(a,i,eF,{argA:eL(e)})};const m=(e,t)=>{const n=Y(p(e));const i=eU(r._getFieldArray(a),n);r._names.focus=eM(a,0,t);c.current=eU(c.current,n.map(eD));h(i);l(i);r._setFieldArray(a,i,eU,{argA:eL(e)})};const g=e=>{const t=eB(r._getFieldArray(a),e);c.current=eB(c.current,e);h(t);l(t);!Array.isArray(y(r._fields,a))&&_(r._fields,a,undefined);r._setFieldArray(a,t,eB,{argA:e})};const b=(e,t,n)=>{const i=Y(p(t));const o=eN(r._getFieldArray(a),e,i);r._names.focus=eM(a,e,n);c.current=eN(c.current,e,i.map(eD));h(o);l(o);r._setFieldArray(a,o,eN,{argA:e,argB:eL(t)})};const w=(e,t)=>{const n=r._getFieldArray(a);eY(n,e,t);eY(c.current,e,t);h(n);l(n);r._setFieldArray(a,n,eY,{argA:e,argB:t},false)};const x=(e,t)=>{const n=r._getFieldArray(a);ej(n,e,t);ej(c.current,e,t);h(n);l(n);r._setFieldArray(a,n,ej,{argA:e,argB:t},false)};const O=(e,t)=>{const n=p(t);const i=ez(r._getFieldArray(a),e,n);c.current=[...i].map((t,r)=>!t||r===e?eD():c.current[r]);h(i);l([...i]);r._setFieldArray(a,i,ez,{argA:e,argB:n},true,false)};const S=e=>{const t=Y(p(e));c.current=t.map(eD);h([...t]);l([...t]);r._setFieldArray(a,[...t],e=>e,{},true,false)};n.useEffect(()=>{r._state.action=false;ey(a,r._names)&&r._subjects.state.next({...r._formState});if(d.current&&(!ev(r._options.mode).isOnSubmit||r._formState.isSubmitted)&&!ev(r._options.reValidateMode).isOnSubmit){if(r._options.resolver){r._runSchema([a]).then(e=>{const t=y(e.errors,a);const n=y(r._formState.errors,a);if(n?!t&&n.type||t&&(n.type!==t.type||n.message!==t.message):t&&t.type){t?_(r._formState.errors,a,t):ee(r._formState.errors,a);r._subjects.state.next({errors:r._formState.errors})}})}else{const e=y(r._fields,a);if(e&&e._f&&!(ev(r._options.reValidateMode).isOnSubmit&&ev(r._options.mode).isOnSubmit)){eC(e,r._names.disabled,r._formValues,r._options.criteriaMode===E.all,r._options.shouldUseNativeValidation,true).then(e=>!q(e)&&r._subjects.state.next({errors:eA(r._formState.errors,e,a)}))}}}r._subjects.state.next({name:a,values:p(r._formValues)});r._names.focus&&ew(r._fields,(e,t)=>{if(r._names.focus&&t.startsWith(r._names.focus)&&e.focus){e.focus();return 1}return});r._names.focus="";r._setValid();d.current=false},[u,a,r]);n.useEffect(()=>{!y(r._formValues,a)&&r._setFieldArray(a);return()=>{const e=(e,t)=>{const n=y(r._fields,e);if(n&&n._f){n._f.mount=t}};r._options.shouldUnregister||o?r.unregister(a):e(a,false)}},[a,r,i,o]);return{swap:n.useCallback(w,[h,a,r]),move:n.useCallback(x,[h,a,r]),prepend:n.useCallback(m,[h,a,r]),append:n.useCallback(v,[h,a,r]),remove:n.useCallback(g,[h,a,r]),insert:n.useCallback(b,[h,a,r]),update:n.useCallback(O,[h,a,r]),replace:n.useCallback(S,[h,a,r]),fields:n.useMemo(()=>u.map((e,t)=>({...e,[i]:c.current[t]||eD()})),[u,i])}}/**
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
 */function eV(e={}){const t=n.useRef(undefined);const r=n.useRef(undefined);const[a,i]=n.useState({isDirty:false,isValidating:false,isLoading:W(e.defaultValues),isSubmitted:false,isSubmitting:false,isSubmitSuccessful:false,isValid:false,submitCount:0,dirtyFields:{},touchedFields:{},validatingFields:{},errors:e.errors||{},disabled:e.disabled||false,isReady:false,defaultValues:W(e.defaultValues)?undefined:e.defaultValues});if(!t.current){if(e.formControl){t.current={...e.formControl,formState:a};if(e.defaultValues&&!W(e.defaultValues)){e.formControl.reset(e.defaultValues,e.resetOptions)}}else{const{formControl:r,...n}=eI(e);t.current={...n,formState:a}}}const o=t.current.control;o._options=e;R(()=>{const e=o._subscribe({formState:o._proxyFormState,callback:()=>i({...o._formState}),reRenderRoot:true});i(e=>({...e,isReady:true}));o._formState.isReady=true;return e},[o]);n.useEffect(()=>o._disableForm(e.disabled),[o,e.disabled]);n.useEffect(()=>{if(e.mode){o._options.mode=e.mode}if(e.reValidateMode){o._options.reValidateMode=e.reValidateMode}},[o,e.mode,e.reValidateMode]);n.useEffect(()=>{if(e.errors){o._setErrors(e.errors);o._focusError()}},[o,e.errors]);n.useEffect(()=>{e.shouldUnregister&&o._subjects.state.next({values:o._getWatch()})},[o,e.shouldUnregister]);n.useEffect(()=>{if(o._proxyFormState.isDirty){const e=o._getDirty();if(e!==a.isDirty){o._subjects.state.next({isDirty:e})}}},[o,a.isDirty]);n.useEffect(()=>{if(e.values&&!M(e.values,r.current)){o._reset(e.values,{keepFieldsRef:true,...o._options.resetOptions});r.current=e.values;i(e=>({...e}))}else{o._resetDefaultValues()}},[o,e.values]);n.useEffect(()=>{if(!o._state.mount){o._setValid();o._state.mount=true}if(o._state.watch){o._state.watch=false;o._subjects.state.next({...o._formState})}o._removeUnmounted()});t.current.formState=k(a,o);return t.current}//# sourceMappingURL=index.esm.mjs.map
},9239:function(e,t,r){"use strict";r.d(t,{A:()=>n});function n(e){"@babel/helpers - typeof";return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}},28:function(e,t,r){"use strict";// EXPORTS
r.d(t,{CS:()=>/* binding */nx,le:()=>/* reexport */eC,zh:()=>/* reexport */r$,pn:()=>/* reexport */rJ});// UNUSED EXPORTS: useInView, FrameValue, inferTo, to, BailSignal, Spring, useIsomorphicLayoutEffect, Trail, useReducedMotion, useChain, Controller, useResize, a, interpolate, useSprings, config, useSpringValue, update, useTrail, useSpringRef, Interpolation, SpringContext, SpringValue, useScroll, Transition, Any, SpringRef, createInterpolator, Globals
;// CONCATENATED MODULE: ../tutor/node_modules/@react-spring/rafz/dist/react-spring_rafz.modern.mjs
// src/index.ts
var n=w();var a=e=>v(e,n);var i=w();a.write=e=>v(e,i);var o=w();a.onStart=e=>v(e,o);var s=w();a.onFrame=e=>v(e,s);var u=w();a.onFinish=e=>v(e,u);var l=[];a.setTimeout=(e,t)=>{const r=a.now()+t;const n=()=>{const e=l.findIndex(e=>e.cancel==n);if(~e)l.splice(e,1);h-=~e?1:0};const i={time:r,handler:e,cancel:n};l.splice(c(r),0,i);h+=1;m();return i};var c=e=>~(~l.findIndex(t=>t.time>e)||~l.length);a.cancel=e=>{o.delete(e);s.delete(e);u.delete(e);n.delete(e);i.delete(e)};a.sync=e=>{p=true;a.batchedUpdates(e);p=false};a.throttle=e=>{let t;function r(){try{e(...t)}finally{t=null}}function n(...e){t=e;a.onStart(r)}n.handler=e;n.cancel=()=>{o.delete(r);t=null};return n};var f=typeof window!="undefined"?window.requestAnimationFrame:// eslint-disable-next-line @typescript-eslint/no-empty-function
()=>{};a.use=e=>f=e;a.now=typeof performance!="undefined"?()=>performance.now():Date.now;a.batchedUpdates=e=>e();a.catch=console.error;a.frameLoop="always";a.advance=()=>{if(a.frameLoop!=="demand"){console.warn("Cannot call the manual advancement of rafz whilst frameLoop is not set as demand")}else{y()}};var d=-1;var h=0;var p=false;function v(e,t){if(p){t.delete(e);e(0)}else{t.add(e);m()}}function m(){if(d<0){d=0;if(a.frameLoop!=="demand"){f(b)}}}function g(){d=-1}function b(){if(~d){f(b);a.batchedUpdates(y)}}function y(){const e=d;d=a.now();const t=c(d);if(t){_(l.splice(0,t),e=>e.handler());h-=t}if(!h){g();return}o.flush();n.flush(e?Math.min(64,d-e):16.667);s.flush();i.flush();u.flush()}function w(){let e=/* @__PURE__ */new Set;let t=e;return{add(r){h+=t==e&&!e.has(r)?1:0;e.add(r)},delete(r){h-=t==e&&e.has(r)?1:0;return e.delete(r)},flush(r){if(t.size){e=/* @__PURE__ */new Set;h-=t.size;_(t,t=>t(r)&&e.add(t));h+=e.size;t=e}}}}function _(e,t){e.forEach(e=>{try{t(e)}catch(e){a.catch(e)}})}var x=/* unused pure expression or super */null&&{/** The number of pending tasks */count(){return h},/** Whether there's a raf update loop running */isRunning(){return d>=0},/** Clear internal state. Never call from update loop! */clear(){d=-1;l=[];o=w();n=w();s=w();i=w();u=w();h=0}};//# sourceMappingURL=react-spring_rafz.modern.mjs.map
// EXTERNAL MODULE: external "React"
var E=r(1594);// CONCATENATED MODULE: ../tutor/node_modules/@react-spring/shared/dist/react-spring_shared.modern.mjs
var O=Object.defineProperty;var S=(e,t)=>{for(var r in t)O(e,r,{get:t[r],enumerable:true})};// src/globals.ts
var A={};S(A,{assign:()=>Y,colors:()=>U,createStringInterpolator:()=>N,skipAnimation:()=>H,to:()=>j,willAdvance:()=>B});// src/helpers.ts
function T(){}var k=(e,t,r)=>Object.defineProperty(e,t,{value:r,writable:true,configurable:true});var R={arr:Array.isArray,obj:e=>!!e&&e.constructor.name==="Object",fun:e=>typeof e==="function",str:e=>typeof e==="string",num:e=>typeof e==="number",und:e=>e===void 0};function C(e,t){if(R.arr(e)){if(!R.arr(t)||e.length!==t.length)return false;for(let r=0;r<e.length;r++){if(e[r]!==t[r])return false}return true}return e===t}var P=(e,t)=>e.forEach(t);function I(e,t,r){if(R.arr(e)){for(let n=0;n<e.length;n++){t.call(r,e[n],`${n}`)}return}for(const n in e){if(e.hasOwnProperty(n)){t.call(r,e[n],n)}}}var D=e=>R.und(e)?[]:R.arr(e)?e:[e];function M(e,t){if(e.size){const r=Array.from(e);e.clear();P(r,t)}}var F=(e,...t)=>M(e,e=>e(...t));var L=()=>typeof window==="undefined"||!window.navigator||/ServerSideRendering|^Deno\//.test(window.navigator.userAgent);// src/globals.ts
var N;var j;var U=null;var H=false;var B=T;var Y=e=>{if(e.to)j=e.to;if(e.now)a.now=e.now;if(e.colors!==void 0)U=e.colors;if(e.skipAnimation!=null)H=e.skipAnimation;if(e.createStringInterpolator)N=e.createStringInterpolator;if(e.requestAnimationFrame)a.use(e.requestAnimationFrame);if(e.batchedUpdates)a.batchedUpdates=e.batchedUpdates;if(e.willAdvance)B=e.willAdvance;if(e.frameLoop)a.frameLoop=e.frameLoop};// src/FrameLoop.ts
var z=/* @__PURE__ */new Set;var q=[];var V=[];var W=0;var $={get idle(){return!z.size&&!q.length},/** Advance the given animation on every frame until idle. */start(e){if(W>e.priority){z.add(e);a.onStart(G)}else{K(e);a(X)}},/** Advance all animations by the given time. */advance:X,/** Call this when an animation's priority changes. */sort(e){if(W){a.onFrame(()=>$.sort(e))}else{const t=q.indexOf(e);if(~t){q.splice(t,1);Q(e)}}},/**
   * Clear all animations. For testing purposes.
   *
   * ☠️ Never call this from within the frameloop.
   */clear(){q=[];z.clear()}};function G(){z.forEach(K);z.clear();a(X)}function K(e){if(!q.includes(e))Q(e)}function Q(e){q.splice(J(q,t=>t.priority>e.priority),0,e)}function X(e){const t=V;for(let r=0;r<q.length;r++){const n=q[r];W=n.priority;if(!n.idle){B(n);n.advance(e);if(!n.idle){t.push(n)}}}W=0;V=q;V.length=0;q=t;return q.length>0}function J(e,t){const r=e.findIndex(t);return r<0?e.length:r}// src/clamp.ts
var Z=(e,t,r)=>Math.min(Math.max(r,e),t);// src/colors.ts
var ee={transparent:0,aliceblue:0xf0f8ffff,antiquewhite:0xfaebd7ff,aqua:0xffffff,aquamarine:0x7fffd4ff,azure:0xf0ffffff,beige:0xf5f5dcff,bisque:0xffe4c4ff,black:255,blanchedalmond:0xffebcdff,blue:65535,blueviolet:0x8a2be2ff,brown:0xa52a2aff,burlywood:0xdeb887ff,burntsienna:0xea7e5dff,cadetblue:0x5f9ea0ff,chartreuse:0x7fff00ff,chocolate:0xd2691eff,coral:0xff7f50ff,cornflowerblue:0x6495edff,cornsilk:0xfff8dcff,crimson:0xdc143cff,cyan:0xffffff,darkblue:35839,darkcyan:9145343,darkgoldenrod:0xb8860bff,darkgray:0xa9a9a9ff,darkgreen:6553855,darkgrey:0xa9a9a9ff,darkkhaki:0xbdb76bff,darkmagenta:0x8b008bff,darkolivegreen:0x556b2fff,darkorange:0xff8c00ff,darkorchid:0x9932ccff,darkred:0x8b0000ff,darksalmon:0xe9967aff,darkseagreen:0x8fbc8fff,darkslateblue:0x483d8bff,darkslategray:0x2f4f4fff,darkslategrey:0x2f4f4fff,darkturquoise:0xced1ff,darkviolet:0x9400d3ff,deeppink:0xff1493ff,deepskyblue:0xbfffff,dimgray:0x696969ff,dimgrey:0x696969ff,dodgerblue:0x1e90ffff,firebrick:0xb22222ff,floralwhite:0xfffaf0ff,forestgreen:0x228b22ff,fuchsia:0xff00ffff,gainsboro:0xdcdcdcff,ghostwhite:0xf8f8ffff,gold:0xffd700ff,goldenrod:0xdaa520ff,gray:0x808080ff,green:8388863,greenyellow:0xadff2fff,grey:0x808080ff,honeydew:0xf0fff0ff,hotpink:0xff69b4ff,indianred:0xcd5c5cff,indigo:0x4b0082ff,ivory:0xfffff0ff,khaki:0xf0e68cff,lavender:0xe6e6faff,lavenderblush:0xfff0f5ff,lawngreen:0x7cfc00ff,lemonchiffon:0xfffacdff,lightblue:0xadd8e6ff,lightcoral:0xf08080ff,lightcyan:0xe0ffffff,lightgoldenrodyellow:0xfafad2ff,lightgray:0xd3d3d3ff,lightgreen:0x90ee90ff,lightgrey:0xd3d3d3ff,lightpink:0xffb6c1ff,lightsalmon:0xffa07aff,lightseagreen:0x20b2aaff,lightskyblue:0x87cefaff,lightslategray:0x778899ff,lightslategrey:0x778899ff,lightsteelblue:0xb0c4deff,lightyellow:0xffffe0ff,lime:0xff00ff,limegreen:0x32cd32ff,linen:0xfaf0e6ff,magenta:0xff00ffff,maroon:0x800000ff,mediumaquamarine:0x66cdaaff,mediumblue:52735,mediumorchid:0xba55d3ff,mediumpurple:0x9370dbff,mediumseagreen:0x3cb371ff,mediumslateblue:0x7b68eeff,mediumspringgreen:0xfa9aff,mediumturquoise:0x48d1ccff,mediumvioletred:0xc71585ff,midnightblue:0x191970ff,mintcream:0xf5fffaff,mistyrose:0xffe4e1ff,moccasin:0xffe4b5ff,navajowhite:0xffdeadff,navy:33023,oldlace:0xfdf5e6ff,olive:0x808000ff,olivedrab:0x6b8e23ff,orange:0xffa500ff,orangered:0xff4500ff,orchid:0xda70d6ff,palegoldenrod:0xeee8aaff,palegreen:0x98fb98ff,paleturquoise:0xafeeeeff,palevioletred:0xdb7093ff,papayawhip:0xffefd5ff,peachpuff:0xffdab9ff,peru:0xcd853fff,pink:0xffc0cbff,plum:0xdda0ddff,powderblue:0xb0e0e6ff,purple:0x800080ff,rebeccapurple:0x663399ff,red:0xff0000ff,rosybrown:0xbc8f8fff,royalblue:0x4169e1ff,saddlebrown:0x8b4513ff,salmon:0xfa8072ff,sandybrown:0xf4a460ff,seagreen:0x2e8b57ff,seashell:0xfff5eeff,sienna:0xa0522dff,silver:0xc0c0c0ff,skyblue:0x87ceebff,slateblue:0x6a5acdff,slategray:0x708090ff,slategrey:0x708090ff,snow:0xfffafaff,springgreen:0xff7fff,steelblue:0x4682b4ff,tan:0xd2b48cff,teal:8421631,thistle:0xd8bfd8ff,tomato:0xff6347ff,turquoise:0x40e0d0ff,violet:0xee82eeff,wheat:0xf5deb3ff,white:0xffffffff,whitesmoke:0xf5f5f5ff,yellow:0xffff00ff,yellowgreen:0x9acd32ff};// src/colorMatchers.ts
var et="[-+]?\\d*\\.?\\d+";var er=et+"%";function en(...e){return"\\(\\s*("+e.join(")\\s*,\\s*(")+")\\s*\\)"}var ea=new RegExp("rgb"+en(et,et,et));var ei=new RegExp("rgba"+en(et,et,et,et));var eo=new RegExp("hsl"+en(et,er,er));var es=new RegExp("hsla"+en(et,er,er,et));var eu=/^#([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/;var el=/^#([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/;var ec=/^#([0-9a-fA-F]{6})$/;var ef=/^#([0-9a-fA-F]{8})$/;// src/normalizeColor.ts
function ed(e){let t;if(typeof e==="number"){return e>>>0===e&&e>=0&&e<=0xffffffff?e:null}if(t=ec.exec(e))return parseInt(t[1]+"ff",16)>>>0;if(U&&U[e]!==void 0){return U[e]}if(t=ea.exec(e)){return(ev(t[1])<<24|// r
ev(t[2])<<16|// g
ev(t[3])<<8|// b
255)>>>// a
0}if(t=ei.exec(e)){return(ev(t[1])<<24|// r
ev(t[2])<<16|// g
ev(t[3])<<8|// b
eg(t[4]))>>>// a
0}if(t=eu.exec(e)){return parseInt(t[1]+t[1]+// r
t[2]+t[2]+// g
t[3]+t[3]+// b
"ff",// a
16)>>>0}if(t=ef.exec(e))return parseInt(t[1],16)>>>0;if(t=el.exec(e)){return parseInt(t[1]+t[1]+// r
t[2]+t[2]+// g
t[3]+t[3]+// b
t[4]+t[4],// a
16)>>>0}if(t=eo.exec(e)){return(ep(em(t[1]),// h
eb(t[2]),// s
eb(t[3]))|255)>>>// a
0}if(t=es.exec(e)){return(ep(em(t[1]),// h
eb(t[2]),// s
eb(t[3]))|eg(t[4]))>>>// a
0}return null}function eh(e,t,r){if(r<0)r+=1;if(r>1)r-=1;if(r<1/6)return e+(t-e)*6*r;if(r<1/2)return t;if(r<2/3)return e+(t-e)*(2/3-r)*6;return e}function ep(e,t,r){const n=r<.5?r*(1+t):r+t-r*t;const a=2*r-n;const i=eh(a,n,e+1/3);const o=eh(a,n,e);const s=eh(a,n,e-1/3);return Math.round(i*255)<<24|Math.round(o*255)<<16|Math.round(s*255)<<8}function ev(e){const t=parseInt(e,10);if(t<0)return 0;if(t>255)return 255;return t}function em(e){const t=parseFloat(e);return(t%360+360)%360/360}function eg(e){const t=parseFloat(e);if(t<0)return 0;if(t>1)return 255;return Math.round(t*255)}function eb(e){const t=parseFloat(e);if(t<0)return 0;if(t>100)return 1;return t/100}// src/colorToRgba.ts
function ey(e){let t=ed(e);if(t===null)return e;t=t||0;const r=(t&0xff000000)>>>24;const n=(t&0xff0000)>>>16;const a=(t&65280)>>>8;const i=(t&255)/255;return`rgba(${r}, ${n}, ${a}, ${i})`}// src/createInterpolator.ts
var ew=(e,t,r)=>{if(R.fun(e)){return e}if(R.arr(e)){return ew({range:e,output:t,extrapolate:r})}if(R.str(e.output[0])){return N(e)}const n=e;const a=n.output;const i=n.range||[0,1];const o=n.extrapolateLeft||n.extrapolate||"extend";const s=n.extrapolateRight||n.extrapolate||"extend";const u=n.easing||(e=>e);return e=>{const t=ex(e,i);return e_(e,i[t],i[t+1],a[t],a[t+1],u,o,s,n.map)}};function e_(e,t,r,n,a,i,o,s,u){let l=u?u(e):e;if(l<t){if(o==="identity")return l;else if(o==="clamp")l=t}if(l>r){if(s==="identity")return l;else if(s==="clamp")l=r}if(n===a)return n;if(t===r)return e<=t?n:a;if(t===-Infinity)l=-l;else if(r===Infinity)l=l-t;else l=(l-t)/(r-t);l=i(l);if(n===-Infinity)l=-l;else if(a===Infinity)l=l+n;else l=l*(a-n)+n;return l}function ex(e,t){for(var r=1;r<t.length-1;++r)if(t[r]>=e)break;return r-1}// src/easings.ts
var eE=(e,t="end")=>r=>{r=t==="end"?Math.min(r,.999):Math.max(r,.001);const n=r*e;const a=t==="end"?Math.floor(n):Math.ceil(n);return Z(0,1,a/e)};var eO=1.70158;var eS=eO*1.525;var eA=eO+1;var eT=2*Math.PI/3;var ek=2*Math.PI/4.5;var eR=e=>{const t=7.5625;const r=2.75;if(e<1/r){return t*e*e}else if(e<2/r){return t*(e-=1.5/r)*e+.75}else if(e<2.5/r){return t*(e-=2.25/r)*e+.9375}else{return t*(e-=2.625/r)*e+.984375}};var eC={linear:e=>e,easeInQuad:e=>e*e,easeOutQuad:e=>1-(1-e)*(1-e),easeInOutQuad:e=>e<.5?2*e*e:1-Math.pow(-2*e+2,2)/2,easeInCubic:e=>e*e*e,easeOutCubic:e=>1-Math.pow(1-e,3),easeInOutCubic:e=>e<.5?4*e*e*e:1-Math.pow(-2*e+2,3)/2,easeInQuart:e=>e*e*e*e,easeOutQuart:e=>1-Math.pow(1-e,4),easeInOutQuart:e=>e<.5?8*e*e*e*e:1-Math.pow(-2*e+2,4)/2,easeInQuint:e=>e*e*e*e*e,easeOutQuint:e=>1-Math.pow(1-e,5),easeInOutQuint:e=>e<.5?16*e*e*e*e*e:1-Math.pow(-2*e+2,5)/2,easeInSine:e=>1-Math.cos(e*Math.PI/2),easeOutSine:e=>Math.sin(e*Math.PI/2),easeInOutSine:e=>-(Math.cos(Math.PI*e)-1)/2,easeInExpo:e=>e===0?0:Math.pow(2,10*e-10),easeOutExpo:e=>e===1?1:1-Math.pow(2,-10*e),easeInOutExpo:e=>e===0?0:e===1?1:e<.5?Math.pow(2,20*e-10)/2:(2-Math.pow(2,-20*e+10))/2,easeInCirc:e=>1-Math.sqrt(1-Math.pow(e,2)),easeOutCirc:e=>Math.sqrt(1-Math.pow(e-1,2)),easeInOutCirc:e=>e<.5?(1-Math.sqrt(1-Math.pow(2*e,2)))/2:(Math.sqrt(1-Math.pow(-2*e+2,2))+1)/2,easeInBack:e=>eA*e*e*e-eO*e*e,easeOutBack:e=>1+eA*Math.pow(e-1,3)+eO*Math.pow(e-1,2),easeInOutBack:e=>e<.5?Math.pow(2*e,2)*((eS+1)*2*e-eS)/2:(Math.pow(2*e-2,2)*((eS+1)*(e*2-2)+eS)+2)/2,easeInElastic:e=>e===0?0:e===1?1:-Math.pow(2,10*e-10)*Math.sin((e*10-10.75)*eT),easeOutElastic:e=>e===0?0:e===1?1:Math.pow(2,-10*e)*Math.sin((e*10-.75)*eT)+1,easeInOutElastic:e=>e===0?0:e===1?1:e<.5?-(Math.pow(2,20*e-10)*Math.sin((20*e-11.125)*ek))/2:Math.pow(2,-20*e+10)*Math.sin((20*e-11.125)*ek)/2+1,easeInBounce:e=>1-eR(1-e),easeOutBounce:eR,easeInOutBounce:e=>e<.5?(1-eR(1-2*e))/2:(1+eR(2*e-1))/2,steps:eE};// src/fluids.ts
var eP=Symbol.for("FluidValue.get");var eI=Symbol.for("FluidValue.observers");var eD=e=>Boolean(e&&e[eP]);var eM=e=>e&&e[eP]?e[eP]():e;var eF=e=>e[eI]||null;function eL(e,t){if(e.eventObserved){e.eventObserved(t)}else{e(t)}}function eN(e,t){const r=e[eI];if(r){r.forEach(e=>{eL(e,t)})}}var ej=class{constructor(e){if(!e&&!(e=this.get)){throw Error("Unknown getter")}eU(this,e)}};eP,eI;var eU=(e,t)=>eY(e,eP,t);function eH(e,t){if(e[eP]){let r=e[eI];if(!r){eY(e,eI,r=/* @__PURE__ */new Set)}if(!r.has(t)){r.add(t);if(e.observerAdded){e.observerAdded(r.size,t)}}}return t}function eB(e,t){const r=e[eI];if(r&&r.has(t)){const n=r.size-1;if(n){r.delete(t)}else{e[eI]=null}if(e.observerRemoved){e.observerRemoved(n,t)}}}var eY=(e,t,r)=>Object.defineProperty(e,t,{value:r,writable:true,configurable:true});// src/regexs.ts
var ez=/[+\-]?(?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?/g;var eq=/(#(?:[0-9a-f]{2}){2,4}|(#[0-9a-f]{3})|(rgb|hsl)a?\((-?\d+%?[,\s]+){2,3}\s*[\d\.]+%?\))/gi;var eV=new RegExp(`(${ez.source})(%|[a-z]+)`,"i");var eW=/rgba\(([0-9\.-]+), ([0-9\.-]+), ([0-9\.-]+), ([0-9\.-]+)\)/gi;var e$=/var\((--[a-zA-Z0-9-_]+),? ?([a-zA-Z0-9 ()%#.,-]+)?\)/;// src/variableToRgba.ts
var eG=e=>{const[t,r]=eK(e);if(!t||L()){return e}const n=window.getComputedStyle(document.documentElement).getPropertyValue(t);if(n){return n.trim()}else if(r&&r.startsWith("--")){const t=window.getComputedStyle(document.documentElement).getPropertyValue(r);if(t){return t}else{return e}}else if(r&&e$.test(r)){return eG(r)}else if(r){return r}return e};var eK=e=>{const t=e$.exec(e);if(!t)return[,];const[,r,n]=t;return[r,n]};// src/stringInterpolation.ts
var eQ;var eX=(e,t,r,n,a)=>`rgba(${Math.round(t)}, ${Math.round(r)}, ${Math.round(n)}, ${a})`;var eJ=e=>{if(!eQ)eQ=U?// match color names, ignore partial matches
new RegExp(`(${Object.keys(U).join("|")})(?!\\w)`,"g"):// never match
/^\b$/;const t=e.output.map(e=>{return eM(e).replace(e$,eG).replace(eq,ey).replace(eQ,ey)});const r=t.map(e=>e.match(ez).map(Number));const n=r[0].map((e,t)=>r.map(e=>{if(!(t in e)){throw Error('The arity of each "output" value must be equal')}return e[t]}));const a=n.map(t=>ew({...e,output:t}));return e=>{const r=!eV.test(t[0])&&t.find(e=>eV.test(e))?.replace(ez,"");let n=0;return t[0].replace(ez,()=>`${a[n++](e)}${r||""}`).replace(eW,eX)}};// src/deprecations.ts
var eZ="react-spring: ";var e0=e=>{const t=e;let r=false;if(typeof t!="function"){throw new TypeError(`${eZ}once requires a function parameter`)}return(...e)=>{if(!r){t(...e);r=true}}};var e1=e0(console.warn);function e2(){e1(`${eZ}The "interpolate" function is deprecated in v9 (use "to" instead)`)}var e4=e0(console.warn);function e6(){e4(`${eZ}Directly calling start instead of using the api object is deprecated in v9 (use ".start" instead), this will be removed in later 0.X.0 versions`)}// src/isAnimatedString.ts
function e5(e){return R.str(e)&&(e[0]=="#"||/\d/.test(e)||// Do not identify a CSS variable as an AnimatedString if its SSR
!L()&&e$.test(e)||e in(U||{}))}// src/dom-events/scroll/index.ts
// src/dom-events/resize/resizeElement.ts
var e3;var e7=/* @__PURE__ */new WeakMap;var e8=e=>e.forEach(({target:e,contentRect:t})=>{return e7.get(e)?.forEach(e=>e(t))});function e9(e,t){if(!e3){if(typeof ResizeObserver!=="undefined"){e3=new ResizeObserver(e8)}}let r=e7.get(t);if(!r){r=/* @__PURE__ */new Set;e7.set(t,r)}r.add(e);if(e3){e3.observe(t)}return()=>{const r=e7.get(t);if(!r)return;r.delete(e);if(!r.size&&e3){e3.unobserve(t)}}}// src/dom-events/resize/resizeWindow.ts
var te=/* @__PURE__ */new Set;var tt;var tr=()=>{const e=()=>{te.forEach(e=>e({width:window.innerWidth,height:window.innerHeight}))};window.addEventListener("resize",e);return()=>{window.removeEventListener("resize",e)}};var tn=e=>{te.add(e);if(!tt){tt=tr()}return()=>{te.delete(e);if(!te.size&&tt){tt();tt=void 0}}};// src/dom-events/resize/index.ts
var ta=(e,{container:t=document.documentElement}={})=>{if(t===document.documentElement){return tn(e)}else{return e9(e,t)}};// src/progress.ts
var ti=(e,t,r)=>t-e===0?1:(r-e)/(t-e);// src/dom-events/scroll/ScrollHandler.ts
var to=/* unused pure expression or super */null&&{x:{length:"Width",position:"Left"},y:{length:"Height",position:"Top"}};var ts=class{constructor(e,t){this.createAxis=()=>({current:0,progress:0,scrollLength:0});this.updateAxis=e=>{const t=this.info[e];const{length:r,position:n}=to[e];t.current=this.container[`scroll${n}`];t.scrollLength=this.container[`scroll${r}`]-this.container[`client${r}`];t.progress=ti(0,t.scrollLength,t.current)};this.update=()=>{this.updateAxis("x");this.updateAxis("y")};this.sendEvent=()=>{this.callback(this.info)};this.advance=()=>{this.update();this.sendEvent()};this.callback=e;this.container=t;this.info={time:0,x:this.createAxis(),y:this.createAxis()}}};// src/dom-events/scroll/index.ts
var tu=/* @__PURE__ */new WeakMap;var tl=/* @__PURE__ */new WeakMap;var tc=/* @__PURE__ */new WeakMap;var tf=e=>e===document.documentElement?window:e;var td=(e,{container:t=document.documentElement}={})=>{let r=tc.get(t);if(!r){r=/* @__PURE__ */new Set;tc.set(t,r)}const n=new ts(e,t);r.add(n);if(!tu.has(t)){const e=()=>{r?.forEach(e=>e.advance());return true};tu.set(t,e);const n=tf(t);window.addEventListener("resize",e,{passive:true});if(t!==document.documentElement){tl.set(t,ta(e,{container:t}))}n.addEventListener("scroll",e,{passive:true})}const a=tu.get(t);raf3(a);return()=>{raf3.cancel(a);const e=tc.get(t);if(!e)return;e.delete(n);if(e.size)return;const r=tu.get(t);tu.delete(t);if(r){tf(t).removeEventListener("scroll",r);window.removeEventListener("resize",r);tl.get(t)?.()}}};// src/hooks/useConstant.ts
function th(e){const t=useRef(null);if(t.current===null){t.current=e()}return t.current}// src/hooks/useForceUpdate.ts
// src/hooks/useIsMounted.ts
// src/hooks/useIsomorphicLayoutEffect.ts
var tp=L()?E.useEffect:E.useLayoutEffect;// src/hooks/useIsMounted.ts
var tv=()=>{const e=(0,E.useRef)(false);tp(()=>{e.current=true;return()=>{e.current=false}},[]);return e};// src/hooks/useForceUpdate.ts
function tm(){const e=(0,E.useState)()[1];const t=tv();return()=>{if(t.current){e(Math.random())}}}// src/hooks/useMemoOne.ts
function tg(e,t){const[r]=(0,E.useState)(()=>({inputs:t,result:e()}));const n=(0,E.useRef)();const a=n.current;let i=a;if(i){const r=Boolean(t&&i.inputs&&tb(t,i.inputs));if(!r){i={inputs:t,result:e()}}}else{i=r}(0,E.useEffect)(()=>{n.current=i;if(a==r){r.inputs=r.result=void 0}},[i]);return i.result}function tb(e,t){if(e.length!==t.length){return false}for(let r=0;r<e.length;r++){if(e[r]!==t[r]){return false}}return true}// src/hooks/useOnce.ts
var ty=e=>(0,E.useEffect)(e,tw);var tw=[];// src/hooks/usePrev.ts
function t_(e){const t=(0,E.useRef)();(0,E.useEffect)(()=>{t.current=e});return t.current}// src/hooks/useReducedMotion.ts
var tx=()=>{const[e,t]=useState3(null);tp(()=>{const e=window.matchMedia("(prefers-reduced-motion)");const r=e=>{t(e.matches);Y({skipAnimation:e.matches})};r(e);if(e.addEventListener){e.addEventListener("change",r)}else{e.addListener(r)}return()=>{if(e.removeEventListener){e.removeEventListener("change",r)}else{e.removeListener(r)}}},[]);return e};// src/index.ts
//# sourceMappingURL=react-spring_shared.modern.mjs.map
;// CONCATENATED MODULE: ../tutor/node_modules/@react-spring/animated/dist/react-spring_animated.modern.mjs
// src/Animated.ts
var tE=Symbol.for("Animated:node");var tO=e=>!!e&&e[tE]===e;var tS=e=>e&&e[tE];var tA=(e,t)=>k(e,tE,t);var tT=e=>e&&e[tE]&&e[tE].getPayload();var tk=class{constructor(){tA(this,this)}/** Get every `AnimatedValue` used by this node. */getPayload(){return this.payload||[]}};// src/AnimatedValue.ts
var tR=class extends tk{constructor(e){super();this._value=e;this.done=true;this.durationProgress=0;if(R.num(this._value)){this.lastPosition=this._value}}/** @internal */static create(e){return new tR(e)}getPayload(){return[this]}getValue(){return this._value}setValue(e,t){if(R.num(e)){this.lastPosition=e;if(t){e=Math.round(e/t)*t;if(this.done){this.lastPosition=e}}}if(this._value===e){return false}this._value=e;return true}reset(){const{done:e}=this;this.done=false;if(R.num(this._value)){this.elapsedTime=0;this.durationProgress=0;this.lastPosition=this._value;if(e)this.lastVelocity=null;this.v0=null}}};// src/AnimatedString.ts
var tC=class extends tR{constructor(e){super(0);this._string=null;this._toString=ew({output:[e,e]})}/** @internal */static create(e){return new tC(e)}getValue(){const e=this._string;return e==null?this._string=this._toString(this._value):e}setValue(e){if(R.str(e)){if(e==this._string){return false}this._string=e;this._value=1}else if(super.setValue(e)){this._string=null}else{return false}return true}reset(e){if(e){this._toString=ew({output:[this.getValue(),e]})}this._value=0;super.reset()}};// src/AnimatedArray.ts
// src/AnimatedObject.ts
// src/context.ts
var tP={dependencies:null};// src/AnimatedObject.ts
var tI=class extends tk{constructor(e){super();this.source=e;this.setValue(e)}getValue(e){const t={};I(this.source,(r,n)=>{if(tO(r)){t[n]=r.getValue(e)}else if(eD(r)){t[n]=eM(r)}else if(!e){t[n]=r}});return t}/** Replace the raw object data */setValue(e){this.source=e;this.payload=this._makePayload(e)}reset(){if(this.payload){P(this.payload,e=>e.reset())}}/** Create a payload set. */_makePayload(e){if(e){const t=/* @__PURE__ */new Set;I(e,this._addToPayload,t);return Array.from(t)}}/** Add to a payload set. */_addToPayload(e){if(tP.dependencies&&eD(e)){tP.dependencies.add(e)}const t=tT(e);if(t){P(t,e=>this.add(e))}}};// src/AnimatedArray.ts
var tD=class extends tI{constructor(e){super(e)}/** @internal */static create(e){return new tD(e)}getValue(){return this.source.map(e=>e.getValue())}setValue(e){const t=this.getPayload();if(e.length==t.length){return t.map((t,r)=>t.setValue(e[r])).some(Boolean)}super.setValue(e.map(tM));return true}};function tM(e){const t=e5(e)?tC:tR;return t.create(e)}// src/getAnimatedType.ts
function tF(e){const t=tS(e);return t?t.constructor:R.arr(e)?tD:e5(e)?tC:tR}// src/createHost.ts
// src/withAnimated.tsx
var tL=(e,t)=>{const r=// Function components must use "forwardRef" to avoid being
// re-rendered on every animation frame.
!R.fun(e)||e.prototype&&e.prototype.isReactComponent;return(0,E.forwardRef)((n,i)=>{const o=(0,E.useRef)(null);const s=r&&// eslint-disable-next-line react-hooks/rules-of-hooks
(0,E.useCallback)(e=>{o.current=tU(i,e)},[i]);const[u,l]=tj(n,t);const c=tm();const f=()=>{const e=o.current;if(r&&!e){return}const n=e?t.applyAnimatedValues(e,u.getValue(true)):false;if(n===false){c()}};const d=new tN(f,l);const h=(0,E.useRef)();tp(()=>{h.current=d;P(l,e=>eH(e,d));return()=>{if(h.current){P(h.current.deps,e=>eB(e,h.current));a.cancel(h.current.update)}}});(0,E.useEffect)(f,[]);ty(()=>()=>{const e=h.current;P(e.deps,t=>eB(t,e))});const p=t.getComponentProps(u.getValue());return /* @__PURE__ */E.createElement(e,{...p,ref:s})})};var tN=class{constructor(e,t){this.update=e;this.deps=t}eventObserved(e){if(e.type=="change"){a.write(this.update)}}};function tj(e,t){const r=/* @__PURE__ */new Set;tP.dependencies=r;if(e.style)e={...e,style:t.createAnimatedStyle(e.style)};e=new tI(e);tP.dependencies=null;return[e,r]}function tU(e,t){if(e){if(R.fun(e))e(t);else e.current=t}return t}// src/createHost.ts
var tH=Symbol.for("AnimatedComponent");var tB=(e,{applyAnimatedValues:t=()=>false,createAnimatedStyle:r=e=>new tI(e),getComponentProps:n=e=>e}={})=>{const a={applyAnimatedValues:t,createAnimatedStyle:r,getComponentProps:n};const i=e=>{const t=tY(e)||"Anonymous";if(R.str(e)){e=i[e]||(i[e]=tL(e,a))}else{e=e[tH]||(e[tH]=tL(e,a))}e.displayName=`Animated(${t})`;return e};I(e,(t,r)=>{if(R.arr(e)){r=tY(t)}i[r]=i(t)});return{animated:i}};var tY=e=>R.str(e)?e:e&&R.str(e.displayName)?e.displayName:R.fun(e)&&e.name||null;//# sourceMappingURL=react-spring_animated.modern.mjs.map
;// CONCATENATED MODULE: ../tutor/node_modules/@react-spring/core/dist/react-spring_core.modern.mjs
// src/hooks/useChain.ts
// src/helpers.ts
function tz(e,...t){return R.fun(e)?e(...t):e}var tq=(e,t)=>e===true||!!(t&&e&&(R.fun(e)?e(t):D(e).includes(t)));var tV=(e,t)=>R.obj(e)?t&&e[t]:e;var tW=(e,t)=>e.default===true?e[t]:e.default?e.default[t]:void 0;var t$=e=>e;var tG=(e,t=t$)=>{let r=tK;if(e.default&&e.default!==true){e=e.default;r=Object.keys(e)}const n={};for(const a of r){const r=t(e[a],a);if(!R.und(r)){n[a]=r}}return n};var tK=["config","onProps","onStart","onChange","onPause","onResume","onRest"];var tQ={config:1,from:1,to:1,ref:1,loop:1,reset:1,pause:1,cancel:1,reverse:1,immediate:1,default:1,delay:1,onProps:1,onStart:1,onChange:1,onPause:1,onResume:1,onRest:1,onResolve:1,// Transition props
items:1,trail:1,sort:1,expires:1,initial:1,enter:1,update:1,leave:1,children:1,onDestroyed:1,// Internal props
keys:1,callId:1,parentId:1};function tX(e){const t={};let r=0;I(e,(e,n)=>{if(!tQ[n]){t[n]=e;r++}});if(r){return t}}function tJ(e){const t=tX(e);if(t){const r={to:t};I(e,(e,n)=>n in t||(r[n]=e));return r}return{...e}}function tZ(e){e=eM(e);return R.arr(e)?e.map(tZ):e5(e)?A.createStringInterpolator({range:[0,1],output:[e,e]})(1):e}function t0(e){for(const t in e)return true;return false}function t1(e){return R.fun(e)||R.arr(e)&&R.obj(e[0])}function t2(e,t){e.ref?.delete(e);t?.delete(e)}function t4(e,t){if(t&&e.ref!==t){e.ref?.delete(e);t.add(e);e.ref=t}}// src/hooks/useChain.ts
function t6(e,t,r=1e3){useIsomorphicLayoutEffect(()=>{if(t){let n=0;each(e,(e,a)=>{const i=e.current;if(i.length){let o=r*t[a];if(isNaN(o))o=n;else n=o;each(i,e=>{each(e.queue,e=>{const t=e.delay;e.delay=e=>o+tz(t||0,e)})});e.start()}})}else{let t=Promise.resolve();each(e,e=>{const r=e.current;if(r.length){const n=r.map(e=>{const t=e.queue;e.queue=[];return t});t=t.then(()=>{each(r,(e,t)=>each(n[t]||[],t=>e.queue.push(t)));return Promise.all(e.start())})}})}})}// src/hooks/useSpring.ts
// src/hooks/useSprings.ts
// src/SpringValue.ts
// src/AnimationConfig.ts
// src/constants.ts
var t5={default:{tension:170,friction:26},gentle:{tension:120,friction:14},wobbly:{tension:180,friction:12},stiff:{tension:210,friction:20},slow:{tension:280,friction:60},molasses:{tension:280,friction:120}};// src/AnimationConfig.ts
var t3={...t5.default,mass:1,damping:1,easing:eC.linear,clamp:false};var t7=class{constructor(){/**
     * The initial velocity of one or more values.
     *
     * @default 0
     */this.velocity=0;Object.assign(this,t3)}};function t8(e,t,r){if(r){r={...r};t9(r,t);t={...r,...t}}t9(e,t);Object.assign(e,t);for(const t in t3){if(e[t]==null){e[t]=t3[t]}}let{frequency:n,damping:a}=e;const{mass:i}=e;if(!R.und(n)){if(n<.01)n=.01;if(a<0)a=0;e.tension=Math.pow(2*Math.PI/n,2)*i;e.friction=4*Math.PI*a*i/n}return e}function t9(e,t){if(!R.und(t.decay)){e.duration=void 0}else{const r=!R.und(t.tension)||!R.und(t.friction);if(r||!R.und(t.frequency)||!R.und(t.damping)||!R.und(t.mass)){e.duration=void 0;e.decay=void 0}if(r){e.frequency=void 0}}}// src/Animation.ts
var re=[];var rt=class{constructor(){this.changed=false;this.values=re;this.toValues=null;this.fromValues=re;this.config=new t7;this.immediate=false}};// src/scheduleProps.ts
function rr(e,{key:t,props:r,defaultProps:n,state:i,actions:o}){return new Promise((s,u)=>{let l;let c;let f=tq(r.cancel??n?.cancel,t);if(f){p()}else{if(!R.und(r.pause)){i.paused=tq(r.pause,t)}let e=n?.pause;if(e!==true){e=i.paused||tq(e,t)}l=tz(r.delay||0,t);if(e){i.resumeQueue.add(h);o.pause()}else{o.resume();h()}}function d(){i.resumeQueue.add(h);i.timeouts.delete(c);c.cancel();l=c.time-a.now()}function h(){if(l>0&&!A.skipAnimation){i.delayed=true;c=a.setTimeout(p,l);i.pauseQueue.add(d);i.timeouts.add(c)}else{p()}}function p(){if(i.delayed){i.delayed=false}i.pauseQueue.delete(d);i.timeouts.delete(c);if(e<=(i.cancelId||0)){f=true}try{o.start({...r,callId:e,cancel:f},s)}catch(e){u(e)}}})}// src/runAsync.ts
// src/AnimationResult.ts
var rn=(e,t)=>t.length==1?t[0]:t.some(e=>e.cancelled)?ro(e.get()):t.every(e=>e.noop)?ra(e.get()):ri(e.get(),t.every(e=>e.finished));var ra=e=>({value:e,noop:true,finished:true,cancelled:false});var ri=(e,t,r=false)=>({value:e,finished:t,cancelled:r});var ro=e=>({value:e,cancelled:true,finished:false});// src/runAsync.ts
function rs(e,t,r,n){const{callId:i,parentId:o,onRest:s}=t;const{asyncTo:u,promise:l}=r;if(!o&&e===u&&!t.reset){return l}return r.promise=(async()=>{r.asyncId=i;r.asyncTo=e;const c=tG(t,(e,t)=>// The `onRest` prop is only called when the `runAsync` promise is resolved.
    t==="onRest"?void 0:e);let f;let d;const h=new Promise((e,t)=>(f=e,d=t));const p=e=>{const t=// The `cancel` prop or `stop` method was used.
i<=(r.cancelId||0)&&ro(n)||// The async `to` prop was replaced.
i!==r.asyncId&&ri(n,false);if(t){e.result=t;d(e);throw e}};const v=(e,t)=>{const a=new rl;const o=new rc;return(async()=>{if(A.skipAnimation){ru(r);o.result=ri(n,false);d(o);throw o}p(a);const s=R.obj(e)?{...e}:{...t,to:e};s.parentId=i;I(c,(e,t)=>{if(R.und(s[t])){s[t]=e}});const u=await n.start(s);p(a);if(r.paused){await new Promise(e=>{r.resumeQueue.add(e)})}return u})()};let m;if(A.skipAnimation){ru(r);return ri(n,false)}try{let t;if(R.arr(e)){t=(async e=>{for(const t of e){await v(t)}})(e)}else{t=Promise.resolve(e(v,n.stop.bind(n)))}await Promise.all([t.then(f),h]);m=ri(n.get(),true,false)}catch(e){if(e instanceof rl){m=e.result}else if(e instanceof rc){m=e.result}else{throw e}}finally{if(i==r.asyncId){r.asyncId=o;r.asyncTo=o?u:void 0;r.promise=o?l:void 0}}if(R.fun(s)){a.batchedUpdates(()=>{s(m,n,n.item)})}return m})()}function ru(e,t){M(e.timeouts,e=>e.cancel());e.pauseQueue.clear();e.resumeQueue.clear();e.asyncId=e.asyncTo=e.promise=void 0;if(t)e.cancelId=t}var rl=class extends Error{constructor(){super("An async animation has been interrupted. You see this error because you forgot to use `await` or `.catch(...)` on its returned promise.")}};var rc=class extends Error{constructor(){super("SkipAnimationSignal")}};// src/FrameValue.ts
var rf=e=>e instanceof rh;var rd=1;var rh=class extends ej{constructor(){super(...arguments);this.id=rd++;this._priority=0}get priority(){return this._priority}set priority(e){if(this._priority!=e){this._priority=e;this._onPriorityChange(e)}}/** Get the current value */get(){const e=tS(this);return e&&e.getValue()}/** Create a spring that maps our value to another value */to(...e){return A.to(this,e)}/** @deprecated Use the `to` method instead. */interpolate(...e){e2();return A.to(this,e)}toJSON(){return this.get()}observerAdded(e){if(e==1)this._attach()}observerRemoved(e){if(e==0)this._detach()}/** Called when the first child is added. */_attach(){}/** Called when the last child is removed. */_detach(){}/** Tell our children about our new value */_onChange(e,t=false){eN(this,{type:"change",parent:this,value:e,idle:t})}/** Tell our children about our new priority */_onPriorityChange(e){if(!this.idle){$.sort(this)}eN(this,{type:"priority",parent:this,priority:e})}};// src/SpringPhase.ts
var rp=Symbol.for("SpringPhase");var rv=1;var rm=2;var rg=4;var rb=e=>(e[rp]&rv)>0;var ry=e=>(e[rp]&rm)>0;var rw=e=>(e[rp]&rg)>0;var r_=(e,t)=>t?e[rp]|=rm|rv:e[rp]&=~rm;var rx=(e,t)=>t?e[rp]|=rg:e[rp]&=~rg;// src/SpringValue.ts
var rE=class extends rh{constructor(e,t){super();/** The animation state */this.animation=new rt;/** Some props have customizable default values */this.defaultProps={};/** The state for `runAsync` calls */this._state={paused:false,delayed:false,pauseQueue:/* @__PURE__ */new Set,resumeQueue:/* @__PURE__ */new Set,timeouts:/* @__PURE__ */new Set};/** The promise resolvers of pending `start` calls */this._pendingCalls=/* @__PURE__ */new Set;/** The counter for tracking `scheduleProps` calls */this._lastCallId=0;/** The last `scheduleProps` call that changed the `to` prop */this._lastToId=0;this._memoizedDuration=0;if(!R.und(e)||!R.und(t)){const r=R.obj(e)?{...e}:{...t,from:e};if(R.und(r.default)){r.default=true}this.start(r)}}/** Equals true when not advancing on each frame. */get idle(){return!(ry(this)||this._state.asyncTo)||rw(this)}get goal(){return eM(this.animation.to)}get velocity(){const e=tS(this);return e instanceof tR?e.lastVelocity||0:e.getPayload().map(e=>e.lastVelocity||0)}/**
   * When true, this value has been animated at least once.
   */get hasAnimated(){return rb(this)}/**
   * When true, this value has an unfinished animation,
   * which is either active or paused.
   */get isAnimating(){return ry(this)}/**
   * When true, all current and future animations are paused.
   */get isPaused(){return rw(this)}/**
   *
   *
   */get isDelayed(){return this._state.delayed}/** Advance the current animation by a number of milliseconds */advance(e){let t=true;let r=false;const n=this.animation;let{toValues:a}=n;const{config:i}=n;const o=tT(n.to);if(!o&&eD(n.to)){a=D(eM(n.to))}n.values.forEach((s,u)=>{if(s.done)return;const l=// Animated strings always go from 0 to 1.
s.constructor==tC?1:o?o[u].lastPosition:a[u];let c=n.immediate;let f=l;if(!c){f=s.lastPosition;if(i.tension<=0){s.done=true;return}let t=s.elapsedTime+=e;const r=n.fromValues[u];const a=s.v0!=null?s.v0:s.v0=R.arr(i.velocity)?i.velocity[u]:i.velocity;let o;const d=i.precision||(r==l?.005:Math.min(1,Math.abs(l-r)*.001));if(!R.und(i.duration)){let n=1;if(i.duration>0){if(this._memoizedDuration!==i.duration){this._memoizedDuration=i.duration;if(s.durationProgress>0){s.elapsedTime=i.duration*s.durationProgress;t=s.elapsedTime+=e}}n=(i.progress||0)+t/this._memoizedDuration;n=n>1?1:n<0?0:n;s.durationProgress=n}f=r+i.easing(n)*(l-r);o=(f-s.lastPosition)/e;c=n==1}else if(i.decay){const e=i.decay===true?.998:i.decay;const n=Math.exp(-(1-e)*t);f=r+a/(1-e)*(1-n);c=Math.abs(s.lastPosition-f)<=d;o=a*n}else{o=s.lastVelocity==null?a:s.lastVelocity;const t=i.restVelocity||d/10;const n=i.clamp?0:i.bounce;const u=!R.und(n);const h=r==l?s.v0>0:r<l;let p;let v=false;const m=1;const g=Math.ceil(e/m);for(let e=0;e<g;++e){p=Math.abs(o)>t;if(!p){c=Math.abs(l-f)<=d;if(c){break}}if(u){v=f==l||f>l==h;if(v){o=-o*n;f=l}}const e=-i.tension*1e-6*(f-l);const r=-i.friction*.001*o;const a=(e+r)/i.mass;o=o+a*m;f=f+o*m}}s.lastVelocity=o;if(Number.isNaN(f)){console.warn(`Got NaN while animating:`,this);c=true}}if(o&&!o[u].done){c=false}if(c){s.done=true}else{t=false}if(s.setValue(f,i.round)){r=true}});const s=tS(this);const u=s.getValue();if(t){const e=eM(n.to);if((u!==e||r)&&!i.decay){s.setValue(e);this._onChange(e)}else if(r&&i.decay){this._onChange(u)}this._stop()}else if(r){this._onChange(u)}}/** Set the current value, while stopping the current animation */set(e){a.batchedUpdates(()=>{this._stop();this._focus(e);this._set(e)});return this}/**
   * Freeze the active animation in time, as well as any updates merged
   * before `resume` is called.
   */pause(){this._update({pause:true})}/** Resume the animation if paused. */resume(){this._update({pause:false})}/** Skip to the end of the current animation. */finish(){if(ry(this)){const{to:e,config:t}=this.animation;a.batchedUpdates(()=>{this._onStart();if(!t.decay){this._set(e,false)}this._stop()})}return this}/** Push props into the pending queue. */update(e){const t=this.queue||(this.queue=[]);t.push(e);return this}start(e,t){let r;if(!R.und(e)){r=[R.obj(e)?e:{...t,to:e}]}else{r=this.queue||[];this.queue=[]}return Promise.all(r.map(e=>{const t=this._update(e);return t})).then(e=>rn(this,e))}/**
   * Stop the current animation, and cancel any delayed updates.
   *
   * Pass `true` to call `onRest` with `cancelled: true`.
   */stop(e){const{to:t}=this.animation;this._focus(this.get());ru(this._state,e&&this._lastCallId);a.batchedUpdates(()=>this._stop(t,e));return this}/** Restart the animation. */reset(){this._update({reset:true})}/** @internal */eventObserved(e){if(e.type=="change"){this._start()}else if(e.type=="priority"){this.priority=e.priority+1}}/**
   * Parse the `to` and `from` range from the given `props` object.
   *
   * This also ensures the initial value is available to animated components
   * during the render phase.
   */_prepareNode(e){const t=this.key||"";let{to:r,from:n}=e;r=R.obj(r)?r[t]:r;if(r==null||t1(r)){r=void 0}n=R.obj(n)?n[t]:n;if(n==null){n=void 0}const a={to:r,from:n};if(!rb(this)){if(e.reverse)[r,n]=[n,r];n=eM(n);if(!R.und(n)){this._set(n)}else if(!tS(this)){this._set(r)}}return a}/** Every update is processed by this method before merging. */_update({...e},t){const{key:r,defaultProps:n}=this;if(e.default)Object.assign(n,tG(e,(e,t)=>/^on/.test(t)?tV(e,r):e));rC(this,e,"onProps");rP(this,"onProps",e,this);const a=this._prepareNode(e);if(Object.isFrozen(this)){throw Error("Cannot animate a `SpringValue` object that is frozen. Did you forget to pass your component to `animated(...)` before animating its props?")}const i=this._state;return rr(++this._lastCallId,{key:r,props:e,defaultProps:n,state:i,actions:{pause:()=>{if(!rw(this)){rx(this,true);F(i.pauseQueue);rP(this,"onPause",ri(this,rO(this,this.animation.to)),this)}},resume:()=>{if(rw(this)){rx(this,false);if(ry(this)){this._resume()}F(i.resumeQueue);rP(this,"onResume",ri(this,rO(this,this.animation.to)),this)}},start:this._merge.bind(this,a)}}).then(r=>{if(e.loop&&r.finished&&!(t&&r.noop)){const t=rS(e);if(t){return this._update(t,true)}}return r})}/** Merge props into the current animation */_merge(e,t,r){if(t.cancel){this.stop(true);return r(ro(this))}const n=!R.und(e.to);const i=!R.und(e.from);if(n||i){if(t.callId>this._lastToId){this._lastToId=t.callId}else{return r(ro(this))}}const{key:o,defaultProps:s,animation:u}=this;const{to:l,from:c}=u;let{to:f=l,from:d=c}=e;if(i&&!n&&(!t.default||R.und(f))){f=d}if(t.reverse)[f,d]=[d,f];const h=!C(d,c);if(h){u.from=d}d=eM(d);const p=!C(f,l);if(p){this._focus(f)}const v=t1(t.to);const{config:m}=u;const{decay:g,velocity:b}=m;if(n||i){m.velocity=0}if(t.config&&!v){t8(m,tz(t.config,o),// Avoid calling the same "config" prop twice.
t.config!==s.config?tz(s.config,o):void 0)}let y=tS(this);if(!y||R.und(f)){return r(ri(this,true))}const w=// When `reset` is undefined, the `from` prop implies `reset: true`,
// except for declarative updates. When `reset` is defined, there
// must exist a value to animate from.
R.und(t.reset)?i&&!t.default:!R.und(d)&&tq(t.reset,o);const _=w?d:this.get();const x=tZ(f);const E=R.num(x)||R.arr(x)||e5(x);const O=!v&&(!E||tq(s.immediate||t.immediate,o));if(p){const e=tF(f);if(e!==y.constructor){if(O){y=this._set(x)}else throw Error(`Cannot animate between ${y.constructor.name} and ${e.name}, as the "to" prop suggests`)}}const S=y.constructor;let A=eD(f);let T=false;if(!A){const e=w||!rb(this)&&h;if(p||e){T=C(tZ(_),x);A=!T}if(!C(u.immediate,O)&&!O||!C(m.decay,g)||!C(m.velocity,b)){A=true}}if(T&&ry(this)){if(u.changed&&!w){A=true}else if(!A){this._stop(l)}}if(!v){if(A||eD(l)){u.values=y.getPayload();u.toValues=eD(f)?null:S==tC?[1]:D(x)}if(u.immediate!=O){u.immediate=O;if(!O&&!w){this._set(l)}}if(A){const{onRest:e}=u;P(rR,e=>rC(this,t,e));const n=ri(this,rO(this,l));F(this._pendingCalls,n);this._pendingCalls.add(r);if(u.changed)a.batchedUpdates(()=>{u.changed=!w;e?.(n,this);if(w){tz(s.onRest,n)}else{u.onStart?.(n,this)}})}}if(w){this._set(_)}if(v){r(rs(t.to,t,this._state,this))}else if(A){this._start()}else if(ry(this)&&!p){this._pendingCalls.add(r)}else{r(ra(_))}}/** Update the `animation.to` value, which might be a `FluidValue` */_focus(e){const t=this.animation;if(e!==t.to){if(eF(this)){this._detach()}t.to=e;if(eF(this)){this._attach()}}}_attach(){let e=0;const{to:t}=this.animation;if(eD(t)){eH(t,this);if(rf(t)){e=t.priority+1}}this.priority=e}_detach(){const{to:e}=this.animation;if(eD(e)){eB(e,this)}}/**
   * Update the current value from outside the frameloop,
   * and return the `Animated` node.
   */_set(e,t=true){const r=eM(e);if(!R.und(r)){const e=tS(this);if(!e||!C(r,e.getValue())){const n=tF(r);if(!e||e.constructor!=n){tA(this,n.create(r))}else{e.setValue(r)}if(e){a.batchedUpdates(()=>{this._onChange(r,t)})}}}return tS(this)}_onStart(){const e=this.animation;if(!e.changed){e.changed=true;rP(this,"onStart",ri(this,rO(this,e.to)),this)}}_onChange(e,t){if(!t){this._onStart();tz(this.animation.onChange,e,this)}tz(this.defaultProps.onChange,e,this);super._onChange(e,t)}// This method resets the animation state (even if already animating) to
// ensure the latest from/to range is used, and it also ensures this spring
// is added to the frameloop.
_start(){const e=this.animation;tS(this).reset(eM(e.to));if(!e.immediate){e.fromValues=e.values.map(e=>e.lastPosition)}if(!ry(this)){r_(this,true);if(!rw(this)){this._resume()}}}_resume(){if(A.skipAnimation){this.finish()}else{$.start(this)}}/**
   * Exit the frameloop and notify `onRest` listeners.
   *
   * Always wrap `_stop` calls with `batchedUpdates`.
   */_stop(e,t){if(ry(this)){r_(this,false);const r=this.animation;P(r.values,e=>{e.done=true});if(r.toValues){r.onChange=r.onPause=r.onResume=void 0}eN(this,{type:"idle",parent:this});const n=t?ro(this.get()):ri(this.get(),rO(this,e??r.to));F(this._pendingCalls,n);if(r.changed){r.changed=false;rP(this,"onRest",n,this)}}}};function rO(e,t){const r=tZ(t);const n=tZ(e.get());return C(n,r)}function rS(e,t=e.loop,r=e.to){const n=tz(t);if(n){const a=n!==true&&tJ(n);const i=(a||e).reverse;const o=!a||a.reset;return rA({...e,loop:t,// Avoid updating default props when looping.
default:false,// Never loop the `pause` prop.
pause:void 0,// For the "reverse" prop to loop as expected, the "to" prop
// must be undefined. The "reverse" prop is ignored when the
// "to" prop is an array or function.
to:!i||t1(r)?r:void 0,// Ignore the "from" prop except on reset.
from:o?e.from:void 0,reset:o,// The "loop" prop can return a "useSpring" props object to
// override any of the original props.
...a})}}function rA(e){const{to:t,from:r}=e=tJ(e);const n=/* @__PURE__ */new Set;if(R.obj(t))rk(t,n);if(R.obj(r))rk(r,n);e.keys=n.size?Array.from(n):null;return e}function rT(e){const t=rA(e);if(R.und(t.default)){t.default=tG(t)}return t}function rk(e,t){I(e,(e,r)=>e!=null&&t.add(r))}var rR=["onStart","onRest","onChange","onPause","onResume"];function rC(e,t,r){e.animation[r]=t[r]!==tW(t,r)?tV(t[r],e.key):void 0}function rP(e,t,...r){e.animation[t]?.(...r);e.defaultProps[t]?.(...r)}// src/Controller.ts
var rI=["onStart","onChange","onRest"];var rD=1;var rM=class{constructor(e,t){this.id=rD++;/** The animated values */this.springs={};/** The queue of props passed to the `update` method. */this.queue=[];/** The counter for tracking `scheduleProps` calls */this._lastAsyncId=0;/** The values currently being animated */this._active=/* @__PURE__ */new Set;/** The values that changed recently */this._changed=/* @__PURE__ */new Set;/** Equals false when `onStart` listeners can be called */this._started=false;/** State used by the `runAsync` function */this._state={paused:false,pauseQueue:/* @__PURE__ */new Set,resumeQueue:/* @__PURE__ */new Set,timeouts:/* @__PURE__ */new Set};/** The event queues that are flushed once per frame maximum */this._events={onStart:/* @__PURE__ */new Map,onChange:/* @__PURE__ */new Map,onRest:/* @__PURE__ */new Map};this._onFrame=this._onFrame.bind(this);if(t){this._flush=t}if(e){this.start({default:true,...e})}}/**
   * Equals `true` when no spring values are in the frameloop, and
   * no async animation is currently active.
   */get idle(){return!this._state.asyncTo&&Object.values(this.springs).every(e=>{return e.idle&&!e.isDelayed&&!e.isPaused})}get item(){return this._item}set item(e){this._item=e}/** Get the current values of our springs */get(){const e={};this.each((t,r)=>e[r]=t.get());return e}/** Set the current values without animating. */set(e){for(const t in e){const r=e[t];if(!R.und(r)){this.springs[t].set(r)}}}/** Push an update onto the queue of each value. */update(e){if(e){this.queue.push(rA(e))}return this}/**
   * Start the queued animations for every spring, and resolve the returned
   * promise once all queued animations have finished or been cancelled.
   *
   * When you pass a queue (instead of nothing), that queue is used instead of
   * the queued animations added with the `update` method, which are left alone.
   */start(e){let{queue:t}=this;if(e){t=D(e).map(rA)}else{this.queue=[]}if(this._flush){return this._flush(this,t)}rB(this,t);return rF(this,t)}/** @internal */stop(e,t){if(e!==!!e){t=e}if(t){const r=this.springs;P(D(t),t=>r[t].stop(!!e))}else{ru(this._state,this._lastAsyncId);this.each(t=>t.stop(!!e))}return this}/** Freeze the active animation in time */pause(e){if(R.und(e)){this.start({pause:true})}else{const t=this.springs;P(D(e),e=>t[e].pause())}return this}/** Resume the animation if paused. */resume(e){if(R.und(e)){this.start({pause:false})}else{const t=this.springs;P(D(e),e=>t[e].resume())}return this}/** Call a function once per spring value */each(e){I(this.springs,e)}/** @internal Called at the end of every animation frame */_onFrame(){const{onStart:e,onChange:t,onRest:r}=this._events;const n=this._active.size>0;const a=this._changed.size>0;if(n&&!this._started||a&&!this._started){this._started=true;M(e,([e,t])=>{t.value=this.get();e(t,this,this._item)})}const i=!n&&this._started;const o=a||i&&r.size?this.get():null;if(a&&t.size){M(t,([e,t])=>{t.value=o;e(t,this,this._item)})}if(i){this._started=false;M(r,([e,t])=>{t.value=o;e(t,this,this._item)})}}/** @internal */eventObserved(e){if(e.type=="change"){this._changed.add(e.parent);if(!e.idle){this._active.add(e.parent)}}else if(e.type=="idle"){this._active.delete(e.parent)}else return;a.onFrame(this._onFrame)}};function rF(e,t){return Promise.all(t.map(t=>rL(e,t))).then(t=>rn(e,t))}async function rL(e,t,r){const{keys:n,to:i,from:o,loop:s,onRest:u,onResolve:l}=t;const c=R.obj(t.default)&&t.default;if(s){t.loop=false}if(i===false)t.to=null;if(o===false)t.from=null;const f=R.arr(i)||R.fun(i)?i:void 0;if(f){t.to=void 0;t.onRest=void 0;if(c){c.onRest=void 0}}else{P(rI,r=>{const n=t[r];if(R.fun(n)){const a=e["_events"][r];t[r]=({finished:e,cancelled:t})=>{const r=a.get(n);if(r){if(!e)r.finished=false;if(t)r.cancelled=true}else{a.set(n,{value:null,finished:e||false,cancelled:t||false})}};if(c){c[r]=t[r]}}})}const d=e["_state"];if(t.pause===!d.paused){d.paused=t.pause;F(t.pause?d.pauseQueue:d.resumeQueue)}else if(d.paused){t.pause=true}const h=(n||Object.keys(e.springs)).map(r=>e.springs[r].start(t));const p=t.cancel===true||tW(t,"cancel")===true;if(f||p&&d.asyncId){h.push(rr(++e["_lastAsyncId"],{props:t,state:d,actions:{pause:T,resume:T,start(t,r){if(p){ru(d,e["_lastAsyncId"]);r(ro(e))}else{t.onRest=u;r(rs(f,t,d,e))}}}}))}if(d.paused){await new Promise(e=>{d.resumeQueue.add(e)})}const v=rn(e,await Promise.all(h));if(s&&v.finished&&!(r&&v.noop)){const r=rS(t,s,i);if(r){rB(e,[r]);return rL(e,r,true)}}if(l){a.batchedUpdates(()=>l(v,e,e.item))}return v}function rN(e,t){const r={...e.springs};if(t){P(D(t),e=>{if(R.und(e.keys)){e=rA(e)}if(!R.obj(e.to)){e={...e,to:void 0}}rH(r,e,e=>{return rU(e)})})}rj(e,r);return r}function rj(e,t){I(t,(t,r)=>{if(!e.springs[r]){e.springs[r]=t;eH(t,e)}})}function rU(e,t){const r=new rE;r.key=e;if(t){eH(r,t)}return r}function rH(e,t,r){if(t.keys){P(t.keys,n=>{const a=e[n]||(e[n]=r(n));a["_prepareNode"](t)})}}function rB(e,t){P(t,t=>{rH(e.springs,t,t=>{return rU(t,e)})})}// src/SpringContext.tsx
var rY=({children:e,...t})=>{const r=(0,E.useContext)(rz);const n=t.pause||!!r.pause,a=t.immediate||!!r.immediate;t=tg(()=>({pause:n,immediate:a}),[n,a]);const{Provider:i}=rz;return /* @__PURE__ */E.createElement(i,{value:t},e)};var rz=rq(rY,{});rY.Provider=rz.Provider;rY.Consumer=rz.Consumer;function rq(e,t){Object.assign(e,E.createContext(t));e.Provider._context=e;e.Consumer._context=e;return e}// src/SpringRef.ts
var rV=()=>{const e=[];const t=function(t){e6();const n=[];P(e,(e,a)=>{if(R.und(t)){n.push(e.start())}else{const i=r(t,e,a);if(i){n.push(e.start(i))}}});return n};t.current=e;t.add=function(t){if(!e.includes(t)){e.push(t)}};t.delete=function(t){const r=e.indexOf(t);if(~r)e.splice(r,1)};t.pause=function(){P(e,e=>e.pause(...arguments));return this};t.resume=function(){P(e,e=>e.resume(...arguments));return this};t.set=function(t){P(e,(e,r)=>{const n=R.fun(t)?t(r,e):t;if(n){e.set(n)}})};t.start=function(t){const r=[];P(e,(e,n)=>{if(R.und(t)){r.push(e.start())}else{const a=this._getProps(t,e,n);if(a){r.push(e.start(a))}}});return r};t.stop=function(){P(e,e=>e.stop(...arguments));return this};t.update=function(t){P(e,(e,r)=>e.update(this._getProps(t,e,r)));return this};const r=function(e,t,r){return R.fun(e)?e(r,t):e};t._getProps=r;return t};// src/hooks/useSprings.ts
function rW(e,t,r){const n=R.fun(t)&&t;if(n&&!r)r=[];const a=(0,E.useMemo)(()=>n||arguments.length==3?rV():void 0,[]);const i=(0,E.useRef)(0);const o=tm();const s=(0,E.useMemo)(()=>({ctrls:[],queue:[],flush(e,t){const r=rN(e,t);const n=i.current>0&&!s.queue.length&&!Object.keys(r).some(t=>!e.springs[t]);return n?rF(e,t):new Promise(n=>{rj(e,r);s.queue.push(()=>{n(rF(e,t))});o()})}}),[]);const u=(0,E.useRef)([...s.ctrls]);const l=[];const c=t_(e)||0;(0,E.useMemo)(()=>{P(u.current.slice(e,c),e=>{t2(e,a);e.stop(true)});u.current.length=e;f(c,e)},[e]);(0,E.useMemo)(()=>{f(0,Math.min(c,e))},r);function f(e,r){for(let a=e;a<r;a++){const e=u.current[a]||(u.current[a]=new rM(null,s.flush));const r=n?n(a,e):t[a];if(r){l[a]=rT(r)}}}const d=u.current.map((e,t)=>rN(e,l[t]));const h=(0,E.useContext)(rY);const p=t_(h);const v=h!==p&&t0(h);tp(()=>{i.current++;s.ctrls=u.current;const{queue:e}=s;if(e.length){s.queue=[];P(e,e=>e())}P(u.current,(e,t)=>{a?.add(e);if(v){e.start({default:h})}const r=l[t];if(r){t4(e,r.ref);if(e.ref){e.queue.push(r)}else{e.start(r)}}})});ty(()=>()=>{P(s.ctrls,e=>e.stop(true))});const m=d.map(e=>({...e}));return a?[m,a]:m}// src/hooks/useSpring.ts
function r$(e,t){const r=R.fun(e);const[[n],a]=rW(1,r?e:[e],r?t||[]:t);return r||arguments.length==2?[n,a]:n}// src/hooks/useSpringRef.ts
var rG=()=>rV();var rK=()=>useState(rG)[0];// src/hooks/useSpringValue.ts
var rQ=(e,t)=>{const r=useConstant(()=>new rE(e,t));useOnce2(()=>()=>{r.stop()});return r};// src/hooks/useTrail.ts
function rX(e,t,r){const n=is10.fun(t)&&t;if(n&&!r)r=[];let a=true;let i=void 0;const o=rW(e,(e,r)=>{const o=n?n(e,r):t;i=o.ref;a=a&&o.reverse;return o},// Ensure the props function is called when no deps exist.
// This works around the 3 argument rule.
r||[{}]);useIsomorphicLayoutEffect3(()=>{each6(o[1].current,(e,t)=>{const r=o[1].current[t+(a?1:-1)];t4(e,i);if(e.ref){if(r){e.update({to:r.springs})}return}if(r){e.start({to:r.springs})}else{e.start()}})},r);if(n||arguments.length==3){const e=i??o[1];e["_getProps"]=(t,r,n)=>{const a=is10.fun(t)?t(n,r):t;if(a){const t=e.current[n+(a.reverse?1:-1)];if(t)a.to=t.springs;return a}};return o}return o[0]}// src/hooks/useTransition.tsx
function rJ(e,t,r){const n=R.fun(t)&&t;const{reset:a,sort:i,trail:o=0,expires:s=true,exitBeforeEnter:u=false,onDestroyed:l,ref:c,config:f}=n?n():t;const d=(0,E.useMemo)(()=>n||arguments.length==3?rV():void 0,[]);const h=D(e);const p=[];const v=(0,E.useRef)(null);const m=a?null:v.current;tp(()=>{v.current=p});ty(()=>{P(p,e=>{d?.add(e.ctrl);e.ctrl.ref=d});return()=>{P(v.current,e=>{if(e.expired){clearTimeout(e.expirationId)}t2(e.ctrl,d);e.ctrl.stop(true)})}});const g=r0(h,n?n():t,m);const b=a&&v.current||[];tp(()=>P(b,({ctrl:e,item:t,key:r})=>{t2(e,d);tz(l,t,r)}));const y=[];if(m)P(m,(e,t)=>{if(e.expired){clearTimeout(e.expirationId);b.push(e)}else{t=y[t]=g.indexOf(e.key);if(~t)p[t]=e}});P(h,(e,t)=>{if(!p[t]){p[t]={key:g[t],item:e,phase:"mount"/* MOUNT */,ctrl:new rM};p[t].ctrl.item=e}});if(y.length){let e=-1;const{leave:r}=n?n():t;P(y,(t,n)=>{const a=m[n];if(~t){e=p.indexOf(a);p[e]={...a,item:h[t]}}else if(r){p.splice(++e,0,a)}})}if(R.fun(i)){p.sort((e,t)=>i(e.item,t.item))}let w=-o;const _=tm();const x=tG(t);const O=/* @__PURE__ */new Map;const S=(0,E.useRef)(/* @__PURE__ */new Map);const A=(0,E.useRef)(false);P(p,(e,r)=>{const a=e.key;const i=e.phase;const l=n?n():t;let d;let h;const p=tz(l.delay||0,a);if(i=="mount"/* MOUNT */){d=l.enter;h="enter"/* ENTER */}else{const e=g.indexOf(a)<0;if(i!="leave"/* LEAVE */){if(e){d=l.leave;h="leave"/* LEAVE */}else if(d=l.update){h="update"/* UPDATE */}else return}else if(!e){d=l.enter;h="enter"/* ENTER */}else return}d=tz(d,e.item,r);d=R.obj(d)?tJ(d):{to:d};if(!d.config){const t=f||x.config;d.config=tz(t,e.item,r,h)}w+=o;const b={...x,// we need to add our props.delay value you here.
delay:p+w,ref:c,immediate:l.immediate,// This prevents implied resets.
reset:false,// Merge any phase-specific props.
...d};if(h=="enter"/* ENTER */&&R.und(b.from)){const a=n?n():t;const i=R.und(a.initial)||m?a.from:a.initial;b.from=tz(i,e.item,r)}const{onResolve:y}=b;b.onResolve=e=>{tz(y,e);const t=v.current;const r=t.find(e=>e.key===a);if(!r)return;if(e.cancelled&&r.phase!="update"/* UPDATE */){return}if(r.ctrl.idle){const e=t.every(e=>e.ctrl.idle);if(r.phase=="leave"/* LEAVE */){const t=tz(s,r.item);if(t!==false){const n=t===true?0:t;r.expired=true;if(!e&&n>0){if(n<=0x7fffffff)r.expirationId=setTimeout(_,n);return}}}if(e&&t.some(e=>e.expired)){S.current.delete(r);if(u){A.current=true}_()}}};const E=rN(e.ctrl,b);if(h==="leave"/* LEAVE */&&u){S.current.set(e,{phase:h,springs:E,payload:b})}else{O.set(e,{phase:h,springs:E,payload:b})}});const T=(0,E.useContext)(rY);const k=t_(T);const C=T!==k&&t0(T);tp(()=>{if(C){P(p,e=>{e.ctrl.start({default:T})})}},[T]);P(O,(e,t)=>{if(S.current.size){const e=p.findIndex(e=>e.key===t.key);p.splice(e,1)}});tp(()=>{P(S.current.size?S.current:O,({phase:e,payload:t},r)=>{const{ctrl:n}=r;r.phase=e;d?.add(n);if(C&&e=="enter"/* ENTER */){n.start({default:T})}if(t){t4(n,t.ref);if((n.ref||d)&&!A.current){n.update(t)}else{n.start(t);if(A.current){A.current=false}}}})},a?void 0:r);const I=e=>/* @__PURE__ */E.createElement(E.Fragment,null,p.map((t,r)=>{const{springs:n}=O.get(t)||t.ctrl;const a=e({...n},t.item,t,r);return a&&a.type?/* @__PURE__ */E.createElement(a.type,{...a.props,key:R.str(t.key)||R.num(t.key)?t.key:t.ctrl.id,ref:a.ref}):a}));return d?[I,d]:I}var rZ=1;function r0(e,{key:t,keys:r=t},n){if(r===null){const t=/* @__PURE__ */new Set;return e.map(e=>{const r=n&&n.find(r=>r.item===e&&r.phase!=="leave"/* LEAVE */&&!t.has(r));if(r){t.add(r);return r.key}return rZ++})}return R.und(r)?e:R.fun(r)?e.map(r):D(r)}// src/hooks/useScroll.ts
var r1=({container:e,...t}={})=>{const[r,n]=r$(()=>({scrollX:0,scrollY:0,scrollXProgress:0,scrollYProgress:0,...t}),[]);useIsomorphicLayoutEffect5(()=>{const t=onScroll(({x:e,y:t})=>{n.start({scrollX:e.current,scrollXProgress:e.progress,scrollY:t.current,scrollYProgress:t.progress})},{container:e?.current||void 0});return()=>{each8(Object.values(r),e=>e.stop());t()}},[]);return r};// src/hooks/useResize.ts
var r2=({container:e,...t})=>{const[r,n]=r$(()=>({width:0,height:0,...t}),[]);useIsomorphicLayoutEffect6(()=>{const t=onResize(({width:e,height:t})=>{n.start({width:e,height:t,immediate:r.width.get()===0||r.height.get()===0})},{container:e?.current||void 0});return()=>{each9(Object.values(r),e=>e.stop());t()}},[]);return r};// src/hooks/useInView.ts
var r4=/* unused pure expression or super */null&&{any:0,all:1};function r6(e,t){const[r,n]=useState2(false);const a=useRef3();const i=is12.fun(e)&&e;const o=i?i():{};const{to:s={},from:u={},...l}=o;const c=i?t:e;const[f,d]=r$(()=>({from:u,...l}),[]);useIsomorphicLayoutEffect7(()=>{const e=a.current;const{root:t,once:i,amount:o="any",...l}=c??{};if(!e||i&&r||typeof IntersectionObserver==="undefined")return;const f=/* @__PURE__ */new WeakMap;const h=()=>{if(s){d.start(s)}n(true);const e=()=>{if(u){d.start(u)}n(false)};return i?void 0:e};const p=e=>{e.forEach(e=>{const t=f.get(e.target);if(e.isIntersecting===Boolean(t)){return}if(e.isIntersecting){const t=h();if(is12.fun(t)){f.set(e.target,t)}else{v.unobserve(e.target)}}else if(t){t();f.delete(e.target)}})};const v=new IntersectionObserver(p,{root:t&&t.current||void 0,threshold:typeof o==="number"||Array.isArray(o)?o:r4[o],...l});v.observe(e);return()=>v.unobserve(e)},[c]);if(i){return[a,f]}return[a,r]}// src/components/Spring.tsx
function r5({children:e,...t}){return e(r$(t))}// src/components/Trail.tsx
function r3({items:e,children:t,...r}){const n=rX(e.length,r);return e.map((e,r)=>{const a=t(e,r);return is13.fun(a)?a(n[r]):a})}// src/components/Transition.tsx
function r7({items:e,children:t,...r}){return rJ(e,r)(t)}// src/interpolate.ts
// src/Interpolation.ts
var r8=class extends rh{constructor(e,t){super();this.source=e;/** Equals false when in the frameloop */this.idle=true;/** The inputs which are currently animating */this._active=/* @__PURE__ */new Set;this.calc=ew(...t);const r=this._get();const n=tF(r);tA(this,n.create(r))}advance(e){const t=this._get();const r=this.get();if(!C(t,r)){tS(this).setValue(t);this._onChange(t,this.idle)}if(!this.idle&&ne(this._active)){nt(this)}}_get(){const e=R.arr(this.source)?this.source.map(eM):D(eM(this.source));return this.calc(...e)}_start(){if(this.idle&&!ne(this._active)){this.idle=false;P(tT(this),e=>{e.done=false});if(A.skipAnimation){a.batchedUpdates(()=>this.advance());nt(this)}else{$.start(this)}}}// Observe our sources only when we're observed.
_attach(){let e=1;P(D(this.source),t=>{if(eD(t)){eH(t,this)}if(rf(t)){if(!t.idle){this._active.add(t)}e=Math.max(e,t.priority+1)}});this.priority=e;this._start()}// Stop observing our sources once we have no observers.
_detach(){P(D(this.source),e=>{if(eD(e)){eB(e,this)}});this._active.clear();nt(this)}/** @internal */eventObserved(e){if(e.type=="change"){if(e.idle){this.advance()}else{this._active.add(e.parent);this._start()}}else if(e.type=="idle"){this._active.delete(e.parent)}else if(e.type=="priority"){this.priority=D(this.source).reduce((e,t)=>Math.max(e,(rf(t)?t.priority:0)+1),0)}}};function r9(e){return e.idle!==false}function ne(e){return!e.size||Array.from(e).every(r9)}function nt(e){if(!e.idle){e.idle=true;P(tT(e),e=>{e.done=true});eN(e,{type:"idle",parent:e})}}// src/interpolate.ts
var nr=(e,...t)=>new r8(e,t);var nn=(e,...t)=>(deprecateInterpolate2(),new r8(e,t));// src/globals.ts
A.assign({createStringInterpolator:eJ,to:(e,t)=>new r8(e,t)});var na=$.advance;// src/index.ts
//# sourceMappingURL=react-spring_core.modern.mjs.map
// EXTERNAL MODULE: external "ReactDOM"
var ni=r(5206);// CONCATENATED MODULE: ../tutor/node_modules/@react-spring/web/dist/react-spring_web.modern.mjs
// src/index.ts
// src/applyAnimatedValues.ts
var no=/^--/;function ns(e,t){if(t==null||typeof t==="boolean"||t==="")return"";if(typeof t==="number"&&t!==0&&!no.test(e)&&!(nc.hasOwnProperty(e)&&nc[e]))return t+"px";return(""+t).trim()}var nu={};function nl(e,t){if(!e.nodeType||!e.setAttribute){return false}const r=e.nodeName==="filter"||e.parentNode&&e.parentNode.nodeName==="filter";const{className:n,style:a,children:i,scrollTop:o,scrollLeft:s,viewBox:u,...l}=t;const c=Object.values(l);const f=Object.keys(l).map(t=>r||e.hasAttribute(t)?t:nu[t]||(nu[t]=t.replace(/([A-Z])/g,// Attributes are written in dash case
    e=>"-"+e.toLowerCase())));if(i!==void 0){e.textContent=i}for(const t in a){if(a.hasOwnProperty(t)){const r=ns(t,a[t]);if(no.test(t)){e.style.setProperty(t,r)}else{e.style[t]=r}}}f.forEach((t,r)=>{e.setAttribute(t,c[r])});if(n!==void 0){e.className=n}if(o!==void 0){e.scrollTop=o}if(s!==void 0){e.scrollLeft=s}if(u!==void 0){e.setAttribute("viewBox",u)}}var nc={animationIterationCount:true,borderImageOutset:true,borderImageSlice:true,borderImageWidth:true,boxFlex:true,boxFlexGroup:true,boxOrdinalGroup:true,columnCount:true,columns:true,flex:true,flexGrow:true,flexPositive:true,flexShrink:true,flexNegative:true,flexOrder:true,gridRow:true,gridRowEnd:true,gridRowSpan:true,gridRowStart:true,gridColumn:true,gridColumnEnd:true,gridColumnSpan:true,gridColumnStart:true,fontWeight:true,lineClamp:true,lineHeight:true,opacity:true,order:true,orphans:true,tabSize:true,widows:true,zIndex:true,zoom:true,// SVG-related properties
fillOpacity:true,floodOpacity:true,stopOpacity:true,strokeDasharray:true,strokeDashoffset:true,strokeMiterlimit:true,strokeOpacity:true,strokeWidth:true};var nf=(e,t)=>e+t.charAt(0).toUpperCase()+t.substring(1);var nd=["Webkit","Ms","Moz","O"];nc=Object.keys(nc).reduce((e,t)=>{nd.forEach(r=>e[nf(r,t)]=e[t]);return e},nc);// src/AnimatedStyle.ts
var nh=/^(matrix|translate|scale|rotate|skew)/;var np=/^(translate)/;var nv=/^(rotate|skew)/;var nm=(e,t)=>R.num(e)&&e!==0?e+t:e;var ng=(e,t)=>R.arr(e)?e.every(e=>ng(e,t)):R.num(e)?e===t:parseFloat(e)===t;var nb=class extends tI{constructor({x:e,y:t,z:r,...n}){const a=[];const i=[];if(e||t||r){a.push([e||0,t||0,r||0]);i.push(e=>[`translate3d(${e.map(e=>nm(e,"px")).join(",")})`,// prettier-ignore
    ng(e,0)])}I(n,(e,t)=>{if(t==="transform"){a.push([e||""]);i.push(e=>[e,e===""])}else if(nh.test(t)){delete n[t];if(R.und(e))return;const r=np.test(t)?"px":nv.test(t)?"deg":"";a.push(D(e));i.push(t==="rotate3d"?([e,t,n,a])=>[`rotate3d(${e},${t},${n},${nm(a,r)})`,ng(a,0)]:e=>[`${t}(${e.map(e=>nm(e,r)).join(",")})`,ng(e,t.startsWith("scale")?1:0)])}});if(a.length){n.transform=new ny(a,i)}super(n)}};var ny=class extends ej{constructor(e,t){super();this.inputs=e;this.transforms=t;this._value=null}get(){return this._value||(this._value=this._get())}_get(){let e="";let t=true;P(this.inputs,(r,n)=>{const a=eM(r[0]);const[i,o]=this.transforms[n](R.arr(a)?a:r.map(eM));e+=" "+i;t=t&&o});return t?"none":e}// Start observing our inputs once we have an observer.
observerAdded(e){if(e==1)P(this.inputs,e=>P(e,e=>eD(e)&&eH(e,this)))}// Stop observing our inputs once we have no observers.
observerRemoved(e){if(e==0)P(this.inputs,e=>P(e,e=>eD(e)&&eB(e,this)))}eventObserved(e){if(e.type=="change"){this._value=null}eN(this,e)}};// src/primitives.ts
var nw=["a","abbr","address","area","article","aside","audio","b","base","bdi","bdo","big","blockquote","body","br","button","canvas","caption","cite","code","col","colgroup","data","datalist","dd","del","details","dfn","dialog","div","dl","dt","em","embed","fieldset","figcaption","figure","footer","form","h1","h2","h3","h4","h5","h6","head","header","hgroup","hr","html","i","iframe","img","input","ins","kbd","keygen","label","legend","li","link","main","map","mark","menu","menuitem","meta","meter","nav","noscript","object","ol","optgroup","option","output","p","param","picture","pre","progress","q","rp","rt","ruby","s","samp","script","section","select","small","source","span","strong","style","sub","summary","sup","table","tbody","td","textarea","tfoot","th","thead","time","title","tr","track","u","ul","var","video","wbr",// SVG
"circle","clipPath","defs","ellipse","foreignObject","g","image","line","linearGradient","mask","path","pattern","polygon","polyline","radialGradient","rect","stop","svg","text","tspan"];// src/index.ts
A.assign({batchedUpdates:ni.unstable_batchedUpdates,createStringInterpolator:eJ,colors:ee});var n_=tB(nw,{applyAnimatedValues:nl,createAnimatedStyle:e=>new nb(e),// eslint-disable-next-line @typescript-eslint/no-unused-vars
getComponentProps:({scrollTop:e,scrollLeft:t,...r})=>r});var nx=n_.animated;//# sourceMappingURL=react-spring_web.modern.mjs.map
},7317:function(e,t,r){"use strict";// EXPORTS
r.d(t,{_:()=>/* binding */a});// CONCATENATED MODULE: ../tutor/node_modules/@swc/helpers/esm/_define_property.js
function n(e,t,r){if(t in e){Object.defineProperty(e,t,{value:r,enumerable:true,configurable:true,writable:true})}else e[t]=r;return e};// CONCATENATED MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_spread.js
function a(e){for(var t=1;t<arguments.length;t++){var r=arguments[t]!=null?arguments[t]:{};var a=Object.keys(r);if(typeof Object.getOwnPropertySymbols==="function"){a=a.concat(Object.getOwnPropertySymbols(r).filter(function(e){return Object.getOwnPropertyDescriptor(r,e).enumerable}))}a.forEach(function(t){n(e,t,r[t])})}return e}},8015:function(e,t,r){"use strict";r.d(t,{_:()=>a});function n(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);if(t){n=n.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})}r.push.apply(r,n)}return r}function a(e,t){t=t!=null?t:{};if(Object.getOwnPropertyDescriptors)Object.defineProperties(e,Object.getOwnPropertyDescriptors(t));else{n(Object(t)).forEach(function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))})}return e}},9414:function(e,t,r){"use strict";// EXPORTS
r.d(t,{_:()=>/* binding */a});// CONCATENATED MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_without_properties_loose.js
function n(e,t){if(e==null)return{};var r={};var n=Object.keys(e);var a,i;for(i=0;i<n.length;i++){a=n[i];if(t.indexOf(a)>=0)continue;r[a]=e[a]}return r};// CONCATENATED MODULE: ../tutor/node_modules/@swc/helpers/esm/_object_without_properties.js
function a(e,t){if(e==null)return{};var r=n(e,t);var a,i;if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);for(i=0;i<o.length;i++){a=o[i];if(t.indexOf(a)>=0)continue;if(!Object.prototype.propertyIsEnumerable.call(e,a))continue;r[a]=e[a]}}return r}},6154:function(e,t,r){"use strict";r.d(t,{_:()=>n});function n(e,t){if(!t)t=e.slice(0);return Object.freeze(Object.defineProperties(e,{raw:{value:Object.freeze(t)}}))}}};/************************************************************************/// The module cache
var t={};// The require function
function r(n){// Check if module is in cache
var a=t[n];if(a!==undefined){return a.exports}// Create a new module (and put it into the cache)
var i=t[n]={id:n,exports:{}};// Execute the module function
e[n](i,i.exports,r);// Return the exports of the module
return i.exports}// expose the modules object (__webpack_modules__)
r.m=e;/************************************************************************/// webpack/runtime/compat_get_default_export
(()=>{// getDefaultExport function for compatibility with non-ESM modules
r.n=e=>{var t=e&&e.__esModule?()=>e["default"]:()=>e;r.d(t,{a:t});return t}})();// webpack/runtime/define_property_getters
(()=>{r.d=(e,t)=>{for(var n in t){if(r.o(t,n)&&!r.o(e,n)){Object.defineProperty(e,n,{enumerable:true,get:t[n]})}}}})();// webpack/runtime/ensure_chunk
(()=>{r.f={};// This file contains only the entry chunk.
// The chunk loading function for additional chunks
r.e=e=>{return Promise.all(Object.keys(r.f).reduce((t,n)=>{r.f[n](e,t);return t},[]))}})();// webpack/runtime/get javascript chunk filename
(()=>{// This function allow to reference chunks
r.u=e=>{// return url for filenames not based on template
// return url for filenames based on template
return"lazy-chunks/"+({"421":"bundle-builder-basic","626":"bundle-builder-additional"})[e]+".js?ver=3.9.5"}})();// webpack/runtime/get mini-css chunk filename
(()=>{// This function allow to reference chunks
r.miniCssF=e=>{// return url for filenames not based on template
// return url for filenames based on template
return""+e+".css"}})();// webpack/runtime/global
(()=>{r.g=(()=>{if(typeof globalThis==="object")return globalThis;try{return this||new Function("return this")()}catch(e){if(typeof window==="object")return window}})()})();// webpack/runtime/has_own_property
(()=>{r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t)})();// webpack/runtime/load_script
(()=>{var e={};var t="tutor-pro:";// loadScript function to load a script via script tag
r.l=function(n,a,i,o){if(e[n]){e[n].push(a);return}var s,u;if(i!==undefined){var l=document.getElementsByTagName("script");for(var c=0;c<l.length;c++){var f=l[c];if(f.getAttribute("src")==n||f.getAttribute("data-webpack")==t+i){s=f;break}}}if(!s){u=true;s=document.createElement("script");s.charset="utf-8";s.timeout=120;if(r.nc){s.setAttribute("nonce",r.nc)}s.setAttribute("data-webpack",t+i);s.src=n}e[n]=[a];var d=function(t,r){s.onerror=s.onload=null;clearTimeout(h);var a=e[n];delete e[n];s.parentNode&&s.parentNode.removeChild(s);a&&a.forEach(function(e){return e(r)});if(t)return t(r)};var h=setTimeout(d.bind(null,undefined,{type:"timeout",target:s}),12e4);s.onerror=d.bind(null,s.onerror);s.onload=d.bind(null,s.onload);u&&document.head.appendChild(s)}})();// webpack/runtime/make_namespace_object
(()=>{// define __esModule on exports
r.r=e=>{if(typeof Symbol!=="undefined"&&Symbol.toStringTag){Object.defineProperty(e,Symbol.toStringTag,{value:"Module"})}Object.defineProperty(e,"__esModule",{value:true})}})();// webpack/runtime/nonce
(()=>{r.nc=undefined})();// webpack/runtime/rspack_version
(()=>{r.rv=()=>"1.5.7"})();// webpack/runtime/auto_public_path
(()=>{var e;if(r.g.importScripts)e=r.g.location+"";var t=r.g.document;if(!e&&t){// Technically we could use `document.currentScript instanceof window.HTMLScriptElement`,
// but an attacker could try to inject `<script>HTMLScriptElement = HTMLImageElement</script>`
// and use `<img name="currentScript" src="https://attacker.controlled.server/"></img>`
if(t.currentScript&&t.currentScript.tagName.toUpperCase()==="SCRIPT")e=t.currentScript.src;if(!e){var n=t.getElementsByTagName("script");if(n.length){var a=n.length-1;while(a>-1&&(!e||!/^http(s?):/.test(e)))e=n[a--].src}}}// When supporting browsers where an automatic publicPath is not supported you must specify an output.publicPath manually via configuration",
// or pass an empty string ("") and set the __webpack_public_path__ variable from your code to use your own logic.',
if(!e)throw new Error("Automatic publicPath is not supported in this browser");e=e.replace(/^blob:/,"").replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/");r.p=e})();// webpack/runtime/jsonp_chunk_loading
(()=>{// object to store loaded and loading chunks
// undefined = chunk not loaded, null = chunk preloaded/prefetched
// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
var e={"410":0};r.f.j=function(t,n){// JSONP chunk loading for javascript
var a=r.o(e,t)?e[t]:undefined;if(a!==0){// 0 means "already installed".
// a Promise means "currently loading".
if(a){n.push(a[2])}else{if(true){// setup Promise in chunk cache
var i=new Promise((r,n)=>a=e[t]=[r,n]);n.push(a[2]=i);// start chunk loading
var o=r.p+r.u(t);// create error before stack unwound to get useful stacktrace later
var s=new Error;var u=function(n){if(r.o(e,t)){a=e[t];if(a!==0)e[t]=undefined;if(a){var i=n&&(n.type==="load"?"missing":n.type);var o=n&&n.target&&n.target.src;s.message="Loading chunk "+t+" failed.\n("+i+": "+o+")";s.name="ChunkLoadError";s.type=i;s.request=o;a[1](s)}}};r.l(o,u,"chunk-"+t,t)}}}};// install a JSONP callback for chunk loading
var t=(t,n)=>{var[a,i,o]=n;// add "moreModules" to the modules object,
// then flag all "chunkIds" as loaded and fire callback
var s,u,l=0;if(a.some(t=>e[t]!==0)){for(s in i){if(r.o(i,s)){r.m[s]=i[s]}}if(o)var c=o(r)}if(t)t(n);for(;l<a.length;l++){u=a[l];if(r.o(e,u)&&e[u]){e[u][0]()}e[u]=0}};var n=self["webpackChunktutor_pro"]=self["webpackChunktutor_pro"]||[];n.forEach(t.bind(null,0));n.push=t.bind(null,n.push.bind(n))})();// webpack/runtime/rspack_unique_id
(()=>{r.ruid="bundler=rspack@1.5.7"})();/************************************************************************/var n={};// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";// EXTERNAL MODULE: ./node_modules/@emotion/react/jsx-runtime/dist/emotion-react-jsx-runtime.esm.js
var e=r(3747);// EXTERNAL MODULE: external "React"
var t=r(1594);var n=/*#__PURE__*/r.n(t);// EXTERNAL MODULE: ./node_modules/react-dom/client.js
var a=r(5338);// EXTERNAL MODULE: external "ReactDOM"
var i=r(5206);// EXTERNAL MODULE: ./node_modules/react-router/dist/index.js
var o=r(7767);// EXTERNAL MODULE: ./node_modules/@remix-run/router/dist/router.js
var s=r(5588);// CONCATENATED MODULE: ./node_modules/react-router-dom/dist/index.js
/**
 * React Router DOM v6.30.1
 *
 * Copyright (c) Remix Software Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE.md file in the root directory of this source tree.
 *
 * @license MIT
 */function u(){u=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r){if(Object.prototype.hasOwnProperty.call(r,n)){e[n]=r[n]}}}return e};return u.apply(this,arguments)}function l(e,t){if(e==null)return{};var r={};var n=Object.keys(e);var a,i;for(i=0;i<n.length;i++){a=n[i];if(t.indexOf(a)>=0)continue;r[a]=e[a]}return r}const c="get";const f="application/x-www-form-urlencoded";function d(e){return e!=null&&typeof e.tagName==="string"}function h(e){return d(e)&&e.tagName.toLowerCase()==="button"}function p(e){return d(e)&&e.tagName.toLowerCase()==="form"}function v(e){return d(e)&&e.tagName.toLowerCase()==="input"}function m(e){return!!(e.metaKey||e.altKey||e.ctrlKey||e.shiftKey)}function g(e,t){return e.button===0&&// Ignore everything but left clicks
(!t||t==="_self")&&// Let browser handle "target=_blank" etc.
!m(e)// Ignore clicks with modifier keys
}/**
 * Creates a URLSearchParams object using the given initializer.
 *
 * This is identical to `new URLSearchParams(init)` except it also
 * supports arrays as values in the object form of the initializer
 * instead of just strings. This is convenient when you need multiple
 * values for a given key, but don't want to use an array initializer.
 *
 * For example, instead of:
 *
 *   let searchParams = new URLSearchParams([
 *     ['sort', 'name'],
 *     ['sort', 'price']
 *   ]);
 *
 * you can do:
 *
 *   let searchParams = createSearchParams({
 *     sort: ['name', 'price']
 *   });
 */function b(e){if(e===void 0){e=""}return new URLSearchParams(typeof e==="string"||Array.isArray(e)||e instanceof URLSearchParams?e:Object.keys(e).reduce((t,r)=>{let n=e[r];return t.concat(Array.isArray(n)?n.map(e=>[r,e]):[[r,n]])},[]))}function y(e,t){let r=b(e);if(t){// Use `defaultSearchParams.forEach(...)` here instead of iterating of
// `defaultSearchParams.keys()` to work-around a bug in Firefox related to
// web extensions. Relevant Bugzilla tickets:
// https://bugzilla.mozilla.org/show_bug.cgi?id=1414602
// https://bugzilla.mozilla.org/show_bug.cgi?id=1023984
t.forEach((e,n)=>{if(!r.has(n)){t.getAll(n).forEach(e=>{r.append(n,e)})}})}return r}// One-time check for submitter support
let w=null;function _(){if(w===null){try{new FormData(document.createElement("form"),// @ts-expect-error if FormData supports the submitter parameter, this will throw
0);w=false}catch(e){w=true}}return w}const x=new Set(["application/x-www-form-urlencoded","multipart/form-data","text/plain"]);function E(e){if(e!=null&&!x.has(e)){false?0:void 0;return null}return e}function O(e,t){let r;let n;let a;let i;let o;if(p(e)){// When grabbing the action from the element, it will have had the basename
// prefixed to ensure non-JS scenarios work, so strip it since we'll
// re-prefix in the router
let o=e.getAttribute("action");n=o?stripBasename(o,t):null;r=e.getAttribute("method")||c;a=E(e.getAttribute("enctype"))||f;i=new FormData(e)}else if(h(e)||v(e)&&(e.type==="submit"||e.type==="image")){let o=e.form;if(o==null){throw new Error('Cannot submit a <button> or <input type="submit"> without a <form>')}// <button>/<input type="submit"> may override attributes of <form>
// When grabbing the action from the element, it will have had the basename
// prefixed to ensure non-JS scenarios work, so strip it since we'll
// re-prefix in the router
let s=e.getAttribute("formaction")||o.getAttribute("action");n=s?stripBasename(s,t):null;r=e.getAttribute("formmethod")||o.getAttribute("method")||c;a=E(e.getAttribute("formenctype"))||E(o.getAttribute("enctype"))||f;// Build a FormData object populated from a form and submitter
i=new FormData(o,e);// If this browser doesn't support the `FormData(el, submitter)` format,
// then tack on the submitter value at the end.  This is a lightweight
// solution that is not 100% spec compliant.  For complete support in older
// browsers, consider using the `formdata-submitter-polyfill` package
if(!_()){let{name:t,type:r,value:n}=e;if(r==="image"){let e=t?t+".":"";i.append(e+"x","0");i.append(e+"y","0")}else if(t){i.append(t,n)}}}else if(d(e)){throw new Error("Cannot submit element that is not <form>, <button>, or "+'<input type="submit|image">')}else{r=c;n=null;a=f;o=e}// Send body for <Form encType="text/plain" so we encode it into text
if(i&&a==="text/plain"){o=i;i=undefined}return{action:n,method:r.toLowerCase(),encType:a,formData:i,body:o}}const S=/* unused pure expression or super */null&&["onClick","relative","reloadDocument","replace","state","target","to","preventScrollReset","viewTransition"],A=/* unused pure expression or super */null&&["aria-current","caseSensitive","className","end","style","to","viewTransition","children"],T=/* unused pure expression or super */null&&["fetcherKey","navigate","reloadDocument","replace","state","method","action","onSubmit","relative","preventScrollReset","viewTransition"];// HEY YOU! DON'T TOUCH THIS VARIABLE!
//
// It is replaced with the proper version at build time via a babel plugin in
// the rollup config.
//
// Export a global property onto the window for React Router detection by the
// Core Web Vitals Technology Report.  This way they can configure the `wappalyzer`
// to detect and properly classify live websites as being built with React Router:
// https://github.com/HTTPArchive/wappalyzer/blob/main/src/technologies/r.json
const k="6";try{window.__reactRouterVersion=k}catch(e){// no-op
}function R(e,t){return createRouter({basename:t==null?void 0:t.basename,future:u({},t==null?void 0:t.future,{v7_prependBasename:true}),history:createBrowserHistory({window:t==null?void 0:t.window}),hydrationData:(t==null?void 0:t.hydrationData)||P(),routes:e,mapRouteProperties:UNSAFE_mapRouteProperties,dataStrategy:t==null?void 0:t.dataStrategy,patchRoutesOnNavigation:t==null?void 0:t.patchRoutesOnNavigation,window:t==null?void 0:t.window}).initialize()}function C(e,t){return createRouter({basename:t==null?void 0:t.basename,future:u({},t==null?void 0:t.future,{v7_prependBasename:true}),history:createHashHistory({window:t==null?void 0:t.window}),hydrationData:(t==null?void 0:t.hydrationData)||P(),routes:e,mapRouteProperties:UNSAFE_mapRouteProperties,dataStrategy:t==null?void 0:t.dataStrategy,patchRoutesOnNavigation:t==null?void 0:t.patchRoutesOnNavigation,window:t==null?void 0:t.window}).initialize()}function P(){var e;let t=(e=window)==null?void 0:e.__staticRouterHydrationData;if(t&&t.errors){t=u({},t,{errors:I(t.errors)})}return t}function I(e){if(!e)return null;let t=Object.entries(e);let r={};for(let[e,n]of t){// Hey you!  If you change this, please change the corresponding logic in
// serializeErrors in react-router-dom/server.tsx :)
if(n&&n.__type==="RouteErrorResponse"){r[e]=new UNSAFE_ErrorResponseImpl(n.status,n.statusText,n.data,n.internal===true)}else if(n&&n.__type==="Error"){// Attempt to reconstruct the right type of Error (i.e., ReferenceError)
if(n.__subType){let t=window[n.__subType];if(typeof t==="function"){try{// @ts-expect-error
let a=new t(n.message);// Wipe away the client-side stack trace.  Nothing to fill it in with
// because we don't serialize SSR stack traces for security reasons
a.stack="";r[e]=a}catch(e){// no-op - fall through and create a normal Error
}}}if(r[e]==null){let t=new Error(n.message);// Wipe away the client-side stack trace.  Nothing to fill it in with
// because we don't serialize SSR stack traces for security reasons
t.stack="";r[e]=t}}else{r[e]=n}}return r}const D=/*#__PURE__*//* unused pure expression or super */null&&React.createContext({isTransitioning:false});if(false){}const M=/*#__PURE__*/t.createContext(new Map);if(false){}//#endregion
////////////////////////////////////////////////////////////////////////////////
//#region Components
////////////////////////////////////////////////////////////////////////////////
/**
  Webpack + React 17 fails to compile on any of the following because webpack
  complains that `startTransition` doesn't exist in `React`:
  * import { startTransition } from "react"
  * import * as React from from "react";
    "startTransition" in React ? React.startTransition(() => setState()) : setState()
  * import * as React from from "react";
    "startTransition" in React ? React["startTransition"](() => setState()) : setState()

  Moving it to a constant such as the following solves the Webpack/React 17 issue:
  * import * as React from from "react";
    const START_TRANSITION = "startTransition";
    START_TRANSITION in React ? React[START_TRANSITION](() => setState()) : setState()

  However, that introduces webpack/terser minification issues in production builds
  in React 18 where minification/obfuscation ends up removing the call of
  React.startTransition entirely from the first half of the ternary.  Grabbing
  this exported reference once up front resolves that issue.

  See https://github.com/remix-run/react-router/issues/10579
*/const F="startTransition";const L=t[F];const N="flushSync";const j=i[N];const U="useId";const H=t[U];function B(e){if(L){L(e)}else{e()}}function Y(e){if(j){j(e)}else{e()}}class z{constructor(){this.status="pending";this.promise=new Promise((e,t)=>{this.resolve=t=>{if(this.status==="pending"){this.status="resolved";e(t)}};this.reject=e=>{if(this.status==="pending"){this.status="rejected";t(e)}}})}}/**
 * Given a Remix Router instance, render the appropriate UI
 */function q(e){let{fallbackElement:t,router:r,future:n}=e;let[a,i]=React.useState(r.state);let[o,s]=React.useState();let[u,l]=React.useState({isTransitioning:false});let[c,f]=React.useState();let[d,h]=React.useState();let[p,v]=React.useState();let m=React.useRef(new Map);let{v7_startTransition:g}=n||{};let b=React.useCallback(e=>{if(g){B(e)}else{e()}},[g]);let y=React.useCallback((e,t)=>{let{deletedFetchers:n,flushSync:a,viewTransitionOpts:o}=t;e.fetchers.forEach((e,t)=>{if(e.data!==undefined){m.current.set(t,e.data)}});n.forEach(e=>m.current.delete(e));let u=r.window==null||r.window.document==null||typeof r.window.document.startViewTransition!=="function";// If this isn't a view transition or it's not available in this browser,
// just update and be done with it
if(!o||u){if(a){Y(()=>i(e))}else{b(()=>i(e))}return}// flushSync + startViewTransition
if(a){// Flush through the context to mark DOM elements as transition=ing
Y(()=>{// Cancel any pending transitions
if(d){c&&c.resolve();d.skipTransition()}l({isTransitioning:true,flushSync:true,currentLocation:o.currentLocation,nextLocation:o.nextLocation})});// Update the DOM
let t=r.window.document.startViewTransition(()=>{Y(()=>i(e))});// Clean up after the animation completes
t.finished.finally(()=>{Y(()=>{f(undefined);h(undefined);s(undefined);l({isTransitioning:false})})});Y(()=>h(t));return}// startTransition + startViewTransition
if(d){// Interrupting an in-progress transition, cancel and let everything flush
// out, and then kick off a new transition from the interruption state
c&&c.resolve();d.skipTransition();v({state:e,currentLocation:o.currentLocation,nextLocation:o.nextLocation})}else{// Completed navigation update with opted-in view transitions, let 'er rip
s(e);l({isTransitioning:true,flushSync:false,currentLocation:o.currentLocation,nextLocation:o.nextLocation})}},[r.window,d,c,m,b]);// Need to use a layout effect here so we are subscribed early enough to
// pick up on any render-driven redirects/navigations (useEffect/<Navigate>)
React.useLayoutEffect(()=>r.subscribe(y),[r,y]);// When we start a view transition, create a Deferred we can use for the
// eventual "completed" render
React.useEffect(()=>{if(u.isTransitioning&&!u.flushSync){f(new z)}},[u]);// Once the deferred is created, kick off startViewTransition() to update the
// DOM and then wait on the Deferred to resolve (indicating the DOM update has
// happened)
React.useEffect(()=>{if(c&&o&&r.window){let e=o;let t=c.promise;let n=r.window.document.startViewTransition(async()=>{b(()=>i(e));await t});n.finished.finally(()=>{f(undefined);h(undefined);s(undefined);l({isTransitioning:false})});h(n)}},[b,o,c,r.window]);// When the new location finally renders and is committed to the DOM, this
// effect will run to resolve the transition
React.useEffect(()=>{if(c&&o&&a.location.key===o.location.key){c.resolve()}},[c,d,a.location,o]);// If we get interrupted with a new navigation during a transition, we skip
// the active transition, let it cleanup, then kick it off again here
React.useEffect(()=>{if(!u.isTransitioning&&p){s(p.state);l({isTransitioning:true,flushSync:false,currentLocation:p.currentLocation,nextLocation:p.nextLocation});v(undefined)}},[u.isTransitioning,p]);React.useEffect(()=>{false?0:void 0;// Only log this once on initial mount
// eslint-disable-next-line react-hooks/exhaustive-deps
},[]);let w=React.useMemo(()=>{return{createHref:r.createHref,encodeLocation:r.encodeLocation,go:e=>r.navigate(e),push:(e,t,n)=>r.navigate(e,{state:t,preventScrollReset:n==null?void 0:n.preventScrollReset}),replace:(e,t,n)=>r.navigate(e,{replace:true,state:t,preventScrollReset:n==null?void 0:n.preventScrollReset})}},[r]);let _=r.basename||"/";let x=React.useMemo(()=>({router:r,navigator:w,static:false,basename:_}),[r,w,_]);let E=React.useMemo(()=>({v7_relativeSplatPath:r.future.v7_relativeSplatPath}),[r.future.v7_relativeSplatPath]);React.useEffect(()=>UNSAFE_logV6DeprecationWarnings(n,r.future),[n,r.future]);// The fragment and {null} here are important!  We need them to keep React 18's
// useId happy when we are server-rendering since we may have a <script> here
// containing the hydrated server-side staticContext (from StaticRouterProvider).
// useId relies on the component tree structure to generate deterministic id's
// so we need to ensure it remains the same on the client even though
// we don't need the <script> tag
return /*#__PURE__*/React.createElement(React.Fragment,null,/*#__PURE__*/React.createElement(UNSAFE_DataRouterContext.Provider,{value:x},/*#__PURE__*/React.createElement(UNSAFE_DataRouterStateContext.Provider,{value:a},/*#__PURE__*/React.createElement(M.Provider,{value:m.current},/*#__PURE__*/React.createElement(D.Provider,{value:u},/*#__PURE__*/React.createElement(Router,{basename:_,location:a.location,navigationType:a.historyAction,navigator:w,future:E},a.initialized||r.future.v7_partialHydration?/*#__PURE__*/React.createElement(V,{routes:r.routes,future:r.future,state:a}):t))))),null)}// Memoize to avoid re-renders when updating `ViewTransitionContext`
const V=/*#__PURE__*//* unused pure expression or super */null&&React.memo(W);function W(e){let{routes:t,future:r,state:n}=e;return UNSAFE_useRoutesImpl(t,undefined,n,r)}/**
 * A `<Router>` for use in web browsers. Provides the cleanest URLs.
 */function $(e){let{basename:t,children:r,future:n,window:a}=e;let i=React.useRef();if(i.current==null){i.current=createBrowserHistory({window:a,v5Compat:true})}let o=i.current;let[s,u]=React.useState({action:o.action,location:o.location});let{v7_startTransition:l}=n||{};let c=React.useCallback(e=>{l&&L?L(()=>u(e)):u(e)},[u,l]);React.useLayoutEffect(()=>o.listen(c),[o,c]);React.useEffect(()=>UNSAFE_logV6DeprecationWarnings(n),[n]);return /*#__PURE__*/React.createElement(Router,{basename:t,children:r,location:s.location,navigationType:s.action,navigator:o,future:n})}/**
 * A `<Router>` for use in web browsers. Stores the location in the hash
 * portion of the URL so it is not sent to the server.
 */function G(e){let{basename:r,children:n,future:a,window:i}=e;let u=t.useRef();if(u.current==null){u.current=(0,s/* .createHashHistory */.TM)({window:i,v5Compat:true})}let l=u.current;let[c,f]=t.useState({action:l.action,location:l.location});let{v7_startTransition:d}=a||{};let h=t.useCallback(e=>{d&&L?L(()=>f(e)):f(e)},[f,d]);t.useLayoutEffect(()=>l.listen(h),[l,h]);t.useEffect(()=>(0,o/* .UNSAFE_logV6DeprecationWarnings */.V8)(a),[a]);return /*#__PURE__*/t.createElement(o/* .Router */.Ix,{basename:r,children:n,location:c.location,navigationType:c.action,navigator:l,future:a})}/**
 * A `<Router>` that accepts a pre-instantiated history object. It's important
 * to note that using your own history object is highly discouraged and may add
 * two versions of the history library to your bundles unless you use the same
 * version of the history library that React Router uses internally.
 */function K(e){let{basename:t,children:r,future:n,history:a}=e;let[i,o]=React.useState({action:a.action,location:a.location});let{v7_startTransition:s}=n||{};let u=React.useCallback(e=>{s&&L?L(()=>o(e)):o(e)},[o,s]);React.useLayoutEffect(()=>a.listen(u),[a,u]);React.useEffect(()=>UNSAFE_logV6DeprecationWarnings(n),[n]);return /*#__PURE__*/React.createElement(Router,{basename:t,children:r,location:i.location,navigationType:i.action,navigator:a,future:n})}if(false){}const Q=typeof window!=="undefined"&&typeof window.document!=="undefined"&&typeof window.document.createElement!=="undefined";const X=/^(?:[a-z][a-z0-9+.-]*:|\/\/)/i;/**
 * The public API for rendering a history-aware `<a>`.
 */const J=/*#__PURE__*//* unused pure expression or super */null&&React.forwardRef(function e(e,t){let{onClick:r,relative:n,reloadDocument:a,replace:i,state:o,target:s,to:c,preventScrollReset:f,viewTransition:d}=e,h=l(e,S);let{basename:p}=React.useContext(UNSAFE_NavigationContext);// Rendered into <a href> for absolute URLs
let v;let m=false;if(typeof c==="string"&&X.test(c)){// Render the absolute href server- and client-side
v=c;// Only check for external origins client-side
if(Q){try{let e=new URL(window.location.href);let t=c.startsWith("//")?new URL(e.protocol+c):new URL(c);let r=stripBasename(t.pathname,p);if(t.origin===e.origin&&r!=null){// Strip the protocol/origin/basename for same-origin absolute URLs
c=r+t.search+t.hash}else{m=true}}catch(e){// We can't do external URL detection without a valid URL
false?0:void 0}}}// Rendered into <a href> for relative URLs
let g=useHref(c,{relative:n});let b=es(c,{replace:i,state:o,target:s,preventScrollReset:f,relative:n,viewTransition:d});function y(e){if(r)r(e);if(!e.defaultPrevented){b(e)}}return(/*#__PURE__*/// eslint-disable-next-line jsx-a11y/anchor-has-content
React.createElement("a",u({},h,{href:v||g,onClick:m||a?r:y,ref:t,target:s})))});if(false){}/**
 * A `<Link>` wrapper that knows if it's "active" or not.
 */const Z=/*#__PURE__*//* unused pure expression or super */null&&React.forwardRef(function e(e,t){let{"aria-current":r="page",caseSensitive:n=false,className:a="",end:i=false,style:o,to:s,viewTransition:c,children:f}=e,d=l(e,A);let h=useResolvedPath(s,{relative:d.relative});let p=useLocation();let v=React.useContext(UNSAFE_DataRouterStateContext);let{navigator:m,basename:g}=React.useContext(UNSAFE_NavigationContext);let b=v!=null&&// Conditional usage is OK here because the usage of a data router is static
// eslint-disable-next-line react-hooks/rules-of-hooks
ex(h)&&c===true;let y=m.encodeLocation?m.encodeLocation(h).pathname:h.pathname;let w=p.pathname;let _=v&&v.navigation&&v.navigation.location?v.navigation.location.pathname:null;if(!n){w=w.toLowerCase();_=_?_.toLowerCase():null;y=y.toLowerCase()}if(_&&g){_=stripBasename(_,g)||_}// If the `to` has a trailing slash, look at that exact spot.  Otherwise,
// we're looking for a slash _after_ what's in `to`.  For example:
//
// <NavLink to="/users"> and <NavLink to="/users/">
// both want to look for a / at index 6 to match URL `/users/matt`
const x=y!=="/"&&y.endsWith("/")?y.length-1:y.length;let E=w===y||!i&&w.startsWith(y)&&w.charAt(x)==="/";let O=_!=null&&(_===y||!i&&_.startsWith(y)&&_.charAt(y.length)==="/");let S={isActive:E,isPending:O,isTransitioning:b};let T=E?r:undefined;let k;if(typeof a==="function"){k=a(S)}else{// If the className prop is not a function, we use a default `active`
// class for <NavLink />s that are active. In v5 `active` was the default
// value for `activeClassName`, but we are removing that API and can still
// use the old default behavior for a cleaner upgrade path and keep the
// simple styling rules working as they currently do.
k=[a,E?"active":null,O?"pending":null,b?"transitioning":null].filter(Boolean).join(" ")}let R=typeof o==="function"?o(S):o;return /*#__PURE__*/React.createElement(J,u({},d,{"aria-current":T,className:k,ref:t,style:R,to:s,viewTransition:c}),typeof f==="function"?f(S):f)});if(false){}/**
 * A `@remix-run/router`-aware `<form>`. It behaves like a normal form except
 * that the interaction with the server is with `fetch` instead of new document
 * requests, allowing components to add nicer UX to the page as the form is
 * submitted and returns with data.
 */const ee=/*#__PURE__*//* unused pure expression or super */null&&React.forwardRef((e,t)=>{let{fetcherKey:r,navigate:n,reloadDocument:a,replace:i,state:o,method:s=c,action:f,onSubmit:d,relative:h,preventScrollReset:p,viewTransition:v}=e,m=l(e,T);let g=ed();let b=eh(f,{relative:h});let y=s.toLowerCase()==="get"?"get":"post";let w=e=>{d&&d(e);if(e.defaultPrevented)return;e.preventDefault();let t=e.nativeEvent.submitter;let a=(t==null?void 0:t.getAttribute("formmethod"))||s;g(t||e.currentTarget,{fetcherKey:r,method:a,navigate:n,replace:i,state:o,relative:h,preventScrollReset:p,viewTransition:v})};return /*#__PURE__*/React.createElement("form",u({ref:t,method:y,action:b,onSubmit:a?d:w},m))});if(false){}/**
 * This component will emulate the browser's scroll restoration on location
 * changes.
 */function et(e){let{getKey:t,storageKey:r}=e;eb({getKey:t,storageKey:r});return null}if(false){}//#endregion
////////////////////////////////////////////////////////////////////////////////
//#region Hooks
////////////////////////////////////////////////////////////////////////////////
var er;(function(e){e["UseScrollRestoration"]="useScrollRestoration";e["UseSubmit"]="useSubmit";e["UseSubmitFetcher"]="useSubmitFetcher";e["UseFetcher"]="useFetcher";e["useViewTransitionState"]="useViewTransitionState"})(er||(er={}));var en;(function(e){e["UseFetcher"]="useFetcher";e["UseFetchers"]="useFetchers";e["UseScrollRestoration"]="useScrollRestoration"})(en||(en={}));// Internal hooks
function ea(e){return e+" must be used within a data router.  See https://reactrouter.com/v6/routers/picking-a-router."}function ei(e){let t=React.useContext(UNSAFE_DataRouterContext);!t?false?0:UNSAFE_invariant(false):void 0;return t}function eo(e){let t=React.useContext(UNSAFE_DataRouterStateContext);!t?false?0:UNSAFE_invariant(false):void 0;return t}// External hooks
/**
 * Handles the click behavior for router `<Link>` components. This is useful if
 * you need to create custom `<Link>` components with the same click behavior we
 * use in our exported `<Link>`.
 */function es(e,t){let{target:r,replace:n,state:a,preventScrollReset:i,relative:o,viewTransition:s}=t===void 0?{}:t;let u=useNavigate();let l=useLocation();let c=useResolvedPath(e,{relative:o});return React.useCallback(t=>{if(g(t,r)){t.preventDefault();// If the URL hasn't changed, a regular <a> will do a replace instead of
// a push, so do the same here unless the replace prop is explicitly set
let r=n!==undefined?n:createPath(l)===createPath(c);u(e,{replace:r,state:a,preventScrollReset:i,relative:o,viewTransition:s})}},[l,u,c,n,a,r,e,i,o,s])}/**
 * A convenient wrapper for reading and writing search parameters via the
 * URLSearchParams interface.
 */function eu(e){false?0:void 0;let t=React.useRef(b(e));let r=React.useRef(false);let n=useLocation();let a=React.useMemo(()=>// Only merge in the defaults if we haven't yet called setSearchParams.
    // Once we call that we want those to take precedence, otherwise you can't
    // remove a param with setSearchParams({}) if it has an initial value
    y(n.search,r.current?null:t.current),[n.search]);let i=useNavigate();let o=React.useCallback((e,t)=>{const n=b(typeof e==="function"?e(a):e);r.current=true;i("?"+n,t)},[i,a]);return[a,o]}function el(){if(typeof document==="undefined"){throw new Error("You are calling submit during the server render. "+"Try calling submit within a `useEffect` or callback instead.")}}let ec=0;let ef=()=>"__"+String(++ec)+"__";/**
 * Returns a function that may be used to programmatically submit a form (or
 * some arbitrary data) to the server.
 */function ed(){let{router:e}=ei(er.UseSubmit);let{basename:t}=React.useContext(UNSAFE_NavigationContext);let r=UNSAFE_useRouteId();return React.useCallback(function(n,a){if(a===void 0){a={}}el();let{action:i,method:o,encType:s,formData:u,body:l}=O(n,t);if(a.navigate===false){let t=a.fetcherKey||ef();e.fetch(t,r,a.action||i,{preventScrollReset:a.preventScrollReset,formData:u,body:l,formMethod:a.method||o,formEncType:a.encType||s,flushSync:a.flushSync})}else{e.navigate(a.action||i,{preventScrollReset:a.preventScrollReset,formData:u,body:l,formMethod:a.method||o,formEncType:a.encType||s,replace:a.replace,state:a.state,fromRouteId:r,flushSync:a.flushSync,viewTransition:a.viewTransition})}},[e,t,r])}// v7: Eventually we should deprecate this entirely in favor of using the
// router method directly?
function eh(e,t){let{relative:r}=t===void 0?{}:t;let{basename:n}=React.useContext(UNSAFE_NavigationContext);let a=React.useContext(UNSAFE_RouteContext);!a?false?0:UNSAFE_invariant(false):void 0;let[i]=a.matches.slice(-1);// Shallow clone path so we can modify it below, otherwise we modify the
// object referenced by useMemo inside useResolvedPath
let o=u({},useResolvedPath(e?e:".",{relative:r}));// If no action was specified, browsers will persist current search params
// when determining the path, so match that behavior
// https://github.com/remix-run/remix/issues/927
let s=useLocation();if(e==null){// Safe to write to this directly here since if action was undefined, we
// would have called useResolvedPath(".") which will never include a search
o.search=s.search;// When grabbing search params from the URL, remove any included ?index param
// since it might not apply to our contextual route.  We add it back based
// on match.route.index below
let e=new URLSearchParams(o.search);let t=e.getAll("index");let r=t.some(e=>e==="");if(r){e.delete("index");t.filter(e=>e).forEach(t=>e.append("index",t));let r=e.toString();o.search=r?"?"+r:""}}if((!e||e===".")&&i.route.index){o.search=o.search?o.search.replace(/^\?/,"?index&"):"?index"}// If we're operating within a basename, prepend it to the pathname prior
// to creating the form action.  If this is a root navigation, then just use
// the raw basename which allows the basename to have full control over the
// presence of a trailing slash on root actions
if(n!=="/"){o.pathname=o.pathname==="/"?n:joinPaths([n,o.pathname])}return createPath(o)}// TODO: (v7) Change the useFetcher generic default from `any` to `unknown`
/**
 * Interacts with route loaders and actions without causing a navigation. Great
 * for any interaction that stays on the same page.
 */function ep(e){var t;let{key:r}=e===void 0?{}:e;let{router:n}=ei(er.UseFetcher);let a=eo(en.UseFetcher);let i=React.useContext(M);let o=React.useContext(UNSAFE_RouteContext);let s=(t=o.matches[o.matches.length-1])==null?void 0:t.route.id;!i?false?0:UNSAFE_invariant(false):void 0;!o?false?0:UNSAFE_invariant(false):void 0;!(s!=null)?false?0:UNSAFE_invariant(false):void 0;// Fetcher key handling
// OK to call conditionally to feature detect `useId`
// eslint-disable-next-line react-hooks/rules-of-hooks
let l=H?H():"";let[c,f]=React.useState(r||l);if(r&&r!==c){f(r)}else if(!c){// We will only fall through here when `useId` is not available
f(ef())}// Registration/cleanup
React.useEffect(()=>{n.getFetcher(c);return()=>{// Tell the router we've unmounted - if v7_fetcherPersist is enabled this
// will not delete immediately but instead queue up a delete after the
// fetcher returns to an `idle` state
n.deleteFetcher(c)}},[n,c]);// Fetcher additions
let d=React.useCallback((e,t)=>{!s?false?0:UNSAFE_invariant(false):void 0;n.fetch(c,s,e,t)},[c,s,n]);let h=ed();let p=React.useCallback((e,t)=>{h(e,u({},t,{navigate:false,fetcherKey:c}))},[c,h]);let v=React.useMemo(()=>{let e=/*#__PURE__*/React.forwardRef((e,t)=>{return /*#__PURE__*/React.createElement(ee,u({},e,{navigate:false,fetcherKey:c,ref:t}))});if(false){}return e},[c]);// Exposed FetcherWithComponents
let m=a.fetchers.get(c)||IDLE_FETCHER;let g=i.get(c);let b=React.useMemo(()=>u({Form:v,submit:p,load:d},m,{data:g}),[v,p,d,m,g]);return b}/**
 * Provides all fetchers currently on the page. Useful for layouts and parent
 * routes that need to provide pending/optimistic UI regarding the fetch.
 */function ev(){let e=eo(en.UseFetchers);return Array.from(e.fetchers.entries()).map(e=>{let[t,r]=e;return u({},r,{key:t})})}const em="react-router-scroll-positions";let eg=/* unused pure expression or super */null&&{};/**
 * When rendered inside a RouterProvider, will restore scroll positions on navigations
 */function eb(e){let{getKey:t,storageKey:r}=e===void 0?{}:e;let{router:n}=ei(er.UseScrollRestoration);let{restoreScrollPosition:a,preventScrollReset:i}=eo(en.UseScrollRestoration);let{basename:o}=React.useContext(UNSAFE_NavigationContext);let s=useLocation();let l=useMatches();let c=useNavigation();// Trigger manual scroll restoration while we're active
React.useEffect(()=>{window.history.scrollRestoration="manual";return()=>{window.history.scrollRestoration="auto"}},[]);// Save positions on pagehide
ew(React.useCallback(()=>{if(c.state==="idle"){let e=(t?t(s,l):null)||s.key;eg[e]=window.scrollY}try{sessionStorage.setItem(r||em,JSON.stringify(eg))}catch(e){false?0:void 0}window.history.scrollRestoration="auto"},[r,t,c.state,s,l]));// Read in any saved scroll locations
if(typeof document!=="undefined"){// eslint-disable-next-line react-hooks/rules-of-hooks
React.useLayoutEffect(()=>{try{let e=sessionStorage.getItem(r||em);if(e){eg=JSON.parse(e)}}catch(e){// no-op, use default empty object
}},[r]);// Enable scroll restoration in the router
// eslint-disable-next-line react-hooks/rules-of-hooks
React.useLayoutEffect(()=>{let e=t&&o!=="/"?(e,r)=>t(u({},e,{pathname:stripBasename(e.pathname,o)||e.pathname}),r):t;let r=n==null?void 0:n.enableScrollRestoration(eg,()=>window.scrollY,e);return()=>r&&r()},[n,o,t]);// Restore scrolling when state.restoreScrollPosition changes
// eslint-disable-next-line react-hooks/rules-of-hooks
React.useLayoutEffect(()=>{// Explicit false means don't do anything (used for submissions)
if(a===false){return}// been here before, scroll to it
if(typeof a==="number"){window.scrollTo(0,a);return}// try to scroll to the hash
if(s.hash){let e=document.getElementById(decodeURIComponent(s.hash.slice(1)));if(e){e.scrollIntoView();return}}// Don't reset if this navigation opted out
if(i===true){return}// otherwise go to the top on new locations
window.scrollTo(0,0)},[s,a,i])}}/**
 * Setup a callback to be fired on the window's `beforeunload` event. This is
 * useful for saving some data to `window.localStorage` just before the page
 * refreshes.
 *
 * Note: The `callback` argument should be a function created with
 * `React.useCallback()`.
 */function ey(e,t){let{capture:r}=t||{};React.useEffect(()=>{let t=r!=null?{capture:r}:undefined;window.addEventListener("beforeunload",e,t);return()=>{window.removeEventListener("beforeunload",e,t)}},[e,r])}/**
 * Setup a callback to be fired on the window's `pagehide` event. This is
 * useful for saving some data to `window.localStorage` just before the page
 * refreshes.  This event is better supported than beforeunload across browsers.
 *
 * Note: The `callback` argument should be a function created with
 * `React.useCallback()`.
 */function ew(e,t){let{capture:r}=t||{};React.useEffect(()=>{let t=r!=null?{capture:r}:undefined;window.addEventListener("pagehide",e,t);return()=>{window.removeEventListener("pagehide",e,t)}},[e,r])}/**
 * Wrapper around useBlocker to show a window.confirm prompt to users instead
 * of building a custom UI with useBlocker.
 *
 * Warning: This has *a lot of rough edges* and behaves very differently (and
 * very incorrectly in some cases) across browsers if user click addition
 * back/forward navigations while the confirm is open.  Use at your own risk.
 */function e_(e){let{when:t,message:r}=e;let n=useBlocker(t);React.useEffect(()=>{if(n.state==="blocked"){let e=window.confirm(r);if(e){// This timeout is needed to avoid a weird "race" on POP navigations
// between the `window.history` revert navigation and the result of
// `window.confirm`
setTimeout(n.proceed,0)}else{n.reset()}}},[n,r]);React.useEffect(()=>{if(n.state==="blocked"&&!t){n.reset()}},[n,t])}/**
 * Return a boolean indicating if there is an active view transition to the
 * given href.  You can use this value to render CSS classes or viewTransitionName
 * styles onto your elements
 *
 * @param href The destination href
 * @param [opts.relative] Relative routing type ("route" | "path")
 */function ex(e,t){if(t===void 0){t={}}let r=React.useContext(D);!(r!=null)?false?0:UNSAFE_invariant(false):void 0;let{basename:n}=ei(er.useViewTransitionState);let a=useResolvedPath(e,{relative:t.relative});if(!r.isTransitioning){return false}let i=stripBasename(r.currentLocation.pathname,n)||r.currentLocation.pathname;let o=stripBasename(r.nextLocation.pathname,n)||r.nextLocation.pathname;// Transition is active if we're going to or coming from the indicated
// destination.  This ensures that other PUSH navigations that reverse
// an indicated transition apply.  I.e., on the list view you have:
//
//   <NavLink to="/details/1" viewTransition>
//
// If you click the breadcrumb back to the list view:
//
//   <NavLink to="/list" viewTransition>
//
// We should apply the transition because it's indicated as active going
// from /list -> /details/1 and therefore should be active on the reverse
// (even though this isn't strictly a POP reverse)
return matchPath(a.pathname,o)!=null||matchPath(a.pathname,i)!=null}//#endregion
//# sourceMappingURL=index.js.map
// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/ErrorBoundary.tsx
var eE=r(74);// EXTERNAL MODULE: ./node_modules/@emotion/react/dist/emotion-react.esm.js
var eO=r(1699);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/utils.js
var eS=r(3160);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/query.js
var eA=r(1317);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/notifyManager.js
var eT=r(1629);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/subscribable.js
var ek=r(7484);// CONCATENATED MODULE: ./node_modules/@tanstack/query-core/build/modern/queryCache.js
// src/queryCache.ts
var eR=class extends ek/* .Subscribable */.Q{constructor(e={}){super();this.config=e;this.#B=/* @__PURE__ */new Map}#B;build(e,t,r){const n=t.queryKey;const a=t.queryHash??(0,eS/* .hashQueryKeyByOptions */.F$)(n,t);let i=this.get(a);if(!i){i=new eA/* .Query */.X({client:e,queryKey:n,queryHash:a,options:e.defaultQueryOptions(t),state:r,defaultOptions:e.getQueryDefaults(n)});this.add(i)}return i}add(e){if(!this.#B.has(e.queryHash)){this.#B.set(e.queryHash,e);this.notify({type:"added",query:e})}}remove(e){const t=this.#B.get(e.queryHash);if(t){e.destroy();if(t===e){this.#B.delete(e.queryHash)}this.notify({type:"removed",query:e})}}clear(){eT/* .notifyManager.batch */.jG.batch(()=>{this.getAll().forEach(e=>{this.remove(e)})})}get(e){return this.#B.get(e)}getAll(){return[...this.#B.values()]}find(e){const t={exact:true,...e};return this.getAll().find(e=>(0,eS/* .matchQuery */.MK)(t,e))}findAll(e={}){const t=this.getAll();return Object.keys(e).length>0?t.filter(t=>(0,eS/* .matchQuery */.MK)(e,t)):t}notify(e){eT/* .notifyManager.batch */.jG.batch(()=>{this.listeners.forEach(t=>{t(e)})})}onFocus(){eT/* .notifyManager.batch */.jG.batch(()=>{this.getAll().forEach(e=>{e.onFocus()})})}onOnline(){eT/* .notifyManager.batch */.jG.batch(()=>{this.getAll().forEach(e=>{e.onOnline()})})}};//# sourceMappingURL=queryCache.js.map
// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/mutation.js
var eC=r(3094);// CONCATENATED MODULE: ./node_modules/@tanstack/query-core/build/modern/mutationCache.js
// src/mutationCache.ts
var eP=class extends ek/* .Subscribable */.Q{constructor(e={}){super();this.config=e;this.#Y=/* @__PURE__ */new Set;this.#z=/* @__PURE__ */new Map;this.#q=0}#Y;#z;#q;build(e,t,r){const n=new eC/* .Mutation */.s({mutationCache:this,mutationId:++this.#q,options:e.defaultMutationOptions(t),state:r});this.add(n);return n}add(e){this.#Y.add(e);const t=eI(e);if(typeof t==="string"){const r=this.#z.get(t);if(r){r.push(e)}else{this.#z.set(t,[e])}}this.notify({type:"added",mutation:e})}remove(e){if(this.#Y.delete(e)){const t=eI(e);if(typeof t==="string"){const r=this.#z.get(t);if(r){if(r.length>1){const t=r.indexOf(e);if(t!==-1){r.splice(t,1)}}else if(r[0]===e){this.#z.delete(t)}}}}this.notify({type:"removed",mutation:e})}canRun(e){const t=eI(e);if(typeof t==="string"){const r=this.#z.get(t);const n=r?.find(e=>e.state.status==="pending");return!n||n===e}else{return true}}runNext(e){const t=eI(e);if(typeof t==="string"){const r=this.#z.get(t)?.find(t=>t!==e&&t.state.isPaused);return r?.continue()??Promise.resolve()}else{return Promise.resolve()}}clear(){eT/* .notifyManager.batch */.jG.batch(()=>{this.#Y.forEach(e=>{this.notify({type:"removed",mutation:e})});this.#Y.clear();this.#z.clear()})}getAll(){return Array.from(this.#Y)}find(e){const t={exact:true,...e};return this.getAll().find(e=>(0,eS/* .matchMutation */.nJ)(t,e))}findAll(e={}){return this.getAll().filter(t=>(0,eS/* .matchMutation */.nJ)(e,t))}notify(e){eT/* .notifyManager.batch */.jG.batch(()=>{this.listeners.forEach(t=>{t(e)})})}resumePausedMutations(){const e=this.getAll().filter(e=>e.state.isPaused);return eT/* .notifyManager.batch */.jG.batch(()=>Promise.all(e.map(e=>e.continue().catch(eS/* .noop */.lQ))))}};function eI(e){return e.options.scope?.id}//# sourceMappingURL=mutationCache.js.map
// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/focusManager.js
var eD=r(8978);// EXTERNAL MODULE: ./node_modules/@tanstack/query-core/build/modern/onlineManager.js
var eM=r(8747);// CONCATENATED MODULE: ./node_modules/@tanstack/query-core/build/modern/infiniteQueryBehavior.js
// src/infiniteQueryBehavior.ts
function eF(e){return{onFetch:(t,r)=>{const n=t.options;const a=t.fetchOptions?.meta?.fetchMore?.direction;const i=t.state.data?.pages||[];const o=t.state.data?.pageParams||[];let s={pages:[],pageParams:[]};let u=0;const l=async()=>{let r=false;const l=e=>{Object.defineProperty(e,"signal",{enumerable:true,get:()=>{if(t.signal.aborted){r=true}else{t.signal.addEventListener("abort",()=>{r=true})}return t.signal}})};const c=(0,eS/* .ensureQueryFn */.ZM)(t.options,t.fetchOptions);const f=async(e,n,a)=>{if(r){return Promise.reject()}if(n==null&&e.pages.length){return Promise.resolve(e)}const i=()=>{const e={client:t.client,queryKey:t.queryKey,pageParam:n,direction:a?"backward":"forward",meta:t.options.meta};l(e);return e};const o=i();const s=await c(o);const{maxPages:u}=t.options;const f=a?eS/* .addToStart */.ZZ:eS/* .addToEnd */.y9;return{pages:f(e.pages,s,u),pageParams:f(e.pageParams,n,u)}};if(a&&i.length){const e=a==="backward";const t=e?eN:eL;const r={pages:i,pageParams:o};const u=t(n,r);s=await f(r,u,e)}else{const t=e??i.length;do{const e=u===0?o[0]??n.initialPageParam:eL(n,s);if(u>0&&e==null){break}s=await f(s,e);u++}while(u<t)}return s};if(t.options.persister){t.fetchFn=()=>{return t.options.persister?.(l,{client:t.client,queryKey:t.queryKey,meta:t.options.meta,signal:t.signal},r)}}else{t.fetchFn=l}}}}function eL(e,{pages:t,pageParams:r}){const n=t.length-1;return t.length>0?e.getNextPageParam(t[n],t,r[n],r):void 0}function eN(e,{pages:t,pageParams:r}){return t.length>0?e.getPreviousPageParam?.(t[0],t,r[0],r):void 0}function ej(e,t){if(!t)return false;return eL(e,t)!=null}function eU(e,t){if(!t||!e.getPreviousPageParam)return false;return eN(e,t)!=null}//# sourceMappingURL=infiniteQueryBehavior.js.map
;// CONCATENATED MODULE: ./node_modules/@tanstack/query-core/build/modern/queryClient.js
// src/queryClient.ts
var eH=class{#V;#a;#d;#W;#$;#G;#K;#Q;constructor(e={}){this.#V=e.queryCache||new eR;this.#a=e.mutationCache||new eP;this.#d=e.defaultOptions||{};this.#W=/* @__PURE__ */new Map;this.#$=/* @__PURE__ */new Map;this.#G=0}mount(){this.#G++;if(this.#G!==1)return;this.#K=eD/* .focusManager.subscribe */.m.subscribe(async e=>{if(e){await this.resumePausedMutations();this.#V.onFocus()}});this.#Q=eM/* .onlineManager.subscribe */.t.subscribe(async e=>{if(e){await this.resumePausedMutations();this.#V.onOnline()}})}unmount(){this.#G--;if(this.#G!==0)return;this.#K?.();this.#K=void 0;this.#Q?.();this.#Q=void 0}isFetching(e){return this.#V.findAll({...e,fetchStatus:"fetching"}).length}isMutating(e){return this.#a.findAll({...e,status:"pending"}).length}/**
   * Imperative (non-reactive) way to retrieve data for a QueryKey.
   * Should only be used in callbacks or functions where reading the latest data is necessary, e.g. for optimistic updates.
   *
   * Hint: Do not use this function inside a component, because it won't receive updates.
   * Use `useQuery` to create a `QueryObserver` that subscribes to changes.
   */getQueryData(e){const t=this.defaultQueryOptions({queryKey:e});return this.#V.get(t.queryHash)?.state.data}ensureQueryData(e){const t=this.defaultQueryOptions(e);const r=this.#V.build(this,t);const n=r.state.data;if(n===void 0){return this.fetchQuery(e)}if(e.revalidateIfStale&&r.isStaleByTime((0,eS/* .resolveStaleTime */.d2)(t.staleTime,r))){void this.prefetchQuery(t)}return Promise.resolve(n)}getQueriesData(e){return this.#V.findAll(e).map(({queryKey:e,state:t})=>{const r=t.data;return[e,r]})}setQueryData(e,t,r){const n=this.defaultQueryOptions({queryKey:e});const a=this.#V.get(n.queryHash);const i=a?.state.data;const o=(0,eS/* .functionalUpdate */.Zw)(t,i);if(o===void 0){return void 0}return this.#V.build(this,n).setData(o,{...r,manual:true})}setQueriesData(e,t,r){return eT/* .notifyManager.batch */.jG.batch(()=>this.#V.findAll(e).map(({queryKey:e})=>[e,this.setQueryData(e,t,r)]))}getQueryState(e){const t=this.defaultQueryOptions({queryKey:e});return this.#V.get(t.queryHash)?.state}removeQueries(e){const t=this.#V;eT/* .notifyManager.batch */.jG.batch(()=>{t.findAll(e).forEach(e=>{t.remove(e)})})}resetQueries(e,t){const r=this.#V;return eT/* .notifyManager.batch */.jG.batch(()=>{r.findAll(e).forEach(e=>{e.reset()});return this.refetchQueries({type:"active",...e},t)})}cancelQueries(e,t={}){const r={revert:true,...t};const n=eT/* .notifyManager.batch */.jG.batch(()=>this.#V.findAll(e).map(e=>e.cancel(r)));return Promise.all(n).then(eS/* .noop */.lQ).catch(eS/* .noop */.lQ)}invalidateQueries(e,t={}){return eT/* .notifyManager.batch */.jG.batch(()=>{this.#V.findAll(e).forEach(e=>{e.invalidate()});if(e?.refetchType==="none"){return Promise.resolve()}return this.refetchQueries({...e,type:e?.refetchType??e?.type??"active"},t)})}refetchQueries(e,t={}){const r={...t,cancelRefetch:t.cancelRefetch??true};const n=eT/* .notifyManager.batch */.jG.batch(()=>this.#V.findAll(e).filter(e=>!e.isDisabled()&&!e.isStatic()).map(e=>{let t=e.fetch(void 0,r);if(!r.throwOnError){t=t.catch(eS/* .noop */.lQ)}return e.state.fetchStatus==="paused"?Promise.resolve():t}));return Promise.all(n).then(eS/* .noop */.lQ)}fetchQuery(e){const t=this.defaultQueryOptions(e);if(t.retry===void 0){t.retry=false}const r=this.#V.build(this,t);return r.isStaleByTime((0,eS/* .resolveStaleTime */.d2)(t.staleTime,r))?r.fetch(t):Promise.resolve(r.state.data)}prefetchQuery(e){return this.fetchQuery(e).then(eS/* .noop */.lQ).catch(eS/* .noop */.lQ)}fetchInfiniteQuery(e){e.behavior=eF(e.pages);return this.fetchQuery(e)}prefetchInfiniteQuery(e){return this.fetchInfiniteQuery(e).then(eS/* .noop */.lQ).catch(eS/* .noop */.lQ)}ensureInfiniteQueryData(e){e.behavior=eF(e.pages);return this.ensureQueryData(e)}resumePausedMutations(){if(eM/* .onlineManager.isOnline */.t.isOnline()){return this.#a.resumePausedMutations()}return Promise.resolve()}getQueryCache(){return this.#V}getMutationCache(){return this.#a}getDefaultOptions(){return this.#d}setDefaultOptions(e){this.#d=e}setQueryDefaults(e,t){this.#W.set((0,eS/* .hashKey */.EN)(e),{queryKey:e,defaultOptions:t})}getQueryDefaults(e){const t=[...this.#W.values()];const r={};t.forEach(t=>{if((0,eS/* .partialMatchKey */.Cp)(e,t.queryKey)){Object.assign(r,t.defaultOptions)}});return r}setMutationDefaults(e,t){this.#$.set((0,eS/* .hashKey */.EN)(e),{mutationKey:e,defaultOptions:t})}getMutationDefaults(e){const t=[...this.#$.values()];const r={};t.forEach(t=>{if((0,eS/* .partialMatchKey */.Cp)(e,t.mutationKey)){Object.assign(r,t.defaultOptions)}});return r}defaultQueryOptions(e){if(e._defaulted){return e}const t={...this.#d.queries,...this.getQueryDefaults(e.queryKey),...e,_defaulted:true};if(!t.queryHash){t.queryHash=(0,eS/* .hashQueryKeyByOptions */.F$)(t.queryKey,t)}if(t.refetchOnReconnect===void 0){t.refetchOnReconnect=t.networkMode!=="always"}if(t.throwOnError===void 0){t.throwOnError=!!t.suspense}if(!t.networkMode&&t.persister){t.networkMode="offlineFirst"}if(t.queryFn===eS/* .skipToken */.hT){t.enabled=false}return t}defaultMutationOptions(e){if(e?._defaulted){return e}return{...this.#d.mutations,...e?.mutationKey&&this.getMutationDefaults(e.mutationKey),...e,_defaulted:true}}clear(){this.#V.clear();this.#a.clear()}};//# sourceMappingURL=queryClient.js.map
// EXTERNAL MODULE: ./node_modules/@tanstack/react-query/build/legacy/QueryClientProvider.js
var eB=r(241);// EXTERNAL MODULE: ./addons/course-bundle/assets/react/bundle-builder/config/routes.tsx + 11 modules
var eY=r(9185);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/atoms/Toast.tsx
var ez=r(4857);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/config/constants.ts
var eq=r(5781);// CONCATENATED MODULE: ../tutor/node_modules/@emotion/sheet/dist/emotion-sheet.esm.js
var eV=false;/*

Based off glamor's StyleSheet, thanks Sunil ❤️

high performance StyleSheet for css-in-js systems

- uses multiple style tags behind the scenes for millions of rules
- uses `insertRule` for appending in production for *much* faster performance

// usage

import { StyleSheet } from '@emotion/sheet'

let styleSheet = new StyleSheet({ key: '', container: document.head })

styleSheet.insert('#box { border: 1px solid red; }')
- appends a css rule into the stylesheet

styleSheet.flush()
- empties the stylesheet of all its contents

*/function eW(e){if(e.sheet){return e.sheet}// this weirdness brought to you by firefox
/* istanbul ignore next */for(var t=0;t<document.styleSheets.length;t++){if(document.styleSheets[t].ownerNode===e){return document.styleSheets[t]}}// this function should always return with a value
// TS can't understand it though so we make it stop complaining here
return undefined}function e$(e){var t=document.createElement("style");t.setAttribute("data-emotion",e.key);if(e.nonce!==undefined){t.setAttribute("nonce",e.nonce)}t.appendChild(document.createTextNode(""));t.setAttribute("data-s","");return t}var eG=/*#__PURE__*/function(){// Using Node instead of HTMLElement since container may be a ShadowRoot
function e(e){var t=this;this._insertTag=function(e){var r;if(t.tags.length===0){if(t.insertionPoint){r=t.insertionPoint.nextSibling}else if(t.prepend){r=t.container.firstChild}else{r=t.before}}else{r=t.tags[t.tags.length-1].nextSibling}t.container.insertBefore(e,r);t.tags.push(e)};this.isSpeedy=e.speedy===undefined?!eV:e.speedy;this.tags=[];this.ctr=0;this.nonce=e.nonce;// key is the value of the data-emotion attribute, it's used to identify different sheets
this.key=e.key;this.container=e.container;this.prepend=e.prepend;this.insertionPoint=e.insertionPoint;this.before=null}var t=e.prototype;t.hydrate=function e(e){e.forEach(this._insertTag)};t.insert=function e(e){// the max length is how many rules we have per style tag, it's 65000 in speedy mode
// it's 1 in dev because we insert source maps that map a single rule to a location
// and you can only have one source map per style tag
if(this.ctr%(this.isSpeedy?65e3:1)===0){this._insertTag(e$(this))}var t=this.tags[this.tags.length-1];if(this.isSpeedy){var r=eW(t);try{// this is the ultrafast version, works across browsers
// the big drawback is that the css won't be editable in devtools
r.insertRule(e,r.cssRules.length)}catch(e){}}else{t.appendChild(document.createTextNode(e))}this.ctr++};t.flush=function e(){this.tags.forEach(function(e){var t;return(t=e.parentNode)==null?void 0:t.removeChild(e)});this.tags=[];this.ctr=0};return e}();// CONCATENATED MODULE: ../tutor/node_modules/@emotion/cache/node_modules/stylis/src/Utility.js
/**
 * @param {number}
 * @return {number}
 */var eK=Math.abs;/**
 * @param {number}
 * @return {string}
 */var eQ=String.fromCharCode;/**
 * @param {object}
 * @return {object}
 */var eX=Object.assign;/**
 * @param {string} value
 * @param {number} length
 * @return {number}
 */function eJ(e,t){return e4(e,0)^45?(((t<<2^e4(e,0))<<2^e4(e,1))<<2^e4(e,2))<<2^e4(e,3):0}/**
 * @param {string} value
 * @return {string}
 */function eZ(e){return e.trim()}/**
 * @param {string} value
 * @param {RegExp} pattern
 * @return {string?}
 */function e0(e,t){return(e=t.exec(e))?e[0]:e}/**
 * @param {string} value
 * @param {(string|RegExp)} pattern
 * @param {string} replacement
 * @return {string}
 */function e1(e,t,r){return e.replace(t,r)}/**
 * @param {string} value
 * @param {string} search
 * @return {number}
 */function e2(e,t){return e.indexOf(t)}/**
 * @param {string} value
 * @param {number} index
 * @return {number}
 */function e4(e,t){return e.charCodeAt(t)|0}/**
 * @param {string} value
 * @param {number} begin
 * @param {number} end
 * @return {string}
 */function e6(e,t,r){return e.slice(t,r)}/**
 * @param {string} value
 * @return {number}
 */function e5(e){return e.length}/**
 * @param {any[]} value
 * @return {number}
 */function e3(e){return e.length}/**
 * @param {any} value
 * @param {any[]} array
 * @return {any}
 */function e7(e,t){return t.push(e),e}/**
 * @param {string[]} array
 * @param {function} callback
 * @return {string}
 */function e8(e,t){return e.map(t).join("")};// CONCATENATED MODULE: ../tutor/node_modules/@emotion/cache/node_modules/stylis/src/Tokenizer.js
var e9=1;var te=1;var tt=0;var tr=0;var tn=0;var ta="";/**
 * @param {string} value
 * @param {object | null} root
 * @param {object | null} parent
 * @param {string} type
 * @param {string[] | string} props
 * @param {object[] | string} children
 * @param {number} length
 */function ti(e,t,r,n,a,i,o){return{value:e,root:t,parent:r,type:n,props:a,children:i,line:e9,column:te,length:o,return:""}}/**
 * @param {object} root
 * @param {object} props
 * @return {object}
 */function to(e,t){return eX(ti("",null,null,"",null,null,0),e,{length:-e.length},t)}/**
 * @return {number}
 */function ts(){return tn}/**
 * @return {number}
 */function tu(){tn=tr>0?e4(ta,--tr):0;if(te--,tn===10)te=1,e9--;return tn}/**
 * @return {number}
 */function tl(){tn=tr<tt?e4(ta,tr++):0;if(te++,tn===10)te=1,e9++;return tn}/**
 * @return {number}
 */function tc(){return e4(ta,tr)}/**
 * @return {number}
 */function tf(){return tr}/**
 * @param {number} begin
 * @param {number} end
 * @return {string}
 */function td(e,t){return e6(ta,e,t)}/**
 * @param {number} type
 * @return {number}
 */function th(e){switch(e){// \0 \t \n \r \s whitespace token
case 0:case 9:case 10:case 13:case 32:return 5;// ! + , / > @ ~ isolate token
case 33:case 43:case 44:case 47:case 62:case 64:case 126:// ; { } breakpoint token
case 59:case 123:case 125:return 4;// : accompanied token
case 58:return 3;// " ' ( [ opening delimit token
case 34:case 39:case 40:case 91:return 2;// ) ] closing delimit token
case 41:case 93:return 1}return 0}/**
 * @param {string} value
 * @return {any[]}
 */function tp(e){return e9=te=1,tt=e5(ta=e),tr=0,[]}/**
 * @param {any} value
 * @return {any}
 */function tv(e){return ta="",e}/**
 * @param {number} type
 * @return {string}
 */function tm(e){return eZ(td(tr-1,t_(e===91?e+2:e===40?e+1:e)))}/**
 * @param {string} value
 * @return {string[]}
 */function tg(e){return tv(ty(tp(e)))}/**
 * @param {number} type
 * @return {string}
 */function tb(e){while(tn=tc())if(tn<33)tl();else break;return th(e)>2||th(tn)>3?"":" "}/**
 * @param {string[]} children
 * @return {string[]}
 */function ty(e){while(tl())switch(th(tn)){case 0:append(tE(tr-1),e);break;case 2:append(tm(tn),e);break;default:append(from(tn),e)}return e}/**
 * @param {number} index
 * @param {number} count
 * @return {string}
 */function tw(e,t){while(--t&&tl())// not 0-9 A-F a-f
if(tn<48||tn>102||tn>57&&tn<65||tn>70&&tn<97)break;return td(e,tf()+(t<6&&tc()==32&&tl()==32))}/**
 * @param {number} type
 * @return {number}
 */function t_(e){while(tl())switch(tn){// ] ) " '
case e:return tr;// " '
case 34:case 39:if(e!==34&&e!==39)t_(tn);break;// (
case 40:if(e===41)t_(e);break;// \
case 92:tl();break}return tr}/**
 * @param {number} type
 * @param {number} index
 * @return {number}
 */function tx(e,t){while(tl())// //
if(e+tn===47+10)break;else if(e+tn===42+42&&tc()===47)break;return"/*"+td(t,tr-1)+"*"+eQ(e===47?e:tl())}/**
 * @param {number} index
 * @return {string}
 */function tE(e){while(!th(tc()))tl();return td(e,tr)};// CONCATENATED MODULE: ../tutor/node_modules/@emotion/cache/node_modules/stylis/src/Enum.js
var tO="-ms-";var tS="-moz-";var tA="-webkit-";var tT="comm";var tk="rule";var tR="decl";var tC="@page";var tP="@media";var tI="@import";var tD="@charset";var tM="@viewport";var tF="@supports";var tL="@document";var tN="@namespace";var tj="@keyframes";var tU="@font-face";var tH="@counter-style";var tB="@font-feature-values";var tY="@layer";// CONCATENATED MODULE: ../tutor/node_modules/@emotion/cache/node_modules/stylis/src/Serializer.js
/**
 * @param {object[]} children
 * @param {function} callback
 * @return {string}
 */function tz(e,t){var r="";var n=e3(e);for(var a=0;a<n;a++)r+=t(e[a],a,e,t)||"";return r}/**
 * @param {object} element
 * @param {number} index
 * @param {object[]} children
 * @param {function} callback
 * @return {string}
 */function tq(e,t,r,n){switch(e.type){case tY:if(e.children.length)break;case tI:case tR:return e.return=e.return||e.value;case tT:return"";case tj:return e.return=e.value+"{"+tz(e.children,n)+"}";case tk:e.value=e.props.join(",")}return e5(r=tz(e.children,n))?e.return=e.value+"{"+r+"}":""};// CONCATENATED MODULE: ../tutor/node_modules/@emotion/cache/node_modules/stylis/src/Middleware.js
/**
 * @param {function[]} collection
 * @return {function}
 */function tV(e){var t=e3(e);return function(r,n,a,i){var o="";for(var s=0;s<t;s++)o+=e[s](r,n,a,i)||"";return o}}/**
 * @param {function} callback
 * @return {function}
 */function tW(e){return function(t){if(!t.root){if(t=t.return)e(t)}}}/**
 * @param {object} element
 * @param {number} index
 * @param {object[]} children
 * @param {function} callback
 */function t$(e,t,r,n){if(e.length>-1){if(!e.return)switch(e.type){case DECLARATION:e.return=prefix(e.value,e.length,r);return;case KEYFRAMES:return serialize([copy(e,{value:replace(e.value,"@","@"+WEBKIT)})],n);case RULESET:if(e.length)return combine(e.props,function(t){switch(match(t,/(::plac\w+|:read-\w+)/)){// :read-(only|write)
case":read-only":case":read-write":return serialize([copy(e,{props:[replace(t,/:(read-\w+)/,":"+MOZ+"$1")]})],n);// :placeholder
case"::placeholder":return serialize([copy(e,{props:[replace(t,/:(plac\w+)/,":"+WEBKIT+"input-$1")]}),copy(e,{props:[replace(t,/:(plac\w+)/,":"+MOZ+"$1")]}),copy(e,{props:[replace(t,/:(plac\w+)/,MS+"input-$1")]})],n)}return""})}}}/**
 * @param {object} element
 * @param {number} index
 * @param {object[]} children
 */function tG(e){switch(e.type){case RULESET:e.props=e.props.map(function(t){return combine(tokenize(t),function(t,r,n){switch(charat(t,0)){// \f
case 12:return substr(t,1,strlen(t));// \0 ( + > ~
case 0:case 40:case 43:case 62:case 126:return t;// :
case 58:if(n[++r]==="global")n[r]="",n[++r]="\f"+substr(n[r],r=1,-1);// \s
case 32:return r===1?"":t;default:switch(r){case 0:e=t;return sizeof(n)>1?"":t;case r=sizeof(n)-1:case 2:return r===2?t+e+e:t+e;default:return t}}})})}};// CONCATENATED MODULE: ../tutor/node_modules/@emotion/cache/node_modules/stylis/src/Parser.js
/**
 * @param {string} value
 * @return {object[]}
 */function tK(e){return tv(tQ("",null,null,null,[""],e=tp(e),0,[0],e))}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {string[]} rule
 * @param {string[]} rules
 * @param {string[]} rulesets
 * @param {number[]} pseudo
 * @param {number[]} points
 * @param {string[]} declarations
 * @return {object}
 */function tQ(e,t,r,n,a,i,o,s,u){var l=0;var c=0;var f=o;var d=0;var h=0;var p=0;var v=1;var m=1;var g=1;var b=0;var y="";var w=a;var _=i;var x=n;var E=y;while(m)switch(p=b,b=tl()){// (
case 40:if(p!=108&&e4(E,f-1)==58){if(e2(E+=e1(tm(b),"&","&\f"),"&\f")!=-1)g=-1;break}// " ' [
case 34:case 39:case 91:E+=tm(b);break;// \t \n \r \s
case 9:case 10:case 13:case 32:E+=tb(p);break;// \
case 92:E+=tw(tf()-1,7);continue;// /
case 47:switch(tc()){case 42:case 47:e7(tJ(tx(tl(),tf()),t,r),u);break;default:E+="/"}break;// {
case 123*v:s[l++]=e5(E)*g;// } ; \0
case 125*v:case 59:case 0:switch(b){// \0 }
case 0:case 125:m=0;// ;
case 59+c:if(g==-1)E=e1(E,/\f/g,"");if(h>0&&e5(E)-f)e7(h>32?tZ(E+";",n,r,f-1):tZ(e1(E," ","")+";",n,r,f-2),u);break;// @ ;
case 59:E+=";";// { rule/at-rule
default:e7(x=tX(E,t,r,l,c,a,s,y,w=[],_=[],f),i);if(b===123)if(c===0)tQ(E,t,x,x,w,i,f,s,_);else switch(d===99&&e4(E,3)===110?100:d){// d l m s
case 100:case 108:case 109:case 115:tQ(e,x,x,n&&e7(tX(e,x,x,0,0,a,s,y,a,w=[],f),_),a,_,f,s,n?w:_);break;default:tQ(E,x,x,x,[""],_,0,s,_)}}l=c=h=0,v=g=1,y=E="",f=o;break;// :
case 58:f=1+e5(E),h=p;default:if(v<1){if(b==123)--v;else if(b==125&&v++==0&&tu()==125)continue}switch(E+=eQ(b),b*v){// &
case 38:g=c>0?1:(E+="\f",-1);break;// ,
case 44:s[l++]=(e5(E)-1)*g,g=1;break;// @
case 64:// -
if(tc()===45)E+=tm(tl());d=tc(),c=f=e5(y=E+=tE(tf())),b++;break;// -
case 45:if(p===45&&e5(E)==2)v=0}}return i}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {number} index
 * @param {number} offset
 * @param {string[]} rules
 * @param {number[]} points
 * @param {string} type
 * @param {string[]} props
 * @param {string[]} children
 * @param {number} length
 * @return {object}
 */function tX(e,t,r,n,a,i,o,s,u,l,c){var f=a-1;var d=a===0?i:[""];var h=e3(d);for(var p=0,v=0,m=0;p<n;++p)for(var g=0,b=e6(e,f+1,f=eK(v=o[p])),y=e;g<h;++g)if(y=eZ(v>0?d[g]+" "+b:e1(b,/&\f/g,d[g])))u[m++]=y;return ti(e,t,r,a===0?tk:s,u,l,c)}/**
 * @param {number} value
 * @param {object} root
 * @param {object?} parent
 * @return {object}
 */function tJ(e,t,r){return ti(e,t,r,tT,eQ(ts()),e6(e,2,-2),0)}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {number} length
 * @return {object}
 */function tZ(e,t,r,n){return ti(e,t,r,tR,e6(e,0,n),e6(e,n+1,-1),n)};// CONCATENATED MODULE: ../tutor/node_modules/@emotion/cache/dist/emotion-cache.browser.esm.js
var t0=function e(e,t,r){var n=0;var a=0;while(true){n=a;a=tc();// &\f
if(n===38&&a===12){t[r]=1}if(th(a)){break}tl()}return td(e,tr)};var t1=function e(e,t){// pretend we've started with a comma
var r=-1;var n=44;do{switch(th(n)){case 0:// &\f
if(n===38&&tc()===12){// this is not 100% correct, we don't account for literal sequences here - like for example quoted strings
// stylis inserts \f after & to know when & where it should replace this sequence with the context selector
// and when it should just concatenate the outer and inner selectors
// it's very unlikely for this sequence to actually appear in a different context, so we just leverage this fact here
t[r]=1}e[r]+=t0(tr-1,t,r);break;case 2:e[r]+=tm(n);break;case 4:// comma
if(n===44){// colon
e[++r]=tc()===58?"&\f":"";t[r]=e[r].length;break}// fallthrough
default:e[r]+=eQ(n)}}while(n=tl())return e};var t2=function e(e,t){return tv(t1(tp(e),t))};// WeakSet would be more appropriate, but only WeakMap is supported in IE11
var t4=/* #__PURE__ */new WeakMap;var t6=function e(e){if(e.type!=="rule"||!e.parent||// positive .length indicates that this rule contains pseudo
// negative .length indicates that this rule has been already prefixed
e.length<1){return}var t=e.value;var r=e.parent;var n=e.column===r.column&&e.line===r.line;while(r.type!=="rule"){r=r.parent;if(!r)return}// short-circuit for the simplest case
if(e.props.length===1&&t.charCodeAt(0)!==58&&!t4.get(r)){return}// if this is an implicitly inserted rule (the one eagerly inserted at the each new nested level)
// then the props has already been manipulated beforehand as they that array is shared between it and its "rule parent"
if(n){return}t4.set(e,true);var a=[];var i=t2(t,a);var o=r.props;for(var s=0,u=0;s<i.length;s++){for(var l=0;l<o.length;l++,u++){e.props[u]=a[s]?i[s].replace(/&\f/g,o[l]):o[l]+" "+i[s]}}};var t5=function e(e){if(e.type==="decl"){var t=e.value;if(t.charCodeAt(0)===108&&// charcode for b
t.charCodeAt(2)===98){// this ignores label
e["return"]="";e.value=""}}};/* eslint-disable no-fallthrough */function t3(e,t){switch(eJ(e,t)){// color-adjust
case 5103:return tA+"print-"+e+e;// animation, animation-(delay|direction|duration|fill-mode|iteration-count|name|play-state|timing-function)
case 5737:case 4201:case 3177:case 3433:case 1641:case 4457:case 2921:case 5572:case 6356:case 5844:case 3191:case 6645:case 3005:case 6391:case 5879:case 5623:case 6135:case 4599:case 4855:case 4215:case 6389:case 5109:case 5365:case 5621:case 3829:return tA+e+e;// appearance, user-select, transform, hyphens, text-size-adjust
case 5349:case 4246:case 4810:case 6968:case 2756:return tA+e+tS+e+tO+e+e;// flex, flex-direction
case 6828:case 4268:return tA+e+tO+e+e;// order
case 6165:return tA+e+tO+"flex-"+e+e;// align-items
case 5187:return tA+e+e1(e,/(\w+).+(:[^]+)/,tA+"box-$1$2"+tO+"flex-$1$2")+e;// align-self
case 5443:return tA+e+tO+"flex-item-"+e1(e,/flex-|-self/,"")+e;// align-content
case 4675:return tA+e+tO+"flex-line-pack"+e1(e,/align-content|flex-|-self/,"")+e;// flex-shrink
case 5548:return tA+e+tO+e1(e,"shrink","negative")+e;// flex-basis
case 5292:return tA+e+tO+e1(e,"basis","preferred-size")+e;// flex-grow
case 6060:return tA+"box-"+e1(e,"-grow","")+tA+e+tO+e1(e,"grow","positive")+e;// transition
case 4554:return tA+e1(e,/([^-])(transform)/g,"$1"+tA+"$2")+e;// cursor
case 6187:return e1(e1(e1(e,/(zoom-|grab)/,tA+"$1"),/(image-set)/,tA+"$1"),e,"")+e;// background, background-image
case 5495:case 3959:return e1(e,/(image-set\([^]*)/,tA+"$1"+"$`$1");// justify-content
case 4968:return e1(e1(e,/(.+:)(flex-)?(.*)/,tA+"box-pack:$3"+tO+"flex-pack:$3"),/s.+-b[^;]+/,"justify")+tA+e+e;// (margin|padding)-inline-(start|end)
case 4095:case 3583:case 4068:case 2532:return e1(e,/(.+)-inline(.+)/,tA+"$1$2")+e;// (min|max)?(width|height|inline-size|block-size)
case 8116:case 7059:case 5753:case 5535:case 5445:case 5701:case 4933:case 4677:case 5533:case 5789:case 5021:case 4765:// stretch, max-content, min-content, fill-available
if(e5(e)-1-t>6)switch(e4(e,t+1)){// (m)ax-content, (m)in-content
case 109:// -
if(e4(e,t+4)!==45)break;// (f)ill-available, (f)it-content
case 102:return e1(e,/(.+:)(.+)-([^]+)/,"$1"+tA+"$2-$3"+"$1"+tS+(e4(e,t+3)==108?"$3":"$2-$3"))+e;// (s)tretch
case 115:return~e2(e,"stretch")?t3(e1(e,"stretch","fill-available"),t)+e:e}break;// position: sticky
case 4949:// (s)ticky?
if(e4(e,t+1)!==115)break;// display: (flex|inline-flex)
case 6444:switch(e4(e,e5(e)-3-(~e2(e,"!important")&&10))){// stic(k)y
case 107:return e1(e,":",":"+tA)+e;// (inline-)?fl(e)x
case 101:return e1(e,/(.+:)([^;!]+)(;|!.+)?/,"$1"+tA+(e4(e,14)===45?"inline-":"")+"box$3"+"$1"+tA+"$2$3"+"$1"+tO+"$2box$3")+e}break;// writing-mode
case 5936:switch(e4(e,t+11)){// vertical-l(r)
case 114:return tA+e+tO+e1(e,/[svh]\w+-[tblr]{2}/,"tb")+e;// vertical-r(l)
case 108:return tA+e+tO+e1(e,/[svh]\w+-[tblr]{2}/,"tb-rl")+e;// horizontal(-)tb
case 45:return tA+e+tO+e1(e,/[svh]\w+-[tblr]{2}/,"lr")+e}return tA+e+tO+e+e}return e}var t7=function e(e,t,r,n){if(e.length>-1){if(!e["return"])switch(e.type){case tR:e["return"]=t3(e.value,e.length);break;case tj:return tz([to(e,{value:e1(e.value,"@","@"+tA)})],n);case tk:if(e.length)return e8(e.props,function(t){switch(e0(t,/(::plac\w+|:read-\w+)/)){// :read-(only|write)
case":read-only":case":read-write":return tz([to(e,{props:[e1(t,/:(read-\w+)/,":"+tS+"$1")]})],n);// :placeholder
case"::placeholder":return tz([to(e,{props:[e1(t,/:(plac\w+)/,":"+tA+"input-$1")]}),to(e,{props:[e1(t,/:(plac\w+)/,":"+tS+"$1")]}),to(e,{props:[e1(t,/:(plac\w+)/,tO+"input-$1")]})],n)}return""})}}};var t8=[t7];var t9=function e(e){var t=e.key;if(t==="css"){var r=document.querySelectorAll("style[data-emotion]:not([data-s])");// get SSRed styles out of the way of React's hydration
// document.head is a safe place to move them to(though note document.head is not necessarily the last place they will be)
// note this very very intentionally targets all style elements regardless of the key to ensure
// that creating a cache works inside of render of a React component
Array.prototype.forEach.call(r,function(e){// we want to only move elements which have a space in the data-emotion attribute value
// because that indicates that it is an Emotion 11 server-side rendered style elements
// while we will already ignore Emotion 11 client-side inserted styles because of the :not([data-s]) part in the selector
// Emotion 10 client-side inserted styles did not have data-s (but importantly did not have a space in their data-emotion attributes)
// so checking for the space ensures that loading Emotion 11 after Emotion 10 has inserted some styles
// will not result in the Emotion 10 styles being destroyed
var t=e.getAttribute("data-emotion");if(t.indexOf(" ")===-1){return}document.head.appendChild(e);e.setAttribute("data-s","")})}var n=e.stylisPlugins||t8;var a={};var i;var o=[];{i=e.container||document.head;Array.prototype.forEach.call(// means that the style elements we're looking at are only Emotion 11 server-rendered style elements
document.querySelectorAll('style[data-emotion^="'+t+' "]'),function(e){var t=e.getAttribute("data-emotion").split(" ");for(var r=1;r<t.length;r++){a[t[r]]=true}o.push(e)})}var s;var u=[t6,t5];{var l;var c=[tq,tW(function(e){l.insert(e)})];var f=tV(u.concat(n,c));var d=function e(e){return tz(tK(e),f)};s=function e(e,t,r,n){l=r;d(e?e+"{"+t.styles+"}":t.styles);if(n){h.inserted[t.name]=true}}}var h={key:t,sheet:new eG({key:t,container:i,nonce:e.nonce,speedy:e.speedy,prepend:e.prepend,insertionPoint:e.insertionPoint}),nonce:e.nonce,inserted:a,registered:{},insert:s};h.sheet.hydrate(o);return h};// EXTERNAL MODULE: ./node_modules/@emotion/react/dist/emotion-element-d59e098f.esm.js
var re=r(8663);// EXTERNAL MODULE: ../tutor/node_modules/cssjanus/src/cssjanus.js
var rt=r(4131);var rr=/*#__PURE__*/r.n(rt);// CONCATENATED MODULE: ../tutor/node_modules/stylis/src/Enum.js
var rn="-ms-";var ra="-moz-";var ri="-webkit-";var ro="comm";var rs="rule";var ru="decl";var rl="@page";var rc="@media";var rf="@import";var rd="@charset";var rh="@viewport";var rp="@supports";var rv="@document";var rm="@namespace";var rg="@keyframes";var rb="@font-face";var ry="@counter-style";var rw="@font-feature-values";var r_="@layer";var rx="@scope";// CONCATENATED MODULE: ../tutor/node_modules/stylis/src/Serializer.js
/**
 * @param {object[]} children
 * @param {function} callback
 * @return {string}
 */function rE(e,t){var r="";for(var n=0;n<e.length;n++)r+=t(e[n],n,e,t)||"";return r}/**
 * @param {object} element
 * @param {number} index
 * @param {object[]} children
 * @param {function} callback
 * @return {string}
 */function rO(e,t,r,n){switch(e.type){case LAYER:if(e.children.length)break;case IMPORT:case NAMESPACE:case DECLARATION:return e.return=e.return||e.value;case COMMENT:return"";case KEYFRAMES:return e.return=e.value+"{"+rE(e.children,n)+"}";case RULESET:if(!strlen(e.value=e.props.join(",")))return""}return strlen(r=rE(e.children,n))?e.return=e.value+"{"+r+"}":""};// CONCATENATED MODULE: ../tutor/node_modules/stylis/src/Utility.js
/**
 * @param {number}
 * @return {number}
 */var rS=Math.abs;/**
 * @param {number}
 * @return {string}
 */var rA=String.fromCharCode;/**
 * @param {object}
 * @return {object}
 */var rT=Object.assign;/**
 * @param {string} value
 * @param {number} length
 * @return {number}
 */function rk(e,t){return rD(e,0)^45?(((t<<2^rD(e,0))<<2^rD(e,1))<<2^rD(e,2))<<2^rD(e,3):0}/**
 * @param {string} value
 * @return {string}
 */function rR(e){return e.trim()}/**
 * @param {string} value
 * @param {RegExp} pattern
 * @return {string?}
 */function rC(e,t){return(e=t.exec(e))?e[0]:e}/**
 * @param {string} value
 * @param {(string|RegExp)} pattern
 * @param {string} replacement
 * @return {string}
 */function rP(e,t,r){return e.replace(t,r)}/**
 * @param {string} value
 * @param {string} search
 * @param {number} position
 * @return {number}
 */function rI(e,t,r){return e.indexOf(t,r)}/**
 * @param {string} value
 * @param {number} index
 * @return {number}
 */function rD(e,t){return e.charCodeAt(t)|0}/**
 * @param {string} value
 * @param {number} begin
 * @param {number} end
 * @return {string}
 */function rM(e,t,r){return e.slice(t,r)}/**
 * @param {string} value
 * @return {number}
 */function rF(e){return e.length}/**
 * @param {any[]} value
 * @return {number}
 */function rL(e){return e.length}/**
 * @param {any} value
 * @param {any[]} array
 * @return {any}
 */function rN(e,t){return t.push(e),e}/**
 * @param {string[]} array
 * @param {function} callback
 * @return {string}
 */function rj(e,t){return e.map(t).join("")}/**
 * @param {string[]} array
 * @param {RegExp} pattern
 * @return {string[]}
 */function rU(e,t){return e.filter(function(e){return!rC(e,t)})};// CONCATENATED MODULE: ../tutor/node_modules/stylis/src/Tokenizer.js
var rH=1;var rB=1;var rY=0;var rz=0;var rq=0;var rV="";/**
 * @param {string} value
 * @param {object | null} root
 * @param {object | null} parent
 * @param {string} type
 * @param {string[] | string} props
 * @param {object[] | string} children
 * @param {object[]} siblings
 * @param {number} length
 */function rW(e,t,r,n,a,i,o,s){return{value:e,root:t,parent:r,type:n,props:a,children:i,line:rH,column:rB,length:o,return:"",siblings:s}}/**
 * @param {object} root
 * @param {object} props
 * @return {object}
 */function r$(e,t){return assign(rW("",null,null,"",null,null,0,e.siblings),e,{length:-e.length},t)}/**
 * @param {object} root
 */function rG(e){while(e.root)e=r$(e.root,{children:[e]});append(e,e.siblings)}/**
 * @return {number}
 */function rK(){return rq}/**
 * @return {number}
 */function rQ(){rq=rz>0?rD(rV,--rz):0;if(rB--,rq===10)rB=1,rH--;return rq}/**
 * @return {number}
 */function rX(){rq=rz<rY?rD(rV,rz++):0;if(rB++,rq===10)rB=1,rH++;return rq}/**
 * @return {number}
 */function rJ(){return rD(rV,rz)}/**
 * @return {number}
 */function rZ(){return rz}/**
 * @param {number} begin
 * @param {number} end
 * @return {string}
 */function r0(e,t){return rM(rV,e,t)}/**
 * @param {number} type
 * @return {number}
 */function r1(e){switch(e){// \0 \t \n \r \s whitespace token
case 0:case 9:case 10:case 13:case 32:return 5;// ! + , / > @ ~ isolate token
case 33:case 43:case 44:case 47:case 62:case 64:case 126:// ; { } breakpoint token
case 59:case 123:case 125:return 4;// : accompanied token
case 58:return 3;// " ' ( [ opening delimit token
case 34:case 39:case 40:case 91:return 2;// ) ] closing delimit token
case 41:case 93:return 1}return 0}/**
 * @param {string} value
 * @return {any[]}
 */function r2(e){return rH=rB=1,rY=rF(rV=e),rz=0,[]}/**
 * @param {any} value
 * @return {any}
 */function r4(e){return rV="",e}/**
 * @param {number} type
 * @return {string}
 */function r6(e){return rR(r0(rz-1,r9(e===91?e+2:e===40?e+1:e)))}/**
 * @param {string} value
 * @return {string[]}
 */function r5(e){return r4(r7(r2(e)))}/**
 * @param {number} type
 * @return {string}
 */function r3(e){while(rq=rJ())if(rq<33)rX();else break;return r1(e)>2||r1(rq)>3?"":" "}/**
 * @param {string[]} children
 * @return {string[]}
 */function r7(e){while(rX())switch(r1(rq)){case 0:append(nt(rz-1),e);break;case 2:append(r6(rq),e);break;default:append(from(rq),e)}return e}/**
 * @param {number} index
 * @param {number} count
 * @return {string}
 */function r8(e,t){while(--t&&rX())// not 0-9 A-F a-f
if(rq<48||rq>102||rq>57&&rq<65||rq>70&&rq<97)break;return r0(e,rZ()+(t<6&&rJ()==32&&rX()==32))}/**
 * @param {number} type
 * @return {number}
 */function r9(e){while(rX())switch(rq){// ] ) " '
case e:return rz;// " '
case 34:case 39:if(e!==34&&e!==39)r9(rq);break;// (
case 40:if(e===41)r9(e);break;// \
case 92:rX();break}return rz}/**
 * @param {number} type
 * @param {number} index
 * @return {number}
 */function ne(e,t){while(rX())// //
if(e+rq===47+10)break;else if(e+rq===42+42&&rJ()===47)break;return"/*"+r0(t,rz-1)+"*"+rA(e===47?e:rX())}/**
 * @param {number} index
 * @return {string}
 */function nt(e){while(!r1(rJ()))rX();return r0(e,rz)};// CONCATENATED MODULE: ../tutor/node_modules/stylis/src/Parser.js
/**
 * @param {string} value
 * @return {object[]}
 */function nr(e){return r4(nn("",null,null,null,[""],e=r2(e),0,[0],e))}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {string[]} rule
 * @param {string[]} rules
 * @param {string[]} rulesets
 * @param {number[]} pseudo
 * @param {number[]} points
 * @param {string[]} declarations
 * @return {object}
 */function nn(e,t,r,n,a,i,o,s,u){var l=0;var c=0;var f=o;var d=0;var h=0;var p=0;var v=1;var m=1;var g=1;var b=0;var y="";var w=a;var _=i;var x=n;var E=y;while(m)switch(p=b,b=rX()){// (
case 40:if(p!=108&&rD(E,f-1)==58){if(rI(E+=rP(r6(b),"&","&\f"),"&\f",rS(l?s[l-1]:0))!=-1)g=-1;break}// " ' [
case 34:case 39:case 91:E+=r6(b);break;// \t \n \r \s
case 9:case 10:case 13:case 32:E+=r3(p);break;// \
case 92:E+=r8(rZ()-1,7);continue;// /
case 47:switch(rJ()){case 42:case 47:rN(ni(ne(rX(),rZ()),t,r,u),u);if((r1(p||1)==5||r1(rJ()||1)==5)&&rF(E)&&rM(E,-1,void 0)!==" ")E+=" ";break;default:E+="/"}break;// {
case 123*v:s[l++]=rF(E)*g;// } ; \0
case 125*v:case 59:case 0:switch(b){// \0 }
case 0:case 125:m=0;// ;
case 59+c:if(g==-1)E=rP(E,/\f/g,"");if(h>0&&(rF(E)-f||v===0&&p===47))rN(h>32?no(E+";",n,r,f-1,u):no(rP(E," ","")+";",n,r,f-2,u),u);break;// @ ;
case 59:E+=";";// { rule/at-rule
default:rN(x=na(E,t,r,l,c,a,s,y,w=[],_=[],f,i),i);if(b===123)if(c===0)nn(E,t,x,x,w,i,f,s,_);else{switch(d){// c(ontainer)
case 99:if(rD(E,3)===110)break;// l(ayer)
case 108:if(rD(E,2)===97)break;default:c=0;// d(ocument) m(edia) s(upports)
case 100:case 109:case 115:}if(c)nn(e,x,x,n&&rN(na(e,x,x,0,0,a,s,y,a,w=[],f,_),_),a,_,f,s,n?w:_);else nn(E,x,x,x,[""],_,0,s,_)}}l=c=h=0,v=g=1,y=E="",f=o;break;// :
case 58:f=1+rF(E),h=p;default:if(v<1){if(b==123)--v;else if(b==125&&v++==0&&rQ()==125)continue}switch(E+=rA(b),b*v){// &
case 38:g=c>0?1:(E+="\f",-1);break;// ,
case 44:s[l++]=(rF(E)-1)*g,g=1;break;// @
case 64:// -
if(rJ()===45)E+=r6(rX());d=rJ(),c=f=rF(y=E+=nt(rZ())),b++;break;// -
case 45:if(p===45&&rF(E)==2)v=0}}return i}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {number} index
 * @param {number} offset
 * @param {string[]} rules
 * @param {number[]} points
 * @param {string} type
 * @param {string[]} props
 * @param {string[]} children
 * @param {number} length
 * @param {object[]} siblings
 * @return {object}
 */function na(e,t,r,n,a,i,o,s,u,l,c,f){var d=a-1;var h=a===0?i:[""];var p=rL(h);for(var v=0,m=0,g=0;v<n;++v)for(var b=0,y=rM(e,d+1,d=rS(m=o[v])),w=e;b<p;++b)if(w=rR(m>0?h[b]+" "+y:rP(y,/&\f/g,h[b])))u[g++]=w;return rW(e,t,r,a===0?rs:s,u,l,c,f)}/**
 * @param {number} value
 * @param {object} root
 * @param {object?} parent
 * @param {object[]} siblings
 * @return {object}
 */function ni(e,t,r,n){return rW(e,t,r,ro,rA(rK()),rM(e,2,-2),0,n)}/**
 * @param {string} value
 * @param {object} root
 * @param {object?} parent
 * @param {number} length
 * @param {object[]} siblings
 * @return {object}
 */function no(e,t,r,n,a){return rW(e,t,r,ru,rM(e,0,n),rM(e,n+1,-1),n,a)};// CONCATENATED MODULE: ../tutor/node_modules/stylis-plugin-rtl/dist/stylis-rtl.js
function ns(e,t,r){switch(e.type){case rf:case ru:case ro:return e.return=e.return||e.value;case rs:{e.value=Array.isArray(e.props)?e.props.join(","):e.props;if(Array.isArray(e.children)){e.children.forEach(function(e){if(e.type===ro)e.children=e.value})}}}var n=rE(Array.prototype.concat(e.children),ns);return rF(n)?e.return=e.value+"{"+n+"}":""}function nu(e,t,r,n){if(e.type===rg||e.type===rp||e.type===rs&&(!e.parent||e.parent.type===rc||e.parent.type===rs)){var a=rr().transform(ns(e,t,r));e.children=a?nr(a)[0].children:[];e.return=""}}// stable identifier that will not be dropped by minification unless the whole module
// is unused
Object.defineProperty(nu,"name",{value:"stylisRTLPlugin"});/* ESM default export */const nl=nu;//# sourceMappingURL=stylis-rtl.js.map
;// CONCATENATED MODULE: ../tutor/assets/react/v3/shared/components/RTLProvider.tsx
var nc=t9({stylisPlugins:[nl],key:"rtl"});var nf=t=>{var{children:r}=t;if(eq/* .isRTL */.V8){return/*#__PURE__*/(0,e/* .jsx */.Y)(re.C,{value:nc,children:r})}return/*#__PURE__*/(0,e/* .jsx */.Y)(e/* .Fragment */.FK,{children:r})};/* ESM default export */const nd=nf;// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/components/modals/Modal.tsx
var nh=r(7316);// EXTERNAL MODULE: ../tutor/assets/react/v3/shared/utils/style-utils.ts
var np=r(6014);// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder/components/App.tsx
var nv=()=>{var[r]=(0,t.useState)(()=>new eH({defaultOptions:{queries:{retry:false,refetchOnWindowFocus:false,networkMode:"always"},mutations:{retry:false,networkMode:"always"}}}));var n=(0,o/* .useRoutes */.Ye)(eY/* ["default"] */.A);return/*#__PURE__*/(0,e/* .jsx */.Y)(nd,{children:/*#__PURE__*/(0,e/* .jsx */.Y)(eB/* .QueryClientProvider */.Ht,{client:r,children:/*#__PURE__*/(0,e/* .jsx */.Y)(ez/* ["default"] */.A,{position:"bottom-center",children:/*#__PURE__*/(0,e/* .jsxs */.FD)(nh/* .ModalProvider */.Z,{children:[/*#__PURE__*/(0,e/* .jsx */.Y)(eO/* .Global */.mL,{styles:[(0,np/* .createGlobalCss */.v)()]}),n]})})})})};/* ESM default export */const nm=nv;// CONCATENATED MODULE: ./addons/course-bundle/assets/react/bundle-builder.tsx
var ng=a.createRoot(document.getElementById("tutor-course-bundle-builder-root"));ng.render(/*#__PURE__*/(0,e/* .jsx */.Y)(n().StrictMode,{children:/*#__PURE__*/(0,e/* .jsx */.Y)(G,{children:/*#__PURE__*/(0,e/* .jsx */.Y)(eE/* ["default"] */.A,{children:/*#__PURE__*/(0,e/* .jsx */.Y)(nm,{})})})}))})()})();