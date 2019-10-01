$(document).ready(function() { //避免爆代码


    var post_info = new Vue({ //axios获取顶部信息
        el: '#load',
        data() {
            return {
                site_url: window.site_url,
                post_id: window.post_id,
                posts: null,
                loading: true, //v-if判断显示占位符
                errored: true
            }
        },
        mounted() {

            //获取文章
            axios.get(this.site_url + '/wp-json/wp/v2/pages/' + this.post_id)
                .then(response => {
                    this.posts = response.data;
                })
                .catch(e => {
                    this.errored = false
                })
                .then(() => {
                    this.loading = false;
                    $('.real').css('display', 'block');
                    $('.article-content').html(this.posts.content.rendered).attr('style', '');
                    $('.single-h2').html(this.posts.title.rendered).attr('style', '');
                    $('.article-list-footer').html('<span class="article-list-date">' + this.posts.post_date + '</span><span class="article-list-divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span><span class="article-list-minutes">' + this.posts.post_metas.views + '&nbsp;Views</span>').attr('style', '');

                })
        }
    });


})