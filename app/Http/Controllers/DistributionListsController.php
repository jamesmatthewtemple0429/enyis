<?php namespace App\Http\Controllers;
    use App\Models\DistributionList;
    use App\Models\Interim;
    use App\Models\Report;
    use App\Models\Subscription;
    use App\Models\SystemIssue;
    use Illuminate\Http\Request;
    use Inertia\Inertia;

    class DistributionListsController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $roles = DistributionList::with('report')->get();

            return Inertia::render("DistributionLists/Index",[
                'roles' => $roles
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return Inertia::render("DistributionLists/Create",[
                'reports' => Report::all()
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            DistributionList::create($request->all());

            return redirect()->route('distributionlists.index')
                ->with([
                    'flash.banner'  => 'The Distribution List was created successfully!'
                ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(DistributionList $distributionlist)
        {
            return Inertia::render("DistributionLists/Edit",[
                'list' => $distributionlist,
                'reports' => Report::all()
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, DistributionList $distributionlist)
        {
            $distributionlist->update($request->all());

            return redirect()->route('distributionlists.index')
                ->with([
                    'flash.banner'  => 'The Distribution List was edited successfully!'
                ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(DistributionList $distributionlist)
        {
            $distributionlist->delete();

            return redirect()->route('distributionlists.index')
                ->with([
                    'flash.banner'  => 'The Distribution List was deleted successfully!'
                ]);
        }

        public function signup(Request $request) {
            $lists = [];

            foreach($request->lists as $list) {
                $lists = [
                    'account_id' => auth()->user()->member->account_id,
                    'distribution_list_id' => $list
                ];
            }

            Subscription::whereAccountId(auth()->user()->member->account_id)->delete();

            Subscription::insert($lists);
        }
    }
