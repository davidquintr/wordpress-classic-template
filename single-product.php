<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
?>

<?php while (have_posts()): ?>
	<?php the_post(); ?>

	<?php
	do_action('woocommerce_before_single_product');

	if (post_password_required()) {
		echo get_the_password_form();
		return;
	}
	?>

	<article id="product-<?php the_ID(); ?>" <?php wc_product_class('alignwide ', $product); ?>>

		<div class="product-inner">
			<!-- Imprime la imagen principal del producto -->
			<div class="product-image">
				<?php
				$images = array();
				$main_image_id = get_post_thumbnail_id($product->get_id());
				$main_image_url = wp_get_attachment_url($main_image_id);

				if($main_image_url){
					array_push($images, $main_image_url);
				}

				$attachment_ids = $product->get_gallery_image_ids();
				if (!empty($attachment_ids)) {
					foreach ($attachment_ids as $attachment_id) {
						$image_url = wp_get_attachment_url($attachment_id);
						array_push($images, $image_url);
					}
				}

				?>
				<ul class="images-lateral">
					<?php
					$default_image = get_template_directory_uri() . '/assets/images/product-no-icon.png';
					if (count($images) < 1) {
						array_push($images, $default_image);
					}
											
					foreach ($images as $image):
						?>
						<li class="image-shop-item">
							<img src="<?php echo $image ?>" />
						</li>
						<?php
					endforeach;
					?>
				</ul>
				<picture class="main-image">
					<img class="showcase-shop-image" src="<?php echo $images[0] ?>" />
				</picture>
			</div>


			<div class="product-info">
				<?php
				$sku = $product->get_sku();
				echo '<p class="product-sku">SKU: ' . ($sku ? $sku : 'N/A') . '</p>';		
				do_action('woocommerce_single_product_summary');
				?>
			</div>

		</div>

	</article>

<?php endwhile; // end of the loop. ?>

<?php
?>

<?php get_footer('shop'); ?>