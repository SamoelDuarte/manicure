<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AvailableSlot;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $availableSlots = AvailableSlot::all();
        return view('backend.schedule.index')->with('availability', $availableSlots);;
    }
    private function insertAvailableSlots()
    {
        $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

        foreach ($daysOfWeek as $day) {
            // Adicione os horários disponíveis para cada dia da semana
            // Aqui, estamos adicionando dois intervalos de tempo para cada dia (manhã e tarde)
            // Você pode adicionar mais intervalos de tempo conforme necessário
            DB::table('available_slots')->insert([
                [
                    'day_of_week' => $day,
                    'start_time' => '08:00',
                    'end_time' => '13:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'day_of_week' => $day,
                    'start_time' => '14:00',
                    'end_time' => '17:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
