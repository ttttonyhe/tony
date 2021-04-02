<?php
get_header();
$p = !get_option('king_per_page') ? '6' : get_option('king_per_page');
$a = get_option('king_display_author') == '关闭' ? true : false;
$m = !get_option('markdown-it') || get_option('markdown-it') == '关闭' ? 0 : 1;
?>

<!-- 首页顶部 -->
<div id="header_info" class="index-top">
    <nav class="header-nav reveal">

        <!-- 顶部 logo 展示 -->
        <?php if (get_option('king_logo_header') == '开启') { ?>
            <img class="header-avatar-top" src="<?php tony_func('echo_logo'); ?>">
        <?php } ?>
        <!-- 顶部 logo 展示 -->

        <!-- 顶部标题与描述 -->
        <a style="text-decoration:none;" href="<?php echo site_url() ?>" class="header-logo" title="<?php echo get_bloginfo('name'); ?>"><?php echo get_bloginfo('name'); ?></a>
        <p class="lead" style="margin-top: 0px;margin-left:5px"><?php get_tony_ms(); ?></p>
        <!-- 顶部标题与描述 -->

    </nav>

    <!-- 分类或后台菜单 -->
    <div class="index-cates">
        <?php
        if (get_option('king_nav_display_top')) {
            $array_menu = wp_get_nav_menu_items(get_option('king_nav_display_top'));
            $menu = array();
            foreach ($array_menu as $m) {
                if (empty($m->menu_item_parent)) {
        ?>
                    <li class="cat-item cat-item-4 cat-real">
                        <a href="<?php echo $m->url ?>"><?php echo $m->title ?></a>
                    </li>
            <?php }
            }
        } else { ?>
            <li class="cat-item cat-item-4 cat-real" style="display:none" v-for="cate in cates" v-if="cate.count !== 0"> <a :href="cate.link" :title="cate.description" v-html="cate.name"></a>
            </li>
            <li class="cat-item cat-item-4 loading-line" style="display: inline-block;width: 98%;height: 35px;box-shadow: none;border-radius: 0px;background: rgb(236, 237, 239);" v-if="loading_cates"></li>
        <?php } ?>
    </div>
    <!-- 分类或后台菜单 -->

    <!-- 顶部标签 -->
    <div>
        <ul class="post_tags">
            <li class="cat-real" v-for="tag in tages" style="display:none">
                <a :href="tag.link" v-html="'#'+tag.name"></a>
            </li>
            <li class="loading-line" style="background: rgb(236, 237, 238);height: 25px;width: 100%;" v-if="loading_tages"></li>
        </ul>
    </div>
    <!-- 顶部标签 -->

</div>
<!-- 首页顶部 -->

<!-- 文章列表 -->
<ul class="article-list" style="opacity:0">

    <!-- 占位骨架图 -->
    <li class="article-list-item reveal index-post-list uk-scrollspy-inview loading-line" v-if="loading"><em class="article-list-type1" style="padding: 5.5px 44px;">&nbsp;</em> <a style="text-decoration: none;">
            <h5 style="background: rgb(236, 237, 238);">&nbsp;</h5>
        </a>
        <p style="background: rgb(246, 247, 248);width: 90%;">&nbsp;</p>
        <p style="background: rgb(246, 247, 248);width: 60%;">&nbsp;</p>
    </li>
    <!-- 占位骨架图 -->

    <!-- 文章卡片 -->
    <li :class="'article-list-item reveal index-post-list ' + (post.sticky ? 'sticky-one' : '')" v-for="post in posts">

        <!-- 无特色图像文章 -->
        <template v-if="post.post_img.url == false">

            <!-- 标签与分类 -->
            <div class="list-show-div">

                <!-- 置顶文章提示 -->
                <em class="article-list-type1 sticky-one-tag" v-if="post.sticky"><i class="czs-arrow-up-l" style="font-size: 14px;font-weight: 600;"></i> 置顶</em>
                <!-- 置顶文章提示 -->

                <!-- 特别分类标签 -->
                <em v-if="post.post_categories[0].term_id === <?php tony_func('echo_s_cate'); ?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php tony_func('echo_ph_cate'); ?>')  }}</em>
                <!-- 特别分类标签 -->

                <!-- 一般分类标签 -->
                <div v-else class="article-list-tags">
                    <a :href="post.post_categories[0].link" v-html="post.post_categories[0].name"></a>
                    <template v-if="!!post.post_tags.length">
                        <a v-for="tag in post.post_tags.slice(0,2)" :href="tag.url" v-html="tag.name"></a>
                    </template>
                    <template v-else>
                        <a>无标签</a>
                    </template>
                </div>
                <!-- 一般分类标签 -->

                <button type="button" class="list-show-btn" @click="preview(post.id)" :id="'btn'+post.id" v-if="post.excerpt.rendered !== ''">全文速览</button>

            </div>
            <!-- 标签与分类 -->

            <!-- 文章信息 -->
            <a :href="post.link" style="text-decoration: none;">
                <h5 v-html="post.title.rendered"></h5>
            </a>

            <!-- 文章描述 -->
            <p class="article-list-content" v-html="post.post_excerpt.nine" :id="post.id"></p>
            <!-- 文章描述 -->

            <!-- 底部信息 -->
            <div class="article-list-footer">
                <?php if ($a) { ?>
                    <span class="article-list-date display-author" v-html="post.post_metas.author"></span>
                    <span class="article-list-divider">-</span>
                <?php } ?>
                <span class="article-list-date">{{ post.post_date }}</span>
                <span class="article-list-divider">-</span>
                <span v-if="post.post_metas.views !== ''" class="article-list-minutes">{{ post.post_metas.views }}&nbsp;Views</span>
                <span v-else class="article-list-minutes">0&nbsp;Views</span>
            </div>
            <!-- 底部信息 -->

            <!-- 文章信息 -->
        </template>
        <!-- 无特色图像文章 -->

        <!-- 存在特色图像的文章 -->
        <template v-else>
            <div class="article-list-img-else">

                <!-- 文章特色图像 -->
                <div class="article-list-img" :style="'background-image:url(' + post.post_img.url +')'"></div>
                <!-- 文章特色图像 -->

                <!-- 文章信息 -->
                <div class="article-list-img-right">
                    <!-- 置顶文章提示 -->
                    <em class="article-list-type1 sticky-one-tag" v-if="post.sticky"><i class="czs-arrow-up-l" style="font-size: 14px;font-weight: 600;"></i> 置顶</em>
                    <!-- 置顶文章提示 -->
                    <em v-if="post.post_categories[0].term_id === <?php tony_func('echo_s_cate'); ?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php tony_func('echo_ph_cate'); ?>')  }}</em>
                    <a v-else :href="post.post_categories[0].link" v-html="post.post_categories[0].name" class="img-cate"></a>
                    <a :href="post.link" style="text-decoration: none;">
                        <h5 v-html="post.title.rendered" style="margin: 0px;padding: 0px;margin-top:15px"></h5>
                    </a>
                    <p v-html="post.post_excerpt.four" :id="post.id"></p>
                    <div class="article-list-footer">
                        <?php if ($a) { ?>
                            <span class="article-list-date" v-html="post.post_metas.author"></span>
                            <span class="article-list-divider">-</span>
                        <?php } ?>
                        <span class="article-list-date">{{ post.post_date }}</span>
                        <span class="article-list-divider">-</span>
                        <span v-if="post.post_metas.views !== ''" class="article-list-minutes">{{ post.post_metas.views }}&nbsp;Views</span>
                        <span v-else class="article-list-minutes">0&nbsp;Views</span>
                    </div>
                </div>
                <!-- 文章信息 -->

            </div>
        </template>
        <!-- 存在特色图像的文章 -->

    </li>
    <!-- 文章卡片 -->

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
<!-- 文章列表 -->

<!-- MarkDown 及插件引入 -->
<link rel="stylesheet" href="https://cdn.staticfile.org/KaTeX/0.11.1/katex.min.css" />
<link rel="stylesheet" href="https://static.ouorz.com/texmath.css" />
<script type="text/javascript" src="https://cdn.staticfile.org/markdown-it/10.0.0/markdown-it.min.js"></script>
<script type="text/javascript" src="https://cdn.staticfile.org/KaTeX/0.11.1/katex.min.js"></script>
<script type="text/javascript" src="https://static.ouorz.com/texmath.js"></script>
<!-- MarkDown 及插件引入 -->

<!-- REST API 请求加密引入 -->
<script src="https://cdn.staticfile.org/blueimp-md5/2.12.0/js/md5.min.js"></script>
<!-- REST API 请求加密引入 -->
<script>
    let tm = texmath.use(katex);
    // Markdown 实例化
    var md = window.markdownit({
        html: true,
        xhtmlOut: false,
        breaks: true,
        linkify: true
    }).use(tm, {
        delimiters: 'dollars',
        macros: {
            "\\RR": "\\mathbb{R}"
        }
    });

    window.index_p = <?php echo $p; ?>;
    window.index_m = '<?php if ($m) echo 'true';
                        else echo 'false'; ?>';
    window.wp_rest = '<?php echo wp_create_nonce('wp_rest'); ?>';
    window.site_url = '<?php echo site_url() ?>';

    window.cate_exclude_option = '<?php if (get_option('king_index_cate_exclude')) echo get_option('king_index_cate_exclude'); ?>';
    <?php if (get_option('king_index_cate_exclude')) { ?>
        window.cate_exclude = 'true';
    <?php } else { ?>
        window.cate_exclude = 'false';
    <?php } ?>

    window.cates_exclude_option = '<?php if (get_option('king_index_exclude')) echo get_option('king_index_exclude'); ?>';
    <?php if (get_option('king_index_exclude')) { ?>
        window.cates_exclude = 'true';
    <?php } else { ?>
        window.cates_exclude = 'false';
    <?php } ?>

    <?php if (get_option('king_preview_comment') == '开启') { ?>
        window.preview_comment_open = true;
    <?php } else { ?>
        window.preview_comment_open = false;
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