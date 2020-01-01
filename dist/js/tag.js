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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/tag.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/tag.js":
/*!********************!*\
  !*** ./src/tag.js ***!
  \********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("window.onload = function() { //避免爆代码\n\n    var click = 0; //初始化加载次数\n    var paged = 1; //获取当前页数\n    var incate = window.cate_id;\n    var tag_name = window.tag_name;\n    var post_count = window.post_count;\n\n    /* 展现内容(避免爆代码) */\n    $('.article-list').css('opacity', '1');\n    $('.top1').html(tag_name);\n    $('.top2').html('标签文章数 : '+ post_count);\n    $('.cat-real').attr('style', 'display:inline-block');\n    /* 展现内容(避免爆代码) */\n\n    new Vue({ //axios获取顶部信息\n        el: '#grid-cell',\n        data() {\n            return {\n                site_url: window.site_url,\n\n                exclude_option: window.cate_exclude_option,\n                cate_exclude: window.cate_exclude,\n                exclude_params: '',\n\n                pages: window.index_p,\n                cate_fre: window.cate_fre,\n                cate_wor: window.cate_fre,\n\n\n                posts: null,\n                posts_id_sticky: '',\n                cates: null,\n                des: null,\n                loading: true, //v-if判断显示占位符\n                loading_des: true,\n                errored: true,\n                loading_css: 'loading-line'\n            }\n        },\n        mounted() {\n\n            //分类排除参数获取\n            if(this.cate_exclude == 'true'){\n                this.exclude_params = '?exclude=' + this.exclude_option;\n            }\n\n            //获取分类\n            axios.get(this.site_url + '/wp-json/wp/v2/categories' + this.exclude_params)\n                .then(response => {\n                    this.des = response.data;\n                }).then(() => {\n                    this.loading_des = false;\n                });\n\n            /*\n            * 获取文章列表\n            * 得到顶置文章后拼接其余文章\n            */\n\n            //获取顶置文章\n            axios.get(this.site_url + '/wp-json/wp/v2/posts?sticky=1&tags=' + incate)\n                .then(res_sticky => {\n                    this.posts = res_sticky.data;\n\n                    //获取顶置文章 IDs 以在获取其余文章时排除\n                    for(var s = 0;s< this.posts.length; ++s){\n                        this.posts_id_sticky += (',' + this.posts[s].id); \n                    }\n                    this.posts_id_sticky = this.posts_id_sticky.substr(1);\n\n                    axios.get(this.site_url + '/wp-json/wp/v2/posts?sticky=0&tags=' + incate + '&exclude='+ this.posts_id_sticky + '&per_page=' + this.pages + '&page=' + paged)\n                    .then(res_normal => {\n                        //拼接其余文章\n                        this.posts = this.posts.concat(res_normal.data);\n                    })\n                })\n                .catch(e => {\n                    this.errored = false\n                })\n                .then(() => {\n                    this.loading = false;\n                    paged++; //加载完1页后累加页数\n                    //加载完文章列表后监听滑动事件\n                    $(window).scroll(function() {\n                        var scrollTop = $(window).scrollTop();\n                        var scrollHeight = $('.bottom').offset().top - 500;\n                        if (scrollTop >= scrollHeight) {\n                            if (click == 0) { //接近底部加载一次新文章\n                                $('#scoll_new_list').click();\n                                click++; //加载次数计次\n                            }\n                        }\n                    });\n\n                })\n        },\n        methods: { //定义方法\n            new_page: function() { //加载下一页文章列表\n                axios.get(this.site_url + '/wp-json/wp/v2/posts?sticky=0&exclude='+ this.posts_id_sticky + 'per_page='+ this.pages +'&page=' + paged + '&tags=' + incate)\n                    .then(response => {\n                        if (!!response.data.length && response.data.length !== 0) { //判断是否最后一页\n                            $('#view-text').html('-&nbsp;文章列表&nbsp;-');\n                            this.posts.push.apply(this.posts, response.data); //拼接在上一页之后\n                            click = 0;\n                            paged++;\n                        } else {\n                            this.loading_css = '';\n                            $('#view-text').html('-&nbsp;全部文章&nbsp;-');\n                            $('.bottom h5').html('暂无更多文章了 O__O \"…').css({\n                                'background': '#fff',\n                                'color': '#999'\n                            });\n                        }\n                    }).catch(e => {\n                        this.loading_css = '';\n                        $('#view-text').html('-&nbsp;所有文章&nbsp;-');\n                        $('.bottom h5').html('暂无更多文章了 O__O \"…').css({\n                            'background': '#fff',\n                            'color': '#999'\n                        });\n                    })\n            }\n        },\n        filters: {\n            link_page: function(cate_id) {\n                if (cate_id == this.cate_fre) {\n                    return '添加于 ';\n                } else if (cate_id == this.cate_wor) {\n                    return '创造于 ';\n                } else {\n                    return '';\n                }\n            },\n            link_style: function(cate_id) {\n                if (cate_id == this.cate_fre || cate_id == this.cate_wor){\n                    return 'display: flex';\n                } else {\n                    return '';\n                }\n            }\n        }\n    });\n\n\n}\n\n//# sourceURL=webpack:///./src/tag.js?");

/***/ })

/******/ });