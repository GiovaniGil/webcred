<?php

use asinfotrack\yii2\audittrail\widgets\AuditTrail;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<section class="content">
    <div class="customer-form container">
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'folder')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div id="selected_file"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div id="container_files"> </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$script = <<< JS

    $(document).ready(function(){
        
        
	$( '#container_files' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
	
	getfilelist( $('#container_files') , '$model->folder' );
	
	function getfilelist( cont, root ) {
	
		$( cont ).addClass( 'wait' );
			
		$.post( '/webcred/common/treeview/Folder_tree.php', { dir: root }, function( data ) {
	
			$( cont ).find( '.start' ).html( '' );
			$( cont ).removeClass( 'wait' ).append( data );
			if( 'Sample' == root ) 
				$( cont ).find('UL:hidden').show();
			else 
				$( cont ).find('UL:hidden').slideDown({ duration: 500, easing: null });
			
			$("div.file").remove();
		});
	}	
	
	$( '#container_files' ).on('click', 'LI A', function() {
		var entry = $(this).parent();
		
		if( entry.hasClass('folder') ) {
			if( entry.hasClass('collapsed') ) {
						
				entry.find('UL').remove();
				getfilelist( entry, escape( $(this).attr('rel') ));
				entry.removeClass('collapsed').addClass('expanded');
			}
			else {
				
				entry.find('UL').slideUp({ duration: 500, easing: null });
				entry.removeClass('expanded').addClass('collapsed');
			}
		} else {
			 if( entry.hasClass('open-file')){
		           return true;		        
		     }
		}
	return false;
	});                       
        
});

JS;
$this->registerJs($script);
?>