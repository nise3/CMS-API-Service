<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\Banner;
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
        for ($i = 0; $i < 10; $i++) {
            /** @var Banner $banner */
            $banner = Banner::factory()->create();
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
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_ALT_IMAGE_TITLE,
                            'column_value' => "भारत का इतिहास या फिर भूगोल"
                        ],
                        [
                            'table_name' => $banner->getTable(),
                            "key_id" => $banner->id,
                            'lang_code' => 'hi',
                            'column_name' => Banner::BANNER_LANGUAGE_ATTR_BUTTON_TEXT,
                            'column_value' => "भारत का इतिहास या फिर भूगोल"
                        ]
                    )
                )
                ->count(4)
                ->create();
        }
        Schema::enableForeignKeyConstraints();
    }
}
