<?php

namespace App\Service;

use App\Repository\CarRepository;
use App\Repository\CustomerRepository;

class MainViewControllerManager
{

    public function cleanArray($array)
    {
        foreach($array as $key=>$value){
            if(empty($value)) unset($array[$key]);
        }

        return array_merge($array);
    }

    public function cleanUnAcitveCustomers($customers)
    {
        foreach ($customers as $index=>$customer) {

            if (!$customer->getIsActive() ) {
                unset($customers[$index]);
            }
        }

        return $customers;
    }

    public function cleanUnAcitveCars($cars)
    {
        foreach ($cars as $index=>$car) {

            if (!$car->getIsActive() ) {
                unset($cars[$index]);
            }
        }

        return $cars;
    }

    public function cleanUnAcitveWorksheets($worksheets)
    {
        foreach ($worksheets as $index=>$worksheet) {

            if (!$worksheet->getIsActive() ) {
                unset($worksheets[$index]);
            }
        }

        return $worksheets;
    }

    public function checkCarIsIn($worksheets)
    {
        foreach ($worksheets as $index=>$worksheet) {
            $isActive =  $worksheet->getIsActive();
            $car = $worksheet->getCar();

            if (!$isActive || $car == null ) {
                unset($worksheets[$index]);
            }
        }

        return $worksheets;
    }

}
