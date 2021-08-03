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
                        <form id="form-add-discount">
                            @csrf
                            <h2 class="mb-4">General Info</h2>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="event_name">Nama Discount</label>
                                        <input type="text" class="form-control" name="event_name" id="event_name" />
                                        <small id="event_name_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="slugs">Slugs</label>
                                        <input type="text" class="form-control" name="slugs" id="slugs" />
                                        <small id="slugs_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            min='2021-08-03' />
                                        <small id="start_date_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" name="end_date" id="end_date" />
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
                _img: "{{ asset('img/products/:data') }}"
            },
            routes: {
                index: "{{route('dashboard.discount')}}",
                slugs: "{{route('discounts.slug')}}",
                store: "{{route('discounts.store')}}",
                search: "{{route('discounts.product')}}",
            }
        };
</script>
<script src="https://unpkg.com/quill-image-compress@1.2.11/dist/quill.imageCompressor.min.js"></script>
<script src="{{ asset('js/discount-create.js') }}"></script>
@endpush