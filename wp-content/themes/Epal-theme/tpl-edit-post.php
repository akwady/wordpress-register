<?php
/*
 Template Name: Edit Post Page
 */

get_header();
?>

<section id="edit-post-page">
    <div class="container">
        <div class="row">
            <div class="vnkings_form col-md-12">
                <?php if(is_user_logged_in()) { ?>
                    <?php
                    $idvnkings = addslashes( $_GET['id'] );
                    $post_tags = wp_get_post_tags($idvnkings); $tagsarray = array();
                    $vnstatus2 = get_post_status($idvnkings);
                    foreach ($post_tags as $tag) {
                        $tagsarray[] = $tag->name;
                    }
                    $tagslist = implode( ', ', $tagsarray );
                    ?>
                    <?php
                    $current_user = wp_get_current_user(); $userid = $current_user->ID; $curpost = get_post( $idvnkings );
                    $userlevel = $current_user->user_level;
                    $lovenduser = $curpost->post_author;
                    if ($userid == $lovenduser || $userlevel > 2 ) { ?>
                        <?php if( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['add_new_post'] ) && current_user_can('level_0') && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )) {
                            if (isset($_POST['post_title'])) {
                                $post_title = $_POST['post_title'];
                            }
                            if (isset($_POST['post_content'])) {
                                $post_content = $_POST['post_content'];
                            }
                            else {
                                echo 'Please enter the content';
                            }
                            if (isset ($_POST['post_category'])) {
                                $post_category = $_POST['post_category'];
                            } else {
                                $post_category = 1;
                            }
                            if (isset($_POST['post_tags'])) {
                                $post_tags = $_POST['post_tags'];
                            }

                            $post = array(
                                'ID' => $idvnkings,
                                'post_title'    => wp_strip_all_tags($post_title),
                                'post_content'  => $post_content,
                                'post_category' => array($post_category),
                                'tags_input'    => $post_tags,
                                'post_type' => 'post',
                                'post_status'   => $vnstatus2,
                            );
                            $lovendpost_id_edit = wp_insert_post($post);

                            if ($_FILES['file']['name'] == "") {
                            } else {
                                foreach ($_FILES as $file => $array) {
                                    $newupload = insert_attachment($file,$lovendpost_id_edit);
                                }
                            }
                            echo '<div class="alert alert-success"><strong>Sửa bài Thành Công!</strong> <a href="'. get_permalink($idvnkings). '"> Xem Bài!</a></div>';
                        } ?>
                        <div id="postBox">
                            <form id="new_post" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <div class="form-group vnking_pd col-sm-12 col-md-12">
                                    <label for="post_title">Tiêu đề</label>
                                    <input type="text" name="post_title" value="<?php echo get_the_title($idvnkings) ;?>" class="form-control" placeholder="Tiêu đề">
                                </div>

                                <div class="form-group vnking_pd col-md-12">
                                    <label for="post_content">Nội Dung</label>
                                    <?php
                                    $post = get_post( $idvnkings, OBJECT, 'edit' );
                                    $content = $post->post_content;
                                    wp_editor( $content, 'userpostcontent', array( 'textarea_name' => 'post_content' ));?>
                                </div>
                                <div class="form-group vnking_pd col-md-12">
                                    <?php
                                    $cats = get_the_category( $idvnkings);
                                    $selected = 0;
                                    if( $cats ) {
                                        $selected = $cats[0]->term_id;
                                    }
                                    ?>
                                    <label for="post_content">Danh mục</label>
                                    <?php
                                    wp_dropdown_categories( array(
                                        'orderby'    => 'title',
                                        'hide_empty' => false,
                                        'id'         => 'Posts_Picture_category',
                                        'class'      => 'form-control',
                                        'name' =>      'post_category',
                                        'selected'   => $selected
                                    ) );
                                    ?>
                                </div>
                                <div class="form-group vnking_pd col-md-12">
                                    <label for="post_tags">Từ khóa</label>
                                    <input type="text" name="post_tags" value="<?php echo $tagslist; ?>" class="form-control" placeholder="Từ khóa">
                                </div>

                                <div style="clear:both;"></div>
                                <div class="form-group col-md-12">
                                    <?php
                                    $feat_image = wp_get_attachment_url( get_post_thumbnail_id($idvnkings) );
                                    ?>
                                    <p><img style="max-width:300px; display:block;" id="output_avatar" src="<?php echo $feat_image;?>"/></p>

                                    <script>
                                        var loadFile = function(event) {
                                            var output = document.getElementById('output_avatar');
                                            output.src = URL.createObjectURL(event.target.files[0]);
                                            $('#output_avatar').addClass('active-avatar');
                                        };
                                    </script>
                                    <span class="btn btn-default btn-file">Hình ảnh bài viết <input class="input-file" accept="image/*" name="file" type="file" class="file" onchange="loadFile(event)">
                    </span>
                                </div>
                                <input type="hidden" name="add_new_post" value="post" />
                                <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
                                <div class="form-group col-md-12">
                                    <div class="col-sm-12" style="padding-left:0;">
                                        <button type="submit" class="btn btn-primary">Sửa Bài</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-warning"><strong>Bạn</strong> không có quyền Sửa bài viết này!</div>
                    <?php }?>
                <?php } else { ?>
                    <div class="formdangnhap">
                        <div class="alert alert-warning"><strong>Bạn</strong> cần đăng nhập để sửa bài!</div>
                        <?php wp_login_form(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>


<?php get_footer() ?>