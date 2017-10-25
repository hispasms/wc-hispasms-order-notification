	<div class="iframe-menu-hispasms">
	  <!-- START - BALANCE -->
	  <div class="box-credit">
	    <span><?php _e( 'Account Balance', 'hispasms' ); ?> : </span>
	    <div class="box-credit-amount">
	    <!-- Saldo de API -->
	    <?php echo HispaSMS_Gateways::init()->hispasms_get_account_balance( $balance = '' ); ?>
	    </div>
	  </div>
	  <!-- END - BALANCE -->
	  <!-- START - BUY BALANCE - SIGN-UP -->
	  <div class="buy-signup">	
		<div class="boton-order-sign-up-general">
		 <a href="https://www.seidonet.com/clientes/cart.php?gid=5" target="_blank"> <span class="dashicons dashicons-cart"> </span> <?php _e( 'Buy Balance', 'hispasms' ); ?></a>
		</div>
		<div class="boton-order-sign-up-general">
		 <a href="https://www.hispasms.com/contacto/" target="_blank"> <span class="dashicons dashicons-edit"> </span> <?php _e( 'Sign Up', 'hispasms' ); ?></a>
		</div>
	  </div>
	  <!-- END - BUY BALANCE - SIGN-UP -->
	  <!-- START - ACCESS PORTAL - HISPASMS WEBSITE -->
	  <div class="access-portal-home">  
	   <div class="boton-access-portal">
	    <a href="https://portal.hispasms.com" target="_blank"> <span class="dashicons dashicons-analytics"> </span> <?php _e( 'Portal Access', 'hispasms' ); ?></a>
	   </div> 
	   <div class="boton-home-hispasms">
	    <a href="https://www.hispasms.com" target="_blank"> <span class="dashicons dashicons-admin-home">   </span> <?php _e( 'HispaSMS Website', 'hispasms' ); ?></a>
	   </div>
	  </div>
	  <!-- END - ACCESS PORTAL - HISPASMS WEBSITE -->
	  <div class="logo-hispa-menu">
	    <div class="box-credit-img"></div>
	  </div>
	<div class="clear"></div>
	</div>
