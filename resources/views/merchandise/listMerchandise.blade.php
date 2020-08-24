@extends('layouts.master')
{{-- @section('title', $title) --}}

@section('content')
    <div class="container">
    {{-- <h1>{{ $title }}</h1> --}}

    {{-- @include('components.validationErrorMessage'); --}}

    <style>
        .pictures {
  text-align: center;
  vertical-align: middle;
}
    </style>

    <table class="table">
        <tr>
            <th>名稱</th>
            <th>照片</th>
            <th>價格</th>
            <th>剩餘數量</th>
        </tr>
        @foreach($MerchandisePaginate as $Merchandise)
        <tr>
            <td>
                <a href="/merchandise/{{ $Merchandise->id }}">
                {{ $Merchandise->name }}
            </a>
            </td>
            <td class="pictures">
                <a href="/merchandise/{{ $Merchandise->id }}">

                @if($Merchandise->photo != null)
                    <img src="{{ $Merchandise->photo  }}"/>
                @else
                    <img src="{{ '/assets/images/default-merchandise.png' }}" width="100px"/>
                @endif
                {{-- <img src="{{ $Merchandise->photo or '/assets/images/default-merchandise.png' }}" /> --}}
                {{-- <img src="{{ '/assets/images/default-merchandise.png' }}" width="60px"/> --}}

            </a>
            </td>
            <td>{{ $Merchandise->price }}</td>
            <td>{{ $Merchandise->remain_count }}</td>
        </tr>
        @endforeach
    </table>
    {{-- 分頁頁數按鈕 --}}
    {{ $MerchandisePaginate->links() }}
    </div>
@endsection
