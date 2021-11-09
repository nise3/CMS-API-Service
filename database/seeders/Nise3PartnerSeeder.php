<?php

namespace Database\Seeders;

use App\Models\CmsLanguage;
use App\Models\Nise3Partner;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class Nise3PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Nise3Partner::query()->truncate();
        for ($i = 0; $i < 10; $i++) {
            /** @var Nise3Partner $nise3Partner */
            $nise3Partner = Nise3Partner::factory()->create();
            CmsLanguage::factory()
                ->state(
                    new Sequence(
                        [
                            'table_name' => $nise3Partner->getTable(),
                            "key_id" => $nise3Partner->id,
                            'lang_code' => 'hi',
                            'column_name' => Nise3Partner::NISE_3_PARTNER_TITLE,
                            'column_value' => "अगर आप किसी एग्जाम की तैयारी "
                        ],
                        [
                            'table_name' => $nise3Partner->getTable(),
                            "key_id" => $nise3Partner->id,
                            'lang_code' => 'hi',
                            'column_name' => Nise3Partner::NISE_3_PARTNER_ATL_IMAGE,
                            'column_value' => "भारत का इतिहासं"
                        ],

                        [
                            'table_name' => $nise3Partner->getTable(),
                            "key_id" => $nise3Partner->id,
                            'lang_code' => 'te',
                            'column_name' => Nise3Partner::NISE_3_PARTNER_TITLE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ],
                        [
                            'table_name' => $nise3Partner->getTable(),
                            "key_id" => $nise3Partner->id,
                            'lang_code' => 'te',
                            'column_name' => Nise3Partner::NISE_3_PARTNER_ATL_IMAGE,
                            'column_value' => "భారతదేశ చరిత్ర"
                        ]
                    )
                )
                ->count(5)
                ->create();
        }
        Schema::enableForeignKeyConstraints();
    }
}
