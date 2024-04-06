<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const NEW_ORDER = 0;
    public const PAID = 1;
    public const UNDER_PROCESS = 2;
    public const FINISHED = 3;
    public const REJECTED = 4;
    public const CANCELED = 5;
    public const REFUNDED_REQUEST = 6;
    public const RETURNED = 7;
    public const REFUNDED = 8;

    public function status($transactionStatus = null)
    {
        $transaction = $transactionStatus != '' ? $transactionStatus : $this->transaction_status;

        switch ($transaction) {
            case 0:
                return 'Novo pedido';
            case 1:
                return 'Pago';
            case 2:
                return 'Em processo';
            case 3:
                return 'Concluído';
            case 4:
                return 'Rejeitado';
            case 5:
                return 'Cancelado';
            case 6:
                return 'Solicitação de reembolso';
            case 7:
                return 'Devolvido';
            case 8:
                return 'Reembolsado';
            default:
                return 0;
        }
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
