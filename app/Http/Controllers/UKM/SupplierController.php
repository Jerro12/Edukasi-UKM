<?php
namespace App\Http\Controllers\UKM;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('ukm.supplier', compact('suppliers'));
    }
}