<?php

namespace ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ProjectBundle\Entity\Address;

class LoadAddressData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        /*
        $adr1 = new Address();
        $adr1->setCountry('Russia');
        $adr1->setCity('Moscow');
        $adr1->setStreet('Pushkina str');
        $adr1->setHome(10);
        */
        
        //  отключаем SQL Log чтобы убавить тормоза
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
        
        $data = $this->getData();
        foreach($data as $key=>$country_data){
            foreach ($country_data["cities"] as $city_data){
                if (file_exists(__DIR__."/data/". $city_data[2] .".txt")){
                    //  заносим строки в массив
                    $streets = file(__DIR__."/data/". $city_data[2] .".txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    while (count($streets)) {
                        //  берем и удаляем 1 элемент массива
                        $street = array_shift($streets);

                            //  generate zipcode
                            $zipcode = $city_data[1]*1000 + mt_rand(0,199);
                            //  range N homes for each streen N=2 (70)
                            $x = rand(1,96);
                            $y = $x+3;
                            foreach(range($x,$y) as $home){
                                //  add PostAddress
                                //  выполняем нативный INSERT
                                $manager->getConnection()->insert('address',
                                    array(
                                        'country'   => $country_data["country"],
                                        'city'      => $city_data[0],
                                        'street'    => $street,
                                        'home'      => $home,
                                        'zipcode'   => $zipcode,
                                        'created_at'=> date("Y-m-d H:i:s", mktime(mt_rand(1,23), mt_rand(1,59), mt_rand(1,59), mt_rand(1,12), mt_rand(1,31), mt_rand(2010,2015)))
                                    )
                                );
                            }
                            $manager->flush();
                            //  чистим ObjectManager после каждых N запросов в базу
                            //  т.к. приводило к тормозам и переполнению памяти скриптом
                            //  исключаем очистку $country, т.к. вызовет ошибку при добавлении в базу следующего города
                            $manager->clear();
                    }
                }
            }
        }
    }
    
    //  тестовые данные
    private function getData(){
        return 
        [
            ["country"  => "Россия",    "cities" => 
                [
                /*  ["название", первые 3 цифры индекса, "data/{имя файлы с улицами}.txt"]  */ 
                    ["Москва",          101, "moscow"],
                    ["Санкт-Петербург", 197, "spb"],
                    ["Ростов-на-Дону",  344, "rostovondon"],
                    ["Казань",          420, "kazan"],
                    ["Нижний Новгород", 603, "nnovgorod"],
                    ["Ульяновск",       432, "ulyanovsk"],
                    ["Самара",          443, "samara"],
                    ["Екатеринбург",    620, "ekaterinburg"],
                    ["Волгоград",       400, "volgograd"]
                ]
            ],
            ["country"  => "Беларусь",  "cities" => 
                [
                    ["Минск",           220, "minsk"]
                ]
            ],
        ];
    }
}