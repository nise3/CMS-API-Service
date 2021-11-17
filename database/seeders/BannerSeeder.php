<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\Banner;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Banner::query()->truncate();
        $sliders = Slider::all();

        foreach ($sliders as $slider) {
            /** @var Banner $banner */
            $banner = Banner::factory()->state(
                new sequence(
                    [
                        'slider_id' => $slider->id
                    ],
                )
            )->create();
            CmsLanguage::factory()
                ->state(
                    new Sequence(
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'hi',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_TITLE,
                            'column_value' => "अगर आप किसी एग्जाम की तैयारी कर रहे हैं, तो जेनरल नॉलेज अच्छी करना बेहद जरूरी। तो चलिए जानते हैं कौन-से सवाल"
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'hi',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_SUB_TITLE,
                            'column_value' => "भारत का इतिहास या फिर भूगोल, यह इतना बड़ा है कि इसको याद करने में बड़ों-बड़ों की रातों की नींद हराम हो जाती है। सभी प्रश्‍नों के उत्‍तर याद करना सभी के लिए लगभग असंभव है, आज हम आपको बता रहे हैं उन खास प्रश्‍नों को उनके उत्‍तर के साथ जो प्रतियोगी परिक्षाओं से लेकर जॉब इंटरव्‍यू में ज्‍यादातर पूछे जाते हैं। अगर आपको इन प्रश्‍नों के उत्‍तर पता हैं तो आपकी मुश्‍किलें हल हो जाएंगी"
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'hi',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                            'column_value' => "भारत का इतिहास या फिर भूगोल"
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'hi',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_BUTTON_TEXT,
                            'column_value' => "भारत का इतिहास या फिर भूगोल"
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'te',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_TITLE,
                            'column_value' => "మీరు ఏదైనా పరీక్షకు సిద్ధమవుతున్నట్లయితే, మంచి సాధారణ జ్ఞానం కలిగి ఉండటం చాలా ముఖ్యం. కాబట్టి ఏయే ప్రశ్నలు తెలుసుకుందాం"
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'te',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_SUB_TITLE,
                            'column_value' => "భారతదేశం యొక్క చరిత్ర లేదా భౌగోళికం, ఇది చాలా పెద్దది, దానిని గుర్తుంచుకోవడంలో పెద్దలకు నిద్రలేని రాత్రులు అవుతుంది. ప్రతి ఒక్కరు అన్ని ప్రశ్నలకు సమాధానాలను గుర్తుంచుకోవడం దాదాపు అసాధ్యం, ఈ రోజు మేము వారి సమాధానాలతో ఆ ప్రత్యేక ప్రశ్నలను మీకు చెప్తున్నాము, వీటిని ఎక్కువగా పోటీ పరీక్షల నుండి ఉద్యోగ ఇంటర్వ్యూలలో ఉపయోగిస్తారు."
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'te',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర లేదా భూగోళశాస్త్రం"
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'te',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_BUTTON_TEXT,
                            'column_value' => "భారతదేశ చరిత్ర లేదా భూగోళశాస్త్రం"
                        ]
                    )
                )
                ->count(8)
                ->create();
        }
        Schema::enableForeignKeyConstraints();
    }
}
