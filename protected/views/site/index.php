<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Sales Report</h1>

<form>
<div class="row">
	<div class="col-xs-12">
		<input type="file" name="excel-file"/><br>
		<input type="submit" value="Upload" class="btn btn-default"/>
	</div>
</div>
</form>
<br>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'company-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'company',
		'industry',
		'country',
		'year',
		'sales'
	),
)); ?>