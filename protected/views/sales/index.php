<?php
/* @var $this SalesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sales',
);

$this->menu=array(
	array('label'=>'Create Sales', 'url'=>array('create')),
	array('label'=>'Manage Sales', 'url'=>array('admin')),
);
?>

<h1>Sales</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
