$(document).ready(function() { //避免爆代码


    var post_info = new Vue({ //axios获取顶部信息
        el: 'main',
        data() {
            return {
                site_url: window.site_url,
                post_id: window.post_id,
                m: window.index_m,
                pwd: window.pwd,
                color: window.color,
                display_author: window.display_author,
                author_div: '',

                posts: null,
                loading: true, //v-if判断显示占位符
                errored: true,
                cate: '分类目录',
                cate_url: '',
                post_tags: [],
                post_prenext: [],
                exist_index: true,
                reading_p: 0
            }
        },
        mounted() {

            //获取文章
            axios.get(this.site_url + '/wp-json/wp/v2/posts/' + this.post_id)
                .then(response => {
                    this.posts = response.data;
                })
                .catch(e => {
                    this.errored = false
                })
                .then(() => {
                    this.loading = false;
                    this.cate = this.posts.post_categories[0].name;
                    this.cate_url = this.posts.post_categories[0].link;
                    this.post_tags = this.posts.post_tags;
                    this.post_prenext = this.posts.post_prenext;

                    $('.real').css('display', 'block');

                    if (!!this.pwd) {
                        $('.article-content').attr('style', '');
                    } else if (!!this.m) {
                        // 初始化 markdown 插件
                        tm = texmath.use(katex);
                        var md = window.markdownit({
                            html: true,
                            xhtmlOut: false,
                            breaks: true,
                            linkify: true
                        }).use(tm,{delimiters:'dollars',macros:{"\\RR": "\\mathbb{R}"}});
                        var md_result = md.render(this.posts.md_content);
                        $('.article-content').html(md_result).attr('style', '');
                    } else {
                        $('.article-content').html(this.posts.content.rendered).attr('style', '');
                    }

                    $('.single-h2').html(this.posts.post_metas.title.replace('密码保护：', '')).attr('style',
                        '');

                    //展示文章作者名称
                    if(this.display_author){
                        this.author_div = '<span class="article-list-date">' + this.posts.post_metas.author +
                        '</span><span class="article-list-divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span>';
                    }

                    $('.article-list-footer').html(this.author_div + '<span class="article-list-date">' + this.posts
                        .post_date +
                        '</span><span class="article-list-divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span><span class="article-list-minutes">' +
                        this.posts.post_metas.views + '&nbsp;Views</span>').attr('style', '');

                    if (!!this.color) {
                        //文章阅读进度条
                        var content_offtop = $('.article-content').offset().top;
                        var content_height = $('.article-content').innerHeight();
                        $(window).scroll(function() {
                            if (($(this).scrollTop() > content_offtop)) { //滑动到内容部分
                                if (($(this).scrollTop() - content_offtop) <= content_height) { //在内容部分内滑动
                                    this.reading_p = Math.round(($(this).scrollTop() - content_offtop) / content_height * 100);
                                } else { //滑出内容部分
                                    this.reading_p = 100;
                                }
                            } else { //未滑到内容部分
                                this.reading_p = 0;
                            }
                            $('.reading-bar').css('width', this.reading_p + '%');
                        });
                    }


                    /* 文章目录 */

                    var h = 0;
                    var pf = 23;
                    var i = 0;
                    $('#article-index').html('');
                    var count_ti = count_in = count_ar = count_sc = count_hr = count_e = 1;
                    var offset = new Array;
                    var min = 0;
                    var c = 0;
                    var icon = '';

                    //获取最高级别h标签
                    $(".article-content>:header").each(function() {
                        h = $(this).eq(0).prop("tagName").replace('H', '');
                        if (c == 0) {
                            min = h;
                            c++;
                        } else {
                            if (h <= min) {
                                min = h;
                            }
                        }
                    });

                    //获取h标签内容
                    $(".article-content>:header").each(function() {
                        h = $(this).eq(0).prop("tagName").replace('H', ''); //标签级别
                        for (i = 0; i < Math.abs(h - min); ++i) { //偏移程度
                            pf += 10;
                        }
                        if (pf !== 23) { //图标
                            icon = 'czs-square-l';
                        } else {
                            icon = 'czs-circle-l';
                        }

                        $('#article-index').html($('#article-index').html() + '<li id="ti' + (
                                count_ti++) +
                            '" style="padding-left:' + pf + 'px"><a><i class="' + icon +
                            '"></i>  ' + $(this).eq(
                                0).text().replace(/[ ]/g, "") + '</a></li>'); //创建目录
                        $(this).eq(0).attr('id', 'in' + (count_in++)); //添加id
                        offset[0] = 0;
                        offset[count_ar++] = $(this).eq(0).offset().top; //位置存入数组
                        count_e++;
                        pf = 23; //设置初始偏移值
                        i = 0; //设置循环开始
                    })

                    //跳转对应位置事件
                    $('#article-index li').click(function() {
                        $('html,body').animate({
                            scrollTop: ($('#in' + $(this).eq(0).attr('id').replace('ti',
                                '')).offset().top - 100)
                        }, 500);
                    });

                    if (count_e !== 1) { //若存在标签

                        $(window).scroll(function() { //滑动窗口时
                            var scroH = $(this).scrollTop() + 130;
                            var navH = offset[count_sc]; //从1开始获取当前位置
                            var navH_prev = offset[count_sc - 1]; //获取上一个位置(以备回滑)
                            if (scroH >= navH) { //滑过当前位置
                                $('#ti' + (count_sc - 1)).attr('class', '');
                                $('#ti' + count_sc).attr('class', 'active');
                                count_sc++; //调至下一个位置
                            }
                            if (scroH <= navH_prev) { //滑回上一个h3位置,调至上一个位置
                                $('#ti' + (count_sc - 2)).attr('class', 'active');
                                count_sc--;
                                $('#ti' + count_sc).attr('class', '');
                            }
                        });

                    } else {
                        $('.index-div').css('display', 'none');
                        this.exist_index = false;
                    }
                    /* 文章目录 */

                    //代码高亮
                    document.querySelectorAll('pre code').forEach((block) => {
                        hljs.highlightBlock(block);
                    });
                })
        }
    });


});