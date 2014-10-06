<?php

require_once 'OG_AE_campaign.php';
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

interface OG_AE_campaigns extends OG_AE_campaign {
    public function __construct();
    
    public function getCampaigns();
    
    public function setCampaigns( $campaigns );
    
    public function readCampaigns();
    
}