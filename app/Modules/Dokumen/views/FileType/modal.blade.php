<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
    <i class="fa fa-eye"></i>&nbsp;
</button>
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">List Tipe `{{$d->nama}}` </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" >
                        <tr>
                            <th>No</th>
                            <th>Tipe</th>
                            <th>Action</th>
                        </tr>
                        @php $n=1; @endphp
                    @foreach (collect($detail)->where('unitkerja_kode',$d->unitkerja_kode) as $det)
                        <tr>
                            <td>{{$n}}</td>
                            <td>{{$det->name}}</td>
                            <td>
                            <button >
                            </button>
                            </td>
                        </tr>
                    @php $n++; @endphp
                    @endforeach
                </table>
                
            </div>

            <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                
            </div>
            
        </div>            
    </div>
</div>