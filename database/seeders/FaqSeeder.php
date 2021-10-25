<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\Faq;
use Database\Factories\CmsLanguageFactory;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $tableName=app(Faq::class);
         Faq::factory()->has(CmsLanguage::factory()->state(
             new Sequence(
                 [
                     'table_name'=>$tableName->getTable(),
                     'lang_code' =>'HI',
                     'column_name' => Faq::LANGUAGE_ATTR_QUESTION,
                     'column_value' => "अगर आप किसी एग्जाम की तैयारी कर रहे हैं, तो जेनरल नॉलेज अच्छी करना बेहद जरूरी। तो चलिए जानते हैं कौन-से सवाल"
                 ],
                 [
                     'table_name'=>$tableName->getTable(),
                     'lang_code' =>'HI',
                     'column_name' => Faq::LANGUAGE_ATTR_ANSWER,
                     'column_value' =>"भारत का इतिहास या फिर भूगोल, यह इतना बड़ा है कि इसको याद करने में बड़ों-बड़ों की रातों की नींद हराम हो जाती है। सभी प्रश्‍नों के उत्‍तर याद करना सभी के लिए लगभग असंभव है, आज हम आपको बता रहे हैं उन खास प्रश्‍नों को उनके उत्‍तर के साथ जो प्रतियोगी परिक्षाओं से लेकर जॉब इंटरव्‍यू में ज्‍यादातर पूछे जाते हैं। अगर आपको इन प्रश्‍नों के उत्‍तर पता हैं तो आपकी मुश्‍किलें हल हो जाएंगी"
                 ]
             )
         )->count(2))->count(10)->create();
    }
}
