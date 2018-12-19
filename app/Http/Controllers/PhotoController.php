<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Gate;
use Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('admin')) {
            return response()->json(['photos' => Picture::all()], 200);
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $this->validate($request, [
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:1024'
        ]);

        $file = $request->file('photo');
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize();

        $fileName = time().'.'. $ext;

        $path = $file->storeAs('photos', $fileName, 'public');

        $photo = Picture::create([
            'path' => $path,
            'size' => $size,
            'extension' => $ext,
        ]);


        return response()->json(['photo' => $photo],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        try {
            $file = Picture::findOrFail($id);

            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
                $file->delete();
            }

            return response()->json([], 200);
        } catch (\Exception $e) {
            //todo: log stuff
            return response()->json(['error' => 'Something went wrong'], 500);
        }

    }
}
