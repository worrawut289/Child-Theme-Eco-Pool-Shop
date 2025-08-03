<?php
$heading = get_field('group_heading_with_link');
if( $heading ): ?>
<div class="container">
    <div class="row">
        <div class="col-8 col-lg-6">
            <div class="title-view-all">
                <div class="title-th">
                    <h2> <?php echo $heading['title_th']; ?></h2>
                </div>
                <div class="title-en">
                    <h2> <?php echo $heading['title_en']; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-4 col-lg-6 view-all">

            <a href="<?php echo esc_url( $heading['link']); ?>">
                <span>ดูทั้งหมด <i class="fa-solid fa-arrow-right"></i></span>
            </a>

        </div>
    </div>
</div>
<?php endif; ?>