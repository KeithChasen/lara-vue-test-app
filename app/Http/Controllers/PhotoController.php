<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPictureRequest;
use App\Services\PictureService;
use Illuminate\Http\Request;
use Gate;

class PhotoController extends Controller
{
    protected $pictureService;

    public function __construct(PictureService $pictureService)
    {
        $this->pictureService = $pictureService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('admin')) {
            return response()->json(['photos' => $this->pictureService->all()], 200);
        }

        return response()->json(['photos' => $this->pictureService->getUserPictures()], 200);
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
    public function store(UploadPictureRequest $request)
    {
        if (!Gate::allows('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return response()->json(
            [
                'photo' => $this->pictureService->store($request->file('photo'))
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        try {
            return response()->json(
                $this->pictureService->show($id),
                200
            );
        } catch (\Exception $e) {
            //todo: log stuff
            return response()->json(['error' => 'Something went wrong'], 500);
        }
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
        if (!Gate::allows('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        try {
            $this->pictureService->update($id, $request->get('ids'));

            return response()->json([], 200);
        } catch (\Exception $e) {
            //todo: log stuff
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
            $this->pictureService->delete($id);

            return response()->json([], 200);
        } catch (\Exception $e) {
            //todo: log stuff
            return response()->json(['error' => 'Something went wrong'], 500);
        }

    }
}
