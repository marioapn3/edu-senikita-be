<html>
<head>
    <style>
        *, html, body {
            margin: 0;
            padding: 0;
            font-family: "Source Sans Pro", sans-serif;
        }

        .page-break {
            page-break-after: always;
        }

        .container {
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
        }

        #certificate {
            width: 1120px;
            height: 790px;
            position: relative;
        }

        .cert {
            color: #3e0e0e;
            background-color: #fff;
            background-image: url("https://eduapi.senikita.my.id/storage/bg-4.png");
            background-position: right bottom;
            background-size: cover;
            background-repeat: no-repeat;
            border: 2px solid #ddd;
            margin: 2em;
            padding: 4em 4em;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        .cert-logo {
            display: flex;
            justify-content: start;
            align-items: center;
            margin-left : 2em;
        }

        .cert-logo-name {
            font-weight: bold;
            margin-left: 0.5em;
            text-align: left;
            text-transform: uppercase;
        }

        .cert-header {
            text-align: center;
        }

        .cert-header .cert-title {
            font-family: "Merriweather", serif;
            font-size: 2em;
            font-weight: normal;
            text-transform: uppercase;
            margin-top: 1em;
        }

        .cert-header .cert-no {
            margin-top: 0.5em;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .cert-content {
            text-align: center;
            margin: 2em 0;
        }

        .cert-content .cert-label {
            font-size: 1.2em;
            text-transform: uppercase;
        }

        .cert-content .cert-course-name {
            color: #A8412A;
            font-family: "Times New Roman";
            font-size: 2.2em;
            margin: 0.5em 0 0.05em;
        }

        .cert-content .cert-user-name {
            color: #A8412A;
            font-family: "Times New Roman";
            font-size: 2.2em;
            margin: 0.5em 0 0.05em;
        }

        .cert-content .cert-achievement {
            font-size: 1.2em;
            text-transform: uppercase;
            font-weight: semi-bold;
            margin-top: 2em;
        }

        .cert-content .cert-signature {
            margin-top: 1.25em;
        }

        .cert-content .cert-signature-sign {
            height: 6em;
        }

        .cert-footer {
    left: 6em;
    right: 2em;
    bottom: 6em; /* dari 2em ke 6em agar naik */
    position: absolute;
    text-align: left;
}


        .cert-qr-image img {
            width: 78px;
            height: 78px;
        }

        .cert-qr-label {
            color: #999;
            font-size: 0.8em;
        }

        .cert-qr-token {
            color: #020202;
            font-size: 1em;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body>
    <div class="container">
        <div id="certificate">
            <div class="cert">
                <div class="cert-header">
                    <div class="cert-logo">
                        <img src="https://eduapi.senikita.my.id/storage/Logo.png" height="40" />
                    </div>

                    <div class="cert-title">Sertifikat Kelulusan</div>
                </div>

                <div class="cert-content">
                    <div class="cert-label">Sertifikat ini ditujukan kepada</div>
                    <div class="cert-user">
                        <div class="cert-user-name">John Doe</div>
                    </div>
                    <div class="cert-achievement">Telah berhasil menyelesaikan pelatihan</div>
                    <div class="cert-course-name">Mencanting Batik Cendrawasih</div>
                    <div class="cert-signature">
                        <div class="">Minggu, 11 Mei 2025</div>
                        <div class="cert-signature-sign">
                            <img src="https://user-images.githubusercontent.com/116018376/265188266-256dfa47-0792-40e6-885e-3870fad0efe7.png" alt="" width="230">
                        </div>
                        <div style="font-weight: bold;">Mario Aprilnino Prasetyo</div>
                        <div>Chief Technology Officer Devlearn</div>
                        <div class="cert-footer">
                            <div class="cert-qr-token">Tanggal Penyelesaian : 11 Mei 2025</div>
                            <div class="cert-qr-token">Sertifikat ID : CERT123456789</div>
                            <div class="cert-qr-label">Sertifikat ini sebagai tanda bahwa pengguna telah menyelesaikan pelatihan kursus dari awal hingga akhir</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
