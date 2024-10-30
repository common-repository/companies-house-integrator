<?php

	/**
	* Companies House PHP API
	*
	* This Companies House PHP API wrapper lets you get informations about companies,
	* officers, fillings and everything else that the Companies House makes public for
	* everyone to see.
	*
	* @link      	https://github.com/GRITnet/Companies-House-PHP-API
	* @wiki		https://github.com/GRITnet/Companies-House-PHP-API/wiki
	* @author	George Dobre (george.dobre@gritnet.uk)
	* @copyright 	Copyright (c) 2016 GRITNET LIMITED (http://gritnet.uk)
	* @license   	https://www.gnu.org/licenses/gpl.html
	* @since     	File available since Release 1.0.0
	* VERSION : 1.00
	*/
	

	class Companies_House
	{
		private $_ApiKey 	= 	'';
		private $_Endpoint 	= 	'https://api.companieshouse.gov.uk';
		public function __construct($sss,$url) {
			$this->_ApiKey = $sss;
			$this->_Endpoint = $url;
			
			
		}
		/**
		* Search
		*
		* Query parameters:
		* @param (string) 	query - The term being searched for
		* @param (string)	type - Search in companies, officers or disqualified officers informations
		* Possible values are: companies (default), officers, disqualified-officers
		* @param (array)	query_string
		* 	@key (integer) items_per_page - The number of search results to return per page *optional*
		* 	@key (integer) start_index - The index of the first result item to return *optional*
		*
		* @return array
		*/
		
		public function search($query, $type = 'companies', $query_string = array())
		{
			$query = str_replace(" ","+",$query);
			$query_string = http_build_query($query_string);
			
			if(empty($query_string))
			{
				$query_string = '/' . $type . '?q=' . $query;
			}
			else
			{
				$query_string = '/' . $type . '?q=' . $query . '&' . $query_string;
			}
			
		
			
			$args = array(
				'timeout'     => 5,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers' 	=> [
									'Authorization' => $this->_ApiKey,
								],
				'cookies'     => array(),
				'body'        => null,
				'compress'    => false,
				'decompress'  => true,
				'sslverify'   => true,
				'stream'      => false,
				'filename'    => null
			); 
			$result = wp_remote_get( $this->_Endpoint . '/search' . $query_string, $args );
			$status = $result['response']['code'];
			$res =json_decode($result['body']);
			$resitems = $res->items;
			
			foreach ($resitems as $row){
				$response[] = array("value"=>$row->company_number,"label"=>$row->title);
			}
			
			if($status==200)
			{
				echo json_encode($response);
			}
			else
			{
				return false;
			}

		}
		/** 
		* Get the basic company information
		*
		* Query parameters: 
		* (string) company_number - The company number of the basic information to return
		*/
		
		public function company_profile($company_number)
		{
			$args = array(
				'timeout'     => 5,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers' 	=> [
									'Authorization' => $this->_ApiKey,
								],
				'cookies'     => array(),
				'body'        => null,
				'compress'    => false,
				'decompress'  => true,
				'sslverify'   => true,
				'stream'      => false,
				'filename'    => null
			); 
			$result = wp_remote_get( $this->_Endpoint . '/company/' . $company_number, $args );
			$status = $result['response']['code'];
			$res = $result;
			
			
			if($status==200)
			{
				return json_encode($res, true);
			}
			else
			{
				return false;
			}

			
			
		}
		
		
		/** 
		* List the company officers
		*
		* Query parameters: 
		* (string) 	company_number - The company number of the officer list being requested
		* (array)	query_string
		* 	(integer) 	items_per_page - The number of officers to return per page
		* 	(integer) 	start_index - The offset into the entire result set that this page starts
		* 	(string)	order_by - The field by which to order the result set. 
		* 	Possible values are: appointed_on, resigned_on, surname
		* Director [name] and postal_code
		*/
		
		public function company_officers($company_number, $query_string = array())
		{
			$query_string = http_build_query($query_string);
			
			if(empty($query_string))
			{
				$query_string = '/officers';
			}
			else
			{
				$query_string = '/officers?' . $query_string;
			}
			$args = array(
				'timeout'     => 5,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers' 	=> [
									'Authorization' => $this->_ApiKey,
								],
				'cookies'     => array(),
				'body'        => null,
				'compress'    => false,
				'decompress'  => true,
				'sslverify'   => true,
				'stream'      => false,
				'filename'    => null
			); 
			$result = wp_remote_get( $this->_Endpoint . '/company/' . $company_number . '/officers', $args );
			$status = $result['response']['code'];
			$res = $result['body'];
			
			if($status==200)
			{
				
				return json_decode($res, true);
			}
			else
			{
				return false;
			}
			
			
			
		}
		
		
	
	}
	
?>
