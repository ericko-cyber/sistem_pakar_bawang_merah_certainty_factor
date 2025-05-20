@extends('layouts.diagnosa.masterdiagnosa')

@section('title', 'Diagnosa Penyakit Bawang Merah')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<style>
    .select-wrapper {
        flex-grow: 1;
    }

    .gejala-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        width: 100%;
    }

    .container {
        /* max-width: 100% !important; */
        padding: 0 !important;
    }

    .alert-help {
        background-color: #f8f9fa;
        border-left: 4px solid #eb512a;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .cf-info {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 5px;
    }

    /* Overlay loading */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        visibility: hidden;
        /* Tampilkan atau sembunyikan overlay sesuai kebutuhan */
    }


    .progress-container {
        display: flex;
        flex-direction: column;
        /* Susun spinner dan teks secara vertikal */
        align-items: center;
        /* Tengah horizontal */
        justify-content: center;
        /* Tengah vertikal jika dibutuhkan */
        width: 100%;
        max-width: 300px;
        text-align: center;
        animation: spin 4s linear infinite;
    }


    .progress-text {
        margin-top: 10px;
        font-weight: bold;
    }
</style>


<div class="main-banner wow fadeIn" id="diagnosa" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="align-self-center">
                        <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                            <h2>Mulai<em> Diagnosa</em> <span>Sekarang</span></h2><br>
                            <div class="align-self-center text-center">
                                <h5>Cari tahu penyakit dan gejala dengan menekan tombol di bawah ini.</h5><br>
                                <a href="{{ route('detailpenyakit') }}" class="main-red-button">Pelajari Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="mt-1 mb-5">
            <div class="col-10 offset-1 mt-5">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #eb512a;">
                        <h5 class="mb-0">Form Diagnosa Penyakit Bawang Merah</h5>
                    </div>
                    <div class="card-body">
                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                        @endif

                        <div class="alert-help">
                            <strong>Petunjuk Penggunaan:</strong>
                            <ol>
                                <li>Pilih minimal 3 gejala yang terlihat pada tanaman bawang merah Anda</li>
                                <li>Tentukan tingkat keyakinan (Certainty Factor) untuk setiap gejala</li>
                                <li>Klik tombol "Tambah Gejala" jika ingin menambahkan lebih banyak gejala</li>
                                <li>Klik "Diagnosa Sekarang" untuk melihat hasil diagnosa</li>
                            </ol>
                        </div>

                        <form method="POST" action="{{ route('diagnosa.process') }}" id="contactUSForm">
                            @csrf
                            <p class="mb-3">Silakan pilih gejala yang muncul pada tanaman bawang merah Anda untuk memulai diagnosa:</p>

                            <div id="gejala-container">
                                <div class="form-group gejala-wrapper">
                                    <div class="select-wrapper">
                                        <select name="gejala[]" class="form-control input-lg mt-2 gejala-select">
                                            <option value="">Pilih Gejala</option>
                                            @foreach($gejala_list as $gejala)
                                            <option value="{{ $gejala->id }}">{{ $gejala->nama_gejala }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="select-wrapper">
                                        <select name="cf_user[]" class="form-control input-lg mt-2 cf-select">
                                            <option value="">Kondisi</option>
                                            <option value="1.0">Pasti (100%)</option>
                                            <option value="0.8">Hampir Pasti (80%)</option>
                                            <option value="0.6">Kemungkinan Besar (60%)</option>
                                            <option value="0.4">Mungkin (40%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="cf-info">
                                <p><strong>Keterangan tingkat keyakinan:</strong></p>
                                <ul>
                                    <!-- <li><strong>Pasti (100%)</strong>: Anda yakin 100% gejala ini terjadi</li> -->
                                    <li><strong>Hampir Pasti (80%)</strong>: Anda cukup yakin gejala ini terjadi</li>
                                    <li><strong>Kemungkinan Besar (60%)</strong>: Anda melihat gejala ini ada tapi tidak terlalu jelas</li>
                                    <li><strong>Mungkin (40%)</strong>: Anda tidak yakin tapi ada kemungkinan gejala ini terjadi</li>
                                    <li><strong>Tidak Yakin (20%)</strong>:  Anda sama sekali tidak yakin/tidak tahu</li>
                                </ul>
                            </div>

                            <div class="form-group mt-3 d-flex gap-2">
                                <button type="button" class="btn btn-primary btn-tambah-gejala">
                                    <i class="fa fa-plus"></i> Tambah Gejala
                                </button>
                                <button type="button" class="btn btn-danger btn-hapus-gejala" style="display:none;">
                                    <i class="fa fa-minus"></i> Hapus Gejala
                                </button>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fa fa-search"></i> Diagnosa Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="progress-container">
        <div class="progress-text">Sedang mendiagnosa penyakit bawang merah...</div>
    </div>
</div>

<!-- Data JSON untuk JavaScript -->
<script type="application/json" id="gejalaListData">
    @json($gejala_list)
</script>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    const gejalaList = JSON.parse(document.getElementById('gejalaListData').textContent);
    let choicesInstances = [];

    function getSelectedValues() {
        return $('.gejala-select').map(function() {
            return $(this).val();
        }).get().filter(val => val !== '');
    }

    function initChoicesOnNewSelect(selectElement) {
        if (!$(selectElement).hasClass('choices-initialized')) {
            const instance = new Choices(selectElement, {
                searchEnabled: true,
                searchPlaceholderValue: 'Cari gejala...',
                itemSelectText: '',
                shouldSort: false,
                placeholderValue: selectElement.classList.contains('gejala-select') ? 'Pilih Gejala' : 'Kondisi'
            });

            $(selectElement).addClass('choices-initialized');
            choicesInstances.push({
                el: selectElement,
                instance
            });
        }
    }

    function updateDropdownOptions() {
        const selectedValues = getSelectedValues();

        choicesInstances.forEach(({
            el,
            instance
        }) => {
            const currentValue = $(el).val();

            // Pastikan hanya dropdown gejala yang diproses untuk pilihan gejala
            if ($(el).hasClass('gejala-select')) {
                instance.clearChoices();
                instance.setChoices(
                    [{
                        value: '',
                        label: 'Pilih Gejala',
                        selected: currentValue === ''
                    }].concat(
                        gejalaList.map(g => ({
                            value: g.id,
                            label: `${g.kode_gejala} - ${g.nama_gejala}`, // <- update label jadi kode - nama
                            disabled: selectedValues.includes(String(g.id)) && String(g.id) !== currentValue,
                            selected: String(g.id) === currentValue
                        }))
                    ),
                    'value',
                    'label',
                    true
                );
            }

            // Pastikan dropdown kepastian (cf-select) tidak terpengaruh
            if ($(el).hasClass('cf-select')) {
                instance.clearChoices();
                instance.setChoices(
                    [{
                        value: '',
                        label: 'Kondisi',
                        selected: currentValue === ''
                    }, {
                        value: '0.8',
                        label: 'Hampir Pasti (80%)',
                        selected: currentValue === '0.8'
                    }, {
                        value: '0.6',
                        label: 'Kemungkinan Besar (60%)',
                        selected: currentValue === '0.6'
                    }, {
                        value: '0.4',
                        label: 'Mungkin (40%)',
                        selected: currentValue === '0.4'
                    }, {
                        value: '0.2',
                        label: 'Tidak Yakin (20%)',
                        selected: currentValue === '0.2'
                    }],
                    'value',
                    'label',
                    true
                );
            }
        });

        $(".gejala-wrapper").each(function(index) {
            // $(this).find(".btn-hapus-gejala").toggle(index !== 0);
        });
    }

    $(document).ready(function() {
        // Inisialisasi Choices untuk gejala
        $(".gejala-select").each(function() {
            initChoicesOnNewSelect(this);
        });

        // Inisialisasi Choices untuk kepercayaan
        $(".cf-select").each(function() {
            initChoicesOnNewSelect(this);
        });

        updateDropdownOptions();

        $(".btn-tambah-gejala").click(function() {
            const newDropdown = `
            <div class="form-group gejala-wrapper">
                <div class="select-wrapper">
                    <select name="gejala[]" class="form-control input-lg mt-2 gejala-select">
                        <option value="">Pilih Gejala</option>
                    </select>
                </div>
                <div class="select-wrapper">
                    <select name="cf_user[]" class="form-control input-lg mt-2 cf-select">
                        <option value="">Kondisi</option>
                        <option value="0.8">Hampir Pasti (80%)</option>
                        <option value="0.6">Kemungkinan Besar (60%)</option>
                        <option value="0.4">Mungkin (40%)</option>
                        <option value="0.2">Tidak Yakin (20%)</option>
                    </select>
                </div>
            </div>
            `;


            $("#gejala-container").append(newDropdown);

            const newGejalaSelect = $("#gejala-container .gejala-select").last()[0];
            const newCfSelect = $("#gejala-container .cf-select").last()[0];

            initChoicesOnNewSelect(newGejalaSelect);
            initChoicesOnNewSelect(newCfSelect);

            updateDropdownOptions();
            // Menampilkan tombol hapus di samping tombol tambah gejala
            $(".btn-hapus-gejala").show();
        });

        $(".btn-hapus-gejala").click(function() {
            const wrappers = $(".gejala-wrapper");
            if (wrappers.length > 1) {
                const lastWrapper = wrappers.last();
                const gejalaSelect = lastWrapper.find('.gejala-select')[0];
                const cfSelect = lastWrapper.find('.cf-select')[0];

                // Simpan dulu kedua index
                const gejalaInstance = choicesInstances.find(ci => ci.el === gejalaSelect);
                const cfInstance = choicesInstances.find(ci => ci.el === cfSelect);

                // Hapus instansi jika ada
                if (gejalaInstance) {
                    gejalaInstance.instance.destroy();
                    choicesInstances = choicesInstances.filter(ci => ci.el !== gejalaSelect);
                }

                if (cfInstance) {
                    cfInstance.instance.destroy();
                    choicesInstances = choicesInstances.filter(ci => ci.el !== cfSelect);
                }

                // Hapus elemen terakhir
                lastWrapper.remove();

                // Perbarui dropdown
                updateDropdownOptions();
            }

            // Sembunyikan tombol hapus jika tinggal satu
            if ($(".gejala-wrapper").length <= 1) {
                $(".btn-hapus-gejala").hide();
            }
        });

        $(document).on('change', '.gejala-select, .cf-select', function() {
            updateDropdownOptions();
        });

        $('#contactUSForm').on('submit', function(e) {
            const selected = getSelectedValues();
            const cfValues = $('.cf-select').map(function() {
                return $(this).val();
            }).get();

            if (selected.length < 3) {
                e.preventDefault();
                alert('Silakan pilih minimal 3 gejala untuk dapat melakukan diagnosa yang akurat.');
                return;
            }

            if (new Set(selected).size !== selected.length) {
                e.preventDefault();
                alert('Terdapat gejala yang dipilih lebih dari satu kali. Harap pilih gejala yang berbeda.');
                return;
            }

            if (cfValues.includes("")) {
                e.preventDefault();
                alert('Silakan pilih kondisi kepastian (CF) untuk setiap gejala yang dipilih.');
                return;
            }

            // Tampilkan loading overlay saat form di-submit
            document.getElementById('loadingOverlay').style.visibility = 'visible';
        });
    });
</script>

@endsection