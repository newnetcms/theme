@extends('core::admin.master')

@section('meta_title', __('theme::theme-translate.index.page_title'))

@section('page_title', __('theme::theme-translate.index.page_title'))

@section('page_subtitle', __('theme::theme-translate.index.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('theme::theme-translate.index.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <form action="{{ route('theme.admin.theme-translate.save') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="edit_locale" value="{{ $currentLocale }}">

        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">
                            {{ __('theme::theme-translate.index.page_title') }}
                        </h6>
                    </div>
                    <div class="text-right">
                        <div class="btn-group">
                            <button class="btn btn-success" type="submit">{{ __('core::button.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Tabs header -->
                <ul class="nav nav-tabs">
                    @foreach(LaravelLocalization::getLocalesOrder() as $code => $locale)
                        <li class="nav-item">
                            <a
                                class="nav-link {{ $currentLocale === $code ? 'active' : '' }}"
                                href="{{ request()->url() }}?edit_locale={{ $code }}"
                            >
                                {{ $locale['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab content -->
                <div class="border p-3 border-top-0">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-dark">
                        <tr>
                            <th style="width:40%">Từ gốc</th>
                            <th style="width:60%">Bản dịch</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($origins as $key => $value)
                            <tr>
                                <td class="align-middle">{{ $key }}</td>
                                <td>
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           name="translations[{{ $key }}]"
                                           placeholder="{{ $value }}"
                                           value="{{ $translations[$key] ?? '' }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <div class="btn-group">
                    <button class="btn btn-success" type="submit">{{ __('core::button.save') }}</button>
                </div>
            </div>
        </div>
    </form>
@stop

