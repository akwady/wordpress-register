<?php

/**
 * Template Name: Author Page
 */

get_header();

?>
    <section id="author-page">
        <div class="container">
            <div class="row">
                <?php if(is_user_logged_in()) { if($user_id == $author_id) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="font-size:21px;">Thông tin thành viên</h1>
                        </div>
                        <div class="panel-body">
                            <?php
                            $user_id = get_current_user_id();
                            $author_user = get_user_by('slug', get_query_var('author_name'));
                            $author_id = $author_user->ID;
                            $current_user = wp_get_current_user();
                            if ($user_id == $author_id) { ?>
                                <?php

                                if (isset($_POST['user_profile_nonce_field']) && wp_verify_nonce($_POST['user_profile_nonce_field'], 'user_profile_nonce')) {
                                    if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
                                        if ($_POST['pass1'] == $_POST['pass2'])
                                            wp_update_user(array('ID' => $current_user->ID, 'user_pass' => esc_attr($_POST['pass1'])));
                                        else
                                            echo $error[] = __('Mật khẩu của bạn không được cập nhật', 'profile');
                                    }
                                    /* Update thông tin user. */
                                    if (!empty($_POST['user_url'])) {
                                        wp_update_user(array('ID' => $current_user->ID, 'user_url' => esc_url($_POST['user_url'])));
                                    }
                                    if (!empty($_POST['nickname'])) {
                                        update_user_meta($current_user->ID, 'nickname', esc_attr($_POST['nickname']));
                                    }
                                    if (!empty($_POST['phone'])) {
                                        update_user_meta($current_user->ID, 'phone', esc_attr($_POST['phone']));
                                    }
                                    if (!empty($_POST['googleplus'])) {
                                        update_user_meta($current_user->ID, 'googleplus', esc_attr($_POST['googleplus']));
                                    }
                                    if (!empty($_POST['facebook'])) {
                                        update_user_meta($current_user->ID, 'facebook', esc_attr($_POST['facebook']));
                                    }
                                    if (!empty($_POST['description'])) {
                                        update_user_meta($current_user->ID, 'description', esc_attr($_POST['description']));
                                    }
                                    echo '<div class="alert alert-success"><strong>Bạn đã sửa thông tin cá nhân thành công!</strong></div>';
                                }
                                ?>

                                <form role="form" action="" id="user_profile" method="POST">
                                    <?php wp_nonce_field('user_profile_nonce', 'user_profile_nonce_field'); ?>
                                    <div class="form-group col-md-6">
                                        <label for="nickname">Họ Tên</label>
                                        <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Họ Tên" value="<?php the_author_meta('nickname', $author_id); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php the_author_meta('user_email', $author_id); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter">Số Điện Thoại</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại của bạn" value="<?php the_author_meta('phone', $author_id); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="user_url">Website</label>
                                        <input type="text" class="form-control" id="user_url" name="user_url" placeholder="Website của bạn" value="<?php the_author_meta('user_url', $author_id); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="facebook">Facebook</label>
                                        <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook của bạn" value="<?php the_author_meta('facebook', $author_id); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="googleplus">Google Plus</label>
                                        <input type="text" class="form-control" id="googleplus" name="googleplus" placeholder="Google Plus của bạn" value="<?php the_author_meta('googleplus', $author_id); ?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="description">Mô tả về bạn</label>
                                        <textarea class="form-control" name="description" id="description" rows="3" cols="50"><?php the_author_meta('description', $author_id); ?></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pass1">Password</label>
                                        <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pass2">Nhập lại Password</label>
                                        <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Password">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-success">Cập nhật</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <div class="col-md-4">
                                    <a href="<?php echo get_author_posts_url($author_id); ?>">
                                        <?php $user_ID = get_current_user_id(); $avatar = get_user_meta( $user_ID,  'vnkingspic', true); $avatar_image =wp_get_attachment_image_src($avatar, 'medium'); ?>
                                        <?php if (!empty($avatar_image)) { ?>
                                            <?php $user_ID = get_current_user_id(); $avatar = get_user_meta( $user_ID,  'vnkingspic', true); $avatar_image =wp_get_attachment_image_src($avatar, 'medium'); ?>
                                            <img src="<?php echo $avatar_image[0]; ?>">
                                        <?php } else { ?>
                                            <?php $user_ID = get_current_user_id(); $avatar = get_user_meta( $user_ID,  'vnkingspic', true); $avatar_image =wp_get_attachment_image_src($avatar, 'medium'); ?>
                                            <img src="12312312" alt="123123">
                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="info_author col-md-8">
                                    <ul class="list-group vnk_label">
                                        <li class="list-group-item">
                                            <label for="nickname">Họ Tên:</label>
                                            <?php the_author_meta('nickname', $current_user->ID); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="nickname">Email:</label>
                                            <?php the_author_meta('user_email', $current_user->ID); ?>
                                        </li>
                                        <li class="list-group-item"><label for="user_url">Website:</label>
                                            <a rel="nofollow"
                                               href="<?php the_author_meta('user_url', $current_user->ID); ?>">
                                                <?php the_author_meta('user_url', $current_user->ID); ?>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="user_url">Facebook:</label>
                                            <a rel="nofollow"
                                               href="<?php the_author_meta('facebook', $current_user->ID); ?>">
                                                <?php the_author_meta('facebook', $current_user->ID); ?>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="user_url">Google+:</label>
                                            <a rel="nofollow"
                                               href="<?php the_author_meta('googleplus', $current_user->ID); ?>">
                                                <?php the_author_meta('googleplus', $current_user->ID); ?>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="nickname">Số điện thoại: </label>
                                            <?php the_author_meta('phone', $current_user->ID); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <label for="description">Chia sẻ về tôi</label>
                                            : <?php the_author_meta('description', $current_user->ID); ?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <div class="button-edit-profile button-register">
                                        <a class="btn btn-success" href="<?php echo get_the_author_link() . $current_user->user_login ?>">Chỉnh sửa Thông tin</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php }}else{ ?>
                    <p>Vui lòng <a href="<?php echo home_url('dang-nhap') ?>">đăng nhập</a> để thấy thông tin cá nhân !</p>
                <?php } ?>
            </div>
        </div>
    </section>

<?php get_footer(); ?>