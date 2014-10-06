<?php
require_once 'OG_AE_ad.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * OG_AE_base
 * OfferGrid API Engine Base Class
 * Provides an interface to be implemented by different channels
 *
 * @category ChannelManagement
 * @package OG_AE_Channel
 * 
 */

interface OG_AE_ads extends OG_AE_ad {
    public function __construct() ;
    
    public function getGoogleTextAds();
    
    public function setGoogleTextAds();
    
    public function createGoogleTextAds($adGroupId,$headline,$description_1,$description_2,$display_url,$url);
    
    public function readGoogleTextAds($adGroupId);
    
    public function pauseEnableGoogleTextAd($adGroupId, $adId,$ENABLED_or_PAUSED);
}