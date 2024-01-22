@extends('admin.layouts.app')

@section('content')


<div class="row">
        <div class="col-md-12">
        <div class="text-right">
        <a href="javascript:void(0)" onclick="confirm('Are you sure?') ? $('#form-products').submit() : false;" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                    <i class="material-icons">close</i>
                </a>
    
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
        
                <div class="card-content">
                    
                    
                    <h4 class="card-title">Activities</h4>
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="material-datatables">
                    <form action="#" method="post" enctype="multipart/form-data" id="form-products">
                        {{csrf_field()}}
                
                        <table id="datatables" class="table table-striped table-shopping table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="">Activity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="">Activity</th>
                                    <th>Date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($activities as $activity)  
                                    <tr>
                                        <td class="text-left">{{ optional($activity->user)->name }}</td>
                                         <td class="">
                                             <div  style="height: {{ $activity->json ? '150px' : null }}; overflow-y: scroll;">
                                                
                                                {{ optional($activity->user)->name }} 
                                                <?php echo  html_entity_decode($activity->action) ?>  <br/>
                                                @if ($activity->json)
                                                    <?php $jsons =  json_decode($activity->json,true );  ?>
                                                    
                                                    @foreach($jsons as $json)
                                                        Name:  {{ $json['name']}} <br/> 
                                                        Price:  {{ $json['price']}} <br/>
                                                        Qty:  {{ $json['quantity']}} <br/>
                                                        Sale Price:  {{ $json['sale_price']}} <br/>
                                                    <hr />
                                                    @endforeach
                                                @endif
                                            
                                            </div>
                                            
                                        
                                        </td>
                                        <td>{{  $activity->created_at }}</td>
                                    </tr>
                                @endforeach  
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div><!-- end content-->
            </div><!--  end card  -->
        </div> <!-- end col-md-12 -->
    </div> <!-- end row -->




@endsection
@section('pagespecificscripts')
<script src="/asset/js/jquery.datatables.js"></script>
@stop


@section('inline-scripts')
$(document).ready(function() {
		$('#datatables').DataTable({
            "autoWidth": true,
			"pagingType": "full_numbers",
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			responsive: true,
			language: {
			search: "_INPUT_",
			searchPlaceholder: "Search records",
            
			}

		});

	});
@stop







