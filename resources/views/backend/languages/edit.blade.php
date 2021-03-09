@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.languages.management') . ' | ' . trans('labels.backend.languages.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.languages.management') }}
        <small>{{ trans('labels.backend.languages.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($language, ['route' => ['admin.languages.update', $language['slug']], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.languages.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.languages.partials.languages-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', trans('validation.attributes.backend.languages.name'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('name', $language['name'], ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.languages.name_placeholder')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('slug', trans('validation.attributes.backend.languages.slug'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('slug', $language['slug'], ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.languages.slug_placeholder')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('status', trans('validation.attributes.backend.languages.default'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <div class="control-group">
                            <label class="control control--checkbox">
                                {{ Form::checkbox('default', 1, ($language['default'] == 1) ? true : false ) }}
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                    </div><!--col-lg-3-->
                </div><!--form control-->

                <div class="edit-form-btn">
                    {{ link_to_route('admin.languages.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection
