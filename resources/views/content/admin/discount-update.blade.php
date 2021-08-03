@extends('layouts.admin.layouts')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('dropzone/css/dropzone.min.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
    .ql-toolbar.ql-snow {
        background-color: rgb(255, 255, 255) !important;
    }
</style>
@endpush
@section('content')
@include('includes.admin._title', ['title', 'routes', 'home'])
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title">{{ $title }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-update-discount">
                            @csrf
                            <h2 class="mb-4">General Info</h2>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="event_name">Nama Discount</label>
                                        <input type="text" class="form-control" name="event_name" id="event_name"
                                            value="{{$disc->event_name}}" />
                                        <small id="event_name_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="slugs">Slugs</label>
                                        <input type="text" class="form-control" name="slugs" id="slugs"
                                            value="{{$disc->slugs}}" />
                                        <small id="slugs_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            min='2021-08-03' value="{{date('Y-m-d', strtotime($disc->start_date))}}" />
                                        <small id="start_date_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" name="end_date" id="end_date"
                                            value="{{date('Y-m-d', strtotime($disc->end_date))}}" />
                                        <small id="end_date_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="images">Image</label>
                                        <input type="file" name="images" class="form-control" id="images" />
                                        <small id="images_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <label for="current image">Current Image</label>
                                    <div class="col-12">
                                        <img src="{{asset('img/discounts/'.$disc->images)}}" alt="images"
                                            class="img-fluid" width="50">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2 class="mb-2">Assign Product</h2>

                            <div class="alert alert-danger alert-dismissible fade" id="products_alert" role="alert">
                                <strong id="msg"></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true" style="color: black">&times;</span>
                                </button>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <input type="search" name="search" class="form-control" id="search"
                                        placeholder="Nama atau Nomor SKU produk" />
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <ul class="list-group position-absolute res" id="result">
                                    </ul>
                                </div>
                            </div>
                            <table id="products-data" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <div>
                                                <input type="checkbox" id="checkall">
                                            </div>
                                        </th>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Harga</th>
                                        <th>Diskon(%)</th>
                                        <th>Harga diskon</th>
                                    </tr>
                                </thead>
                                <tbody id="data-body">
                                    @foreach ($disc->discount_products as $data)
                                    <tr>
                                        <td>
                                            <input type="checkbox" checked value="{{$data->uid_products}}"
                                                name="products[]" class="delete_check" />
                                        </td>
                                        <td>{{$data->products->sku}}</td>
                                        <td>{{$data->products->nama}}</td>
                                        <td width="15%">{{number_format($data->products->harga, 0)}}</td>
                                        <td width="10%">
                                            <input type="number" data-harga="{{$data->products->harga}}"
                                                class="form-control diskon" value="{{$data->disc_percent}}"
                                                name="diskon[]">
                                        </td>
                                        <td width="20%">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                @php
                                                $harga = ($data->disc_percent/100) * $data->products->harga;
                                                $harga = $data->products->harga - $harga;
                                                @endphp
                                                <input type="number" class="form-control harga-hasil" readonly
                                                    value="{{$harga}}">
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row text-center mt-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info" id="add-discount">
                                        <i class="fa fa-spinner fa-spin d-none" id="spins"></i>
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
    var config = { 
            data: {
                _token: "{{ csrf_token() }}",
            },
            routes: {
                index: "{{route('dashboard.discount')}}",
                slugs: "{{route('discounts.slug')}}",
                search: "{{route('discounts.product')}}",
            }
        };
</script>
<script src="https://unpkg.com/quill-image-compress@1.2.11/dist/quill.imageCompressor.min.js"></script>
<script src="{{ asset('js/discount-update.js') }}"></script>
@endpush