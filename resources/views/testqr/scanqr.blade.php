@extends('layouts.admin')

@push('css')

@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Scan QR Code</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Main Content goes here -->
    <!-- Tombol untuk membuka modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#qrModal">
        Buka Modal dengan Scan QR
    </button>

    <!-- Modal -->
    <div class="modal" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">Scan QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Preview video untuk pemindaian QR -->
                    <video id="preview" width="100%" height="100%"></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Main Content -->

    
@endsection

@push('js')
<script src="{{ asset('js/instascan.min.js') }}"></script>
<script>
    let scanner; // Deklarasikan variabel scanner di luar fungsi

    // Fungsi untuk memulai pemindaian QR
    function startQRScanner() {
        // Instansiasi objek Instascan
        scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        // Tangani hasil pemindaian
        scanner.addListener('scan', function (content) {
            $('#qrModal').modal('hide');
            console.log('Hasil Scan QR: ' + content);
            // Di sini Anda dapat menangani hasil pemindaian QR sesuai kebutuhan
        });

        // Mulai pemindaian
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]); // Gunakan kamera pertama yang ditemukan
            } else {
                console.error('Tidak ada kamera yang ditemukan.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    }

    // Tangani peristiwa saat modal ditutup
    $('#qrModal').on('hidden.bs.modal', function () {
        // Hentikan pemindaian saat modal ditutup
        if (scanner) {
            scanner.stop();
        }
    });

    // Panggil fungsi saat modal dibuka
    $('#qrModal').on('shown.bs.modal', function () {
        startQRScanner();
    });
</script>



@endpush
