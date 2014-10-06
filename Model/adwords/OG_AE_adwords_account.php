<?php
/*
 * Copyright OfferGrid Networks
 *   * 
 */

/**
 * Description of OG_AE_adwords_adgroups
 *
 * 
 */
require_once 'OG_AE_adwords_base.php';

class OG_AE_ADWORD_account extends OG_AE_adwords_base 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function createGoogleAccount()
    {
        $user =  $this->user;
        // Get the service, which loads the required classes.
        $managedCustomerService = $user->GetService('ManagedCustomerService', ADWORDS_VERSION);

        // Create customer.
        $customer = new ManagedCustomer();
        $customer->name = 'Account #' . uniqid();
        $customer->currencyCode = 'EUR';
        $customer->dateTimeZone = 'Europe/London';

        // Create operation.
        $operation = new ManagedCustomerOperation();
        $operation->operator = 'ADD';
        $operation->operand = $customer;

        $operations = array($operation);

        // Make the mutate request.
        $result = $managedCustomerService->mutate($operations);

        // Display result.
        $customer = $result->value[0];
        printf("Account with customer ID '%s' was created.\n", $customer->customerId);
    }
    
    public function getGoogleAccount() {
        
    }

}