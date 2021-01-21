@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ __('Categories') }}</div>

                    <div class="card-body">
                        <form action="{{ route('search-categories') }}" role="search" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Search Categories</h4>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="search" name="category_search" class="form-control" placeholder="Search categories" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-light">Search</button>
                                </div>

                            </div>
                        </form>
                        <form action="{{ route('categories') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Add New Category</h4>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" id="category_name" class="form-control" name="category_name" placeholder="Category name" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary">Add Category</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-3">
                                    <div class="alert alert-primary text-center">
                                        <p>{{ $category->name }}</p>
                                        <span class="btn-span">
                                            <span><a class="delete-category"
                                                     data-categoryname="{{ $category->name }}"
                                                     data-categoryid="{{ $category->id }}" ><i class="bi bi-trash-fill"></i></a></span>
                                            <span><a class="edit-category"
                                                     data-categoryname="{{ $category->name }}"
                                                     data-categoryid="{{ $category->id }}" ><i class="bi bi-pencil-square"></i></a></span>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ (!is_null($showLinks) && $showLinks) ?  $categories->links() : '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <! -- Modal edit window -->

    <div class="modal" tabindex="-1" id="edit-window">
        <div class="modal-dialog">
            <form action="{{ route('categories') }}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_category_name">Category Name</label>
                                    <input type="text" id="edit_category_name" class="form-control" name="category_name" value="" placeholder="Category name" required>
                                </div>
                            </div>
                            <input type="hidden" name="category_id" id="edit_category_id">
                            <input type="hidden" name="_method" value="PUT">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <! -- Modal delete window -->

    <div class="modal" tabindex="-1" id="delete-window">
        <div class="modal-dialog">
            <form action="{{ route('categories') }}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="delete-message"></p>

                        @csrf
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="category_id" value="" id="category_id">

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
        jQuery(document).ready(function (){
            var $deleteCategory = $('.delete-category');
            var $deleteWindow = $('#delete-window');
            var $categoryId = $('#category_id');
            var $deleteMessage = $('#delete-message');
            $deleteCategory.on('click', function (e){
                var category_id = $(this).data('categoryid');
                var category_name = $(this).data('categoryname');
                e.preventDefault();
                $categoryId.val(category_id);
                $deleteMessage.text('Are you sure you want to delete ' + category_name);
                $deleteWindow.modal('show');
            });

            var $editCategory = $('.edit-category');
            var $editWindow = $('#edit-window');
            var $editCategoryName = $('#edit_category_name');
            var $editCategoryId = $('#edit_category_id');
            $editCategory.on('click', function (e){
                e.preventDefault();
                var edit_category_id = $(this).data('categoryid');
                var edit_category_name = $(this).data('categoryname');
                $editCategoryName.val(edit_category_name);
                $editCategoryId.val(edit_category_id);
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
