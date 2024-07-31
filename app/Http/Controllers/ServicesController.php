<?php

namespace App\Http\Controllers;

use App\Http\Requests\Services\StoreRequest;
use App\Http\Requests\Services\UpdateServicesRequest;
use App\Models\LikeS;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myservices = Services::where('user_id', Auth::user()->id)->get();
        return Inertia::render('Services/Index',compact('myservices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Services/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only('name', 'description', 'phone');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $routeImage = $file->store('imgservices', ['disk' => 'public']);
            $data['img'] = $routeImage;
        }
        $data['reaction'] = 0;
        $data['user_id'] = Auth::user()->id;
        // Logging para verificar los datos
        
        Services::create($data);

        return to_route('myservices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Services $services)
    {
        $allServices = Services::with('user')->get();
        return Inertia::render('Services/Show', compact('allServices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $services)
    {
        return Inertia::render('Services/Edit', compact('services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Services $services)
    {
        $data = $request->only('name', 'description', 'phone');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $routeImage = $file->store('imgservices', ['disk' => 'public']);
            $data['img'] = $routeImage;
            if ($services->img) {
                Storage::disk('public')->delete($services->img);
            }
        }
        
        $data['user_id'] = Auth::user()->id;
        // Logging para verificar los datos
        
        $services->update($data);

        return to_route('myservices.index',$services);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $services)
    {
        if ($services->img) {

            Storage::disk('public')->delete($services->img);
        }

        $services->delete();

        to_route('myservices.index');
    }

    public function like($id)
    {
        $userId = Auth::id();
        $like = LikeS::where('user_id', $userId)->where('service_id', $id)->first();

        if (!$like) {
            LikeS::create([
                'user_id' => $userId,
                'service_id' => $id,
            ]);

            $services = Services::find($id);
            $services->reaction++;
            $services->save();

            return redirect()->back()->with('message', 'Like added successfully')->with('service_id', $id)->with('reaction', $services->reaction);
        }

        return redirect()->back()->with('message', 'Ya le diste like a este proyecto')->with('service_id', $id);
    }
}
