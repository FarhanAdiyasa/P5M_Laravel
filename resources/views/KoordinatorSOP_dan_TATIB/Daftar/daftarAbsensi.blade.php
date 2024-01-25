@extends('KoordinatorSOP_dan_TATIB.layout.header')
@section('style')
<style>
#overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7); 
    z-index: 9999;
}

</style>
@endsection
@section('konten')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Import Absensi</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Absensi</li>
                <li class="breadcrumb-item active" aria-current="page">Import Absensi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card recent-sales overflow-auto">
            <div class="card-body">
                <br>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-warning">{{ session('error') }}</div>
                @endif
                <div class="container">
                    <div class="row" >
                            <form method="post" action="{{ url('/import') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>Pilih file excel</label>
                                            <div class="form-group">
                                                <input type="file" name="file" required="required">
                                            </div>
                                        </div>
                                        <div class="col-2 mt-3">
                                            <button type="submit" onclick="handleFormSubmission()" class="btn btn-primary">Import</button>
                                        </div>
                                        <div class="col-7 mt-3 text-right">
                                            File excel di export dari mesin absensi <a href="{{ url('/download/template') }}">download template</a> untuk menyesuaikan. Pastikan file excel berformat xlsx!.
                                        </div>
                                    </div>
                                </div>
                              
                                
                            </form>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <div id="overlay" style="display:none;"></div>
</main>

@endsection


@section('script')
<script>
    function handleFormSubmission() {
        document.getElementById('overlay').style.display = 'block';
    }
</script>
@endsection