@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.languages.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.languages.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.languages.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.languages.partials.languages-header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="languages-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.languages.table.name') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($languages as $language)
                        <tr>
                            <td>{{$language['name']}} 
                                @if($language['default']) 
                                    <label class='label label-success pull-right'>{{trans('labels.general.default')}}</label> 
                                @endif
                            </td>
                            <td>
                                <div class="btn-group action-btn">
                                    <a href="{{route('admin.languages.edit', ['id' => $language['slug']])}}" class="btn btn-flat btn-default">
                                        <i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{route('admin.languages.destroy', ['id' => $language['slug']])}}" 
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
            var dataTable = $('#languages-table').dataTable({});
        });

    </script>
@endsection