<form class="form-inline" id="searchform" role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
	<input class="form-control search-control" id="s" name="s" type="text" placeholder="<?php echo esc_attr__('Search', 'toocheke'); ?>">
	<button class="btn btn-danger" type="submit">
		<?php echo esc_html__('Search', 'toocheke'); ?>
	</button>
</form>