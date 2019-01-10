<?php

namespace App\Http\Controllers\Ap;

use App\Models\Ap\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::orderBy('bank_name', 'asc')->get();

        return view('ap.bank')->with(['banks' => $banks]);
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
            'bank_name' => 'required'
        ]);

        $filtered_words = array("OF", "THE", "AND");
        $special_char = array( '(', ')', '!', '@', '#', '$', '%', '^', '&', '*');

        $array_bank_name = explode(" ", strtoupper(request('bank_name')));
        foreach($array_bank_name as $key => $value) {
            if(in_array($value, $filtered_words)) {
                unset($array_bank_name[$key]);
            } else {
                $array_bank_name[$key] = str_replace($special_char, '', $value);
            }
        }

        $bank_initials = '';
        foreach ($array_bank_name as $key) {
            $bank_initials .= $key[0];
        }

        $concat_bank_initials = str_pad($bank_initials, 3, $key[0], STR_PAD_RIGHT);
        $counter = Bank::where('bank_prefix', '=', $concat_bank_initials)->count();
        $num_padded = sprintf("%03d", $counter + 1);
        $bank_code = $concat_bank_initials . $num_padded;

        Bank::create([
            'bank_code' => $bank_code,
            'bank_name' => request('bank_name'),
            'bank_prefix' => $concat_bank_initials,
            'disabled' => 'N',
            'logs' => "Created by: " . Auth::user()->name
        ]);

        return redirect('ap/bank');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idΩ
     * @return \Illuminate\Http\Response
     */
    public function update(Bank $bank)
    {
        $bank->update([
            'bank_name' => request('bank_name'),
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        return redirect('/ap/bank');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bank $bank
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect('/ap/bank');
    }

    /**
     * Update the status of specified resource from storage
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_status($id)
    {
        $bank = Bank::find($id);

        $status = $bank->disabled == 'N' ? 'Y' : 'N';

        $bank->update([
            'disabled' => $status,
            'date_disabled' => date('Y-m-d H:i:s', time()),
            'disabled_by' => "Disabled by: " . Auth::user()->name,
            'last_modified' => "Last modified by: " . Auth::user()->name
        ]);

        return redirect('/ap/bank');
    }
}
