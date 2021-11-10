<?php

use App\Models\BaseModel;
use App\Models\Slider;

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
            "id"=>BaseModel::SHOW_IN_YOUTH,
            "title"=>"Youth",
            "title_en"=>'Youth'
        ],
        3=>[
            "id"=>BaseModel::SHOW_IN_TSP,
            "title"=>"TSP",
            "title_en"=>'TSP'
        ],
        4=>[
            "id"=>BaseModel::SHOW_IN_INDUSTRY,
            "title"=>"Industry",
            "title_en"=>'Industry'
        ]
//        5=>[
//            "id"=>BaseModel::SHOW_IN_INDUSTRY_ASSOCIATION,
//            "title"=>"Industry Association",
//            "title_en"=>'Industry Association'
//        ]
    ],
    "banner_template"=>[
        Slider::BT_LR=>[
            "banner_template_code"=>Slider::BT_LR,
            "banner_template_title"=>Slider::BANNER_TEMPLATE_TYPES[Slider::BT_LR],
            "title"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_LEFT
            ],
            "sub_title"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_LEFT
            ],
            "button"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_LEFT
            ],
            "context_path"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_RIGHT
            ]
        ],
        Slider::BT_RL=>[
            "banner_template_code"=>Slider::BT_RL,
            "banner_template_title"=>Slider::BANNER_TEMPLATE_TYPES[Slider::BT_RL],
            "title"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "sub_title"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "button"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "context_path"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_LEFT
            ]
        ],
        Slider::BT_CB=>[
            "banner_template_code"=>Slider::BT_CB,
            "banner_template_title"=>Slider::BANNER_TEMPLATE_TYPES[Slider::BT_CB],
            "title"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_CENTER
            ],
            "sub_title"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_CENTER
            ],
            "button"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_CENTER
            ],
            "context_path"=>[
                "position"=>Slider::BANNER_CONTEXT_POSITION_BACKGROUND
            ]
        ]
    ]
];
