<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman Ruangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
            color: #333333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        
        .header h2 {
            color: #64748b;
            font-size: 18px;
            margin: 5px 0 0 0;
            font-weight: normal;
        }
        
        .document-info {
            text-align: center;
            margin-bottom: 30px;
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .document-info h3 {
            color: #059669;
            font-size: 20px;
            margin: 0;
            font-weight: bold;
        }
        
        .document-info p {
            color: #64748b;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        
        .booking-details {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .booking-details-header {
            background-color: #f1f5f9;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .booking-details-header h4 {
            color: #1e293b;
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }
        
        .booking-details-content {
            padding: 20px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 10px;
        }
        
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .detail-label {
            width: 40%;
            font-weight: bold;
            color: #475569;
            font-size: 14px;
        }
        
        .detail-value {
            width: 60%;
            color: #1e293b;
            font-size: 14px;
        }
        
        .status-approved {
            background-color: #dcfce7;
            color: #166534;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
        }
        
        .purpose-section {
            background-color: #fefce8;
            border: 1px solid #fde047;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .purpose-section h5 {
            color: #854d0e;
            font-size: 14px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        
        .purpose-text {
            color: #713f12;
            font-size: 14px;
            line-height: 1.5;
            white-space: pre-wrap;
        }
        
        .admin-note {
            background-color: #eff6ff;
            border: 1px solid #3b82f6;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .admin-note h5 {
            color: #1d4ed8;
            font-size: 14px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        
        .admin-note-text {
            color: #1e40af;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
        
        .footer p {
            color: #64748b;
            font-size: 12px;
            margin: 5px 0;
        }
        
        .verification-info {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
        }
        
        .verification-info h5 {
            color: #0c4a6e;
            font-size: 14px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        
        .verification-code {
            color: #0369a1;
            font-size: 16px;
            font-weight: bold;
            font-family: monospace;
            letter-spacing: 2px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .header {
                page-break-inside: avoid;
            }
            
            .booking-details {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>SISTEM PEMINJAMAN GEDUNG</h1>
        <h2>Bukti Persetujuan Peminjaman Ruangan</h2>
    </div>

    <!-- Document Info -->
    <div class="document-info">
        <h3>PEMINJAMAN DISETUJUI</h3>
        <p>Dokumen ini merupakan bukti resmi persetujuan peminjaman ruangan</p>
    </div>

    <!-- Booking Details -->
    <div class="booking-details">
        <div class="booking-details-header">
            <h4>Informasi Peminjaman</h4>
        </div>
        <div class="booking-details-content">
            <div class="detail-row">
                <div class="detail-label">Nama Peminjam:</div>
                <div class="detail-value">{{ $peminjaman->user->name }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value">{{ $peminjaman->user->email }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Ruangan:</div>
                <div class="detail-value">{{ $peminjaman->ruangan->nama }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Gedung:</div>
                <div class="detail-value">{{ $peminjaman->ruangan->gedung->nama }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Kapasitas:</div>
                <div class="detail-value">{{ $peminjaman->ruangan->kapasitas }} orang</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Tanggal Peminjaman:</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal)->isoFormat('dddd, D MMMM Y') }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Waktu:</div>
                <div class="detail-value">{{ $peminjaman->jam_mulai }} - {{ $peminjaman->jam_selesai }} WIB</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">
                    <span class="status-approved">✓ DISETUJUI</span>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Tanggal Pengajuan:</div>
                <div class="detail-value">{{ $peminjaman->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Tanggal Persetujuan:</div>
                <div class="detail-value">{{ $peminjaman->updated_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</div>
            </div>
            
            <!-- Purpose Section -->
            <div class="purpose-section">
                <h5>Tujuan Peminjaman:</h5>
                <div class="purpose-text">{{ $peminjaman->tujuan }}</div>
            </div>
            
            <!-- Admin Note (if exists) -->
            @if($peminjaman->catatan_admin)
            <div class="admin-note">
                <h5>Catatan Administrator:</h5>
                <div class="admin-note-text">{{ $peminjaman->catatan_admin }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Verification Info -->
    <div class="verification-info">
        <h5>Kode Verifikasi Dokumen</h5>
        <div class="verification-code">{{ strtoupper(substr(md5($peminjaman->id . $peminjaman->created_at), 0, 8)) }}</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Dokumen ini dibuat secara otomatis oleh Sistem Peminjaman Gedung</strong></p>
        <p>Dicetak pada: {{ now()->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
        <p>Harap simpan dokumen ini sebagai bukti peminjaman yang sah</p>
        <p style="margin-top: 15px; font-size: 10px; color: #94a3b8;">
            Dokumen ini hanya berlaku untuk peminjaman yang tercantum di atas.<br>
            Untuk verifikasi, hubungi administrator dengan menyertakan kode verifikasi.
        </p>
    </div>
</body>
</html>