<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public $title = 'FAQ';
    public function index()
    {
        $this->authorize('viewAny',Faq::class);
        $title = $this->title;
        return view('faqs.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = $this->title;
        $this->authorize('create',Faq::class);
        $faq = new Faq;
        return view('faqs.edit', compact('title','faq'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Faq::class);
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'description' => 'nullable|string'
        ]);

        $faq = Faq::create($validatedData);

        return redirect()->route('faq.index')->with('success','Faq added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $healthCare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($faqId)
    {
        $this->authorize('update',Faq::class);
        $title = $this->title;
        $faq = Faq::findOrFail($faqId);

        return view('faqs.edit', compact('title','faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $faqId)
    {
        $this->authorize('update',Faq::class);
        $faq = Faq::findOrFail($faqId);

        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'description' => 'string'
        ]);

        $faq->question = $validatedData['question'];
        $faq->description = $validatedData['description'];
        $faq->save();
        return redirect()->route('faq.index')->with('success','Faq updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($faqId)
    {
        $this->authorize('delete',Faq::class);
        $record = Faq::destroy($faqId);
        return response()->json(['success' => $record]);

    }

    public function getFaqData()
    {
        $this->authorize('viewAny',Faq::class);

        $query = Faq::query();

        return DataTables::of($query)
            ->addColumn('action', function ($faq) {
                return '
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <a class="dropdown-item" href="'.route('faq.edit', $faq->id).'">Edit</a>
                                    <a class="dropdown-item delete-record" href="#" data-route="'.route('faq.destroy', $faq->id).'" data-id="'.$faq->id.'">Delete</a>
                                </div>
                            </div>
                        ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
