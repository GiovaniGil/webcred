<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="overlay">
        <div class="fix" id="loading-img"><i class="fa fa-5x fa-circle-o-notch fa-spin"></i></i></div>
    </div>

    <?php Pjax::begin(['id' => 'pjax-grid-view']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'agency',
            'name',
            [
                'attribute' => 'birthday',
                'format' => ['date', DATE],
            ],
            'document',
            // 'registry',
            'address',
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

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        $url = Url::to(['customer/view', 'id' => $model->id]);
                        return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'view']);
                    },
                ]
            ],
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
<script>

</script>
