<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPictureRequest;
use App\Models\User;
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
    public function store(UploadPictureRequest $request)
    {
        if (!Gate::allows('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $photo = $this->pictureService->store($request->file('photo'));

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
        if (!Gate::allows('admin')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        try {
            $photo = $this->pictureService->find($id);
            $userIds = $this->pictureService->getUserIds($photo);
            $users = User::nonAdmin()->get();

            return response()->json(
                [
                    'photo' => $photo,
                    'users' => $users,
                    'userIds' => $userIds
                ],
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
            $photo = $this->pictureService->find($id);

            $userIds = $this->pictureService->getUserIds($photo);
            $ids = $request->get('ids');

            $detach = array_diff($userIds, $ids);
            $attach = array_diff($ids,$userIds);

            if (!empty($attach))
                $photo->users()->attach($attach);

            if (!empty($detach))
                $photo->users()->detach($detach);

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
