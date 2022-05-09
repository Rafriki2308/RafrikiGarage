<?php

namespace App\Service;

class EditManager
{

    public function setEntityCar(
        $car,
        $idCustomer,
        $regPlateEdited,
        $chasisNumEdited,
        $brandEdited,
        $modelEdited,
        $engineTypeEdited
    ) {

        if(!empty($idCustomer)){
            $car->setIdCustomer($idCustomer);
        }

        if(!empty($regPlateEdited)){
            $car->setRegPlate($regPlateEdited);
        }

        if(!empty($chasisNumEdited)){
            $car->setChasisNum($chasisNumEdited);
        }

        if(!empty($brandEdited)){
            $car->setBrand($brandEdited);
        }

        if(!empty($chasisNumEdited)){
            $car->setChasisNum($chasisNumEdited);
        }

        if(!empty($modelEdited)){
            $car->setModel($modelEdited);
        }

        if(!empty($engineTypeEdited)){
            $car->setEngineType($engineTypeEdited);
        }

        return $car;
    }

    public function setEntityCustomer(
        $customer,
        $nameEdited,
        $surnamesEdited,
        $idCardEdited,
        $telNumberEdited,
        $eMailEdited
    ) {
        
        if(!empty($nameEdited)){
            $customer->setName($nameEdited);
        }

        if(!empty($surnamesEdited)){
            $customer->setSurnames($surnamesEdited);
        }

        if(!empty($idCardEdited)){
            $customer->setIdCard($idCardEdited);
        }

        if(!empty($telNumberEdited)){
            $customer->setTelNumber($telNumberEdited);
        }

        if(!empty($eMailEdited)){
            $customer->setEMail($eMailEdited);
        }

        return $customer;
    }

    public function setEntityWorksheet($worksheet, $idCar, $descriptionEdit)
    {
        if(!empty($idCar))
        {
            $worksheet->setIdCar($idCar);
        }

        if(!empty($descriptionEdit))
        {
            $worksheet->setDescription($descriptionEdit);
        }

        return $worksheet;
    }

}
