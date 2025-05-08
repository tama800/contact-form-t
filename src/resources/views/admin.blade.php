@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header-button')
@if (Auth::check())
      <form action="/logout" method="POST" >
        @csrf
      <button type="submit" class="header-nav__link logout-button">logout</button>
      </form>
  @endif
@endsection


@section('content')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn.detail').forEach(btn => {
      btn.addEventListener('click', function () {
        const id = this.dataset.id;
        document.getElementById('modal-' + id).style.display = 'flex';
      });
    });

    document.querySelectorAll('.modal-close').forEach(btn => {
      btn.addEventListener('click', function () {
        const id = this.dataset.id;
        document.getElementById('modal-' + id).style.display = 'none';
      });
    });
  });
</script>

<div class="main">
  <h2 class="main__title">Admin</h2>
  <div class="filters">
    <form class="filters__search" action="/admin/search" method="get">
      @csrf
      <input type="text" name="keyword" class="filter__input" value="{{ request('keyword') }}" placeholder="名前やメールアドレスを入力してください">

      <select class="filter__select" name="gender">
        <option value="性別" disabled {{ request('gender') == '性別' || is_null(request('gender')) ? 'selected' : '' }}>性別</option>
        <option value="全て" {{ request('gender') == '全て' ? 'selected' : '' }}>全て</option>
        <option value="男性" {{ request('gender') == '男性' ? 'selected' : '' }}>男性</option>
        <option value="女性" {{ request('gender') == '女性' ? 'selected' : '' }}>女性</option>
        <option value="その他" {{ request('gender') == 'その他' ? 'selected' : '' }}>その他</option>
      </select>

      <select class="filter__select" name="category_id">
        <option value="">お問い合わせの種類</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->content }}
          </option>
        @endforeach
      </select>

      <input type="date" name="from_date" class="filter__select" value="{{ request('from_date') }}">
      <input type="date" name="to_date" class="filter__select" value="{{ request('to_date') }}">

      <button type="submit" class="btn search">検索</button>
      <a href="/admin" class="btn reset">リセット</a>
    </form>
</div>

</div>
<div class="export-pagination-container">
  <form method="GET" action="{{ route('contacts.export') }}" class="export-form">
    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
    <input type="hidden" name="gender" value="{{ request('gender') }}">
    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
    <input type="hidden" name="from_date" value="{{ request('from_date') }}">
    <input type="hidden" name="to_date" value="{{ request('to_date') }}">
    <button type="submit" class="btn export">エクスポート</button>
  </form>

  {{-- ページネーション --}}
  <div class="pagination">
    @if ($contacts->onFirstPage())
      <span>&lt;</span>
      @else
      <a href="{{ $contacts->previousPageUrl() }}">&lt;</a>
    @endif

    @for ($i = 1; $i <= $contacts->lastPage(); $i++)
      @if ($i == $contacts->currentPage())
        <span class="active">{{ $i }}</span>
      @else
        <a href="{{ $contacts->url($i) }}">{{ $i }}</a>
      @endif
    @endfor

    @if ($contacts->hasMorePages())
      <a href="{{ $contacts->nextPageUrl() }}">&gt;</a>
      @else
      <span>&gt;</span>
    @endif
  </div>
</div>

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
      @foreach ($contacts as $contact)
      <tr>
        <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
        <td>
          @if ($contact->gender == 1)
            男性
          @elseif ($contact->gender == 2)
            女性
          @else
            その他
          @endif
        </td>
        <td>{{ $contact->email }}</td>
        <td>{{ $contact->category->content ?? '' }}</td>
        <td><button class="btn detail" data-id="{{ $contact->id }}">詳細</button></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- モーダル --}}
  @foreach ($contacts as $contact)
  <div class="modal" id="modal-{{ $contact->id }}">
    <div class="modal-content">
      <button class="modal-close" data-id="{{ $contact->id }}">×</button>
      <table>
        <tr><th>お名前</th><td>{{ $contact->last_name }}　{{ $contact->first_name }}</td></tr>
        <tr><th>性別</th><td>
          @if ($contact->gender == 1) 男性
          @elseif ($contact->gender == 2) 女性
          @else その他
          @endif
        </td></tr>
        <tr><th>メールアドレス</th><td>{{ $contact->email }}</td></tr>
        <tr><th>電話番号</th><td>{{ $contact->tel }}</td></tr>
        <tr><th>住所</th><td>{{ $contact->address }}</td></tr>
        <tr><th>建物名</th><td>{{ $contact->building }}</td></tr>
        <tr><th>お問い合わせの種類</th><td>{{ $contact->category->content ?? '' }}</td></tr>
        <tr><th>お問い合わせ内容</th><td>{{ $contact->detail }}</td></tr>
      </table>
      <form method="POST" action="{{ route('contacts.destroy', $contact->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn delete">削除</button>
      </form>
    </div>
  </div>
  @endforeach
@endsection
