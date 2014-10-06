<?php
require_once dirname(dirname(__FILE__)).'/base/OG_AE_report.php';

require_once 'OG_AE_adwords_base.php';

require_once ADWORDS_UTIL_PATH . '/ReportUtils	.php';

class OG_AE_Google_report extends OG_AE_adwords_base  {

    public function __construct() {
        parent::__construct();
    }

    public function reportAwsql($fields_to_be_selected, $dateRange) {
        $user = $this->user;
        $reportFormat = 'CSV';
        $filePath = dirname(__FILE__) . '/report.csv'; // edit this to ur required file

        $reportQuery = 'SELECT ' . $fields_to_be_selected . $dateRange;

        // Set additional options.
        $options = array('version' => ADWORDS_VERSION);

        // Download report.
        ReportUtils::DownloadReportWithAwql($reportQuery, $filePath, $user, $reportFormat, $options);

        printf("Report was downloaded to '%s'.\n", $filePath);
    }

}

class OG_AE_Google_Campaign_report extends OG_AE_Google_report implements OG_AE_Campaign_reports {
    
    public function __construct() {
        parent::__construct();
    }

    public function googleAdwordsCampaignPerformanceReoprt($dateRange) {
        $fields_to_be_selected = "CampaignId,CampaignName, CampaignStatus, BounceRate,"
                . "AverageCpc,AveragePosition,AverageCpm,AveragePageviews,AverageTimeOnSite,"
                . "CostPerConversion,ConversionRateManyPerClick,TotalBudget,ConversionRate,"
                . "Impressions, Clicks, Cost FROM CAMPAIGN_PERFORMANCE_REPORT "
                . "WHERE Status IN [ENABLED, PAUSED] DURING ";


        $this->reportAwsql($fields_to_be_selected, $dateRange);
    }

}

class OG_AE_Google_TextAd_report extends OG_AE_Google_report implements OG_AE_TextAd_reports  {

    public function __construct() {
        parent::__construct();
    }

    public function googleTextAdsReport($dateRange) {
        $fields_to_be_selected = 'CampaignId,CampaignName, CampaignStatus, BounceRate,'
                . 'AverageCpc,AveragePosition,AverageCpm,AveragePageviews,AverageTimeOnSite,'
                . 'CostPerConversion,ConversionRateManyPerClick,ConversionRate,'
                . 'Impressions, Clicks, Cost FROM AD_PERFORMANCE_REPORT '
                . 'WHERE Status IN [ENABLED, PAUSED] DURING ';

        $this->reportAwsql($fields_to_be_selected, $dateRange);
    }

    public function googleTextAdsExtensionPerformReport() {
        
    }

}

class OG_AE_Google_adGroup_report extends OG_AE_Google_report implements OG_AE_adGroup_report {

    public function __construct() {
        parent::__construct();
    }

    public function AdGroupPerformanceReport($dateRange) {
        $fields_to_be_selected = 'CampaignId,CampaignName, CampaignStatus,AdGroupId,AdGroupName,AdGroupStatus, BounceRate,'
                . 'AverageCpc,AveragePosition,AverageCpm,AveragePageviews,AverageTimeOnSite,'
                . 'CostPerConversion,ConversionRateManyPerClick,ConversionRate,'
                . 'Impressions, Clicks, Cost FROM ADGROUP_PERFORMANCE_REPORT '
                . 'WHERE Status IN [ENABLED, PAUSED] DURING ';


        $this->reportAwsql($fields_to_be_selected, $dateRange);
    }

    
        
    }



class OG_AE_Google_keyWords_report extends OG_AE_Google_report implements OG_AE_keyWords_report  {

    public function __construct() {
        parent::__construct();
    }

    public function KeyPerformanceReport($dateRange) {

        $fields_to_be_selected = 'CampaignId,CampaignName,CampaignStatus, AdGroupId,AdGroupName, AccountCurrencyCode,AssistClicks, '
                . 'AverageCpc,AverageCpm,AveragePosition,BounceRate,Ctr,CostPerConversion,KeywordText,KeywordMatchType,SearchImpressionShare,'
                . 'ConversionRate,MaxCpc,MaxCpm,'
                . 'Impressions, Clicks, Cost FROM  KEYWORDS_PERFORMANCE_REPORT '
                . 'WHERE Status IN [ENABLED, PAUSED] DURING ';
        $this->reportAwsql($fields_to_be_selected, $dateRange);
    }

   
}
