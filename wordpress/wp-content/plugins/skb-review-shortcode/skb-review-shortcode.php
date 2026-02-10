<?php
/**
 * Plugin Name: Random Review
 * Author: Brayden Rehak
 * Version: 0.1.0
 * Description: Displays a random review with information to the book.
 */

/**
 * Shortcode: [skb-review]
 * Displays a random review with reviewer info and a link to the book.
 */

namespace SKB;

class ReviewShortcode {
	private static $instance;

	public function __construct() {
		add_shortcode( 'skb-review', [ $this, 'reviewShortcode' ] );
	}

	private function __clone() {
	}

	public static function getInstance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	public function reviewShortcode( $atts ) {
		// Get one random published review
		$review_query = new \WP_Query( [
			'post_type'      => ReviewPostType::POST_TYPE,
			'posts_per_page' => 1,
			'orderby'        => 'rand',
			'post_status'    => 'publish'
		] );

		if ( $review_query->have_posts() ) {
			$review_query->the_post();
			$meta           = ReviewMeta::getInstance();
			$review_content = get_the_content();
			$reviewer       = esc_html( $meta->getReviewerName() );
			$location       = esc_html( $meta->getReviewerLocation() );
			$rating         = $meta->getReviewerRatingStars();
			$book_id        = $meta->getBookId();
			$book_title     = $meta->getBookTitle();
			$book_link      = $book_id ? get_permalink( $book_id ) : '#';

			// Simple block
			$output = "<div class='skb-review-block' style='border:2px solid #222; padding:15px; margin:10px 0;'>";
			$output .= "<h4 style='margin-top:0;'>Random Reader Review</h4>";
			$output .= "<p style='font-style:italic;'>{$review_content}</p>";
			$output .= "<p><strong>{$reviewer}</strong> <span style='color:#777;'>{$location}</span> <span>{$rating}</span></p>";
			if ( $book_id ) {
				$output .= "<p>Book: <a href='{$book_link}'>{$book_title}</a></p>";
			}
			$output .= "</div>";

			wp_reset_postdata();

			return $output;
		} else {
			return "<div class='skb-review-block'>No reviews found.</div>";
		}
	}
}

ReviewShortcode::getInstance();

