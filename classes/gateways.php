<?php
/**
 * SMS Gateway handler class
 *
 * @author Icare
 */
class HispaSMS_Gateways {

    private static $_instance;

    public static function init() {
        if ( !self::$_instance ) {
            self::$_instance = new HispaSMS_Gateways();
        }

        return self::$_instance;
    }

    /**
    * Hispa SMS Gateway
    *
    * @param  array $sms_data
    * @return boolean
    */
    function hispasms( $sms_data ) {
        $hispasms_username        = hispasms_get_option( 'hispasms_username', 'hispasms_gateway', '' );
        $hispasms_password        = hispasms_get_option( 'hispasms_password', 'hispasms_gateway', '' );
        $hispasms_sender_no       = hispasms_get_option( 'hispasms_sender_no', 'hispasms_gateway', '' );

        if( empty( $hispasms_username ) || empty( $hispasms_password ) ) {
            return;
        }

        require_once dirname( __FILE__ ) . '/../lib/hispaSMS/vendor/autoload.php';

        $smsClient = new \hispaSMS\SmsClient( $hispasms_username, $hispasms_password );

        $smsMessage = new \hispaSMS\models\SMSRequest();
        $smsMessage->senderAddress = $hispasms_sender_no;
        $smsMessage->address = $sms_data['number'];
        $smsMessage->message = $sms_data['sms_body'];

        $smsMessageSendResult = $smsClient->sendSMS($smsMessage);
        
        /* ogm  Aquí se produce la pantalla en blanco */
        /* $smsMessageStatus = $smsClient->queryDeliveryStatus($smsMessageSendResult); 
        if( $smsMessageStatus->isSuccess() ) { */
        
        if( $smsMessageSendResult->clientCorrelator ) {
            return true;
        } else {
            return false;
        }

    }
    
    function hispasms_get_account_balance($balance = '' ) {
    
    	$hispasms_username        = hispasms_get_option( 'hispasms_username', 'hispasms_gateway', '' );
    	$hispasms_password        = hispasms_get_option( 'hispasms_password', 'hispasms_gateway', '' );
    
    	if( empty( $hispasms_username ) || empty( $hispasms_password ) ) {
    		return;
    	}
    
    	require_once dirname( __FILE__ ) . '/../lib/hispaSMS/vendor/autoload.php';
    
    	$customerProfileClient = new \hispaSMS\CustomerProfileClient( $hispasms_username, $hispasms_password );
    	$customerProfileClient->login();
    
    	$accountBalance = $customerProfileClient->getAccountBalance();
    
    	if(!$accountBalance->isSuccess()) {
    		$balance = $accountBalance->exception;
    		write_log ( $balance );
    
    	} else {
    		 
    		$balance = $accountBalance->balance . ' ' . $accountBalance->currency->symbol;
    	}
    	 
    	return $balance;
    	 
    }
    
    function hispasms_query_outbound_messages($messages=null) {
    
    	$hispasms_username        = hispasms_get_option( 'hispasms_username', 'hispasms_gateway', '' );
    	$hispasms_password        = hispasms_get_option( 'hispasms_password', 'hispasms_gateway', '' );
    
    	if( empty( $hispasms_username ) || empty( $hispasms_password ) ) {
    		return;
    	}
    
    	require_once dirname( __FILE__ ) . '/../lib/hispaSMS/vendor/autoload.php';
    
    	$smsClient = new \hispaSMS\SmsClient ( $hispasms_username, $hispasms_password );
    	$messages = $smsClient->retrieveOutboundMessages($fromTime=null, $toTime=null, $messageId=null);
    
    	return $messages;
    
    }

}
