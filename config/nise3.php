<?php

use App\Models\BaseModel;
use App\Models\Banner;

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
        Banner::BT_LR=>[
            "banner_template_code"=>Banner::BT_LR,
            "banner_template_title"=>Banner::BANNER_TEMPLATE_TYPES[Banner::BT_LR],
            "title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ],
            "sub_title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ],
            "button"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ],
            "context_path"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ]
        ],
        Banner::BT_RL=>[
            "banner_template_code"=>Banner::BT_RL,
            "banner_template_title"=>Banner::BANNER_TEMPLATE_TYPES[Banner::BT_RL],
            "title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "sub_title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "button"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "context_path"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ]
        ],
        Banner::BT_CB=>[
            "banner_template_code"=>Banner::BT_CB,
            "banner_template_title"=>Banner::BANNER_TEMPLATE_TYPES[Banner::BT_CB],
            "title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_CENTER
            ],
            "sub_title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_CENTER
            ],
            "button"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_CENTER
            ],
            "context_path"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_BACKGROUND
            ]
        ]
    ],
    "static_page_template"=>[
        Banner::BT_LR=>[
            "banner_template_code"=>Banner::BT_LR,
            "banner_template_title"=>Banner::BANNER_TEMPLATE_TYPES[Banner::BT_LR],
            "title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ],
            "sub_title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ],
            "button"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ],
            "context_path"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ]
        ],
        Banner::BT_RL=>[
            "banner_template_code"=>Banner::BT_RL,
            "banner_template_title"=>Banner::BANNER_TEMPLATE_TYPES[Banner::BT_RL],
            "title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "sub_title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "button"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_RIGHT
            ],
            "context_path"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_LEFT
            ]
        ],
        Banner::BT_CB=>[
            "banner_template_code"=>Banner::BT_CB,
            "banner_template_title"=>Banner::BANNER_TEMPLATE_TYPES[Banner::BT_CB],
            "title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_CENTER
            ],
            "sub_title"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_CENTER
            ],
            "button"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_CENTER
            ],
            "context_path"=>[
                "position"=>Banner::BANNER_CONTEXT_POSITION_BACKGROUND
            ]
        ]
    ]
];
