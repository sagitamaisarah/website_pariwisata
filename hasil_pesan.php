// Fetch data dari database
$sql = "SELECT * FROM pesanan";
$result = $conn->query($sql);

// Simpan ke array
$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

// Cetak tabel
foreach ($rows as $row) {
    echo "<tr>
            <td>{$row['nama_pemesan']}</td>
            <td>{$row['nomor_hp']}</td>
            <td>{$row['jumlah_peserta']}</td>
            <td>{$row['durasi_wisata']}</td>
            <td>" . ($row['layanan_penginapan'] ? 'Y' : 'N') . "</td>
            <td>" . ($row['layanan_transportasi'] ? 'Y' : 'N') . "</td>
            <td>" . ($row['layanan_makanan'] ? 'Y' : 'N') . "</td>
            <td>Rp. " . number_format($row['harga_paket'], 0, ',', '.') . "</td>
            <td>Rp. " . number_format($row['jumlah_tagihan'], 0, ',', '.') . "</td>
            <td class='action-buttons'>
                <a href='#' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#chatModal_{$row['id_pesanan']}'>Chat</a>
            </td>
          </tr>";
}

// Cetak modal
foreach ($rows as $row) {
    echo "
    <div class='modal fade' id='chatModal_{$row['id_pesanan']}' tabindex='-1' role='dialog' aria-labelledby='chatModalLabel_{$row['id_pesanan']}' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Chat dengan Admin - {$row['nama_pemesan']}</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' action='kirim_pesan.php'>
                        <input type='hidden' name='id_pesanan' value='{$row['id_pesanan']}'>
                        <input type='hidden' name='nama_pemesan' value='{$row['nama_pemesan']}'>
                        <div class='form-group'>
                            <textarea class='form-control' name='pesan' placeholder='Tulis keluhan anda...' required></textarea>
                        </div>
                        <button type='submit' class='btn btn-primary'>Kirim</button>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
                </div>
            </div>
        </div>
    </div>";
}
