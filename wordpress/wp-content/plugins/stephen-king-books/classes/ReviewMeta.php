<?php

namespace SKB;

class ReviewMeta extends Singleton
{
	const NAME_KEY = 'skb_review_name';
	const LOCATION_KEY = 'skb_review_location';
	const RATING_KEY = 'skb_review_rating';
	const BOOK_KEY = 'skb_review_book_id';
	const NONCE_ACTION = 'review_meta_save';
	const NONCE_FIELD = 'review_meta_nonce';

	protected static $instance;

	protected function __construct()
	{
		add_action('add_meta_boxes', [$this, 'registerMetaBox']);
		add_action('save_post_' . ReviewPostType::POST_TYPE, [$this, 'saveReviewMeta']);
	}

	public function registerMetaBox()
	{
		add_meta_box(
			'review-details',
			'Review Details',
			array($this, 'metaForm'),
			ReviewPostType::POST_TYPE,
			'normal',
			'high'
		);
	}

	public function metaForm($post)
	{
		wp_nonce_field(self::NONCE_ACTION, self::NONCE_FIELD);

		$books = get_posts([
			'post_type' => BookPostType::POST_TYPE,
			'numberposts' => -1,
			'post_status' => 'publish'
		]);
		$selected_book = get_post_meta($post->ID, self::BOOK_KEY, true);

		include PLUGIN_PATH . 'templates/review-meta-form.php';
	}

	public function saveReviewMeta($post_id)
	{
		$name = isset($_POST[self::NAME_KEY]) ? sanitize_text_field($_POST[self::NAME_KEY]) : '';
		$location = isset($_POST[self::LOCATION_KEY]) ? sanitize_text_field($_POST[self::LOCATION_KEY]) : '';
		$rating = isset($_POST[self::RATING_KEY]) ? intval($_POST[self::RATING_KEY]) : '';
		$book_id = isset($_POST[self::BOOK_KEY]) ? absint($_POST[self::BOOK_KEY]) : '';

		update_post_meta($post_id, self::NAME_KEY, $name);
		update_post_meta($post_id, self::LOCATION_KEY, $location);
		update_post_meta($post_id, self::RATING_KEY, $rating);
		update_post_meta($post_id, self::BOOK_KEY, $book_id);
	}

	// Individual meta getters for template and display
	public function getReviewerName($post_id = null) {
		$post_id = $post_id ?: get_the_ID();
		return get_post_meta($post_id, self::NAME_KEY, true);
	}

	public function getReviewerLocation($post_id = null) {
		$post_id = $post_id ?: get_the_ID();
		return get_post_meta($post_id, self::LOCATION_KEY, true);
	}

	public function getReviewerRating($post_id = null) {
		$post_id = $post_id ?: get_the_ID();
		return get_post_meta($post_id, self::RATING_KEY, true);
	}

	public function getReviewerRatingStars($post_id = null) {
		$rating = intval($this->getReviewerRating($post_id));
		return str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
	}

	public function getBookId($post_id = null) {
		$post_id = $post_id ?: get_the_ID();
		return get_post_meta($post_id, self::BOOK_KEY, true);
	}

	public function getBookTitle($post_id = null) {
		$book_id = $this->getBookId($post_id);
		return $book_id ? get_the_title($book_id) : 'Unknown';
	}


}