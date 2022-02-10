<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaticPageBlocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('static_page_blocks')->truncate();
        DB::table('static_page_blocks')->insert([
            array('static_page_type_id' => '3', 'show_in' => '1', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'নাইস কিভাবে কাজ করে?', 'title_en' => NULL, 'content' => '<p>নাইস একটি সম যার মাধ্যমে সরকার, শিল্প, প্রশিক্ষণ পরিষেবা এবং যুবসমাজের মধ্যে একটি ভারসাম্যপূর্ন সম্পর্ক স্থাপিত হয়।</p>', 'content_en' => NULL, 'attachment_type' => '3', 'template_code' => 'PBT_LR', 'is_button_available' => '1', 'button_text' => 'বিস্তারিত পড়ুন', 'link' => NULL, 'is_attachment_available' => '1', 'image_path' => NULL, 'video_url' => 'https://www.youtube.com/watch?v=ZleQ9PmIVfU', 'video_id' => 'ZleQ9PmIVfU', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-01-11 00:39:17', 'updated_at' => '2022-02-09 20:26:57', 'deleted_at' => NULL),
            array('static_page_type_id' => '11', 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '1', 'title' => 'Page block', 'title_en' => NULL, 'content' => '<div class="editor-template-table">
<table border="0" width="100%">
<tbody>
<tr>
<td colspan="6"><img src="https://bitac.nise.gov.bd/storage/course/cdd4e51d8e0ce35ce1aa568e695f24fe.jpg" alt="" width="100%" height="300" /></td>
<td colspan="6">
<p>আমাদের সম্পর্কে</p>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি<br />বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব&nbsp;<br />দেওয়া ও প্রদান করা।</p>
<p>&nbsp;</p>
<div><a class="link-button MuiButton-root MuiButton-contained MuiButton-containedPrimary MuiButton-sizeMedium MuiButton-containedSizeMedium MuiButtonBase-root" style="border-radius: 5px; border: 1px solid #bfbfbf; padding: 5px 10px 8px; text-decoration: none; color: #1c1c1c;" title="আরো দেখুন" href="http://mcci.nise.asm/about-us" target="_blank" rel="noopener">আরো দেখুন</a></div>
</td>
</tr>
<tr>
<td colspan="6">
<p>আমাদের উদ্দেশ্য ও লক্ষ্য</p>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি<br />বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব&nbsp;<br />দেওয়া ও প্রদান করা।</p>
<p>&nbsp;</p>
<div><a class="link-button MuiButton-root MuiButton-contained MuiButton-containedPrimary MuiButton-sizeMedium MuiButton-containedSizeMedium MuiButtonBase-root" style="border-radius: 5px; border: 1px solid #bfbfbf; padding: 5px 10px 8px; text-decoration: none; color: #1c1c1c;" title="আরো দেখুন" href="http://mcci.nise.asm/about-us" target="_blank" rel="noopener">আরো দেখুন</a></div>
</td>
<td colspan="6">
<p><img src="https://bitac.nise.gov.bd/storage/course/cdd4e51d8e0ce35ce1aa568e695f24fe.jpg" alt="" width="100%" height="300" /></p>
</td>
</tr>
</tbody>
</table>
</div>', 'content_en' => NULL, 'attachment_type' => NULL, 'template_code' => 'PBT_SHOW_EDITOR_CONTENT', 'is_button_available' => '0', 'button_text' => NULL, 'link' => NULL, 'is_attachment_available' => '0', 'image_path' => NULL, 'video_url' => NULL, 'video_id' => NULL, 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-07 19:24:01', 'updated_at' => '2022-02-09 00:07:57', 'deleted_at' => NULL),
            array( 'static_page_type_id' => '11', 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '2', 'title' => 'test', 'title_en' => NULL, 'content' => '<div class="editor-template-table">
<table border="0" width="100%">
<tbody>
<tr>
<td colspan="6"><img src="https://bitac.nise.gov.bd/storage/course/cdd4e51d8e0ce35ce1aa568e695f24fe.jpg" alt="" width="100%" height="300" /></td>
<td colspan="6">
<h3><strong>আমাদের সম্পর্কে</strong></h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি<br />বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব&nbsp;<br />দেওয়া ও প্রদান করা।</p>
<p>&nbsp;</p>
<div><a class="link-button MuiButton-root MuiButton-contained MuiButton-containedPrimary MuiButton-sizeMedium MuiButton-containedSizeMedium MuiButtonBase-root" style="border-radius: 5px; border: 1px solid #bfbfbf; padding: 5px 10px 8px; text-decoration: none; color: #1c1c1c;" title="আরো দেখুন" href="http://mcci.nise.asm/about-us" target="_blank" rel="noopener">আরো দেখুন</a></div>
</td>
</tr>
<tr>
<td colspan="6">
<h3><strong>আমাদের উদ্দেশ্য ও লক্ষ্য</strong></h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি<br />বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব&nbsp;<br />দেওয়া ও প্রদান করা।</p>
<p>&nbsp;</p>
<div><a class="link-button MuiButton-root MuiButton-contained MuiButton-containedPrimary MuiButton-sizeMedium MuiButton-containedSizeMedium MuiButtonBase-root" style="border-radius: 5px; border: 1px solid #bfbfbf; padding: 5px 10px 8px; text-decoration: none; color: #1c1c1c;" title="আরো দেখুন" href="http://mcci.nise.asm/about-us">আরো দেখুন</a></div>
</td>
<td colspan="6"><iframe src="https://www.youtube.com/embed/ZleQ9PmIVfU" width="100%" height="300" allowfullscreen="allowfullscreen"></iframe></td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
</div>', 'content_en' => NULL, 'attachment_type' => NULL, 'template_code' => 'PBT_SHOW_EDITOR_CONTENT', 'is_button_available' => '0', 'button_text' => NULL, 'link' => NULL, 'is_attachment_available' => '0', 'image_path' => NULL, 'video_url' => NULL, 'video_id' => NULL, 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-07 20:28:58', 'updated_at' => '2022-02-07 23:08:37', 'deleted_at' => NULL),
            array('static_page_type_id' => '7', 'show_in' => '3', 'institute_id' => '1', 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'আমাদের সম্পর্কে', 'title_en' => NULL, 'content' => '<p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের রূপকল্প ২০২১ বাস্তবায়নে যুবকদের আত্নকর্মসংস্থান ও স্বাবলম্বী করে তোলার লক্ষ্যে "অনলাইনে বিভিন্ন প্রশিক্ষণ কোর্সের পরিচালনা ও পর্যবেক্ষণ করা"। এই ওয়েব অ্যাপ্লিকেশনটি মূলত "অনলাইন কোর্স ম্যানেজমেন্ট সিস্টেম"। এই প্ল্যাটফর্মে শিক্ষার্থী অতি সহজে বিভিন্ন প্রশিক্ষণ কোর্সে প্রশিক্ষণ নিয়ে স্বাবলম্বী হতে পাড়বে। শিক্ষার্থী তার নিজ পছন্দের বিষয়ে প্রশিক্ষণের জন্য এডমিনে কাছে অনুরোধ/আবেদন করতে পাড়বে। প্রশিক্ষণ শেষে শিক্ষার্থীকে সার্টিফিকেট প্রদান করা হবে।</p>', 'content_en' => NULL, 'attachment_type' => '3', 'template_code' => 'PBT_LR', 'is_button_available' => '0', 'button_text' => NULL, 'link' => NULL, 'is_attachment_available' => '1', 'image_path' => NULL, 'video_url' => 'https://www.youtube.com/watch?v=k28XOpo_IZM', 'video_id' => 'k28XOpo_IZM', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-07 21:25:17', 'updated_at' => '2022-02-07 21:25:17', 'deleted_at' => NULL),
            array('static_page_type_id' => '6', 'show_in' => '1', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'নিজেকে যাচাই করুন', 'title_en' => NULL, 'content' => '<p>আপনার ক্যারিয়ারের আগ্রহ, দক্ষতা, কাজের মান এবং শেখার স্টাইল সম্পর্কে আরো আবিষ্কার করুন এই সরঞ্জামগুলি আত্মসচেতনতা সুবিধার্থে এবং অনুসন্ধানের সুবিধার্থে</p>', 'content_en' => NULL, 'attachment_type' => '1', 'template_code' => 'PBT_LR', 'is_button_available' => '1', 'button_text' => 'বিস্তারিত', 'link' => NULL, 'is_attachment_available' => '1', 'image_path' => 'https://file-phase1.nise.gov.bd/uploads/9tiMgK2gM4EUbgMXAccLsdkCNfh3gP1644326864.jpeg', 'video_url' => NULL, 'video_id' => NULL, 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-07 23:22:39', 'updated_at' => '2022-02-09 01:27:49', 'deleted_at' => NULL),
            array('static_page_type_id' => '7', 'show_in' => '3', 'institute_id' => '2', 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'আমাদের সম্পর্কে', 'title_en' => NULL, 'content' => '<p>The &ldquo;Strengthening Inclusive Development in Chittagong Hill Tracts&rdquo; project, approved in 2016, will continue to support the GoB in the implementation of the Peace Accord, the 8th FYP and Sustainable Development Goals (SDGs), in bringing peace, stability and socio-economic development in the CHT region. The project&rsquo;s Theory of Change responds to the main development challenges through analysis of the root causes and addressing the barriers to progress. During the project&rsquo;s implementation the importance of issues such as women and girls&rsquo; empowerment and creating alternative livelihood opportunities for the youth has been recognised.</p>', 'content_en' => NULL, 'attachment_type' => '3', 'template_code' => 'PBT_LR', 'is_button_available' => '1', 'button_text' => 'আরও দেখুন', 'link' => NULL, 'is_attachment_available' => '1', 'image_path' => NULL, 'video_url' => 'https://www.youtube.com/watch?v=Gbzbg2U48Nk', 'video_id' => 'Gbzbg2U48Nk', 'image_alt_title_en' => NULL, 'image_alt_title' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-08 00:47:59', 'updated_at' => '2022-02-08 00:47:59', 'deleted_at' => NULL)
        ]);
        Schema::disableForeignKeyConstraints();
    }
}
