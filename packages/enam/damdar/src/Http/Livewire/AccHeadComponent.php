<?php

namespace Enam\Acc\Http\Livewire;

use Enam\Acc\Models\AccHead;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class AccHeadComponent extends Component
{
    public $newSubhead = '';
    public $heads;
    public $subHeads = [];
    public $showDialog = false;
    public $newHead;
    public $rules = [
        'c_h' => 'required'
    ];

    public $c_ph = "Income";
    public $c_sh;
    public $c_h, $c_id;
    public $updateMode = false;

    public function mount()
    {
        View::share('title', 'Heads - Chart of Accounts');

        $bal = AccHead::all(['sub_head'])->toArray();
        foreach ($bal as $h) {
            array_push($this->subHeads, $h['sub_head']);
        }
        $this->subHeads = array_unique($this->subHeads);
        //dd($this->subHeads);

//        dd($this->subHeads);
        if (count($this->subHeads) > 0) {
            $this->c_sh = $this->subHeads[0];

        }
    }

    public function add()
    {
        $this->validate($this->rules);
        $nh = new AccHead;
        $nh->cid = 1;
        $nh->user = auth()->user()->id;
        $nh->head = $this->c_h;
        $nh->sub_head = $this->c_sh;
        $nh->parent_head = $this->c_ph;
        $nh->save();
        $this->newHead = '';
        $this->reset(['c_h']);

        session()->flash('message', 'Item Added');

    }

    public function addSubHead()
    {
        array_push($this->subHeads, $this->newSubhead);
        $this->newSubhead = '';
        $this->showDialog = false;

        $this->c_sh = last($this->subHeads);


    }


    public function update($id)
    {
        $nh = AccHead::findOrFail($id);
        $this->c_id = $id;
        $this->c_ph = $nh->parent_head;
        $this->c_sh = $nh->sub_head;
        $this->c_h = $nh->head;
        $this->updateMode = true;

//        session()->flush('message', 'Updated');

    }

    public function confirmUpdate()
    {
        AccHead::find($this->c_id)->update([
            'parent_head' => $this->c_ph,
            'sub_head' => $this->c_sh,
            'head' => $this->c_h,
        ]);
        $this->c_h = '';
        $this->c_sh = '';
        $this->c_ph = '';
        $this->updateMode = false;


        session()->flash('message', 'Updated');

    }

    public function delete($id)
    {
        $nh = AccHead::destroy($id);
        session()->flash('message', 'Deleted Head Successfully');

    }


    public function render()
    {
        $this->heads = AccHead::query()->where('cid', '=', '1')->latest()->get();

        return view('acc::livewire.acc-head-component')->layout('layouts.admin.base');
    }
}
