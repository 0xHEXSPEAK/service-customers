<?php

use yii\mongodb\Migration as MongoMigration;

/**
 * Class m170309_092638_countries_collection
 */
class m170309_092638_countries_collection extends MongoMigration
{

    public static $collectionName = 'countries';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createCollection(self::$collectionName);

        $dataPath = dirname(__FILE__).'/../data/';
        $insertData = [];

        $csvCountries = fopen($dataPath.'countries.csv', 'r');

        /**
         * Goes through all countries
         */
        while(!feof($csvCountries)) {
            $countryRow = fgetcsv($csvCountries);
            $countryData = [
                'name' => $countryRow[0],
                'iso2' => $countryRow[1],
                'iso3' => $countryRow[2],
                'states' => [],
            ];

            $statesFileName = strtolower($countryRow[2]);
            $csvStatesPath = $dataPath."states/$statesFileName.csv";

            /**
             * Checks if states file exists for current country.
             * In case file is exist, we are going to fill states key
             */
            if (file_exists($csvStatesPath)) {
                $csvStates = fopen($csvStatesPath, 'r');
                while(!feof($csvStates)) {
                    $statesRow = fgetcsv($csvStates);
                    $countryData['states'][] = [
                        'name' => $statesRow[0],
                        'iso2' => $statesRow[1],
                    ];
                }
                fclose($csvStates);
            }

            /**
             * Pushes new country into the batch data request
             */
            $insertData[] = $countryData;
        }

        fclose($csvCountries);

        $this->batchInsert(self::$collectionName, $insertData);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropCollection(self::$collectionName);
    }
}
