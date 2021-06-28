<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class CoachController extends Controller
{
   public function index(Request $request){
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('coach.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('coach.create',compact('roles'));
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
            'email' => 'required|email|unique:coach,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $coach = User::create($input);
        $coach->assignRole($request->input('roles'));
    
        return redirect()->route('coach.index')
                        ->with('success','coach created successfully');
    }
    public function show($id)
    {
        $coach = User::find($id);
        return view('coach.show',compact('coach'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coach = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $coachRole = $coach->roles->pluck('name','name')->all();
    
        return view('coach.edit',compact('coach','roles','coachRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:coach,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $coach = User::find($id);
        $coach->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $coach->assignRole($request->input('roles'));
    
        return redirect()->route('coach.index')
                        ->with('success','coach updated successfully');
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('coach.index')
                        ->with('success','coach deleted successfully');
    }
}
