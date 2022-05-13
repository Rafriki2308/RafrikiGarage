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

    public function checkWorksheetIsActive($worksheets)
    {
        $i = null;
        foreach ($worksheets as $worksheet) {
            $isActive = $worksheet->getIsActive();

            if ($isActive) {
                $i++;
            }
        }

        if(!$i){
            return false;
        }

        return true;
    }

    public function checkCarIsIn($worksheets)
    {
        foreach ($worksheets as $index=>$worksheet) {
            $isActive = $isActive = $worksheet->getIsActive();

            if (!$isActive) {
                unset($worksheets[$index]);
            }
        }

        return $worksheets;
    }

}
