<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\AlertLte;

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<?php /*if (isset($this->blocks['content-header'])) { */?><!--
				<h1><?/*= $this->blocks['content-header'] */?></h1>
			<?php /*} else { */?>
				<h1>
					<?php
		/*					if ($this->title !== null) {
                                echo \yii\helpers\Html::encode($this->title);
                            } else {
                                echo \yii\helpers\Inflector::camel2words(
                                    \yii\helpers\Inflector::id2camel($this->context->module->id)
                                );
                                echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                            } */?>
				</h1>
			--><?php /*} */?>

		<div>
			<?=
			Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
		</div>
	</section>

	<!-- Main content -->
	<section class="content" style="padding-top: 0px">
		<?= $content ?>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
