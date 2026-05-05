<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $car = Car::with('maintenances')->findOrFail($id);
        return view('maintenances.index',compact('car'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create(string $id)
{
    $car = Car::findOrFail($id);
    return view('maintenances.create', compact('car'));
}

    // app/Http/Controllers/MaintenancesController.php

public function store(Request $req)
{
    $validated = $req->validate(
    [
        'car_id' => 'required|exists:cars,id',
        'type' => 'required|string|max:255',
        'maintenance_date' => 'required|date|before_or_equal:today',
        'cost' => 'required|numeric|min:0',
        'mileage' => 'required|numeric|min:0',
    ],
    [
        'car_id.required' => 'La voiture est obligatoire',
        'car_id.exists' => 'Cette voiture n’existe pas',
        'type.required' => 'Le type de maintenance est obligatoire',
        'maintenance_date.required' => 'La date est obligatoire',
        'maintenance_date.date' => 'Format de date invalide',
        'maintenance_date.before_or_equal' => 'La date ne peut pas être dans le futur.',
        'cost.required' => 'Le coût est obligatoire',
        'cost.numeric' => 'Le coût doit être un nombre',
        'mileage.required' => 'Le kilométrage est obligatoire',
        'mileage.numeric' => 'Le kilométrage doit être un nombre',
    ]
);

    // نضيفو هاد السطر باش ما يخزنش comment إذا ما جاش
    $data = $req->only(['car_id', 'type', 'maintenance_date', 'cost', 'mileage']);
    if ($req->has('comment')) {
        $data['comment'] = $req->comment;
    }
    
    Maintenance::create($data);
    
    // 🔥 هادي هي النقطة المهمة: نطفيو maintenance_needed
    $car = Car::findOrFail($req->car_id);
    $car->maintenance_needed = false;
    $car->save();
    
    return redirect()->route('maintenance.index', $req->car_id)
        ->with('success', 'تمت إضافة الصيانة بنجاح و تم إزالة التنبيه');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $car = $maintenance->car;
        return view('maintenances.edit',compact('maintenance','car'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
{
    $maintenance = Maintenance::findOrFail($id);
    $validated = $req->validate(
    [
        'car_id' => 'required|exists:cars,id',
        'type' => 'required|string|max:255',
        'maintenance_date' => 'required|date|before_or_equal:today',
        'cost' => 'required|numeric|min:0',
        'mileage' => 'required|numeric|min:0',
    ],
    [
        'car_id.required' => 'La voiture est obligatoire',
        'car_id.exists' => 'Cette voiture n’existe pas',
        'type.required' => 'Le type de maintenance est obligatoire',
        'maintenance_date.required' => 'La date est obligatoire',
        'maintenance_date.date' => 'Format de date invalide',
        'maintenance_date.before_or_equal' => 'La date ne peut pas être dans le futur.',
        'cost.required' => 'Le coût est obligatoire',
        'cost.numeric' => 'Le coût doit être un nombre',
        'mileage.required' => 'Le kilométrage est obligatoire',
        'mileage.numeric' => 'Le kilométrage doit être un nombre',
    ]
);
    
    $maintenance->update($validated);
    
    // 🔥 نطفيو maintenance_needed كمان هنا
    $car = Car::findOrFail($req->car_id);
    $car->maintenance_needed = false;
    $car->save();
    
    return redirect()->route('maintenance.index', $req->car_id)
        ->with('success', 'تم تعديل الصيانة بنجاح');
}
    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $car_id = $maintenance->car_id;
        $maintenance->delete();
        return redirect()
            ->route('maintenance.index', $car_id)
            ->with('success', '✔ Maintenance supprimée avec succès');
    }




    /**
 * صفحة رئيسية تعرض جميع السيارات اللي عندها maintenance_needed = true
 */
public function carsNeedingMaintenance()
{
    $cars = Car::where('maintenance_needed', true)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return view('maintenances.cars_needing', compact('cars'));
}
}
