<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{

    public function index()
    {
        return Blog::all();
    }

    public function store(StoreBlogRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = 1;
        $data['deleted_at'] = null;

        Blog::create($data);

        return response()->json([
            'S'=>'T',
            'message' => 'Yeni blog kaydı oluşturuldu.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
