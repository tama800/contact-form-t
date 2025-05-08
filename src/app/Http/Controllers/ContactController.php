<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Contact;
use App\Models\Category;


class ContactController extends Controller
{
    public function index()
        {
            return view('index');
        }

    public function confirm(ContactRequest $request)
        {

            $telParts = explode('-', $request->tel);
    $request->merge([
        'tel1' => $telParts[0] ?? '',
        'tel2' => $telParts[1] ?? '',
        'tel3' => $telParts[2] ?? '',
    ]);
          $contact=$request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail'
        ]);
          return view('confirm', compact('contact'));
        }
    
    public function store(ContactRequest $request)
        {
          $contact=$request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail'
        ]);
          Contact::create($contact);
          return view('thanks');
        }

        public function thanks()
        {
            return view('thanks');
        }

        public function admin()
        {
          $categories = Category::all(); // ← カテゴリ全部取ってくる！
          $contacts = Contact::with('category')->paginate(7)->withQueryString(); // ← contacts全部取る！
            
          return view('admin', compact('categories', 'contacts'));
        }

        public function search(Request $request)
        {
            $query = Contact::query();

    // キーワード検索（フルネーム or メール）
    if (!empty($request->keyword)) {
    $keyword = $request->keyword;
    $concatKeyword = str_replace([' ', '　'], '', $keyword); // 半角・全角スペース除去

    $query->where(function ($q) use ($keyword, $concatKeyword) {
        $q->whereRaw("REPLACE(CONCAT(last_name, first_name), ' ', '') LIKE ?", ['%' . $concatKeyword . '%'])
          ->orWhere('last_name', 'like', '%' . $keyword . '%')
          ->orWhere('first_name', 'like', '%' . $keyword . '%')
          ->orWhere('email', 'like', '%' . $keyword . '%');
    });
}

    // 性別検索（外に出す！）
    if (!empty($request->gender) && $request->gender !== '全て' && $request->gender !== '性別') {
    if ($request->gender === '男性') {
        $query->where('gender', 1);
    } elseif ($request->gender === '女性') {
        $query->where('gender', 2);
    } elseif ($request->gender === 'その他') {
        $query->where('gender', 3);
    }
}

    // カテゴリ検索
    if (!empty($request->category_id)) {
        $query->where('category_id', $request->category_id);
    }

    // 日付検索
    if (!empty($request->from_date) && !empty($request->to_date)) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    // データ取得
    $contacts = $query->with('category')->paginate(7)->withQueryString();
    $categories = Category::all();

    return view('admin', compact('contacts', 'categories'));
        }

    public function destroy($id)
{
    Contact::findOrFail($id)->delete();
    return redirect('/admin')->with('message', '削除しました');
}

public function export(Request $request): StreamedResponse
{
    $query = Contact::with('category');

    // 検索条件と同様の絞り込み処理
    if (!empty($request->keyword)) {
        $keyword = $request->keyword;
        $concatKeyword = str_replace([' ', '　'], '', $keyword);
        $query->where(function ($q) use ($keyword, $concatKeyword) {
            $q->whereRaw("REPLACE(CONCAT(last_name, first_name), ' ', '') LIKE ?", ['%' . $concatKeyword . '%'])
              ->orWhere('last_name', 'like', '%' . $keyword . '%')
              ->orWhere('first_name', 'like', '%' . $keyword . '%')
              ->orWhere('email', 'like', '%' . $keyword . '%');
        });
    }

    if (!empty($request->gender) && $request->gender !== '全て' && $request->gender !== '性別') {
        $gender = ['男性' => 1, '女性' => 2, 'その他' => 3][$request->gender] ?? null;
        if ($gender) {
            $query->where('gender', $gender);
        }
    }

    if (!empty($request->category_id)) {
        $query->where('category_id', $request->category_id);
    }

    if (!empty($request->from_date) && !empty($request->to_date)) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    $contacts = $query->get();

    $response = new StreamedResponse(function () use ($contacts) {
        $handle = fopen('php://output', 'w');

        // ヘッダー行
        fputcsv($handle, [
            'お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容', '登録日時'
        ]);

        // データ行
        foreach ($contacts as $contact) {
            fputcsv($handle, [
                $contact->last_name . ' ' . $contact->first_name,
                ['男性', '女性', 'その他'][$contact->gender - 1] ?? '不明',
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content ?? '',
                $contact->detail,
                $contact->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
    });

    $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
    $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
    $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);

    return $response;
}


}

