<?php
/**
 * Template Name: Contact
 */

    get_header();
?>

<section id="contact">
    <div class="container">
        <div class="row">
            <!--Nội Dung Contact-->


            <div class="col-md-6">
<!--                shortcode Lấy Form plugin-->
                <?php echo do_shortcode('[gravityform id=1 title=false description=false ajax=true tabindex=49]') ?>
            </div>
        </div>
    </div>
</section>



<?php get_footer() ?>
