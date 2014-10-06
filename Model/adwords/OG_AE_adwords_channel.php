<?php
require_once dirname(dirname(__FILE__)).'/base/OG_AE_channel_1.php';
require_once 'OG_AE_adwords_base.php';
require_once 'OG_AE_adwords_campaign.php';
require_once 'OG_AE_adwords_campaigns.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OG_AE_adwords_channel
 *
 * 
 */
class OG_AE_adwords_channel extends OG_AE_adwords_base implements OG_AE_channel_1{
    
    const pid = 581;
    
    public $campaign;
    public $campaigns;

     public function __construct() {

        parent::__construct();         
        $this->campaign = new OG_AE_adwords_campaign;
        $this->campaigns = new OG_AE_adwords_campaigns;

    }




}
