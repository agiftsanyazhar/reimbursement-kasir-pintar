<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reimbursment;
use Illuminate\Support\Facades\{
    Request,
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

        $data['edit'] = false;

        return view('admin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reimbursment $reimbursment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Reimbursment $request, Reimbursment $reimbursment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reimbursment $reimbursment)
    {
        //
    }
}
