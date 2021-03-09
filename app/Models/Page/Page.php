<?php

namespace App\Models\Page;

use App\Models\BaseModel;
use App\Models\ModelTrait;
use App\Models\Page\Traits\Attribute\PageAttribute;
use App\Models\Page\Traits\PageRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Page extends BaseModel
{
    use ModelTrait,
    SoftDeletes,
    PageRelationship,
    HasTranslations,
    PageAttribute {
        // PageAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    const HOME = 2;

    public $translatable = ['title', 'page_slug', 'description', 'cannonical_link', 'seo_title', 'seo_keyword', 'seo_description'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The guarded field which are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'created_by' => 1,
    ];

    protected $with = ['owner'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.pages.table');
    }

    public function scopeActive($query)
    {
        if(auth()->check()) {
            return $query;
        }

        return $query->where('status', '<>', 0);
    }
}
