<?php namespace App\Http\Controllers;
    use App\Models\Interim;
    use App\Models\Permission;
    use App\Models\Role;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use App\Models\Member;
    use Carbon\Carbon;

    class RolesController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $roles = Role::all();

            return Inertia::render("Roles/Index",[
                'roles' => $roles
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("Roles/Create",[
                'members'   => Member::all(),
                'permissionChunks' => Permission::all()->groupBy('scope')->chunk(3)
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $role = Role::create([
                'name'          => $request->name,
                'description'   => $request->description,
                'is_admin'      => $request->is_admin
            ]);

            $role->permissions()->sync($request->permissions);

            return redirect()->route('roles.index')
                ->with([
                    'flash.banner'  => 'The Role was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Role $role)
        {
            return Inertia::render("Roles/Edit",[
                'role'  => $role,
                'permissionChunks' => Permission::all()->groupBy('scope')->chunk(3)

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

            $role->permissions()->sync($request->permissions);

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
