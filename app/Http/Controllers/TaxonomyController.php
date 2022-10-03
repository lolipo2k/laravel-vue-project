<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactStatusResource;
use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldsCategoryResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\WorkExperienceResource;
use App\Models\Projects\ContactStatus;
use App\Models\Taxonomy\Field;
use App\Models\Taxonomy\FieldsCategory;
use App\Models\Taxonomy\Region;
use App\Models\Taxonomy\WorkExperience;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function regions()
    {
        return RegionResource::collection(Region::all());
    }

    public function fields()
    {
        return FieldResource::collection(Field::all());
    }

    public function workExperience()
    {
        return WorkExperienceResource::collection(WorkExperience::all());
    }

    public function contactStatuses()
    {
        return ContactStatusResource::collection(ContactStatus::all());
    }

    public function fieldsCategories()
    {
        return FieldsCategoryResource::collection(FieldsCategory::all());
    }
}
