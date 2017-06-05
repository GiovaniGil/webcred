<?php

use asinfotrack\yii2\audittrail\widgets\AuditTrail;
use common\models\User;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

?>
<?PHP

echo Alert::widget([
    'options' => [
        'class' => 'alert-success',
        'style' => 'display:none',
        'id' => 'sheet-imported'
    ],
    'body' => '<div id="alert-text">...</div>',
]);

echo Alert::widget([
    'options' => [
        'class' => 'alert-danger',
        'style' => 'display:none',
        'id' => 'sheet-danger'
    ],
    'body' => '<div id="alert-danger">...</div>',
]);

?>
<div class="overlay">
    <div class="fix" id="loading-img"><i class="fa fa-5x fa-circle-o-notch fa-spin"></i></i></div>
</div>
<section class="content">
    <fieldset><legend>Upload</legend>
    <div class="customer-form container">
        <div class="row">
            <?php $form = ActiveForm::begin(['id' => 'formSheet',
                'action' =>  urldecode(Yii::$app->urlManager->createUrl(['customer/upload-file'])),
                'options' => ['method' => 'POST','enctype' => 'multipart/form-data']]) ?>
            <div class="col-sm-4">

                <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary" style="height: inherit;">
                        Arquivo&hellip; <?= $form->field($model, 'file', ['template' => "{input}"])->fileInput(['id' => 'excelSheet', 'style' => 'display: none;']) ?>

                        <input type="hidden" name="id" value="<?= $model->id ?>" />
                    </span>
                    </label>
                    <input type="text" id="fileUploadTxt" class="form-control" readonly>
                    <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-upload']).' Enviar',
                        ['class' => 'btn btn-default', 'style' => 'float:left; position:absolute; height:inherit']); ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
        <!--<div class="row">
            <div class="col-sm-4">
                <div id="selected_file"></div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-sm-12"><hr class="col-sm-12"></div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div id="container_files"> </div>
                </div>
            </div>
        </div>
    </div>
    </fieldset>
</section>

<?php

$this->registerCss("
#loading-img {    
    width: 40px;
    margin:100px auto;  
    position: sticky;
    top: 50%;
    left: 50%;
    margin-top: -50px;
    margin-left: -100px;
}

.overlay {
    background: #e9e9e9;
    display: none;
    position: fixed;
    overflow-y: scroll;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    opacity: 0.5;
    z-index:1000;
}


/* add sorting icons to gridview sort links */
a.asc:after, a.desc:after {
    position: relative;
    top: 1px;
    display: inline-block;
    font-family: 'FontAwesome';
    font-style: normal;
    font-weight: normal;
    line-height: 1;
    padding-left: 5px;
}

a.asc:after {
    content: '\\f0d8';
}

a.desc:after {
    content: '\\f0d7';
}

"
);

$script = <<< JS


     $(document).ready( function () {
     
        $( '#container_files' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
        
        getfilelist( $('#container_files') , '$model->folder' );       
        
        function getfilelist( cont, root ) {
            $( cont ).addClass( 'wait' );
                
            $.post( '../../common/treeview/Folder_tree.php', { dir: root }, function( data ) {
        
                $( cont ).find( '.start' ).html( '' );
                $( cont ).removeClass( 'wait' ).append( data );
                if( 'Sample' == root ) 
                    $( cont ).find('UL:hidden').show();
                else 
                    $( cont ).find('UL:hidden').slideDown({ duration: 500, easing: null });
                
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
		    if( entry.hasClass('file')){

		        fileName = $(this).attr('href');
		        var r = confirm("Você tem certeza que deseja excluir o arquivo '"+fileName.split('/')[fileName.split('/').length-1]+"'?");
	    
		        if (r){
		            $(".overlay").show();
                    $.post({
                    url: 'index.php?r=customer/delete-file',
                    type: 'POST',
                    data: {file: fileName},
                    success: function (data) {                                                
                         setTimeout(function(){
                            $(".overlay").hide();
                            if(data.success){
                                $('#alert-text').text(data.msg);
                                $('#sheet-imported').show();
                                $( '#container_files' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
                                getfilelist( $('#container_files') , '$model->folder' );
                            }else{
                                $('#alert-danger').text(data.msg);
                                $('#sheet-danger').show();
                            }                                                    
                          },3000);                               
                    },
                    error: function (exception) {
                        alert('Error: '+exception);
                        $(".overlay").hide();
                    }
                });
                }
		    
		
		    }

		}
	return false;
	});
        
        
        $('.field-excelSheet').each(function(){        
            $(this).removeClass('form-group');
        });
        
        $( '#formSheet' ).on('beforeSubmit', function(e) {

        $('#sheet-danger').hide();
        $('#sheet-imported').hide();
        
        if($('#excelSheet').val() != ""){
                $(".overlay").show();
                var form = $(this);
                var formData = new FormData($(this)[0]);

                $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {                       
                     
                     setTimeout(function(){
                        $(".overlay").hide();
                        if(data.success){
                            $('#alert-text').text(data.msg);
                            $('#sheet-imported').show();
                            $( '#container_files' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
                            getfilelist( $('#container_files') , '$model->folder' );
                        }else{
                            $('#alert-danger').text(data.msg);
                            $('#sheet-danger').show();
                        }
                        //async:false - refresh apenas nos container, sem essa opção dá refresh na página toda
                        //$.pjax.reload({container: '#pjax-grid-view', async: false});
                        $('#excelSheet').val('');
                        $('#fileUploadTxt').val('');
                                                
                      },3000);      
                      
                },
                error: function (exception) {
                    alert('Error: '+exception);
                    $(".overlay").hide();
                }
            });
        }}).on('submit', function(e){
            e.preventDefault();
        });
});

$(function() {

        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = '';
            
            $.each( input.get(0).files, function (index, file) {
                label = file.name;
            });
            
            input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' arquivos selecionados' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });                       
        });

    });
  
JS;
$this->registerJs($script);
?>


