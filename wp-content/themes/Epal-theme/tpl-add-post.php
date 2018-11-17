<?php
/**
 * Template Name: Add Post Page
 */

get_header();
?>

<section id="add-post-page">
    <div class="container">
        <div class="row">
            <?php if(is_user_logged_in()) {
                $user_id = get_current_user_id();
                $current_user = wp_get_current_user();
                $vnkings =  $current_user->user_level;
                if($vnkings <= 2) { $vnstatus = "pending"; } else { $vnstatus = "publish"; }
                ?>

                <div id="vnkings_postBox">
                    <form id="new_post" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group vnking_pd col-sm-12 col-md-12">
                            <label for="post_title">Tiêu đề</label>
                            <input type="text" name="post_title" class="form-control" placeholder="Tiêu đề">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="post_content">Nội Dung</label>
                            <?php $post_obj = $wp_query->get_queried_object(); wp_editor( $post_obj->post_content, 'userpostcontent', array( 'textarea_name' => 'post_content' ));?>
                        </div>
                        <div class="form-group vnking_pd col-md-12">
                            <label for="post_content">Danh mục</label>
                            <?php $categories = wp_dropdown_categories("echo=0&hide_empty=0&selected=0");
                            preg_match_all('/\s*<option class="(\S*)" value="(\S*)">(.*)<\/option>\s*/', $categories, $matches, PREG_SET_ORDER);
                            echo "<select id='post_category' class='form-control' name='post_category'>";
                            foreach ($matches as $match){
                                echo "<option value='{$match[2]}'>{$match[3]}</option>";
                            }
                            echo "</select><br />\n";
                            ?>
                        </div>
                        <div class="form-group vnking_pd col-md-12">
                            <label for="post_tags">Từ khóa</label>
                            <input type="text" name="post_tags" class="form-control" placeholder="Từ khóa">
                        </div>
                        <div class="form-group col-md-12">
                            <p><img width="150" id="output_avatar"/></p>
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
                                <button type="submit" class="btn btn-primary">Đăng Bài</button>
                            </div>
                        </div>
                    </form>
                </div>
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
                    }
                    if (isset($_POST['post_tags'])) {
                        $post_tags = $_POST['post_tags'];
                    }
                    $post = array(
                        'post_title'    => wp_strip_all_tags($post_title),
                        'post_content'  => $post_content,
                        'post_category' => array($post_category),
                        'tags_input'    => $post_tags,
                        'post_status'   => $vnstatus,
                        'post_type' => 'post',
                    );
                    $vnkings_post_id = wp_insert_post($post);

                    if ($_FILES) {
                        foreach ($_FILES as $file => $array) {
                            $newupload = insert_attachment($file,$vnkings_post_id);
                        }
                    }
                    echo '<div class="alert alert-success"><strong>Bạn đã đăng bài thành công!</strong></div>';
                }?>

            <?php } else { ?>
                <div class="formdangnhap">
                    <?php wp_login_form(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>


<?php get_footer() ?>
