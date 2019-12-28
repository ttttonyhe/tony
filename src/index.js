/*
 *   Author - TonyHe
 *   Theme Tony - v4.37
 *   https://www.ouorz.com/ | Released under GPL-3.0 license
 */

$(document).ready(function () { //避免爆代码

    //获取评论参数
    var site = window.site_url;
    var wp_rest = window.wp_rest;

    var now = 20;
    var click = 0; //初始化加载次数
    var paged = 1; //获取当前页数
    var pre_post_id = null;
    var pre_post_con = '';

    /* 展现内容(避免爆代码) */
    $('.article-list').css('opacity', '1');
    $('.cat-real').attr('style', 'display:inline-block');
    /* 展现内容(避免爆代码) */

    var antd = new Vue({ //axios获取顶部信息
        el: '#grid-cell',
        data() {
            return {
                m: window.index_m,
                site_url: window.site_url,

                exclude_option: window.cate_exclude_option,
                cate_exclude: window.cate_exclude,
                exclude_params: '',

                cates_exclude: window.cates_exclude,
                cate_exclude_params: '',
                cate_exclude_option: window.cates_exclude_option,

                pages: window.index_p,

                preview_comment_open: window.preview_comment_open,

                posts: null,
                cates: null,
                tages: null,
                loading: true, //v-if判断显示占位符
                loading_cates: true,
                loading_tages: true,
                errored: true,
                loading_css: 'loading-line',
                comments_html: '<div id="new_comments" style="margin-top:40px"></div>'
            }
        },
        mounted() {

            //分类排除参数获取
            if (this.cate_exclude == 'true') {
                this.exclude_params = '?exclude=' + this.exclude_option;
            }

            if (this.cates_exclude == 'true') {
                this.cate_exclude_params = '&categories_exclude=' + this.cate_exclude_option;
            }

            //获取分类
            axios.get(this.site_url + '/wp-json/wp/v2/categories' + this.exclude_params)
                .then(response => {
                    this.cates = response.data;
                })
                .then(() => {
                    this.loading_cates = false;

                    //获取标签
                    axios.get(this.site_url + '/wp-json/wp/v2/tags?order=desc&per_page=15')
                        .then(response => {
                            this.tages = response.data;
                        }).then(() => {
                            this.loading_tages = false;
                        });

                });

            //获取文章列表
            axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page=' + this.pages + '&page=' + paged + this.cate_exclude_params)
                .then(response => {
                    this.posts = response.data
                })
                .catch(e => {
                    this.errored = false;
                    alert('文章加载失败，可能是伪静态未配置正确，请参考: https://www.wpdaxue.com/wordpress-rewriterule.html 来配置。加入 QQ 群：454846972 以获得更多支持。');
                })
                .then(() => {
                    this.loading = false;
                    paged++; //加载完1页后累加页数
                    //加载完文章列表后监听滑动事件
                    $(window).scroll(function () {
                        var scrollTop = $(window).scrollTop();
                        var scrollHeight = $('.bottom').offset().top - 800;
                        if (scrollTop >= scrollHeight) {
                            if (click == 0) { //接近底部加载一次新文章
                                $('#scoll_new_list').click();
                                click++; //加载次数计次
                            }
                        }
                    });

                    //检查是否存在下一页
                    axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page=' + this.pages + '&page=' + paged + this.cate_exclude_params)
                    .then(response => {
                        if (!response.data.length || response.data.length == 0) { //判断是否最后一页
                            this.loading_css = '';
                            $('#view-text').html('-&nbsp;全部文章&nbsp;-');
                            $('.bottom h5').html('暂无更多文章了 O__O "…').css({
                                'background': '#fff',
                                'color': '#999'
                            });
                        }
                    }).catch(e => {
                        this.loading_css = '';
                        $('#view-text').html('-&nbsp;所有文章&nbsp;-');
                        $('.bottom h5').html('暂无更多文章了 O__O "…').css({
                            'background': '#fff',
                            'color': '#999'
                        });
                    })

                })

        },
        methods: { //定义方法
            new_page: function () { //加载下一页文章列表
                $('#view-text').html('-&nbsp;加载中&nbsp;-');
                axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page=' + this.pages + '&page=' + paged + this.cate_exclude_params)
                    .then(response => {
                        if (!!response.data.length && response.data.length !== 0) { //判断是否最后一页
                            $('#view-text').html('-&nbsp;文章列表&nbsp;-');
                            this.posts.push.apply(this.posts, response.data); //拼接在上一页之后
                            click = 0;
                            paged++;
                        } else {
                            this.loading_css = '';
                            $('#view-text').html('-&nbsp;全部文章&nbsp;-');
                            $('.bottom h5').html('暂无更多文章了 O__O "…').css({
                                'background': '#fff',
                                'color': '#999'
                            });
                        }
                    }).catch(e => {
                        this.loading_css = '';
                        $('#view-text').html('-&nbsp;所有文章&nbsp;-');
                        $('.bottom h5').html('暂无更多文章了 O__O "…').css({
                            'background': '#fff',
                            'color': '#999'
                        });
                    })
            },
            preview: function (postId) { //预览文章内容
                var previewingPost = $('.article-list-item .preview-p');
                if (!!previewingPost.length) { // 若有其它预览已打开,则自动收起
                    var previewingPostItemEl = previewingPost.parent('.article-list-item');
                    previewingPostItemEl.find('.list-show-btn').html('全文速览');
                    previewingPostItemEl.find('.article-list-content').html(pre_post_con).removeClass('preview-p');
                    pre_post_con = '';
                    this.comments_html = '<div id="new_comments" style="margin-top:40px"></div>';
                    if (postId === pre_post_id) { // 若点击当前已打开文章的按钮
                        return;
                    }
                }

                $('#' + postId).html('<div uk-spinner></div><h7 class="loading-text">加载中...</h7>');
                axios.get(this.site_url + '/wp-json/wp/v2/posts/' + postId)
                    .then(response => {
                        if (response.data.length !== 0) { //判断是否最后一页
                            axios.get(this.site_url + '/wp-json/wp/v2/comments?post=' + postId)
                                .then(comments => {
                                    if (response.data.comment_status == 'open' && this.preview_comment_open) {
                                        //处理评论格式
                                        for (var c = 0; c < comments.data.length; ++c) {
                                            this.comments_html += '<div class="quick-div"><div><img class="quick-img" src="' + comments.data[c].author_avatar_urls['48'] + '"></div><div><p class="quick-name">' + comments.data[c].author_name + '<em class="quick-date">' + comments.data[c].date + '</em></p>' + comments.data[c].content.rendered + '</div></div>';
                                        }
                                        this.comments_html += '<div class="quick-div" style="margin-top: 15px;padding-bottom: 0px;"><div style="flex:1;border-right: 1px solid #eee;"><input type="text" placeholder="昵称" id="comment_form_name" class="quick-form"></div><div style="flex:1;margin-left: 10px;"><input type="email" placeholder="邮箱" id="comment_form_email" class="quick-form"></div></div><div class="quick-div" style="padding: 4px;"><textarea placeholder="说点什么..." id="comment_form_content" class="quick-form-textarea"></textarea></div><button class="quick-btn" onclick="send_comment(' + postId + ')">发送评论</button>';
                                    }


                                    $('#btn' + postId).html('收起速览'); //更改按钮

                                    if (!!this.m) {
                                        var show_con = response.data.content.rendered.replace(reg1, '').replace(reg2, '').replace(reg3, '');
                                        show_con = md.render(show_con);
                                        pre_post_con = md.render(response.data.post_excerpt.nine); //保存摘录
                                    } else {
                                        var show_con = response.data.content.rendered;
                                        pre_post_con = response.data.post_excerpt.nine; //保存摘录
                                    }

                                    $('#' + postId).addClass('preview-p').html(
                                        show_con +
                                        this.comments_html
                                    ); //更改内容
                                    pre_post_id = postId;
                                    document.querySelectorAll('pre code').forEach((block) => {
                                        hljs.highlightBlock(block);
                                    });
                                })
                        } else {
                            $('#' + postId).html('Nothing Here');
                        }
                    });
            }
        }
    });


})