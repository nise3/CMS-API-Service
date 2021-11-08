<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        StaticPage::query()->truncate();
        for ($i = 0; $i < 10; $i++) {
            /** @var StaticPage $staticPage */
            $staticPage = StaticPage::factory()->create();
            CmsLanguage::factory()
                ->state(
                    new Sequence(
                        [
                            'table_name' => $staticPage->getTable(),
                            "key_id" => $staticPage->id,
                            'lang_code' => 'hi',
                            'column_name' => StaticPage::LANGUAGE_ATTR_TITLE,
                            'column_value' => "अगर आप किसी एग्जाम की तैयारी "
                        ],
                        [
                            'table_name' => $staticPage->getTable(),
                            "key_id" => $staticPage->id,
                            'lang_code' => 'hi',
                            'column_name' => StaticPage::LANGUAGE_ATTR_SUB_TITLE,
                            'column_value' => "भारत का इतिहासं"
                        ],
                        [
                            'table_name' => $staticPage->getTable(),
                            "key_id" => $staticPage->id,
                            'lang_code' => 'hi',
                            'column_name' => StaticPage::LANGUAGE_ATTR_CONTENTS,
                            'column_value' => "आधुनिक अधिकांश विकास पडता उशकी सभिसमज असक्षम केन्द्रिय लेकिन गटकउसि आशाआपस बनाकर उसके करने गटकउसि संस्थान मुश्किले संसाध तरीके हमेहो। सोफ़्टवेर अन्तरराष्ट्रीयकरन अन्य खरिदे दिशामे सभिसमज पढाए नवंबर आवश्यक आवश्यकत जाता प्रसारन मर्यादित विभाजनक्षमता चुनने एछित संसाध एछित हमेहो। सामूहिक समाज वर्णन अनुकूल स्थापित ढांचामात्रुभाषा करने विशेष परस्पर दर्शाता केन्द्रित
"
                        ],
                        [
                            'table_name' => $staticPage->getTable(),
                            "key_id" => $staticPage->id,
                            'lang_code' => 'te',
                            'column_name' => StaticPage::LANGUAGE_ATTR_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $staticPage->getTable(),
                            "key_id" => $staticPage->id,
                            'lang_code' => 'te',
                            'column_name' => StaticPage::LANGUAGE_ATTR_SUB_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $staticPage->getTable(),
                            "key_id" => $staticPage->id,
                            'lang_code' => 'te',
                            'column_name' => StaticPage::LANGUAGE_ATTR_CONTENTS,
                            'column_value' => "ఆధునిక అభివృద్ధిలో ఎక్కువ భాగం కేంద్రంగా అసమర్థతతో సంబంధం కలిగి ఉంటుంది, అయితే ఆ ఆశను మరియు అదే సంస్థలతో దీన్ని చేయడానికి మనకు కష్టమైన మార్గాలు ఉన్నాయి. సాఫ్ట్‌వేర్ యొక్క అంతర్జాతీయీకరణ, ఇతర కొనుగోలు దిశలలో అవగాహనను బోధించడం నవంబర్ అవసరమైన అవసరాలు ప్రసారాన్ని ఎంచుకోవడానికి మాకు సరైన వనరులు ఉన్నాయి, పరిమిత విభజన సామర్థ్యం. సామూహిక సమాజ వివరణ ఏర్పాటు చేయబడిన ఫ్రేమ్‌వర్క్‌కు అనుగుణంగా ఉంటుంది, నిర్దిష్ట పరస్పర భాషను ప్రతిబింబించడంపై దృష్టి పెట్టింది",

                        ]
                    )
                )
                ->count(4)
                ->create();

        }
        Schema::disableForeignKeyConstraints();

    }
}
