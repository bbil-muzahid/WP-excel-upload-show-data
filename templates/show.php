<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style> .ShowTable tr th:first-child{text-transform: uppercase;}</style>

<div class="col-sm-12">
	<h3 class="text-center">All Installers</h3>
	<?php $db->show_all_installers(); ?>
</div>
<?php $db->edit_installer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
	jQuery(function($) {
		$(document).on( 'click', '#installer_edit', function(){
			var elementValue = '';
			var ID = $(this).parents('tr').attr('id');
			var installer_values = $('tr#'+ID+' td');

			$('#installerForm input').each(function(i){
				$(this).val(installer_values[i].innerHTML);
			});

			$('#editInstaller').modal();
		});

		$(document).on( 'click', '#editInstallerBtn', function(e){
			e.preventDefault();
			var ajaxUrl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
			var formData = $('#installerForm').serialize();
			$.ajax({
	            url : ajaxUrl+'?'+formData,
	            type : 'post',
	            data : { action : 'save_installer' },
	            success : function( response ) {
	            	$('#editInstaller').modal('hide');
	            	swal("Updated!", "Your modified data is saved", "success");
	            }
	        });

		});

		$(document).on( 'click', '#installer_delete', function(e){
			e.preventDefault();
			var ajaxUrl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
			var formID = $(this).attr('data_id');
			
			swal({
			  title: "Are you sure?",
			  text: "You will not be able to recover this installer",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Delete",
			  cancelButtonText: "Cancel",
			  closeOnConfirm: true,
			  closeOnCancel: true
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
			            url : ajaxUrl+'?ID='+formID,
			            type : 'post',
			            data : { action : 'delete_installer' },
			            success : function( response ) {
			                swal('deleted');
			            }
			        });
				}
			});
			// var delConfirm = confirm('You sure?');
			// if (delConfirm) {
			// 	console.log('value : '+delConfirm)
			// }
		});
	});
</script>