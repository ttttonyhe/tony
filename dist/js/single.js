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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/single.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/single.js":
/*!***********************!*\
  !*** ./src/single.js ***!
  \***********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("$(document).ready(function() { //避免爆代码\n\n\n    var post_info = new Vue({ //axios获取顶部信息\n        el: 'main',\n        data() {\n            return {\n                site_url: window.site_url,\n                post_id: window.post_id,\n                m: window.index_m,\n                pwd: window.pwd,\n                color: window.color,\n                display_author: window.display_author,\n                author_div: '',\n\n                posts: null,\n                loading: true, //v-if判断显示占位符\n                errored: true,\n                cate: '分类目录',\n                cate_url: '',\n                post_tags: [],\n                post_prenext: [],\n                exist_index: true,\n                reading_p: 0\n            }\n        },\n        mounted() {\n\n            //获取文章\n            axios.get(this.site_url + '/wp-json/wp/v2/posts/' + this.post_id)\n                .then(response => {\n                    this.posts = response.data;\n                })\n                .catch(e => {\n                    this.errored = false\n                })\n                .then(() => {\n                    this.loading = false;\n                    this.cate = this.posts.post_categories[0].name;\n                    this.cate_url = this.posts.post_categories[0].link;\n                    this.post_tags = this.posts.post_tags;\n                    this.post_prenext = this.posts.post_prenext;\n\n                    $('.real').css('display', 'block');\n\n                    if (!!this.pwd) {\n                        $('.article-content').attr('style', '');\n                    } else if (!!this.m) {\n                        var md = window.markdownit({\n                            html: true,\n                            xhtmlOut: false,\n                            breaks: true,\n                            linkify: true\n                        });\n                        var reg1 = new RegExp('<p>', 'g');\n                        var reg2 = new RegExp('</p>', 'g');\n                        var reg3 = new RegExp('<br />', 'g');\n                        this.posts.content.rendered = this.posts.content.rendered.replace(reg1, '').replace(reg2, '').replace(reg3, '');\n                        var md_result = md.render(this.posts.content.rendered);\n                        $('.article-content').html(md_result).attr('style', '');\n                    } else {\n                        $('.article-content').html(this.posts.content.rendered).attr('style', '');\n                    }\n\n                    $('.single-h2').html(this.posts.post_metas.title.replace('密码保护：', '')).attr('style',\n                        '');\n\n                    //展示文章作者名称\n                    if(this.display_author){\n                        this.author_div = '<span class=\"article-list-date\">' + this.posts.post_metas.author +\n                        '</span><span class=\"article-list-divider\">&nbsp;&nbsp;/&nbsp;&nbsp;</span>';\n                    }\n\n                    $('.article-list-footer').html(this.author_div + '<span class=\"article-list-date\">' + this.posts\n                        .post_date +\n                        '</span><span class=\"article-list-divider\">&nbsp;&nbsp;/&nbsp;&nbsp;</span><span class=\"article-list-minutes\">' +\n                        this.posts.post_metas.views + '&nbsp;Views</span>').attr('style', '');\n\n                    if (!!this.color) {\n                        //文章阅读进度条\n                        var content_offtop = $('.article-content').offset().top;\n                        var content_height = $('.article-content').innerHeight();\n                        $(window).scroll(function() {\n                            if (($(this).scrollTop() > content_offtop)) { //滑动到内容部分\n                                if (($(this).scrollTop() - content_offtop) <= content_height) { //在内容部分内滑动\n                                    this.reading_p = Math.round(($(this).scrollTop() - content_offtop) / content_height * 100);\n                                } else { //滑出内容部分\n                                    this.reading_p = 100;\n                                }\n                            } else { //未滑到内容部分\n                                this.reading_p = 0;\n                            }\n                            $('.reading-bar').css('width', this.reading_p + '%');\n                        });\n                    }\n\n\n                    /* 文章目录 */\n\n                    var h = 0;\n                    var pf = 23;\n                    var i = 0;\n                    $('#article-index').html('');\n                    var count_ti = count_in = count_ar = count_sc = count_hr = count_e = 1;\n                    var offset = new Array;\n                    var min = 0;\n                    var c = 0;\n                    var icon = '';\n\n                    //获取最高级别h标签\n                    $(\".article-content>:header\").each(function() {\n                        h = $(this).eq(0).prop(\"tagName\").replace('H', '');\n                        if (c == 0) {\n                            min = h;\n                            c++;\n                        } else {\n                            if (h <= min) {\n                                min = h;\n                            }\n                        }\n                    });\n\n                    //获取h标签内容\n                    $(\".article-content>:header\").each(function() {\n                        h = $(this).eq(0).prop(\"tagName\").replace('H', ''); //标签级别\n                        for (i = 0; i < Math.abs(h - min); ++i) { //偏移程度\n                            pf += 10;\n                        }\n                        if (pf !== 23) { //图标\n                            icon = 'czs-square-l';\n                        } else {\n                            icon = 'czs-circle-l';\n                        }\n\n                        $('#article-index').html($('#article-index').html() + '<li id=\"ti' + (\n                                count_ti++) +\n                            '\" style=\"padding-left:' + pf + 'px\"><a><i class=\"' + icon +\n                            '\"></i>  ' + $(this).eq(\n                                0).text().replace(/[ ]/g, \"\") + '</a></li>'); //创建目录\n                        $(this).eq(0).attr('id', 'in' + (count_in++)); //添加id\n                        offset[0] = 0;\n                        offset[count_ar++] = $(this).eq(0).offset().top; //位置存入数组\n                        count_e++;\n                        pf = 23; //设置初始偏移值\n                        i = 0; //设置循环开始\n                    })\n\n                    //跳转对应位置事件\n                    $('#article-index li').click(function() {\n                        $('html,body').animate({\n                            scrollTop: ($('#in' + $(this).eq(0).attr('id').replace('ti',\n                                '')).offset().top - 100)\n                        }, 500);\n                    });\n\n                    if (count_e !== 1) { //若存在标签\n\n                        $(window).scroll(function() { //滑动窗口时\n                            var scroH = $(this).scrollTop() + 130;\n                            var navH = offset[count_sc]; //从1开始获取当前位置\n                            var navH_prev = offset[count_sc - 1]; //获取上一个位置(以备回滑)\n                            if (scroH >= navH) { //滑过当前位置\n                                $('#ti' + (count_sc - 1)).attr('class', '');\n                                $('#ti' + count_sc).attr('class', 'active');\n                                count_sc++; //调至下一个位置\n                            }\n                            if (scroH <= navH_prev) { //滑回上一个h3位置,调至上一个位置\n                                $('#ti' + (count_sc - 2)).attr('class', 'active');\n                                count_sc--;\n                                $('#ti' + count_sc).attr('class', '');\n                            }\n                        });\n\n                    } else {\n                        $('.index-div').css('display', 'none');\n                        this.exist_index = false;\n                    }\n                    /* 文章目录 */\n\n                    //代码高亮\n                    document.querySelectorAll('pre code').forEach((block) => {\n                        hljs.highlightBlock(block);\n                    });\n                })\n        }\n    });\n\n\n});\n\n//# sourceURL=webpack:///./src/single.js?");

/***/ })

/******/ });