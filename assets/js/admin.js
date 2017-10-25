;(function($) {

	// Gateway select change event
	$('.hide_class').hide();
	$('.hispasms_hide_class').hide();
	$('#hispasms_gateway\\[sms_gateway\\]').on( 'change', function() {
		var self = $(this),
			value = self.val();
		$('.hide_class').hide();
		$('.'+value+'_wrapper').fadeIn();
	});

	$('#wpuf-hispasms_message_diff_status\\[enable_diff_status_mesg\\]').on( 'change', function() {
		var self = $(this),
			value = self.val();
		if ( self.is(':checked')) {
			$('.hispasms_hide_class').hide();
			$('.hispasms_different_message_status_wrapper').fadeIn();
		} else {
			$('.hispasms_hide_class').hide();
		}
	});

	// Trigger when a change occurs in gateway select box
	$('#hispasms_gateway\\[sms_gateway\\]').trigger('change');
	$('#wpuf-hispasms_message_diff_status\\[enable_diff_status_mesg\\]').trigger('change');

	// handle send sms from order page in admin panale
	var w = $('.hispasms_send_sms').width(),
		h = $('.hispasms_send_sms').height(),
		block = $('#hispasms_send_sms_overlay_block').css({
					'width' : w+'px',
					'height' : h+'px',
				});


	$( 'input#hispasms_send_sms_button' ).on( 'click', function(e) {
		e.preventDefault();
		var self = $(this),
			textareaValue = $('#hispasms_sms_to_buyer').val(),
			smsNonce = $('#hispasms_send_sms_nonce').val(),
			orderId = $('input[name=order_id][type=hidden]').val(),
			data = {
				action : 'hispasms_send_sms_to_buyer',
				textareavalue: textareaValue,
				sms_nonce: smsNonce,
				order_id: orderId
			};

		if( !textareaValue ) {
			return;
		}
		self.attr( 'disabled', true );
		block.show();
		$.post( hispasms.ajaxurl, data , function( res ) {
			if ( res.success ) {
				$('div.hispasms_send_sms_result').html( res.data.message ).show();
				$('#hispasms_sms_to_buyer').val('');
				block.hide();
				self.attr( 'disabled', false );
			} else {
				$('div.hispasms_send_sms_result').html( res.data.message ).show();
				block.hide();
				self.attr( 'disabled', false );
			}
		});
	});


})(jQuery);