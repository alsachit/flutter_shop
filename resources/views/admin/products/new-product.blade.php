@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h5>{!!   (!is_null($product)) ? 'Update product: <span class="product-header-title">' . $product->title . '</span>' : 'New Product' !!}</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ (!is_null($product)) ? route('update-product') : route('new-product') }}" method="post" class="row" enctype="multipart/form-data">

                            @csrf

                            @if(!is_null($product))
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @endif

                            <div class="form-group col-md-12">
                                <label for="product_title">Product Title</label>
                                <input id="product_title" type="text" name="product_title" class="form-control" placeholder="Product title" value="{{ (!is_null($product)) ? $product->title : ''}}">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="product_description">Product Description</label>
                                <textarea name="product_description" class="form-control" id="product_description" cols="30" rows="10" required  >{{ (!is_null($product)) ? $product->description : ''}}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="product_category">Product Category</label>
                                <select class="form-control" name="product_category" id="product_category" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (! is_null($product) && ($product->category->id === $category->id)) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="product_unit">Product Unit</label>
                                <select class="form-control" name="product_unit" id="product_unit" required>
                                    <option value="">Select a unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ (! is_null($product) && ($product->hasUnit->id === $unit->id)) ? 'selected' : '' }}>{{ $unit->formatted() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="product_price">Product Price</label>
                                <input id="product_price" type="number" step="any" name="product_price" class="form-control" placeholder="Product price" value="{{ (!is_null($product)) ? $product->price : ''}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="product_discount">Product Discount</label>
                                <input id="product_discount" type="number" step="any" name="product_discount" class="form-control" placeholder="Product discount" value="{{ (!is_null($product)) ? $product->discount : '0'}}">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="product_total">Product Total</label>
                                <input id="product_total" type="number" step="any" name="product_total" class="form-control" placeholder="Product total" value="{{ (!is_null($product)) ? $product->total : ''}}">
                            </div>

                            <!-- Option Section -->
                            <div class="form-group col-md-12">
                                <h5>Options Table</h5>
                                <table id="options-table" class="table table-striped">
                                    <tr>
                                        <td>
                                            Option Name
                                        </td>
                                        <td>
                                            Option Value
                                        </td>
                                        <td>
                                            Remove Option
                                        </td>
                                    </tr>
                                    @if(!is_null($product))

                                        @if(!is_null($product->jsonOptions()))
                                            @foreach($product->jsonOptions() as $optionName => $options)
                                                @foreach($options as $option)
                                                    <tr>
                                                        <td>
                                                            {{ $optionName }}
                                                        </td>
                                                        <td>
                                                            {{ $option }}
                                                        </td>
                                                        <td>
                                                            <a href="" class="option-remove-btn"><i class="bi bi-dash-circle-fill"></i></a>
                                                            <input type="hidden" name="{{ $optionName}}[]" value="{{ $option }}">
                                                        </td>
                                                        <td><input type="hidden" name="options[]" value="{{ $optionName }}"></td>
                                                    </tr>

                                                @endforeach
                                            @endforeach
                                        @endif

                                    @endif

                                </table>

                                <a class="btn btn-outline-dark add-option-btn">Add Option</a>

                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Add Photos</h5>
                                    </div>

                                    @for($i = 0 ; $i < 6 ; $i++)
                                        <div class="col-md-4 col-sm-12 mb-4">
                                            <div class="card image-card-upload">
                                                @if(!is_null($product->images) && count($product->images) > 0)
                                                    @if(isset($product->images[$i]))
                                                        <a href="#" data-imageid="{{ $product->images[$i]->id }}" data-removeimg="removeimg-{{ $i }}" data-fileid="image-{{ $i }}" class="remove-image-upload"><i class="bi bi-x-circle"></i></a>
                                                    @else
                                                        <a href="#" class="remove-image-upload" style="display: none"><i class="bi bi-x-circle"></i></a>
                                                    @endif
                                                @endif
                                                <a href="#" class="activate-image-upload" data-fileid="image-{{ $i }}" id="removeimg-{{ $i }}">
                                                    @if(!is_null($product->images) && count($product->images) > 0)
                                                        @if(isset($product->images[$i]))
                                                            <img id="{{ 'iimage-'. $i }}" src="{{ asset($product->images[$i]->url) }}" class="card-img-top">
                                                        @endif
                                                    @endif
                                                    <div class="card-body text-center">
                                                        @if(!is_null($product->images) && count($product->images) > 0)
                                                            @if(isset($product->images[$i]))
                                                                <i class="bi bi-card-image" style="display: none"></i>
                                                            @else
                                                                <i class="bi bi-card-image"></i>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </a>
                                                <input name="product_images[]" type="file" class="form-control-file image-file-upload" id="image-{{ $i }}">
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                            </div>

                            <div class="form-group col-md-2 offset-md-5">

                                <button type="submit" class="btn btn-primary btn-block">{{ (!is_null($product)) ? 'Update Product' : 'Add Product' }}</button>

                            </div>
                        </form>
                        <!-- End Option -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <! -- Modal option window -->

    <div class="modal" tabindex="-1" id="options-window">
        <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Option</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="option_name">Option Name</label>
                                <input id="option_name" type="text" name="option_name" class="form-control" placeholder="Option name">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="option_value">Option Value</label>
                                <input id="option_value" type="text" name="option_value" class="form-control" placeholder="Option value ">
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary add-option-button">Add Option</button>
                    </div>
                </div>
        </div>
    </div>


    <! -- Modal delete image window -->

    <div class="modal" tabindex="-1" id="imageDelete-window">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p>Are you sure you want to delete this image?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a type="submit" class="delete-image-btn btn btn-primary">Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        var optionsNameList = [];
    </script>
    <script>
        var imageDeleteUrl = '{{ route('delete-image') }}';
    </script>

    @if(!is_null($product))

        @if(!is_null($product->jsonOptions()))
            @foreach($product->jsonOptions() as $optionName => $options)
                <script> optionsNameList.push('{{ $optionName }}'); </script>
            @endforeach
        @endif
    @endif

    <script>
        $(document).ready(function (){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var optionsNameRow = '';
            var $optionWindow = $('#options-window');
            var $addOptionButton = $('.add-option-btn');
            var $optionTable = $('#options-table');
            var $optionRemoveBtn = $('.option-remove-btn');
            var $deleteImageWindow = $('#imageDelete-window');

            var $activateImageUpload = $('.activate-image-upload');


            function readURL(input, imageID){
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                       $('#'+imageID).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function resetUploadFile(fileUploadId, imageId, $elementI, $eD) {
                $('#'+imageId).attr('src', '');
                $elementI.fadeIn();
                $eD.fadeOut();
                $('#'+fileUploadId).val('');
            }

            $activateImageUpload.on('click', function (e){
                e.preventDefault();
                var me = $(this);

                var fileUploadId = $(this).data('fileid');
                $('#'+fileUploadId).trigger('click');
                var imageTag = '<img id="i'+ fileUploadId +'" src="" class="card-img-top">';
                $(this).append(imageTag);
                $('#'+fileUploadId).on('change', function (e){
                    readURL(this, 'i'+fileUploadId);
                    me.find('i').fadeOut();
                    var removeThisImage = me.parent().find('.remove-image-upload');
                    removeThisImage.fadeIn();
                    removeThisImage.on('click', function (e){
                        e.preventDefault();
                        resetUploadFile(fileUploadId, 'i'+fileUploadId ,  me.find('i'), removeThisImage);
                    });

                });

            });


            $('.remove-image-upload').on('click', function (e){
                e.preventDefault();
                var me = $(this)
                var imageID = me.data('imageid');
                var fileUploadId = $(this).data('fileid');
                var removeID = $(this).data('removeimg');
                var $removeThisImage = me.parent().find('.remove-image-upload');

                $('.delete-image-btn').data('fileid', fileUploadId);
                $('.delete-image-btn').data('removeimg', removeID);
                $('.delete-image-btn').data('imageid', imageID);
                $('.delete-image-btn').data('ed', $removeThisImage );
                $deleteImageWindow.modal('show');

            });

            $(document).on('click', '.delete-image-btn', function (e){
                e.preventDefault();

                var imageID = $(this).data('imageid');
                var fileUploadId = $(this).data('fileid');
                var removeID = $(this).data('removeimg');
                var ed = $(this).data('ed');

                resetUploadFile(fileUploadId, 'i'+fileUploadId ,  $('#'+removeID).find('i'), ed);

                $.ajax({
                    url : imageDeleteUrl,
                    data : {
                        image_id : imageID,
                    },
                    dataType : 'json',
                    method : 'post'
                });
                $deleteImageWindow.modal('hide');
            });

            $addOptionButton.on('click', function (e){
                e.preventDefault();
                $optionWindow.modal('show');
            });

            $(document).on('click', '.option-remove-btn', function (e){
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            $(document).on('click', '.add-option-button', function (e){
                e.preventDefault();
                var $optionName = $('#option_name');
                if ($optionName.val() === ''){
                    alert('Option name is required');
                    return false;
                }
                var $optionValue = $('#option_value');
                if ($optionValue.val() === ''){
                    alert('Option value is required');
                    return false;
                }

                if (!optionsNameList.includes($optionName.val())){
                    optionsNameList.push($optionName.val());
                    optionsNameRow = '<td><input type="hidden" name="options[]" value="' + $optionName.val() + '"></td>';
                }

                var optionRaw = `
                <tr>
                    <td>
                        `+ $optionName.val() + `
                    </td>
                    <td>
                        `+ $optionValue.val() +`
                    </td>
                    <td>
                        <a href="" class="option-remove-btn"><i class="bi bi-dash-circle-fill"></i></a>
                        <input type="hidden" name="`+ $optionName.val() +`[]" value="`+ $optionValue.val() +`">
                    </td>
                </tr>
                `;


                $optionTable.append(
                    optionRaw
                );

                $optionTable.append(
                    optionsNameRow
                );

                $optionValue.val('');

            });





        });
    </script>

@endsection
