<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\SoapWrapper; 
use SoapClient;

class MBWayClientController /* extends SoapClient */
{

    protected $sandbox;

    protected $endpoint = 'https://qly.mbway.pt/';

    protected $aliasClient;

    private static $WSDL = [
        'DIR'                 => 'wsdl/',
        'MERCHANT_ALIAS'      => 'MerchantAliasWSService.wsdl',
        'FINANCIAL_OPERATION' => 'MerchantFinancialWSService.wsdl',
    ];
    
    public function test(){
        
        $url         = ""; 
        $options = array(
          'cache_wsdl' => 0,
          'trace' => 1,
          'stream_context' => 
          stream_context_create(array(
                'ssl' => array(
                     'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                )
          )
        ));
        //$sClient = new SoapClient(__DIR__.'/../'.self::$WSDL['DIR'].self::$WSDL['MERCHANT_ALIAS']);   
      

         $this->soapWrapper = new SoapWrapper();

         $this->soapWrapper->add('mbway', function ($service) {
            $service
              ->wsdl(__DIR__.'/../'.self::$WSDL['DIR'].self::$WSDL['MERCHANT_ALIAS'])
              ->trace(true)
              ->classmap([
               
              ]);
          });

         $client = $this->soapWrapper->client("mbway");

       // parent::SoapClient($wsdl, $options)
        $this->aliasClient = $this->soapWrapper;


        dd($this->aliasClient,$client);  
        
    }

    public function createMerchantAlias(){

     /*    $this->addAddressingFeature($this->aliasClient, 'http://alias.services.merchant.channelmanagermsp.sibs/MerchantAliasWS/createMerchantAliasRequest', $this->config->getMerchantAliasAsyncService());

        return $this->aliasClient->__soapCall('createMerchantAlias', [$parameters], [
            'location' => $this->getLocation('createMerchantAlias'),
        ]); */
    }
}
