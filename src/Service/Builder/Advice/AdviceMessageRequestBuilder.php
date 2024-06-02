<?php

declare(strict_types=1);

namespace App\Service\Builder\Advice;

use App\Entity\EnergyTypes;
use App\Entity\UserInformation;
use App\Entity\Users;

class AdviceMessageRequestBuilder
{
    public const HEATING_MONTHS = [
        '01' => 'yes',
        '02' => 'yes',
        '03' => 'yes',
        '04' => 'yes',
        '05' => 'yes',
        '06' => 'no',
        '07' => 'no',
        '08' => 'no',
        '09' => 'no',
        '10' => 'yes',
        '11' => 'yes',
        '12' => 'yes',
    ];

    public function build(Users $user, array $consumptions): string
    {
        $userInformation = $user->getUserInformation();

        $request = 'Lives=' . $userInformation->getCity() . " \n";
        $request .= 'Building=' . $userInformation->getHouseType() === $userInformation::HOUSE_TYPE_PRIVATE ? 'Private_house' . " \n" : 'Multiflat' . " \n";
        $request .= 'Persons=' . $userInformation->getResidents() . " \n";
        $request .= 'Living_space=' . $userInformation->getLivingArea() . " \n";
        $request .= 'Living_space=' . $userInformation->getLivingArea() . " \n";

        $now = new \DateTime();
        $monthTitle = $now->format('F');
        $request .= 'Month=' . $monthTitle . " \n";

        $month = $now->format('m');
        $request .= 'Month=' . self::HEATING_MONTHS[$month] . " \n";

        $request .= 'Previous_electricity_consumption_household=' . $consumptions[EnergyTypes::ELECTRICITY_INDEX]['consumption'] . " \n";
        $request .= 'Previous_heat_consumption_TFA=' . $consumptions[EnergyTypes::HEAT_INDEX]['consumption'] . " \n";
        if ($userInformation->getFuelType() === UserInformation::FUEL_TYPE_NATURAL_GAS) {
            $request .= 'Previous_gas_consumption_TFA=' . $consumptions[EnergyTypes::HEAT_INDEX]['consumption'] . " \n";
        } else {
            $request .= 'Previous_gas_consumption_TFA=0' . " \n";
        }

        $request .= 'Previous_car_fuel=' . $consumptions[EnergyTypes::FUEL_INDEX]['consumption'] . " \n";

        return $request;
    }
}