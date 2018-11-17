<?php
// Redirect khi đăng nhập
function my_login_redirect($redirect_to, $request, $user)
{
    //is there a user to check?
    global $user;
    if (isset($user->roles) && is_array($user->roles)) {
        //check for admins
        if (in_array('administrator', $user->roles)) {
            // redirect them to the default place
            return home_url() . '/wp-admin';
        } else {
            return home_url();
        }
    } else {
        return $redirect_to;
    }
}

add_filter('login_redirect', 'my_login_redirect', 10, 3);
function redirect_login_page()
{
    $login_page = home_url('/dang-nhap/');
    $page_viewed = basename($_SERVER['REQUEST_URI']);
    if ($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
}

add_action('init', 'redirect_login_page');
// Kết thúc Redirect khi đăng nhập

// Kiểm tra lỗi đăng nhập
function login_failed()
{
    $login_page = home_url('/dang-nhap/');
    wp_redirect($login_page . '?login=failed');
    exit;
}

add_action('wp_login_failed', 'login_failed');
function verify_username_password($user, $username, $password)
{
    $login_page = home_url('/dang-nhap/');
    if ($username == "" || $password == "") {
        wp_redirect($login_page . "?login=empty");
        exit;
    }
}

add_filter('authenticate', 'verify_username_password', 1, 3);



function add_fields_user($profile_fields){
    $profile_fields['googleplus'] = 'Google+';
    $profile_fields['phone'] = 'Số Điện Thoại';
    $profile_fields['facebook'] = 'Facebook profile URL';
    return $profile_fields;
}
add_filter('user_contactmethods', 'add_fields_user');



function my_custom_scripts(){
    wp_enqueue_media();
    wp_enqueue_script('my-custom-jquery', get_stylesheet_directory_uri().'/uploadavatar/auploadavatar.js', array('jquery'), false, true );
}
add_action('admin_enqueue_scripts', 'my_custom_scripts');

add_action('admin_enqueue_scripts', 'my_custom_scripts');
function vnkings_profile_fields( $user ) {
    $profile_pic = ($user!=='add-new-user') ? get_user_meta($user->ID, 'vnkingspic', true): false;
    if( !empty($profile_pic) ){
        $image = wp_get_attachment_image_src( $profile_pic, 'medium' );
    } ?>
    <fieldset>
        <legend><?php _e('Ảnh đại diện', 'vnkings') ?></legend>
        <table class="form-table fh-profile-upload-options wpuf-table">
            <tr>
                <th><label for="uploadnd">Hình ảnh đại diện của bạn</label></th>
                <td class="wp-core-ui nd">
                    <input type="button" data-id="vnkings_image_id" data-src="vnkings-img" class="button vnkings-image" name="vnkings_image" id="vnkings-image" value="Upload" />
                    <input type="hidden" class="button" name="vnkings_image_id" id="vnkings_image_id" value="<?php echo !empty($profile_pic) ? $profile_pic : ''; ?>" />
                    <img id="vnkings-img" src="<?php echo !empty($profile_pic) ? $image[0] : ''; ?>" style="<?php echo  empty($profile_pic) ? 'display:none;' :'' ?> width: 200px; height: auto; border:1px solid cadetblue;padding:2px;" />
                </td>
            </tr>
        </table>
    </fieldset>
    <?php
}
add_action( 'show_user_profile', 'vnkings_profile_fields' );
add_action( 'edit_user_profile', 'vnkings_profile_fields' );
add_action( 'user_new_form', 'vnkings_profile_fields' );
function vnkings_profile_update($user_id){

    if( current_user_can('administrator') || current_user_can('editor') || current_user_can('author') || current_user_can('subscriber') || current_user_can('contributor') ){
        $profile_pic = empty($_POST['vnkings_image_id']) ? '' : $_POST['vnkings_image_id'];
        update_user_meta($user_id, 'vnkingspic', $profile_pic);
    }
}
add_action('profile_update', 'vnkings_profile_update');
add_action('user_register', 'vnkings_profile_update');

add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );
function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;

    if ( is_numeric( $id_or_email ) ) {
        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }
    if($user){
        $custom_avatar  =   get_user_meta( $user->data->ID, 'vnkingspic', true );

        if( !empty($custom_avatar) ){

            $image  =   wp_get_attachment_image_src($custom_avatar, 'medium');
            if( $image ){
                $safe_alt = esc_attr($alt);
                $avatar = "<img alt='{$safe_alt}' src='{$image[0]}' class='avatar photo' height='60px' width='60px' />";
            }
        }
    }
    return $avatar;
}



function insert_attachment($file_handler,$post_id,$setthumb='false') {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $attach_id = media_handle_upload( $file_handler, $post_id );

    if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
    return $attach_id;
}