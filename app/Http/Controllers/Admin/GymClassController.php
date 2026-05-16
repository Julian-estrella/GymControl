<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Models\Trainer;
use Illuminate\Http\Request;

class GymClassController extends Controller
{
    public function index()
    {
        $classes = GymClass::with('trainer')->latest()->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $trainers = Trainer::where('is_active', true)->orderBy('name')->get();
        return view('admin.classes.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'trainer_id'   => 'nullable|exists:trainers,id',
            'schedule'     => 'required|string',
            'max_capacity' => 'required|integer|min:1',
        ]);

        // Decode and validate schedule JSON
        $scheduleData = json_decode($request->schedule, true);
        if (empty($scheduleData)) {
            return back()->withErrors(['schedule' => 'Debes seleccionar al menos un día con horario.'])->withInput();
        }

        GymClass::create([
            'name'         => $request->name,
            'description'  => $request->description,
            'trainer_id'   => $request->trainer_id,
            'schedule'     => $scheduleData,
            'max_capacity' => $request->max_capacity,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Clase creada',
            'text'  => 'La clase ha sido creada correctamente.',
        ]);

        return redirect()->route('admin.classes.index');
    }

    public function show(GymClass $class)
    {
        $class->load('trainer');
        return view('admin.classes.show', compact('class'));
    }

    public function edit(GymClass $class)
    {
        $trainers = Trainer::where('is_active', true)->orderBy('name')->get();
        return view('admin.classes.edit', compact('class', 'trainers'));
    }

    public function update(Request $request, GymClass $class)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'trainer_id'   => 'nullable|exists:trainers,id',
            'schedule'     => 'required|string',
            'max_capacity' => 'required|integer|min:1',
        ]);

        $scheduleData = json_decode($request->schedule, true);
        if (empty($scheduleData)) {
            return back()->withErrors(['schedule' => 'Debes seleccionar al menos un día con horario.'])->withInput();
        }

        $class->update([
            'name'         => $request->name,
            'description'  => $request->description,
            'trainer_id'   => $request->trainer_id,
            'schedule'     => $scheduleData,
            'max_capacity' => $request->max_capacity,
            'is_active'    => $request->boolean('is_active'),
        ]);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Clase actualizada',
            'text'  => 'Los datos de la clase han sido actualizados.',
        ]);

        return redirect()->route('admin.classes.index');
    }

    public function destroy(GymClass $class)
    {
        $class->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Clase eliminada',
            'text'  => 'La clase ha sido eliminada correctamente.',
        ]);

        return redirect()->route('admin.classes.index');
    }
}
