<?php
// ===============================
// Application Section
// ===============================
if (have_rows('repeater_feature_product')): ?>
<div class="product-application">
    <h3>Application</h3>
    <ul class="application-list">
        <?php while (have_rows('repeater_feature_product')): the_row(); ?>
        <li>
            <span class="icon">✔</span>
            <?php echo esc_html(get_sub_field('feature_detail')); ?>
        </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php endif; ?>

<?php
// ===============================
// PDF Download Section
// ===============================
if (have_rows('repeater_pdf_product')): ?>
<div class="product-pdf-download">
    <div class="pdf-download-list">
        <?php while (have_rows('repeater_pdf_product')): the_row(); 
            $btn_name = get_sub_field('btn_name');
            $pdf_file = get_sub_field('pdf_file');
            if ($pdf_file): ?>
        <a class="pdf-download-btn-v2" href="<?php echo esc_url($pdf_file['url']); ?>" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/file_pdf.png" alt="PDF"
                class="pdf-icon-img" />
            <?php echo esc_html($btn_name ?: 'Download PDF'); ?>
        </a>
        <?php endif; ?>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>