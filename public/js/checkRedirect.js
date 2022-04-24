/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/checkRedirect.ts ***!
  \***************************************/


var redirectKey = localStorage.getItem('redirect_to');

if (redirectKey != null) {
  localStorage.removeItem('redirect_to');
  window.location.href = redirectKey;
}
/******/ })()
;