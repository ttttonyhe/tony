<?php 
/*
Template Name: 单栏页面
*/
get_header(); ?>
<?php setPostViews($post->ID); ?>  

                    <article class="article reveal">
                        <div id="load">
                        <header class="article-header">
                            <span class="badge badge-pill badge-danger single-badge"><a href="https://www.ouorz.com" style="text-decoration:none"><i class="czs-read-l" style="margin-right:5px;"></i>博客页面</a></span>
                            
                            <h2 class="single-h2" style="height: 50px;width: 100%;background: rgba(238, 238, 238, 0.81);color:rgba(238, 238, 238, 0.81)"></h2>
                            <div class="article-list-footer" style="height: 25px;background: rgb(246, 247, 248);width: 80%;margin-top: 15px;color:rgb(246, 247, 248)">
                            </div>
                            <div class="single-line"></div>
                        </header>
                        
                         <div class="article-content"><p style="     display: block;     background: rgb(246, 247, 248);     width: 100%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 95%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 95%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 100%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 100%;     height: 20px; "></p></div>
                         <div class="article-comments" id="article-comments">
                            <?php if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                    endif;
                                ?>
                         </div>
                         </div>
                    </article>
                    

























<script>
window.onload = function(){ //避免爆代码
        
        
        var post_info = new Vue({ //axios获取顶部信息
            el : '#load',
            data() {
                return {
                    posts: null,
                    loading: true, //v-if判断显示占位符
                    errored: true
                }
            },
            mounted () {

                //获取文章
                axios.get('<?php echo site_url() ?>/wp-json/wp/v2/pages/'+<?php echo $post->ID; ?>)
                 .then(response => {
                     this.posts = response.data;
                 })
                 .catch(e => {
                     this.errored = false
                 })
                 .then(() => {
                     this.loading = false;
                     $('.real').css('display','block');
                     $('.article-content').html(this.posts.content.rendered).attr('style','');
                     $('.single-h2').html(this.posts.title.rendered).attr('style','');
                     $('.article-list-footer').html('<span class="article-list-date">'+this.posts.post_date+'</span><span class="article-list-divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span><span class="article-list-minutes">'+this.posts.post_metas.views+'&nbsp;Views</span>').attr('style','');
                     
                })
            }
        });
        
        
}
</script>






















<?php get_footer(); ?>