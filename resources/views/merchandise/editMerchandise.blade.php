



@extends('layouts.master')
{{--
@section('title', $title) --}}

@section('content')
    <div class="container">
        {{-- <h1>{{ $title }}</h1> --}}
        {{-- @include('components.validationErrorMessage') --}}
        <form action="/merchandise/{{ $Merchandise->id }}"
            method="post"
            enctype="multipart/form-data"
            >

            {{-- 隱藏方法欄位 --}}
            {{ method_field('PUT') }}
            <label>
                商品狀態：
                <select name="status">
                    <option value="C" @if(old('status', $Merchandise->status)=='C') selected @endif>
                        建立中
                    </option>
                    <option value="S" @if(old('status', $Merchandise->status)=='S') selected @endif>
                        可販售
                    </option>

                </select>
            </label>

            <label>
                商品名稱：
                <input type="text"
                        name="name"
                        placeholder="商品名稱"
                        value="{{ old('name', $Merchandise->name) }}">
            </label>

            <label>
                商品英文名稱：
                <input type="text"
                        name="name_en"
                        placeholder="商品英文名稱"
                        value="{{ old('name_en', $Merchandise->name_en) }}">
            </label>

            <label>
                商品介紹：
                <input type="text"
                        name="introduction"
                        placeholder="商品介紹"
                        value="{{ old('introduction', $Merchandise->introduction) }}">
            </label>

            <label>
                商品介紹：
                <input type="text"
                        name="introduction_en"
                        placeholder="商品英文介紹"
                        value="{{ old('introduction_en', $Merchandise->introduction_en) }}">
            </label>

            <label>
                商品照片：
                <input type="file" name="photo" placeholder="商品照片">
                @if($Merchandise->photo != null)
                        <img src="{{ $Merchandise->photo  }}"/>
                @else
                    <img src="{{ '/assets/images/default-merchandise.png' }}" width="100px"/>
                @endif
{{--
                <img src="{{ $Merchandise->photo }}"/> --}}
                {{-- <img src="{{ $Merchandise->photo or '/assets/images/default-merchandise.png'}}"/> --}}
                {{-- <img src="{{ '/assets/images/default-merchandise.png' }}" width="80px"/> --}}
            </label>

            <label>
                商品價格：
                <input type="text" name="price" placeholder="商品價格" value="{{ old('price', $Merchandise->price) }}">


            </label>
            <label>
                商品剩餘數量：
                <input type="text"
                        name="remain_count"
                        placeholder="商品剩餘數量"
                        value="{{ old('remain_count', $Merchandise->remain_count) }}">

            </label>

            <button type="submit" class="btn btn-default">更新商品資訊</button>
            {{ csrf_field() }}

            <input type="hidden" name="_method" value="PUT">

        </form>


    </div>


@endsection
