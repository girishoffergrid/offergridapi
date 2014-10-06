<?php

require_once dirname(dirname(__FILE__)).'/base/OG_AE_adgroup.php';
require_once 'OG_AE_adwords_base.php';
require_once UTIL_PATH . '/MediaUtils.php';

/*
 * Copyright OfferGrid Networks
 *   * 
 */

/**
 * Description of OG_AE_adwords_adgroups
 *
 * 
 */
class OG_AE_Google_adwords_textads extends OG_AE_adwords_base implements OG_AE_textads
{
    
    private $textAds;
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function getGoogleTextAds()
    {
        return $this->textAds;
    }
    public function setGoogleTextAds()
    {
        return $this->textAds = $textAds;
    }
    //-----------------------------------------------------------------------------------------------  
    public function createGoogleTextAds($adGroupId,$headline,$description_1,$description_2,$display_url,$url)
    {
        $user = $this->user;
        // Get the service, which loads the required classes.
        $adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);

        
        $operations = array();
        
            // Create text ad.
            $textAd = new TextAd();
            $textAd->headline = $headline . uniqid();
            $textAd->description1 = $description_1;
            $textAd->description2 = $description_2;
            $textAd->displayUrl = $display_url;
            $textAd->url = $url;

            // Create ad group ad.
            $adGroupAd = new AdGroupAd();
            $adGroupAd->adGroupId = $adGroupId;
            $adGroupAd->ad = $textAd;

            // Set additional settings (optional).
            $adGroupAd->status = 'ENABLED';

            // Create operation.
            $operation = new AdGroupAdOperation();
            $operation->operand = $adGroupAd;
            $operation->operator = 'ADD';
            $operations[] = $operation;
        

        // Make the mutate request.
        $result = $adGroupAdService->mutate($operations);

        // Display results.
        foreach ($result->value as $adGroupAd) {
            //printf("Text ad with headline '%s' and ID '%s' was added.\n",
            //  $adGroupAd->ad->headline, $adGroupAd->ad->id);
            return $adGroupAd->ad->id;
        }
    }

  //-----------------------------------------------------------------------------------------------    
    public function readGoogleTextAds($adGroupId)
    {
        // Get the service, which loads the required classes.
        $adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);

        // Create selector.
        $selector = new Selector();
        $selector->fields = array('Headline', 'Id', 'Description1', 'Description2', 'DisplayUrl', 'Url', 'Status', 'AverageCpc', 'AveragePosition', 'Clicks', 'Conversions', 'Cost', 'Ctr', 'Impressions');
        $selector->ordering[] = new OrderBy('Headline', 'ASCENDING');

        // Create predicates.
        $selector->predicates[] = new Predicate('AdGroupId', 'IN', array($adGroupId));
        $selector->predicates[] = new Predicate('AdType', 'IN', array('TEXT_AD'));
        // By default disabled ads aren't returned by the selector. To return them
        // include the DISABLED status in a predicate.
        $selector->predicates[] = new Predicate('Status', 'IN', array('ENABLED', 'PAUSED', 'DISABLED'));
        $selector->predicates[] = new Predicate('Impressions', 'GREATER_THAN', array('1'));
       

        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

        
            // Make the get request.
            $page = $adGroupAdService->get($selector);

            $get_tex_ads_id_headline = array();
            
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroupAd) {
                    //printf("Text ad with headline '%s' and ID '%s' was found.\t",
                    //   $adGroupAd->ad->headline, $adGroupAd->ad->id);
                     $cr = 0;
                     if ($adGroupAd->stats->clicks > 0)
                     {
                         $cr = $adGroupAd->stats->conversions / $adGroupAd->stats->clicks;
                         
                     }

                $get_tex_ads_id_headline[] = array(    'id'       => $adGroupAd->ad->id ,
                                                       'headline' => $adGroupAd->ad->headline ,
                                                       'desc1'    => $adGroupAd->ad->description1 ,
                                                       'desc2'    => $adGroupAd->ad->description2 ,
                                                       'dispurl'  => $adGroupAd->ad->displayUrl ,
                                                       'url'      => $adGroupAd->ad->url,
                                                       'status'   => $adGroupAd->status,
                                                       'clicks'   => $adGroupAd->stats->clicks,
                                                       'cpc'     => $adGroupAd->stats->averageCpc->microAmount / 1000000,
                                                       'conversions' => $adGroupAd->stats->conversions,
                                                       'cost'    => $adGroupAd->stats->cost->microAmount / 1000000,
                                                       'ctr'     => $adGroupAd->stats->ctr,
                                                       'impressions' => $adGroupAd->stats->impressions,
                                                       'cr'      => $cr,
                                                       'position'=> $adGroupAd->stats->averagePosition,
                                                       ''
                                                    );
                }
            } else{
                $get_tex_ads_id_headline = 'no text ads';
            }

            return $get_tex_ads_id_headline;
                   
    }
   //-----------------------------------------------------------------------------------------------   
    public function pauseEnableGoogleTextAd($adGroupId, $adId,$ENABLED_or_PAUSED) {
        
        $user = $this->user;
        // Get the service, which loads the required classes.
        $adGroupAdService = $user->GetService('AdGroupAdService', ADWORDS_VERSION);

        // Create ad using an existing ID. Use the base class Ad instead of TextAd to
        // avoid having to set ad-specific fields.
        $ad = new Ad();
        $ad->id = $adId;

        // Create ad group ad.
        $adGroupAd = new AdGroupAd();
        $adGroupAd->adGroupId = $adGroupId;
        $adGroupAd->ad = $ad;

        // Update the status.
        $adGroupAd->status =$ENABLED_or_PAUSED;

        // Create operation.
        $operation = new AdGroupAdOperation();
        $operation->operand = $adGroupAd;
        $operation->operator = 'SET';

        $operations = array($operation);

        // Make the mutate request.
        $result = $adGroupAdService->mutate($operations);

        // Display result.
        $adGroupAd = $result->value[0];
        //printf("Ad of type '%s' with ID '%s' has updated status '%s'.\n", $adGroupAd->ad->AdType, $adGroupAd->ad->id, $adGroupAd->status);
        
        return $adGroupAd->status;
    }
 //----------------------------------------------------------------------------------------------- 
}