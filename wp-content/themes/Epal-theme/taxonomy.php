

<!--Code Lấy bài Viết Của Taxonomy-->
<?php
$id = get_queried_object_id(); // Hàm Lấy ID Taxonomy
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$list = new WP_Query([
    'post_type' => 'product', // Tham Số Lấy Bài Viết
    'posts_per_page' => 3,  // Giới Hạn Lấy bao Nhiêu Bài Viết
    'paged' => $paged, // Dùng Để Phân Trang
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'taxonomy', // Tên Của Chuyên Mục Taxonomy
            'field' => 'id', // Tham Số Lấy Bài ID Hoặc Slug
            'terms' => $id, // ID của categories
        )),
]);
while($list->have_posts()) : $list->the_post()
    ?>


    <?php the_post_thumbnail() //Lấy Ảnh Đại Diện Bài Viết Hàm Này Không Cần Thẻ IMG (get_the_post_thumbnail_url() hàm này cần thẻ IMG) ?>

    <?php echo get_the_title(); // lấy Tiêu Đề Của Bài Viết (có thể sài the_title()) ?>

    <?php echo get_the_excerpt() // lấy Mô Tả Của Bài Viết (có thể sài the_excerpt()) ?>

    <a href="<?php the_permalink() // Hàm Này Lấy Link Của Bài Viết  ?>"></a>

    <?php echo get_the_date() // Lấy Ngày Tháng Đăng Bài Của Bài Viết ?>

    <?php echo get_the_time() // Lấy Thời Gian Đăng Bài Của Bài Viết ?>




<?php endwhile; wp_reset_query(); ?>




<!--Code Phân Trang-->
<div class="pagenavi">
    <?php if (function_exists('devvn_wp_corenavi')) devvn_wp_corenavi($query); ?>
</div>