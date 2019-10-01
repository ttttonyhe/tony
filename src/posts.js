window.onload = function(){ //避免爆代码

    /* 展现内容(避免爆代码) */
    $('.grid-centered').css({'max-width':'660px','padding': '0px 20px','margin-top': '80px'});
    $('.article-list').css('opacity','1');
    $('#header-div').css('opacity', '1');
    $('#header_info').css('opacity', '1');
    $('.cat-real').attr('style','display:inline-block');
    /* 展现内容(避免爆代码) */
    
    new Vue({ //axios获取顶部信息
        el : '#grid-cell',
        data() {
            return {
                site_url : window.site_url,
                flag: false,
                posts: null,
                loading: true, //v-if判断显示占位符
                loading_des: false,
                last_year: 0,
                posts_array: [],
            }
        },
        mounted () {
            //获取文章列表
            axios.get(this.site_url + '/wp-json/wp/v2/posts?per_page='+ window.post_count) //默认以发布时间排序
             .then(response => {
                 this.posts = response.data
             })
             .then(() => {
                 var k = -1;
                 var i = 0;
                 for(i=0;i<(this.posts).length;i++){ //遍历所有文章
                     if( ((this.posts[i].date.split('T'))[0].split('-'))[0] !== this.last_year ){ //当前文章发布年与上一篇不同
                         this.posts_array[k += 1] = []; //初始化数组
                         this.posts_array[k]['posts'] = []; //初始化 posts 数组
                         this.posts_array[k]['year'] = parseInt(((this.posts[i].date.split('T'))[0].split('-'))[0]); //增加年份
                         this.posts_array[k]['posts'][(this.posts_array[k]['posts']).length] = this.posts[i]; //增加文章
                         this.last_year = ((this.posts[i].date.split('T'))[0].split('-'))[0]; //赋值当前文章发布年份
                     }else{ //发布年份与上一篇相同
                        this.posts_array[k]['posts'][(this.posts_array[k]['posts']).length] = this.posts[i]; //增加文章
                     }
                 }
                 this.loading = false;
            })
        }
    });
    
    
}