@extends('layouts.producer')

@section('title', 'Notificaciones')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Notificaciones</h1>
        <div>
            @if(count($notifications) > 0)
            <form action="{{ route('producer.notifications.mark-all-read') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-check-double me-1"></i> Marcar todas como leídas
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Todas las notificaciones</h6>
        </div>
        <div class="card-body">
            @if(count($notifications) > 0)
                <div class="list-group">
                    @foreach($notifications as $notification)
                        <div class="list-group-item list-group-item-action {{ $notification->read_at ? '' : 'unread-notification' }}">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    @if(!($notification->data['for_admin'] ?? true))
                                        <h5 class="mb-1">
                                            <i class="fas fa-shopping-cart text-primary me-2"></i>
                                            Nuevo Pedido: {{ $notification->data['order_number'] }}
                                        </h5>
                                        <p class="mb-1">Se ha recibido un nuevo pedido para tu tienda.</p>
                                    @else
                                        <h5 class="mb-1">
                                            <i class="fas fa-bell text-warning me-2"></i>
                                            {{ $notification->type }}
                                        </h5>
                                        <p class="mb-1">{{ json_encode($notification->data) }}</p>
                                    @endif
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($notification->created_at)->locale('es')->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="d-flex">
                                    @if(!($notification->data['for_admin'] ?? true))
                                        <a href="{{ route('orders.show', $notification->data['order_id']) }}" class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-eye"></i> Ver Pedido
                                        </a>
                                    @endif
                                    
                                    @if(!$notification->read_at)
                                        <form action="{{ route('producer.notifications.mark-read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check"></i> Marcar como leída
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                    <h5>No tienes notificaciones</h5>
                    <p class="text-muted">Las notificaciones aparecerán aquí cuando haya nuevos pedidos o actividades importantes.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .unread-notification {
        background-color: rgba(13, 110, 253, 0.05);
        border-left: 4px solid #0d6efd;
    }
</style>
@endsection
