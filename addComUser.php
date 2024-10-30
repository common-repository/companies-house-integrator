<?php
/**
 * add user
 */
function coho_add_user_companies($com_id , $userroles){

	$valueUrl = get_option('companies_house_finder_optionsurl', '');
	
	include('CompaniesHouse.php');
	$CompaniesHouse = new Companies_House(get_option( 'companies_house_finder_options' ),$valueUrl);

	//company officers information	
	$company_officers = $CompaniesHouse->company_officers($com_id);
		
	
	if(isset($company_officers['items']['0']['officer_role'])){
		$company_officers_officer_role 			= $company_officers['items']['0']['officer_role'];
	}else{
		$company_officers_officer_role 			= '';
	}
	if(isset($company_officers['items']['0']['address']['address_line_1'])){
		$company_officers_address_line_1 		= $company_officers['items']['0']['address']['address_line_1'];
	}else{
		$company_officers_address_line_1 			= '';
	}	
	if(isset($company_officers['items']['0']['address']['address_line_2'])){
		$company_officers_address_line_2 		= $company_officers['items']['0']['address']['address_line_2'];
	}else{
		$company_officers_address_line_2 			= '';
	}	
	if(isset($company_officers['items']['0']['address']['country'])){
		$company_officers_country 		= $company_officers['items']['0']['address']['country'];
	}else{
		$company_officers_country 			= '';
	}	
	if(isset($company_officers['items']['0']['address']['region'])){
		$company_officers_region 		= $company_officers['items']['0']['address']['region'];
	}else{
		$company_officers_region 			= '';
	}
	if(isset($company_officers['items']['0']['address']['postal_code'])){
		$company_officers_postal_code 		= $company_officers['items']['0']['address']['postal_code'];
	}else{
		$company_officers_postal_code 			= '';
	}	
	if(isset($company_officers['items']['0']['address']['locality'])){
		$company_officers_locality 		= $company_officers['items']['0']['address']['locality'];
	}else{
		$company_officers_locality 			= '';
	}	
	if(isset($company_officers['items']['0']['address']['premises'])){
		$company_officers_premises 		= $company_officers['items']['0']['address']['premises'];
	}else{
		$company_officers_premises 			= '';
	}	
	if(isset($company_officers['items']['0']['country_of_residence'])){
		$company_officers_country_of_residence 		= $company_officers['items']['0']['country_of_residence'];
	}else{
		$company_officers_country_of_residence 			= '';
	}	
	if(isset($company_officers['items']['0']['name'])){
		$company_officers_name 		= $company_officers['items']['0']['name'];
		$officer_name_array 					= explode(", ",$company_officers_name);
		$officer_name 							= $officer_name_array['0'];
		$officer_last_name 						= $officer_name_array['1'];
	}else{
		$company_officers_name 			= '';
		$officer_name					='';
		$officer_last_name				='';
	}	
	if(isset($company_officers['items']['0']['nationality'])){
		$company_officers_nationality 		= $company_officers['items']['0']['nationality'];
	}else{
		$company_officers_nationality 			= '';
	}


	/*
	* company profile information
	*/
	
	$company_profile 						= json_decode($CompaniesHouse->company_profile($com_id), true);
	$company_profile 						= json_decode($company_profile['body'], true);

	if(isset($company_profile['company_name'])){
		$company_profile_company_name 		= $company_profile['company_name'];
	}else{
		$company_profile_company_name 			= '';
		return 0;
	}
	if(isset($company_profile['registered_office_address']['address_line_1'])){
		$company_profile_address_line_1 		= $company_profile['registered_office_address']['address_line_1'];
	}else{
		$company_profile_address_line_1 			= '';
	}
	if(isset($company_profile['registered_office_address']['address_line_2'])){
		$company_profile_address_line_2 		= $company_profile['registered_office_address']['address_line_2'];
	}else{
		$company_profile_address_line_2 			= '';
	}
	if(isset($company_profile['registered_office_address']['locality'])){
		$company_profile_locality_address 		= $company_profile['registered_office_address']['locality'];
	}else{
		$company_profile_locality_address 			= '';
	}
	if(isset($company_profile['registered_office_address']['region'])){
		$company_profile_region 		= $company_profile['registered_office_address']['region'];
	}else{
		$company_profile_region 			= '';
	}
	if(isset($company_profile['registered_office_address']['postal_code'])){
		$company_profile_postal_code 		= $company_profile['registered_office_address']['postal_code'];
	}else{
		$company_profile_postal_code 			= '';
	}
	if(isset($company_profile['locality'])){
		$company_profile_locality 		= $company_profile['locality'];
	}else{
		$company_profile_locality 			= '';
	}


	
	// company name 
	$str_name_com 							= str_replace(" ","",$company_profile_company_name);


	
	//exit;
	
	$user_id = username_exists( $str_name_com );
	if ( !$user_id and email_exists($str_name_com.'@gmail.com') == false ) {
		$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
		$user_id = wp_create_user( $str_name_com, $random_password, $str_name_com.'@gmail.com' );
		//add user roles
		$u = new WP_User( $user_id );
		$u->set_role( $userroles );

		//add user meta
		add_user_meta( $user_id, 'company_officers_officer_role', $company_officers_officer_role);
		add_user_meta( $user_id, 'company_officers_address_line_1', $company_officers_address_line_1);
		add_user_meta( $user_id, 'company_officers_address_line_2', $company_officers_address_line_2);
		add_user_meta( $user_id, 'company_officers_country', $company_officers_country);
		add_user_meta( $user_id, 'company_officers_region', $company_officers_region);
		add_user_meta( $user_id, 'company_officers_postal_code', $company_officers_postal_code);
		add_user_meta( $user_id, 'company_officers_locality', $company_officers_locality);
		add_user_meta( $user_id, 'company_officers_premises', $company_officers_premises);
		add_user_meta( $user_id, 'company_officers_country_of_residence', $company_officers_country_of_residence);
		add_user_meta( $user_id, 'company_officers_name', $company_officers_name);
		
		update_user_meta( $user_id, 'last_name', $officer_name);
		update_user_meta( $user_id, 'first_name', $officer_last_name);
		
		
		add_user_meta( $user_id, 'company_profile_company_name', $company_profile_company_name);
		add_user_meta( $user_id, 'company_profile_address_line_1', $company_profile_address_line_1);
		add_user_meta( $user_id, 'company_profile_address_line_2', $company_profile_address_line_2);
		add_user_meta( $user_id, 'company_profile_locality_address', $company_profile_locality_address);
		add_user_meta( $user_id, 'company_profile_region', $company_profile_region);
		add_user_meta( $user_id, 'company_profile_postal_code', $company_profile_postal_code);
		add_user_meta( $user_id, 'company_profile_locality', $company_profile_locality);
		
		if ( class_exists( 'WooCommerce' ) ) {
		  // code that requires WooCommerce
		  //billing  billing_ city
		  add_user_meta( $user_id, 'billing_company', $company_profile_company_name);
		  add_user_meta( $user_id, 'billing_address_1', $company_profile_address_line_1);
		  add_user_meta( $user_id, 'billing_address_2', $company_profile_address_line_2);
		  add_user_meta( $user_id, 'billing_city', $company_profile_region);
		  add_user_meta( $user_id, 'billing_postcode', $company_profile_postal_code);
		  
		  //shipping
		  add_user_meta( $user_id, 'shipping_company', $company_profile_company_name);
		  add_user_meta( $user_id, 'shipping_address_1', $company_profile_address_line_1);
		  add_user_meta( $user_id, 'shipping_address_2', $company_profile_address_line_2);
		  add_user_meta( $user_id, 'shipping_city', $company_profile_region);
		  add_user_meta( $user_id, 'shipping_postcode', $company_profile_postal_code);
		  add_user_meta( $user_id, 'shipping_last_name', $officer_name);
		  add_user_meta( $user_id, 'shipping_first_name', $officer_last_name);
		  
		}
		
		return $user_id;
	} else {
		$random_password = __('User already exists.  Password inherited.');
		return false;
	}
	
	
}
 
/**
 * Display a custom menu page
 */
 
 
 
 


//add com user
function coho_add_companies_house_api(){
	if (isset($_POST) && isset($_POST['cohononceadd'])) {
		if ( wp_verify_nonce( $_POST['cohononceadd'], 'coho-nonce-add-user' ) ) {
			
			if(isset($_POST['selectuser_id']) && $_POST['selectuser_id'] != ''){
	
				$addUser = coho_add_user_companies(sanitize_text_field($_POST['selectuser_id']),sanitize_text_field($_POST['userroles']));
				if($addUser){
					wp_redirect('user-edit.php?user_id='.$addUser);
				}else{
					 echo esc_html__('No Save user');
				}
				
			}
			
		}else{
			die( 'Security check ,No Save user' ); 
		}
		
	}
	?>
	
	<form action="#" method="post">
	<input type="hidden" name="cohononceadd" value="<?php echo wp_create_nonce( 'coho-nonce-add-user' ); ?>">
      <table>
        <tr>
            <td><?php echo esc_html__('Company name');?></td>
            <td>
				<input type='text' id='autocomplete' class='regular-text ltr' >
				<input type='hidden' id='selectuser_id' name="selectuser_id"/>
			</td>
   
            <td><?php echo esc_html__('User roles');?></td>
            <td>
				<select id='userroles' name="userroles">
					<option value="subscriber"><?php echo esc_html__('Select User Roles');?></option>
				  <?php foreach (get_editable_roles() as $role_name => $role_info): ?>
					<option value="<?php echo esc_html__($role_name); ?>"><?php echo esc_html__( $role_name );?></option>
				  <?php endforeach; ?>
				</select>
			</td>
        </tr>
		<tr>
            <td></td>
            <td>
				<input type="submit" value="<?php echo esc_html__('Save User');?>">
			</td>
			 <td></td>
			  <td></td>
        </tr>
    </table>
	</form>
	
	<?php
}



function coho_load_jquery_ui_autocomplete() {
        wp_enqueue_style( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
}
add_action( 'admin_enqueue_scripts', 'coho_load_jquery_ui_autocomplete' );



add_action( 'admin_footer', 'coho_ajax_send_javascript' ); // Write our JS below here

//function my_action_javascript() { 
function coho_ajax_send_javascript() { ?>
    <script type='text/javascript' >
    jQuery( function() {
  
        jQuery( "#autocomplete" ).autocomplete({

            source: function( request, response ) {
                
                jQuery.ajax({
                    url: "<?php echo admin_url( 'admin-ajax.php' );?>",
                    type: 'post',
                    dataType: "json",
                    data: {
						
						'action': 'coho_search_companies_by_title',
                        search: request.term
						
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                jQuery('#autocomplete').val(ui.item.label); // display the selected text
                jQuery('#selectuser_id').val(ui.item.value); // save selected id to input					
				//jQuery( '#compcontent' ).html( data );
				jQuery.ajax({
                    url: "<?php echo admin_url( 'admin-ajax.php' );?>",
                    type: 'post',
                    
                    data: {
						
						'action': 'coho_get_companies_by_id',
                        search: ui.item.value
						
                    },
                    success: function( data ) {
						var arrayes = JSON.parse(data);
						var htmlnew = '<div id="message" class="updated woocommerce-message"><h3 style="margin: 10px;"> User Information </h3></div>';
                        htmlnew += '<div style="background-color: #fff;box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);margin: 5px 15px 2px;padding: 1px 11px;">';
						htmlnew += '<table style="    margin: 10px;">';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;    padding-right: 80px;">Company Name : </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				ui.item.label;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;">Company Id: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				ui.item.value;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;    padding-right: 80px;">Occupation: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				arrayes.items[0].occupation;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;">Name: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				arrayes.items[0].name;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;">Address Line 1: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				arrayes.items[0].address.address_line_1;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;">Address Line 2: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				arrayes.items[0].address.address_line_2;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;">Locality: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				arrayes.items[0].address.locality;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;">Postal code: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				arrayes.items[0].address.postal_code;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew +='		<tr>';
						htmlnew +='			<td style="    padding: 10px;"><h3 style="margin: 0px;">Region: </h3></td>';
						htmlnew +=' 		<td style="    padding: 10px;">';
						htmlnew +=				arrayes.items[0].address.region;
						htmlnew +='			</td>';
						htmlnew +='		</tr>';
						htmlnew += '</table>';
						htmlnew += '</div>';

			
						jQuery( '#compcontent' ).html( htmlnew );
						//response( data );
						console.log(arrayes);
                    }
                });
				
                return false;
            }
        });


    });

    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    </script>
	 <?php
}

if ( is_user_logged_in() ) {
    add_action( 'wp_ajax_coho_search_companies_by_title', 'coho_search_companies_by_title' );
} else {
    add_action( 'wp_ajax_nopriv_coho_search_companies_by_title', 'coho_search_companies_by_title' );
}

function coho_search_companies_by_title() {
		$valueUrl = get_option('companies_house_finder_optionsurl', '');
	if($valueUrl == ''){
		$valueUrl = 'https://api.companieshouse.gov.uk';
	}
	include('CompaniesHouse.php');
	$CompaniesHouse = new Companies_House(get_option( 'companies_house_finder_options' ),$valueUrl);

	$CompaniesHouse->search(sanitize_text_field($_POST['search']));
    
	wp_die();
}


if ( is_user_logged_in() ) {
    add_action( 'wp_ajax_coho_get_companies_by_id', 'coho_get_companies_by_id' );
} else {
    add_action( 'wp_ajax_nopriv_coho_get_companies_by_id', 'coho_get_companies_by_id' );
}


//get companies from companies id
function coho_get_companies_by_id() {
		$valueUrl = get_option('companies_house_finder_optionsurl', '');
	if($valueUrl == ''){
		$valueUrl = 'https://api.companieshouse.gov.uk';
	}
	include('CompaniesHouse.php');
	$CompaniesHouse = new Companies_House(get_option( 'companies_house_finder_options' ),$valueUrl);

	$company_profile = $CompaniesHouse->company_profile(sanitize_text_field($_POST['search']));
	$company_officers = $CompaniesHouse->company_officers(sanitize_text_field($_POST['search']));

	print_r( json_encode($company_officers));
    
	wp_die();
}