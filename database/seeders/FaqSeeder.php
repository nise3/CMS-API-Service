<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Schema::disableForeignKeyConstraints();

        /** @var Faq $faqModelInstance */
        $faqModelInstance = app(Faq::class);

        Faq::query()->truncate();

        Faq::factory()->has(
            CmsLanguage::factory()
                ->state(
                    new Sequence(
                        [
                            'table_name' => $faqModelInstance->getTable(),
                            'lang_code' => 'hi',
                            'column_name' => Faq::LANGUAGE_ATTR_QUESTION,
                            'column_value' => "अगर आप किसी एग्जाम की तैयारी कर रहे हैं, तो जेनरल नॉलेज अच्छी करना बेहद जरूरी। तो चलिए जानते हैं कौन-से सवाल"
                        ],
                        [
                            'table_name' => $faqModelInstance->getTable(),
                            'lang_code' => 'hi',
                            'column_name' => Faq::LANGUAGE_ATTR_ANSWER,
                            'column_value' => "भारत का इतिहास या फिर भूगोल, यह इतना बड़ा है कि इसको याद करने में बड़ों-बड़ों की रातों की नींद हराम हो जाती है। सभी प्रश्‍नों के उत्‍तर याद करना सभी के लिए लगभग असंभव है, आज हम आपको बता रहे हैं उन खास प्रश्‍नों को उनके उत्‍तर के साथ जो प्रतियोगी परिक्षाओं से लेकर जॉब इंटरव्‍यू में ज्‍यादातर पूछे जाते हैं। अगर आपको इन प्रश्‍नों के उत्‍तर पता हैं तो आपकी मुश्‍किलें हल हो जाएंगी"
                        ],
                        [
                            'table_name' => $faqModelInstance->getTable(),
                            'lang_code' => 'te',
                            'column_name' => Faq::LANGUAGE_ATTR_QUESTION,
                            'column_value' => "మీరు ఏదైనా పరీక్షకు సిద్ధమవుతున్నట్లయితే"
                        ],
                        [
                            'table_name' => $faqModelInstance->getTable(),
                            'lang_code' => 'te',
                            'column_name' => Faq::LANGUAGE_ATTR_ANSWER,
                            'column_value' => "మీరు ఏదైనా పరీక్షకు సిద్ధమవుతున్నట్లయితే, మంచి సాధారణ జ్ఞానం కలిగి ఉండటం చాలా ముఖ్యం. కాబట్టి ఏయే ప్రశ్నలు తెలుసుకుందాం"
                        ]
                    )
                )
                ->count(4)
        )
            ->count(20)
            ->create();

        Schema::enableForeignKeyConstraints();
    }
}
