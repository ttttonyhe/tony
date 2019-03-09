<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta charset="utf-8">
        <title><?php site_page_title(); ?></title>
	    <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link rel="dns-prefetch" href="https://cdn.bootcss.com" />
	    <meta name="keywords" content="<?php echo get_option('king_gjc');?>"/>
        <meta name="description" content="<?php echo get_option('king_ms');?>">
        <link rel="Shortcut Icon" href="<?php echo get_option('king_ico') ?>" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://static.ouorz.com/popper.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/style.css">
        <link type="text/css" rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() );  ?>/css/caomei-cion.css">
        <link href="https://cdn.bootcss.com/twitter-bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdn.bootcss.com/uikit/3.0.3/css/uikit.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/uikit/3.0.3/css/uikit-rtl.min.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/uikit/3.0.3/js/uikit.min.js"></script>
        <script src="https://cdn.bootcss.com/vue/2.6.4/vue.min.js"></script>
        <script src="https://cdn.bootcss.com/axios/0.19.0-beta.1/axios.min.js"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/jquery.goup.js"></script>
        <!-- <script src="https://cdn.bootcss.com/vue-router/3.0.2/vue-router.min.js"></script> -->
        <?php echo stripslashes(get_option('king_zztj')); ?>

    </head>
        <body id="body">
            
            <header class="tony-header-fixed" id="header-div">
                <?php if(is_single()){ ?>
                <div class="header-div1">
        	<a href="<?php echo site_url() ?>" style="display: inline-block;"><img src="<?php echo get_option('king_logo') ?>"></a>
<a href="<?php echo site_url() ?>/feed" style="display: inline-block;margin-top: 12px;margin-left: 15px;"><button type="button" class="btn btn-light" style="letter-spacing: 1px;font-weight: 500;">RSS订阅</button></a>
<a style="margin-top: 12px;margin-left: 12px;"><button onclick="open_search();" type="button" class="btn btn-light" style="letter-spacing: 1px;font-weight: 500;">博客搜索</button></a>
</div>
                <?php }else{ ?>
        <div class="header-div1-1">
        	<a href="<?php echo site_url() ?>"><img src="<?php echo get_option('king_logo'); ?>"></a>
        	<a style="margin-top: 12px;margin-left: 12px;"><button onclick="open_search();" type="button" class="btn btn-light" style="letter-spacing: 1px;font-weight: 500;">博客搜索</button></a>
        </div>
        <?php } ?>
        <div class="header-div2">
            <a href="<?php echo site_url() ?>"><button type="button" class="btn btn-light" style="letter-spacing: 1px;font-weight: 500;">首页</button></a>
            <?php if(get_option('king_nav_pu') !== ''){ ?>
                <a href="<?php echo get_option('king_nav_pu'); ?>"><button type="button" class="btn btn-light" style="letter-spacing: 1px;font-weight: 500;"><?php echo get_option('king_nav_pn'); ?></button></a>
            <?php } ?>
            <button type="button" class="btn btn-primary" style="letter-spacing: 1px;font-weight: 600;padding: 5px 15px;"><a href="<?php echo get_option('king_abt_url'); ?>" style="text-decoration:none;color:white"><i class="czs-user-l" style="margin-right:5px"></i>关于我 </a></button>
            </div>
    </header>
    
    
    <div id="view-div" class="center-info" style="display:none"><p style="font-weight: 600;font-size: 1.2rem;color: #555;" id="view-text">-&nbsp;<?php if(!is_single() && !is_page()) echo '文章列表'; else echo '博客内容'; ?>&nbsp;-</p></div>
    
    <script>
    $(window).scroll(function() {
        var to_top_header = $(document).scrollTop();
        if (to_top_header <= 0) {
            $('#header-div').attr('class','tony-header-fixed');
            $('#view-div').css('display','none');
            
            $('#header-div').hover(function(){
            $('#header-div').attr('class','tony-header-scoll');
            },function(){
            $('#header-div').attr('class','tony-header-fixed');
            })
            
        }else{
            $('#header-div').attr('class','tony-header-scoll');
            $('#view-div').css('display','block');
            
            $('#header-div').hover(function(){
            $('#header-div').attr('class','tony-header-scoll');
            },function(){
            $('#header-div').attr('class','tony-header-scoll');
            })
        }
      });
      
      var open_search = function(){
          $('#search_form').attr('class','search_form_play');
          $('.search-bg-b').attr('style','display:block');
          $('#search-div').attr('style','display:block');
      }
      var close_search = function(){
          $('#search_form').attr('class','search_form_dis');
          $('.search-bg-b').attr('style','display:none');
          $('#search-div').attr('style','display:none');
      }
      
    </script>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        <div id="jv-loadingbar"></div>
        <script type="text/javascript">
$("#jv-loadingbar").show();
$("#jv-loadingbar").animate({width:"20%"},100);
</script>
<script type="text/javascript">
$("#jv-loadingbar").animate({width:"100%"},100,function(){
$("#jv-loadingbar").fadeOut(1000,function(){$("#jv-loadingbar").css("width","0");});
});
</script>

<div id="search_form" class="search_form_dis">
<div class="search-bg-b"></div>
<div class="search-bg" id="search-div">
    <div class="search-div1">
        <h3>搜索内容<button type="button" class="btn btn-primary" style="font-weight: 600;padding: 4px 14px;font-size: .9rem;margin-top: 6px;margin-left: 10px;float: right;" onclick="close_search();">关闭</button></h3>
        <p>从博客全部内容中搜索所需</p>
        <input class="uk-input" type="text" placeholder="请输入搜索内容并回车Enter..." v-on:keyup.enter="search_query" v-model.trim="search_key">
    </div>
    <div class="search-div2">
        <ul v-if="search_loading">
            <template v-if="search_content.length !== 0">
                <li v-for="search in search_content">
                    <a :href="search.link">
                        <h4 v-html="search.title.rendered"></h4>
                        <p v-html="search.post_excerpt.four"></p>
                    </a>
                </li>
            </template>
            <template v-else>
                <li>
                    <h4 style="color:#777">无匹配文章</h4>
                    <p>请尝试更换搜索词再试试吧...</p>
                </li>
            </template>
        </ul>
        <ul v-if="loading_ph">
            <ul class="uk-animation-slide-bottom-small">
                <li class="search-line" style="padding: 30px;background: #f1f2f3;border: none;"></li>
                <li class="search-line" style="padding: 30px;background: #f1f2f3;border: none;"></li> 
                <li class="search-line" style="padding: 30px;background: #f1f2f3;border: none;"></li>
            </ul>
    </div>
</div>
</div>

<script>
    var search_vue = new Vue({
        el: '#search-div',
        data(){
            return {
                search_content : null,
                search_key : null,
                search_loading : false,
                loading_ph : true,
                search_open : false
            }
        },
        methods : {
            search_query : function(){
                this.search_loading = false;
                this.loading_ph = true;
                
                var s = this.search_key;
                axios.get('<?php echo site_url() ?>/wp-json/wp/v2/posts?search='+ s +'<?php if(get_option('king_index_exclude')) echo '&categories_exclude='.get_option('king_index_exclude'); ?>')
                 .then(response => {
                     this.search_content = response.data;
                     this.loading_ph = false;
                     this.search_loading = true;
                 })
            }
        }
    })
</script>
        <main role="main">
            <div class="grid grid-centered" style="<?php if(!is_single() && !is_page()) echo 'max-width: 660px;padding: 0px 20px;margin-top: 80px;'; ?>">
                <div class="grid-cell" id="grid-cell">