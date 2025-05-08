@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
  <main>
    <div class="confirm__content">
      <div class="confirm__heading">
        <h2>Confirm</h2>
      </div>
      <form class="form" action="/contacts" method="post">
        @csrf
        <div class="confirm-table">
          <table class="confirm-table__inner">
            <tr class="confirm-table__row">
              <th class="confirm-table__header">お名前</th>
              <td class="confirm-table__text">
                <div class="name-input-group">
                <input type="text" name="last_name" value="{{ $contact['last_name']}}" readonly/>
                <input type="text" name="first_name" value="{{ $contact['first_name']}}" readonly />
                </div>
              </td>
            </tr>
            <tr class="confirm-table__row">
              <th class="confirm-table__header">性別</th>
              <td class="confirm-table__text">
                @php
                $genderText = [1 => '男性', 2 => '女性', 3 => 'その他'];
                @endphp
                {{ $genderText[$contact['gender']] }}
                <input type="hidden" name="gender" value="{{ $contact['gender'] }}" />
              </td>
            </tr>
            <tr class="confirm-table__row">
              <th class="confirm-table__header">メールアドレス</th>
              <td class="confirm-table__text">
                <input type="text" name="email" value="{{ $contact['email']}}" />
              </td>
            </tr>
            <tr class="confirm-table__row">
              <th class="confirm-table__header">電話番号</th>
              <td class="confirm-table__text">
                <input type="text" name="tel" value="{{ $contact['tel']}}" readonly/>
              </td>
            </tr>
            <tr class="confirm-table__row">
              <th class="confirm-table__header">住所</th>
              <td class="confirm-table__text">
                <input type="text" name="address" value="{{ $contact['address']}}" readonly/>
              </td>
            </tr>
            <tr class="confirm-table__row">
              <th class="confirm-table__header">建物名</th>
              <td class="confirm-table__text">
                <input type="text" name="building" value="{{ $contact['building'] }}" readonly/>
              </td>
            </tr>
            <tr class="confirm-table__row">
              <th class="confirm-table__header">お問い合わせの種類</th>
              <td class="confirm-table__text">
                @php
                  $categoryLabel = [
                  '1' => '商品のお届けについて',
                  '2' => '商品の交換について',
                  '3' => '商品トラブル',
                  '4' => 'ショップへのお問い合わせ',
                  '5' => 'その他'
                  ];
                @endphp
                {{ $categoryLabel[$contact['category_id']] }}
                <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
              </td>
            </tr>
            <tr class="confirm-table__row">
              <th class="confirm-table__header">お問い合わせ内容</th>
              <td class="confirm-table__text">
                <input type="text" name="detail" value="{{ $contact['detail']}}" readonly/>
              </td>
            </tr>
          </table>
        </div>
        <div class="form__button">
          <button class="form__button-submit" type="submit">送信</button>
          <button type="button" class="form__button-link" onclick="history.back()">修正</button>
        </div>
      </form>
    </div>
  </main>
</body>

</html>
@endsection