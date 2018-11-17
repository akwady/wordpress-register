<?php
/**
 * Template Name: Reset Password
 */

get_header();
?>


<?php
global $wpdb;

$error = '';
$success = '';

// check if we're in reset form
if (isset($_POST['action']) && 'reset' == $_POST['action']) {
    $email = trim($_POST['user_login']);

    if (empty($email)) {
        $error = 'Nhập tên người dùng hoặc địa chỉ e-mail';
    } else if (!is_email($email)) {
        $error = 'Tên người dùng hoặc địa chỉ e-mail không hợp lệ.';
    } else if (!email_exists($email)) {
        $error = 'Không có người dùng nào được đăng ký với địa chỉ email đó.';
    } else {
        $random_password = wp_generate_password(12, false);
        $user = get_user_by('email', $email);
        $update_user = wp_update_user(array(
                'ID' => $user->ID,
                'user_pass' => $random_password
            )
        );
        echo 'Lấy mật khẩu mới thành công ! vui lòng kiểm email để lấy mật khẩu.';
        // if  update user return true then lets send user an email containing the new password
        if ($update_user) {
            $to = $email;
            $subject = 'Mật khẩu mới của bạn';
            $sender = get_option('name');

            $message = 'Mật khẩu mới của bạn là:' . $random_password;

            $headers[] = 'MIME-Version: 1.0' . "\r\n";
            $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers[] = "X-Mailer: PHP \r\n";
            $headers[] = 'From: ' . $sender . ' < ' . $email . '>' . "\r\n";

            $mail = wp_mail($to, $subject, $message, $headers);
            if ($mail)
                $success = 'Kiểm tra địa chỉ email cho bạn mật khẩu mới.';
        } else {
            $error = 'Đã xảy ra sự cố khi cập nhật tài khoản của bạn.';
        }

    }

    if (!empty($error))
        echo '<div class="message"><p class="error"><strong>Lỗi:</strong> ' . $error . '</p></div>';

    if (!empty($success))
        echo '<div class="error_login"><p class="success">' . $success . '</p></div>';
}
?>


    <form method="post">
        <fieldset>
            <p>Vui lòng nhập tên người dùng hoặc địa chỉ email của bạn. Bạn sẽ nhận được một liên kết để tạo mật khẩu
                mới qua email.</p>
            <p><label for="user_login">Username or E-mail:</label>
                <?php $user_login = isset($_POST['user_login']) ? $_POST['user_login'] : ''; ?>
                <input class="input form-control" type="text" name="user_login" id="user_login"
                       value="<?php echo $user_login; ?>"/></p>
            <p>
                <input type="hidden" name="action" value="reset"/>
                <input type="submit" value="Lấy mật khẩu mới" class="btn btn-success" id="submit"/>
            </p>
        </fieldset>
    </form>


<?php get_footer() ?>