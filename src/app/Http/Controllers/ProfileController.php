<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        $user->update($request->only(['name', 'zipcode', 'address', 'building',]));

        return redirect()->route('profile.show')->with('success', 'プロフィールを更新しました。');
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->setup_completed) {
            return redirect()->route('items.index');
        }

        return view('profile.create', compact('user'));
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        } 
        
        $user->fill($request->only(['name', 'zipcode', 'address', 'building']));
        $user->setup_completed = true;
        $user->save();

        return redirect()->route('items.index')->with('success', 'プロフィールが登録されました。');
    }
}
