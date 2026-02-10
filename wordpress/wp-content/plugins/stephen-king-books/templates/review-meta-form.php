<?php

namespace SKB;

$meta = ReviewMeta::getInstance();

$name = $meta->getReviewerName($post->ID);
$location = $meta->getReviewerLocation($post->ID);
$rating = $meta->getReviewerRating($post->ID);

?>

<?php wp_nonce_field( ReviewMeta::NONCE_ACTION, ReviewMeta::NONCE_FIELD ); ?>
<p>
    <label for="<?= ReviewMeta::NAME_KEY ?>">Reviewer Name:</label>
    <input
            type="text"
            id="<?= ReviewMeta::NAME_KEY ?>"
            name="<?= ReviewMeta::NAME_KEY ?>"
            value="<?= esc_attr($name) ?>"
            style="width: 100%;"
    />
</p>
<p>
    <label for="<?= ReviewMeta::LOCATION_KEY ?>">Location (city, state):</label>
    <input
            type="text"
            id="<?= ReviewMeta::LOCATION_KEY ?>"
            name="<?= ReviewMeta::LOCATION_KEY ?>"
            value="<?= esc_attr($location) ?>"
            style="width: 100%;"
    />
</p>
<p>
    <label for="<?= ReviewMeta::RATING_KEY ?>">Rating:</label>
    <select id="<?= ReviewMeta::RATING_KEY ?>" name="<?= ReviewMeta::RATING_KEY ?>">
		<?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>" <?= selected($rating, $i, false) ?>><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
		<?php endfor; ?>
    </select>
</p>
<p>
    <label for="<?= \SKB\ReviewMeta::BOOK_KEY ?>">Book Being Reviewed:</label>
    <select id="<?= \SKB\ReviewMeta::BOOK_KEY ?>" name="<?= \SKB\ReviewMeta::BOOK_KEY ?>">
        <option value="">Select a Book</option>
		<?php
		$books = get_posts([
			'post_type' => \SKB\BookPostType::POST_TYPE,
			'numberposts' => -1,
			'post_status' => 'publish'
		]);
		$selected_book = get_post_meta($post->ID, \SKB\ReviewMeta::BOOK_KEY, true);
		foreach ($books as $book): ?>
            <option value="<?= $book->ID ?>" <?= selected($selected_book, $book->ID, false) ?>>
				<?= esc_html($book->post_title) ?>
            </option>
		<?php endforeach; ?>
    </select>
</p>