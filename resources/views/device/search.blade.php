@extends('master.master')

@section('title')
	Search Device
@endsection

@section('content')
	<div>
		<form name="frm_search" action="" id="frm_search" method="post">
			<div>
				<label for="devicename">Device Name : </label>
				<input type="text" name="devicename" id="devicename" placeholder="Device Name" value="" />
			</div>

			<div>
				<input type="hidden" name="_token" id="hid_token" value="{{Session::token()}}" />
			</div>

			<div>
				<input type="button" name="btn_search" id="btn_search" value="Search" />
			</div>

		</form>
	</div>

	<div id="res">
		
	</div>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			searchDevice();
		});

		$('#btn_search').click(function(){
			searchDevice();
		});

		function searchDevice(){
			var devicename	=	$('#devicename').val();
			var token 		=	$('#hid_token').val();
			var url			=	"{{route('searchdevice')}}";
			var	date		=	new Date();
			var timechange	=	date.getTimezoneOffset();

			$.post(url
					,{
						'devicename':devicename
						,'_token':token
					}
					,function(res){
						//console.log(res);return false;
						if(res){
							var obj		=	$.parseJSON(res);
							var tbl 	=	"<table border=1 id='tbl_device'>";
								tbl 	+=	"<thead>";
								tbl 	+=	"<tr>";
								tbl 	+=	"<th>Sl No.</th>";
								tbl 	+=	"<th>Device Label</th>";
								tbl 	+=	"<th>Last Update Time</th>";
								tbl 	+=	"<th>Last Status</th>";
								tbl 	+=	"</tr>";
								tbl 	+=	"</thead>";
							if(!obj.fail){
								$.each(obj,function(i,item){
									var last_date	=	new Date(item.last_status +timechange);
									
									var lastmonth	=	(last_date.getMonth()+1)<'10' ? '0'+last_date.getMonth():last_date.getMonth();
									var lastday		=	last_date.getDate()<'10'?'0'+last_date.getDate():last_date.getDate();
									var lasthour	=	last_date.getHours()<'10'?'0'+last_date.getHours():last_date.getHours();
									var lastmin		=	last_date.getMinutes()<'10'?'0'+last_date.getMinutes():last_date.getMinutes();
									var lastsec		=	last_date.getSeconds()<'10'?'0'+last_date.getSeconds():last_date.getSeconds();
									last_date		=	last_date.getFullYear()+'-'+lastmonth+'-'+ lastday+' '+lasthour+':'+lastmin+':'+lastsec;
									tbl 	+=	"<tbody>";
									tbl 	+=	"<tr>";
									tbl 	+=	"<td>"+ ++i +"</td>";
									tbl 	+=	"<td>"+item.device_name.substr(0,1).toUpperCase()+item.device_name.substr(1,item.device_name.length)+"</td>";
									tbl 	+=	"<td>"+last_date+"</td>";
									tbl 	+=	"<td class='"+item.background+"'>"+item.status.toUpperCase()+"</td>";

									tbl 	+=	"</tr>";
									tbl 	+=	"</tbody>";
								});
								
							}else{
									tbl 	+=	"<tbody>";
									tbl 	+=	"<tr>";
									tbl 	+=	"<td></td>";
									tbl 	+=	"<td class='nodata'>"+obj.msg+"</td>";
									tbl 	+=	"<td></td>";
									tbl 	+=	"<td></td>";
									tbl 	+=	"</tr>";
									tbl 	+=	"</tbody>";
							}

							tbl 	+=	"</table>";

							$('#res').html(tbl);
							$('#tbl_device').DataTable(
								{
									bFilter: false
									, bInfo: false
								},
								  
							);
								
						}
					}
			);
		}
	</script>


@endsection