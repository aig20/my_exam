<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
	
		if(isset($_POST["submit"])) 
		{
			Yii::import('application.components.*');
			require_once('excel_reader.php');
			$target_dir = Yii::app()->basePath."/uploads/";
			$target_file = $target_dir . basename($_FILES["excel_file"]["name"]);
			$file = file_get_contents($_FILES['excel_file']['tmp_name']);
			$excel = new PhpExcelReader();
			
			if ($file == NULL) {
			  // error
			}
			else {
				if (move_uploaded_file($_FILES["excel_file"]["tmp_name"], $target_file)) {
					$excel->read($target_file);
					foreach($excel->sheets[0]['cells'] as $key => $value) {
						$company = Company::model()->findAllByAttributes(array('company'=>$value[1]));
						if(!$company){
							$company = new Company();
							$company->company = $value[1];
							$company->save();
						}
						
						$industry = Industry::model()->findAllByAttributes(array('industry'=>$value[2]));
						
						if(!$industry){
							$industry = new Industry();
							$industry->industry = $value[2];
							$industry->save();
						}
						
						$country = Country::model()->findAllByAttributes(array('country'=>$value[3]));
						if(!$country){
							$country = new Country();
							$country->country = $value[3];
							$country->save();
						}
						
						$sales1 = new Sales();
						$sales1->company_id = $company[0]->id;
						$sales1->industry_id = $industry[0]->id;
						$sales1->country_id = $country[0]->id;
						$sales1->sales = $value[4];
						$sales1->year = '2013';
						$sales1->save();
							
						$sales2 = new Sales();
						$sales2->company_id = $company[0]->id;
						$sales2->industry_id = $industry[0]->id;
						$sales2->country_id = $country[0]->id;
						$sales2->sales = $value[5];
						$sales2->year = 2014;
						$sales2->save();
						
						$sales3 = new Sales();
						$sales3->company_id = $company[0]->id;
						$sales3->industry_id = $industry[0]->id;
						$sales3->country_id = $country[0]->id;
						$sales3->sales = $value[6];
						$sales3->year = 2015;
						$sales3->save();
						
						$sales4 = new Sales();
						$sales4->company_id = $company[0]->id;
						$sales4->industry_id = $industry[0]->id;
						$sales4->country_id = $country[0]->id;
						$sales4->sales = $value[7];
						$sales4->year = 2016;
						$sales4->save();
						
						$sales5 = new Sales();
						$sales5->company_id = $company[0]->id;
						$sales5->industry_id = $industry[0]->id;
						$sales5->country_id = $country[0]->id;
						$sales5->sales = $value[8];
						$sales5->year = 2017;
						$sales5->save();
					}
				}
			}
		}
			$model=new Sales('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['Sales']))
				$model->attributes=$_GET['Sales'];
			
			$this->render('index',array(
					'model'=>$model,
			));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}