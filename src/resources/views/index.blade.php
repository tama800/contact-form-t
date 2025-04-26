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
    <div class="header__inner">
      <a class="header__logo" href="/">
        Contact Form
      </a>
    </div>
  </header>


  <main>
    <div class="contact-form__content">
      <div class="contact-form__heading">
        <h2>Contact</h2>
      </div>
      <form class="form" action="/confirm" method="post">
        @csrf
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">お名前</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--textname">
              <input type="text" name="last_name" placeholder="例:山田" value="{{ old('last_name')}}"/>
              <input type="text" name="first_name" placeholder="例:太郎" value="{{ old('first_name')}}"/>
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
              <!-- 姓のエラー -->
              @error('last_name')
                {{ $message }}
              @enderror
              <!-- 名のエラー -->
              @error('first_name')
                {{ $message }}
              @enderror 
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">性別</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--radio">
              <label><input type="radio" name="gender" value="1" checked />男性</label>
              <label><input type="radio" name="gender" value="2" />女性</label>
              <label><input type="radio" name="gender" value="3" />その他</label>
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
              @error('gender')
                {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">メールアドレス</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="email" name="email" placeholder="test@example.com" value="{{ old('email')}}"/>
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
              @error('email')
                {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">電話番号</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
              <div class="form__input--tel">
  <input type="tel" id="tel1" maxlength="5" placeholder="080" value="{{ old('tel1')}}">
  -
  <input type="tel" id="tel2" maxlength="5" placeholder="1234" value="{{ old('tel2')}}">
  -
  <input type="tel" id="tel3" maxlength="5" placeholder="5678" value="{{ old('tel3')}}">

<!-- ここに結合結果を入れて送信する -->
<input type="hidden" name="tel" id="tel">

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const tel1 = document.getElementById('tel1');
    const tel2 = document.getElementById('tel2');
    const tel3 = document.getElementById('tel3');
    const tel = document.getElementById('tel');

    form.addEventListener('submit', function () {
      tel.value = `${tel1.value}-${tel2.value}-${tel3.value}`;
    });
  });
</script>
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
             @error('tel')
                {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">住所</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address')}}"/>
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
              @error('address')
                {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">建物名</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building')}}" />
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">お問い合わせの種類</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--select">
              <select name="category_id" id="category_id" value="{{ old('category_id')}}">
                <option value="">選択してください  ▼</option>
                <option value="1">商品のお届けについて</option>
                <option value="2">商品の交換について</option>
                <option value="3">商品トラブル</option>
                <option value="4">ショップへのお問い合わせ</option>
                <option value="5">その他</option>
              </select>
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
              @error('category_id')
                {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">お問い合わせ内容</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--textarea">
              <textarea name="detail" placeholder="お問い合わせ内容をご記載ください"> {{ old('detail')}}</textarea>
            </div>
            <div class="form__error">
              <!--バリデーション機能を実装したら記述します。-->
              @error('name')
                {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__button">
          <button class="form__button-submit" type="submit">確認画面</button>
        </div>
      </form>
    </div>
  </main>
</body>

</html>