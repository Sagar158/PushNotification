<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    public $title = 'Announcement';
    public function index()
    {
        $title = $this->title;
        $this->authorize('viewAny', Announcement::class);
        return view('announcement.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = $this->title;
        $this->authorize('create', Announcement::class);
        $announcement = new Announcement();
        return view('announcement.edit', compact('announcement','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Announcement::class);
        $validatedData = $request->validate([
            'title' => [
                'required',
                'string'
            ],
            'description' => 'string'
        ]);
        DB::beginTransaction();
        try{
                $trafficPost = new Announcement();
                $trafficPost->title = $validatedData['title'];
                $trafficPost->description = $validatedData['description'];
                $trafficPost->created_by = auth()->user()->id;
                if($request->has('image'))
                {
                    $trafficPost->image = Helper::imageUpload($request->file('image'));
                }
                $trafficPost->save();
                DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            throw new \Exception("Error occurred: " . $e->getMessage());
        }
        return redirect()->route('announcement.index')->with('success', 'Traffic Posts added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        $this->authorize('viewAny', Announcement::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($announcementId)
    {
        $this->authorize('update', Announcement::class);
        $title = $this->title;
        $trafficPost = Announcement::findOrFail($announcementId);
        return view('trafficpost.edit', compact('trafficPost','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $announcementId)
    {
        $this->authorize('update', Announcement::class);
        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
            ],
            'description' => 'string'
        ]);
        DB::beginTransaction();
        try
        {
            $trafficPost = Announcement::findOrFail($announcementId);
            $trafficPost->title = $validatedData['title'];
            $trafficPost->description = $validatedData['description'];
            $trafficPost->created_by = auth()->user()->id;
            if($request->has('image'))
            {
                $trafficPost->image = Helper::imageUpload($request->file('image'));
            }
            $trafficPost->save();

            DB::commit();

        }
        catch(\Exception $e)
        {
            DB::rollback();
            throw new \Exception("Error occurred: " . $e->getMessage());
        }
        return redirect()->route('announcement.index')->with('success', 'Traffic Posts updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($announcementId)
    {
        $this->authorize('delete', Announcement::class);
        $record = Announcement::destroy($announcementId);
        return response()->json(['success' => $record]);
    }
    public function getAnnouncementData()
    {
        $query = Announcement::query();

        return DataTables::of($query)
            ->editColumn('image',function($announcement){
                return '<img src="'.asset($announcement->image).'">';
            })
            ->addColumn('action', function ($announcement) {
                return '
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <a class="dropdown-item" href="'.route('announcement.edit', $announcement->id).'">Edit</a>
                                    <a class="dropdown-item delete-record" href="#" data-route="'.route('announcement.destroy', $announcement->id).'" data-id="'.$announcement->id.'">Delete</a>
                                </div>
                            </div>
                        ';
            })
            ->rawColumns(['action','image'])
            ->make(true);

    }
}
