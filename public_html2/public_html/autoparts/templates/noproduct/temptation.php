<div class="no_product">
	<h2><?php echo $err404name; ?></h2>
	<form id="callback">
		<p>Извините, на данный момент не все товары успели загрузиться на сайт. Обратитесь к оператору в чат или оставьте свой телефон, мы с вами свяжемся и обязательно поможем.</p>
		<input id="callbackPhone" type="text" name="phone" placeholder="Номер телефона">
		<input type="hidden" name="page" value="<?php echo $err404name; ?>">
		<p class="errPhone">Введите правильный номер телефона.</p>
		<input type="submit" value="Обратный звонок">
		<p class="sucsess">Заявка отправлена.</p>
	</form>
</div>
<div id="callbackSubmit" title="Заявка отправлена">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Наш оператор свяжется с Вами ближайшее время.
	</p>
</div>

<script>
	jQuery(document).ready(function() {
		jQuery('#callback').submit(function(ev) {
			
			if(jQuery('#callbackPhone').val().length<6) {
				jQuery('#callback .errPhone').show(400);
			} else {
				var phone = $('input#callbackPhone').val();
				var name = jQuery('input[type="hidden"]').text();
				$.post( "order.php", {
					phone: phone,
					page: document.location.href,
					productName : name.trim()
				})
				.done(function( data ) {
					fastOrderDialog.dialog( "open" );
					jQuery('#callback .errPhone').hide(400);
					jQuery('#callback .sucsess').show(400);
					jQuery('#callback input').prop('disabled', true);;
				});
			}
			return false;
		});
		jQuery('input#callbackPhone').mask('+38(000) 000 00 00');	
		jQuery('input#callbackPhone').focus(function() {
			if(jQuery(this).val()==''||jQuery(this).val('')=='+38')
				jQuery(this).val('+38');
		});
	});		
	fastOrderDialog = jQuery( "#callbackSubmit" ).dialog({
		  autoOpen: false,
		  width: 350,
		  modal: true,
		  buttons: {
			"Закрыть": function() {
			  fastOrderDialog.dialog( "close" );
			}
		  }
	});
</script>