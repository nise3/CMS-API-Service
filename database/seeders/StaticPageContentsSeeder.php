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
            array('static_page_type_id' => '1', 'show_in' => '3', 'institute_id' => '2', 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'আমাদের সম্পর্কে', 'title_en' => NULL, 'sub_title' => NULL, 'sub_title_en' => NULL, 'content' => '<p>The &ldquo;Strengthening Inclusive Development in Chittagong Hill Tracts&rdquo; project, approved in 2016, will continue to support the GoB in the implementation of the Peace Accord, the 8th FYP and Sustainable Development Goals (SDGs), in bringing peace, stability and socio-economic development in the CHT region. The project&rsquo;s Theory of Change responds to the main development challenges through analysis of the root causes and addressing the barriers to progress. During the project&rsquo;s implementation the importance of issues such as women and girls&rsquo; empowerment and creating alternative livelihood opportunities for the youth has been recognised.<br />One of the project&rsquo;s strategies will be to create alternative livelihood opportunities for the youth through the development of skills and promotion of entrepreneurships. The project strategy is to offer access to quality and market-oriented skill training for adolescents, as well as support entrepreneurship development in CHT. More specifically, it seeks to provide start-ups with access to finance and mentoring through the establishment of a pilot sustainable self-financed business incubator. Additionally, the project will focus on developing specialised technical- and project management skills, which will allow the youth to design and implement technical livelihood improvements and solutions that respond to climate change and can be implemented in communities affected by the harmful impact of climate change. Indeed, the youth in CHT are well-suited for this task, because they are not only eager to address the problem of climate change but also improve the livelihood situation of their own communities, which are stricken by poverty and have few educational- or income-generating opportunities. The COVID-19 crisis, which hit the region in 2020, has also illustrated how vulnerable indigenous communities are, when they, for instance, do not have access to cold storage facilities, at a time when the markets are closed. There is, hence, an urgent need to provide assistance to those rural communities, which have been most affected by climate change and the project will equip the local youth with skills and resources to do so.&nbsp;<br />Target group: 1,200 girls will receive equitable access to safe, quality, and inclusive education with better retention. 1,000 local actors (teachers, parents, local communities, CSOs etc) will increase their knowledge of inclusive educational environments. More specifically, the teaching capacities of 1,800 teachers in 300 schools will be enhanced to provide quality as well as gender-sensitive education for girls. Gender-responsive infrastructures and facilities in 600 schools will likewise be safeguarded for safe and inclusive learning spaces.&nbsp;</p>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-01-11 00:28:04', 'updated_at' => '2022-02-08 00:45:06', 'deleted_at' => NULL),
            array('static_page_type_id' => '1', 'show_in' => '1', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'Test nise', 'title_en' => NULL, 'sub_title' => 'Test nise', 'sub_title_en' => NULL, 'content' => '<p>test nise f fs f</p>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-01-11 00:36:00', 'updated_at' => '2022-02-08 00:16:00', 'deleted_at' => NULL),
            array('static_page_type_id' => '1', 'show_in' => '2', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'test youth', 'title_en' => NULL, 'sub_title' => 'test youth', 'sub_title_en' => NULL, 'content' => '<p>fds dfs df</p>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-01-11 00:37:21', 'updated_at' => '2022-01-11 00:37:21', 'deleted_at' => NULL),
            array('static_page_type_id' => '1', 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '2', 'title' => 'About us', 'title_en' => NULL, 'sub_title' => NULL, 'sub_title_en' => NULL, 'content' => '<div class="editor-template-table">
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
</div>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-01-30 22:22:47', 'updated_at' => '2022-02-07 00:43:12', 'deleted_at' => NULL),
            array('static_page_type_id' => '2', 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '2', 'title' => 'ddd', 'title_en' => NULL, 'sub_title' => NULL, 'sub_title_en' => NULL, 'content' => '<div class="editor-template-table">
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
</div>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-03 21:49:15', 'updated_at' => '2022-02-03 21:49:15', 'deleted_at' => NULL),
            array('static_page_type_id' => '1', 'show_in' => '5', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => '1', 'title' => 'Test', 'title_en' => NULL, 'sub_title' => 'test', 'sub_title_en' => NULL, 'content' => '<div class="editor-template-table">
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
</div>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-07 20:26:51', 'updated_at' => '2022-02-07 20:26:51', 'deleted_at' => NULL),
            array('static_page_type_id' => '1', 'show_in' => '3', 'institute_id' => '1', 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'আমাদের সম্পর্কে', 'title_en' => NULL, 'sub_title' => 'আমাদের সম্পর্কে 3', 'sub_title_en' => NULL, 'content' => '<p>যুব উন্নয়ন অধিদপ্তর যুব জনসংখ্যার বিকাশের জন্য দায়ী বাংলাদেশের সরকারী বিভাগ। এটা বাংলাদেশের ঢাকার মতিঝিলে অবস্থিত। বর্তমান মহাপরিচালক আখতারুজ জামান খান কবির।</p>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-07 21:24:08', 'updated_at' => '2022-02-07 21:24:08', 'deleted_at' => NULL),
            array('static_page_type_id' => '2', 'show_in' => '3', 'institute_id' => '1', 'organization_id' => NULL, 'industry_association_id' => NULL, 'title' => 'test', 'title_en' => NULL, 'sub_title' => 'test', 'sub_title_en' => NULL, 'content' => '<p>test &nbsp; test &nbsp; test &nbsp; test &nbsp; test &nbsp;&nbsp;</p>', 'content_en' => NULL, 'created_by' => NULL, 'updated_by' => NULL, 'row_status' => '1', 'created_at' => '2022-02-07 21:24:34', 'updated_at' => '2022-02-07 21:24:34', 'deleted_at' => NULL)

        ]);
        Schema::disableForeignKeyConstraints();
    }
}
