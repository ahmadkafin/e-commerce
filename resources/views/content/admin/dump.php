@foreach ($datas as $data)
<tr class="data-produk">
    <td>
        <input type="checkbox" value="{{$data->id}}" class="chckall" name="products[]">
    </td>
    @php
    $image = empty($data->image->image_name) ? 'default.png' :
    'products/'.$data->image->image_name;
    @endphp
    <td class="text-center">
        <img src="{{asset('img/'. $image)}}" alt="image" class="img-fluid" width="50">
    </td>
    <td>{{$data->sku}}</td>
    <td>{{$data->nama}}</td>
    <td width="15%" class="harga" data-harga="{{$data->harga}}">Rp.
        {{number_format($data->harga, 0)}}
    </td>
    <td width="10%">
        <input type="number" data-harga="{{$data->harga}}" class="form-control diskon" name="diskon[]">
    </td>
    <td width="20%">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Rp.</span>
            </div>
            <input type="number" class="form-control harga-hasil" value="0" readonly>
        </div>
    </td>
</tr>
@endforeach