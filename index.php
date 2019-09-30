<?php
get_header();
if (!get_option('king_per_page')) $p = '6';
else $p = get_option('king_per_page');
if (!get_option('markdown-it')) $m = 0;
elseif (get_option('markdown-it') == '关闭') $m = 0;
else $m = 1;
?>

<div id="header_info" class="index-top">
    <nav class="header-nav reveal">
        <a style="text-decoration:none;" href="<?php echo site_url() ?>" class="header-logo" title="<?php echo get_bloginfo('name'); ?>"><?php echo get_bloginfo('name'); ?></a>
        <p class="lead" style="margin-top: 0px;margin-left:5px"><?php get_tony_ms(); ?></p>
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
    <li class="article-list-item reveal index-post-list uk-scrollspy-inview loading-line" v-if="loading"><em class="article-list-type1" style="padding: 5.5px 44px;">&nbsp;</em> <a style="text-decoration: none;">
            <h5 style="background: rgb(236, 237, 238);">&nbsp;</h5>
        </a>
        <p style="background: rgb(246, 247, 248);width: 90%;">&nbsp;</p>
        <p style="background: rgb(246, 247, 248);width: 60%;">&nbsp;</p>
    </li>
    <!-- 占位DIV -->


    <li class="article-list-item reveal index-post-list" v-for="post in posts">

        <template v-if="post.post_img.url == false">
            <div class="list-show-div">
                <em v-if="post.post_categories[0].term_id === <?php if (get_option('king_cate_cate')) {
                                                                    echo get_option('king_cate_cate');
                                                                } else {
                                                                    echo '0';
                                                                } ?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php if (get_option('king_cate_cate_ph')) echo get_option('king_cate_cate_ph');
                                                                                                                                                                                                                    else echo 'XX' ?>')  }}</em>
                <div v-else class="article-list-tags">
                    <a>文章标签</a>
                    <template v-if="!!post.post_tags.length">
                        <a v-for="tag in post.post_tags.slice(0,2)" :href="tag.url" v-html="tag.name"></a>
                    </template>
                    <template v-else>
                        <a>空标签</a>
                    </template>
                </div>
                <button type="button" class="list-show-btn" @click="preview(post.id)" :id="'btn'+post.id" v-if="post.excerpt.rendered !== ''">全文速览</button>
            </div>
            <a :href="post.link" style="text-decoration: none;">
                <h5 v-html="post.title.rendered"></h5>
            </a>
            <?php if ($m) { ?>
                <p class="article-list-content" v-html="md.render(post.post_excerpt.nine)" :id="post.id"></p>
            <?php } else { ?>
                <p class="article-list-content" v-html="post.post_excerpt.nine" :id="post.id"></p>
            <?php } ?>
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
                    <em v-if="post.post_categories[0].term_id === <?php if (get_option('king_cate_cate')) {
                                                                        echo get_option('king_cate_cate');
                                                                    } else {
                                                                        echo '0';
                                                                    } ?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php if (get_option('king_cate_cate_ph')) echo get_option('king_cate_cate_ph');
                                                                                                                                                                                                                        else echo 'XX' ?>')  }}</em>
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
    <li :class="'article-list-item reveal index-post-list uk-scrollspy-inview bottom '+loading_css"><em class="article-list-type1" style="padding: 5.5px 45px;">&nbsp;</em> <a style="text-decoration: none;">
            <h5 style="background: rgb(236, 237, 238);">&nbsp;</h5>
        </a>
        <p style="background: rgb(246, 247, 248);width: 90%;">&nbsp;</p>
        <p style="background: rgb(246, 247, 248);width: 60%;">&nbsp;</p>
    </li>
    <!-- 加载占位DIV -->

    <!-- 加载按钮 -->
    <button @click="new_page" id="scoll_new_list" style="opacity:0"></button>
    <!-- 加载按钮 -->
</ul>

<script src="https://cdn.bootcss.com/markdown-it/8.4.2/markdown-it.min.js"></script>
<script src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.min.js"></script>
<script>
    // Markdown 实例化
    var md = window.markdownit({
        html: true,
        xhtmlOut: false,
        breaks: true,
        linkify: true
    });

    //去除标签混淆
    var reg1 = new RegExp('<p>', 'g');
    var reg2 = new RegExp('</p>', 'g');
    var reg3 = new RegExp('<br />', 'g');

    window.index_p = <?php echo $p; ?>;
    window.index_m = '<?php if ($m) echo 'true';
                        else echo 'false'; ?>';
    window.wp_rest = '<?php echo wp_create_nonce('wp_rest'); ?>';
    window.site_url = '<?php echo site_url() ?>';

    window.cate_exclude_option = '<?php if (get_option('king_index_cate_exclude')) echo get_option('king_index_cate_exclude'); ?>'
    <?php if (get_option('king_index_cate_exclude')) { ?>
        window.cate_exclude = 'true';
    <?php } else { ?>
        window.cate_exclude = 'false';
    <?php } ?>

    window.cates_exclude_option = '<?php if (get_option('king_index_exclude')) echo get_option('king_index_exclude'); ?>'
    <?php if (get_option('king_index_exclude')) { ?>
        window.cates_exclude = 'true';
    <?php } else { ?>
        window.cates_exclude = 'false';
    <?php } ?>

    var send_comment = function(postId) {
        var _nonce = wp_rest;
        var na = $('#comment_form_name').val();
        var em = $('#comment_form_email').val();
        var ct = $('#comment_form_content').val();
        if (na !== '' && ct !== '' && em !== '') {
            axios.post(window.site_url + '/wp-json/wp/v2/comments?post=' + postId, {
                    author_name: na,
                    author_email: em,
                    content: ct,
                    post: postId
                }, {
                    headers: {
                        'X-WP-Nonce': _nonce
                    }
                })
                .then(() => {
                    $('#new_comments').html('<div class="quick-div"><div><img class="quick-img" src="https://gravatar.loli.net/avatar/' + md5(em) + '?d=mp&s=80"></div><div><p class="quick-name">' + na + '<em class="quick-date">刚刚</em></p><p>' + ct + '</p></div></div>' + $('#new_comments').html());
                    $('#comment_form_content').val('');
                })
        } else {
            alert('信息不全');
        }
    }
</script>

<script type="text/javascript" src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/js/index.js"></script>
<?php get_footer(); ?>