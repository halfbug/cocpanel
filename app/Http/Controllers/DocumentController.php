<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\document;
use App\module;

class DocumentController extends Controller {

    public function docUploadPost(Request $request) {
        $this->validate($request, [
            'document' => 'required|max:2048',
            'description' => 'required'
        ]);

//        $fileName = $request->document->getClientOriginalName();
        $fileName = rand(11111,99999).".".$request->document->getClientOriginalExtension();
        $request->document->move(public_path('documents'), $fileName);

        // insert to database
        $doc = new document();
        $doc->description = $request->description;
        $doc->module_id = $request->doc_module_id;
        $doc->uploaded_by = \Auth::user()->id;
        $doc->filename = $fileName;
        $doc->save();

        return back()
                        ->with('success', 'Document Uploaded successfully.')
                        ->with('model', '#documentModel');
    }

    public function destroy($doc_id) {
        $doc = document::destroy($doc_id);
        return response()->json($doc);
    }

    public function listModuleDoc($module_id) {
        $documents = module::find($module_id)->documents()->get();
        return response()->json($documents);
    }

}
