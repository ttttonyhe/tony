<?php get_header(); ?>
<?php
$category = get_the_category();
if ($category[0]) $id = $category[0]->term_id;
$name = $category[0]->cat_name;
$des = $category[0]->description;
if (empty($des)) $des = '无描述的分类';
if (!get_option('king_fre_cate')) $f = '99999';
else $f = get_option('king_fre_cate');
if (!get_option('king_wor_cate')) $w = '66666';
else $w = get_option('king_wor_cate');
if (!get_option('king_per_page')) $p = '6';
else $p = get_option('king_per_page');
if (get_option('king_display_author') == '关闭') $a = false;
else $a = true;
?>

<div id="header_info">
    <nav class="header-nav reveal">

        <a class="top1 header-logo" style="text-decoration:none;" href="<?php echo site_url() ?>">XXXXX</a>
        <p class="top2 lead archive-p">XXXXXXXXXXXXXXXXXXXXXXXXXXX</p>

        <div class="btn-group" style="float: right;margin-top: -65px;">
            <button type="button" class="btn btn-primary"><a href="<?php echo site_url() ?>" style="text-decoration:none;color:white"><i class="czs-hand-slide" style="margin-right:5px"></i>回到首页</a></button>
        </div>
    </nav>
    <div class="index-cates">
        <?php
        if (get_option('king_nav_display_top')) {
            $array_menu = wp_get_nav_menu_items(get_option('king_nav_display_top'));
            $menu = array();
            foreach ($array_menu as $m) {
                if (empty($m->menu_item_parent)) {
                    ?>
                    <li class="cat-item cat-item-4 cat-real"> <a href="<?php echo $m->url ?>"><?php echo $m->title ?></a>
                    </li>
            <?php }
                }
            } else { ?>
            <li class="cat-item cat-item-4 cat-real" style="display:none" v-for="de in des" v-if="de.count !== 0"> <a :href="de.link" :title="de.description" v-html="de.name"></a>
            </li>
            <li class="cat-item cat-item-4 loading-line" style="display: inline-block;width: 98%;height: 35px;box-shadow: none;border-radius: 0px;background: rgb(236, 237, 239);" v-if="loading_des"></li>
        <?php } ?>
    </div>
</div>














<ul class="article-list" style="opacity:0">

    <li v-if="loading" class="article-list-item reveal index-post-list uk-scrollspy-inview loading-line"><em class="article-list-type1" style="padding: 5.5px 45px;">&nbsp;</em> <a style="text-decoration: none;">
            <h5 style="background: rgb(236, 237, 238);">&nbsp;</h5>
        </a>
        <p style="background: rgb(246, 247, 248);width: 90%;">&nbsp;</p>
        <p style="background: rgb(246, 247, 248);width: 60%;">&nbsp;</p>
    </li>
    <!-- 占位DIV -->

    <li :class="'article-list-item reveal index-post-list ' + (post.sticky ? 'sticky-one' : '')" v-for="post in posts" :style="post.post_categories[0].term_id | link_style">

        <template v-if="post.post_img.url == false || post.post_categories[0].term_id == <?php echo $f; ?> || post.post_categories[0].term_id == <?php echo $w; ?>">
            <em v-if="post.post_categories[0].term_id == <?php tony_func('echo_s_cate'); ?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php tony_func('echo_ph_cate'); ?>')  }}</em>
            <div v-if="post.post_categories[0].term_id == <?php echo $f; ?> || post.post_categories[0].term_id == <?php echo $w; ?>" class="link-list-left"><img :src="post.post_metas.img[0]" class="link-list-img"></div>
            <div class="link-list-right" :style="(post.post_categories[0].term_id == <?php echo $f; ?> || post.post_categories[0].term_id == <?php echo $w; ?> || post.post_categories[0].term_id == <?php tony_func('echo_s_cate'); ?>) ? '' : 'margin-top: -10px;'">
                <a v-if="post.post_categories[0].term_id == <?php echo $f; ?> || post.post_categories[0].term_id == <?php echo $w; ?>" :href="post.post_metas.link" style="text-decoration: none;" target="_blank">
                    <h5 style="margin-top: 10px;" v-html="post.title.rendered"></h5>
                </a>
                <a v-else :href="post.link" style="text-decoration: none;">
                    <h5 v-html="post.title.rendered"></h5>
                </a>
                <p v-html="post.post_excerpt.nine"></p>
                <div class="article-list-footer">
                <?php if($a){ ?>
                 <span class="article-list-date display-author" v-html="post.post_metas.author"></span>
                 <span class="article-list-divider">-</span>
                 <?php } ?>
                    <span class="article-list-date">{{ post.post_categories[0].term_id | link_page }}{{ post.post_date }}</span>
                    <span class="article-list-divider" v-if="post.post_categories[0].term_id !== <?php echo $f; ?> && post.post_categories[0].term_id !== <?php echo $w; ?>">-</span>
                    <span class="article-list-minutes" v-if="post.post_categories[0].term_id !== <?php echo $f; ?> && post.post_categories[0].term_id !== <?php echo $w; ?>">{{ post.post_metas.views }}&nbsp;Views</span>
                </div>
            </div>
        </template>

        <template v-else>
            <div class="article-list-img-else">
                <div class="article-list-img" :style="'background-image:url(' + post.post_img.url +')'"></div>
                <div class="article-list-img-right">
                <!-- 置顶文章提示 -->
                <em class="article-list-type1 sticky-one-tag" v-if="post.sticky"><i class="czs-arrow-up-l" style="font-size: 14px;font-weight: 600;"></i> 置顶</em>
                <!-- 置顶文章提示 -->
                    <em v-if="post.post_categories[0].term_id === <?php tony_func('echo_s_cate'); ?>" class="article-list-type1">{{ post.post_categories[0].name + ' | ' + (post.post_metas.tag_name ? post.post_metas.tag_name.toUpperCase() : '<?php tony_func('echo_ph_cate'); ?>')  }}</em>
                    <a :href="post.link" style="text-decoration: none;">
                        <h5 v-html="post.title.rendered" style="margin: 0px;padding: 0px;margin-top:15px"></h5>
                    </a>
                    <p v-html="post.post_excerpt.four" :id="post.id"></p>
                    <div class="article-list-footer">
                    <?php if($a){ ?>
                 <span class="article-list-date display-author" v-html="post.post_metas.author"></span>
                 <span class="article-list-divider">-</span>
                 <?php } ?>
                        <span class="article-list-date">{{ post.post_date }}</span>
                        <span class="article-list-divider">-</span>
                        <span v-if="post.post_metas.views !== ''" class="article-list-minutes">{{ post.post_metas.views }}&nbsp;Views</span>
                        <span v-else class="article-list-minutes">0&nbsp;Views</span>
                    </div>
                </div>
            </div>
        </template>


    </li>

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





<script>
    window.cate_id = <?php echo $id; ?>;
    window.site_url = '<?php echo site_url() ?>';
    window.cate_name = '<?php echo $name; ?>';
    window.cate_des = '<?php echo $des; ?>';

    window.cate_exclude_option = '<?php if (get_option('king_index_cate_exclude')) echo get_option('king_index_cate_exclude'); ?>';
    <?php if (get_option('king_index_cate_exclude')) { ?>
        window.cate_exclude = 'true';
    <?php } else { ?>
        window.cate_exclude = 'false';
    <?php } ?>

    window.index_p = <?php echo $p; ?>;

    window.cate_fre = <?php if (get_option('king_fre_cate')) echo get_option('king_fre_cate');
                        else echo '0' ?>;
    window.cate_wor = <?php if (get_option('king_wor_cate')) echo get_option('king_wor_cate');
                        else echo '0' ?>;
</script>

<script type="text/javascript" src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/js/archive.js"></script>

























<?php get_footer(); ?>