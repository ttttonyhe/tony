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
        <link type="text/css" rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>">
        <link type="text/css" rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() );  ?>/css/caomei-cion.css">
        <link href="https://cdn.bootcss.com/twitter-bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdn.bootcss.com/uikit/3.0.3/css/uikit.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/uikit/3.0.3/css/uikit-rtl.min.css" rel="stylesheet">
        <script src="https://cdn.bootcss.com/uikit/3.0.3/js/uikit.min.js"></script>
        <script src="https://cdn.bootcss.com/vue/2.6.4/vue.min.js"></script>
        <script>Vue.config.devtools = true</script>
        <script src="https://cdn.bootcss.com/axios/0.19.0-beta.1/axios.min.js"></script>
        <!-- <script src="https://cdn.bootcss.com/vue-router/3.0.2/vue-router.min.js"></script> -->
        <?php echo stripslashes(get_option('king_zztj')); ?>

    </head>
        <body id="body">
            
            <header class="tony-header-fixed" id="header-div">
                <?php if(is_single()){ ?>
                <div class="header-div1">
        	<a href="<?php echo site_url() ?>" style="display: inline-block;"><img src="<?php echo get_option('king_logo') ?>"></a>
<a href="h<?php echo site_url() ?>/feed" style="display: inline-block;margin-top: 12px;margin-left: 15px;"><button type="button" class="btn btn-light" style="letter-spacing: 1px;font-weight: 500;">RSS订阅</button></a>
        </div>
                <?php }else{ ?>
        <div class="header-div1-1">
        	<a href="<?php echo site_url() ?>"><img src="<?php echo get_option('king_logo'); ?>"></a>
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
        <main role="main">
            <div class="grid grid-centered" style="<?php if(!is_single() && !is_page()) echo 'max-width: 660px;padding: 0px 20px;margin-top: 80px;'; ?>">
                <div class="grid-cell" id="grid-cell">