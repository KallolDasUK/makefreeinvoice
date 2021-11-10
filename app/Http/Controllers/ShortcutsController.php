<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shortcut;
use Illuminate\Http\Request;
use Exception;

class ShortcutsController extends Controller
{

    /**
     * Display a listing of the shortcuts.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $shortcuts = Shortcut::paginate(25);

        return view('shortcuts.index', compact('shortcuts'));
    }

    /**
     * Show the form for creating a new shortcut.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        

        return view('shortcuts.create');
    }

    /**
     * Store a new shortcut in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

            
            $data = $this->getData($request);
            
            Shortcut::create($data);

            return redirect()->route('shortcuts.shortcut.index')
                ->with('success_message', 'Shortcut was successfully added.');

    }

    /**
     * Display the specified shortcut.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $shortcut = Shortcut::findOrFail($id);

        return view('shortcuts.show', compact('shortcut'));
    }

    /**
     * Show the form for editing the specified shortcut.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $shortcut = Shortcut::findOrFail($id);
        

        return view('shortcuts.edit', compact('shortcut'));
    }

    /**
     * Update the specified shortcut in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

            
            $data = $this->getData($request);
            
            $shortcut = Shortcut::findOrFail($id);
            $shortcut->update($data);

            return redirect()->route('shortcuts.shortcut.index')
                ->with('success_message', 'Shortcut was successfully updated.');

    }

    /**
     * Remove the specified shortcut from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $shortcut = Shortcut::findOrFail($id);
            $shortcut->delete();

            return redirect()->route('shortcuts.shortcut.index')
                ->with('success_message', 'Shortcut was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'name' => 'required|nullable|string|min:1|max:255',
            'link' => 'required|nullable|string|min:1', 
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
