<?php

require_once dirname(dirname(__FILE__)).'/base/OG_AE_base.php';
require_once 'init.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OG_AE_adwords_base
 *
 *
 */
class OG_AE_adwords_base implements OG_AE_base {

    private $user;
    
    public function __construct() {
        $this->doAuth();
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(AdWordsUser $user) {
        return $this->user = $user;
    }

    public function doAuth(AdWordsUser $user = NULL) {
        if (is_null($user)) {
            $user = new AdWordsUser();
        }
        return $this->user = $user;
        //return $user->logall();
    }

}
