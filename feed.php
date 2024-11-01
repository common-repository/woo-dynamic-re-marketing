<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

function adwords_feed() {

	// output headers so that the file is downloaded rather than displayed
	header('Content-Type: text/csv; charset=utf-8');

	// set file name with current date
	header('Content-Disposition: attachment; filename=adwords-feed-' . date('Y-m-d') . '.csv');

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');

	// set the column headers for the csv
	$headings = array( 'Item title',	'Final URL',	'price'	, 'Image URL',	'ID', 'Item Category');

	// output the column headings
	fputcsv($output, $headings );

	// get all simple products where stock is managed
	$args = array(
	'post_type'			=> 'product',
	'post_status' 		=> 'publish',
    'posts_per_page' 	=> -1,
    'orderby'			=> 'title',
    'order'				=> 'ASC',
	
	);

	$loop = new WP_Query( $args );

	while ( $loop->have_posts() ) : $loop->the_post();
	
        global $product;
		$terms = get_the_terms( $post->ID, 'product_cat' );
		$nterms = get_the_terms( $post->ID, 'product_tag'  );
        foreach ($terms  as $term  ) {
            $product_cat_id = $term->term_id;
            $product_cat_name = $term->name;
            break;
        }
        $row = array( $product->get_title(), get_permalink($product_id),$product->get_price_including_tax(). " ".get_woocommerce_currency(), wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' )[0],$product->id, $product_cat_name);

        fputcsv($output, $row);
		
	endwhile; 

	
}
adwords_feed();