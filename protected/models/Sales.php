<?php

/**
 * This is the model class for table "tbl_sales".
 *
 * The followings are the available columns in table 'tbl_sales':
 * @property integer $id
 * @property string $company_id
 * @property integer $industry_id
 * @property integer $country_id
 * @property integer $sales
 * @property integer $year
 */
class Sales extends CActiveRecord
{
	public $company;
	public $industry;
	public $country;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, industry_id, country_id, sales, year', 'required'),
			array('id, industry_id, country_id, sales, year', 'numerical', 'integerOnly'=>true),
			array('company_id', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, industry_id, country_id, sales, year, company, industry, country', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'companyTBL' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'industryTBL' => array(self::BELONGS_TO, 'Industry', 'industry_id'),
			'countryTBL' => array(self::BELONGS_TO, 'Country', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company',
			'industry_id' => 'Industry',
			'country_id' => 'Country',
			'sales' => 'Sales',
			'year' => 'Year',
			'company' => 'Company',
			'industry' => 'Industry',
			'country' => 'Company'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('industry_id',$this->industry_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('sales',$this->sales);
		$criteria->compare('year',$this->year);
		$criteria->compare('companyTBL.company', $this->company, true );
		$criteria->compare('industryTBL.industry', $this->industry, true );
		$criteria->compare('countryTBL.country', $this->industry, true );
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
					'attributes'=>array(
							'company'=>array(
									'asc'=>'companyTBL.company',
									'desc'=>'companyTBL.company DESC',
							),
							'industry'=>array(
									'asc'=>'industryTBL.industry',
									'desc'=>'industryTBL.industry DESC',
							),
							'country'=>array(
									'asc'=>'countryTBL.country',
									'desc'=>'countryTBL.country DESC',
							)
							,
							'*',
					),
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
