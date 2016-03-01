<?php
if(!empty($_POST)){
	require_once __DIR__.'/../vendor/autoload.php';
	/*
	connect to database
	 */
	$db = new CodeKashmir\UrlShortner\Db();
	/*
	 instantiate Url shortener service
	*/
	$urlShortner = new CodeKashmir\UrlShortner\UrlShortner($db->dbh);
	/*
		output shortened Url
	*/
	echo $urlShortner->shortn($_POST['siteurl']);
	die();
}
if(!empty($_GET['q'])) 
{
	print_r($_GET['q']);
	//find actual url
	$shortUrl = $urlShortner->findActualUrl($_GET['q']);
	if($shortUrl){
		//redirect
		header('location:'+$url);
		die();
	}
}
?>
<html lang="en" >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Angular Material style sheet -->
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.css">
	<link rel="stylesheet" type="text/css" href="css/app.css">
</head>
<body ng-app="UrlShortner" ng-cloak>
  <!--
    HTML content here
  -->
  	<div flex="100" ng-controller="AppCtrl">
		<md-content>
			<md-toolbar>
		    	<div class="md-toolbar-tools">
		       		Convert your lengthy Urls into shorter one.
		    	</div>
		    </md-toolbar>
		    <div layout="row" layout-align="center" layout-gt-sm="row">
		    	<form id="urlShortnerForm" name="urlShortnerForm" method="post" flex="80" flex-gt-xs="50">
		    		<md-input-container class="md-block">
					    <label>Paste your lengthy url here</label>
					    <input name="siteurl" ng-model="siteurl" type="url" required />
					    <div ng-messages="urlShortnerForm.siteurl.$error" ng-show="urlShortnerForm.siteurl.$dirty">
					    	<div ng-message="required">This is required!</div>
					    	<div ng-message="url">Url is invalid</div>
					    </div>
	  				</md-input-container>
	  				<div layout="row" layout-align="center" ng-if="isShortening">
	  				 	<md-progress-circular class="md-info" md-diameter="70">
	  				 	</md-progress-circular>
	  				</div>
	  				<div layout="row" layout-align="center" ng-if="isShortening">
	  					<span>Shortening ...</span>
	  				</div>
	  				<div layout="row" layout-align="center" ng-if="!isShortening">
	  					<md-button class="md-raised md-primary" ng-click="submitURL()">Shorten URL</md-button>
	  				</div>
		    	</form>
		    </div>
		</md-content>  
	</div>
  
	<!-- Angular Material requires Angular.js Libraries -->
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-aria.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-messages.min.js"></script>

	<!-- Angular Material Library -->
	<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.js"></script>

	<!-- Your application bootstrap  -->
	<script src= "js/app.js" type="text/javascript"></script>  
</body>
</html>