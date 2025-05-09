<?php
namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\DesignTemplate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DesignTemplateController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $templates = DesignTemplate::where('supplier_id', Auth::id())->get();
        return view('supplier.index', compact('templates'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'file'         => 'required|file|mimes:pdf,png,jpg,jpeg,svg,ai,psd,cdr',
            'example_link' => 'nullable|url',
        ]);

        $path = $request->file('file')->store('design_templates', 'public');

        DesignTemplate::create([
            'supplier_id'  => Auth::id(),
            'title'        => $request->title,
            'description'  => $request->description,
            'file_path'    => $path,
            'example_link' => $request->example_link,
        ]);

        return redirect()->route('supplier.templates.index')->with('success', 'Template berhasil ditambahkan.');
    }

    public function destroy(DesignTemplate $template)
    {
        // $this->authorize('delete', $template); // jika Anda pakai policy
        Storage::disk('public')->delete($template->file_path);
        $template->delete();
        return redirect()->route('supplier.templates.index')->with('success', 'Template berhasil dihapus.');
    }
}