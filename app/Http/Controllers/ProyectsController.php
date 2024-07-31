<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proyects\StoreRequest;
use App\Http\Requests\Proyects\UpdateRequest;
use App\Models\LikeP;
use App\Models\Proyects;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProyectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myproyects = Proyects::where('user_id', Auth::user()->id)->get();
        return Inertia::render('Proyects/Index', compact('myproyects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Proyects/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only('name', 'description', 'price');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $routeImage = $file->store('imgproyects', ['disk' => 'public']);
            $data['img'] = $routeImage;
        }
        $data['reaction'] = 0;
        $data['user_id'] = Auth::user()->id;
        // Logging para verificar los datos
        Log::info('Data being stored: ', $data);

        Proyects::create($data);

        return to_route('myproyects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyects $proyects)
    {
        $allProyects = Proyects::with('user')->get();
        return Inertia::render('Proyects/Show', compact('allProyects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyects $proyects)
    {
        return Inertia::render('Proyects/Edit', compact('proyects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Proyects $proyects)
    {
        $data = $request->only('name', 'description', 'price');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $routeImage = $file->store('imgproyects', ['disk' => 'public']);
            $data['img'] = $routeImage;

            if ($proyects->img) {
                Storage::disk('public')->delete($proyects->img);
            }
        }

        $data['user_id'] = Auth::user()->id;


        $proyects->update($data);

        return to_route('myproyects.index', $proyects);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyects $proyects)
    {
        if ($proyects->img) {

            Storage::disk('public')->delete($proyects->img);
        }

        $proyects->delete();

        to_route('myproyects.index');
    }

    public function like($id)
    {
        $userId = Auth::id();
        $like = LikeP::where('user_id', $userId)->where('proyect_id', $id)->first();

        if (!$like) {
            LikeP::create([
                'user_id' => $userId,
                'proyect_id' => $id,
            ]);

            $proyect = Proyects::find($id);
            $proyect->reaction++;
            $proyect->save();

            return redirect()->back()->with('message', 'Like added successfully')->with('proyect_id', $id)->with('reaction', $proyect->reaction);
        }

        return redirect()->back()->with('message', 'Ya le diste like a este proyecto')->with('proyect_id', $id);
    }
}
