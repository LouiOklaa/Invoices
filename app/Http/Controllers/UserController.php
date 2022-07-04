<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:قائمة المستخدمين|اضافة مستخدم|تعديل مستخدم|حذف مستخدم|عرض معلومات مستخدم', ['only' => ['index']]);
        $this->middleware('permission:اضافة مستخدم', ['only' => ['create','store']]);
        $this->middleware('permission:عرض معلومات مستخدم', ['only' => ['show']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id')->paginate(5);
        return view('users.show_users',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.add',compact('roles'));
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required'

        ],[

            'name.required' => 'يرجى ادخال اسم المستخدم',
            'email.required' => 'يرجى ادخال البريد الالكتروني',
            'email.email' => 'البريد الالكتروني يجب ان يكون من الشكل : exampel@exampel.com',
            'email.unique' => 'البريد الالكتروني موجود مسبقا',
            'password.required' =>'يرجى ادخال كلمة المرور',
            'password.same' =>'كلمات المرور غير متطابقين',
            'roles_name.required' =>'يرجى اختيار صلاحية واحدة ع الاقل',

        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));

        session()->flash('Add','تم اضافة المستخدم بنجاح');
        return redirect()->route('users.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
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
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required'

        ],[

            'name.required' => 'يرجى ادخال اسم المستخدم',
            'email.required' => 'يرجى ادخال البريد الالكتروني',
            'email.email' => 'البريد الالكتروني يجب ان يكون من الشكل : exampel@exampel.com',
            'email.unique' => 'البريد الالكتروني موجود مسبقا',
            'password.required' =>'يرجى ادخال كلمة المرور',
            'password.same' =>'كلمات المرور غير متطابقين',
            'roles_name.required' =>'يرجى اختيار صلاحية واحدة ع الاقل',

        ]);

        $input = $request->all();
        if(!empty($input['password'])){

            $input['password'] = Hash::make($input['password']);

        }
        else{

            $input = array_except($input,array('password'));

        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles_name'));

        session()->flash('Edit','تم تعديل المستخدم بنجاح');
        return redirect()->route('users.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::find($request->user_id)->delete();

        session()->flash('Delete','تم حذف المستخدم بنجاح');
        return redirect()->route('users.index');
    }

    public function profile (){

        return view('users.profile');

    }
}
