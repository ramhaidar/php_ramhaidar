<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "testdb";

$koneksi = new mysqli( $servername, $username, $password, $dbname );

if ( $koneksi->connect_error )
{
    die ( "Koneksi gagal: " . $koneksi->connect_error );
}

function tampilkanLaporanHobi ( $koneksi, $cariHobi = null )
{
    if ( $cariHobi )
    {
        $stmt     = $koneksi->prepare ( "SELECT h.hobi, COUNT(p.id) as jumlah_orang
                                   FROM hobi h
                                   JOIN person p ON h.person_id = p.id
                                   WHERE h.hobi LIKE ?
                                   GROUP BY h.hobi
                                   ORDER BY jumlah_orang DESC" );
        $cariHobi = "%" . $cariHobi . "%";
        $stmt->bind_param ( "s", $cariHobi );
    }
    else
    {
        $stmt = $koneksi->prepare ( "SELECT h.hobi, COUNT(p.id) as jumlah_orang
                                   FROM hobi h
                                   JOIN person p ON h.person_id = p.id
                                   GROUP BY h.hobi
                                   ORDER BY jumlah_orang DESC" );
    }

    $stmt->execute ();
    $hasil = $stmt->get_result ();

    echo "<table border='1'>
            <tr>
                <th>Hobi</th>
                <th>Jumlah Orang</th>
            </tr>";

    while ( $baris = $hasil->fetch_assoc () )
    {
        echo "<tr>
                <td>" .
            htmlspecialchars ( $baris[ "hobi" ] ) .
            "</td>
                <td>" .
            htmlspecialchars ( $baris[ "jumlah_orang" ] ) .
            "</td>
              </tr>";
    }

    echo "</table>";
}
$cariHobi = isset ( $_GET[ "cari_hobi" ] ) ? $_GET[ "cari_hobi" ] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 2 | Screening Web Programmer</title>
</head>

<body>
    <h1>Laporan Hobi</h1>
    <form method="get" action="">
        <label for="cari_hobi">Cari Berdasarkan Hobi:</label>
        <input type="text" name="cari_hobi" id="cari_hobi" value="<?php echo htmlspecialchars (
            $cariHobi
        ); ?>">
        <button type="submit">Cari</button>
    </form>

    <?php
    tampilkanLaporanHobi ( $koneksi, $cariHobi );
    $koneksi->close ();
    ?>
</body>

</html>