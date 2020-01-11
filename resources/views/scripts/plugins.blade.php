@if(isset($page_set) && ($page_set == 'list_emp' || $page_set == 'list_salary'))
	<!-- jQuery dataTable core JS Library -->
	<script src="{{ASSET_URL}}assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="{{ASSET_URL}}assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
	<!-- initialize Js-->
	<script src="{{ASSET_URL}}assets/js/datatableInt.js"></script>
	<script src="{{ASSET_URL}}assets/js/common.js"></script>
@endif
