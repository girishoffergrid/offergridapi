<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once dirname(__FILE__).'/function/function_get_google_campain.php';
require_once dirname(__FILE__).'/function/function_create_google_campain.php';
require_once dirname(__FILE__).'/function/function_update_google_campain.php';
require_once dirname(__FILE__).'/function/function_remove_google_campain.php';
require_once UTIL_PATH . '/MediaUtils.php';
try {
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
  $user = new AdWordsUser();

  // Log every SOAP XML request and response.
  $user->LogAll();

  // Run the example.
  //createGoogleCampain($user,5000000,'girish-kumar');
    
  // createGoogleGroups($user,'202940005','giri-test-1',500000);
  //createGoogleTextAds($user,'19202982685');
  
  // GetGoogleCampaigns($user);
  //GoogleAddKeywords($user, '19202982685', 'hi how are u ', 'BROAD');
  //GoogleAddKeywords($user, '19202982685', 'hoe am i','PHRASE');
  
  GetGoogleAdGroups($user,'202940005');
  
  //GetGoogleTextAds($user, '19202982685');
  
  //GetGoogleKeywords($user,'19202982685');
  
  //UpdateGoogleAdGroup($user, '19202982685', 0.75);
 
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}
