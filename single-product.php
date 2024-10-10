<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>

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
			<!-- Usa la galería de imágenes nativa de WooCommerce -->
			<div class="product-image">
				<?php
				// WooCommerce renderiza automáticamente el visor y las imágenes
				woocommerce_show_product_images();
				?>
			</div>

			<div class="product-info">
				<?php
				$sku = $product->get_sku();
				echo '<p class="product-sku">SKU: ' . ($sku ? $sku : 'N/A') . '</p>';
				do_action('woocommerce_single_product_summary');
				?>
			</div>

			<?php
			if ($product->is_type('variable')) {
				$variations = $product->get_available_variations();

				if (!empty($variations)) {
					foreach ($variations as $variation) {
						$variation_id = $variation['variation_id'];
						$variation_obj = wc_get_product($variation_id);

						// Obtener los atributos de la variación (ejemplo: color, talla, etc.)
						$attributes = $variation['attributes'];

						// Aquí puedes obtener el valor del atributo color (si existe)
						$color = isset($attributes['attribute_pa_color']) ? $attributes['attribute_pa_color'] : '';

						// Aquí puedes obtener el valor del atributo size (si existe)
						$size = isset($attributes['attribute_pa_size']) ? $attributes['attribute_pa_size'] : '';

						// Crear un slug combinado de color y size (u otros atributos)
						$attribute_slug = trim($color . '-' . $size, '-'); // Combina los valores de color y talla

						// Si no se encuentra ningún atributo relevante, puedes saltar esta iteración
						if (empty($attribute_slug)) {
							continue;
						}

						// Obtener imágenes de la variación
						$variation_images = array();

						// Imagen principal de la variación
						$main_variation_image_id = $variation_obj->get_image_id();
						if ($main_variation_image_id) {
							$variation_images[] = wp_get_attachment_url($main_variation_image_id);
						}

						// Imágenes de la galería de la variación (si tiene)
						$gallery_image_ids = $variation_obj->get_gallery_image_ids();
						if (!empty($gallery_image_ids)) {
							foreach ($gallery_image_ids as $gallery_image_id) {
								$variation_images[] = wp_get_attachment_url($gallery_image_id);
							}
						}

						// Convertir el array de imágenes a una cadena separada por comas
						$variation_images_str = implode(',', $variation_images);
						?>
						
						<input type="hidden" class="images-variants" id="<?php echo esc_attr($attribute_slug); ?>" value="<?php echo esc_attr($variation_images_str); ?>">
						
						<?php
					}
				}
			}
			?>

		</div>

	</article>

	<article class="product-metadata alignwide">
		<div class="product-metadata-tabs">
			<button class="product-tab-button active">
				About the Product
			</button>
			<button class="product-tab-button">
				Customer Reviews
			</button>
		</div>
		<ul class="product-tabs">
			<li class="product-tab-item active raw-text">
				<?php echo do_shortcode($product->get_description()); ?>
			</li>
			<li class="product-tab-item">
				<div id="comments" class="comments-area">
					<?php
					if (comments_open() || get_comments_number()):
						comments_template(); // Carga el template de comentarios
					endif;
					?>
				</div>
			</li>
		</ul>
	</article>

	<?php
	// Configura los argumentos para obtener productos relacionados
	$related_products_ids = wc_get_related_products($product->get_id(), 4); // Obtén hasta 4 productos relacionados

	if (!empty($related_products_ids)) {
		$args = array(
			'post_type' => 'product',
			'post__in' => $related_products_ids,
			'posts_per_page' => 4,
			'orderby' => 'rand' // Opcional, para obtener productos aleatorios
		);

		// Realiza la consulta
		$related_products_query = new WP_Query($args);

		if ($related_products_query->have_posts()): ?>
			<article class="alignwide">
				<div class="related-title">
					<h1 class="title has-tw-cent-mt-std-font-family">YOU MAY ALSO LOVE</h1>
					<hr class="separator-tiny">
				</div>
				<ul class="products-wrapper tiny-version">
					<?php while ($related_products_query->have_posts()):
						$related_products_query->the_post(); ?>
						<?php get_template_part('template-parts/content', 'product'); ?>
					<?php endwhile; ?>
				</ul>
			</article>
			<?php
		endif;
		wp_reset_postdata();
	}
	?>

<?php endwhile; // end of the loop. ?>

<?php get_footer('shop'); ?>
