<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Hash,
    Log,
};

class UserController extends Controller
{
    private $title;

    public function __construct()
    {
        $this->title = 'User';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = $this->title;

        $data['user'] = User::get();

        return view('dashboard.user.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name', 'nip', 'position', 'password'
        ]);

        try {
            $request->validate([
                'name' => 'required|string',
                'nip' => 'required|integer|unique:users',
                'position' => 'required',
                'password' => 'required|string',
            ]);

            User::create($data);
            event(new Registered($data));

            $status = 'success';
            $message = 'Berhasil disimpan. Silakan login.';
        } catch (\Exception  $e) {
            Log::error($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan. ' . $e->getMessage();
        }
        return redirect()->back()->with($status, $message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $data = $request->only([
            'name', 'nip', 'position', 'password'
        ]);

        $data['password'] = Hash::make($data['password']);

        try {
            $request->validate([
                'name' => 'required|string',
                'nip' => 'required|integer|unique:users',
                'position' => 'required',
                'password' => 'required|string',
            ]);

            $user->update($data);

            $status = 'success';
            $message = 'Berhasil disimpan.';
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan. Ukuran file terlalu besar atau jenis file tidak valid.';
        }

        return redirect()->back()->with($status, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            $status = 'success';
            $message = 'Berhasil dihapus.';
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $status = 'danger';
            $message = 'Gagal dihapus.' . $e->getMessage();
        }

        return redirect()->back()->with($status, $message);
    }
}
