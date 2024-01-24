@extends('admin.layouts.admin')

@section('title', 'Create Brand')

@section('script')
    <script>
        $('#attribute_ids').selectpicker({
            'title' : 'انتخاب ویژگی'
        });

        $('#attribute_ids').change(function() {
            let attributesSelected = $(this).val();
            let attributes = @json($attributes);



            let attributeForFilter = [];

            attributes.forEach((attribute) => {
                $.each(attributesSelected , function(i,element){
                    if( attribute.id == element ){
                        attributeForFilter.push(attribute);
                    }
                });
            });

            $("#filter_attribute_ids").find("option").remove();
            $("#variation_attribute_id").find("option").remove();


            attributeForFilter.forEach((element)=>{
                let attributeFilterOption = $("<option/>" , {
                    value : element.id,
                    text : element.name
                });

                let variationOption = $("<option/>" , {
                    value : element.id,
                    text : element.name
                });

                $("#filter_attribute_ids").append(attributeFilterOption);
                $("#filter_attribute_ids").selectpicker('refresh');

                $("#variation_attribute_id").append(variationOption);
                $("#variation_attribute_id").selectpicker('refresh');
            });


        });



        $('#filter_attribute_ids').selectpicker({
            'title' : 'انتخاب ویژگی قابل فیلتر'
        });

        $('#variation_attribute_id').selectpicker({
            'title' : 'انتخاب ویژگی متغیر'
        });
    </script>
@endsection

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="row">

            <div class="form-group col-3">
                <label for="name">نام</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="form-group col-3">
                <label for="slug">نام انگلیسی</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
            </div>

            <div class="form-group col-3">
                <label for="parent_id">دسته والد</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="0">بدون والد</option>
                    @foreach ($parent_categories as $parent_category)
                    <option value="{{$parent_category->id}}">{{$parent_category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-3">
                <label for="is_active">وضعیت</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" selected>فعال</option>
                    <option value="0">غیرفعال</option>
                </select>
            </div>

            <div class="form-group col-md-12">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group col-3">
                <label for="attribute_ids">ویژگی</label>
                <select name="attribute_ids[]" multiple id="attribute_ids" class="form-control" data-live-search="true">
                    @foreach ($attributes as $attribute)
                        <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-3">
                <label for="filter_attribute_ids">ویژگی قابل فیلتر</label>
                <select name="filter_attribute_ids[]" multiple id="filter_attribute_ids" class="form-control" data-live-search="true">
                </select>
            </div>

            <div class="form-group col-3">
                <label for="variation_attribute_id">ویژگی متغیر</label>
                <select name="variation_attribute_id" id="variation_attribute_id" class="form-control" data-live-search="true">
                </select>
            </div>

            <div class="form-group col-3">
                <label for="icon">آیکون</label>
                <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon') }}">
            </div>

            <div class="col">
                <button type="submit" class="btn btn-primary">ثبت</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark">بازگشت</a>
            </div>

    </div>
</form>

@endsection
