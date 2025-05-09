<?php
namespace App\Http\Controllers\Ukm;

use App\Http\Controllers\Controller;
use App\Models\DesignTemplate;

class TemplateViewerController extends Controller
{
    public function index()
    {
        $templates = DesignTemplate::latest()->get(); // semua template
        return view('ukm.template', compact('templates'));
    }

    public function show($id)
    {
        $template = DesignTemplate::findOrFail($id);
        return view('ukm.detail-template', compact('template'));
    }
}