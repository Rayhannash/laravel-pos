<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index(){
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    public function create(){
        return view('members.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama_member' => 'required|string|max:255',
            'nomor_handphone' => 'required|numeric'
        ]);
    
        Member::create([
            'nama_member' => $request->nama_member,
            'nomor_handphone' => $request->nomor_handphone
        ]);
    
        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan');
    }

    public function edit($id){
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member){
        $request->validate([
            'nama_member' => 'required',
            'nomor_handphone' => 'required|numeric',
        ]);

        $member->update([
            'nama_member' => $request->nama_member,
            'nomor_handphone' => $request->nomor_handphone,
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil diperbarui!');
    }

    public function destroy(Member $member){
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus!');
    }
}
