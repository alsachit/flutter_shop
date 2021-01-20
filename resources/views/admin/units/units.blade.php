

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Units') }}</div>

                    <div class="card-body">
                            <form action="{{ route('units') }}" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Add Unit</h3>
                                    </div>
                                @csrf
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit_name">Unit Name</label>
                                            <input type="text" id="unit_name" class="form-control" name="unit_name" placeholder="Unit name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit_code">Unit Code</label>
                                            <input type="text" id="unit_code" class="form-control" name="unit_code" placeholder="Unit code" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Add Unit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div class="row" >
                        @foreach($units as $unit)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" >
                                        <p>{{ $unit->unit_code }} ,  {{ $unit->unit_name }}</p>
                                        <span class="btn-span">
                                            <span><a class="delete-unit"
                                                     data-unitcode="{{ $unit->unit_code }}"
                                                     data-unitname="{{ $unit->unit_name }}"
                                                     data-unitid="{{ $unit->id }}" ><i class="bi bi-trash-fill"></i></a></span>
                                            <span><a class="edit-unit"
                                                     data-unitcode="{{ $unit->unit_code }}"
                                                     data-unitname="{{ $unit->unit_name }}"
                                                     data-unitid="{{ $unit->id }}" ><i class="bi bi-pencil-square"></i></a></span>
                                        </span>
                                    </div>
                                </div>
                        @endforeach
                        </div>
                        {{ $units->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <! -- Modal edit window -->

    <div class="modal" tabindex="-1" id="edit-window">
        <div class="modal-dialog">
            <form action="{{ route('units') }}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_unit_name">Unit Name</label>
                                    <input type="text" id="edit_unit_name" class="form-control" name="unit_name" value="" placeholder="Unit name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_unit_code">Unit Code</label>
                                    <input type="text" id="edit_unit_code" class="form-control" name="unit_code" value="" placeholder="Unit code" required>
                                </div>
                            </div>
                            <input type="hidden" name="unit_id" id="edit_unit_id">
                            <input type="hidden" name="_method" value="PUT">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changess</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <! -- Modal delete window -->

    <div class="modal" tabindex="-1" id="delete-window">
        <div class="modal-dialog">
            <form action="{{ route('units') }}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="delete-message"></p>

                                @csrf
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="unit_id" value="" id="unit_id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        jQuery(document).ready( function () {

            // Delete Script
            var $deleteUnit = $('.delete-unit');
            var $deleteWindow = $('#delete-window');
            var $unitId = $('#unit_id');
            var $deleteMessage = $('#delete-message');
            $deleteUnit.on('click', function (element){
                element.preventDefault();
                var unit_id = $(this).data('unitid');
                var unitName = $(this).data('unitname');
                var unitCode = $(this).data('unitcode');
                $deleteMessage.text('Are you sure you want delete ' + unitName + ' with code ' + unitCode);
                $unitId.val(unit_id);
                $deleteWindow.modal('show');
            });

            //Edit Script
            var $editUnit = $('.edit-unit');
            var $editWindow = $('#edit-window');
            var $edit_unitName = $('#edit_unit_name');
            var $edit_unitCode = $('#edit_unit_code');
            var $edit_unitId = $('#edit_unit_id');
            $editUnit.on('click', function (e){
                e.preventDefault();
                var unit_name = $(this).data('unitname');
                var unit_code = $(this).data('unitcode');
                var unit_id = $(this).data('unitid')
                $edit_unitName.val(unit_name);
                $edit_unitCode.val(unit_code);
                $edit_unitId.val(unit_id);
                $editWindow.modal('show');
            });

        });
    </script>

@if(\Illuminate\Support\Facades\Session::has('message'))
    <script>
        toastr.success("{!! \Illuminate\Support\Facades\Session::get('message') !!}");
    </script>
@endif
@if(\Illuminate\Support\Facades\Session::has('error'))
    <script>
        toastr.error("{!! \Illuminate\Support\Facades\Session::get('error') !!}");
    </script>
@endif

@endsection
