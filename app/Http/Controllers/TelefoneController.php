<?php

namespace CodeAgenda\Http\Controllers;


use CodeAgenda\Entities\Pessoa;
use CodeAgenda\Entities\Telefone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelefoneController extends Controller
{
    public function create($id)
    {
        $pessoa = Pessoa::find($id);

        return view('telefone.create', compact('pessoa'));
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'descrição' => 'required|min:4|max:50',
            'codpaís' => 'required|min:2|max:8',
            'ddd' => 'required|min:3|max:4',
            'prefixo' => 'required|min:4',
            'sufixo' => 'required|min:4|max:5',
        ]);

        if($validator->fails()) {
            return redirect()->route('telefone.create', ['id' => $id])->withErrors($validator)->withInput();
        }

        $pessoa = Pessoa::find($id);

        $data = $request->all();
        $data['pessoa_id']=$pessoa->id;
        Telefone::create($data);
        
        $letra = strtoupper(substr($pessoa->apelido,0,1));
        return redirect()->route('agenda.letra', ['letra' => $letra]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        $telefone = Telefone::find($id);
        $pessoa = $telefone->pessoa;

        return view('telefone.delete', compact('pessoa', 'telefone'));
    }

    public function destroy($id)
    {
        Telefone::destroy($id);
        return redirect()->route('agenda.index');
    }

}