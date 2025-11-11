<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserAdminController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->boolean('fragment')) {
            return view('admin.users._table');
        }

        // opcional: una vista completa si algún día la usas
        return view('admin.users.index');
    }

    public function data()
    {
        $users = User::query()
            ->select(['id','name','email','role','created_at','updated_at'])
            ->orderByDesc('created_at')
            ->get();

        $data = $users->map(function ($u) {
            return [
                'id'      => $u->id,
                'name'    => $u->name,
                'email'   => $u->email,
                'role'    => $u->role ?? '—',
                'created' => $u->created_at?->format('Y-m-d H:i'),
                'updated' => $u->updated_at?->format('Y-m-d H:i'),
            ];
        });

        return response()->json(['data' => $data]);
    }
}
