<?php

class m131209_221545_add_schema extends CDbMigration
{
	public function up()
	{
		echo "Creating Tables.\n";
		$sql = file_get_contents(Yii::getPathOfAlias('application.data') . '/schema.mysql.sql');
                $this->execute($sql);

                echo "Importing States.\n";
                $sql = file_get_contents(Yii::getPathOfAlias('application.data') . '/states.sql');
                $this->execute($sql);

                echo "Importing Cities.\n";
                $sql = file_get_contents(Yii::getPathOfAlias('application.data') . '/cities.sql');
                $this->execute($sql);

                echo "Creating Test Bank Rates.\n";
                $rows = Yii::app()->db->createCommand("SELECT * FROM city")->queryAll();
                if($rows) {
                	foreach($rows as $row) {
                		$rate = rand(1, 999);
                		echo sprintf("Rate: %s City: %s\n", $rate, $row['city']);
                		$model = new BankRate;
                		$model->city_id = $row['id'];
                		$model->rate = $rate;
                		$model->save();
                	}
                }
                echo "Done.\n";
	}

	public function down()
	{
		echo "m131209_221545_add_schema does not support migration down.\n";
		return false;
	}
}