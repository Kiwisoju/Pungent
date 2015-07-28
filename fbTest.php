<?php

/* INCLUSION OF LIBRARY FILEs*/
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/FacebookSession.php');
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/FacebookRequest.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/FacebookResponse.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/FacebookSDKException.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/FacebookRequestException.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/FacebookRedirectLoginHelper.php');
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/FacebookAuthorizationException.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/GraphObject.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/GraphUser.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/GraphSessionInfo.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/Entities/AccessToken.php');
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/HttpClients/FacebookCurl.php' );
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/HttpClients/FacebookHttpable.php');
	require_once( 'vendor/facebook/php-sdk-v4/Facebook/HttpClients/FacebookCurlHttpClient.php');
/* USE NAMESPACES */
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;
	use Facebook\FacebookHttpable;
	use Facebook\FacebookCurlHttpClient;
	use Facebook\FacebookCurl;




$fb = new Facebook\Facebook([
  'app_id' => '{469336573246700}',
  'app_secret' => '{32c46b4268b6f882db3a6f2d1cdf3211}',
  'default_graph_version' => 'v2.2',
  ]);
  
  
  $helper = new FacebookRedirectLoginHelper($redirect_url);
  var_dump($helper);

?>