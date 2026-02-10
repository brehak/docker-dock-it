<?php

namespace SKB;

class ReviewPostType extends Singleton {
	const POST_TYPE = 'review';

	protected static $instance;

	protected function __construct() {
		add_action('init', [$this, 'registerPostType'], 0);
		add_filter('the_content', [$this, 'postContent'], 10);
	}

	public function registerPostType() {
		$labels = array(
			'name'                  => _x('Reviews', 'Post Type General Name', TEXT_DOMAIN),
			'singular_name'         => _x('Review', 'Post Type Singular Name', TEXT_DOMAIN),
			'menu_name'             => __('Reviews', TEXT_DOMAIN),
			'name_admin_bar'        => __('Review', TEXT_DOMAIN),
			'add_new'               => __('Add New', TEXT_DOMAIN),
			'add_new_item'          => __('Add New Review', TEXT_DOMAIN),
			'new_item'              => __('New Review', TEXT_DOMAIN),
			'edit_item'             => __('Edit Review', TEXT_DOMAIN),
			'update_item'           => __('Update Review', TEXT_DOMAIN),
			'view_item'             => __('View Review', TEXT_DOMAIN),
			'all_items'             => __('All Reviews', TEXT_DOMAIN),
			'search_items'          => __('Search Reviews', TEXT_DOMAIN),
			'not_found'             => __('Not found', TEXT_DOMAIN),
			'not_found_in_trash'    => __('Not found in Trash', TEXT_DOMAIN),
		);

		$args = array(
			'label'               => __('Review', TEXT_DOMAIN),
			'description'         => __('Reviews for Stephen King books.', TEXT_DOMAIN),
			'labels'              => $labels,
			'supports'            => array('title', 'editor'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 6,
			'menu_icon'           => 'dashicons-star-filled',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_in_rest'        => true,
		);

		register_post_type(self::POST_TYPE, $args);
	}

	public function postContent( $content ) {
		$post = get_post();
		if ( is_singular( self::POST_TYPE ) && in_the_loop() && is_main_query() ) {
			$meta = ReviewMeta::getInstance();

			$meta_display = '
			<div class="review-details">
				<h3>Review Details</h3>
				<p><strong>Reviewer:</strong> ' . esc_html( $meta->getReviewerName() ) . '</p>
				<p><strong>Location:</strong> ' . esc_html( $meta->getReviewerLocation() ) . '</p>
				<p><strong>Rating:</strong> ' . $meta->getReviewerRatingStars() . '</p>
			</div>
			<hr>
		';

			$content = $meta_display . $content;
		}

		return $content;
	}
}