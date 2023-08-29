<?php namespace App\Http\Controllers;
    use App\Models\AuthRule;
    use App\Models\Interim;
    use App\Models\Role;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;

    class RulesController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $rules = AuthRule::all();

            return Inertia::render("Rules/Index",[
                'rules' => $rules
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("Rules/Create",[
                'members'   => Member::all(),
                'roles' => Role::all()
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $rule = AuthRule::create($request->all());

            return redirect()->route('rules.index')
                ->with([
                    'flash.banner'  => 'The Rule was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Role $role)
        {
            return Inertia::render("Roles/Edit",[
                'role'  => $role
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Role $role)
        {
            $role->update([
                'name'          => $request->name,
                'description'   => $request->description,
                'is_admin'      => $request->is_admin
            ]);



            return redirect()->route('roles.index')
                ->with([
                    'flash.banner'  => 'The Role was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Role $role)
        {
            $role->delete();

            return redirect()->route('roles.index')
                ->with([
                    'flash.banner'  => 'The Role was deleted successfully!'
                ]);
        }
    }
