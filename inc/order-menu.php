	<div class="iframe-order-customer-hispasms">
	  <div class="logo-hispa-order-credit">
	    <div class="box-order-credit-img"></div>
	  </div>
      <div class="box-order-credit">
	    <span><?php _e( 'Account Balance', 'hispasms' ); ?> : </span>
	    <div class="box-order-credit-amount">
	    <!-- Saldo de API - START -->
	    <?php echo HispaSMS_Gateways::init()->hispasms_get_account_balance( $balance = '' ); ?>
	    <!-- Saldo de API - END -->
		</div>
	  </div>
	</div>		
