@extends('layouts.admin.layouts')
@section('content')
@include('includes.admin._title', ['title', 'routes', 'home'])
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title">List {{ $title }}</h3>
                            </div>
                            <div class="col order-1">

                            </div>
                            <div class="col order-5">
                                <div class="card-title float-right">
                                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-info btn-sm">+
                                        Tambah Produk</a>
                                </div>
                            </div>
                        </div>
                        <form id="form-import">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-sm-10 col-md-10 col-lg-10">
                                    <div class="form-group">
                                        <label for="excel">Upload data CSV / XLSX</label>
                                        <input type="file" name="excel" id="excel" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="excel">&nbsp;</label>
                                        <button type="submit" class="btn btn-info btn-block" id="btn-import">
                                            <i class="fa fa-spinner fa-spin d-none" id="spins"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="products-data" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>images</th>
                                    <th>sku</th>
                                    <th>Nama</th>
                                    <th>Warna</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="modals">
    <!-- Modal -->
    <div class="modal fade" id="modSize" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelBaju">List Ukuran baju</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mod-body">
                    <div class="row">
                        <div class="col-md-4" id="ukuranS"></div>
                        <div class="col-md-4" id="ukuranM"></div>
                        <div class="col-md-4" id="ukuranL"></div>
                        <div class="col-md-4" id="ukuranXL"></div>
                        <div class="col-md-4" id="ukuranXXL"></div>
                        <div class="col-md-4" id="ukuranXXXL"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
@endsection

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script>
    var config = {
            data: {
                _token: "{{ csrf_token() }}",
                _img: "{{ asset('img/:data') }}"
            },
            routes: {
                index: "{{ route('products.index') }}",
                edit: "{{ route('dashboard.products.edit', ':id') }}",
                delete: "{{ route('products.destroy', ':id') }}",
                import: "{{route('products.import')}}",
            }
        }
</script>
<script src="{{ asset('js/products-script.js') }}"></script>
<script>

</script>
@endpush