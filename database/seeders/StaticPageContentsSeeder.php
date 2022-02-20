<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaticPageContentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('static_page_contents')->truncate();
        DB::table('static_page_contents')->insert([
            array('id' => '1','static_page_type_id' => '1','show_in' => '3','institute_id' => '2','organization_id' => NULL,'industry_association_id' => NULL,'title' => 'আমাদের সম্পর্কে','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<p>The &ldquo;Strengthening Inclusive Development in Chittagong Hill Tracts&rdquo; project, approved in 2016, will continue to support the GoB in the implementation of the Peace Accord, the 8th FYP and Sustainable Development Goals (SDGs), in bringing peace, stability and socio-economic development in the CHT region. The project&rsquo;s Theory of Change responds to the main development challenges through analysis of the root causes and addressing the barriers to progress. During the project&rsquo;s implementation the importance of issues such as women and girls&rsquo; empowerment and creating alternative livelihood opportunities for the youth has been recognised.<br />One of the project&rsquo;s strategies will be to create alternative livelihood opportunities for the youth through the development of skills and promotion of entrepreneurships. The project strategy is to offer access to quality and market-oriented skill training for adolescents, as well as support entrepreneurship development in CHT. More specifically, it seeks to provide start-ups with access to finance and mentoring through the establishment of a pilot sustainable self-financed business incubator. Additionally, the project will focus on developing specialised technical- and project management skills, which will allow the youth to design and implement technical livelihood improvements and solutions that respond to climate change and can be implemented in communities affected by the harmful impact of climate change. Indeed, the youth in CHT are well-suited for this task, because they are not only eager to address the problem of climate change but also improve the livelihood situation of their own communities, which are stricken by poverty and have few educational- or income-generating opportunities. The COVID-19 crisis, which hit the region in 2020, has also illustrated how vulnerable indigenous communities are, when they, for instance, do not have access to cold storage facilities, at a time when the markets are closed. There is, hence, an urgent need to provide assistance to those rural communities, which have been most affected by climate change and the project will equip the local youth with skills and resources to do so.&nbsp;<br />Target group: 1,200 girls will receive equitable access to safe, quality, and inclusive education with better retention. 1,000 local actors (teachers, parents, local communities, CSOs etc) will increase their knowledge of inclusive educational environments. More specifically, the teaching capacities of 1,800 teachers in 300 schools will be enhanced to provide quality as well as gender-sensitive education for girls. Gender-responsive infrastructures and facilities in 600 schools will likewise be safeguarded for safe and inclusive learning spaces.&nbsp;</p>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-01-11 06:28:04','updated_at' => '2022-02-08 06:45:06','deleted_at' => NULL),
            array('id' => '2','static_page_type_id' => '1','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'আমাদের সম্পর্কে','title_en' => NULL,'sub_title' => 'আমাদের সম্পর্কে সাবটাইটেল','sub_title_en' => NULL,'content' => '<h5>বেকার যুবক-যুব মহিলাগণকে চাহিদা ভিত্তিক দক্ষতা উন্নয়নমূলক প্রশিক্ষণ সরবরাহের ফলে অধিক দক্ষ শ্রমশক্তি তৈরি হচ্ছে যা শিল্প- প্রতিষ্ঠানগুলোর সার্বিক উৎপাদন বৃদ্ধি করতে ও কাঁচামালের অপচয় রোধে ব্যাপক ভূমিকা রাখছে।</h5>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-01-11 06:36:00','updated_at' => '2022-02-14 17:41:52','deleted_at' => NULL),
            array('id' => '3','static_page_type_id' => '1','show_in' => '2','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'আমাদের সম্পর্কে','title_en' => NULL,'sub_title' => 'আমাদের সম্পর্কে সাবটাইটেল','sub_title_en' => NULL,'content' => '<h5>বেকার যুবক-যুব মহিলাগণকে চাহিদা ভিত্তিক দক্ষতা উন্নয়নমূলক প্রশিক্ষণ সরবরাহের ফলে অধিক দক্ষ শ্রমশক্তি তৈরি হচ্ছে যা শিল্প- প্রতিষ্ঠানগুলোর সার্বিক উৎপাদন বৃদ্ধি করতে ও কাঁচামালের অপচয় রোধে ব্যাপক ভূমিকা রাখছে।</h5>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-01-11 06:37:21','updated_at' => '2022-02-14 20:49:51','deleted_at' => NULL),
            array('id' => '4','static_page_type_id' => '1','show_in' => '5','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => '2','title' => 'About us','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<div class="editor-template-table">
<table>
<tbody>
<tr>
<td colspan="6">
<h3><strong>আমাদের সম্পর্কে জানুন</strong></h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব দেওয়া ও প্রদান করা।</p>
</td>
<td colspan="6"><iframe src="https://www.youtube.com/embed/ZleQ9PmIVfU" width="100%" height="300" allowfullscreen="allowfullscreen"></iframe></td>
</tr>
<tr>
<td colspan="6"><img src="https://bitac.nise.gov.bd/storage/course/cdd4e51d8e0ce35ce1aa568e695f24fe.jpg" alt="" width="100%" height="300" /></td>
<td colspan="6">
<h3>আমাদের উদ্দেশ্য&nbsp;</h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব দেওয়া ও প্রদান করা।</p>
</td>
</tr>
<tr>
<td colspan="6">
<h3>আমাদের লক্ষ্য&nbsp;</h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব দেওয়া ও প্রদান করা।</p>
</td>
<td colspan="6"><img src="https://bitac.nise.gov.bd/storage/course/cdd4e51d8e0ce35ce1aa568e695f24fe.jpg" alt="" width="100%" height="300" /></td>
</tr>
</tbody>
</table>
</div>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-01-31 04:22:47','updated_at' => '2022-02-07 06:43:12','deleted_at' => NULL),
            array('id' => '5','static_page_type_id' => '2','show_in' => '5','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => '2','title' => 'ddd','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<div class="editor-template-table">
<div>
<div>sdkfslkdjslkdfjslkdfjslkdfjs</div>
<div><img src="https://file-phase1.nise.gov.bd/uploads/EAtsRTmyIzFMZ5xwaq7iUqhkRVeasp1643877430.png" alt="" width="462" height="253" /></div>
</div>
<div>
<div>Write here</div>
<div><img src="https://file-phase1.nise.gov.bd/uploads/EAtsRTmyIzFMZ5xwaq7iUqhkRVeasp1643877430.png" alt="" width="462" height="253" /></div>
</div>
<div>
<div>Write here</div>
<div>upload here</div>
</div>
</div>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-04 03:49:15','updated_at' => '2022-02-04 03:49:15','deleted_at' => NULL),
            array('id' => '6','static_page_type_id' => '1','show_in' => '5','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => '1','title' => 'আমাদের সম্পর্কে','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<div class="editor-template-table">
<table border="0" width="100%">
<tbody>
<tr>
<td colspan="6">
<h3><strong>আমাদের সম্পর্কে জানুন</strong></h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব দেওয়া ও প্রদান করা।</p>
</td>
<td colspan="6"><iframe src="https://www.youtube.com/embed/ZleQ9PmIVfU" width="100%" height="300" allowfullscreen="allowfullscreen" data-mce-fragment="1"></iframe></td>
</tr>
<tr>
<td colspan="6"><img src="https://bitac.nise.gov.bd/storage/course/cdd4e51d8e0ce35ce1aa568e695f24fe.jpg" alt="" width="100%" height="300" /></td>
<td colspan="6">
<h3>আমাদের উদ্দেশ্য&nbsp;</h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব দেওয়া ও প্রদান করা।</p>
</td>
</tr>
<tr>
<td colspan="6">
<h3>আমাদের লক্ষ্য&nbsp;</h3>
<p>বেসিস সদস্য কোম্পানিগুলোর উচ্চাকাঙ্ক্ষা, সক্ষমতা এবং টেকসই প্রবৃদ্ধি বিকাশ করা এবং ওয়ান বাংলাদেশ-এ বেসিস অবদানকে নেতৃত্ব দেওয়া ও প্রদান করা।</p>
</td>
<td colspan="6"><img src="https://bitac.nise.gov.bd/storage/course/cdd4e51d8e0ce35ce1aa568e695f24fe.jpg" alt="" width="100%" height="300" /></td>
</tr>
</tbody>
</table>
</div>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-08 02:26:51','updated_at' => '2022-02-14 18:38:29','deleted_at' => NULL),
            array('id' => '7','static_page_type_id' => '1','show_in' => '3','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'title' => 'আমাদের সম্পর্কে','title_en' => NULL,'sub_title' => 'আমাদের সম্পর্কে 3','sub_title_en' => NULL,'content' => '<p>যুব উন্নয়ন অধিদপ্তর যুব জনসংখ্যার বিকাশের জন্য দায়ী বাংলাদেশের সরকারী বিভাগ। এটা বাংলাদেশের ঢাকার মতিঝিলে অবস্থিত। বর্তমান মহাপরিচালক আখতারুজ জামান খান কবির।</p>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-08 03:24:08','updated_at' => '2022-02-08 03:24:08','deleted_at' => NULL),
            array('id' => '8','static_page_type_id' => '2','show_in' => '3','institute_id' => '1','organization_id' => NULL,'industry_association_id' => NULL,'title' => 'test','title_en' => NULL,'sub_title' => 'test','sub_title_en' => NULL,'content' => '<p>test &nbsp; test &nbsp; test &nbsp; test &nbsp; test &nbsp;&nbsp;</p>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-08 03:24:34','updated_at' => '2022-02-08 03:24:34','deleted_at' => NULL),
            array('id' => '9','static_page_type_id' => '4','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'নাইস কিভাবে কাজ করে?','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<p>নাইস একটি সম যার মাধ্যমে সরকার, শিল্প, প্রশিক্ষণ পরিষেবা এবং যুবসমাজের মধ্যে একটি ভারসাম্যপূর্ন সম্পর্ক স্থাপিত হয়।</p>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-10 21:40:08','updated_at' => '2022-02-10 21:40:08','deleted_at' => NULL),
            array('id' => '10','static_page_type_id' => '5','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'নিজেকে যাচাই করুন','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<p>আপনার ক্যারিয়ারের আগ্রহ, দক্ষতা, কাজের মান এবং শেখার স্টাইল সম্পর্কে আরো আবিষ্কার করুন এই সরঞ্জামগুলি আত্মসচেতনতা সুবিধার্থে এবং অনুসন্ধানের সুবিধার্থে</p>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-10 23:10:23','updated_at' => '2022-02-10 23:11:37','deleted_at' => NULL),
            array('id' => '11','static_page_type_id' => '2','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'গোপনীয়তা নীতি','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<pre id="tw-target-text" class="tw-data-text tw-text-large tw-ta" dir="ltr" data-placeholder="অনুবাদ"><span class="Y2IQFc" lang="bn">গোপনীয়তা নীতি নিজেই মোটামুটি আদর্শ এবং নিম্নলিখিত প্রধান বিভাগগুলি অন্তর্ভুক্ত করে:

১। আবেদনের সুযোগ
২।সংগৃহীত তথ্য এবং কিভাবে ব্যবহার করা হয়
৩। ওয়েবসাইট বা অ্যাপ্লিকেশন ব্যবহার করে স্বয়ংক্রিয়ভাবে তথ্য সংগ্রহ করা হয়
৪। তৃতীয় পক্ষের কাছ থেকে সংগৃহীত তথ্য (সংযুক্ত সামাজিক মিডিয়া অ্যাকাউন্ট, উদাহরণস্বরূপ)
তথ্য ভাগাভাগি</span></pre>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-14 20:32:37','updated_at' => '2022-02-14 20:32:37','deleted_at' => NULL),
            array('id' => '12','static_page_type_id' => '2','show_in' => '2','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'গোপনীয়তা নীতি','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<pre id="tw-target-text" class="tw-data-text tw-text-large tw-ta" dir="ltr" data-placeholder="অনুবাদ"><span class="Y2IQFc" lang="bn">গোপনীয়তা নীতি নিজেই মোটামুটি আদর্শ এবং নিম্নলিখিত প্রধান বিভাগগুলি অন্তর্ভুক্ত করে:

১। আবেদনের সুযোগ
২।সংগৃহীত তথ্য এবং কিভাবে ব্যবহার করা হয়
৩। ওয়েবসাইট বা অ্যাপ্লিকেশন ব্যবহার করে স্বয়ংক্রিয়ভাবে তথ্য সংগ্রহ করা হয়
৪। তৃতীয় পক্ষের কাছ থেকে সংগৃহীত তথ্য (সংযুক্ত সামাজিক মিডিয়া অ্যাকাউন্ট, উদাহরণস্বরূপ)
তথ্য ভাগাভাগি</span></pre>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-14 20:33:18','updated_at' => '2022-02-14 20:33:18','deleted_at' => NULL),
            array('id' => '13','static_page_type_id' => '8','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'শর্তাবলী','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<pre id="tw-target-text" class="tw-data-text tw-text-large tw-ta" dir="ltr" data-placeholder="অনুবাদ"><span class="Y2IQFc" lang="bn">আপনার ব্যবসার একটি ওয়েবসাইট থাকলে, আপনাকে দর্শকদের জন্য ব্যবহারের শর্তাবলী লিখতে হবে। এগুলি আপনার এবং আপনার ওয়েবসাইটের ব্যবহারকারীদের মধ্যে আইনি অধিকার এবং বাধ্যবাধকতা নির্ধারণ করে। আপনার ওয়েবসাইটের শর্তাবলী কভার করা উচিত:

1. ওয়েবসাইটের বিষয়বস্তুর মালিকানা এবং কপিরাইট;

2. ওয়েবসাইট এবং বিষয়বস্তুর গ্রহণযোগ্য এবং অগ্রহণযোগ্য ব্যবহার</span></pre>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-14 20:37:14','updated_at' => '2022-02-14 20:37:14','deleted_at' => NULL),
            array('id' => '14','static_page_type_id' => '8','show_in' => '2','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'শর্তাবলী','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<pre id="tw-target-text" class="tw-data-text tw-text-large tw-ta" dir="ltr" data-placeholder="অনুবাদ"><span class="Y2IQFc" lang="bn">আপনার ব্যবসার একটি ওয়েবসাইট থাকলে, আপনাকে দর্শকদের জন্য ব্যবহারের শর্তাবলী লিখতে হবে। এগুলি আপনার এবং আপনার ওয়েবসাইটের ব্যবহারকারীদের মধ্যে আইনি অধিকার এবং বাধ্যবাধকতা নির্ধারণ করে। আপনার ওয়েবসাইটের শর্তাবলী কভার করা উচিত:

1. ওয়েবসাইটের বিষয়বস্তুর মালিকানা এবং কপিরাইট;

2. ওয়েবসাইট এবং বিষয়বস্তুর গ্রহণযোগ্য এবং অগ্রহণযোগ্য ব্যবহার</span></pre>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-14 20:38:42','updated_at' => '2022-02-14 20:38:42','deleted_at' => NULL),
            array('id' => '15','static_page_type_id' => '9','show_in' => '2','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'ক্যারিয়ার পরামর্শ','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<pre id="tw-target-text" class="tw-data-text tw-text-large tw-ta" dir="ltr" data-placeholder="অনুবাদ"><span class="Y2IQFc" lang="bn">1. আপনার স্বপ্নের চাকরিতে কাজ করুন
2. আপনার কর্মজীবন অগ্রসর করুন<br />3. আপনার কর্মজীবন শ্রেষ্ঠ করে তুলুন
4. আপনার নিজের ব্যবসা শুরু করুন</span></pre>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-14 20:57:21','updated_at' => '2022-02-14 20:57:21','deleted_at' => NULL),
            array('id' => '16','static_page_type_id' => '9','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'ক্যারিয়ার পরামর্শ','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<pre id="tw-target-text" class="tw-data-text tw-text-large tw-ta" dir="ltr" data-placeholder="অনুবাদ"><span class="Y2IQFc" lang="bn">1. আপনার স্বপ্নের চাকরিতে কাজ করুন
2. আপনার কর্মজীবন অগ্রসর করুন<br />3. আপনার কর্মজীবন শ্রেষ্ঠ করে তুলুন
4. আপনার নিজের ব্যবসা শুরু করুন</span></pre>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-14 20:57:24','updated_at' => '2022-02-14 20:57:24','deleted_at' => NULL),
            array('id' => '17','static_page_type_id' => '10','show_in' => '1','institute_id' => NULL,'organization_id' => NULL,'industry_association_id' => NULL,'title' => 'নির্দেশিকা','title_en' => NULL,'sub_title' => NULL,'sub_title_en' => NULL,'content' => '<pre id="tw-target-text" class="tw-data-text tw-text-large tw-ta" dir="ltr" data-placeholder="অনুবাদ"><span class="Y2IQFc" lang="bn">১. নিয়মিত আমাদের সাইটে চোখ রাখুন

২. নিখুঁতভাবে আপনার প্রোফাইল তৈরি করুন<br /><br />৩. আপনার প্রোফাইলে তথ্য যেমন হবে সেই অনুসারে আপনি কোর্স সাজেশন পাবেন এবং জব অফার পাবেন<br /></span></pre>','content_en' => NULL,'created_by' => NULL,'updated_by' => NULL,'row_status' => '1','created_at' => '2022-02-14 20:59:29','updated_at' => '2022-02-14 21:04:19','deleted_at' => NULL)

        ]);
        Schema::disableForeignKeyConstraints();
    }
}
