<?php
require get_template_directory() . '/inc/setting.php';   //setting
require get_template_directory() . '/inc/views.php';   //views
require get_template_directory() . '/inc/rewrite.php';   //页面伪静态
require get_template_directory() . '/inc/metabox.php'; //文章meta

//获取评论人数 by wpdaxue
function get_comments_users($postid=0,$which=0) {
	$comments = get_comments('status=approve&type=comment&post_id='.$postid); //获取文章的所有评论
	if ($comments) {
		$i=0; $j=0; $commentusers=array();
		foreach ($comments as $comment) {
			++$i;
			if ($i==1) { $commentusers[] = $comment->comment_author_email; ++$j; }
			if ( !in_array($comment->comment_author_email, $commentusers) ) {
				$commentusers[] = $comment->comment_author_email;
				++$j;
			}
		}
		$output = array($j,$i);
		$which = ($which == 0) ? 0 : 1;
		return $output[$which]; //返回评论人数
	}
	return 0; //没有评论返回0
}

//自动获取关键字 by suxing
function deel_keywords() {
  global $s, $post;//声明$post全局变量
  $keywords = '';
  if ( is_single() ) {
    //if ( get_the_tags( $post->ID ) ) {
      //foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
    //}<br>    //如果文章有标签，关键词为标签
    $category = get_the_category();
    $parent = get_cat_name($category[0]->category_parent);
    //echo $parent;//得到父级分类名称
    foreach ( get_the_category( $post->ID ) as $category ) $keywords .=$parent.','. $category->cat_name . ', '.get_the_title();
//关键词为父级分类名称，分类名称，文章标题
//下面判断条件为不同模板
    $keywords = substr_replace( $keywords , '' , -2);
  }
  if ( $keywords ) {
    echo "<meta name=\"keywords\" content=\"$keywords\">\n";
  }
}
//关键字加入head头部代码
add_action('wp_head','deel_keywords');

//文章内时间以ago显示 by someone
function lb_time_since( $older_date, $comment_date = false ) {
	$chunks = array(
		array( 24 * 60 * 60,' 天前' ),
		array( 60 * 60, ' 小时前'),
		array( 60, ' 分钟前' ),
		array( 1,' 秒前')
	);
	$newer_date = time();
	$since      = abs( $newer_date - $older_date );
	if ( $since < 30 * 24 * 60 * 60 ) {
		for ( $i = 0, $j = count( $chunks ); $i < $j; $i ++ ) {
			$seconds = $chunks[ $i ][0];
			$name    = $chunks[ $i ][1];
			if ( ( $count = floor( $since / $seconds ) ) != 0 ) {
				break;
			}
		}
		$output = $count . $name;
	} else {
		$output = $comment_date ? date( 'y-m-d', $older_date ) : date( 'Y-m-d', $older_date );
	}

	return $output;
}

//后台提示信息
function remove_footer_admin () {
    echo 'Theme <b style="letter-spacing:1px;">Tony</b> | Designed with <img draggable="false" class="emoji" alt="love" src="https://s.w.org/images/core/emoji/11/svg/2764.svg"> by <a href="https://www.ouorz.com" target="_blank">TonyHe</a> | 当前 <a href="https://github.com/HelipengTony/tony/releases" target="_blank">'.wp_get_theme()->get( 'Version' ).'</a> 版本</p>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// 评论添加@ by someone
function comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '<span class="comment-at">@'.get_comment_author( $comment->comment_parent ) . '</span>' . $comment_text;
  }
  return $comment_text;
}
add_filter( 'comment_text' , 'comment_add_at', 20, 2);

//插入文章内链 by suxing
//添加按钮
add_action('media_buttons_context', 'mee_insert_post_custom_button');
function mee_insert_post_custom_button($_var)
{
	$_var .= '<button type="button" id="insert-media-button" class="button insert-post-embed" data-editor="content"><span class="dashicons dashicons-pressthis"></span>插入文章</button><div class="smilies-wrap"></div><script>jQuery(document).ready(function(){jQuery(document).on("click", ".insert-post-embed",function(){var post_id=prompt("输入文章ID，多个文章，使用英文逗号隔开","");if (post_id!=null && post_id!=""){send_to_editor("[fa_insert_post ids="+ post_id +"]");}return false;});});</script>';
	return $_var;
}
//插入文章
function fa_insert_posts( $atts, $content = null ){
extract( shortcode_atts( array(
'ids' => ''
),
$atts ) );
global $post;
$content = '';
$postids =  explode(',', $ids);
$inset_posts = get_posts(array('post__in'=>$postids));
foreach ($inset_posts as $key => $post) {
setup_postdata( $post );
$content .=  '<div class="warp-post-embed"><a style="text-decoration: none;" href="' . get_permalink() . '" target="_blank" ><div class="embed-content"><h2>'.get_the_title().'</h2><p>'. wp_trim_words(get_the_excerpt(), 30 ) .'</p></div></a></div>';
}
wp_reset_postdata();
return $content;
}
add_shortcode('fa_insert_post', 'fa_insert_posts');


//去除抖动
function wps_login_error()
{
remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'wps_login_error');

//错误信息
function failed_login() {
    return '密码不正确';
}
add_filter('login_errors', 'failed_login');

//防止黑客
//去除版本信息
function remove_version() {
return '';
}
add_filter('the_generator', 'remove_version');

//去除评论隐患
function lxtx_comment_body_class($content){
    $pattern = "/(.*?)([^>]*)author-([^>]*)(.*?)/i";
    $replacement = '$1$4';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
add_filter('comment_class', 'lxtx_comment_body_class');
add_filter('body_class', 'lxtx_comment_body_class');


function get_tag_post_count_by_id( $tag_id ) {
    $tag = get_term_by( 'id', $tag_id, 'post_tag' );
    _make_cat_compat( $tag );
    return $tag->count;
}

//add post thumbnails
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}

//根据上传时间重命名文件
add_filter('wp_handle_upload_prefilter', 'custom_upload_filter' );
    function custom_upload_filter( $file ){
        $info = pathinfo($file['name']);
        $ext = $info['extension'];
        $filedate = date('YmdHis').rand(10,99);//为了避免时间重复，再加一段2位的随机数
        $file['name'] = $filedate.'.'.$ext;
        return $file;
    }


add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}





/* rest-api */
add_action( 'rest_api_init', 'wp_rest_insert_tag_links' );

function wp_rest_insert_tag_links(){

    register_rest_field( 'post',
        'post_categories',
        array(
            'get_callback'    => 'wp_rest_get_categories_links',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'post',
        'post_excerpt',
        array(
            'get_callback'    => 'wp_rest_get_plain_excerpt',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'post',
        'post_date',
        array(
            'get_callback'    => 'wp_rest_get_normal_date',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'page',
        'post_date',
        array(
            'get_callback'    => 'wp_rest_get_normal_date',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field( 'post', 
        'post_metas', 
        array(
            'get_callback' => 'get_post_meta_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field( 'page', 
        'post_metas', 
        array(
            'get_callback' => 'get_post_meta_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field( 'post', 
        'post_img', 
        array(
            'get_callback' => 'get_post_img_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field( 'post', 
        'post_tags', 
        array(
            'get_callback' => 'get_post_tags_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
    register_rest_field( 'post', 
        'post_prenext', 
        array(
            'get_callback' => 'get_post_prenext_for_api',
            'update_callback' => null,
            'schema' => null,
        )
    );
}

function wp_rest_get_categories_links($post){
    $post_categories = array();
    $categories = wp_get_post_terms( $post['id'], 'category', array('fields'=>'all') );

foreach ($categories as $term) {
    $term_link = get_term_link($term);
    if ( is_wp_error( $term_link ) ) {
        continue;
    }
    $post_categories[] = array('term_id'=>$term->term_id, 'name'=>$term->name, 'link'=>$term_link);
}
    return $post_categories;

}
function wp_rest_get_plain_excerpt($post){
    $excerpts = array();
    $excerpts['nine'] = wp_trim_words(get_the_excerpt($post['id']), 90);
    $excerpts['four'] = wp_trim_words(get_the_excerpt($post['id']), 45);
    return $excerpts;
}

function wp_rest_get_normal_date($post){
    if(get_option('king_date_format')) 
    $format = get_option('king_date_format');
    else $format = 'd-m-y';
    $date = get_the_date( $format,$post['id']);
    return $date;
}

function get_post_meta_for_api($post){
    $post_meta = array();
    $post_meta['views'] = get_post_meta($post['id'],'post_views_count',true);
    $post_meta['link'] = get_post_meta($post['id'],'link',true);
    $post_meta['img'] = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
    $post_meta['title'] = get_the_title($post['id']);
    $tagsss = get_the_tags($post['id']);
    $post_meta['tag_name'] = $tagsss[0]->name;
    return $post_meta;
}

function get_post_img_for_api($post){
    $post_img = array();
    $post_img['url'] = get_the_post_thumbnail_url($post['id']);
    return $post_img;
}
/* rest-api */

//获取全部分类
function admin_show_category() {
    global $wpdb;
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request .= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    echo "<h3>全部分类及ID</h4><ul style='height:50px'>";
    foreach ($categorys as $category) {
        echo  '<li style="margin-right: 10px;float:left;">'.$category->name."（<code>".$category->term_id.'</code>）</li>';
    }
    echo "</ul>";
}


//设置站点title
function site_page_title(){
    if ( is_home() ) {
		bloginfo('name'); echo " - "; bloginfo('description');
	} elseif ( is_category() ) {
		single_cat_title(); echo " - "; bloginfo('name');
	} elseif (is_single() || is_page() ) {
		single_post_title();
	} elseif (is_search() ) {
		echo "搜索结果"; echo " - "; bloginfo('name');
	} elseif (is_404() ) {
		echo '没有找到页面';
	} else {
		wp_title('',true);
	}
}

//默认头像
add_filter( 'avatar_defaults', 'newgravatar' );  
 
function newgravatar($avatar_defaults) {  
    $myavatar = 'https://i.loli.net/2019/03/10/5c84adf73a7a2.jpg';  
    $avatar_defaults[$myavatar] = "Tony主题默认头像";
    return $avatar_defaults;  
}

//标题描述
function get_tony_ms(){
    if(get_option('king_ms') && !get_option('king_title_ms')){
        echo get_option('king_ms');
    }elseif(get_option('king_title_ms')){
        echo get_option('king_title_ms'); 
    }else{
        echo '未设置描述';
    }
}

//获取文章标签
function get_post_tags_for_api($post){
    $tag_term = array();
    $tags = wp_get_post_tags($post['id']);
    $i = 0;
    foreach($tags as $tag){
        $tag_term[$i]['url'] = get_tag_link($tag->term_id);
        $tag_term[$i]['name'] = $tag->name;
        $i++;
    }
    return $tag_term;
}

//获取上下篇文章
function get_post_prenext_for_api($post){
    $array = array();
    $prev_post = get_previous_post(false,'');
	$next_post = get_next_post(false,'');
	$array['prev'][0] = $prev_post->guid;
	$array['prev'][1] = $prev_post->post_title;
	$array['prev'][2] = wp_get_post_categories($prev_post->ID)[0];
	$array['next'][0] = $next_post->guid;
	$array['next'][1] = $next_post->post_title;
	$array['next'][2] = wp_get_post_categories($next_post->ID)[0];
	return $array;
}
