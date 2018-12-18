<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('admin')) {
            return response()->json(['users' => User::with('role')->get()], 200);
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
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        if (Gate::allows('admin')) {
            try {
                $user = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password')),
                    'role_id' => Role::where('role', Role::USER_ROLE)->first()->id
                ]);

                return response()->json(['user' => $user], 200);
            } catch (\Exception $e) {
                //todo: log stuff
                return response()->json(['error' => 'Something went wrong'], 500);
            }
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::allows('admin')) {
            return response()->json(['user' => User::findOrFail($id)], 200);
        }

        return response()->json(['error' => 'Forbidden'], 403);
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
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if (Gate::allows('admin')) {
            try {
                $user = User::findOrFail($id);
                $user->name = $request->get('name');
                $user->email = $request->get('email');
                if ($request->get('password')) {
                    $user->password = bcrypt($request->get('password'));
                }
                $user->update();

                return response()->json(['user' => $user], 200);
            } catch (\Exception $e) {
                //todo: log stuff
                return response()->json(['error' => 'Something went wrong'], 500);
            }


        }

        return response()->json(['error' => 'Forbidden'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('admin')) {
            try {
                $user = User::findOrFail($id);
                $user->delete();

                return response()->json([], 200);
            } catch (\Exception $e) {
                //todo: log stuff
                return response()->json(['error' => 'Something went wrong'], 500);
            }
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }
}
