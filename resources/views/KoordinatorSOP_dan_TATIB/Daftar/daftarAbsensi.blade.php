@extends('KoordinatorSOP_dan_TATIB.layout.header')

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

                        {{-- <!-- Progress Bar -->
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!-- End Progress Bar -->

                        <!-- Progress Message -->
                        <div id="progressMessage"></div>
                        <!-- End Progress Message --> --}}

                    </div>

                    <!-- Add your table or other content here -->

                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

@endsection

@section('script')
<script>
    function updateProgress() {
    console.log("jalan");
    $.ajax({
        url: '/getImportProgress',
        method: 'GET',
        success: function (data) {
            console.log(data); // Corrected from $data to data
            // Update your progress bar
            var progressValue = (data.importedRows / data.totalRows) * 100;
            $('.progress-bar').width(progressValue + "%").attr("aria-valuenow", progressValue);

            // Show progress message
            $('#progressMessage').text(data.importedRows + " out of " + data.totalRows + " records imported");
        },
        error: function (error) {
            console.log(error); // Corrected from $data to error
            console.error('Error fetching import progress:', error);
        }
    });
}

    function handleFormSubmission() {
        setInterval(updateProgress, 1000);
    }
</script>
@endsection
