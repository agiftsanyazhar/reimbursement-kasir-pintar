<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reimbursment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Log,
    Storage,
};

class ReimbursmentController extends Controller
{
    private $title;
    private $uploadPath;

    public function __construct()
    {
        $this->title = 'Reimbursment';
        $this->uploadPath = 'uploads/reimbursment/';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = $this->title;

        $data['reimbursment'] = Reimbursment::orderBy('created_at', 'ASC')->get();

        return view('dashboard.reimbursment.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name', 'description', 'status',
        ]);

        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();

        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->validate([
                    'file' => 'mimes:pdf,jpeg,jpg,png|max:1024'
                ]);

                $file = $request->file('file');
                $data['file'] = $file->store($this->uploadPath);
            }

            Reimbursment::insert($data);

            $status = 'success';
            $message = 'Berhasil disimpan.';
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan. Ukuran file terlalu besar atau jenis file tidak valid.';
        }

        return redirect()->back()->with($status, $message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $reimbursment = Reimbursment::findOrFail($request->id);

        $data = $request->only([
            'name', 'description', 'status',
        ]);

        $data['user_id'] = Auth::user()->id;
        $data['updated_at'] = Carbon::now();

        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->validate([
                    'file' => 'mimes:pdf,jpeg,jpg,png|max:1024'
                ]);

                $file = $request->file('file');
                $data['file'] = $file->store($this->uploadPath);
                if ($reimbursment->file) {
                    Storage::delete($reimbursment->file);
                }
            }

            $reimbursment->update($data);

            $status = 'success';
            $message = 'Berhasil disimpan.';
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan. Ukuran file terlalu besar atau jenis file tidak valid.';
        }

        return redirect()->back()->with($status, $message);
    }

    public function approve($id)
    {
        try {
            $reimbursment = Reimbursment::findOrFail($id);
            $reimbursment->status = 'approved';
            $reimbursment->save();

            $status = 'success';
            $message = 'Berhasil disimpan.';
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan.';
        }

        return redirect()->back()->with($status, $message);
    }

    public function reject($id)
    {
        try {
            $reimbursment = Reimbursment::findOrFail($id);
            $reimbursment->status = 'rejected';
            $reimbursment->save();

            $status = 'success';
            $message = 'Berhasil disimpan.';
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan.';
        }

        return redirect()->back()->with($status, $message);
    }
}
