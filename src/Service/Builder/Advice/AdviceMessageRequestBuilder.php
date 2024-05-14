<?php

declare(strict_types=1);

namespace App\Service\Builder\Advice;

use App\Entity\UserInformation;
use App\Entity\Users;

class AdviceMessageRequestBuilder
{
    public function build(
        Users $user,
        array $consumptions,
        array $mostConsumedConsumptions,
        array $mostSavedConsumptions
    ): string {
        $request = $this->buildUserInformation($user);
        $request .= $this->buildByConsumption($consumptions, $mostConsumedConsumptions, $mostSavedConsumptions);

        return $request;
    }

    private function buildUserInformation(Users $user): string
    {
        $request = '';

        $userInformation = $user->getUserInformation();

        if ($userInformation->getCity()) {
            $request.= ' Vartotojas gyvena ' . $userInformation->getCity() . ' Lietuva. ';
        }

        if ($userInformation->getHouseType()) {
            $request.= ' Vartotojas gyvena ';
            $request.= $userInformation->getHouseType() === $userInformation::HOUSE_TYPE_INDIVIDUAL ? 'privačiame name. ' : 'daugiabutyje ';
        }

        if ($userInformation->getResidents()) {
            $request.= ' Vartotojas gyvena ' . $userInformation->getResidents() . ' asmenų šeimoje. ';
        }

        if ($userInformation->getLivingArea()) {
            $request.= ' Vartotojo gyvenamasis plotas ' . $userInformation->getLivingArea() . ' m2 ';
        }

        if ($userInformation->getHeatType()) {
            $request.= $userInformation->getHeatType() === UserInformation::HEAT_TYPE_CENTRAL ? ' Vartotojas naudojasi centriniu šildymu. ' : ' Vartotojas šildosi individualiai ';
        }

        if ($userInformation->getFuelType()) {
            $fuelType = '';
            switch ($userInformation->getFuelType()) {
                case UserInformation::FUEL_TYPE_NATURAL_GAS:
                    $fuelType = 'gamtinės dujos';
                    break;
                case UserInformation::FUEL_TYPE_FIREWOOD:
                    $fuelType = 'malkos';
                    break;
                case UserInformation::FUEL_TYPE_COAL:
                    $fuelType = 'anglys';
                    break;
                case UserInformation::FUEL_TYPE_BRIQUETTES:
                    $fuelType = 'briketai';
                    break;
                case UserInformation::FUEL_TYPE_PROPANE_BHUTAN:
                    $fuelType = 'propanas arba butanas';
                    break;
            }

            if ($fuelType) {
                $request .= ' Vartotojo kuro tipas - ' . $fuelType . '. ';
            }
        }

        return $request;
    }

    private function buildByConsumption(
        array $consumptions,
        array $mostConsumedConsumptions,
        array $mostSavedConsumptions
    ): string {
        $request = 'Praeitos savaitės vartotojo CO2 pėdsakas: ';

        foreach ($consumptions as $key => $consumption) {
            if ($consumption['consumption'] && $key !== 'total') {
                $request .= $consumption['title'] . ' ' . $consumption['consumption'] . ' kg ';
            }
        }

        $request .= '. ';

        if ($mostConsumedConsumptions) {
            $request.= 'Šių energijos tipų CO2 pedsakas padidėjo: ';

            $n = 0;

            foreach ($mostConsumedConsumptions as $mostConsumedConsumption) {
                if ($n < 3) {
                    $request .= $mostConsumedConsumption['title'] . ' padidejo ' . $mostConsumedConsumption['consumption'] . ' kg ';
                }
                $n++;
            }

            $request.= '. ';
        }

        if ($mostSavedConsumptions) {
            $request.= 'Šių energijos tipų CO2 pėdsakas sumažėjo: ';

            $n = 0;

            foreach ($mostSavedConsumptions as $mostSavedConsumption) {
                if ($n < 3) {
                    $request .= $mostSavedConsumption['title'] . ' sumažėjo ' . $mostSavedConsumption['consumption'] * -1 . ' kg ';
                }

                $n++;
            }

            $request.= '. ';
        }

        return $request;
    }
}