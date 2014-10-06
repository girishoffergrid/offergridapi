<?php
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

interface OG_AE_Campaign_reports {
   
    public function __construct();

    public function googleAdwordsCampaignPerformanceReoprt($dateRange);
    
    
}

interface OG_AE_adGroup_report{
    public function __construct();
    
    public function AdGroupPerformanceReport($dateRange);
    
}

interface OG_AE_TextAd_reports {
    public function __construct();
    
    public function googleTextAdsReport($dateRange);
}

interface OG_AE_keyWords_report{
     public function __construct();
     
      public function KeyPerformanceReport($dateRange);
}