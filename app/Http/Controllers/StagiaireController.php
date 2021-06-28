<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class StagiaireController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request){
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('stagiaire.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    public function create()
    {
        // $roles = Role::pluck('name','name')->all();
        return view('stagiaire.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:stagiaire,email',
            'password' => 'required|same:confirm-password',
        ]);
    
        
        // $input = $request->all();
        // $input['password'] = Hash::make($input['password']); 

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'role' => "stagiaire",
            'password' => Hash::make($request['password']),
        ]);
    
        // $stagiaire = User::create($input);
        // $stagiaire->assignRole($request->input('roles'));
    
        return redirect()->view('stagiaire.index')
                        ->with('success','Stagiaire created successfully');
    }
    public function show($id)
    {
        $stagiaire = User::find($id);
        return view('stagiaire.show',compact('stagiaire'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stagiaire = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $stagiaireRole = $stagiaire->roles->pluck('name','name')->all();
    
        return view('stagiaire.edit',compact('stagiaire','roles','stagiaireRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:stagiaire,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $stagiaire = User::find($id);
        $stagiaire->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $stagiaire->assignRole($request->input('roles'));
    
        return redirect()->route('stagiaire.index')
                        ->with('success','stagiaire updated successfully');
    }
    
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('stagiaire.index')
                        ->with('success','stagiaire deleted successfully');
    }
}
