<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Sales Report</h1>

<form method="POST" enctype="multipart/form-data">
<div class="row">
	<div class="col-xs-12">
		<input type="file" name="excel_file"/><br>
		<input type="submit" name="submit" value="Upload" class="btn btn-default"/>
	</div>
</div>
</form>
<br>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'company-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header' => 'Company',
			'name' => 'company',
			'value' => '$data->companyTBL->company',
		),
		array(
			'header' => 'Industry',
			'name' => 'industry',
			'value' => '$data->industryTBL->industry',
		),
		array(
			'header' => 'Country',
			'name' => 'country',
			'value' => '$data->countryTBL->country',
		),
		'year',
		'sales'
	),
)); ?>