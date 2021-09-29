{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">لیست مکان ها
                    <div class="text-muted pt-2 font-size-sm">در این بخش شما لیست مکان ها را مشاهده میکنید</div>
                </h3>
            </div>
        </div>

        <div class="card-body">

            <!--begin::Search Form-->
            <form action="{{ route('panel.locations.index') }}" method="GET">
                <div class="mt-2 mb-5 mt-lg-5 mb-lg-10">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-xl-4">
                            <div class="row align-items-center">
                                <div class="col-md-12 my-2 my-md-0">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" placeholder="جستجو ..."
                                               id="kt_datatable_search_query" name="name"
                                               value="{{ request('name') }}"/>
                                        <span><i class="flaticon2-search-1 text-muted"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                            <button class="btn btn-light-primary px-6 font-weight-bold" type="submit">
                                جستجو
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Search Form-->

            <table class="table table-bordered table-hover" id="locationList">
                <thead>
                <tr>
                    <th>کد مکان</th>
                    <th>عنوان</th>
                    <th>دسته بندی</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($locations as $location)
                    <tr>
                        <td>
                            <span class="label-cursor">
                                {{ $location->id }}
                            </span>
                        </td>
                        <td>{{ $location->title }}</td>
                        <td>{{ $location->category->title }}</td>
                        <td>
                           @if($location->status == 1)
                                <form action="{{ route('panel.locations.update.status', ['location' => $location->id]) }}" method="POST">
                                    <button class="btn btn-success font-weight-bolder btn-sm" type="submit">
                                        <i class="fa fa-check-double"></i>
                                        تایید شده
                                    </button>
                                    @csrf
                                    @method('PUT')
                                </form>
                            @else
                                <form action="{{ route('panel.locations.update.status', ['location' => $location->id]) }}" method="POST">
                                    <button class="btn btn-primary font-weight-bolder btn-sm" type="submit">
                                        <i class="fa fa-spin fa-spinner"></i>
                                        در انتظار تایید
                                    </button>
                                    @csrf
                                    @method('PUT')
                                </form>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown dropdown-inline mr-4">
                                <button type="button" class="btn btn-default btn-icon btn-sm"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item text-warning btn-status-coll"
                                       href="">
                                        <i class="fas fa-edit text-warning mr-2"></i>
                                        <span>
                                            ویرایش
                                        </span>
                                    </a>

                                    <a class="dropdown-item text-danger btn-status-coll"
                                       href="">
                                        <i class="fas fa-trash text-danger mr-2"></i>
                                        <span>
                                            حذف
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/Tools.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    @toastr_render
@endsection
