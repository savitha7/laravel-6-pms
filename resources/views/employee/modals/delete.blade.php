<div class="modal fade" id="delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form role="form" method="post">
            <div class="modal-body">
                <p class="delete_note"></p>
            </div>
            <div class="modal-footer">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger btn-sm">Yes</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->