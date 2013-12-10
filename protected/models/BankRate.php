<?php
class BankRate extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
 
    public function tableName() {
        return 'bank_rate';
    }

    public function relations() {
        return array(
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
        );
    }

    /**
     * Return list of rates queried by city name
     * @param array
     * @return array
     */
    public function getRatesByCity($cities) {
    	return Yii::app()->db->createCommand()
			    ->select('c.city, r.rate')
			    ->from('bank_rate r')
			    ->join('city c', 'c.id=r.city_id')
			    ->where(array('in', 'LOWER(c.city)', $cities))
			    ->queryAll();
    }

    /**
     * Return list of rates queried by state name
     * @param array
     * @return array
     */
    public function getRatesByState($states) {
    	return Yii::app()->db->createCommand()
			    ->select('c.city, r.rate')
			    ->from('bank_rate r')
			    ->join('city c', 'c.id=r.city_id')
			    ->where(array('in', 'c.state_code', $states))
			    ->queryAll();
    }
}