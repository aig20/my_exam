<?php
/* @var $this SalesController */
/* @var $model Sales */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sales-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'industry_id'); ?>
		<?php echo $form->textField($model,'industry_id'); ?>
		<?php echo $form->error($model,'industry_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->textField($model,'country_id'); ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sales'); ?>
		<?php echo $form->textField($model,'sales'); ?>
		<?php echo $form->error($model,'sales'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year'); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->