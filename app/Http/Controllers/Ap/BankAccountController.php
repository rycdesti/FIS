<?php

namespace App\Http\Controllers\Ap;

use App\Models\Ap\Bank;
use App\Models\Ap\BankAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate(request(), [
            'bank_id' => 'required',
            'bank_code' => 'required',
            'bank_address' => 'required',
            'acct_code' => 'required',
            'acct_no' => 'required',
            'acct_type' => 'required',
            'currency' => 'required'
        ]);

        BankAccount::create([
            'bank_id' => request('bank_id'),
            'bank_code' => request('bank_code'),
            'bank_address' => request('bank_address'),
            'acct_code' => request('acct_code'),
            'acct_no' => request('acct_no'),
            'acct_type' => request('acct_type'),
            'currency' => request('currency'),
            'disabled' => 'N',
            'beginning_balance' => 0.0,
            'logs' => "Created by: " . Auth::user()->name
        ]);

        $bank_id = request('bank_id');

        return redirect(url('/ap/bank_account', $bank_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank_accounts = BankAccount::latest()
            ->where('bank_id', '=', $id)
            ->get();
        $bank = Bank::find($id);
        $account_types = array('S' => 'Savings', 'C' => 'Cheque In');
        $currencies = array('PHP' => 'Philippine Peso');

        return view('ap.bank_account')->with([
            'bank_accounts' => $bank_accounts,
            'bank' => $bank,
            'account_types' => $account_types,
            'currencies' => $currencies
        ]);
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
     * @param BankAccount $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(BankAccount $bankAccount)
    {
        $bankAccount->update([
            'bank_address' => request('bank_address'),
            'acct_code' => request('acct_code'),
            'acct_no' => request('acct_no'),
            'acct_type' => request('acct_type'),
            'currency' => request('currency'),
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        $bank_id = request('bank_id');

        return redirect(url('/ap/bank_account', $bank_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BankAccount $bankAccount
     * @param $bank_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($bank_id, BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect(url('/ap/bank_account', $bank_id));
    }

    /**
     * Update the status of specified resource from storage
     *
     * @param $id
     * @param $bank_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_status($bank_id, $id)
    {
        $bank_account = BankAccount::find($id);

        $status = $bank_account->disabled == 'N' ? 'Y' : 'N';

        $bank_account->update([
            'disabled' => $status,
            'date_disabled' => date('Y-m-d H:i:s', time()),
            'disabled_by' => "Disabled by: " . Auth::user()->name,
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        return redirect(url('/ap/bank_account', $bank_id));
    }
}
