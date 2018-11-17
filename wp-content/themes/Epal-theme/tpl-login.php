<?php
/**
 * Template Name: Login Page
 */

get_header();
?>

<section id="login-page">
    <div class="container">
        <div class="row">
            <?php if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                $current_user = wp_get_current_user();
                $profile_url = get_author_posts_url($user_id);
                $edit_profile_url = get_edit_profile_url($user_id); ?>
                <div class="regted">
                    Bạn đã đăng nhập với tên nick <a
                            href="<?php echo $profile_url ?>"><?php echo $current_user->display_name; ?></a> Bạn có muốn
                    <a href="<?php echo esc_url(wp_logout_url('dang-nhap')); ?>">Thoát</a> không ?
                </div>
            <?php } else { ?>
                <div class="loginForm">
                    <?php
                    $login = (isset($_GET['login'])) ? $_GET['login'] : 0;
                    if ($login === "failed") {
                        echo '<p><strong>Lỗi:</strong> Sai username hoặc mật khẩu.</p>';
                    } elseif ($login === "empty") {
                        echo '<p><strong>Lỗi:</strong> Username và mật khẩu không thể bỏ trống.</p>';
                    } elseif ($login === "false") {
                        echo '<p><strong>Lỗi:</strong> Bạn đã thoát ra.</p>';
                    }
                    ?>
                    <?php wp_login_form(); ?>
                    <a href="<?php echo home_url('quen-mat-khau') ?>" title="Bạn quên mất mật khẩu">Bạn quên mất mật khẩu</a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>


<?php get_footer() ?>
