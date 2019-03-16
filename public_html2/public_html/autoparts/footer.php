
			</div>
		</section>
		<link rel="stylesheet" href="assets/vendor/summernote/summernote.css" />
		<link rel="stylesheet" href="assets/vendor/summernote/summernote-bs3.css" />

		<style>
			.dotted_child>div {border-bottom:1px dotted #ccc}
			.dotted_child>div:nth-last-child(1) {border-bottom:0px dotted #ccc}
		</style>
		<!-- Examples -->
		<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		<!-- Vendor -->
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<script src="assets/javascripts/ui-elements/examples.modals.js"></script>

		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/ios7-switch/ios7-switch.js"></script>
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<script src="assets/vendor/summernote/summernote.js"></script>


		<script>
		// SummerNote
			(function( $ ) {

				'use strict';

				if ( $.isFunction($.fn[ 'summernote' ]) ) {

					$(function() {
						$('[data-plugin-summernote]').each(function() {
							var $this = $( this ),
								opts = {};

							var pluginOptions = $this.data('plugin-options');
							if (pluginOptions)
								opts = pluginOptions;

							$this.themePluginSummerNote(opts);
						});
					});

				}

			}).apply(this, [ jQuery ]);
			jQuery(document).ready(function() {
				jQuery('.simple-frame-modal').magnificPopup({
				  type: 'iframe'
				});
				$('#delete_alert').magnificPopup();
				
				$('a[href*="admin/del/"').on('click', function(e) {
					e.preventDefault();
					$('#delete_alert').click();
					$('#delete_alert_box a').attr('href', $(this).attr('href'));
				});
			});
			$('a[href*="admin/del/"').on('click', function(e) {
				e.preventDefault();
				$('#delete_alert').click();
				$('#delete_alert_box a').attr('href', $(this).attr('href'));
			});
		</script>
		<style>@media(min-width:767px){.dataTable tr td{overflow:hidden;}}</style>
		
		<div class="hidden">
			<a href="#delete_alert_box" id="delete_alert"></a>
			<div id="delete_alert_box" style="width: 400px; background: #fff; padding: 20px 10px 30px; text-align: center; margin: 0 auto;">
				<h3>Підтвердіть видалення</h3>
				<h2><a href="#"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Видалити</button></a></h2>
			</div>
		</div>
	</body>
</html>