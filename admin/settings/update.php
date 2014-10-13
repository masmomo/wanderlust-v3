<?php
// INSERT tbl_general
function insert_general($url, $title, $description, $keywords, $analytics, $phone, $email, $address, $country, $province, $city, $postal, $facebook, $twitter, $instagram, $currency, $logo){
   $sql   = "INSERT INTO tbl_general  
             (url, 
			  website_title, 
			  website_description, 
			  website_keywords,
			  analytics_code, 
			  company_phone,
			  company_email,
			  company_address, 
			  company_country, 
			  company_province, 
			  company_city, 
			  company_postal_code, 
			  company_facebook, 
			  company_twitter,
			  company_instagram,  
			  currency_rate, 
			  logo) 
			  ) 
			  VALUES
			  ('$url',
			   '$title',
			   '$description',
			   '$keywords',
			   '$analytics',
			   '$phone',
			   '$email',
			   '$address',
			   '$country',
			   '$province',
			   '$city',
			   '$postal',
			   '$facebook',
			   '$twitter',
			   '$instagram',
			   '$currency',
			   '$logo')";
   $query = mysql_query($sql) or die (mysql_error());
}


// UPDATE tbl_general
function update_general($url, $title, $description, $keywords, $analytics, $phone, $email, $address, $country, $province, $city, $postal, $facebook, $twitter, $instagram, $currency, $logo){
   $sql   = "UPDATE `tbl_general` SET `url` = '$url',
			        `website_title` = '$title',
				    `website_description` = '$description',
					`website_keywords` = '$keywords',
				    `analytics_code` = '$analytics',
				    `company_phone` = '$phone',
				    `company_email` = '$email',
				    `company_address` = '$address',
				    `company_country` = '$country',
				    `company_province` = '$province',
				    `company_city` = '$city',
				    `company_postal_code` = '$postal',
				    `company_facebook` = '$facebook',
				    `company_twitter` = '$twitter',
					`company_instagram` = '$instagram',
				    `currency_rate` = '$currency',
					`logo` = '$logo'
			WHERE `general_id` = '1'";
   $query = mysql_query($sql) or die(mysql_error());
}




?>