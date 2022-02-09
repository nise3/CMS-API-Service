<?php

namespace App\Services;

use App\Facade\ServiceToServiceCall;
use App\Models\BaseModel;

class NiseDashboardService
{

    public function getStatistics(): array
    {
        if (env('IS_RANDOM_STATISTICS')) {
            return [
                "total_ministry" => 50,
                "total_department" => 100,
                "total_industrial_skills_council" => 100,
                "total_deputy_commissioner_office" => 64,
                "total_youth" => 3000000,
                "total_4_ir_project" => 100,
                "total_rto" => 100,
                "total_industry" => 100,
                "total_job_provider" => [
                    [
                        "industry_associations_title" => "মেট্রোপলিটন চেম্বার অব কমার্স অ্যান্ড ইন্ড্রাস্ট্রি",
                        "industry_associations_title_en" => "Metropolitan Chamber of Commerce & Industry",
                        "total_job_provided" => 100
                    ],
                    [
                        "industry_associations_title" => "জাতীয় ক্ষুদ্র ও কুটির শিল্প সমিতি",
                        "industry_associations_title_en" => "The National Association of Small and Cottage Industries",
                        "total_job_provided" => 90
                    ],
                    [
                        "industry_associations_title" => "ক্ষুদ্র ও মাঝারি শিল্প ফাউন্ডেশন",
                        "industry_associations_title_en" => "Small & Medium Enterprise Foundation",
                        "total_job_provided" => 85
                    ],
                    [
                        "industry_associations_title" => "বাংলাদেশ তৈরী পোশাক প্রস্তুত ও রপ্তানিকারক সমিতি",
                        "industry_associations_title_en" => "The Bangladesh Garment Manufacturers and Exporters Association",
                        "total_job_provided" => 82
                    ]
                ],
                "total_popular_job" => [
                    [
                        "job_title" => "মেডিকেল প্রমোশন অফিসার",
                        "job_title_en" => "Medical Promotion Officer",
                        "total_applied" => 100
                    ],
                    [
                        "job_title_en" => "Assistant Director (Engineer-Civil) - Bangladesh Bank",
                        "job_title" => "অ্যাসিস্ট্যান্ট ডিরেক্টর (ইঞ্জিনিয়ার-সিভিল) - বাংলাদেশ ব্যাংক",
                        "total_applied" => 90
                    ],
                    [
                        "job_title" => "ম্যানেজার - বিয়োমেডিক্যাল ইঞ্জিনিয়ারিং",
                        "job_title_en" => "Manager - Biomedical Engineering",
                        "total_applied" => 85
                    ],
                    [
                        "job_title" => "মেশিন লার্নিং এক্সপার্ট ",
                        "job_title_en" => "Machine Learning Expert",
                        "total_applied" => 82
                    ]
                ],
                "total_skill_development_center" => [
                    [
                        "training_center_title" => "যুব উন্নয়ন অধিদপ্তর - গণপ্রজাতন্ত্রী বাংলাদেশ সরকার",
                        "training_center_title_en" => "Department of Youth Development - Government of the People\'s Republic of Bangladesh",
                        "total_trained" => 80
                    ],
                    [
                        "training_center_title" => "ট্রেন্থেনিং ইনক্লুসিভ ডেভেলপমেন্ট ইন চিটাগাং হিল ট্রাক্টস (এসআইডি - সিএইচটি)",
                        "training_center_title_en" => "Strengthening Inclusive Development in Chittagong Hill Tracts (SID-CHT)",
                        "total_trained" => 70
                    ],
                    [
                        "training_center_title" => "বাংলাদেশ শিল্প কারিগরি সহায়তা কেন্দ্র (বিটাক)",
                        "training_center_title_en" => "Bangladesh Industrial Technical Assistance Center (BITAC)",
                        "total_trained" => 70
                    ],
                    [
                        "training_center_title" => "সমাজসেবা অধিদফতর ট্রেনিং সেন্টার",
                        "training_center_title_en" => "DSS Training Center",
                        "total_trained" => 65
                    ]
                ],
                "total_popular_courses" => [
                    [
                        "course_title" => "ডিপ্লোমা কোর্স ইন সিস & ইট",
                        "course_title_en" => "Diploma Course in CS & IT",
                        "total_enrollments" => 1600
                    ],
                    [
                        "course_title" => "ডিপ্লোমা ইন ফিজিওথেরাপি",
                        "course_title_en" => "Diploma in Physiotherapy",
                        "total_enrollments" => 1000
                    ],
                    [
                        "course_title" => "ডিপ্লোমা ইন ইন্টেরিয়র ডিজাইন",
                        "course_title_en" => "Diplomas in Interior Design",
                        "total_enrollments" => 900
                    ],
                    [
                        "course_title" => "ডিপ্লোমা ইন নার্সিং",
                        "course_title_en" => "Diplomas in Nursing",
                        "total_enrollments" => 900
                    ]
                ]
            ];
        } else {
            $totalYouth = $this->getStatisticsFromYouth();
            [$totalSkillDevelopmentCenter, $totalPopularCourses] = $this->getStatisticsFromSSP();
            [$totalIndustry, $totalJobProvider, $totalIndustrialSkillsCouncil, $totalPopularJob] = $this->getStatisticsFromIndustryAssociation();
            return [
                "total_ministry" => 0,
                "total_department" => 0,
                "total_industrial_skills_council" => $totalIndustrialSkillsCouncil,
                "total_deputy_commissioner_office" => 64,
                "total_youth" => $totalYouth,
                "total_4_ir_project" => 0,
                "total_rto" => 0,
                "total_industry" => $totalIndustry,
                "total_job_provider" => $totalJobProvider,
                "total_popular_job" => $totalPopularJob,
                "total_skill_development_center" => $totalSkillDevelopmentCenter,
                "total_popular_courses" => $totalPopularCourses
            ];
        }

    }

    /**
     * @return array|mixed
     */
    private function getStatisticsFromYouth(): mixed
    {
        $url = clientUrl(BaseModel::YOUTH_CLIENT_URL_TYPE) . 'nise-statistics';
        return ServiceToServiceCall::getNiseDashBoardData($url);
    }

    /**
     * @return array
     */
    private function getStatisticsFromIndustryAssociation(): array
    {
        $url = clientUrl(BaseModel::ORGANIZATION_CLIENT_URL_TYPE) . 'public/nise-statistics';
        $industryAssociationStatistics = ServiceToServiceCall::getNiseDashBoardData($url);
        /**
         * Industry
         * Job provider
         * Popular job
         */
        $totalIndustry = $industryAssociationStatistics['total_industry'] ?? 0;
        $totalJobProvider = $industryAssociationStatistics['total_job_provider'] ?? [];
        $totalIndustrialSkillsCouncil = $industryAssociationStatistics['total_industry_association'] ?? 0;
        $totalPopularJob = $industryAssociationStatistics['total_popular_job'] ?? [];
        return [
            $totalIndustry,
            $totalJobProvider,
            $totalIndustrialSkillsCouncil,
            $totalPopularJob
        ];
    }

    /**
     * @return array
     */
    private function getStatisticsFromSSP(): array
    {
        $url = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . 'public/nise-statistics';

        $sspStatistics = ServiceToServiceCall::getNiseDashBoardData($url);
        /**
         *Skill Development Center (training center)
         *Popular Courses
         */
        $totalSkillDevelopmentCenter = $sspStatistics['total_skill_development_center'] ?? 0;
        $totalPopularCourses = $sspStatistics['total_popular_courses'] ?? 0;
        return [
            $totalSkillDevelopmentCenter,
            $totalPopularCourses
        ];
    }
}
