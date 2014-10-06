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
 * @author shashank
 */

interface OG_AE_adgroup {
    public function __construct();
    
    public function getGoogleAdGroup();
    
    public function setGoogleAdGroup($adgroup);
    
    public function createGoogleAdGroup($campaignId, $adsGroupName, $campMoney_per_click);
    
    public function  readGoogleAdGroups($campaignId);
    
    public function pauseEnableGoogleAdGroup($campaignId,$ENABLED_or_PAUSED_REMOVED);
    
    public function updateGoogleAdGroup( $adGroupId, $money_to_update);
}
