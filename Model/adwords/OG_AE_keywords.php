<?php

require_once dirname(dirname(__FILE__)).'/base/OG_AE_keywords.php';
require_once 'OG_AE_adwords_base.php';
require_once UTIL_PATH . '/MediaUtils.php';

/*
 * Copyright OfferGrid Networks
 *   * 
 */

/**
 * Description of OG_AE_keywords
 *
 * 
 */
class OG_AE_keywords extends OG_AE_adwords_base implements OG_AE_keywords
{
    private $keywords;
    public function __construct()
    {
        parent::__construct();
        
    }
    
    public function getGoogleKeyWords()
    {
        return $this->keywords;
    }
    
    public function setGoogleKeywords()
    {
        return $this->keywords = $keywords;
    }
    
    public function createGoogleKeyWords( $adGroupId,$keywords_input,$BROAD_PHRASE_NEGATIVE)
    {
        // Get the service, which loads the required classes.
        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);

       
        $operations = array();
        
            // Create keyword criterion.
            $keyword = new Keyword();
            $keyword->text = $keywords_input;
            $keyword->matchType = $BROAD_PHRASE_NEGATIVE;

            // Create biddable ad group criterion.
            $adGroupCriterion = new BiddableAdGroupCriterion();
            $adGroupCriterion->adGroupId = $adGroupId;
            $adGroupCriterion->criterion = $keyword;

            // Set additional settings (optional).
            $adGroupCriterion->userStatus = 'ENABLED';
            //$adGroupCriterion->destinationUrl = 'http://www.example.com/mars';

            /* // Set bids (optional).
              $bid = new CpcBid();
              $bid->bid =  new Money(500000);
              $biddingStrategyConfiguration = new BiddingStrategyConfiguration();
              $biddingStrategyConfiguration->bids[] = $bid;
              $adGroupCriterion->biddingStrategyConfiguration = $biddingStrategyConfiguration;
             */
            $adGroupCriteria[] = $adGroupCriterion;

            // Create operation.
            $operation = new AdGroupCriterionOperation();
            $operation->operand = $adGroupCriterion;
            $operation->operator = 'ADD';
            $operations[] = $operation;
       

        // Make the mutate request.
        $result = $adGroupCriterionService->mutate($operations);

        // Display results.

        foreach ($result->value as $adGroupCriterion) {
           // printf("Keyword with text '%s', match type '%s', and ID '%s' was added.\n", $adGroupCriterion->criterion->text, $adGroupCriterion->criterion->matchType, $adGroupCriterion->criterion->id);

            $keywords_id_text_match = array($adGroupCriterion->criterion->id , $adGroupCriterion->criterion->text , $adGroupCriterion->criterion->matchType);
        }



        return $keywords_id_text_match;
    }
  //-----------------------------------------------------------------------------------------------  
    
    public function readGoogleKeywords( $adGroupId) {
        $user = $this->user;
        // Get the service, which loads the required classes.
        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);

        // Create selector.
        $selector = new Selector();
        $selector->fields = array('KeywordText', 'KeywordMatchType', 'Id', 'AverageCpc', 'AveragePosition', 'Clicks', 'Conversions', 'Cost', 'Ctr', 'Impressions', 'QualityScore', 'Status');
        $selector->ordering[] = new OrderBy('KeywordText', 'ASCENDING');

        // Create predicates.
        $selector->predicates[] = new Predicate('AdGroupId', 'IN', array($adGroupId));
        $selector->predicates[] = new Predicate('CriteriaType', 'IN', array('KEYWORD'));

        // Create paging controls.
        $selector->paging = new Paging(0, AdWordsConstants::RECOMMENDED_PAGE_SIZE);

        
            // Make the get request.
            $page = $adGroupCriterionService->get($selector);

            $get_id_text_matchtype = array();
            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroupCriterion) {
                    $cr = 0;
                if ($adGroupCriterion->stats->clicks > 0)
                { $cr = $adGroupCriterion->stats->conversions / $adGroupCriterion->stats->clicks;}

                /* printf("Keyword with text '%s', match type '%s', and ID '%s' was "
                      . "found.\n", $adGroupCriterion->criterion->text,
                      $adGroupCriterion->criterion->matchType,
                      $adGroupCriterion->criterion->id);
                     */
                    $get_id_text_matchtype[] =array( 'id'    => $adGroupCriterion->criterion->id ,
                                                     'type'  => $adGroupCriterion->criterion->matchType,
                                                     'text'  => $adGroupCriterion->criterion->text,
                                                     'status'=> $adGroupCriterion->userStatus,
                                                     'clicks' => $adGroupCriterion->stats->clicks,
                                                     'cpc' => $adGroupCriterion->stats->averageCpc->microAmount / 1000000,
                                                     'conversions' => $adGroupCriterion->stats->conversions,
                                                     'cost' => $adGroupCriterion->stats->cost->microAmount / 1000000,
                                                     'ctr' => $adGroupCriterion->stats->ctr,
                                                     'impressions' => $adGroupCriterion->stats->impressions,
                                                     'qualityfactor' => $adGroupCriterion->qualityInfo->qualityScore,
                                                     'cr' => $cr,
                                                     'position' => $adGroupCriterion->stats->averagePosition);
            }
            } else {
                $get_id_text_matchtype = "No keywords were found.\n";
            }
            return $get_id_text_matchtype;
            // Advance the paging index.
           
    }
    
  //----------------------------------------------------------------------------------------------- 
    
     public function removeGoogleKeyword( $adGroupId, $criterionId) 
    {
        $user = $this->user;
        // Get the service, which loads the required classes.
        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);

        // Create criterion using an existing ID. Use the base class Criterion
        // instead of Keyword to avoid having to set keyword-specific fields.
        $criterion = new Criterion();
        $criterion->id = $criterionId;

        // Create ad group criterion.
        $adGroupCriterion = new AdGroupCriterion();
        $adGroupCriterion->adGroupId = $adGroupId;
        $adGroupCriterion->criterion = new Criterion($criterionId);

        // Create operation.
        $operation = new AdGroupCriterionOperation();
        $operation->operand = $adGroupCriterion;
        $operation->operator = 'REMOVE';

        $operations = array($operation);

        // Make the mutate request.
        $result = $adGroupCriterionService->mutate($operations);

        // Display result.
        $adGroupCriterion = $result->value[0];
        //printf("Keyword with ID '%d' was removed.\n", $adGroupCriterion->criterion->id);
         $msg = 'removed keyword with creation id '. $adGroupCriterion->criterion->id;
        return $msg;
    }
    
  //-----------------------------------------------------------------------------------------------    
    
    public function UpdateGoogleKeywordDestinationUrl(AdWordsUser $user, $adGroupId, $criterionId,$url)
    {   
        $user = $this->user;
        // To geto get keywords, run GetKeywords function
        // Get the service, which loads the required classes.
        $adGroupCriterionService = $user->GetService('AdGroupCriterionService', ADWORDS_VERSION);

        // Create ad group criterion.
        $adGroupCriterion = new BiddableAdGroupCriterion();
        $adGroupCriterion->adGroupId = $adGroupId;
        // Create criterion using an existing ID. Use the base class Criterion
        // instead of Keyword to avoid having to set keyword-specific fields.
        $adGroupCriterion->criterion = new Criterion($criterionId);

        // Update destination URL.
        $adGroupCriterion->destinationUrl = $url;

        // Create operation.
        $operation = new AdGroupCriterionOperation();
        $operation->operand = $adGroupCriterion;
        $operation->operator = 'SET';

        $operations = array($operation);

        // Make the mutate request.
        $result = $adGroupCriterionService->mutate($operations);

        // Display result.
        $adGroupCriterion = $result->value[0];
        printf("Keyword with ID '%s' has updated destination URL '%s'.\n", $adGroupCriterion->criterion->id, $adGroupCriterion->destinationUrl);

        $updated_keyword_url = $adGroupCriterion->criterion->id . " " . $adGroupCriterion->destinationUrl;
        return $updated_keyword_url;
    }
 //----------------------------------------------------------------------------------------------- 
}
