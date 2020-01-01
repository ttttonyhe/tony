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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/*\n *   Author - TonyHe\n *   Theme Tony - v4.37\n *   https://www.ouorz.com/ | Released under GPL-3.0 license\n */\n\n$(document).ready(function () { //避免爆代码\n\n    //获取评论参数\n    var site = window.site_url;\n    var wp_rest = window.wp_rest;\n\n    var now = 20;\n    var click = 0; //初始化加载次数\n    var paged = 1; //获取当前页数\n    var pre_post_id = null;\n    var pre_post_con = '';\n\n    /* 展现内容(避免爆代码) */\n    $('.article-list').css('opacity', '1');\n    $('.cat-real').attr('style', 'display:inline-block');\n    /* 展现内容(避免爆代码) */\n\n    var antd = new Vue({ //axios获取顶部信息\n        el: '#grid-cell',\n        data() {\n            return {\n                m: window.index_m,\n                site_url: window.site_url,\n\n                exclude_option: window.cate_exclude_option,\n                cate_exclude: window.cate_exclude,\n                exclude_params: '',\n\n                cates_exclude: window.cates_exclude,\n                cate_exclude_params: '',\n                cate_exclude_option: window.cates_exclude_option,\n\n                pages: window.index_p,\n\n                preview_comment_open: window.preview_comment_open,\n\n                posts: null,\n                posts_id_sticky: '',\n                cates: null,\n                tages: null,\n                loading: true, //v-if判断显示占位符\n                loading_cates: true,\n                loading_tages: true,\n                errored: true,\n                loading_css: 'loading-line',\n                comments_html: '<div id=\"new_comments\" style=\"margin-top:40px\"></div>'\n            }\n        },\n        mounted() {\n\n            //分类排除参数获取\n            if (this.cate_exclude == 'true') {\n                this.exclude_params = '?exclude=' + this.exclude_option;\n            }\n\n            if (this.cates_exclude == 'true') {\n                this.cate_exclude_params = '&categories_exclude=' + this.cate_exclude_option;\n            }\n\n            //获取分类\n            axios.get(this.site_url + '/wp-json/wp/v2/categories' + this.exclude_params)\n                .then(response => {\n                    this.cates = response.data;\n                })\n                .then(() => {\n                    this.loading_cates = false;\n\n                    //获取标签\n                    axios.get(this.site_url + '/wp-json/wp/v2/tags?order=desc&per_page=15')\n                        .then(response => {\n                            this.tages = response.data;\n                        }).then(() => {\n                            this.loading_tages = false;\n                        });\n\n                });\n\n                \n            /*\n            * 获取文章列表\n            * 得到顶置文章后拼接其余文章\n            */\n\n            //获取顶置文章\n            axios.get(this.site_url + '/wp-json/wp/v2/posts?sticky=1&'+ this.cate_exclude_params)\n                .then(res_sticky => {\n                    this.posts = res_sticky.data;\n\n                    //获取顶置文章 IDs 以在获取其余文章时排除\n                    for(var s = 0;s< this.posts.length; ++s){\n                        this.posts_id_sticky += (',' + this.posts[s].id); \n                    }\n                    this.posts_id_sticky = this.posts_id_sticky.substr(1);\n\n                    axios.get(this.site_url + '/wp-json/wp/v2/posts?sticky=0&exclude='+ this.posts_id_sticky +'&per_page=' + this.pages + '&page=' + paged + this.cate_exclude_params)\n                    .then(res_normal => {\n                        //拼接其余文章\n                        this.posts = this.posts.concat(res_normal.data);\n                    })\n                })\n                .catch(e => {\n                    this.errored = false;\n                    alert('文章加载失败，可能是伪静态未配置正确，请参考: https://www.wpdaxue.com/wordpress-rewriterule.html 来配置。加入 QQ 群：454846972 以获得更多支持。');\n                })\n                .then(() => {\n                    this.loading = false;\n                    paged++; //加载完1页后累加页数\n                    //加载完文章列表后监听滑动事件\n                    $(window).scroll(function () {\n                        var scrollTop = $(window).scrollTop();\n                        var scrollHeight = $('.bottom').offset().top - 800;\n                        if (scrollTop >= scrollHeight) {\n                            if (click == 0) { //接近底部加载一次新文章\n                                $('#scoll_new_list').click();\n                                click++; //加载次数计次\n                            }\n                        }\n                    });\n\n                    //检查是否存在下一页\n                    axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page=' + this.pages + '&page=' + paged + this.cate_exclude_params)\n                    .then(response => {\n                        if (!response.data.length || response.data.length == 0) { //判断是否最后一页\n                            this.loading_css = '';\n                            $('#view-text').html('-&nbsp;全部文章&nbsp;-');\n                            $('.bottom h5').html('暂无更多文章了 O__O \"…').css({\n                                'background': '#fff',\n                                'color': '#999'\n                            });\n                        }\n                    }).catch(e => {\n                        this.loading_css = '';\n                        $('#view-text').html('-&nbsp;所有文章&nbsp;-');\n                        $('.bottom h5').html('暂无更多文章了 O__O \"…').css({\n                            'background': '#fff',\n                            'color': '#999'\n                        });\n                    })\n\n                })\n\n        },\n        methods: { //定义方法\n            new_page: function () { //加载下一页文章列表\n                $('#view-text').html('-&nbsp;加载中&nbsp;-');\n                axios.get(this.site_url + '/wp-json/wp/v2/posts?sticky=0&exclude='+ this.posts_id_sticky + '&per_page=' + this.pages + '&page=' + paged + this.cate_exclude_params)\n                    .then(response => {\n                        if (!!response.data.length && response.data.length !== 0) { //判断是否最后一页\n                            $('#view-text').html('-&nbsp;文章列表&nbsp;-');\n                            this.posts.push.apply(this.posts, response.data); //拼接在上一页之后\n                            click = 0;\n                            paged++;\n                        } else {\n                            this.loading_css = '';\n                            $('#view-text').html('-&nbsp;全部文章&nbsp;-');\n                            $('.bottom h5').html('暂无更多文章了 O__O \"…').css({\n                                'background': '#fff',\n                                'color': '#999'\n                            });\n                        }\n                    }).catch(e => {\n                        this.loading_css = '';\n                        $('#view-text').html('-&nbsp;所有文章&nbsp;-');\n                        $('.bottom h5').html('暂无更多文章了 O__O \"…').css({\n                            'background': '#fff',\n                            'color': '#999'\n                        });\n                    })\n            },\n            preview: function (postId) { //预览文章内容\n                var previewingPost = $('.article-list-item .preview-p');\n                if (!!previewingPost.length) { // 若有其它预览已打开,则自动收起\n                    var previewingPostItemEl = previewingPost.parent('.article-list-item');\n                    previewingPostItemEl.find('.list-show-btn').html('全文速览');\n                    previewingPostItemEl.find('.article-list-content').html(pre_post_con).removeClass('preview-p');\n                    pre_post_con = '';\n                    this.comments_html = '<div id=\"new_comments\" style=\"margin-top:40px\"></div>';\n                    if (postId === pre_post_id) { // 若点击当前已打开文章的按钮\n                        return;\n                    }\n                }\n\n                $('#' + postId).html('<div uk-spinner></div><h7 class=\"loading-text\">加载中...</h7>');\n                axios.get(this.site_url + '/wp-json/wp/v2/posts/' + postId)\n                    .then(response => {\n                        if (response.data.length !== 0) { //判断是否最后一页\n                            axios.get(this.site_url + '/wp-json/wp/v2/comments?post=' + postId)\n                                .then(comments => {\n                                    if (response.data.comment_status == 'open' && this.preview_comment_open) {\n                                        //处理评论格式\n                                        for (var c = 0; c < comments.data.length; ++c) {\n                                            this.comments_html += '<div class=\"quick-div\"><div><img class=\"quick-img\" src=\"' + comments.data[c].author_avatar_urls['48'] + '\"></div><div><p class=\"quick-name\">' + comments.data[c].author_name + '<em class=\"quick-date\">' + comments.data[c].date + '</em></p>' + comments.data[c].content.rendered + '</div></div>';\n                                        }\n                                        this.comments_html += '<div class=\"quick-div\" style=\"margin-top: 15px;padding-bottom: 0px;\"><div style=\"flex:1;border-right: 1px solid #eee;\"><input type=\"text\" placeholder=\"昵称\" id=\"comment_form_name\" class=\"quick-form\"></div><div style=\"flex:1;margin-left: 10px;\"><input type=\"email\" placeholder=\"邮箱\" id=\"comment_form_email\" class=\"quick-form\"></div></div><div class=\"quick-div\" style=\"padding: 4px;\"><textarea placeholder=\"说点什么...\" id=\"comment_form_content\" class=\"quick-form-textarea\"></textarea></div><button class=\"quick-btn\" onclick=\"send_comment(' + postId + ')\">发送评论</button>';\n                                    }\n\n\n                                    $('#btn' + postId).html('收起速览'); //更改按钮\n\n                                    if (!!this.m) {\n                                        var show_con = response.data.content.rendered.replace(reg1, '').replace(reg2, '').replace(reg3, '');\n                                        show_con = md.render(show_con);\n                                        pre_post_con = md.render(response.data.post_excerpt.nine); //保存摘录\n                                    } else {\n                                        var show_con = response.data.content.rendered;\n                                        pre_post_con = response.data.post_excerpt.nine; //保存摘录\n                                    }\n\n                                    $('#' + postId).addClass('preview-p').html(\n                                        show_con +\n                                        this.comments_html\n                                    ); //更改内容\n                                    pre_post_id = postId;\n                                    document.querySelectorAll('pre code').forEach((block) => {\n                                        hljs.highlightBlock(block);\n                                    });\n                                })\n                        } else {\n                            $('#' + postId).html('Nothing Here');\n                        }\n                    });\n            }\n        }\n    });\n\n\n})\n\n//# sourceURL=webpack:///./src/index.js?");

/***/ })

/******/ });