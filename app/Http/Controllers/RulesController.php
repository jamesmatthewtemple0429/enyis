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
            $attributes = $request->all();
            $attributes['allow_interim'] = ($attributes['allow_interim'] == '0') ? null : $attributes['allow_interim'];

            $rule = AuthRule::create($attributes);

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
            $attributes = $request->all();
            $attributes['allow_interim'] = ($attributes['allow_interim'] == '0') ? null : $attributes['allow_interim'];

            $role->update($attributes);

            return redirect()->route('rules.index')
                ->with([
                    'flash.banner'  => 'The Rule was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Rule $rule)
        {
            $rule->delete();

            return redirect()->route('rules.index')
                ->with([
                    'flash.banner'  => 'The Rule was deleted successfully!'
                ]);
        }
    }
