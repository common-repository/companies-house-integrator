<?php

function coho_admin_companies_menu(){
	$value = get_option('companies_house_finder_options');
	if($value == ''){
		?>
		<h3><?php echo esc_html__('Plugin instructions');?></h3>
		<p style="max-width: 600px;">
		<?php echo esc_html__('The plugin will allow you to automatically import a Companies House entity into your Wordpress site as a user and assign them as whatever user Type you have available as an option, including as a Customer on Woocommerce.');?>
		<br><br>
		<?php echo esc_html__('In order to make the plugin work you need to register with Companies House');?> <a href="https://account.companieshouse.gov.uk/oauth2/user/signin?request=eyJhbGciOiJkaXIiLCJ0eXAiOiJKV0UiLCJlbmMiOiJBMTI4Q0JDLUhTMjU2In0..Tm4pKOr5wDSk_YEwJz1vlg.PLO--JM8nX06PPB-zslXcHuwPomMtT36T7noxJERV7MWJF6yZtMD8FEzw5PjaiD_QtLM0LkhL25L2vD4mlJ-Cfpw1S8N4RT_DP0mzApJCqvx3z0akz4Ry-0n79_6F6CsVjRYKnfSiA0iEL6uT4z4MRtZke4xGDwezW5lbklI13MxhIXN4PXLCi35shEzAIp1GvxiBJ-LFwcWfD-oaruXl2N6_rWCouBLO8cbb9kUIWz3BXvBz4t5ypYYkVYwbwsbzU-2Y2jk1jZbmaGsnq21eo5pXVfZAmBWxsigg7RG28nwTl2Cz-fdTJMKkxeny9Lpsy8VWI2xMRCoeCWsnhkSevzcJPSfsNp64P2Aq10-k3N97k01Mkk5J2FTuTJUYq1szFBe5-Bl0l-VDUAOZlSBLfP_X2Ar-dNaTijWaExO0JG54H5mxk_oaA7WmywdNQBifbp7e1gfzSIDfCwWNkoLqbIb21RA7MyKHvLglRZhWEjt8M8ewLA0FgJNrx8Kn4yuszPUTmvoKaoMNiPOE2LEx-ft7vnBuMru3ImGCOa63z0p1TZ0LOX9rNj47ZXxxp5hlG16Rduj9BwctrUh1Ur-IyTdzJVMN4BvGX_mrfjQcmM.esYOux8ZXdzYfUtDdAuiPw"><?php echo esc_html__('here');?></a> <?php echo esc_html__('or search ‘Companies House API account’ and follow the instructions, activate your email and then obtain an API key under the Your Applications tab.');?> 
		<br><br>
		<?php echo esc_html__('Once you enter the plugin name, an API code will appear which you enter into our plugin and you will be able to use it ongoing.');?>
		<br><br>
		<?php echo esc_html__('Enjoy!');?>
		<br><br>

		</p>
		<?php
	}
	?>
		<div id="message1" style="    border-left-color: #ba0000" class="updated woocommerce-message"><h3 style="margin: 10px;"><?php echo esc_html__('Companies House Api Key');?></h3></div>
		<div style="background-color: #fff;box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);margin: 5px 15px 2px;padding: 29px 11px;">
		<?php 
		coho_api_companies_connect_option();
		?>
	</div>
			<br>
			<br>
			<br>
			<?php
	if($value != ''){
		?><hr/>
		<div id="message1" class="updated woocommerce-message"><h3 style="margin: 10px;"><?php echo esc_html__('Add Company User');?></h3></div>
		<div style="background-color: #fff;box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);margin: 5px 15px 2px;padding: 1px 11px;">
		<?php
		coho_add_companies_house_api();
		?>
		</div>
				<br>
				<br>
				<br>
		<div id="compcontent"></div>
		<?php
	}
	
}
