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

                        <form action="{{ (!is_null($product)) ? route('update-product') : route('new-product') }}" method="post" class="row">

                            @csrf

                            @if(!is_null($product))
                                <input type="hidden" name="_method" value="PUT">
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
                                </table>

                                <a class="btn btn-outline-dark add-option-btn">Add Option</a>

                            </div>

                            <div class="form-group col-md-2 offset-md-5">

                                <button type="submit" class="btn btn-primary btn-block">Add Product</button>

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

@endsection

@section('scripts')

    <script>
        $(document).ready(function (){

            var optionsNameList = [];

            var optionsNameRow = '';
            $optionWindow = $('#options-window');
            $addOptionButton = $('.add-option-btn');
            $optionTable = $('#options-table');
            //$optionRemoveBtn = $('.option-remove-btn')
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
