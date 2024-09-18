<?php

namespace App\Services;
use App\Models\Ips;


class IpCheckService{


    public function CountIps($ipAddress,$date){
        $isMoreFive;

        $ips = Ips::where([
            ['ip', '=', $ipAddress],
            ['date', '=', $date],
        ])->get();

        count($ips) > 5 ? $isMoreFive = true : $isMoreFive = false;
        return $isMoreFive;

    }


}