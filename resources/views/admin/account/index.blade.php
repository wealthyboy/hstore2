@extends('admin.layouts.app')
@section('content')

<div class="row">
   <div class="col-md-12">
      <div class="title">
         <h3>Search</h3>
      </div>
      <!-- <form action="" method="get" >
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label class="label-control">From Date</label>
                  <input required type="text" name="from_date" class="form-control datepicker" value=""/>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label class="label-control">To Date</label>
                  <input type="text" name="to_date" required class="form-control datepicker" value=""/>
               </div>
            </div>
            <div class="col-md-4">
               <button type="submit" class="btn mt-2 btn-primary btn-round mb-2">Submit</button>
            </div>
         </div>
      </form> -->
   </div>
</div>
</div>
<div class="row">
   <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <h5 class="card-title text-black">Today's Sales Total (Without shipping)</h3>
               <p class="card-title">{{ $currency }}{{ number_format($tows) ?? 0}}</p>
         </div>
      </div>
   </div>
   <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <h5 class="card-title text-black">Today's Sales Total</h3>
               <p class="card-title">{{ $currency }}{{ number_format($todays_sales->items_total) ?? 0}}</p>


         </div>
      </div>
   </div>
   <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <h5 class="card-title text-black">Items Sold Today</h3>
               <p class="card-title">{{ $todays_orders->qty ?? 0 }}</p>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category">All Products Value</p>
            <h4 class="card-title">{{ $currency }}{{ number_format($total_value->total) ?? 0 }}</h4>
         </div>
      </div>
   </div>

   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category">All Sales</p>
            <h4 class="card-title">{{ number_format($all_sales->qty) }}</h4>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category">Sales Total</p>
            <h4 class="card-title">{{ $currency }}{{ number_format($all_sales_value->items_total) }}</h4>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category"> Remaining Products</p>
            <h4 class="card-title">{{ number_format($remaining_products) }}</h4>
         </div>
      </div>
   </div>

   <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category">Best selling product this week</p>
            <h4 class="card-title">{{ optional(optional($product_variation)->product_variation)->name  }}</h4>
         </div>
      </div>
   </div>

   <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-content">
            <p class="category">Best selling product this month</p>
            <h4 class="card-title">{{ optional(optional($product_variation_month)->product_variation)->name  }}</h4>
         </div>
      </div>
   </div>

</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-content">
            <div class="col-md-12">
               <div class="text-left">
                  <h4 class="card-title">Sales</h4>
               </div>
               <div class="text-right">
               </div>
            </div>
            <div class="toolbar">
               <!--  Here you can write extra buttons/actions for the toolbar-->
            </div>
            <div class="material-datatables">
               <table id="datatables" class="table table-striped table-shopping table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                     <tr>
                        <th>
                           <div class="checkbox">
                              <label>
                                 <input onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" type="checkbox" name="optionsCheckboxes">
                              </label>
                           </div>
                        </th>
                        <th>Customer</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Sku</th>
                        <th>Total</th>
                        <th class="disabled-sorting text-right">Date</th>
                     </tr>
                  </thead>
                  <tbody>

                  </tbody>
               </table>
            </div>
         </div>
         <!-- end content-->
      </div>
      <!--  end card  -->
   </div>
   <!-- end col-md-12 -->
</div>
<!-- end row -->
@endsection

@section('inline-scripts')
$(document).ready(function() {
});
@stop