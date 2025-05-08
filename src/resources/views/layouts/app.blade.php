<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FashionablyLate</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
      <!-- 左側：空白スペース -->
      <div class="header-left"></div>
      <!-- 中央：ロゴ -->
      <div class="header-center">
      <div class="header__logo">
          FashionablyLate
      </div>
      </div>
      <!-- 右側：ボタンとか -->
      <div class="header-right">
      @yield('header-button')
      </div>
      </div>
    </div>
    <div class="header__line"></div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>