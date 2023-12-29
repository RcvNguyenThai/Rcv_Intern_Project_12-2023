@php
    $isUpdate = isset($product);

    $listInput = [
        [
            'name' => 'productName',
            'label' => 'Tên sản phẩm',
            'type' => 'text',
            'placeholder' => 'Nhập tên sản phẩm',
            'value' => $isUpdate ? $product->product_name : '',
            'form' => 'input',
        ],
        [
            'name' => 'description',
            'label' => 'Mô tả',
            'placeholder' => 'Nhập mô tả',
            'value' => $isUpdate ? $product->description : '',
            'form' => 'textarea',
            'rows' => 5,
            'cols' => 70,
        ],
        [
            'name' => 'price',
            'label' => 'Giá sản phẩm (USD)',
            'type' => 'number',
            'placeholder' => 'Nhập giá',
            'value' => $isUpdate ? $product->price : '',
            'form' => 'input',
        ],
        [
            'name' => 'status',
            'label' => 'Trạng thái',
            'placeholder' => 'Nhập mô tả',
            'value' => $isUpdate ? $product->status : '',
            'options' => ['Đang bán' => 0, 'Dừng bán' => 1, 'Hết hàng' => 2],
            'form' => 'select',
        ],
    ];
@endphp
<div>
    @foreach ($listInput as $input)
        @if ($input['form'] == 'input')
            <x-forms.input :error="$errors->first($input['name'])" :placeholder="$input['placeholder']" :name="$input['name']" :value="$input['value']" :label="$input['label']"
                :type="$input['type']" />
        @endif


        @if ($input['form'] == 'textarea')
            <x-forms.textarea :error="$errors->first($input['name'])" :placeholder="$input['placeholder']" :name="$input['name']" :label="$input['label']" :rows="$input['rows']"
                :cols="$input['cols']">
                {{ $input['value'] }}</x-forms.textarea>
        @endif

        @if ($input['form'] == 'select')
            <x-forms.select-box isForm :defaultValue="$input['value']" :options="$input['options']" :name="$input['name']" :title="$input['label']" />
        @endif
    @endforeach
</div>
