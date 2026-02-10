<?php

namespace SKB;

$meta = BookMeta::getInstance();
?>

<?php wp_nonce_field( BookMeta::NONCE_ACTION, BookMeta::NONCE_FIELD ); ?>
<p>
	<label for="<?= BookMeta::PUBLISHER_KEY ?>">Publisher:</label>
	<input
		type="text"
		id="<?= BookMeta::PUBLISHER_KEY ?>"
		name="<?= BookMeta::PUBLISHER_KEY ?>"
		value="<?= $meta->getPublisher() ?>"
		style="width: 100%;"
	/>
</p>
<p>
	<label for="<?= BookMeta::PUBLISHED_DATE_KEY ?>">Published Date:</label>
	<input
		type="date"
		id="<?= BookMeta::PUBLISHED_DATE_KEY ?>"
		name="<?= BookMeta::PUBLISHED_DATE_KEY ?>"
		value="<?= $meta->getPublishedDate() ?>"
		style="width: 100%;"
	/>
</p>
<p>
	<label for="<?= BookMeta::PAGE_COUNT_KEY ?>">Page Count:</label>
	<input
		type="number"
		id="<?= BookMeta::PAGE_COUNT_KEY ?>"
		name="<?= BookMeta::PAGE_COUNT_KEY ?>"
		value="<?= $meta->getPageCount() ?>"
		min="1"
		style="width: 100%;"
	/>
</p>
<p>
	<label for="<?= BookMeta::PRICE_KEY ?>">Price ($):</label>
	<input
		type="number"
		step="0.01"
		id="<?= BookMeta::PRICE_KEY ?>"
		name="<?= BookMeta::PRICE_KEY ?>"
		value="<?= $meta->getPrice() ?>"
		min="0"
		style="width: 100%;"
	/>
</p>
