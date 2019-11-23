/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/posts.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/posts.js":
/*!**********************!*\
  !*** ./src/posts.js ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("window.onload = function(){ //避免爆代码\n\n    /* 展现内容(避免爆代码) */\n    $('.grid-centered').css({'max-width':'660px','padding': '0px 20px','margin-top': '80px'});\n    $('.article-list').css('opacity','1');\n    $('#header-div').css('opacity', '1');\n    $('#header_info').css('opacity', '1');\n    $('.cat-real').attr('style','display:inline-block');\n    /* 展现内容(避免爆代码) */\n    \n    new Vue({ //axios获取顶部信息\n        el : '#grid-cell',\n        data() {\n            return {\n                site_url : window.site_url,\n                flag: false,\n                posts: null,\n                loading: true, //v-if判断显示占位符\n                loading_des: false,\n                last_year: 0,\n                posts_array: [],\n            }\n        },\n        mounted () {\n            //获取文章列表\n            axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page='+ window.post_count) //默认以发布时间排序\n             .then(response => {\n                 this.posts = response.data;\n             })\n             .then(() => {\n                 var k = -1;\n                 var i = 0;\n                 for(i=0;i<(this.posts).length;i++){ //遍历所有文章\n                     if( ((this.posts[i].date.split('T'))[0].split('-'))[0] !== this.last_year ){ //当前文章发布年与上一篇不同\n                         this.posts_array[k += 1] = []; //初始化数组\n                         this.posts_array[k]['posts'] = []; //初始化 posts 数组\n                         this.posts_array[k]['year'] = parseInt(((this.posts[i].date.split('T'))[0].split('-'))[0]); //增加年份\n                         this.posts_array[k]['posts'][(this.posts_array[k]['posts']).length] = this.posts[i]; //增加文章\n                         this.last_year = ((this.posts[i].date.split('T'))[0].split('-'))[0]; //赋值当前文章发布年份\n                     }else{ //发布年份与上一篇相同\n                        this.posts_array[k]['posts'][(this.posts_array[k]['posts']).length] = this.posts[i]; //增加文章\n                     }\n                 }\n                 this.loading = false;\n            })\n        }\n    });\n    \n    \n}\n\n//# sourceURL=webpack:///./src/posts.js?");

/***/ })

/******/ });