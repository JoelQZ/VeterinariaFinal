<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SaleController extends Controller{
    public function create($appointment_id){
        $appointment = Appointment::with(['petRelation', 'ownerRelation'])->findOrFail($appointment_id);
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('appointment', 'products'));
    }

    public function index(){
        $sales = Sale::with(['owner', 'details'])->latest()->get();
        $totalEfectivo = Sale::where('payment_method', 'Efectivo')->sum('total');
        $totalTarjeta = Sale::where('payment_method', 'Tarjeta')->sum('total');
        $totalTransferencia = Sale::where('payment_method', 'Transferencia')->sum('total');
        $totalGeneral = Sale::sum('total');
        return view('sales.index', compact('sales', 'totalEfectivo', 'totalTarjeta', 'totalTransferencia', 'totalGeneral'));
    }

    public function store(Request $request){
        $request->validate([
            'appointment_id' => 'required|integer',
            'owner_id'       => 'required',
            'payment_method' => 'required|string',
            'service_price'  => 'required|numeric|min:0',
        ]);
        DB::transaction(function () use ($request) {
            $appointment = Appointment::findOrFail($request->appointment_id);

            $totalSale = $request->service_price;

            if ($request->has('products')) {
                foreach ($request->products as $productId => $productData) {
                    if (isset($productData['selected'])) {
                        $product = Product::findOrFail($productId);
                        $totalSale += $product->price * $productData['quantity'];
                    }
                }
            }
            $sale = Sale::create([
                'appointment_id' => $appointment->id,
                'owner_id'       => $request->owner_id,
                'total'          => $totalSale,
                'payment_method' => $request->payment_method,
            ]);
            SaleDetail::create([
                'sale_id'    => $sale->id,
                'product_id' => null,
                'concept'    => 'Servicio: ' . $appointment->reason,
                'quantity'   => 1,
                'price'      => $request->service_price,
            ]);
            if ($request->has('products')) {
                foreach ($request->products as $productId => $productData) {
                    if (isset($productData['selected'])) {
                        $product = Product::findOrFail($productId);
                        $qty = $productData['quantity'];

                        SaleDetail::create([
                            'sale_id'    => $sale->id,
                            'product_id' => $product->id,
                            'concept'    => $product->name,
                            'quantity'   => $qty,
                            'price'      => $product->price,
                        ]);

                        $product->decrement('stock', $qty);
                    }
                }
            }
            $appointment->status = 'Finalizada';
            $appointment->save();
        });
        return redirect('/dashboard')->with('success', 'Cita finalizada y cobro registrado correctamente.');
    }
}