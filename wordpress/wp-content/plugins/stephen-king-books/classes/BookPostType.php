<?php

namespace SKB;

class BookPostType extends Singleton {
	const POST_TYPE = 'book';

	protected static $instance;

	protected function __construct() {
		add_action( 'init', [ $this, 'registerPostType' ], 0 );
		add_filter( 'the_content', [ $this, 'postContent' ], 10 );
	}

	public function registerPostType() {
		$labels  = array(
			'name'                  => _x( 'Books', 'Post Type General Name', TEXT_DOMAIN ),
			'singular_name'         => _x( 'Book', 'Post Type Singular Name', TEXT_DOMAIN ),
			'menu_name'             => __( 'Stephen King Books', TEXT_DOMAIN ),
			'name_admin_bar'        => __( 'Book', TEXT_DOMAIN ),
			'archives'              => __( 'Book Archives', TEXT_DOMAIN ),
			'attributes'            => __( 'Book Attributes', TEXT_DOMAIN ),
			'parent_item_colon'     => __( 'Parent Book:', TEXT_DOMAIN ),
			'all_items'             => __( 'All Books', TEXT_DOMAIN ),
			'add_new_item'          => __( 'Add New Book', TEXT_DOMAIN ),
			'add_new'               => __( 'Add New', TEXT_DOMAIN ),
			'new_item'              => __( 'New Book', TEXT_DOMAIN ),
			'edit_item'             => __( 'Edit Book', TEXT_DOMAIN ),
			'update_item'           => __( 'Update Book', TEXT_DOMAIN ),
			'view_item'             => __( 'View Book', TEXT_DOMAIN ),
			'view_items'            => __( 'View Books', TEXT_DOMAIN ),
			'search_items'          => __( 'Search Books', TEXT_DOMAIN ),
			'not_found'             => __( 'Not found', TEXT_DOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', TEXT_DOMAIN ),
			'featured_image'        => __( 'Book Cover', TEXT_DOMAIN ),
			'set_featured_image'    => __( 'Set book cover', TEXT_DOMAIN ),
			'remove_featured_image' => __( 'Remove book cover', TEXT_DOMAIN ),
			'use_featured_image'    => __( 'Use as book cover', TEXT_DOMAIN ),
			'insert_into_item'      => __( 'Insert into book', TEXT_DOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this book', TEXT_DOMAIN ),
			'items_list'            => __( 'Books list', TEXT_DOMAIN ),
			'items_list_navigation' => __( 'Books list navigation', TEXT_DOMAIN ),
			'filter_items_list'     => __( 'Filter books list', TEXT_DOMAIN ),
		);

		$rewrite = array(
			'slug'       => 'books',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args    = array(
			'label'               => __( 'Book', TEXT_DOMAIN ),
			'description'         => __( 'A collection of Stephen King novels and stories.', TEXT_DOMAIN ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'author' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-book-alt',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => 'books',
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
			'show_in_rest'        => true,
		);

		register_post_type( self::POST_TYPE, $args );
	}


	/**
	 * Filters the post content to display book metadata and reader reviews (comments).
	 * @param string $content The post content.
	 * @return string Modified content.
	 */
	public function postContent( $content ) {
		$post = get_post();

		if ( is_singular( self::POST_TYPE ) && in_the_loop() && is_main_query() ) {
			$meta = BookMeta::getInstance();

			$meta_display = '
                <div class="book-details">
                    <h3>Book Details</h3>
                    <p><strong>Publisher:</strong> ' . esc_html( $meta->getPublisher() ) . '</p>
                    <p><strong>Published Date:</strong> ' . esc_html( $meta->getPublishedDate() ) . '</p>
                    <p><strong>Page Count:</strong> ' . esc_html( $meta->getPageCount() ) . '</p>
                    <p><strong>Price:</strong> ' . esc_html( $meta->getPrice() ) . '</p>
                </div>
                <hr>
                <h3>Synopsis</h3>
            ';

			$content = $meta_display . $content;

			// --- Display linked Reviews (not comments) ---
			$review_query = new \WP_Query([
				'post_type'  => ReviewPostType::POST_TYPE,
				'meta_key'   => ReviewMeta::BOOK_KEY,
				'meta_value' => $post->ID,
				'post_status'=> 'publish',
				'posts_per_page' => 10,
				'orderby' => 'date',
				'order' => 'DESC',
			]);
			$reviews_html = '<h3>Reader Reviews:</h3>';
			if ($review_query->have_posts()) {
				$reviews_html .= '<ul class="book-reviews-list" style="list-style-type: none; padding-left: 0;">';
				while ($review_query->have_posts()) {
					$review_query->the_post();
					$review_meta = ReviewMeta::getInstance();
					$reviewer = esc_html($review_meta->getReviewerName());
					$location = esc_html($review_meta->getReviewerLocation());
					$rating = $review_meta->getReviewerRatingStars();
					$review_content = get_the_content();
					$review_url = get_permalink();

					$reviews_html .= '<li style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">';
					$reviews_html .= "<p><strong>{$reviewer}</strong> <span style='color:#666;'>{$location}</span> <span>{$rating}</span></p>";
					$reviews_html .= "<p style='font-style:italic; margin:0;'>{$review_content}</p>";
					$reviews_html .= "<p><a href='{$review_url}'>Read full review</a></p>";
					$reviews_html .= '</li>';
				}
				$reviews_html .= '</ul>';
				wp_reset_postdata();
			} else {
				$reviews_html .= '<p>No reviews yet for this book.</p>';
			}
			$content .= $reviews_html;
		}

		return $content;
	}
}
