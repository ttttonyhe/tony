<?php /* Template Name: 归档页面 */ get_header(); ?>

<div id="header_info" style="opacity:0">
    <nav class="header-nav reveal"> <a class="top1 header-logo" style="text-decoration:none;" href="<?php echo site_url() ?>">归档页面</a>

        <p class="top2 lead archive-p">按照年月归档存放的文章</p>
        <div class="btn-group" style="margin-top: -145px;margin-left: 180px;">
            <button type="button" class="btn btn-primary"><a href="<?php echo site_url() ?>" style="text-decoration:none;color:white"><i class="czs-hand-slide" style="margin-right:5px" ></i>回到首页</a>
            </button>
        </div>
    </nav>

</div>


<ul class="article-list" style="opacity:0">
    <!-- 占位DIV -->
    <li uk-scrollspy="cls:uk-animation-slide-left-small" class="article-list-item reveal index-post-list uk-scrollspy-inview" v-if="loading"><em class="article-list-type1 loading-line" style="padding: 5.5px 44px;">&nbsp;</em>  <a style="text-decoration: none;"><h5 class="loading-line" style="background: rgb(236, 237, 238);">&nbsp;</h5></a>
        <p style="background: rgb(246, 247, 248);width: 90%;">&nbsp;</p>
        <p class="loading-line" style="background: rgb(246, 247, 248);width: 60%;">&nbsp;</p>
    </li>
    <!-- 占位DIV -->
    <li class="article-list-item reveal index-post-list" uk-scrollspy="cls:uk-animation-slide-left-small" v-for="array in posts_array">
        <h2>{{ array.year }}</h2>
        <a class="post-a" :href="post.link" v-for="post in array.posts" v-if="post.post_categories[0].term_id !== 2 && post.post_categories[0].term_id !== 58 && post.post_categories[0].term_id !== 5 && !post.post_metas.status"><p v-html="'<em class=\'post-date\'>' + (post.date.split('T'))[0] + '</em>' + post.title.rendered"></p></a>
    </li>
</ul>

<script>
    window.site_url = '<?php echo site_url() ?>';
    window.post_count = <?php $count_posts = wp_count_posts(); echo $published_posts =$count_posts->publish; ?>
</script>
<script type="text/javascript" src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/js/posts.js"></script>
<?php get_footer(); ?>