<?php
if ( ! defined( 'ABSPATH' ) ) exit; 

function oggy_quote_form_shortcode() {
        ob_start();

        // ถ้ามีการ submit ฟอร์ม
        if ( isset($_POST['submit_quote']) ) {
            
        $token = sanitize_text_field($_POST['cf-turnstile-response']);
        $secret = "0x4AAAAAABrNIBVIszmYZWcDF4_oiIN3lnU"; 

        $response = wp_remote_post("https://challenges.cloudflare.com/turnstile/v0/siteverify", array(
            'body' => array(
                'secret'   => $secret,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        ));

        $result = json_decode(wp_remote_retrieve_body($response), true);

        if ( empty($result['success']) ) {
            echo "<p style='color:red;'>❌ การยืนยันไม่ผ่าน กรุณาลองใหม่อีกครั้ง</p>";
            return ob_get_clean();
        }

        $fullname   = sanitize_text_field($_POST['fullname']);
        $address    = sanitize_textarea_field($_POST['address']);
        $phone      = sanitize_text_field($_POST['phone']);
        $lineid     = sanitize_text_field($_POST['lineid']);
        $email      = sanitize_email($_POST['email']);
        $message_in = sanitize_textarea_field($_POST['message']);
        // ใช้ชื่อและ URL สินค้าจาก WooCommerce
        $product_id = get_the_ID();
        $product    = get_the_title($product_id);
        $product_url = get_permalink($product_id);

        // อีเมลปลายทาง (Admin)
        $to = array(
            'sarantorn@ecopooltech.co.th',
            'somruk.srbc@gmail.com'
        );
        $subject = "📩 คำขอใบเสนอราคา: $product";

        // ทำอีเมลเป็น HTML
        $message = "
            <h2>มีคำขอใบเสนอราคาจากลูกค้า</h2>
            <table cellpadding='8' cellspacing='0' border='0' style='border-collapse: collapse;'>
                <tr>
                    <td><strong>สินค้า:</strong></td>
                    <td>{$product}<br><a href='{$product_url}' target='_blank' style='color:#005ae0;font-size:13px;'>{$product_url}</a></td>
                </tr>
                <tr>
                    <td><strong>ชื่อ-นามสกุล:</strong></td>
                    <td>{$fullname}</td>
                </tr>
                <tr>
                    <td><strong>ที่อยู่:</strong></td>
                    <td>{$address}</td>
                </tr>
                <tr>
                    <td><strong>เบอร์โทร:</strong></td>
                    <td>{$phone}</td>
                </tr>
                <tr>
                    <td><strong>Line ID:</strong></td>
                    <td>{$lineid}</td>
                </tr>
                <tr>
                    <td><strong>อีเมล:</strong></td>
                    <td>{$email}</td>
                </tr>
                <tr>
                    <td><strong>รายละเอียดเพิ่มเติม:</strong></td>
                    <td>{$message_in}</td>
                </tr>
            </table>
        ";

        // header (ให้ตรงกับ SMTP ที่ใช้)
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: EcoPoolShop <ecopool.mineralpure@gmail.com>',
            'Reply-To: '.$email 
        );

        // ส่งอีเมล
        if ( wp_mail($to, $subject, $message, $headers) ) {
            echo "<p style='color: green;'>✅ ส่งคำขอใบเสนอราคาเรียบร้อยแล้ว</p>";
        } else {
            echo "<p style='color: red;'>❌ ส่งไม่สำเร็จ กรุณาส่งใหม่อีกครั้ง</p>";
        }
    }

    // ปุ่ม + Modal (popup) เหมือนเดิม ↓
    ?>
<!-- ปุ่ม -->
<button type="button" id="openQuoteModal" class="quote-btn">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/contract.png" alt="icon"
        class="quote-btn-icon" />
    ขอใบเสนอราคา
</button>

<!-- Modal -->
<div id="quoteModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-modal-close" id="closeQuoteModal">&times;</span>
        <div class="quote-modal-header">
            <?php 
                    $product_id = get_the_ID();
                    $product_img = get_the_post_thumbnail_url($product_id, 'medium');
                    $product_title = get_the_title();
                ?>
            <?php if($product_img): ?>
            <img src="<?php echo esc_url($product_img); ?>" alt="<?php echo esc_attr($product_title); ?>"
                class="quote-product-img" />
            <?php endif; ?>
            <div class="quote-product-title"><?php echo esc_html($product_title); ?></div>
        </div>
        <form method="post" action="" class="quote-form-grid">
            <div class="form-row">
                <div class="form-group">
                    <label>ชื่อ - นามสกุล<span class="required">*</span></label>
                    <input type="text" name="fullname" placeholder="กรอกชื่อ-นามสกุล" required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width:100%">
                    <label>ที่อยู่<span class="required">*</span></label>
                    <textarea name="address" placeholder="กรอกที่อยู่" required></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>เบอร์โทรศัพท์<span class="required">*</span></label>
                    <input type="tel" name="phone" placeholder="กรอกเบอร์โทรศัพท์" required />
                </div>
                <div class="form-group">
                    <label>Line ID</label>
                    <input type="text" name="lineid" placeholder="กรอก Line ID" />
                </div>
                <div class="form-group">
                    <label>อีเมล<span class="required">*</span></label>
                    <input type="email" name="email" placeholder="กรอกอีเมล" required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group" style="width:100%">
                    <label>รายละเอียดเพิ่มเติม</label>
                    <textarea name="message" placeholder="กรอกรายละเอียดเพิ่มเติม"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="cf-turnstile" data-sitekey="0x4AAAAAABrNIB490tzB0nql"></div>
            </div>
            <input type="hidden" name="product_name" value="<?php echo esc_attr($product_title); ?>">
            <div class="form-row" style="justify-content:center;">
                <button type="submit" name="submit_quote" class="btn btn-success">ส่งคำขอ</button>
            </div>
        </form>
    </div>
</div>

<style>
.custom-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
}

.custom-modal-content {
    background: #fff;
    margin: 4% auto;
    padding: 32px 32px 24px 32px;
    border-radius: 18px;
    max-height: 80vh;
    /* กำหนดความสูงสูงสุด */
    overflow-y: auto;
    max-width: 800px;
    position: relative;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.13);
    font-family: 'Prompt', 'Sarabun', Arial, sans-serif;
    scrollbar-width: none;
    /* สำหรับ Firefox */
    -ms-overflow-style: none;
    /* สำหรับ IE/Edge */
}

.custom-modal-content::-webkit-scrollbar {
    display: none;
    /* สำหรับ Chrome/Safari */
}

.quote-modal-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 18px;
}

.quote-product-img {
    width: 250px;
    height: 250px;
    object-fit: contain;
    border-radius: 12px;
    margin-bottom: 8px;
    background: #f7f7f7;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.07);
}

.quote-product-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 6px;
    text-align: center;
}

.quote-form-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-row {
    display: flex;
    gap: 18px;
    width: 100%;
}

.form-group {
    display: flex;
    flex-direction: column;
    flex: 1 1 0;
    min-width: 0;
}

.form-group label {
    font-size: 1rem !important;
    font-weight: 500;
    margin-bottom: 6px;
    color: #222;
}

.form-group input,
.form-group textarea {
    background: #fafafa !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 12px 14px !important;
    font-size: 1rem !important;
    margin-bottom: 0 !important;
    outline: none !important;
    transition: box-shadow 0.2s !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
}

.form-group input:focus,
.form-group textarea:focus {
    box-shadow: 0 0 0 2px #b2e0ff;
}

.form-group textarea {
    min-height: 48px;
    resize: vertical;
}

.required {
    color: #e53935;
    margin-left: 2px;
}

.btn.btn-success {
    align-items: center;
    background: #14284b;
    width: -webkit-fill-available;
    color: #fff;
    text-align: center;
    font-weight: 500;
    padding: 14px 16px;
    border-radius: 16px;
    text-decoration: none;
    font-size: 17px;
    gap: 12px;
    transition: background 0.3s;
    box-shadow: 0 2px 8px rgba(20, 40, 75, 0.08);
}

.btn.btn-success:hover {
    background: #005ae0ff;
}

.custom-modal-close {
    color: #aaa;
    position: absolute;
    right: 18px;
    top: 12px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.custom-modal-close:hover {
    color: #333;
}

/* ปุ่มขอใบเสนอราคา */
.quote-btn {
    display: inline-flex;
    align-items: center;
    background: #14284b;
    color: #fff;
    font-weight: 500;
    padding: 14px 16px;
    border-radius: 16px;
    text-decoration: none;
    font-size: 17px;
    gap: 12px;
    transition: background 0.3s;
    box-shadow: 0 2px 8px rgba(20, 40, 75, 0.08);
    border: none;
    cursor: pointer;
}

.quote-btn-icon {
    width: 22px;
    height: 22px;
    object-fit: contain;
    display: inline-block;
}

.quote-btn:hover {
    background: #223a63;
}

@media (max-width: 900px) {
    .custom-modal-content {
        padding: 18px 6vw 18px 6vw;
        margin: 10px;
        max-width: 98vw;
    }

    .quote-product-img {
        width: 160px;
        height: 160px;
    }

    .form-row {
        flex-direction: column;
        gap: 0;
    }

    .form-group {
        margin-bottom: 12px;
    }
}

@media (max-width: 600px) {
    .custom-modal-content {
        padding: 10px 2vw 10px 2vw;
        margin: 10px;
        max-width: 100vw;
    }

    .quote-product-img {
        width: 100px;
        height: 100px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('quoteModal');
    var openBtn = document.getElementById('openQuoteModal');
    var closeBtn = document.getElementById('closeQuoteModal');

    openBtn.onclick = function() {
        modal.style.display = 'block';
    }
    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
</script>

<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<?php

    return ob_get_clean();
}
add_shortcode('quote_form', 'oggy_quote_form_shortcode');