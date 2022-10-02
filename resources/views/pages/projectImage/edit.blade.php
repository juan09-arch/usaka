@extends('layouts.app')

@section('title',"USAKA | PROJECT")

@section('content')
     <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

    <form method="POST" id="editProject" action="{{ route('dashboard.image.update',$projectImage->id) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col">
                        <div class="card card-success">
                            <div class="card-header">
                            {{-- <h3 class="card-title"></h3> --}}
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="hidden" name="id_project" value="{{ $projectImage->id_project }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <div class="preview mb-2">
                                                <img id="file-ip-1-preview" src="/image/{{ $projectImage->image }}">
                                                {{-- <img src="/image/{{ $projectImage->image }}"> --}}
                                            </div>
                                            <label class="mr-3" for="file-ip-1">Upload Image</label>
                                            <input class="hidden" type="file" id="file-ip-1" accept="image/*" name="image"
                                                onchange="showPreview(event);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
        <button type="submit" class="btn btn-success float btn-lg">
           Simpan
        </button>
    </form>

</div>
<!-- /.content-wrapper -->
@endsection

{{-- THIS SCRIPT ONLY RENDER FOR THIS PAGE --}}
@push('script')
   <script>
    function showPreview(event) {
                if (event.target.files.length > 0) {
                    var src = URL.createObjectURL(event.target.files[0]);
                    var preview = document.getElementById("file-ip-1-preview");
                    preview.src = src;
                    preview.style.display = "block";
                }
            }
   </script>
@endpush


{{-- THIS STYLE ONLY RENDER FOR THIS PAGE --}}
@push('style')
<style>

.float{
	position:fixed;
	bottom:40px;
	right:40px;
	color:#FFF;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:22px;
}
</style>
@endpush

