@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Tags') }}</div>
                    <div class="card-body">
                        <form action="{{ route('search-tags') }}" role="search" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Search Tags</h4>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="search" name="tag_search" class="form-control" placeholder="Search tags" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-light">Search</button>
                                </div>

                            </div>
                        </form>
                            <form action="{{ route('tags') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Add New Tag</h4>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tag_name">Tag Name</label>
                                        <input type="text" id="tag_name" class="form-control" name="tag_name" placeholder="Tag name" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary">Add Tag</button>
                                    </div>
                                </div>
                            </form>
                        <div class="row">
                            @foreach($tags as $tag)
                                <div class="col-md-3">
                                    <div class="alert alert-primary text-center">
                                        <p>{{ $tag->tag }}</p>
                                        <span class="btn-span">
                                            <span><a class="delete-tag"
                                                     data-tagname="{{ $tag->tag }}"
                                                     data-tagid="{{ $tag->id }}" ><i class="bi bi-trash-fill"></i></a></span>
                                            <span><a class="edit-tag"
                                                     data-tagname="{{ $tag->tag }}"
                                                     data-tagid="{{ $tag->id }}" ><i class="bi bi-pencil-square"></i></a></span>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ (!is_null($showLinks) && $showLinks ? $tags->links() : '')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<! -- Modal edit window -->

<div class="modal" tabindex="-1" id="edit-window">
    <div class="modal-dialog">
        <form action="{{ route('tags') }}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_tag_name">Tag Name</label>
                                <input type="text" id="edit_tag_name" class="form-control" name="tag_name" value="" placeholder="Tag name" required>
                            </div>
                        </div>
                        <input type="hidden" name="tag_id" id="edit_tag_id">
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
        <form action="{{ route('tags') }}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="delete-message"></p>

                    @csrf
                    <input type="hidden" name="_method" value="delete">
                    <input type="hidden" name="tag_id" value="" id="tag_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
    <script>
        jQuery(document).ready(function (){
            var $deleteTag = $('.delete-tag');
            var $deleteWindow = $('#delete-window');
            var $tagId = $('#tag_id');
            var $deleteMessage = $('#delete-message');
            $deleteTag.on('click', function (e){
                var tag_id = $(this).data('tagid');
                var tag_name = $(this).data('tagname');
                e.preventDefault();
                $tagId.val(tag_id);
                $deleteMessage.text('Are you sure you want to delete ' + tag_name);
                $deleteWindow.modal('show');
            });

            var $editTag = $('.edit-tag');
            var $editWindow = $('#edit-window');
            var $editTagName = $('#edit_tag_name');
            var $editTagId = $('#edit_tag_id');
            $editTag.on('click', function (e){
                e.preventDefault();
                var edit_tag_id = $(this).data('tagid');
                var edit_tag_name = $(this).data('tagname');
                $editTagName.val(edit_tag_name);
                $editTagId.val(edit_tag_id);
                $editWindow.modal('show');
            });
        });
    </script>
    @if(\Illuminate\Support\Facades\Session::has('success'))
        <script>
            toastr.success("{!! \Illuminate\Support\Facades\Session::get('success') !!}");
        </script>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('warning'))
        <script>
            toastr.warning("{!! \Illuminate\Support\Facades\Session::get('warning') !!}");
        </script>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('error'))
        <script>
            toastr.error("{!! \Illuminate\Support\Facades\Session::get('error') !!}");
        </script>
    @endif
@endsection
