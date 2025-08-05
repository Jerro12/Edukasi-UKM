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

    /**
     * Tampilkan daftar template milik supplier yang sedang login.
     */
    public function index()
    {
        $templates = DesignTemplate::where('supplier_id', Auth::id())->get();
        return view('supplier.index', compact('templates'));
    }

    /**
     * Tampilkan form create.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Simpan template baru.
     */
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

    /**
     * Tampilkan detail template.
     */
    public function show(DesignTemplate $template)
    {
        // Pastikan hanya owner yang dapat melihat
        if ($template->supplier_id !== Auth::id()) {
            abort(403);
        }

        $fileUrl = $template->file_path ? Storage::url($template->file_path) : null;

        return view('supplier.show', compact('template', 'fileUrl'));
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(DesignTemplate $template)
    {
        if ($template->supplier_id !== Auth::id()) {
            abort(403);
        }

        return view('supplier.edit', compact('template'));
    }

    /**
     * Update resource.
     */
    public function update(Request $request, DesignTemplate $template)
    {
        if ($template->supplier_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'file'         => 'nullable|file|mimes:pdf,png,jpg,jpeg,svg,ai,psd,cdr',
            'example_link' => 'nullable|url',
        ]);

        $data = [
            'title'        => $request->title,
            'description'  => $request->description,
            'example_link' => $request->example_link,
        ];

        // Jika ada file baru, hapus file lama lalu simpan file baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
                Storage::disk('public')->delete($template->file_path);
            }

            $path = $request->file('file')->store('design_templates', 'public');
            $data['file_path'] = $path;
        }

        $template->update($data);

        return redirect()->route('supplier.templates.show', $template)->with('success', 'Template berhasil diperbarui.');
    }

    /**
     * Hapus template.
     */
    public function destroy(DesignTemplate $template)
    {
        if ($template->supplier_id !== Auth::id()) {
            abort(403);
        }

        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        $template->delete();

        return redirect()->route('supplier.templates.index')->with('success', 'Template berhasil dihapus.');
    }
}
