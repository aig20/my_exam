<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'company-grid',
	'afterAjaxUpdate'=>'loadData',
	'dataProvider'=>$pivotTable,
	'filter'=>null,
	'columns'=>array(
		'company',
		'industry',
		'country',
		'_2013',
		'_2014',
		'_2015',
		'_2016',
		'_2017'
	),
)); ?>