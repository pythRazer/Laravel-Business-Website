

<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') - Shop Laravel - Admin</title>
</head>
<body>


    <ul class="nav">
        {{-- <li class="nav-item">
          <a class="nav-link active" href="/merchandise/manage">
            管理商品</a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link" href="/merchandise">
            商品列表</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="/merchandise/create">
            新增商品</a>
        </li> --}}

        {{-- @section('content')

        $user_id = Auth::id();
        $User = User::findOrFail($user_id);
        @endsection --}}



        @if(Auth::check() && Auth::user()->type == 'A')

        <li class="nav-item">
            <a class="nav-link" href="/merchandise/create">
                新增商品</a>
        </li>

        <li class="nav-item">
            <a class="nav-link active" href="/merchandise/manage">
              管理商品</a>
          </li>
        @elseif(Auth::check() && Auth::user()->type == 'G')
        <li class="nav-item">
            <a class="nav-link" href="/transaction">
                查詢訂單</a>
        </li>

        @endif



        <li class="nav-item">
            <a class="nav-link active" href="/home">帳號</a>

      </ul>



    <div class="container">
        @yield('content')
    </div>


</body>
</html>
