<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 1 | Screening Web Programmer</title>
</head>

<body>
    <?php if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" )
    {
        $jumlahBaris = isset ( $_POST[ "jumlahBaris" ] )
            ? (int) $_POST[ "jumlahBaris" ]
            : 0;
        $jumlahKolom = isset ( $_POST[ "jumlahKolom" ] )
            ? (int) $_POST[ "jumlahKolom" ]
            : 0;

        if ( $jumlahBaris > 0 && $jumlahKolom > 0 )
        {
            echo "<form method='post' action='soal1.php'>";
            for ( $baris = 1; $baris <= $jumlahBaris; $baris++ )
            {
                for ( $kolom = 1; $kolom <= $jumlahKolom; $kolom++ )
                {
                    echo "$baris.$kolom: <input type='text' name='input[$baris][$kolom]'>&nbsp;&nbsp;";
                }
                echo "<br>";
            }
            echo "<br><input type='submit' value='Submit'>";
            echo "</form>";
        }
        elseif ( ! empty ( $_POST[ "input" ] ) )
        {
            $input = $_POST[ "input" ];
            foreach ( $input as $baris => $dataKolom )
            {
                foreach ( $dataKolom as $kolom => $nilai )
                {
                    echo "$baris.$kolom: $nilai<br>";
                }
            }
        }
        else
        {
            echo "Masukan tidak valid!";
        }
    }
    else
    {
        ?>
        <form method="post" action="<?php echo $_SERVER[ "PHP_SELF" ]; ?>">
            Inputkan Jumlah Baris: <input type="text" name="jumlahBaris"><br>
            Inputkan Jumlah Kolom: <input type="text" name="jumlahKolom"><br><br>
            <input type="submit" value="Submit">
        </form>
        <?php
    } ?>
</body>

</html>