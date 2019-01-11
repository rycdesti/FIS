<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\AccountCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use Yajra\Datatables\Html\Builder;

class AccountCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_categories = AccountCategory::all();

        if(request()->ajax()) {
            return Datatables::of(AccountCategory::query())
                ->editColumn('disabled', function(AccountCategory $accountCategory) {
                    return ($accountCategory->disabled == 'N' ? '<span class="badge-info">Enabled' : '<span class="badge-danger">Disabled') . '</span>';
                })
                ->editColumn('actions', function() {
                    return '<button class="btn btn-secondary">EDIT</button><button class="btn btn-danger">X</button>';
                })
                ->make(true);
        }

//        $account_categories = Blog::orderBy('description', 'asc')->get();

//        echo Datatables::eloquent(AccountCategory::query())
//            ->editColumn('description', function(AccountCategory $accountCategory) {
//                return 'Description: ' . $accountCategory->description;
//            })
//            ->make(true);

//        return Datatables::eloquent($account_categories)
//            ->editColumn('description', function(AccountCategory $accountCategory) {
//                return "Description: ". $accountCategory->description;
//            })
//            ->rawColumns(['description'])
//            ->make(true);

        return view('financial.account_category', compact('account_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $this->validate(request(), ['description' => 'required']);

        AccountCategory::create([
            'description' => request('description'),
            'disabled' => 'N',
            'logs' => "Created by: " . Auth::user()->name
        ]);

        return redirect('financial/account_category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountCategory $accountCategory)
    {
        $accountCategory->update([
            'description' => request('description'),
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        return redirect('/financial/account_category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(AccountCategory $accountCategory)
    {
        $accountCategory->delete();

        return redirect('/financial/account_category');
    }

    /**
     * Update the status of specified resource from storage
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_status($id)
    {
        $accountCategory = AccountCategory::find($id);

        $status = $accountCategory->disabled == 'N' ? 'Y' : 'N';

        $accountCategory->update([
            'disabled' => $status,
            'date_disabled' => date('Y-m-d H:i:s', time()),
            'disabled_by' => "Disabled by: " . Auth::user()->name,
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        return redirect('/financial/account_category');
    }
}
