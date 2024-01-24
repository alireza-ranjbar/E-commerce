@extends('admin.layouts.admin')

@section('title', 'Create Product')

@section('script')
<script>
    jalaliDatepicker.startWatch();

    $('#category').selectpicker({
        title: 'انتخاب دسته'
    })
    $('#brand').selectpicker({
        title: 'انتخاب برند'
    })
    $('#tags').selectpicker({
        title: 'انتخاب تگ'
    })

    $('.fadeable').slideUp();
    $('#category').change(function(){
        $('#variation-container').empty();
        let category_id = $(this).val();

        $.get( `{{url('/admin-panel/management/category-attributes/${category_id}')}}` , (response , status) => {
            $('#for-filter').find('div').remove();
            $('.fadeable').slideDown();

            if(status == 'success'){
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

                    $('#for-filter').append(div);
                });

                //make elements of variation attr
                let variation_attr = response.variation_attr;
                let h5 = $('<h5/>',{text: 'تعیین مشخصات برای ویژگی'})
                h5.append($('<span/>',{class: "font-weight-bold" , text:' ' + variation_attr.name + ':'} ))
                $('#variation-container').append(h5);

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
                $('#variation-container').append(add_btn);


                let num = 0;
                function addNewVariation(){
                    //create wrapper div
                    let wrapper = $('<div/>', {class: 'row align-items-center wrapper'});

                    //create remove btn and add to wrapper
                    wrapper.append($('<i/>',{class: "bi bi-dash-circle mt-2 text-danger removeBtn"}));

                    //insert elements of wrapper

                    for(let index in variation_elements){
                        let div = $('<div/>',{
                            class: "form-group col-2"
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

                        wrapper.append(div);
                    }


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

                $('#variation-container').on('click','.removeBtn', function(){
                    $(this).parent().remove();
                })
                $('#variation-container').on('mouseenter','.removeBtn', function(){
                    $(this).removeClass('bi-dash-circle')
                    $(this).addClass('bi-dash-circle-fill')
                })
                $('#variation-container').on('mouseleave','.removeBtn', function(){
                    $(this).removeClass('bi-dash-circle-fill')
                    $(this).addClass('bi-dash-circle')
                })



            }
        });
    });
    $('#primary_image,#other_images').change(function() {
        $(this).next('label').html('انتخاب شد');
        $(this).next('label').css('color','green');
    });

</script>
@endsection

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5>اطلاعات محصول</h5>
        </div>

        <div class="form-group col-md-3">
            <label for="name">نام</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group col-md-3">
            <label for="brand">برند</label>
            <select name="brand" id="brand" class="form-control" data-live-search="true">
                @foreach ($brands as $brand)
                <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="is_active">وضعیت</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" selected>فعال</option>
                <option value="0">غیرفعال</option>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="tags">تگ ها</label>
            <select name="tags[]" id="tags" class="form-control" multiple data-live-search="true">
                @foreach ($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="description">توضیحات</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="col-md-12 mb-4">
            <hr>
            <h5>تصاویر محصول</h5>
        </div>

        <div class="form-group col-3">
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" name="primary_image" id="primary_image">
                <label class="custom-file-label" for="primary_image">تصویر اصلی</label>
            </div>
        </div>

        <div class="form-group col-3">
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" name="other_images[]" multiple id="other_images">
                <label class="custom-file-label" for="other_images">سایر تصاویر</label>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <hr>
            <h5>دسته بندی محصول</h5>
        </div>


        <div class="from-group col-md-12 d-flex justify-content-center align-items-center">
            <label for="category" class="ml-2">دسته محصول</label>
            <select class="form-control col-md-6 ms-2" name="category" id="category" data-live-search="true">
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}} - {{$category->parent->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-4 fadeable">
            <h5>ویژگی های فیلتر</h5>
            <div id="for-filter" class="row"></div>
        </div>

        <div id="variation-container" class="col-md-12 mb-4 fadeable">
        </div>

        <div class="col-md-12 mb-4">
            <hr>
            <h5>هزینه ارسال</h5>
        </div>

        <div class="form-group col-3">
            <label for="delivery_amount">هزینه ارسال</label>
            <input type="text" name="delivery_amount" id="delivery_amount" class="form-control"
                value="{{ old('delivery_amount') }}">
        </div>

        <div class="form-group col-3">
            <label for="delivery_amount_per_product">هزینه ارسال به ازای هر محصول اضافه</label>
            <input type="text" name="delivery_amount_per_product" id="delivery_amount_per_product" class="form-control"
                value="{{ old('delivery_amount_per_product') }}">
        </div>

        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">ثبت</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-dark">بازگشت</a>
        </div>

    </div>
</form>

@endsection
