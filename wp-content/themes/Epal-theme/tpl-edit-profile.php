<?php
/**
 * Template Name: Edit Author Page
 */
get_header();

?>
    <section id="author-page">
        <div class="container">
            <div class="row">
                <?php echo do_shortcode('[edit-profile]') ?>
            </div>
        </div>
    </section>
<?php get_footer();?>