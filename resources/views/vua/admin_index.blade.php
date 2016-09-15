@extends('adm')
@section('content')
    <h1 class="apage-title">{{trans('m.companies')}}</h1>
    <table class="companies-atable admin-table tablesorter">
        <thead>
        <tr class="th-row">
            <th class="header">{{trans('m.title')}}</th>
            <th class="header">{{trans('m.region')}}</th>
            <th class="header">{{trans('m.type')}}</th>
            <th class="header">{{trans('m.author')}}</th>
            <th class="header">{{trans('m.owner')}}</th>
            <th class="header">{{trans('m.pub')}}</th>
            <th class="header">{{trans('m.created')}}</th>
            <th class="header">{{trans('m.updated')}}</th>
            <th class="header">{{trans('m.actions')}}</th>
        </tr>
        </thead>
        <?php $title_lang = 'title_' .  App::getLocale(); ?>
        @foreach($companies as $company)
            <tr>
                <td>{{$company->$title_lang}}</td>
                <td>
                    @if(!empty($company->region))
                        {{$company->region->$title_lang}}
                    @endif
                <td>
                    @foreach($company->company_type as $type)
                        {{($type->$title_lang)}}
                    @endforeach
                </td>
                <td>
                    {{\App\User::find($company->user_id)->name}}
                </td>
                <td>
                    @if(!empty($company->owner_id))
                        {{\App\User::find($company->owner_id)->name}}
                    @endif
                </td>
                <td>
                    @if($company->published == true)
                        <span class="agreen">{{trans('m.yes')}}</span>
                        <span class="icn_security">
                            <a class="atable-button a-unpublish" href="/{{App::getLocale()}}/adm/company/{{$company->id}}/unpublish">&nbsp;</a>
                        </span>
                    @else
                        <span class="ared">{{trans('m.no')}}</span>
                        <span class="icn_photo">
                            <a class="atable-button a-publish"  href="/{{App::getLocale()}}/adm/company/{{$company->id}}/publish">&nbsp;</a>
                        </span>
                    @endif
                </td>
                <td>
                    {{ date('H:i', strtotime($company->created_at)) }}
                    <br>
                    {{ date('d.m.y', strtotime($company->created_at)) }}
                </td>
                <td>
                    {{ date('H:i', strtotime($company->updated_at)) }}
                    <br>
                    {{ date('d.m.y', strtotime($company->updated_at)) }}
                </td>
                <td>
                    <span class="icn_edit">
                        <a class="atable-button" href="/{{App::getLocale()}}/adm/company/{{$company->id}}/edit">&nbsp;</a>
                    </span>
                    <span class="icn_trash">
                        <?php $locale = App::getLocale();  ?>
                        {!! Form::open(array('url' => "/$locale/adm/company/$company->id/delete", 'method' => 'delete', 'class' => 'form')) !!}
                        {!! Form::submit('&nbsp;', ['class' => 'btn-delete']) !!}
                        {!! Form::close() !!}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    {{--{!! $companies->render() !!}--}}

@endsection