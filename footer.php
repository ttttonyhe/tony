<?php
/* 获取选项参数 */
// 侧边备案号展示
if (get_option('king_icp_display') && !!is_home() && get_option('king_icp_display_bottom') !== '开启') {
    $icpDisplay = true;
    echo '
        <div class="icp-div">
            <a href="http://beian.miit.gov.cn/" target="_blank">' . get_option('king_icp_display') . '</a>
        </div>
    ';
}
if (get_option('king_icp_display_bottom') == '开启' && !!is_home() && get_option('king_icp_display')) {
    //底部备案号展示
    $icpDisplayBottom = true;
} else {
    $icpDisplayBottom = false;
}
echo '
    <footer class="footer reveal" style="' . (wp_is_mobile() ? 'display:none;' : '') . '">
        <p>Copyright &copy; ' . date('Y') . ' ' . get_bloginfo('name') . ' · Theme Tony | Made with <i class="czs-heart tonys-love"></i> by <a href="https://www.ouorz.com" target="_blank">TonyHe</a>' . ($icpDisplayBottom ? (' | ' . get_option('king_icp_display')) : '') . '</p>
    </footer>
';
?>

<!-- 回到顶部按钮初始化 -->
<script type="text/javascript">
    $(document).ready(function() {
        $.goup({
            trigger: 100,
            bottomOffset: 30, //距底部偏移量 
            locationOffset: 30, //距右部偏移量
        });
    });
</script>
<!-- 回到顶部按钮初始化 -->

<!-- Bootstrap 资源引入 -->
<script src="https://static.ouorz.com/bootstrap.min.js"></script>
<!-- Bootstrap 资源引入 -->

<!-- 承接头部区块 -->
</div>
</div>
</main>
</body>

</html>
<!-- 承接头部区块 -->