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
                "total_ministry" => 0,
                "total_department" => 0,
                "total_industrial_skills_council" => 0,
                "total_deputy_commissioner_office" => 64,
                "total_youth" => 0,
                "total_4_ir_project" => 0,
                "total_rto" => 0,
                "total_industry" => 0,
                "total_job_provider" => 0,
                "total_popular_job" => 0,
                "total_skill_development_center" => 0,
                "total_popular_courses" => 0
            ];
        } else {
            $totalYouth = $this->getStatisticsFromYouth();
            [$totalSkillDevelopmentCenter, $totalPopularCourses] = $this->getStatisticsFromSSP();
            [$totalIndustry, $totalJobProvider, $totalIndustrialSkillsCouncil] = $this->getStatisticsFromIndustryAssociation();
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
                "total_popular_job" => 0,
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
        $totalJobProvider = $industryAssociationStatistics['total_job_provider'] ?? 0;
        $totalIndustrialSkillsCouncil = $industryAssociationStatistics['total_industry_association'] ?? 0;
        return [
            $totalIndustry,
            $totalJobProvider,
            $totalIndustrialSkillsCouncil
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
