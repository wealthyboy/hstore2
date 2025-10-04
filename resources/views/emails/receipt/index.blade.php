<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Invoice Receipt</title>
</head>
<body style="margin:0; padding:0; background-color:#FFFFE8 !important;">
   <table width="100%" cellspacing="0" cellpadding="0" border="0" 
          style="background-color:#FFFFE8 !important; padding:20px;">
  <tr>
         <td align="center">
            
            <!-- Wrapper -->
            <table width="668" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#FFFFE8" style="margin:0 auto; background-color:#FFFFE8;  border-radius:6px; border:1px solid #e2e2e2;">
               
               <!-- Header -->
               <tr>
                  <td align="center" style="padding:20px; border-bottom:1px solid #eee;">
                     <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                           <td align="left">
                              <a href="{{ config('app.url') }}" target="_blank" style="text-decoration:none;">
                                 <img src="https://theaurabydora.com/images/logo/17591618781751691052D__1-remove%20bg%20copy.png" 
                                      alt="The Aura by Dora" 
                                      style="max-width:120px; height:auto; display:block; border:none;">
                              </a>
                           </td>
                           <td align="right" style="font-family:sans-serif; font-size:18px; color:#333; font-weight:bold;">
                              Invoice Receipt
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>

               <!-- Body -->
               <tr>
                  <td align="left" style="padding:30px; font-family:sans-serif; font-size:14px; color:#333; line-height:22px;">

                     <!-- Greeting -->
                     Dear {{ $order->order_type != 'admin' 
                        ? optional($order->user)->fullname() 
                        : optional(optional($order)->addres)->first_name .' '. optional(optional($order)->addres)->last_name }},<br><br>

                     Thank you for your order! Your order has been received and is now being processed. Please find your details below:

                     <div style="height:20px;"></div>

                     <!-- Invoice Details -->
                     <strong>Invoice Number:</strong> {{ $order->invoice_number ?? 'N/A' }}<br>
                     <strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}<br>

                     <div style="height:20px;"></div>

                     <!-- Shipping Address -->
                     <strong>Shipping Address:</strong><br>
                     {{ optional($order->addres)->first_name }} {{ optional($order->addres)->last_name }}<br>
                     {{ optional($order->addres)->address_line1 }}<br>
                     @if(optional($order->addres)->address_line2)
                        {{ optional($order->addres)->address_line2 }}<br>
                     @endif
                     {{ optional($order->addres)->city }}, {{ optional($order->addres)->state }} {{ optional($order->addres)->postal_code }}<br>
                     {{ optional($order->addres)->country }}

                     <div style="height:30px;"></div>

                     <!-- Order Items Table -->
                     <!-- Order Items Table -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; font-size:14px; color:#333;">
   <thead>
      <tr style="background:#FFFFE8; text-align:center;">
         <th style="padding:8px; border:1px solid #ddd;">Product</th>
         <th style="padding:8px; border:1px solid #ddd;">Quantity</th>
         <th style="padding:8px; border:1px solid #ddd;">Price</th>
         <th style="padding:8px; border:1px solid #ddd;">Total</th>
      </tr>
   </thead>
   <tbody>
      @foreach($order->ordered_products as $ordered_product)
         <tr>
            <td style="padding:8px; border:1px solid #ddd; vertical-align: top;">
               <!-- Product Image -->
               <div style="width: 120px; max-height: 160px; overflow: hidden; display: block; margin-bottom:6px;">
                  <img style="outline:0; max-width:100%;" 
                       src="{{ $ordered_product->product_variation->image_to_show ?? '/images/default.png' }}" 
                       alt="Product Image"/>
               </div>
               
               <!-- Product Name -->
               <strong>
                  {{ optional($ordered_product->product_variation)->name  
                     ?? optional(optional($ordered_product->product_variation)->product)->product_name }}
               </strong>

               <!-- Product Variations -->
               @if ($ordered_product->product_variation && $ordered_product->product_variation->product_variation_values->count())
                  <br>
                  <small style="color:#666;">
                     @foreach($ordered_product->product_variation->product_variation_values as $v)
                        {{ $v->attribute->name }}@if(!$loop->last), @endif
                     @endforeach
                  </small>
               @endif
            </td>

            <!-- Quantity -->
            <td style="padding:8px; border:1px solid #ddd; text-align:center;">
               {{ $ordered_product->quantity }}
            </td>

            <!-- Price -->
            <td style="padding:8px; border:1px solid #ddd; text-align:center;">
               {{ $order->currency }}{{ $ordered_product->order_price }}
            </td>

            <!-- Total -->
            <td style="padding:8px; border:1px solid #ddd; text-align:center;">
               {{ $order->currency }}{{ $ordered_product->total }}
            </td>
         </tr>
      @endforeach
   </tbody>
</table>


                     <div style="height:20px;"></div>

                     <!-- Order Summary -->
                     <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; font-size:14px; color:#333;">
                        <tr>
                           <td style="text-align:right; padding:8px;">Subtotal:</td>
                           <td style="text-align:right; padding:8px;">{{ $order->currency }}{{  number_format($sub_total)  }}</td>
                        </tr>
                        <tr>
                           <td style="text-align:right; padding:8px;">Shipping:</td>
                           <td style="text-align:right; padding:8px;">{{ $order->currency }}{{ optional($order->shipping)->converted_price  ?? '0.00'}} </td>
                        </tr>
                        <tr>
                           <td style="text-align:right; padding:8px;">Coupon:</td>
                           <td style="text-align:right; padding:8px;">
                              {{ $order->coupon ?  $order->coupon.' - %'.$order->voucher()->amount.' off' : '---' }}
                           </td>
                        </tr>
                        <tr>
                           <td style="text-align:right; padding:8px; font-weight:bold;">Total:</td>
                           <td style="text-align:right; padding:8px; font-weight:bold;">{{ $order->currency }}{{  $order->get_total() }}</td>
                        </tr>
                     </table>

                     <div style="height:30px;"></div>

                     <!-- CTA Button -->
                     <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin:0 auto;">
                        <tr>
                           <td align="center" bgcolor="#3F4E4F" style="border-radius:4px;">
                              <a href="https://theaurabydora.com/orders/{{$order->id}}" 
                                 target="_blank" 
                                 style="display:inline-block; padding:12px 24px; font-family:sans-serif; font-size:14px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:4px;">
                                 View Your Order
                              </a>
                           </td>
                        </tr>
                     </table>

                  </td>
               </tr>

            </table>
            <!-- End Wrapper -->

         </td>
      </tr>
   </table>

</body>
</html>
