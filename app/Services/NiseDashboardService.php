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
                        "industry_associations_title" => "Industry-1",
                        "industry_associations_title_en" => "Industry-1",
                        "total_job_provided" => 100
                    ],
                    [
                        "industry_associations_title" => "Industry-2",
                        "industry_associations_title_en" => "Industry-2",
                        "total_job_provided" => 90
                    ],
                    [
                        "industry_associations_title" => "Industry-3",
                        "industry_associations_title_en" => "Industry-3",
                        "total_job_provided" => 85
                    ],
                    [
                        "industry_associations_title" => "Industry-4",
                        "industry_associations_title_en" => "Industry-4",
                        "total_job_provided" => 82
                    ]
                ],
                "total_popular_job" => [
                    [
                        "job_title" => "Popular Job-1",
                        "job_title_en" => "Popular Job-1",
                        "total_applied" => 100
                    ],
                    [
                        "job_title" => "Popular Job-2",
                        "job_title_en" => "Popular Job-2",
                        "total_applied" => 90
                    ],
                    [
                        "job_title" => "Popular Job-3",
                        "job_title_en" => "Popular Job-3",
                        "total_applied" => 85
                    ],
                    [
                        "job_title" => "Popular Job-4",
                        "job_title_en" => "Popular Job-4",
                        "total_applied" => 82
                    ]
                ],
                "total_skill_development_center" => [
                    [
                        "training_center_title" => "Leonardo Bauch",
                        "training_center_title_en" => "Verona Koss V",
                        "total_trained" => 80
                    ],
                    [
                        "training_center_title" => "Verona Bahringer MD",
                        "training_center_title_en" => "Stephania Cremin II",
                        "total_trained" => 70
                    ],
                    [
                        "training_center_title" => "Nico Koepp",
                        "training_center_title_en" => "Dr. Adaline Glover II",
                        "total_trained" => 70
                    ],
                    [
                        "training_center_title" => "Title",
                        "training_center_title_en" => "Title En",
                        "total_trained" => 65
                    ]
                ],
                "total_popular_courses" => [
                    [
                        "course_title" => "Dr. Barrett Bauch DDS",
                        "course_title_en" => "Prof. Vincenzo Bernhard DDS",
                        "total_enrollments" => 1600
                    ],
                    [
                        "course_title" => "Juwan Fadel",
                        "course_title_en" => "Coleman Connelly I",
                        "total_enrollments" => 1000
                    ],
                    [
                        "course_title" => "Josefina Lockman",
                        "course_title_en" => "Colby Hudson",
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
