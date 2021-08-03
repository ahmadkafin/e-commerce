@extends('layouts.admin.layouts')
@push('styles')

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
                            <div class="col order-1">

                            </div>
                            <div class="col order-5">
                                <div class="card-title float-right">
                                    <a href="{{route('dashboard.discount.create')}}" class="btn btn-info">Add
                                        Discount</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="discounts-data" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Images</th>
                                    <th>Name</th>
                                    <th>Slugs</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Aktif</th>
                                    <th>Action</th>
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

@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script>
    var config = {
            routes : {
                index: "{{route('discounts.index')}}",
                edit: "{{route('dashboard.discount.edit', ':id')}}",
            },
            data: {
                _token: "{{ csrf_token() }}",
                _path: "{{asset('/img')}}"
            }
    }
</script>
<script src="{{ asset('js/discounts-scripts.js') }}"></script>
@endpush