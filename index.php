<?php 
    get_header(); 
    if(!get_option('king_per_page')) $p = '6'; else $p = get_option('king_per_page');
?>

<div id="header_info" class="index-top">
    <nav class="header-nav reveal">
        <a style="text-decoration:none;" href="<?php echo site_url() ?>" class="header-logo" title="<?php echo get_bloginfo('name'); ?>"><?php echo get_bloginfo('name'); ?></a>
        <p class="lead" style="margin-top: 0px;margin-left:5px"><?php if(get_option('king_ms')) echo get_option('king_ms'); else echo '未设置描述'; ?></p>
    </nav>
    <div class="index-cates">
        <li class="cat-item cat-item-4 cat-real" style="display:none" v-for="cate in cates" v-if="cate.count !== 0"> <a :href="cate.link" :title="cate.description" v-html="cate.name"></a>
        </li>
        <li class="cat-item cat-item-4 loading-line" style="display: inline-block;width: 98%;height: 35px;box-shadow: none;border-radius: 0px;background: rgb(236, 237, 239);" v-if="loading_cates"></li>
    </div>
    <div>
        <ul class="post_tags">
            <li class="cat-real" v-for="tag in tages" style="display:none">
                <a :href="tag.link" v-html="'#'+tag.name"></a>
            </li>
            <li class="loading-line" style="background: rgb(236, 237, 238);height: 25px;width: 100%;" v-if="loading_tages"></li>
        </ul>
    </div>
</div>
<ul class="article-list" style="opacity:0">
    
    <!-- 占位DIV -->
    <li class="article-list-item reveal index-post-list uk-scrollspy-inview loading-line" v-if="loading"><em class="article-list-type1" style="padding: 5.5px 44px;">&nbsp;</em>  <a style="text-decoration: none;"><h5 style="background: rgb(236, 237, 238);">&nbsp;</h5></a><p style="background: rgb(246, 247, 248);width: 90%;">&nbsp;</p><p style="background: rgb(246, 247, 248);width: 60%;">&nbsp;</p>
    </li>
    <!-- 占位DIV -->
    
    
    <li class="article-list-item reveal index-post-list" v-for="post in posts">
        
        <template v-if="post.post_img.url == false">
        <div class="list-show-div">
            <em v-if="post.post_categories[0].term_id === <?php if(get_option('king_cate_cate')){ echo get_option('king_cate_cate'); }else{ echo '0'; }?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php if(get_option('king_cate_cate_ph')) echo get_option('king_cate_cate_ph'); else echo 'XX' ?>')  }}</em>
            <button type="button" class="list-show-btn" @click="preview(post.id)" :id="'btn'+post.id">全文速览</button>
        </div>
        <a :href="post.link" style="text-decoration: none;"><h5 v-html="post.title.rendered"></h5></a>
        <p class="article-list-content" v-html="post.post_excerpt.nine" :id="post.id"></p>
        <div class="article-list-footer"> 
            <span class="article-list-date">{{ post.post_date }}</span>
            <span class="article-list-divider">-</span>
            <span v-if="post.post_metas.views !== ''" class="article-list-minutes">{{ post.post_metas.views }}&nbsp;Views</span>
            <span v-else class="article-list-minutes">0&nbsp;Views</span>
        </div>
        </template>
        
        <template v-else>
            <div class="article-list-img-else">
    <div class="article-list-img" :style="'background-image:url(' + post.post_img.url +')'"></div>
    <div class="article-list-img-right">
        <em v-if="post.post_categories[0].term_id === <?php if(get_option('king_cate_cate')){ echo get_option('king_cate_cate'); }else{ echo '0'; }?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php if(get_option('king_cate_cate_ph')) echo get_option('king_cate_cate_ph'); else echo 'XX' ?>')  }}</em>
        <a :href="post.link" style="text-decoration: none;">
            <h5 v-html="post.title.rendered" style="margin: 0px;padding: 0px;margin-top:15px"></h5>
        </a>
        <p v-html="post.post_excerpt.four" :id="post.id"></p>
        <div class="article-list-footer"> 
            <span class="article-list-date">{{ post.post_date }}</span>
            <span class="article-list-divider">-</span>
            <span v-if="post.post_metas.views !== ''" class="article-list-minutes">{{ post.post_metas.views }}&nbsp;Views</span>
            <span v-else class="article-list-minutes">0&nbsp;Views</span>
        </div>
     </div>
</div>
        </template>
    </li>
    
    <!-- 加载占位DIV -->
    <li :class="'article-list-item reveal index-post-list uk-scrollspy-inview bottom '+loading_css"><em class="article-list-type1" style="padding: 5.5px 45px;">&nbsp;</em>  <a style="text-decoration: none;"><h5 style="background: rgb(236, 237, 238);">&nbsp;</h5></a><p style="background: rgb(246, 247, 248);width: 90%;">&nbsp;</p><p style="background: rgb(246, 247, 248);width: 60%;">&nbsp;</p>
    </li>
    <!-- 加载占位DIV -->
    
    <!-- 加载按钮 -->
    <button @click="new_page" id="scoll_new_list" style="opacity:0"></button>
    <!-- 加载按钮 -->
</ul>


<script>
window.onload = function(){ //避免爆代码
        
        var now = 20;
        var click = 0; //初始化加载次数
        var paged = 1; //获取当前页数
        var pre_post_id = null;
        var pre_post_con = '';
        
        /* 展现内容(避免爆代码) */
        $('.article-list').css('opacity','1');
        $('.cat-real').attr('style','display:inline-block');
        /* 展现内容(避免爆代码) */
        
        new Vue({ //axios获取顶部信息
            el : '#grid-cell',
            data() {
                return {
                    posts: null,
                    cates: null,
                    tages: null,
                    loading: true, //v-if判断显示占位符
                    loading_cates: true,
                    loading_tages: true,
                    errored: true,
                    loading_css : 'loading-line'
                }
            },
            mounted () {
                //获取分类
                axios.get('<?php echo site_url() ?>/wp-json/wp/v2/categories<?php if(get_option('king_index_cate_exclude')) echo '?exclude='.get_option('king_index_cate_exclude'); ?>')
                 .then(response => {
                     this.cates = response.data;
                 })
                 .then(() => {
                     this.loading_cates = false;
                     
                     //获取标签
                     axios.get('<?php echo site_url() ?>/wp-json/wp/v2/tags?order=desc&per_page=15')
                     .then(response => {
                         this.tages = response.data;
                     }).then(() => {
                        this.loading_tages = false;
                     });
                     
                 });
                
                //获取文章列表
                axios.get('<?php echo site_url() ?>/wp-json/wp/v2/posts?per_page=<?php echo $p; ?>&page='+paged+'<?php if(get_option('king_index_exclude')) echo '&categories_exclude='.get_option('king_index_exclude'); ?>')
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
                    $(window).scroll(function(){
　　                    var scrollTop = $(window).scrollTop();
　　                    var scrollHeight = $('.bottom').offset().top - 800;
　　                    if(scrollTop >= scrollHeight){
　　                        if(click == 0){ //接近底部加载一次新文章
　　　　                        $('#scoll_new_list').click();
　　　　                        click++; //加载次数计次
　　                        }
　　                    }
                    });
                    
                })
            },
            methods: { //定义方法
                new_page : function(){ //加载下一页文章列表
                    $('#view-text').html('-&nbsp;加载中&nbsp;-');
                    axios.get('<?php echo site_url() ?>/wp-json/wp/v2/posts?per_page=<?php echo $p; ?>&page='+paged+'<?php if(get_option('king_index_exclude')) echo '&categories_exclude='.get_option('king_index_exclude'); ?>')
                 .then(response => {
                     if(!!response.data.length && response.data.length !== 0){ //判断是否最后一页
                         $('#view-text').html('-&nbsp;文章列表&nbsp;-');
                         this.posts.push.apply(this.posts,response.data); //拼接在上一页之后
                         click = 0;
                         paged++;
                     }else{
                         this.loading_css = '';
                         $('#view-text').html('-&nbsp;全部文章&nbsp;-');
                         $('.bottom h5').html('暂无更多文章了 O__O "…').css({'background':'#fff','color':'#999'});
                     }
                 }).catch(e => {
                     this.loading_css = '';
                     $('#view-text').html('-&nbsp;所有文章&nbsp;-');
                     $('.bottom h5').html('暂无更多文章了 O__O "…').css({'background':'#fff','color':'#999'});
                 })
            },
                preview : function(postId){ //预览文章内容
                  var previewingPost = $('.article-list-item .preview-p');
                  if (!!previewingPost.length) { // 若有其它预览已打开,则自动收起
                    var previewingPostItemEl = previewingPost.parent('.article-list-item');
                    previewingPostItemEl.find('.list-show-btn').html('全文速览');
                    previewingPostItemEl.find('.article-list-content').html(pre_post_con).removeClass('preview-p');
                    pre_post_con = '';
                    if (postId === pre_post_id) { // 若点击当前已打开文章的按钮
                      return;
                    }
                  }
                   
                  $('#'+postId).html('<div uk-spinner></div><h7 class="loading-text">加载中...</h7>');
                  axios.get('<?php echo site_url() ?>/wp-json/wp/v2/posts/'+postId)
                    .then(response => {
                     if(response.data.length !== 0){ //判断是否最后一页
                         $('#btn'+postId).html('收起速览'); //更改按钮
                         $('#'+postId).addClass('preview-p').html(response.data.content.rendered); //更改内容
                         pre_post_con = response.data.post_excerpt.nine; //保存摘录
                         pre_post_id = postId
                     }else{
                         $('#'+postId).html('Nothing Here');
                     }
                   });
                }
            }
        });
        
        
}
</script>
<?php get_footer(); ?>