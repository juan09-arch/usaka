@extends('layouts.app')

@section('title',"USAKA | PROJECT")

@section('content')
     <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

    <form method="POST" id="editProject" action="{{ route('dashboard.project.update',$project->id) }}">
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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mr-3" for="title">Nama:</label>
                                            <input type="text" id="title" name="title" value="{{ $project->title }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mr-3" for="description">Keterangan :</label>
                                            <input type="text" class="form-control" id="description" name="description" value="{{ $project->description }} ">
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
       $(function(){
           let editProject = $("form#editProject");

      
            editProject.on("submit",function(event){
                event.preventDefault();

                let data = $(this).serialize();
                let url = $(this).attr("action");
                
                $.ajax({
                    url:url,
                    method:"POST",
                    data:data,
                    dataType:"JSON",
                    success:function(res){
                        showNotification(res.message, "success", 3000);
                        window.location.href = "{{ route('dashboard.project.index') }}";
                    },
                    error:function(res){
                        let data = res.responseJSON;
                        showNotification(data.message, "error", 3000);
                    }
                    
                })
            })


       });
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

