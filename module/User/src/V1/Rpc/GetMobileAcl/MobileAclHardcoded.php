<?php

namespace User\V1\Rpc\GetMobileAcl;

class MobileAclHardcoded
{
    /**
     * @param  string  $domain
     * @return array
     */
    public function getMobileAcl($domain)
    {
        switch (true) {
            case $domain === "dev":
            case $domain === "dev.xtend.my.id":
                return [
                    "forms" => [
                        "leave",
                        "overtime",
                        "reimburse",
                        "purchase",
                        "deliveryOrder"
                    ],
                    "vehicle"       => true,
                    "myJob"         => true,
                    "stockIn"       => true,
                    "attendance"    => true,
                ];

            case $domain === "xtend":
            case $domain === "xtend.my.id":
                return [
                    "forms" => [
                        "leave",
                        "overtime",
                        "reimburse",
                        "purchase",
                        "deliveryOrder"
                    ],
                    "vehicle"       => true,
                    "myJob"         => true,
                    "stockIn"       => true,
                    "attendance"    => true,
                ];

            case $domain === "dikaragunaraksa":
            case $domain === "dikaragunaraksa.xtend.my.id":
                return [
                    "forms" => [
                        ""
                    ],
                    "vehicle"       => false,
                    "myJob"         => false,
                    "stockIn"       => false,
                    "attendance"    => true,
                ];

            case $domain === "mnu":
            case $domain === "mnu.xtend.my.id":
                return [
                    "forms" => [
                        "deliveryOrder"
                    ],
                    "vehicle"       => false,
                    "myJob"         => false,
                    "stockIn"       => false,
                    "attendance"    => false,
                ];

            default:
                return [
                    "forms" => [
                        "leave",
                        "overtime",
                        "reimburse",
                        "purchase",
                        "deliveryOrder"
                    ],
                    "vehicle"       => true,
                    "myJob"         => true,
                    "stockIn"       => true,
                    "attendance"    => true,
                ];
        }
    }
}
