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
	'afterAjaxUpdate'=>'loadData',
	'beforeAjaxUpdate'=>'setData',
	'dataProvider'=>$pivotTable,
	'filter'=>null,
	'columns'=>array(
		array(
			'header'=>'Company',
			'name'=>'company'
		),
		array(
			'header'=>'Industry',
			'name'=>'industry'
		),
		array(
			'header'=>'Country',
			'name'=>'country'
		),
		array(
			'header'=>'2013',
			'name'=>'_2013'
		),
		array(
			'header'=>'2014',
			'name'=>'_2014'
		),
		array(
			'header'=>'2015',
			'name'=>'_2015'
		),
		array(
			'header'=>'2016',
			'name'=>'_2016'
		),
		array(
			'header'=>'2017',
			'name'=>'_2017'
		)
	),
)); ?>

<div id="piechart" style="width: 900px; height: 500px;"></div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sales-grid',
	'dataProvider'=>$model2->search(),
	'filter'=>$model2,
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
		array(
			'header' => 'Sales',
			'name' => 'sales',
			'footer' => $model2->getTotalSales($model2->search()->getKeys()),
		),
		'year',
	),
)); ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	var year = '', 
		sort, 
		pieData = [['Company', 'Sales']];
	
	function drawChart() {

		var data = google.visualization.arrayToDataTable(pieData);

		var options = {
			title: 'Top 5 sales for '+year,
			pieHole: 0.4,
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);
	}

	function loadData(id, data) {
		console.log(id);
		var array = [];
		var headers = [];
		pieData = [];
		$('#'+id+' table thead th a').each(function(index, item) {
			headers[index] = $(item).html();
		});
		$('#'+id+' table tbody tr').has('td').each(function() {
			var arrayItem = {};
			$('td', $(this)).each(function(index, item) {
				arrayItem[headers[index]] = $(item).html();
			});
			array.push(arrayItem);
		});
		console.log(array);
		pieData[0] = ['Company', 'Sales'];
		for (var i = 0; i < 5; i++) {
			pieData[i+1] = [array[i].Company+' - '+array[i].Country, parseInt(array[i][year])];
		}
		console.log(pieData);
		drawChart();
	}

	function setData(id, options) {
		console.log(options);
		sort = getAllUrlParams(unescape(options.url)).sort;
		strYear = sort.replace('_','');
		strYear = strYear.split(".");
		year = strYear[0];  
		//str = JSON.stringify(obj);
		console.log(year);
	}

	function getAllUrlParams(url) {	

		// get query string from url (optional) or window
		var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

		// we'll store the parameters here
		var obj = {};

		// if query string exists
		if (queryString) {

			// stuff after # is not part of query string, so get rid of it
			queryString = queryString.split('#')[0];

			// split our query string into its component parts
			var arr = queryString.split('&');

			for (var i=0; i<arr.length; i++) {
			// separate the keys and the values
			var a = arr[i].split('=');

			// in case params look like: list[]=thing1&list[]=thing2
			var paramNum = undefined;
			var paramName = a[0].replace(/\[\d*\]/, function(v) {
				paramNum = v.slice(1,-1);
				return '';
			});

			// set parameter value (use 'true' if empty)
			var paramValue = typeof(a[1])==='undefined' ? true : a[1];

			// (optional) keep case consistent
			paramName = paramName.toLowerCase();
			paramValue = paramValue.toLowerCase();

			// if parameter name already exists
			if (obj[paramName]) {
				// convert value to array (if still string)
				if (typeof obj[paramName] === 'string') {
				obj[paramName] = [obj[paramName]];
				}
				// if no array index number specified...
				if (typeof paramNum === 'undefined') {
				// put the value on the end of the array
				obj[paramName].push(paramValue);
				}
				// if array index number specified...
				else {
				// put the value at that index number
				obj[paramName][paramNum] = paramValue;
				}
			}
			// if param name doesn't exist yet, set it
			else {
				obj[paramName] = paramValue;
			}
			}
		}

		return obj;
	}
</script>