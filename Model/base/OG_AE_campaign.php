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

interface OG_AE_campaign {
    public function __construct();
    
    public function getCampaignId();
    
    public function setCampaignId($campaign_id);
    
    public function getCampaign();
    
    public function setCampaign( $campaign );
    
    public function createCampaign($campain_Name,$money_per_day) ;
    
    public function readCampaign();
    
    public function changeStatusCampaign( $campaignId,$ELIGIBLE_or_PAUSED_or_REMOVED);

    
}

