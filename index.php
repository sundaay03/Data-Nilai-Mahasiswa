<?php
$matkul = [
    [
        "nama"  => "Pemrograman Web",
        "sks"   => 3,
        "nilai" => 88
    ],
    [
        "nama"  => "Struktur Data & Algoritma",
        "sks"   => 3,
        "nilai" => 76
    ],
    [
        "nama"  => "Basis Data",
        "sks"   => 3,
        "nilai" => 82
    ],
    [
        "nama"  => "Jaringan Komputer",
        "sks"   => 3,
        "nilai" => 52 
    ],
    [
        "nama"  => "Kecerdasan Buatan",
        "sks"   => 3,
        "nilai" => 91
    ]
];

function hitungBobot($nilai) {
    if ($nilai >= 85) {
        return ['huruf' => 'A', 'bobot' => 4.0];
    } elseif ($nilai >= 70) {
        return ['huruf' => 'B', 'bobot' => 3.0];
    } elseif ($nilai >= 55) {
        return ['huruf' => 'C', 'bobot' => 2.0];
    } elseif ($nilai >= 40) {
        return ['huruf' => 'D', 'bobot' => 1.0];
    } else {
        return ['huruf' => 'E', 'bobot' => 0.0];
    }
}

$totalSks = 0;
$totalBobotSks = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transkrip Nilai Semester & Ringkasan IPS</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        h2 {
            margin-top: 0;
            color: #1a202c;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: #2b6cb0;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        tr.baris-mengulang {
            background-color: #fed7d7;
            color: #9b2c2c;
            font-weight: 500;
        }

        tr.baris-mengulang td {
            border-bottom: 1px solid #feb2b2;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-lulus {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge-mengulang {
            background-color: #e53e3e;
            color: #ffffff;
        }

        .summary-card {
            margin-top: 28px;
            padding: 20px;
            background-color: #f7fafc;
            border-radius: 8px;
            border-left: 5px solid #2b6cb0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 15px;
        }

        .summary-item strong {
            color: #2d3748;
        }

        .highlight-ips {
            font-size: 20px;
            font-weight: bold;
            color: #2b6cb0;
        }

        .sks-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e0;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Kartu Hasil Studi (KHS) Mahasiswa</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai Angka</th>
                <th>Nilai Huruf</th>
                <th>Bobot</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($matkul as $mk): 
                $hasil = hitungBobot($mk['nilai']);
                $huruf = $hasil['huruf'];
                $bobot = $hasil['bobot'];

                $isLulus = ($bobot >= 2.0);
                $statusText = $isLulus ? "LULUS" : "MENGULANG";

                $totalSks += $mk['sks'];
                $totalBobotSks += ($mk['sks'] * $bobot);

                $rowClass = !$isLulus ? 'class="baris-mengulang"' : '';
            ?>
            <tr <?= $rowClass ?>>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($mk['nama']) ?></td>
                <td><?= $mk['sks'] ?></td>
                <td><?= $mk['nilai'] ?></td>
                <td><strong><?= $huruf ?></strong></td>
                <td><?= number_format($bobot, 1) ?></td>
                <td>
                    <span class="badge <?= $isLulus ? 'badge-lulus' : 'badge-mengulang' ?>">
                        <?= $statusText ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    $ips = ($totalSks > 0) ? ($totalBobotSks / $totalSks) : 0;

    $maxSks = ($ips >= 3.00) ? 24 : 20;
    ?>

    <div class="summary-card">
        <div class="summary-item">
            <span>Total Beban SKS:</span>
            <strong><?= $totalSks ?> SKS</strong>
        </div>
        <div class="summary-item">
            <span>Total Angka Mutu (SKS &times; Bobot):</span>
            <strong><?= number_format($totalBobotSks, 2) ?></strong>
        </div>
        <div class="summary-item">
            <span>Indeks Prestasi Semester (IPS):</span>
            <span class="highlight-ips"><?= number_format($ips, 2) ?></span>
        </div>
        
        <div class="sks-info">
            <strong>Batas Maksimal Pengambilan SKS Semester Depan:</strong>
            <p style="margin: 6px 0 0 0; color: <?= ($maxSks == 24) ? '#276749' : '#c53030' ?>; font-weight: 600;">
                Berdasarkan capaian IPS (<?= number_format($ips, 2) ?>), Anda berhak mengambil maksimal <u><?= $maxSks ?> SKS</u> pada semester berikutnya.
            </p>
        </div>
    </div>
</div>

</body>
</html>