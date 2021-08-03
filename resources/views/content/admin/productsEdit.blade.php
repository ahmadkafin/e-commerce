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
@include('includes.admin._title', ['title', 'routes'])
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title">Edit {{ $title }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-update">
                            <div class="row">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="sku">Nomor SKU</label>
                                            <input type="text" class="form-control" id="sku" name="sku"
                                                placeholder="SKU">
                                            <small class="form-text text-danger" id="name-error"></small>
                                        </div>
                                    </div>
                                </div>
                                <hr style="width: 95%">
                                <div class="row mb-3">
                                    <h4 class="mb-3">Basic Info</h4>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="nama">Nama Produk</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                placeholder="Nama Produk">
                                            <small class="form-text text-muted">Nama Produk</small>
                                            <small class="form-text text-danger" id="name-error"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="slugs">Nama Slugs</label>
                                            <input type="text" class="form-control" id="slugs" name="slugs"
                                                placeholder="Nama Slugs">
                                            <small class="form-text text-muted">Slugs akan menjadi url endpoint kamu,
                                                eg: kotd.com/produk/nama-slugs</small>
                                            <small class="form-text text-danger" id="slugs-error"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="harga">Harga Produk</label>
                                            <input type="number" class="form-control" id="harga" name="harga"
                                                placeholder="Harga">
                                            <small class="form-text text-muted">Harga</small>
                                            <small class="form-text text-danger" id="harga-error"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="_isDiscount">Discount?</label>
                                            <input type="checkbox" class="form-check-input" id="_isDiscount"
                                                name="_isDiscount" style="margin-left: 3px;">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="discount" name="_discount"
                                                    placeholder="Discount" disabled>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Discount </small>
                                            <small class="form-text text-danger" id="slugs-error"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div id="body" style="height: 500px" style="background: white"></div>
                                        <textarea name="deskripsi" hidden id="deskripsi"></textarea>
                                    </div>
                                </div>
                                <hr style="width: 95%">
                                <div class="row mb-3">
                                    <h4 class="mb-3">Ukuran</h4>
                                    <div class="row" id="ukuran">
                                    </div>
                                </div>
                                <hr style="width: 95%">
                                <div class="row mb-3">
                                    <h4 class="mb-3">Images</h4>
                                    <div class="row" id="images_product">

                                    </div>
                                </div>
                            </div>
                            <hr style="width: 100%">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="modal-update">
    <!-- Modal -->
    <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelBaju">Upload Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header d-flex p-0">
                    <ul class="nav nav-pills p-2">
                        <li class="nav-item"><a class="nav-link" href="#uimage" data-toggle="tab">Upload
                                Images</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#imgs" data-toggle="tab">Images</a></li>
                    </ul>
                </div>
                <div class="modal-body" id="mod-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content">
                                <div class="tab-pane" id="uimage">
                                    <form id="uploadImage" class="dropzone" enctype="multipart/form-data" method="POST">
                                        @csrf
                                    </form>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="checks" id="checks">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Associate this image with this products
                                        </label>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="imgs">
                                    <div class="row" id="img_data">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closed">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var config = {
            data: {
                _token: "{{ csrf_token() }}",
                _img: "{{ asset('img/products/:data') }}"
            },
            routes: {
                show: "{{ route('products.show', ':id') }}",
                getImage: "{{ route('images.get') }}",
                postImage: "{{ route('images.store') }}"
            }
        }
</script>
<script src="https://unpkg.com/quill-image-compress@1.2.11/dist/quill.imageCompressor.min.js"></script>
<script src="{{ asset('js/products-update.js') }}"></script>
<script src="{{ asset('js/dropzoneU.js') }}"></script>
@endpush