<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        DB::table('faqs')->truncate();

        DB::table('faqs')->insert(array(
            array('id' => '1', 'show_in' => '5', 'institute_id' => NULL, 'industry_association_id' => '1', 'organization_id' => NULL, 'question' => 'MCCI কি?', 'question_en' => NULL, 'answer' => 'মেট্রোপলিটন চেম্বার অফ কমার্স অ্যান্ড ইন্ডাস্ট্রি, ঢাকা (এমসিসিআই) বাংলাদেশের প্রাচীনতম এবং প্রসিদ্ধ বাণিজ্য সংস্থা। এটি 1904 সালে প্রতিষ্ঠিত হয়েছিল। বিশ্বব্যাপী তথ্য অনুসারে, মাত্র 0.5% সংস্থা 100 বছরেরও বেশি সময় ধরে বেঁচে থাকে। MCCI বাংলাদেশের একটি বিরল ব্যবসায়িক প্রতিষ্ঠান যা গত 117 বছর ধরে (2021 সাল পর্যন্ত) সক্রিয়ভাবে কাজ করছে। এর প্রাথমিক দায়িত্ব হলো দেশে ব্যবসা-বাণিজ্য ও শিল্পের প্রসার ঘটানো। MCCI ব্যবসার দায়িত্বশীল এবং নৈতিক কণ্ঠস্বরকে উৎসাহিত করে। বাংলাদেশের বৃহৎ প্রতিষ্ঠান ও সমষ্টির অধিকাংশই এর সদস্য। এটি একটি অলাভজনক সত্তা হিসাবে কোম্পানি আইনের অধীনে নিবন্ধিত।', 'answer_en' => NULL, 'row_status' => '0', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-10 18:02:42', 'updated_at' => '2022-02-14 21:20:36', 'deleted_at' => NULL),
            array('id' => '2', 'show_in' => '3', 'institute_id' => '1', 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'প্রশিক্ষণের উদ্দেশ্য?', 'question_en' => NULL, 'answer' => 'বেকার যুবক ও যুবনারীদের আধুনিক প্রযুক্তিতে হাতে কলমে প্রশিক্ষণের মাধ্যমে কর্মমূখী সক্ষমতা বৃদ্ধি করা।
যুবদের স্ব-কর্মসংস্থান সৃজনে উপযোগী করে গড়ে তোলা।
বিশ্বায়নের সাতে সংগঠিত রেখে যুবদের দেশ-বিদেশের শ্রমবাজারের উপযোগী দক্ষ মানবসম্পদে পরিনত করা।', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-10 21:42:07', 'updated_at' => '2022-02-10 21:42:07', 'deleted_at' => NULL),
            array('id' => '3', 'show_in' => '3', 'institute_id' => '1', 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'প্রশিক্ষণ গ্রহণের সুবিধাদি?', 'question_en' => NULL, 'answer' => 'মাননীয় প্রধানমন্ত্রী শেখ হাসিনার নির্দেশনায় পাহাড়ী, নৃ-গোষ্টি, হিজড়া, অটিস্টিক যুবক/যুবনারীদের ভর্তি ফি ব্যতিত প্রশিক্ষণের ব্যবস্থা গ্রহণ করা হয়েছে এবং পাহাড়ী যুবক ও যুবনারীদের জন্য প্রশিক্ষণে ১০০/- যাতায়াত ভাতা প্রদান।
অনলাইন প্রশিক্ষণের সুযোগঃ
ভার্মি কম্পোস্ট/কেঁচো সার উৎপাদন, গরু মোটাতাজাকরণ, স্বল্প পুঁজিতে কোয়েল পালন, স্ক্রীণ প্রিন্টিং, পশুর চামড়া ছাড়ানো এবং মাছের মিশ্রচাষ।

( ভিডিও দেখতে ভিজিট করুন  www.dyd.gov.bd  এর  ই-সেবা মেনু)

আবাসিক প্রশিক্ষণ কোর্সসমূহে প্রশিক্ষণ ভাতা প্রদান।
অনাবাসিক প্রশিক্ষণ কোর্সসমূহে (প্রয়োজনে) বিনামূল্যে আবাসন সুবিধা।', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-10 21:42:58', 'updated_at' => '2022-02-10 21:42:58', 'deleted_at' => NULL),
            array('id' => '4', 'show_in' => '5', 'institute_id' => NULL, 'industry_association_id' => '1', 'organization_id' => NULL, 'question' => 'MCCI কি করে? / MCCI দ্বারা কি কি কাজ এবং সেবা প্রদান করা হয়?', 'question_en' => NULL, 'answer' => 'চেম্বারের পরিষেবাগুলি, দীর্ঘ সময় ধরে উন্নত, ব্যাপক এবং বিশেষ ক্ষেত্রগুলিকে কভার করে যেমন কর, আমদানি-রপ্তানি, শুল্ক এবং অশুল্ক ব্যবস্থা, বিনিয়োগ, ডব্লিউটিও বিষয়, বিনিয়োগ, জলবায়ু পরিবর্তন, এসডিজি বাস্তবায়ন এবং বেসরকারি খাত, প্রযুক্তি এবং 4IR এবং অন্যান্য জাতীয় এবং আন্তর্জাতিক অর্থনৈতিক এবং বাণিজ্যিক উদ্বেগ।

MCCI সদস্য সংস্থাগুলির পরিবর্তনশীল চাহিদার প্রতি কার্যকরভাবে সাড়া দেয়। স্থানীয় ও আন্তর্জাতিক প্রতিষ্ঠানের সাথে সহযোগিতা এমসিসিআইকে তার নিজস্ব সক্ষমতা বাড়াতে সাহায্য করেছে।

MCCI নিয়মিতভাবে তার স্টেকহোল্ডারদের সাথে যোগাযোগ করে এবং ব্যবসা এবং সমাজকে উপকৃত করে এমন সেরা অনুশীলনগুলিকে স্বীকৃতি দেয়।', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-10 22:30:10', 'updated_at' => '2022-02-14 18:23:39', 'deleted_at' => NULL),
            array('id' => '5', 'show_in' => '5', 'institute_id' => NULL, 'industry_association_id' => '1', 'organization_id' => NULL, 'question' => 'MCCI দ্বারা প্রদত্ত পরিষেবাগুলি অন্যান্য চেম্বারগুলির থেকে কীভাবে আলাদা?', 'question_en' => NULL, 'answer' => 'মেট্রোপলিটন চেম্বার অফ কমার্স অ্যান্ড ইন্ডাস্ট্রি, ঢাকা (এমসিসিআই) প্রধানত দুটি কারণে একটি মর্যাদাপূর্ণ সংস্থা। প্রথমত, এর কার্যক্রমের প্রকৃতি এবং সদস্য সংস্থাগুলির জন্য নিবেদিত পরিষেবাগুলির কারণে। দ্বিতীয়ত, সরকারের নীতি প্রণয়ন প্রক্রিয়ায় গবেষণা ভিত্তিক অবদানের কারণে। সমস্ত ব্যবহারিক উদ্দেশ্যে, MCCI প্রাথমিকভাবে দেশের বৃহৎ উদ্যোগের সাথে লেনদেন করে। জাতীয় রাজস্ব বোর্ডের (এনবিআর) বড় করদাতা ইউনিটের 80% এমসিসিআই সদস্য। অনুমান করা হয় যে এনবিআরের কর রাজস্বের প্রায় 40% এমসিসিআই সদস্যদের অবদানের মাধ্যমে উত্পন্ন হয়।

দীর্ঘায়ু বা কার্যকারিতার দিক থেকে তুলনা করা যেতে পারে এই উপমহাদেশে খুব কম বাণিজ্য সংস্থা রয়েছে। MCCI সদস্য সংস্থাগুলির পরিবর্তনশীল চাহিদার প্রতি কার্যকরভাবে সাড়া দেয়। স্থানীয় এবং আন্তর্জাতিক প্রতিষ্ঠানের সাথে সহযোগিতা এমসিসিআইকে তার নিজস্ব সক্ষমতা বাড়াতে সাহায্য করেছে।

MCCI নিয়মিতভাবে স্টেকহোল্ডারদের সাথে যোগাযোগ করে এবং ব্যবসা ও সমাজকে উপকৃত করে এমন সেরা অনুশীলনগুলিকে স্বীকৃতি দেয়।', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-10 22:31:17', 'updated_at' => '2022-02-14 18:24:53', 'deleted_at' => NULL),
            array('id' => '6', 'show_in' => '1', 'institute_id' => NULL, 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'NISE3 কি ?', 'question_en' => NULL, 'answer' => 'National Intelligence for Skills, Employment, Education and Entrepreneurship', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-14 17:52:47', 'updated_at' => '2022-02-14 17:53:27', 'deleted_at' => NULL),
            array('id' => '7', 'show_in' => '1', 'institute_id' => NULL, 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'NISE3 কিভাবে কাজ করে?', 'question_en' => NULL, 'answer' => 'ঠিক এভাবেই কাজ করে', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-14 17:56:03', 'updated_at' => '2022-02-14 17:56:03', 'deleted_at' => NULL),
            array('id' => '8', 'show_in' => '1', 'institute_id' => NULL, 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'NISE3 আমাকে কিভাবে সাহায্য করতে পারে?', 'question_en' => NULL, 'answer' => 'NISE3 আপনাকে এমন ভাবে সাহায্য করতে পারে, যা আপনি কখনো স্বপ্নেও ভাবেননি।', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-14 18:00:07', 'updated_at' => '2022-02-14 18:00:07', 'deleted_at' => NULL),
            array('id' => '9', 'show_in' => '2', 'institute_id' => NULL, 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'NISE3 কি ?', 'question_en' => NULL, 'answer' => 'National Intelligence for Skills, Employment, Education and Entrepreneurship', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-14 20:46:15', 'updated_at' => '2022-02-14 20:46:15', 'deleted_at' => NULL),
            array('id' => '10', 'show_in' => '2', 'institute_id' => NULL, 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'NISE3 কিভাবে কাজ করে?', 'question_en' => NULL, 'answer' => 'ঠিক এভাবেই কাজ করে', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-14 20:46:58', 'updated_at' => '2022-02-14 20:46:58', 'deleted_at' => NULL),
            array('id' => '11', 'show_in' => '2', 'institute_id' => NULL, 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'ইয়ুথ হিসেবে NISE3 আমাকে কিভাবে সাহায্য করতে পারে?', 'question_en' => NULL, 'answer' => 'NISE3 আপনাকে এমন ভাবে সাহায্য করতে পারে, যা আপনি কখনো স্বপ্নেও ভাবেননি।', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-14 20:48:08', 'updated_at' => '2022-02-14 20:48:08', 'deleted_at' => NULL),
            array('id' => '12', 'show_in' => '3', 'institute_id' => '2', 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'what', 'question_en' => NULL, 'answer' => 'nothing special', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-14 22:47:48', 'updated_at' => '2022-02-14 22:48:01', 'deleted_at' => NULL),
            array('id' => '13', 'show_in' => '3', 'institute_id' => '1', 'industry_association_id' => NULL, 'organization_id' => NULL, 'question' => 'test question edited', 'question_en' => NULL, 'answer' => 'test answer  edited', 'answer_en' => NULL, 'row_status' => '1', 'created_by' => NULL, 'updated_by' => NULL, 'created_at' => '2022-02-15 15:55:36', 'updated_at' => '2022-02-15 15:56:15', 'deleted_at' => '2022-02-15 15:56:15')
        ));

        Schema::enableForeignKeyConstraints();
    }
}
