<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->type) && $request->type == 'deposit'){

            $response = [
                'success' => true,
                'message' => 'Data stored successfully.',
            ];
        }
        else if(isset($request->type) && $request->type == 'withdraw'){
            $response = [
                'success' => true,
                'message' => 'Data stored successfully.',
            ];
        }
        else if(isset($request->type) && $request->type == 'transfer'){

            $response = [
                'success' => true,
                'message' => 'Data stored successfully.',
            ];    
        }
        else{
            $response = [
                'success' => false,
                'message' => 'Something went wrong.',
            ];    
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
