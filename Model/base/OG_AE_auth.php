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

interface OG_AE_auth {
    
    public function getUser();

    public function setUser($user);

    public function doAuth($user = NULL);
    
}