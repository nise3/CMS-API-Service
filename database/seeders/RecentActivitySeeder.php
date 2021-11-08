<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\RecentActivity;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RecentActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecentActivity::factory()->count(10)->create();

        Schema::disableForeignKeyConstraints();
        RecentActivity::query()->truncate();
        for ($i = 0; $i < 10; $i++) {
            /** @var RecentActivity $recentActivity */
            $recentActivity = RecentActivity::factory()->create();
            CmsLanguage::factory()
                ->state(
                    new Sequence(
                        [
                            'table_name' => $recentActivity->getTable(),
                            "key_id" => $recentActivity->id,
                            'lang_code' => 'hi',
                            'column_name' => RecentActivity::LANGUAGE_ATTR_TITLE,
                            'column_value' => "अगर आप किसी एग्जाम की तैयारी "
                        ],
                        [
                            'table_name' => $recentActivity->getTable(),
                            "key_id" => $recentActivity->id,
                            'lang_code' => 'hi',
                            'column_name' => RecentActivity::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                            'column_value' => "भारत का इतिहासं"
                        ],
                        [
                            'table_name' => $recentActivity->getTable(),
                            "key_id" => $recentActivity->id,
                            'lang_code' => 'hi',
                            'column_name' => RecentActivity::LANGUAGE_ATTR_DESCRIPTION,
                            'column_value' => "भारत का इतिहासं"
                        ],
                        [
                            'table_name' => $recentActivity->getTable(),
                            "key_id" => $recentActivity->id,
                            'lang_code' => 'te',
                            'column_name' => RecentActivity::LANGUAGE_ATTR_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $recentActivity->getTable(),
                            "key_id" => $recentActivity->id,
                            'lang_code' => 'te',
                            'column_name' => RecentActivity::LANGUAGE_ATTR_IMAGE_ALT_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $recentActivity->getTable(),
                            "key_id" => $recentActivity->id,
                            'lang_code' => 'te',
                            'column_name' => RecentActivity::LANGUAGE_ATTR_DESCRIPTION,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ]
                    )
                )
                ->count(6)
                ->create();
        }
        Schema::enableForeignKeyConstraints();
    }
}
