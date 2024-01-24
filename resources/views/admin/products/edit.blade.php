@extends('admin.layouts.admin')

@section('title', 'Edit Product')

@section('script')
<script>
    jalaliDatepicker.startWatch();

    $('#tags').selectpicker({
            title : 'انتخاب تگ'
    });
    $('#category').selectpicker({
           title : 'انتخاب دسته'
    });

    $('#category').change(function(){
        let category_id = $(this).val();
        $.get( `{{url('/admin-panel/management/category-attributes/${category_id}')}}` , (response , status) => {
            if(status == 'success'){
                $('#filter-attributes').empty();
                $('#variation-attribute').empty();

                //make elements of filter attrs
                response.filter_attrs.forEach((filter_attr) => {
                        let div = $('<div/>',{
                            class: "form-group col-3"
                        })
                        div.append($('<label/>',{
                            for: filter_attr.name,
                            text: filter_attr.name
                        }) , $('<input/>', {
                            type: "text",
                            name: `filter_attributes[${filter_attr.id}]`,
                            id: filter_attr.name,
                            class: "form-control"
                        })
                        );

                        $('#filter-attributes').append(div);
                });

                //make elements of variation attr
                let variation_attr = response.variation_attr;
                let h5 = $('<h5/>',{text: 'تعیین مشخصات برای ویژگی'})
                h5.append($('<span/>',{class: "font-weight-bold" , text:' ' + variation_attr.name + ':'} ))
                $('#variation-attribute-title').html(h5);

                const variation_elements = {
                    'name' : 'نام',
                    'price' : 'قیمت',
                    'quantity' : 'تعداد',
                    'sku' : 'شناسه انبار',
                    'sale_price' : 'قیمت حراجی',
                    'date_on_sale_from' : 'تاریخ شروع حراجی',
                    'date_on_sale_to' : 'تاریخ پایان حراجی',
                }

                //insert add_btn in container
                let add_btn = $('<a/>',{class: "btn btn-success text-white",id: "add_btn", text: "اضافه کردن"});
                add_btn.prepend($('<i/>',{class: "bi bi-plus"}));
                $('#variation-attribute').append(add_btn);

                let num = 0;
                function addNewVariation(){
                    //create wrapper div
                    let wrapper = $('<div/>', {class: 'row align-items-center wrapper'});

                    //create remove btn and add to wrapper
                    let removebtn_div = $('<div/>', {class: 'col-1'});
                    removebtn_div.append($('<i/>',{class: "bi bi-dash-circle mt-2 text-danger removeBtn"}));

                    //insert elements of wrapper
                    let inputs_div = $('<div/>', {class: 'row col-11'});
                    for(let index in variation_elements){
                        let div = $('<div/>',{
                            class: "form-group col-3"
                        })

                        div.append( $('<label/>',{
                            for: `${index}-${num}`,
                            text: variation_elements[index]
                            }) , $('<input/>', {
                            id: `${index}-${num}`,
                            type: "text",
                            name: `variation[${index}][]`,
                            class: "form-control"
                            })
                        );

                        inputs_div.append(div);
                    }
                    wrapper.append(removebtn_div,inputs_div);



                    //add wrapper before add btn
                    add_btn.before(wrapper);

                    //add datepicker to input elements
                    $(`#date_on_sale_from-${num}`).attr({'data-jdp': '',autocomplete: 'off'});
                    $(`#date_on_sale_to-${num}`).attr({'data-jdp': '',autocomplete: 'off'});

                    num++;
                }

                addNewVariation();

                add_btn.click(function(){
                    addNewVariation();
                });

                $('#variation-attribute').on('click','.removeBtn', function(){
                        $(this).parent().parent().remove();
                })
                $('#variation-attribute').on('mouseenter','.removeBtn', function(){
                    $(this).removeClass('bi-dash-circle')
                    $(this).addClass('bi-dash-circle-fill')
                })
                $('#variation-attribute').on('mouseleave','.removeBtn', function(){
                    $(this).removeClass('bi-dash-circle-fill')
                    $(this).addClass('bi-dash-circle')
                })
            }
        });
    });

    //add datepicker to input elements
    $('#date_on_sale_from').attr({'data-jdp': '',autocomplete: 'off'});
    $('#date_on_sale_to').attr({'data-jdp': '',autocomplete: 'off'});

</script>
@endsection

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="POST">
    @csrf
    @method('put')
    <div class="row">

        <div class="form-group col-3">
            <label for="name">نام محصول</label>
            <input type="text" name="name" id="name" class="form-control" value="{{$product->name}}">
        </div>

        <div class="form-group col-3">
            <label for="brand">برند</label>
            <select name="brand" id="brand" class="form-control">
                @foreach ($brands as $brand)
                <option value="{{$brand->id}}" {{$brand->id == $product->brand_id ? 'selected' : ''}}>{{$brand->name}}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-3">
            <label>وضعیت</label>
            <select name="is_active" class="form-control">
                <option value="1" {{$product->getRawOriginal('is_active') ? 'selected' : ''}}>فعال</option>
                <option value="0" {{$product->getRawOriginal('is_active') ? '' : 'selected'}}>غیرفعال</option>
            </select>
        </div>

        <div class="form-group col-3">
            <label for="tags">تگ ها</label>
            <select name="tags[]" id="tags" multiple class="form-control" data-live-search="true">
                @foreach ($tags as $tag)
                <option value="{{$tag->id}}" {{in_array($tag->id,$product->tags()->pluck('tag_id')->toArray()) ?
                    'selected': ''}}>{{$tag->name}}</option>
                @endforeach
            </select>

        </div>

        <div class="form-group col-12">
            <label>توضیحات</label>
            <textarea class="form-control" name="description">{{$product->description}}</textarea>
        </div>

        {{-- category and attributes --}}
        <div class="col-12 mb-3">
            <hr>
        </div>
        <div class="form-group col-3 mb-5">
            <label>
                <h5>دسته بندی</h5>
            </label>
            <select name="category" id="category" class="form-control" data-live-search="true">
                @foreach ($categories as $category)
                <option value="{{$category->id}}" {{$category->id == $product->category->id ? 'selected':
                    ''}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        {{-- filter attributes --}}
        <div class="col-12 mb-1">
            <h5>ویژگی های فیلتر</h5>
        </div>
        <div id="filter-attributes" class="row col-12">
            @foreach ($product->productAttributes()->with('attribute')->get() as $productAttribute)
            <div class="form-group col-3">
                <label>{{$productAttribute->attribute->name}}</label>
                <input type="text" name="filter_attributes[{{$productAttribute->attribute->id}}]" class="form-control"
                    value="{{$productAttribute->value}}">
            </div>
            @endforeach
        </div>


        {{-- variation attribute --}}
        <div class="col-12 mt-5">
            <h5 id="variation-attribute-title">متغیرهای ویژگی
                {{$product->productVariations()->first()->attribute->name}}</h5>
        </div>
        <div id="variation-attribute" class="col-md-12 mb-4 fadeable">
            @foreach ($product->productVariations as $productVariation)

            <div class="col-12 d-flex justify-content-start align-items-center my-2">
                <h5 class="me-5">متغیر {{$productVariation->value}}</h5>
                <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="collapse"
                    data-target="#collapse-{{$productVariation->id}}">
                    نمایش
                </button>
            </div>

            <div class="collapse col-12" id="collapse-{{$productVariation->id}}">
                <div class="card card-body">
                    <div class="row">
                        <div class="form-group col-3">
                            <label>نام</label>
                            <input type="text" name="variation[name][]" class="form-control"
                                value="{{$productVariation->value}}">
                        </div>
                        <div class="form-group col-3">
                            <label>قیمت</label>
                            <input type="text" name="variation[price][]" class="form-control"
                                value="{{$productVariation->price}}">
                        </div>
                        <div class="form-group col-3">
                            <label>تعداد</label>
                            <input type="text" name="variation[quantity][]" class="form-control"
                                value="{{$productVariation->quantity}}">
                        </div>
                        <div class="form-group col-3">
                            <label>شناسه انبار</label>
                            <input type="text" name="variation[sku][]" class="form-control"
                                value="{{$productVariation->sku}}">
                        </div>
                        <div class="form-group col-3">
                            <label>قیمت حراجی</label>
                            <input type="text" name="variation[sale_price][]" class="form-control"
                                value="{{$productVariation->sale_price}}">
                        </div>
                        <div class="form-group col-3">
                            <label>تاریخ آغاز حراجی</label>
                            <div class="form-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Small</span>
                            </div>
                            <input type="text" id="date_on_sale_from" name="variation[date_on_sale_from][]"
                                class="form-control" value="{{verta($productVariation->date_on_sale_from)}}">
                        </div>
                        <div class="form-group col-3">
                            <label>تاریخ پایان حراجی</label>
                            <input type="text" id="date_on_sale_to" name="variation[date_on_sale_to][]"
                                class="form-control" value="{{verta($productVariation->date_on_sale_to)}}">
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>

        {{-- show delivery amounts --}}
        <div class="col-12 mb-3">
            <hr>
            <h5>هزینه ارسال</h5>
        </div>
        <div class="form-group col-3">
            <label>هزینه ارسال</label>
            <input type="text" name="delivery_amount" class="form-control" value="{{$product->delivery_amount}}">
        </div>
        <div class="form-group col-3">
            <label>هزینه ارسال برای محصول اضافی</label>
            <input type="text" name="delivery_amount_per_product" class="form-control"
                value="{{$product->delivery_amount_per_product}}">
        </div>

    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary">ویرایش</button>
        <a href="{{route('admin.products.index')}}" class="btn btn-dark mr-3">بازگشت</a>
    </div>
</form>

@endsection
