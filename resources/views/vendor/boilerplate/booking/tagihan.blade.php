<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        
        <table  style="width:100%;">
            <tr>
                <td>
                    <img src="{{ public_path('/favicon.png') }}" alt="sky" height="75px"> <br> 
                    <h3><b>Sky Rent Car</b></h3>
                </td>
                <td>
                    <img src="{{ public_path('/invoice.png') }}" alt="invoice_sky" height="75px">
                </td>
            </tr>
            <tr>
                <td>
                    Amartha Safira Bagarry Cluster B6/22, <br>
                    Sidoarjo, Jawa Timur, Indonesia 61252 <br>
                    Phone : 08113605559 | email : <a href="mailto:cs@skyrentcar.id">cs@skyrentcar.id</a> 
                </td>
                <td>
                    No. Invoice 	: {{ $booking->noinvoice }} <br>
                    Tgl. Invoice 	: {{ $tgl_invoice }}
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    Nama Pelanggan <br> 
                    Alamat
                </td>
                <td>
                    : {{ $booking->nama }} <br>
                    : {{ $booking->alamat }}
                </td>
        </table>
        <table border="1px" >
            <tr>
                <th>
                    No.
                </th>
                <th>
                    Tanggal Sewa
                </th>
                <th>
                    Keterangan
                </th>
                <th>
                    Harga/hari
                </th>
                <th>
                    hari
                </th>
                <th>
                    Harga Total
                </th>
            </tr>
            <tr>
                <td>
                    1
                </td>
                <td rowspan="3" class="align-middle text-center">
                    {{ $booking->awal_sewa.' s/d '.$booking->akhir_sewa }}
                </td>
                <td>
                    {{ $booking->tipe.' '.$booking->plat }}
                </td>
                <td>
                    {{ $booking->biaya_investor+$booking->biaya_danlap }}
                </td>
                <td rowspan="3" class="align-middle text-center">
                    {{ $booking->hari }}
                </td>
                <td>
                    {{ ($booking->biaya_investor+$booking->biaya_danlap)*$booking->hari }}
                </td>
            </tr>
            <tr>
                <td>
                    2
                </td>
                <td>
                    {{ $driver }}
                </td>
                <td>
                    {{ $booking->biaya_driver }}
                </td>
                <td>
                    {{ $booking->biaya_driver*$booking->hari }}
                </td>
            </tr>
            <tr>
                <td>
                    3
                </td>
                <td>
                    {{ $bbmtol }}
                </td>
                <td>
                    {{ $booking->biaya_bbmtol }}
                </td>
                <td>
                    {{ $booking->biaya_bbmtol*$booking->hari }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="align-middle text-center"><b>Total (Dalam Rupiah)</b></td>
                <td><b>{{ $booking->biaya }}</b></td>
            </tr>
        </table>
        <p>
            Pembayaran dapat melalui Bank Transfer <br>
            Bank BCA <br>
        </p>
        <table>
            <tr>
                <td>Atas Nama</td>
                <td>: Sky Team</td>
            </tr>
            <tr>
                <td>No. Rekening</td>
                <td>: 123123123</td>
            </tr>
        </table>
        <br>
        Hormat Kami <br>
        <br>
        <br>
        <br>
        <b>Sky Rent Car</b>
    </body>
</html>