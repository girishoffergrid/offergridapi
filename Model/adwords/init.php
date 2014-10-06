<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$depth = '/';
define('SRC_PATH', dirname(__FILE__) . $depth . 'lib/');
define('LIB_PATH', 'Google/Api/Ads/AdWords/Lib');
define('UTIL_PATH', 'Google/Api/Ads/Common/Util');
define('ADWORDS_UTIL_PATH', 'Google/Api/Ads/AdWords/Util');

define('ADWORDS_VERSION', 'v201406');

// Configure include path
ini_set('include_path', implode(array(
    ini_get('include_path'), PATH_SEPARATOR, SRC_PATH
)));

// Include the AdWordsUser
require_once LIB_PATH . '/AdWordsUser.php';