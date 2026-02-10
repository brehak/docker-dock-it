<?php

namespace SKB;

class BookMeta extends Singleton
{
	const PUBLISHER_KEY = 'skb_publisher';
	const PUBLISHED_DATE_KEY = 'skb_published_date';
	const PAGE_COUNT_KEY = 'skb_page_count';
	const PRICE_KEY = 'skb_price';
	const NONCE_ACTION = 'review_meta_save';
	const NONCE_FIELD = 'review_meta_nonce';

	protected static $instance;

	protected function __construct()
	{
		add_action('add_meta_boxes', [$this, 'registerMetaBox']);
		add_action('save_post_' . BookPostType::POST_TYPE, [$this, 'saveBookMeta']);
	}

	public function registerMetaBox()
	{
		add_meta_box(
			'book-details',
			'Book Details',
			array($this, 'metaForm'),
			BookPostType::POST_TYPE,
			'side',
			'core'
		);
	}

	public function metaForm()
	{
		wp_nonce_field( basename(__FILE__), 'book_details_nonce' );

		include PLUGIN_PATH . 'templates/book-meta-form.php';
	}

	public function saveBookMeta($post_id)
	{

		$publisher = isset($_POST[self::PUBLISHER_KEY]) ? sanitize_text_field($_POST[self::PUBLISHER_KEY]) : '';
		$published_date = isset($_POST[self::PUBLISHED_DATE_KEY]) ? sanitize_text_field($_POST[self::PUBLISHED_DATE_KEY]) : '';
		$page_count = isset($_POST[self::PAGE_COUNT_KEY]) ? absint($_POST[self::PAGE_COUNT_KEY]) : '';
		$price = isset($_POST[self::PRICE_KEY]) ? sanitize_text_field($_POST[self::PRICE_KEY]) : '';

		update_post_meta($post_id, self::PUBLISHER_KEY, $publisher);
		update_post_meta($post_id, self::PUBLISHED_DATE_KEY, $published_date);
		update_post_meta($post_id, self::PAGE_COUNT_KEY, $page_count);
		update_post_meta($post_id, self::PRICE_KEY, $price);
	}

	public function getPublisher()
	{
		$post = get_post();
		return get_post_meta($post->ID, self::PUBLISHER_KEY, true);
	}

	public function getPublishedDate()
	{
		$post = get_post();
		return get_post_meta($post->ID, self::PUBLISHED_DATE_KEY, true);
	}

	public function getPageCount()
	{
		$post = get_post();
		return get_post_meta($post->ID, self::PAGE_COUNT_KEY, true);
	}

	public function getPrice()
	{
		$post = get_post();
		return get_post_meta($post->ID, self::PRICE_KEY, true);
	}
}
