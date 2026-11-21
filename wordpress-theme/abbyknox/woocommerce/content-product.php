<?php
/**
 * Product card in loops (related products, shortcodes). Uses the theme's book card.
 *
 * @package AbbyKnox
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'ak-loop-item', $product ); ?>>
	<?php ak_book_card( $product ); ?>
</li>
