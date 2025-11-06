<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 9.9.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>
<p>
    <?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	/* translators: %s: Customer first name */
	printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) );
} else {
	printf( esc_html__( 'Hi,', 'woocommerce' ) );
}
?>
</p>
<p><?php esc_html_e( 'We have finished processing your order.', 'woocommerce' ); ?></p>
<?php if ( $email_improvements_enabled ) : ?>
<p><?php esc_html_e( 'Here’s a reminder of what you’ve ordered:', 'woocommerce' ); ?></p>
<?php endif; ?>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
$shipping_company = get_field('shipping_company', $order->get_id()); // จะได้ key เช่น kerry
$tracking_number  = get_field('tracking_number', $order->get_id());

$choices = [
    'thailand_post' => 'ไปรษณีย์ไทย EMS',
    'kerry'         => 'Kerry Express',
    'jnt'           => 'J&T Express',
    'flash'         => 'Flash Express',
    'shopee'        => 'SPX Express',
    'lex'           => 'LEX Express',
    'ninja'         => 'Ninja Van',
    'dhl'           => 'DHL',
    'ups'           => 'UPS',
    'best'          => 'Best Express',
    'scg'           => 'SCG Express',
    'fedex'         => 'FedEx',
    'nim'           => 'Nim Express',
    'lalamove'      => 'Lalamove',
];

$company_label = isset($choices[$shipping_company]) ? $choices[$shipping_company] : $shipping_company;

if ( $company_label || $tracking_number ) : ?>
<div style="margin-bottom: 15px;">
    <h2>ข้อมูลการจัดส่ง</h2>
    <p>
        <?php if ( $company_label ) : ?>
        <strong>ขนส่ง:</strong> <?php echo esc_html( $company_label ); ?><br>
        <?php endif; ?>
        <?php if ( $tracking_number ) : ?>
        <strong>เลขพัสดุ:</strong> <?php echo esc_html( $tracking_number ); ?>
        <?php endif; ?>
    </p>
</div>
<?php endif; ?>



<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );