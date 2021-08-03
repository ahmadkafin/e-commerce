@extends('layouts.admin.layouts')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('dropzone/css/dropzone.min.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
    .ql-toolbar.ql-snow {
        background-color: rgb(255, 255, 255) !important;
    }
</style>
@endpush
@section('content')
@include('includes.admin._title', ['title', 'routes', 'home', 'home'])
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
                            <div class="col order-1">

                            </div>
                            <div class="col order-5">
                                <div class="card-title float-right">
                                    <button type="button" class="btn btn-info" id="btn-assign" disabled
                                        data-toggle="modal" data-target="#assign-modal">Assign</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="images-product">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- modal --}}
<div class="modal fade" id="assign-modal" tabindex="-1" role="dialog" aria-labelledby="assignModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign Image to Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select name="uid_products" id="dropdown-products" class="form-control select2bs4">
                    @foreach ($datas as $data)
                    <option value="{{$data->sku}}">{{$data->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save">
                    <i class="fa fa-spinner fa-spin d-none" id="spins"></i>
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
    integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var config = {
            data: {
                _img: "{{ asset('img/products/:data') }}"
            },
            routes: {
                images: "{{route('images.getAll')}}",
                edit: "{{route('images.update')}}",
            }
        }
</script>
<script>
    $(document).ready(function() {
        $('.select2bs4').select2({
            dropdownParent: $('#assign-modal'),
            theme: 'bootstrap4',
        })
    });
</script>
<script src="{{ asset('js/images-index.js') }}"></script>

@endpush