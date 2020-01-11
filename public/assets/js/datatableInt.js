var vars = {};
var dataTableInit = function () {   
    
    var handleDataTable_init = function(getData,options) { 
		    var table_unique = $('#'+getData.ID).data('id');
		    var callback_function = $('#'+getData.ID).data('callback');
            var method_prefix = "success_"; 
			
			var append = '';
			if(typeof table_unique !== 'undefined' && table_unique !== ''){
				append = table_unique;
			}

			var dtOptions = {
				processing: true,
				serverSide: true,
				"ajax": {
					"url":getData.URL,
					"type":"POST",
					"data":function ( d ) { 
						Object.assign(d,options.data);					
					}
				},			
				columnDefs: [{
					className: 'mdl-data-table__cell--non-numeric',
					targets: options.targets, 
					orderable:false
				}], 
				lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],pageLength: 50,
				aaSorting: [],
				bAutoWidth: true,
				sScrollX: "100%",
				sScrollXInner: "100%",
				order: [],
				scrollCollapse: true,
				language: {
					search: "_INPUT_",
					searchPlaceholder: "Search",
					zeroRecords:options.zeroRecord
				},				
				initComplete: function( settings, json ) {
					if(typeof callback_function !== 'undefined'){
						window[method_prefix+callback_function](json,getData.ID);
					}
				},
				fnDrawCallback: function( oSettings ) {
					/*var api = this.api();
					var resjson = api.ajax.json();
					if(typeof callback_function !== 'undefined'){
						setTimeout(function(){
							window[method_prefix+callback_function](resjson,getData.ID); 
						}, 1000);						
					}*/
				}
			};

        	if(!$.isEmptyObject(options.options)){
                Object.assign(dtOptions,options.options)
			}

			var table_inti = $('#'+getData.ID).DataTable(dtOptions);
			vars['init'+append] = table_inti;
			//console.log(vars);
    }
    return {
        //main function to initiate the module
        init: function (getData,getOptions) {	
			handleDataTable_init(getData,getOptions);	
        }

    };
}();

function initDataTable(tableid,action,options){ 
	//call submitHandler
	if(tableid !== ''){
		options = options || 0;		
		var sendData = {ID:tableid,URL:action};
		var dataObj = {_token:new_csrfToken,table:tableid};
		var sendOptions = {
			data:(typeof options.data === "undefined")?dataObj:Object.assign(dataObj,options.data),
			zeroRecord:(typeof options.zeroRecord === "undefined")?'<div class="col-sm-12"><div class="empty-view text-center"><p>No Record</p></div></div>':'<div class="col-sm-12"><div class="empty-view text-center"><p>'+options.zeroRecord+'</p></div></div>',
			targets:(typeof options.targets === "undefined")?[]:options.targets,
            options:(typeof options.dt_options === "undefined")?{}:options.dt_options
		};

		dataTableInit.init(sendData,sendOptions);
	}
}