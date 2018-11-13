<?php
//Khai Báo 1 Template
/**
 * Template Name: Home
 */

//      Hàm Lấy File header.php
get_header();

//      Hàm Lấy Các File Trong Folder sections
get_template_part('sections/top-header');
?>

<?php while (have_posts()) : the_post() ?>
    <?php the_content() ?>

<?php endwhile; ?>

<?php
//      Hàm Lấy File footer.php
get_footer();
?>
