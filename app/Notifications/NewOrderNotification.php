<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $forAdmin;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, bool $forAdmin = false)
    {
        $this->order = $order;
        $this->forAdmin = $forAdmin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Always use database channel, and use mail channel if configured
        $channels = ['database'];

        // Only add mail channel if mail is properly configured
        if (config('mail.default') && config('mail.mailers.' . config('mail.default') . '.transport')) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject($this->forAdmin ? 'Nuevo Pedido Recibido: ' . $this->order->order_number : 'Nuevo Pedido para tu Tienda: ' . $this->order->order_number)
            ->greeting('¡Hola ' . ($notifiable->name ?? 'Usuario') . '!')
            ->line($this->forAdmin
                ? 'Se ha recibido un nuevo pedido en la plataforma.'
                : 'Se ha recibido un nuevo pedido para tu tienda.')
            ->line('Número de Pedido: ' . $this->order->order_number)
            ->line('Monto Total: $' . number_format($this->order->total_amount, 0, ',', '.'))
            ->line('Estado: Pendiente')
            ->line('Método de Pago: ' . $this->getPaymentMethodName($this->order->payment_method));

        if ($this->forAdmin) {
            $mailMessage->action('Ver Todos los Pedidos', url('/admin/orders'));
        } else {
            $mailMessage->action('Ver Detalles del Pedido', url('/producer/orders/' . $this->order->id));
        }

        $mailMessage->line('¡Gracias por usar nuestra plataforma!');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_amount' => $this->order->total_amount,
            'status' => $this->order->status,
            'payment_method' => $this->order->payment_method,
            'created_at' => $this->order->created_at->format('Y-m-d H:i:s'),
            'for_admin' => $this->forAdmin,
        ];
    }

    /**
     * Get the human-readable payment method name.
     */
    private function getPaymentMethodName(string $method): string
    {
        return match ($method) {
            'cash' => 'Efectivo',
            'credit_card' => 'Tarjeta de Crédito',
            'bank_transfer' => 'Transferencia Bancaria',
            default => $method,
        };
    }
}
