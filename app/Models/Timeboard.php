<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeboard extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'hour_start',
        'hour_end',
        'user_id',
        'user_id_sign',
        'warehouse_id'
    ];
    protected $appends = ['diff'];
    public function getDiffAttribute()
    {
        // Sprawdź, czy obiekt ma ustawione godziny początkową i końcową
        if ($this->hour_start && $this->hour_end) {
            // Przekształć godziny na obiekty DateTime
            $start = new \DateTime($this->date . ' ' . $this->hour_start);
            $end = new \DateTime($this->date . ' ' . $this->hour_end);

            // Oblicz różnicę czasową
            $diff = $start->diff($end);

            // Zwróć różnicę czasową w formie stringa (HH:MM:SS)
            return $diff->format('%H:%I:%S');
        }

        // Jeśli godziny nie są ustawione, zwróć null
        return null;
    }

    // Dodaj automatyczne dodawanie atrybutu 'diff' do tablicy atrybutów
    public function toArray()
    {
        $attributes = parent::toArray();
        $attributes['diff'] = $this->diff;

        return $attributes;
    }
}
