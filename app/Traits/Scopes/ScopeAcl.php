<?php

namespace App\Traits\Scopes;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\Youth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

trait ScopeAcl
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeAcl($query): mixed
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $tableName = $this->getTable();

        if ($authUser instanceof User) { //Backend Users
            if ($authUser->isInstituteUser()) {
                if (Schema::hasColumn($tableName, 'institute_id')) {
                    $query = $query->where($tableName . '.institute_id', $authUser->institute_id);
                }
            } else if ($authUser->isOrganizationUser()) {
                if (Schema::hasColumn($tableName, 'organization_id')) {
                    $query = $query->where($tableName . '.organization_id', $authUser->organization_id);
                }
            } else if ($authUser->isIndustryAssociationUser()) {
                if (Schema::hasColumn($tableName, 'industry_association_id')) {
                    $query = $query->where($tableName . '.industry_association_id', $authUser->industry_association_id);
                }
            }
        } elseif ($authUser instanceof Youth){ //youth user

            if (Schema::hasColumn($tableName, 'youth_id')) {
                $query = $query->where($tableName . '.youth_id', $authUser->id);
            }
        }

        return $query;
    }

}
