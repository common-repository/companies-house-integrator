<?php

/**
 * Display a custom menu page
 */
function coho_api_companies_connect_option(){
	if (isset($_POST) && isset($_POST['cohononce'])) {
		if ( wp_verify_nonce( $_POST['cohononce'], 'coho-nonce' ) ) {
			
			if (isset($_POST['companies_house_finder_options'])) {
				update_option('companies_house_finder_options', sanitize_text_field($_POST['companies_house_finder_options']));
				$value = sanitize_text_field($_POST['companies_house_finder_options']);
			} 
			if (isset($_POST['companies_house_finder_optionsurl'])) {
				update_option('companies_house_finder_optionsurl', sanitize_text_field($_POST['companies_house_finder_optionsurl']));
				$valueUrl = sanitize_text_field($_POST['companies_house_finder_optionsurl']);
			} 
			
		}else{
			die( 'Security check' ); 
		}
		
	}
	
    $value = get_option('companies_house_finder_options', '');

    $valueUrl = get_option('companies_house_finder_optionsurl', '');
	?>

	<form method="POST">
		<input type="hidden" name="cohononce" value="<?php echo wp_create_nonce( 'coho-nonce' ); ?>">
		<label for="companies_house_finder_options">Your Api Key</label>
		<input type="text" name="companies_house_finder_options" id="companies_house_finder_options" class="regular-text ltr" value="<?php echo $value; ?>">
		<br><br>
		<label for="companies_house_finder_optionsurl">Your Api URL</label>
		<input type="text" name="companies_house_finder_optionsurl" id="companies_house_finder_optionsurl" class="regular-text ltr" value="<?php echo $valueUrl; ?>">
		<br><br>
		<input type="submit" value="Save" class="button button-primary button-large">
	</form>
	<?php
	
}