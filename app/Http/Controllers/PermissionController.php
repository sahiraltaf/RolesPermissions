<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Permission;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Auth;
class PermissionController extends Controller
{ 

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    function __construct()

    {

        //  $this->middleware('permission:permission-list|add-permission|edit-permission|delete-permission', ['only' => ['index','show']]);

        //  $this->middleware('permission:add-permission', ['only' => ['create','store']]);

        //  $this->middleware('permission:edit-permission', ['only' => ['edit','update']]);

        //  $this->middleware('permission:delete-permission', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $permissions = Permission::latest()->paginate(5);
        // dd($permissions);
        if(Auth::user()->roles()->pluck('name')[0] === "Super Admin"){
            // dd(Auth::user()->roles()->pluck('name')[0]);
            return view('permissions.index',compact('permissions'))->with('i', (request()->input('page', 1) - 1) * 5);
        }
        else{
             return response()->json(['User have not permission for this page access.']);
        }
        
    }

    

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('permissions.create');

    }

    

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        request()->validate([

            'name' => 'required',

        ]);

    

        // Permission::create($request->all());
        // dd($request->all());
        // DB::table('permissions')->insert($request->all());
        
        $permission = Permission::create(['name' => $request->input('name')]);
        return redirect()->route('permissions.index')->with('success','Permission created successfully.');

    }

    

    /**

     * Display the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function show(Permission $permission)

    {

        return view('permissions.show',compact('permission'));

    }

    

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {
        $permission = Permission::find($id);
        // dd($permission);
        return view('permissions.edit',compact('permission'));

    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Permission $permission)

    {

         request()->validate([

            'name' => 'required',

        ]);

    

        $permission->update($request->all());

    

        return redirect()->route('permissions.index')

                        ->with('success','Permission updated successfully');

    }

    

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy(Permission $permission)

    {

        $permission->delete();
        return redirect()->route('permissions.index')->with('success','Permission deleted successfully');

    }

}
