<?php
error_reporting(E_ALL^E_NOTICE);


$ops = array();

$ops[] = array(
    'name' => __('附加设置'),
    'type' => 'heading'
);


    $ops[] = array(
        'name' => __('友情链接'),
        'desc' => __('仅在友情链接对应目录发表的文章可填写此字段'),
        'id' => 'link',
        'size' => array( 65 , 1),
        'type' => 'textarea',
        'ops' => '',
    );
    

/**
*   实现post-meta-box TAB
*/
class DamiMetaTab{

    var $ops;
    var $dami_value;
    
    function __construct(){
        add_action( 'add_meta_boxes', array( $this , 'dami_add_meta_box' ) );
        add_action('save_post', array($this, 'save_postdata'));
        add_action( 'admin_enqueue_scripts', array($this, 'add_script_and_styles') );
    }

    function dami_add_meta_box() {

        $screens = array( 'post' );

        foreach ( $screens as $screen ) {

            add_meta_box(
                'dami-post-meta',
                __( '文章可选扩展' ),
                array( $this , 'dami_meta_box_callback'),
                $screen,'normal','high'
            );
        }
    }

    function init($ops){
        $this->ops = $ops;
    }

    function add_script_and_styles() {
		if( is_admin() ){
        wp_enqueue_style('metabox_fields_css', get_bloginfo('template_directory') .  '/inc/metabox_fields.css');
        wp_enqueue_script('metabox_fields_js', get_bloginfo('template_directory') . '/inc/metabox_fields.js');
        }
    }

    function save_postdata() {
        if( isset( $_POST['post_type'] ) &&  (isset($_POST['save']) || isset($_POST['publish']) ) ){

            $post_id = $_POST['post_ID'];
        if (!wp_verify_nonce($_REQUEST['dami_meta_noce'], 'damimetabox')) {
            return 0;
        }

        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id  ) )
                return 0;
            }else{
                if ( !current_user_can( 'edit_post', $post_id  ) )
                    return 0;
        }


    foreach ($this->ops as $dami_meta) {

        if( $dami_meta['type'] == 'tinymce' ){
            $data =  stripslashes( $_POST[$dami_meta['id']] );
        }elseif( $dami_meta['type'] == 'checkbox' ){
            $data =  $_POST[$dami_meta['id']];
        }elseif( $dami_meta['type'] == 'numbers_array' ){
            $data = explode( ',', $_POST[$dami_meta['id']] );
        }else{
            //$data = htmlspecialchars($_POST[$dami_meta['id']], ENT_QUOTES,"UTF-8");
            $data = $_POST[$dami_meta['id']];
        }

        if(get_post_meta($post_id , $dami_meta['id']) == "")
            add_post_meta($post_id , $dami_meta['id'], $data, true);
        elseif($data != get_post_meta($post_id , $dami_meta['id'], true))
            update_post_meta($post_id , $dami_meta['id'], $data);
        elseif($data == "")
            delete_post_meta($post_id , $dami_meta['id'], get_post_meta($post_id , $dami_meta['id'], true));
            }
        }
    }


    function dami_meta_box_callback( $post ) {

        wp_nonce_field( 'damimetabox', 'dami_meta_noce' );

        foreach ($this->ops as $value) {
            
            if( $value['type'] == 'heading' ){
                $head[] = $value['name'];
            }

        }
        $i = 0;
        foreach ($this->ops as $key => $value) {

            if( $value['type'] == 'heading' ){
                $i++;
            }
            
            if( $value['type'] != 'heading' ){

                $body[$i][] = $key;

            }
        }
        echo "<div class='tab-head'>";
        $i = 1;
        foreach ($head as $value) {
            if( $i == 1 ){
                $class = "cur";
            }else{
                $class = "";
            }
            echo "<li class='".$class."'>".$value."</li>";
            $i++;
        }
        echo "<div class='clear'></div></div>";

        $c = 1;
        echo "<div class='tab-body'>";
        foreach ($body as $value) {
            if( $c == 1 ){
                $class = "one";
            }else{
                $class = "";
            }
            echo "<div class='dami_metabox ".$class."'>";
            foreach ($value as $value) {
                //echo $value;
                $meta_box_value = get_post_meta($post->ID, $this->ops[$value]['id'], true);
                $name = $this->ops[$value]['type'];

                if( $meta_box_value != '' ){
                    $this->ops[$value]['std'] = $meta_box_value;
                }
                echo "<div class='meta-box'>";
                $this->$name($this->ops[$value]);
                echo "</div>";
            }
            echo "</div>";
            $c++;
        }
        echo "</div>";

    }

    
  function title($dami_meta) {
    echo '<h2>'.$dami_meta['name'].'</h2>';
  }
  
  function text($dami_meta) {
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
    echo '<p>'.$dami_meta['desc'].'</p>';
      
    echo '<p><input type="text" size="'.$dami_meta['size'].'" value="'.$dami_meta['std'].'" id="'.$dami_meta['id'].'" name="'.$dami_meta['id'].'"/></p>';
  }
  
  function textarea($dami_meta) {
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
      echo '<p>'.$dami_meta['desc'].'</p>';
      
    echo '<p><textarea class="dami_textarea" cols="'.$dami_meta['size'][0].'" rows="'.$dami_meta['size'][1].'" id="'.$dami_meta['id'].'" name="'.$dami_meta['id'].'">'.$dami_meta['std'].'</textarea></p>';
  }
  
  function upload($dami_meta) {
      
    $button_text = (isset($dami_meta['button_text'])) ? $dami_meta['button_text'] : 'Upload';
    
    $image = '';
    
    if($dami_meta['std'] != '')
      $image = '<img src="'.$dami_meta['std'].'" />';
      
   
    
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
      echo '<p>'.$dami_meta['desc'].'</p>';
      
    echo '<input class="damiwp_url_input" type="text" id="'.$dami_meta['id'].'_input" size="'.$dami_meta['size'].'" value="'.$dami_meta['std'].'" name="'.$dami_meta['id'].'"/><a href="#" id="'.$dami_meta['id'].'" class="dami_upload_button button">'.$button_text.'</a>';
     echo '<div id="'.$dami_meta['id'].'_div" class="dami_img_preview">'.$image .'</div>';
  }
  
  function radio( $dami_meta ) {
  
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
      echo '<p>'.$dami_meta['desc'].'</p>';
      
    foreach( $dami_meta['buttons'] as $key=>$value ) {
      $checked ="";
      
      if($dami_meta['std'] == $key) {
        $checked = 'checked = "checked"';
      }
    
      echo '<label><input '.$checked.' type="radio" class="dami_radio" value="'.$key.'" name="'.$dami_meta['id'].'"/>'.$value."</label>";
    }
  }
  
  function checkbox($dami_meta) {
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
      echo '<p>'.$dami_meta['desc'].'</p>';
      
    //$values = implode( ',', $dami_meta['std'] );
    
    foreach( $dami_meta['buttons'] as $key=>$value ) {
      $checked ="";
      
      if( is_array($dami_meta['std']) && in_array($key,$dami_meta['std'])) {
        $checked = 'checked = "checked"';
      }
      
      echo '<label><input '.$checked.' type="checkbox" class="dami_checkbox" value="'.$key.'" name="'.$dami_meta['id'].'[]"/>'.$value."</label>";
    }
  }
  
  function select($dami_meta) {
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
      echo '<p>'.$dami_meta['desc'].'</p>';
      
    if($dami_meta['subtype'] == 'page'){
      $select = 'Select page';
      $entries = get_pages('title_li=&orderby=name');
    }elseif($dami_meta['subtype'] == 'category'){
      $select = 'Select category';
      $entries = get_categories('title_li=&orderby=name&hide_empty=0');
    }elseif($dami_meta['subtype'] == 'menu'){
      $select = 'Select...';
      $entries = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
    }elseif($dami_meta['subtype'] == 'sidebar'){
      global $wp_registered_sidebars;
      $select = 'Select a sidebar';
      $entries = $wp_registered_sidebars;
    }else{
      $select = 'Select...';
      $entries = $dami_meta['subtype'];
    }
    
    echo '<p><select class="postform" id="'. $dami_meta['id'] .'" name="'. $dami_meta['id'] .'"> ';
    echo '<option value="">'.$select .'</option>  ';
    
    foreach ($entries as $key => $entry){
      if($dami_meta['subtype'] == 'page'){
        $id = $entry->ID;
        $title = $entry->post_title;
      }elseif($dami_meta['subtype'] == 'category'){
        $id = $entry->term_id;
        $title = $entry->name;
      }elseif($dami_meta['subtype'] == 'menu'){
        $id = $entry->term_id;
        $title = $entry->name;
      }elseif($dami_meta['subtype'] == 'sidebar'){
        $id = $entry['id'];
        $title = $entry['name'];
      }else{
        $id = $key;
        $title = $entry;
      }
      
      if ($dami_meta['std'] == $id ){
        $selected = 'selected="selected"';
      }else{
        $selected = "";
      }
      
      echo "<option $selected value='". $id."'>". $title."</option>";
    }
    
    echo '</select></p>';
  }
  
  function numbers_array($dami_meta){
    if($dami_meta['std']!='')
      $nums = implode( ',', $dami_meta['std'] );
    
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
      echo '<p>'.$dami_meta['desc'].'</p>';
    echo '<input type="text" size="'.$dami_meta['size'].'" value="'.$nums.'" id="'.$dami_meta['id'].'" name="'.$dami_meta['id'].'"/>';
  }
  
  function tinymce($dami_meta){
    echo '<h3>'.$dami_meta['name'].'</h3>';
    if($dami_meta['desc'] != "")
      echo '<p>'.$dami_meta['desc'].'</p>';
      
    $tinymce_args = array(
      'content_css' => get_stylesheet_directory_uri() . '/css/editor-'.$dami_meta['id'].'.css'
    );
    
    if( isset($dami_meta['media']) && !$dami_meta['media'] )
      $dami_meta['media'] = 0;
    else
      $dami_meta['media'] = 1;
      
    wp_editor( $dami_meta['std'],$dami_meta['id'],$settings=array('tinymce'=>$dami_meta['media'],'media_buttons'=>1,'textarea_rows' => 8,'tinymce'=>$tinymce_args) );
  }



}


$a = new DamiMetaTab();
$a->init($ops);