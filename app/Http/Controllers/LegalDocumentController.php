<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use Illuminate\Http\Request;

class LegalDocumentController extends Controller
{
    public function index()
    {
        $legalDocuments = LegalDocument::all();
        return response()->json($legalDocuments);
    }
}
