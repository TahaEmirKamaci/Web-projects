<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;

class RecordController extends Controller
{
    public function index(Request $request)
    {

        $records = Record::all();

        $page = $request->input('page', 1);
        $records = Record::whereNull('Date_exit')->get();
        $all_records = Record::orderBy('Date', 'desc')->paginate(10); // Her sayfada 5 kayıt göster

        return view('welcome', [
            'page' => $page,
            'records' => $records,
            'all_records' => $all_records,
            'total_pages' => $all_records->lastPage()
        ]);
    }



    public function showForm()
    {
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max: 8192',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'appointment' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'who' => 'required|string|max:255',
        ]);

        // Yeni kayıt ekleme işlemleri
        $record = new Record;
        $record->name = $request->name;
        $record->surname = $request->surname;
        $record->appointment = $request->appointment;
        $record->purpose = $request->purpose;
        $record->who = $request->who;
        $record->Date = now();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads', $filename);

            $record->image = 'storage/uploads/' . $filename;
        }

        $record->save();

        return redirect()->back()->with('success', 'Kayıt başarılı bir şekilde eklendi.');
    }

    public function checkout(Request $request)
    {
        $record = Record::find($request->record_id);
        if ($record) {
            // Eğer çıkış yapılmamışsa çıkış yap
            if ($record->Date_exit === null) {
                $record->Date_exit = now();
                $record->save();

                return redirect()->back()->with('success', 'Çıkış başarılı.');
            } else {
                // Çıkış yapılmışsa uygun bir hata mesajı göster
                return redirect()->back()->withErrors('Bu kayıt için zaten çıkış yapılmış.');
            }
        } else {
            // Kayıt bulunamazsa uygun bir hata mesajı göster
            return redirect()->back()->withErrors('Çıkış yapılacak kayıt bulunamadı.');
        }
    }

    public function record(Request $request)
    {
        $records = Record::all();

        $page = $request->input('page', 1);
        $records = Record::whereNull('Date_exit')->get();
        $all_records = Record::orderBy('Date', 'desc')->paginate(10); // Her sayfada 5 kayıt göster

        return view('record', [
            'page' => $page,
            'records' => $records,
            'all_records' => $all_records,
            'total_pages' => $all_records->lastPage()
        ]);
    }
    public function dashboard()
    {
        // Dashboard görünümünü döndürün
        return view('dashboard'); // 'dashboard' adında bir Blade görünüm dosyasına yönlendirme
    }
}
