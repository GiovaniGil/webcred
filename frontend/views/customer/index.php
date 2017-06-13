<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="overlay">
        <div class="fix" id="loading-img"><i class="fa fa-5x fa-circle-o-notch fa-spin"></i></i></div>
    </div>

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
    <p>
    <div class="row">
        <div class="col-lg-3 col-sm-3 col-6">
            <?= Html::a(Yii::t('frontend','Create Customer'), ['create'], ['class' => 'btn btn-success']) ?>

        </div>
        <?php $form = ActiveForm::begin(['id' => 'formSheet',
            'action' =>  urldecode(Yii::$app->urlManager->createUrl(['customer/import-sheet'])),
            'options' => ['method' => 'POST','enctype' => 'multipart/form-data']]) ?>

        <div class="col-lg-3 col-sm-3 col-6 col-sm-offset-5">
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary" style="height: inherit;">
                        Planilha&hellip; <input type="file" accept=".csv" id="excelSheet" name="excelSheet" style="display: none;" multiple>
                    </span>
                </label>
                <input type="text" id="excelSheetTxt" class="form-control" readonly>
                <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-upload']).' Importar',
                    ['class' => 'btn btn-default', 'style' => 'float:left; position:absolute; height:inherit']); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php if(sizeof($fileChunks) > 0): ?>
        <div class="row" id="rowFormChunk" style="padding-bottom: 30px">
            <div class="col-lg-6 col-sm-6 col-6 col-sm-offset-8">
                <?php $form = ActiveForm::begin(['id' => 'formChunk',
                    'action' =>  urldecode(Yii::$app->urlManager->createUrl(['customer/import-chunks'])),
                    'options' => ['method' => 'POST','enctype' => 'multipart/form-data']]) ?>
                <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-upload']).' Ainda existem partes não importadas',
                    ['class' => 'btn btn-default', 'style' => 'float:left; position:absolute; height:inherit']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-grid-view']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'agency',
            [
                'attribute' => 'name',
                'value' => function($model){
                    return $model->name;
                    //return explode(' ',$model->name)[0];
                }
            ],
            [
                'attribute' => 'birthday',
                'format' => ['date', DATE]
            ],
            'document',
            // 'registry',
            //'address',
            // 'complement',
            // 'zip_code',
            // 'neighbourhood',
            'city',
            // 'state',
            // 'phone1',
            // 'phone2',
            // 'phone3',
            // 'mail',
            // 'customer_password',
            // 'observation:ntext',
            // 'telemarketing',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>


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

/*.sort-numerical a.asc:after {
    content: '\\e153';
}

.sort-numerical a.desc:after {
    content: '\\e154';
}

.sort-ordinal a.asc:after {
    content: '\\e155';
}

.sort-ordinal a.desc:after {
    content: '\\e156';*/
}"
);

$script = <<< JS
     $(document).ready( function () {        
        
        /*function upload(fileInputId, fileIndex, action)
		{
		//multipart/form-data;
			// take the file from the input
			var file = document.getElementById(fileInputId).files[fileIndex]; 
			var reader = new FileReader();
			reader.readAsBinaryString(file); // alternatively you can use readAsDataURL
			
			reader.onload = function(event) {
			  alert('Load');
			}
			reader.onloadend  = function(evt)
			{
					// create XHR instance
					xhr = new XMLHttpRequest();

					// send the file through POST
					xhr.open("POST", action, true);
					var tokenCsrf = yii.getCsrfToken();
					xhr.setRequestHeader("Cache-Control", "no-cache");
                    xhr.setRequestHeader("Content-Type", "application/vnd.ms-excel");
                    xhr.setRequestHeader("X-File-Type", file.type);
                    xhr.setRequestHeader("X-Requested-With", 'XMLHttpRequest');
                    xhr.setRequestHeader("X-CSRF-Token", tokenCsrf);
                                                   
					// make sure we have the sendAsBinary method on all browsers
					XMLHttpRequest.prototype.mySendAsBinary = function(text){
						var data = new ArrayBuffer(text.length);
						var ui8a = new Uint8Array(data, 0);
						for (var i = 0; i < text.length; i++) 
						    ui8a[i] = (text.charCodeAt(i) & 0xff);
			
                        if(typeof window.Blob == "function")
			            {
			                 var blob = new Blob([data]);
			            }else{
			                 var bb = new (window.MozBlobBuilder || window.WebKitBlobBuilder || window.BlobBuilder)();
			                 bb.append(data);
			                 var blob = bb.getBlob();
			            }

                        var formData = new FormData();
                        formData.append('_frontendCSRF', tokenCsrf);
                        formData.append('myfile', encodeURIComponent(file));
						xhr.send(formData);
					}
					
					// let's track upload progress
					var eventSource = xhr.upload || xhr;
					eventSource.addEventListener("progress", function(e) {
						// get percentage of how much of the current file has been sent
						var position = e.position || e.loaded;
						var total = e.totalSize || e.total;
						var percentage = Math.round((position/total)*100);
						
						// here you should write your own code how you wish to proces this
						alert(percentage);
					});
					
					// state change observer - we need to know when and if the file was successfully uploaded
					xhr.onreadystatechange = function()
					{
						if(xhr.readyState == 4)
						{
							if(xhr.status == 200)
							{
								// process success
								alert('Sucesso');								
							}else{
								alert('Erro');
							}
						}
					};
					
					 xhr.onerror = function () {
                          alert("Error "+ xhr.statusText);
                     };
					// start sending
					//xhr.mySendAsBinary(evt.target.result);
			};
		}*/
        
        
        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $.fn.datepicker.defaults.language = "pt-BR";
        $('input[name="CustomerSearch[birthday]"]').datepicker({});        
        
        $( '#formSheet, #formChunk' ).on('beforeSubmit', function(e) {
        
        $('#sheet-danger').hide();
        $('#sheet-imported').hide();
        
        if($('#excelSheet').val() != "" || $(this).attr('id') == 'formChunk'){
                $(".overlay").show();
                var form = $(this);
                var formData = new FormData($(this)[0]);
                var idForm = $(this).attr('id');
                
                $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                timeout: 0,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {                       
                     setTimeout(function(){
                        $(".overlay").hide();
                        if(data.success){
                            $('#alert-text').text(data.msg);
                            $('#sheet-imported').show();
                            if(idForm == 'formChunk')
                                $('#rowFormChunk').hide();
                        }else{
                            $('#alert-danger').text(data.msg);
                            $('#sheet-danger').show();
                        }
                        //async:false - refresh apenas nos container, sem essa opção dá refresh na página toda
                        $.pjax.reload({container: '#pjax-grid-view', async: false});
                        $('#excelSheet').val('');
                        $('#excelSheetTxt').val('');
                      },3000);      
                      
                },
                error: function (exception) {                    
                    console.log(exception);
                    $(".overlay").hide();
                    location.reload();
                }
            });
          }
        }).on('submit', function(e){
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
<script>

</script>
