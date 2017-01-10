{extends file="_centered.tpl"}
{block name=title}{$L.my_snippets}{/block}
{block name="body"}
<div class="container container-table">
<div class="card  mb-3 mt-3">
  <div class="card-block">
		<h1 class="mt-3">{$L.my_snippets}</h1>
    <div class="container">
	<table id="example" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>{$L.name}</th>
                <th>{$L.date}</th>
                <th>{$L.syntax}</th>
                <th>{$L.control}</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>{$L.name}</th>
                <th>{$L.date}</th>
                <th>{$L.syntax}</th>
                <th>{$L.control}</th>
            </tr>
        </tfoot>
        <tbody>
			</tbody></table>
		</div>
	


	</div>
</div>
	</div>
{/block}
{block name="css" append}

<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap4.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap4.min.css " />
{/block}
{block name="js_end" append}
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable({$ldim}   
	"columnDefs": [ {
"targets": 3,
"orderable": false
} ],
	"language": {
            "lengthMenu": "{$L.lengthMenu}",
            "zeroRecords": "{$L.zeroRecords}",
            "info": "{$L.paginfog}",
            "infoEmpty": "{$L.zeroRecords}",
            "infoFiltered": "(filtered from _MAX_ total records)",
	"paginate": {
      "next": "{$L.next}",
	  "previous" : "{$L.previous}"
    }
        },
		"bLengthChange": true,
		searching: false,
	        "processing": true,
        "serverSide": true,
		"ajax": "{$R->Path("MySnippets\\AllSnippetsPage")}",
	"columns": [
    { "data": "title" },
    { "data": "title" },
    { "data": "syntax" },
    { "data": "syntax" }
  ], "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            $('td:eq(0)', nRow).html('<a href="/' + aData.id + '">' +
                aData.title + '</a>');
			var d=new Date(aData.modifiedTime.date);
            $('td:eq(1)', nRow).html(
                d.getMinutes()+':'+d.getHours()+' '+d.getDate()+'.'+(d.getMonth()+1)+'.'+d.getFullYear());
            $('td:eq(3)', nRow).html('<form class="btn-group" action="Edit/'+aData.id+'" method="get"><button class="btn btn-sm btn-info">{$L.edit}</button><input type="hidden" class="btn"></form>'+
	'<form class="btn-group" action="'+aData.id+'" method="delete"><input type="hidden" class="btn "><button class="btn btn-sm btn-danger">{$L.remove}</button></form>');
            return nRow;
        }
	{$rdim});
	$('#example_wrapper').removeClass("form-inline");
	$('#example_wrapper > div:nth-child(2) > div').removeClass("col-xs-12").addClass("col-xl-12");
} );
</script>
{/block}