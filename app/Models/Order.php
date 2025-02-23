<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    //
    use HasUuids;
    protected $fillable = [
        'layanan_id',
        'customer_id',
        'worker_id',
        'bank_id',
        'harga_member',
        'harga_worker',
        'nominal',
        'waktu',
        'alamat',
        'tanggal',
        'dari_bank',
        'nominal_transfer',
        'bukti_transfer',
        'village_code',
        'district_code',
        'city_code',
        'province_code',
        'status_pembayaran',
        'status_order',
    ];

    public function bank(): BelongsTo
    {
        return $this->BelongsTo(Bank::class, 'bank_id');
    }

    public function layanan(): BelongsTo
    {
        return $this->BelongsTo(Layanan::class, 'layanan_id');
    }

    public function customer(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'customer_id');
    }

    public function worker(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'worker_id');
    }

    public function getStatusPembayaranTextAttribute()
    {
        $status_pembayaran = list_status_pembayaran();
        return isset($status_pembayaran[$this->status_pembayaran]) ? $status_pembayaran[$this->status_pembayaran] : '';
    }

    public function getStatusOrderTextAttribute()
    {
        $status_order = list_status_order();
        return isset($status_order[$this->status_order]) ? $status_order[$this->status_order] : '';
    }

    protected $appends = ['bukti_transfer_url'];

    public function getBuktiTransferUrlAttribute()
    {
        return $this->bukti_transfer ? asset('storage/bukti_bayar') . '/' . $this->bukti_transfer : '';
    }
    public function workerProofs()
    {
        return $this->hasMany(WorkerProof::class);
    }
}
