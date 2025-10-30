<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StorePeminjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ruangan_id'   => 'required|exists:ruangans,id',
            'tanggal'      => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'jam_mulai'    => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $this->validateOperatingHours($value, $fail, 'Jam mulai');
                    $this->validateTimeInterval($value, $fail);
                },
            ],
            'jam_selesai'  => [
                'required',
                'date_format:H:i',
                'after:jam_mulai',
                function ($attribute, $value, $fail) {
                    $this->validateOperatingHours($value, $fail, 'Jam selesai');
                    $this->validateTimeInterval($value, $fail);
                    $this->validateDuration($fail);
                },
            ],
            'tujuan'       => 'required|string|max:500',
            'dokumen'      => 'nullable|mimes:pdf|max:2048',
        ];
    }

    /**
     * Validate operating hours (07:00 - 22:00)
     */
    protected function validateOperatingHours($value, $fail, $fieldName)
    {
        try {
            $time = Carbon::createFromFormat('H:i', $value);
            $minTime = Carbon::createFromFormat('H:i', '07:00');
            $maxTime = Carbon::createFromFormat('H:i', '22:00');

            if ($time->lessThan($minTime) || $time->greaterThan($maxTime)) {
                $fail("{$fieldName} harus dalam jam operasional ruangan (07:00 - 22:00).");
            }
        } catch (\Exception $e) {
            $fail("{$fieldName} tidak valid.");
        }
    }

    /**
     * Validate 15-minute intervals
     */
    protected function validateTimeInterval($value, $fail)
    {
        try {
            $time = Carbon::createFromFormat('H:i', $value);

            if ($time->minute % 15 !== 0) {
                $fail('Waktu harus dalam kelipatan 15 menit (contoh: 08:00, 08:15, 08:30, 08:45).');
            }
        } catch (\Exception $e) {
            // Skip if time format is invalid (already handled by date_format rule)
        }
    }

    /**
     * Validate booking duration
     */
    protected function validateDuration($fail)
    {
        if (!$this->has('jam_mulai') || !$this->has('jam_selesai')) {
            return;
        }

        try {
            $jamMulai = Carbon::createFromFormat('H:i', $this->jam_mulai);
            $jamSelesai = Carbon::createFromFormat('H:i', $this->jam_selesai);

            // Calculate duration in minutes
            $durationMinutes = $jamMulai->diffInMinutes($jamSelesai);

            // Minimum duration: 30 minutes
            if ($durationMinutes < 30) {
                $fail('Durasi peminjaman minimal 30 menit.');
                return;
            }

            // Maximum duration: 8 hours (480 minutes)
            if ($durationMinutes > 480) {
                $fail('Durasi peminjaman maksimal 8 jam.');
                return;
            }
        } catch (\Exception $e) {
            // Skip if time format is invalid
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ruangan_id.required' => 'Ruangan harus dipilih.',
            'ruangan_id.exists' => 'Ruangan yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal peminjaman harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal peminjaman tidak boleh kurang dari hari ini.',
            'jam_mulai.required' => 'Jam mulai harus diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (gunakan format HH:MM).',
            'jam_selesai.required' => 'Jam selesai harus diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (gunakan format HH:MM).',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'tujuan.required' => 'Tujuan peminjaman harus diisi.',
            'tujuan.max' => 'Tujuan peminjaman maksimal 500 karakter.',
            'dokumen.mimes' => 'Dokumen harus berformat PDF.',
            'dokumen.max' => 'Ukuran dokumen maksimal 2MB.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'ruangan_id' => 'ruangan',
            'tanggal' => 'tanggal peminjaman',
            'jam_mulai' => 'jam mulai',
            'jam_selesai' => 'jam selesai',
            'tujuan' => 'tujuan peminjaman',
            'dokumen' => 'dokumen pendukung',
        ];
    }
}
