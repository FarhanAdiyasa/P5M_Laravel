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
                <div class="row">

                    <div class="col-4">
                        <form method="post" action="{{ url('/import') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-7">
                                    <label>Pilih file excel</label>
                                    <div class="form-group">
                                        <input type="file" name="file" required="required">
                                    </div>
                                </div>
                                <div class="col-2 mt-3 mx-5">
                                    <button type="submit" onclick="handleFormSubmission()" class="btn btn-primary">Import</button>
                                    </div>
                            </div>
                        </form>
                    </div>

                    <!-- Add your table or other content here -->

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