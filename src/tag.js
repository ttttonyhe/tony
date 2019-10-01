window.onload = function() { //避免爆代码

    var click = 0; //初始化加载次数
    var paged = 1; //获取当前页数
    var incate = window.cate_id;
    var tag_name = window.tag_name;
    var post_count = window.post_count;

    /* 展现内容(避免爆代码) */
    $('.article-list').css('opacity', '1');
    $('.top1').html(tag_name);
    $('.top2').html('标签文章数 : '+ post_count);
    $('.cat-real').attr('style', 'display:inline-block');
    /* 展现内容(避免爆代码) */

    new Vue({ //axios获取顶部信息
        el: '#grid-cell',
        data() {
            return {
                site_url: window.site_url,

                exclude_option: window.cate_exclude_option,
                cate_exclude: window.cate_exclude,
                exclude_params: '',

                pages: window.index_p,
                cate_fre: window.cate_fre,
                cate_wor: window.cate_fre,


                posts: null,
                cates: null,
                des: null,
                loading: true, //v-if判断显示占位符
                loading_des: true,
                errored: true,
                loading_css: 'loading-line'
            }
        },
        mounted() {

            //分类排除参数获取
            if(this.cate_exclude == 'true'){
                this.exclude_params = '?exclude=' + this.exclude_option;
            }

            //获取分类
            axios.get(this.site_url + '/wp-json/wp/v2/categories' + this.exclude_params)
                .then(response => {
                    this.des = response.data;
                }).then(() => {
                    this.loading_des = false;
                });

            //获取文章列表
            axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page='+ this.pages +'&page=' + paged + '&tags=' + incate)
                .then(response => {
                    this.posts = response.data
                })
                .catch(e => {
                    this.errored = false
                })
                .then(() => {
                    this.loading = false;
                    paged++; //加载完1页后累加页数
                    //加载完文章列表后监听滑动事件
                    $(window).scroll(function() {
                        var scrollTop = $(window).scrollTop();
                        var scrollHeight = $('.bottom').offset().top - 500;
                        if (scrollTop >= scrollHeight) {
                            if (click == 0) { //接近底部加载一次新文章
                                $('#scoll_new_list').click();
                                click++; //加载次数计次
                            }
                        }
                    });

                })
        },
        methods: { //定义方法
            new_page: function() { //加载下一页文章列表
                axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page='+ this.pages +'&page=' + paged + '&tags=' + incate)
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
            }
        },
        filters: {
            link_page: function(cate_id) {
                if (cate_id == this.cate_fre) {
                    return '添加于 ';
                } else if (cate_id == this.cate_wor) {
                    return '创造于 ';
                } else {
                    return '';
                }
            },
            link_style: function(cate_id) {
                if (cate_id == this.cate_fre || cate_id == this.cate_wor){
                    return 'display: flex';
                } else {
                    return '';
                }
            }
        }
    });


}