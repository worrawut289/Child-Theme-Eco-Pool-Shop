<div class="container d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="col">
            <?php
            $contact = get_field('group_line_contact'); 
            if( $contact ):
                $url = esc_url( $contact['link']['url'] );
                $title = esc_html( $contact['title'] );
                $icon = get_stylesheet_directory_uri() . '/assets/icons/line.png'; 
            ?>
            <a class="button-line-contact" href="<?php echo $url; ?>" target="_blank" rel="noopener">
                <img src="<?php echo $icon; ?>" alt="">
                <span><?php echo $title; ?></span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>