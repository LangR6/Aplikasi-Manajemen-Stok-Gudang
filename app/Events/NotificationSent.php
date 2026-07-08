<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $namaBarang;
    public int $sisaStok;
    public string $roleTujuan;

    public function __construct(string $namaBarang, int $sisaStok, string $roleTujuan)
    {
        $this->namaBarang = $namaBarang;
        $this->sisaStok   = $sisaStok;
        $this->roleTujuan = $roleTujuan;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('gudang-notification.role.' . $this->roleTujuan);
    }

    public function broadcastAs(): string
    {
        return 'stok.menipis';
    }

    public function broadcastWith(): array
    {
        return [
            'nama_barang' => $this->namaBarang,
            'sisa_stok'   => $this->sisaStok,
            'role_tujuan' => $this->roleTujuan,
        ];
    }
}
