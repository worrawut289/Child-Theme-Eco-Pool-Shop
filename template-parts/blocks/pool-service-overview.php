  <?php if (have_rows('repeater_pool_service_overview')) : ?>
  <main class="wrapper">
      <!-- GRID 5 คอลัมน์ -->
      <section class="cards" aria-label="บริการทั้งหมด 5 รายการ">
          <?php 
          $total_rows = count(get_field('repeater_pool_service_overview'));
          $current_row = 0;
          while (have_rows('repeater_pool_service_overview')) : the_row();
            $current_row++;
            $title = get_sub_field('title');
            $detail = get_sub_field('detail');
            $bg = get_sub_field('bg');
            $icon = get_sub_field('icon');
            $is_last = ($current_row === $total_rows);
        ?>
          <article class="feature-card<?php echo $is_last ? ' feature-card--single' : ''; ?>" role="region"
              aria-label="ระบบหมุนเวียนสระน้ำ">
              <div class="bg" aria-hidden="true">
                  <img src="<?= esc_url($bg); ?>" alt="สระว่ายน้ำริมทะเลพร้อมเก้าอี้นอน" alt="<?= esc_attr($title); ?>">
              </div>
              <div class="content">
                  <div class="chip" aria-hidden="true">
                      <?php if ($icon): ?>
                      <img src="<?= esc_url($icon); ?>" class="service-icon">
                      <?php endif; ?>
                  </div>
                  <h2><?= esc_html($title); ?></h2>
                  <p><?= esc_html($detail); ?></p>
              </div>
          </article>
          <?php endwhile; ?>
      </section>
  </main>
  <?php endif; ?>