@php
$isAdminRoute = request()->is('admin*') || request()->is('*/admin*') || (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), '/admin'));
if (!isset($query) && isset($id)) {
    $query = DB::table('query_master')->where('id', $id)->first();
}
$abc = marked_closed($id);
if ($abc) {
    $closed = $abc->is_closed;
} else {
    $closed = 0;
}
@endphp
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabels">
        @if($type == 1)
        Query Details / प्रश्न विवरण
        @elseif($isAdminRoute && Auth::guard('admin')->check())
        Send Reminder / अनुस्मारक भेजें
        @else
        Query Reply / संशय/आपत्ति का उत्तर दें
        @endif
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    @if(isset($query))
    <div class="card mb-3" style="background-color: #fcf8fa; border: 1px solid #e2d2dc; border-left: 4px solid #6f125a;">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    @if(!empty($query->query_subject))
                        <h6 class="mb-1 text-primary"><strong>Subject / विषय:</strong> {{ $query->query_subject }}</h6>
                    @endif
                    <p class="mb-1"><strong>Query Remark / प्रश्न टिप्पणी:</strong> {{ $query->query_details ?? '--' }}</p>
                    <small class="text-muted"><strong>Query Raised On / प्रश्न उठाया गया:</strong> {{ dmy($query->trans_date ?? $query->created_at ?? date('Y-m-d')) }}</small>
                </div>
                <div class="col-md-4 text-md-end text-start mt-2 mt-md-0">
                    <strong>Query Related Document<br>प्रश्न संबंधित दस्तावेज़:</strong><br>
                    @if(!empty($query->query_doc))
                        @php
                            $q_img = url('public/queryDoc').'/'.$query->query_doc;
                            $q_img1 = url('public/images/images.svg');
                            $q_doc = explode('.',$query->query_doc);
                            $q_ext = isset($q_doc[1]) ? strtolower($q_doc[1]) : '';
                            if($q_ext == 'pdf') $q_img1 = url('public/images/pdf.svg');
                        @endphp
                        <a href="{{ $q_img }}" target="_blank" class="d-inline-flex align-items-center gap-1 mt-1 text-decoration-none">
                            <img src="{{ $q_img1 }}" onclick="appendImage('{{$q_img}}','{{$q_ext}}')" class="img-fluid img-query" style="max-height: 35px; cursor: pointer;" title="Click to view document" />
                            <span class="btn btn-outline-info btn-sm py-0 px-2 ms-1">View</span>
                        </a>
                    @else
                        <span class="badge bg-light text-muted border">No Document Attached</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($closed == 0 && $type == 0)
    <form action="{{url('directMarkQuery')}}" method="post" enctype="multipart/form-data" class="directMarkQuery" novalidate>
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="col-90">
                    <div class="form-group">
                        <input type="hidden" name="queryIdReply" id="queryIdReply" value="<?= $id; ?>">
                        <input type="hidden" name="queryTypeReply" id="queryTypeReply" value="<?= $type; ?>">

                        <label class="placeholder">Details <span class="text-danger">*</span></label>
                        <textarea class="form-control" required name="is_mark_query_reply" id="is_mark_query_reply" cols="95" rows="2"></textarea>

                        <label>Documents</label>
                        <div class="input-group">
                            <input type="file" name="query_doc" class="query_doc_image_reply form-control" onchange="getfileext(this.value,10)" id="File10" aria-describedby="inputGroupFileAddon05" aria-label="Upload">
                        </div>
                        <span class="note">(File Format: jpeg, jpg, Pdf | Max File Size: 2 MB)</span>

                        <br>
                        <button type="button" class="btn btn-info mt-2" data-bs-dismiss="modal">Back</button>
                        <button type="button" onclick="queryReply()" class="btn btn-success mt-2">Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
    <div class="mt-1 card">
        <div class="card-body">
            <h3 class="bg-light"> Query Replied List </h3>
            <table id="dataTable" class="table table-bordered" border="1" style="border-collapse: collapse; width: 100%;" id="query-form-marked-table">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Type</th>
                        <th>Details</th>
                        <th>Document</th>
                        <th>Date</th>
                        <th>Reply To</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($query))
                    <tr style="background-color: #fdfafc;">
                        <td>1</td>
                        <td><span class="badge bg-primary text-white">Query<br>प्रश्न</span></td>
                        <td>
                            @if(!empty($query->query_subject))
                                <strong>{{ $query->query_subject }}</strong><br>
                            @endif
                            <textarea class="form-control" readonly rows="2">{{ $query->query_details }}</textarea>
                        </td>
                        <td class="text-center">
                            @if(!empty($query->query_doc))
                                @php
                                    $q_img = url('public/queryDoc').'/'.$query->query_doc;
                                    $q_img1 = url('public/images/images.svg');
                                    $q_doc = explode('.',$query->query_doc);
                                    $q_ext = isset($q_doc[1]) ? strtolower($q_doc[1]) : '';
                                    if($q_ext == 'pdf') $q_img1 = url('public/images/pdf.svg');
                                @endphp
                                <a href="{{ $q_img }}" target="_blank">
                                    <img src="{{ $q_img1 }}" onclick="appendImage('{{$q_img}}','{{$q_ext}}')" class="img-fluid img-query" style="max-height: 35px; cursor: pointer;" title="View Query Related Document" />
                                </a>
                            @else
                                --
                            @endif
                        </td>
                        <td>{{ dmy($query->trans_date ?? $query->created_at ?? date('Y-m-d')) }}</td>
                        <td>
                            <small><strong>From:</strong> {{ !empty($query->rso_id) ? rsoName($query->rso_id) : 'Department' }}</small><br>
                            <small><strong>To:</strong> {{ userName($query->user_id, $query->id) }}</small>
                        </td>
                    </tr>
                    @endif

                    @foreach($reply as $key=>$item)
                    <tr>
                        <td>{{ (isset($query) ? 2 : 1) + $key }}</td>
                        <td>
                            @if($item->current_status == "User")
                                <span class="badge bg-success text-white">Reply<br>उत्तर</span>
                            @else
                                <span class="badge bg-info text-white">Reminder<br>अनुस्मारक</span>
                            @endif
                        </td>
                        <td>
                            <textarea class="form-control" readonly rows="2">{{ $item->reply }}</textarea>
                        </td>
                        <td class="text-center">
                            @if($item->reply_doc != '')
                                @php
                                    $img = url('public/queryDoc').'/'.$item->reply_doc;
                                    $img1 = url('public/images/images.svg');
                                    $doc = explode('.',$item->reply_doc);
                                    $ext = isset($doc[1]) ? strtolower($doc[1]) : '';
                                    if($ext == 'pdf') $img1 = url('public/images/pdf.svg');
                                @endphp
                                <a href="{{ $img }}" target="_blank">
                                    <img src="{{$img1}}" onclick="appendImage('{{$img}}','{{$ext}}')" class="img-fluid img-query" style="max-height: 35px; cursor: pointer;" title="View Reply Document" />
                                </a>
                            @else
                                --
                            @endif
                        </td>
                        <td>{{ dmy($item->trans_date) }}</td>
                        <td>
                            @if($item->current_status == "User")
                                <small><strong>From:</strong> Applicant / आवेदक</small><br>
                                <small><strong>To:</strong> {{ rsoName($item->reply_to) }}</small>
                            @else
                                <small><strong>From:</strong> {{ $item->current_status }}</small><br>
                                <small><strong>To:</strong> {{ userName($item->reply_to, $item->query_id) }}</small>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    @if(!isset($query) && count($reply) == 0)
                    <tr>
                        <td colspan="6" class="text-center text-muted">No records found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!---- Self  RSO ---->
</div>