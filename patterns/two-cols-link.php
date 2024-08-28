<?php
/**
 * Title: 2-Cols with Title and Link
 * Slug: two-cols-link
 * Viewport width: 1400
 * Description: A 2 cols section with a title, a paragraph, and an image.
 */
?>

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":40,"overlayColor":"black","isUserOverlayColor":true,"minHeight":75,"minHeightUnit":"vh","isDark":false,"style":{"layout":{"selfStretch":"fixed","flexSize":"49%"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light" style="min-height:75vh"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-40 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group has-white-color has-text-color has-link-color"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"xxx-large","fontFamily":"tw-cent-mt-std"} -->
<h2 class="wp-block-heading has-text-align-center has-tw-cent-mt-std-font-family has-xxx-large-font-size" style="font-style:normal;font-weight:700">Col 1</h2>
<!-- /wp:heading -->

<!-- wp:separator {"className":"separator-medium"} -->
<hr class="wp-block-separator has-alpha-channel-opacity separator-medium"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"black","fontSize":"x-large","fontFamily":"tw-cent-mt-std"} -->
<p class="has-text-align-center has-black-color has-text-color has-link-color has-tw-cent-mt-std-font-family has-x-large-font-size"><a href="https://gabsters.co/about-us/">Link</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":40,"overlayColor":"black","isUserOverlayColor":true,"minHeight":75,"minHeightUnit":"vh","isDark":false,"style":{"layout":{"selfStretch":"fixed","flexSize":"49%"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light" style="min-height:75vh"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-40 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group has-white-color has-text-color has-link-color"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"xxx-large","fontFamily":"tw-cent-mt-std"} -->
<h2 class="wp-block-heading has-text-align-center has-tw-cent-mt-std-font-family has-xxx-large-font-size" style="font-style:normal;font-weight:700">Col 2</h2>
<!-- /wp:heading -->

<!-- wp:separator {"className":"separator-medium"} -->
<hr class="wp-block-separator has-alpha-channel-opacity separator-medium"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"black","fontSize":"x-large","fontFamily":"tw-cent-mt-std"} -->
<p class="has-text-align-center has-black-color has-text-color has-link-color has-tw-cent-mt-std-font-family has-x-large-font-size"><a href="https://gabsters.co/about-us/">Link</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->