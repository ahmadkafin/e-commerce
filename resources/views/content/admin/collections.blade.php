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
                                    <button type="button" class="btn btn-info" id="btn-modal-collection"
                                        data-toggle="modal" data-target="#collection-modal">Add Collection</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="collections-data" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Slugs</th>
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

{{-- modal --}}
<div class="modal fade" id="collection-modal" tabindex="-1" role="dialog" aria-labelledby="assignModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Add Collection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="form-add-collection">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name_collection" />
                        <small class="form-text text-danger" id="name-error"></small>
                    </div>
                    <div class="form-group">
                        <label for="slugs">Slugs</label>
                        <input type="text" name="slugs" class="form-control" id="slugs_collection" />
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" id="image_collection" />
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">
                        <i class="fa fa-spinner fa-spin d-none" id="spins"></i>
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="collection-modal-update" tabindex="-1" role="dialog" aria-labelledby="assignModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Add Collection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="form-update-collection">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="method" value="PUT">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="nameupdate" class="form-control" id="name_collection_update" />
                        <small class="form-text text-danger" id="name-error"></small>
                    </div>
                    <div class="form-group">
                        <label for="slugs">Slugs</label>
                        <input type="text" name="slugsupdate" class="form-control" id="slugs_collection_update" />
                    </div>
                    <div class="form-group">
                        <label for="images">Image</label>
                        <input type="file" name="images" class="form-control" id="image_collection_update" />
                        <br>
                        <label for="_image">Current Image</label>
                        <div id="_image" class="mt-3 text-center">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save-update">
                        <i class="fa fa-spinner fa-spin d-none" id="spins2"></i>
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal --}}
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
                index: "{{route('collections.index')}}",
                store: "{{route('collections.store')}}",
                check: "{{route('collections.cks')}}",
                patch: "{{route('collections.patch', ':id')}}",
                show: "{{route('collections.show', ':id')}}",
                update: "{{route('collections.update', ':id')}}",
                delete: "{{route('collections.destroy',':id')}}",
            },
            data: {
                _token: "{{ csrf_token() }}",
                _path: "{{asset('/img')}}"
            }
    }
</script>
<script src="{{ asset('js/collections-scripts.js') }}"></script>
@endpush