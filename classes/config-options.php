<?php

/**
 * WordPress settings API class
 *
 * @author HispaSMS
 */

class HispaSMS_Config_Options {

    private $settings_api;
    public static $shortcodes;

    function __construct() {

        $this->settings_api = new WeDevs_Settings_API;
        self::$shortcodes = apply_filters( 'hispa_sms_shortcode_insert_description', __( 'For order id just insert <code>[order_id]</code> and for order status insert <code>[order_status]</code>. Similarly <code>[order_items]</code>, <code>[order_items_description]</code>, <code>[order_amount]</code>, <code>[billing_firstname]</code>, <code>[billing_lastname]</code>, <code>[billing_email]</code>, <code>[billing_address1]</code>, <code>[billing_address2]</code>, <code>[billing_country]</code>, <code>[billing_city]</code>, <code>[billing_state]</code>, <code>[billing_postcode]</code>, <code>[billing_phone]</code>, <code>[shipping_address1]</code>, <code>[shipping_country]</code>, <code>[shipping_city]</code>, <code>[shipping_state]</code>, <code>[shipping_postcode]</code>, <code>[payment_method]</code>', 'hispasms' ) );

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'wsa_form_bottom_hispasms_message_diff_status', array( $this, 'hispasms_settings_field_message_diff_status' ) );
        add_action( 'wsa_form_bottom_hispasms_gateway', array( $this, 'hispasms_settings_field_gateway' ) );
    }

    /**
     * Admin init hook
     * @return void
     */
    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
     * Admin Menu CB
     * @return void
     */
    /**
     * PERMISOS disponibles
     * 
	 * 'manage_options' --> Administrador (administrator)
	 * 'manage_woocommerce' --> Admin Gestor de Tienda
	 * 'view_woocommerce_reports' --> Gestor de Tienda (shop_manager)
	 * 'edit_posts' --> Editor
	 *
	 */	 
    function admin_menu() {
        add_menu_page( __( 'SMS Settings', 'hispasms' ), __( 'SMS Settings', 'hispasms' ), 'manage_options', 'hispa-order-sms-notification-settings', array( $this, 'plugin_page' ), '/wp-content/plugins/wc-hispasms-order-notification/assets/images/icon-24x24-white.png' );
        add_submenu_page( 'hispa-order-sms-notification-settings', __( 'Send SMS to Any', 'hispasms' ), __( 'Send SMS to Any', 'hispasms' ), 'view_woocommerce_reports', 'hispa-order-sms-send-any', array( $this, 'send_sms_to_any' ) );
		add_submenu_page( 'hispa-order-sms-notification-settings', __( 'SMS Delivery Report', 'hispasms' ), __( 'SMS Delivery Report', 'hispasms' ), 'view_woocommerce_reports', 'hispa-order-sms-logs', array( $this, 'send_sms_reports' ) );
    }

    /**
     * Send SMS to any submenu callback
     * @return void
     */
    function send_sms_to_any() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'Send SMS to a single or several Numbers', 'hispasms' ); ?></h1>
	<!-- GENERAL MENU HISPASMS -->
		<?php
		include($_SERVER['DOCUMENT_ROOT'].substr(__FILE__, 0, (strpos(__FILE__, '/')))."/wp-content/plugins/wc-hispasms-order-notification/inc/general-menu.php");
		?>
	<!-- GENERAL MENU HISPASMS -->			
            <div class="postbox send_sms_to_any_notice">
                <p><?php _e( '<strong>INFORMATION</strong><br /><strong>·</strong> You can send SMS to a single recipient or several at a time. To do this, you must put the number of each recipient separated by a comma <strong>(,)</strong> and without any space <strong>( e.g 1:</strong> 1 recipient. <code><strong>34612345678</strong></code> <strong>)</strong>. <strong>( e.g 2:</strong> several recipients. <code><strong>34612345678,34698765432,34611228866</strong></code> <strong>)</strong> <strong>-- No <code>"short code"</code> customization of messages, plain text only --</strong>.<br /><strong>·</strong> Make sure that the SMS recipient number must have the <strong>Country Code</strong> before the phone number <strong>( e.g:</strong> the number format must be like this <code>34612345678</code> <strong>)</strong>, where <code></strong>34</strong></code> is the <strong>Country Code</strong>, in this case to send an SMS to SPAIN', 'hispasms' ); ?></p>
            </div>
            <?php if( isset( $_GET['message'] ) && $_GET['message'] == 'error' ): ?>
                <div class="error">
                    <p><strong><span style="color:#dc3232;"><?php _e( 'ERROR : Receiver phone number must be required', 'hispasms' ) ?></span></strong>
					<br /><br />
					<strong><span style="color:#dc3232;">INFO :</span></strong> <strong><?php _e( 'Remember to include the <strong>Country Code</strong> as indicated below', 'hispasms' ) ?>
					</p>
                </div>
            <?php endif; ?>
            
            <?php if( isset( $_GET['message'] ) && $_GET['message'] == 'error-valid-number' ): ?>
                <div class="error">
                    <p><strong><span style="color:#dc3232;"><?php _e( 'ERROR : Enter a valid phone number with <strong>Country Code</strong>', 'hispasms' ) ?></span></strong>
					<br /><br />
					<strong><span style="color:#dc3232;">INFO :</span></strong> <strong><?php _e( 'Remember that landline numbers are not accepted', 'hispasms' ) ?>
					</p>
                </div>
            <?php endif; ?>
            
            <?php if( isset( $_GET['message'] ) && $_GET['message'] == 'error-empty-body' ): ?>
                <div class="error">
                    <p><strong><span style="color:#dc3232;"><?php _e( 'ERROR : Message SMS is required', 'hispasms' ) ?></span></strong>
					<br /><br />
					<strong><span style="color:#dc3232;">INFO :</span></strong> <strong><?php _e( 'You must enter text in the message field before you can send it', 'hispasms' ) ?>
					</p>
                </div>
            <?php endif; ?>            

            <?php if( isset( $_GET['message'] ) && $_GET['message'] == 'gateway_problem' ): ?>
                <div class="error">
                    <p><strong><span style="color:#dc3232;"><?php _e( 'ERROR : <strong>SMS Gateway</strong> has not been configured correctly', 'hispasms' ) ?></span></strong>
					<br /><br />
					<strong><span style="color:#dc3232;">INFO :</span></strong> <strong><?php _e( 'Access the <strong>SMS Gateway Settings</strong> tab and make the necessary settings', 'hispasms' ) ?>
					</p>
                </div>
            <?php endif; ?>

            <?php if( isset( $_GET['message'] ) && $_GET['message'] == 'sending_failed' ): ?>
                <div class="error">
                    <p><strong><span style="color:#dc3232;"><?php _e( 'ERROR : Message Sending Faild, Please check your number or Gateway settings', 'hispasms' ) ?></span></strong>
					<br /><br />
					<strong><span style="color:#dc3232;">INFO :</span></strong> <strong><?php _e( 'An Error has ocurred in the sending, access <strong>SMS Notifications</strong> in the <strong>SMS Gateway Settings</strong> Tab to configure your account correctly. Also check the phone number you entered to see if it is correct', 'hispasms' ) ?>
					</p>
                </div>
            <?php endif; ?>

            <?php if( isset( $_GET['message'] ) && $_GET['message'] == 'success' ): ?>
                <div class="updated">
                    <p><strong><span style="color:#46b450;"><?php _e( 'SUCCESS : Message Sucessfully Send to Receiver', 'hispasms' ) ?></span></strong>
					<br /><br />
					<strong><span style="color:#dc3232;">INFO :</span></strong> <strong><?php _e( 'You can review the logs or generate a complete report of your SMS messages in your <strong><a href="https://portal.hispasms.com" target="_blank" />Services and Campaigns Portal</a></strong> in the <strong>Reports</strong> section', 'hispasms' ) ?>
					</p>
                </div>
            <?php endif; ?>

            <div class="postbox " id="hispasms_send_sms_any">
                <h3 class="hndle"><?php _e( 'Send SMS to Any number', 'hispasms' ) ?></h3>
                <div class="inside">
                    <form class="initial-form" id="hispasms-send-sms-any-form" method="post" action="" name="post">
                        <p>
                            <label for="hispasms_receiver_number"><?php _e( 'Receiver Number', 'hispasms' ) ?></label><br>
                            <input type="text" name="hispasms_receiver_number" id="hispasms_receiver_number">
                            <span><?php _e( 'Enter the SMS Receiver Number, the number must include the <strong>Country Code</strong>', 'hispasms' ) ?></span>
                        </p>

                        <p>
                            <label for="hispasms_sms_body"><?php _e( 'SMS Body', 'hispasms' ) ?></label><br>
                            <textarea name="hispasms_sms_body" id="hispasms_sms_body" cols="50" rows="6"></textarea>
                            <span><?php _e( 'Enter your message body what you like you want to send this receiver', 'hispasms' ) ?></span>
                        </p>

                        <p>
                            <?php wp_nonce_field( 'send_sms_to_any_action','send_sms_to_any_nonce' ); ?>
                            <input type="submit" class="button button-primary" name="hispasms_send_sms" value="<?php _e( 'Send SMS', 'hispasms' ); ?>">
                        </p>

                    </form>
                </div>
            </div>

        </div>
        <?php
    }

	/**
    * SMS Delivery Report submenu callback
    * @return void
    */
	
	function send_sms_reports() {
        ?>
     <div class="wrap">
        <h1><?php _e( 'SMS Delivery Report', 'hispasms' ); ?></h1>
	<!-- GENERAL MENU HISPASMS -->
		<?php
		include ( $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wc-hispasms-order-notification/inc/general-menu.php' );
		?>
	<!-- GENERAL MENU HISPASMS -->
	    <div class="postbox send_sms_to_any_notice">
        <p><?php _e( '<strong>INFORMATION</strong><br /><strong>·</strong> From this section you will be able to quickly display a list of all the status reports of each sms message that have been sent. Remember that it may take some time to update the Status.<br /><strong>·</strong> The information is not instantly updated, it may take a few minutes to appear.<br /><strong>·</strong> In the list of entries, you can organize each result of the column you want in descending or ascending order. In the option on the left with the "<strong>Show Entries</strong>" drop-down, you can change the default records that show that they are 10, 25, 50 or 100. And in the "<strong>Search:</strong>" field on the right, you can filter as you type a number or words and the matching results will be displayed.<br /><strong>·</strong> Only the <strong>last 48 hours</strong> of reports are displayed. To see a more detailed report, you can review the logs or generate a complete report of your SMS messages in your <strong><a href="https://portal.hispasms.com" target="_blank" />Services and Campaigns Portal</a></strong> in the <strong>Reports</strong> section<br /><strong>·</strong> The format used to display the dates in the report list is as follows: <strong>D-M-Y ( days-months-years )</strong> and for the time is: <strong>H:M:S ( hours:minuts:seconds )</strong>', 'hispasms' ); ?></p>
        </div>

	  <div class="postbox" id="hispasms_send_sms_any">
		<h3 class="hndle"><?php _e( 'Logs Report List', 'hispasms' ); ?></h3>
		<div class="inside_table">
			<script src="/wp-content/plugins/wc-hispasms-order-notification/assets/js/jquery-2.1.1.min.js"></script>
			<script src="/wp-content/plugins/wc-hispasms-order-notification/assets/js/jquery.dataTables.min.js"></script>
			<script type="text/javascript" src="/wp-content/plugins/wc-hispasms-order-notification/assets/js/table.js"></script>
			<link rel="stylesheet" href="/wp-content/plugins/wc-hispasms-order-notification/assets/css/jquery.dataTables.min.css">
			<table id="reportlog" class="display" cellspacing="0" width="100%">
			 <thead> 
			  <tr>
			<!-- LISTADO DE REPORTES DE SMS HISPASMS -->
			<?php $messages = HispaSMS_Gateways::init()->hispasms_query_outbound_messages($messages=null); ?>

    			<th scope="col" class="col_th"><?php _e( 'Destination Address:' , 'hispasms' ) ?></th>
				<th scope="col" class="col_th"><?php _e( 'Sender Address:' , 'hispasms' ) ?></th>
    			<th scope="col" class="col_th"><?php _e( 'Message Text:' , 'hispasms' ) ?></th>
				<th scope="col" class="col_th"><?php _e( 'Delivery Status:' , 'hispasms' ) ?></th>
				<th scope="col" class="col_th"><?php _e( 'Description:' , 'hispasms' ) ?></th>
    			<th scope="col" class="col_th"><?php _e( 'Send Date Time:' , 'hispasms' ) ?></th>
				<th scope="col" class="col_th"><?php _e( 'Date of Delivery:' , 'hispasms' ) ?></th>
    			<th scope="col" class="col_th"><?php _e( 'SMS Count:' , 'hispasms' ) ?></th>				
				<th scope="col" class="col_th"><?php _e( 'Price:' , 'hispasms' ) ?></th>
				<th scope="col" class="col_th hidden_responsive"><?php _e( 'Currency:' , 'hispasms' ) ?></th>
				<th scope="col" class="col_th hidden_responsive"><?php _e( 'Operator:' , 'hispasms' ) ?></th>
				<th scope="col" class="col_th hidden_responsive"><?php _e( 'Country:' , 'hispasms' ) ?></th>
			  </tr>
			 </thead> 
			 <tbody> 
			<?php			  
    		foreach ($messages->logs as $message) {   
    		  $sendDate = date_create($message->sendDateTime); ?>
    		  <tr>
				
				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Destination Address:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo $message->destinationAddress . "\n"; ?>
					</div>
				</td>
					
				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Sender Address:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo $message->sender . "\n"; ?>
					</div>
				</td>

				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Message Text:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo $message->messageText . "\n"; ?>
					</div>
				</td>
				
				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Delivery Status:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php
						switch ($message->status->status) {
							case "Failed":
								echo _e( 'Failed' , 'hispasms' ) . "\n"; ?></div></td>
								<?php break; 
							case "Delivered":
								echo _e( 'Delivered' , 'hispasms' ) . "\n"; ?></div></td>
								<?php break;
							case "Rejected":
								echo _e( 'Rejected' , 'hispasms' ) . "\n"; ?></div></td>
								<?php break;
							default:
								echo _e( $message->status->status , 'hispasms' ) . "\n"; ?>
						</div></td>
					<?php } ?>

				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Description:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php 
						switch ($message->status->description) {
							case "Message sent and delivered":
								echo _e( 'Message sent and delivered' , 'hispasms' ) . "\n"; ?></div></td>
								<?php break;
							case "Not enough credits":
								echo _e( 'Not enough credits' , 'hispasms' ) . "\n"; ?></div></td>
								<?php break;
							case "Message delivered to handset":
								echo _e( 'Message delivered to handset' , 'hispasms' ) . "\n"; ?></div></td>
								<?php break;
							case "Invalid destination address":
								echo _e( 'Invalid destination address' , 'hispasms' ) . "\n"; ?></div></td>
								<?php break;
							default:
								echo _e( $message->status->description , 'hispasms' ) . "\n"; ?></div></td>
					<?php } ?>

				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Send Date Time:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo date_format($sendDate, 'd-m-Y H:i:s') . "\n"; ?>
					</div>
				</td>

				<td class="flex-row">
						<div class="flex-th col_th_hidden_responsive">
							<?php _e( 'Date of Delivery:' , 'hispasms' ) ?>
				</div>
				<div class="flex-td">				
				<?php if (strcmp ( substr($message->deliveryReportTime,0,4) , '1970' ) !== 0) { ?>
						<?php $deliveryReportDate = date_create($message->deliveryReportTime);
								  echo date_format ($deliveryReportDate, 'd-m-Y H:i:s') . "\n"; ?>
			    <?php } else { ?> 
			    <?php } ?>			
					</div>
				</td>	

				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'SMS Count:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo $message->smsCount . "\n"; ?>
					</div>	
				</td>				

				<td class="flex-row">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Price:' , 'hispasms' ) ?>	
					</div>
					<div class="flex-td">
						<?php echo $message->pricePerMessage->price . "\n"; ?>
					</div>	
				</td>	
				
				<td class="flex-row hidden_responsive">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Currency:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo $message->pricePerMessage->currency . "\n"; ?>
					</div>
				</td>
				
				<td class="flex-row hidden_responsive">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Operator:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo $message->destinationNetwork->name . "\n"; ?>
					</div>
				</td>
				
				<td class="flex-row hidden_responsive">
					<div class="flex-th col_th_hidden_responsive">
						<?php _e( 'Country:' , 'hispasms' ) ?>
					</div>
					<div class="flex-td">
						<?php echo $message->destinationNetwork->country->name . "\n"; ?>
					</div>
				</td>
			  </tr>
			<?php } ?>	
			 </tbody> 
		<!-- LISTADO DE REPORTES DE SMS HISPASMS -->
			</table>
		</div>
	  </div>
	 </div>
	<?php
	}
	
    /**
     * Get All settings Field
     * @return array
     */
    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'hispasms_general',
                'title' => __( 'General Settings', 'hispasms' )
            ),
            array(
                'id' => 'hispasms_gateway',
                'title' => __( 'SMS Gateway Settings', 'hispasms' )
            ),

            array(
                'id' => 'hispasms_message',
                'title' => __( 'SMS Notify Settings', 'hispasms' )
            ),

            array(
                'id' => 'hispasms_message_diff_status',
                'title' => __( 'SMS Body Settings', 'hispasms' )
            )
        );
        return apply_filters( 'hispasms_settings_sections' , $sections );
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {

        $buyer_message = "Thanks for purchasing\nYour [order_id] is now [order_status]\nThank you";
        $admin_message = "You have a new Order\nThe [order_id] is now [order_status]\n";
        $settings_fields = array(

            'hispasms_general' => apply_filters( 'hispasms_general_settings', array(
                array(
                    'name' => 'enable_notification',
                    'label' => __( 'Enable SMS Notifications', 'hispasms' ),
                    'desc' => __( 'If checked then enable your sms notification for new order', 'hispasms' ),
                    'type' => 'checkbox',
                ),

                array(
                    'name' => 'admin_notification',
                    'label' => __( 'Enable Admin Notifications', 'hispasms' ),
                    'desc' => __( 'If checked then enable admin sms notification for new order', 'hispasms' ),
                    'type' => 'checkbox',
                    'default' => 'on'
                ),

                array(
                    'name' => 'buyer_notification',
                    'label' => __( 'Enable buyer Notification', 'hispasms' ),
                    'desc' => __( 'If checked then buyer can get notification options in checkout page', 'hispasms' ),
                    'type' => 'checkbox',
                ),

                array(
                    'name' => 'force_buyer_notification',
                    'label' => __( 'Force buyer notification', 'hispasms' ),
                    'desc' => __( 'If select <strong>Yes</strong> then the Buyer SMS Notification option will be Required in Checkout page', 'hispasms' ),
                    'type' => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => __( 'Yes', 'hispasms' ),
                        'no'   => __( 'No', 'hispasms' )
                    )
                ),

                array(
                    'name' => 'buyer_notification_text',
                    'label' => __( 'Text of check box for Buyer SMS Notification', 'hispasms' ),
                    'desc' => __( 'Enter the text that will appear as a checkbox on the <strong>Checkout Page</strong> of the Buyer', 'hispasms' ),
                    'type' => 'textarea',
                    'default' => __( 'Send me SMS Notifications from the Status of my Orders<br/><strong>INFO:</strong> SMS Notifications will be sent in your billing <strong>Phone</strong> of your account and have no cost', 'hispasms' )
                ),
                array(
                    'name' => 'order_status',
                    'label' => __( 'Check Order Status ', 'hispasms' ),
                    'desc' => __( 'This is used to choose in which <strong>Order Status</strong> notifications will be sent by SMS ( select a minimum state to notify )', 'hispasms' ),
                    'type' => 'multicheck',
                    'options' => wc_get_order_statuses()
                )
            ) ),

            'hispasms_gateway' => apply_filters( 'hispasms_gateway_settings',  array(
                array(
                    'name' => 'sms_gateway',
                    'label' => __( 'Your SMS Gateway', 'hispasms' ),
                    'desc' => __( 'Is your current SMS Gateway', 'hispasms' ),
                    'type' => 'select',
                    'default' => '-1',
                    'options' => $this->get_sms_gateway()
                ),
            ) ),

            'hispasms_message' => apply_filters( 'hispasms_message_settings',  array(
                array(
                    'name' => 'sms_admin_phone',
                    'label' => __( 'Enter your Phone Number with the <strong>Country Code</strong>', 'hispasms' ),
                    'desc' => __( '<br>Admin Order SMS Notifications will be send in this number. Please, make sure that the number must have a <strong>Country Code</strong> <strong>(</strong> e.g. : <strong>34612345678</strong> where <strong>34</strong> will be <strong>Country Code )</strong>', 'hispasms' ),
                    'type' => 'text'
                ),
                array(
                    'name' => 'admin_sms_body',
                    'label' => __( 'Enter your SMS body', 'hispasms' ),
                    'desc' => __( 'Write your custom message. When an order is create then you get this type of format message.', 'hispasms' ) . ' ' . self::$shortcodes,
                    'type' => 'textarea',
                    'default' => __( $admin_message, 'hispasms' )
                ),

                array(
                    'name' => 'sms_body',
                    'label' => __( 'Enter buyer SMS body', 'hispasms' ),
                    'desc' => __( 'Write your custom message. If enbale buyer notification options then buyer can get this message in this format.', 'hispasms' ) . ' ' . self::$shortcodes,
                    'type' => 'textarea',
                    'default' => __( $buyer_message, 'hispasms' )
                ),
            ) ),

            'hispasms_message_diff_status' => apply_filters( 'hispasms_message_diff_status_settings',  array(

                array(
                    'name' => 'enable_diff_status_mesg',
                    'label' => __( 'Enable different message for different order status', 'hispasms' ),
                    'desc' => __( 'If checked then admin and buyer get sms body content according with different enabled order status', 'hispasms' ),
                    'type' => 'checkbox'
                ),

            ) ),
        );

        return apply_filters( 'hispasms_settings_section_content', $settings_fields );
    }

    /**
     * Loaded Plugin page
     * @return void
     */
    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

    /**
     * Get sms Gateway settings
     * @return array
     */
    function get_sms_gateway() {
        $gateway = array(
            'hispasms'      => __( 'Hispasms', 'hispasms' ),
        );

        return apply_filters( 'hispasms_sms_gateway', $gateway );
    }

    function hispasms_settings_field_message_diff_status() {
        $enabled_order_status = hispasms_get_option( 'order_status', 'hispasms_general', array() );
        ?>
        <div class="hispasms_different_message_status_wrapper hispasms_hide_class">
            <hr>
            <?php if ( $enabled_order_status  ): ?>
                <h3><?php _e( 'Set the content of SMS Notifications for Buyer', 'hispasms' ) ?></h3>
                <p style="margin-top:15px; margin-bottom:0px; padding-left: 20px; font-style: italic; font-size: 14px;">
                    <strong><?php _e( 'Set your Buyers SMS Notifications content, according to the Status of your Order that has been activated in the tab of <strong>General Settings</strong>', 'hispasms' ); ?></strong><br>
                    <span><?php _e( 'Write your custom message. When an order is create then you get this type of format message.', 'hispasms' ); echo ' ' .self::$shortcodes; ?></span>
                </p>
                <table class="form-table">
                    <?php foreach ( $enabled_order_status as $buyer_status_key => $buyer_status_value ): ?>
                        <?php
                            $buyer_display_order_status = str_replace( 'wc-', '', $buyer_status_key );
                            $buyer_content_value = hispasms_get_option( 'buyer-'.$buyer_status_key, 'hispasms_message_diff_status', 'hispasms' );
                        ?>
                        <tr valign="top">
                            <th scrope="row">
                            <?php 
                            switch ($buyer_display_order_status) {
                            	case "pending":
                            		echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Pending', 'hispasms' ) ) ) ); ?></th>
                                    <?php break; 
                                case "processing":	
                                    echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Processing', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                case "on-hold":
                                    echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'On-hold', 'hispasms' ) ) ) ); ?></th>
									<?php break;
								case "completed":
                                    echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Completed', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                case "cancelled":
                                    echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Cancelled', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                case "refunded":
                                    echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Refunded', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                case "failed":
                                    echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Failed', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                default:
                                    echo sprintf( '%s %s',  __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( $buyer_display_order_status, 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                               } ?>
                        
                            <td>
                                <textarea class="regular-text" name="hispasms_message_diff_status[buyer-<?php echo $buyer_status_key; ?>]" id="hispasms_message_diff_status[buyer-<?php echo $buyer_status_key; ?>]" cols="55" rows="5"><?php echo $buyer_content_value; ?></textarea>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>

                <hr>

                <h3><?php _e( 'Set content of SMS Notifications for Admin', 'hispasms' ) ?></h3>
                <p style="margin-top:15px; margin-bottom:0px; padding-left: 20px; font-style: italic; font-size: 14px;">
                    <strong><?php _e( 'Set your Admin SMS Notifications content, according to the Status of your Order that has been activated in the tab of <strong>General Settings</strong>', 'hispasms' ); ?></strong><br>
                    <span><?php _e( 'Write your custom message. When an order is create then you get this type of format message.', 'hispasms' ); echo ' ' .self::$shortcodes; ?></span>
                </p>
                <table class="form-table">
                    <?php foreach ( $enabled_order_status as $admin_status_key => $admin_status_value ): ?>
                        <?php
                            $admin_display_order_status = str_replace( 'wc-', '', $admin_status_key );
                            $admin_content_value = hispasms_get_option( 'admin-'.$admin_status_key, 'hispasms_message_diff_status', '' );
                        ?>
                        <tr valign="top">
                            <th scrope="row">
                            <?php 
                            switch ($admin_display_order_status) {
                            	case "pending":
                            		echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Pending', 'hispasms' ) ) ) ); ?></th>
                                    <?php break; 
                                case "processing":	
                                    echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Processing', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                case "on-hold":
                                    echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'On-hold', 'hispasms' ) ) ) ); ?></th>
									<?php break;
								case "completed":
                                    echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Completed', 'hispasms' ) ) ) ); ?></th>									
                                    <?php break;
                                case "cancelled":
                                    echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Cancelled', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                case "refunded":
                                    echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Refunded', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                case "failed":
                                    echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( 'Failed', 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                default:
                                    echo sprintf( '%s %s', __( 'Order Status', 'hispasms' ), ucfirst( str_replace( '-', ' ', __( $admin_display_order_status, 'hispasms' ) ) ) ); ?></th>
                                    <?php break;
                                } ?>		
                                                        
                            <td>
                                <textarea class="regular-text" name="hispasms_message_diff_status[admin-<?php echo $admin_status_key; ?>]" id="hispasms_message_diff_status[buyer-<?php echo $admin_status_key; ?>]" cols="55" rows="5"><?php echo $admin_content_value; ?></textarea>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>

            <?php else: ?>
                <p style="margin-top:15px; margin-bottom:0px; padding-left: 20px; font-size: 14px;"><?php _e( 'Sorry no Order Status will be selected for sending SMS. Select some Order Status from <strong>General Settings</strong> Tab') ?></p>
            <?php endif ?>
        </div>

        <?php
    }

    /**
     * SMS Gateway Settings Extra panel options
     * @return void
     */
    function hispasms_settings_field_gateway() {

        $hispasms_username        = hispasms_get_option( 'hispasms_username', 'hispasms_gateway', '' );
        $hispasms_password        = hispasms_get_option( 'hispasms_password', 'hispasms_gateway', '' );
        $hispasms_sender_no       = hispasms_get_option( 'hispasms_sender_no', 'hispasms_gateway', '' );

        $hispasms_helper    = _e( '<p class="account-hispasms-info">Fill in your account information in <strong>HispaSMS</strong>. If you do not have this information, then go to <strong><a href="https://portal.hispasms.com" target="_blank">HispaSMS Portal</a></strong> and get your informations.<br /><br />If you do not have an active client account yet, please, contact our Advisors so they can help you get one from <strong><a href="https://www.hispasms.com" target="_blank">HERE</a></strong>.</p><br />', 'hispasms' );
        ?>

        <?php do_action( 'hispasms_gateway_settings_options_before' ); ?>

        <div class="hispasms_wrapper hide_class">
            <hr>
            <p style="margin-top:15px; margin-bottom:0px; padding-left: 20px; font-style: italic; font-size: 14px;">
                <strong><?php _e( $hispasms_helper, 'hispasms' ); ?></strong>
           </p>
            <table class="form-table">
                <tr valign="top">
                    <th scrope="row"><?php _e( 'Hispasms Username', 'hispasms' ) ?></th>
                    <td>
                        <input type="text" name="hispasms_gateway[hispasms_username]" id="hispasms_gateway[hispasms_username]" value="<?php echo $hispasms_username; ?>">
                        <span><?php _e( 'Enter your Hispasms Username', 'hispasms' ); ?></span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scrope="row"><?php _e( 'Hispasms Password', 'hispasms' ) ?></th>
                    <td>
                        <input type="text" name="hispasms_gateway[hispasms_password]" id="hispasms_gateway[hispasms_password]" value="<?php echo $hispasms_password; ?>">
                        <span><?php _e( 'Enter your Hispasms Password', 'hispasms' ); ?></span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scrope="row"><?php _e( 'Hispasms Sender Id', 'hispasms' ) ?></th>
                    <td>
                        <input type="text" name="hispasms_gateway[hispasms_sender_no]" id="hispasms_gateway[hispasms_sender_no]" value="<?php echo $hispasms_sender_no; ?>">
                        <span><?php _e( 'Sender ID that will appear in the Message with a maximum of 11 alphanumeric characters. Eg: HISPASMS, 34612345678 or 34911234567 (Do not use + before the Country Code)', 'hispasms' ) ?></span>
                    </td>
                </tr>
            </table>
        </div>

        <?php do_action( 'hispasms_gateway_settings_options_after' ) ?>
        <?php
    }

} // End of HispaSMS_Config_Options Class