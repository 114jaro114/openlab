/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

eval("// require('./bootstrap');\n//\n// var ms2 = 0;\n// const mqtt2 = require('mqtt')\n// const client2 = mqtt2.connect('ws://openlab.kpi.fei.tuke.sk/mqtt')\n// client2.on('connect', () => {\n//     client2.subscribe('openlab/sensorkits/B8:27:EB:2F:7B:7D/json', {\n//         qos: 0\n//     });\n// })\n// client2.on('message', function(topic2, message2) {\n//     // console.log('this message :', message2.toString());\n//     ms2 = message2.toString();\n// });\n//\n// //insert data to db every 10sec (without this 1sec)\n// let timerId2 = setInterval(() => {\n//     if (ms2 != 0) {\n//         $.ajax({\n//             type: \"POST\",\n//             url: 'api/saveDataAllSensors',\n//             data: {\n//                 data: ms2\n//             },\n//             success: function(response) {\n//                 console.log(response);\n//             },\n//             error: function(XMLHttpRequest, textStatus, errorThrown) {\n//                 console.log(\"error\");\n//             }\n//         });\n//     } else {\n//         console.log(\"no connection to openlab kpi fei\");\n//     }\n// }, 10000);\n//\n//\n//\n// var ms = 0;\n// const mqtt = require('mqtt')\n// const client = mqtt.connect('ws://openlab.kpi.fei.tuke.sk/mqtt')\n// client.on('connect', () => {\n//     client.subscribe('MeriTo/KPI/B4-E6-2D-B0-13-91/Data', {\n//         qos: 0\n//     });\n// })\n// client.on('message', function(topic, message) {\n//     ms = message.toString();\n// });\n//\n// // insert data to db every 10sec (without this 1sec)\n// let timerId = setInterval(() => {\n//     if (ms != 0) {\n//         $.ajax({\n//             type: \"POST\",\n//             url: 'api/saveDataPowerConsumption',\n//             data: {\n//                 data: ms\n//             },\n//             success: function(response) {\n//                 console.log(response);\n//             },\n//             error: function(XMLHttpRequest, textStatus, errorThrown) {\n//                 console.log(\"error\");\n//             }\n//         });\n//     } else {\n//         console.log(\"no connection to openlab kpi fei\");\n//     }\n// }, 10000);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvYXBwLmpzPzZkNDAiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VzQ29udGVudCI6WyIvLyByZXF1aXJlKCcuL2Jvb3RzdHJhcCcpO1xuLy9cbi8vIHZhciBtczIgPSAwO1xuLy8gY29uc3QgbXF0dDIgPSByZXF1aXJlKCdtcXR0Jylcbi8vIGNvbnN0IGNsaWVudDIgPSBtcXR0Mi5jb25uZWN0KCd3czovL29wZW5sYWIua3BpLmZlaS50dWtlLnNrL21xdHQnKVxuLy8gY2xpZW50Mi5vbignY29ubmVjdCcsICgpID0+IHtcbi8vICAgICBjbGllbnQyLnN1YnNjcmliZSgnb3BlbmxhYi9zZW5zb3JraXRzL0I4OjI3OkVCOjJGOjdCOjdEL2pzb24nLCB7XG4vLyAgICAgICAgIHFvczogMFxuLy8gICAgIH0pO1xuLy8gfSlcbi8vIGNsaWVudDIub24oJ21lc3NhZ2UnLCBmdW5jdGlvbih0b3BpYzIsIG1lc3NhZ2UyKSB7XG4vLyAgICAgLy8gY29uc29sZS5sb2coJ3RoaXMgbWVzc2FnZSA6JywgbWVzc2FnZTIudG9TdHJpbmcoKSk7XG4vLyAgICAgbXMyID0gbWVzc2FnZTIudG9TdHJpbmcoKTtcbi8vIH0pO1xuLy9cbi8vIC8vaW5zZXJ0IGRhdGEgdG8gZGIgZXZlcnkgMTBzZWMgKHdpdGhvdXQgdGhpcyAxc2VjKVxuLy8gbGV0IHRpbWVySWQyID0gc2V0SW50ZXJ2YWwoKCkgPT4ge1xuLy8gICAgIGlmIChtczIgIT0gMCkge1xuLy8gICAgICAgICAkLmFqYXgoe1xuLy8gICAgICAgICAgICAgdHlwZTogXCJQT1NUXCIsXG4vLyAgICAgICAgICAgICB1cmw6ICdhcGkvc2F2ZURhdGFBbGxTZW5zb3JzJyxcbi8vICAgICAgICAgICAgIGRhdGE6IHtcbi8vICAgICAgICAgICAgICAgICBkYXRhOiBtczJcbi8vICAgICAgICAgICAgIH0sXG4vLyAgICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbihyZXNwb25zZSkge1xuLy8gICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKHJlc3BvbnNlKTtcbi8vICAgICAgICAgICAgIH0sXG4vLyAgICAgICAgICAgICBlcnJvcjogZnVuY3Rpb24oWE1MSHR0cFJlcXVlc3QsIHRleHRTdGF0dXMsIGVycm9yVGhyb3duKSB7XG4vLyAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coXCJlcnJvclwiKTtcbi8vICAgICAgICAgICAgIH1cbi8vICAgICAgICAgfSk7XG4vLyAgICAgfSBlbHNlIHtcbi8vICAgICAgICAgY29uc29sZS5sb2coXCJubyBjb25uZWN0aW9uIHRvIG9wZW5sYWIga3BpIGZlaVwiKTtcbi8vICAgICB9XG4vLyB9LCAxMDAwMCk7XG4vL1xuLy9cbi8vXG4vLyB2YXIgbXMgPSAwO1xuLy8gY29uc3QgbXF0dCA9IHJlcXVpcmUoJ21xdHQnKVxuLy8gY29uc3QgY2xpZW50ID0gbXF0dC5jb25uZWN0KCd3czovL29wZW5sYWIua3BpLmZlaS50dWtlLnNrL21xdHQnKVxuLy8gY2xpZW50Lm9uKCdjb25uZWN0JywgKCkgPT4ge1xuLy8gICAgIGNsaWVudC5zdWJzY3JpYmUoJ01lcmlUby9LUEkvQjQtRTYtMkQtQjAtMTMtOTEvRGF0YScsIHtcbi8vICAgICAgICAgcW9zOiAwXG4vLyAgICAgfSk7XG4vLyB9KVxuLy8gY2xpZW50Lm9uKCdtZXNzYWdlJywgZnVuY3Rpb24odG9waWMsIG1lc3NhZ2UpIHtcbi8vICAgICBtcyA9IG1lc3NhZ2UudG9TdHJpbmcoKTtcbi8vIH0pO1xuLy9cbi8vIC8vIGluc2VydCBkYXRhIHRvIGRiIGV2ZXJ5IDEwc2VjICh3aXRob3V0IHRoaXMgMXNlYylcbi8vIGxldCB0aW1lcklkID0gc2V0SW50ZXJ2YWwoKCkgPT4ge1xuLy8gICAgIGlmIChtcyAhPSAwKSB7XG4vLyAgICAgICAgICQuYWpheCh7XG4vLyAgICAgICAgICAgICB0eXBlOiBcIlBPU1RcIixcbi8vICAgICAgICAgICAgIHVybDogJ2FwaS9zYXZlRGF0YVBvd2VyQ29uc3VtcHRpb24nLFxuLy8gICAgICAgICAgICAgZGF0YToge1xuLy8gICAgICAgICAgICAgICAgIGRhdGE6IG1zXG4vLyAgICAgICAgICAgICB9LFxuLy8gICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24ocmVzcG9uc2UpIHtcbi8vICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhyZXNwb25zZSk7XG4vLyAgICAgICAgICAgICB9LFxuLy8gICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKFhNTEh0dHBSZXF1ZXN0LCB0ZXh0U3RhdHVzLCBlcnJvclRocm93bikge1xuLy8gICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKFwiZXJyb3JcIik7XG4vLyAgICAgICAgICAgICB9XG4vLyAgICAgICAgIH0pO1xuLy8gICAgIH0gZWxzZSB7XG4vLyAgICAgICAgIGNvbnNvbGUubG9nKFwibm8gY29ubmVjdGlvbiB0byBvcGVubGFiIGtwaSBmZWlcIik7XG4vLyAgICAgfVxuLy8gfSwgMTAwMDApOyJdLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvYXBwLmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/app.js\n");

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvc2Fzcy9hcHAuc2Nzcz80NzVmIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7QUFBQSIsImZpbGUiOiIuL3Jlc291cmNlcy9zYXNzL2FwcC5zY3NzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/sass/app.scss\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			__webpack_require__.O();
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;