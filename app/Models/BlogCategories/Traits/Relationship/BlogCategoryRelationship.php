<?php

namespace App\Models\BlogCategories\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Blogs\Blog;

/**
 * Class BlogCategoryRelationship.
 */
trait BlogCategoryRelationship
{
    /**
     * BlogCategories belongs to relationship with state.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_map_categories', 'category_id', 'blog_id');
    }
}
