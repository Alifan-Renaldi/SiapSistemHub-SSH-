<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title style="font-size: 100px; font-weight: bold;">QR Code Mobil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 10px;
            justify-content: center;
            align-items: center;
            padding-left: 70px;
            padding-top: 100px;
        }

        .qr-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
            padding: 40px 36px 32px;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .qr-card__title {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .qr-card__image-wrapper {
            display: inline-block;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 24px;
            background: #fff;
        }

        .qr-card__image-wrapper img {
            display: block;
            width: 450px;
            height: 450px;
        }

        .qr-card__info {
            text-align: left;
            border-top: 1px solid #e9ecef;
            padding-top: 20px;
        }

        .qr-card__row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }

        .qr-card__row + .qr-card__row {
            border-top: 1px solid #f1f3f5;
        }

        .qr-card__label {
            font-size: 18px;
            font-weight: 600;
            color: #212529;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .qr-card__value {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
        }

        .qr-card__value--nopol {
            font-size: 18px;
            color: #2c3e50;
        }

        .qr-card__actions {
            margin-top: 24px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn--download {
            background: #3085d6;
            color: #fff;
        }

        .btn--download:hover {
            background: #2574c2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(48, 133, 214, 0.3);
        }

        .btn--print {
            background: #28a745;
            color: #fff;
        }

        .btn--print:hover {
            background: #219a3b;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .qr-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
            .qr-card__actions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div>
        <div class="container-fluid">
            <div class="qr-card">
                <div class="qr-card__title">Vehicle QR Code</div>

                <div class="qr-card__image-wrapper">
                    <img src="<?= base_url('vehicles/view_qrcode/' . $vehicledetails[0]['v_id']) ?>" alt="QR Code">
                </div>

                <div class="qr-card__info">
                    <div class="qr-card__row">
                        <span class="qr-card__label">Nopol</span>
                        <span class="qr-card__value qr-card__value--nopol"><?= esc($vehicledetails[0]['v_registration_no']) ?></span>
                    </div>
                    <div class="qr-card__row">
                        <span class="qr-card__label">Nama Kendaraan</span>
                        <span class="qr-card__value"><?= esc($vehicledetails[0]['v_name']) ?></span>
                    </div>
                    <div class="qr-card__row">
                        <span class="qr-card__label">Tipe Kendaraan</span>
                        <span class="qr-card__value"><?= esc($vehicledetails[0]['v_type']) ?></span>
                    </div>
                </div>
            </div>

        <!-- <div class="qr-card__actions">
            <button class="btn btn--print" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print
            </button>
        </div> -->
    </div>
        <script>
        window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);

                setTimeout(function() {
                    window.location.href = "<?= base_url('vehicles/vehicles_management'); ?>";
                }, 2000);
            };
        </script>
</body>
</html>
