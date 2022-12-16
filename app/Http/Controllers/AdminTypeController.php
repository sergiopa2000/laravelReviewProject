<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Type;

class AdminTypeController extends Controller
{
    function __construct() {
        $this->middleware('admin');
    }
    
    public function index(){
        $types = Type::all();
        return view('admin.type.index', ['types' => $types]);
    }
    
    public function create()
    {
        return view('admin.type.create');
    }

    
    public function store(Request $request)
    {
        $type = new Type($request->all());
        try{
            $type->save();
            return redirect('admin/type')->with('typeCreated', 'The type was successfully created');
        }catch(\Exception $e){
            return redirect('admin/type')->withErrors(['typeCreateError' => 'An error ocurred creating your type']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        try{
            $type->delete();
            return redirect('admin/type')->with('typeDeleteSuccess', 'The type was successfully deleted');
        }catch(\Exception $e){
            return redirect('admin/type')->withErrors(['typeDeleteError' => 'An error ocurred creating your type']);
        }
    }
}
