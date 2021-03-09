<?php

namespace App\Models\Page\Traits\Attribute;

/**
 * Class PageAttribute.
 */
trait PageAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        $buttons = '<div class="btn-group action-btn">
                    ' . $this->getEditButtonAttribute('edit-page', 'admin.pages.edit') . '
                    ' . $this->getViewButtonAttribute();

        if($this->status != self::HOME) {
            $buttons .= $this->getDeleteButtonAttribute('delete-page', 'admin.pages.destroy');
        }

        $buttons .= '</div>';

        return $buttons;
    }

    /**
     * @return string
     */
    public function getViewButtonAttribute()
    {
        return '<a target="_blank" href="' . url('/' . app()->getLocale() . '/' . trim($this->slug, '"')) . '" class="btn btn-flat btn-default">
                    <i data-toggle="tooltip" data-placement="top" title="View Page" class="fa fa-eye"></i>
                </a>';
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<label class='label label-success'>" . trans('labels.general.active') . '</label>';
        }

        return "<label class='label label-danger'>" . trans('labels.general.inactive') . '</label>';
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status >= 1;
    }
}
