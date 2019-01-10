<?php

namespace App\Http\Controllers\Financial;

use App\Models\Financial\AccountCategory;
use App\Models\Financial\ChartAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChartAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chart_accounts = ChartAccount::latest()->get();
        $account_categories = AccountCategory::all()->where('disabled', '!=', 'Y');
        $posting_types = array('B' => 'Balance Sheet', 'P' => 'Profit And Loss');
        $typical_balances = array('D' => 'Debit', 'C' => 'Credit');

//        return view('financial.chart_account', compact(['chart_accounts', 'account_categories']));
        return view('financial.chart_account')->with([
            'chart_accounts' => $chart_accounts,
            'account_categories' => $account_categories,
            'posting_types' => $posting_types,
            'typical_balances' => $typical_balances
        ]);
    }

    /**
     * Show the form for creating a new resource.0
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
        $this->validate(request(), [
            'acct_code' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'posting_type' => 'required',
            'typical_balance' => 'required'

        ]);

        ChartAccount::create([
            'acct_code' => request('acct_code'),
            'description' => request('description'),
            'category_id' => request('category_id'),
            'posting_type' => request('posting_type'),
            'typical_balance' => request('typical_balance'),
            'disabled' => 'N',
            'logs' => "Created by: " . Auth::user()->name
        ]);

        return redirect('financial/chart_account');
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
    public function update(ChartAccount $chartAccount)
    {
        $chartAccount->update([
            'description' => request('description'),
            'category_id' => request('category_id'),
            'posting_type' => request('posting_type'),
            'typical_balance' => request('typical_balance'),
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        return redirect('/financial/chart_account');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ChartAccount $chartAccount
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(ChartAccount $chartAccount)
    {
        $chartAccount->delete();

        return redirect('/financial/chart_account');
    }

    /**
     * Update the status of specified resource from storage
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_status($id)
    {
        $chartAccount = ChartAccount::find($id);

        $status = $chartAccount->disabled == 'N' ? 'Y' : 'N';

        $chartAccount->update([
            'disabled' => $status,
            'date_disabled' => date('Y-m-d H:i:s', time()),
            'disabled_by' => "Disabled by: " . Auth::user()->name,
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        return redirect('/financial/chart_account');
    }
}
