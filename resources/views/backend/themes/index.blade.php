@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.themes.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.themes.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.themes.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.themes.partials.themes-header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="pages-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.themes.table.name') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($themes as $theme)
                            <tr>
                                <td>{{$theme}} @if($theme == $activated_theme) <label class="label label-success pull-right">Active</label> @endif</td>
                                <td>
                                    <div class="btn-group action-btn">
                                        <a href="{{route('admin.themes.update', ['id' => $theme])}}" 
                                            class="btn btn-flat btn-default" data-method="put"
                                            data-trans-button-cancel="{{trans('buttons.general.cancel')}}"
                                            data-trans-button-confirm="{{trans('buttons.themes.use_as_default')}}"
                                            data-trans-title="{{trans('strings.backend.general.are_you_sure')}}">
                                            <i data-toggle="tooltip" data-placement="top" title="Confirm" class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{route('admin.themes.destroy', ['id' => $theme])}}" 
                                            class="btn btn-flat btn-default" data-method="delete"
                                            data-trans-button-cancel="{{trans('buttons.general.cancel')}}"
                                            data-trans-button-confirm="{{trans('buttons.general.crud.delete')}}"
                                            data-trans-title="{{trans('strings.backend.general.are_you_sure')}}">
                                            <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
                                        </a>
                                    </div>

                                </td>
                            </tr>                            
                        @endforeach

                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            var dataTable = $('#pages-table').dataTable({});
        });

    </script>
@endsection