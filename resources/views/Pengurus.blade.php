
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang Kami - Sanggar Cakra Aji</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #feffc4;
            --yellow: #ffbc4c;
            --green: #91a052;
            --brown: #3c1808;
            --red: #c1272d;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--cream);
            color: var(--brown);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        /* HERO / PENGURUS */

        .about-section {
            background: var(--cream);
            padding: 38px 7.7% 45px;
        }

        .section-label {
            color: #b65b43;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .main-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(30px, 4vw, 45px);
            line-height: 1.12;
            max-width: 550px;
            margin-bottom: 18px;
        }

        .main-description {
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 38px;
            color: #604b3d;
        }

        .team-label {
            margin-bottom: 16px;
        }

        /* CARD */

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .team-card {
            background: white;
            border: 2px solid var(--brown);
            box-shadow: 6px 6px 0 var(--brown);
            min-width: 0;
            transition: transform .25s ease;
        }

        .team-card:hover {
            transform: translateY(-5px);
        }

        .team-photo {
            height: 174px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border-bottom: 2px solid var(--brown);
            position: relative;
            overflow: hidden;
        }

        .team-photo.hijau {
            background: var(--green);
        }

        .team-photo.kuning {
            background: var(--yellow);
        }

        .team-photo.krem {
            background: var(--cream);
        }

        .team-photo.merah {
            background: var(--red);
        }

        .team-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }

        .initials {
            font-family: 'Playfair Display', serif;
            font-size: 52px;
            font-weight: 700;
            z-index: 1;
        }

        .team-photo.merah .initials {
            color: var(--cream);
        }

        .photo-caption {
            position: absolute;
            bottom: 12px;
            font-size: 8px;
            color: rgba(60, 24, 8, .65);
            font-weight: 600;
        }

        .team-info {
            min-height: 96px;
            padding: 11px 14px 13px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .team-name {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.3;
        }

        .role {
            display: inline-block;
            border: 1px solid var(--brown);
            border-radius: 30px;
            padding: 4px 12px;
            font-size: 9px;
            font-weight: 700;
        }

        .role.yellow {
            background: var(--yellow);
        }

        .role.green {
            background: var(--green);
        }

        /* ASISTEN */

        .assistant-section {
            background: var(--yellow);
            border-top: 3px solid var(--brown);
            padding: 42px 7.3% 105px;
        }

        .assistant-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            margin-bottom: 38px;
        }

        .assistant-card .team-photo {
            height: 174px;
        }

        .assistant-card .team-info {
            min-height: 96px;
            justify-content: flex-start;
        }

        /* CTA */

        .cta-section {
            background: var(--green);
            border-top: 3px solid var(--brown);
            padding: 30px 7.5% 35px;
        }

        .cta-box {
            background: var(--brown);
            border-radius: 20px;
            padding: 27px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 9px 9px 0 var(--cream);
        }

        .cta-title {
            color: var(--cream);
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            margin-bottom: 5px;
        }

        .cta-description {
            color: #e4d6b6;
            font-size: 11px;
        }

        .cta-button {
            display: inline-block;
            background: var(--yellow);
            color: var(--brown);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: 30px;
            white-space: nowrap;
            transition: .2s;
        }

        .cta-button:hover {
            background: var(--cream);
            transform: translateY(-2px);
        }

        /* TABLET */

        @media (max-width: 900px) {
            .team-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
            }

            .about-section {
                padding: 35px 6%;
            }

            .assistant-section {
                padding: 40px 6% 75px;
            }

            .team-photo,
            .assistant-card .team-photo {
                height: 190px;
            }
        }

        /* HP */

        @media (max-width: 600px) {
            .about-section {
                padding: 30px 20px 40px;
            }

            .main-title {
                font-size: 32px;
            }

            .main-description {
                font-size: 12px;
                margin-bottom: 30px;
            }

            .team-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
                column-gap: 13px;
            }

            .team-card {
                box-shadow: 4px 4px 0 var(--brown);
            }

            .team-photo,
            .assistant-card .team-photo {
                height: 135px;
            }

            .initials {
                font-size: 40px;
            }

            .team-info {
                min-height: 95px;
                padding: 10px;
            }

            .team-name {
                font-size: 12px;
            }

            .role {
                font-size: 8px;
                padding: 4px 9px;
            }

            .assistant-section {
                padding: 35px 20px 65px;
            }

            .assistant-title {
                font-size: 27px;
                margin-bottom: 25px;
            }

            .cta-section {
                padding: 25px 20px 30px;
            }

            .cta-box {
                flex-direction: column;
                align-items: flex-start;
                padding: 24px 20px;
                gap: 18px;
                border-radius: 16px;
            }

            .cta-title {
                font-size: 19px;
            }

            .cta-description {
                font-size: 10px;
                line-height: 1.6;
            }

            .cta-button {
                padding: 11px 25px;
            }
        }

        @media (max-width: 350px) {
            .team-grid {
                grid-template-columns: 1fr;
            }

            .team-photo,
            .assistant-card .team-photo {
                height: 180px;
            }
        }
    </style>
</head>

<body>

    {{-- NAVBAR YANG SUDAH ADA --}}
    @include('components.navbar')


    {{-- BAGIAN PENGURUS --}}
    <section class="about-section">

        <p class="section-label">Pengurus</p>

        <h1 class="main-title">
            Tangan-tangan yang<br>
            merawat bunyi.
        </h1>

        <p class="main-description">
            Pelatih, asisten, dan admin yang menemani setiap latihan
            di Sanggar Seni Cakra Aji.
        </p>

        <p class="section-label team-label">
            Pelatih & Admin
        </p>

        <div class="team-grid">

            @foreach ($pengurus as $orang)

                <div class="team-card">

                    <div class="team-photo {{ $orang['warna'] }}">

                        @if ($orang['foto'])
                            <img src="{{ asset($orang['foto']) }}"
                                 alt="{{ $orang['nama'] }}">
                        @else
                            <span class="initials">
                                {{ $orang['inisial'] }}
                            </span>

                            <span class="photo-caption">
                                GANTI DENGAN FOTO
                            </span>
                        @endif

                    </div>

                    <div class="team-info">

                        <h3 class="team-name">
                            {{ $orang['nama'] }}
                        </h3>

                        <span class="role {{ $orang['jabatan'] === 'Pelatih' ? 'yellow' : 'green' }}">
                            {{ $orang['jabatan'] }}
                        </span>

                    </div>

                </div>

            @endforeach

        </div>

    </section>


    {{-- BAGIAN ASISTEN PELATIH --}}
    <section class="assistant-section">

        <p class="section-label">
            Bersama Para Pelatih
        </p>

        <h2 class="assistant-title">
            Asisten Pelatih
        </h2>

        <div class="team-grid">

            @foreach ($asisten as $orang)

                <div class="team-card assistant-card">

                    <div class="team-photo {{ $orang['warna'] }}">

                        @if ($orang['foto'])
                            <img src="{{ asset($orang['foto']) }}"
                                 alt="{{ $orang['nama'] }}">
                        @else
                            <span class="initials">
                                {{ $orang['inisial'] }}
                            </span>

                            <span class="photo-caption">
                                GANTI DENGAN FOTO
                            </span>
                        @endif

                    </div>

                    <div class="team-info">

                        <h3 class="team-name">
                            {{ $orang['nama'] }}
                        </h3>

                    </div>

                </div>

            @endforeach

        </div>

    </section>


    {{-- AJAKAN MENDAFTAR --}}
    <section class="cta-section">

        <div class="cta-box">

            <div>
                <h2 class="cta-title">
                    Ingin ikut berlatih bersama kami?
                </h2>

                <p class="cta-description">
                    Daftar jadi murid dan mulai belajar karawitan
                    di Sanggar Seni Cakra Aji.
                </p>
            </div>

            <a href="{{ url('/pendaftaran') }}" class="cta-button">
                Daftar Murid
            </a>

        </div>

    </section>


    {{-- FOOTER YANG SUDAH ADA --}}
    @include('components.footer')


</body>
</html>
