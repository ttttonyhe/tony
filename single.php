<script>
/*
    function closeinfo(){
    var lastread=document.getElementById('lastread');
    lastread.style.display="none";
    }
    */
</script>
<!--
<div class="card lastread-card" id="lastread" style="<?php // if(!isset($_COOKIE[lastreadtitle]) || !isset($_COOKIE[lastreadlink]) || $_COOKIE[lastreadlink]=='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']){ echo "display:none;"; } ?> box-shadow: 0 1px 3px rgba(249,249,249,0.08), 0 0 0 1px rgba(26,53,71,.04), 0 1px 1px rgba(26,53,71,.06);border:none;z-index: 111;">
  <div class="card-body" style="padding: 1.05rem;">
    <h5 class="card-title">上次读到:</h5>
    <h6 class="card-subtitle mb-2 text-muted"><?php // echo $_COOKIE['lastreadtitle']; ?></h6>
    <a onclick="closeinfo();" class="card-link lastread-card-a1">关闭提示</a>
<a href="<?php // echo $_COOKIE['lastreadlink']; ?>" class="card-link lastread-card-a2">继续阅读</a>
    
  </div>
</div> -->


<?php get_header(); ?>
<?php setPostViews($post->ID); ?>  

                    <article class="article reveal uk-animation-slide-left-small" id="lightgallery">
                        <div id="load">
                        <header class="article-header">
                            <span class="badge badge-pill badge-danger single-badge"><a href="<?php echo site_url() ?>" style="text-decoration:none"><i class="czs-read-l" style="margin-right:5px;"></i>博客文章</a></span>
                            
                            <h2 class="single-h2" style="height: 50px;width: 100%;background: rgba(238, 238, 238, 0.81);color:rgba(238, 238, 238, 0.81)"></h2>
                            <div class="article-list-footer" style="height: 25px;background: rgb(246, 247, 248);width: 80%;margin-top: 15px;color:rgb(246, 247, 248)">
                            </div>
                            <div class="single-line"></div>
                        </header>
                        
                         <div class="article-content"><p style="     display: block;     background: rgb(246, 247, 248);     width: 100%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 95%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 95%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 90%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 100%;     height: 20px; "></p><p style="     display: block;     background: rgb(246, 247, 248);     width: 100%;     height: 20px; "></p></div>
                         <?php if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                    endif;
                                ?>
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
                axios.get('<?php echo site_url() ?>/wp-json/wp/v2/posts/'+<?php echo $post->ID; ?>)
                 .then(response => {
                     this.posts = response.data;
                 })
                 .catch(e => {
                     this.errored = false
                 })
                 .finally(() => {
                     this.loading = false;
                     $('.real').css('display','block');
                     $('.article-content').html(this.posts.content.rendered).attr('style','');
                     $('.single-h2').html(this.posts.post_metas.title).attr('style','');
                     $('.article-list-footer').html('<span class="article-list-date">'+this.posts.post_date+'</span><span class="article-list-divider">&nbsp;&nbsp;/&nbsp;&nbsp;</span><span class="article-list-minutes">'+this.posts.post_metas.views+'&nbsp;Views</span>').attr('style','');
                     
                })
            }
        });
        
        
}
</script>





















<?php get_footer(); ?>