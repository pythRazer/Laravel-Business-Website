@extends('layouts.master')
@section('title', $title)

{{-- @section('title', $title) --}}
@section('content')
    <div class="container">
        {{-- @include('components.validationErrorMessage') --}}
        <table class="table">
            <tr>
                <th>編號</th>
                <th>名稱</th>
                <th>圖片</th>
                <th>狀態</th>
                <th>價格</th>
                <th>剩餘數量</th>
                <th>編輯</th>
                <th>刪除</th>

            </tr>

            @foreach($MerchandisePaginate as $Merchandise)
            <tr>
                <td>{{ $Merchandise->id }}</td>
                <td>{{ $Merchandise->name }}</td>
                <td>

                    {{-- <img src="{{ $Merchandise->photo or '/assets/images/default-merchandise.png' }}"/> --}}
                    @if($Merchandise->photo != null)
                        <img src="{{ $Merchandise->photo  }}"/>
                    @else
                        <img src="{{ '/assets/images/default-merchandise.png' }}" width="100px"/>
                    @endif

                </td>

                <td>
                    @if($Merchandise->status =='C')
                        建立中
                    @else
                        可販售
                    @endif
                </td>
                <td>{{ $Merchandise->price }}</td>
                <td>{{ $Merchandise->remain_count }}</td>
                <td>
                    <a href="/merchandise/{{ $Merchandise->id }}/edit">
                    編輯</a>
                </td>

                <td>
                    <a href="/merchandise/{{$Merchandise->id}}/delete">刪除</a>
                </td>
            </tr>
            @endforeach

        </table>
        {{-- 分頁頁數按鈕 --}}
        {{ $MerchandisePaginate->links() }}
    </div>
@endsection