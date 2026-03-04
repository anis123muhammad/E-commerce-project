@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')

	<section class="content-header">
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Order: OR{{ $order->id }}</h1>
							</div>
							<div class="col-sm-6 text-right">
                                <a href="orders.html" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header pt-3">
                                        <div class="row invoice-info">
                                       <div class="col-sm-4 invoice-col">
    <h1 class="h5 mb-3">Shipping Address</h1>
    <address>
        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
        {{ $order->address }}<br>
        {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
        Phone: {{ $order->mobile }}<br>
        Email: {{ $order->email }}
    </address>
</div>

<div class="col-sm-4 invoice-col">
    <b>Invoice #{{ $order->id }}</b><br><br>
    <b>Order ID:</b> {{ $order->id }}<br>
    <b>Total:</b> ${{ number_format($order->grand_total, 2) }}<br>
    <b>Status:</b>
<span id="order-status-badge"
      class="text-{{
        $order->status == 'delivered' ? 'success' :
        ($order->status == 'cancelled' ? 'danger' :
        ($order->status == 'shipped' ? 'info' : 'warning'))
      }}">
    {{ ucfirst($order->status) }}
</span>
    <br>
</div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th width="100">Price</th>
                                                    <th width="100">Qty</th>
                                                    <th width="100">Total</th>
                                                </tr>
                                            </thead>
                                         <tbody>
@foreach($order->items as $item)
<tr>
    <td>{{ $item->product->name }}</td>
    <td>${{ number_format($item->price, 2) }}</td>
    <td>{{ $item->quantity }}</td>
    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
</tr>
@endforeach
<tr>
    <th colspan="3" class="text-right">Subtotal:</th>
    <td>${{ number_format($order->subtotal, 2) }}</td>
</tr>
<tr>
    <th colspan="3" class="text-right">Shipping:</th>
    <td>${{ number_format($order->shipping, 2) }}</td>
</tr>
<tr>
    <th colspan="3" class="text-right">Grand Total:</th>
    <td>${{ number_format($order->grand_total, 2) }}</td>
</tr>
</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Order Status</h2>
                                        <div class="mb-3">
<select name="status" id="order_status" class="form-control">
    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
</select>
                                        </div>
                                        <div class="mb-3">
<button class="btn btn-primary mt-2" onclick="updateStatus({{ $order->id }})">
    Update
</button>                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Send Inovice Email</h2>
                                        <div class="mb-3">
                                          <select name="email_type" id="email_type" class="form-control">
    <option value="customer">Customer</option>
    <option value="admin">Admin</option>
</select>
                                        </div>
                                        <div class="mb-3">
<button class="btn btn-primary mt-2" onclick="sendInvoiceEmail({{ $order->id }})">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<!-- /.card -->
				</section>

@endsection

<script>
function updateStatus(orderId) {
    let status = document.getElementById('order_status').value;

    fetch("{{ route('admin.order.updateStatusAjax') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            order_id: orderId,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {

            // 🔥 Update Text
            let badge = document.getElementById('order-status-badge');
            badge.innerText = status.charAt(0).toUpperCase() + status.slice(1);

            // 🔥 Remove old color classes
            badge.classList.remove('text-success','text-danger','text-info','text-warning');

            // 🔥 Add new color dynamically
            if(status === 'delivered') {
                badge.classList.add('text-success');
            }
            else if(status === 'cancelled') {
                badge.classList.add('text-danger');
            }
            else if(status === 'shipped') {
                badge.classList.add('text-info');
            }
            else {
                badge.classList.add('text-warning');
            }

            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<script>
    function sendInvoiceEmail(orderId) {
    let emailType = document.getElementById('email_type').value;

    fetch("{{ route('emails.order-invoice') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            order_id: orderId,
            email_type: emailType
        })


    })
    .then(async response => {
        let data = await response.json();
        if(response.ok && data.success){
            alert(data.message);
        } else {
            alert('Failed: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
