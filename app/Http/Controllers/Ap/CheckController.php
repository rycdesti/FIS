<?php

namespace App\Http\Controllers\Ap;

use App\Models\Ap\Bank;
use App\Models\Ap\BankAccount;
use App\Models\Ap\Check;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $this->validate(request(), [
            'bank_id' => 'required',
            'bank_account_id' => 'required',
            'acct_no' => 'required',
            'check_from' => 'required',
            'check_to' => 'required'
        ]);

        $bank_id = request('bank_id');
        $bank_account_id = request('bank_account_id');

        $acct_no = request('acct_no');
        $check_from = request('check_from');
        $check_to = request('check_to');
        $logs = "Created by: " . Auth::user()->name;

        $temp_query = '';
        $query_count = 0;
        $insert_query = "INSERT INTO ap.checks (acct_no, check_from, check_to, check_no, logs, is_disabled)";
        $insert_query_count = "SELECT COUNT(*) as record_count
            FROM ap.checks
            WHERE 1-1 ";
        $check_no = $check_from;
        while ($check_no <= $check_to) {
            $temp_query .= " SELECT '$acct_no', '$check_from', '$check_to', '$check_no', '$logs', 'N' UNION ALL ";

            $query_count++;
            $check_no++;
        }
        $insert_query_count .= " AND (check_no BETWEEN $check_from AND $check_to) AND acct_no = '$acct_no' ";
        $query = $insert_query . rtrim($temp_query, 'UNION ALL');

        DB::statement($query);

        return redirect('ap/check/get/' . $bank_id . '/' . $bank_account_id);
    }

    /**
     * Display the specified resource.
     *
     * @param $bank_account_id
     * @param $bank_id
     * @return \Illuminate\Http\Response
     */
    public function show($bank_id, $bank_account_id)
    {
        $bank_account = BankAccount::find($bank_account_id);
        $checks = Check::select('acct_no', 'check_from', 'check_to', 'logs', 'created_at')
            ->where('acct_no', '=', $bank_account->acct_no)
            ->orderBy('check_from')
            ->groupCheck()
            ->get();
        $bank = Bank::find($bank_id);

        return view('ap.check')->with([
            'checks' => $checks,
            'bank_account' => $bank_account,
            'bank' => $bank,
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
