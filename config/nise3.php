<?php

use App\Models\BaseModel;

return [
    "is_dev_mode" => env("IS_DEVELOPMENT_MOOD", false),
    "should_ssl_verify" => env("IS_SSL_VERIFY", false),
    "default_language_code" => ["BN", "EN"],
    "show_in"=>[
        1=>[
            "id"=>BaseModel::SHOW_IN_NISE3,
            "title"=>"Nise3",
            "title_en"=>'Nise3'
        ],
        2=>[
            "id"=>BaseModel::SHOW_IN_TSP,
            "title"=>"TSP",
            "title_en"=>'TSP'
        ],
        3=>[
            "id"=>BaseModel::SHOW_IN_INDUSTRY,
            "title"=>"Industry",
            "title_en"=>'Industry'
        ],
        4=>[
            "id"=>BaseModel::SHOW_IN_INDUSTRY_ASSOCIATION,
            "title"=>"Industry Association",
            "title_en"=>'Industry Association'
        ]
    ]
];
