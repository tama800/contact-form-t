<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
</head>

<body>
  <header class="header">
    <h1 class="header__title">FashionablyLate</h1>
    <a href="{{ route('login') }}" class="header__login">login</a>
  </header>

  <main class="main">
    <h2 class="main__title">Admin</h2>

    <div class="filters">
      <input type="text" class="filter__input" placeholder="名前やメールアドレスを入力してください">
      <select name="gender" class="filter__select">
          <option value="">全て</option>
          <option value="男性">男性</option>
          <option value="女性">女性</option>
          <option value="その他">その他</option>
      </select>
      <select class="filter__select"><option>お問い合わせの種類</option></select>
      <select class="filter__select"><option>年月日</option></select>
      <button class="btn search">検索</button>
      <button class="btn reset">リセット</button>
    </div>

    <button class="btn export">エクスポート</button>

    <table class="contact-table">
      <thead>
        <tr>
          <th>お名前</th>
          <th>性別</th>
          <th>メールアドレス</th>
          <th>お問い合わせの種類</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @for ($i = 0; $i < 7; $i++)
        <tr>
          <td>山田 太郎</td>
          <td>男性</td>
          <td>test@example.com</td>
          <td>商品の交換について</td>
          <td><button class="btn detail">詳細</button></td>
        </tr>
        @endfor
      </tbody>
    </table>

    <div class="pagination">
      <button>&lt;</button>
      <button class="active">1</button>
      <button>2</button>
      <button>3</button>
      <button>4</button>
      <button>5</button>
      <button>&gt;</button>
    </div>
  </main>
</body>
</html>
