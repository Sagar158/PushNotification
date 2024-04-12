<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SliderController extends Controller
{
    public $title = 'Slides';
    public function index()
    {
        $this->authorize('viewAny', Slider::class);
        $title = $this->title;
        return view('slider.index',compact('title'));
    }
    public function create()
    {
        $this->authorize('create', Slider::class);
        $title = $this->title;
        $slider = new Slider();
        return view('slider.edit', compact('slider','title'));
    }
    public function edit(Request $request, $sliderId)
    {
        $this->authorize('update', Slider::class);
        $title = $this->title;
        $slider = Slider::findOrFail($sliderId);
        return view('slider.edit', compact('slider','title'));
    }

    public function store(Request $request)
    {

        $this->authorize('create', Slider::class);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slider = new Slider();
        $slider->title = $validatedData['title'];
        $slider->image = Helper::imageUpload($request->file('image'));
        $slider->save();

        return redirect()->route('slider.index')->with('success', 'Slider added successfully.');
    }

    public function update(Request $request, $sliderId)
    {
        $this->authorize('update', Slider::class);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $slider = Slider::findOrFail($sliderId);
        $slider->title = $validatedData['title'];
        if($request->has('image'))
        {
            $slider->image = Helper::imageUpload($request->file('image'));
        }
        $slider->save();

        return redirect()->route('slider.index')->with('success', 'Slider updated successfully.');
    }

    public function getSlidersData()
    {
        $this->authorize('viewAny', Slider::class);
        $query = Slider::query(); // Modify as needed to get your data

        return DataTables::of($query)
            ->editColumn('image', function ($slider) {
                $imageUrl = asset($slider->image);
                return '<img src="'. $imageUrl .'" style="height: 50px; width: 50px; border-radius: 50%;">';
            })
            ->addColumn('action', function ($slider) {
                return '
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <a class="dropdown-item" href="'.route('slider.show', $slider->id).'">Show</a>
                                    <a class="dropdown-item" href="'.route('slider.edit', $slider->id).'">Edit</a>
                                    <a class="dropdown-item delete-record" href="#" data-route="'.route('slider.destroy', $slider->id).'" data-id="'.$slider->id.'">Delete</a>
                                </div>
                            </div>
                        ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function destroy(Request $request, $sliderId)
    {
        $this->authorize('delete', Slider::class);
        $slidesImages = Slider::where('id',$sliderId)->select('image')->pluck('image')->toArray();
        Helper::deleteFiles($slidesImages);

        $record = Slider::destroy($sliderId);
        return response()->json(['success' => $record]);
    }

    public function show(Request $request, $sliderId)
    {
        $this->authorize('viewAny', Slider::class);
        $title = $this->title;

        $slider = Slider::findorFail($sliderId);

        return view('slider.show',compact('slider','title'));
    }

}
