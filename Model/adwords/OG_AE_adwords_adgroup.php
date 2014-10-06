<?php

require_once dirname(dirname(__FILE__)).'/base/OG_AE_adgroup.php';
require_once 'OG_AE_adwords_base.php';

/*
 * Copyright OfferGrid Networks
 *   * 
 */

/**
 * Description of OG_AE_adwords_adgroups
 *
 * 
 */
class OG_AE_Google_adwords_adgroup extends OG_AE_adwords_base implements OG_AE_adgroup {
    private $adgroup;
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function getGoogleAdGroup()
    {
        return $this->adgroup;
    }
    
    public function setGoogleAdGroup($adgroup)
    {
        return $this->adgroup = $adgroup;
    }
    
    public function createGoogleAdGroup($campaignId, $adsGroupName, $campMoney_per_click)
    {
        $user = $this->getUser();
        
        // Get the service, which loads the required classes.
        $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

        $operations = array();

        // Create ad group.
        $adGroup = new AdGroup();
        $adGroup->campaignId = $campaignId;
        $adGroup->name = $adsGroupName;

        // Set bids (required).
        $bid = new CpcBid();
        $bid->bid = new Money($campMoney_per_click);
        $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        $biddingStrategyConfiguration->bids[] = $bid;
        $adGroup->biddingStrategyConfiguration = $biddingStrategyConfiguration;

        // Set additional settings (optional).
        $adGroup->status = 'ENABLED';

        // Targetting restriction settings - these setting only affect serving
        // for the Display Network.
        $targetingSetting = new TargetingSetting();
        // Restricting to serve ads that match your ad group placements.
        $targetingSetting->details[] = new TargetingSettingDetail('PLACEMENT', TRUE);
        // Using your ad group verticals only for bidding.
        $targetingSetting->details[] = new TargetingSettingDetail('VERTICAL', FALSE);
        $adGroup->settings[] = $targetingSetting;

        // Create operation.
        $operation = new AdGroupOperation();
        $operation->operand = $adGroup;
        $operation->operator = 'ADD';
        $operations[] = $operation;

        // Make the mutate request.
        $result = $adGroupService->mutate($operations);

        // Display result.
        $adGroup = $result->value[0];
        $adGroups_id_name = array('id'=> $adGroup->id, 'name' => $adGroup->name);

        return $adGroups_id_name;
    }
    
  //-----------------------------------------------------------------------------------------------   
    public function readGoogleAdGroups($campaignId)
    {
        $user = $this->user;
        // Get the service, which loads the required classes.
        $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Id', 'Name','AdGroupAd.Status','Label','AdGroupAd.ApprovalStatus');
        $selector->ordering[] = new OrderBy('Name', 'ASCENDING');

        // Create predicates.
        $selector->predicates[] = new Predicate('CampaignId', 'IN', array($campaignId));

        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

        
            // Make the get request.
            $page = $adGroupService->get($selector);

            $get_google_adgroups_id_name = array();

            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroup) {
                    //printf("Ad group with name '%s' and ID '%s' was found.\n",
                    //  $adGroup->name, $adGroup->id);
                    $get_google_adgroups_id_name[] = array( 'id'    => $adGroup->id ,
                                                            'name'  => $adGroup->name,
                                                            'status'=> $adGroup->status,
                                                            'lable' => $adGroup->lables,
                                                            'aprovalStatus' => $adGroup->approvalStatus
                                                            
                                                          );
                }
            } 
            else {
                $get_google_adgroups_id_name = 'no ad groups';
            }
            return $get_google_adgroups_id_name;
            // Advance the paging index.
            
    }
    
  //----------------------------------------------------------------------------------------------- 
    
    public function pauseEnableGoogleAdGroup($campaignId,$ENABLED_or_PAUSED_REMOVED)
    {
        $user = $this->user;
        // Get the service, which loads the required classes.
        $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

        // Create ad group with REMOVED status.
        $adGroup = new AdGroup();
        $adGroup->id = $adGroupId;
        $adGroup->status = $ENABLED_or_PAUSED_REMOVED;

        // Create operations.
        $operation = new AdGroupOperation();
        $operation->operand = $adGroup;
        $operation->operator = 'SET';

        $operations = array($operation);

        // Make the mutate request.
        $result = $adGroupService->mutate($operations);

        // Display result.
        $adGroup = $result->value[0];
        //printf("Ad group with ID '%d' was removed.\n", $adGroup->id);
        return $adGroup->status;
    }
    
 //----------------------------------------------------------------------------------------------- 
    
    
    public function updateGoogleAdGroup( $adGroupId, $money_to_update) {
        $user = $this->user;
        // Get the service, which loads the required classes.
        $adGroupService = $user->GetService('AdGroupService', ADWORDS_VERSION);

        // Create ad group using an existing ID.
        $adGroup = new AdGroup();
        $adGroup->id = $adGroupId;

        // Update the bid.
        $bid = new CpcBid();
        $bid->bid = new Money($money_to_update * AdWordsConstants::MICROS_PER_DOLLAR);
        $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
        $biddingStrategyConfiguration->bids[] = $bid;
        $adGroup->biddingStrategyConfiguration = $biddingStrategyConfiguration;

        // Create operation.
        $operation = new AdGroupOperation();
        $operation->operand = $adGroup;
        $operation->operator = 'SET';

        $operations = array($operation);

        // Make the mutate request.
        $result = $adGroupService->mutate($operations);

        // Display result.
        $adGroup = $result->value[0];
       // printf("Ad group with ID '%s' has updated default bid '$%s'.\n", $adGroup->id, $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount /
         //       AdWordsConstants::MICROS_PER_DOLLAR);


        $updated_id_money = array('id' => $adGroup->id , 
                                  'money' => $adGroup->biddingStrategyConfiguration->bids[0]->bid->microAmount /
                AdWordsConstants::MICROS_PER_DOLLAR);

        return $updated_id_money;
    }
 //----------------------------------------------------------------------------------------------- 
}
