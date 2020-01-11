<script type="text/javascript">
	var BASE_URL = "{{ url('/') }}";        
	var APP_URL = "{{ env('APP_URL') }}";      
	
	var new_csrfToken = '{{ csrf_token() }}';
	setInterval(refreshToken, 3600000); // 1 hour
	   
	function refreshToken(){
		$.get('/refresh-csrf').done(function(data){
			new_csrfToken = data; // the new token
		});            
	}
	
	var PAGE_SET = '<?php echo isset($page_set)?$page_set:''; ?>';
</script>
<script src="{{ASSET_URL}}assets/js/jquery.min.js"></script>