@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.themes.management') . ' | ' . trans('labels.backend.themes.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.themes.management') }}
        <small>{{ trans('labels.backend.themes.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.themes.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.themes.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.themes.partials.themes-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', trans('validation.attributes.backend.themes.name'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.themes.name'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->


                <div class="edit-form-btn">
                    {{ link_to_route('admin.themes.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection

